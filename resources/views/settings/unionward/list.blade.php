@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_locations', 'active')
@section('admin_menu_settings_union_ward', 'active')

{{-- display page title --}}
@section('page_title', __('Union/Ward'))
@section('body_class', 'union-ward list')

{{-- display page header --}}
@section('page_header_icon', 'icon-location4')
@section('page_header', __('Union/Ward'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#'                                          => __('Settings'),
        action('Settings\UnionWardController@index') => __('Union/Ward')
    ];
@endphp

@section('breadcrumb_right')
    @if(hasUserCap('add_union_ward'))
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\UnionWardController@add') }}">
            <i class="icon-add mr-1" aria-hidden="true"></i>
            {{ __('Add') }}
        </a>
    @endif
@endsection

{{-- add necessary styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/select2.min.css') }}">
@endpush

{{-- page content --}}
@section('content')

    @if(! $unionWardLists->isEmpty() || filter_input(INPUT_GET, 'filter'))
        @include('settings.unionward.search')
    @endif

    @include('errors.validation')

    @if(!$unionWardLists->isEmpty())

        <div class="border mb-1">
            <table class="table table-hover table-striped mb-0">
                <thead>
                <tr class="bg-secondary text-white">
                    <th>{{ __('Upazila') }}</th>
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
                @foreach($unionWardLists as $value)
                    <tr>
                        <td>
                            {{ !empty($value->thana_upazila_name) ? $value->thana_upazila_name : $value->thana_upazila }}
                        </td>

                        <td class="font-weight-bold">
                            @if(hasUserCap('edit_union_ward'))
                                <a href="{{ action('Settings\UnionWardController@edit', ['unionward_id' => $value->id]) }}">
                                    {{ $value->name_en }}
                                </a>
                            @else
                                {{ $value->name_en }}
                            @endif
                        </td>

                        <td>{{ !empty($value->name_bn) ? $value->name_bn : '-' }}</td>

                        <td>{{ translateString($value->geo_code) }}</td>

                        <td class="small">
                            @if(!empty($value->latitude) && !empty($value->longitude))
                                {{ translateString($value->latitude) }}<br>
                                {{ translateString($value->longitude) }}
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if('Both' === $value->type)
                                {{ __('Upazila') }}
                            @else
                                {{ __($value->type) }}
                            @endif
                        </td>

                        <td>
                            @if(1 === $value->is_active)
                                <span class="badge badge-success">{{ __("Active") }}</span>
                            @elseif(0 === $value->is_active)
                                <span class="badge badge-danger"> {{ __("Inactive") }}</span>
                            @endif
                        </td>

                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('Actions') }}
                                </button>

                                @if(hasUserCap(['edit_union_ward','delete_union_ward']))
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-1">
                                        @if(hasUserCap('edit_union_ward'))
                                            <a href="{{ action('Settings\UnionWardController@edit', ['union_ward_id' => $value->id]) }}" class="dropdown-item">
                                                <i class="icon-pencil7" aria-hidden="true"></i>
                                                {{ __('Edit') }}
                                            </a>
                                        @endif

                                        @if(hasUserCap('delete_union_ward'))
                                            <div class="dropdown-divider"></div>

                                            <form action="{{ route('unionward.delete', $value->id) }}" method="POST">
                                                <button type="submit" onclick="return confirm('Are you sure?')" class="delete-unionward btn btn-link text-danger dropdown-item">
                                                    <i class="icon-trash" aria-hidden="true"></i>
                                                    {{ __('Delete') }}
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
                    <th>{{ __('Upazila') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Name (Bengali)') }}</th>
                    <th>{{ __('Geo Code') }}</th>
                    <th>{{ __('Coordinates') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
                </tfoot>
            </table>
        </div>

        {!! gridFooter($unionWardLists, $itemsPerPage) !!}

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
