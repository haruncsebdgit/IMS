<?php

namespace App\Models\Inventory;

use DB;
use Auth;
use App\Models\User;
use App\Models\Settings\CommonLabel;
use App\Models\Inventory\InvSupplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemAllocation extends Model
{
    use HasFactory;

    protected $table = 'inv_item_allocations';

    protected $fillable = [
        'user_id',
        'allocation_date',
        'location_id',
        'approved_date', 'received_date',
        'is_approved', 'is_received',
        'approved_by', 'received_by',
        'forwarded_user_id',
        'remarks',
        'created_at', 'updated_at',
        'created_by', 'updated_by'
    ];

    /**
     * Get the location that owns the request item.
     */
    public function location()
    {
        return $this->belongsTo(CommonLabel::class, 'location_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAllocationDateAttribute($value)
    {
        if ($value) {
            return date('d-m-Y', strtotime($value));
        } else {
            return null;
        }
    }
    public function setAllocationDateAttribute($value)
    {
        if ($value) {
            $this->attributes['allocation_date'] =  date('Y-m-d', strtotime($value));
        } else {
            $this->attributes['allocation_date'] = null;
        }
    }

    public function itemDetails()
    {
        return $this->hasMany(ItemAllocationDetails::class, 'allocation_item_master_id', 'id');
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
            $requestedItems = $requestedItems->where('inv_item_allocations.id', $id);
        }

        if (!empty($arguments['request_from']) || !empty($arguments['request_to'])) {
            $dateFrom = date('Y-m-d', strtotime($arguments['request_from']));
            $dateTo = date('Y-m-d', strtotime($arguments['request_to']));

            $requestedItems = $requestedItems
                ->whereDate('inv_item_allocations.allocation_date', '>=', $dateFrom);
            $requestedItems = $requestedItems
                ->whereDate('inv_item_allocations.allocation_date', '<=', $dateTo);
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
        $data['userLists'] = User::getUserListWithDesignation();
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

        ItemAllocationDetails::saveRequestedItem($request->all(), $requestedItem->id);
    }
}
