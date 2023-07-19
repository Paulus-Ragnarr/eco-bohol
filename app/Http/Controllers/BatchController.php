<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\BatchInfo;
use Illuminate\Support\Facades\Session;

use App\Actions\Custom\UserAuthorization;

class BatchController extends Controller
{
    function create(Request $request)
    {

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['batch-create'])) {
            return view('admin.not-authorized');
        }

        $request->validate(
            [
                'species_id' => 'required',
                'no_potted' => 'required|numeric|min:0',
                'date_potted' => 'required|before_or_equal:today',
                'remarks' => 'max:500',
            ],
            [
                'species_id.required' => 'The species field is required.'
            ]
        );


        // dd($request->get(intval('nursery_id')));
        $batch = new BatchInfo();
        $batch->nursery_id = $request->get('nursery_id');
        $batch->species_id = $request->get('species_id');
        $batch->no_potted = $request->get('no_potted');
        $batch->current_no_potted = $request->get('no_potted');
        $batch->date_potted = $request->get('date_potted');
        $batch->remarks = $request->get('remarks');
        $batch->status = 'Active';
        $batch->save();

        Session::flash('success', 'Batch propagule has been created!');
        return redirect('/admin/manage-nurseries/view?nursery_id=' . $batch->nursery_id);
    }

    function update(Request $request)
    {

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['batch-update'])) {
            return view('admin.not-authorized');
        }

        $request->validate(
            [
                'species_id' => 'required',
                'no_potted' => 'required|numeric|min:0',
                'current_no_potted' => 'required|numeric|min:0|lte:no_potted',
                'date_potted' => 'required|before_or_equal:today',
                'remarks' => 'max:500',
            ],
            [
                'species_id.required' => 'The species field is required.'
            ]
        );
        // dd($request->all());
        // dd($request->get(intval('batch_id')));
        $batch = BatchInfo::find($request->get('batch_id'));
        $batch->species_id = $request->get('species_id');
        $batch->no_potted = $request->no_potted;
        $batch->current_no_potted = $request->current_no_potted;
        $batch->date_potted = $request->date_potted;
        $batch->remarks = $request->remarks;
        $batch->save();

        Session::flash('success', 'Batch propagule has been updated!');
        return redirect('/admin/manage-nurseries/view?nursery_id=' . $batch->nursery_id);
    }

    public function archive(Request $request)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['batch-archive'])) {
            return view('admin.not-authorized');
        }

        $batch = BatchInfo::find($request->species_id);
        $batch->status = $batch->status == 'Active' ? 'Archived' : 'Active';
        $batch->save();

        Session::flash('success', 'Batch Propagule Status has been Updated!');
        return redirect('/admin/manage-nurseries/view?nursery_id=' . $batch->nursery_id);
    }
}