<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\OrganizationScope;
class TechnologyModel extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'technologies';

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
            'organization_id',
            'organogram_id',
            'project_id',
            'technology_type_id', 'name_en', 'name_bn',
            'code', 'is_active', 'order',
            'created_by', 'updated_by',
            'created_at', 'updated_at'
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
     * Get cigs List.
     *
     * @param array $args Array of arguments.
     *
     * @return object Object of fetch cigs otherwise null.
     * --------------------------------------------------
     */
    public static function getAll($args = array(), $id = null)
    {
        $defaults = array(
            'exclude'           => array(),
            'name'=>"",
            'is_active'=>"",
            'technology_type_id'=>"",
            'order'             => array(
                'id'      => 'desc',
            ),
            'items_per_page' => -1,
            'paginate'       => false, // ignored, if 'items_per_page' = -1
        );
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $arguments = parseArguments($args, $defaults);

        $technologies = TechnologyModel::query()
                
                ->leftJoin('common_labels AS technologyType', 'technologies.technology_type_id', '=', 'technologyType.id')
                ->select('technologies.*',
                    "technologyType.$name AS technologyTypeName",
                );

        if (!is_null($id)) {
            $technologies = $technologies->where('technologies.id', $id);
        }

        if (!empty($arguments['name'])) {
            $search_name = $arguments['name'];
            
            $technologies = $technologies->where(
            function ($technologies) use ($search_name) {
            $technologies->where('technologies.name_en', 'LIKE', '%' . $search_name . '%')->orWhere('technologies.name_bn', 'LIKE', '%' . $search_name . '%');
            }
            );
        }

        if (!empty($arguments['is_active'])) {
            $technologies = $technologies->where('technologies.is_active', $arguments['is_active']);
        }
        if (!empty($arguments['technology_type_id'])) {
            $technologies = $technologies->where('technologies.technology_type_id', $arguments['technology_type_id']);
        }

        foreach ($arguments['order'] as $orderBy => $order) {
            $technologies = $technologies->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $technologies = $technologies->get();
        } else {
            if (true == $arguments['paginate']) {
                $technologies = $technologies->paginate(intval($arguments['items_per_page']));
            } else {
                $technologies = $technologies->take(intval($arguments['items_per_page']));
                $technologies = $technologies->get();
            }
        }

        return $technologies;
    }





    /**
     * Get Technology List according to organization
     */
    public static function getTechnologList($typeId = null)
    {
        $lang = config('app.locale');
        $name = "name_{$lang} AS name";
        $technology = TechnologyModel::where('is_active',1);
        if(!empty($typeId)){
            $technology = $technology->where('technology_type_id',$typeId);
        }
        $technology = $technology->pluck($name, 'id');
        return $technology;
    }

}


