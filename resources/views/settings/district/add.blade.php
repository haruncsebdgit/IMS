
@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_locations', 'active')
@section('admin_menu_settings_district', 'active')

{{-- display page title --}}
@section('page_title', __('Add District'))
@section('body_class', 'district add')

{{-- display page header --}}
@section('page_header_icon', 'icon-location4')
@section('page_header', __('Add District') )

{{-- submit button label --}}
@section('form_submit_btn', __('Save'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
    '#' => __('Settings'),
    'javascript:' => __('Locations'),
    action('Settings\DistrictController@index') => __('Districts'),
    action('Settings\DistrictController@add')   => __('Add')
];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap(['view_districts','edit_districts','delete_districts']) )
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\DistrictController@index') }}">
            <i class="icon-list mr-1"></i> {{  __('List') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

    @include('errors.validation')

    <form action="{{ route('district.save') }}" method="POST" class="needs-validation" novalidate>

        @include('settings/district/form')

    </form>

@endsection
