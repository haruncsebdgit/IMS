@include('errors.validation')

<div class="row">

    <div class="col-sm-4">
        <div class="form-group">
            <label for="name" class="d-block">
                <span class="font-weight-bold">{{ __('Name (English)') }}</span>
            </label>
            {{ $item_category_sub_category_information->name_en }}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="address" class="d-block">
                <span class="font-weight-bold">{{ __('Name (Bengali)') }}</span>
            </label>
            {{ $item_category_sub_category_information->name_bn }}
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="date_of_birth" class="d-block">
                <span class="font-weight-bold">{{ __('Remarks') }}</span>
            </label>
            {{ $item_category_sub_category_information->remarks }}
        </div>
    </div>



</div>
