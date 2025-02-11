@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_item_receive_from_supplier_info', 'active')

{{-- display page title --}}
@section('page_title', __('Edit Item Receive from Supplier'))
@section('body_class', '')

{{-- display page header --}}
@section('page_header_icon', 'icon-cart')
@section('page_header', __('Edit Item Receive from Supplier'))
@section('sidebar')
    @include('layouts.admin-sidebar-inventory')
@endsection
{{-- submit button label --}}
@section('form_submit_btn', __('Update'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        action('Inventory\ItemReceiveFromSupplierInformationController@index') => __('Item Receive from Supplier'),
        action('Inventory\ItemReceiveFromSupplierInformationController@edit')  => __('Edit')
    ];
@endphp

@section('breadcrumb_right')

    @if( hasUserCap('view_item_receive_from_supplier_information'))
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Inventory\ItemReceiveFromSupplierInformationController@index') }}">
            <i class="icon-list-unordered"></i> {{ __('List') }}
        </a>
    @endif

    @if( hasUserCap('add_item_receive_from_supplier_information'))
        <a href="{{ action('Inventory\ItemReceiveFromSupplierInformationController@create') }}" class="btn btn-sm btn-primary">
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
        {!! Form::model($item_receive_from_supplier_information, ['route' => ['item-receive-from-supplier-information.update', $item_receive_from_supplier_information->id],'method'=>'put', 'files' => true, 'class' => 'needs-validation', 'novalidate']) !!}

            @include ('inventory.item-receive-from-supplier-information.form')

        {!! Form::close() !!}
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
    <script src="{{ asset('js/libs/datepicker.min.js') }}"></script>
@endpush
