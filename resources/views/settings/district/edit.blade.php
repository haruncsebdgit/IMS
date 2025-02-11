
@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_locations', 'active')
@section('admin_menu_settings_district', 'active')

{{-- display page title --}}
@section('page_title', __('Edit District'))
@section('body_class', 'district edit')

{{-- display page header --}}
@section('page_header_icon', 'icon-location4')
@section('page_header', __('Edit District') )

{{-- submit button label --}}
@section('form_submit_btn', __('Update'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
    '#' => __('Settings'),
    'javascript:' => __('Locations'),
    action('Settings\DistrictController@index') => __('Divisions'),
    action('Settings\DistrictController@edit') => __('Edit')
];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap(['view_districts','edit_districts','delete_districts']) )
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\DistrictController@index') }}">
            <i class="icon-list mr-1" aria-hidden="true"></i> {{  __('List') }}
        </a>
    @endif

    @if( hasUserCap('add_districts') )
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\DistrictController@add') }}">
            <i class="icon-add mr-1" aria-hidden="true"></i> {{  __('Add') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

    @include('errors.validation')

    <form action="{{ route('district.update') }}" method="POST" class="needs-validation" novalidate>

        @include('settings/district/form')

        <input type="hidden" name="id" value="{{ $district->id }}">
        @method('PUT')

    </form>

@endsection
