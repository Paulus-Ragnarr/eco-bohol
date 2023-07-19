<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nursery;
use Illuminate\Support\Facades\Session;

use App\Actions\Custom\UserAuthorization;
use Illuminate\Support\Facades\Auth;

class NurseriesController extends Controller
{
    //
    function create(Request $request)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['nurseryController-create'])) {
            return view('admin.not-authorized');
        }

        $request->validate([
            'nursery_address' => 'required|max:100|unique:nurseries,nursery_address',
            'date_established' => 'required|date|before_or_equal:today',
        ]);

        $nursery = new Nursery();
        $nursery->nursery_address = $request->nursery_address;
        $nursery->date_established = $request->date_established;
        $nursery->manager_id = $request->user()->user_id;
        $nursery->save();

        Session::flash('success', 'Mangrove Nursery added successfully!');
        return redirect('/admin/manage-nurseries');
    }

    function update(Request $request)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['nurseryController-update'])) {
            return view('admin.not-authorized');
        }

        $request->validate([
            'nursery_address' => 'required|max:100',
            'date_established' => 'required|date|before_or_equal:today',
        ]);

        $nursery = Nursery::find($request->get('nursery_id'));
        $nursery->nursery_address = $request->nursery_address;
        $nursery->date_established = $request->date_established;
        $nursery->save();

        Session::flash('success', 'Mangrove Nursery updated successfully!');
        return redirect('/admin/manage-nurseries');
    }
}
