<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestItemDetails extends Model
{
    use HasFactory;

    protected $table = 'inv_request_item_details';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'request_item_master_id',
        'item_id',
        'serial_no',
        'item_category_id',
        'quantity', 'remarks',
        'created_at',
        'updated_at'
    ];



    public static function saveRequestedItem($inputData, $requestItemMasterId)
    {
        if (!isset($inputData['item_id']) || empty($inputData['item_id'])) {
            return;
        }
        self::where('request_item_master_id', $requestItemMasterId)->delete();
        foreach ($inputData['item_id'] as $key=>$item) {
            self::create([
                'request_item_master_id' => $requestItemMasterId,
                'item_id' => $item,
                'item_category_id' => $inputData['item_category_id'][$key],
                'quantity' => $inputData['quantity'][$key],
                'remarks' => $inputData['remarks_details'][$key]
            ]);
        }
    }
}
