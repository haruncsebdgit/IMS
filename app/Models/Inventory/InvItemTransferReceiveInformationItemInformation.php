<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvItemTransferReceiveInformationItemInformation extends Model
{
    use HasFactory;

    protected $table = 'inv_item_transfer_receive_information_item_information';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transfer_receive_item_id', 'item_id','item_status_id',
        'quantity', 'serial',
        'fixed_asset_id', 'remarks',
        'created_at',
        'updated_at'
    ];



    public static function saveIvnTransferReceiveItemInfo($inputData, $transferReceiveItemId) 
    {
        if (!isset($inputData['item_id']) || empty($inputData['item_id'])) {
            return;
        }
        InvItemTransferReceiveInformationItemInformation::where('transfer_receive_item_id', $transferReceiveItemId)->delete();
        foreach ($inputData['item_id'] as $key=>$item) {
            InvItemTransferReceiveInformationItemInformation::create([
                'transfer_receive_item_id' => $transferReceiveItemId,
                'item_id' => $item,
                'item_status_id' => $inputData['item_status_id'][$key],
                'quantity' => $inputData['quantity'][$key],
                'serial' => $inputData['serial'][$key],
                'fixed_asset_id' => $inputData['fixed_asset_id'][$key],
                'remarks' => $inputData['remarks'][$key]
                
                
            ]);
        }
    }
}
