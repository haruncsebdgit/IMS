@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section("admin_menu_users", 'active')
@section("admin_menu_users_group_list", 'active')

{{-- display page title --}}
@section('page_title',  __('Users Group'))
@section('body_class', 'user-group list-user-group')

{{-- display page header --}}
@section('page_header_icon', 'icon-collaboration')
@section('page_header', __('Users Group'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#'                                        => __('Access Management'),
        action('Users\UsersGroupController@index') => __('Users Group')
    ];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap('add_users_group'))
        <a href="{{ action('Users\UsersGroupController@add') }}" class="btn btn-primary btn-sm">
            <i class="icon-add-to-list mr-1" aria-hidden="true"></i>
            {{ __('Add') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

    @include('errors.validation')

    @if( ! $usersGroupInfo->isEmpty() )

        <div class="border mb-1">
            <table class="table table-hover table-striped mb-0">
                <thead>
                <tr class="bg-secondary text-white">
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Author') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
                </thead>

                <tbody>
                @foreach( $usersGroupInfo as $value )

                    {{-- localize user group if applicable --}}
                    @php $value = $usersGroupModel->localizeUsersGroup($value); @endphp

                    <tr>
                        <td class="font-weight-bold">
                            @if( hasUserCap('edit_users_group'))
                                <a href="{{ action('Users\UsersGroupController@edit', ['user_group_id' => $value->id]) }}">
                                    {{ $value->title }}
                                </a>
                            @else
                                {{ $value->title }}
                            @endif
                        </td>

                        <td>
                            @if(isset($value->created_by))
                                @php
                                    $author = $usersGroupModel->getUsersGroupAuthor($value->created_by);
                                @endphp

                                {{ resolveFieldName($author) }}
                            @endif
                        </td>

                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-{{ $value->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('Actions') }}
                                </button>

                                @if( hasUserCap(["edit_users_group", "delete_users_group"]) )
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-{{ $value->id }}">
                                        @if( hasUserCap('edit_users_group'))
                                            <a href="{{ action('Users\UsersGroupController@edit', ['user_group_id' => $value->id]) }}" class="dropdown-item">
                                                <i class="icon-pencil7" aria-hidden="true"></i>
                                                {{ __('Edit Group') }}
                                            </a>
                                        @endif

                                        @if( hasUserCap('delete_users_group') )
                                            <div class="dropdown-divider"></div>

                                            <form action="{{ route('usergroup.delete', $value->id) }}" method="POST">
                                                <button type="submit" onclick="return confirm('Are you sure?')" class="delete-user-group btn btn-link text-danger dropdown-item">
                                                    <i class="icon-trash" aria-hidden="true"></i>
                                                    {{ __('Delete Group') }}
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
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Author') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
                </tfoot>
            </table>
        </div>

        {!! gridFooter($usersGroupInfo, $itemsPerPage) !!}

    @else

        <div class="alert alert-info alert-styled-left" role="alert">
            {{ __('No users group found to display') }}
        </div>
    @endif

@endsection
