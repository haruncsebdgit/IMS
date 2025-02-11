
@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_locations', 'active')
@section('admin_menu_settings_thana_upazila', 'active')

{{-- display page title --}}
@section('page_title', __('Edit Upazila'))
@section('body_class', 'district edit')

{{-- display page header --}}
@section('page_header_icon', 'icon-location4')
@section('page_header', __('Edit Upazila') )

{{-- submit button label --}}
@section('form_submit_btn', __('Update'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
    '#' => __('Settings'),
    action('Settings\ThanaUpazilaController@index') => __('Upazila'),
    action('Settings\ThanaUpazilaController@edit') => __('Edit')
];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap(['view_thana_upazilas','edit_thana_upazilas','delete_thana_upazilas']) )
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Settings\ThanaUpazilaController@index') }}">
            <i class="icon-list mr-1" aria-hidden="true"></i> {{  __('List') }}
        </a>
    @endif

    @if( hasUserCap('add_thana_upazilas') )
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\ThanaUpazilaController@add') }}">
            <i class="icon-add mr-1" aria-hidden="true"></i> {{  __('Add') }}
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

    <form action="{{ route('thanaupazilas.update') }}" method="POST" class="needs-validation" novalidate>

        @include('settings/thanaupazila/form')

        <input type="hidden" name="id" value="{{ $thanaUpazila->id }}">
        @method('PUT')

    </form>

@endsection

{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
@endpush
