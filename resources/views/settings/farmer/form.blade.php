@include('errors.validation')


<?php
$farmerInfo = isset($farmerInfo) ? $farmerInfo : null;
?>
<x-package-location :divisionId="$farmerInfo->division_id ?? null" :districtId="$farmerInfo->district_id ?? null" :upazilaId="$farmerInfo->upazila_id ?? null" :unionId="$farmerInfo->union_id ?? null" :columnInRow=4>

    <input type="hidden" name="organization_id" value="{{auth()->user()->organization_id}}">

    <div class="col-sm-4">
        <div class="form-group">
            <label for="farmer-name-en" class="d-block">
                <span class="font-weight-bold">{{ __('Name (in English)') }}</span>
                <span class="text-danger">*</span>
            </label>

            {!! Form::text('name_en', null, [ 'class'=>'form-control'. ($errors->has('name_en') ? 'is-invalid' : ''), 'autocomplete'=>'off','required']) !!}
            @if ($errors->has('name_en'))
            <div style="display: block" class="invalid-feedback">{{ $errors->first('name_en') }}</div>
            @endif
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="dls-demo-end-date" class="d-block">
                <span class="font-weight-bold">{{ __('Name (in Bengali)') }}</span>
                <span class="text-danger">*</span>
            </label>
            {!! Form::text('name_bn', null, [ 'class'=>'form-control'. ($errors->has('name_bn') ? 'is-invalid' : ''), 'autocomplete'=>'off','required']) !!}
            @if ($errors->has('name_bn'))
            <div style="display: block" class="invalid-feedback">{{ $errors->first('name_bn') }}</div>
            @endif
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="dae-primary-reporting-date" class="d-block">
                <span class="font-weight-bold">{{ __('Date of Birth') }}</span>
                <span class="text-danger">*</span>
            </label>

            <div class="input-group">
                {!! Form::text('date_of_birth', null, ['pattern'=>'(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}', 'class'=>'form-control datepicker '. ($errors->has('date_of_birth') ? 'is-invalid' : ''),'placeholder' => __('Pick a date'), 'autocomplete'=>'off','required']) !!}
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="icon-calendar" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            @if ($errors->has('date_of_birth'))
            <div style="display: block" class="invalid-feedback">{{ $errors->first('date_of_birth') }}</div>
            @endif
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="gender" class="d-block">
                <span class="font-weight-bold">{{ __('Gender') }}</span>
                <span class="text-danger">*</span>
            </label>
            {!! Form::select('gender', $genderList, null, ['class' => 'form-control enable-select2 ' . ($errors->has('gender') ? 'is-invalid' : ''),'placeholder' => __('Select'), 'required']) !!}
            @if ($errors->has('gender'))
            <div class="invalid-feedback">{{ $errors->first('gender') }}</div>
            @endif
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="mobile-no" class="d-block">
                <span class="font-weight-bold">{{ __('Mobile No.') }}</span>

            </label>
            {!! Form::number('mobile_no', null, ['class' => 'form-control ' . ($errors->has('mobile_no') ? 'is-invalid' : '')]) !!}
            @if ($errors->has('mobile_no'))
            <div class="invalid-feedback">{{ $errors->first('mobile_no') }}</div>
            @endif
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="nid" class="d-block">
                <span class="font-weight-bold">{{ __('NID') }}</span>
                <span class="text-danger">*</span>
            </label>
            {{-- <input type="number" id="person-nid" class="form-control form-control-sm" placeholder="In Numbers" autocomplete="off" inputmode="numeric" pattern="^([0-9]{10})$|^([0-9]{13})$|^([0-9]{17})$"> --}}
            {!! Form::text('nid', null, ['inputmode'=>"numeric", 'pattern'=>"^([0-9]{10})$|^([0-9]{13})$|^([0-9]{17})$", 'autocomplete'=>"off", 'class' => 'form-control ' . ($errors->has('nid') ? 'is-invalid' : ''), 'required']) !!}
            @if ($errors->has('nid'))
            <div class="invalid-feedback">{{ $errors->first('nid') }}</div>
            @else
            <div class="invalid-feedback">{{ __('NID Numbers needs to be 10, 13, or 17 digits') }}</div>
            @endif
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="village" class="d-block">
                <span class="font-weight-bold">{{ __('Village') }}</span>
                <span class="text-danger">*</span>
            </label>
            {!! Form::text('village', null, ['class' => 'form-control ' . ($errors->has('village') ? 'is-invalid' : ''), 'required']) !!}
            @if ($errors->has('village'))
            <div class="invalid-feedback">{{ $errors->first('village') }}</div>
            @endif
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="is_ethnic" class="d-block">
                <span class="font-weight-bold">{{ __('Is Ethnic') }}</span>
                <span class="text-danger">*</span>
            </label>
            <div class="custom-control custom-radio custom-control-inline">
                {!! Form::radio('is_ethnic', 1, true, ['id'=>"is_ethnic1",'class'=>'custom-control-input '. ($errors->has('is_ethnic') ? 'is-invalid' : ''), 'required' ]) !!}
                <label class="custom-control-label" for="is_ethnic1">{{ __("Yes") }}</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                {!! Form::radio('is_ethnic', 0, false, ['id'=>"is_ethnic0",'class'=>'custom-control-input '. ($errors->has('is_ethnic') ? 'is-invalid' : ''), 'required' ]) !!}
                <label class="custom-control-label" for="is_ethnic0">{{ __("No") }}</label>
            </div>
            @if ($errors->has('is_ethnic'))
            <div class="invalid-feedback">{{ $errors->first('is_ethnic') }}</div>
            @endif
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="ethnic_community_id" class="d-block">
                <span class="font-weight-bold">{{ __('Ethnic Community') }}</span>
            </label>
            {!! Form::select('ethnic_community_id', $ethnicCommunity, null, ['class' => 'form-control enable-select2 ' . ($errors->has('ethnic_community_id') ? 'is-invalid' : ''), 'placeholder' => __('Select'), '']) !!}
            @if ($errors->has('ethnic_community_id'))
            <div class="invalid-feedback">{{ $errors->first('ethnic_community_id') }}</div>
            @endif
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="father_name" class="d-block">
                <span class="font-weight-bold">{{ __('Father Name') }}</span>
            </label>
            {!! Form::text('father_name', null, ['class' => 'form-control ' . ($errors->has('father_name') ? 'is-invalid' : '')]) !!}
            @if ($errors->has('father_name'))
            <div class="invalid-feedback">{{ $errors->first('father_name') }}</div>
            @endif
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="mother_name" class="d-block">
                <span class="font-weight-bold">{{ __('Mother Name') }}</span>
            </label>
            {!! Form::text('mother_name', null, ['class' => 'form-control ' . ($errors->has('mother_name') ? 'is-invalid' : '')]) !!}
            @if ($errors->has('mother_name'))
            <div class="invalid-feedback">{{ $errors->first('mother_name') }}</div>
            @endif
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="spouse_name" class="d-block">
                <span class="font-weight-bold">{{ __('Spouse Name') }}</span>
            </label>
            {!! Form::text('spouse_name', null, ['class' => 'form-control ' . ($errors->has('spouse_name') ? 'is-invalid' : ''), '']) !!}
            @if ($errors->has('spouse_name'))
            <div class="invalid-feedback">{{ $errors->first('spouse_name') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            @php $_is_active = setDefaultValue('is_active', $farmerInfo, 1); @endphp
            <label for="technology-status" class="font-weight-bold">{{ __('Status') }}</label>
            <select name="is_active" id="division-status" class="custom-select">
                <option value="1" {{ 1 === $_is_active ? 'selected="selected"' : '' }}>{{ __('Active') }}</option>
                <option value="0" {{ 0 === $_is_active ? 'selected="selected"' : '' }}>{{ __('Inactive') }}</option>
            </select>
        </div>
    </div>

</x-package-location>

<div class="text-right">
    <button type="submit" class="btn btn-primary">
        <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
        @yield('form_submit_btn')
    </button>
</div>
