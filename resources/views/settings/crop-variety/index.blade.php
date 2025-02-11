@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_monitoring_settings', 'active')
@section('admin_menu_settings_crop_variety', 'active')

{{-- display page title --}}
@section('page_title', __('CropVariety'))
@section('body_class', 'CropVariety list')

{{-- display page header --}}
@section('page_header_icon', 'icon-cog')
@section('page_header', __('CropVariety') )

@section('sidebar')
@include('layouts.admin-sidebar-monitoring')
@endsection

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
'#' => __('CropVariety'),
action('Settings\CropVarietyController@index') => __('CropVariety')
];
@endphp

@section('breadcrumb_right')
@if( hasUserCap('add_crop_variety') )
<a class="btn btn-sm btn-primary" href="{{ action('Settings\CropVarietyController@create') }}">
    <i class="icon-add mr-1" aria-hidden="true"></i> {{ __('Add') }}
</a>
@endif
@endsection

{{-- page content --}}
@section('content')

@if( ! $cropvariety->isEmpty() || filter_input(INPUT_GET, 'filter') )
@include ('settings.crop-variety.search-form')
@endif

@include('errors.validation')

@if(!$cropvariety->isEmpty())

<div class="border mb-1">
    <table class="table table-hover table-striped mb-0">
        <thead>
            <tr class="bg-secondary text-white">
                <th>#</th>
                <th>{{ __('Crop') }}</th>
                <th>{{ __('Crop Type') }}</th>
                <th>{{ __('Name (English)') }}</th>
                <th>{{ __('Name (Bengali)') }}</th>
                <th>{{ __('Unit') }}</th>
                <th>{{ __('Is Active') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach($cropvariety as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->crops }}</td>
                <td>{{ cropType($item->crop_type_id) }}</td>
                <td>{{ $item->name_en }}</td>
                <td>{{ $item->name_bn }}</td>
                <td>{{ $item->unit }}</td>
                <td>
                    @if($item->is_active)
                        <span class="badge badge-success">{{ __('Yes') }}</span>
                    @else
                        <span class="badge badge-secondary">{{ __('No') }}</span>
                    @endif
                </td>

                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('Actions') }}
                        </button>
                        @if( hasUserCap(['edit_crop_variety','delete_crop_variety']) )
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-1">
                            @if( hasUserCap('edit_crop_variety') )
                            <a href="{{ action('Settings\CropVarietyController@edit', ['id' => $item->id]) }}" class="dropdown-item">
                                <i class="icon-pencil7" aria-hidden="true"></i> {{ __('Edit') }}
                            </a>
                            @endif

                            @if( hasUserCap('delete_crop_variety') )
                            <div class="dropdown-divider"></div>

                            <form action="{{ route('crop-variety.delete', $item->id) }}" method="POST">
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
                <th>#</th>
                <th>{{ __('Crop') }}</th>
                <th>{{ __('Crop Type') }}</th>
                <th>{{ __('Name (English)') }}</th>
                <th>{{ __('Name (Bengali)') }}</th>
                <th>{{ __('Unit') }}</th>
                <th>{{ __('Is Active') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </tfoot>
    </table>
</div>

{!! gridFooter($cropvariety, $itemsPerPage) !!}


@else

<div class="alert alert-info alert-styled-left" role="alert">
    {{ __('Sorry! No data found to display') }}
</div>

@endif

@endsection
