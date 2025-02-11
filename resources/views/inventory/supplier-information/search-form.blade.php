@section('admin_search_form_body')

<?php
/**
 * Get all the filter parameters from URL and Sanitize 'em.
 * @link https://www.php.net/manual/en/function.filter-input.php
 * @var $_filter_params Array of parameters. VARIABLE NAME NEEDS TO BE INTACT.
 */
$_filter_params = array(
    'name' => filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING)
);
?>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="division_id">{{ __('Name') }}</label>
            {!! Form::text('name', $_filter_params['name'], ['class'=>'form-control enable-select2', 'placeholder' => __('Supplier name') ]) !!}
        </div>
    </div>
</div>

@endsection

@include('layouts.admin-search-form')
