@php
$user = $user ?? '';
$userId = $user->id ?? null;
$required = empty($userId) ? ' required' : '';
@endphp

@include('errors.validation')

<div class="row">
    <div class="col-sm-8">
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
            <div class="col-sm-6">
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
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="username" class="d-block">
                        <span class="font-weight-bold">{{ __('Username') }}</span>

                        @if( empty($userId) )
                        <span class="text-danger">*</span>
                        @else
                        <span class="float-right small text-info">
                            <i class="icon-info22" aria-hidden="true"></i>
                            {{ __('Not Allowed to Edit') }}
                        </span>
                        @endif
                    </label>
                    <input id="username" type="username" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" name="username" value="{{ setDefaultValue('username', $user) }}" autocomplete="off" {{ ! empty($userId) ? 'readonly disabled' : 'required' }}>
                    @if ($errors->has('username'))
                    <div class="invalid-feedback">{{ $errors->first('username') }}</div>
                    @endif
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="phone" class="d-block font-weight-bold">{{ __('Phone') }}</label>
                    <input id="phone" type="text" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone" value="{{ setDefaultValue('phone', $user) }}" autocomplete="phone">
                    @if ($errors->has('phone'))
                    <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                    @endif
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="is-active" class="d-block">
                        <span class="font-weight-bold">{{ __('Status') }}</span>
                        <span class="text-danger">*</span>
                    </label>
                    <?php $_isActive = setDefaultValue('is_active', $user, 1); ?>
                    <select name="is_active" id="is-active" class="custom-select {{ $errors->has('is_active') ? 'is-invalid' : '' }}" required>
                        <option value="">{{ __('Select the Status') }}</option>
                        <option value="1" {{ $_isActive == 1 ? 'selected="selected"' : '' }}>{{ __('Active') }}</option>
                        <option value="0" {{ $_isActive == 0 ? 'selected="selected"' : '' }}>{{ __('Inactive') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="button" id="change-password" class="btn btn-sm btn-outline-secondary mb-2 {{ $errors->has('password') ? 'd-none' : '' }}">
            <i class="icon-user-lock mr-1" aria-hidden="true"></i>
            {{ __('Change Password') }}
        </button>

        <section class="user-password-block {{ $errors->has('password') ? 'show' : '' }}">
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

                        <input id="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" {{ $required }} autocomplete="off">

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

                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" {{ $required }}>

                        @if ($errors->has('password_confirmation'))
                        <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-sm-4">
        <div class="row">
            <div class="col-sm-12 user-image-upload-holder">
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

                @if(isset($userImage))
                <div class="mb-3 user-image-existing-group">
                    <div class="row">
                        <div class="col-sm-7 mb-2 mb-sm-0">
                            <?php //$userImagePath = url("/storage/uploads/images/" . $user->user_image); ?>

                            <div class="position-relative">
                                <button type="button" class="btn btn-sm btn-danger btn-user-image-remove" style="position: absolute; left: 0; top: 0; z-index: 1;">
                                    <i class="icon-cancel-circle2" aria-hidden="true"></i>

                                    <span class="d-inline-block d-sm-none">
                                        {{ __('User Image') }}
                                    </span>
                                </button>

                                <a id="user-image-fullview" href="{{ $userImage }}" target="_blank" rel="noopener noreferrer" class="d-inline-block">
                                    <img src="{{ $userImage }}" id="user-image-preview" width="200" style="width: 200px; height: auto; max-height: 180px;">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
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

                <!-- FIELD: HIDDEN REMOVE EXISTING USER IMAGE -->
                <input type="hidden" id="remove-existing-user-image" name="remove_existing_user_image" value="no">

                <!-- FIELD: HIDDEN EXISTING USER IMAGE -->
                <input type="hidden" class="user-image-hidden-field" name="existing_user_image" value="{{ setDefaultValue('user_image', $user, '') }}">
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-sm-4">
        <div class="form-group">
            <label for="user-level" class="font-weight-bold">{{ __('User Level') }}</label>
            <?php $_userLevel = setDefaultValue('user_level', $user); ?>
            <select name="user_level" id="user-level" class="custom-select {{ $errors->has('user_level') ? 'is-invalid' : '' }}">
                <option value="">{{ __('Select a Level') }}</option>
                @foreach( userLevels() as $level => $levelName )
                <option value="{{ $level }}" {{ $_userLevel === $level ? 'selected="selected"' : '' }}>{{ $levelName }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-4">
        <?php $role_data = $userRole ?? old('user_role'); ?>
        <div class="form-group">
            <label for="user-role" class="d-block">
                <span class="font-weight-bold">{{ __('Role/Roles') }}</span>
                <span class="text-danger">*</span>
            </label>
            <select name="user_role[]" id="user-role" class="form-control enable-select2 {{ $errors->has('user_role') ? 'is-invalid' : '' }}" required multiple data-placeholder="{{ __('Select Role/Roles') }}">
                @foreach( $registeredUserRoles as $role => $role_label )
                <option value="{{ $role }}" {{ !empty($role_data) && in_array( $role, $role_data ) ? 'selected="selected"' : '' }}>
                    {{ $role_label }}
                </option>
                @endforeach
            </select>
            @if ($errors->has('user_role'))
            <div class="invalid-feedback">{{ $errors->first('user_role') }}</div>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="designation" class="font-weight-bold">{{ __('Designation') }}</label>
            <?php $_designation = setDefaultValue('designation_id', $user); ?>
            <select name="designation_id" id="designation" class="custom-select {{ $errors->has('designation_id') ? 'is-invalid' : '' }}">
                <option value="">{{ __('Select a Designation') }}</option>
                @foreach( getCommonLabels('designations') as $designation )
                <option value="{{ $designation->id }}" {{ $_designation === $designation->id ? 'selected="selected"' : '' }}>{{ resolveFieldName($designation) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="blood-group" class="font-weight-bold">{{ __('Address') }}</label>
            <textarea class="form-control" name="address">{{ setDefaultValue('address', $user) }}</textarea>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="location_id" class="font-weight-bold">{{ __('Location (Room No)') }}</label>
            <?php $_locationId = setDefaultValue('location_id', $user); ?>
            <select name="location_id" id="location_id" class="custom-select {{ $errors->has('location_id') ? 'is-invalid' : '' }}">
                <option value="">{{ __('Select Room No.') }}</option>
                @foreach( $assetLocation as $id => $location )
                <option value="{{ $id }}" {{ $_locationId === $id ? 'selected="selected"' : '' }}>{{ $location }}</option>
                @endforeach
            </select>
        </div>
    </div>

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

</div>


@csrf
<br>
<div class="text-sm-right">
    <button type="submit" class="btn btn-primary">
        <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
        @yield('user_form_submit_btn')
    </button>
</div>

@push('scripts')
<script>
    var userImage = '{{ $placeHolderImage }}';

</script>
@endpush
