@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_item_return_on_support_info', 'active')

{{-- display page title --}}
@section('page_title', __('Item Return On Support Information'))
@section('body_class', 'Item Return On Support Information list')

{{-- display page header --}}
@section('page_header_icon', 'icon-vimeo2')
@section('page_header', __('Item Return On Support Information') )
@section('sidebar')
@include('layouts.admin-sidebar-inventory')
@endsection
{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
action('Inventory\ItemReturnOnSupportController@index') => __('Item Return On Support Information'),
'#' => __('List')
];
@endphp

@section('breadcrumb_right')
@if( hasUserCap('view_item_return_on_support_info') )
<a class="btn btn-sm btn-primary" href="{{ action('Inventory\ItemReturnOnSupportController@create') }}">
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

@if( ! $item_return_on_support->isEmpty() || filter_input(INPUT_GET, 'filter') )
@include ('inventory.item-return-on-support.search-form')
@endif

@include('errors.validation')

@if(!$item_return_on_support->isEmpty())

<div class="border mb-1">
    <table class="table table-hover table-striped mb-0">
        <thead>
            <tr class="bg-secondary text-white">
                <th>#</th>
                <th>{{ __('Id') }}</th>
                <th>{{ __('Date') }}</th>
                <th>{{ __('Inventory Center') }}</th>
                <th>{{ __('Supplier') }}</th>
                <th>{{ __('Transaction By') }}</th>
                <th>{{ __('Remarks') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach($item_return_on_support as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                     @if( hasUserCap(['view_item_return_on_support_info']))
                        <a href="{{ action('Inventory\ItemReturnOnSupportController@show', ['id' => $item->id]) }}">
                            {{ $item->id }}
                        </a>
                    @else
                        {{ $item->id }}
                    @endif
                </td>
                <td>{{ displayDateTime($item->date) }}</td>
                <td>{{ $item->inventory_name }}</td>
                <td>{{ $item->supplier }}</td>
                <td>{{ $item->user_name }}</td>
                <td>{{ $item->return_remarks }}</td>

                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('Actions') }}
                        </button>
                        @if( hasUserCap(['edit_item_return_on_support_info','delete_item_return_on_support_info']) )
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-1">
                            @if( hasUserCap('edit_item_return_on_support_info') )
                            <a href="{{ action('Inventory\ItemReturnOnSupportController@edit', ['id' => $item->id]) }}" class="dropdown-item">
                                <i class="icon-pencil7" aria-hidden="true"></i> {{ __('Edit') }}
                            </a>
                            @endif
                            @if( hasUserCap('view_item_return_on_support_info'))
                                <a href="{{ action('Inventory\ItemReturnOnSupportController@show', ['id' =>  $item->id]) }}" class="dropdown-item">
                                    <i class="icon-eye8" aria-hidden="true"></i> {{ __('View') }}
                                </a>
                            @endif

                            @if( hasUserCap('delete_item_return_on_support_info') )
                            <div class="dropdown-divider"></div>

                            <form action="{{ route('item-return-on-support.delete', $item->id) }}" method="POST">
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
                <th>{{ __('Id') }}</th>
                <th>{{ __('Date') }}</th>
                <th>{{ __('Inventory Center') }}</th>
                <th>{{ __('Supplier') }}</th>
                <th>{{ __('Transaction By') }}</th>
                <th>{{ __('Remarks') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </tfoot>
    </table>
</div>

{!! gridFooter($item_return_on_support, $itemsPerPage) !!}


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