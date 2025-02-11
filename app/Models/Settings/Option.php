<?php

/**
 * Option Model.
 * php version 7.1.3
 *
 * @category CMS/Admin
 * @package  LGSP3
 * @author   Mayeenul Islam <wz.islam@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */

namespace App\Models\Settings;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

/**
 * Option Model.
 * php version 7.1.3
 *
 * @category CMS/Admin
 * @package  LGSP3
 * @author   Mayeenul Islam <wz.islam@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class Option extends Model
{
    protected $table = 'options';

    protected $fillable = [
        'option_id',
        'option_name',
        'option_value'
    ];

    /**
     * Get option data.
     *
     * @param string $option Name of the option.
     *
     * @return array|string  Return the value, if necessary unserialize data.
     * ---------------------------------------------------------------------
     */
    public static function getOption($option)
    {
        $option = trim($option);
        if (empty($option)) {
            return false;
        }

        // Distinguish between `false` as a default, and not passing one.
        //$passed_default = func_num_args() > 1;

        // Cache time
        $cacheTime = 2592000; //seconds (60 seconds x 60 min x 24 hr x 30 = 30 days)

        $result = Cache::remember(
            $option,
            $cacheTime,
            function () use ($option) {
                return DB::table('options')
                    ->select('options.option_value')
                    ->where('options.option_name', $option)
                    ->first();
            }
        );

        if (is_object($result)) {
            $value = $result->option_value;
        } else {
            $value = $result;
        }

        return self::maybeUnserialize($value);
    }

    /**
     * Save option data.
     *
     * @param string       $option Name of the option.
     * @param array|string $value  Value want to save.
     *
     * @return boolean             True|False.
     * ---------------------------------------------------------------------
     */
    public static function addOption($option, $value = '')
    {
        $option = trim($option);
        if (empty($option)) {
            return false;
        }

        if (is_object($value)) {
            $value = clone $value;
        }

        $serialized_value = self::maybeSerialize($value);

        $result = DB::table('options')->insert(
            [
                'option_name'  => $option,
                'option_value' => $serialized_value
            ]
        );

        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * Update option data.
     *
     * @param string       $option Name of the option.
     * @param array|string $value  Value want to save.
     *
     * @return boolean             True|False.
     * ---------------------------------------------------------------------
     */
    public static function updateOption($option, $value = '')
    {
        $option = trim($option);
        if (empty($option)) {
            return false;
        }

        if (is_object($value)) {
            $value = clone $value;
        }

        $old_value = self::getOption($option);

        // If the new and old values are the same, no need to update.
        //
        // Unserialized values will be adequate in most cases. If the unserialized
        // data differs, the (maybe) serialized data is checked to avoid
        // unnecessary db calls for otherwise identical object instances.
        if ($value === $old_value || self::maybeSerialize($value) === self::maybeSerialize($old_value)) {
            return false;
        }

        $serialized_value = self::maybeSerialize($value);

        $result = DB::table('options')->where('option_name', $option)
            ->update(
                [
                    'option_name'  => $option,
                    'option_value' => $serialized_value
                ]
            );

        if (!$result) {
            $added = self::addOption($option, $value);
        }

        if (!$result && !$added) {
            return false;
        }

        // Clear the specific cache.
        if (Cache::has($option)) {
            Cache::forget($option);
        }

        return true;
    }

    /**
     * Delete Option Data.
     *
     * @param string $option Option Key.
     *
     * @return boolean
     * ---------------------------------------------------------------------
     */
    public static function deleteOption($option)
    {
        $option = trim($option);
        if (empty($option)) {
            return false;
        }

        $result = DB::table('options')->where('option_name', $option)->delete();

        if (!$result) {
            return false;
        }

        // Clear the specific cache.
        if (Cache::has($option)) {
            Cache::forget($option);
        }

        return true;
    }

    /**
     * Unserialize if necessary.
     *
     * @param array|string $original Data want to unserialize.
     *
     * @return array|string          Data | Unserialized data.
     * ---------------------------------------------------------------------
     */
    public static function maybeUnserialize($original)
    {
        if (self::_isSerialized($original)) // don't attempt to unserialize data that wasn't serialized going in
            return @unserialize($original);

        return $original;
    }

    /**
     * Serialize data.
     *
     * @param string|array $data Data to be serialized.
     *
     * @return string            Serialized data | String.
     * ---------------------------------------------------------------------
     */
    public static function maybeSerialize($data)
    {
        if (is_array($data) || is_object($data)) {
            return serialize($data);
        }

        if (self::_isSerialized($data, false)) {
            return serialize($data);
        }

        return $data;
    }

    /**
     * Check whether is serialized?
     *
     * @param string|array $data   Data to check serialization.
     * @param boolean      $strict Strict or not.
     *
     * @return boolean             True | False.
     * ---------------------------------------------------------------------
     */
    private static function _isSerialized($data, $strict = true)
    {
        // if it isn't a string, it isn't serialized.
        if (!is_string($data)) {
            return false;
        }
        $data = trim($data);
        if ('N;' == $data) {
            return true;
        }
        if (strlen($data) < 4) {
            return false;
        }
        if (':' !== $data[1]) {
            return false;
        }
        if ($strict) {
            $lastc = substr($data, -1);
            if (';' !== $lastc && '}' !== $lastc) {
                return false;
            }
        } else {
            $semicolon = strpos($data, ';');
            $brace = strpos($data, '}');
            // Either ; or } must exist.
            if (false === $semicolon && false === $brace)
                return false;
            // But neither must be in the first X characters.
            if (false !== $semicolon && $semicolon < 3)
                return false;
            if (false !== $brace && $brace < 4)
                return false;
        }
        $token = $data[0];
        switch ($token) {
            case 's':
                if ($strict) {
                    if ('"' !== substr($data, -2, 1)) {
                        return false;
                    }
                } elseif (false === strpos($data, '"')) {
                    return false;
                }
                // or else fall through
            case 'a':
            case 'O':
                return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'b':
            case 'i':
            case 'd':
                $end = $strict ? '$' : '';

                return (bool) preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
        }

        return false;
    }

    /**
     * Update all the options accordingly.
     *
     * @param array $inputs Array of form items.
     *
     * @return void.
     * ---------------------------------------------------------------------
     */
    public static function updateAllOptions($inputs)
    {
        // Get all the fields from inputs.
        $array_keys = array_keys($inputs);

        // Remove _token and _method from our update process.
        // http://stackoverflow.com/a/11764428/1743124
        $array_keys = array_flip($array_keys);
        unset($array_keys['_method']);
        unset($array_keys['_token']);
        $array_keys = array_flip($array_keys);

        // Do add/update all of 'em.
        foreach ($array_keys as $option_name) {
            self::updateOption($option_name, $inputs[$option_name]);
        }
    }
}
