@section('admin_search_form_body')

<?php
/**
 * Get all the filter parameters from URL and Sanitize 'em.
 * @link https://www.php.net/manual/en/function.filter-input.php
 * @var $_filter_params Array of parameters. VARIABLE NAME NEEDS TO BE INTACT.
 */
$_filter_params = array(
    'name_en' => filter_input(INPUT_GET, 'name_en', FILTER_SANITIZE_STRING),
    'code_en' => filter_input(INPUT_GET, 'code_en', FILTER_SANITIZE_STRING),
    'category' => filter_input(INPUT_GET, 'category', FILTER_SANITIZE_STRING),
    'part_number' => filter_input(INPUT_GET, 'part_number', FILTER_SANITIZE_STRING),
);
?>


<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            {!! Form::text('name_en', $_filter_params['name_en'], ['class'=>'form-control' ]) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="registration_no">{{ __('Code') }}</label>
            {!! Form::text('code_en', $_filter_params['code_en'], ['class'=>'form-control' ]) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="parent">{{ __('Category') }}</label>
            {!! Form::select('category', $category, null, ['placeholder'=>__('Select'),'class' => 'form-control enable-select2']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="registration_no">{{ __('Part Number') }}</label>
            {!! Form::text('part_number', $_filter_params['part_number'], ['class'=>'form-control' ]) !!}
        </div>
    </div>
</div>

@endsection

@include('layouts.admin-search-form')