<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\JournalsController;
use App\Http\Controllers\NurseriesController;
use App\Http\Controllers\PlantationsController;
use App\Http\Controllers\BatchMonitoringController;
use App\Http\Controllers\DashboardGraphsController;
use App\Http\Controllers\MonitoringRecordController;
use App\Http\Controllers\OfficerMonitoringController;
use App\Http\Controllers\SpeciesController;
use App\http\Controllers\ProjectController;
use App\http\Controllers\SearchController;
use App\http\Controllers\ManageMapsController;
use App\http\Controllers\HomeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StakeholderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Models\Journal;
use App\Models\OfficerMonitoring;
use App\Models\Stakeholder;
use Monolog\Handler\RotatingFileHandler;

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/register', function () {
    return view('register');
})->name('register');
Route::get('/stakeholder/register', function () {
    return view('register-stakeholder');
})->name('stakeholder-register');
Route::post('/stakeholder/register', [StakeholderController::class, 'register']);

// Route::post('/auth', function (Request $request) {
//     $validated = $request->validate([
//         'email' =>'required|email',
//         'password' =>'required|min:6',
//     ]);

//     return redirect('/admin');
// });

// Get requests are (for now) only used to get the views
// More specific routes are placed above the more general ones as laravel goes to each line by line as ordered here:
// /admin/{location} 
// is in the bottom as it is a fallback route if it doesn't get any match from

// /admin/manage-users/{location} 
// /admin/manage-plantations/{location}

