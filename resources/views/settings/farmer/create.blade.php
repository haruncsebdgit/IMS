@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_monitoring_settings', 'active')
@section('admin_menu_settings_farmers', 'active')

{{-- display page title --}}
@section('page_title', __('Add Farmer Information'))
@section('body_class', 'farmer add')

{{-- display page header --}}
@section('page_header_icon', 'icon-vcard')
@section('page_header', __('Add Farmer Information'))

@section('sidebar')
@include('layouts.admin-sidebar-monitoring')
@endsection

{{-- submit button label --}}
@section('form_submit_btn', __('Save'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
        'javascript:' => __('Settings'),
         action('Settings\FarmerController@index') => __('Farmers'),
         action('Settings\FarmerController@create') => __('Add')
];
@endphp

@section('breadcrumb_right')
@if(hasUserCap(['view_farmers','edit_farmers','delete_farmers']))
<a class="btn btn-sm btn-primary" href="{{ action('Settings\FarmerController@index') }}">
    <i class="icon-list mr-1" aria-hidden="true"></i>
    {{ __('List') }}
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

@include('errors.validation')


{!! Form::open(['action' => ['Settings\FarmerController@store'], 'files' => true, 'class' => 'needs-validation', 'novalidate']) !!}

@include('settings.farmer.form')

{!! Form::close() !!}

@endsection

{{-- add necessary scripts --}}
@push('scripts')
<script src="{{ asset('js/libs/select2.min.js') }}"></script>
<script src="{{ asset('js/libs/datepicker.min.js') }}"></script>
@endpush
