<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plantation;
use App\Models\Attachments;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use App\Actions\Custom\UserAuthorization;
use Illuminate\Support\Facades\Auth;

class PlantationsController extends Controller
{
    //
    public function create(Request $request)
    {

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['plantationsController-create'])) {
            return view('admin.not-authorized');
        }

        $request->validate([
            'unique_code' => 'required|unique:plantations|max:30|regex:/^[a-zA-Z0-9\-]+$/',
            'manager_id' => 'required',
            'region' => 'required',
            'district' => 'required',
            'plantation_address' => 'required|max:50',
            'penro' => 'required|alpha:ascii',
            'cenro' => 'required|alpha:ascii',
            'component' => 'required|alpha:ascii',
            'commodity' => 'required|alpha:ascii',
            'date_started' => 'required|date|before_or_equal:today',
            'total_area' => 'required|numeric|regex:/^\d+(\.\d{1,6})?$/|min:1',
            'tenure' => 'required|regex:/^[a-zA-Z\s]+$/',
            'fund_source' => 'required|alpha',
            'target_loa' => 'required|numeric|min:1|lte:total_area',
            'no_loa' => 'required|numeric|min:1',
            'species' => 'required',
            'target_no' => 'required|numeric|min:1',
            'initial_no' => 'required|numeric|min:0',
            'density_ha' => 'required|numeric|min:1',
            'current_planted' => 'required|numeric|lte:target_no|min:0',
            'status' => 'required',
            'latitude' => 'required|numeric|between:-90.0,90.0',
            'longitude' => 'required|numeric|between:-180.0,180.0',
            'loa_attachment' => '',
        ], [
            'date_started.before_or_equal' => 'The given date is greater than the date today.',
        ]);



        $user_input = $request->all();
        $species = $user_input['species'];

        $user_input['species'] = implode(',', $species);
        $new_plantation = Plantation::create($user_input);


        // dd($request->all());
        // dd($new_plantation);
        // $new_plantation->save();
        // dd($request->file('loa_attachment'));

        if ($request->file('loa_attachment')) {

            foreach ($request->file('loa_attachment') as $attachment) {
                $var = date_create();
                $time = date_format($var, 'YmdHis');
                $attachmentName = $time . '-' . $attachment->getClientOriginalName();
                $attachmentUrl = 'attachments/' . $attachmentName;
                $attachment->storeAs('attachments', $attachmentName, 'public');

                Attachments::insert([
                    'attachment' => $attachmentUrl,
                    'attachmentFor' => 'loa_attachment',
                    'file_id' => $new_plantation->plantation_id,
                    'attachmentFilename' => $attachment->getClientOriginalName(),
                ]);
            }
        }
        // dd($new_plantation->all());
        Session::flash('success', 'Plantation record added successfully!');
        return redirect('/admin/manage-plantations');
    }

    function update(Request $request)
    {

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['plantationsController-update'])) {
            return view('admin.not-authorized');
        }
        
        $plantation_id = $request->query->all()['plantation_id'];

        $plantation = Plantation::find($plantation_id);

        $request->validate([
            'unique_code' => 'required|max:30|regex:/^[a-zA-Z0-9\-]+$/',
            'manager_id' => 'required',
            'region' => 'required',
            'district' => 'required',
            'plantation_address' => 'required|max:50',
            'penro' => 'required|alpha:ascii',
            'cenro' => 'required|alpha:ascii',
            'component' => 'required|alpha:ascii',
            'commodity' => 'required|alpha:ascii',
            'date_started' => 'required|date|before_or_equal:today',
            'total_area' => 'required|numeric|regex:/^\d+(\.\d{1,6})?$/|min:1',
            'tenure' => 'required|regex:/^[a-zA-Z\s]+$/',
            'fund_source' => 'required|alpha',
            'target_loa' => 'required|numeric|min:1|lte:total_area',
            'no_loa' => 'required|numeric',
            'species' => 'required',
            'target_no' => 'required|numeric|min:1',
            'initial_no' => 'required|numeric|min:0',
            'density_ha' => 'required|numeric|min:1',
            'current_planted' => 'required|numeric|lte:target_no|min:0',
            'status' => 'required',
            'latitude' => 'required|numeric|between:-90.0,90.0',
            'longitude' => 'required|numeric|between:-180.0,180.0',
        ], [
            'date_started.before_or_equal' => 'The given date is greater than the date today.',
        ]);

        // dd($request->species);
        $species = implode(',', $request->species);
        $request->merge(['species' => $species]);
        $plantation->update($request->all());

        $existing_attachments = Attachments::where('file_id', $plantation_id)
            ->where('attachmentFor', 'loa_attachment')
            ->get();

            if ($request->hasFile('loa_attachment')) {
                foreach ($existing_attachments as $existing_attachment) {
                    Storage::delete('public/' . $existing_attachment->attachment);
                    $existing_attachment->delete();
                }
                foreach ($request->file('loa_attachment') as $attachment) {
                    $var = date_create();
                    $time = date_format($var, 'YmdHis');
                    $attachmentName = $time . '-' . $attachment->getClientOriginalName();
                    $attachmentUrl = 'attachments/' . $attachmentName;
                    $attachment->storeAs('attachments', $attachmentName, 'public');
        
                    Attachments::insert([
                        'attachment' => $attachmentUrl,
                        'attachmentFor' => 'loa_attachment',
                        'file_id' => $plantation->plantation_id,
                        'attachmentFilename' => $attachment->getClientOriginalName(),
                    ]);
                }
            }

        Session::flash('success', 'Plantation Record updated successfully!');
        return redirect('/admin/manage-plantations');
    }
}
