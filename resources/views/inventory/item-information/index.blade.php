@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_item_info', 'active')

{{-- display page title --}}
@section('page_title', __('Item List'))
@section('body_class', 'Item list')

{{-- display page header --}}
@section('page_header_icon', 'icon-cube4')
@section('page_header', __('Item List') )
@section('sidebar')
@include('layouts.admin-sidebar-inventory')
@endsection
{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
action('Inventory\ItemInformationController@index') => __('Item'),
'#' => __('List')
];
@endphp

@section('breadcrumb_right')
@if( hasUserCap('view_item_category_sub_category_info') )
<a class="btn btn-sm btn-primary" href="{{ action('Inventory\ItemInformationController@create') }}">
    <i class="icon-add mr-1" aria-hidden="true"></i> {{ __('Add') }}
</a>
@endif
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/datepicker.min.css') }}">
@endpush
{{-- page content --}}
@section('content')

@if( ! $item_information->isEmpty() || filter_input(INPUT_GET, 'filter') )
@include ('inventory.item-information.search-form')
@endif

@include('errors.validation')

@if(!$item_information->isEmpty())

<div class="border mb-1">
    <table class="table table-hover table-striped mb-0">
        <thead>
            <tr class="bg-secondary text-white">
                <th>#</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Code') }}</th>
                <th>{{ __('Asset Type') }}</th>
                <th>{{ __('Category') }}</th>
                <th>{{ __('UoM') }}</th>
                <th>{{ __('Part Number') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach($item_information as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                     @if( hasUserCap(['view_item_info']))
                        <a href="{{ action('Inventory\ItemInformationController@show', ['id' => $item->id]) }}">
                            {{ $item->name_en }}
                        </a>
                    @else
                        {{ $item->name_en }}
                    @endif
                </td>
                <td>{{ $item->code_en }}</td>
                <td>{{ getAssetType($item->asset_type) }}</td>
                <td>{{ $item->category }}</td>
                <td>{{ $item->uoM }}</td>
                <td>{{ $item->part_number }}</td>

                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('Actions') }}
                        </button>
                        @if( hasUserCap(['edit_item_info','delete_item_info']) )
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-1">
                            @if( hasUserCap('edit_item_info') )
                            <a href="{{ action('Inventory\ItemInformationController@edit', ['id' => $item->id]) }}" class="dropdown-item">
                                <i class="icon-pencil7" aria-hidden="true"></i> {{ __('Edit') }}
                            </a>
                            @endif
                            @if( hasUserCap('view_item_info'))
                                <a href="{{ action('Inventory\ItemInformationController@show', ['id' =>  $item->id]) }}" class="dropdown-item">
                                    <i class="icon-eye8" aria-hidden="true"></i> {{ __('View') }}
                                </a>
                            @endif

                            @if( hasUserCap('delete_item_info') )
                            <div class="dropdown-divider"></div>

                            <form action="{{ route('item-information.delete', $item->id) }}" method="POST">
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
                <th>{{ __('Name') }}</th>
                <th>{{ __('Code') }}</th>
                <th>{{ __('Asset Type') }}</th>
                <th>{{ __('Category') }}</th>
                <th>{{ __('UoM') }}</th>
                <th>{{ __('Part Number') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </tfoot>
    </table>
</div>

{!! gridFooter($item_information, $itemsPerPage) !!}


@else

<div class="alert alert-info alert-styled-left" role="alert">
    {{ __('Sorry! No data found to display') }}
</div>

@endif

@endsection
@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
    <script src="{{ asset('js/libs/datepicker.min.js') }}"></script>
@endpush
