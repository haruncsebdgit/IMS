@extends('layouts.admin')

@section('admin_menu_item_transfer_receive_info', 'active')

{{-- display page title --}}
@section('page_title', __('Item Transfer Receive Information') )

@section('body_class', 'dashboard view')

{{-- display page header --}}
@section('page_header_icon', 'icon-transmission')
@section('page_header', __('Item Transfer Receive Information') )
@section('sidebar')
    @include('layouts.admin-sidebar-inventory')
@endsection
{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
    action('Inventory\ItemTransferReceiveInformationController@index') => __('Item Transfer Receive Information'),
    '#' => __('View')
];
@endphp
@section('breadcrumb_right')
     @if( hasUserCap('edit_item_transfer_receive_information')) 
        <a href="{{ action('Inventory\ItemTransferReceiveInformationController@edit', ['id' => $item_transfer_receive_information->id]) }}" class="btn btn-sm btn-outline-primary">
            <i class="icon-pencil7 mr-1" aria-hidden="true"></i> {{ __('Edit') }}
        </a>
     @endif 
     @if( hasUserCap(['edit_item_transfer_receive_information'])) 
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Inventory\ItemTransferReceiveInformationController@index') }}">
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

            {{-- <a href="{{ action('Inventory\ItemTransferReceiveInformationController@show', [$item_transfer_receive_information->id, "print"]) }}" target="_blank" class="float-right btn btn-sm border border-white text-white">
                <i class="icon-printer2 mr-1" aria-hidden="true"></i>
                {{ __('Print') }}
            </a> --}}
            <div class="pt-1 font-we">
                {{ __('Item Information') }}
            </div>
        </div>
        <div class="card-body">
            @include ('inventory.item-transfer-receive-information.view')
        </div>
    </div>

@endsection
@push('scripts')
    <script src="{{ asset('js/libs/jquery.fancybox.min.js') }}"></script>
@endpush