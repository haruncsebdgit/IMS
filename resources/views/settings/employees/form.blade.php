<?php
    $employeeInfo = $employeeInfo ?? '';
    $lang         = config('app.locale');
?>

<section class="card mb-3">
    <div class="card-body">
        <p class="mb-20 text-info">
            <i class="icon-exclamation" aria-hidden="true"></i>
            {!! __('All fields marked with an asterisk (*) are required.') !!}
        </p>

        <div class="row">
            <div class="col-sm-6">
                <!-- FIELD: NAME (ENGLISH) -->
                <div class="form-group">
                    <label for="name-en" class="font-weight-bold">
                        {{ __('Name of Employee (English)') }}
                        <sup class="text-danger">*</sup>
                    </label>

                    @php $name_en = setDefaultValue('name_en', $employeeInfo); @endphp

                    <input type="text" name="name_en" value="{{ $name_en }}" id="name-en" class="form-control {{ $errors->has('name_en') ? 'is-invalid' : '' }}" placeholder="" autocomplete="off" required>

                    @if ($errors->has('name_en'))
                        <div class="invalid-feedback">{{ $errors->first('name_en') }}</div>
                    @else
                        <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                    @endif
                </div>
            </div>

            <div class="col-sm-6">
                <!-- FIELD: NAME (BENGALI) -->
                <div class="form-group">
                    <label for="name-bn" class="font-weight-bold">
                        {{ __('Name of Employee (Bengali)') }}
                        <sup class="text-danger">*</sup>
                    </label>

                    @php $name_bn = setDefaultValue('name_bn', $employeeInfo); @endphp

                    <input type="text" name="name_bn" value="{{ $name_bn }}" id="name-bn" class="form-control {{ $errors->has('name_bn') ? 'is-invalid' : '' }}" placeholder="" autocomplete="off" required>

                    @if ($errors->has('name_bn'))
                        <div class="invalid-feedback">{{ $errors->first('name_bn') }}</div>
                    @else
                        <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                    @endif
                </div>
            </div>
        </div>

        <h3 class="inline-header inline-header-center h6 my-1 text-secondary py-3">
            {{ __("Employee Information") }}
        </h3>

        <div class="row">
            <div class="col-sm-6">
                <!-- FIELD: DESIGNATION -->
                <div class="form-group">
                    <label for="designation-id" class="font-weight-bold">
                        {{ __('Designation') }}
                        <sup class="text-danger">*</sup>
                    </label>

                    @php $designation_id = setDefaultValue('designation_id', $employeeInfo); @endphp

                    <select name="designation_id" id="designation-id" class="form-control enable-select2 {{ $errors->has('designation_id') ? 'is-invalid' : '' }}" required>
                        <option value="">{{ __('Select Designation') }}</option>

                        @if(count($designationList) > 0)
                            @foreach($designationList as $value)
                                @php $designation_name = "name_$lang"; @endphp

                                <option value="{{ $value->id }}" {{ $value->id == $designation_id ? 'selected="selected"' : '' }}>
                                    {{ $value->$designation_name ?? $value->name_en }}
                                </option>
                            @endforeach
                        @endif
                    </select>

                    @if ($errors->has('designation_id'))
                        <div class="invalid-feedback">{{ $errors->first('designation_id') }}</div>
                    @else
                        <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                    @endif
                </div>
            </div>

            <div class="col-sm-3">
                <!-- FIELD: DATE OF BIRTH -->
                <div class="form-group">
                    <label for="date-of-birth" class="font-weight-bold">
                        {{ __('Date of Birth') }}
                        <sup class="text-danger">*</sup>
                    </label>

                    @php
                        $date_of_birth = setDefaultValue('date_of_birth', $employeeInfo);
                        $date_of_birth = $date_of_birth ? date('d-m-Y', strtotime($date_of_birth)) : null;
                    @endphp

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="icon-calendar" aria-hidden="true"></i>
                            </div>
                        </div>

                        <input type="text" class="form-control datepicker {{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}" name="date_of_birth" id="date-of-birth" required value="{{ $date_of_birth }}" placeholder="{{ __('Pick a date') }}" autocomplete="off" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}">

                        @if ($errors->has('date_of_birth'))
                            <div class="invalid-feedback">{{ $errors->first('date_of_birth') }}</div>
                        @else
                            <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <!-- FIELD: MOBILE -->
                <div class="form-group">
                    <label for="mobile" class="font-weight-bold">
                        {{ __('Mobile Number') }}
                        <sup class="text-danger">*</sup>
                    </label>

                    @php $mobile = setDefaultValue('mobile', $employeeInfo); @endphp

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="icon-mobile" aria-hidden="true"></i>
                            </div>
                        </div>

                        <input type="text" name="mobile" value="{{ $mobile }}" id="mobile" class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" placeholder="{{ __('In Numbers') }}" autocomplete="off" required inputmode="numeric" pattern="^\d{11}$">

                        @if ($errors->has('mobile'))
                            <div class="invalid-feedback">{{ $errors->first('mobile') }}</div>
                        @else
                            <div class="invalid-feedback">{{ __('(11 Digit Mobile Number should be written in English, e.g., :pattern)', ['pattern' => '01552343391']) }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <!-- FIELD: FATHER NAME -->
                <div class="form-group">
                    <label for="father-name" class="font-weight-bold">
                        {{ __("Father's Name") }}
                        <sup class="text-danger">*</sup>
                    </label>

                    @php $father_name = setDefaultValue('father_name', $employeeInfo); @endphp

                    <input type="text" name="father_name" value="{{ $father_name }}" id="father-name" class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}" placeholder="" autocomplete="off" required>

                    @if ($errors->has('father_name'))
                        <div class="invalid-feedback">{{ $errors->first('father_name') }}</div>
                    @else
                        <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                    @endif
                </div>
            </div>

            <div class="col-sm-6">
                <!-- FIELD: MOTHER NAME -->
                <div class="form-group">
                    <label for="mother-name" class="font-weight-bold">
                        {{ __("Mother's Name") }}
                        <sup class="text-danger">*</sup>
                    </label>

                    @php $mother_name = setDefaultValue('mother_name', $employeeInfo); @endphp

                    <input type="text" name="mother_name" value="{{ $mother_name }}" id="mother-name" class="form-control {{ $errors->has('mother_name') ? 'is-invalid' : '' }}" placeholder="" autocomplete="off" required>

                    @if ($errors->has('mother_name'))
                        <div class="invalid-feedback">{{ $errors->first('mother_name') }}</div>
                    @else
                        <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <!-- FIELD: NID -->
                <div class="form-group">
                    <label for="nid" class="font-weight-bold">
                        {{ __('National Identification (NID) Number') }}
                        <sup class="text-danger">*</sup>
                    </label>

                    @php $nid = setDefaultValue('nid', $employeeInfo); @endphp

                    <input type="text" name="nid" value="{{ $nid }}" id="nid" class="form-control {{ $errors->has('nid') ? 'is-invalid' : '' }}" placeholder="{{ __('In Numbers') }}" autocomplete="off" required inputmode="numeric" pattern="^([0-9]{10})$|^([0-9]{13})$|^([0-9]{17})$">

                    @if ($errors->has('nid'))
                        <div class="invalid-feedback">{{ $errors->first('nid') }}</div>
                    @else
                        <div class="invalid-feedback">{{ __('NID Numbers needs to be 10, 13, or 17 digits.') }}</div>
                    @endif
                </div>
            </div>

            <div class="col-sm-6">
                <!-- FIELD: EMAIL -->
                <div class="form-group">
                    <label for="email" class="font-weight-bold">
                        {{ __('Email') }}
                        <sup class="text-danger">*</sup>
                    </label>

                    @php $email = setDefaultValue('email', $employeeInfo); @endphp

                    <input type="email" name="email" value="{{ $email }}" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="xyz@something.com" autocomplete="off" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="xyz@something.com">

                    @if ($errors->has('email'))
                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    @else
                        <div class="invalid-feedback">{{ __('E-mail format must be (e.g., :pattern).', ['pattern' => 'xyz@mail.com']) }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">


            <div class="col-sm-6">
                <!-- FIELD: GENDER -->
                <div class="form-group">
                    <label for="gender" class="font-weight-bold">
                        {{ __('Gender') }}
                        <sup class="text-danger">*</sup>
                    </label>

                    @php $gender = setDefaultValue('gender', $employeeInfo); @endphp

                    <select name="gender" id="gender" class="form-control enable-select2 {{ $errors->has('gender') ? 'is-invalid' : '' }}" required>
                        <option value="">{{ __('Select Gender') }}</option>
                        @if(count($genderList) > 0)
                            @foreach($genderList as $key => $value)
                                <option value="{{ $key }}" {{ $key == $gender ? 'selected="selected"' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        @endif
                    </select>

                    @if ($errors->has('gender'))
                        <div class="invalid-feedback">{{ $errors->first('gender') }}</div>
                    @else
                        <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                    @endif
                </div>
            </div>

            <div class="col-sm-6">
                <!-- FIELD: RELIGION -->
                <div class="form-group">
                    <label for="religion" class="font-weight-bold">
                        {{ __('Religion') }}
                        <sup class="text-danger">*</sup>
                    </label>

                    @php $religion = setDefaultValue('religion', $employeeInfo); @endphp

                    <select name="religion" id="religion" class="form-control enable-select2 {{ $errors->has('religion') ? 'is-invalid' : '' }}" required>
                        <option value="">{{ __('Select Religion') }}</option>
                        @if(count($religionList) > 0)
                            @foreach($religionList as $key => $value)
                                <option value="{{ $key }}" {{ $key == $religion ? 'selected="selected"' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        @endif
                    </select>

                    @if ($errors->has('religion'))
                        <div class="invalid-feedback">{{ $errors->first('religion') }}</div>
                    @else
                        <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <!-- FIELD: JOINING DATE -->
                <div class="form-group">
                    <label for="joining-date" class="font-weight-bold">
                        {{ __('Joining Date') }}
                        <sup class="text-danger">*</sup>
                    </label>

                    @php
                        $joining_date = setDefaultValue('joining_date', $employeeInfo);
                        $joining_date = $joining_date ? date('d-m-Y', strtotime($joining_date)) : null;
                    @endphp

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="icon-calendar" aria-hidden="true"></i>
                            </div>
                        </div>

                        <input type="text" class="form-control datepicker {{ $errors->has('joining_date') ? 'is-invalid' : '' }}" name="joining_date" id="joining-date" value="{{ $joining_date }}" placeholder="{{ __('Pick a date') }}" autocomplete="off" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}">

                        @if ($errors->has('joining_date'))
                            <div class="invalid-feedback">{{ $errors->first('joining_date') }}</div>
                        @else
                            <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <!-- FIELD: RETIREMENT DATE -->
                <div class="form-group">
                    <label for="retirement-date" class="font-weight-bold">
                        {{ __('Retirement Date') }}
                    </label>

                    @php
                        $retirement_date = setDefaultValue('retirement_date', $employeeInfo);
                        $retirement_date = $retirement_date ? date('d-m-Y', strtotime($retirement_date)) : null;
                    @endphp

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="icon-calendar" aria-hidden="true"></i>
                            </div>
                        </div>

                        <input type="text" class="form-control datepicker" name="retirement_date" id="retirement-date" value="{{ $retirement_date }}" placeholder="{{ __('Pick a date') }}" autocomplete="off" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <!-- FIELD: EMPLOYEE TYPE -->
                <div class="form-group">
                    <label for="employee-type-id" class="font-weight-bold">
                        {{ __('Employee Type') }}
                        <sup class="text-danger">*</sup>
                    </label>

                    @php $employee_type_id = setDefaultValue('employee_type_id', $employeeInfo); @endphp

                    <select required name="employee_type_id" id="employee-type-id" class="form-control enable-select2 {{ $errors->has('employee_type_id') ? 'is-invalid' : '' }}">
                        <option value="">{{ __('Select Employee Type') }}</option>

                        @if(count($employeeTypeList) > 0)
                            @foreach($employeeTypeList as $value)
                                @php $employee_type_name = "name_$lang"; @endphp

                                <option value="{{ $value->id }}" {{ $value->id == $employee_type_id ? 'selected="selected"' : '' }}>
                                    {{ $value->$employee_type_name ?? $value->name_en }}
                                </option>
                            @endforeach
                        @endif
                    </select>

                    @if ($errors->has('employee_type_id'))
                        <div class="invalid-feedback">{{ $errors->first('employee_type_id') }}</div>
                    @else
                        <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <!-- FIELD: EMPLOYEE CATEGORY -->
                <div class="form-group">
                    <label for="employee-category-id" class="font-weight-bold">
                        {{ __('Employee Category') }}
                        <sup class="text-danger">*</sup>
                    </label>

                    @php $employee_category_id = setDefaultValue('employee_category_id', $employeeInfo); @endphp

                    <select required name="employee_category_id" id="employee-category-id" class="form-control enable-select2 {{ $errors->has('employee_category_id') ? 'is-invalid' : '' }}">
                        <option value="">{{ __('Select Employee Category') }}</option>

                        @if(count($employeeCategoryList) > 0)
                            @foreach($employeeCategoryList as $value)
                                @php $employee_category_name = "name_$lang"; @endphp

                                <option value="{{ $value->id }}" {{ $value->id == $employee_category_id ? 'selected="selected"' : '' }}>
                                    {{ $value->$employee_category_name ?? $value->name_en }}
                                </option>
                            @endforeach
                        @endif
                    </select>

                    @if ($errors->has('employee_category_id'))
                        <div class="invalid-feedback">{{ $errors->first('employee_category_id') }}</div>
                    @else
                        <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                    @endif
                </div>
            </div>

            <div class="col-sm-3">
                <!-- FIELD: EMPLOYEE CLASS -->
                <div class="form-group">
                    <label for="employee-class-id" class="font-weight-bold">
                        {{ __('Employee Class') }}
                        <sup class="text-danger">*</sup>
                    </label>

                    @php $employee_class_id = setDefaultValue('employee_class_id', $employeeInfo); @endphp

                    <select required name="employee_class_id" id="employee-class-id" class="form-control enable-select2 {{ $errors->has('employee_class_id') ? 'is-invalid' : '' }}">
                        <option value="">{{ __('Select Employee Class') }}</option>

                        @if(count($employeeClassList) > 0)
                            @foreach($employeeClassList as $value)
                                @php $employee_class_name = "name_$lang"; @endphp

                                <option value="{{ $value->id }}" {{ $value->id == $employee_class_id ? 'selected="selected"' : '' }}>
                                    {{ $value->$employee_class_name ?? $value->name_en }}
                                </option>
                            @endforeach
                        @endif
                    </select>

                    @if ($errors->has('employee_class_id'))
                        <div class="invalid-feedback">{{ $errors->first('employee_class_id') }}</div>
                    @else
                        <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                    @endif
                </div>
            </div>

            <div class="col-sm-3">
                <!-- FIELD: IS ACTIVE -->
                <div class="form-group">
                    @php $is_active = setDefaultValue('is_active', $employeeInfo, 1); @endphp

                    <label for="is-active" class="font-weight-bold">
                        {{ __('Status') }}
                        <sup class="text-danger">*</sup>
                    </label>

                    <select name="is_active" id="is-active" class="custom-select {{ $errors->has('is_active') ? 'is-invalid' : '' }}" required>
                        <option value="1" {{ 1 == $is_active ? 'selected="selected"' : '' }}>
                            {{ __('Active') }}
                        </option>

                        <option value="0" {{ 0 == $is_active ? 'selected="selected"' : '' }}>
                            {{ __('Inactive') }}
                        </option>
                    </select>

                    @if ($errors->has('is_active'))
                        <div class="invalid-feedback">{{ $errors->first('is_active') }}</div>
                    @else
                        <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                    @endif
                </div>
            </div>
        </div>

        <h3 class="inline-header inline-header-center text-muted small text-uppercase mt-4 mb-4">
            {{ __("Other Information") }}
        </h3>

        <!-- FIELD: ADDRESS -->
        <div class="form-group">
            <label for="address" class="font-weight-bold">
                {{ __('Address') }}
                <sup class="text-danger">*</sup>
            </label>

            @php $address = setDefaultValue('address', $employeeInfo); @endphp

            <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" rows="1" id="address" name="address" required>{{ $address }}</textarea>

            @if ($errors->has('address'))
                <div class="invalid-feedback">{{ $errors->first('address') }}</div>
            @else
                <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
            @endif
        </div>

        <div class="row">
            <!-- FIELD: EMPLOYEE IMAGE -->
            <div class="col-sm-3 employee-image-upload-holder">
                <label for="employee-image" class="font-weight-bold">
                    {{ __('Image') }}
                </label>

                <?php
                // if not mentioned, apply the default image types.
                $accepted_extension = App\Http\Controllers\Settings\EmployeeController::$defaultExtensions;
                $mime_type_array    = \App\Models\BaseUpload::mimeTypesFromExtensions($accepted_extension);
                $existing           = setDefaultValue('employee_image', $employeeInfo, false);

                $maximum_image_size = App\Http\Controllers\Settings\EmployeeController::$uploadMaxSize;
                $image_size         = formatBytes($maximum_image_size);
                ?>

                <div class="employee-image-upload-group form-group {{ isset($employeeInfo->employee_image) ? 'd-none' : '' }}">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="employee_image" class="custom-file-input" id="employee-image" aria-describedby="employee-image-upload-btn" accept="{{ implode(',', $mime_type_array) }}">
                            <label class="custom-file-label" for="employee-image">{{ __('Choose Image') }}</label>
                        </div>
                    </div>

                    <span class="text-muted small">
                        {{ __('Allowed image types: :image_type.',['image_type' => $accepted_extension]) }}<br/>
                        {{ __('Maximum upload size: :image_size',['image_size' => $image_size]) }}
                    </span>
                </div>

                @if(isset($employeeInfo->employee_image))
                    <div class="mb-3 employee-image-existing-group">
                        <div class="row">
                            <div class="col-sm-7 mb-2 mb-sm-0">
                                <?php $employeeImagePath = url("/storage/uploads/images/" . $employeeInfo->employee_image); ?>

                                <div class="position-relative">
                                    <button type="button" class="btn btn-sm btn-danger btn-employee-image-remove" style="position: absolute; left: 0; top: 0; z-index: 1;">
                                        <i class="icon-cancel-circle2" aria-hidden="true"></i>

                                        <span class="d-inline-block d-sm-none">
                                            {{ __('Employee Image') }}
                                        </span>
                                    </button>

                                    <a href="{{ $employeeImagePath }}" target="_blank" rel="noopener noreferrer" class="d-inline-block">
                                        <img src="{{ $employeeImagePath }}" width="230" style="width: 230px; height: auto; max-height: 300px;">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- FIELD: HIDDEN REMOVE EXISTING EMPLOYEE IMAGE -->
                <input type="hidden" id="remove-existing-employee-image" name="remove_existing_employee_image" value="no">

                <!-- FIELD: HIDDEN EXISTING EMPLOYEE IMAGE -->
                <input type="hidden" class="employee-image-hidden-field" name="existing_employee_image" value="{{ setDefaultValue('employee_image', $employeeInfo, '') }}">
            </div>
        </div>
    </div>
    <!-- /.card-body -->

    @csrf
</section>
<!-- /.card -->

<div class="text-right">
    <button type="submit" class="btn btn-primary text-right">
        <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
        @yield('form_submit_btn')
    </button>
</div>
