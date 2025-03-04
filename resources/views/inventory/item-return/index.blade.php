@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_item_return', 'active')

{{-- display page title --}}
@section('page_title', __('Return Item'))
@section('body_class', 'Return Item list')

{{-- display page header --}}
@section('page_header_icon', 'icon-cart')
@section('page_header', __('Return Item') )
@section('sidebar')
@include('layouts.admin-sidebar-inventory')
@endsection
{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
action('Inventory\ReturnItemController@index') => __('Return Item'),
'#' => __('List')
];
@endphp

@section('breadcrumb_right')
@if( hasUserCap('view_item_receive_from_supplier_information') )
<a class="btn btn-sm btn-primary" href="{{ action('Inventory\ReturnItemController@create') }}">
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

@if( ! $returnItems->isEmpty() || filter_input(INPUT_GET, 'filter') )
@include ('inventory.item-return.search-form')
@endif

@include('errors.validation')

@if(!$returnItems->isEmpty())

<div class="border mb-1">
    <table class="table table-hover table-striped mb-0">
        <thead>
            <tr class="bg-secondary text-white">
                <th>#</th>
                <th>{{ __('Return Date') }}</th>
                <th>{{ __('Remarks') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach($returnItems as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ displayDateTime($item->return_date) }}</td>
                <td>{{ $item->remarks }}</td>

                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('Actions') }}
                        </button>
                        @if( hasUserCap(['edit_item_request_information','delete_item_request_information', 'approve_item_request_information']) )
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-1">
                            @if( hasUserCap('edit_item_request_information') )
                                    <a href="{{ action('Inventory\ReturnItemController@edit', ['id' => $item->id]) }}" class="dropdown-item">
                                        <i class="icon-pencil7" aria-hidden="true"></i> {{ __('Edit') }}
                                    </a>
                            @endif
                            @if( hasUserCap('view_item_request_information'))
                                <a href="{{ action('Inventory\ReturnItemController@show', ['id' =>  $item->id]) }}" class="dropdown-item">
                                    <i class="icon-eye8" aria-hidden="true"></i> {{ __('View') }}
                                </a>
                            @endif

                            @if( hasUserCap('delete_item_request_information') )
                            <div class="dropdown-divider"></div>

                            <form action="{{ route('item-return.delete', $item->id) }}" method="POST">
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
                <th>{{ __('Return Date') }}</th>
                <th>{{ __('Remarks') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </tfoot>
    </table>
</div>

{!! gridFooter($returnItems, $itemsPerPage) !!}


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
