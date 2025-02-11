<?php

use Illuminate\Support\Facades\Route;

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
/*
| --------------------------------------------------------------------------
| UTILITIES: Clear cache, views, config, route and debugbar
| --------------------------------------------------------------------------
|
| The following URL will run the mentioned Artisan commands
| and clean up the things accordingly. It's a nicer way
| to clear things while in production.
|
| @props Nazmul Hasan
| @link  https://laravel.com/docs/5.2/artisan#calling-commands-via-code
| --------------------------------------------------------------------------
*/
Route::prefix(Request::segment(1))->middleware('locale')->group(
    function () {
        if (Config::get('app.debug')) {
            Route::get(
                '/clear',
                function () {
                    $clearCache = Artisan::call('cache:clear');
                    echo "Cache cleared<br>";

                    $clearView = Artisan::call('view:clear');
                    echo "View cleared<br>";

                    $clearConfig = Artisan::call('config:clear');
                    echo "Config cleared<br>";

                    $clearRoute = Artisan::call('route:clear');
                    echo "Route cleared<br>";
                }
            );
        }
    }
);

require __DIR__.'/../auth.php';

/*
| --------------------------------------------------------------------------
| AJAX Routes
| --------------------------------------------------------------------------
|
| All the URLs specific to the AJAX requests. The usage code can be
| found in the .js files under resources/assets/js directory.
|
| --------------------------------------------------------------------------
*/
// TODO VistaCMS Framework Update Required
Route::prefix(Request::segment(1))->middleware('locale')->group(
    function () {
        Route::post(
            'users/meta/save',
            [
                'as'   => 'users.meta.save',
                'uses' => 'Users\UserController@ajaxMetaSave'
            ]
        )->middleware('auth');
    }
);

/*
| --------------------------------------------------------------------------
| Administration (Back End) Routes
| --------------------------------------------------------------------------
|
| All the URLs specific to the admin panel only. The route-group
| needs to be placed before front-end routes for not conflicting
| with the dynamic URLs of the CMS.
|
| --------------------------------------------------------------------------
*/

// Uses for setting up the language.
Route::get('{locale}/' . config('app.admin_route_prefix'), 'LanguageController@setLocale');

/*
| --------------------------------------------------------------------------
| PUBLIC API ROUTES
| --------------------------------------------------------------------------
|
| Routes specific to global APIs of the app. The order is important.
| It must be stayed below the admin routes.
| --------------------------------------------------------------------------
*/
Route::prefix(Request::segment(1))->middleware('locale')->group(
    function () {
        Route::get('getDistrict/{division_id?}', 'Settings\DistrictController@getDistrict');
        Route::get('getThanaUpazila/{district_id?}', 'Settings\ThanaUpazilaController@getThanaUpazila');
        Route::get('getUnionWard/{thana_upazila_id?}', 'Settings\UnionWardController@getUnionWard');
    }
);

