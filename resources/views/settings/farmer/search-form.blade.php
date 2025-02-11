@section('admin_search_form_body')

<?php
/**
 * Get all the filter parameters from URL and Sanitize 'em.
 * @link https://www.php.net/manual/en/function.filter-input.php
 * @var $_filter_params Array of parameters. VARIABLE NAME NEEDS TO BE INTACT.
 */
$_filter_params = array(
    'division_id'      => filter_input(INPUT_GET, 'division_id', FILTER_SANITIZE_STRING),
    'district_id' => filter_input(INPUT_GET, 'district_id', FILTER_SANITIZE_STRING),
    'upazila_id' => filter_input(INPUT_GET, 'upazila_id', FILTER_SANITIZE_STRING),
    'union_id' => filter_input(INPUT_GET, 'union_id', FILTER_SANITIZE_STRING)
);
?>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="division_id">{{ __('Division') }}</label>
            {!! Form::select('division_id', $divisions, $_filter_params['division_id'], ['id'=>'division' ,'class'=>'form-control enable-select2', 'placeholder' => __('Select') ]) !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="district_id">{{ __('District') }}</label>
            {!! Form::select('district_id', [], $_filter_params['district_id'], ['id'=>'district' ,'class'=>'form-control enable-select2', 'placeholder' => __('Select') ]) !!}

        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="upazilla_id">{{ __('Upazila') }}</label>
            {!! Form::select('upazila_id', [], $_filter_params['upazila_id'], ['id'=>'thana-upazila','class'=>'form-control enable-select2 ', 'placeholder' => __('Select') ]) !!}

        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="union_id">{{ __('Union') }}</label>
            {!! Form::select('union_id', [], $_filter_params['union_id'], ['id'=>'union-ward','class'=>'form-control enable-select2', 'placeholder' => __('Select') ]) !!}
        </div>
    </div>
</div>

@endsection

@include('layouts.admin-search-form')
