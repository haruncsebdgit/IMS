@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_locations', 'active')
@section('admin_menu_settings_region', 'active')

{{-- display page title --}}
@section('page_title', __('Regions'))
@section('body_class', 'region list')

{{-- display page header --}}
@section('page_header_icon', 'icon-location4')
@section('page_header', __('Regions') )

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
'#' => __('Settings'),
'javascript:' => __('Locations'),
action('Settings\RegionController@index') => __('Regions')
];
@endphp

@section('breadcrumb_right')
@if( hasUserCap('add_regions') )
<a class="btn btn-sm btn-primary" href="{{ action('Settings\RegionController@add') }}">
    <i class="icon-add mr-1" aria-hidden="true"></i> {{ __('Add') }}
</a>
@endif
@endsection

{{-- page content --}}
@section('content')

@if( ! $regions->isEmpty() || filter_input(INPUT_GET, 'filter') )
@include('settings/region/search')
@endif

@include('errors.validation')

@if(!$regions->isEmpty())

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
            @foreach($regions as $region)
            <tr>
                <td class="font-weight-bold">
                    @if( hasUserCap('edit_regions') )
                        <a href="{{ action('Settings\RegionController@edit', [$region->id]) }}">
                            {{ $region->name_en }}
                        </a>
                    @else
                    {{ $region->name_en }}
                    @endif
                </td>

                <td>{{ !empty($region->name_bn) ? $region->name_bn : '-' }}</td>

                <td>{{ translateString($region->geo_code) }}</td>

                <td class="small">
                    @if(!empty($region->latitude) && !empty($region->longitude))
                    {{ translateString($region->latitude) }}<br>
                    {{ translateString($region->longitude) }}
                    @else
                    -
                    @endif
                </td>

                <td>
                    @if( 1 === $region->is_active )
                    <span class="badge badge-success">{{ __("Active") }}</span>
                    @elseif( 0 === $region->is_active )
                    <span class="badge badge-danger"> {{ __("Inactive") }}</span>
                    @endif
                </td>

                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('Actions') }}
                        </button>
                        @if( hasUserCap(['edit_regions','delete_regions']) )
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-1">
                            @if( hasUserCap('edit_regions') )
                            <a href="{{ action('Settings\RegionController@edit', [$region->id]) }}" class="dropdown-item">
                                <i class="icon-pencil7" aria-hidden="true"></i> {{ __('Edit') }}
                            </a>
                            @endif

                            @if( hasUserCap('delete_regions') )
                            <div class="dropdown-divider"></div>

                            <form action="{{ route('region.delete', $region->id) }}" method="POST">
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

{!! gridFooter($regions, $itemsPerPage) !!}


@else

<div class="alert alert-info alert-styled-left" role="alert">
    {{ __('Sorry! No data found to display') }}
</div>

@endif

@endsection