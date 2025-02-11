@extends('layouts.admin')

@section('admin_menu_item_return_on_support_info', 'active')

{{-- display page title --}}
@section('page_title', __('Add Item Return On Support Information'))
@section('body_class', '')

{{-- display page header --}}
@section('page_header_icon', 'icon-vimeo2')
@section('page_header', __('Add Item Return On Support Information'))
@section('sidebar')
    @include('layouts.admin-sidebar-inventory')
@endsection
{{-- submit button label --}}
@section('form_submit_btn', __('Save'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
    action('Inventory\ItemReturnOnSupportController@index') => __('Item Return On Support Information'),
    action('Inventory\ItemReturnOnSupportController@create')  => __('Add New')
];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap(['view_item_return_on_support_info']))
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Inventory\ItemReturnOnSupportController@index') }}">
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
    {!! Form::open(['action' => ['Inventory\ItemReturnOnSupportController@store'], 'files' => true, 'class' => 'needs-validation', 'novalidate']) !!}
        
        @include ('inventory.item-return-on-support.form')

    {!! Form::close() !!}
    </div>
</div>
@endsection

{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
    <script src="{{ asset('js/libs/datepicker.min.js') }}"></script>
@endpush
