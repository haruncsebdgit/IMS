<?php
/**
 * Thana Upazila Model.
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
 * Thana Upazila Model Class.
 * php version 7.1.3
 *
 * @category Application
 * @package  LGSP3
 * @author   Ariful Islam Srabon <arif.cse18604@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class ThanaUpazila extends Model
{
    protected $table = 'thana_upazilas';

    protected $fillable = [
        'district_id',
        'type',
        'name_en',
        'name_bn',
        'url',
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
     * Get All list of Thana Upazila.
     *
     * @param array $args Array of arguments.
     *
     * @return object.
     */
    public static function getThanaUpazilas($args = array())
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $defaults = array(
            'exclude'        => array(),
            'name'           => null, // int|array
            'geo_code'       => null, // int|array
            'is_active'      => null, // int|array
            'district_id'    => null, // int|array
            'status'         => 'all',
            'order'          => array(
                'thana_upazilas.id'    => 'desc',
                "thana_upazilas.$name" => 'asc'
            ),
            'items_per_page' => -1,
            'paginate'       => false, // ignored, if 'items_per_page' = -1
        );

        $arguments = parseArguments($args, $defaults);

        $thana_upazilas = DB::table('thana_upazilas');

        $thana_upazilas = $thana_upazilas->select(
            'thana_upazilas.*',
            'districts.name_en AS district_name_en',
            'districts.name_bn AS district_name_bn'
        );

        $thana_upazilas = $thana_upazilas->leftJoin('districts', 'districts.id', '=', 'thana_upazilas.district_id');

        if (!empty($arguments['exclude'])) {
            $thana_upazilas = $thana_upazilas->whereNotIn('thana_upazilas.id', $arguments['exclude']);
        }
        if (!empty($arguments['district_id'])) {
            $thana_upazilas = $thana_upazilas->where('thana_upazilas.district_id', $arguments['district_id']);
        }

        if (!empty($arguments['is_active'])) {
            if ('active' === $arguments['is_active']) {
                $thana_upazilas = $thana_upazilas->where('thana_upazilas.is_active', 1);
            } elseif ('inactive' === $arguments['is_active']) {
                $thana_upazilas = $thana_upazilas->where('thana_upazilas.is_active', 0);
            }
        }

        if (!empty($arguments['name'])) {
            $search_name    = $arguments['name'];
            $thana_upazilas = $thana_upazilas->where(
                function ($thana_upazilas) use ($search_name) {
                    $thana_upazilas->where('thana_upazilas.name_en', 'LIKE', '%' . $search_name . '%');
                    $thana_upazilas->orWhere('thana_upazilas.name_bn', 'LIKE', '%' . $search_name . '%');
                }
            );
        }

        if (!empty($arguments['geo_code'])) {
            $thana_upazilas = $thana_upazilas->where('thana_upazilas.geo_code', $arguments['geo_code']);
        }

        foreach ($arguments['order'] as $orderBy => $order) {
            $thana_upazilas = $thana_upazilas->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $thana_upazilas = $thana_upazilas->get();
        } else {
            if (true == $arguments['paginate']) {
                $thana_upazilas = $thana_upazilas->paginate(intval($arguments['items_per_page']));
            } else {
                $thana_upazilas = $thana_upazilas->take(intval($arguments['items_per_page']));
                $thana_upazilas = $thana_upazilas->get();
            }
        }

        return $thana_upazilas;
    }

    /**
     * Get Thana Upazila names & ids.
     *
     * @return array List of Thana Upazilas.
     */
    public function getAllThanaUpazilas()
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $thanaUpazila = DB::table($this->table)
            ->select('name_en', 'name_bn', 'id')
            ->where('is_active', 1)
            ->orderBy("$name", 'ASC')
            ->get();

        return $thanaUpazila;
    }

    /**
     * Get Thana names & ids.
     *
     * @return array List of Thana as key(id) value(name) array.
     */
    public static function getThanaUpazillaListWithKeyValuePair($thanaUpazilaId = null)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";
        $thanaUpz = DB::table("thana_upazilas")
                        ->where('is_active', 1);
        if(!empty($thanaUpazilaId)){
            $thanaUpz = $thanaUpz->where('id', $thanaUpazilaId);
        }
        return $thanaUpz->orderBy("$name", 'ASC')
                    ->pluck($name, 'id');
    }

    public static function getDistrictWIseThanaUpazillaListWithKeyValuePair($districtId = null)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";
        $thanaUpz = DB::table("thana_upazilas")
                        ->where('is_active', 1);
        if(!empty($districtId)){
            $thanaUpz = $thanaUpz->where('district_id', $districtId);
        }
        return $thanaUpz->orderBy("$name", 'ASC')
                    ->pluck($name, 'id');
    }

    /**
     * Get District names & ids with District ID.
     *
     * @param integer $district_id District ID.
     *
     * @return array List of Thana Upazilas.
     */
    public function getListByDistrictId($district_id)
    {
        return DB::table($this->table)
                ->where('is_active', 1)
                ->where('district_id', $district_id)
                ->select('name_en', 'name_bn', 'id')
                ->get();
    }

    /**
     * Get Upazila Name By Division ID.
     *
     * @param integer $division_id Division ID.
     *
     * @return array List of Upazilas.
     */
    public function getUpazilaNameByDivisionId($division_id = null)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $upazilaList = DB::table('thana_upazilas');
        $upazilaList = $upazilaList->select('thana_upazilas.name_en', 'thana_upazilas.name_bn', 'thana_upazilas.id');
        $upazilaList = $upazilaList->leftJoin('districts', 'districts.id', '=', 'thana_upazilas.district_id');
        $upazilaList = $upazilaList->where('thana_upazilas.is_active', 1);

        if (!empty($division_id)) {
            $upazilaList = $upazilaList->where('districts.division_id', $division_id);
        }

        $upazilaList = $upazilaList->orderBy("thana_upazilas.$name", 'asc');
        $upazilaList = $upazilaList->get();

        return $upazilaList;
    }

    /**
     * Get Upazila information by ID.
     *
     * @param integer $upazilaId Upazila ID.
     *
     * @return object
     */
    public function getUpazilaInfo($upazilaId)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $cacheKey = "upazila_front_{$upazilaId}";

        $upazila = Cache::get($cacheKey, function () use ($upazilaId, $name) {
            return DB::table($this->table)
                ->select(
                    '*',
                    "{$name} as name"
                )
                ->where('id', $upazilaId)
                ->where('is_active', 1)
                ->orderBy($name, 'ASC')
                ->first();
        });

        return $upazila;
    }

    /**
     * Get Upazilas by the District.
     * Used in FrontEnd Dashboard.
     *
     * @param integer $districtId
     * @return object
     */
    public function getUpazilasByDistrictId($districtId)
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
            ->where('district_id', $districtId)
            ->orderBy($name, 'ASC')
            ->get();
    }
}
