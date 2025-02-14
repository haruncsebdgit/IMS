<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100 no-js">

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
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet" type="text/css">
    @if( 'bn' === app()->getLocale() )
    <link href="{{ asset('css/bengali.css') }}" rel="stylesheet">
    @endif
</head>
<body class="admin-login bg-pattern h-100">
    <div class="d-table w-100 h-100">
        <div class="d-table-cell align-middle">
            <div class="container-fluid" style="max-width: 1000px;">
                <div class="text-right">
                    <div class="dropdown">
                        <a href="#" class="text-dark dropdown-toggle small" role="button" id="language-switcher" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-sphere mr-1" aria-hidden="true"></i>
                            {{ __('Change Language') }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="language-switcher">
                            <a class="dropdown-item {{ 'bn' === app()->getLocale() ? 'active' : '' }}" href="{{ url('/bn/') }}">বাংলা</a>
                            <a class="dropdown-item {{ 'en' === app()->getLocale() ? 'active' : '' }}" href="{{ url('/en/') }}">English</a>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow rounded overflow-hidden">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="" style="padding: 35px">
                                <a href="{{ route('login') }}" class="d-block mb-4">
                                    <img class="site-logo mb-2" src="{{ asset('/images/iu-logo.png') }}" alt="Logo of IU" style="margin-left: 72px; max-height: 95px;">
                                    <h2 class="site-title-mini text-uppercase my-0 font-weight-bold">
                                        {{ __('master.app_name_brief') }}
                                    </h2>
                                    <h3 class="site-title-second mb-0">
                                        {{ __('master.app_dept') }}
                                    </h3>
                                    <h5 class="site-title-second">
                                        {{ __('master.app_unit') }}
                                    </h5>
                                </a>
                                <main class="main">
                                    @yield('content')
                                </main>
                            </div>
                        </div>
                        <div class="col-md-7 d-none d-md-block text-right">
                            <img src="{{ asset('/images/login-bg-2.png') }}" alt="Customery design image for the login page">
                        </div>
                    </div>
                </div>
                <div class="row small mt-2">
                    <div class="col-sm-5 text-center text-sm-left text-white">
                        <p>{{ autoCopyright(2024, __('master.app_name_short')) }}</p>
                    </div>
                    <div class="col-sm-7 text-center text-sm-right text-white">
                        <p>
                            {{ __('Designed & Developed by') }}:
                            <a href="#" target="_blank" rel="noopener" class="text-reset">
                                {{ __('Mohammad Harun-Or-Rashid and Musa Kalimullah') }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        /* <![CDATA[ */
        var app_data = '{!! json_encode(array()) !!}';
        /* ]]> */

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
