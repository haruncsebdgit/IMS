@extends('layouts.admin')

{{-- display page title --}}
@section('page_title', __('Edit Profile'))
@section('body_class', 'users edit-profile')

{{-- make the relevant menu active --}}
@section('admin_top_edit_profile', 'active')

{{-- display page header --}}
@section('page_header_icon', 'icon-profile')
@section('page_header', __('Edit Profile'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        action('Users\UserController@editProfile')  => __('Edit Profile')
    ];
@endphp


@section('breadcrumb_right')
    @if( hasUserCap('edit_users'))
        <a href="{{ action('Users\UserController@edit', ['user_id' => $user->id]) }}" class="btn btn-sm btn-outline-primary">
            <i class="icon-user-check mr-1"></i> {{ __('Edit the User') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

    <form action="{{ route('users.updateprofile') }}" class="needs-validation" novalidate method="POST" id="form-content" enctype="multipart/form-data">

        @php
        $user   = $user ?? '';
        $userId = $user->id ?? null;
        @endphp

        @include('errors.validation')

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name-en" class="d-block">
                        <span class="font-weight-bold">{{ __('Name (English)') }}</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input id="name-en" type="text" class="form-control {{ $errors->has('name_en') ? 'is-invalid' : '' }}" name="name_en" value="{{ setDefaultValue('name_en', $user) }}" required autofocus autocomplete="off">
                    @if ($errors->has('name_en'))
                        <div class="invalid-feedback">{{ $errors->first('name_en') }}</div>
                    @endif
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name-bn" class="d-block">
                        <span class="font-weight-bold">{{ __('Name (Bengali)') }}</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input id="name-bn" type="text" class="form-control {{ $errors->has('name_bn') ? 'is-invalid' : '' }}" name="name_bn" value="{{ setDefaultValue('name_bn', $user) }}" autocomplete="off" required>
                    @if ($errors->has('name_bn'))
                        <div class="invalid-feedback">{{ $errors->first('name_bn') }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-sm-3">
                <div class="form-group">
                    <label for="email" class="d-block">
                        <span class="font-weight-bold">{{ __('Email') }}</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ setDefaultValue('email', $user) }}" autocomplete="off" required>
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    @endif
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <label class="font-weight-bold">{{ __('Username') }}</label>
                    <p class="form-control-plaintext">
                    	<code>{{ $user->username }}</code>
                    </p>
                </div>
            </div>


            <div class="col-sm-6">
                <div class="form-group">
                    <label for="user-role" class="font-weight-bold">{{ __('User Roles') }}</label>
                    <p class="form-control-plaintext">
                    	<?php
                        $userRole = getUserRole(Auth::id());

                        if( false == $userRole ) {
                            echo '&mdash';
                        } else {
                            $_counter = 1;
                            $_data_count = count($userRole);

                            foreach ($userRole as $item) {
                                echo strip_tags($item['label']);
                                if($_counter !== $_data_count) echo ', ';

                                $_counter ++;
                            } //endforeach
                        } //endif
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <button type="button" id="change-password" class="btn btn-sm btn-outline-secondary mb-2 {{ $errors->has('password') ? 'd-none' : '' }}">
            <i class="icon-user-lock mr-1" aria-hidden="true"></i> {{ __('Change Password') }}
        </button>

        <div class="user-password-block {{ $errors->has('password') ? 'show' : '' }}">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="password" class="d-block">
                            <span class="font-weight-bold">{{ __('Password') }}</span>
                            <span class="float-right small text-info ml-2">
                                <i class="icon-info22" aria-hidden="true"></i>
                                {{ trans_choice('master.password_min_chars', 8, ['min' => translateString(8)]) }}
                            </span>
                            @if(empty($userId))
                                <span class="text-danger">*</span>
                            @endif
                        </label>

                        <input id="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" autocomplete="off">

                        @if ($errors->has('password'))
                            <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="password-confirm" class="d-block">
                            <span class="font-weight-bold">{{ __('Confirm Password') }}</span>
                            @if(empty($userId))
                                <span class="text-danger">*</span>
                            @endif
                        </label>

                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                        @if ($errors->has('password_confirmation'))
                            <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <h5 class="inline-header inline-header-center text-muted small text-uppercase mt-4 mb-4">{{ __('Other Information') }}</h5>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="blood-group" class="font-weight-bold">{{ __('Blood Group') }}</label>
                    <?php $_blood_group = setDefaultValue('blood_group', $user); ?>
                    <select name="blood_group" id="blood-group" class="custom-select {{ $errors->has('blood_group') ? 'is-invalid' : '' }}">
                        <option value="">{{ __('Select a Blood Group') }}</option>
                        @foreach( bloodGroups() as $group => $label )
                            <option value="{{ $group }}" {{ $_blood_group === $group ? 'selected="selected"' : '' }}>{{ __( $label ) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="phone" class="d-block font-weight-bold">{{ __('Phone') }}</label>
                    <input id="phone" type="text" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone" value="{{ setDefaultValue('phone', $user) }}" autocomplete="phone">
                    @if ($errors->has('phone'))
                        <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8 user-image-upload-holder">
                <!-- FIELD: USER IMAGE -->
                <label for="user-image" class="font-weight-bold">
                    {{ __('Image') }}
                </label>

                <?php
                // if not mentioned, apply the default image types.
                $user_accepted_extension = App\Http\Controllers\Users\UserController::$defaultExtensions;
                $user_mime_type_array    = \App\Models\BaseUpload::mimeTypesFromExtensions($user_accepted_extension);
                $user_existing           = setDefaultValue('user_image', $user, false);

                $user_maximum_image_size = App\Http\Controllers\Users\UserController::$uploadMaxSize;
                $user_image_size         = formatBytes($user_maximum_image_size);
                ?>

                <div class="user-image-upload-group form-group {{ isset($user->user_image) ? 'd-none' : '' }}">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="user_image" class="custom-file-input" id="user-image" aria-describedby="user-image-upload-btn" accept="{{ implode(',', $user_mime_type_array) }}">
                            <label class="custom-file-label" for="user-image">{{ __('Choose Image') }}</label>
                        </div>
                    </div>

                    <span class="text-muted small">
                        {{ __('Allowed image types: :image_type. Maximum upload size: :image_size',['image_type' => $user_accepted_extension,'image_size' => $user_image_size]) }}
                    </span>
                </div>

                @if(isset($user->user_image))
                    <div class="mb-3 user-image-existing-group">
                        <div class="row">
                            <div class="col-sm-7 mb-2 mb-sm-0">
                                <?php $userImagePath = url("/storage/uploads/images/" . $user->user_image); ?>

                                <div class="position-relative">
                                    <button type="button" class="btn btn-sm btn-danger btn-user-image-remove" style="position: absolute; left: 0; top: 0; z-index: 1;">
                                        <i class="icon-cancel-circle2" aria-hidden="true"></i>

                                        <span class="d-inline-block d-sm-none">
                                            {{ __('User Image') }}
                                        </span>
                                    </button>

                                    <a href="{{ $userImagePath }}" target="_blank" rel="noopener noreferrer" class="d-inline-block">
                                        <img src="{{ $userImagePath }}" width="230" style="width: 230px; height: auto; max-height: 300px;">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- FIELD: HIDDEN REMOVE EXISTING USER IMAGE -->
                <input type="hidden" id="remove-existing-user-image" name="remove_existing_user_image" value="no">

                <!-- FIELD: HIDDEN EXISTING USER IMAGE -->
                <input type="hidden" class="user-image-hidden-field" name="existing_user_image" value="{{ setDefaultValue('user_image', $user, '') }}">
            </div>
        </div>

        @csrf

        <div class="text-sm-right">
            <button type="submit" class="btn btn-primary">
                <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
               {{ __('Update') }}
            </button>
        </div>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-6 text-sm-right">
            </div>
        </div>

        <input type="hidden" name="id" value="{{ $user->id }}">

        @method('PUT')

    </form>

@endsection

{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/pages/user_form_page.js') }}"></script>
@endpush
