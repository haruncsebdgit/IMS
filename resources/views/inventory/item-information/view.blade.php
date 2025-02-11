@include('errors.validation')

<div class="row">

    <div class="col-sm-4">
        <div class="form-group">
            <label for="name" class="d-block">
                <span class="font-weight-bold">{{ __('Name') }}</span>
            </label>
            {{ $item_information->name_en }}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="address" class="d-block">
                <span class="font-weight-bold">{{ __('Name in Bangla') }}</span>
            </label>
            {{ $item_information->name_bn }}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="mobile" class="d-block">
                <span class="font-weight-bold">{{ __('Code') }}</span>
            </label>
            {{ $item_information->code_en }}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="email" class="d-block">
                <span class="font-weight-bold">{{ __('Code in Bangla') }}</span>
            </label>
            {{ $item_information->code_bn }}
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="registration_no" class="d-block">
                <span class="font-weight-bold">{{ __('Asset Type') }}</span>
            </label>
            {{ $item_information->asset }}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="registration_no" class="d-block">
                <span class="font-weight-bold">{{ __('Category') }}</span>
            </label>
            {{ $item_information->category }}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="registration_no" class="d-block">
                <span class="font-weight-bold">{{ __('UoM') }}</span>
            </label>
            {{ $item_information->uoM }}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="registration_no" class="d-block">
                <span class="font-weight-bold">{{ __('Manufacturer') }}</span>
            </label>
            {{ $item_information->manufacturer }}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="registration_no" class="d-block">
                <span class="font-weight-bold">{{ __('Model') }}</span>
            </label>
            {{ $item_information->model }}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="registration_no" class="d-block">
                <span class="font-weight-bold">{{ __('Part Number') }}</span>
            </label>
            {{ $item_information->part_number }}
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="registration_no" class="d-block">
                <span class="font-weight-bold">{{ __('Is Serialized') }}</span>
            </label>
            @if($item_information->is_serialized == 1)
                    {{ __('Yes') }}
                @else
                    {{ __('No') }}
                @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="registration_no" class="d-block">
                <span class="font-weight-bold">{{ __('Is Active') }}</span>
            </label>
            @if($item_information->is_active == 1)
                    {{ __('Yes') }}
                @else
                    {{ __('No') }}
                @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="date_of_birth" class="d-block">
                <span class="font-weight-bold">{{ __('Remarks') }}</span>
            </label>
            {{ $item_information->remarks }}
        </div>
    </div>



</div>
