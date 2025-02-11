@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_nav_dashboard', 'active')

{{-- display page title --}}
@section('page_title', __('Dashboard - Inventory'))

@section('body_class', 'dashboard')

{{-- display page header --}}
@section('page_header_icon', 'icon-meter2')
@section('page_header', __('Inventory Dashboard'))
@section('sidebar')
@include('layouts.admin-sidebar-inventory')
@endsection

{{-- add necessary scripts --}}
@push('scripts')
<script src="{{ asset('js/libs/jquery.matchHeight-min.js') }}"></script>
@endpush


{{-- page content --}}
@section('content')

<?php
    // Passing data into Javascript using the Global $_javascript_data.
    $_javascript_data = array_merge($_javascript_data, array(
        'dash_contents'    => '',
        'dash_total_count' => '',
        'dash_total_label' => __('Total:')
    ));
    ?>

@endsection

{{--add necessary scripts--}}
@push('scripts')
<script type="text/javascript" src="{{ asset('js/libs/d3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/libs/c3.min.js') }}"></script>
@endpush
