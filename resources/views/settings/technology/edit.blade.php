
@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_monitoring_settings', 'active')
@section('admin_menu_settings_technology_labels', 'active')

{{-- display page title --}}
@section('page_title', __('Add Technology'))
@section('body_class', 'thana-upazila add')

{{-- display page header --}}
@section('page_header_icon', 'icon-headset')
@section('page_header', __('Add Technology') )


@section('sidebar')
@include('layouts.admin-sidebar-monitoring')
@endsection

{{-- submit button label --}}
@section('form_submit_btn', __('Save'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
    '#' => __('Settings'),
    action('Settings\TechnologyController@index') => __('Technology'),
    action('Settings\TechnologyController@add')   => __('Add')
];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap(['view_technology_labels']) )
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Settings\TechnologyController@index') }}">
            <i class="icon-list mr-1"></i> {{  __('List') }}
        </a>
    @endif
@endsection

{{-- add necessary styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/select2.min.css') }}">
@endpush

{{-- page content --}}
@section('content')

    @include('errors.validation')

    {!! Form::model($technologyInfo, ['route' => ['technologies.update', $technologyInfo->id],'method'=>'put', 'files' => true, 'class' => 'needs-validation', 'novalidate']) !!}

    @include ('settings.technology.form')

    {!! Form::close() !!}


@endsection


{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
@endpush
