@extends('layouts.admin')

@section('admin_menu_item_return', 'active')

{{-- display page title --}}
@section('page_title', __('Return Item') )

@section('body_class', 'dashboard view')

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
    '#' => __('View')
];
@endphp
@section('breadcrumb_right')
     @if( hasUserCap('edit_item_receive_from_supplier_information'))
        <a href="{{ action('Inventory\ReturnItemController@edit', ['id' => $requestedItem->id]) }}" class="btn btn-sm btn-outline-primary">
            <i class="icon-pencil7 mr-1" aria-hidden="true"></i> {{ __('Edit') }}
        </a>
     @endif
     @if( hasUserCap(['view_item_receive_from_supplier_information']))
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Inventory\ReturnItemController@index') }}">
            <i class="icon-list-unordered"></i> {{ __('List') }}
        </a>
     @endif
@endsection
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/jquery.fancybox.min.css') }}">
@endpush
@section('content')

    <div class="card">
        <div class="card-header bg-primary text-white">

            <div class="pt-1 font-we">
                {{ __('Item Information') }}
            </div>
        </div>
        <div class="card-body">
            @include('errors.validation')
            @include ('inventory.item-return.view')
        </div>
    </div>

@endsection
@push('scripts')
    <script src="{{ asset('js/libs/jquery.fancybox.min.js') }}"></script>
@endpush
