@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section("admin_menu_settings", 'active')
@section("admin_menu_settings_financial_year", 'active')
@section("admin_menu_settings_financial_year_edit", 'active')

{{-- display page title --}}
@section('page_title', __('Edit Financial Year'))
@section('body_class', "financial-year edit")

{{-- display page header --}}
@section('page_header_icon', "icon-stats-growth")
@section('page_header', __('Edit Financial Year'))

{{-- submit button label --}}
@section('financial_year_form_submit_btn', __('Update'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#'                                              => __('Settings'),
        action('Settings\FinancialYearController@index') => __('Financial Year')
    ];

    if(hasUserCap('edit_financial_year')){
        $breadcrumbs[action('Settings\FinancialYearController@edit', array('financial_year_id' => $the_financial_year->id))] = __('Edit');
    }
@endphp

@section('breadcrumb_right')
    @if(hasUserCap(['view_financial_year','edit_financial_year','delete_financial_year']))
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Settings\FinancialYearController@index') }}">
            <i class="icon-list-unordered mr-1" aria-hidden="true"></i>
            {{ __('List of Financial Year') }}
        </a>
    @endif

    @if(hasUserCap('add_financial_year'))
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\FinancialYearController@add') }}">
            <i class="icon-add mr-1" aria-hidden="true"></i>
            {{ __('Add Financial Year') }}
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

    <form action="{{ route('financialyear.update') }}" method="POST" class="needs-validation" novalidate>

        @include('settings.financial-year.form')

        <input type="hidden" name="id" value="{{ $the_financial_year->id }}">

        @method('PUT')

    </form>

@endsection

{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
    <script src="{{ asset('js/libs/datepicker.min.js') }}"></script>
@endpush
