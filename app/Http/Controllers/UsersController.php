<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Manager;
use App\Models\Stakeholder;

use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;

use App\Actions\Custom\UserAuthorization;

class UsersController extends Controller
{
    //
    public function add_user(Request $request)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['userController-add_user'])) {
            return view('admin.not-authorized');
        }

        $request->validate([
            'user_email' => 'required|unique:users,email',
            'user_password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols()],
            'first_name' => 'required|regex:/^[a-zA-Z ]+$/',
            'middle_name' => 'nullable|regex:/^[a-zA-Z ]+$/',
            'last_name' => 'required|regex:/^[a-zA-Z ]+$/',
            'suffix' => 'nullable|regex:/^[a-zA-Z. ]+$/',
            'user_contact' => [
                'nullable',
                'regex:/^(09|\+639)[0-9\s\-\(\)]{9}$/',
            ],
            'position' => 'required|regex:/^[a-zA-Z\s]+$/',
            // 'office' => 'required|regex:/^[a-zA-Z\s]+$/',
            'user_role' => 'required',
        ]);

        $new_user = new User();
        $new_user->name = $request->first_name . " " . $request->middle_name . " " . $request->last_name . " " . $request->suffix;
        $new_user->email = $request->user_email;
        $new_user->password = Hash::make($request->user_password);
        $new_user->user_contact = $request->user_contact;
        $new_user->position = $request->position;
        $new_user->user_role = $request->user_role;
        $new_user->status = "active";
        // $new_user->office = $request->office;
        $new_user->save();
        // dd(Auth::user());

        $location = '/admin/manage-users';

        Session::flash('success', 'Account has been created!');
        return redirect($location);
    }
    public function add_manager(Request $request)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['userController-add_manager'])) {
            return view('admin.not-authorized');
        }
        $request->validate([
            'user_email' => 'required|unique:users,email',
            'user_password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols()],
            'first_name' => 'required|regex:/^[a-zA-Z ]+$/',
            'middle_name' => 'nullable|regex:/^[a-zA-Z ]+$/',
            'last_name' => 'required|regex:/^[a-zA-Z ]+$/',
            'suffix' => 'nullable|regex:/^[a-zA-Z. ]+$/',
            'user_contact' => [
                'nullable',
                'regex:/^(09|\+639)[0-9\s\-\(\)]{9}$/',
            ],
            'org_name' => 'required|regex:/^[\pL\s.-]+(?:\s[\pL\s.-]+)*(?:,\s[\pL\s.-]+)?$/u',
            'org_type' => 'required',
            'user_role' => 'required',
        ]);

        $new_user = new User();
        $new_user->name = $request->first_name . " " . $request->middle_name . " " . $request->last_name . " " . $request->suffix;
        $new_user->email = $request->user_email;
        $new_user->password = Hash::make($request->user_password);
        $new_user->user_contact = $request->user_contact;
        // $new_user->position = $request->position;
        $new_user->user_role = $request->user_role;
        $new_user->status = "active";
        // $new_user->office = $request->office;
        $new_user->save();
        // dd(Auth::user());

        if ($new_user->user_role == "manager") {
            $manager = new Manager();
            $manager->manager_id = $new_user->user_id;
            // $manager->manager_name = $request->first_name . " " . $request->last_name . " " . $request->suffix;
            // $manager->manager_contact = $new_user->user_contact;
            $manager->org_name = $request->org_name;
            $manager->org_type = $request->org_type;
            // $manager->status = $new_user->status;
            $manager->save();
            $location = '/admin/managers';
        }
        // dd($request->user);
        Session::flash('success', 'Account has been created!');
        return redirect($location);
    }

    // /**
    //  * The function changes the role of a user and redirects to the manage-users page.
    //  * 
    //  * @param Request request  is an instance of the Request class which contains the data sent by
    //  * the client in the HTTP request. It can contain data from the URL parameters, form data, headers,
    //  * cookies, and more. In this case, it is used to retrieve the user ID and the new user role from the
    //  * form
    //  * 
    //  * @return a redirect to the '/admin/manage-users' page.
    //  */
    public function change_user_role(Request $request)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['userController-change_user_role'])) {
            return view('admin.not-authorized');
        }
        $existing_user = User::find($request->user_id);
        $existing_user->user_role = $request->user_role;

        $existing_user->save();

        return redirect('/admin/manage-users');
    }

    // /**
    //  * The function toggles the status of a user between active and inactive and redirects to the
    //  * appropriate page based on the user's role.
    //  * 
    //  * @param Request request The  parameter is an instance of the Request class, which contains
    //  * the data sent to the server through an HTTP request. It can contain data from the URL, form data,
    //  * and other sources. In this function, it is used to retrieve the user ID of the user whose status is
    //  * being togg
    //  * 
    //  * @return a redirect response to either '/admin/managers' or '/admin/manage-users' depending on the
    //  * user role of the updated user.
    //  */
    public function toggle_user_status(Request $request)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['userController-toggle_user_status'])) {
            return view('admin.not-authorized');
        }
        $existing_user = User::find($request->user_id);
        $existing_user->status = $existing_user->status == 'active' ? 'inactive' : 'active';
        $existing_user->save();

        Session::flash('success', 'User Status Updated!');

        if ($existing_user->user_role == "manager") {
            return redirect('/admin/managers');
        } else {
            return redirect('/admin/manage-users');
        }
    }

    public function edit_user_detail(Request $request)
    {

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['userController-edit_user_detail'])) {
            return view('admin.not-authorized');
        }
        $request->validate([
            'name' => 'required|regex:/^[\pL\s.]+(?:\s[\pL\s.]+)*(?:,\s[\pL\s.]+)?$/u',
            'email' => 'required',
            'user_contact' => [
                'nullable',
                'regex:/^(09|\+639)[0-9\s\-\(\)]{9}$/',
            ],
            'position' => 'required|regex:/^[a-zA-Z\s]+$/',
            // 'office' => 'required|regex:/^[a-zA-Z\s]+$/',

        ]);
        // dd($request->all());

        $user_id = $request->query->all()['user_id'];
        $edit_user = User::find($user_id);

        $edit_user->name = $request['name'];
        $edit_user->email = $request['email'];
        $edit_user->user_contact = $request['user_contact'];
        $edit_user->position = $request['position'];
        // $edit_user->office = $request['office'];

        $edit_user->save();

        Session::flash('success', 'Account Updated Successfully!');
        return redirect('/admin/account-settings/edit-user-account?user_id=' . $user_id);
    }

    public function edit_user_password(Request $request)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['userController-edit_user_password'])) {
            return view('admin.not-authorized');
        }
        $request->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],

        ]);
        // dd($request->all());

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            Session::flash('error', "Current Password doesn't match!");
            return back();
        }
        $user_id = $request->query->all()['user_id'];
        $edit_user = User::find($user_id);

        $edit_user->password = Hash::make($request['new_password']);
        $edit_user->save();

        Session::flash('successP', 'Password Updated Successfully!');
        return redirect('/admin/account-settings/edit-user-account?user_id=' . $user_id);
    }

    public function edit_manager_details(Request $request)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['userController-edit_manager_details'])) {
            return view('admin.not-authorized');
        }
        $request->validate([
            'name' => 'required|regex:/^[\pL\s.]+(?:\s[\pL\s.]+)*(?:,\s[\pL\s.]+)?$/u',
            'email' => 'required',
            'user_contact' => [
                'nullable',
                'regex:/^(09|\+639)[0-9\s\-\(\)]{9}$/',
            ],
            'org_name' => 'required|regex:/^[\pL\s\pP]+$/u',
            'org_type' => 'required',
        ]);

        $user_id = $request->query->all()['user_id'];

        $edit_user = User::find($user_id);
        $edit_user->name = $request['name'];
        $edit_user->email = $request['email'];
        $edit_user->user_contact = $request['user_contact'];
        $edit_user->save();

        $manager_id = $request->query->all()['user_id'];
        $manager_user = Manager::find($manager_id);
        $manager_user->org_name = $request['org_name'];
        $manager_user->org_type = $request['org_type'];
        $manager_user->save();

        Session::flash('success', 'Account Updated Successfully!');
        return redirect('/admin/account-settings/edit-manager-account?user_id=' . $user_id);
    }

    public function edit_manager_password(Request $request)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['userController-edit_manager_password'])) {
            return view('admin.not-authorized');
        }
        $request->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            Session::flash('error', "Current Password doesn't match!");
            return back();
        }
        $user_id = $request->query->all()['user_id'];
        $edit_user = User::find($user_id);

        $edit_user->password = Hash::make($request['new_password']);
        $edit_user->save();

        Session::flash('successP', 'Password Updated Successfully!');
        return redirect('/admin/account-settings/edit-manager-account?user_id=' . $user_id);
    }

    public function edit_stakeholder_details(Request $request)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['userController-edit_stakeholder_details'])) {
            return view('admin.not-authorized');
        }
        $request->validate([
            'name' => 'required|regex:/^[\pL\s.]+(?:\s[\pL\s.]+)*(?:,\s[\pL\s.]+)?$/u',
            'email' => 'required|email',
            'user_contact' => [
                'nullable',
                'regex:/^(09|\+639)[0-9\s\-\(\)]{9}$/',
            ],
            'org_name' => 'required|regex:/^[\pL\s.]+(?:\s[\pL\s.]+)*(?:,\s[\pL\s.]+)?$/u',
            'stakeholder_type' => 'required',
        ]);

        $user_id = $request->query->all()['user_id'];

        $edit_user = User::find($user_id);
        $edit_user->name = $request['name'];
        $edit_user->email = $request['email'];
        $edit_user->user_contact = $request['user_contact'];
        $edit_user->save();

        $stakeholder_id = $request->query->all()['user_id'];
        $stakeholder_user = Stakeholder::find($stakeholder_id);
        $stakeholder_user->org_name = $request['org_name'];
        $stakeholder_user->stakeholder_type = $request['stakeholder_type'];
        $stakeholder_user->save();

        Session::flash('success', 'Account Updated Successfully!');
        return redirect('/admin/account-settings/edit-stakeholder-account?user_id=' . $user_id);
    }

    public function edit_stakeholder_password(Request $request)
    {
        // Perform check
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['userController-edit_stakeholder_password'])) {
            return view('admin.not-authorized');
        }
        $request->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            Session::flash('error', "Current Password doesn't match!");
            return back();
        }
        $user_id = $request->query->all()['user_id'];
        $edit_user = User::find($user_id);

        $edit_user->password = Hash::make($request['new_password']);
        $edit_user->save();

        Session::flash('successP', 'Password Updated Successfully!');
        return redirect('/admin/account-settings/edit-stakeholder-account?user_id=' . $user_id);
    }


    // change password by admin
    public function admin_change_password(Request $request)
    {
        // Perform check
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['userController-admin_change_password'])) {
            return view('admin.not-authorized');
        }
        $request->validate([
            'new_password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        $user = User::find($request->get('user_id'));
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        $redirect_location = '';
        if ($user->user_role == 'manager') {
            $redirect_location = '/managers';
        } else if ($user->user_role == 'stakeholder') {
            $redirect_location = '/manage-stakeholders';
        } else {
            $redirect_location = '/manage-users';
        }

        Session::flash('success', 'Password Updated Successfully!');
        return redirect('/admin' . $redirect_location);
    }
}