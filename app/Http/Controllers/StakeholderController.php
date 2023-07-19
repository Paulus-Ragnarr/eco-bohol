<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Models\Attachments;
use App\Models\Stakeholder;
use Illuminate\Support\Facades\Session;
use App\Models\User;

use Illuminate\Support\Facades\Storage;
use App\Actions\Custom\UserAuthorization;

class StakeholderController extends Controller
{
    public function register(Request $request)
    {
        $request->validate(
            [
                'stakeholder_email' => 'required|unique:users,email|email',
                'stakeholder_pass' => ['required', Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
                'first_name' => 'required|regex:/^[a-zA-Z ]+$/',
                'middle_name' => 'nullable|regex:/^[a-zA-Z ]+$/',
                'last_name' => 'required|regex:/^[a-zA-Z ]+$/',
                'suffix' => 'nullable|regex:/^[a-zA-Z ]+$/',
                'contact_num' => [
                    'required',
                    'regex:/^(09|\+639)[0-9\s\-\(\)]{9}$/',
                ],
                'endorsement_letter' => 'required',
                'org_name' => 'required|regex:/^[a-zA-Z\s\p{P}]+$/u',
            ],
            [
                'contact_num.required' => 'The contact number field is required.',
                'org_name.required' => 'The organization name field is required.',
            ]

        );

        $register_stakeholder = new User();
        $register_stakeholder->name = $request->first_name . " " . $request->middle_name . " " . $request->last_name . " " . $request->suffix;
        $register_stakeholder->email = $request->stakeholder_email;
        $register_stakeholder->user_contact = $request->contact_num;
        $register_stakeholder->password = Hash::make($request->stakeholder_pass);
        $register_stakeholder->user_role = 'stakeholder';
        $register_stakeholder->status = "Pending";
        $register_stakeholder->save();

        $stakeholder_id = $register_stakeholder->user_id;

        $new_stakeholder = new Stakeholder();
        $new_stakeholder->stakeholder_id = $stakeholder_id;
        $new_stakeholder->stakeholder_type = $request->stakeholder_type;
        $new_stakeholder->org_name = $request->org_name;
        $new_stakeholder->save();

        if ($request->file('endorsement_letter')) {
            foreach ($request->file('endorsement_letter') as $attachment) {
                $var = date_create();
                $time = date_format($var, 'YmdHis');
                $attachmentName = $time . '-' . $attachment->getClientOriginalName();
                $attachmentUrl = 'attachments/' . $attachmentName;
                $attachment->storeAs('attachments', $attachmentName, 'public');
                // $attachments[] = $attachmentUrl;

                // $attachmentUrl = Storage::putFileAs('attachments', $attachment, $imageName);
                Attachments::insert([
                    'attachment' => $attachmentUrl,
                    'attachmentFor' => 'endorsement_letter',
                    'file_id' => $stakeholder_id,
                    'attachmentFilename' => $attachment->getClientOriginalName(),
                ]);
            }
        }

        $location = '/stakeholder/register';
        Session::flash('success', 'Account successfully registered!');
        return redirect($location);
    }

    public function update_stakeholder_pass(Request $request)
    {

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['stakeholderController-update_stakeholder_pass'])) {
            return view('admin.not-authorized');
        }

        $request->validate([
            'new_password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        $user_id = $request->query->all()['user_id'];

        $user = User::find($request->get('user_id'));
        $user->password = Hash::make($request->input('new_password'));
        $user->save();


        Session::flash('successP', 'Password Updated Successfully!');
        return redirect('/admin/manage-stakeholders/update?user_id=' . $user_id);
    }

    public function approve_request(Request $request)
    {

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['stakeholderController-approve_request'])) {
            return view('admin.not-authorized');
        }
        //Making the pending status active
        $pending_user = User::find($request->user_id);
        $pending_user->status = 'active';
        $pending_user->save();


        Session::flash('success', 'Account succesfully registered!');
        return redirect('/admin/manage-stakeholders');
    }

    public function disable(Request $request)
    {

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['stakeholderController-disable'])) {
            return view('admin.not-authorized');
        }
        $registered_user = User::find($request->input('user_id'));
        $registered_user->status = $registered_user->status == 'active' ? 'inactive' : 'active';

        $registered_user->save();

        Session::flash('success', 'Account Status Updated!');
        return redirect('/admin/manage-stakeholders');
    }

    public function delete_user(Request $request)
    {
        //dd(existing_endorsements) 
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['stakeholderController-delete_user'])) {
            return view('admin.not-authorized');
        }
        $pending_user = User::find($request->user_id);
        $pending_stakeholder = Stakeholder::find($request->user_id);

        $existing_endorsements = Attachments::where('stakeholder_id', $request->user_id)
            ->where('attachmentFor', 'endorsement_letter')
            ->get();

        foreach ($existing_endorsements as $existing_endorsement) {
            Storage::delete('public/' . $existing_endorsement->attachment);
            $existing_endorsement->delete();
        }

        $pending_user->delete();
        $pending_stakeholder->delete();

        Session::flash('success', 'Account is rejected!');
        return redirect('/admin/manage-stakeholders');
    }
}