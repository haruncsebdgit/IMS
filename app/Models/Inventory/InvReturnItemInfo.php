<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvReturnItemInfo extends Model
{
    use HasFactory;

    protected $table = 'inv_return_item_infos';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'return_item_id', 'item_id','item_status_id',
        'quantity', 'serial',
        'fixed_asset_id', 'remarks',
        'created_at',
        'updated_at'
    ];



    public static function saveReturnItemInfo($inputData, $returnItemId) 
    {
        if (!isset($inputData['item_id']) || empty($inputData['item_id'])) {
            return;
        }
        InvReturnItemInfo::where('return_item_id', $returnItemId)->delete();
        foreach ($inputData['item_id'] as $key=>$item) {
            InvReturnItemInfo::create([
                'return_item_id' => $returnItemId,
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
