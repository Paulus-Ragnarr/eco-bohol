<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SpeciesRecord;
use App\Models\Plantation;
use App\Models\Nursery;
use App\Models\BatchInfo;
use App\Models\BatchMonitoring;
use App\Models\Location;
use App\Models\User;
use App\Models\Manager;
use App\Models\ManagerMonitoring;
use App\Models\Stakeholder;
use App\Models\MangroveProject;
use App\Models\Journal;
use App\Models\OfficerMonitoring;
use App\Models\Species_group;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

use App\Actions\Custom\UserAuthorization;
use App\Models\Purchase;

class AdminController extends Controller
{
    // Putting base admin routes in one function to avoid having one function for each view
    function index(Request $request, $location): View
    {
        $return_view = '';
        $return_array = array();
        $user = Auth::user();
        $return_array['user'] = $user;
        $return_array['location'] = $location;

        if ($user->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization($user, UserAuthorization::$authorization_levels[$location])) {
            return view('admin.not-authorized');
        }
        if ($location == 'dashboard') {

            //admin and officer
            $userCount = User::where('status', '=', 'active')->count();
            $pendingCount = User::where('status', 'Pending')->count();
            $mangroveCount = SpeciesRecord::where('status', '=', 'Active')->count();
            $ongoingCount = Plantation::where('status', '=', 'Ongoing')->count();
            $completeCount = Plantation::where('status', '=', 'Completed')->count();

            //stakeholder
            $ongoingproj = MangroveProject::where('stakeholder_id', $user->user_id)->where('proj_status', '=', 'Ongoing')->where('status', 'Active')->count();
            $upcomingproj = MangroveProject::where('stakeholder_id', $user->user_id)->where('proj_status', '=', 'Upcoming')->where('status', 'Active')->count();
            $completeproj = MangroveProject::where('stakeholder_id', $user->user_id)->where('proj_status', '=', 'Completed')->where('status', 'Active')->count();

            //Manager
            $ongoingplant = Plantation::where('manager_id', $user->user_id)->where('status', '=', 'Ongoing')->count();
            $completeplant = Plantation::where('manager_id', $user->user_id)->where('status', '=', 'Completed')->count();

            $return_array['ongoingplant'] = $ongoingplant;
            $return_array['completeplant'] = $completeplant;
            $return_array['ongoingproj'] = $ongoingproj;
            $return_array['upcomingproj'] = $upcomingproj;
            $return_array['completeproj'] = $completeproj;
            $return_array['completeCount'] = $completeCount;
            $return_array['ongoingCount'] = $ongoingCount;
            $return_array['mangroveCount'] = $mangroveCount;
            $return_array['pendingCount'] = $pendingCount;
            $return_array['userCount'] = $userCount;
            $return_view = 'admin.dashboard';
        } else if ($location == 'manage-plantations') {


            $query_params = $request->query->all();
            // dd($query_params);
            $search_term = '';
            if (array_key_exists('searchTerm', $query_params)) {
                $search_term = $query_params['searchTerm'];
            } else if (array_key_exists('query', $query_params)) {
                $search_term = $query_params['query'];
            }

            if ($search_term) {
                if ($user->user_role == 'manager') {
                    $plantations = Plantation::search($search_term)->where('manager_id', $user->user_id)->paginate(10);
                } else {
                    $plantations = Plantation::search($search_term)->paginate(10);
                }
            } else {
                if ($user->user_role == 'manager') {
                    $plantations = Plantation::where('manager_id', $user->user_id)->orderByRaw("CASE WHEN status = 'Completed' THEN 1 ELSE 0 END")->orderBy('plantation_id')->orderBy('status')->paginate(10);
                } else {
                    $plantations = Plantation::orderByRaw("CASE WHEN status = 'Completed' THEN 1 ELSE 0 END")->orderBy('plantation_id')->orderBy('status')->paginate(10);
                }
            }

            $return_array['searchTerm'] = $search_term;
            $return_view = 'admin.plantations.plantations';
            $return_array['plantations'] = $plantations;
        } else if ($location == 'manage-nurseries') {

            $nurseries = Nursery::where('manager_id', $user->user_id)->paginate(10);

            $managers = Manager::all();
            $mangroves = SpeciesRecord::all();
            $return_view = 'admin.nurseries.nurseries';

            $return_array['nurseries'] = $nurseries;
            $return_array['managers'] = $managers;
            $return_array['speciesrecord'] = $mangroves;
        } else if ($location == 'account-settings') {

            $user = User::where('user_id', $user->user_id)->first();

            $return_array['user'] = $user;
            $return_view = 'admin.users.account_view_settings';
        } else if ($location == 'manage-users') {

            $count = User::selectRaw('user_role, count(user_role)')->groupBy('user_role')->get();

            $officers_researchers = User::where('user_role', '=', 'officer')->orWhere('user_role', '=', 'researcher')->orWhere('user_role', '=', 'admin')->orderBy('user_role', 'asc')->orderBy('name', 'asc')->orderBy('status', 'asc')->paginate(10);
            $return_array['user_type'] = 'Admins, Officers & Researchers';
            $return_array['count'] = $count;
            $return_array['users'] = $officers_researchers;
            $return_view = 'admin.users.users';
        } else if ($location == 'managers') {
            $count = User::selectRaw('user_role, count(user_role)')->groupBy('user_role')->get();
            $return_array['users'] = User::where('user_role', 'manager')->orderBy('name', 'asc')->orderBy('status', 'asc')->paginate(10);
            $return_array['user_type'] = 'Managers';
            $return_array['count'] = $count;
            $return_view = 'admin.users.users';
        } else if ($location == 'manage-speciesrecords') {
            $query_params = $request->query->all();

            if (array_key_exists('searchTerm', $query_params)) {
                $search_term = $query_params['searchTerm'];
                $mangroves = SpeciesRecord::search($search_term)->paginate(10);
                $return_array['searchTerm'] = $search_term;
            } else if (array_key_exists('query', $query_params)) {
                $search_term = $query_params['query'];
                $mangroves = SpeciesRecord::search($search_term)->paginate(10);
                $return_array['searchTerm'] = $search_term;
            } else {
                $mangroves = SpeciesRecord::orderBy('status')->orderByRaw("CASE WHEN status = 'Archived' THEN 1 ELSE 0 END")->orderBy('scientific_name', 'asc')->paginate(10);
                $return_array['searchTerm'] = '';
            }
            $return_array['speciesrecord'] = $mangroves;
            $return_view = 'admin.mangroves.species_record';
        } else if ($location == 'manage-projects') {

            $query_params = $request->query->all();

            $search_term = '';
            if (array_key_exists('searchTerm', $query_params)) {
                $search_term = $query_params['searchTerm'];
            } else if (array_key_exists('query', $query_params)) {
                $search_term = $query_params['query'];
            }

            if ($search_term) {
                if ($user->user_role == 'stakeholder') {
                    $mangroveproject = MangroveProject::search($search_term)->where('stakeholder_id', $user->user_id)->paginate(10);
                }
            } else {
                if ($user->user_role == 'stakeholder') {
                    $mangroveproject = MangroveProject::where('stakeholder_id', $user->user_id)->orderBy('status')->orderByRaw("CASE WHEN status = 'Archived' THEN 1 ELSE 0 END")->orderByRaw("CASE WHEN proj_status = 'Ongoing' THEN 1 WHEN proj_status = 'Upcoming' THEN 2 WHEN proj_status = 'Completed' THEN 3 ELSE 4 END")->orderBy('project_id')->orderBy('status')->paginate(10);
                }
            }

            $return_array['searchTerm'] = $search_term;
            $return_array['mangroveproject'] = $mangroveproject;
            $return_view = 'admin.projects.mangrove_projects';
        } else if ($location == 'manage-journals') {

            $query_params = $request->query->all();
            $search_term = '';

            if (array_key_exists('searchTerm', $query_params)) {
                $search_term = $query_params['searchTerm'];
            } else if (array_key_exists('query', $query_params)) {
                $search_term = $query_params['query'];
            }

            if ($search_term) {
                if ($user->user_role == 'researcher') {
                    $journals = Journal::search($search_term)->where('user_id', $user->user_id)->get();
                }
            } else {
                if ($user->user_role == 'researcher') {
                    $journals = Journal::where('user_id', $user->user_id)->orderBy('status')->orderByRaw("CASE WHEN status = 'Archived' THEN 1 ELSE 0 END")->orderBy('resjournal_id')->get();
                }
            }

            $return_array['searchTerm'] = $search_term;
            $return_array['journals'] = $journals;
            $return_view = 'admin.journals.journals';
        } else if ($location == 'managers') {

            $count = User::selectRaw('user_role, count(user_role)')->groupBy('user_role')->get();

            $return_array['users'] = User::where('user_role', 'manager')->paginate(10);
            $return_array['user_type'] = 'Managers';
            $return_array['count'] = $count;
            $return_view = 'admin.users.users';
        } else if ($location == 'manage-stakeholders') {

            $userstakeholder = User::join('stakeholders', 'users.user_id', '=', 'stakeholders.stakeholder_id')
                ->where('users.user_role', 'stakeholder')
                ->whereIn('users.status', ['active', 'inactive'])
                ->orderBy('stakeholders.stakeholder_type', 'asc')
                ->orderBy('users.status')
                ->orderByRaw("CASE WHEN users.status = 'inactive' THEN 1 ELSE 0 END")
                ->paginate(10);
            $pending = User::where('user_role', 'stakeholder')->where('status', 'Pending')->orderBy('created_at')->paginate(10);

            $return_array['userstakeholder'] = $userstakeholder;
            $return_array['pending'] = $pending;
            $return_view = 'admin.users.stakeholders';
        } else if ($location == 'manage-speciesrecords') {

            $query_params = $request->query->all();

            if (array_key_exists('searchTerm', $query_params)) {
                $search_term = $query_params['searchTerm'];
                $mangroves = SpeciesRecord::search($search_term)->paginate(10);
                $return_array['searchTerm'] = $search_term;
            } else if (array_key_exists('query', $query_params)) {
                $search_term = $query_params['query'];
                $mangroves = SpeciesRecord::search($search_term)->paginate(10);
                $return_array['searchTerm'] = $search_term;
            } else {
                $mangroves = SpeciesRecord::orderBy('status')->orderByRaw("CASE WHEN status = 'Archived' THEN 1 ELSE 0 END")->orderBy('species_id')->paginate(10);
                $return_array['searchTerm'] = '';
            }
            $return_array['speciesrecord'] = $mangroves;
            $return_view = 'admin.mangroves.species_record';
        } else if ($location == 'manage-maps') {


            $query_params = $request->query->all();
            $search_term = '';

            if (array_key_exists('searchTerm', $query_params)) {
                $search_term = $query_params['searchTerm'];
            } else if (array_key_exists('query', $query_params)) {
                $search_term = $query_params['query'];
            }

            if ($search_term) {
                $locations = Location::search($search_term)->paginate(10);
            } else {
                $locations = Location::paginate(10);
            }

            $return_array['searchTerm'] = $search_term;
            $return_array['species'] = SpeciesRecord::all();
            $return_array['locations'] = $locations;
            $return_array['plantations'] = Plantation::all();
            $return_view = 'admin.maps.manage-maps';
        } else {
            $return_view = 'admin.admin-not-found';
        }

        // dd($return_array);
        return view($return_view, $return_array);
    }


