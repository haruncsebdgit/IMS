@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_locations', 'active')
@section('admin_menu_settings_union_ward', 'active')

{{-- display page title --}}
@section('page_title', __('Add Union/Ward'))
@section('body_class', 'union-ward add')

{{-- display page header --}}
@section('page_header_icon', 'icon-location4')
@section('page_header', __('Add Union/Ward'))

{{-- submit button label --}}
@section('form_submit_btn', __('Save'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#'                                          => __('Settings'),
        action('Settings\UnionWardController@index') => __('Union/Ward'),
        action('Settings\UnionWardController@add')   => __('Add')
    ];
@endphp

@section('breadcrumb_right')
    @if(hasUserCap(['view_union_ward','edit_union_ward','delete_union_ward']))
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Settings\UnionWardController@index') }}">
            <i class="icon-list mr-1" aria-hidden="true"></i>
            {{ __('List') }}
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

    <form action="{{ route('unionward.save') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">

        @include('settings.unionward.form')

    </form>

@endsection


{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
@endpush
