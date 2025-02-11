@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section("admin_menu_settings", 'active')
@section("admin_menu_settings_common_labels", 'active')
@section("admin_menu_settings_common_labels_edit", 'active')

{{-- display page title --}}
@section('page_title', __('Edit Common Label'))
@section('body_class', "common-labels edit")

{{-- display page header --}}
@section('page_header_icon', "icon-clipboard3")
@section('page_header', __('Edit Common Label'))

{{-- submit button label --}}
@section('common_label_form_submit_btn', __('Update'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#' => __('Settings'),
        action('Settings\CommonLabelController@index') => __('Common Labels'),
        action('Settings\CommonLabelController@edit', ['id' => $the_common_label->id])  => __('Edit')
    ];
@endphp

@section('breadcrumb_right')

    @if( hasUserCap(['view_common_labels','edit_common_labels','delete_common_labels']) )
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Settings\CommonLabelController@index') }}">
            <i class="icon-clipboard3 mr-1" aria-hidden="true"></i> {{ __('Common Labels') }}
        </a>

        @if($the_common_label->data_type)
            <a class="btn btn-sm btn-primary" href="{{ action('Settings\CommonLabelController@index', ['current_data_type' => $the_common_label->data_type]) }}">
                <i class="icon-list-unordered mr-1"></i> {{ __('Back to List') }}
            </a>
        @endif
    @endif

@endsection

{{-- page content --}}
@section('content')

    <form action="{{ route('commonlabels.update') }}" method="POST" class="needs-validation" novalidate>

        @if($the_common_label->data_type)
            <h4 class="border-bottom border-primary h5 font-weight-bold text-primary pb-1">{{ $dataTypes[$the_common_label->data_type] }}</h4>
        @endif

        @include('settings/common-labels/form')

        <input type="hidden" name="id" value="{{ $the_common_label->id }}">
        @method('PUT')

    </form>

@endsection
