@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section("admin_menu_settings_organogram", 'active')
@section("admin_menu_settings", 'active')

{{-- display page title --}}
@section('page_title', __('Organogram'))
@section('body_class', "users")

{{-- display page header --}}
@section('page_header_icon', 'icon-tree7')
@section('page_header', __('Organogram'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
'#' => __('Settings'),
//action('Scheme\BgccMeetingController@index') => __('Proposed Schemes'),
];
@endphp

@section('breadcrumb_right')
@if( hasUserCap('add_proposed_schemes') && empty($type))
<a href="{{ action('Scheme\BgccMeetingController@create') }}" class="btn btn-sm btn-primary">
    <i class="icon-plus3 mr-1" aria-hidden="true"></i> {{ __('Add') }}
</a>
@endif
@endsection
{{-- add necessary styles --}}
@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/libs/select2.min.css') }}">
@endpush

{{-- page content --}}
@section('content')

{{-- @if( $organogramTreeList || filter_input(INPUT_GET, 'filter') ) --}}
{{-- @include('scheme.bgcc-meeting.search-form') --}}
{{-- @endif --}}

@include('errors.validation')

<div class="row">
    <div class="col-md-12">
        @include('settings.organogram.organogram', ['showActionButton' => true])
    </div>
</div>

@endsection
{{-- add necessary scripts --}}
@push('scripts')

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-keyboard="false" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header bg-dark text-white">
            <h5 class="modal-title" id="exampleModalLabel">{{ __('Organogram') }}</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="content"></div>
    </div>
</div>

@endpush
