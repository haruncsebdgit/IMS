@include('errors.validation')

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="upazila_id" class="d-block">
                <span class="font-weight-bold">{{ __('Supplier') }}</span>
            </label>
            {{ $item_receive_from_supplier_information->supplier_name }}
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="upazila_id" class="d-block">
                <span class="font-weight-bold">{{ __('Receive Date') }}</span>
            </label>
            {{ displayDateTime($item_receive_from_supplier_information->receive_date)}}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="upazila_id" class="d-block">
                <span class="font-weight-bold">{{ __('Invoice No.') }}</span>
            </label>
            {{ $item_receive_from_supplier_information->invoice_id}}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="upazila_id" class="d-block">
                <span class="font-weight-bold">{{ __('Invoice Date') }}</span>
            </label>
            {{ displayDateTime($item_receive_from_supplier_information->invoice_date)}}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="upazila_id" class="d-block">
                <span class="font-weight-bold">{{ __('Receive By') }}</span>
            </label>
            {{ $item_receive_from_supplier_information->user_name }}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="upazila_id" class="d-block">
                <span class="font-weight-bold">{{ __('Remarks') }}</span>
            </label>
            {{ $item_receive_from_supplier_information->supplier_remarks }}
        </div>
    </div>



</div>

<h4 class="inline-header inline-header-center text-primary h6 my-3 small text-uppercase font-weight-bold py-2">
    {{ __('Supplier Item Information') }}
</h4>
@include('inventory.item-receive-from-supplier-information.supplier-item-info-list', ['showActionButton'=>false])
