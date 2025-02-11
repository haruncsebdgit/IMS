@section('admin_search_form_body')

<?php
/**
 * Get all the filter parameters from URL and Sanitize 'em.
 * @link https://www.php.net/manual/en/function.filter-input.php
 * @var $_filter_params Array of parameters. VARIABLE NAME NEEDS TO BE INTACT.
 */
$_filter_params = array(
    'name_en' => filter_input(INPUT_GET, 'name_en', FILTER_SANITIZE_STRING),
    'name_bn' => filter_input(INPUT_GET, 'name_bn', FILTER_SANITIZE_STRING),
    'parent' => filter_input(INPUT_GET, 'parent', FILTER_SANITIZE_STRING),
);
?>


<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="name">{{ __('Name (English)') }}</label>
            {!! Form::text('name_en', $_filter_params['name_en'], ['class'=>'form-control' ]) !!}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="registration_no">{{ __('Name (Bengali)') }}</label>
            {!! Form::text('name_bn', $_filter_params['name_bn'], ['class'=>'form-control' ]) !!}
        </div>
    </div>
</div>

@endsection

@include('layouts.admin-search-form')
