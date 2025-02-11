<?php

namespace App\Models\Settings;
use DB;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Switch_;

/**
 * Organization Model Class.
 *
 * @category Application
 * @package  NATP-2 (National Agricultural Technology Program- Phase II)
 * @author   Ariful Islam Srabon<arif.cse18604@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd
 */
class OrganizationModel extends Model
{
    protected $table = "organizations";

    protected $fillable = [
        'id',
        'name_en',
        'name_bn',
        'short_name',
        'code',
        'address',
        'phone',
        'fax',
        'email',
        'web_address',
        'comment',
        'logo',
        'banner',
        'is_active',
        'sort_order',

        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;



    /**
     * Get Organizations List.
     *
     * @param array $args Array of arguments.
     *
     * @return object Object of fetch organizations otherwise null.
     * --------------------------------------------------
     */
    public static function getOrganizationsList($args = array())
    {
        $defaults = array(
            'exclude'           => array(),
            'organization_name' => null,
            'organization_code' => null,
            'author'            => null, // int|array
            'is_active'         => null,
            'order'             => array(
                'organizations.id'      => 'desc',
                'organizations.name_en' => 'asc',
                'organizations.name_bn' => 'asc',
            ),
            'items_per_page' => -1,
            'paginate'       => false, // ignored, if 'items_per_page' = -1
        );

        $arguments = parseArguments($args, $defaults);

        $organizations = DB::table('organizations');

        $organizations = $organizations->select('organizations.*');

        if (!empty($arguments['exclude'])) {
            $organizations = $organizations->whereNotIn('organizations.id', $arguments['exclude']);
        }

        if (!empty($arguments['organization_name'])) {
            $search_name = $arguments['organization_name'];

            $organizations = $organizations->where(
                function ($organizations) use ($search_name) {
                    $organizations->where('organizations.name_en', 'LIKE', '%' . $search_name . '%')
                        ->orWhere('organizations.name_bn', 'LIKE', '%' . $search_name . '%')
                        ->orWhere('organizations.short_name', 'LIKE', '%' . $search_name . '%');
                }
            );
        }


        if (!empty($arguments['organization_code'])) {
            $organizations = $organizations->where('organizations.code', $arguments['organization_code']);
        }


        if (!empty($arguments['is_active'])) {
            if($arguments['is_active'] == 'active'){
                $organizations = $organizations->where('organizations.is_active', 1);
            }else{
                $organizations = $organizations->where('organizations.is_active', 0);
            }

        }

        if (!empty($arguments['author'])) {
            if (is_array($arguments['author'])) {
                $organizations = $organizations->whereIn('organizations.created_by', $arguments['author']);
            } else {
                $organizations = $organizations->where('organizations.created_by', $arguments['author']);
            }
        }


        foreach ($arguments['order'] as $orderBy => $order) {
            $organizations = $organizations->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $organizations = $organizations->get();
        } else {
            if (true == $arguments['paginate']) {
                $organizations = $organizations->paginate(intval($arguments['items_per_page']));
            } else {
                $organizations = $organizations->take(intval($arguments['items_per_page']));
                $organizations = $organizations->get();
            }
        }

        return $organizations;
    }

    public static function getOrganizationList()
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";
        $organization =  OrganizationModel::query();
        if ( auth()->user()->user_level !== 'super_admin' && auth()->user()->user_level !== 'pmu' ) {
            $organization = $organization->whereId(auth()->user()->organization_id);
        }
        return $organization->selectRaw("CONCAT($name, ' (', code, ')') AS name, id")->pluck('name', 'id');
    }

    public static function getOrganizationIdByCode($code)
    {
        $id = 0;
        switch ($code) {
            case 'BARC':
                $id = config('app.organization_id_barc');
              break;
            case 'DAE':
                $id = config('app.organization_id_dae');
              break;
            case 'DOF':
                $id = config('app.organization_id_dof');
              break;
              case 'DLS':
                $id = config('app.organization_id_dls');
              break;
              case 'PMU':
                $id = config('app.organization_id_pmu');
              break;
          }

          return $id;
    }
}
