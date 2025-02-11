@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_monitoring_settings', 'active')
@section('admin_menu_settings_farmers', 'active')

{{-- display page title --}}
@section('page_title', __('Farmers'))
@section('body_class', 'farmer list')

{{-- display page header --}}
@section('page_header_icon', 'icon-vcard')
@section('page_header', __('Farmers') )

@section('sidebar')
@include('layouts.admin-sidebar-monitoring')
@endsection

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
'#' => __('Settings'),
'javascript:' => __('Farmers'),
action('Settings\FarmerController@index') => __('List')
];
@endphp

@section('breadcrumb_right')
@if( hasUserCap('add_divisions') )
<a class="btn btn-sm btn-primary" href="{{ action('Settings\FarmerController@create') }}">
    <i class="icon-add mr-1" aria-hidden="true"></i> {{ __('Add') }}
</a>
@endif
@endsection

{{-- page content --}}
@section('content')

@if( ! $farmersLists->isEmpty() || filter_input(INPUT_GET, 'filter') )
@include('settings/farmer/search-form')
@endif

@include('errors.validation')

@if(!$farmersLists->isEmpty())

<div class="border mb-1">
    <table class="table table-hover table-striped mb-0">
        <thead>
            <tr class="bg-secondary text-white">
                <th>{{ __('Name (in English)') }}</th>
                <th>{{ __('Name (in Bengali)') }}</th>
                <th>{{ __('Location') }}</th>
                <th>{{ __('Village') }}</th>
                <th>{{ __('Gender') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach($farmersLists as $item)
            <tr>
                <td class="font-weight-bold">
                    @if( hasUserCap('edit_farmers') )
                    <a href="{{ action('Settings\FarmerController@edit', ['id' => $item->id]) }}">
                        {{ $item->name_en }}
                    </a>
                    @else
                    {{ $item->name_en }}
                    @endif
                </td>

                <td>{{ !empty($item->name_bn) ? $item->name_bn : '-' }}</td>

                <td>
                    {{ $item->union_name }}, {{ $item->upazila_name }}, <br>
                    {{ $item->district_name }}, {{ $item->division_name }}
                </td>

                <td> {{ $item->village }}</td>
                <td>{{ genderLabel($item->gender) }}</td>

                <td>
                    @if( 1 === $item->is_active )
                    <span class="badge badge-success">{{ __("Active") }}</span>
                    @elseif( 0 === $item->is_active )
                    <span class="badge badge-danger"> {{ __("Inactive") }}</span>
                    @endif
                </td>

                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('Actions') }}
                        </button>
                        @if( hasUserCap(['edit_farmers','delete_farmers']) )
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-1">
                            @if( hasUserCap('edit_farmers') )

                            <a href="{{ action('Settings\FarmerController@edit', ['farmer_id' => $item->id]) }}" class="dropdown-item">
                                <i class="icon-pencil7" aria-hidden="true"></i>
                                {{ __('Edit') }}
                            </a>

                            @endif

                            @if( hasUserCap('delete_farmers') )
                            <div class="dropdown-divider"></div>

                            <form action="{{ route('farmer.delete', $item->id) }}" method="POST">
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
                <th>{{ __('Location') }}</th>
                <th>{{ __('Village') }}</th>
                <th>{{ __('Gender') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </tfoot>
    </table>
</div>

{!! gridFooter($farmersLists, $itemsPerPage) !!}


@else

<div class="alert alert-info alert-styled-left" role="alert">
    {{ __('Sorry! No data found to display') }}
</div>

@endif

@endsection
