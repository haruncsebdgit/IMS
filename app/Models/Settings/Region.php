<?php
namespace App\Models\Settings;


use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

/**
 * Division Model.
 * php version >= 7.3
 *
 * @category Application
 * @package  LGSP3
 * @author   Ariful Islam Srabon <arif.cse18604@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class Region extends Model
{
    protected $table = 'regions';

    protected $fillable = [
        'name_en',
        'name_bn',
        'geo_code',
        'latitude',
        'longitude',
        'is_active',

        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];


    /**
     * Get All list of Division.
     *
     * @param array $args Array of arguments.
     *
     * @return object.
     * --------------------------------------------------
     */
    public static function getRegions($args = array())
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $defaults = array(
            'exclude'        => array(),
            'name'           => null, // int|array
            'geo_code'       => null, // int|array
            'is_active'      => null, // int|array
            'status'         => 'all',
            'order'          => array(
                'regions.id'    => 'desc',
                "regions.$name" => 'asc',
            ),
            'items_per_page' => -1,
            'paginate'       => false, // ignored, if 'items_per_page' = -1
        );

        $arguments = parseArguments($args, $defaults);

        $regions = DB::table('regions');

        $regions = $regions->select('regions.*');


        if (!empty($arguments['exclude'])) {
            $regions = $regions->whereNotIn('regions.id', $arguments['exclude']);
        }

        if (!empty($arguments['is_active'])) {
            if ($arguments['is_active'] === 'active') {
                $regions = $regions->where('regions.is_active', 1);
            } elseif ($arguments['is_active'] === 'inactive') {
                $regions = $regions->where('regions.is_active', 0);
            }
        }

        if (!empty($arguments['name'])) {
            $search_name = $arguments['name'];
            $regions = $regions ->where(function($regions) use ($search_name){
                $regions->where('regions.name_en', 'LIKE', '%'.$search_name.'%');
                $regions->orWhere('regions.name_bn', 'LIKE', '%'.$search_name.'%');
            });
        }

        if (!empty($arguments['geo_code'])) {
            $regions = $regions->where('regions.geo_code', $arguments['geo_code']);
        }

        foreach ($arguments['order'] as $orderBy => $order) {
            $regions = $regions->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $regions = $regions->get();
        } else {
            if (true == $arguments['paginate']) {
                $regions = $regions->paginate(intval($arguments['items_per_page']));
            } else {
                $regions = $regions->take(intval($arguments['items_per_page']));
                $regions = $regions->get();
            }
        }

        return $regions;
    }

    /**
     * Get Region names & ids.
     *
     * @return array List of Regions.
     */
    public function getRegionList()
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $regions = DB::table($this->table)
            ->select('name_en', 'name_bn', 'id')
            ->where('is_active', 1)
            ->orderBy("$name", 'ASC')
            ->get();

        return $regions;
    }

    /**
     * Get Regions names & ids.
     *
     * @return array List of Regions.
     */
    public static function getRegionsListArray($regionId = null)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $regions = DB::table('regions')
            ->where('is_active', 1)
            ->orderBy("$name", 'ASC');

            if(!empty($regionId)){
                $regions = $regions->whereId($regionId);
            }

        return $regions->pluck($name, 'id');
    }


    /**
     * Get Region names & ids.
     *
     * @return array List of Regions.
     */
    public function getRegionById($region_id)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $regions = DB::table($this->table)
            ->select('name_en', 'name_bn', 'id')
            ->where('id', $region_id)
            ->where('is_active', 1)
            ->orderBy("$name", 'ASC')
            ->get();

        return $regions;
    }

   
}
