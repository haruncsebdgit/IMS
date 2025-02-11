@extends('layouts.app')

@section('content')
    <div class="heading">
        <h1 class="h5 font-weight-bold text-uppercase mb-0" style="color: #f26522">
            {{ __('Set New Password') }}
        </h1>
        <hr class="block-separator separator-left" style="border-top-color: #f26522">
    </div>
    @include('errors.validation')
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <input id="email" type="hidden" name="email" value="{{ $email }}">

        <div class="form-group">
            <label for="password" class="font-weight-bold label-required">{{ __('Password') }}</label>
            <div class="input-with-icon">
                <i class="icon-lock5 input-icon" aria-hidden="true"></i>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="new-password" autofocus>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @else
                    <span class="invalid-feedback">
                        <strong>{{ __('Please provide a new password password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label for="password-confirm" class="font-weight-bold label-required">{{ __('Confirm Password') }}</label>

            <div class="input-with-icon">
                <i class="icon-lock5 input-icon" aria-hidden="true"></i>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-sm btn-block">
            {{ __('Reset Password') }}
        </button>
    </form>
    <hr>
    <div class="text-center">
        @if (Route::has('password.request'))
            <a class="btn btn-link btn-sm" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
    </div>
@endsection
