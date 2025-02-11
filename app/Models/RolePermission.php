<?php

/**
 * Role Permission Model.
 * php version 7.1.3
 *
 * @category CMS/Admin
 * @package  LGSP3
 * @author   Mowshana Farhana <mowshana.farhana@technovista.com.bd>
 * @author   Mayeenul Islam <wz.islam@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;
use Cache;
use App\Models\Settings\Option;
use Illuminate\Support\Facades\App;
use Auth;

/**
 * Role Permission Model.
 * php version 7.1.3
 *
 * @category CMS/Admin
 * @package  LGSP3
 * @author   Mowshana Farhana <mowshana.farhana@technovista.com.bd>
 * @author   Mayeenul Islam <wz.islam@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class RolePermission extends Model
{
    protected $table = 'roles_permissions';

    protected $fillable = [
        'organization_id',
        'slug',
        'name',
        'name_bn',
        'permissions'
    ];

    public function scopeFilter($query) 
    {
        $user = Auth::user();
        if(!empty($user->organization_id)) {
            $query = $query->where ('organization_id', $user->organization_id);
        }
        return $query;
    }

    /**
     * Get User Roles Information.
     *
     * @param boolean $limit    Max data to be fetched. 'False' to fetch all.
     * @param boolean $paginate Whether to paginate or not.
     *
     * @return object            User Roles Object.
     * -----------------------------------------------------------------------
     */
    public static function getUserRolesInfo($limit = false, $paginate = false)
    {
        if ($limit < 1 || $limit > 100) {
            $limit = 10;
        }

        $userRoles = RolePermission::filter()
            ->select(
                'id',
                'slug',
                'name',
                'name_bn'
            )
            ->orderBy("name", 'asc')
            ->orderBy("name_bn", 'asc');

        if ($limit) {
            if ($paginate) {
                $userRoles = $userRoles->paginate($limit);
            } else {
                $userRoles = $userRoles->get($limit);
            }
        } else {
            $userRoles = $userRoles->get();
        }

        return $userRoles;
    }

    /**
     * Register Role Here.
     *
     * @return array Array of Registered Roles.
     * -----------------------------------------------------------------------
     */
    public static function roles()
    {
        $identityName = App::isLocale('en') ? 'name' : 'name_bn';

        $roles = array();
        $roles_data = self::getUserRolesInfo();

        foreach ($roles_data as $_role) {
            $roles[$_role->slug] = empty($_role->$identityName) ? $_role->name : $_role->$identityName;
        }

        return $roles;
    }

    /**
     * Get Capabilities By Role Information.
     *
     * @param array $roleKey Role Keys in an array.
     *
     * @return array Array  User Roles.
     * -----------------------------------------------------------------------
     */
    public static function getCapabilitiesByRole($roleKey)
    {
        // Cache time
        $cacheTime = 2592000; //seconds (60 seconds x 60 min x 24 hr x 30 = 30 days)

        $_combined_caps = array();
        $roleKeys = array_map('trim', $roleKey);
        foreach ($roleKeys as $roleKey) {
            $cacheKey = "user_role_{$roleKey}";

            $result = Cache::remember(
                $cacheKey,
                $cacheTime,
                function () use ($roleKey) {
                    return DB::table('roles_permissions')->select('permissions')->where('slug', $roleKey)->first();
                }
            );

            $_user_caps = Option::maybeUnserialize($result->permissions);

            $_combined_caps = array_merge($_combined_caps, $_user_caps);
        }

        return array_unique($_combined_caps); //remove duplicate caps from different roles
    }
}
