<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\OrganizationScope;
use App\Models\Settings\CommonLabel;
use App\Models\Settings\Organogram;
use DB;
use Auth;

class InvItemTransferReceiveInformation extends Model
{
    use HasFactory;
    protected $table = 'inv_item_transfer_receive_information';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'organization_id','transfer_date', 'inventory_cost_center_from',
        'inventory_cost_center_to', 'transfer_receive_remarks',
        'created_by', 'updated_by',
        'created_at', 'updated_at'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new OrganizationScope);
    }

    public function getTransferDateAttribute($value)
    {
        if ($value) {
            return date('d-m-Y', strtotime($value));
        } else {
            return null;
        }
    }
    public function setTransferDateAttribute($value)
    {
        if ($value) {
            $this->attributes['transfer_date'] =  date('Y-m-d', strtotime($value));
        } else {
            $this->attributes['transfer_date'] = null;
        }
    }

    
    public function ivnTransferReceiveItemInfo()
    {
        return $this->hasMany(InvItemTransferReceiveInformationItemInformation::class, 'transfer_receive_item_id' , 'id');
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

        $inv_item_transfer_receive_information = InvItemTransferReceiveInformation::query()
            ->leftJoin('users AS u', 'inv_item_transfer_receive_information.created_by', '=', 'u.id')
            ->leftJoin('organograms AS o', 'inv_item_transfer_receive_information.inventory_cost_center_from', '=', 'o.id')
            ->leftJoin('organograms AS org', 'inv_item_transfer_receive_information.inventory_cost_center_to', '=', 'org.id')
            ->select(
                'inv_item_transfer_receive_information.*',
                "u.$name AS user_name",
                "o.$name AS inventory_name_from",
                "org.$name AS inventory_name_to",
            );

        if (!is_null($id)) {
            $inv_item_transfer_receive_information = $inv_item_transfer_receive_information->where('inv_item_transfer_receive_information.id', $id);
        }

        if (!empty($arguments['receive_id'])) {
            $inv_item_transfer_receive_information = $inv_item_transfer_receive_information->where('inv_item_transfer_receive_information.id', '=',  $arguments['receive_id']);
        }
        if (!empty($arguments['inventory_center_from'])) {
            $inv_item_transfer_receive_information = $inv_item_transfer_receive_information->where('inv_item_transfer_receive_information.inventory_cost_center_from', '=', $arguments['inventory_center_from']);
        }
    

        if (!empty($arguments['date_from']) || !empty($arguments['date_to']) ) {
            $dateFrom = date('Y-m-d', strtotime( $arguments['date_from'] ));
            $dateTo = date('Y-m-d', strtotime( $arguments['date_to'] ));
            
            $inv_item_transfer_receive_information = $inv_item_transfer_receive_information
                ->whereDate('inv_item_transfer_receive_information.transfer_date', '>=', $dateFrom);
            $inv_item_transfer_receive_information = $inv_item_transfer_receive_information
                ->whereDate('inv_item_transfer_receive_information.transfer_date', '<=', $dateTo);
    
        }

        

        foreach ($arguments['order'] as $orderBy => $order) {
            $inv_item_transfer_receive_information = $inv_item_transfer_receive_information->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $inv_item_transfer_receive_information = $inv_item_transfer_receive_information->get();
        } else {
            if (true == $arguments['paginate']) {
                $inv_item_transfer_receive_information = $inv_item_transfer_receive_information->paginate(intval($arguments['items_per_page']));
            } else {
                $inv_item_transfer_receive_information = $inv_item_transfer_receive_information->take(intval($arguments['items_per_page']));
                $inv_item_transfer_receive_information = $inv_item_transfer_receive_information->get();
            }
        }

        return $inv_item_transfer_receive_information;
    }
    public static function getMasterData($inv_item_transfer_receive_information = null)
    {
        $data['item'] = InvItemCategorySubCategoryInformation::pluck('name_en', 'id');
        $data['status'] = CommonLabel::getCLWithKeyValue('status');
        $data['inventory'] = Organogram::where('is_inventory_center', 1)->pluck('name_en', 'id');
        $data['supplier'] = InvSupplier::pluck('name_en', 'id');
        
        return $data;
    }

    public static function saveOrUpdate($request, $id = null)
    {
        $requestData = $request->all();
        $requestData['organization_id'] = auth()->user()->organization_id;
        if (is_null($id)) {
            $requestData['created_by'] = Auth::id();

            $inv_item_transfer_receive_information = InvItemTransferReceiveInformation::create($requestData);
        } else {
            $inv_item_transfer_receive_information = InvItemTransferReceiveInformation::findOrFail($id);
            $requestData['updated_by'] = Auth::id();
            $inv_item_transfer_receive_information->update($requestData);
        }

        InvItemTransferReceiveInformationItemInformation::saveIvnTransferReceiveItemInfo($request->all(), $inv_item_transfer_receive_information->id);
        }
}
