@include('errors.validation')

<div class="row">
    
        <div class="col-sm-4">
            <div class="form-group">
                <label for="upazila_id" class="d-block">
                    <span class="font-weight-bold">{{ __('Transfer ID') }}</span>
                </label>
                {{ $item_return_on_support->id }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="upazila_id" class="d-block">
                    <span class="font-weight-bold">{{ __('Transfer Date') }}</span>
                </label>
                {{ displayDateTime($item_return_on_support->date)}}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="upazila_id" class="d-block">
                    <span class="font-weight-bold">{{ __('Inventory Center') }}</span>
                </label>
                {{ $item_return_on_support->inventory_name }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="upazila_id" class="d-block">
                    <span class="font-weight-bold">{{ __('Supplier') }}</span>
                </label>
                {{ $item_return_on_support->supplier }}
            </div>
        </div>
        
        <div class="col-sm-4">
            <div class="form-group">
                <label for="upazila_id" class="d-block">
                    <span class="font-weight-bold">{{ __('Receive By') }}</span>
                </label>
                {{ $item_return_on_support->user_name}}
            </div>
        </div>
        
        <div class="col-sm-4">
            <div class="form-group">
                <label for="upazila_id" class="d-block">
                    <span class="font-weight-bold">{{ __('Remarks') }}</span>
                </label>
                {{ $item_return_on_support->return_remarks }}
            </div>
        </div>
    
    

</div>

<h4 class="inline-header inline-header-center h6 my-3 small text-uppercase font-weight-bold py-2">
    {{ __('Return Item Information') }}
</h4>
@include('inventory.item-return-on-support.return-item-info-list', ['showActionButton'=>false])

