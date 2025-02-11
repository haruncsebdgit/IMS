<?php
    $showActionButton = $showActionButton ?? true;
?>
<div class="table-responsive">
    <table id="supplier-item-info" class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>{{ __('Category of Item') }}</th>
                <th>{{ __('Item') }}</th>
                <th>{{ __('Quantity') }}</th>
                <th>{{ __('Remarks') }}</th>

                @if ($showActionButton)
                <th>{{ __('Actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>

            @if(isset($itemDetails) && !empty($itemDetails))
            @foreach($itemDetails as $key => $value)

            <tr class="rows">
                {{-- {!! Form::hidden('member_details_id[]', $value->id) !!} --}}
                <td>
                    <span id="item-status-view-{{ $value->id }}">{{ $itemCategory[$value->item_category_id] }}</span>
                    <input class="item-status-type" id="item-status-{{ $value->id }}" name="item_category_id[]" type="hidden" value="{{ $value->item_category_id }}">
                </td>
                <td>
                    <span id="item-view-{{ $value->id }}">{{ $item[$value->item_id] }}</span>
                    <input class="item" id="item-{{ $value->id }}" name="item_id[]" type="hidden" value="{{ $value->item_id }}">
                </td>

                <td>
                    <span id="quantity-view-{{ $value->id }}">{{ $value->quantity }}</span>
                    <input class="quantity" id="quantity-{{ $value->id }}" name="quantity[]" type="hidden" value="{{ $value->quantity }}">
                </td>
                <td>
                    <span id="remarks-view-{{ $value->id }}">{{ $value->remarks }}</span>
                    <input class="remarks" id="remarks-{{ $value->id }}" name="remarks_details[]" type="hidden" value="{{ $value->remarks }}">
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
