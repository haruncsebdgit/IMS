@section('admin_search_form_body')

    <?php
    $lang = config('app.locale');

    /**
     * Get all the filter parameters from URL and Sanitize 'em.
     * @link https://www.php.net/manual/en/function.filter-input.php
     * @var $_filter_params Array of parameters. VARIABLE NAME NEEDS TO BE INTACT.
     */
    $_filter_params = array(
        'param_name'                 => filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING),
        'param_designation_id'       => filter_input(INPUT_GET, 'designation_id', FILTER_VALIDATE_INT),
        'param_birth_date_from'      => filter_input(INPUT_GET, 'birth_date_from', FILTER_SANITIZE_STRING),
        'param_birth_date_to'        => filter_input(INPUT_GET, 'birth_date_to', FILTER_SANITIZE_STRING),
        'param_mobile'               => filter_input(INPUT_GET, 'mobile', FILTER_SANITIZE_STRING),
        'param_nid'                  => filter_input(INPUT_GET, 'nid', FILTER_SANITIZE_STRING),
        'param_email'                => filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL),
        'param_gender'               => filter_input(INPUT_GET, 'gender', FILTER_SANITIZE_STRING),
        'param_joining_date_from'    => filter_input(INPUT_GET, 'joining_date_from', FILTER_SANITIZE_STRING),
        'param_joining_date_to'      => filter_input(INPUT_GET, 'joining_date_to', FILTER_SANITIZE_STRING),
        'param_retirement_date_from' => filter_input(INPUT_GET, 'retirement_date_from', FILTER_SANITIZE_STRING),
        'param_retirement_date_to'   => filter_input(INPUT_GET, 'retirement_date_to', FILTER_SANITIZE_STRING),
        'param_is_active'            => filter_input(INPUT_GET, 'is_active', FILTER_SANITIZE_STRING),
    );
    ?>

    <div class="row">
        <div class="col-sm-8">
            <!-- FIELD: NAME -->
            <div class="form-group">
                <label for="name" class="font-weight-bold">
                    {{ __('Name') }}
                </label>

                <input type="text" name="name" id="name" class="form-control" autocomplete="off" value="{{ $_filter_params['param_name'] }}">
            </div>
        </div>

        <div class="col-sm-4">
            <!-- FIELD: DESIGNATION -->
            <div class="form-group">
                <label for="designation-id" class="font-weight-bold">
                    {{ __('Designation') }}
                </label>

                <select name="designation_id" id="designation-id" class="form-control enable-select2">
                    <option value="">{{ __('Select Designation') }}</option>

                    @if(count($designationList) > 0)
                        @foreach($designationList as $value)
                            @php $designation_name = "name_$lang"; @endphp

                            <option value="{{ $value->id }}" {{ $value->id == $_filter_params['param_designation_id'] ? 'selected="selected"' : '' }}>
                                {{ $value->$designation_name ?? $value->name_en }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <!-- FIELD: DATE OF BIRTH (FROM) -->
            <div class="form-group">
                <label for="birth-date-from" class="font-weight-bold">
                    {{ __('Date of Birth (From)') }}
                </label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="icon-calendar" aria-hidden="true"></i>
                        </div>
                    </div>

                    <input type="text" name="birth_date_from" id="birth-date-from" class="form-control datepicker" placeholder="{{ __('Pick a date, e.g., :pattern', ['pattern' => translateString('21-02-1952')]) }}" autocomplete="off" value="{{ $_filter_params['param_birth_date_from'] }}" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <!-- FIELD: DATE OF BIRTH (TO) -->
            <div class="form-group">
                <label for="birth-date-to" class="font-weight-bold">
                    {{ __('Date of Birth (To)') }}
                </label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="icon-calendar" aria-hidden="true"></i>
                        </div>
                    </div>

                    <input type="text" name="birth_date_to" id="birth-date-to" class="form-control datepicker" placeholder="{{ __('Pick a date, e.g., :pattern', ['pattern' => translateString('21-02-1952')]) }}" autocomplete="off" value="{{ $_filter_params['param_birth_date_to'] }}" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <!-- FIELD: MOBILE -->
            <div class="form-group">
                <label for="mobile" class="font-weight-bold">
                    {{ __('Mobile Number') }}
                </label>

                <input type="text" name="mobile" id="mobile" class="form-control" autocomplete="off" value="{{ $_filter_params['param_mobile'] }}" placeholder="{{ __('In Numbers') }}" inputmode="numeric">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <!-- FIELD: NID -->
            <div class="form-group">
                <label for="nid" class="font-weight-bold">
                    {{ __('National Identification (NID) Number') }}
                </label>

                <input type="text" name="nid" id="nid" class="form-control" autocomplete="off" value="{{ $_filter_params['param_nid'] }}" placeholder="{{ __('In Numbers') }}" inputmode="numeric">
            </div>
        </div>
        
        <div class="col-sm-4">
            <!-- FIELD: EMAIL -->
            <div class="form-group">
                <label for="email" class="font-weight-bold">
                    {{ __('E-mail') }}
                </label>

                <input type="text" name="email" id="email" class="form-control" autocomplete="off" value="{{ $_filter_params['param_email'] }}" placeholder="xyz@something.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="xyz@something.com">
            </div>
        </div>

        <div class="col-sm-4">
            <!-- FIELD: GENDER -->
            <div class="form-group">
                <label for="gender" class="font-weight-bold">
                    {{ __('Gender') }}
                </label>

                <select name="gender" id="gender" class="form-control enable-select2">
                    <option value="">{{ __('Select Gender') }}</option>
                    @if(count($genderList) > 0)
                        @foreach($genderList as $key => $value)
                            <option value="{{ $key }}" {{ $key == $_filter_params['param_gender'] ? 'selected="selected"' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <!-- FIELD: JOINING DATE (FROM) -->
            <div class="form-group">
                <label for="joining-date-from" class="font-weight-bold">
                    {{ __('Date of Joining (From)') }}
                </label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="icon-calendar" aria-hidden="true"></i>
                        </div>
                    </div>

                    <input type="text" name="joining_date_from" id="joining-date-from" class="form-control datepicker" placeholder="{{ __('Pick a date, e.g., :pattern', ['pattern' => translateString('21-02-1952')]) }}" autocomplete="off" value="{{ $_filter_params['param_joining_date_from'] }}" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <!-- FIELD: JOINING DATE (TO) -->
            <div class="form-group">
                <label for="joining-date-to" class="font-weight-bold">
                    {{ __('Date of Joining (To)') }}
                </label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="icon-calendar" aria-hidden="true"></i>
                        </div>
                    </div>

                    <input type="text" name="joining_date_to" id="joining-date-to" class="form-control datepicker" placeholder="{{ __('Pick a date, e.g., :pattern', ['pattern' => translateString('21-02-1952')]) }}" autocomplete="off" value="{{ $_filter_params['param_joining_date_to'] }}" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <!-- FIELD: RETIREMENT DATE (FROM) -->
            <div class="form-group">
                <label for="retirement-date-from" class="font-weight-bold">
                    {{ __('Date of Retirement (From)') }}
                </label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="icon-calendar" aria-hidden="true"></i>
                        </div>
                    </div>

                    <input type="text" name="retirement_date_from" id="retirement-date-from" class="form-control datepicker" placeholder="{{ __('Pick a date, e.g., :pattern', ['pattern' => translateString('21-02-1952')]) }}" autocomplete="off" value="{{ $_filter_params['param_retirement_date_from'] }}" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <!-- FIELD: RETIREMENT DATE (TO) -->
            <div class="form-group">
                <label for="retirement-date-to" class="font-weight-bold">
                    {{ __('Date of Retirement (To)') }}
                </label>
    
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="icon-calendar" aria-hidden="true"></i>
                        </div>
                    </div>
    
                    <input type="text" name="retirement_date_to" id="retirement-date-to" class="form-control datepicker" placeholder="{{ __('Pick a date, e.g., :pattern', ['pattern' => translateString('21-02-1952')]) }}" autocomplete="off" value="{{ $_filter_params['param_retirement_date_to'] }}" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <!-- FIELD: IS ACTIVE -->
            <div class="form-group">
                <label for="is-active" class="font-weight-bold">
                    {{ __('Status') }}
                </label>
    
                <select name="is_active" id="is-active" class="custom-select">
                    <option value="">{{ __('Select a Status') }}</option>
    
                    <option value="active" {{ "active" === $_filter_params['param_is_active'] ? 'selected="selected"' : '' }}>
                        {{ __('Active') }}
                    </option>
    
                    <option value="inactive" {{ "inactive" === $_filter_params['param_is_active'] ? 'selected="selected"' : '' }}>
                        {{ __('Inactive') }}
                    </option>
                </select>
            </div>
        </div>
    </div>

@endsection

@include('layouts.admin-search-form')
