<?php
/**
 * Shortcut Functions.
 *
 * Instantiation of Controllers for the application
 * will be managed here.
 *
 * php version 7.1.3
 *
 * @category CMS/Helpers
 * @package  LGSP3
 * @author   Mayeenul Islam <wz.islam@gmail.com>
 * @author   Mowshana Farhana <mowshana.farhana@technovista.com.bd>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */

use App\Models\User;
use App\Models\Settings\Option;
use App\Models\Settings\CommonLabel;
use App\Models\Settings\District;
use App\Models\Settings\ThanaUpazila;
use App\Models\Settings\UnionWard;
use App\Models\Settings\Organogram;
use App\Models\Training\TrainingCategoryModel;

/**
 * Get Option.
 *
 * @param string $option Option Key.
 *
 * @return Option::getOption.
 * ---------------------------------------------------------------------
 */
function getOption($option)
{
    return Option::getOption($option);
}


/**
 * Add Option.
 *
 * @param string       $option Option Key.
 * @param string|array $value  Option Value.
 *
 * @return Option::addOption.
 * ---------------------------------------------------------------------
 */
function addOption($option, $value = '')
{
    return Option::addOption($option, $value);
}


/**
 * Update Option.
 *
 * @param string       $option Option Key.
 * @param string|array $value  Option Value.
 *
 * @return Option::updateOption.
 * ---------------------------------------------------------------------
 */
function updateOption($option, $value = '')
{
    return Option::updateOption($option, $value);
}


/**
 * Delete Option.
 *
 * @param string $option Option Key.
 *
 * @return Option::deleteOption.
 * ---------------------------------------------------------------------
 */
function deleteOption($option)
{
    return Option::deleteOption($option);
}

/**
 * Get Users Capabilities.
 *
 * @param integer $user_id User Id.
 *
 * @return User::getUserCaps
 * ---------------------------------------------------------------------
 */
function getUserCaps($user_id)
{
    return User::getUserCaps($user_id);
}

/**
 * Get Current Users Capabilities.
 *
 * @return User::getCurrentUserCaps
 * ---------------------------------------------------------------------
 */
function getCurrentUserCaps()
{
    return User::getCurrentUserCaps();
}

/**
 * Get Users Role.
 *
 * @param integer $user_id User Id.
 *
 * @return User::getUserRole
 * ---------------------------------------------------------------------
 */
function getUserRole($user_id)
{
    return User::getUserRole($user_id);
}

/**
 * Get Current Users Role.
 *
 * @return User::getCurrentUserRole
 * ---------------------------------------------------------------------
 */
function getCurrentUserRole()
{
    return User::getCurrentUserRole();
}

/**
 * Is Users Roles.
 *
 * @param array   $role    Users Role Type.
 * @param integer $user_id User Id.
 *
 * @return User::isUserRole
 * ---------------------------------------------------------------------
 */
function isUserRole($role, $user_id = null)
{
    return User::isUserRole($role, $user_id);
}

/**
 * Has Users Capabilities.
 *
 * @param array   $capability Users Capabilities.
 * @param integer $user_id    User Id.
 * @param boolean $strict     Whether to strictly match capability. Default: false.
 *
 * @return User::hasUserCap
 * ---------------------------------------------------------------------
 */
function hasUserCap($capability, $user_id = null, $strict = false)
{
    return User::hasUserCap($capability, $user_id, $strict);
}

/**
 * Get User Meta Information.
 *
 * @param int    $userId  User Id of the user meta.
 * @param string $metaKey Meta key of the user meta.
 *
 * @return User::getUserMeta.
 * ---------------------------------------------------------------------
 */
function getUserMeta($userId, $metaKey)
{
    return User::getUserMeta($userId, $metaKey);
}


/**
 * Add User Meta Information.
 *
 * @param int          $userId    User Id of the user meta.
 * @param string       $metaKey   Meta key of the user meta.
 * @param array|string $metaValue Value want to save.
 *
 * @return User::addUserMeta.
 * ---------------------------------------------------------------------
 */
function addUserMeta($userId, $metaKey, $metaValue = '')
{
    return User::addUserMeta($userId, $metaKey, $metaValue);
}


/**
 * Update User Meta Information.
 *
 * @param int          $userId    User Id of the user meta.
 * @param string       $metaKey   Meta key of the user meta.
 * @param array|string $metaValue Value want to save.
 *
 * @return User::updateUserMeta.
 * ---------------------------------------------------------------------
 */
function updateUserMeta($userId, $metaKey, $metaValue = '')
{
    return User::updateUserMeta($userId, $metaKey, $metaValue);
}


/**
 * Delete User Meta Information.
 *
 * @param int    $userId  User Id of the user meta.
 * @param string $metaKey Meta key of the user meta.
 *
 * @return User::deleteUserMeta.
 * ---------------------------------------------------------------------
 */
function deleteUserMeta($userId, $metaKey)
{
    return User::deleteUserMeta($userId, $metaKey);
}

/**
 * Get Common Labels for use.
 *
 * @param string $data_type Data Type.
 *
 * @return CommonLabel::getCL().
 * --------------------------------------------------
 */
function getCommonLabels($data_type)
{
    return CommonLabel::getCL($data_type);
}

/**
 * Get User Name by ID.
 *
 * @param $userId User ID.
 *
 * @return User->getUserNameById
 * -----------------------------------------------------------------------
 */
function getUserNameById($userId)
{
    $user = new User;

    return $user->getUserNameById($userId);
}

/**
 * Report: Check Visible Column.
 *
 * @param string $field   Field to be checked.
 * @param array  $columns All the columns.
 *
 * @return boolean        True if checked, false otherwise.
 */
function isColumnChecked($field, $columns)
{
    return \App\Helpers\Reports::isColumnChecked($field, $columns);
}

/**
 *  Get current logged in user district/upazila/union name
 *
 *  @return array
 */
function getCurrentUserLocationData()
{
    $user = Auth::user();
    $lang = config('app.locale');
    $name = "name_{$lang}";
    $data['districtName'] = District::find($user->district_id)->$name ?? null;
    $data['upazilaName'] = ThanaUpazila::find($user->upazila_id)->$name ?? null;
    $data['unionName'] = UnionWard::find($user->union_id)->$name ?? null;
    return $data;
}

function getOrganogramTreeViewList($showActionButton = true, $selectedId = []) 
{
    //dd(is_array($selectedId));
    $selectedId = $selectedId ?? [];
    if(!empty($selectedId) && !is_array($selectedId)) {
        $selectedId = [$selectedId];
    } else if(empty($selectedId)) {
        $selectedId = [];
    }

    return (new Organogram())->getOrganogramTreeViewList($showActionButton, $selectedId);
}

function getTrainingCategoryDataTreeList($showActionButton = true, $selectedId = []) 
{
    //dd(is_array($selectedId));
    $selectedId = $selectedId ?? [];
    if(!empty($selectedId) && !is_array($selectedId)) {
        $selectedId = [$selectedId];
    } else if(empty($selectedId)) {
        $selectedId = [];
    }

    return (new TrainingCategoryModel())->getTrainingCategoryTreeviewList($showActionButton, $selectedId);
}
