@include('errors.validation')

@php $the_common_label = $the_common_label ?? ''; @endphp

<section class="card mb-3">
    <div class="card-body">

        <!-- HIDDEN DATA TYPE -->
        <input type="hidden" name="data_type" value="{{ setDefaultValue('data_type', $the_common_label, ($currentDataType ?? '')) }}">

        <!-- FIELD: NAME -->
        <div class="form-group">
            <label for="common-label-name" class="font-weight-bold">
                {{ __('Name (English)') }}
                <sup class="text-danger">*</sup>
            </label>
            <input type="text" name="name_en" class="form-control common-label-name {{ $errors->has('name_en') ? 'is-invalid' : '' }}" id="common-label-name" placeholder="{{ __('Name of the Common Label') }}" autocomplete="off" value="{{ setDefaultValue('name_en', $the_common_label) }}" required>
        </div>

        <!-- FIELD: NAME (BENGALI)-->
        <div class="form-group">
            <label for="common-label-name-bn" class="font-weight-bold">
                {{ __('Name (Bengali)') }}
            </label>
            <input type="text" name="name_bn" class="form-control common-label-name-bn" id="common-label-name-bn" placeholder="{{ __('Name of the Common Label (Bengali)') }}" autocomplete="off" value="{{ setDefaultValue('name_bn', $the_common_label) }}">
        </div>

        <hr />

        <!-- FIELD: STATUS -->
        <div class="form-group">
            @php $status = setDefaultValue('status', $the_common_label, 1); @endphp
            <label for="common-label-status" class="font-weight-bold">{{ __('Status') }}</label>
            <select name="status" id="common-label-status" class="custom-select">
                <option value="">{{ __('Select a Status') }}</option>
                <option value="1" {{ 1 == $status ? 'selected="selected"' : '' }}>{{ __('Active') }}</option>
                <option value="0" {{ 0 == $status ? 'selected="selected"' : '' }}>{{ __('Inactive') }}</option>
            </select>
        </div>

        <!-- FIELD: ORDER -->
        <div class="form-group">
            <label for="common-label-order" class="font-weight-bold">{{ __('Order') }}</label>
            <input type="number" name="order" id="common-label-order" class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}" placeholder="0" min="0" autocomplete="off" value="{{ setDefaultValue('order', $the_common_label) }}" min="0" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
        </div>

        <!-- FIELD: Code -->
        <div class="form-group">
            <label for="common-label-code" class="font-weight-bold">{{ __('Code') }}</label>
            <input type="text" name="code" class="form-control common-label-code" id="common-label-code" placeholder="{{ __('Code') }}" autocomplete="off" value="{{ setDefaultValue('code', $the_common_label) }}">
        </div>

    </div>
    <!-- /.card-body -->
</section>
<!-- /.card -->

@csrf

<button type="submit" class="btn btn-primary mb-3">
    <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
    @yield('common_label_form_submit_btn')
</button>
