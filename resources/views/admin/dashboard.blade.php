@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_nav_dashboard', 'active')

{{-- display page title --}}
@section('page_title', __('Dashboard'))

@section('body_class', 'dashboard')

{{-- display page header --}}
@section('page_header_icon', 'icon-meter2')
@section('page_header', __('Dashboard'))

{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/libs/jquery.matchHeight-min.js') }}"></script>
@endpush


{{-- page content --}}
@section('content')
    @php
    $widgets = array(
        array(
            'icon'       => 'icon-cube4',
            'label'      => __('Inventory'),
            'desc'       => __('Management of the Inventories'),
            'link'       => action('Admin\DashboardController@showInventoryModule'),
            'bg_color'   => '#00a8ee',
            'icon_color' => '#0b80b0',
        ),
        array(
            'icon'       => 'icon-users2',
            'label'      => __('User Management'),
            'desc'       => __('Role based Access Control'),
            'link'       => action('Users\UserController@index'),
            'bg_color'   => '#81c35c',
            'icon_color' => '#589436',
        ),
    );
    @endphp

    <div class="row mb-3">
        @foreach ($widgets as $widget)
            <div class="col-md-4 col-sm-6">
                <a href="{{ $widget['link'] }}" class="card card-dashboard mb-3 position-relative text-center text-white text-decoration-none match-height" style="background-color: {{ $widget['bg_color'] }};">
                    <div class="card-body">
                        <div class="dash-icon-holder position-absolute"  style="background-color: {{ $widget['icon_color'] }}">
                            <i class="dash-icon {{ $widget['icon'] }}" aria-hidden="true"></i>
                        </div>
                        <h3 class="mt-4 font-weight-bold">{{ $widget['label'] }}</h3>
                        <p>{{ $widget['desc'] }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

@endsection
