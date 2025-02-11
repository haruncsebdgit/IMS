@include('errors.validation')
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="seed_multiplication_farm_name" class="d-block">
                <span class="font-weight-bold">{{ __('Supplier') }}</span>
                <span class="text-danger">*</span>
            </label>
            {!! Form::select('supplier_id', $supplier , null, ['class' => 'form-control enable-select2 ' . ($errors->has('supplier_id') ? 'is-invalid' : ''), 'placeholder' => __('Select'), 'required']) !!}
            @if ($errors->has('supplier_id'))
            <div class="invalid-feedback">{{ $errors->first('supplier_id') }}</div>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="buyer_name" class="d-block">
                <span class="font-weight-bold">{{ __('PO Number') }}</span>
                <span class="text-danger">*</span>
            </label>
            {!! Form::text('po_number', null, ['step'=>'any', 'class' => 'form-control ' . ($errors->has('po_number') ? 'is-invalid' : ''), 'required']) !!}
            @if ($errors->has('po_number'))
            <div class="invalid-feedback">{{ $errors->first('po_number') }}</div>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="sale_date" class="d-block">
                <span class="font-weight-bold">{{ __('Receive Date') }}</span>
                <span class="text-danger">*</span>
            </label>

            <div class="input-group">
                {!! Form::text('receive_date', null, ['id'=>'date', 'pattern'=>'(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}', 'class'=>'form-control datepicker '. ($errors->has('receive_date') ? 'is-invalid' : ''),'placeholder' => __('Pick a date'), 'autocomplete'=>'off', 'required']) !!}
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="icon-calendar" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            @if ($errors->has('receive_date'))
            <div style="display: block" class="invalid-feedback">{{ $errors->first('receive_date') }}</div>
            @endif
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="buyer_name" class="d-block">
                <span class="font-weight-bold">{{ __('Invoice No.') }}</span>
                <!-- <span class="text-danger">*</span> -->
            </label>
            {!! Form::text('invoice_no', null, ['step'=>'any', 'class' => 'form-control ' . ($errors->has('invoice_no') ? 'is-invalid' : ''), 'required']) !!}
            @if ($errors->has('invoice_no'))
            <div class="invalid-feedback">{{ $errors->first('invoice_no') }}</div>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="invoice_date" class="d-block">
                <span class="font-weight-bold">{{ __('Invoice Date') }}</span>
                <!-- <span class="text-danger">*</span> -->
            </label>

            <div class="input-group">
                {!! Form::text('invoice_date', null, ['id'=>'date', 'pattern'=>'(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}', 'class'=>'form-control datepicker '. ($errors->has('invoice_date') ? 'is-invalid' : ''),'placeholder' => __('Pick a date'), 'autocomplete'=>'off']) !!}
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="icon-calendar" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            @if ($errors->has('invoice_date'))
            <div style="display: block" class="invalid-feedback">{{ $errors->first('invoice_date') }}</div>
            @endif
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group-prepend">
            <label for="unit_price" class="d-block">
                <span class="font-weight-bold">{{ __('Remarks') }}</span>
                <!-- <span class="small text-danger">*</span> -->
            </label>
            {!! Form::text('supplier_remarks', null, ['step'=>'any', 'class' => 'form-control ']) !!}
        </div>
    </div>


</div>

@include('inventory.item-receive-from-supplier-information.supplier-item-info-form')


<div class="text-right mt-3">
    <button type="submit" class="btn btn-primary">
        <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
        @yield('form_submit_btn')
    </button>
</div>

@push('scripts')
<script src="{{ asset('js/pages/supplier-item-infos.js') }}"></script>
@endpush
