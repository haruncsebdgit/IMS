@section('admin_search_form_body')

    <?php
    $lang = config('app.locale');
    /**
     * Get all the filter parameters from URL and Sanitize 'em.
     * @link https://www.php.net/manual/en/function.filter-input.php
     * @var $_filter_params Array of parameters. VARIABLE NAME NEEDS TO BE INTACT.
     */
    $_filter_params = array(
        'name'        => filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING),
        'geo_code'    => filter_input(INPUT_GET, 'geo_code', FILTER_SANITIZE_NUMBER_INT),
        'is_active'   => filter_input(INPUT_GET, 'is_active', FILTER_SANITIZE_STRING),
        'district_id' => filter_input(INPUT_GET, 'district_id', FILTER_SANITIZE_NUMBER_INT)
    );
    ?>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="districts" class="font-weight-bold">{{ __('District') }}</label>
                <select name="district_id" id="districts" class="form-control">
                    <option value="">{{ __('Select a District') }}</option>
                    @foreach($districts as $district)
                        @php $district_name = "name_$lang"; @endphp
                        <option value="{{ $district->id }}" {{ $district->id == $_filter_params['district_id'] ? 'selected="selected"' : '' }} >
                            {{ $district->$district_name ?? $district->name_en }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="name" class="font-weight-bold">{{ __('Name') }}</label>
                <input type="text" name="name" id="search" class="form-control" autocomplete="off" value="{{ $_filter_params['name'] }}">
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-6">
            <div class="form-group">
                <label for="geo-code" class="font-weight-bold">{{ __('Geo Code') }}</label>
                <input type="number" name="geo_code" id="geo-code" class="form-control" autocomplete="off" value="{{ $_filter_params['geo_code'] }}" placeholder="{{ __('In Numbers') }}">
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="department" class="font-weight-bold">{{ __('Status') }}</label>

                <select name="is_active" id="division-status" class="custom-select">
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
