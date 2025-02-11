@extends('layouts.admin')

{{-- make the relevant menu active --}}
{{-- @section('admin_menu_users', 'active') --}}
@section('admin_menu_loggedin_users_list', 'active')

{{-- display page title --}}
@section('page_title',  __('Logged In Users'))
@section('body_class', 'users')

{{-- display page header --}}
@section('page_header_icon', 'icon-users')
@section('page_header', __('Logged In Users'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#' => __('Logged In Users')
    ];
@endphp

{{-- add necessary styles --}}
@push('styles')
@endpush

{{-- page content --}}
@section('content')

@if( ! $users->isEmpty() )
<h4 class="font-weight-bold text-center text-primary h3 mb-3">
    {{ __('Total') . ": " . translateString($users->count()) . " " .  __('Persons') }}
</h4>
    <div class="border mb-1">
        <table class="table table-bordered table-sm mb-0">

            <tbody>
                @foreach ($users as $user)
                    {{-- @if ($user->isOnline()) --}}
                    <tr>
                        <td>{{ (!empty($user->name_bn) ? $user->name_bn : $user->name_en) }}</td>
                        <td>
                            <li class="text-success">
                                {{ __('Online') }}
                            </li>
                        </td>
                    </tr>
                    {{-- @endif --}}
                @endforeach
            </tbody>

        </table>
    </div>

@else

<div class="alert alert-info alert-styled-left" role="alert">
    {{ __('Sorry! No data found to display') }}
</div>

@endif

@endsection

{{-- add necessary scripts --}}
@push('scripts')
@endpush
