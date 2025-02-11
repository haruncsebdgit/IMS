<div class="row">
    @if($isShowDivisions)
        <div class="col-sm-{{ $columnInRow }}">
            <div class="form-group">
                <label for="division_id" class="d-block">
                @if(auth()->user()->organization_id == config('app.organization_id_dae'))
                    <span class="font-weight-bold {{ $isShowLabel ? '' : 'd-none' }}">{{ __('Regions') }}</span>
                @else 
                    <span class="font-weight-bold {{ $isShowLabel ? '' : 'd-none' }}">{{ __('Division') }}</span>
                @endif 
                    <span class="text-danger {{ $isRequiredDivisions ? '' : 'd-none' }}">*</span>
                </label>
                {!! Form::select('division_id', $divisions, $divisionId, [$isRequiredDivisions, $isDisabledDivisions, 'id'=>'division' ,'class' => 'form-control enable-select2 ' . ($errors->has('division_id') ? 'is-invalid' : '') ,'placeholder' => __('Select')]) !!}
                @if ($errors->has('division_id'))
                <div class="invalid-feedback">{{ $errors->first('division_id') }}</div>
                @endif
            </div>
        </div>
        @if (!empty ($isDisabledDivisions))
            {!! Form::hidden('division_id', $divisionId) !!}
        @endif
    @endif
    @if ($isShowDistricts)
        <div class="col-sm-{{ $columnInRow }}">
            <div class="form-group">
                <label for="district_id" class="d-block">
                    <span class="font-weight-bold {{ $isShowLabel ? '' : 'd-none' }}">{{ __('District') }}</span>
                    <span class="text-danger {{ $isRequiredDistricts ? '' : 'd-none' }}">*</span>
                </label>
                {!! Form::select('district_id', $districts, $districtId, [$isRequiredDistricts, $isDisabledDistricts, 'id'=>'district' ,'class' => 'form-control enable-select2 ' . ($errors->has('district_id') ? 'is-invalid' : ''), 'placeholder' => __('Select')]) !!}
                @if ($errors->has('district_id'))
                <div class="invalid-feedback">{{ $errors->first('district_id') }}</div>
                @endif
            </div>
        </div>
        @if (!empty ($isDisabledDistricts))
            {!! Form::hidden('district_id', $districtId) !!}
        @endif
    @endif
    @if($isShowUpazilas)
        <div class="col-sm-{{ $columnInRow }}">
            <div class="form-group">
                <label for="upazila_id" class="d-block">
                    <span class="font-weight-bold {{ $isShowLabel ? '' : 'd-none' }}">{{ __('Upazila') }}</span>
                    <span class="text-danger {{ $isRequiredUpazilas ? '' : 'd-none' }}">*</span>
                </label>
                {!! Form::select('upazila_id', $upazilas, $upazilaId, [$isRequiredUpazilas, $isDisabledUpazilas, 'id'=>"thana-upazila", 'class' => 'form-control enable-select2 ' . ($errors->has('upazila_id') ? 'is-invalid' : ''), 'placeholder' => __('Select')]) !!}
                @if ($errors->has('upazila_id'))
                <div class="invalid-feedback">{{ $errors->first('upazila_id') }}</div>
                @endif
            </div>
        </div>
        @if (!empty ($isDisabledUpazilas))
            {!! Form::hidden('upazila_id', $upazilaId) !!}
        @endif
    @endif
    @if($isShowUnions)
        <div class="col-sm-{{ $columnInRow }}">
            <div class="form-group">
                <label for="union_id" class="d-block">
                    <span class="font-weight-bold {{ $isShowLabel ? '' : 'd-none' }}">{{ __('Union') }}</span>
                    <span class="text-danger {{ $isRequiredUnions ? '' : 'd-none' }}">*</span>
                </label>
                {!! Form::select('union_id', $unions, $unionId, [$isRequiredUnions, $isDisabledUnions, 'id'=>"union-ward", 'class' => 'form-control enable-select2 ' . ($errors->has('union_id') ? 'is-invalid' : ''), 'placeholder' => __('Select')]) !!}
                @if ($errors->has('union_id'))
                <div class="invalid-feedback">{{ $errors->first('union_id') }}</div>
                @endif
            </div>
        </div>
        @if (!empty ($isDisabledUnions))
            {!! Form::hidden('union_id', $unionId) !!}
        @endif
    @endif

    {{ $slot }}
</div>
