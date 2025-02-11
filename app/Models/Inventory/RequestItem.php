<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\CommonLabel;
use App\Models\Inventory\InvSupplier;
use DB;
use Auth;

class RequestItem extends Model
{
    use HasFactory;
    protected $table = 'inv_request_items';

    protected $fillable = [
        'requested_date',
        'location_id',
        'approved_date', 'received_date',
        'is_requested', 'is_approved', 'is_received', 'requested_by',
        'approved_by', 'received_by',
        'forwarded_user_id',
        'remarks',
        'created_at', 'updated_at'
    ];

    /**
     * Get the location that owns the request item.
     */
    public function location()
    {
        return $this->belongsTo(CommonLabel::class, 'location_id');
    }

    public function getReceiveDateAttribute($value)
    {
        if ($value) {
            return date('d-m-Y', strtotime($value));
        } else {
            return null;
        }
    }
    public function setReceiveDateAttribute($value)
    {
        if ($value) {
            $this->attributes['receive_date'] =  date('Y-m-d', strtotime($value));
        } else {
            $this->attributes['receive_date'] = null;
        }
    }

    public function getRequestedDateAttribute($value)
    {
        if ($value) {
            return date('d-m-Y', strtotime($value));
        } else {
            return null;
        }
    }
    public function setRequestedDateAttribute($value)
    {
        if ($value) {
            $this->attributes['requested_date'] =  date('Y-m-d', strtotime($value));
        } else {
            $this->attributes['requested_date'] = null;
        }
    }
    public function itemDetails()
    {
        return $this->hasMany(RequestItemDetails::class, 'request_item_master_id', 'id');
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
    public static function getMasterData()
    {
        $data['assetLocation'] = CommonLabel::getCLWithKeyValue('asset-location');
        $data['itemCategory'] = InvItemCategorySubCategoryInformation::pluck('name_en', 'id');
        $data['item'] = InvItemInformation::pluck('name_en', 'id');
        $data['status'] = getItemStatus();
        $data['supplier'] = InvSupplier::pluck('name_en', 'id');
        return $data;
    }

    public static function saveOrUpdate($request, $id = null)
    {
        $requestData = $request->all();
        if (is_null($id)) {
            $requestData['created_by'] = Auth::id();
            //$requestData['requested_date'] = date('Y-m-d');
            $requestData['is_requested'] = 1;
            $requestData['requested_by'] = Auth::id();
            //dd($requestData);
            $requestedItem = self::create($requestData);
        } else {
            $requestedItem = self::findOrFail($id);
            $requestData['updated_by'] = Auth::id();
            $requestedItem->update($requestData);
        }

        RequestItemDetails::saveRequestedItem($request->all(), $requestedItem->id);
    }
}
