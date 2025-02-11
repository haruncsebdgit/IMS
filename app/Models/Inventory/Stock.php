<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'inv_stocks';

    protected $fillable = [
        'dept',
        'asset_location_id',
        'user_id', 'item_id',
        'item_status_id', 'stock_quantity',
        'created_at', 'updated_at'
    ];

    public static function getStock($inputs)
    {
        $assetLoc = $inputs['asset_location_id'] ?? null;
        $stocks = self::where('item_id', $inputs['item_id'])
            ->where('item_status_id', $inputs['item_status_id'])
            ->where('user_id', $inputs['user_id'])
            ->where('dept', $inputs['dept'])
            ->where('asset_location_id', $assetLoc)
            ->first();

        return $stocks;
    }

    public static function remove($inputs)
    {
        $stock = self::getStock($inputs);
        if (!$stock) {
            return false;
        }

        if($stock->stock_quantity != 0 && $stock->stock_quantity != null) {
            $stock->decrement('stock_quantity', $inputs['quantity']);
        }

    }

    public static function add($inputs)
    {
        $stockItems = [
            'item_id'=> $inputs['item_id'],
            'item_status_id'=> $inputs['item_status_id'],
            'user_id'=> $inputs['user_id'],
            'dept'=>$inputs['dept'],
            'stock_quantity'=>$inputs['quantity'],
            'asset_location_id'=>$inputs['asset_location_id'] ?? null
        ];
        $stock = self::getStock($inputs);

        if ($stock) {
            $stockItems['stock_quantity'] += $stock->stock_quantity;
            $stock->update($stockItems);
        } else {
            self::create($stockItems);
        }
    }

    public static function getStockItems($params = [])
    {
        $whereCondition = '';
        if(!empty($params['user_id'])) {
            $whereCondition .= " AND stock.user_id = '" . $params['user_id'] . "'";
        }
        $sql = "
            SELECT stock.dept, '' AS user, item.name_en AS item,
                    stock.item_status_id AS item_status,
                    stock.stock_quantity
            FROM `inv_stocks` AS stock
            LEFT JOIN inv_item_information AS item ON stock.item_id = item.id
            WHERE stock.user_id IS NULL $whereCondition

            UNION ALL

            SELECT stock.dept, users.name_en AS user, item.name_en AS item,
                    stock.item_status_id AS item_status,
                    stock.stock_quantity
            FROM `inv_stocks` AS stock
            LEFT JOIN inv_item_information AS item ON stock.item_id = item.id
            LEFT JOIN users ON stock.user_id = users.id
            WHERE stock.user_id IS NOT NULL $whereCondition;
        ";

        return DB::select($sql);
    }

    public static function getRoomWiseStockItems($params = [])
    {
        $whereCondition = '';
        if(!empty($params['user_id'])) {
            $whereCondition .= " AND stock.user_id = '" . $params['user_id'] . "'";
        }
        if(!empty($params['location_id'])) {
            $whereCondition .= " AND stock.asset_location_id = '" . $params['location_id'] . "'";
        }
        $sql = "

            SELECT stock.dept, users.name_en AS user, item.name_en AS item,
                    stock.item_status_id AS item_status,
                    stock.stock_quantity, room.name_en AS room
            FROM `inv_stocks` AS stock
            LEFT JOIN inv_item_information AS item ON stock.item_id = item.id
            LEFT JOIN common_labels AS room ON stock.asset_location_id = room.id
            LEFT JOIN users ON stock.user_id = users.id
            WHERE stock.user_id IS NOT NULL $whereCondition;
        ";

        return DB::select($sql);
    }
}
