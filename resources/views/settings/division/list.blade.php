@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_locations', 'active')
@section('admin_menu_settings_division', 'active')

{{-- display page title --}}
@section('page_title', __('Divisions'))
@section('body_class', 'division list')

{{-- display page header --}}
@section('page_header_icon', 'icon-location4')
@section('page_header', __('Divisions') )

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
    '#' => __('Settings'),
    'javascript:' => __('Locations'),
    action('Settings\DivisionController@index') => __('Divisions')
];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap('add_divisions') )
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\DivisionController@add') }}">
            <i class="icon-add mr-1" aria-hidden="true"></i> {{  __('Add') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

    @if( ! $divisions->isEmpty() || filter_input(INPUT_GET, 'filter') )
        @include('settings/division/search')
    @endif

    @include('errors.validation')

    @if(!$divisions->isEmpty())

        <div class="border mb-1">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr class="bg-secondary text-white">
                        <th>{{ __('Name (in English)') }}</th>
                        <th>{{ __('Name (in Bengali)') }}</th>
                        <th>{{ __('Geo Code') }}</th>
                        <th>{{ __('Coordinates') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($divisions as $division)
                    <tr>
                        <td class="font-weight-bold">
                            @if( hasUserCap('edit_divisions') )
                                <a href="{{ action('Settings\DivisionController@edit', ['division_id' => $division->id]) }}">
                                    {{ $division->name_en }}
                                </a>
                            @else
                                {{ $division->name_en }}
                            @endif
                        </td>

                        <td>{{ !empty($division->name_bn) ? $division->name_bn : '-' }}</td>

                        <td>{{ translateString($division->geo_code) }}</td>

                        <td class="small">
                            @if(!empty($division->latitude) && !empty($division->longitude))
                                {{ translateString($division->latitude) }}<br>
                                {{ translateString($division->longitude) }}
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if( 1 === $division->is_active )
                                <span class="badge badge-success">{{ __("Active") }}</span>
                            @elseif( 0 === $division->is_active )
                                <span class="badge badge-danger"> {{ __("Inactive") }}</span>
                            @endif
                        </td>

                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('Actions') }}
                                </button>
                                @if( hasUserCap(['edit_divisions','delete_divisions']) )
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-1">
                                        @if( hasUserCap('edit_divisions') )
                                            <a href="{{ action('Settings\DivisionController@edit', ['division_id' => $division->id]) }}" class="dropdown-item">
                                                <i class="icon-pencil7" aria-hidden="true"></i> {{ __('Edit') }}
                                            </a>
                                        @endif

                                        @if( hasUserCap('delete_divisions') )
                                           <div class="dropdown-divider"></div>

                                          <form action="{{ route('division.delete', $division->id) }}" method="POST">
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
                        <th>{{ __('Geo Code') }}</th>
                        <th>{{ __('Coordinates') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        {!! gridFooter($divisions, $itemsPerPage) !!}


    @else

        <div class="alert alert-info alert-styled-left" role="alert">
            {{ __('Sorry! No data found to display') }}
        </div>

    @endif

@endsection
