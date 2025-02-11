@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section("admin_menu_users", 'active')
@section("admin_menu_roles", 'active')

{{-- display page title --}}
@section('page_title', __('New Role & Permission'))
@section('body_class', 'user-roles add-user-role')

{{-- display page header --}}
@section('page_header_icon', 'icon-stack-check')
@section('page_header',__('New Role & Permission'))

{{-- submit button label --}}
@section('user_role_form_submit_btn', __('Add'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#' => __('Access Management'),
        action('Users\RoleController@index') => __('Roles & Permissions'),
        action('Users\RoleController@add')   => __('Add')
    ];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap(['view_roles_permissions','edit_roles_permissions','delete_roles_permissions']))
        <a href="{{ action('Users\RoleController@index') }}" class="btn btn-sm btn-link">
            <i class="icon-list-unordered mr-1" aria-hidden="true"></i>
            {{ __('List') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

    <form action="{{ route('urole.save') }}" method="POST" class="needs-validation" novalidate>
        @include('users/roles/form')
    </form>

@endsection

@push('scripts')
    {{-- Force lowercase string as a slug for better resolve conflict --}}
    <script type="text/javascript">
        // Auto suggest slug from the Role name.
        document.addEventListener('DOMContentLoaded', function() {
            var name_field = document.getElementById('name');

            name_field.onchange = name_field.onkeyup = function(event) {
                document.getElementById('slug').value = this.value.replace(/\s/g, "-").toLowerCase();
            };
        }, false);

        // Manage, inputs directly in the 'slug' field.
        var slug_input = document.getElementById('slug');

        slug_input.onkeyup = function(){
            this.value = this.value.toLowerCase();
        }
    </script>
@endpush
