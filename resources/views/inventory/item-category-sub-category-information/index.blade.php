@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_item_category_sub_category_info', 'active')

{{-- display page title --}}
@section('page_title', __('Item Category'))
@section('body_class', 'Item Category list')

{{-- display page header --}}
@section('page_header_icon', 'icon-paragraph-justify2')
@section('page_header', __('Item Category') )
@section('sidebar')
@include('layouts.admin-sidebar-inventory')
@endsection
{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
action('Inventory\ItemCategorySubCategoryInformationController@index') => __('Item Category'),
'#' => __('List')
];
@endphp

@section('breadcrumb_right')
@if( hasUserCap('view_item_category_sub_category_info') )
<a class="btn btn-sm btn-primary" href="{{ action('Inventory\ItemCategorySubCategoryInformationController@create') }}">
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

@if( ! $item_category_sub_category_information->isEmpty() || filter_input(INPUT_GET, 'filter') )
@include ('inventory.item-category-sub-category-information.search-form')
@endif

@include('errors.validation')

@if(!$item_category_sub_category_information->isEmpty())

<div class="border mb-1">
    <table class="table table-hover table-striped mb-0">
        <thead>
            <tr class="bg-secondary text-white">
                <th>#</th>
                <th>{{ __('Name (English)') }}</th>
                <th>{{ __('Name (Bengali)') }}</th>
                <th>{{ __('Remarks') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach($item_category_sub_category_information as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                     @if( hasUserCap(['view_item_category_sub_category_info']))
                        <a href="{{ action('Inventory\ItemCategorySubCategoryInformationController@show', ['id' => $item->id]) }}">
                            {{ $item->name_en }}
                        </a>
                    @else
                        {{ $item->name_en }}
                    @endif
                </td>
                <td>{{ $item->name_bn }}</td>
                <td>{{ $item->remarks }}</td>

                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('Actions') }}
                        </button>
                        @if( hasUserCap(['edit_item_category_sub_category_info','delete_item_category_sub_category_info']) )
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-1">
                            @if( hasUserCap('edit_item_category_sub_category_info') )
                            <a href="{{ action('Inventory\ItemCategorySubCategoryInformationController@edit', ['id' => $item->id]) }}" class="dropdown-item">
                                <i class="icon-pencil7" aria-hidden="true"></i> {{ __('Edit') }}
                            </a>
                            @endif
                            @if( hasUserCap('view_item_category_sub_category_info'))
                                <a href="{{ action('Inventory\ItemCategorySubCategoryInformationController@show', ['id' =>  $item->id]) }}" class="dropdown-item">
                                    <i class="icon-eye8" aria-hidden="true"></i> {{ __('View') }}
                                </a>
                            @endif

                            @if( hasUserCap('delete_item_category_sub_category_info') )
                            <div class="dropdown-divider"></div>

                            <form action="{{ route('item-category-sub-category-information.delete', $item->id) }}" method="POST">
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
                <th>{{ __('Name (English)') }}</th>
                <th>{{ __('Name (Bengali)') }}</th>
                <th>{{ __('Remarks') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </tfoot>
    </table>
</div>

{!! gridFooter($item_category_sub_category_information, $itemsPerPage) !!}


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
