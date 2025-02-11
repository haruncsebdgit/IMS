@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section("admin_menu_settings", 'active')
@section("admin_menu_settings_financial_year", 'active')
@section("admin_menu_settings_financial_year_add", 'active')

{{-- display page title --}}
@section('page_title', __('Add Financial Year'))
@section('body_class', "financial-year add")

{{-- display page header --}}
@section('page_header_icon', "icon-stats-growth")
@section('page_header', __('Add Financial Year'))

{{-- submit button label --}}
@section('financial_year_form_submit_btn', __('Save'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#'                                              => __('Settings'),
        action('Settings\FinancialYearController@index') => __('Financial Year'),
        action('Settings\FinancialYearController@add')   => __('Add')
    ];
@endphp

@section('breadcrumb_right')
    @if(hasUserCap(['view_financial_year','edit_financial_year','delete_financial_year']))
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Settings\FinancialYearController@index') }}">
            <i class="icon-list-unordered mr-1" aria-hidden="true"></i>
            {{ __('List of Financial Year') }}
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

    <form action="{{ route('financialyear.save') }}" method="POST" class="needs-validation" novalidate>

        @include('settings.financial-year.form')

        <input type="hidden" name="id" value="">

    </form>

@endsection

{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
    <script src="{{ asset('js/libs/datepicker.min.js') }}"></script>
@endpush
