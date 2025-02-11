<?php
    $unionWardInfo = $unionWardInfo ?? '';
    $lang          = config('app.locale');
?>

<div class="row">
    <div class="col-sm-9">
        <section class="card">
            <div class="card-body">
                <p class="mb-20 text-info">
                    <i class="icon-exclamation" aria-hidden="true"></i>
                    {!! __('All fields marked with an asterisk (*) are required.') !!}
                </p>


                <div class="row">
                    <div class="col-sm-6">
                        <!-- FIELD: TYPE -->
                        <div class="form-group">
                            <label for="types" class="font-weight-bold">
                                {{ __('Type') }}
                                <sup class="text-danger">*</sup>
                            </label>

                            @php $_type = setDefaultValue('type', $unionWardInfo, 'Union'); @endphp

                            <div class="input-group">
                                <select name="type" id="types" class="custom-select form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" required>
                                    {{--<option value="">{{ __('Select a Type') }}</option>--}}
                                    <option value="Union" {{ "Union" == $_type ? 'selected="selected"' : '' }}>
                                        {{ __('Union') }}
                                    </option>
                                </select>

                                @if ($errors->has('type'))
                                    <div class="invalid-feedback">{{ $errors->first('type') }}</div>
                                @else
                                    <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <!-- FIELD: UPAZILA ID -->
                        <div class="form-group">
                            <label for="thana-upazila" class="font-weight-bold">
                                {{ __('Upazila') }}
                                <sup class="text-danger">*</sup>
                            </label>

                            @php $_thana_upazila_id = setDefaultValue('thana_upazila_id', $unionWardInfo); @endphp

                            <div class="input-group">
                                <select name="thana_upazila_id" id="thana-upazila" class="form-control enable-select2 {{ $errors->has('thana_upazila_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">{{ __('Select a Upazila') }}</option>
                                    @if(!empty($thanaUpazilas))
                                        @foreach($thanaUpazilas as $value)
                                            @php $thana_upazila_name = "name_$lang"; @endphp

                                            <option value="{{ $value->id }}" {{ $value->id == $_thana_upazila_id ? 'selected="selected"' : '' }} >
                                                {{ $value->$thana_upazila_name ?? $value->name_en }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>

                                @if ($errors->has('thana_upazila_id'))
                                    <div class="invalid-feedback">{{ $errors->first('thana_upazila_id') }}</div>
                                @else
                                    <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <!-- FIELD: NAME (ENGLISH) -->
                        <div class="form-group">
                            <label for="name-en" class="font-weight-bold">
                                {{ __('Name (in English)') }}
                                <sup class="text-danger">*</sup>
                            </label>

                            @php $_name_en = setDefaultValue('name_en', $unionWardInfo); @endphp

                            <input type="text" name="name_en" value="{{ $_name_en }}" id="name-en" class="form-control {{ $errors->has('name_en') ? 'is-invalid' : '' }}" placeholder="" autocomplete="off" required>

                            @if ($errors->has('name_en'))
                                <div class="invalid-feedback">{{ $errors->first('name_en') }}</div>
                            @else
                                <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <!-- FIELD: NAME (BENGALI) -->
                        <div class="form-group">
                            <label for="name-bn" class="font-weight-bold">
                                {{ __('Name (in Bengali)') }}
                                <sup class="text-danger">*</sup>
                            </label>

                            @php $_name_bn = setDefaultValue('name_bn', $unionWardInfo); @endphp

                            <input type="text" name="name_bn" value="{{ $_name_bn }}" id="name-bn" class="form-control {{ $errors->has('name_bn') ? 'is-invalid' : '' }}" placeholder="" autocomplete="off" required>

                            @if ($errors->has('name_bn'))
                                <div class="invalid-feedback">{{ $errors->first('name_bn') }}</div>
                            @else
                                <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                            @endif
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-sm-4">
                        <!-- FIELD: GEO CODE -->
                        <div class="form-group">
                            <label for="geo-code" class="font-weight-bold">
                                {{ __('Geo Code') }}
                                <sup class="text-danger">*</sup>
                            </label>

                            @php $_geo_code = setDefaultValue('geo_code', $unionWardInfo); @endphp

                            <input type="number" name="geo_code" value="{{ $_geo_code }}" id="geo-code" class="form-control {{ $errors->has('geo_code') ? 'is-invalid' : '' }}" placeholder="{{ __('In Numbers') }}" autocomplete="off" required>

                            @if ($errors->has('geo_code'))
                                <div class="invalid-feedback">{{ $errors->first('geo_code') }}</div>
                            @else
                                <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <!-- FIELD: LATITUDE -->
                        <div class="form-group">
                            <label for="latitude" class="font-weight-bold">
                                {{ __('Latitude') }}
                            </label>

                            @php $_latitude = setDefaultValue('latitude', $unionWardInfo); @endphp

                            <input type="text" name="latitude" value="{{ $_latitude }}" id="latitude" class="form-control {{ $errors->has('latitude') ? 'is-invalid' : '' }}" placeholder="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <!-- FIELD: LONGITUDE -->
                        <div class="form-group">
                            <label for="longitude" class="font-weight-bold">
                                {{ __('Longitude') }}
                            </label>

                            @php $_longitude = setDefaultValue('longitude', $unionWardInfo); @endphp

                            <input type="text" name="longitude" value="{{ $_longitude }}" id="longitude" class="form-control {{ $errors->has('longitude') ? 'is-invalid' : '' }}" placeholder="" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </section>
        <!-- /.card -->

        @csrf
    </div>

    <div class="col-sm-3">
        <aside class="card mb-3">
            <div class="card-body">
                <!-- FIELD: IS ACTIVE -->
                <div class="form-group">
                    @php $_is_active = setDefaultValue('is_active', $unionWardInfo); @endphp

                    <label for="status" class="font-weight-bold">{{ __('Status') }}</label>

                    <select name="is_active" id="status" class="custom-select">
                        <option value="1" {{ 1 === $_is_active ? 'selected="selected"' : '' }}>
                            {{ __('Active') }}
                        </option>

                        <option value="0" {{ 0 === $_is_active ? 'selected="selected"' : '' }}>
                            {{ __('Inactive') }}
                        </option>
                    </select>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
                        @yield('form_submit_btn')
                    </button>
                </div>
            </div>
        </aside>
    </div>
</div>
