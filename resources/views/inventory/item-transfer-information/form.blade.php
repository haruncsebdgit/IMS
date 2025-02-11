@include('errors.validation')

{!! Form::hidden('organization_id', auth()->user()->organization_id) !!}
<div class="row">

    <div class="col-sm-4">
        <div class="form-group">
            <label for="sale_date" class="d-block">
                <span class="font-weight-bold">{{ __('Transfer Date') }}</span>
                <span class="text-danger">*</span>
            </label>

            <div class="input-group">
                {!! Form::text('transfer_date', null, ['id'=>'date', 'pattern'=>'(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}', 'class'=>'form-control datepicker '. ($errors->has('transfer_date') ? 'is-invalid' : ''),'placeholder' => __('Pick a date'), 'autocomplete'=>'off', 'required']) !!}
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="icon-calendar" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            @if ($errors->has('transfer_date'))
            <div style="display: block" class="invalid-feedback">{{ $errors->first('transfer_date') }}</div>
            @endif
        </div>
    </div>

    <div class="col-sm-4">
            <div class="form-group">
                <label for="seed_multiplication_farm_name" class="d-block">
                    <span class="font-weight-bold">{{ __('Inventory Center From') }}</span>
                    <!-- <span class="text-danger">*</span> -->
                </label>
                {!! Form::select('inventory_cost_center_from', $inventory, null, ['class' => 'form-control enable-select2 ' . ($errors->has('inventory_cost_center_from') ? 'is-invalid' : ''), 'placeholder' => __('Select')]) !!}
                @if ($errors->has('inventory_cost_center_from'))
                <div class="invalid-feedback">{{ $errors->first('inventory_cost_center_from') }}</div>
                @endif
            </div>
    </div>
    

    <div class="col-sm-4">
            <div class="form-group">
                <label for="inventory_cost_center_to" class="d-block">
                    <span class="font-weight-bold">{{ __('Inventory Center To') }}</span>
                    <span class="text-danger">*</span>
                </label>
                {!! Form::select('inventory_cost_center_to', $inventory, null, ['class' => 'form-control enable-select2 ' . ($errors->has('inventory_cost_center_to') ? 'is-invalid' : ''), 'placeholder' => __('Select' ) ,  'required']) !!}
                @if ($errors->has('inventory_cost_center_to'))
                <div class="invalid-feedback">{{ $errors->first('inventory_cost_center_to') }}</div>
                @endif
            </div>
    </div>

    
    
        <div class="col-sm-4">
                <div class="form-group">
                    <label for="unit_price" class="d-block">
                        <span class="font-weight-bold">{{ __('Remarks') }}</span>
                        <!-- <span class="small text-danger">*</span> -->
                    </label>
                    {!! Form::text('transfer_remarks', null, ['step'=>'any', 'class' => 'form-control ']) !!}
                </div>
        </div>
    
 </div>



 @include('inventory.item-transfer-information.transfer-item-info-form')


<div class="text-right mt-3">
    <button type="submit" class="btn btn-primary">
        <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
        @yield('form_submit_btn')
    </button>
</div>

@push('scripts')
<script src="{{ asset('js/pages/transfer-item-infos.js') }}"></script>
@endpush