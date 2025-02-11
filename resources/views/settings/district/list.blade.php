@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_locations', 'active')
@section('admin_menu_settings_district', 'active')

{{-- display page title --}}
@section('page_title', __('Districts'))
@section('body_class', 'district list')

{{-- display page header --}}
@section('page_header_icon', 'icon-location4')
@section('page_header', __('Districts') )

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
    '#' => __('Settings'),
    'javascript:' => __('Locations'),
    action('Settings\DistrictController@index') => __('Districts')
];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap('add_districts') )
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\DistrictController@add') }}">
            <i class="icon-add mr-1" aria-hidden="true"></i> {{  __('Add') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

    @if( ! $districts->isEmpty() || filter_input(INPUT_GET, 'filter') )
        @include('settings/district/search')
    @endif

    @include('errors.validation')

    <?php
    $lang = config('app.locale');
    $division_column_name = "division_name_{$lang}";
    ?>

    @if(!$districts->isEmpty())

        <div class="border mb-1">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr class="bg-secondary text-white">
                        <th>{{ __('Division') }}</th>
                        <th>{{ __('Name (in English)') }}</th>
                        <th>{{ __('Name (in Bengali)') }}</th>
                        <th>{{ __('Geo Code') }}</th>
                        <th>{{ __('Coordinates') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($districts as $district)
                    <tr>
                        <td>
                            {{ $district->$division_column_name ??  $district->division_name_en }}
                        </td>

                        <td class="font-weight-bold">
                            @if( hasUserCap('edit_districts') )
                                <a href="{{ action('Settings\DistrictController@edit', ['district_id' => $district->id]) }}">
                                    {{ $district->name_en }}
                                </a>
                            @else
                                {{ $district->name_en }}
                            @endif
                        </td>

                        <td>{{ !empty($district->name_bn) ? $district->name_bn : '-' }}</td>

                        <td>
                            {{ translateString($district->geo_code) }}
                        </td>

                        <td class="small">
                            @if(!empty($district->latitude) && !empty($district->longitude))
                                {{ translateString($district->latitude) }}<br>
                                {{ translateString($district->longitude) }}
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if( 1 === $district->is_active )
                                <span class="badge badge-success">{{ __("Active") }}</span>
                            @elseif( 0 === $district->is_active )
                                <span class="badge badge-danger"> {{ __("Inactive") }}</span>
                            @endif
                        </td>

                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('Actions') }}
                                </button>

                                @if( hasUserCap(['edit_districts','delete_districts']) )
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-1">
                                        @if( hasUserCap('edit_districts') )
                                            <a href="{{ action('Settings\DistrictController@edit', ['district_id' => $district->id]) }}" class="dropdown-item">
                                                <i class="icon-pencil7" aria-hidden="true"></i> {{ __('Edit') }}
                                            </a>
                                        @endif

                                        @if( hasUserCap('delete_districts') )
                                            <div class="dropdown-divider"></div>

                                            <form action="{{ route('district.delete', $district->id) }}" method="POST">
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
                        <th>{{ __('Division') }}</th>
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

        {!! gridFooter($districts, $itemsPerPage) !!}

    @else

        <div class="alert alert-info alert-styled-left" role="alert">
            {{ __('Sorry! No data found to display') }}
        </div>

    @endif

@endsection
