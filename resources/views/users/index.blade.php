@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_users', 'active')
@section('admin_menu_users_list', 'active')

{{-- display page title --}}
@section('page_title',  __('Users'))
@section('body_class', 'users')

{{-- display page header --}}
@section('page_header_icon', 'icon-users')
@section('page_header', __('Users'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#' => __('Access Management'),
        action('Users\UserController@index') => __('Users')
    ];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap('add_users'))
        <a href="{{ action('Users\UserController@add') }}" class="btn btn-sm btn-primary">
            <i class="icon-user-plus mr-1" aria-hidden="true"></i> {{ __('Add') }}
        </a>
    @endif
@endsection

{{-- add necessary styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/select2.min.css') }}">
@endpush

{{-- page content --}}
@section('content')

    @if( ! $users->isEmpty() || filter_input(INPUT_GET, 'filter') )
        @include('users.search-form')
    @endif

    @include('errors.validation')

    @if( ! $users->isEmpty() )

        <div class="border mb-1">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr class="bg-secondary text-white">
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Username') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Room No') }}</th>
                        <th>{{ __('Role') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="font-weight-bold">
                                @if( hasUserCap('edit_users'))
                                    <a href="{{ action('Users\UserController@edit', ['user_id' => $user->id]) }}">{{ resolveFieldName($user) }}</a>
                                @else
                                    {{ resolveFieldName($user) }}
                                @endif
                                @if( $user->is_active )
                                    <span class="dot bg-success align-middle ml-1" title="{{ __('Active User') }}"></span>
                                @else
                                    <span class="dot align-middle ml-1" title="{{ __('Inactive User') }}"></span>
                                @endif
                            </td>
                            <td><code>{{ $user->username }}</code></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ resolveFieldName($user->location()->first()) }}</td>
                            <td>
                                <?php
                                $userRole = getUserRole($user->id);

                                if( false == $userRole ) {
                                    echo '&mdash';
                                } else {
                                    $_counter = 1;
                                    $_data_count = count($userRole);

                                    foreach ($userRole as $item) {
                                        echo strip_tags($item['label']);
                                        if($_counter !== $_data_count) echo ', ';

                                        $_counter ++;
                                    } //endforeach
                                } //endif
                                ?>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-{{$user->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ __('Actions') }}
                                    </button>

                                    @if( hasUserCap(['view_users','edit_users','delete_users','user_capabilities']))
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-{{$user->id}}">

                                        @if( hasUserCap('edit_users'))
                                            <a href="{{ action('Users\UserController@edit', ['user_id' => $user->id]) }}" class="dropdown-item">
                                                <i class="icon-pencil7" aria-hidden="true"></i> {{ __('Edit User') }}
                                            </a>
                                        @endif

                                        @if( hasUserCap('user_capabilities'))
                                            <a href="{{ action('Users\UserController@userCapabilities', ['user_id' => $user->id]) }}" class="dropdown-item">
                                                <i class="icon-user-check" aria-hidden="true"></i> {{ __('User Capabilities') }}
                                            </a>
                                        @endif

                                        @if( hasUserCap('delete_users'))
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('users.delete', $user->id) }}" method="POST">
                                            <button type="submit" onclick="return confirm('Are you sure?')" class="delete-user btn btn-link text-danger dropdown-item">
                                                <i class="icon-trash" aria-hidden="true"></i> {{ __('Delete User') }}
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
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Username') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Room No') }}</th>
                        <th>{{ __('Role') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        {!! gridFooter($users, $itemsPerPage) !!}

    @else

        <div class="alert alert-info alert-styled-left" role="alert">
            {{ __('Sorry! No data found to display') }}
        </div>

    @endif

@endsection

{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
@endpush
