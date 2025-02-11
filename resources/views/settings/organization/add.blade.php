@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section("admin_menu_settings", 'active')
@section("admin_menu_settings_organization", 'active')


{{-- display page title --}}
@section('page_title', __('Add Organization'))
@section('body_class', "organization add")

{{-- display page header --}}
@section('page_header_icon', "icon-office")
@section('page_header', __('Add Organization Information'))

{{-- submit button label --}}
@section('organization_form_submit_btn', __('Save'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#'                                              => __('Settings'),
        action('Settings\OrganizationController@index') => __('Organization'),
        action('Settings\OrganizationController@add')   => __('Add')
    ];
@endphp

@section('breadcrumb_right')
    @if(hasUserCap(['view_organizations','add_organizations']))
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Settings\OrganizationController@index') }}">
            <i class="icon-list-unordered mr-1" aria-hidden="true"></i>
            {{ __('List of Organization') }}
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

    <form action="{{ route('organization.save') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">

        @include('settings.organization.form')

        <input type="hidden" name="id" value="">

    </form>

@endsection

{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
@endpush
