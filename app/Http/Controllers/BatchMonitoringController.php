<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BatchInfo;
use App\Models\BatchMonitoring;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

use App\Actions\Custom\UserAuthorization;
use Illuminate\Support\Facades\Auth;

class BatchMonitoringController extends Controller
{
    function create(Request $request)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['batchmonitoring-create'])) {
            return view('admin.not-authorized');
        }

        $request->validate([

            'date_monitored' => [
                'required', 'date', 'before_or_equal:today', Rule::unique('batch_monitorings')->where(function ($query) use ($request) {
                    return $query->where('batch_id', $request->input('batch_id'));
                }),
            ],
            'current_no_potted', 'numeric|min:0',
            'no_survived' => 'required|numeric|min:0|lte:current_no_potted',
            'no_dead' => 'required|numeric|min:0|lte:current_no_potted',
            'total_no_dead' => 'lte:current_no_potted',
            'survival_rate' => 'required|numeric|min:0',
            'remarks' => 'max:200'
        ]);

        $batch_id = $request->get('batch_id');
        $batch_monitoring = new BatchMonitoring;
        $batch_monitoring->batch_id = intval($batch_id);
        $batch_monitoring->no_survived = $request->get('no_survived');
        $batch_monitoring->no_dead = $request->get('no_dead');
        $batch_monitoring->survival_rate = $request->get('survival_rate');
        $batch_monitoring->remarks = $request->get('remarks');
        $batch_monitoring->date_monitored = $request->get('date_monitored');
        $batch_monitoring->current_no_potted = $request->get('current_no_potted');
        $batch_monitoring->total_no_dead = $request->get('total_no_dead');
        $batch_monitoring->save();

        $batch_monitoring->batch_info->current_no_potted = $request->get('no_survived');
        $batch_monitoring->batch_info->save();


        Session::flash('success', 'Monitoring Record Added Successfully!');
        return redirect('/admin/manage-nurseries/view-batch?batch_id=' . $request->get('batch_id') . '&nursery_id=' . $request->get('nursery_id'));
    }

    function update(Request $request)
    {

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['batchmonitoring-update'])) {
            return view('admin.not-authorized');
        }

        $request->validate([

            'date_monitored' => 'required|before_or_equal:today',
            'current_no_potted', 'numeric|min:0',
            'no_survived' => 'required|numeric|min:0|lte:current_no_potted',
            'no_dead' => 'required|numeric|min:0|lte:current_no_potted',
            'total_no_dead' => 'lte:current_no_potted',
            'survival_rate' => 'required|numeric|min:0',
            'remarks' => 'max:200'
        ]);

        // dd($request->all());
        $batch_monitoring = BatchMonitoring::find(intval($request->query->all()['monitor_id']));
        $batch_monitoring->batch_info->current_no_potted = $request->get('no_survived');
        $batch_monitoring->total_no_dead = $request->get('total_no_dead');
        $batch_monitoring->batch_info->save();
        // dd($batch_monitoring);
        $batch_monitoring->update($request->all());

        Session::flash('success', 'Monitoring Record Update Successfully!');
        return redirect('/admin/manage-nurseries/view-batch?batch_id=' . $request->get('batch_id') . '&nursery_id=' . $request->get('nursery_id'));
    }
}
