@include('errors.validation')
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="sale_date" class="d-block">
                <span class="font-weight-bold">{{ __('Return Date') }}</span>
                <span class="text-danger">*</span>
            </label>

            <div class="input-group">
                {!! Form::text('return_date', null, ['id'=>'date', 'pattern'=>'(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}', 'class'=>'form-control datepicker '. ($errors->has('return_date') ? 'is-invalid' : ''),'placeholder' => __('Pick a date'), 'autocomplete'=>'off', 'required']) !!}
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="icon-calendar" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            @if ($errors->has('return_date'))
            <div style="display: block" class="invalid-feedback">{{ $errors->first('return_date') }}</div>
            @endif
        </div>
    </div>

    <div class="col-sm-8">
        <div class="form-group-prepend">
            <label for="unit_price" class="d-block">
                <span class="font-weight-bold">{{ __('Remarks') }}</span>
                <!-- <span class="small text-danger">*</span> -->
            </label>
            {!! Form::text('remarks', null, ['class' => 'form-control ']) !!}
        </div>
    </div>


</div>

@include('inventory.item-return.item-form')


<div class="text-right mt-3">
    <button type="submit" class="btn btn-primary">
        <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
        @yield('form_submit_btn')
    </button>
</div>

@push('scripts')
<script src="{{ asset('js/pages/request-item.js') }}"></script>
@endpush
