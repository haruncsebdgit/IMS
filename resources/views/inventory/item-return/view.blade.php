<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="sale_date" class="d-block">
                <span class="font-weight-bold">{{ __('Return Date') }}</span>
            </label>
            {{ $requestedItem->return_date }}
        </div>
    </div>

    <div class="col-sm-8">
        <div class="form-group-prepend">
            <label for="unit_price" class="d-block">
                <span class="font-weight-bold">{{ __('Remarks') }}</span>
                <!-- <span class="small text-danger">*</span> -->
            </label>
            {{ $requestedItem->remarks }}
        </div>
    </div>

</div>

@include('inventory.item-return.item-list', ['showActionButton'=>false])
