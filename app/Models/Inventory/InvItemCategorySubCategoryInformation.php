<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\CommonLabel;
use App\Models\Settings\District;
use App\Models\Settings\Division;
use App\Models\Settings\ThanaUpazila;
use App\Models\Settings\UnionWard;
use App\Scopes\OrganizationScope;
use DB;

class InvItemCategorySubCategoryInformation extends Model
{
    use HasFactory;
    

    protected $table = 'inv_item_category_sub_category_information';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'organization_id','name_en', 'name_bn',
        'code_en', 'code_bn',
        'parent_id', 'remarks',
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

        $item_category_sub_category_information = InvItemCategorySubCategoryInformation::query()
            ->leftjoin('inv_item_category_sub_category_information AS itm', 'inv_item_category_sub_category_information.parent_id' , 'itm.id')
            ->select(
                'inv_item_category_sub_category_information.*',
                'itm.name_en AS parent'
            );

        if (!is_null($id)) {
            $item_category_sub_category_information = $item_category_sub_category_information->where('inv_item_category_sub_category_information.id', $id);
        }

        if (!empty($arguments['name_en'])) {
            $item_category_sub_category_information = $item_category_sub_category_information->where('inv_item_category_sub_category_information.name_en', 'LIKE', '%' . $arguments['name_en'] . '%');
        }
        if (!empty($arguments['name_bn'])) {
            $item_category_sub_category_information = $item_category_sub_category_information->where('inv_item_category_sub_category_information.name_bn', 'LIKE', '%' . $arguments['name_bn'] . '%');
        }

        if (!empty($arguments['parent'])) {
            $item_category_sub_category_information = $item_category_sub_category_information->where('inv_item_category_sub_category_information.parent_id', '=', $arguments['parent']);
        }

        

        foreach ($arguments['order'] as $orderBy => $order) {
            $item_category_sub_category_information = $item_category_sub_category_information->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $item_category_sub_category_information = $item_category_sub_category_information->get();
        } else {
            if (true == $arguments['paginate']) {
                $item_category_sub_category_information = $item_category_sub_category_information->paginate(intval($arguments['items_per_page']));
            } else {
                $item_category_sub_category_information = $item_category_sub_category_information->take(intval($arguments['items_per_page']));
                $item_category_sub_category_information = $item_category_sub_category_information->get();
            }
        }

        return $item_category_sub_category_information;
    }
    public static function getMasterData($item_category_sub_category_information = null)
    {
        $data['category'] = InvItemCategorySubCategoryInformation::pluck('name_en', 'id');
        
        return $data;
    }
}
