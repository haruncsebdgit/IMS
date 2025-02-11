@include('errors.validation')

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="cig_name" class="d-block">
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
            <label for="cig_name" class="d-block">
                <span class="font-weight-bold">{{ __('Name (Bangla)') }}</span>
                <!-- <span class="text-danger">*</span> -->
            </label>
            {!! Form::text('name_bn', null, ['class' => 'form-control ' . ($errors->has('name_bn') ? 'is-invalid' : '')]) !!}
            @if ($errors->has('name_bn'))
            <div class="invalid-feedback">{{ $errors->first('name_bn') }}</div>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="cig_name" class="d-block">
                <span class="font-weight-bold">{{ __('Contact No.') }}</span>
                <!-- <span class="text-danger">*</span> -->
            </label>
            {!! Form::number('contact_no', null, ['class' => 'form-control ' . ($errors->has('contact_no') ? 'is-invalid' : '')]) !!}
            @if ($errors->has('contact_no'))
            <div class="invalid-feedback">{{ $errors->first('contact_no') }}</div>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="cig_name" class="d-block">
                <span class="font-weight-bold">{{ __('Email') }}</span>
                <!-- <span class="text-danger">*</span> -->
            </label>
            {!! Form::email('email', null, ['class' => 'form-control ' . ($errors->has('email') ? 'is-invalid' : '')]) !!}
            @if ($errors->has('email'))
            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="website" class="d-block">
                <span class="font-weight-bold">{{ __('Website') }}</span>
                <!-- <span class="text-danger">*</span> -->
            </label>
            {!! Form::email('website', null, ['class' => 'form-control ' . ($errors->has('website') ? 'is-invalid' : '')]) !!}
            @if ($errors->has('website'))
            <div class="invalid-feedback">{{ $errors->first('website') }}</div>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="cig_address" class="d-block">
                <span class="font-weight-bold">{{ __('Address') }}</span>
                <!-- <span class="text-danger">*</span> -->
            </label>
            {!! Form::textarea('address', null, ['rows'=>2, 'class' => 'form-control ' . ($errors->has('address') ? 'is-invalid' : '')]) !!}
            @if ($errors->has('address'))
            <div class="invalid-feedback">{{ $errors->first('address') }}</div>
            @endif
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="bank_branch" class="d-block">
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
