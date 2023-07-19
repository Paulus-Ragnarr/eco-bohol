<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ManagerMonitoring;
use App\Models\Plantation;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

use App\Actions\Custom\UserAuthorization;

class MonitoringRecordController extends Controller
{

    public function create(Request $request)
    {

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['monitoringRecord-create'])) {
            return view('admin.not-authorized');
        }

        $request->validate([
            'date_monitored' => [
                'required', 'date', 'before_or_equal:today', Rule::unique('manager_monitorings')->where(function ($query) use ($request) {
                    return $query->where('plantation_id', $request->input('plantation_id'));
                }),
            ],
            'no_survived' => 'required|numeric|min:0',
            'no_dead' => 'required|numeric|min:0',
            'no_replanted' => 'required|numeric|min:0',
            'area' => 'required|numeric|min:1',
            'remarks' => 'max:50'
        ]);

        $plantation_id = $request->get('plantation_id');
        $monitoring_record = new ManagerMonitoring;
        $monitoring_record->plantation_id = intval($plantation_id);
        $monitoring_record->manager_id = intval($request->get('manager_id'));
        $monitoring_record->date_monitored = $request->get('date_monitored');
        $monitoring_record->no_survived = $request->get('no_survived');
        $monitoring_record->no_dead = $request->get('no_dead');
        $monitoring_record->no_replanted = $request->get('no_replanted');
        $monitoring_record->area = $request->get('area');
        $monitoring_record->remarks = $request->get('remarks');

        $plantation = Plantation::find($plantation_id);
        $plantation->current_planted = ($plantation->current_planted - $request->get('no_dead')) + $request->get('no_replanted');

        $monitoring_record->current_planted = $plantation->current_planted;
        $plantation->save();
        $monitoring_record->save();
        Session::flash('success', 'Monitoring Record Added Successfully!');
        return redirect('/admin/manage-plantations/view?plantation_id=' . $plantation_id);
    }

    public function update(Request $request)
    {

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['monitoringRecord-update'])) {
            return view('admin.not-authorized');
        }

        $request->validate([
            'date_monitored' => 'required|date|before_or_equal:today',
            'no_survived' => 'required|numeric|min:0',
            'no_dead' => 'required|numeric|min:0',
            'no_replanted' => 'required|numeric|min:0',
            'area' => 'required|numeric|min:1',
            'remarks' => 'max:50'
        ]);

        $monitoring_record = ManagerMonitoring::find(intval($request->query->all()['monitor_id']));
        $previous_mr_no_replanted = $monitoring_record->no_replanted;

        $request_survived = $request->get('no_survived');
        $monitoring_no_dead = $monitoring_record->no_dead;

        $monitoring_record->no_survived = $request_survived;
        $monitoring_record->date_monitored = $request->get('date_monitored');
        $monitoring_record->no_dead = $request->get('no_dead');
        $monitoring_record->no_replanted = $request->get('no_replanted');
        $monitoring_record->area = $request->get('area');
        $monitoring_record->remarks = $request->get('remarks');

        $plantation_id = $request->get('plantation_id');
        $plantation = Plantation::find($plantation_id);

        // dd($difference_planted);

        $plantation->current_planted = (($plantation->current_planted + $monitoring_no_dead - $previous_mr_no_replanted) - $request->get('no_dead')) + $request->get('no_replanted');
        $monitoring_record->current_planted = $plantation->current_planted;
        $plantation->save();
        $monitoring_record->save();

        Session::flash('success', 'Monitoring Record Updated Successfully!');
        return redirect('/admin/manage-plantations/view?plantation_id=' . $plantation_id);
    }
}
