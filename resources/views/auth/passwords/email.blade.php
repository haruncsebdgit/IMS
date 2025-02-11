@extends('layouts.app')

@section('content')
    <div class="heading">
        <h1 class="h5 font-weight-bold text-uppercase mb-0" style="color: #f26522">
            {{ __('Reset Password') }}
        </h1>
        <hr class="block-separator separator-left" style="border-top-color: #f26522">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @include('errors.validation')

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="font-weight-bold label-required">{{ __('E-Mail Address') }}</label>

                <div class="input-with-icon">
                    <i class="icon-envelop4 input-icon" aria-hidden="true"></i>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <button type="submit" class="btn btn-primary btn-sm btn-block">
                {{ __('Send Password Reset Link') }}
            </button>
        </form>

        <hr>
        <div class="text-center">
            <a href="{{ route('login') }}" class="btn btn-link">{{ __('Login') }}</a>
            {{-- @if(getOption('is_register_open'))
                <span class="ml-1 mr-1">|</span>

                <a class="btn btn-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            @endif --}}
        </div>
    </div>

@endsection
