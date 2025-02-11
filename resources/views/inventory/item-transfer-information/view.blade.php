@include('errors.validation')

<div class="row">
    
        <div class="col-sm-4">
            <div class="form-group">
                <label for="upazila_id" class="d-block">
                    <span class="font-weight-bold">{{ __('Transfer ID') }}</span>
                </label>
                {{ $item_transfer_information->id }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="upazila_id" class="d-block">
                    <span class="font-weight-bold">{{ __('Transfer Date') }}</span>
                </label>
                {{ displayDateTime($item_transfer_information->transfer_date)}}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="upazila_id" class="d-block">
                    <span class="font-weight-bold">{{ __('Inventory Center From') }}</span>
                </label>
                {{ $item_transfer_information->inventory_name_from }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="upazila_id" class="d-block">
                    <span class="font-weight-bold">{{ __('Inventory Center to') }}</span>
                </label>
                {{ $item_transfer_information->inventory_name_to }}
            </div>
        </div>
        
        <div class="col-sm-4">
            <div class="form-group">
                <label for="upazila_id" class="d-block">
                    <span class="font-weight-bold">{{ __('Receive By') }}</span>
                </label>
                {{ $item_transfer_information->user_name}}
            </div>
        </div>
        
        <div class="col-sm-4">
            <div class="form-group">
                <label for="upazila_id" class="d-block">
                    <span class="font-weight-bold">{{ __('Remarks') }}</span>
                </label>
                {{ $item_transfer_information->transfer_remarks }}
            </div>
        </div>
    
    

</div>

<h4 class="inline-header inline-header-center h6 my-3 small text-uppercase font-weight-bold py-2">
    {{ __('Transfer Item Information') }}
</h4>
@include('inventory.item-transfer-information.transfer-item-info-list', ['showActionButton'=>false])

