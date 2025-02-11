@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_organization', 'active')

{{-- display page title --}}
@section('page_title', __('Organization'))
@section('body_class', 'organization list')

{{-- display page header --}}
@section('page_header_icon', 'icon-office')
@section('page_header', __('Organization') )

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
'#' => __('Settings'),
action('Settings\OrganizationController@index') => __('Organization')
];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap('add_organizations') )
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\OrganizationController@add') }}">
            <i class="icon-add mr-1" aria-hidden="true"></i> {{ __('Add') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

@if( ! $organizationsList->isEmpty() || filter_input(INPUT_GET, 'filter') )
 @include('settings/organization/search')
@endif

@include('errors.validation')

@if(!$organizationsList->isEmpty())

<div class="border mb-1">
    <table class="table table-hover table-striped mb-0">
        <thead>
            <tr class="bg-secondary text-white">
                <th>{{ __('Name (in English)') }}</th>
                <th>{{ __('Name (in Bengali)') }}</th>
                <th>{{ __('Short Name') }}</th>
                <th>{{ __('Code') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach($organizationsList as $organizations)
            <tr>
                <td class="font-weight-bold">
                    @if( hasUserCap('edit_organizations') )
                    <a href="{{ action('Settings\OrganizationController@edit', ['organization_id' => $organizations->id]) }}">
                        {{ $organizations->name_en }}
                    </a>
                    @else
                    {{ $organizations->name_en }}
                    @endif
                </td>

                <td>{{ !empty($organizations->name_bn) ? $organizations->name_bn : '-' }}</td>

                <td>{{ translateString($organizations->short_name) }}</td>
                <td>{{ translateString($organizations->code) }}</td>

                <td>
                    @if( 1 === $organizations->is_active )
                    <span class="badge badge-success">{{ __("Active") }}</span>
                    @elseif( 0 === $organizations->is_active )
                    <span class="badge badge-danger"> {{ __("Inactive") }}</span>
                    @endif
                </td>

                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('Actions') }}
                        </button>
                        @if( hasUserCap(['edit_organizations','delete_organizations']) )
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-1">
                            @if( hasUserCap('edit_organizations') )
                            <a href="{{ action('Settings\OrganizationController@edit', ['organization_id' => $organizations->id]) }}" class="dropdown-item">
                                <i class="icon-pencil7" aria-hidden="true"></i> {{ __('Edit') }}
                            </a>
                            @endif

                            @if( hasUserCap('delete_organizations') )
                            <div class="dropdown-divider"></div>

                            <form action="{{ route('organization.delete', $organizations->id) }}" method="POST">
                                <button type="submit" onclick="return confirm('Are you sure?')" class="delete-user btn btn-link text-danger dropdown-item">
                                    <i class="icon-trash" aria-hidden="true"></i> {{ __('Delete') }}
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
                <th>{{ __('Short Name') }}</th>
                <th>{{ __('Code') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </tfoot>
    </table>
</div>

{!! gridFooter($organizationsList, $itemsPerPage) !!}


@else

<div class="alert alert-info alert-styled-left" role="alert">
    {{ __('Sorry! No data found to display') }}
</div>

@endif

@endsection