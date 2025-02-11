@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section("admin_menu_users", 'active')
@section("admin_menu_users_list", 'active')

{{-- display page title --}}
@section('page_title', __('User Capabilities'))
@section('body_class', 'user-capabilities')

{{-- display page header --}}
@section('page_header_icon', 'icon-users2')
@section('page_header', __('User Capabilities'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#' => __('Access Management'),
        action('Users\UserController@index') => __('Users'),
        action('Users\UserController@userCapabilities') => __('User Capabilities')
    ];
@endphp

{{-- page content --}}
@section('content')

    @include('errors.validation')

    @php
        $lang = config('app.locale');
        $user_name = "name_$lang";

        $_username   = isset($user) ? $user->$user_name : $user->name_en;
        $_user_email = isset($user) ? $user->email : '';
        $_user_role = '';
        if( false == $userRole ) {
            $_user_role = '&mdash';
        } else {
            $_counter = 1;
            $_data_count = count($userRole);

            foreach ($userRole as $item) {
                $_user_role .= strip_tags($item['label']);
                if($_counter !== $_data_count) $_user_role .= ', ';

                $_counter ++;
            } //endforeach
        } //endif
    @endphp

    <div class="alert alert-warning alert-styled-left small" role="alert">
        {!! __('You are modifying the capabilities for <strong>:user</strong>. <em>These capabilities will get precedence over their role.</em><br> To let them get back their capabilities by role, choose <strong>UnCheck All</strong> and <strong>Save</strong> the changes.', array('user' => $_username)) !!}
    </div>

    <form action="{{ route('capabilities.save') }}" method="POST" id="form-role">

        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="small">{{ __('Name') }}</div>

                        <div class="font-weight-bold">
                            {{ $_username }}
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="small">{{ __('Email') }}</div>

                        <div class="font-weight-bold">
                            {{ $_user_email }}
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="small">{{ __('User Role') }}</div>

                        <div class="font-weight-bold">
                            {{ $_user_role }}
                        </div>
                    </div>

                    <div class="col-sm-3 text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if( getUserMeta($user->id, '_capabilities') )
            <div class="alert alert-info alert-styled-left small" role="alert">
                {{ __('Custom Capabilities enabled over User Role.') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h6>
                    {{ __('User Capabilities') }}
                </h6>

                <div class="heading-elements btn-group">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="check-all">
                        <i class="icon-stack-check mr-1" aria-hidden="true"></i>
                        {{ __('Check All') }}
                    </button>

                    <button type="button" class="btn btn-outline-secondary btn-sm" id="uncheck-all">
                        <i class="icon-stack-empty mr-1" aria-hidden="true"></i>
                        {{ __('Uncheck All') }}
                    </button>
                </div>
            </div>

            <div>
                @php
                    $registeredCapabilities   = \App\Http\Controllers\Users\UserController::allCapabilities();
                    $userCaps                 = false == $userCaps ? [] : $userCaps;
                @endphp

                <nav class="mt-1 p-1">
                    <ul class="nav nav-tabs">
                        <?php $_counter = 0; ?>

                        @foreach( $registeredCapabilities as $module => $data )
                            @if( hasUserCap(array_keys(call_user_func_array('array_merge', array_values($data) ) )) || $userLevel === 'super_admin')
                                <li role="presentation" class="nav-item">
                                    <a href="#{{ Str::slug($module) }}" aria-controls="{{ Str::slug($module) }}" role="tab" data-toggle="tab" class="nav-link {{ $_counter == 0 ? 'active' : ''}}">
                                        {{ $module }}
                                    </a>
                                </li>

                                <?php $_counter++; ?>
                            @endif
                        @endforeach
                    </ul>
                </nav>

                <div class="tab-content">
                    <?php $counter = 0; ?>

                    @foreach( $registeredCapabilities as $module => $data )

                        <div role="tabpanel" class="tab-pane {{ $counter == 0 ? 'active' : ''}}" id="{{ Str::slug($module) }}">

                            <table class="table table-capabilities">

                                @foreach( $data as $block => $caps )
                                    @if( hasUserCap(array_keys($caps)) || $userLevel === 'super_admin')

                                        <thead>

                                        <tr>
                                            <th class="bg-secondary text-white" colspan="2">{{ $block }}</th>
                                        </tr>

                                        </thead>

                                        <tbody>

                                        @foreach( $caps as $capabilitiesKey => $capabilitiesLabel )
                                            @if( hasUserCap($capabilitiesKey) || $userLevel === 'super_admin')
                                                <tr>
                                                    <td class="pl-4">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" id="{{ Str::slug($capabilitiesKey) }}" class="caps-checkboxes child-checkbox custom-control-input" name="capabilities[]" value="{{ $capabilitiesKey }}" {{ in_array($capabilitiesKey, $userCaps) ? 'checked="checked"' : '' }}>
                                                            <label class="custom-control-label" for="{{ Str::slug($capabilitiesKey) }}">{{ $capabilitiesLabel }}</label>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <code>{{ $capabilitiesKey }}</code>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        </tbody>

                                    @endif

                                @endforeach

                            </table>

                        </div>
                        <!-- /.tab-pane -->

                        <?php $counter++; ?>
                    @endforeach
                </div> <!-- /.tab-content -->
            </div>
        </div>

        <input type="hidden" name="user_id" value="{{ isset($user) ? $user->id : '' }}">

        @csrf

    </form>

@endsection
