
@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_locations', 'active')
@section('admin_menu_settings_thana_upazila', 'active')

{{-- display page title --}}
@section('page_title', __('Add Upazila'))
@section('body_class', 'thana-upazila add')

{{-- display page header --}}
@section('page_header_icon', 'icon-location4')
@section('page_header', __('Add Upazila') )

{{-- submit button label --}}
@section('form_submit_btn', __('Save'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
    '#' => __('Settings'),
    action('Settings\ThanaUpazilaController@index') => __('Upazila'),
    action('Settings\ThanaUpazilaController@add')   => __('Add')
];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap(['view_thana_upazilas','edit_thana_upazilas','delete_thana_upazilas']) )
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Settings\ThanaUpazilaController@index') }}">
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

    <form action="{{ route('thanaupazilas.save') }}" method="POST" class="needs-validation" novalidate>

        @include('settings/thanaupazila/form')

    </form>

@endsection


{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
@endpush
