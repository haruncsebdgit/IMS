<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
            {{ __('RÉTAILO') }}
        </title>

        <!-- Favicon
        ================================================== -->
        <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">

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
        <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    </head>

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
    <body class="auth login @yield('body_class')">

        <main class="main container-fluid h-100">
            @yield('content')
        </main>

        <!-- Javascripts
        =========================================== -->
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
