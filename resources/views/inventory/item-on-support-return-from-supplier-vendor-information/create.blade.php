@extends('layouts.admin')

@section('admin_menu_item_on_support_return_from_supplier_vendor_info', 'active')

{{-- display page title --}}
@section('page_title', __('Add Item On-Support or Return from Supplier/Vendor Information'))
@section('body_class', '')

{{-- display page header --}}
@section('page_header_icon', 'icon-pie-chart5')
@section('page_header', __('Add Item On-Support or Return from Supplier/Vendor Information'))
@section('sidebar')
    @include('layouts.admin-sidebar-inventory')
@endsection
{{-- submit button label --}}
@section('form_submit_btn', __('Save'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
    action('Inventory\ItemOnSupportReturnFromSupplierVendorInformationController@index') => __('Item On-Support or Return from Supplier/Vendor Information'),
    action('Inventory\ItemOnSupportReturnFromSupplierVendorInformationController@create')  => __('Add New')
];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap(['view_item_on_support_return_from_supplier_vendor_information']))
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Inventory\ItemOnSupportReturnFromSupplierVendorInformationController@index') }}">
            <i class="icon-list-unordered"></i> {{ __('List') }}
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
    {!! Form::open(['action' => ['Inventory\ItemOnSupportReturnFromSupplierVendorInformationController@store'], 'files' => true, 'class' => 'needs-validation', 'novalidate']) !!}
        
        @include ('inventory.item-on-support-return-from-supplier-vendor-information.form')

    {!! Form::close() !!}
    </div>
</div>
@endsection

{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
    <script src="{{ asset('js/libs/datepicker.min.js') }}"></script>
@endpush
