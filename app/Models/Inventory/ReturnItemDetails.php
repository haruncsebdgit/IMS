<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class ReturnItemDetails extends Model
{
    use HasFactory;

    protected $table = 'inv_return_item_details';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'return_item_master_id', 'item_id','item_category_id',
        'quantity', 'remarks',
        'created_at',
        'updated_at'
    ];

    public static function saveRequestedItem($inputData, $returnItemMasterId)
    {
        $currentItems = self::where('return_item_master_id', $returnItemMasterId)->get();
        // First decrese stock for all item
        foreach($currentItems as $currentItem)
        {
            Stock::remove([
                'item_id'=> $currentItem->item_id,
                'item_status_id'=> 1,  // 1 for item status good,
                'user_id'=> null,
                'dept'=>'dept_cse',
                'quantity'=>$currentItem->quantity
            ]);
            Stock::add([
                'item_id'=> $currentItem->item_id,
                'item_status_id'=> 1,  // 1 for item status good,
                'user_id'=> Auth::id(),
                'dept'=>'dept_cse',
                'quantity'=>$currentItem->quantity
            ]);
        }

        self::where('return_item_master_id', $returnItemMasterId)->delete();
        if (!isset($inputData['item_id']) || empty($inputData['item_id'])) {
            return;
        }

        foreach ($inputData['item_id'] as $key=>$item) {
            self::create([
                'return_item_master_id' => $returnItemMasterId,
                'item_id' => $item,
                'item_category_id' => $inputData['item_category_id'][$key],
                'quantity' => $inputData['quantity'][$key],
                'remarks' => $inputData['remarks_details'][$key]
            ]);

            Stock::add([
                'item_id'=> $item,
                'item_status_id'=> 1,  // 1 for item status good,
                'user_id'=> null,
                'dept'=>'dept_cse',
                'quantity'=>$inputData['quantity'][$key]
            ]);
            //dd("aaaa");
            Stock::remove([
                'item_id'=> $item,
                'item_status_id'=> 1,  // 1 for item status good,
                'user_id'=> Auth::id(),
                'dept'=>'dept_cse',
                'quantity'=>$inputData['quantity'][$key]
            ]);
        }
    }
}
