<?php 
    $showActionButton = $showActionButton ?? true;
?>
<div class="table-responsive">
    <table id="supplier-item-info" class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>{{ __('Item') }}</th>
                <th>{{ __('Item Status') }}</th>
                <th>{{ __('Quantity') }}</th>
                <th>{{ __('Serial') }}</th>
                <th>{{ __('Fixed Asset ID') }}</th>
                <th>{{ __('Remarks') }}</th>
                
                @if ($showActionButton)
                    <th>{{ __('Actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
        
        @if(isset($item_on_support_return_to_supplier_vendor_information) && !empty($ivn_return_item_info))
          @foreach($ivn_return_item_info as $key => $value)
            
            <tr class="rows">
            {{-- {!! Form::hidden('member_details_id[]', $value->id) !!} --}}
                <td>
                    <span id="item-view-{{ $value->id }}">{{ $item[$value->item_id] }}</span>
                    <input class="item" id="item-{{ $value->id }}" name="item_id[]" type="hidden" value="{{ $value->item_id }}">
                </td>
                <td>
                    <span id="item-status-view-{{ $value->id }}">{{ $status[$value->item_status_id] }}</span>
                    <input class="item-status-type" id="item-status-{{ $value->id }}" name="item_status_id[]" type="hidden" value="{{ $value->item_status_id }}">
                </td>
                <td>
                    <span id="quantity-view-{{ $value->id }}">{{ $value->quantity }}</span>
                    <input class="quantity" id="quantity-{{ $value->id }}" name="quantity[]" type="hidden" value="{{ $value->quantity }}">
                </td>
                <td>
                    <span id="serial-view-{{ $value->id }}">{{ $value->serial }}</span>
                    <input class="serial" id="serial-{{ $value->id }}" name="serial[]" type="hidden" value="{{ $value->serial }}">
                </td>
                <td>
                    <span id="fixed-asset-id-view-{{ $value->id }}">{{ $value->fixed_asset_id }}</span>
                    <input class="fixed-asset-id" id="fixed-asset-id-{{ $value->id }}" name="fixed_asset_id[]" type="hidden" value="{{ $value->fixed_asset_id }}">
                </td>
                <td>
                    <span id="remarks-view-{{ $value->id }}">{{ $value->remarks }}</span>
                    <input class="remarks" id="remarks-{{ $value->id }}" name="remarks[]" type="hidden" value="{{ $value->remarks }}">
                </td>
                
                
                
                
                @if ($showActionButton)
                    <td>
                        <a class="edit btn btn-link" uid="{{ $value->id }}" href="javascript:void(0)"><i class="icon-pencil7"></i></a>&nbsp;
                        <a class="remove btn btn-link text-danger" uid="{{ $value->id }}" href="javascript:void(0)"><i class="icon-trash"></i></a>
                    </td>
                @endif
            </tr>
          @endforeach
        @endif
        </tbody>
    </table>
</div>