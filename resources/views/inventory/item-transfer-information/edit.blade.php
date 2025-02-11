@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_item_transfer_info', 'active')

{{-- display page title --}}
@section('page_title', __('Edit Item Transfer Information'))
@section('body_class', '')

{{-- display page header --}}
@section('page_header_icon', 'icon-transmission')
@section('page_header', __('Edit Item Transfer Information'))
@section('sidebar')
    @include('layouts.admin-sidebar-inventory')
@endsection
{{-- submit button label --}}
@section('form_submit_btn', __('Update'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        action('Inventory\ItemTransferInformationController@index') => __('Item Transfer Information'),
        action('Inventory\ItemTransferInformationController@edit')  => __('Edit')
    ];
@endphp

@section('breadcrumb_right')

    @if( hasUserCap('view_item_transfer_information'))
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Inventory\ItemTransferInformationController@index') }}">
            <i class="icon-list-unordered"></i> {{ __('List') }}
        </a>
    @endif

    @if( hasUserCap('add_item_transfer_information'))
        <a href="{{ action('Inventory\ItemTransferInformationController@create') }}" class="btn btn-sm btn-primary">
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
        {!! Form::model($item_transfer_information, ['route' => ['item-transfer-information.update', $item_transfer_information->id],'method'=>'put', 'files' => true, 'class' => 'needs-validation', 'novalidate']) !!}

            @include ('inventory.item-transfer-information.form')

        {!! Form::close() !!}
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
    <script src="{{ asset('js/libs/datepicker.min.js') }}"></script>
@endpush
