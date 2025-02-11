<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvSupplierItemInfo extends Model
{
    use HasFactory;

    protected $table = 'inv_supplier_item_infos';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'supplier_item_id', 'item_id','item_status_id',
        'quantity', 'serial',
        'fixed_asset_id', 'remarks',
        'created_at',
        'updated_at'
    ];



    public static function saveItems($inputData, $receiveMasterId)
    {
        $currentItems = self::where('supplier_item_id', $receiveMasterId)->get();
        // First decrese stock for all item
        foreach($currentItems as $currentItem)
        {
            $items = [
                'supplier_item_id' => $receiveMasterId,
                'item_id' => $currentItem->item_id,
                'item_status_id' => $currentItem->item_status_id,
                'quantity' => $currentItem->quantity,
                'serial' => $currentItem->serial,
                'fixed_asset_id' => $currentItem->fixed_asset_id,
                'remarks' => $currentItem->remarks
            ];
            Stock::remove(array_merge($inputData, $items));
        }
        // Deleting item info
        self::where('supplier_item_id', $receiveMasterId)->delete();
        if (!isset($inputData['item_id']) || empty($inputData['item_id'])) {
            return;
        }

        // Finally adding item info and also update stock
        foreach ($inputData['item_id'] as $key=>$item) {
            $items = [
                'supplier_item_id' => $receiveMasterId,
                'item_id' => $item,
                'item_status_id' => $inputData['item_status_id'][$key],
                'quantity' => $inputData['quantity'][$key],
                'serial' => $inputData['serial'][$key],
                'fixed_asset_id' => $inputData['fixed_asset_id'][$key],
                'remarks' => $inputData['remarks'][$key]
            ];

            self::create($items);
            // Updating stock
            Stock::add(array_merge($inputData, $items));
        }
    }

    public static function saveSupplierItemInfo($inputData, $supplierItemId)
    {
        if (!isset($inputData['item_id']) || empty($inputData['item_id'])) {
            return;
        }
        InvSupplierItemInfo::where('supplier_item_id', $supplierItemId)->delete();
        foreach ($inputData['item_id'] as $key=>$item) {
            InvSupplierItemInfo::create([
                'supplier_item_id' => $supplierItemId,
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
