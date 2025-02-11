@section('admin_search_form_body')

    <?php
    $lang = config('app.locale');

    /**
     * Get all the filter parameters from URL and Sanitize 'em.
     * @link https://www.php.net/manual/en/function.filter-input.php
     * @var $_filter_params Array of parameters. VARIABLE NAME NEEDS TO BE INTACT.
     */
    $_filter_params = array(
        'name'             => filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING),
        'geo_code'         => filter_input(INPUT_GET, 'geo_code', FILTER_SANITIZE_NUMBER_INT),
        'is_active'        => filter_input(INPUT_GET, 'is_active', FILTER_SANITIZE_STRING),
        'thana_upazila_id' => filter_input(INPUT_GET, 'thana_upazila_id', FILTER_SANITIZE_NUMBER_INT)
    );
    ?>

    <div class="row">
        <div class="col-sm-6">
            <!-- FIELD: UPAZILA ID -->
            <div class="form-group">
                <label for="thana-upazila" class="font-weight-bold">
                    {{ __('Upazila') }}
                </label>

                <select name="thana_upazila_id" id="thana-upazila" class="form-control enable-select2">
                    <option value="">{{ __('Select a Upazila') }}</option>
                    @if(!empty($thanaUpazilas))
                        @foreach($thanaUpazilas as $value)
                            @php $thana_upazila_name = "name_$lang"; @endphp

                            <option value="{{ $value->id }}" {{ $value->id == $_filter_params['thana_upazila_id'] ? 'selected="selected"' : '' }} >
                                {{ $value->$thana_upazila_name ?? $value->name_en }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-sm-6">
            <!-- FIELD: NAME -->
            <div class="form-group">
                <label for="name" class="font-weight-bold">
                    {{ __('Name') }}
                </label>

                <input type="text" name="name" id="name" class="form-control" autocomplete="off" value="{{ $_filter_params['name'] }}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <!-- FIELD: GEO CODE -->
            <div class="form-group">
                <label for="geo-code" class="font-weight-bold">
                    {{ __('Geo Code') }}
                </label>

                <input type="number" name="geo_code" id="geo-code" class="form-control" autocomplete="off" value="{{ $_filter_params['geo_code'] }}" placeholder="{{ __('In Numbers') }}">
            </div>
        </div>

        <div class="col-sm-6">
            <!-- FIELD: IS ACTIVE -->
            <div class="form-group">
                <label for="is-active" class="font-weight-bold">
                    {{ __('Status') }}
                </label>

                <select name="is_active" id="is-active" class="custom-select">
                    <option value="">{{ __('Select a Status') }}</option>

                    <option value="active" {{ "active" === $_filter_params['is_active'] ? 'selected="selected"' : '' }}>
                        {{ __('Active') }}
                    </option>

                    <option value="inactive" {{ "inactive" === $_filter_params['is_active'] ? 'selected="selected"' : '' }}>
                        {{ __('Inactive') }}
                    </option>
                </select>
            </div>
        </div>
    </div>

@endsection

@include('layouts.admin-search-form')
