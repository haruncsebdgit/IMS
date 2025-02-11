<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemAllocationDetails extends Model
{
    use HasFactory;
    protected $table = 'inv_item_allocation_details';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'allocation_item_master_id',
        'item_id',
        'serial_no',
        'item_category_id',
        'quantity', 'remarks',
        'created_at',
        'updated_at'
    ];



    public static function saveRequestedItem($inputData, $itemMasterId)
    {
        if (!isset($inputData['item_id']) || empty($inputData['item_id'])) {
            return;
        }
        self::where('allocation_item_master_id', $itemMasterId)->delete();
        foreach ($inputData['item_id'] as $key=>$item) {
            self::create([
                'allocation_item_master_id' => $itemMasterId,
                'item_id' => $item,
                'item_category_id' => $inputData['item_category_id'][$key],
                'quantity' => $inputData['quantity'][$key],
                'remarks' => $inputData['remarks_details'][$key]
            ]);

            Stock::remove([
                'item_id' => $item,
                'item_status_id' => 1,  // 1 for item status good
                'quantity' => $inputData['quantity'][$key],
                'user_id' => null,
                'dept' => 'dept_cse',
            ]);
            Stock::add([
                'item_id' => $item,
                'item_status_id' => 1,  // 1 for item status good
                'quantity' => $inputData['quantity'][$key],
                'dept' => 'dept_cse',
                'asset_location_id' => $inputData['location_id'],
                'user_id' => $inputData['user_id'],
            ]);
        }
    }
}
