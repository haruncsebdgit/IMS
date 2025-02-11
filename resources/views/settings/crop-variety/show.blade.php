@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_monitoring_settings', 'active')
@section("admin_menu_cropvariety", 'active')

{{-- display page title --}}
@section('page_title', __('CropVariety') )

@section('body_class', 'dashboard view')

{{-- display page header --}}
@section('page_header_icon', 'icon-file-stats')
@section('page_header', __('CropVariety') )

@section('sidebar')
    @include('layouts.admin-sidebar-monitoring')
@endsection
{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
    '#' => __('CropVariety'),
    action('Settings/CropVarietyController@index') => __('CropVariety')
];
@endphp
@section('breadcrumb_right')
    {{-- @if( hasUserCap('add_bgcc_meeting')) --}}
        <a href="{{ action('Settings/CropVarietyController@edit', ['id' => $cropvariety->id]) }}" class="btn btn-sm btn-outline-primary">
            <i class="icon-pencil7 mr-1" aria-hidden="true"></i> {{ __('Edit') }}
        </a>
    {{-- @endif --}}
    {{-- @if( hasUserCap(['view_bgcc_meeting'])) --}}
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Settings/CropVarietyController@index') }}">
            <i class="icon-list-unordered"></i> {{ __('List') }}
        </a>
    {{-- @endif --}}
@endsection
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/jquery.fancybox.min.css') }}">
@endpush
@section('content')

    <div class="card">
        <div class="card-header bg-primary text-white">
            {{-- <div class="dropdown float-right ml-1">
                <button class="btn btn-sm btn-primary border border-white dropdown-toggle" type="button" id="export-report" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-download mr-1" aria-hidden="true"></i>
                    {{ __('Export') }}
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="export-report">
                    <a href="{{ action('CropVarietyController@show', [$cropvariety->id, "pdf"]) }}" target="_blank" class="dropdown-item btn btn-sm border border-white" title="{{ __('Portable Document Format (Extension: .pdf)') }}">
                        <i class="icon-file-pdf mr-1" aria-hidden="true"></i>
                        {{ __('Export as PDF') }}
                    </a>

                    <a href="{{ action('CropVarietyController@show', [$cropvariety->id, "xls"]) }}" target="_blank" class="dropdown-item btn btn-sm border border-white" title="{{ __('Microsoft Excel Spreadsheet (Extension: .xls)') }}">
                        <i class="icon-file-excel mr-1" aria-hidden="true"></i>
                        {{ __('Export as XLS') }}
                    </a>

                    <a href="{{ action('CropVarietyController@show', [$cropvariety->id, "doc"]) }}" target="_blank" class="dropdown-item btn btn-sm border border-white" title="{{ __('Microsoft Word document  (Extension: .doc)') }}">
                        <i class="icon-file-word mr-1" aria-hidden="true"></i>
                        {{ __('Export as DOC') }}
                    </a>
                </div>
            </div> --}}

            <a href="{{ action('Settings/CropVarietyController@show', [$cropvariety->id, "print"]) }}" target="_blank" class="float-right btn btn-sm border border-white text-white">
                <i class="icon-printer2 mr-1" aria-hidden="true"></i>
                {{ __('Print') }}
            </a>
            <div class="pt-1 font-we">
                {{ __('CropVariety') }}
            </div>
        </div>
        <div class="card-body">
            @include ('settings.crop-variety.view')
        </div>
    </div>

@endsection
@push('scripts')
    <script src="{{ asset('js/libs/jquery.fancybox.min.js') }}"></script>
@endpush
