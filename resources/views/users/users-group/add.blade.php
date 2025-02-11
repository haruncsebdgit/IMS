@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section("admin_menu_users", 'active')
@section("admin_menu_users_group_list", 'active')
@section("admin_menu_users_group_add", 'active')

{{-- display page title --}}
@section('page_title', __('New Users Group'))
@section('body_class', 'user-group add-user-group')

{{-- display page header --}}
@section('page_header_icon', 'icon-collaboration')
@section('page_header',__('New Users Group'))

{{-- submit button label --}}
@section('user_group_form_submit_btn', __('Add'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#'                                        => __('Access Management'),
        action('Users\UsersGroupController@index') => __('Users Group'),
        action('Users\UsersGroupController@add')   => __('Add')
    ];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap(['view_users_group','edit_users_group','delete_users_group']))
        <a href="{{  action('Users\UsersGroupController@index') }}" class="btn btn-sm btn-link">
            <i class="icon-list-unordered mr-1" aria-hidden="true"></i>
            {{ __('List') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

    <form action="{{ route('usergroup.save') }}" method="POST" class="needs-validation" novalidate>
        @include('users/users-group/form')
    </form>

@endsection
