<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="sale_date" class="d-block">
                <span class="font-weight-bold">{{ __('Request Date') }}</span>
            </label>
            {{ displayDateTime($requestedItem->requested_date) }}
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="sale_date" class="d-block">
                <span class="font-weight-bold">{{ __('Location (Room No.)') }}</span>
            </label>
            {{ resolveFieldName($requestedItem->location()->first()) }}
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group-prepend">
            <label for="unit_price" class="d-block">
                <span class="font-weight-bold">{{ __('Remarks') }}</span>
                <!-- <span class="small text-danger">*</span> -->
            </label>
            {{ $requestedItem->remarks }}
        </div>
    </div>

</div>

{{-- Requested item details --}}
<div class="table-responsive">
    <table id="supplier-item-info" class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>{{ __('Category of Item') }}</th>
                <th>{{ __('Item') }}</th>
                <th>{{ __('Quantity') }}</th>
                <th>{{ __('Serial No') }}</th>
                <th>{{ __('Remarks') }}</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($itemDetails) && !empty($itemDetails))
                @foreach($itemDetails as $key => $value)
                    <tr class="rows">
                        <td>
                            <span id="item-status-view-{{ $value->id }}">{{ $itemCategory[$value->item_category_id] }}</span>
                        </td>
                        <td>
                            <span id="item-view-{{ $value->id }}">{{ $item[$value->item_id] }}</span>
                        </td>
                        <td>
                            <span id="quantity-view-{{ $value->id }}">{{ $value->quantity }}</span>
                        </td>
                        <td>
                            @if(isset($type) && $type === 'Approve')
                                <input class="serial form-control" id="serial-{{ $value->id }}" name="serial[{{ $value->id }}]" type="text" value="{{ $value->serial_no }}" placeholder="Write Item Serial No.">
                            @else
                                <span id="serial-view-{{ $value->id }}">{{ $value->serial_no }}</span>
                            @endif
                        </td>
                        <td>
                            <span id="remarks-view-{{ $value->id }}">{{ $value->remarks }}</span>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

