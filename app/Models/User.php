<?php

namespace App\Models;

use DB;
use Auth;
use Cache;
use App\Models\RolePermission;
use App\Models\Settings\Option;
use App\Models\Settings\Organogram;
use App\Models\Settings\CommonLabel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_en',
        'name_bn',
        'email',
        'address',
        'username',
        'password',
        'phone',
        'blood_group',
        'designation_id',
        'location_id',
        'user_level',
        'user_image',
        'is_active',
        'employee_id',
        'user_type'
    ];

    /**
     * The offices/organogram that belong to the user.
     */
    public function organograms()
    {
        return $this->belongsToMany(Organogram::class, 'organogram_user', 'user_id', 'organogram_id');
    }

     /**
     * The projects that belong to the user.
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user', 'user_id', 'project_id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function isOnline()
    {
        //dd(Cache::has('user-is-online-'. 4887));
        return Cache::has('user-is-online-'. $this->id);
    }
    public function location()
    {
        return $this->belongsTo(CommonLabel::class, 'location_id');
    }

    public function scopeFilter($query, array $filters)
    {

        if (!empty($filters['exclude'])) {
            $query = $query->whereNotIn('users.id', $filters['exclude']);
        }

        if (!empty($filters['name'])) {
            $search_name = $filters['name'];
            $query       = $query->where(
                function ($query) use ($search_name) {
                    $query->where('users.name_en', 'LIKE', '%' . $search_name . '%');
                    $query->orWhere('users.name_bn', 'LIKE', '%' . $search_name . '%');
                }
            );
        }

        if (!empty($filters['email']) && filter_var($filters['email'], FILTER_VALIDATE_EMAIL)) {
            $query = $query->where('users.email', $filters['email']);
        }

        if (!empty($filters['role'])) {
            // Known Caveat: Role is stored in serialized value, not ideal for searching.
            $query = $query->leftjoin('user_meta', 'users.id', '=', 'user_meta.user_id')
                ->where('user_meta.meta_key', '_role')
                ->where('user_meta.meta_value', 'LIKE', '%' . $filters['role'] . '%');
        }

        if (!empty($filters['username'])) {
            $query = $query->where('users.username', $filters['username']);
        }

        return $query;
    }


    /**
     * Get Users.
     *
     * @param array $args Array of arguments.
     *
     * @return object     Object of fetch users otherwise null.
     * --------------------------------------------------
     */
    public static function getUsers($args = array())
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $defaults = array(
            'exclude'          => array(),
            'order'            => array(
                'users.id'    => 'desc',
                "users.$name" => 'asc'
            ),
            'items_per_page'   => -1,
            'paginate'         => false, // ignored, if 'items_per_page' = -1
            'name'             => '',
            'email'            => '',
            'role'             => '',
            'username'         => ''
        );

        $arguments = parseArguments($args, $defaults);

        $users = User::query();

        $users = $users->select('users.*');
        $users = $users->filter($arguments);

        foreach ($arguments['order'] as $orderBy => $order) {
            $users = $users->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $users = $users->get();
        } else {
            if (true == $arguments['paginate']) {
                $users = $users->paginate(intval($arguments['items_per_page']));
            } else {
                $users = $users->take(intval($arguments['items_per_page']));
                $users = $users->get();
            }
        }

        return $users;
    }

    /**
     * Get Users Capabilities.
     *
     * @param int $user_id User ID.
     *
     * @return array
     * --------------------------------------------------
     */
    public static function getUserCaps($user_id)
    {
        if (empty($user_id)) {
            return false;
        }

        $get_user_caps = getUserMeta($user_id, '_capabilities');

        if (!empty($get_user_caps)) {
            return $get_user_caps;
        }

        $get_user_role = getUserMeta($user_id, '_role');

        if (empty($get_user_role)) {
            return false;
        }

        $get_role_caps = RolePermission::getCapabilitiesByRole($get_user_role);

        if (empty($get_role_caps)) {
            return false;
        }

        return $get_role_caps;
    }

    /**
     * Get Current Users Capabilities.
     *
     * @return self::getUserCaps()
     * --------------------------------------------------
     */
    public static function getCurrentUserCaps()
    {
        return self::getUserCaps(Auth::id());
    }

    /**
     * Get Users Role.
     *
     * @param int $user_id User ID.
     *
     * @return array
     * --------------------------------------------------
     */
    public static function getUserRole($user_id)
    {
        if (empty($user_id)) {
            return false;
        }

        $user_role = getUserMeta($user_id, '_role');

        if (empty($user_role)) {
            return false;
        }

        $availableRoles = RolePermission::roles();

        $result = [];

        if (count($user_role) > 0) {
            foreach ($user_role as $key => $value) {
                $result[$key]['role'] = $value;
                $result[$key]['label'] = $availableRoles[$value] ?? '';
            }
        }

        return $result;
    }

    /**
     * Get Current Users Role.
     *
     * @return self::getUserRole()
     * --------------------------------------------------
     */
    public static function getCurrentUserRole()
    {
        return self::getUserRole(Auth::id());
    }

    /**
     * Is Users Roles.
     *
     * @param array $role    Role key.
     * @param int   $user_id User ID.
     *
     * @return array
     * --------------------------------------------------
     */
    public static function isUserRole($role, $user_id = null)
    {
        $user_id = null === $user_id ? Auth::id() : $user_id;

        $get_user_role = self::getUserRole($user_id);

        if (empty($get_user_role)) {
            return false;
        }

        foreach ($get_user_role as $user_role) {
            // TODO VistaCMS needs to be updated.
            if ($role === $user_role['role']) {
                return true;
            }
        }

        return false;
    }

    /**
     * Has Users Capabilities.
     *
     * @param string|array $capability Capability.
     * @param int          $user_id    Default: null.
     * @param boolean      $strict     Whether to strictly match capability. Default: false.
     *
     * @return array
     * --------------------------------------------------
     */
    public static function hasUserCap($capability, $user_id = null, $strict = false)
    {
        $user_id = null === $user_id ? Auth::id() : $user_id;

        $get_user_caps = self::getUserCaps($user_id);

        if (false !== $get_user_caps) {
            if (is_array($capability)) {
                if ($strict) {
                    // Strict mode.
                    foreach ($capability as $cap) {
                        if (!in_array($cap, $get_user_caps)) {
                            return false;
                        }
                    }

                    return true;
                } else {
                    // General mode.
                    foreach ($capability as $cap) {
                        if (in_array($cap, $get_user_caps)) {
                            return true;
                        }
                    }

                    return false;
                }
            } else {
                if ($strict) {
                    // Strict mode. Match with all.
                    return !in_array($capability, $get_user_caps) ? false : true;
                } else {
                    // General mode.
                    return in_array($capability, $get_user_caps) ? true : false;
                }
            }
        }
    }

    /**
     * Get User Meta Information.
     *
     * @param int    $userId  User Id of the user meta.
     * @param string $metaKey Meta key of the user meta.
     *
     * @return array|string   Return the value
     * --------------------------------------------------
     */
    public static function getUserMeta($userId, $metaKey)
    {
        $user_id = abs(intval($userId));
        $meta_key = trim($metaKey);
        if (empty($user_id) && empty($meta_key)) {
            return false;
        }

        // Cache time
        $cacheTime = 2592000; //seconds (60 seconds x 60 min x 24 hr x 30 = 30 days)

        $cacheKey = "user_meta_{$user_id}_{$meta_key}";

        $result = Cache::remember(
            $cacheKey,
            $cacheTime,
            function () use ($user_id, $meta_key) {
                return DB::table('user_meta')
                    ->select('user_meta.meta_value')
                    ->where('user_meta.user_id', $user_id)
                    ->where('user_meta.meta_key', $meta_key)
                    ->first();
            }
        );

        if (is_object($result)) {
            $value = $result->meta_value;
        } else {
            $value = $result;
        }

        return Option::maybeUnserialize($value);
    }

    /**
     * Save User Meta Information.
     *
     * @param int          $userId    User Id of the user meta.
     * @param string       $metaKey   Meta key of the user meta.
     * @param array|string $metaValue Value want to save.
     *
     * @return boolean                True|False.
     * --------------------------------------------------
     */
    public static function addUserMeta($userId, $metaKey, $metaValue = '')
    {
        $user_id = abs(intval($userId));
        $meta_key = trim($metaKey);
        if (empty($user_id) && empty($meta_key)) {
            return false;
        }

        if (is_object($metaValue)) {
            $metaValue = clone $metaValue;
        }

        $meta_value = Option::maybeSerialize($metaValue);

        $result = DB::table('user_meta')->insert(
            [
                'user_id'    => $user_id,
                'meta_key'   => $meta_key,
                'meta_value' => $meta_value
            ]
        );

        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * Update User Meta Information.
     *
     * @param int          $userId    User Id of the user meta.
     * @param string       $metaKey   Meta key of the user meta.
     * @param array|string $metaValue Value want to save.
     *
     * @return boolean                True|False.
     * --------------------------------------------------
     */
    public static function updateUserMeta($userId, $metaKey, $metaValue = '')
    {
        $user_id = abs(intval($userId));
        $meta_key = trim($metaKey);
        if (empty($user_id) && empty($meta_key)) {
            return false;
        }

        if (is_object($metaValue)) {
            $metaValue = clone $metaValue;
        }

        $old_value = self::getUserMeta($user_id, $meta_key);

        // If the new and old values are the same, no need to update.
        if ($metaValue === $old_value) {
            return false;
        }

        $serialized_value = Option::maybeSerialize($metaValue);

        $result = DB::table('user_meta')
            ->where('user_id', $user_id)
            ->where('meta_key', $meta_key)
            ->update(
                [
                    'meta_value' => $serialized_value
                ]
            );

        if (!$result) {
            $added = self::addUserMeta($user_id, $meta_key, $metaValue);
        }

        if (!$result && !$added) {
            return false;
        }

        $cacheKey = "user_meta_{$user_id}_{$meta_key}";

        // Clear the specific cache.
        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        }

        return true;
    }

    /**
     * Delete User Meta Information.
     *
     * @param int    $userId  User Id of the user meta.
     * @param string $metaKey Meta key of the user meta.
     *
     * @return boolean        True|False.
     * -------------------------------------------------
     */
    public static function deleteUserMeta($userId, $metaKey)
    {
        $user_id = abs(intval($userId));
        $meta_key = trim($metaKey);
        if (empty($user_id) && empty($meta_key)) {
            return false;
        }

        $result = DB::table('user_meta')
            ->where('user_id', $user_id)
            ->where('meta_key', $meta_key)
            ->delete();

        $cacheKey = "user_meta_{$user_id}_{$meta_key}";

        // Clear the specific cache.
        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        }

        return $result;
    }

    /**
     * Get User Name by ID.
     *
     * @param $userId User ID.
     *
     * @return string User Name.
     * -----------------------------------------------------------------------
     */
    public function getUserNameById($userId)
    {
        $user_id = intval($userId);

        return DB::table('users')->where('id', $user_id)->value('name_en');
    }

    /**
     * Get User Information List
     *
     * @return string User Information.
     * -----------------------------------------------------------------------
     */
    public function getUserInformationList()
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $userList = DB::select(DB::raw("SELECT users.id AS user_id,
                                               users.designation_id AS designation_id,
                                               users.district_id AS district_id,
                                               users.upazila_id AS upazila_id,
                                               users.union_id AS union_id,

                                               users.$name AS user,
                                               users.name_en AS user_name,

                                               users.user_level AS user_level,

                                               desi.$name AS designation,
                                               desi.name_en AS desination_name,

                                               dist.$name AS district,
                                               dist.name_en AS district_name,

                                               thana.$name AS upazila,
                                               thana.name_en AS upazila_name,

                                               ward.$name AS ward,
                                               ward.name_en AS ward_name

                                        FROM users
                                        LEFT JOIN common_labels AS desi ON desi.id = users.designation_id
                                        LEFT JOIN districts AS dist ON dist.id = users.district_id
                                        LEFT JOIN thana_upazilas AS thana ON thana.id = users.upazila_id
                                        LEFT JOIN union_wards AS ward ON ward.id = users.union_id
                                        WHERE users.is_active = 1
                                        ORDER BY users.id ASC"));

        $user_array = [];

        foreach ($userList as $key => $value) {

            $userName        = empty($value->user) ? $value->user_name : $value->user;
            $designationName = empty($value->designation) ? $value->desination_name : $value->designation;
            $districtName    = empty($value->district) ? $value->district_name : $value->district;
            $upazilaName     = empty($value->upazila) ? $value->upazila_name : $value->upazila;
            $wardName        = empty($value->ward) ? $value->ward_name : $value->ward;

            if (!empty($value->union_id) && !empty($value->upazila_id) && !empty($value->district_id)) {
                $location = ' - ' . '(' . $wardName . ', ' . $upazilaName . ', ' . $districtName . ')';
            } else if (empty($value->union_id) && !empty($value->upazila_id) && !empty($value->district_id)) {
                $location = ' - ' . '(' . $upazilaName . ', ' . $districtName . ')';
            } else if (!empty($value->union_id) && empty($value->upazila_id) && !empty($value->district_id)) {
                $location = ' - ' . '(' . $wardName . ', ' . $districtName . ')';
            } else if (!empty($value->union_id) && !empty($value->upazila_id) && empty($value->district_id)) {
                $location = ' - ' . '(' . $wardName . ', ' . $upazilaName . ')';
            } else if (empty($value->union_id) && empty($value->upazila_id) && !empty($value->district_id)) {
                $location = ' - ' . '(' . $districtName . ')';
            } else if (empty($value->union_id) && !empty($value->upazila_id) && empty($value->district_id)) {
                $location = ' - ' . '(' . $upazilaName . ')';
            } else if (!empty($value->union_id) && empty($value->upazila_id) && empty($value->district_id)) {
                $location = ' - ' . '(' . $wardName . ')';
            } else {
                $location = '';
            }

            if (($value->user_level) == 'pmu') {
                $level = __('PMU Level (Country)');
            } else if (($value->user_level) == 'ddlg') {
                $level = __('DDLG Level (District)');
            } else if (($value->user_level) == 'df') {
                $level = __('DF Level (District)');
            } else if (($value->user_level) == 'ups') {
                $level = __('UPS Level (Union)');
            } else {
                $level = '';
            }

            if (!empty($value->designation_id) && !empty($value->user_level)) {
                $designation_user_level = !empty($level) ? ',' . ' (' . $designationName . '-' . $level . ') ' : '';
            } else if (!empty($value->designation_id) && empty($value->user_level)) {
                $designation_user_level = ',' . ' (' . $designationName . ') ';
            } else if (empty($value->designation_id) && !empty($value->user_level)) {
                $designation_user_level = !empty($level) ? ',' . ' (' . $level . ') ' : '';
            } else {
                $designation_user_level = '';
            }

            $user_array[$value->user_id] = $userName . $designation_user_level . $location;
        }

        return $user_array;
    }

    /**
     * Get User Name List
     *
     * @return string User Name.
     * -----------------------------------------------------------------------
     */
    public function getUserList()
    {
        return DB::table('users')
            ->select('name_en', 'name_bn', 'id')
            ->where('is_active', 1)
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * Get Support Agent Name List
     *
     * @return string Support Agent Name.
     * -----------------------------------------------------------------------
     */
    public function getSupportAgentList()
    {
        return DB::table('users')
            ->select('name_en', 'name_bn', 'id')
            ->where('is_active', '=', 1)
            ->where('user_level', '=', 'sa')
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * Get user list with concating designation
     */
    public static function getUserListWithDesignation($designationId = null)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $user = DB::table('users')
                ->selectRaw("
                    CASE WHEN users.designation_id IS NOT NULL
                         THEN CONCAT(users.$name, ' (', COALESCE(cl.$name, ' '), ') ')
                         ELSE users.$name END AS name,
                    users.id
                ")
                ->leftJoin('common_labels AS cl', 'users.designation_id', 'cl.id');

        if(!empty($designationId)){
            $user = $user->where('cl.id', $designationId);
        }

        return $user->pluck('name', 'id');
    }
}
