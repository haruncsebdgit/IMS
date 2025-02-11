@section('admin_search_form_body')

<?php
/**
 * Get all the filter parameters from URL and Sanitize 'em.
 * @link https://www.php.net/manual/en/function.filter-input.php
 * @var $_filter_params Array of parameters. VARIABLE NAME NEEDS TO BE INTACT.
 */
$_filter_params = array(
    'receive_id' => filter_input(INPUT_GET, 'receive_id', FILTER_SANITIZE_STRING),
    'inventory_center' => filter_input(INPUT_GET, 'inventory_center', FILTER_SANITIZE_STRING),
    'date_from' => filter_input(INPUT_GET, 'date_from', FILTER_SANITIZE_STRING),
    'date_to' => filter_input(INPUT_GET, 'date_to', FILTER_SANITIZE_STRING),
    'supplier' => filter_input(INPUT_GET, 'supplier', FILTER_SANITIZE_STRING),
    'package' => filter_input(INPUT_GET, 'package', FILTER_SANITIZE_STRING),
    'item' => filter_input(INPUT_GET, 'item', FILTER_SANITIZE_STRING),
    'po_number' => filter_input(INPUT_GET, 'po_number', FILTER_SANITIZE_STRING),
);
?>


<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label for="date_from">{{ __('Receive Date (From)') }}
            </label>

            <div class="input-group">
                {!! Form::text('date_from', date('d-m-Y'), [ 'class'=>'form-control datepicker', 'placeholder' =>  __('Pick a date'), 'autocomplete'=>'off']) !!}
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="icon-calendar" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="date_to">{{ __('Date (To)') }}
            </label>

            <div class="input-group">
                {!! Form::text('date_to', date('d-m-Y'), [ 'class'=>'form-control datepicker', 'placeholder' =>  __('Pick a date'), 'autocomplete'=>'off']) !!}
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="icon-calendar" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="parent">{{ __('Supplier') }}</label>
            {!! Form::select('supplier', $supplier, null, ['placeholder'=>__('Select'),'class' => 'form-control enable-select2']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="parent">{{ __('Item') }}</label>
            {!! Form::select('item', $item, null, ['placeholder'=>__('Select'),'class' => 'form-control enable-select2']) !!}
        </div>
    </div>
</div>

@endsection

@include('layouts.admin-search-form')
