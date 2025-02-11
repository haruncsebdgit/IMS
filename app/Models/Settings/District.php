<?php

/**
 * District Model.
 * php version 7.1.3
 *
 * @category Application
 * @package  LGSP3
 * @author   Ariful Islam Srabon <arif.cse18604@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */

namespace App\Models\Settings;

use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

/**
 * District Model Class.
 * php version 7.1.3
 *
 * @category Application
 * @package  LGSP3
 * @author   Ariful Islam Srabon <arif.cse18604@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class District extends Model
{
    protected $table = 'districts';

    protected $fillable = [
        'division_id',
        'region_id',
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
     * Get All list of District.
     *
     * @param array $args Array of arguments.
     *
     * @return object.
     */
    public static function getDistricts($args = array())
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $defaults = array(
            'exclude'        => array(),
            'name'           => null, // int|array
            'geo_code'       => null, // int|array
            'is_active'      => null, // int|array
            'division_id'    => null, // int|array
            'status'         => 'all',
            'order'          => array(
                'districts.id'    => 'desc',
                "districts.$name" => 'asc'
            ),
            'items_per_page' => -1,
            'paginate'       => false, // ignored, if 'items_per_page' = -1
        );

        $arguments = parseArguments($args, $defaults);

        $districts = DB::table('districts');

        $districts = $districts->select(
            'districts.*',
            'divisions.name_en AS division_name_en',
            'divisions.name_bn AS division_name_bn'
        );

        $districts = $districts->leftJoin('divisions', 'divisions.id', '=', 'districts.division_id');

        if (!empty($arguments['exclude'])) {
            $districts = $districts->whereNotIn('districts.id', $arguments['exclude']);
        }
        if (!empty($arguments['division_id'])) {
            $districts = $districts->where('districts.division_id', $arguments['division_id']);
        }

        if (!empty($arguments['is_active'])) {
            if ('active' === $arguments['is_active']) {
                $districts = $districts->where('districts.is_active', 1);
            } elseif ('inactive' === $arguments['is_active']) {
                $districts = $districts->where('districts.is_active', 0);
            }
        }

        if (!empty($arguments['name'])) {
            $search_name = $arguments['name'];
            $districts   = $districts->where(
                function ($districts) use ($search_name) {
                    $districts->where('districts.name_en', 'LIKE', '%' . $search_name . '%');
                    $districts->orWhere('districts.name_bn', 'LIKE', '%' . $search_name . '%');
                }
            );
        }

        if (!empty($arguments['geo_code'])) {
            $districts = $districts->where('districts.geo_code', $arguments['geo_code']);
        }

        foreach ($arguments['order'] as $orderBy => $order) {
            $districts = $districts->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $districts = $districts->get();
        } else {
            if (true == $arguments['paginate']) {
                $districts = $districts->paginate(intval($arguments['items_per_page']));
            } else {
                $districts = $districts->take(intval($arguments['items_per_page']));
                $districts = $districts->get();
            }
        }

        return $districts;
    }

    /**
     * Get District names & ids.
     *
     * @return array List of Distrcits.
     */
    public function getDistrictList()
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $districts = DB::table($this->table)
            ->select('name_en', 'name_bn', 'id')
            ->where('is_active', 1)
            ->orderBy("$name", 'ASC')
            ->get();

        return $districts;
    }

    /**
     * Get District names & ids.
     *
     * @return array List of Distrcits as key(id) value(name) array.
     */
    public static function getDistrictListWithKeyValuePair($districtId = null)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";
        $districts = DB::table("districts")
                    ->where('is_active', 1);
        if(!empty($districtId)){
            $districts = $districts->where('id', $districtId );
        }

        return $districts->orderBy("$name", 'ASC')
            ->pluck($name, 'id');
    }

    public static function getDistrictListByDivisionId($divisionId = null)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";
        $districts = DB::table("districts")
                    ->where('is_active', 1);
        if(!empty($divisionId)){
            $districts = $districts->where('division_id', $divisionId );
        }

        return $districts->orderBy("$name", 'ASC')
            ->pluck($name, 'id');
    }

    /**
     * Get District names & ids by Division.
     *
     * @param integer $division_id
     *
     * @return array List of Districts.
     */
    public function getListByDivisionId($division_id)
    {
        return DB::table($this->table)
                ->where('is_active', 1)
                ->where('division_id', $division_id)
                ->select('name_en', 'name_bn', 'id')
                ->get();
    }

    /**
     * Get District names & ids by $district_id.
     *
     * @param integer $district_id
     *
     * @return array List of Districts.
     */
    public function getDistrictNameId($district_id)
    {
        return DB::table($this->table)
            ->where('is_active', 1)
            ->where('id', $district_id)
            ->select('name_en', 'name_bn', 'id')
            ->get();
    }

    /**
     * Get District information by ID.
     *
     * @param integer $districtId District ID.
     *
     * @return object
     */
    public function getDistrictInfo($districtId)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $cacheKey = "district_front_{$districtId}";

        $district = Cache::get($cacheKey, function () use ($districtId, $name) {
            return DB::table($this->table)
                ->select(
                    '*',
                    "{$name} as name"
                )
                ->where('id', $districtId)
                ->where('is_active', 1)
                ->orderBy($name, 'ASC')
                ->first();
        });

        return $district;
    }

    /**
     * Get Districts by the Division.
     * Used in FrontEnd Dashboard.
     *
     * @param integer $divisionId
     * @return object
     */
    public function getDistrictsByDivisionId($divisionId)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        return DB::table($this->table)
            ->select(
                'id',
                "$name as name",
                'latitude',
                'longitude'
            )
            ->where('is_active', 1)
            ->where('division_id', $divisionId)
            ->orderBy($name, 'ASC')
            ->get();
    }
}
