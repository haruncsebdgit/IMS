<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * Users Group Model Class.
 *
 * @category CMS
 * @package  Vista_CMS
 * @author   Mayeenul Islam <wz.islam@gmail.com>
 * @author   Mowshana Farhana <mowshana.farhana@technovista.com.bd>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class UsersGroup extends Model
{
    protected $table = 'users_group';

    protected $fillable = [
        'title',
        'title_bn',
        'remarks',

        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    /**
     * Get Users Group.
     *
     * @param array $args Array of arguments.
     *
     * @return object Object of fetch users group otherwise null.
     * --------------------------------------------------
     */
    public static function getUsersGroupList($args = array())
    {
        $defaults = array(
            'exclude'        => array(),
            'title'          => null,
            'user_id'        => null, // int|array
            'author'         => null, // int|array
            'order'          => array(
                'users_group.id'    => 'desc',
                'users_group.title' => 'asc'
            ),
            'items_per_page' => -1,
            'paginate'       => false, // ignored, if 'items_per_page' = -1
        );

        $arguments = parseArguments($args, $defaults);

        $groupUsers = DB::table('users_group');

        $groupUsers = $groupUsers->select(
            'users_group.*'
        );

        if (!empty($arguments['exclude'])) {
            $groupUsers = $groupUsers->whereNotIn('users_group.id', $arguments['exclude']);
        }

        if (!empty($arguments['title'])) {
            $search_query = $arguments['title'];

            $groupUsers = $groupUsers->where(
                function ($groupUsers) use ($search_query) {
                    $groupUsers->where('users_group.title', 'LIKE', "%$search_query%");
                    $groupUsers->orWhere('users_group.title_bn', 'LIKE', "%$search_query%");
                }
            );
        }

        if (!empty($arguments['user_id'])) {
            $groupUsers = $groupUsers->leftjoin('users_group_users', 'users_group.id', '=', 'users_group_users.user_group_id');

            if (is_array($arguments['user_id'])) {
                $groupUsers = $groupUsers->whereIn('users_group_users.user_id', $arguments['user_id']);
            } else {
                $groupUsers = $groupUsers->where('users_group_users.user_id', $arguments['user_id']);
            }
            $groupUsers = $groupUsers->groupBy('users_group.id');
        }

        if (!empty($arguments['author'])) {
            if (is_array($arguments['author'])) {
                $groupUsers = $groupUsers->whereIn('users_group.created_by', $arguments['author']);
            } else {
                $groupUsers = $groupUsers->where('users_group.created_by', $arguments['author']);
            }
        }

        foreach ($arguments['order'] as $orderBy => $order) {
            $groupUsers = $groupUsers->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $groupUsers = $groupUsers->get();
        } else {
            if (true == $arguments['paginate']) {
                $groupUsers = $groupUsers->paginate(intval($arguments['items_per_page']));
            } else {
                $groupUsers = $groupUsers->take(intval($arguments['items_per_page']));
                $groupUsers = $groupUsers->get();
            }
        }

        return $groupUsers;
    }

    /**
     * Localize Users Group.
     *
     * An interim method to localize user group where applicable.
     *
     * @param Object $userGroups Users Group object.
     *
     * @return Object mixed
     * --------------------------------------------------
     */
    public static function localizeUsersGroup($userGroups)
    {
        if (config('app.locale') !== config('app.fallback_locale')) {

            $app_locale = config('app.locale');

            $column_title = "title_{$app_locale}";

            $title = $userGroups->$column_title;

            //Check and set overwrite value
            $userGroups->title = empty($title) ? $userGroups->title : $title;
        }

        return $userGroups;
    }

    /**
     * Get Users Group Author Information.
     *
     * @param integer $user_id Users Group author id.
     *
     * @return object          Users Group author object.
     * --------------------------------------------------
     */
    public function getUsersGroupAuthor($user_id)
    {
        $user_id = intval($user_id);

        return DB::table('users')->where('id', $user_id)->first();
    }

    /**
     * Get User Information.
     *
     * @param int $user_group_id Users Group ID of the users group User.
     *
     * @return array          Return the attachment terms details.
     * --------------------------------------------------
     */
    public static function getUserInfo($user_group_id)
    {
        $usersGroupId = abs(intval($user_group_id));

        if (empty($usersGroupId)) {
            return false;
        }

        $userData = DB::table('users_group_users')
            ->select('users.*')
            ->leftjoin('users', 'users_group_users.user_id', '=', 'users.id')
            ->where('users_group_users.user_group_id', $usersGroupId)
            ->get();

        $userInfo = array();

        foreach ($userData as $key => $value) {

            $userInfo[$value->id] = array(
                'user_id' => $value->id,
                'name_en' => $value->name_en,
            );
        }

        return $userInfo;
    }

    /**
     * Save User Information.
     *
     * @param int   $user_group_id Users Group ID of the users group User.
     * @param array $user_id       User ID of the users group User.
     *
     * @return boolean
     * --------------------------------------------------
     */
    public static function addUserInfo($user_group_id, $user_id)
    {
        $usersGroupId = abs(intval($user_group_id));

        if (empty($usersGroupId) && empty($user_id)) {
            return false;
        }

        $buildUpArray = array();

        if (is_array($user_id)) {
            foreach ($user_id as $value) {
                $buildUpArray[] = [
                    'user_group_id' => $usersGroupId,
                    'user_id'       => (int)$value
                ];
            }
        } else {
            $buildUpArray = [
                'user_group_id' => $usersGroupId,
                'user_id'       => (int)$user_id
            ];
        }

        $result = DB::table('users_group_users')->insert($buildUpArray);

        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * Delete User Information.
     *
     * @param int   $user_group_id Users Group ID of the users group User.
     * @param array $user_id       User ID of the users group User.
     *
     * @return boolean
     * --------------------------------------------------
     */
    public static function deleteUserInfo($user_group_id, $user_id = null)
    {
        $usersGroupId = abs(intval($user_group_id));

        if (empty($usersGroupId)) {
            return false;
        }

        $result = DB::table('users_group_users')
            ->where('user_group_id', $usersGroupId);

        if (null !== $user_id) {
            $result = $result->where('user_id', (int)$user_id);
        }

        $result = $result->delete();

        if (!$result) {
            return false;
        }

        return $result;
    }
}