Route::group(['middleware' => ['auth']], function () {
    Route::post('/admin/manage-users/add', [UsersController::class, 'add_user']);
    Route::post('/admin/managers/add-manager', [UsersController::class, 'add_manager']);
    Route::get('/admin/manage-users/change-user-role', [UsersController::class, 'change_user_role']);
    Route::get('/admin/manage-users/toggle-user-status', [UsersController::class, 'toggle_user_status']);
    Route::get('/admin/manage-users/{location}', [AdminController::class, 'users']);

    //Account Settings View
    Route::get('/admin/account-settings/{location}', [AdminController::class, 'users']);

    //Edit Users Account (Admin, Officer, Researcher)
    Route::patch('/admin/account-settings/edit-user-account', [UsersController::class, 'edit_user_detail']);
    Route::patch('/admin/account-settings/edit-user-password', [UsersController::class, 'edit_user_password']);

    //Edit Manager Account
    Route::patch('/admin/account-settings/edit-manager-account', [UsersController::class, 'edit_manager_details']);
    Route::patch('/admin/account-settings/edit-manager-password', [UsersController::class, 'edit_manager_password']);

    //Edit Stakeholder Account
    Route::patch('/admin/account-settings/edit-stakeholder-account', [UsersController::class, 'edit_stakeholder_details']);
    Route::patch('/admin/account-settings/edit-stakeholder-password', [UsersController::class, 'edit_stakeholder_password']);

    // Newly added - mostly similar to manage-users
    Route::get('/admin/managers/{location}', [AdminController::class, 'users']);

    //View User Data
    Route::get('/admin/manage-users/{location}', [AdminController::class, 'users']);

    // Reports Views
    Route::get('/admin/analytics-reports/{key}', [AdminController::class, 'analytics_reports']);

    # Archive Record
    Route::get('/admin/archive-species-record', [SpeciesController::class, 'archive']);
    Route::get('/admin/archive-mangrove-project', [ProjectController::class, 'archive']);
    Route::get('/admin/archive-manage-journals', [JournalsController::class, 'archive']);
    Route::get('/admin/archive-batch-propagule', [BatchController::class, 'archive']);

    # Delete Record
    Route::get('/admin/delete-record', [SpeciesController::class, 'delete']);

    //Stakeholder
    Route::get('/admin/manage-stakeholders/{location}', [AdminController::class, 'stakeholder_views']);
    Route::patch('/admin/manage-stakeholders/update', [StakeholderController::class, 'update_stakeholder_pass']);
    Route::get('/admin/manage-stakeholders/approve/{user_id}', [StakeholderController::class, 'approve_request'])->name('approve.stakeholder');

    //Disable Stakeholder
    Route::get('/admin/disable-manage-stakeholders/', [StakeholderController::class, 'disable']);
    Route::get('/admin/manage-stakeholders/delete/{user_id}', [StakeholderController::class, 'delete_user'])->name('delete.user');

    //Species Record
    Route::put('/admin/manage-speciesrecords/add', [SpeciesController::class, 'create']);
    Route::patch('/admin/manage-speciesrecords/update', [SpeciesController::class, 'update']);
    Route::get('/admin/manage-speciesrecords/{location}', [AdminController::class, 'species_views']);

    //Mangrove Project
    Route::put('/admin/manage-projects/add', [ProjectController::class, 'create']);
    Route::patch('/admin/manage-projects/{project_id}', [ProjectController::class, 'update']);
    Route::get('/admin/manage-projects/{location}', [AdminController::class, 'project_views']);

    //Journal
    Route::put('/admin/manage-journals/add', [JournalsController::class, 'create']);
    Route::patch('/admin/manage-journals/{resjournal_id}', [JournalsController::class, 'update']);
    Route::get('/admin/manage-journals/{location}', [AdminController::class, 'journal_views']);

    // Plantation 
    Route::put('/admin/manage-plantations/add', [PlantationsController::class, 'create']);
    Route::patch('/admin/manage-plantations/update', [PlantationsController::class, 'update']);
    Route::get('/admin/manage-plantations/{location}', [AdminController::class, 'plantation_views']);

    // Nursery
    Route::put('/admin/manage-nurseries/add', [NurseriesController::class, 'create']);
    Route::patch('/admin/manage-nurseries/update', [NurseriesController::class, 'update']);

    // Nursery -> Batch
    Route::put('/admin/manage-nurseries/add-batch', [BatchController::class, 'create']);
    Route::patch('/admin/manage-nurseries/update-batch', [BatchController::class, 'update']);

    //Batch Purchase
    Route::put('/admin/manage-nurseries/add-purchased-planted', [PurchaseController::class, 'add_purchased_planted']);
    Route::patch('/admin/manage-nurseries/update-purchased-planted', [PurchaseController::class, 'update_purchased_planted']);

    // Nursery -> Batch Monitoring
    Route::put('/admin/manage-nurseries/add-batch-monitoring', [BatchMonitoringController::class, 'create']);
    Route::patch('/admin/manage-nurseries/update-batch-monitoring', [BatchMonitoringController::class, 'update']);

    // Nursery Views
    Route::get('/admin/manage-nurseries/{location}', [AdminController::class, 'nursery_views']);

    //Plantation -> Manager Monitoring records
    Route::put('/admin/manage-plantations/add-monitoring-record', [MonitoringRecordController::class, 'create']);
    Route::patch('/admin/manage-plantations/update-monitoring-record', [MonitoringRecordController::class, 'update']);

    //Plantation -> Officer Monitoring records
    Route::put('/admin/manage-plantations/add-officer-monitoring-record', [OfficerMonitoringController::class, 'create']);
    Route::patch('/admin/manage-plantations/update-officer-monitoring-record', [OfficerMonitoringController::class, 'update']);
    Route::get('/admin/manage-plantations/{location}', [AdminController::class, 'plantation_views']);

    //Get Bar Graph Plantation Planted
    Route::get('/graph/plantation-planted', [DashboardGraphsController::class, 'currentPlanted']);

    Route::get('/graph/survival-rate', [DashboardGraphsController::class, 'survivalRate']);

    // Manage Maps
    Route::post('/admin/manage-maps/add', [ManageMapsController::class, 'create']);
    // Route::get('/admin/manage-maps/addspecies', [ManageMapsController::class, 'add_species']);

    // Allow Change of password by admin
    Route::get('/admin/manage-accounts/update', [AdminController::class, 'admin_change_password']);
    Route::patch('/admin/manage-accounts/change-password', [UsersController::class, 'admin_change_password']);

    // // Main Admin Views Route
    Route::get('/admin/{location}', [AdminController::class, 'index']);

    Route::get('/admin', function () {
        return redirect('/admin/dashboard');
    });



    Route::post('/manage-maps-update/species-info', [ManageMapsController::class, 'update_species_info']);
    Route::post('/manage-maps-update/location', [ManageMapsController::class, 'update_location']);
    Route::post('/admin/manage-maps/addspecies', [ManageMapsController::class, 'add_species']);

});


// Redirect in case location is not completely filled by user
Route::get('/home', function () {
    if (!Auth::user()) {
        return view('admin.not-activated');
    }
    if (Auth::user()->status != 'active') {
        Auth::logout();
        return view('admin.not-activated');
    }
    return redirect('/admin/dashboard');
});

// Search
Route::get('/search/{searchType}', [SearchController::class, 'searchType']);
Route::get('/search', [SearchController::class, 'index']);

Route::get('/mangroves', [SearchController::class, 'mangroves']);
Route::get('/projects', [SearchController::class, 'projects']);
Route::get('/journals', [SearchController::class, 'journals']);