@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_item_request', 'active')

{{-- display page title --}}
@section('page_title', __('Request Item'))
@section('body_class', 'Request Item list')

{{-- display page header --}}
@section('page_header_icon', 'icon-cart')
@section('page_header', __('Request Item') )
@section('sidebar')
@include('layouts.admin-sidebar-inventory')
@endsection
{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
action('Inventory\RequestItemController@index') => __('Request Item'),
'#' => __('List')
];
@endphp

@section('breadcrumb_right')
@if( hasUserCap('add_item_request_information') )
<a class="btn btn-sm btn-primary" href="{{ action('Inventory\RequestItemController@create') }}">
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

@if( ! $item_receive_from_supplier_information->isEmpty() || filter_input(INPUT_GET, 'filter') )
@include ('inventory.item-request.search-form')
@endif

@include('errors.validation')

@if(!$item_receive_from_supplier_information->isEmpty())

<div class="border mb-1">
    <table class="table table-hover table-striped mb-0">
        <thead>
            <tr class="bg-secondary text-white">
                <th>#</th>
                <th>{{ __('Request Date') }}</th>
                <th>{{ __('Approved Date') }}</th>
                <th>{{ __('Received Date') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach($item_receive_from_supplier_information as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ displayDateTime($item->requested_date) }}</td>
                <td>{{ displayDateTime($item->approved_date) }}</td>
                <td>{{ displayDateTime($item->received_date) }}</td>

                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('Actions') }}
                        </button>
                        @if( hasUserCap(['edit_item_request_information','delete_item_request_information', 'approve_item_request_information']) )
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-1">
                            @if( hasUserCap('edit_item_request_information') )
                                @if($item->is_approved == 0)
                                    <a href="{{ action('Inventory\RequestItemController@edit', ['id' => $item->id]) }}" class="dropdown-item">
                                        <i class="icon-pencil7" aria-hidden="true"></i> {{ __('Edit') }}
                                    </a>
                                @endif
                            @endif
                            @if( hasUserCap('view_item_request_information'))
                                <a href="{{ action('Inventory\RequestItemController@show', ['id' =>  $item->id]) }}" class="dropdown-item">
                                    <i class="icon-eye8" aria-hidden="true"></i> {{ __('View') }}
                                </a>
                            @endif

                            @if( hasUserCap('approve_item_request_information'))
                                @if($item->is_approved == 0)
                                    <a href="{{ action('Inventory\RequestItemController@approveItem', ['id' =>  $item->id]) }}" class="dropdown-item">
                                        <i class="icon-checkmark4" aria-hidden="true"></i> {{ __('Approve') }}
                                    </a>
                                @endif
                            @endif

                            @if( hasUserCap('view_item_request_information'))
                                @if($item->is_received == 0 && $item->is_approved == 1)
                                    <a href="{{ action('Inventory\RequestItemController@createReceive', ['id' =>  $item->id]) }}" class="dropdown-item">
                                        <i class="icon-select2" aria-hidden="true"></i> {{ __('Receive') }}
                                    </a>
                                @endif
                            @endif

                            @if( hasUserCap('delete_item_request_information') )
                            <div class="dropdown-divider"></div>

                            <form action="{{ route('item-request.delete', $item->id) }}" method="POST">
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
                <th>{{ __('Request Date') }}</th>
                <th>{{ __('Approved Date') }}</th>
                <th>{{ __('Received Date') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </tfoot>
    </table>
</div>

{!! gridFooter($item_receive_from_supplier_information, $itemsPerPage) !!}


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
