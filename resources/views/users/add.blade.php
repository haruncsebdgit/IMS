@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section("admin_menu_users", 'active')
@section("admin_menu_users_list", 'active')

{{-- display page title --}}
@section('page_title', __('Add User'))
@section('body_class', 'users add-user')

{{-- display page header --}}
@section('page_header_icon', 'icon-user-plus')
@section('page_header', __('Add User'))

{{-- submit button label --}}
@section('user_form_submit_btn', __('Add'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
    '#' => __('Access Management'),
    action('Users\UserController@index') => __('Users'),
    action('Users\UserController@add')  => __('Add New')
];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap(['view_users','edit_users','delete_users']))
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Users\UserController@index') }}">
            <i class="icon-list-unordered"></i> {{ __('List of Users') }}
        </a>
    @endif
@endsection

{{-- add necessary styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/select2.min.css') }}">
@endpush

{{-- page content --}}
@section('content')

    <form action="{{ route('users.save') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">

        @include('users/form')

    </form>

@endsection

{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
    <script src="{{ asset('js/pages/user_form_page.js') }}"></script>
@endpush
