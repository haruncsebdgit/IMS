
@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_locations', 'active')
@section('admin_menu_settings_division', 'active')

{{-- display page title --}}
@section('page_title', __('Edit Division'))
@section('body_class', 'division edit')

{{-- display page header --}}
@section('page_header_icon', 'icon-location4')
@section('page_header', __('Edit Division') )

{{-- submit button label --}}
@section('form_submit_btn', __('Update'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
    '#' => __('Settings'),
    'javascript:' => __('Locations'),
    action('Settings\DivisionController@index') => __('Divisions'),
    action('Settings\DivisionController@edit') => __('Edit')
];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap(['view_divisions','edit_divisions','delete_divisions']) )
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\DivisionController@index') }}">
            <i class="icon-list mr-1" aria-hidden="true"></i> {{  __('List') }}
        </a>
    @endif

    @if( hasUserCap('add_divisions') )
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\DivisionController@add') }}">
            <i class="icon-add mr-1" aria-hidden="true"></i> {{  __('Add') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

    @include('errors.validation')

    <form action="{{ route('division.update') }}" method="POST" class="needs-validation" novalidate>

        @include('settings/division/form')

        <input type="hidden" name="id" value="{{ $division->id }}">
        @method('PUT')

    </form>

@endsection
