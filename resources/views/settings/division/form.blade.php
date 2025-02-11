<?php $division = $division ?? ''; ?>
<section class="card">
    <div class="card-body">
        <div class="row">

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name-en" class="font-weight-bold">
                        {{ __('Name (in English)') }}
                        <sup class="text-danger">*</sup>
                    </label>
                    <input type="text" name="name_en"  value="{{ setDefaultValue('name_en', $division) }}" id="name-en" class="form-control {{ $errors->has('name_en') ? 'is-invalid' : '' }}" autocomplete="off">
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name-bn" class="font-weight-bold">
                        {{ __('Name (in Bengali)') }}
                        <sup class="text-danger">*</sup>
                    </label>
                    <input type="text" name="name_bn" value="{{ setDefaultValue('name_bn', $division) }}" id="name-bn" class="form-control {{ $errors->has('name_bn') ? 'is-invalid' : '' }}" autocomplete="off" required>
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
                    <input type="number" name="geo_code"  value="{{ setDefaultValue('geo_code', $division) }}" id="geo-code" class="form-control {{ $errors->has('geo_code') ? 'is-invalid' : '' }}" placeholder="{{ __('In Numbers') }}" autocomplete="off" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    @php $_is_active = setDefaultValue('is_active', $division, 1); @endphp
                    <label for="division-status" class="font-weight-bold">{{ __('Status') }}</label>
                    <select name="is_active" id="division-status" class="custom-select">
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
                    <input type="text" name="latitude" value="{{ setDefaultValue('latitude', $division) }}" id="latitude" class="form-control {{ $errors->has('latitude') ? 'is-invalid' : '' }}" placeholder="" autocomplete="off" >
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="longitude" class="font-weight-bold">
                        {{ __('Longitude') }}
                    </label>
                    <input type="text" name="longitude" value="{{ setDefaultValue('longitude', $division) }}" id="longitude" class="form-control {{ $errors->has('longitude') ? 'is-invalid' : '' }}" placeholder="" autocomplete="off" >
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
