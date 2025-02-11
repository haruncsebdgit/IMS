@include('errors.validation')
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="crop_id" class="d-block">
                <span class="font-weight-bold">{{ __('Crop') }}</span>
                <span class="text-danger">*</span>
            </label>
            {!! Form::select('crop_id', $crops, null, ['class' => 'form-control enable-select2 ' . ($errors->has('crop_id') ? 'is-invalid' : ''), 'placeholder' => __('Select'), 'required']) !!}
            @if ($errors->has('crop_id'))
            <div class="invalid-feedback">{{ $errors->first('crop_id') }}</div>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="crop_type_id" class="d-block">
                <span class="font-weight-bold">{{ __('Crop Type') }}</span>
                {{-- <span class="text-danger">*</span> --}}
            </label>
            {!! Form::select('crop_type_id', cropType(), null, ['class' => 'form-control enable-select2 ' . ($errors->has('crop_type_id') ? 'is-invalid' : ''), 'placeholder' => __('Select'), '']) !!}
            @if ($errors->has('crop_type_id'))
            <div class="invalid-feedback">{{ $errors->first('crop_type_id') }}</div>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="name_en" class="d-block">
                <span class="font-weight-bold">{{ __('Name (English)') }}</span>
                <span class="text-danger">*</span>
            </label>
            {!! Form::text('name_en', null, ['class' => 'form-control ' . ($errors->has('name_en') ? 'is-invalid' : ''), 'required']) !!}
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
            {!! Form::text('name_bn', null, ['class' => 'form-control ' . ($errors->has('name_bn') ? 'is-invalid' : ''), 'required']) !!}
            @if ($errors->has('name_bn'))
            <div class="invalid-feedback">{{ $errors->first('name_bn') }}</div>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="unit_id" class="d-block">
                <span class="font-weight-bold">{{ __('Unit') }}</span>
                {{-- <span class="text-danger">*</span> --}}
            </label>
            {!! Form::select('unit_id', $units, null, ['class' => 'form-control enable-select2 ' . ($errors->has('unit_id') ? 'is-invalid' : ''), 'placeholder' => __('Select'), '']) !!}
            @if ($errors->has('unit_id'))
            <div class="invalid-feedback">{{ $errors->first('unit_id') }}</div>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="crop_lifetime_id" class="d-block">
                <span class="font-weight-bold">{{ __('Crop Lifetime') }}</span>
                {{-- <span class="text-danger">*</span> --}}
            </label>
            {!! Form::select('crop_lifetime_id', cropLifetime(), null, ['class' => 'form-control enable-select2 ' . ($errors->has('crop_lifetime_id') ? 'is-invalid' : ''), 'placeholder' => __('Select'), '']) !!}
            @if ($errors->has('crop_lifetime_id'))
            <div class="invalid-feedback">{{ $errors->first('crop_lifetime_id') }}</div>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="is_active" class="d-block">
                <span class="font-weight-bold">{{ __('Is Active') }}</span>
                {{-- <span class="text-danger">*</span> --}}
            </label>
            <div class="custom-control custom-radio custom-control-inline">
                {!! Form::radio('is_active', 1, true, ['id'=>"is_active1",'class'=>'custom-control-input '. ($errors->has('is_active') ? 'is-invalid' : ''), '%%required%%' ]) !!}
                <label class="custom-control-label" for="is_active1">{{ __("Yes") }}</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                {!! Form::radio('is_active', 0, false, ['id'=>"is_active0",'class'=>'custom-control-input '. ($errors->has('is_active') ? 'is-invalid' : ''), '%%required%%' ]) !!}
                <label class="custom-control-label" for="is_active0">{{ __("No") }}</label>
            </div>
            @if ($errors->has('is_active'))
            <div class="invalid-feedback">{{ $errors->first('is_active') }}</div>
            @endif
        </div>
    </div>

</div>

<div class="text-right">
    <button type="submit" class="btn btn-primary">
        <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
        @yield('form_submit_btn')
    </button>
</div>
