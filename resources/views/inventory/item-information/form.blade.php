@include('errors.validation')
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="name_en" class="d-block">
                <span class="font-weight-bold">{{ __('Name (English)') }}</span>
                <span class="text-danger">*</span>
            </label>
            {!! Form::text('name_en', null, ['required', 'class' => 'form-control ' . ($errors->has('name_en') ? 'is-invalid' : ''), '']) !!}
            @if ($errors->has('name_en'))
            <div class="invalid-feedback">{{ $errors->first('name_en') }}</div>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="name_bn" class="d-block">
                <span class="font-weight-bold">{{ __('Name (Bengali)') }}</span>
                <span class="text-danger">*</span>
            </label>
            {!! Form::text('name_bn', null, [ 'class' => 'form-control ' . ($errors->has('name_bn') ? 'is-invalid' : ''), 'required']) !!}
            @if ($errors->has('name_bn'))
            <div class="invalid-feedback">{{ $errors->first('name_bn') }}</div>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="code_en" class="d-block">
                <span class="font-weight-bold">{{ __('Code (English)') }}</span>
                 <span class="text-danger">*</span>
            </label>
            {!! Form::text('code_en', null, ['required', 'class' => 'form-control ' . ($errors->has('code_en') ? 'is-invalid' : ''), '']) !!}
            @if ($errors->has('code_en'))
            <div class="invalid-feedback">{{ $errors->first('code_en') }}</div>
            @endif
        </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="code_bn" class="d-block">
                    <span class="font-weight-bold">{{ __('Code (Bengali)') }}</span>
                    {{-- <span class="text-danger">*</span> --}}
                </label>
                {!! Form::text('code_bn', null, ['class' => 'form-control ' . ($errors->has('code_bn') ? 'is-invalid' : ''), '']) !!}
                @if ($errors->has('code_bn'))
                <div class="invalid-feedback">{{ $errors->first('code_bn') }}</div>
                @endif
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label for="asset_type" class="d-block">
                    <span class="font-weight-bold">{{ __('Asset Type') }}</span>
                    <span class="text-danger">*</span>
                </label>
                {!! Form::select('asset_type', $assetType, null, ['required' ,'placeholder'=>__('Select'),'class' => 'form-control enable-select2' . ($errors->has('asset_type') ? 'is-invalid' : '')]) !!}
                @if ($errors->has('asset_type'))
                <div class="invalid-feedback">{{ $errors->first('asset_type') }}</div>
                @endif
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label for="category_id" class="d-block">
                    <span class="font-weight-bold">{{ __('Category') }}</span>
                    <span class="text-danger">*</span>
                </label>
                {!! Form::select('category_id', $category, null, ['required', 'placeholder'=>__('Select'),'class' => 'form-control enable-select2' . ($errors->has('category_id') ? 'is-invalid' : '')]) !!}
                @if ($errors->has('category_id'))
                <div class="invalid-feedback">{{ $errors->first('category_id') }}</div>
                @endif
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label for="uom_id" class="d-block">
                    <span class="font-weight-bold">{{ __('UoM') }}</span>
                </label>
                {!! Form::select('uom_id', $uoM, null, ['placeholder'=>__('Select'),'class' => 'form-control enable-select2' . ($errors->has('uom_id') ? 'is-invalid' : '')]) !!}
                @if ($errors->has('uom_id'))
                <div class="invalid-feedback">{{ $errors->first('uom_id') }}</div>
                @endif
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label for="manufacturer_id" class="d-block">
                    <span class="font-weight-bold">{{ __('Manufacturer') }}</span>
                </label>
                {!! Form::select('manufacturer_id', $manufacturer, null, ['placeholder'=>__('Select'),'class' => 'form-control enable-select2' . ($errors->has('manufacturer_id') ? 'is-invalid' : '')]) !!}
                @if ($errors->has('manufacturer_id'))
                <div class="invalid-feedback">{{ $errors->first('manufacturer_id') }}</div>
                @endif
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="model" class="d-block">
                    <span class="font-weight-bold">{{ __('Model') }}</span>
                    {{-- <span class="text-danger">*</span> --}}
                </label>
                {!! Form::text('model', null, ['class' => 'form-control ' . ($errors->has('model') ? 'is-invalid' : ''), '']) !!}
                @if ($errors->has('model'))
                <div class="invalid-feedback">{{ $errors->first('model') }}</div>
                @endif
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label for="part_number" class="d-block">
                    <span class="font-weight-bold">{{ __('Part Number') }}</span>
                    {{-- <span class="text-danger">*</span> --}}
                </label>
                {!! Form::text('part_number', null, ['class' => 'form-control ' . ($errors->has('part_number') ? 'is-invalid' : ''), '']) !!}
                @if ($errors->has('part_number'))
                <div class="invalid-feedback">{{ $errors->first('part_number') }}</div>
                @endif
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label for="remarks" class="d-block">
                    <span class="font-weight-bold">{{ __('Remarks') }}</span>
                    {{-- <span class="text-danger">*</span> --}}
                </label>
                {!! Form::text('remarks', null, ['class' => 'form-control ' . ($errors->has('remarks') ? 'is-invalid' : ''), '']) !!}
                @if ($errors->has('remarks'))
                <div class="invalid-feedback">{{ $errors->first('remarks') }}</div>
                @endif
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label for="is_applied_registration" class="d-block">
                    <span class="font-weight-bold">{{ __('Is Serialized') }}</span>
                    {{-- <span class="text-danger">*</span> --}}
                </label>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('is_serialized', 1, true, ['id'=>"is_serialized1",'class'=>'custom-control-input ' ]) !!}
                    <label class="custom-control-label" for="is_serialized1">{{ __("Yes") }}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('is_serialized', 0, false, ['id'=>"is_serialized0",'class'=>'custom-control-input ' ]) !!}
                    <label class="custom-control-label" for="is_serialized0">{{ __("No") }}</label>
                </div>

            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label for="is_applied_registration" class="d-block">
                    <span class="font-weight-bold">{{ __('Is Active') }}</span>
                    {{-- <span class="text-danger">*</span> --}}
                </label>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('is_active', 1, true, ['id'=>"is_active1",'class'=>'custom-control-input ' ]) !!}
                    <label class="custom-control-label" for="is_active1">{{ __("Yes") }}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('is_active', 0, false, ['id'=>"is_active0",'class'=>'custom-control-input ' ]) !!}
                    <label class="custom-control-label" for="is_active0">{{ __("No") }}</label>
                </div>

            </div>
        </div>

    </div>







<div class="text-right">
    <button type="submit" class="btn btn-primary">
        <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
        @yield('form_submit_btn')
    </button>
</div>

@push('scripts')
{{-- <script src="{{ asset('js/libs/datatables.min.js') }}"></script> --}}


<script src="{{ asset('js/libs/bootstrap-notify.min.js') }}"></script>
@endpush
