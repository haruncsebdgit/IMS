<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\OrganizationScope;
use App\Models\Settings\CommonLabel;
use App\Models\Settings\Organogram;
use App\Models\Procurement\Package;
use App\Models\Inventory\InvSupplier;
use DB;
use Auth;

class InvItemReceiveFromSupplierInformation extends Model
{
    use HasFactory;
    protected $table = 'inv_item_receive_from_supplier_information';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'division_id', 'district_id', 'upazila_id', 'organization_id', 'inventory_center_id', 'supplier_id',
        'package_lot_id', 'po_number',
        'receive_date', 'invoice_no', 'invoice_date', 'supplier_remarks',
        'created_by', 'updated_by',
        'created_at', 'updated_at'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new OrganizationScope);
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

    public function getInvoiceDateAttribute($value)
    {
        if ($value) {
            return date('d-m-Y', strtotime($value));
        } else {
            return null;
        }
    }
    public function setInvoiceDateAttribute($value)
    {
        if ($value) {
            $this->attributes['invoice_date'] =  date('Y-m-d', strtotime($value));
        } else {
            $this->attributes['invoice_date'] = null;
        }
    }
    public function ivnSupplierItemInfo()
    {
        return $this->hasMany(InvSupplierItemInfo::class, 'supplier_item_id', 'id');
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

        $itemReceives = InvItemReceiveFromSupplierInformation::query()
            ->leftJoin('inv_item_category_sub_category_information AS c', 'inv_item_receive_from_supplier_information.created_by', '=', 'c.id')
            ->leftJoin('users AS u', 'inv_item_receive_from_supplier_information.created_by', '=', 'u.id')
            ->leftJoin('inv_suppliers AS is', 'inv_item_receive_from_supplier_information.supplier_id', '=', 'is.id')

            ->select(
                'inv_item_receive_from_supplier_information.*',
                "u.$name AS user_name",
                "is.$name AS supplier_name"
            );

        if (!is_null($id)) {
            $itemReceives = $itemReceives->where('inv_item_receive_from_supplier_information.id', $id);
        }

        if (!empty($arguments['supplier'])) {
            $itemReceives = $itemReceives->where('inv_item_receive_from_supplier_information.supplier_id', '=',  $arguments['supplier']);
        }
        if (!empty($arguments['package'])) {
            $itemReceives = $itemReceives->where('inv_item_receive_from_supplier_information.package_lot_id', '=', $arguments['package']);
        }
        if (!empty($arguments['po_number'])) {
            $itemReceives = $itemReceives->where('inv_item_receive_from_supplier_information.po_number', 'LIKE', '%' . $arguments['po_number'] . '%');
        }

        if (!empty($arguments['date_from']) || !empty($arguments['date_to'])) {
            $dateFrom = date('Y-m-d', strtotime($arguments['date_from']));
            $dateTo = date('Y-m-d', strtotime($arguments['date_to']));

            $itemReceives = $itemReceives
                ->whereDate('inv_item_receive_from_supplier_information.receive_date', '>=', $dateFrom);
            $itemReceives = $itemReceives
                ->whereDate('inv_item_receive_from_supplier_information.receive_date', '<=', $dateTo);
        }



        foreach ($arguments['order'] as $orderBy => $order) {
            $itemReceives = $itemReceives->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $itemReceives = $itemReceives->get();
        } else {
            if (true == $arguments['paginate']) {
                $itemReceives = $itemReceives->paginate(intval($arguments['items_per_page']));
            } else {
                $itemReceives = $itemReceives->take(intval($arguments['items_per_page']));
                $itemReceives = $itemReceives->get();
            }
        }

        return $itemReceives;
    }
    public static function getMasterData($itemReceives = null)
    {
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
        $requestData['user_id'] = null;
        $requestData['dept'] = 'dept_cse';
        if (is_null($id)) {
            $requestData['created_by'] = Auth::id();

            $items = InvItemReceiveFromSupplierInformation::create($requestData);
        } else {
            $items = InvItemReceiveFromSupplierInformation::findOrFail($id);
            $requestData['updated_by'] = Auth::id();
            $items->update($requestData);
        }

        InvSupplierItemInfo::saveItems($requestData, $items->id);
    }
}
