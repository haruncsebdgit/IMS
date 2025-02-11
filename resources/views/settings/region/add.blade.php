@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_locations', 'active')
@section('admin_menu_settings_region', 'active')

{{-- display page title --}}
@section('page_title', __('Add Region'))
@section('body_class', 'division add')

{{-- display page header --}}
@section('page_header_icon', 'icon-location4')
@section('page_header', __('Add Region') )

{{-- submit button label --}}
@section('form_submit_btn', __('Save'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
    '#' => __('Settings'),
    'javascript:' => __('Locations'),
    action('Settings\RegionController@index') => __('Regions'),
    action('Settings\RegionController@add')   => __('Add')
];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap(['view_regions','edit_regions','delete_regions']) )
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\RegionController@index') }}">
            <i class="icon-list mr-1"></i> {{  __('List') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

    @include('errors.validation')

    <form action="{{ route('region.save') }}" method="POST" class="needs-validation" novalidate>

        @include('settings/region/form')

    </form>

@endsection
