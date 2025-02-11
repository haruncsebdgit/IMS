<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;

class ReturnItem extends Model
{
    use HasFactory;

    protected $table = 'inv_return_items';

    protected $fillable = [
        'return_date',
        'approved_date',
        'is_approved',
        'approved_by',
        'remarks',
        'created_at', 'updated_at'
    ];

    public function getReturnDateAttribute($value)
    {
        if ($value) {
            return date('d-m-Y', strtotime($value));
        } else {
            return null;
        }
    }
    public function setReturnDateAttribute($value)
    {
        if ($value) {
            $this->attributes['return_date'] =  date('Y-m-d', strtotime($value));
        } else {
            $this->attributes['return_date'] = null;
        }
    }

    public function itemDetails()
    {
        return $this->hasMany(ReturnItemDetails::class, 'return_item_master_id', 'id');
    }

    public static function getAll($args = array(), $id = null)
    {
        $defaults = array(
            'exclude'           => array(),
            'order'             => array(
                'id'      => 'desc'
            ),
            'items_per_page' => -1,
            'paginate'       => false, // ignored, if 'items_per_page' = -1
        );
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $arguments = parseArguments($args, $defaults);

        $requestedItems = self::query();

        if (!is_null($id)) {
            $requestedItems = $requestedItems->where('inv_request_items.id', $id);
        }

        if (!empty($arguments['request_from']) || !empty($arguments['request_to'])) {
            $dateFrom = date('Y-m-d', strtotime($arguments['request_from']));
            $dateTo = date('Y-m-d', strtotime($arguments['request_to']));

            $requestedItems = $requestedItems
                ->whereDate('inv_request_items.requested_date', '>=', $dateFrom);
            $requestedItems = $requestedItems
                ->whereDate('inv_request_items.requested_date', '<=', $dateTo);
        }

        foreach ($arguments['order'] as $orderBy => $order) {
            $requestedItems = $requestedItems->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $requestedItems = $requestedItems->get();
        } else {
            if (true == $arguments['paginate']) {
                $requestedItems = $requestedItems->paginate(intval($arguments['items_per_page']));
            } else {
                $requestedItems = $requestedItems->take(intval($arguments['items_per_page']));
                $requestedItems = $requestedItems->get();
            }
        }

        return $requestedItems;
    }
    public static function getMasterData($inv_item_receive_from_supplier_information = null)
    {
        $data['itemCategory'] = InvItemCategorySubCategoryInformation::pluck('name_en', 'id');
        $data['item'] = InvItemInformation::pluck('name_en', 'id');
        $data['status'] = getItemStatus();
        $data['inventory'] = [];
        $data['supplier'] = InvSupplier::pluck('name_en', 'id');
        $data['package'] = [];
        return $data;
    }

    public static function saveOrUpdate($request, $id = null)
    {
        $requestData = $request->all();
        if (is_null($id)) {
            $requestData['created_by'] = Auth::id();
            $requestedItem = self::create($requestData);
        } else {
            $requestedItem = self::findOrFail($id);
            $requestData['updated_by'] = Auth::id();
            $requestedItem->update($requestData);
        }

        ReturnItemDetails::saveRequestedItem($request->all(), $requestedItem->id);
    }
}
