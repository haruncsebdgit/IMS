@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_locations', 'active')
@section('admin_menu_settings_thana_upazila', 'active')

{{-- display page title --}}
@section('page_title', __('Upazila'))
@section('body_class', 'thana-upazila list')

{{-- display page header --}}
@section('page_header_icon', 'icon-location4')
@section('page_header', __('Upazila') )

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
    '#' => __('Settings'),
    action('Settings\ThanaUpazilaController@index') => __('Upazila')
];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap('add_thana_upazilas') )
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\ThanaUpazilaController@add') }}">
            <i class="icon-add mr-1" aria-hidden="true"></i> {{  __('Add') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

    @if( ! $thanaUpazilas->isEmpty() || filter_input(INPUT_GET, 'filter') )
        @include('settings/thanaupazila/search')
    @endif

    @include('errors.validation')

    <?php
    $lang = config('app.locale');
    $district_column_name = "district_name_{$lang}";
    ?>

    @if(!$thanaUpazilas->isEmpty())

        <div class="border mb-1">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr class="bg-secondary text-white">
                        <th>{{ __('District') }}</th>
                        <th>{{ __('Name (in English)') }}</th>
                        <th>{{ __('Name (in Bengali)') }}</th>
                        <th>{{ __('Geo Code') }}</th>
                        <th>{{ __('Coordinates') }}</th>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($thanaUpazilas as $thanaupazila)
                    <tr>
                        <td>
                            {{ $thanaupazila->$district_column_name ??  $thanaupazila->district_name_en }}
                        </td>

                        <td class="font-weight-bold">
                            @if( hasUserCap('edit_thana_upazilas') )
                                <a href="{{ action('Settings\ThanaUpazilaController@edit', ['thanaupazilas_id' => $thanaupazila->id]) }}">
                                    {{ $thanaupazila->name_en }}
                                </a>
                            @else
                                {{ $thanaupazila->name_en }}
                            @endif
                        </td>

                        <td>{{ !empty($thanaupazila->name_bn) ? $thanaupazila->name_bn : '-' }}</td>

                        <td>{{ translateString($thanaupazila->geo_code) }}</td>

                        <td class="small">
                            @if(!empty($thanaupazila->latitude) && !empty($thanaupazila->longitude))
                                {{ translateString($thanaupazila->latitude) }}<br>
                                {{ translateString($thanaupazila->longitude) }}
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if('Both' === $thanaupazila->type)
                                {{ __('Upazila') }}
                            @else
                                {{ __($thanaupazila->type) }}
                            @endif
                        </td>

                        <td>
                            @if( 1 === $thanaupazila->is_active )
                                <span class="badge badge-success">{{ __("Active") }}</span>
                            @elseif( 0 === $thanaupazila->is_active )
                                <span class="badge badge-danger"> {{ __("Inactive") }}</span>
                            @endif
                        </td>

                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('Actions') }}
                                </button>

                                @if( hasUserCap(['edit_thana_upazilas','delete_thana_upazilas']) )
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-1">
                                        @if( hasUserCap('edit_thana_upazilas') )
                                            <a href="{{ action('Settings\ThanaUpazilaController@edit', ['district_id' => $thanaupazila->id]) }}" class="dropdown-item">
                                                <i class="icon-pencil7" aria-hidden="true"></i> {{ __('Edit') }}
                                            </a>
                                        @endif

                                        @if( hasUserCap('delete_thana_upazilas') )
                                            <div class="dropdown-divider"></div>

                                            <form action="{{ route('thanaupazilas.delete', $thanaupazila->id) }}" method="POST">
                                                <button type="submit" onclick="return confirm('Are you sure?')" class="delete-thana btn btn-link text-danger dropdown-item">
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
                        <th>{{ __('District') }}</th>
                        <th>{{ __('Name (in English)') }}</th>
                        <th>{{ __('Name (in Bengali)') }}</th>
                        <th>{{ __('Geo Code') }}</th>
                        <th>{{ __('Coordinates') }}</th>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        {!! gridFooter($thanaUpazilas, $itemsPerPage) !!}

    @else

        <div class="alert alert-info alert-styled-left" role="alert">
            {{ __('Sorry! No data found to display') }}
        </div>

    @endif

@endsection
