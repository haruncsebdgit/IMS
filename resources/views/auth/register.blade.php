@extends('layouts.app')

@section('content')
    <div class="heading">
        <h1 class="h5 font-weight-bold text-uppercase mb-0" style="color: #f26522">
            {{ __('Register') }}
        </h1>
        <hr class="block-separator separator-left" style="border-top-color: #f26522">
    </div>
    <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
        @csrf

        <div class="form-group">
            <label for="name-en">{{ __('Name (in English)') }}</label>

            <input id="name-en" type="text" class="form-control{{ $errors->has('name_en') ? ' is-invalid' : '' }}" name="name_en" value="{{ old('name_en') }}" required autocomplete="name_en" autofocus>

            @if ($errors->has('name_en'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name_en') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="email">{{ __('E-Mail Address') }}</label>

            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autocomplete="email">

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="username">{{ __('Username') }}</label>

            <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autocomplete="username">

            @if ($errors->has('username'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <span class="float-right small text-info ml-2">
                <i class="icon-info22" aria-hidden="true"></i>
                {{ trans_choice('master.password_min_chars', 8, ['min' => translateString(8)]) }}
            </span>
            <label for="password">{{ __('Password') }}</label>

            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="new-password">

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="password-confirm">{{ __('Confirm Password') }}</label>

            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>

        <div class="text-sm-right">
            <button type="submit" class="btn btn-primary">
                {{ __('Register') }}
            </button>
        </div>


        <hr>
        <div class="text-center">
            <a href="{{ route('login') }}" class="btn btn-link">{{ __('Login') }}</a>
        </div>
    </form>
@endsection
