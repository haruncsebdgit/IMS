<?php
/**
 * Division Model.
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
 * Division Model Class.
 * php version 7.1.3
 *
 * @category Application
 * @package  LGSP3
 * @author   Ariful Islam Srabon <arif.cse18604@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class Division extends Model
{
    protected $table = 'divisions';

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
    public static function getDivisions($args = array())
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
                'divisions.id'    => 'desc',
                "divisions.$name" => 'asc',
            ),
            'items_per_page' => -1,
            'paginate'       => false, // ignored, if 'items_per_page' = -1
        );

        $arguments = parseArguments($args, $defaults);

        $divisions = DB::table('divisions');

        $divisions = $divisions->select('divisions.*');


        if (!empty($arguments['exclude'])) {
            $divisions = $divisions->whereNotIn('divisions.id', $arguments['exclude']);
        }

        if (!empty($arguments['is_active'])) {
            if ($arguments['is_active'] === 'active') {
                $divisions = $divisions->where('divisions.is_active', 1);
            } elseif ($arguments['is_active'] === 'inactive') {
                $divisions = $divisions->where('divisions.is_active', 0);
            }
        }

        if (!empty($arguments['name'])) {
            $search_name = $arguments['name'];
            $divisions = $divisions ->where(function($divisions) use ($search_name){
                $divisions->where('divisions.name_en', 'LIKE', '%'.$search_name.'%');
                $divisions->orWhere('divisions.name_bn', 'LIKE', '%'.$search_name.'%');
            });
        }

        if (!empty($arguments['geo_code'])) {
            $divisions = $divisions->where('divisions.geo_code', $arguments['geo_code']);
        }

        foreach ($arguments['order'] as $orderBy => $order) {
            $divisions = $divisions->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $divisions = $divisions->get();
        } else {
            if (true == $arguments['paginate']) {
                $divisions = $divisions->paginate(intval($arguments['items_per_page']));
            } else {
                $divisions = $divisions->take(intval($arguments['items_per_page']));
                $divisions = $divisions->get();
            }
        }

        return $divisions;
    }

    /**
     * Get Division names & ids.
     *
     * @return array List of Divisions.
     */
    public function getDivisionList()
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $divisions = DB::table($this->table)
            ->select('name_en', 'name_bn', 'id')
            ->where('is_active', 1)
            ->orderBy("$name", 'ASC')
            ->get();

        return $divisions;
    }

    /**
     * Get Division names & ids.
     *
     * @return array List of Divisions.
     */
    public static function getDivisionListArray($divisionId = null)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $divisions = DB::table('divisions')
            ->where('is_active', 1)
            ->orderBy("$name", 'ASC');

            if(!empty($divisionId)){
                $divisions = $divisions->whereId($divisionId);
            }

        return $divisions->pluck($name, 'id');
    }


    /**
     * Get Division names & ids.
     *
     * @return array List of Divisions.
     */
    public function getDivisionById($division_id)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $divisions = DB::table($this->table)
            ->select('name_en', 'name_bn', 'id')
            ->where('id', $division_id)
            ->where('is_active', 1)
            ->orderBy("$name", 'ASC')
            ->get();

        return $divisions;
    }

    /**
     * Get Division information by ID.
     *
     * @param integer $divisionId Division ID.
     *
     * @return object
     */
    public function getDivisionInfo($divisionId)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $cacheKey = "division_front_{$divisionId}";

        $division = Cache::get($cacheKey, function () use ($divisionId, $name) {
            return DB::table($this->table)
                ->select(
                    '*',
                    "{$name} as name"
                )
                ->where('id', $divisionId)
                ->where('is_active', 1)
                ->orderBy($name, 'ASC')
                ->first();
        });

        return $division;
    }

    /**
     * Get all the Divisions.
     * Used in FrontEnd Dashboard.
     *
     * @return object
     */
    public function getAllDivisions()
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
            ->orderBy($name, 'ASC')
            ->get();
    }

}
