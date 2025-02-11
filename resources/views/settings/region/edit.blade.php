
@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_locations', 'active')
@section('admin_menu_settings_region', 'active')

{{-- display page title --}}
@section('page_title', __('Edit Region'))
@section('body_class', 'region edit')

{{-- display page header --}}
@section('page_header_icon', 'icon-location4')
@section('page_header', __('Edit Region') )

{{-- submit button label --}}
@section('form_submit_btn', __('Update'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
    '#' => __('Settings'),
    'javascript:' => __('Locations'),
    action('Settings\RegionController@index') => __('Regions'),
    action('Settings\RegionController@edit') => __('Edit')
];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap(['view_regions','edit_regions','delete_regions']) )
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\RegionController@index') }}">
            <i class="icon-list mr-1" aria-hidden="true"></i> {{  __('List') }}
        </a>
    @endif

    @if( hasUserCap('add_divisions') )
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\RegionController@add') }}">
            <i class="icon-add mr-1" aria-hidden="true"></i> {{  __('Add') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

    @include('errors.validation')

    <form action="{{ route('region.update') }}" method="POST" class="needs-validation" novalidate>

        @include('settings/region/form')

        <input type="hidden" name="id" value="{{ $regions->id }}">
        @method('PUT')

    </form>

@endsection
