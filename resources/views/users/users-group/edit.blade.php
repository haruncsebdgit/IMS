@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section("admin_menu_users", 'active')
@section("admin_menu_users_group_list", 'active')
@section("admin_menu_users_group_edit", 'active')

{{-- display page title --}}
@section('page_title',  __('Edit Users Group'))
@section('body_class', 'user-group edit-user-group')

{{-- display page header --}}
@section('page_header_icon', 'icon-collaboration')
@section('page_header', __('Edit Users Group'))

{{-- submit button label --}}
@section('user_group_form_submit_btn', __('Update'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#'                                        => __('Access Management'),
        action('Users\UsersGroupController@index') => __('Users Group'),
        action('Users\UsersGroupController@edit')  => __('Edit')
    ];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap(['view_users_group','edit_users_group','delete_users_group']))
        <a href="{{  action('Users\UsersGroupController@index') }}" class="btn btn-sm btn-link">
            <i class="icon-list-unordered mr-1" aria-hidden="true"></i>
            {{ __('List') }}
        </a>
    @endif

    @if( hasUserCap('add_users_group'))
        <a href="{{ action('Users\UsersGroupController@add') }}" class="btn btn-primary btn-sm">
            <i class="icon-add-to-list mr-1" aria-hidden="true"></i>
            {{ __('Add') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

    <form action="{{ route('usergroup.update') }}" method="POST" class="needs-validation" novalidate>

        @include('users/users-group/form')

        <input type="hidden" name="id" value="{{ $usersGroupData->id }}">

        @method('PUT')

    </form>

@endsection

@push('scripts')
    <script src="{{ asset('js/libs/list.min.js') }}"></script>

    <script type="text/javascript">
        var options = {
            valueNames: ['username']
        };

        var locList = new List('user-group-list', options);

        $('#filter-users').on('change keyup', function () {
            var searchString = $(this).val();
            locList.search(searchString);
        });

        $('#reset-filter, #btn-submit').click(function () {
            $('#filter-users').val('');
            locList.search();
        });
    </script>
@endpush
