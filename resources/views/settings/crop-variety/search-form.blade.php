@section('admin_search_form_body')

<?php
/**
 * Get all the filter parameters from URL and Sanitize 'em.
 * @link https://www.php.net/manual/en/function.filter-input.php
 * @var $_filter_params Array of parameters. VARIABLE NAME NEEDS TO BE INTACT.
 */
$_filter_params = array(
    'crop_id'      => filter_input(INPUT_GET, 'crop_id', FILTER_SANITIZE_STRING),
    'crop_type_id'      => filter_input(INPUT_GET, 'crop_type_id', FILTER_SANITIZE_STRING),
    'is_active' => filter_input(INPUT_GET, 'is_active', FILTER_SANITIZE_STRING)
);
?>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="crop_id" class="d-block">
                <span class="font-weight-bold">{{ __('Crop') }}</span>
            </label>
            {!! Form::select('crop_id', $crops, $_filter_params['crop_id'], ['class' => 'form-control enable-select2 ', 'placeholder' => __('Select')]) !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="crop_type_id" class="d-block">
                <span class="font-weight-bold">{{ __('Crop Type') }}</span>
            </label>
            {!! Form::select('crop_type_id', cropType(), $_filter_params['crop_type_id'], ['class' => 'form-control enable-select2 ', 'placeholder' => __('Select'), '']) !!}
        </div>
    </div>
</div>

@endsection

@include('layouts.admin-search-form')