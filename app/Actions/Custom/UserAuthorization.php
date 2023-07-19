<?php

namespace App\Actions\Custom;

use App\Models\User;

class UserAuthorization
{
    static $authorization_levels = [
        // AdminController =================================
        'dashboard' => ['admin', 'manager', 'officer', 'stakeholder', 'researcher'],
        'manage-plantations' => ['admin', 'manager', 'officer'],
        'manage-nurseries' => ['admin', 'manager', 'officer'],

        'manage-users' => ['admin'],
        'managers' => ['admin'],
        'manage-stakeholders' => ['admin'],

        'manage-speciesrecords' => ['admin'],
        'manage-projects' => ['stakeholder'],
        'manage-journals' => ['researcher'],
        'manage-maps' => ['admin', 'manager', 'officer', 'stakeholder', 'researcher'],

        'account-settings' => ['admin', 'manager', 'officer', 'stakeholder', 'researcher'],
        'admin-change-password' => ['admin'],

        // User
        'user-add' => ['admin'],
        'user-add-manager' => ['admin'],
        'user-view' => ['admin'],
        'user-edit-user-account' => ['admin', 'researcher', 'officer'],
        'user-edit-manager-account' => ['admin', 'manager'],
        'user-edit-stakeholder-account' => ['stakeholder'],

        // Plantation
        'plantation-add' => ['admin'],
        'plantation-update' => ['admin'],
        'plantation-view' => ['admin', 'manager', 'officer'],
        // Plantation -> Manager_monitoring
        'plantation-add-monitoring-record' => ['manager'],
        'plantation-update-monitoring-record' => ['manager'],
        // Plantation -> Officer_monitoring
        'plantation-view-officer-monitoring-record' => ['admin', 'officer'],
        'plantation-add-officer-monitoring-record' => ['officer'],
        'plantation-update-officer-monitoring-record' => ['officer'],

        // Nursery
        'nursery-add' => ['manager', 'officer'],
        'nursery-view' => ['manager', 'officer'],
        'nursery-update' => ['manager', 'officer'],
        'nursery-add-batch' => ['manager', 'officer'],
        'nursery-view-batch' => ['manager', 'officer'],
        'nursery-view-batch-purchase' => ['manager', 'officer'],
        'nursery-update-batch' => ['manager', 'officer'],
        'nursery-add-batch-monitoring' => ['manager', 'officer'],
        'nursery-update-batch-monitoring' => ['manager', 'officer'],
        'nursery-add-purchased-planted' => ['manager', 'officer'],
        'nursery-update-purchased-planted' => ['manager', 'officer'],

        // Species Records
        'species-add' => ['admin'],
        'species-view' => ['admin'],
        'species-update' => ['admin'],

        // Project
        'project-add' => ['stakeholder'],
        'project-view' => ['stakeholder'],
        'project-update' => ['stakeholder'],

        // Journal
        'journal-add' => ['researcher'],
        'journal-view' => ['researcher'],
        'journal-update' => ['researcher'],

        // Report
        'report-heatmap' => ['admin', 'manager', 'officer', 'stakeholder'],
        'report-plantation_records' => ['admin', 'manager', 'officer'],
        'report-plantation_monitoring' => ['admin', 'manager', 'officer'],
        'report-nursery_records' => ['admin', 'manager', 'officer'],
        'report-nursery_monitoring' => ['admin', 'manager', 'officer'],
        'report-projects' => ['stakeholder'],   
        // Stakeholder
        'stakeholder-view' => ['admin'],
        'stakeholder-update' => ['admin'],
        'stakeholder-view-registered' => ['admin'],

        // AdminController =================================


        // BatchController =================================
        'batch-create' => ['admin', 'manager', 'officer'],
        'batch-update' => ['admin', 'manager', 'officer'],
        'batch-archive' => ['admin', 'manager', 'officer'],
        'batch-purchased-planted' => ['admin', 'manager', 'officer'],
        'batch-update-purchased-planted' => ['admin', 'manager', 'officer'],
        // BatchController =================================

        // BatchMonitoringController =======================
        'batchmonitoring-create' => ['admin', 'manager', 'officer'],
        'batchmonitoring-update' => ['admin', 'manager', 'officer'],
        // BatchMonitoringController =======================

        // JournalController =================================
        'journalController-create' => ['admin', 'researcher'],
        'journalController-update' => ['admin', 'researcher'],
        'journalController-archive' => ['admin', 'researcher'],
        // JournalController =================================

        // MonitoringRecordController ========================
        'monitoringRecord-create' => ['admin', 'manager'],
        'monitoringRecord-update' => ['admin', 'manager'],
        // MonitoringRecordController ========================

        // NurseryController =================================
        'nurseryController-create' => ['manager', 'officer'],
        'nurseryController-update' => ['manager', 'officer'],
        // NurseryController =================================

        // OfficerMonitoringController =================================
        'officerMonitoringController-create' => ['officer'],
        'officerMonitoringController-update' => ['officer'],
        // OfficerMonitoringController =================================

        // PlantationsController =================================
        'plantationsController-create' => ['admin'],
        'plantationsController-update' => ['admin'],
        // PlantationsController =================================

        // ProjectController =================================
        'projectController-create' => ['admin', 'stakeholder'],
        'projectController-update' => ['admin', 'stakeholder'],
        'projectController-archive' => ['admin', 'stakeholder'],
        // ProjectController =================================

        // SpeciesController =================================
        'speciesController-create' => ['admin'],
        'speciesController-update' => ['admin'],
        'speciesController-archive' => ['admin'],
        'speciesController-delete' => ['admin'],
        // SpeciesController =================================

        // StakeholderController =================================
        // 'stakeholderController-register' => ['admin'],
        'stakeholderController-update_stakeholder_pass' => ['admin'],
        'stakeholderController-approve_request' => ['admin'],
        'stakeholderController-disable' => ['admin'],
        'stakeholderController-delete_user' => ['admin'],
        // StakeholderController =================================

        // UserController =================================
        'userController-add_user' => ['admin'],
        'userController-add_manager' => ['admin'],
        'userController-change_user_role' => ['admin'],
        'userController-toggle_user_status' => ['admin'],
        'userController-edit_user_detail' => ['admin', 'manager', 'researcher', 'stakeholder', 'officer'],
        'userController-edit_user_password' => ['admin', 'manager', 'researcher', 'stakeholder', 'officer'],
        'userController-edit_manager_details' => ['manager'],
        'userController-edit_manager_password' => ['manager'],
        'userController-edit_stakeholder_details' => ['stakeholder'],
        'userController-edit_stakeholder_password' => ['stakeholder'],

        'userController-admin_change_password' => ['admin'],
        // UserController =================================
    ];


    public static function verify_authorization(User $user, $allowed_user_roles = [])
    {
        foreach ($allowed_user_roles as $role) {
            if ($role == $user->user_role) {
                return true;
            }
        }

        return false;
    }
}