@extends('layouts.admin')

@section('admin_menu_item_request', 'active')

{{-- display page title --}}
@section('page_title', __('Request Item') )

@section('body_class', 'dashboard view')

{{-- display page header --}}
@section('page_header_icon', 'icon-cart')
@if(isset($type))
@section('page_header', $type . __(' Item') )
@else
@section('page_header', __('Request Item') )
@endif
@section('sidebar')
@include('layouts.admin-sidebar-inventory')
@endsection
{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
action('Inventory\RequestItemController@index') => __('Request Item'),
'#' => __('View')
];
@endphp
@section('breadcrumb_right')
@if( hasUserCap('edit_item_request_information') && $requestedItem->is_approved == 0)
<a href="{{ action('Inventory\RequestItemController@edit', ['id' => $requestedItem->id]) }}" class="btn btn-sm btn-outline-primary">
    <i class="icon-pencil7 mr-1" aria-hidden="true"></i> {{ __('Edit') }}
</a>
@endif
@if( hasUserCap(['view_item_request_information']))
<a class="btn btn-sm btn-outline-primary" href="{{ action('Inventory\RequestItemController@index') }}">
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

        {!! Form::model($requestedItem, ['route' => ['request-item.approve', $requestedItem->id],'method'=>'put', 'class' => 'needs-validation', 'novalidate']) !!}
        @include ('inventory.item-request.view')
        @include ('inventory.item-request.approval-history')
        <div class="text-center">
            @if(isset($type))
                @if($type === 'Approve')
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-4 text-right">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-secondary active">
                                    <input type="radio" name="approve_type" id="approve" value="approved" autocomplete="off" checked> {{ __('Approve') }}
                                </label>
                                <label class="btn btn-outline-secondary">
                                    <input type="radio" name="approve_type" id="forward" value="forwarded" autocomplete="off"> {{ __('Forward') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3 text-left">
                            <div class="form-group">
                                {!! Form::select('forwarded_user_id', $userLists, null, ['class'=>'form-control enable-select2 user' ,'placeholder' => __('Select User') ]) !!}
                            </div>
                        </div>
                        <div class="col-sm-4 text-left">
                            <div class="form-group">
                                {!! Form::text('comments', null, ['class'=>'form-control' ,'placeholder' => __('Write comments') ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary" name="status" value='{{ $type }}'>
                            <i class="icon-checkmark4 mr-1" aria-hidden="true"></i>
                            {{ __('Submit') }}
                        </button>
                    </div>
                @else
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary" name="status" value='{{ $type }}'>
                            <i class="icon-checkmark4 mr-1" aria-hidden="true"></i>
                            {{ $type }}
                        </button>
                    </div>
                @endif
            @endif
        </div>
        {!! Form::close() !!}
    </div>
</div>
<section class="card mt-3">
    <div class="card-body border border-0 small">
        <div class="row">
            <div class="col-sm-3">
                {{ __("Created by") }}

                <div class="text-muted">
                    {{ ($requestedItem->requested_by) ? getUserNameById($requestedItem->requested_by) : '-'}}
                </div>
            </div>

            <div class="col-sm-3">
                {{ __("Created at") }}

                <div class="text-muted">
                    {!! displayDateTime($requestedItem->created_at, 'd F Y h:i A') !!}
                </div>
            </div>

            <div class="col-sm-3">
                {{ __("Updated by") }}

                <div class="text-muted">
                    {{ ($requestedItem->updated_by) ? getUserNameById($requestedItem->updated_by) : '-' }}
                </div>
            </div>

            <div class="col-sm-3">
                {{ __("Updated at") }}

                <div class="text-muted">
                    {!! displayDateTime($requestedItem->updated_at, 'd F Y h:i A') !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script src="{{ asset('js/libs/jquery.fancybox.min.js') }}"></script>
@endpush
