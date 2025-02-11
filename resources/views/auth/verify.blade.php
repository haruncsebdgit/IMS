@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <header>
                        <h2 class="text-uppercase text-center h5 mb-4 text-secondary font-weight-bold">{{ __('Verify Your Email Address') }}</h2>
                    </header>
                    <hr>
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <footer class="text-center text-muted small mt-2">
                {{ __('Designed & Developed by') }} <a href="https://technovista.com.bd?ref=lgsp3" class="text-reset" target="_blank" rel="noopener">{{ __('TechnoVista Limited') }}</a>
            </footer>
        </div>
    </div>
</div>
@endsection
