<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\OrganizationScope;
use App\Models\Settings\CommonLabel;
use App\Models\Settings\Organogram;
use DB;
use Auth;

class InvItemOnSupportReturnToSupplierVendorInformation extends Model
{
    use HasFactory;
    protected $table = 'inv_item_on_support_return_to_supplier_vendor_information';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'organization_id','date', 'inventory_cost_center',
        'supplier_vendor', 'return_remarks',
        'created_by', 'updated_by',
        'created_at', 'updated_at'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new OrganizationScope);
    }

    public function getDateAttribute($value)
    {
        if ($value) {
            return date('d-m-Y', strtotime($value));
        } else {
            return null;
        }
    }
    public function setDateAttribute($value)
    {
        if ($value) {
            $this->attributes['date'] =  date('Y-m-d', strtotime($value));
        } else {
            $this->attributes['date'] = null;
        }
    }

    
    public function ivnReturnItemInfo()
    {
        return $this->hasMany(InvReturnItemInfo::class, 'return_item_id' , 'id');
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

        $item_on_support_return_to_supplier_vendor_information = InvItemOnSupportReturnToSupplierVendorInformation::query()
            ->leftJoin('users AS u', 'inv_item_on_support_return_to_supplier_vendor_information.created_by', '=', 'u.id')
            ->leftJoin('organograms AS o', 'inv_item_on_support_return_to_supplier_vendor_information.inventory_cost_center', '=', 'o.id')
            ->leftJoin('inv_return_item_infos AS i', 'inv_item_on_support_return_to_supplier_vendor_information.id', '=', 'i.return_item_id')
            ->select(
                'inv_item_on_support_return_to_supplier_vendor_information.*',
                "u.$name AS user_name",
                "o.$name AS inventory_name",
                "i.item_id AS items",
            );
            // dd($item_on_support_return_to_supplier_vendor_information->get());

        if (!is_null($id)) {
            $item_on_support_return_to_supplier_vendor_information = $item_on_support_return_to_supplier_vendor_information->where('inv_item_on_support_return_to_supplier_vendor_information.id', $id);
        }

        if (!empty($arguments['transaction_id'])) {
            $item_on_support_return_to_supplier_vendor_information = $item_on_support_return_to_supplier_vendor_information->where('inv_item_on_support_return_to_supplier_vendor_information.id', '=', $arguments['transaction_id'] );
        }
        if (!empty($arguments['inventory_center_from'])) {
            $item_on_support_return_to_supplier_vendor_information = $item_on_support_return_to_supplier_vendor_information->where('inv_item_on_support_return_to_supplier_vendor_information.inventory_cost_center', '=', $arguments['inventory_center_from']);
        }

        // if (!empty($arguments['item'])) {
        //     $item_on_support_return_to_supplier_vendor_information = $item_on_support_return_to_supplier_vendor_information->where('inv_item_on_support_return_to_supplier_vendor_information.items', '=', $arguments['item']);
        // }

        if (!empty($arguments['date_from']) || !empty($arguments['date_to']) ) {
            $dateFrom = date('Y-m-d', strtotime( $arguments['date_from'] ));
            $dateTo = date('Y-m-d', strtotime( $arguments['date_to'] ));
            
            $item_on_support_return_to_supplier_vendor_information = $item_on_support_return_to_supplier_vendor_information
                ->whereDate('inv_item_on_support_return_to_supplier_vendor_information.date', '>=', $dateFrom);
            $item_on_support_return_to_supplier_vendor_information = $item_on_support_return_to_supplier_vendor_information
                ->whereDate('inv_item_on_support_return_to_supplier_vendor_information.date', '<=', $dateTo);
    
        }
         
        foreach ($arguments['order'] as $orderBy => $order) {
            $item_on_support_return_to_supplier_vendor_information = $item_on_support_return_to_supplier_vendor_information->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $item_on_support_return_to_supplier_vendor_information = $item_on_support_return_to_supplier_vendor_information->get();
        } else {
            if (true == $arguments['paginate']) {
                $item_on_support_return_to_supplier_vendor_information = $item_on_support_return_to_supplier_vendor_information->paginate(intval($arguments['items_per_page']));
            } else {
                $item_on_support_return_to_supplier_vendor_information = $item_on_support_return_to_supplier_vendor_information->take(intval($arguments['items_per_page']));
                $item_on_support_return_to_supplier_vendor_information = $item_on_support_return_to_supplier_vendor_information->get();
            }
        }

        return $item_on_support_return_to_supplier_vendor_information;
    }
    public static function getMasterData($item_on_support_return_to_supplier_vendor_information = null)
    {
        $data['item'] = InvItemCategorySubCategoryInformation::pluck('name_en', 'id');
        $data['inventory'] = Organogram::where('is_inventory_center', 1)->pluck('name_en', 'id');
        $data['status'] = CommonLabel::getCLWithKeyValue('status');
        return $data;
    }

    public static function saveOrUpdate($request, $id = null)
    {
        $requestData = $request->all();
        $requestData['organization_id'] = auth()->user()->organization_id;
        if (is_null($id)) {
            $requestData['created_by'] = Auth::id();

            $item_on_support_return_to_supplier_vendor_information = InvItemOnSupportReturnToSupplierVendorInformation::create($requestData);
        } else {
            $item_on_support_return_to_supplier_vendor_information = InvItemOnSupportReturnToSupplierVendorInformation::findOrFail($id);
            $requestData['updated_by'] = Auth::id();
            $item_on_support_return_to_supplier_vendor_information->update($requestData);
        }

        InvReturnItemInfo::saveReturnItemInfo($request->all(), $item_on_support_return_to_supplier_vendor_information->id);
        }
}
