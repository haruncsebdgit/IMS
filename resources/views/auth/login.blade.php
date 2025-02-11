@extends('layouts.app')

@section('content')
    <div class="heading">
        <h1 class="h5 font-weight-bold text-uppercase mb-0" style="color: #f26522">
            {{ __('Login') }}
        </h1>
        <hr class="block-separator separator-left" style="border-top-color: #f26522">
    </div>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @include('errors.validation')
    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
        @csrf
        <div class="form-group">
            <label for="login" class="font-weight-bold">{{ __('Username') }}</label>
            <div class="input-with-icon">
                <i class="icon-user input-icon" aria-hidden="true"></i>
                <input id="login" type="text" class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}" name="login" value="{{ old('username') ?: old('email') }}" required autofocus>
                @if ($errors->has('username') || $errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                    </span>
                @else
                    <span class="invalid-feedback">
                        <strong>{{ __('Please provide a valid username or email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="font-weight-bold">{{ __('Password') }}</label>
            <div class="input-with-icon">
                <i class="icon-lock5 input-icon" aria-hidden="true"></i>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="current-password">
            </div>
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @else
                <span class="invalid-feedback">
                    <strong>{{ __('Please provide your password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-check mb-2 mt-n1">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
                {{ __('Store Password') }}
            </label>
        </div>
        <button type="submit" class="btn btn-primary btn-sm btn-block">
            {{ __('Login') }}
        </button>
    </form>
    <hr>
    <div class="text-center">
        @if (Route::has('password.request'))
            <a class="btn btn-link btn-sm" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
        {{-- @if(getOption('is_register_open'))
            <span class="ml-1 mr-1">|</span>
            <a class="btn btn-link" href="{{ route('register') }}">{{ __('Register') }}</a>
        @endif --}}
    </div>
@endsection
