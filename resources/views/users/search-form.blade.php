@section('admin_search_form_body')

<?php
    /**
     * Get all the filter parameters from URL and Sanitize 'em.
     * @link https://www.php.net/manual/en/function.filter-input.php
     * @var $_filter_params Array of parameters. VARIABLE NAME NEEDS TO BE INTACT.
     */

    $lang = config('app.locale');
    $common_name = "name_{$lang}";

    $_filter_params = array(
        'param_division'  => filter_input(INPUT_GET, 'division_id', FILTER_VALIDATE_INT),
        'param_district'  => filter_input(INPUT_GET, 'district_id', FILTER_VALIDATE_INT),
        'param_thana_upazila'  => filter_input(INPUT_GET, 'thana_upazila_id', FILTER_VALIDATE_INT),
        'param_union_ward'  => filter_input(INPUT_GET, 'union_ward_id', FILTER_VALIDATE_INT),

        'name'  => filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING),
        'email' => filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL),
        'role'  => filter_input(INPUT_GET, 'role', FILTER_SANITIZE_STRING),
        'username'  => filter_input(INPUT_GET, 'username', FILTER_SANITIZE_STRING)
    );


    if(!empty($division_disabled)){
        $_filter_params['param_division'] = $division_id;
    }

    if(!empty($district_disabled)){
        $_filter_params['param_district'] = $district_id;
    }
    if(!empty($thana_upazila_disabled)){
        $_filter_params['param_thana_upazila'] = $thana_upazila_id;
    }

    if(!empty($union_ward_disabled)){
        $_filter_params['param_union_ward'] = $union_ward_id;
    }


    ?>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" class="form-control" autocomplete="off" value="{{ $_filter_params['name'] }}">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input type="email" name="email" id="email" class="form-control" autocomplete="off" value="{{ $_filter_params['email'] }}">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="role">{{ __('Role') }}</label>
            <select name="role" id="role" class="custom-select">
                <option value="">{{ __('Select a Role') }}</option>
                @foreach($roles as $roleKey => $role)
                <?php $_selected = $_filter_params['role'] === $roleKey ? 'selected="selected"' : ''; ?>
                <option value="{{ $roleKey }}" {{ $_selected }}>{{ $role }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="name">{{ __('Username') }}</label>
            <input type="text" name="username" id="username" class="form-control" autocomplete="off" value="{{ $_filter_params['username'] }}">
        </div>
    </div>

</div>

@endsection

@include('layouts.admin-search-form')