    // User Functions --------------------------------
    function users(Request $request, $location)
    {
        $return_view = '';
        $return_array = ['action' => $location];
        $return_array['location'] = explode('/', $request->path())[1];
        // dd()

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['user-' . $location])) {
            return view('admin.not-authorized');
        }

        if ($location == 'add') {
            $return_view = 'admin.users.add_users';
        } else if ($location == 'add-manager') {
            $return_view = 'admin.users.add_manager';
        } else if ($location == 'view') {
            $user = User::find(intval($request->query->all()['user_id']));
            $managers = Manager::all();

            $return_array['managers'] = $managers;
            $return_array['user'] = $user;
            $return_view = 'admin.users.view_user';
        } else if ($location == 'edit-user-account') {

            $user = User::where('user_id', intval($request->query->all()['user_id']))->first();

            $return_array['user'] = $user;
            $return_view = 'admin.users.edit_user_account';
        } else if ($location == 'edit-manager-account') {
            $user = User::where('user_id', intval($request->query->all()['user_id']))->first();
            $manager = Manager::where('manager_id', intval($request->query->all()['user_id']))->first();
            // dd($manager);

            $return_array['user'] = $user;
            $return_array['manager'] = $manager;
            $return_view = 'admin.users.edit_manager_account';
        } else if ($location == 'edit-stakeholder-account') {
            $user = User::where('user_id', intval($request->query->all()['user_id']))->first();
            $stakeholder = Stakeholder::where('stakeholder_id', intval($request->query->all()['user_id']))->first();

            $return_array['user'] = $user;
            $return_array['stakeholder'] = $stakeholder;
            $return_view = 'admin.users.edit_stakeholder_account';
        }

        return view($return_view, $return_array);
    }



    // Plantations Functions --------------------------------
    function plantation_views(Request $request, $location)
    {
        $return_view = '';
        $return_array = [
            'plantation' => null,
            'location_for' => null,
            'record' => null,
            'action' => $location,
        ];
        $user = Auth::user();
        $return_array['user'] = $user;

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['plantation-' . $location])) {
            return view('admin.not-authorized');
        }

        if ($location == 'add') {
            $managers = User::where('user_role', 'manager')->get();
            $mangroves = SpeciesRecord::all();
            $plantation = Plantation::all();
            $SelectedSpecies = array();

            $return_view = 'admin.plantations.plantation';
            $return_array['speciesrecord'] = $mangroves;
            $return_array['SelectedSpecies'] = $SelectedSpecies;
            $return_array['managers'] = $managers;
        } else if ($location == 'update') {
            $managers = User::where('user_role', 'manager')->get();
            $mangroves = SpeciesRecord::all();
            $plantation = Plantation::where('plantation_id', intval($request->query->all()['plantation_id']))
                ->first();
            // $location_for = Location::where([
            //     'location_for' => 'plantation',
            //     'location_for_id' => $plantation->plantation_id
            // ])->first();
            $SelectedSpecies = explode(',', $plantation->species);
            $return_view = 'admin.plantations.plantation';
            $return_array['managers'] = $managers;
            $return_array['speciesrecord'] = $mangroves;
            $return_array['plantation'] = $plantation;
            $return_array['SelectedSpecies'] = $SelectedSpecies;
            // $return_array['location_for'] = $location_for;
        } else if ($location == 'view') {
            $managers = Manager::all();
            $officer = User::all();
            $plantation = Plantation::find(intval($request->query->all()['plantation_id']));
            $manager = Manager::find($plantation->manager_id);
            $records = array();

            $latest_record = OfficerMonitoring::where('plantation_id', intval($request->query->all()['plantation_id']))->latest()->first();

            $return_array['latest_record'] = $latest_record;

            if (($user->user_role == 'manager')) {
                $records = ManagerMonitoring::where('plantation_id', intval($request->query->all()['plantation_id']))->orderBy('date_monitored', 'desc')->paginate(10)->appends(request()->query());
            } else if ($user->user_role == 'officer' || $user->user_role == 'admin') {
                $records = OfficerMonitoring::where('plantation_id', intval($request->query->all()['plantation_id']))->orderBy('date_monitored', 'desc')->paginate(10)->appends(request()->query());
            } else {
                $records = array();
            }
            $return_view = 'admin.plantations.view_plantation';
            $return_array['managers'] = $managers;
            $return_array['plantation'] = $plantation;
            $return_array['officer'] = $officer;
            $return_array['records'] = $records;
            $return_array['manager'] = $manager;
        } else if ($location == 'add-monitoring-record') {
            $plantation = Plantation::find(intval($request->query->all()['plantation_id']));
            $return_view = 'admin.plantations.monitoring_record';
            $return_array['plantation'] = $plantation;
        } else if ($location == 'update-monitoring-record') {
            $plantation = Plantation::find(intval($request->query->all()['plantation_id']));
            $record = ManagerMonitoring::find(intval($request->query->all()['monitor_id']));
            $return_view = 'admin.plantations.monitoring_record';
            $return_array['plantation'] = $plantation;
            $return_array['record'] = $record;
        } else if ($location == 'view-officer-monitoring-record') {
            $officer = User::all();
            $plantation = Plantation::where('plantation_id', intval($request->query->all()['plantation_id']))
                ->first();
            $record = OfficerMonitoring::find(intval($request->query->all()['monitor_id']));
            $return_view = 'admin.plantations.view_officer_monitoring_record';
            $return_array['officer'] = $officer;
            $return_array['plantation'] = $plantation;
            $return_array['record'] = $record;
        } else if ($location == 'add-officer-monitoring-record') {
            $plantation = Plantation::find(intval($request->query->all()['plantation_id']));
            $currentno = Plantation::where('plantation_id', intval($request->query->all()['plantation_id']))->get();

            $return_view = 'admin.plantations.officer_monitoring_record';
            $return_array['plantation'] = $plantation;
            $return_array['currentno'] = $currentno;
        } else if ($location == 'update-officer-monitoring-record') {
            $plantation = Plantation::find(intval($request->query->all()['plantation_id']));
            $record = OfficerMonitoring::find(intval($request->query->all()['monitor_id']));
            $return_view = 'admin.plantations.officer_monitoring_record';
            $return_array['plantation'] = $plantation;
            $return_array['record'] = $record;
        }
        return view($return_view, $return_array);
    }


    function nursery_views(Request $request, $location)
    {
        $return_view = '';
        $return_array = [
            'action' => $location,
            'nursery' => null,
            'batch' => null,
            'batches' => null,
            'batch_monitoring_records' => [],
            'batch_monitoring' => [],
            'purchase' => [],
        ];
        $user = Auth::user();
        $return_array['user'] = $user;

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['nursery-' . $location])) {
            return view('admin.not-authorized');
        }

        if ($location == 'add') {
            $managers = Manager::all();
            $return_view = 'admin.nurseries.nursery';
            $return_array['managers'] = $managers;
        } else if ($location == 'update') {
            $nursery = Nursery::where('nursery_id', intval($request->query->all()['nursery_id']))
                ->first();
            $return_view = 'admin.nurseries.nursery';
            $return_array['nursery'] = $nursery;
        } else if ($location == 'view') {
            $managers = Manager::all();
            $mangroves = SpeciesRecord::all();
            $nursery = Nursery::where('nursery_id', intval($request->query->all()['nursery_id']))
                ->first();
            $batches = BatchInfo::where('nursery_id', intval($request->query->all()['nursery_id']))->orderBy('status', 'asc')
                ->orderByRaw("CASE WHEN status = 'Archived' THEN 1 ELSE 0 END")
                ->paginate(10)->appends(request()->query());

            $return_view = 'admin.nurseries.view_nursery';
            $return_array['nursery'] = $nursery;
            $return_array['speciesrecord'] = $mangroves;
            $return_array['managers'] = $managers;
            $return_array['batches'] = $batches;
        } else if ($location == 'view-batch') {
            $mangroves = SpeciesRecord::all();
            $nursery = Nursery::where('nursery_id', intval($request->query->all()['nursery_id']))
                ->first();
            $batch = BatchInfo::find($request->query->all()['batch_id']);
            $batch_monitoring_records = BatchMonitoring::where('batch_id', intval($batch->batch_id))->orderBy('monitor_id', 'desc')->paginate(10)->appends(request()->query());


            $latest_record = BatchMonitoring::where('batch_id', intval($request->query->all()['batch_id']))->latest()->first();
            $return_array['latest_record'] = $latest_record;

            // $purchases = Purchase::where('batch_id', intval($request->query->all()['batch_id']))->orderBy('acquire_id', 'desc')->paginate(10)->appends(request()->query());
            // $return_array['purchases'] = $purchases;

            $return_view = 'admin.nurseries.batch.view_batch';
            $return_array['nursery'] = $nursery;
            $return_array['speciesrecord'] = $mangroves;
            $return_array['batch'] = $batch;
            $return_array['batch_monitoring_records'] = $batch_monitoring_records;
        }else if ($location == 'view-batch-purchase') {
            $mangroves = SpeciesRecord::all();
            $nursery = Nursery::where('nursery_id', intval($request->query->all()['nursery_id']))
                ->first();
            $batch = BatchInfo::find($request->query->all()['batch_id']);
            // $batch_monitoring_records = BatchMonitoring::where('batch_id', intval($batch->batch_id))->orderBy('monitor_id', 'desc')->paginate(10)->appends(request()->query());


            $latest_record = BatchMonitoring::where('batch_id', intval($request->query->all()['batch_id']))->latest()->first();
            $return_array['latest_record'] = $latest_record;

            $purchases = Purchase::where('batch_id', intval($request->query->all()['batch_id']))->orderBy('acquire_id', 'desc')->paginate(10)->appends(request()->query());
            $return_array['purchases'] = $purchases;

            $return_view = 'admin.nurseries.batch.view_batch_purchase';
            $return_array['nursery'] = $nursery;
            $return_array['speciesrecord'] = $mangroves;
            $return_array['batch'] = $batch;
            // $return_array['batch_monitoring_records'] = $batch_monitoring_records;
        } else if ($location == 'add-batch') {
            $mangroves = SpeciesRecord::all();
            $nursery = Nursery::where('nursery_id', intval($request->query->all()['nursery_id']))
                ->first();
            $return_view = 'admin.nurseries.batch.batch';
            $return_array['speciesrecord'] = $mangroves;
            $return_array['nursery'] = $nursery;
        } else if ($location == 'update-batch') {
            $mangroves = SpeciesRecord::all();
            $nursery = Nursery::where('nursery_id', intval($request->query->all()['nursery_id']))
                ->first();
            $batch = BatchInfo::find($request->query->all()['batch_id']);
            $return_view = 'admin.nurseries.batch.batch';
            $return_array['nursery'] = $nursery;
            $return_array['speciesrecord'] = $mangroves;
            $return_array['batch'] = $batch;
        } else if ($location == 'add-batch-monitoring') {
            $nursery = Nursery::where('nursery_id', intval($request->query->all()['nursery_id']))
                ->first();
            $batch = BatchInfo::find($request->query->all()['batch_id']);
            $currentno = BatchInfo::where('nursery_id', intval($request->query->all()['nursery_id']))->get();

            $return_view = 'admin.nurseries.batch.batch_monitoring';
            $return_array['currentno'] = $currentno;
            $return_array['nursery'] = $nursery;
            $return_array['batch'] = $batch;
        } else if ($location == 'update-batch-monitoring') {
            $nursery = Nursery::where('nursery_id', intval($request->query->all()['nursery_id']))
                ->first();
            $batch = BatchInfo::find($request->query->all()['batch_id']);
            $batch_monitoring = BatchMonitoring::find(intval($request->query->all()['batch_monitoring_id']));
            $return_view = 'admin.nurseries.batch.batch_monitoring';
            $return_array['nursery'] = $nursery;
            $return_array['batch'] = $batch;
            $return_array['batch_monitoring'] = $batch_monitoring;
        } else if ($location == 'add-purchased-planted') {
            $nursery = Nursery::where('nursery_id', intval($request->query->all()['nursery_id']))
                ->first();
            $batch = BatchInfo::find($request->query->all()['batch_id']);

            $return_array['nursery'] = $nursery;
            $return_array['batch'] = $batch;
            $return_view = 'admin.nurseries.batch.add_purchase_plant';
        } else if ($location == 'update-purchased-planted') {
            $nursery = Nursery::where('nursery_id', intval($request->query->all()['nursery_id']))
                ->first();
            $batch = BatchInfo::find($request->query->all()['batch_id']);
            $purchase = Purchase::find(intval($request->query->all()['acquire_id']));

            $return_array['nursery'] = $nursery;
            $return_array['batch'] = $batch;
            $return_array['purchase'] = $purchase;
            $return_view = 'admin.nurseries.batch.add_purchase_plant';
        }

        return view($return_view, $return_array);
    }


    //Species Record Function -----------------------------
    function species_views(Request $request, $location)
    {
        $return_view = '';
        $return_array = [
            'speciesrecord' => null,
            'action' => $location,
        ];
        $user = Auth::user();
        $return_array['user'] = $user;

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['species-' . $location])) {
            return view('admin.not-authorized');
        }

        if ($location == 'add') {
            $return_view = 'admin.mangroves.add_species';
        } else if ($location == 'update') {
            $speciesrecord = SpeciesRecord::where('species_id', intval($request->query->all()['species_id']))
                ->first();
            $return_view = 'admin.mangroves.add_species';
            $return_array['speciesrecord'] = $speciesrecord;
        } else if ($location == 'view') {
            $speciesrecord = SpeciesRecord::find(intval($request->query->all()['species_id']));
            $return_view = 'admin.mangroves.view_speciesrecord';
            $return_array['speciesrecord'] = $speciesrecord;
        }
        return view($return_view, $return_array);
    }


    //Mangrove Project Function -----------------------------
    function project_views(Request $request, $location)
    {
        $return_view = '';
        $return_array = [
            'mangroveproject' => null,
            'action' => $location,
        ];
        $user = Auth::user();
        $return_array['user'] = $user;

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['project-' . $location])) {
            return view('admin.not-authorized');
        }

        if ($location == 'add') {
            $return_view = 'admin.projects.add_projects';
        } else if ($location == 'update') {
            $mangroveproject = MangroveProject::where('project_id', intval($request->query->all()['project_id']))
                ->first();
            $return_view = 'admin.projects.add_projects';
            $return_array['mangroveproject'] = $mangroveproject;
        } else if ($location == 'view') {
            $mangroveproject = MangroveProject::find(intval($request->query->all()['project_id']));
            $return_view = 'admin.projects.view_project';
            $return_array['mangroveproject'] = $mangroveproject;
        }

        return view($return_view, $return_array);
    }


    //Journals Function-------------------------------
    function journal_views(Request $request, $location)
    {
        $return_view = '';
        $return_array = [
            'journals' => null,
            'action' => $location,
        ];
        $user = Auth::user();
        $return_array['user'] = $user;

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['journal-' . $location])) {
            return view('admin.not-authorized');
        }

        if ($location == 'add') {
            $mangroves = SpeciesRecord::where('status', 'active')->get();
            $selectedSpecies = array();

            $return_view = 'admin.journals.add_journals';
            $return_array['speciesrecord'] = $mangroves;
            $return_array['selectedSpecies'] = $selectedSpecies;
        } else if ($location == 'update') {
            $mangroves = SpeciesRecord::all();
            $groupspecies = Species_group::where('resjournal_id', intval($request->query->all()['resjournal_id']))->get();
            $selectedSpecies = $groupspecies->pluck('species_id')->toArray();
            $journals = Journal::where('resjournal_id', intval($request->query->all()['resjournal_id']))
                ->first();
            $return_view = 'admin.journals.add_journals';
            $return_array['speciesrecord'] = $mangroves;
            $return_array['groupspecies'] = $groupspecies;
            $return_array['selectedSpecies'] = $selectedSpecies;
            $return_array['journals'] = $journals;
        } else if ($location == 'view') {
            $journals = Journal::find(intval($request->query->all()['resjournal_id']));

            $species_groups = Species_group::where('resjournal_id', $request->query->all()['resjournal_id'])->pluck('species_id');
            $mangrove = SpeciesRecord::whereIn('species_id', $species_groups)->get();

            $return_view = 'admin.journals.view_journals';
            $return_array['journals'] = $journals;
            $return_array['species_groups'] = $species_groups;
            $return_array['mangrove'] = $mangrove;
            // $return_array['species'] = $species;
        }

        return view($return_view, $return_array);
    }

    // Analytics Reports Functions----------------------
    function analytics_reports(Request $request, $key)
    {
        $user = Auth::user();

        // Perform checks
        if ($user->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization($user, UserAuthorization::$authorization_levels['report-' . $key])) {
            return view('admin.not-authorized');
        }

        $return_view = 'admin.reports.' . $key;
        $return_array = array();

        $return_array['user'] = $user;

        $search_id = $request->id;
        $searchTerm = $request->searchTerm;
        $return_array['searchTerm'] = $searchTerm;
        if ($key == 'plantation_records') {
            if (!$search_id) {
                if ($searchTerm) {
                    $plantation_records = Plantation::search($searchTerm)->paginate(10);
                } else {
                    $plantation_records = Plantation::paginate(10);
                }
                $return_array['plantation_records'] = $plantation_records;
            } else {
                $plantation_record = Plantation::find(intval($search_id));
                $return_array['plantation_record'] = $plantation_record;

                $return_array['survival_rates'] = $plantation_record->officer_monitorings()->select('date_monitored', 'survival_rate')->get();
                $return_array['no_planted_data'] = json_encode([
                    [
                        'unique_code' => $plantation_record->unique_code,
                        'target_no' => $plantation_record->target_no,
                        'current_planted' => $plantation_record->current_planted,
                    ]
                ]);
                // dd($plantation_record);
                // dd($return_array['no_planted_data']);

                $return_view = 'admin.reports.individual.plantation_record';
            }
        } else if ($key == 'plantation_monitoring') {
            $role_version = '';

            if ($user->user_role == "officer") {
                $role_version = 'admin';
            } else {
                $role_version = $user->user_role;
            }
            // dd($search_id);

            if (!$search_id) {
                if ($user->user_role == "admin" || $user->user_role == "officer") {
                    if ($searchTerm) {
                        $plantation_monitorings = Plantation::search($searchTerm)->where('status', 'ongoing')->paginate(10);
                    } else {
                        $plantation_monitorings = Plantation::where('status', 'ongoing')->paginate(10);
                    }
                } else if ($user->user_role == "manager") {
                    // dd($user->user_id);
                    if ($request->searchTerm) {
                        $plantation_monitorings = Plantation::search($searchTerm)->where('status', 'ongoing')->where('manager_id', $user->user_id)->paginate(10);
                    } else {
                        $plantation_monitorings = Plantation::where('status', 'ongoing')->where('manager_id', $user->user_id)->paginate(10);
                    }
                }
                $return_view = 'admin.reports.plantation_monitorings';
                $return_array['plantation_monitorings'] = $plantation_monitorings;
            } else {

                $start_date = $request->start_date;
                $end_date = $request->end_date;


                if ($user->user_role == "admin" || $user->user_role == "officer") {
                    $plantation_monitorings = OfficerMonitoring::where('plantation_id', $search_id)
                        ->whereBetween('date_monitored', [$start_date, $end_date])
                        ->get();

                    $graph_data = OfficerMonitoring::select('date_monitored', 'survival_rate', 'total_planted', 'no_dead', 'no_survived')
                        ->where('plantation_id', $search_id)
                        ->whereBetween('date_monitored', [$start_date, $end_date])
                        ->get();
                    $return_array['graph_data'] = $graph_data;
                } else if ($user->user_role == "manager") {
                    $plantation_monitorings = ManagerMonitoring::where('plantation_id', $search_id)
                        ->whereBetween('date_monitored', [$start_date, $end_date])
                        ->get();

                    $graph_data = ManagerMonitoring::select('date_monitored', 'current_planted', 'no_dead', 'no_replanted')
                        ->where('plantation_id', $search_id)
                        ->whereBetween('date_monitored', [$start_date, $end_date])
                        ->get();
                    $return_array['graph_data'] = $graph_data;
                }
                // dd($start_date, $end_date);
                // dd($plantation_monitorings);
                $return_view = 'admin.reports.individual.plantation_monitoring';
                $return_array['start_date'] = $start_date;
                $return_array['end_date'] = $end_date;
                $plantation_record = Plantation::find(intval($search_id));
                $return_array['plantation'] = $plantation_record;
                $return_array['plantation_monitorings'] = $plantation_monitorings;
            }
        } else if ($key == 'nursery_records') {
            if (!$search_id) {
                if ($searchTerm) {
                    $nursery_records = Nursery::search($searchTerm)->paginate(10);
                } else {
                    $nursery_records = Nursery::paginate(10);
                }
                $return_array['nursery_records'] = $nursery_records;
            } else {
                $nursery_record = Nursery::find(intval($search_id));

                $batch_infos = $nursery_record->batch_infos;

                $latest_records = array();
                foreach ($batch_infos as $batch_info) {
                    // dd($batch_info->batch_monitorings()->latest()->first());
                    if (strtolower($batch_info->status) != "active") {
                        continue;
                    }
                    $record = $batch_info->batch_monitorings()->latest()->first();
                    if ($record) {
                        array_push($latest_records, [
                            "species" => $batch_info->species_record->common_name,
                            "survival_rate" => $record->survival_rate,
                            "current_no_potted" => $batch_info->current_no_potted,
                        ]);
                    } else {
                        array_push($latest_records, [
                            "species" => $batch_info->species_record->common_name,
                            "survival_rate" => 0,
                            "current_no_potted" => $batch_info->current_no_potted,
                        ]);
                    }
                }
                $return_array['latest_records'] = json_encode($latest_records);

                $return_view = 'admin.reports.individual.nursery_record';
                $return_array['nursery_record'] = $nursery_record;
            }
        } else if ($key == 'nursery_monitoring') {
            if (!$search_id) {
                $records = [];
                if ($searchTerm) {
                    $batch_infos = BatchInfo::search($searchTerm)->get();
                    if ($batch_infos->isEmpty()) {
                        $species_records = SpeciesRecord::search($searchTerm)->get();
                        foreach ($species_records as $species_record) {
                            $batch_infos = $batch_infos->concat($species_record->batchinfos);
                        }
                    }
                } else {
                    $batch_infos = BatchInfo::orderBy('status', 'asc')->get();
                }
                if ($batch_infos) {
                    foreach ($batch_infos as $batch_info) {
                        if ($batch_info->nursery->manager_id == $user->user_id) {
                            array_push($records, $batch_info);
                        }
                    }
                }
                $return_array['batch_infos'] = $records;
            } else {
                $start_date = $request->start_date;
                $end_date = $request->end_date;

                $batch_info = BatchInfo::find(intval($search_id));
                $batch_monitorings = BatchMonitoring::where('batch_id', intval($search_id))
                    ->whereBetween('date_monitored', [$start_date, $end_date])->get();
                $return_view = 'admin.reports.individual.nursery_monitoring_individual';
                $return_array['start_date'] = $start_date;
                $return_array['end_date'] = $end_date;

                $return_array['batch_info'] = $batch_info;
                $return_array['batch_monitorings'] = $batch_monitorings;
            }
        } else if ($key == 'projects') {

            $proj_status = $request->proj_status;

            $projects = MangroveProject::where('stakeholder_id', $user->user_id)->where('proj_status', $proj_status)->get();

            $return_view = 'admin.reports.individual.projects';
            $return_array['proj_status'] = $proj_status;
            $return_array['projects'] = $projects;
        }


        return view($return_view, $return_array);
    }

    //Stakeholders Function-------------------------------
    function stakeholder_views(Request $request, $location)
    {
        $return_view = '';
        $return_array = [
            'pending' => null,
            'action' => $location,
        ];

        $user = Auth::user();
        $return_array['user'] = $user;

        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['stakeholder-' . $location])) {
            return view('admin.not-authorized');
        }

        if ($location == 'view') {
            $pending = User::find(intval($request->query('user_id')));
            $return_view = 'admin.users.stakeholder_views';
            $return_array['pending'] = $pending;
        } else if ($location == 'update') {
            $registered = User::where('user_id', intval($request->query('user_id')))
                ->first();
            $return_view = 'admin.users.update_stakeholder_pass';
            $return_array['registered'] = $registered;
        } else if ($location == 'view-registered') {
            $registered = User::find(intval($request->query('user_id')));

            $stakeholder = Stakeholder::where('stakeholder_id', intval($request->query('user_id')))->first();

            $return_array['registered'] = $registered;
            $return_array['stakeholder'] = $stakeholder;
            $return_view = 'admin.users.stakeholder_registered_view';
        }

        return view($return_view, $return_array);
    }
    public function admin_change_password(Request $request)
    {
        // Perform checks
        if (Auth::user()->status != 'active') {
            return view('admin.not-activated');
        }
        if (!UserAuthorization::verify_authorization(Auth::user(), UserAuthorization::$authorization_levels['admin-change-password'])) {
            return view('admin.not-authorized');
        }

        $user = User::find($request->user_id);
        return view('admin.users.change_password', ['user' => $user]);
    }
}