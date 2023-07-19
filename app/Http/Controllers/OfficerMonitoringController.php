<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use Illuminate\Http\Request;
use App\Models\OfficerMonitoring;
use App\Models\Plantation;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use App\Actions\Custom\UserAuthorization;
use Illuminate\Support\Facades\Auth;

class OfficerMonitoringController extends Controller
{
    public function create(Request $request)
    {

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['officerMonitoringController-create'])) {
            return view('admin.not-authorized');
        }

        $request->validate([
            'date_monitored' => [
                'required',
                'date',
                'before_or_equal:today', Rule::unique('officer_monitorings')->where(function ($query) use ($request) {
                    return $query->where('plantation_id', $request->input('plantation_id'));
                }),
            ],
            // 'latitude' => 'required|numeric|between:-90.0,90.0',
            // 'longitude' => 'required|numeric|between:-180.0,180.0',
            'address' => 'required|max:50',
            'area' => 'required|numeric|min:1',
            'spacing' => 'required',
            'no_plots' => 'required|numeric|min:1',
            'total_planted' => 'required|numeric|min:1|max:10000',
            'no_survived' => 'required|numeric|min:0|lte:total_planted',
            'no_dead' => 'required|numeric|min:0',
            'attachment' => 'required',
            'remarks' => 'max:50',
        ]);

        $plantation_id = $request->get('plantation_id');
        $officer_monitoring_record = new OfficerMonitoring();
        $officer_monitoring_record->plantation_id = intval($plantation_id);
        $officer_monitoring_record->user_id = $request->user()->user_id;
        $officer_monitoring_record->date_monitored = $request->get('date_monitored');
        // $officer_monitoring_record->latitude = $request->get('latitude');
        // $officer_monitoring_record->longitude = $request->get('longitude');
        $officer_monitoring_record->address = $request->get('address');
        $officer_monitoring_record->area = $request->get('area');
        $officer_monitoring_record->spacing = $request->get('spacing');
        $officer_monitoring_record->no_plots = $request->get('no_plots');
        $officer_monitoring_record->total_planted = $request->get('total_planted');
        $officer_monitoring_record->no_survived = $request->get('no_survived');
        $officer_monitoring_record->no_dead = $request->get('no_dead');
        $officer_monitoring_record->survival_rate = $request->get('survival_rate');
        $officer_monitoring_record->remarks = $request->get('remarks');

        $plantation = Plantation::find($plantation_id);
        $plantation->current_planted = $plantation->current_planted - $request->get('no_dead');

        $officer_monitoring_record->current_planted = $plantation->current_planted;
        $plantation->save();
        $officer_monitoring_record->save();

        $monitor_id = $officer_monitoring_record->monitor_id;

        if ($request->file('attachment')) {

            foreach ($request->file('attachment') as $attachment) {
                $var = date_create();
                $time = date_format($var, 'YmdHis');
                $attachmentName = $time . '-' . $attachment->getClientOriginalName();
                $attachmentUrl = 'attachments/' . $attachmentName;
                $attachment->storeAs('attachments', $attachmentName, 'public');

                Attachments::insert([
                    'attachment' => $attachmentUrl,
                    'attachmentFor' => 'monitor_attachment',
                    'file_id' => $monitor_id,
                    'attachmentFilename' => $attachment->getClientOriginalName(),
                ]);
            }
        }
        Session::flash('success', 'Monitoring Record Added Successfully!');
        return redirect('/admin/manage-plantations/view?plantation_id=' . $plantation_id);
    }

    public function update(Request $request)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['officerMonitoringController-update'])) {
            return view('admin.not-authorized');
        }

        // dd($request->all());
        $request->validate([
            'date_monitored' => 'required|date|before_or_equal:today',
            // 'latitude' => 'required|numeric|between:-90.0,90.0',
            // 'longitude' => 'required|numeric|between:-180.0,180.0',
            'address' => 'required|max:50',
            'area' => 'required|numeric|min:1',
            'spacing' => 'required',
            'no_plots' => 'required|numeric|min:1',
            'total_planted' => 'required|numeric|min:1|max:10000',
            'no_survived' => 'required|numeric|min:0|lte:total_planted',
            'no_dead' => 'required|numeric|min:0',
            'attachment' => '',
            'remarks' => 'max:50',
        ]);

        $monitor_id = $request->query->all()['monitor_id'];
        $officer_monitoring_record = OfficerMonitoring::find($monitor_id);
        $previous_dead = $officer_monitoring_record->no_dead;

        $officer_monitoring_record->date_monitored = $request->get('date_monitored');
        // $officer_monitoring_record->latitude = $request->get('latitude');
        // $officer_monitoring_record->longitude = $request->get('longitude');
        $officer_monitoring_record->address = $request->get('address');
        $officer_monitoring_record->area = $request->get('area');
        $officer_monitoring_record->spacing = $request->get('spacing');
        $officer_monitoring_record->no_plots = $request->get('no_plots');
        $officer_monitoring_record->total_planted = $request->get('total_planted');
        $officer_monitoring_record->no_survived = $request->get('no_survived');
        $officer_monitoring_record->no_dead = $request->get('no_dead');
        $officer_monitoring_record->survival_rate = $request->get('survival_rate');
        $officer_monitoring_record->remarks = $request->get('remarks');

        $officer_monitoring_record->current_planted = ($officer_monitoring_record->current_planted + $previous_dead) - $request->get('no_dead');

        $existing_attachments = Attachments::where('file_id', $monitor_id)
            ->where('attachmentFor', 'monitor_attachment')->get();
        // dd($existing_attachments);

        if ($request->hasFile('attachment')) {
            foreach ($existing_attachments as $existing_attachment) {
                Storage::delete('public/' . $existing_attachment->attachment);
                $existing_attachment->delete();
            }
            foreach ($request->file('attachment') as $attachment) {
                $var = date_create();
                $time = date_format($var, 'YmdHis');
                $attachmentName = $time . '-' . $attachment->getClientOriginalName();
                $attachmentUrl = 'attachments/' . $attachmentName;
                $attachment->storeAs('attachments', $attachmentName, 'public');

                Attachments::insert([
                    'attachment' => $attachmentUrl,
                    'attachmentFor' => 'monitor_attachment',
                    'file_id' => $monitor_id,
                    'attachmentFilename' => $attachment->getClientOriginalName(),
                ]);
            }
        }

        $officer_monitoring_record->save();

        Session::flash('success', 'Monitoring Record Updated Successfully!');
        $plantation_id = $request->get('plantation_id');
        return redirect('/admin/manage-plantations/view?plantation_id=' . $plantation_id);
    }
}