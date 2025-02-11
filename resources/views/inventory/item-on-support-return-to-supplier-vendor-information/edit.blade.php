@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_item_on_support_return_to_supplier_vendor_info', 'active')

{{-- display page title --}}
@section('page_title', __('Edit Item On-Support or Return to Supplier/Vendor Information'))
@section('body_class', '')

{{-- display page header --}}
@section('page_header_icon', 'icon-vimeo2')
@section('page_header', __('Edit Item On-Support or Return to Supplier/Vendor Information'))
@section('sidebar')
    @include('layouts.admin-sidebar-inventory')
@endsection
{{-- submit button label --}}
@section('form_submit_btn', __('Update'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        action('Inventory\ItemOnSupportReturnToSupplierVendorInformationController@index') => __('Item On-Support or Return to Supplier/Vendor Information'),
        action('Inventory\ItemOnSupportReturnToSupplierVendorInformationController@edit')  => __('Edit')
    ];
@endphp

@section('breadcrumb_right')

    @if( hasUserCap('view_item_on_support_return_to_supplier_vendor_information'))
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Inventory\ItemOnSupportReturnToSupplierVendorInformationController@index') }}">
            <i class="icon-list-unordered"></i> {{ __('List') }}
        </a>
    @endif

    @if( hasUserCap('add_item_on_support_return_to_supplier_vendor_information'))
        <a href="{{ action('Inventory\ItemOnSupportReturnToSupplierVendorInformationController@create') }}" class="btn btn-sm btn-primary">
            <i class="icon-plus3 mr-1" aria-hidden="true"></i> {{ __('Add') }}
        </a>
    @endif
@endsection

{{-- add necessary styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/datepicker.min.css') }}">
@endpush

{{-- page content --}}
@section('content')
<div class="alert alert-info alert-styled-left">
    {{ __('All fields marked with an asterisk (*) are required.') }}
</div>
    <div class="card">
        <div class="card-body">
        {!! Form::model($item_on_support_return_to_supplier_vendor_information, ['route' => ['item-on-support-return-to-supplier-vendor-information.update', $item_on_support_return_to_supplier_vendor_information->id],'method'=>'put', 'files' => true, 'class' => 'needs-validation', 'novalidate']) !!}

            @include ('inventory.item-on-support-return-to-supplier-vendor-information.form')

        {!! Form::close() !!}
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
    <script src="{{ asset('js/libs/datepicker.min.js') }}"></script>
@endpush
