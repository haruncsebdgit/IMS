<?php
$thanaUpazila = $thanaUpazila ?? '';
$lang         = config('app.locale');
?>
<section class="card">
    <div class="card-body">

        <div class="form-group">
            @php $_district = setDefaultValue('district_id', $thanaUpazila); @endphp
            <label for="districts" class="font-weight-bold">
                {{ __('District') }}
                <sup class="text-danger">*</sup>
            </label>
            <div class="input-group">
                <select name="district_id" id="districts" class="form-control enable-select2" required>
                    <option value="">{{ __('Select a District') }}</option>
                    @foreach($districts as $district)
                        @php $district_name = "name_$lang"; @endphp
                        <option value="{{ $district->id }}" {{ $district->id == $_district ? 'selected="selected"' : '' }} >
                            {{ $district->$district_name ?? $district->name_en }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name-en" class="font-weight-bold">
                        {{ __('Name (in English)') }}
                        <sup class="text-danger">*</sup>
                    </label>
                    <input type="text" name="name_en" value="{{ setDefaultValue('name_en', $thanaUpazila) }}" id="name-en" class="form-control {{ $errors->has('name_en') ? 'is-invalid' : '' }}" autocomplete="off" required>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name-bn" class="font-weight-bold">
                        {{ __('Name (in Bengali)') }}
                        <sup class="text-danger">*</sup>
                    </label>
                    <input type="text" name="name_bn" value="{{ setDefaultValue('name_bn', $thanaUpazila) }}" id="name-bn" class="form-control {{ $errors->has('name_bn') ? 'is-invalid' : '' }}" autocomplete="off"  required>
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
                    <input type="number" name="geo_code" value="{{ setDefaultValue('geo_code', $thanaUpazila) }}" id="geo-code" class="form-control {{ $errors->has('geo_code') ? 'is-invalid' : '' }}" placeholder="{{ __('In Numbers') }}" autocomplete="off" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="types" class="font-weight-bold">
                        {{ __('Type') }}
                        <sup class="text-danger">*</sup>
                    </label>
                    @php $_type = setDefaultValue('type', $thanaUpazila, 'Both'); @endphp
                    <div class="input-group">
                        <select name="type" id="types" class="form-control" required>
                            <option value="">{{ __('Select a Type') }}</option>
                            <option value="Thana" {{ "Thana" == $_type ? 'selected="selected"' : '' }}>{{ __('Thana') }}</option>
                            <option value="Upazila" {{ "Upazila" == $_type ? 'selected="selected"' : '' }}>{{ __('Upazila') }}</option>
                            <option value="Both" {{ "Both" == $_type ? 'selected="selected"' : '' }}>{{ __('Both') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="latitude" class="font-weight-bold">
                        {{ __('Latitude') }}
                    </label>
                    <input type="text" name="latitude" value="{{ setDefaultValue('latitude', $thanaUpazila) }}" id="latitude" class="form-control {{ $errors->has('latitude') ? 'is-invalid' : '' }}" autocomplete="off" >
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="longitude" class="font-weight-bold">
                        {{ __('Longitude') }}
                    </label>
                    <input type="text" name="longitude" value="{{ setDefaultValue('longitude', $thanaUpazila) }}" id="longitude" class="form-control {{ $errors->has('longitude') ? 'is-invalid' : '' }}" autocomplete="off" >
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="url" class="font-weight-bold">
                        {{ __('URL') }}
                    </label>
                    <input type="text" name="url" value="{{ setDefaultValue('url', $thanaUpazila) }}" id="url" class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" autocomplete="off" >
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    @php $_is_active = setDefaultValue('is_active', $thanaUpazila); @endphp
                    <label for="division-status" class="font-weight-bold">{{ __('Status') }}</label>

                    <select name="is_active" id="division-status" class="custom-select">
                            <option value="1" {{ 1 === $_is_active ? 'selected="selected"' : '' }}>{{ __('Active') }}</option>
                            <option value="0" {{ 0 === $_is_active ? 'selected="selected"' : '' }}>{{ __('Inactive') }}</option>
                        </select>
                </div>
            </div>
            <div class="col-sm-4 text-right mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
                    @yield('form_submit_btn')
                </button>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</section>
<!-- /.card -->

@csrf
