<div class="card">
    <div class="card-header text-primary font-weight-bold text-center">
        {{ __('Item Information') }}
    </div>
    <div class="card-body">
        <div class="row">

            <div class="col-sm-3">
                <div class="form-group extended-form-group mt-4 mt-sm-0">
                    <label for="fish_species_id" class="small">
                        <span class="font-weight-bold">{{ __('Category of Item') }}</span>
                        <span class="small text-danger">*</span>
                    </label>
                    <div class="">
                        {!! Form::select(null, $itemCategory , null, ['onchange'=>'validateInput(this)', 'id'=>'item-category','class'=>'custom-select ' ,'placeholder' => __('Select') ]) !!}
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group extended-form-group mt-4 mt-sm-0">
                    <label for="fish_species_id" class="small">
                        <span class="font-weight-bold">{{ __('Item') }}</span>
                        <span class="small text-danger">*</span>
                    </label>
                    <div class="">
                        {!! Form::select('item_repeater', $item , null, ['onchange'=>'validateInput(this)', 'id'=>'item','class'=>'custom-select ' ,'placeholder' => __('Select') ]) !!}
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group extended-form-group mt-4 mt-sm-0">
                    <label for="brood_received_female" class="small">
                        <span class="small text-danger">*</span>
                        <span class="font-weight-bold">{{ __('Quantity') }}</span>

                    </label>
                    {!! Form::number('quantity_repeater', null, ['step'=>'any', 'id'=>'quantity', 'class' => 'form-control ', 'placeholder' => __('')]) !!}
                    {!! Form::hidden('available_item_qty', null, ['id'=>'available-item-quantity']) !!}
                    <small id="available-qty" class="form-text text-primary">
                    </small>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group extended-form-group mt-4 mt-sm-0">
                    <label for="unit_price" class="small">
                        <span class="font-weight-bold">{{ __('Remarks') }}</span>
                        <!-- <span class="small text-danger">*</span> -->
                    </label>
                    {!! Form::text(null, null, ['step'=>'any', 'id'=>'remarks', 'class' => 'form-control ']) !!}
                </div>
            </div>

        </div>

        <div class="text-right">
            <button type="button" class="btn btn-outline-primary" id="btn-add-supplier-item-info">
                <i class="icon-add mr-1" aria-hidden="true"></i>
                {{ __("Add") }}
            </button>
        </div>

        <br>
        {!! Form::hidden('row_uid', null, ['id'=>'row-id']) !!}
        @include('inventory.item-request.item-list')
    </div>
</div>
