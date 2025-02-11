@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_reports', 'active')

{{-- display page title --}}
@section('page_title', __('Stock'))
@section('body_class', 'reports test')

{{-- display page header --}}
@section('page_header_icon', 'icon-file-text')
@if(!empty($type))
    @section('admin_menu_room_wise_stock_reports', 'active')
    @section('page_header', __('Room wise Item'))
@else
    @section('admin_menu_stock_reports', 'active')
    @section('page_header', __('Stock'))
@endif

@section('sidebar')
    @include('layouts.admin-sidebar-inventory')
@endsection

{{-- set the form post route --}}
@section('report_route', route('report.stock.preview'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#' => __('Reports'),
        action('Reports\StockReportController@index') => __('Stock')
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
        @include('reports.stock.form')
    @endsection

    @include('layouts.report')

@endsection

{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
    <script src="{{ asset('js/libs/datepicker.min.js') }}"></script>
@endpush
