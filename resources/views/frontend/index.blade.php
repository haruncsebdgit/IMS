@extends('layouts.frontend')

{{-- display page title --}}
@section('page_title', __('Home'))
@section('body_class', 'home h-100')

{{-- display breadcrumbs --}}
{{-- @php
$breadcrumbs =
[
    action('Settings\OptionsController@index') => __('Main Page')
    action('Settings\OptionsController@index') => __('Child Page')
];
@endphp --}}

{{-- add necessary styles --}}
{{-- @push('styles')
    <link rel="stylesheet" href="{{ asset('css/libs/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/libs/owl-carousel/owl.theme.default.min.css') }}">
@endpush --}}

{{-- page content --}}
@section('content')

    <div class="text-center py-5">
        <h1>WELCOME TO HOME PAGE</h1>
        <a href="{{ rtrim( baseURL(), '/\\' ) . config('app.admin_route_prefix') }}" class="btn btn-primary">Get to the Dashboard</a>
    </div>

@endsection

{{-- add necessary scripts --}}
{{-- @push('scripts')
    <script src="{{ asset('js/libs/owl.carousel.min.js') }}"></script>
@endpush --}}
