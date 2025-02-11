@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section("admin_menu_users", 'active')
@section("admin_menu_roles", 'active')

{{-- display page title --}}
@section('page_title',  __('Edit Role & Permission'))
@section('body_class', 'user-roles edit-user-role')

{{-- display page header --}}
@section('page_header_icon', 'icon-stack-check')
@section('page_header', __('Edit Role & Permission'))

{{-- submit button label --}}
@section('user_role_form_submit_btn', __('Update'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#' => __('Access Management'),
        action('Users\RoleController@index') => __('Roles & Permissions'),
        action('Users\RoleController@edit')   => __('Edit')
    ];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap(['view_roles_permissions','edit_roles_permissions','delete_roles_permissions']))
        <a href="{{ action('Users\RoleController@index') }}" class="btn btn-link btn-sm">
            <i class="icon-list-unordered mr-1" aria-hidden="true"></i>
            {{ __('List') }}
        </a>
    @endif

    @if( hasUserCap('add_roles_permissions'))
        <a href="{{ action('Users\RoleController@add') }}" class="btn btn-primary btn-sm">
            <i class="icon-add-to-list mr-1" aria-hidden="true"></i>
            {{ __('Add') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

    <form action="{{ route('urole.update') }}" method="POST" class="needs-validation" novalidate>

        @include('users/roles/form')

        <input type="hidden" name="id" value="{{ $userRolesData->id }}">

        @method('PUT')

    </form>

@endsection
