@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_monitoring_settings', 'active')
@section('admin_menu_settings_crop_variety', 'active')

{{-- display page title --}}
@section('page_title', __('Add CropVariety'))
@section('body_class', '')

{{-- display page header --}}
@section('page_header_icon', 'icon-cog')
@section('page_header', __('Add CropVariety'))

@section('@section('sidebar')
    @include('layouts.admin-sidebar-monitoring')
@endsection', 'active')

{{-- submit button label --}}
@section('form_submit_btn', __('Save'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
    action('Settings\CropVarietyController@index') => __('CropVariety'),
    action('Settings\CropVarietyController@create')  => __('Add New')
];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap(['view_crop_variety']))
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Settings\CropVarietyController@index') }}">
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
    {!! Form::open(['action' => ['Settings\CropVarietyController@store'], 'files' => true, 'class' => 'needs-validation', 'novalidate']) !!}

        @include ('settings.crop-variety.form')

    {!! Form::close() !!}
    </div>
</div>
@endsection

{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
    <script src="{{ asset('js/libs/datepicker.min.js') }}"></script>
@endpush
