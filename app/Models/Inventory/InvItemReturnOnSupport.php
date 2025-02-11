<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\OrganizationScope;
use App\Models\Settings\CommonLabel;
use App\Models\Settings\Organogram;
use DB;
use Auth;

class InvItemReturnOnSupport extends Model
{
    use HasFactory;
    protected $table = 'inv_item_return_on_supports';

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

        $inv_item_return_on_support = InvItemReturnOnSupport::query()
            ->leftJoin('users AS u', 'inv_item_return_on_supports.created_by', '=', 'u.id')
            ->leftJoin('organograms AS o', 'inv_item_return_on_supports.inventory_cost_center', '=', 'o.id')
            ->leftJoin('inv_return_item_infos AS i', 'inv_item_return_on_supports.id', '=', 'i.return_item_id')
            ->leftJoin('inv_suppliers AS is', 'inv_item_return_on_supports.supplier_vendor', '=', 'is.id')
            ->select(
                'inv_item_return_on_supports.*',
                "u.$name AS user_name",
                "o.$name AS inventory_name",
                "i.item_id AS items",
                "is.$name AS supplier",
            );
            // dd($item_on_support_return_to_supplier_vendor_information->get());

        if (!is_null($id)) {
            $inv_item_return_on_support = $inv_item_return_on_support->where('inv_item_return_on_supports.id', $id);
        }

        if (!empty($arguments['transaction_id'])) {
            $inv_item_return_on_support = $inv_item_return_on_support->where('inv_item_return_on_supports.id', '=', $arguments['transaction_id'] );
        }
        if (!empty($arguments['inventory_center_from'])) {
            $inv_item_return_on_support = $inv_item_return_on_support->where('inv_item_return_on_supports.inventory_cost_center', '=', $arguments['inventory_center_from']);
        }

        // if (!empty($arguments['item'])) {
        //     $item_on_support_return_to_supplier_vendor_information = $item_on_support_return_to_supplier_vendor_information->where('inv_item_on_support_return_to_supplier_vendor_information.items', '=', $arguments['item']);
        // }

        if (!empty($arguments['date_from']) || !empty($arguments['date_to']) ) {
            $dateFrom = date('Y-m-d', strtotime( $arguments['date_from'] ));
            $dateTo = date('Y-m-d', strtotime( $arguments['date_to'] ));
            
            $inv_item_return_on_support = $inv_item_return_on_support
                ->whereDate('inv_item_return_on_support.date', '>=', $dateFrom);
            $inv_item_return_on_support = $inv_item_return_on_support
                ->whereDate('inv_item_return_on_support.date', '<=', $dateTo);
    
        }
         
        foreach ($arguments['order'] as $orderBy => $order) {
            $inv_item_return_on_support = $inv_item_return_on_support->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $inv_item_return_on_support = $inv_item_return_on_support->get();
        } else {
            if (true == $arguments['paginate']) {
                $inv_item_return_on_support = $inv_item_return_on_support->paginate(intval($arguments['items_per_page']));
            } else {
                $inv_item_return_on_support = $inv_item_return_on_support->take(intval($arguments['items_per_page']));
                $inv_item_return_on_support = $inv_item_return_on_support->get();
            }
        }

        return $inv_item_return_on_support;
    }
    public static function getMasterData($inv_item_return_on_support = null)
    {
        $data['item'] = InvItemCategorySubCategoryInformation::pluck('name_en', 'id');
        $data['inventory'] = Organogram::where('is_inventory_center', 1)->pluck('name_en', 'id');
        $data['status'] = CommonLabel::getCLWithKeyValue('status');
        $data['supplier'] = InvSupplier::pluck('name_en', 'id');
        
        return $data;
    }

    public static function saveOrUpdate($request, $id = null)
    {
        $requestData = $request->all();
        $requestData['organization_id'] = auth()->user()->organization_id;
        if (is_null($id)) {
            $requestData['created_by'] = Auth::id();

            $inv_item_return_on_support = InvItemReturnOnSupport::create($requestData);
        } else {
            $inv_item_return_on_support = InvItemReturnOnSupport::findOrFail($id);
            $requestData['updated_by'] = Auth::id();
            $inv_item_return_on_support->update($requestData);
        }

        InvReturnItemInfo::saveReturnItemInfo($request->all(), $inv_item_return_on_support->id);
        }
}
