<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Actions\Custom\UserAuthorization;
use App\Models\BatchInfo;

class PurchaseController extends Controller
{
    public function add_purchased_planted(Request $request)
    {
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['batch-purchased-planted'])) {
            return view('admin.not-authorized');
        }

        // dd($request->all());
        $request->validate([
            'date_acquired' => 'required|date|before_or_equal:today',
            'taken_values' => 'required|numeric|min:0|lte:current_no_potted',
            'remarks' => 'required|max:500'
        ]);

        $acquire = new Purchase();
        $acquire->date_acquired = $request->date_acquired;
        $acquire->current_no_potted = $request->current_no_potted - $request->taken_values;
        $acquire->no_acquired = $request->taken_values;
        $acquire->type = $request->type;
        $acquire->remarks = $request->remarks;
        $acquire->batch_id = $request->batch_id;

        $batch = BatchInfo::find($request->batch_id);
        $batch->current_no_potted = $acquire->current_no_potted;
        $acquire->save();
        $batch->save();

        Session::flash('success', 'Purchased or Planted Added Successfully!');
        return redirect('/admin/manage-nurseries/view-batch-purchase?batch_id=' . $request->get('batch_id') . '&nursery_id=' . $request->get('nursery_id'));
    }

    public function update_purchased_planted(Request $request)
    {
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['batch-update-purchased-planted'])) {
            return view('admin.not-authorized');
        }

        $request->validate([
            'date_acquired' => 'required|date|before_or_equal:today',
            'taken_values' => 'required|numeric|min:0|lte:current_no_potted',
            'remarks' => 'required|max:500'
        ]);

        $acquire = Purchase::find($request->query->all()['acquire_id']);
        $prev_no_acquired = $acquire->no_acquired;

        $acquire->date_acquired = $request->date_acquired;
        $acquire->current_no_potted = ($acquire->current_no_potted + $prev_no_acquired) - $request->taken_values;
        $acquire->no_acquired = $request->taken_values;
        $acquire->type = $request->type;
        $acquire->remarks = $request->remarks;

        $batch = BatchInfo::find($request->batch_id);
        $batch->current_no_potted = $acquire->current_no_potted;
        $acquire->save();
        $batch->save();

        Session::flash('success', 'Purchased or Planted Updated Successfully!');
        return redirect('/admin/manage-nurseries/view-batch-purchase?batch_id=' . $request->get('batch_id') . '&nursery_id=' . $request->get('nursery_id'));
    }
}