Route::prefix(Request::segment(1) . config('app.admin_route_prefix'))->middleware('locale')->group(
    function () {
        // --------------------
        // Admin Dashboard
        // --------------------
        Route::get('/', 'Admin\DashboardController@index')->middleware('auth', 'permissions:view_dashboard');
        Route::get('monitoring', 'Admin\DashboardController@showMonitoring')->middleware('auth', 'permissions:view_dashboard');
        Route::get('training', 'Admin\DashboardController@showTrainingModule')->middleware('auth', 'permissions:view_dashboard');
        Route::get('procurement', 'Admin\DashboardController@showProcurementModule')->middleware('auth', 'permissions:view_dashboard');
        Route::get('inventory', 'Admin\DashboardController@showInventoryModule')->middleware('auth', 'permissions:view_dashboard');

        Route::get('dashboard', 'Admin\DashboardController@index')->middleware('auth', 'permissions:view_dashboard');
        Route::get('/dashboard/monitoring', 'Admin\DashboardController@showMonitoring')->middleware('auth', 'permissions:view_dashboard');
        Route::get('/dashboard/training', 'Admin\DashboardController@showTrainingModule')->middleware('auth', 'permissions:view_dashboard');
        Route::get('/dashboard/procurement', 'Admin\DashboardController@showProcurementModule')->middleware('auth', 'permissions:view_dashboard');

        Route::get('employee-picker', 'EmployeePickerController@showEmployeeList')->middleware('auth');
        Route::post('employee-picker/read', 'EmployeePickerController@read')->middleware('auth');
        // --------------------
        // System Status
        // --------------------
        Route::get('status', 'Settings\StatusController@index')->middleware('auth', 'permissions:manage_status');

        // --------------------
        // Options
        // --------------------
        Route::get('settings', 'Settings\OptionsController@index')->middleware('auth', 'permissions:manage_options');

        Route::patch(
            'settings/save',
            [
                'as'   => 'settings.save',
                'uses' => 'Settings\OptionsController@save'
            ]
        )->middleware('auth');

        // --------------------
        // Backup
        // --------------------
        Route::get('settings/backup', 'Settings\OptionsController@backup')->middleware('auth', 'permissions:manage_backup');

        Route::post(
            'settings/backup/save',
            [
                'as'   => 'backup.save',
                'uses' => 'Settings\OptionsController@createBackup'
            ]
        )->middleware('auth');

        Route::get('settings/backup/download/{file?}', 'Settings\OptionsController@downloadBackup')->middleware('auth');

        Route::post(
            'settings/backup/download/delete/{file?}',
            [
                'as'   => 'backup.delete',
                'uses' => 'Settings\OptionsController@deleteBackup'
            ]
        )->middleware('auth');

        Route::post(
            'settings/backup/clear',
            [
                'as'   => 'backup.clear',
                'uses' => 'Settings\OptionsController@deleteAllBackup'
            ]
        )->middleware('auth');

        Route::post(
            'settings/backup/mysql/save',
            [
                'as'   => 'backup.mysql.save',
                'uses' => 'Settings\OptionsController@saveMysql'
            ]
        )->middleware('auth');

        // --------------------
        // Regions
        // --------------------
        Route::get('settings/region', 'Settings\RegionController@index')->middleware('auth', 'permissions:view_regions;add_regions');

        Route::get('settings/region/add', 'Settings\RegionController@add')->middleware('auth', 'permissions:add_regions');

        Route::post(
            'settings/region/save',
            [
                'as'   => 'region.save',
                'uses' => 'Settings\RegionController@save'
            ]
        )->middleware('auth');

        Route::get('settings/region/{region_id?}/edit', 'Settings\RegionController@edit')->middleware('auth', 'permissions:edit_regions');

        Route::put(
            'settings/region',
            [
                'as'   => 'region.update',
                'uses' => 'Settings\RegionController@update'
            ]
        )->middleware('auth');

        Route::delete(
            'settings/region/{region_id}/delete',
            [
                'as'   => 'region.delete',
                'uses' => 'Settings\RegionController@delete'
            ]
        )->middleware('auth', 'permissions:delete_regions');

        // --------------------
        // Divisions
        // --------------------
        Route::get('settings/division', 'Settings\DivisionController@index')->middleware('auth', 'permissions:view_divisions;add_divisions');

        Route::get('settings/division/add', 'Settings\DivisionController@add')->middleware('auth', 'permissions:add_divisions');

        Route::post(
            'settings/division/save',
            [
                'as'   => 'division.save',
                'uses' => 'Settings\DivisionController@save'
            ]
        )->middleware('auth');

        Route::get('settings/division/{division_id?}/edit', 'Settings\DivisionController@edit')->middleware('auth', 'permissions:edit_divisions');

        Route::put(
            'settings/division',
            [
                'as'   => 'division.update',
                'uses' => 'Settings\DivisionController@update'
            ]
        )->middleware('auth');

        Route::delete(
            'settings/division/{division_id}/delete',
            [
                'as'   => 'division.delete',
                'uses' => 'Settings\DivisionController@delete'
            ]
        )->middleware('auth', 'permissions:delete_divisions');

        // --------------------
        // District
        // --------------------
        Route::get('settings/district', 'Settings\DistrictController@index')->middleware('auth', 'permissions:view_districts;add_districts');

        Route::get('settings/district/add', 'Settings\DistrictController@add')->middleware('auth', 'permissions:add_districts');

        Route::post(
            'settings/district/save',
            [
                'as'   => 'district.save',
                'uses' => 'Settings\DistrictController@save'
            ]
        )->middleware('auth');

        Route::get('settings/district/{district_id?}/edit', 'Settings\DistrictController@edit')->middleware('auth', 'permissions:edit_districts');

        Route::put(
            'settings/district',
            [
                'as'   => 'district.update',
                'uses' => 'Settings\DistrictController@update'
            ]
        )->middleware('auth');

        Route::delete(
            'settings/district/{district_id}/delete',
            [
                'as'   => 'district.delete',
                'uses' => 'Settings\DistrictController@delete'
            ]
        )->middleware('auth', 'permissions:delete_districts');

        // --------------------
        // Thana Upazilas
        // --------------------
        Route::get('settings/thanaupazilas', 'Settings\ThanaUpazilaController@index')->middleware('auth', 'permissions:view_thana_upazilas;add_thana_upazilas');

        Route::get('settings/thanaupazilas/add', 'Settings\ThanaUpazilaController@add')->middleware('auth', 'permissions:add_thana_upazilas');

        Route::post(
            'settings/thanaupazilas/save',
            [
                'as'   => 'thanaupazilas.save',
                'uses' => 'Settings\ThanaUpazilaController@save'
            ]
        )->middleware('auth');

        Route::get('settings/thanaupazilas/{thanaupazilas_id?}/edit', 'Settings\ThanaUpazilaController@edit')->middleware('auth', 'permissions:edit_thana_upazilas');

        Route::put(
            'settings/thanaupazilas',
            [
                'as'   => 'thanaupazilas.update',
                'uses' => 'Settings\ThanaUpazilaController@update'
            ]
        )->middleware('auth');

        Route::delete(
            'settings/thanaupazilas/{thanaupazilas_id}/delete',
            [
                'as'   => 'thanaupazilas.delete',
                'uses' => 'Settings\ThanaUpazilaController@delete'
            ]
        )->middleware('auth', 'permissions:delete_thana_upazilas');

        // --------------------
        // Union Ward
        // --------------------
        Route::get('settings/union-ward', 'Settings\UnionWardController@index')->middleware('auth', 'permissions:view_union_ward;add_union_ward');

        Route::get('settings/union-ward/add', 'Settings\UnionWardController@add')->middleware('auth', 'permissions:add_union_ward');

        Route::post(
            'settings/union-ward/save',
            [
                'as'   => 'unionward.save',
                'uses' => 'Settings\UnionWardController@save'
            ]
        )->middleware('auth');

        Route::get('settings/union-ward/{unionward_id?}/edit', 'Settings\UnionWardController@edit')->middleware('auth', 'permissions:edit_union_ward');

        Route::put(
            'settings/union-ward',
            [
                'as'   => 'unionward.update',
                'uses' => 'Settings\UnionWardController@update'
            ]
        )->middleware('auth');

        Route::delete(
            'settings/union-ward/{unionward_id}/delete',
            [
                'as'   => 'unionward.delete',
                'uses' => 'Settings\UnionWardController@delete'
            ]
        )->middleware('auth', 'permissions:delete_union_ward');

        // --------------------
        // Users
        // --------------------
        Route::get('users/list', 'Users\UserController@index')->middleware('auth', 'permissions:view_users');
        Route::get('users/getEmployeeByDesignation/{designationId}', 'Settings\EmployeeController@getEmployeeByDesignation')->middleware('auth', 'permissions:view_users');
        Route::get('users/getEmployeeByEmployeeId/{employeeId}', 'Settings\EmployeeController@getEmployeeByEmployeeId')->middleware('auth', 'permissions:view_users');
        Route::get('users/logged-in-user', 'Users\UserController@getLoggedInUserList')->middleware('auth', 'permissions:view_users');
        Route::get('users/project/getProjectsBySearchParam', 'ProjectController@getProjectsBySearchParam')->middleware('auth', 'permissions:view_users');

        Route::get('users/add', 'Users\UserController@add')->middleware('auth', 'permissions:add_users');

        Route::post(
            'users/save',
            [
                'as'   => 'users.save',
                'uses' => 'Users\UserController@save'
            ]
        )->middleware('auth');

        Route::get('users/edit/{user_id?}', 'Users\UserController@edit')->middleware('auth', 'permissions:edit_users');

        Route::put(
            'users/update',
            [
                'as'   => 'users.update',
                'uses' => 'Users\UserController@update'
            ]
        )->middleware('auth');

        Route::delete(
            'users/delete/{user_id}',
            [
                'as'   => 'users.delete',
                'uses' => 'Users\UserController@delete'
            ]
        )->middleware('auth', 'permissions:delete_users');

        // --------------------
        // User Capabilities
        // --------------------
        Route::get('users/capabilities/{user_id?}', 'Users\UserController@userCapabilities')->middleware('auth', 'permissions:user_capabilities');

        Route::post(
            'users/capabilities/save',
            [
                'as'   => 'capabilities.save',
                'uses' => 'Users\UserController@saveUserCapabilities'
            ]
        )->middleware('auth');

        // --------------------
        // User Profile
        // --------------------
        Route::get('users/edit-profile/{user_id?}', 'Users\UserController@editProfile')->middleware('auth', 'permissions:view_dashboard');

        Route::put(
            'users/updateprofile',
            [
                'as'   => 'users.updateprofile',
                'uses' => 'Users\UserController@updateProfile'
            ]
        )->middleware('auth');

        // --------------------
        // Users Group
        // --------------------
        Route::get('users-group', 'Users\UsersGroupController@index')->middleware('auth', 'permissions:view_users_group;add_users_group');

        Route::get('users-group/add', 'Users\UsersGroupController@add')->middleware('auth', 'permissions:add_users_group');

        Route::post(
            'users-group/save',
            [
                'as'   => 'usergroup.save',
                'uses' => 'Users\UsersGroupController@save'
            ]
        )->middleware('auth');

        Route::get('users-group/edit/{user_group_id?}', 'Users\UsersGroupController@edit')->middleware('auth', 'permissions:edit_users_group');

        Route::put(
            'users-group/update',
            [
                'as'   => 'usergroup.update',
                'uses' => 'Users\UsersGroupController@update'
            ]
        )->middleware('auth');

        Route::delete(
            'users-group/delete/{user_group_id}',
            [
                'as'   => 'usergroup.delete',
                'uses' => 'Users\UsersGroupController@delete'
            ]
        )->middleware('auth', 'permissions:delete_users_group');

        // --------------------
        // User Roles & Permissions
        // --------------------
        Route::get('user-role', 'Users\RoleController@index')->middleware('auth', 'permissions:view_roles_permissions;add_roles_permissions');

        Route::get('user-role/add', 'Users\RoleController@add')->middleware('auth', 'permissions:add_roles_permissions');

        Route::post(
            'user-role/save',
            [
                'as'   => 'urole.save',
                'uses' => 'Users\RoleController@save'
            ]
        )->middleware('auth');

        Route::get('user-role/edit/{role_id?}', 'Users\RoleController@edit')->middleware('auth', 'permissions:edit_roles_permissions');

        Route::put(
            'user-role/update',
            [
                'as'   => 'urole.update',
                'uses' => 'Users\RoleController@update'
            ]
        )->middleware('auth');

        Route::delete(
            'user-role/delete/{role_id}',
            [
                'as'   => 'urole.delete',
                'uses' => 'Users\RoleController@delete'
            ]
        )->middleware('auth', 'permissions:delete_roles_permissions');

        // --------------------
        // Common Labels
        // --------------------
        Route::get('common-labels/{current_data_type?}', 'Settings\CommonLabelController@index')->middleware('auth', 'permissions:view_common_labels');

        Route::post(
            'common-labels/save',
            [
                'as'   => 'commonlabels.save',
                'uses' => 'Settings\CommonLabelController@save'
            ]
        )->middleware('auth');

        Route::get('common-labels/edit/{common_label_id?}', 'Settings\CommonLabelController@edit')->middleware('auth', 'permissions:edit_common_labels');

        Route::put(
            'common-labels/update',
            [
                'as'   => 'commonlabels.update',
                'uses' => 'Settings\CommonLabelController@update'
            ]
        )->middleware('auth');

        Route::delete(
            'common-labels/delete/{common_label_id}',
            [
                'as'   => 'commonlabels.delete',
                'uses' => 'Settings\CommonLabelController@delete'
            ]
        )->middleware('auth', 'permissions:delete_common_labels');

        // --------------------
        //  Organizaion Setup
        // --------------------
        Route::get('organization/list', 'Settings\OrganizationController@index')->middleware('auth','permissions:view_organizations;add_organizations');

        Route::get('organization/add', 'Settings\OrganizationController@add')->middleware('auth', 'permissions:add_organizations');

        Route::post(
            'organization/save',
            [
                'as'   => 'organization.save',
                'uses' => 'Settings\OrganizationController@save'
            ]
        )->middleware('auth');

        Route::get('organization/edit/{organization_id?}', 'Settings\OrganizationController@edit')->middleware('auth', 'permissions:edit_organizations');

        Route::put(
            'organization/update',
            [
                'as'   => 'organization.update',
                'uses' => 'Settings\OrganizationController@update'
            ]
        )->middleware('auth');

        Route::delete(
            'organization/delete/{organization_id}',
            [
                'as'   => 'organization.delete',
                'uses' => 'Settings\OrganizationController@delete'
            ]
        )->middleware('auth', 'permissions:delete_organizations');

        Route::delete(
            'organization/delete-upload/{organization_id}/{organization_image_type}',
            [
                'as'   => 'organization.uploads.delete.ajax',
                'uses' => 'Settings\OrganizationController@deleteUploadImage'
            ]
            )->middleware('auth');

        // --------------------
        //  Financial Year
        // --------------------
        Route::get('financial-year/list', 'Settings\FinancialYearController@index')->middleware('auth', 'permissions:view_financial_year;add_financial_year');

        Route::get('financial-year/add', 'Settings\FinancialYearController@add')->middleware('auth', 'permissions:add_financial_year');

        Route::post(
            'financial-year/save',
            [
                'as'   => 'financialyear.save',
                'uses' => 'Settings\FinancialYearController@save'
            ]
        )->middleware('auth');

        Route::get('financial-year/edit/{financial_year_id?}', 'Settings\FinancialYearController@edit')->middleware('auth', 'permissions:edit_financial_year');

        Route::put(
            'financial-year/update',
            [
                'as'   => 'financialyear.update',
                'uses' => 'Settings\FinancialYearController@update'
            ]
        )->middleware('auth');

        Route::delete(
            'financial-year/delete/{financial_year_id}',
            [
                'as'   => 'financialyear.delete',
                'uses' => 'Settings\FinancialYearController@delete'
            ]
        )->middleware('auth', 'permissions:delete_financial_year');

        // Organograme route
        //Route::resource('organograms', 'Settings\OrganogramController');

        Route::get('organograms/list', 'Settings\OrganogramController@index')->middleware('auth', 'permissions:view_organogram');
        //Route::get('organograms/create', 'Settings\OrganogramController@create')->middleware('auth', 'permissions:view_financial_year');
        //Route::get('organograms/view/{id?}', 'Settings\OrganogramController@view')->middleware('auth', 'permissions:view_proposed_schemes');
        Route::post('organograms/store', 'Settings\OrganogramController@store')->middleware('auth', 'permissions:add_organogram');
        Route::get('organograms/{mode}/{id?}', 'Settings\OrganogramController@create')->middleware('auth', 'permissions:add_organogram;edit_organogram',);
        Route::get('organization/organograms/getOrganogramByOrganizationId/{organizationId}', 'Settings\OrganogramController@getOrganogramByOrganizationId')->middleware('auth', 'permissions:add_organogram;edit_organogram',);
        Route::delete(
            'organograms/{id}',
            [
                'as'   => 'organogram.delete',
                'uses' => 'Settings\OrganogramController@delete'
            ]
        )->middleware('auth', 'permissions:delete_organogram');
        Route::put(
            'organograms/update/{id}',
            [
                'as'   => 'organogram.update',
                'uses' => 'Settings\OrganogramController@update'
            ]
        )->middleware('auth', 'permissions:edit_organogram');

        // --------------------
        // Employees
        // --------------------
        Route::prefix('employees')->group(function () {
            Route::get('/list', 'Settings\EmployeeController@index')->middleware('permissions:view_employees;add_employees')->name('employees.list');
            Route::get('/add', 'Settings\EmployeeController@add')->middleware('permissions:add_employees')->name('employees.add');
            Route::post('/save', 'Settings\EmployeeController@save')->middleware('permissions:add_employees')->name('employees.save');
            Route::get('/view/{employee_id?}', 'Settings\EmployeeController@view')->middleware('permissions:view_employees')->name('employees.view');
            Route::get('/edit/{employee_id?}', 'Settings\EmployeeController@edit')->middleware('permissions:edit_employees')->name('employees.edit');
            Route::put('/update', 'Settings\EmployeeController@update')->middleware('permissions:edit_employees')->name('employees.update');
            Route::delete('/delete/{employee_id}', 'Settings\EmployeeController@delete')->middleware('permissions:delete_employees')->name('employees.delete');
        });

        // --------------------
        // Crop Variety
        // --------------------
        Route::prefix('crop-variety')->group(function () {
            Route::get('/list', 'Settings\CropVarietyController@index')->middleware('permissions:view_crop_variety')->name('crop-variety.list');
            Route::get('/add', 'Settings\CropVarietyController@create')->middleware('permissions:add_crop_variety')->name('crop-variety.add');
            Route::post('/save', 'Settings\CropVarietyController@store')->middleware('permissions:add_crop_variety')->name('crop-variety.save');
            Route::get('/view/{id?}', 'Settings\CropVarietyController@show')->middleware('permissions:view_crop_variety')->name('crop-variety.view');
            Route::get('/edit/{id?}', 'Settings\CropVarietyController@edit')->middleware('permissions:edit_crop_variety')->name('crop-variety.edit');
            Route::get('/getUnitByCropItemId/{cropItemId?}', 'Settings\CropVarietyController@getUnitByCropItemId')->middleware('permissions:edit_crop_variety')->name('crop-variety.edit');
            Route::put('/update/{id}', 'Settings\CropVarietyController@update')->middleware('permissions:edit_crop_variety')->name('crop-variety.update');
            Route::delete('/delete/{id}', 'Settings\CropVarietyController@destroy')->middleware('permissions:delete_crop_variety')->name('crop-variety.delete');
        });


        // --------------------
        // Farmers
        // --------------------
        Route::prefix('farmers')->group(function () {
            Route::get('/list', 'Settings\FarmerController@index')->middleware('permissions:view_farmers;add_farmers')->name('farmers.list');
            Route::get('/add', 'Settings\FarmerController@create')->middleware('permissions:add_farmers')->name('farmers.add');
            Route::post('/save', 'Settings\FarmerController@store')->middleware('permissions:add_farmers')->name('farmers.save');
            Route::get('/view/{farmer_id?}', 'Settings\FarmerController@view')->middleware('permissions:view_farmers')->name('farmers.view');
            Route::get('/edit/{farmer_id?}', 'Settings\FarmerController@edit')->middleware('permissions:edit_farmers')->name('farmers.edit');
            Route::get('/farmerInfoBuyId/{farmer_id?}', 'Settings\FarmerController@getFarmerById')->middleware('permissions:edit_farmers')->name('farmers.edit');
            Route::put(
                '/update/{id}',
                [
                    'as'   => 'farmer.update',
                    'uses' => 'Settings\FarmerController@update'
                ]
            )->middleware('auth', 'permissions:edit_farmers');

            Route::delete(
                'delete/{id}',
                [
                    'as'   => 'farmer.delete',
                    'uses' => 'Settings\FarmerController@destroy'
                ]
            )->middleware('auth', 'permissions:delete_farmers');
        });
        Route::post(
            'store-new-farmer-ajax',
            [
                'as'   => 'farmer.add.ajax',
                'uses' => 'Settings\FarmerController@addNewFarmer'
            ]
        )->middleware('auth');

        // Projects route
        Route::get('project/list', 'ProjectController@index')->middleware('auth', 'permissions:view_project');
        Route::get('project/create', 'ProjectController@create')->middleware('auth', 'permissions:add_project');
        Route::get('project/view/{id?}/{mode?}', 'ProjectController@show')->middleware('auth', 'permissions:view_project');
        Route::post('project/store', 'ProjectController@store')->middleware('auth', 'permissions:add_project');
        Route::get('project/edit/{id?}', 'ProjectController@edit')->middleware('auth', 'permissions:edit_project');
        Route::get('project/origin-project/{phaseNo?}', 'ProjectController@getOriginProjectByPhaseNo')->middleware('auth');
        Route::delete(
            'project/{id}',
            [
                'as'   => 'project.delete',
                'uses' => 'ProjectController@destroy'
            ]
        )->middleware('auth', 'permissions:delete_project');
        Route::put(
            'project/update/{id}',
            [
                'as'   => 'project.update',
                'uses' => 'ProjectController@update'
            ]
        )->middleware('auth', 'permissions:edit_project');

        // --------------------
        // Icons
        // --------------------
        Route::get(
            '/icons',
            function () {
                return view('admin.icons');
            }
        )->middleware('auth');

        // --------------------
        // Reports
        // --------------------
        Route::group(
            ['prefix' => 'report'],
            function () {
                Route::group(
                    ['middleware' => ['auth', 'permissions:manage_reports']],
                    function () {
                        // Report : User Activity Log
                        Route::get('user-activity-log', 'Reports\UserActivityLogController@index')->middleware('auth', 'permissions:view_user_activity_log_reports');
                        Route::get('activity-log/getUserByDesignation/{designationId}', 'Reports\UserActivityLogController@getUserByDesignation')->middleware('auth', 'permissions:view_salary_reports');
                        Route::post(
                            '/user-activity-log',
                            [
                                'as'   => 'report.activitylog.preview',
                                'uses' => 'Reports\UserActivityLogController@show'
                            ]
                        );
                        Route::get('inventory/stock', 'Reports\StockReportController@index')->middleware('auth', 'permissions:view_user_activity_log_reports');
                        Route::post(
                            '/stock',
                            [
                                'as'   => 'report.stock.preview',
                                'uses' => 'Reports\StockReportController@show'
                            ]
                        );


                    }
                );
            }
        );

        //-------------
        // Technologies
        //-------------
        Route::prefix('technologies')->group(function () {
            Route::get('/list', 'Settings\TechnologyController@index')->middleware('permissions:view_technology_labels;add_technology_labels')->name('technologies.list');
            Route::get('/add', 'Settings\TechnologyController@add')->middleware('permissions:view_technology_labels;add_technology_labels')->name('technologies.add');
            Route::get('technology/edit/{id?}', 'Settings\TechnologyController@edit')->middleware('auth', 'permissions:edit_technology_labels')->name('technologies.edit');
            Route::post('/save', 'Settings\TechnologyController@save')->middleware('permissions:view_technology_labels;add_technology_labels')->name('technologies.save');
            Route::put(
                'technology/update/{id}',
                [
                'as' => 'technologies.update',
                'uses' => 'Settings\TechnologyController@update'
                ]
                )->middleware('permissions:edit_technology_labels');

            Route::delete(
                'technology/{id}',
                [
                    'as'   => 'technologies.delete',
                    'uses' => 'Settings\TechnologyController@destroy'
                ]
            )->middleware('auth', 'permissions:delete_technology_labels');
        });
    }
);

/*
| --------------------------------------------------------------------------
| FRONT END ROUTES
| --------------------------------------------------------------------------
|
| Routes specific to front end of the app. The order is important.
| It must be stayed below the admin routes.
| --------------------------------------------------------------------------
*/

Route::get('/', 'LanguageController@baseURL');

// Uses for setting up the language.
Route::get('/{lang?}', 'FrontEnd\DashboardController@index');

Route::prefix(Request::segment(1))->middleware('locale')->group(
    function () {
        Route::get('/', 'FrontEnd\DashboardController@index');
    }
);
