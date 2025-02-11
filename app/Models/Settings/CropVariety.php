<?php

namespace App\Models\Settings;

use DB;
use Auth;
use App\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Model;

class CropVariety extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'crop_varieties';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
            'crop_id', 'crop_type_id',
            'name_en', 'name_bn',
            'unit_id', 'crop_lifetime_id',
            'organization_id',
            'organogram_id',
            'project_id',
            'is_active',
            'created_at',
            'created_by',
            'updated_by',
            'updated_at',
        ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new OrganizationScope);
    }

    /**
     * Get crop_varieties List.
     *
     * @param array $args Array of arguments.
     *
     * @return object Object of fetch crop_varieties otherwise null.
     * --------------------------------------------------
     */
    public static function getAll($args = array())
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

        $cropVarieties = CropVariety::query()
                        ->leftJoin('common_labels AS crop', 'crop_varieties.crop_id', '=', 'crop.id')
                        ->leftJoin('common_labels AS unit', 'crop_varieties.unit_id', '=', 'unit.id')
                        ->select('crop_varieties.*',
                            "crop.$name AS crops",
                            "unit.$name AS unit"
                        );

        if (!empty($arguments['crop_id'])) {
            $cropVarieties = $cropVarieties->where('crop_varieties.crop_id', $arguments['crop_id']);
        }
        if (!empty($arguments['crop_type_id'])) {
            $cropVarieties = $cropVarieties->where('crop_varieties.crop_type_id', $arguments['crop_type_id']);
        }
        foreach ($arguments['order'] as $orderBy => $order) {
            $cropVarieties = $cropVarieties->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $cropVarieties = $cropVarieties->get();
        } else {
            if (true == $arguments['paginate']) {
                $cropVarieties = $cropVarieties->paginate(intval($arguments['items_per_page']));
            } else {
                $cropVarieties = $cropVarieties->take(intval($arguments['items_per_page']));
                $cropVarieties = $cropVarieties->get();
            }
        }

        return $cropVarieties;
    }

    public static function saveOrUpdate($requestData, $id = null)
    {
        if (is_null($id)) {
            CropVariety::create($requestData);
        } else {
            CropVariety::findOrFail($id)->update($requestData);
        }
    }

    public static function getCommonConfigData()
    {
        $data['crops'] = CommonLabel::getCLWithKeyValue('crop-name');
        $data['units'] = CommonLabel::getCLWithKeyValue('units');
        return $data;
    }
}
