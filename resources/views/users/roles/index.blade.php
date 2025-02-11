@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section("admin_menu_users", 'active')
@section("admin_menu_roles", 'active')

{{-- display page title --}}
@section('page_title',  __('Roles & Permissions'))
@section('body_class', 'user-roles list-user-role')

{{-- display page header --}}
@section('page_header_icon', 'icon-stack-check')
@section('page_header', __('Roles & Permissions'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#' => __('Access Management'),
        action('Users\RoleController@index') => __('Roles & Permissions'),
    ];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap('add_roles_permissions'))
        <a href="{{ action('Users\RoleController@add') }}" class="btn btn-primary btn-sm">
            <i class="icon-add-to-list mr-1" aria-hidden="true"></i>
            {{ __('Add') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

    @include('errors.validation')

    @if( ! $userRolesInfo->isEmpty() )

        <div class="border mb-1">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr class="bg-secondary text-white">
                        <th>{{ __('Name (in English)') }}</th>
                        <th>{{ __('Name (in Bengali)') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $userRolesInfo as $role )
                        <tr>
                            <td class="font-weight-bold">
                                @if( hasUserCap('edit_roles_permissions'))
                                    <a href="{{ action('Users\RoleController@edit', ['role_id' => $role->id]) }}">{{ $role->name }}</a>
                                @else
                                    {{ $role->name }}
                                @endif
                            </td>
                            <td>{{ $role->name_bn }}</td>
                            <td>

                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-{{$role->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ __('Actions') }}
                                    </button>

                                    @if( hasUserCap(["edit_roles_permissions", "delete_roles_permissions"]) )
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-{{$role->id}}">
                                        @if( hasUserCap('edit_roles_permissions'))
                                            <a href="{{ action('Users\RoleController@edit', ['role_id' => $role->id]) }}" class="dropdown-item">
                                                <i class="icon-pencil7" aria-hidden="true"></i> {{ __('Edit Role') }}
                                            </a>
                                        @endif
                                        @if( hasUserCap('delete_roles_permissions') && $role->id != 1 )
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('urole.delete', $role->id) }}" method="POST">
                                                <button type="submit" onclick="return confirm('Are you sure?')" class="delete-user btn btn-link text-danger dropdown-item">
                                                    <i class="icon-trash" aria-hidden="true"></i> {{ __('Delete Role') }}
                                                </button>
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                    </div>
                                    @endif
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-secondary text-white">
                        <th>{{ __('Name (in English)') }}</th>
                        <th>{{ __('Name (in Bengali)') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="row small text-muted">
            <div class="col-sm-6">
                {{ __('Showing :count out of :total', ['count' => translateString($userRolesInfo->count()), 'total' => translateString($userRolesInfo->total()) ] ) }}
                <span class="ml-1 mr-1">|</span>
                {{ trans_choice(':items_per_page item per page|:items_per_page items per page', $itemsPerPage, ['items_per_page' => $itemsPerPage ] ) }}
            </div>
            <div class="text-sm-right col-sm-6">
                @if( $userRolesInfo->total() > $itemsPerPage )
                    {{-- Pagination keeping the filter parameters --}}
                    {{ $userRolesInfo->appends(Input::except('page'))->render() }}
                @else
                    {{ __('Page 1') }}
                @endif
            </div>
        </div>

    @else

        <div class="alert alert-info" role="alert">
            {{ __('No data available in this role') }}
        </div>

    @endif

@endsection
