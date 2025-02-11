@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_monitoring_settings', 'active')
@section('admin_menu_settings_technology_labels', 'active')

{{-- display page title --}}
@section('page_title', __('Technology'))
@section('body_class', 'Technology list')

{{-- display page header --}}
@section('page_header_icon', 'icon-headset')
@section('page_header', __('Technology') )

@section('sidebar')
@include('layouts.admin-sidebar-monitoring')
@endsection

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
'#' => __('Settings'),
action('Settings\TechnologyController@index') => __('Technology')
];
@endphp

@section('breadcrumb_right')
    @if( hasUserCap('add_technology_labels') )
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\TechnologyController@add') }}">
            <i class="icon-add mr-1" aria-hidden="true"></i> {{ __('Add') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

@if( ! $technologyLists->isEmpty() || filter_input(INPUT_GET, 'filter') )
@include ('settings.technology.search-form')
@endif

@include('errors.validation')

@if(!$technologyLists->isEmpty())

<div class="border mb-1">
    <table class="table table-hover table-striped mb-0">
        <thead>
            <tr class="bg-secondary text-white">
                <th>#</th>
                <th>{{ __('Name (in English)') }}</th>
                <th>{{ __('Name (in Bengali)') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Technology Type') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach($technologyLists as $item)

            <tr>
                <td>{{ $loop->iteration }}</td>


                <td>
                    @if( hasUserCap(['edit_technology_labels']))
                    <a href="{{ action('Settings\TechnologyController@edit', ['id' => $item->id]) }}">
                        {{ $item->name_en }}
                    </a>
                    @else
                        {{ $item->name_en }}
                    @endif
                </td>
                <td>{{ $item->name_bn }}</td>
                <td>
                    @if($item->is_active == 1)
                    <span class="badge badge-pill badge-success">{{ __('Active') }}</span>
                    @elseif($item->is_active == 0)
                    <span class="badge badge-pill badge-secondary">{{ __('Inactive') }}</span>
                    @endif
                </td>
                <td>{{ $item->technologyTypeName }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('Actions') }}
                        </button>
                        @if( hasUserCap(['edit_technology_labels','delete_technology_labels']) )
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-1">
                            @if( hasUserCap('edit_technology_labels') )
                            <a href="{{ action('Settings\TechnologyController@edit', ['id' => $item->id]) }}" class="dropdown-item">
                                <i class="icon-pencil7" aria-hidden="true"></i> {{ __('Edit') }}
                            </a>
                            @endif

                            @if( hasUserCap('delete_technology_labels') )
                            <div class="dropdown-divider"></div>

                            <form action="{{ route('technologies.delete', $item->id) }}" method="POST">
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
                <th>{{ __('Name (in English)') }}</th>
                <th>{{ __('Name (in Bengali)') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Technology Type') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </tfoot>
    </table>
</div>

{!! gridFooter($technologyLists, $itemsPerPage) !!}


@else

<div class="alert alert-info alert-styled-left" role="alert">
    {{ __('Sorry! No data found to display') }}
</div>

@endif

@endsection
