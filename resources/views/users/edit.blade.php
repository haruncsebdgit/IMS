@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section("admin_menu_users", 'active')
@section("admin_menu_users_list", 'active')

{{-- display page title --}}
@section('page_title', __('Edit User'))
@section('body_class', 'users edit-user')

{{-- display page header --}}
@section('page_header_icon', 'icon-users')
@section('page_header', __('Edit User'))

{{-- submit button label --}}
@section('user_form_submit_btn', __('Update'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#' => __('Access Management'),
        action('Users\UserController@index') => __('Users'),
        action('Users\UserController@edit')  => __('Edit')
    ];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap('user_capabilities'))
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Users\UserController@userCapabilities', ['user_id' => $user->id]) }}">
            <i class="icon-user-check mr-1"></i> {{ __('User Capabilities') }}
        </a>
    @endif

    @if( hasUserCap(['view_users','edit_users','delete_users']))
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Users\UserController@index') }}">
            <i class="icon-list-unordered mr-1"></i> {{ __('List of Users') }}
        </a>
    @endif

    @if( hasUserCap('add_users'))
        <a class="btn btn-primary btn-sm" href="{{ action('Users\UserController@add') }}">
            <i class="icon-user-plus mr-1"></i> {{ __('Add') }}
        </a>
    @endif
@endsection

{{-- add necessary styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/select2.min.css') }}">
@endpush

{{-- page content --}}
@section('content')

    {!! Form::model($user, ['route' => ['users.update', $user->id],'method'=>'put', 'files' => true, 'class' => 'needs-validation', 'novalidate']) !!}

    {{-- <form action="{{ route('users.update') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data"> --}}

        @include('users/form')

        <input type="hidden" name="id" value="{{ $user->id }}">
        {{-- @method('PUT') --}}

    {{-- </form> --}}
    {!! Form::close() !!}

@endsection

@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
    <script src="{{ asset('js/pages/user_form_page.js') }}"></script>
@endpush
