<?php

/**
 * CAPABILITIES_______________________________________________________________
 * Configuration File to define user capabilities.
 *
 * The first two level of array keys are for presentational
 * purposes, so you can mention human-readable string
 * instead of machine-readable string.
 *
 * All the capabilities needs to be defined with underscores,
 * with a human-readable label corresponding to them.
 *
 * php version 7.1.3
 *
 * @category CMS,Application
 * @package  NAPT-2
 * @license  MIT (https://opensource.org/licenses/MIT)
 */

return [

    /*
   |--------------------------------------------------------------------------
   | User Access Management
   |--------------------------------------------------------------------------
   |
   | Capabilities specific to User Access Management.
   |
   */
    'Access Management' => [
        'Users' => [
            // capability_key => label
            'view_users'        => 'View User',
            'add_users'         => 'Add User',
            'edit_users'        => 'Edit User',
            'delete_users'      => 'Delete User',
            'user_capabilities' => 'User Capabilities'
        ],

        'Users Group' => [
            // capability_key => label
            'view_users_group'        => 'View Users Group',
            'add_users_group'         => 'Add Users Group',
            'edit_users_group'        => 'Edit Users Group',
            'delete_users_group'      => 'Delete Users Group',
        ],

        'Roles & Permission' => [
            // capability_key => label
            'view_roles_permissions'   => 'View Roles & Permissions',
            'add_roles_permissions'    => 'Add Roles & Permissions',
            'edit_roles_permissions'   => 'Edit Roles & Permissions',
            'delete_roles_permissions' => 'Delete Roles & Permissions'
        ],


        'Reports' => [
            // capability_key => label
            'manage_reports'                                    => 'Manage Reports',
            'view_user_activity_log_reports'                    => 'View user activity log',
        ],

    ],


    /*
    |--------------------------------------------------------------------------
    | Application
    |--------------------------------------------------------------------------
    |
    | Capabilities specific to the web application.
    |
    */
    'Inventory' => include(config_path('capabilities_inventory.php')),


    /*
    |--------------------------------------------------------------------------
    | Core
    |--------------------------------------------------------------------------
    |
    | Core Capabilities to the system.
    |
    */
        'Core & Settings'   => [
            'Core' => [
                // capability_key => label
                'view_dashboard'    => 'View Dashboard',
            ],

            'Common Labels' => [
                // capability_key => label
                'view_common_labels'   => 'View Common Label',
                'edit_common_labels'   => 'Edit Common Label',
                'delete_common_labels' => 'Delete Common Label',
            ],

          /*   'Financial Year' => [
                // capability_key => label
                'view_financial_year'   => 'View Financial Year',
                'add_financial_year'    => 'Add Financial Year',
                'edit_financial_year'   => 'Edit Financial Year',
                'delete_financial_year' => 'Delete Financial Year',
            ], */

            'Employees' => [
                // capability_key => label
                'view_employees'   => 'View Employee  Information',
                'add_employees'    => 'Add Employee Information',
                'edit_employees'   => 'Edit Employee Information',
                'delete_employees' => 'Delete Employee Information',
            ],
        ],

];

