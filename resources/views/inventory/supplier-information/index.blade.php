@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_setup', 'active')
@section('admin_menu_supplier_info', 'active')

{{-- display page title --}}
@section('page_title', __('Supplier'))
@section('body_class', 'Supplier list')

{{-- display page header --}}
@section('page_header_icon', 'icon-database-export')
@section('page_header', __('Supplier') )

@section('sidebar')
@include('layouts.admin-sidebar-inventory')
@endsection

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
'#' => __('Settings'),
action('Inventory\SupplierController@index') => __('Supplier')
];
@endphp

@section('breadcrumb_right')
@if( hasUserCap('add_supplier_info') )
    <a class="btn btn-sm btn-primary" href="{{ action('Inventory\SupplierController@create') }}">
        <i class="icon-add mr-1" aria-hidden="true"></i> {{ __('Add') }}
    </a>
@endif
@endsection

{{-- page content --}}
@section('content')

@if( ! $supplier_information->isEmpty() || filter_input(INPUT_GET, 'filter') )
@include ('inventory.supplier-information.search-form')
@endif

@include('errors.validation')

@if(!$supplier_information->isEmpty())

<div class="border mb-1">
    <table class="table table-hover table-striped mb-0">
        <thead>
            <tr class="bg-secondary text-white">
                <th>#</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Email') }}</th>
                <th>{{ __('Address') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach($supplier_information as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if( hasUserCap(['view_supplier_info']))
                        <a href="{{ action('Inventory\SupplierController@show', ['id' => $item->id]) }}">
                            {{ $item->name_en }}
                        </a>
                    @else
                        {{ $item->name_en }}
                    @endif
                </td>
                <td>
                {{ $item->email }}
                </td>
                <td>{{ $item->address }}</td>

                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('Actions') }}
                        </button>
                        @if( hasUserCap(['edit_supplier_info','delete_supplier_info', 'view_supplier_info']) )
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-1">
                            @if( hasUserCap('edit_supplier_info') )
                            <a href="{{ action('Inventory\SupplierController@edit', ['id' => $item->id]) }}" class="dropdown-item">
                                <i class="icon-pencil7" aria-hidden="true"></i> {{ __('Edit') }}
                            </a>
                            @endif

                            @if( hasUserCap('view_supplier_info') )
                            <a href="{{ action('Inventory\SupplierController@show', ['id' =>  $item->id]) }}" class="dropdown-item">
                                <i class="icon-eye8" aria-hidden="true"></i> {{ __('View') }}
                            </a>
                            @endif

                            @if( hasUserCap('delete_supplier_info') )
                            <div class="dropdown-divider"></div>

                            <form action="{{ route('supplier-information.delete', $item->id) }}" method="POST">
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
                <th>{{ __('Email') }}</th>
                <th>{{ __('Address') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </tfoot>
    </table>
</div>

{!! gridFooter($supplier_information, $itemsPerPage) !!}


@else

<div class="alert alert-info alert-styled-left" role="alert">
    {{ __('Sorry! No data found to display') }}
</div>

@endif

@endsection
