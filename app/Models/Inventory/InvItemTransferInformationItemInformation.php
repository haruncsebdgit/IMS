<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvItemTransferInformationItemInformation extends Model
{
    use HasFactory;

    protected $table = 'inv_item_transfer_information_item_information';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transfer_item_id', 'item_id','item_status_id',
        'quantity', 'serial',
        'fixed_asset_id', 'remarks',
        'created_at',
        'updated_at'
    ];



    public static function saveIvnTransferItemInfo($inputData, $transferItemId) 
    {
        if (!isset($inputData['item_id']) || empty($inputData['item_id'])) {
            return;
        }
        InvItemTransferInformationItemInformation::where('transfer_item_id', $transferItemId)->delete();
        foreach ($inputData['item_id'] as $key=>$item) {
            InvItemTransferInformationItemInformation::create([
                'transfer_item_id' => $transferItemId,
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
