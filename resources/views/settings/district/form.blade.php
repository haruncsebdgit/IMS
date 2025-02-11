<?php
$district = $district ?? '';
$lang     = config('app.locale');
?>

<section class="card">
    <div class="card-body">

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    @php $_division = setDefaultValue('division_id', $district); @endphp
                    <label for="divisions" class="font-weight-bold">
                        {{ __('Division') }}
                        <sup class="text-danger">*</sup>
                    </label>
                    <div class="input-group">
                        <select name="division_id" id="divisions" class="form-control" required>
                            <option value="">{{ __('Select a Division') }}</option>
                            @php $division_name = "name_$lang"; @endphp
                            @foreach($divisions as $division)
                            <option value="{{ $division->id }}" {{ $division->id == $_division ? 'selected="selected"' : '' }}>
                                {{ $division->$division_name ?? $division->name_en }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-6">
                
            <div class="form-group">
                    @php $_division = setDefaultValue('region_id', $district); @endphp
                    <label for="divisions" class="font-weight-bold">
                        {{ __('Regions') }}
                    </label>
                    <div class="input-group">
                        <select name="region_id" id="region_id" class="form-control" >
                            <option value="">{{ __('Select a Region') }}</option>
                            @php $region_name = "name_$lang"; @endphp
                            @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ $region->id == $_division ? 'selected="selected"' : '' }}>
                                {{ $region->$region_name ?? $region->name_en }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>


        </div>



        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name-en" class="font-weight-bold">
                        {{ __('Name (in English)') }}
                        <sup class="text-danger">*</sup>
                    </label>
                    <input type="text" name="name_en" value="{{ setDefaultValue('name_en', $district) }}" id="name-en" class="form-control {{ $errors->has('name_en') ? 'is-invalid' : '' }}" autocomplete="off" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name-bn" class="font-weight-bold">
                        {{ __('Name (in Bengali)') }}
                        <sup class="text-danger">*</sup>
                    </label>
                    <input type="text" name="name_bn" value="{{ setDefaultValue('name_bn', $district) }}" id="name-bn" class="form-control {{ $errors->has('name_bn') ? 'is-invalid' : '' }}" autocomplete="off" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="geo-code" class="font-weight-bold">
                        {{ __('Geo Code') }}
                        <sup class="text-danger">*</sup>
                    </label>
                    <input type="number" name="geo_code" value="{{ setDefaultValue('geo_code', $district) }}" id="geo-code" class="form-control {{ $errors->has('geo_code') ? 'is-invalid' : '' }}" placeholder="{{ __('In Numbers') }}" autocomplete="off" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    @php $_is_active = setDefaultValue('is_active', $district, 1); @endphp
                    <label for="district-status" class="font-weight-bold">{{ __('Status') }}</label>
                    <select name="is_active" id="district-status" class="custom-select">
                        <option value="1" {{ 1 === $_is_active ? 'selected="selected"' : '' }}>{{ __('Active') }}</option>
                        <option value="0" {{ 0 === $_is_active ? 'selected="selected"' : '' }}>{{ __('Inactive') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="latitude" class="font-weight-bold">
                        {{ __('Latitude') }}
                    </label>
                    <input type="text" name="latitude" value="{{ setDefaultValue('latitude', $district) }}" id="latitude" class="form-control {{ $errors->has('latitude') ? 'is-invalid' : '' }}" autocomplete="off" placeholder="55.415224000000">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="longitude" class="font-weight-bold">
                        {{ __('Longitude') }}
                    </label>
                    <input type="text" name="longitude" value="{{ setDefaultValue('longitude', $district) }}" id="longitude" class="form-control {{ $errors->has('longitude') ? 'is-invalid' : '' }}" autocomplete="off" placeholder="20.454645645100">
                </div>
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary">
                <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
                @yield('form_submit_btn')
            </button>
        </div>

    </div>
    <!-- /.card-body -->
</section>
<!-- /.card -->

@csrf