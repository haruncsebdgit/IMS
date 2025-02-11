@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_monitoring_settings', 'active')
@section('admin_menu_settings_farmers', 'active')

{{-- display page title --}}
@section('page_title', __('Edit Farmer Information'))
@section('body_class', '')

{{-- display page header --}}
@section('page_header_icon', 'icon-vcard')
@section('page_header', __('Edit Farmer Information'))


@section('sidebar')
@include('layouts.admin-sidebar-monitoring')
@endsection

{{-- submit button label --}}
@section('form_submit_btn', __('Save'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
action('Settings\FarmerController@index') => __('Farmer Information'),
action('Settings\FarmerController@create') => __('Edit')
];
@endphp

@section('breadcrumb_right')
@if( hasUserCap(['view_demonstration_info']))
<a class="btn btn-sm btn-outline-primary" href="{{ action('Settings\FarmerController@index') }}">
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

        {!! Form::model($farmerInfo, ['route' => ['farmer.update', $farmerInfo->id],'method'=>'put', 'files' => true, 'class' => 'needs-validation', 'novalidate']) !!}

          @include('settings.farmer.form')

        {!! Form::close() !!}

    </div>
</div>



@endsection

{{-- add necessary scripts --}}
@push('scripts')\
<script src="{{ asset('js/libs/jquery.repeater.js') }}"></script>
<script src="{{ asset('js/libs/select2.min.js') }}"></script>
<script src="{{ asset('js/libs/datepicker.min.js') }}"></script>

@endpush
