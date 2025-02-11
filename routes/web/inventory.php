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

Route::prefix(Request::segment(1) . config('app.admin_route_prefix') . '/inventory')->middleware(['auth', 'locale'])->namespace('Inventory')->group(
    function () {

        // Item Category Sub-Category Information
        Route::get('item-category-sub-category-information/list', 'ItemCategorySubCategoryInformationController@index')->middleware('permissions:view_item_category_sub_category_info');
        Route::get('item-category-sub-category-information/create', 'ItemCategorySubCategoryInformationController@create')->middleware('permissions:add_item_category_sub_category_info');
        Route::get('item-category-sub-category-information/view/{id?}', 'ItemCategorySubCategoryInformationController@show')->middleware('permissions:view_item_category_sub_category_info');
        Route::post('item-category-sub-category-information/store', 'ItemCategorySubCategoryInformationController@store')->middleware('permissions:add_item_category_sub_category_info');
        Route::get('item-category-sub-category-information/edit/{id?}', 'ItemCategorySubCategoryInformationController@edit')->middleware('permissions:edit_item_category_sub_category_info');
        Route::delete(
            'item-category-sub-category-information/{id}',
            [
                'as'   => 'item-category-sub-category-information.delete',
                'uses' => 'ItemCategorySubCategoryInformationController@destroy'
            ]
        )->middleware('permissions:delete_item_category_sub_category_info');
        Route::put(
            'item-category-sub-category-information/update/{id}',
            [
                'as'   => 'item-category-sub-category-information.update',
                'uses' => 'ItemCategorySubCategoryInformationController@update'
            ]
        )->middleware('permissions:edit_item_category_sub_category_info');

        // Item Information
        Route::get('item-information/list', 'ItemInformationController@index')->middleware('permissions:view_item_info');
        Route::get('item-information/create', 'ItemInformationController@create')->middleware('permissions:add_item_info');
        Route::get('item-information/view/{id?}', 'ItemInformationController@show')->middleware('permissions:view_item_info');
        Route::post('item-information/store', 'ItemInformationController@store')->middleware('permissions:add_item_info');
        Route::get('item-information/edit/{id?}', 'ItemInformationController@edit')->middleware('permissions:edit_item_info');
        Route::delete(
            'item-information/{id}',
            [
                'as'   => 'item-information.delete',
                'uses' => 'ItemInformationController@destroy'
            ]
        )->middleware('permissions:delete_item_info');
        Route::put(
            'item-information/update/{id}',
            [
                'as'   => 'item-information.update',
                'uses' => 'ItemInformationController@update'
            ]
        )->middleware('permissions:edit_item_info');

        // Item Receive from Supplier Information
        Route::get('item-receive-from-supplier-information/list', 'ItemReceiveFromSupplierInformationController@index')->middleware('permissions:view_item_receive_from_supplier_information');
        Route::get('item-receive-from-supplier-information/create', 'ItemReceiveFromSupplierInformationController@create')->middleware('permissions:add_item_receive_from_supplier_information');
        Route::get('item-receive-from-supplier-information/view/{id?}', 'ItemReceiveFromSupplierInformationController@show')->middleware('permissions:view_item_receive_from_supplier_information');
        Route::post('item-receive-from-supplier-information/store', 'ItemReceiveFromSupplierInformationController@store')->middleware('permissions:add_item_receive_from_supplier_information');
        Route::get('item-receive-from-supplier-information/edit/{id?}', 'ItemReceiveFromSupplierInformationController@edit')->middleware('permissions:edit_item_receive_from_supplier_information');
        Route::delete(
            'item-receive-from-supplier-information/{id}',
            [
                'as'   => 'item-receive-from-supplier-information.delete',
                'uses' => 'ItemReceiveFromSupplierInformationController@destroy'
            ]
        )->middleware('permissions:delete_item_receive_from_supplier_information');
        Route::put(
            'item-receive-from-supplier-information/update/{id}',
            [
                'as'   => 'item-receive-from-supplier-information.update',
                'uses' => 'ItemReceiveFromSupplierInformationController@update'
            ]
        )->middleware('permissions:edit_item_receive_from_supplier_information');

        // Allocate item
        Route::get('item-allocation/list', 'ItemAllocationController@index')->middleware('permissions:view_item_request_information');
        Route::get('item-allocation/create', 'ItemAllocationController@create')->middleware('permissions:add_item_request_information');
        Route::get('item-allocation/view/{id?}', 'ItemAllocationController@show')->middleware('permissions:view_item_request_information');
        Route::post('item-allocation/store', 'ItemAllocationController@store')->middleware('permissions:add_item_request_information');
        Route::get('item-allocation/edit/{id?}', 'ItemAllocationController@edit')->middleware('permissions:edit_item_request_information');
        Route::get('item-allocation/getItemQtyByItemId/{itemId?}', 'ItemAllocationController@getItemQtyByItemId')->middleware('permissions:edit_item_request_information');

        Route::delete(
            'item-allocation/{id}',
            [
                'as'   => 'item-allocation.delete',
                'uses' => 'ItemAllocationController@destroy'
            ]
        )->middleware('permissions:delete_item_request_information');
        Route::put(
            'item-allocation/update/{id}',
            [
                'as'   => 'item-allocation.update',
                'uses' => 'ItemAllocationController@update'
            ]
        )->middleware('permissions:edit_item_request_information');
        Route::put(
            'item-allocation/approve/{id}',
            [
                'as'   => 'item-allocation.approve',
                'uses' => 'ItemAllocationController@approve'
            ]
        );

        // Request item
        Route::get('request-item/list', 'RequestItemController@index')->middleware('permissions:view_item_request_information');
        Route::get('request-item/create', 'RequestItemController@create')->middleware('permissions:add_item_request_information');
        Route::get('request-item/view/{id?}', 'RequestItemController@show')->middleware('permissions:view_item_request_information');
        Route::get('request-item/approved/{id?}', 'RequestItemController@approveItem')->middleware('permissions:approve_item_request_information');
        Route::get('request-item/createReceive/{id?}', 'RequestItemController@createReceive')->middleware('permissions:view_item_request_information');
        Route::post('request-item/store', 'RequestItemController@store')->middleware('permissions:add_item_request_information');
        Route::get('request-item/edit/{id?}', 'RequestItemController@edit')->middleware('permissions:edit_item_request_information');
        Route::get('getItemByCategory/{categoryId?}', 'RequestItemController@getItemByCategory')->middleware('permissions:edit_item_request_information');
        Route::delete(
            'request-item/{id}',
            [
                'as'   => 'item-request.delete',
                'uses' => 'RequestItemController@destroy'
            ]
        )->middleware('permissions:delete_item_request_information');
        Route::put(
            'request-item/update/{id}',
            [
                'as'   => 'request-item.update',
                'uses' => 'RequestItemController@update'
            ]
        )->middleware('permissions:edit_item_request_information');
        Route::put(
            'request-item/approve/{id}',
            [
                'as'   => 'request-item.approve',
                'uses' => 'RequestItemController@approve'
            ]
        );
        //->middleware('permissions:approve_item_request_information');

        // Return item
        Route::get('return-item/list', 'ReturnItemController@index')->middleware('permissions:view_item_request_information');
        Route::get('return-item/create', 'ReturnItemController@create')->middleware('permissions:add_item_request_information');
        Route::get('return-item/view/{id?}', 'ReturnItemController@show')->middleware('permissions:view_item_request_information');
        //Route::get('request-item/approved/{id?}', 'ReturnItemController@approveItem')->middleware('permissions:approve_item_request_information');
        //Route::get('request-item/createReceive/{id?}', 'ReturnItemController@createReceive')->middleware('permissions:view_item_request_information');
        Route::post('return-item/store', 'ReturnItemController@store')->middleware('permissions:add_item_request_information');
        Route::get('return-item/edit/{id?}', 'ReturnItemController@edit')->middleware('permissions:edit_item_request_information');
        //Route::get('getItemByCategory/{categoryId?}', 'ReturnItemController@getItemByCategory')->middleware('permissions:edit_item_request_information');
        Route::delete(
            'return-item/{id}',
            [
                'as'   => 'item-return.delete',
                'uses' => 'ReturnItemController@destroy'
            ]
        )->middleware('permissions:delete_item_request_information');
        Route::put(
            'return-item/update/{id}',
            [
                'as'   => 'return-item.update',
                'uses' => 'ReturnItemController@update'
            ]
        )->middleware('permissions:edit_item_request_information');

        // Item Transfer Information
        Route::get('item-transfer-information/list', 'ItemTransferInformationController@index')->middleware('permissions:view_item_transfer_information');
        Route::get('item-transfer-information/create', 'ItemTransferInformationController@create')->middleware('permissions:add_item_transfer_information');
        Route::get('item-transfer-information/view/{id?}', 'ItemTransferInformationController@show')->middleware('permissions:view_item_transfer_information');
        Route::post('item-transfer-information/store', 'ItemTransferInformationController@store')->middleware('permissions:add_item_transfer_information');
        Route::get('item-transfer-information/edit/{id?}', 'ItemTransferInformationController@edit')->middleware('permissions:edit_item_transfer_information');
        Route::delete(
            'item-transfer-information/{id}',
            [
                'as'   => 'item-transfer-information.delete',
                'uses' => 'ItemTransferInformationController@destroy'
            ]
        )->middleware('permissions:delete_item_transfer_information');
        Route::put(
            'item-transfer-information/update/{id}',
            [
                'as'   => 'item-transfer-information.update',
                'uses' => 'ItemTransferInformationController@update'
            ]
        )->middleware('permissions:edit_item_transfer_information');

        // Item Transfer Receive Information
        Route::get('item-transfer-receive-information/list', 'ItemTransferReceiveInformationController@index')->middleware('permissions:view_item_transfer_receive_information');
        Route::get('item-transfer-receive-information/create', 'ItemTransferReceiveInformationController@create')->middleware('permissions:add_item_transfer_receive_information');
        Route::get('item-transfer-receive-information/view/{id?}', 'ItemTransferReceiveInformationController@show')->middleware('permissions:view_item_transfer_receive_information');
        Route::post('item-transfer-receive-information/store', 'ItemTransferReceiveInformationController@store')->middleware('permissions:add_item_transfer_receive_information');
        Route::get('item-transfer-receive-information/edit/{id?}', 'ItemTransferReceiveInformationController@edit')->middleware('permissions:edit_item_transfer_receive_information');
        Route::delete(
            'item-transfer-receive-information/{id}',
            [
                'as'   => 'item-transfer-receive-information.delete',
                'uses' => 'ItemTransferReceiveInformationController@destroy'
            ]
        )->middleware('permissions:delete_item_transfer_receive_information');
        Route::put(
            'item-transfer-receive-information/update/{id}',
            [
                'as'   => 'item-transfer-receive-information.update',
                'uses' => 'ItemTransferReceiveInformationController@update'
            ]
        )->middleware('permissions:edit_item_transfer_receive_information');

        // Item On-Support or Return to Supplier/Vendor Information
        Route::get('item-on-support-return-to-supplier-vendor-information/list', 'ItemOnSupportReturnToSupplierVendorInformationController@index')->middleware('permissions:view_item_on_support_return_to_supplier_vendor_information');
        Route::get('item-on-support-return-to-supplier-vendor-information/create', 'ItemOnSupportReturnToSupplierVendorInformationController@create')->middleware('permissions:add_item_on_support_return_to_supplier_vendor_information');
        Route::get('item-on-support-return-to-supplier-vendor-information/view/{id?}', 'ItemOnSupportReturnToSupplierVendorInformationController@show')->middleware('permissions:view_item_on_support_return_to_supplier_vendor_information');
        Route::post('item-on-support-return-to-supplier-vendor-information/store', 'ItemOnSupportReturnToSupplierVendorInformationController@store')->middleware('permissions:add_item_on_support_return_to_supplier_vendor_information');
        Route::get('item-on-support-return-to-supplier-vendor-information/edit/{id?}', 'ItemOnSupportReturnToSupplierVendorInformationController@edit')->middleware('permissions:edit_item_on_support_return_to_supplier_vendor_information');
        Route::delete(
            'item-on-support-return-to-supplier-vendor-information/{id}',
            [
                'as'   => 'item-on-support-return-to-supplier-vendor-information.delete',
                'uses' => 'ItemOnSupportReturnToSupplierVendorInformationController@destroy'
            ]
        )->middleware('permissions:delete_item_on_support_return_to_supplier_vendor_information');
        Route::put(
            'item-on-support-return-to-supplier-vendor-information/update/{id}',
            [
                'as'   => 'item-on-support-return-to-supplier-vendor-information.update',
                'uses' => 'ItemOnSupportReturnToSupplierVendorInformationController@update'
            ]
        )->middleware('permissions:edit_item_on_support_return_to_supplier_vendor_information');

        // Item Return to Supplier, Under Maintenance (On-Support) or Status Change Information
        Route::get('item-return-on-support/list', 'ItemReturnOnSupportController@index')->middleware('permissions:view_item_return_on_support_info');
        Route::get('item-return-on-support/create', 'ItemReturnOnSupportController@create')->middleware('permissions:add_item_return_on_support_info');
        Route::get('item-return-on-support/view/{id?}', 'ItemReturnOnSupportController@show')->middleware('permissions:view_item_return_on_support_info');
        Route::post('item-return-on-support/store', 'ItemReturnOnSupportController@store')->middleware('permissions:add_item_return_on_support_info');
        Route::get('item-return-on-support/edit/{id?}', 'ItemReturnOnSupportController@edit')->middleware('permissions:edit_item_return_on_support_info');
        Route::delete(
            'item-return-on-support/{id}',
            [
                'as'   => 'item-return-on-support.delete',
                'uses' => 'ItemReturnOnSupportController@destroy'
            ]
        )->middleware('permissions:delete_item_return_on_support_info');
        Route::put(
            'item-return-on-support/update/{id}',
            [
                'as'   => 'item-return-on-support.update',
                'uses' => 'ItemReturnOnSupportController@update'
            ]
        )->middleware('permissions:edit_item_return_on_support_info');

        // Item On-Support or Return from Supplier/Vendor Information
        Route::get('item-on-support-return-from-supplier-vendor-information/list', 'ItemOnSupportReturnFromSupplierVendorInformationController@index')->middleware('permissions:view_item_on_support_return_from_supplier_vendor_information');
        Route::get('item-on-support-return-from-supplier-vendor-information/create', 'ItemOnSupportReturnFromSupplierVendorInformationController@create')->middleware('permissions:add_item_on_support_return_from_supplier_vendor_information');
        Route::get('item-on-support-return-from-supplier-vendor-information/view/{id?}', 'ItemOnSupportReturnFromSupplierVendorInformationController@show')->middleware('permissions:view_item_on_support_return_from_supplier_vendor_information');
        Route::post('item-on-support-return-from-supplier-vendor-information/store', 'ItemOnSupportReturnFromSupplierVendorInformationController@store')->middleware('permissions:add_item_on_support_return_from_supplier_vendor_information');
        Route::get('item-on-support-return-from-supplier-vendor-information/edit/{id?}', 'ItemOnSupportReturnFromSupplierVendorInformationController@edit')->middleware('permissions:edit_item_on_support_return_from_supplier_vendor_information');
        Route::delete(
            'item-on-support-return-from-supplier-vendor-information/{id}',
            [
                'as'   => 'item-on-support-return-from-supplier-vendor-information.delete',
                'uses' => 'ItemOnSupportReturnFromSupplierVendorInformationController@destroy'
            ]
        )->middleware('permissions:delete_item_on_support_return_from_supplier_vendor_information');
        Route::put(
            'item-on-support-return-from-supplier-vendor-information/update/{id}',
            [
                'as'   => 'item-on-support-return-from-supplier-vendor-information.update',
                'uses' => 'ItemOnSupportReturnFromSupplierVendorInformationController@update'
            ]
        )->middleware('permissions:edit_item_on_support_return_from_supplier_vendor_information');

        // Supplier Information
        Route::get('supplier-information/list', 'SupplierController@index')->middleware('permissions:view_supplier_info');
        Route::get('supplier-information/create', 'SupplierController@create')->middleware('permissions:add_supplier_info');
        Route::get('supplier-information/view/{id?}', 'SupplierController@show')->middleware('permissions:view_supplier_info');
        Route::post('supplier-information/store', 'SupplierController@store')->middleware('permissions:add_supplier_info');
        Route::get('supplier-information/edit/{id?}', 'SupplierController@edit')->middleware('permissions:edit_supplier_info');
        Route::delete(
            'supplier-information/{id}',
            [
                'as'   => 'supplier-information.delete',
                'uses' => 'SupplierController@destroy'
            ]
        )->middleware('permissions:delete_supplier_info');
        Route::put(
            'supplier-information/update/{id}',
            [
                'as'   => 'supplier-information.update',
                'uses' => 'SupplierController@update'
            ]
        )->middleware('permissions:edit_supplier_info');

        // --------------------
        // Reports
        // --------------------
        Route::group(
            ['prefix' => 'report'],
            function () {
                Route::group(
                    ['middleware' => ['auth', 'permissions:manage_reports']],
                    function () {
                        // Report: Test



                    }
                );
            }
        );
    }
);
