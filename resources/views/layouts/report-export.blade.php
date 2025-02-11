<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

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

        <!-- Style sheets
        =========================================== -->
        <?php
        /**
         * KNOWN ISSUE:
         * niklasravnsborg/laravel-pdf DOESN'T SUPPORT EXTERNAL CSS.
         * Hence, Internal CSS is applied.
         *
         * See: https://github.com/niklasravnsborg/laravel-pdf/issues/59
         */
        ?>
        @if('pdf' === $mode)

            @include('layouts.report--pdf-styles')

        @else

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

        @endif

    </head>

    <body onload="javascript:window.print()">

        <div class="container">
            @include('layouts.report--head')

            @yield('report_content')

            <div class="small text-muted mt-5 text-center">
                @yield('report_footer', __('Report Prepared at: :date', ['date' => translateString(date('d F Y | h:i:s a'))]))
            </div>
        </div>

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

    </body>

</html>
