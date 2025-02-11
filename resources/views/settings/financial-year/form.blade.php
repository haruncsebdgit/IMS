@php $the_financial_year = $the_financial_year ?? ''; @endphp

@include('errors.validation') {{-- this placement _below_ the hook is necessary --}}

<section class="card mb-3">
    <div class="card-body">
        <p class="mb-20 text-info">
            <i class="icon-exclamation" aria-hidden="true"></i>
            {!! __('All fields marked with an asterisk (*) are required.') !!}
        </p>

        <div class="row">
            <div class="col-sm-4">
                <!-- FIELD: YEAR NAME -->
                <div class="form-group">
                    <label for="fy-year-name" class="font-weight-bold">
                        {{ __('Year Name') }}
                        <sup class="text-danger">*</sup>
                    </label>

                    @php $year_name = setDefaultValue('year_name', $the_financial_year); @endphp

                    <input type="text" name="year_name" class="form-control fy-year-name {{ $errors->has('year_name') ? 'is-invalid' : '' }}" id="fy-year-name" placeholder="{{ __('Title, e.g., :pattern', ['pattern' => translateString('1971-1972')]) }}" autocomplete="off" value="{{ $year_name }}" required pattern="[0-9]{4}-[0-9]{4}">

                    @if ($errors->has('year_name'))
                        <div class="invalid-feedback">{{ $errors->first('year_name') }}</div>
                    @else
                        <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                    @endif
                </div>
            </div>

            <div class="col-sm-4">
                <!-- FIELD: START DATE -->
                <div class="form-group">
                    <label for="fy-start-date" class="font-weight-bold">
                        {{ __('Start Date') }}
                        <sup class="text-danger">*</sup>
                    </label>

                    @php
                        $start_date = setDefaultValue('start_date', $the_financial_year);
                        $start_date = $start_date ? date('d-m-Y', strtotime($start_date)) : null;
                    @endphp

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="icon-calendar" aria-hidden="true"></i>
                            </div>
                        </div>

                        <input type="text" name="start_date" id="fy-start-date" class="form-control datepicker {{ $errors->has('start_date') ? 'is-invalid' : '' }}" placeholder="{{ __('Pick a date, e.g., :pattern', ['pattern' => translateString('21-02-1952')]) }}" autocomplete="off" value="{{ $start_date }}" required pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}">

                        @if ($errors->has('start_date'))
                            <div class="invalid-feedback">{{ $errors->first('start_date') }}</div>
                        @else
                            <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <!-- FIELD: END DATE -->
                <div class="form-group">
                    <label for="fy-end-date" class="font-weight-bold">
                        {{ __('End Date') }}
                        <sup class="text-danger">*</sup>
                    </label>

                    @php
                        $end_date = setDefaultValue('end_date', $the_financial_year);
                        $end_date = $end_date ? date('d-m-Y', strtotime($end_date)) : null;
                    @endphp

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="icon-calendar" aria-hidden="true"></i>
                            </div>
                        </div>

                        <input type="text" name="end_date" id="fy-end-date" class="form-control datepicker {{ $errors->has('end_date') ? 'is-invalid' : '' }}" placeholder="{{ __('Pick a date, e.g., :pattern', ['pattern' => translateString('21-02-1952')]) }}" autocomplete="off" value="{{ $end_date }}" required pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}">

                        @if ($errors->has('end_date'))
                            <div class="invalid-feedback">{{ $errors->first('end_date') }}</div>
                        @else
                            <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-sm-4">
                <!-- FIELD: IS ACTIVE -->
                <div class="form-group">
                    @php $is_active = setDefaultValue('is_active', $the_financial_year, 1); @endphp

                    <label for="fy-is-active" class="font-weight-bold">{{ __('Status') }}</label>

                    <select name="is_active" id="fy-is-active" class="custom-select">
                        <option value="1" {{ 1 == $is_active ? 'selected="selected"' : '' }}>
                            {{ __('Active') }}
                        </option>

                        <option value="0" {{ 0 == $is_active ? 'selected="selected"' : '' }}>
                            {{ __('Inactive') }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="col-sm-4">
                <!-- FIELD: SORT ORDER -->
                <div class="form-group">
                    @php $sort_order = setDefaultValue('sort_order', $the_financial_year); @endphp

                    <label for="fy-sort-order" class="font-weight-bold">{{ __('Order') }}</label>

                    <input type="number" name="sort_order" id="fy-sort-order" class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}" placeholder="0" min="0" autocomplete="off" value="{{ $sort_order }}" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                </div>
            </div>

            <div class="col-sm-4">
                <!-- FIELD: IS CURRENT FINANCIAL YEAR -->
                <div class="form-group">
                    @php $is_current_fy = setDefaultValue('is_current_fy', $the_financial_year); @endphp

                    <label for="is_current_fy" class="font-weight-bold">
                    {{ __('Is Current Financial Year?') }}
                    </label>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="is_current_fy" value="1" {{ $is_current_fy == 1 ? 'checked="checked"' : '' }} id="is-current-fy" class="custom-control-input">

                        <label class="custom-control-label small" for="is-current-fy">
                            <!-- {{ __('Is Current Financial Year?') }} -->
                        </label>
                    </div>
                </div>
            </div>
        </div>

        @csrf
    </div>
    <!-- /.card-body -->
</section>
<!-- /.card -->

<div class="text-right">
    <button type="submit" class="btn btn-primary text-right">
        <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
        @yield('financial_year_form_submit_btn')
    </button>
</div>
