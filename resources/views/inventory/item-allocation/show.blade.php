@extends('layouts.admin')

@section('admin_menu_item_allocation', 'active')

{{-- display page title --}}
@section('page_title', __('Item Allocation') )

@section('body_class', 'dashboard view')

{{-- display page header --}}
@section('page_header_icon', 'icon-cart')
@if(isset($type))
@section('page_header', $type . __(' Item') )
@else
@section('page_header', __('Item Allocation') )
@endif
@section('sidebar')
@include('layouts.admin-sidebar-inventory')
@endsection
{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
action('Inventory\ItemAllocationController@index') => __('Item Allocation'),
'#' => __('View')
];
@endphp
@section('breadcrumb_right')
@if( hasUserCap('edit_item_request_information') )
<a href="{{ action('Inventory\ItemAllocationController@edit', ['id' => $itemAllocation->id]) }}" class="btn btn-sm btn-outline-primary">
    <i class="icon-pencil7 mr-1" aria-hidden="true"></i> {{ __('Edit') }}
</a>
@endif
@if( hasUserCap(['view_item_request_information']))
<a class="btn btn-sm btn-outline-primary" href="{{ action('Inventory\ItemAllocationController@index') }}">
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
        @include ('inventory.item-allocation.view')
    </div>
</div>
<section class="card mt-3">
    <div class="card-body border border-0 small">
        <div class="row">
            <div class="col-sm-3">
                {{ __("Created by") }}

                <div class="text-muted">
                    {{ ($itemAllocation->created_by) ? getUserNameById($itemAllocation->created_by) : '-'}}
                </div>
            </div>

            <div class="col-sm-3">
                {{ __("Created at") }}

                <div class="text-muted">
                    {!! displayDateTime($itemAllocation->created_at, 'd F Y h:i A') !!}
                </div>
            </div>

            <div class="col-sm-3">
                {{ __("Updated by") }}

                <div class="text-muted">
                    {{ ($itemAllocation->updated_by) ? getUserNameById($itemAllocation->updated_by) : '-' }}
                </div>
            </div>

            <div class="col-sm-3">
                {{ __("Updated at") }}

                <div class="text-muted">
                    {!! displayDateTime($itemAllocation->updated_at, 'd F Y h:i A') !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
