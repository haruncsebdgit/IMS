<?php $technologyInfo = $technologyInfo ?? ''; ?>
<section class="card">
    <div class="card-body">
        <div class="row">

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name-en" class="font-weight-bold">
                        {{ __('Name (in English)') }}
                        <sup class="text-danger">*</sup>
                    </label>
                    <input type="text" name="name_en" value="{{ setDefaultValue('name_en', $technologyInfo) }}" id="name-en" class="form-control" autocomplete="off" required>
                    @if ($errors->has('name_en'))
                        <div class="invalid-feedback">{{ $errors->first('name_en') }}</div>
                    @else
                        <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                    @endif
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name-bn" class="font-weight-bold">
                        {{ __('Name (in Bengali)') }}
                        <sup class="text-danger">*</sup>
                    </label>
                    <input type="text" name="name_bn" value="{{ setDefaultValue('name_en', $technologyInfo) }}" id="name-bn" class="form-control" required>
                    @if ($errors->has('name_bn'))
                        <div class="invalid-feedback">{{ $errors->first('name_bn') }}</div>
                    @else
                        <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                    @endif
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="districts" class="font-weight-bold">
                        {{ __('Technology') }}
                    </label>
                    @php $_technology_type_id = setDefaultValue('technology_type_id', $technologyInfo); @endphp
                    <div class="input-group">
                        <select name="technology_type_id" id="technology-type-id" class="form-control enable-select2">
                            <option value="">{{ __('Select a Technology') }}</option>
                            @foreach($technologyTypeList as $key=>$technologytypename)
                            <option value="{{$key}}" {{ $key == $_technology_type_id ? 'selected="selected"' : '' }}>
                            {{ $technologytypename }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has('district_id'))
                        <div class="invalid-feedback">{{ $errors->first('district_id') }}</div>
                    @else
                        <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                @php $_is_active = setDefaultValue('is_active', $technologyInfo, 1); @endphp
                    <label for="technology-status" class="font-weight-bold">{{ __('Status') }}</label>
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
                    <label for="code" class="font-weight-bold">
                        {{ __('Code') }}
                    </label>
                    <input type="number" name="code" value="{{ setDefaultValue('code', $technologyInfo) }}" id="geo-code" class="form-control" placeholder="{{ __('In Numbers') }}" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="order" class="font-weight-bold">
                        {{ __('Order') }}
                    </label>
                    <input type="number" name="order" value="{{ setDefaultValue('order', $technologyInfo) }}" id="order" class="form-control" placeholder="{{ __('In Numbers') }}" autocomplete="off">
                </div>
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary text-right">
                <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
                @yield('form_submit_btn')
            </button>
        </div>
    </div>
    <!-- /.card-body -->
</section>
<!-- /.card -->

@csrf
