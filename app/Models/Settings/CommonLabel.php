<?php

/**
 * Common Label Model.
 * php version 7.1.3
 *
 * @category Application/Admin
 * @package  LGSP3
 * @author   Mowshana Farhana <mowshana.farhana@technovista.com.bd>
 * @author   Mayeenul Islam <wz.islam@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */

namespace App\Models\Settings;

use DB;
use Cache;
use Illuminate\Database\Eloquent\Model;

/**
 * Common Label Model Class.
 * php version 7.1.3
 *
 * @category Application/Admin
 * @package  LGSP3
 * @author   Mowshana Farhana <mowshana.farhana@technovista.com.bd>
 * @author   Mayeenul Islam <wz.islam@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class CommonLabel extends Model
{
    protected $table = 'common_labels';

    protected $fillable = [
        'data_type',
        'name_en',
        'name_bn',
        'is_delatable',
        'organization_id',
        'order',
        'status',
        'code',

        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    /**
     * Get Common Labels.
     *
     * @param array $args Array of arguments.
     *
     * @return object Object of fetch common labels otherwise null.
     */
    public static function getCommonLabels($args = array())
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $defaults = array(
            'exclude'        => array(),
            'data_type'      => '',
            'author'         => null, // int|array
            'name'           => '',
            'status'         => '',
            'order'          => array(
                'common_labels.id'    => 'desc',
                "common_labels.$name" => 'asc'
            ),
            'items_per_page' => -1,
            'paginate'       => false, // ignored, if 'items_per_page' = -1
        );

        $arguments = parseArguments($args, $defaults);

        $commonLabels = DB::table('common_labels');
        $commonLabels = $commonLabels->select(
            'common_labels.*',
        );

        if (!empty($arguments['exclude'])) {
            $commonLabels = $commonLabels->whereNotIn('common_labels.id', $arguments['exclude']);
        }

        if ($arguments['data_type']) {
            if (is_array($arguments['data_type'])) {
                $commonLabels = $commonLabels->whereIn('common_labels.data_type', $arguments['data_type']);
            } else {
                $commonLabels = $commonLabels->where('common_labels.data_type', $arguments['data_type']);
            }
        }

        if (!empty($arguments['author'])) {
            if (is_array($arguments['author'])) {
                $commonLabels = $commonLabels->whereIn('common_labels.created_by', $arguments['author']);
            } else {
                $commonLabels = $commonLabels->where('common_labels.created_by', $arguments['author']);
            }
        }

        if (!empty($arguments['name'])) {
            $search_name  = $arguments['name'];
            $commonLabels = $commonLabels->where(function ($commonLabels) use ($search_name) {
                $commonLabels->where('common_labels.name_en', 'LIKE', '%' . $search_name . '%');
                $commonLabels->orWhere('common_labels.name_bn', 'LIKE', '%' . $search_name . '%');
            });
        }

        if ($arguments['status']) {
            if (is_array($arguments['status'])) {
                $commonLabels = $commonLabels->whereIn('common_labels.status', $arguments['status']);
            } else {
                $commonLabels = $commonLabels->where('common_labels.status', $arguments['status']);
            }
        }

        foreach ($arguments['order'] as $orderBy => $order) {
            $commonLabels = $commonLabels->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $commonLabels = $commonLabels->get();
        } else {
            if (true == $arguments['paginate']) {
                $commonLabels = $commonLabels->paginate(intval($arguments['items_per_page']));
            } else {
                $commonLabels = $commonLabels->take(intval($arguments['items_per_page']));
                $commonLabels = $commonLabels->get();
            }
        }

        return $commonLabels;
    }

    /**
     * Get Common Labels for use.
     *
     * @param string $data_type Data Type.
     *
     * @return object Common Labels Data.
     */
    public static function getCL($data_type)
    {
        $cache_key  = "common_label_{$data_type}_" . auth()->user()->organization_id;
        $cache_time = 60 * 24 * 30; //30 days in minutes = minutes x hours x days

        $values = Cache::remember(
            $cache_key,
            $cache_time,
            function () use ($data_type) {
                return DB::table('common_labels')
                    ->select(
                        'id',
                        "name_en",
                        "name_bn"
                    )
                    ->where('data_type', $data_type)
                    ->where('status', '1')
                    ->where(function ($query){
                        $query->where('organization_id', auth()->user()->organization_id)
                            ->orWhereNull('organization_id');
                    })
                    ->orderBy('order', 'asc')
                    ->orderBy('name_en', 'asc')
                    ->get();
            }
        );

        return $values;
    }
    /**
     * Get Common Labels with key value pair array(Ex. ['key'=>'value']) for use.
     *
     * @param string $data_type Data Type.
     *
     * @return object Common Labels Data.
     */
    public static function getCLWithKeyValue($data_type)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";
        $cache_key  = "common_label_key_value_{$data_type}_" . auth()->user()->organization_id;
        $cache_time = 60 * 24 * 30; //30 days in minutes = minutes x hours x days

        $values = Cache::remember(
            $cache_key,
            $cache_time,
            function () use ($data_type, $name) {
                return DB::table('common_labels')
                    ->where('data_type', $data_type)
                    ->where('status', '1')
                    ->where(function ($query){
                        $query->where('organization_id', auth()->user()->organization_id)
                            ->orWhereNull('organization_id');
                    })
                    ->orderBy('order', 'asc')
                    ->orderBy('name_en', 'asc')
                    ->pluck($name, 'id');
            }
        );

        return $values;
    }
}
