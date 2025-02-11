<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\CommonLabel;
use App\Scopes\OrganizationScope;
use DB;

class InvItemInformation extends Model
{
    use HasFactory;

    protected $table = 'inv_item_information';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'organization_id','name_en', 'name_bn',
        'code_en', 'code_bn',
        'asset_type', 'category_id',
        'uom_id', 'manufacturer_id',
        'model', 'part_number',
        'min_re_order_qty', 'remarks','is_serialized', 'is_active',
        'created_by', 'updated_by',
        'created_at', 'updated_at'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new OrganizationScope);
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

        $item_information = InvItemInformation::query()
            ->leftjoin('inv_item_category_sub_category_information AS itm', 'inv_item_information.category_id' , 'itm.id')
            ->leftJoin('common_labels AS unit', 'inv_item_information.uom_id', '=', 'unit.id')
            ->leftJoin('common_labels AS manufac', 'inv_item_information.manufacturer_id', '=', 'manufac.id')
            ->select(
                'inv_item_information.*',
                'itm.name_en AS category',
                "unit.$name AS uoM",
                "manufac.$name AS manufacturer"
            );

        if (!is_null($id)) {
            $item_information = $item_information->where('inv_item_information.id', $id);
        }

        if (!empty($arguments['name_en'])) {
            $item_information = $item_information->where('inv_item_information.name_en', 'LIKE', '%' . $arguments['name_en'] . '%');
        }
        if (!empty($arguments['name_bn'])) {
            $item_information = $item_information->where('inv_item_information.code_en', 'LIKE', '%' . $arguments['code_en'] . '%');
        }

        if (!empty($arguments['category'])) {
            $item_information = $item_information->where('inv_item_information.category_id', '=', $arguments['category']);
        }

        if (!empty($arguments['part_number'])) {
            $item_information = $item_information->where('inv_item_information.part_number', 'LIKE', '%' . $arguments['part_number'] . '%');
        }
        if (!empty($arguments['code_en'])) {
            $item_information = $item_information->where('inv_item_information.code_en', $arguments['code_en']);
        }



        foreach ($arguments['order'] as $orderBy => $order) {
            $item_information = $item_information->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $item_information = $item_information->get();
        } else {
            if (true == $arguments['paginate']) {
                $item_information = $item_information->paginate(intval($arguments['items_per_page']));
            } else {
                $item_information = $item_information->take(intval($arguments['items_per_page']));
                $item_information = $item_information->get();
            }
        }

        return $item_information;
    }
    public static function getMasterData($item_information = null)
    {
        $data['category'] = InvItemCategorySubCategoryInformation::pluck('name_en', 'id');
        $data['assetType'] = getAssetType();
        $data['uoM'] = CommonLabel::getCLWithKeyValue('units');
        $data['manufacturer'] = CommonLabel::getCLWithKeyValue('manufacturer');
        return $data;
    }
}
