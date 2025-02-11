@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_employee', 'active')
@section('admin_menu_settings_employee_add', 'active')

{{-- display page title --}}
@section('page_title', __('Add Employee Information'))
@section('body_class', 'employee add')

{{-- display page header --}}
@section('page_header_icon', 'icon-users2')
@section('page_header', __('Add Employee Information'))

{{-- submit button label --}}
@section('form_submit_btn', __('Save'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        'javascript:'                               => __('Settings'),
        action('Settings\EmployeeController@index') => __('Employees'),     
        action('Settings\EmployeeController@add')   => __('Add')
    ];
@endphp

@section('breadcrumb_right')
    @if(hasUserCap(['view_employees','edit_employees','delete_employees']))
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\EmployeeController@index') }}">
            <i class="icon-list mr-1" aria-hidden="true"></i>
            {{ __('List') }}
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

    @include('errors.validation')

    <form action="{{ route('employees.save') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">

        @include('settings.employees.form')

    </form>

@endsection

{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
    <script src="{{ asset('js/libs/datepicker.min.js') }}"></script>
    <script src="{{ asset('js/pages/employee_form_page.js') }}"></script>
@endpush
