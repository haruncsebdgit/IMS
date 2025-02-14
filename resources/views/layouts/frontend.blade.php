<!DOCTYPE html>
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="{{ app()->getLocale() }}"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="{{ app()->getLocale() }}"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" lang="{{ app()->getLocale() }}"> <!--<![endif]-->

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token
		================================================== -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Meta tags | SEO
		=========================================== -->
		<meta name="description" content="@if (View::hasSection('meta_description')) @yield('meta_description') @else {{ __('master.app_description') }} @endif">
		<meta name="author" content="{{ __('master.app_author') }}">

		<!-- Meta tags | Social Sharing
		=========================================== -->
		<!-- Facebook compliant meta tags -->
        <meta property="og:image" content="{{ asset('images/cover-image.jpg') }}" />
        <meta property="og:type" content="website">
		<meta property="og:title" content="@yield('page_title') @if (View::hasSection('page_title')) &bull; @endif {{ __('master.app_name') }}">
		<meta property="og:description" content="{{ __('master.app_description') }}">
		<meta property="og:site_name" content="{{ __('master.app_name') }}">
		<meta property="og:locale" content="{{ app()->getLocale() }}">

		<!-- Twitter card meta tags -->
		<meta name="twitter:card" content="summary">
		<meta name="twitter:title" content="@yield('page_title') @if (View::hasSection('page_title')) &bull; @endif {{ __('master.app_name') }}">
		<meta name="twitter:description" content="@if (View::hasSection('meta_description')) @yield('meta_description') @else {{ __('master.app_description') }} @endif">
		<meta name="twitter:image" content="{{ asset('images/cover-image.jpg') }}">

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
		<link href="{{ asset('css/frontend.css') }}" rel="stylesheet">
		@if( 'bn' === app()->getLocale() )
			<link href="{{ asset('css/bengali.css') }}" rel="stylesheet">
        @endif
        @if( 'bn' === app()->getLocale() )
            <link href="https://fonts.googleapis.com/css2?family=Baloo+Da+2:wght@800&display=swap" rel="stylesheet">
            <style>
                .heading-font {
                    font-family: 'Baloo Da 2', cursive;
                }
                body {
                    font-family: "Siyam Rupali ANSI", "Siyam Rupali", "Solaimanlipi", Vrinda, sans-serif;
                }
            </style>
        @else
            <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&display=swap" rel="stylesheet">
            <style>
                .heading-font {
                    font-family: 'Merriweather', serif;
                }
            </style>
        @endif
		<style>
			@media print{
				a[href]:after {
					content: none !important;
				}

				.equal-height{
					height: auto !important;
				}
			}
		</style>

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
	<body class="frontend @yield('body_class')">

		<!--[if lt IE 8]>
	        <p class="browserupgrade">You are using an <strong>outdated</strong> browser.<br>Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	    <![endif]-->

	    <a class="sr-only sr-only-focusable" href="#content">
			Skip to content
		</a>

        <main id="content" class="position-relative">
            <div id="hero">

                <div id="top-bar">
                    <div class="container-fluid">
                        <div class="row text-light text-center small">
                            <div class="col-sm-6 py-1 text-sm-left">
                                {!! __('Government of the People&rsquo;s Republic of Bangladesh') !!}
                            </div>

                            <div class="col-sm-6 py-1 text-sm-right">

                                    <a href="{{URL::to('/images/lgsp-go.apk')}}"  download="lgsp-go.apk"
                                       class="text-reset mr-2" target="_blank" data-toggle="tooltip" title="{{ __('NATP-2 মোবাইল অ্যাপ্লিকেশনটি ডাউনলোড করুন') }}">
                                        <img alt="Play Store" src="{{URL::to('/images/google-play-store-icon.png')}}" width="16" class="mr-1">
                                        @if('en' === app()->getLocale())
                                            {{ __('NATP-2') }}
                                        @else
                                            {{ __('এনএটিপি-২') }}
                                        @endif
                                    </a>

                                    @if('en' === app()->getLocale())
                                    <a href="{{ url('/bn/'. config('app.admin_route_prefix')) }}" class="text-reset"><i class="icon-reload-alt mr-1" aria-hidden="true"></i> বাংলা</a>
                                    @else
                                    <a href="{{ url('/en/'. config('app.admin_route_prefix')) }}"  class="text-reset"><i class="icon-reload-alt mr-1" aria-hidden="true"></i> {{ __('English') }}</a>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /#top-bar -->

                <header class="site-header text-white position-relative">
                    <nav class="navbar navbar-expand-lg navbar-dark">
                        <a href="{{ action('FrontEnd\DashboardController@index') }}" class="text-white navbar-brand" rel="home">
                            <img src="{{ asset('/images/bdgovtlogo.png') }}" alt="Logo of the PRB" class="mr-2 float-left" width="60" height="60">
                            <div class="d-inline-block mt-1">
                                <h1 class="site-title h5 mb-0 font-weight-bold">
                                    <span class="d-none d-sm-block">{{ __('master.app_name') }}</span> <span class="d-block d-sm-none" aria-hidden="true">{{ __('master.app_name_short') }}</span>
                                </h1>
                                <h2 class="site-subtitle h6 my-0 text-light">{{ __('master.app_author') }}</h2>
                            </div>
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="main-navbar">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{ action('FrontEnd\DashboardController@index') }}">
                                        <i class="icon-home4 mr-1" aria-hidden="true"></i> {{ __('Home') }} <span class="sr-only">(current)</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="http://natp2pmu.gov.bd/ target="_blank" rel="noopener">
                                        <i class="icon-sphere mr-1" aria-hidden="true"></i> {{ __('Website') }}<sup class="icon-new-tab2 mt-n3" aria-hidden="true"></sup>
                                    </a>
                                </li>
                                @guest
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">
                                            <i class="icon-enter2 mr-1" aria-hidden="true"></i> {{ __('Login') }}
                                        </a>
                                    </li>
                                @else
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <strong>{{ resolveFieldName(Auth::user()) }}</strong>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="user-dropdown">
                                            @if( hasUserCap('view_dashboard') )
                                                <a class="dropdown-item" href="{{ action('Admin\DashboardController@index') }}">
                                                    <i class="icon-meter2 mr-1" aria-hidden="true"></i> {{ __('Admin Panel') }}
                                                </a>
                                                <div class="dropdown-divider"></div>
                                            @endif
                                            <a class="dropdown-item text-danger" role="button" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
                </header>

            <div class="head-section pt-2 text-white mb-2">
                <h4 class="h6 text-center text-uppercase mt-4 text-light">{{ __('Project Dashboard') }}</h4>
                <h3 class="h1 dash-headings font-weight-bold text-center heading-font heading-with-separator text-uppercase mb-3">
                    @yield('dashboard_title')
                </h3>
            </div>
        </div>
        <!-- /#hero -->

            <?php
            /**
             * ------------------------------------------------------
             * PLACEHOLDER HOOK: content
             * ------------------------------------------------------
             *
             * Pass the view page's main content from the
             * view page using @section('content')
             * ------------------------------------------------------
             */
            ?>
            @yield('content')

        </main>
        <!-- /#content -->

        <div class="py-4 mb-n1" aria-hidden="true"></div>
        <footer class="site-footer text-white">
            <div class="p-4">
                <div class="row text-center">
                    <div class="col-sm-6 text-sm-left small mb-4 mb-sm-0">
                        <img src="{{ asset('/images/bdgovtlogo.png') }}" alt="Logo of the PRB" class="mr-2 float-sm-left" width="30" height="30">
                        <h3 class="font-weight-bold pt-1 h5 mb-0">
                            {{ __('master.app_name_short') }}
                        </h3>
                    </div>
                    <div class="col-sm-6 text-sm-right small mb-4 mb-sm-0 pt-sm-1">
                        &copy; {{ date('Y') }} {{ __('master.app_name') }}, {{ __('master.app_author') }}
                    </div>
                </div>
            </div>
            <div class="text-center small p-2 text-light footer-dark">
                {{ __('Designed & Developed by') }} <a href="#" class="text-reset font-weight-bold" target="_blank" rel="noopener">{{ __('Mohammad Harun-Or-Rashid and Musa Kalimullah') }}</a>
            </div>
        </footer>

		<!-- Javascripts
        =========================================== -->
        <?php
        // Passing data into a globally defined array variable.
        $_javascript_data = array_merge($_javascript_data, array(
            'app_url'          => baseUrl(),
            'asset_url'        => asset('/'),
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
		<script src="{{ asset('js/vendor-frontend.js') }}"></script>
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
		<script src="{{ asset('js/frontend.js') }}"></script>
	</body>

</html>
