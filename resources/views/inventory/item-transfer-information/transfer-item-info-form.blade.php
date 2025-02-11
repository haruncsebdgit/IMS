<div class="card">
    <div class="card-header text-primary font-weight-bold text-center">
        {{ __('Item Information') }}
    </div>
    <div class="card-body">
        <div class="row">
            
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
                    <label for="sale_info_type" class="small">
                        <span class="font-weight-bold">{{ __('Item Status') }}</span>
                        <span class="small text-danger">*</span>
                    </label>
                    <div class="">
                    {!! Form::select('item_status_repeater', $status , null, ['onchange'=>'validateInput(this)', 'id'=>'item-status','class'=>'custom-select ' ,'placeholder' => __('Select') ]) !!}
                    </div>
                    </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group extended-form-group mt-4 mt-sm-0">
                    <label for="brood_received_female" class="small">
                    <span class="small text-danger">*</span>
                        <span class="font-weight-bold">{{ __('Quantity') }}</span>
                        
                    </label>
                    {!! Form::number('quantity_repeater', null, ['step'=>'any',  'id'=>'quantity', 'class' => 'form-control ', 'placeholder' => __('')]) !!}
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group extended-form-group mt-4 mt-sm-0">
                    <label for="serial" class="small">
                        <span class="font-weight-bold">{{ __('Serial') }}</span>
                        
                    </label>
                    {!! Form::text('serial_repeater', null, ['step'=>'any',   'id'=>'serial', 'class' => 'form-control ', 'placeholder' => __('')]) !!}
                </div>
            </div>


    

            <div class="col-sm-3">
                <div class="form-group extended-form-group mt-4 mt-sm-0">
                    <label for="unit_price" class="small">
                        <span class="font-weight-bold">{{ __('Fixed Asset Id') }}</span>
                        <span class="small text-danger">*</span>
                    </label>
                    {!! Form::text('fixed_asset_repeater', null, ['step'=>'any',  'id'=>'fixed-asset-id', 'class' => 'form-control ']) !!}
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group extended-form-group mt-4 mt-sm-0">
                    <label for="unit_price" class="small">
                        <span class="font-weight-bold">{{ __('Remarks') }}</span>
                        <!-- <span class="small text-danger">*</span> -->
                    </label>
                    {!! Form::text('remarks_repeater', null, ['step'=>'any',  'id'=>'remarks', 'class' => 'form-control ']) !!}
                </div>
            </div>

            <div class="col-sm-4">
                <button type="button" class="btn btn-outline-primary" id="btn-add-supplier-item-info">
                    <i class="icon-add mr-1" aria-hidden="true"></i>
                    {{ __("Add") }}
                </button>
            </div>

        </div>
        
        <br>
        {!! Form::hidden('row_uid', null, ['id'=>'row-id']) !!}
        @include('inventory.item-transfer-information.transfer-item-info-list')
        </div>
</div>
