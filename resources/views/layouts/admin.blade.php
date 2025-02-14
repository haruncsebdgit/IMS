<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token
        ================================================== -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            <?php
            /**
             * ------------------------------------------------------
             * PLACEHOLDER HOOK: page_title
             * ------------------------------------------------------
             *
             * Pass the view page's HTML title from the view page
             * using @section('page_title')
             * ------------------------------------------------------
             */
            ?>
            @yield('page_title')
            @if (View::hasSection('page_title'))
                &bull;
            @endif
            {{ __('master.app_name') }}
        </title>

        <!-- Favicon
        ================================================== -->
        <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

        <!-- Style sheets
        =========================================== -->
        <?php
        /**
         * ------------------------------------------------------
         * PLACEHOLDER HOOK: styles
         * ------------------------------------------------------
         *
         * Pass the view page's additional stylesshets
         * from the view page using @push('styles')
         * ------------------------------------------------------
         */
        ?>
        @stack('styles')
        <link href="{{ asset('css/admin.css') }}" rel="stylesheet" type="text/css">
        @if( 'bn' === app()->getLocale() )
			<link href="{{ asset('css/bengali.css') }}" rel="stylesheet">
		@endif
        <?php
        /**
        * ------------------------------------------------------
        * PLACEHOLDER HOOK: custom_styles
        * ------------------------------------------------------
        *
        * Pass the view page's additional stylesshets
        * from the view page using @push('custom_styles')
        * ------------------------------------------------------
        */
        ?>
        @stack('custom_styles')
    </head>

    <?php $_is_sidebar_mini = getUserMeta( Auth::id(), '_sidebar_mini' ) ? 'sidebar-mini' : ''; ?>

    <?php
    /**
     * ------------------------------------------------------
     * PLACEHOLDER HOOK: body_class
     * ------------------------------------------------------
     *
     * Pass the view page's body CSS class to body tag from
     * the view page using @section('body_class')
     * ------------------------------------------------------
     */
    ?>
    <body class="admin @yield('body_class') {{ $_is_sidebar_mini }}">

        <nav class="navbar navbar-expand-md navbar-dark gray-header">

                <a class="navbar-brand" href="{{ action('Admin\DashboardController@index') }}">
                    <img src="{{ asset('/images/iu-logo.png') }}" alt="Logo of the IU" class="mr-1" width="80" height="80">
                    <span class="mt-1 d-inline-block"><span class="d-none d-sm-block">{{ __('master.app_name') }}</span> <span class="d-block d-sm-none" aria-hidden="true">{{ __('master.app_name_short') }}</span></span>
                </a>

                <div>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#top-nav-collapsible" aria-controls="top-nav-collapsible" aria-expanded="false" aria-label="{{ __('Toggle Top Navigation') }}">
                        <i class="icon-user" aria-hidden="true"></i>
                    </button>
                    <button class="navbar-toggler sidebar-toggle" type="button" aria-expanded="false" aria-label="{{ __('Toggle Sidebar Menu') }}">
                        <i class="icon-three-bars" aria-hidden="true"></i>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="top-nav-collapsible">
                    <!-- Left Side of the Navbar -->

                    <!-- Right Side of the Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item mr-md-2 mb-2 mb-md-0 text-right">
                            <div class="btn-group mt-1 language-btn-group" role="group">
                                <a href="{{ url('/bn/'. config('app.admin_route_prefix')) }}" class="{{ 'bn' === app()->getLocale() ? 'active' : '' }} btn btn-outline-light btn-sm">
                                    বাংলা
                                </a>
                                <a href="{{ url('/en/'. config('app.admin_route_prefix')) }}"  class="{{ 'en' === app()->getLocale() ? 'active' : '' }} btn btn-outline-light btn-sm">
                                    {{ __('English') }}
                                </a>
                            </div>
                        </li>

                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="user-dropdown" class="nav-link dropdown-toggle text-right mt-2 text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if(Auth::user()->user_image)
                                        <img src="{{ url("/storage/uploads/images/" . Auth::user()->user_image) }}" alt="" class="rounded-circle user-image-header" width="35" height="35">
                                    @else
                                        <i class="icon-user mr-1" aria-hidden="true"></i>
                                    @endif

                                    <strong>{{ resolveFieldName(Auth::user()) }}</strong> <i class="icon-arrow-down5" aria-hidden="true"></i><br>
                                    <?php $userRole = getUserRole(Auth::id()); ?>
                                    @if( false !== $userRole )
                                        <small class="mr-4">
                                            {{ $userRole[0]['label'] }}
                                        </small>
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="user-dropdown">

                                    @if( hasUserCap('view_dashboard') )
                                        <a class="dropdown-item @yield('admin_top_edit_profile')" href="{{ action('Users\UserController@editProfile', ['user_id' => Auth::id()]) }}">
                                            <i class="icon-profile mr-1" aria-hidden="true"></i> {{ __('Edit Profile') }}
                                        </a>
                                    @endif

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="icon-switch mr-1" aria-hidden="true"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>

        </nav>

        <div class="body-content">

            @yield('sidebar', view('layouts.admin-sidebar'))

            <main class="main">

                <h3 class="page-header pt-2 pb-2 pl-3 pr-3 mb-0">
                    <?php
                    /**
                     * ------------------------------------------------------
                     * PLACEHOLDER HOOK: page_header_icon
                     * ------------------------------------------------------
                     *
                     * Pass the view page's page header icon from the
                     * view page using @section('page_header_icon')
                     * ------------------------------------------------------
                     */
                    ?>
                    <i class="@yield('page_header_icon') mr-2 float-left border border-secondary rounded-circle p-2 text-center"></i>

                    <?php
                    /**
                     * ------------------------------------------------------
                     * PLACEHOLDER HOOK: page_header
                     * ------------------------------------------------------
                     *
                     * Pass the view page's page header from the
                     * view page using @section('page_header')
                     * ------------------------------------------------------
                     */
                    ?>
                    @yield('page_header')
                </h3>

                <div class="breadcrumb-line container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb pl-0">
                                    @if( ! isset($breadcrumbs) )
                                        <li class="breadcrumb-item active" aria-current="page">
                                            {{ __('Dashboard') }}
                                        </li>
                                    @else
                                        <li class="breadcrumb-item">
                                            <a href="{{ action('Admin\DashboardController@index') }}" rel="bookmark" aria-label="{{ __('Dashboard') }}" title="{{ __('Dashboard') }}" aria-label="{{ __('Dashboard') }}">
                                                <i class="icon-meter2 mr-1" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        @php
                                        $_total_items  = count($breadcrumbs);
                                        $_loop_counter = 1;
                                        @endphp
                                        @foreach( $breadcrumbs as $url => $label )
                                            {{-- Don't make last item linked --}}
                                            @if( $_total_items == $_loop_counter )
                                                <li class="breadcrumb-item active" aria-current="page">
                                                    {{ $label }}
                                                </li>
                                            @elseif( (strpos($url, '#') !== false) || (strpos($url, 'javascript:') !== false) )
                                                <li class="breadcrumb-item active">
                                                    {{ $label }}
                                                </li>
                                            @else
                                                <li class="breadcrumb-item">
                                                    <a href="{{ $url }}" rel="bookmark">
                                                        {{ $label }}
                                                    </a>
                                                </li>
                                            @endif
                                            @php $_loop_counter++; @endphp
                                        @endforeach
                                    @endif
                                </ol>
                            </nav>
                        </div>
                        <div class="col-sm-6 breadcrumb-right">
                            @yield('breadcrumb_right')
                        </div>
                    </div>
                </div>
                <!-- /.breadcrumb-line -->

                <div class="page-content p-3">
                    @yield('content')
                </div>
                <!-- /.page-content -->
            </main>

        </div>
        <!-- /.body-content -->

        <!-- Javascripts
        =========================================== -->
        <?php
        // Passing data into a globally defined array variable.
        $_javascript_data = array_merge($_javascript_data, array(
            'app_url'          => baseUrl(),
            'sidebar_collapse' => __('Collapse Sidebar'),
            'sidebar_expand'   => __('Expand Sidebar'),
            'pin_label'        => __('Pin'),
            'unpin_label'      => __('Unpin'),
            'choose_label'     => __('Choose'),
            'change_label'     => __('Change'),
            'label_select'     => __('Select'),
            'app_locale'       => config('app.locale'),
            'fallback_locale'  => config('app.fallback_locale'),
        ));
        ?>
        <script type="text/javascript">
            /* <![CDATA[ */
                var app_data = '{!! json_encode($_javascript_data) !!}';
            /* ]]> */

            // @Devs:
            // this is done for the repeaters containing textarea input.
            // Fixing a bug with textarea inputs with line breaks.
            //
            // Possible issue: This could impact any non-repeater
            // data inside the app_data.
            var app_data = app_data.replace(new RegExp('\r\n', 'g'), '&#013;');
        </script>
        <script src="{{ asset('js/bootstrap.js') }}"></script>
        <?php
        /**
         * ------------------------------------------------------
         * PLACEHOLDER HOOK: scripts
         * ------------------------------------------------------
         *
         * Pass the view page's additional script files
         * from the view page using @push('scripts')
         * ------------------------------------------------------
         */
        ?>
        @stack('scripts')
        <script src="{{ asset('js/admin.js') }}"></script>
    </body>

</html>
