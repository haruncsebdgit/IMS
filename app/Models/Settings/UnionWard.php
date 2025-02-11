<?php
/**
 * Union Ward Model.
 * php version 7.2.30
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
 * Union Ward Model Class.
 * php version 7.2.30
 *
 * @category Application
 * @package  LGSP3
 * @author   Ariful Islam Srabon <arif.cse18604@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class UnionWard extends Model
{
    protected $table = 'union_wards';

    protected $fillable = [
        'thana_upazila_id',
        'type',
        'city_corp_municipality_id',
        'name_en',
        'name_bn',
        'geo_code',
        'latitude',
        'longitude',
        'is_active',
        'male_voter',
        'female_voter',
        'area_in_acr',
        'population',

        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the comments for the blog post.
     */
    public function draftSchemes()
    {
        return $this->hasMany('App\Models\Scheme\BgccMeeting', 'union_id');
    }

    /**
     * Get All list of Union/Ward.
     *
     * @param array $args Array of arguments.
     *
     * @return object.
     * --------------------------------------------------
     */
    public static function getUnionWardLists($args = array())
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $defaults = array(
            'exclude'          => array(),
            'name'             => '',
            'geo_code'         => '',
            'is_active'        => '',
            'thana_upazila_id' => null, // int|array
            'order'            => array(
                'union_wards.id'      => 'desc',
                'union_wards.name_en' => 'asc'
            ),
            'items_per_page'   => -1,
            'paginate'         => false, // ignored, if 'items_per_page' = -1
        );

        $arguments = parseArguments($args, $defaults);

        $unionwardLists = DB::table('union_wards');

        $unionwardLists = $unionwardLists->select(
            "union_wards.*",
            "thana_upazilas.$name AS thana_upazila_name",
            "thana_upazilas.name_en AS thana_upazila"
        );

        $unionwardLists = $unionwardLists->leftJoin('thana_upazilas', 'thana_upazilas.id', '=', 'union_wards.thana_upazila_id');

        if (!empty($arguments['exclude'])) {
            $unionwardLists = $unionwardLists->whereNotIn('union_wards.id', $arguments['exclude']);
        }
        if (!empty($arguments['thana_upazila_id'])) {
            $unionwardLists = $unionwardLists->where('union_wards.thana_upazila_id', $arguments['thana_upazila_id']);
        }

        if (!empty($arguments['is_active'])) {
            if ($arguments['is_active'] === "active") {
                $unionwardLists = $unionwardLists->where('union_wards.is_active', 1);
            } elseif ($arguments['is_active'] === "inactive") {
                $unionwardLists = $unionwardLists->where('union_wards.is_active', 0);
            }
        }

        if (!empty($arguments['name'])) {
            $search_name = $arguments['name'];
            $unionwardLists = $unionwardLists->where(
                function ($unionwardLists) use ($search_name) {
                    $unionwardLists->where('union_wards.name_en', 'LIKE', '%' . $search_name . '%');
                    $unionwardLists->orWhere('union_wards.name_bn', 'LIKE', '%' . $search_name . '%');
                }
            );
        }

        if (!empty($arguments['geo_code'])) {
            $unionwardLists = $unionwardLists->where('union_wards.geo_code', $arguments['geo_code']);
        }

        foreach ($arguments['order'] as $orderBy => $order) {
            $unionwardLists = $unionwardLists->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $unionwardLists = $unionwardLists->get();
        } else {
            if (true == $arguments['paginate']) {
                $unionwardLists = $unionwardLists->paginate(intval($arguments['items_per_page']));
            } else {
                $unionwardLists = $unionwardLists->take(intval($arguments['items_per_page']));
                $unionwardLists = $unionwardLists->get();
            }
        }

        return $unionwardLists;
    }

    /**
     * Get Union/Ward Name & ID by calling getUnionWard() function
     * @return array() list
     *
     */
    public function getUnionWard()
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $unionWardList = DB::table($this->table)
            ->select('name_en', 'name_bn', 'id')
            ->where('is_active', 1)
            ->orderBy("$name", 'ASC')
            ->get();

        return $unionWardList;
    }

    /**
     * Get Union names & ids.
     *
     * @return array List of Union as key(id) value(name) array.
     */
    public static function getUnionWithKeyValuePair($unionId = null)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";
        $unions = DB::table("union_wards")
                    ->where('is_active', 1);
        if(!empty($unionId)){
            $unions = $unions->where('id', $unionId);
        }
        return $unions->orderBy("$name", 'ASC')
            ->pluck($name, 'id');

    }

    /**
     * Get Union names & ids.
     *
     * @return array List of Union as key(id) value(name) array.
     */
    public static function getUnionListByUpazilaId($upazila = null)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";
        $unions = DB::table("union_wards")
                    ->where('is_active', 1);
        if(!empty($upazila)){
            $unions = $unions->where('thana_upazila_id', $upazila);
        }
        return $unions->orderBy("$name", 'ASC')
            ->pluck($name, 'id');

    }

    /**
     * Get Union/Ward List by calling getUnionWardId() function
     *
     * @param int $thana_upazila_id
     *
     * @return array() list
     *
     */
    public function getListByUnionWardId($thana_upazila_id)
    {
        return DB::table($this->table)
            ->where('is_active', 1)
            ->where('thana_upazila_id', $thana_upazila_id)
            ->select('name_en', 'name_bn', 'id')
            ->get();
    }


    /**
     * Get Union/Ward List by calling getUnionWardListByDistrictId() function
     *
     * @param int $district_id
     *
     * @return array() list
     *
     */
    public function getUnionWardListByDistrictId($district_id)
    {
        return DB::table("union_wards")
            ->leftJoin('thana_upazilas', 'thana_upazilas.id', '=', 'union_wards.thana_upazila_id')
            ->where('union_wards.is_active', 1)
            ->where('thana_upazilas.district_id', $district_id)
            ->select('union_wards.name_en', 'union_wards.name_bn', 'union_wards.id')
            ->get();
    }


     /**
     * Get Union Name By Division ID.
     *
     * @param integer $division_id Division ID.
     *
     * @return array List of Unions.
     */
    public function getUnionNameByDivisionId($division_id = null)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $unionList = DB::table('union_wards');
        $unionList = $unionList->select('union_wards.name_en', 'union_wards.name_bn', 'union_wards.id');
        $unionList = $unionList->leftJoin('thana_upazilas', 'thana_upazilas.id', '=', 'union_wards.thana_upazila_id');
        $unionList = $unionList->leftJoin('districts', 'districts.id', '=', 'thana_upazilas.district_id');
        $unionList = $unionList->where('union_wards.is_active', 1);

        if (!empty($division_id)) {
            $unionList = $unionList->where('districts.division_id', $division_id);
        }

        $unionList = $unionList->orderBy("union_wards.$name", 'asc');
        $unionList = $unionList->get();

        return $unionList;
    }

    /**
     * Get Union information by ID.
     *
     * @param integer $unionId Union ID.
     *
     * @return object
     */
    public function getUnionInfo($unionId)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $cacheKey = "union_front_{$unionId}";

        $union = Cache::get($cacheKey, function () use ($unionId, $name) {
            return DB::table($this->table)
                ->select(
                    '*',
                    "{$name} as name"
                )
                ->where('id', $unionId)
                ->where('is_active', 1)
                ->orderBy($name, 'ASC')
                ->first();
        });

        return $union;
    }

    /**
     * Get Unions by the Upazila.
     * Used in FrontEnd Dashboard.
     *
     * @param integer $upazilaId
     * @return object
     */
    public function getUnionsByUpazilaId($upazilaId)
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
            ->where('thana_upazila_id', $upazilaId)
            ->orderBy($name, 'ASC')
            ->get();
    }
}
