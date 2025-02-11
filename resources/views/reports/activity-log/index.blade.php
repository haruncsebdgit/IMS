@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_reports', 'active')
@section('admin_menu_use_activity_log_reports', 'active')

{{-- display page title --}}
@section('page_title', __('User Activity Log'))
@section('body_class', 'reports test')

{{-- display page header --}}
@section('page_header_icon', 'icon-file-text')
@section('page_header', __('User Activity Log'))

{{-- set the form post route --}}
@section('report_route', route('report.activitylog.preview'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#' => __('Reports'),
        action('Reports\UserActivityLogController@index') => __('User Activity Log')
    ];
@endphp

{{-- add necessary styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/datepicker.min.css') }}">
@endpush

{{-- page content --}}
@section('content')

    @section('report_form_body')
        @include('reports.activity-log.form')
    @endsection

    @include('layouts.report')

@endsection

{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
    <script src="{{ asset('js/libs/datepicker.min.js') }}"></script>
@endpush
