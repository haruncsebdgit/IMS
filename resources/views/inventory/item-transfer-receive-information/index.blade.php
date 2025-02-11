@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_item_transfer_receive_info', 'active')

{{-- display page title --}}
@section('page_title', __('Item Transfer Receive Information'))
@section('body_class', 'Item Transfer Receive Information list')

{{-- display page header --}}
@section('page_header_icon', 'icon-cloud-upload')
@section('page_header', __('Item Transfer Receive Information') )
@section('sidebar')
@include('layouts.admin-sidebar-inventory')
@endsection
{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
action('Inventory\ItemTransferReceiveInformationController@index') => __('Item Transfer Receive Information'),
'#' => __('List')
];
@endphp

@section('breadcrumb_right')
@if( hasUserCap('view_item_transfer_receive_information') )
<a class="btn btn-sm btn-primary" href="{{ action('Inventory\ItemTransferReceiveInformationController@create') }}">
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

@if( ! $item_transfer_receive_information->isEmpty() || filter_input(INPUT_GET, 'filter') )
@include ('inventory.item-transfer-receive-information.search-form')
@endif

@include('errors.validation')

@if(!$item_transfer_receive_information->isEmpty())

<div class="border mb-1">
    <table class="table table-hover table-striped mb-0">
        <thead>
            <tr class="bg-secondary text-white">
                <th>#</th>
                <th>{{ __('Transfer Id') }}</th>
                <th>{{ __('Transfer Date') }}</th>
                <th>{{ __('Inventory Center From') }}</th>
                <th>{{ __('Inventory Center to') }}</th>
                <th>{{ __('Transfer By') }}</th>
                <th>{{ __('Remarks') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach($item_transfer_receive_information as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                     @if( hasUserCap(['view_transfer_information']))
                        <a href="{{ action('Inventory\ItemTransferReceiveInformationController@show', ['id' => $item->id]) }}">
                            {{ $item->id }}
                        </a>
                    @else
                        {{ $item->id }}
                    @endif
                </td>
                <td>{{ displayDateTime($item->transfer_date) }}</td>
                <td>{{ $item->inventory_name_from }}</td>
                <td>{{ $item->inventory_name_to }}</td>
                <td>{{ $item->created_by }}</td>
                <td>{{ $item->transfer_receive_remarks }}</td>

                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('Actions') }}
                        </button>
                        @if( hasUserCap(['edit_item_transfer_receive_information','delete_item_transfer_receive_information']) )
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-1">
                            @if( hasUserCap('edit_item_transfer_receive_information') )
                            <a href="{{ action('Inventory\ItemTransferReceiveInformationController@edit', ['id' => $item->id]) }}" class="dropdown-item">
                                <i class="icon-pencil7" aria-hidden="true"></i> {{ __('Edit') }}
                            </a>
                            @endif
                            @if( hasUserCap('view_item_transfer_receive_information'))
                                <a href="{{ action('Inventory\ItemTransferReceiveInformationController@show', ['id' =>  $item->id]) }}" class="dropdown-item">
                                    <i class="icon-eye8" aria-hidden="true"></i> {{ __('View') }}
                                </a>
                            @endif

                            @if( hasUserCap('delete_item_transfer_receive_information') )
                            <div class="dropdown-divider"></div>

                            <form action="{{ route('item-transfer-receive-information.delete', $item->id) }}" method="POST">
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
                <th>{{ __('Transfer Id') }}</th>
                <th>{{ __('Transfer Date') }}</th>
                <th>{{ __('Inventory Center From') }}</th>
                <th>{{ __('Inventory Center to') }}</th>
                <th>{{ __('Transfer By') }}</th>
                <th>{{ __('Remarks') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </tfoot>
    </table>
</div>

{!! gridFooter($item_transfer_receive_information, $itemsPerPage) !!}


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