@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_options', 'active')

{{-- display page title --}}
@section('page_title', __('General Settings'))
@section('body_class', 'settings')

{{-- display page header --}}
@section('page_header_icon', 'icon-cog')
@section('page_header', __('General Settings'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
   '#'  => __('Settings'),
	action('Settings\OptionsController@index') => __('General Settings')
];
@endphp

{{-- add necessary styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/select2.min.css') }}">
@endpush

{{-- page content --}}
@section('content')

    <div id="settings-page">

        @include('errors.validation')

        <form action="{{ route('settings.save') }}" method="POST" class="needs-validation" novalidate>

            <nav>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a href="#tab-global" id="tag-trigger-global" aria-controls="Global" aria-selected="true" class="nav-link active" data-toggle="tab">{{ __('Global') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#tab-social" id="tag-trigger-social" aria-controls="Social" aria-selected="false" class="nav-link" data-toggle="tab">{{ __('Social') }}</a>
                    </li>
                </ul>
            </nav>

            <div class="card border-top-0">
                <div class="tab-content card-body">
                    <div role="tabpanel" class="tab-pane fade show active" id="tab-global" aria-labelledby="tag-trigger-global">
                        @include( 'settings.options.options-global' )
                    </div>
                    <!-- /#tab-global -->
                    <div role="tabpanel" class="tab-pane fade" id="tab-social" aria-labelledby="tag-trigger-social">
                        @include( 'settings.options.options-social' )
                    </div>
                    <!-- /#tab-social -->
                </div>
            </div>

            @method('PATCH')
            @csrf

            <br>

            <button type="submit" class="btn btn-primary">
                <i class="icon-floppy-disk mr-1" aria-hidden="true"></i> {{ __('Save') }}
            </button>

        </form>

    </div> <!-- /#settings-page -->

@endsection

{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
@endpush
