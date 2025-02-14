<?php

/**
 * Utilities/Helper Functions.
 *
 * Helper functions necessary for the application
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

use Illuminate\Support\Arr;

/**
 * Auto Copyright
 *
 * @param string|integer $year A year | 'auto'.
 * @param string         $text Copyright text.
 *
 * @author Ipstenu (Mika Epstein) <[<email address>]>
 * @link   https://halfelf.org/2017/copyright-years-wordpress/
 *
 * @return void.
 * ---------------------------------------------------------------------
 */
function autoCopyright($year = 'auto', $text = '')
{
    $year = ($year == 'auto' || ctype_digit($year) == false) ? date('Y') : intval($year);
    $text = ($text == '') ? '&copy;' : $text;

    if ($year == date('Y') || $year > date('Y')) {
        $output = date('Y');
    } elseif ($year < date('Y')) {
        $output = $year . ' - ' . date('Y');
    }

    $output = ('bn' == App::getLocale()) ? ENtoBN::translate($output) : $output;

    echo '&copy; ' . $output . ' ' . $text;
}


/**
 * Translate String, when applicable.
 *
 * Translate the string only when certain locale is set.
 *
 * @param string $string String to translate.
 *
 * @return string        Translated/Non-translated string.
 * -----------------------------------------------------------------------
 */
function translateString($string)
{
    $translatedString = ('bn' == App::getLocale()) ? ENtoBN::translate($string) : $string;

    return $translatedString;
}

function translateAlphabet($string)
{
    $translatedString = ('bn' == App::getLocale()) ? ENtoBN::translateAlphabetToConsonent($string) : $string;

    return $translatedString;
}

/**
 * Display DateTime.
 *
 * Empty check the date first to avoid displaying default date '01 January 1970',
 * then translate the string if applicable, and return the formatted DateTime.
 *
 * @param integer $dateTimeInput DateTime as input.
 * @param string  $format        Date Format.
 *
 * @return string                String translated, EmDash otherwise.
 * -----------------------------------------------------------------------
 */
function displayDateTime($dateTimeInput, $format = 'd F Y')
{
    if (empty($dateTimeInput)) {
        return '―';
    }

    $formattedDate = date($format, strtotime($dateTimeInput));

    if ('bn' == App::getLocale()) {
        return ENtoBN::translate($formattedDate);
    } else {
        return $formattedDate;
    }
}

/**
 * Truncate Amount.
 *
 * @param integer $amount Amount.
 *
 * @return array Array of truncated amount and label.
 */
function truncateAmount($amount)
{
    // filter and format it
    if ($amount < 1000) {
        // 0 - 1000
        $amountOutput = (int) $amount;
        $truncateLabel = '';
    } elseif ($amount < 900000) {
        // 0.9k-850k
        $amountOutput = round(($amount / 1000), 2);
        $truncateLabel = __('k');
    } elseif ($amount < 900000000) {
        // 0.9m-850m
        $amountOutput = round(($amount / 1000000), 2);
        $truncateLabel = __('m');
    } elseif ($amount < 900000000000) {
        // 0.9b-850b
        $amountOutput = round(($amount / 1000000000), 2);
        $truncateLabel = __('b');
    } else {
        // 0.9t+
        $amountOutput = round(($amount / 1000000000000), 2);
        $truncateLabel = __('t');
    }

    return array(
        'amountOutput'  => $amountOutput,
        'truncateLabel' => $truncateLabel,
    );
}

/**
 * Display amount.
 *
 * Display amount thousand formatted, and float pointed,
 * and if applicable, with currency symbol.
 *
 * @param integer        $amount         Amount value.
 * @param boolean|string $currencySymbol Symbol Currency symbol, otherwise false.
 * @param boolean        $truncate       Whether display the short form or detail form.
 *
 * @see truncateAmount() Truncate Amount.
 *
 * @return string                    Formatted amount string.
 * -----------------------------------------------------------------------
 */
function viewAmount($amount, $currencySymbol = false, $truncate = false)
{
    if (empty($amount)) {
        return '—';
    }

    // make sure it's a number...
    if (!IS_NUMERIC($amount)) {
        return false;
    }

    if ($truncate) {
        $tr = truncateAmount($amount);

        $amountOutput  = $tr['amountOutput'];
        $truncateLabel = $tr['truncateLabel'];
    } else {
        // Thousand Separated and float pointed.
        $amountOutput = number_format((int) $amount, 2, '.', ',');
    }

    $amountOutput = ('bn' === app()->getLocale()) ? ENtoBN::translate_number($amountOutput) : $amountOutput;

    if (false !== $currencySymbol) {
        $amountOutput = $currencySymbol . $amountOutput;
    }

    if ($truncate) {
        $amountOutput = $amountOutput . ' ' . $truncateLabel;
    }

    return $amountOutput;
}

/**
 * Elapsed time
 *
 * Calculates how much time elapsed from a time mentioned.
 *
 * @param string $time Date & Time string.
 *
 * @author arnorhs
 * @link   http://stackoverflow.com/a/2916189/1743124
 *
 * @return string       Elapsed time.
 * -----------------------------------------------------------------------
 */
function timeElapsed($time)
{
    $time   = strtotime($time);
    $now    = date('Y-m-d H:i:s', time());
    $time   = strtotime($now) - $time; // to get the time since that moment
    $tokens = array(
        31536000 => __('year|years'),
        2592000 => __('month|months'),
        604800 => __('week|weeks'),
        86400 => __('day|days'),
        3600 => __('hour|hours'),
        60 => __('minute|minutes'),
        1 => __('second|seconds')
    );
    foreach ($tokens as $unit => $text) {
        if ($time < $unit) {
            continue;
        }

        $number_of_units = floor($time / $unit);
        $localized_number_of_units = 'bn' == App::getLocale() ? ENtoBN::translate($number_of_units) : $number_of_units;
        return $localized_number_of_units . ' ' . trans_choice($text, $number_of_units);
    }
}

/**
 * Date Difference In Days
 *
 * Calculates how much time from a date mentioned.
 * PHP code to find the number of days between two given dates.
 * Function to find the difference between two dates.
 *
 * @param string $date1        From Date.
 * @param string $date2        To Date.
 * @param string $stringAppend Text.
 *
 * @link http://www.geeksforgeeks.org/program-to-find-the-number-of-days-between-two-dates-in-php/
 *
 * @return integer|string in days.
 * -----------------------------------------------------------------------
 */

function dateDiffInDays($date1, $date2, $stringAppend = '')
{
    // Calulating the difference in timestamps
    $diff = strtotime($date2) - strtotime($date1);

    // 1 day = 24 hours
    // 24 * 60 * 60 = 86400 seconds
    $number = abs(round($diff / 86400));

    if (!empty($stringAppend)) {
        return "{$number} {$stringAppend}";
    }

    return $number;
}

/**
 * Parse Arguments.
 *
 * Parse user defined arguments and mix them with default
 * arguments defined.
 *
 * Adopted, but modified from WordPress Core.
 *
 * @param array $args     User defined arguments.
 * @param array $defaults Default arguments.
 *
 * @return array          Merged version of arguments.
 * ---------------------------------------------------------------------
 */
function parseArguments($args, $defaults)
{
    if (!is_array($args) || !is_array($defaults)) {
        return 'Both the parameters need to be array';
    }

    $r = &$args;

    return array_merge($defaults, $r);
}


/**
 * The array_merge_recursive does indeed merge arrays, but it converts values with duplicate
 * keys to arrays rather than overwriting the value in the first array with the duplicate
 * value in the second array, as array_merge does. I.e., with array_merge_recursive,
 * this happens (documented behavior):
 *
 * The array_merge_recursive(array('key' => 'org value'), array('key' => 'new value'));
 *     => array('key' => array('org value', 'new value'));
 *
 * array_merge_recursive_distinct does not change the datatypes of the values in the arrays.
 * Matching keys' values in the second array overwrite those in the first array, as is the
 * case with array_merge, i.e.:
 *
 * array_merge_recursive_distinct(array('key' => 'org value'), array('key' => 'new value'));
 *     => array('key' => array('new value'));
 *
 * Parameters are passed by reference, though only for performance reasons. They're not
 * altered by this function.
 *
 * @param array $array1 Array 1
 * @param array $array2 Array 2
 *
 * @author Daniel <daniel (at) danielsmedegaardbuus (dot) dk>
 * @author Gabriel Sobrinho <gabriel (dot) sobrinho (at) gmail (dot) com>
 *
 * @link https://medium.com/@kcmueller/php-merging-two-multi-dimensional-arrays-overwriting-existing-values-8648d2a7ea4f
 *
 * @return array
 * ---------------------------------------------------------------------
 */
function arrayMergeRecursiveDistinct(array &$array1, array &$array2)
{
    $merged = $array1;
    foreach ($array2 as $key => &$value) {
        if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
            $merged[$key] = arrayMergeRecursiveDistinct($merged[$key], $value);
        } else {
            $merged[$key] = $value;
        }
    }
    return $merged;
}


/**
 * In Admin
 * Detect whether the current URL is of Admin Panel or not.
 *
 * @return boolean          True if in admin, false otherwise.
 * ---------------------------------------------------------------------
 */
function inAdmin()
{
    // Strip out language prefix.
    $currentRoutePrefix = str_replace('/' . App::getLocale(), '', Request()->route()->getPrefix());

    if (config('app.admin_route_prefix') === $currentRoutePrefix) {
        return true;
    } else {
        return false;
    }
}


/**
 * Items Per Page (IPP).
 *
 * Restrict items per page within the defined item limits.
 *
 * @param  integer $default Default is 10 items per page.
 * @return integer Fool-proof items per page.
 */
function itemsPerPage($default = 10)
{
    $itemLimits = config('app.items_per_pages');

    $itemsPerPage = Request::input('ipp') ?? $default;

    if (!in_array($itemsPerPage, $itemLimits)) {
        $itemsPerPage = $default;
    }

    return $itemsPerPage;
}


/**
 * Show the Footer of a Grid/List.
 *
 * @param object  $query        Query object.
 * @param integer $itemsPerPage Items per page count.
 */
function gridFooter($query, $itemsPerPage)
{
    $itemLimits  = config('app.items_per_pages');
    $query_count = ('bn' === app()->getLocale()) ? ENtoBN::translate_number($query->count()) : $query->count();
    $query_total = ('bn' === app()->getLocale()) ? ENtoBN::translate_number($query->total()) : $query->total();


    ob_start();
?>

    <div class="row small text-muted">
        <div class="col-sm-4 pt-1">
            <?php echo __('Per page'); ?>
            <select name="ipp" id="items-per-page" class="custom-select custom-select-sm w-auto">
                <?php foreach ($itemLimits as $limit) { ?>
                    <option value="<?php echo intval($limit); ?>" <?php echo $itemsPerPage == $limit ? 'selected="selected"' : ''; ?>><?php echo translateString($limit); ?></option>
                <?php } ?>
            </select>
            <?php echo __('items'); ?>
            <span class="ml-1 mr-1">|</span>
            <?php echo __('Showing :count out of :total items', ['count' => $query_count, 'total' => $query_total]); ?>
        </div>
        <div class="col-sm-8 text-sm-right">
            <?php
            if ($query->total() > $itemsPerPage) {
                // Pagination keeping the filter parameters
                echo $query->appends(Request::except('page'))->render();
            } else {
                echo __('Page 1');
            }
            ?>
        </div>
    </div>

<?php
    return ob_get_clean();
}

/**
 * Show the Footer of a Grid/List.
 *
 * @param object  $query        Query object.
 * @param integer $itemsPerPage Items per page count.
 */
function gridFooterSimplePaginate($links, $itemsPerPage, $query_total)
{
    $itemLimits  = config('app.items_per_pages');
    $query_count = 10;
    if (isset($_GET['ipp']) && !empty($_GET['ipp'])) {
        $query_count = $_GET['ipp'];
        //dd("ttt");
    }
?>

    <div class="row small text-muted">
        <div class="col-sm-4 pt-1">
            <?php echo __('Per page'); ?>
            <select name="ipp" id="items-per-page" class="custom-select custom-select-sm w-auto">
                <?php foreach ($itemLimits as $limit) { ?>
                    <option value="<?php echo intval($limit); ?>" <?php echo $itemsPerPage == $limit ? 'selected="selected"' : ''; ?>><?php echo translateString($limit); ?></option>
                <?php } ?>
            </select>
            <?php echo __('items'); ?>
            <span class="ml-1 mr-1">|</span>
            <?php echo __('Showing :count out of :total items', ['count' => $query_count, 'total' => $query_total]); ?>
        </div>
        <div class="col-sm-8 text-sm-right">
            <?php
            /* if ($query->total() > $itemsPerPage) {
                // Pagination keeping the filter parameters
                echo $query->appends(Request::except('page'))->render();
            } else {
                echo __('Page 1');
            } */
            echo $links;
            ?>
        </div>
    </div>

<?php
    return ob_get_clean();
}


/**
 * Create Zip Archive
 *
 * @param string $source      Source directory.
 * @param string $destination Destination directory with Archive name.
 *
 * @author Marvin Menzerath
 * @link   https://gist.github.com/MarvinMenzerath/4185113/72db1670454bd707b9d761a9d5e83c54da2052ac
 *
 * @return void|false
 * ---------------------------------------------------------------------
 */
function createZip($source, $destination)
{

    if (extension_loaded('zip') === true) {
        if (file_exists($source) === true) {
            $zip = new ZipArchive();
            if ($zip->open($destination, ZIPARCHIVE::CREATE) === true) {
                $source = realpath($source);
                if (is_dir($source) === true) {
                    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
                    foreach ($files as $file) {
                        $file = realpath($file);
                        if (is_dir($file) === true) {
                            $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                        } elseif (is_file($file) === true) {
                            $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                        }
                    }
                } elseif (is_file($source) === true) {
                    $zip->addFromString(basename($source), file_get_contents($source));
                }
            }
            return $zip->close();
        }
    }
    return false;
}

/**
 * Format Bytes.
 *
 * @param integer $bytes     Bytes
 * @param integer $precision Precision
 *
 * @link https://stackoverflow.com/a/2510459/1743124
 *
 * @return integer
 * ---------------------------------------------------------------------
 */
function formatBytes($bytes, $precision = 2)
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow   = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow   = min($pow, count($units) - 1);

    // Uncomment one of the following alternatives
    // $bytes /= pow(1024, $pow);
    $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
}


/**
 * Method to check mysqldump command is accessible or not.
 *
 * Used to execute database backup using mysqldump command.
 *
 * @return string|boolean false if inaccessible, path as string if accessible.
 * ---------------------------------------------------------------------
 */
function hasMySQLDump()
{
    // Check default way - the PATH.
    exec('mysqldump --version 2>&1', $output, $return_val);

    if ($return_val != 0) {
        // It's not working by default. Get user defined path, and try again.
        $path_to_mysqld = getOption('_path_to_mysqld');
        if (empty($path_to_mysqld)) {
            return false;
        } else {
            $path_to_mysqld = rtrim($path_to_mysqld, '/\\'); // untrailingSlahIt

            if (!is_dir($path_to_mysqld)) {
                // There's no such directory.
                return false;
            }

            // https://stackoverflow.com/a/13539649/1743124
            $mysql_path = "{$path_to_mysqld}\mysqldump.exe";
            $mysqldump  = escapeshellarg($mysql_path); // escape unwanted shell command

            exec("{$mysqldump} --version 2>&1", $output_secondary, $return_val_secondary);

            if ($return_val_secondary != 0) {
                // It's not working even with user defined path.
                return false;
            } else {
                // It's working with user defined path, return it.
                return $mysql_path;
            }
        }
    } else {
        // It's working, return the command itself.
        return 'mysqldump';
    }
}


/**
 * Method to check gzip command is accessible or not.
 *
 * Used to execute database backup using mysqldump command.
 *
 * @return boolean false if inaccessible, true otherwise.
 * ---------------------------------------------------------------------
 */
function hasGZip()
{
    // Check default way - the PATH.
    exec('gzip --version 2>&1', $output, $return_val);

    return $return_val != 0 ? false : true;
}


/**
 * Generate alt text from Image file path.
 *
 * @param string $image_file_path Image file path.
 *
 * @return string                 Alt text.
 * -----------------------------------------------------------------------
 */
function generateAltTextFromImagePath($image_file_path)
{
    $alt_text = pathinfo($image_file_path)['filename'];
    $alt_text = str_replace('_', ' ', $alt_text);
    $alt_text = str_replace('-', ' ', $alt_text);

    return $alt_text;
}


/**
 * Add Filter Parameters to Query Arguments.
 *
 * If your db Query key is different than the URL params,
 * then pass and associative array as $additions, if not,
 * you can pass a one-dimentional array of parameters.
 *
 * Usage Instructions:
 * - $additions = array(
 *      'query_key1' => 'parameter1',
 *      'query_key2' => 'parameter2'
 *   );
 * - $additions = array('parameter1', 'parameter2');
 *
 * @param array $args      Array of Arguments.
 * @param array $additions Array of Filter Keys.
 *
 * @return array           Merged Array.
 * -----------------------------------------------------------------------
 */
function filterParams($args, $additions)
{
    if (Arr::isAssoc($additions)) {
        foreach ($additions as $query_key => $param) {
            $_var = Request::input($param);

            if (!empty($_var)) {
                $args = array_merge($args, array($query_key => $_var));
            }
        }
    } else {
        foreach ($additions as $param) {
            $_var = Request::input($param);

            if (!empty($_var)) {
                $args = array_merge($args, array($param => $_var));
            }
        }
    }

    return $args;
}

/**
 * Get Status Label and Icon
 *
 * @param string $status Status key.
 * @param bool   $icon   True to return icon also, false otherwise. Default: false.
 *
 * @return array|bool|null|string If icon, array, otherwise status string. Returns false if not matched.
 * -----------------------------------------------------------------------
 */
function getStatusLabel($status, $icon = false)
{
    if ('draft' === $status) {
        $icon  = 'icon-pencil7';
        $label = __('Draft');
    } elseif ('pending' === $status) {
        $icon  = 'icon-shield-notice';
        $label = __('Pending Review');
    } elseif ('private' === $status) {
        $icon  = 'icon-user-lock';
        $label = __('Private');
    } elseif ('internal' === $status) {
        $icon  = 'icon-lock5';
        $label = __('Internal');
    } elseif ('publish' === $status) {
        $icon  = 'icon-checkmark-circle2';
        $label = __('Publish');
    } elseif ('trash' === $status) {
        $icon  = 'icon-trash-alt';
        $label = __('Trash');
    } else {
        return false;
    }

    if ($icon) {
        return array(
            'icon'  => $icon,
            'label' => $label
        );
    } else {
        return $label;
    }
}

/**
 * Site's Base URL.
 *
 * Might be similar to the Home URL, but it's made
 * because of the locale middleware.
 *
 * @return string Base URL of the site.
 * -----------------------------------------------------------------------
 */
function baseURL()
{
    if (!empty(config('app.locale'))) {
        $locale_param = '/' . config('app.locale') . '/';
    } else {
        $locale_param = '';
    }

    return action('LanguageController@baseURL') . $locale_param;
}

/**
 * Suppress Base URL from a URL.
 *
 * @param string $url User passed URL.
 *
 * @return string Suppressed URL.
 * -----------------------------------------------------------------------
 */
function suppressBaseURL($url)
{
    $baseURL = rtrim(baseURL(), '/\\'); //untrailingslashit. Thanks to WordPress.
    return str_replace($baseURL, '', $url);
}


/**
 * Convert Line Breaks to Paragraphs.
 *
 * @param string  $string      String to put paragraphs on.
 * @param boolean $line_breaks Whether to put line breaks or not.
 * @param boolean $xml         Whether there is XML or not.
 *
 * @author Shoelaced
 * @link   https://stackoverflow.com/a/52692970/1743124
 *
 * @return string              Formatted String
 * -----------------------------------------------------------------------
 */
function nl2p($string, $line_breaks = true, $xml = true)
{
    // Remove current tags to avoid double-wrapping.
    $string = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $string);

    // Default: Use <br> for single line breaks, <p> for multiple line breaks.
    if ($line_breaks == true) {
        $string = '<p>' . preg_replace(
            array("/([\n]{2,})/i", "/([\r\n]{3,})/i", "/([^>])\n([^<])/i"),
            array("</p>\n<p>", "</p>\n<p>", '$1<br' . ($xml == true ? ' /' : '') . '>$2'),
            trim($string)
        ) . '</p>';

        // Use <p> for all line breaks if $line_breaks is set to false.
    } else {
        $string = '<p>' . preg_replace(
            array("/([\n]{1,})/i", "/([\r]{1,})/i"),
            "</p>\n<p>",
            trim($string)
        ) . '</p>';
    }

    // Remove empty paragraph tags.
    $string = str_replace('<p></p>', '', $string);

    // Return string.
    return $string;
}

/**
 * Years for Select field.
 *
 * @param integer $earliestYear Earliest year to load from.
 * @param integer $limitYear    Limit where to stop.
 *
 * @author Mayeenul Islam
 * @author Chris Baker
 * @link   https://stackoverflow.com/a/7083153/1743124
 *
 * @return array                 Translated array of years.
 * -----------------------------------------------------------------------
 */
function selectYears($earliestYear = null, $limitYear = null)
{
    $earliestYear = null == $earliestYear ? 1952 : $earliestYear;
    $limitYear    = null == $limitYear ? date('Y') : $limitYear;

    $years = array();

    foreach (range($limitYear, $earliestYear) as $year) :
        $yearLabel = 'bn' == App::getLocale() ? ENtoBN::translate_number($year) : $year;
        $years[$year] = $yearLabel;
    endforeach;

    return $years;
}

/**
 * Show CSS Loader.
 *
 * Show the HTML markups for a CSS loader.
 *
 * @author Aaron Iker
 * @link   https://codepen.io/aaroniker/pen/ZmOMJp
 *
 * @return void
 * -----------------------------------------------------------------------
 */
function showLoader()
{
?>
    <div class="loader-boxes">
        <div class="loader-box">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="loader-box">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="loader-box">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="loader-box">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <?php
}

/**
 * Display View Button.
 *
 * Display view button in admin panel based on the status.
 * - Draft => Preview
 * - View (Internal) => Admin View
 * - View (Public) => Public View
 *
 * @param string $status      Status.
 * @param string $internalURL Internal Url.
 * @param string $publicURL   Public Url.
 *
 * @return void
 * -----------------------------------------------------------------------
 */
function displayViewButton($status, $internalURL, $publicURL = '')
{
    if (in_array($status, ['internal', 'draft'])) {
    ?>
        <a href="<?php echo $internalURL; ?>" class="btn btn-outline-primary btn-sm">
            <i class="icon-eye mr-1" aria-hidden="true"></i>
            <?php echo 'draft' === $status ? __('Preview') : __('View'); ?>
        </a>
    <?php
    } elseif ('publish' === $status) {
    ?>
        <div class="dropdown d-inline-block">
            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="view-scope" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-eye mr-1" aria-hidden="true"></i>
                <?php echo __('View'); ?>
            </button>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="view-scope">
                <a href="<?php echo $internalURL; ?>" class="dropdown-item">
                    <?php echo __('Internal'); ?>
                </a>

                <a href="<?php echo $publicURL; ?>" class="dropdown-item">
                    <?php echo __('Public'); ?>
                </a>
            </div>
        </div>
<?php
    }
}

/**
 * Prohibit Editing Other People's Draft.
 *
 * Not applicable for 'administrator'.
 *
 * @param string  $status     Status.
 * @param integer $authorId   Author ID.
 * @param integer $statusCode HTTP Status Code. Default: 403.
 * @param string  $message    Custom message. Default: empty.
 *
 * @return \Illuminate\Http\Response
 */
function prohibitDraftEdit($status, $authorId, $statusCode = 403, $message = 'Unauthorized Draft')
{
    if (isUserRole('administrator')) {
        return;
    }

    if ('draft' === $status && $authorId !== Auth::id()) {
        if (empty($message)) {
            return abort($statusCode);
        } else {
            return abort($statusCode, $message);
        }
    }
}

/**
 * Set Default Value.
 *
 * @param object $object  Data Object.
 * @param string $field   Database Field.
 * @param mixed  $default Default value. Default: Empty.
 *
 * @return mixed
 */
function setDefaultValue($field, $object, $default = '')
{
    if (old($field)) {
        // Prioritize $_POST data.
        $value = old($field);
    } elseif (isset($object) && !empty($object)) {
        // Then database value (in edit mode).
        $value = $object->$field;
    } else {
        // None. Return default.
        $value = $default;
    }

    return $value;
}

/**
 * Check URL/Route is match or not.
 *
 * @param string $route User provided Route/URL.
 *
 * @return boolean      True if url is matched, false otherwise.
 */
function isCurrentRoute($route)
{
    $this_url = suppressBaseURL(url()->current());
    $edit_url = suppressBaseURL($route);

    if ($this_url === $edit_url) {
        return true;
    }

    return false;
}

/**
 * Blood Groups.
 *
 * Defined blood groups.
 *
 * @link https://www.nhs.uk/conditions/blood-groups/
 *
 * @return array Array of Blood Groups.
 */
function bloodGroups()
{
    return array(
        'A+'  => __('A Positive (A+ve)'),
        'A-'  => __('A Negative (A-ve)'),
        'B+'  => __('B Positive (B+ve)'),
        'B-'  => __('B Negative (B-ve)'),
        'O+'  => __('O Positive (O+ve)'),
        'O-'  => __('O Negative (O-ve)'),
        'AB+' => __('AB Positive (AB+ve)'),
        'AB-' => __('AB Negative (AB-ve)'),
    );
}

/**
 * Blood Group Label.
 *
 * @param string $bloodGroup Boold Group.
 *
 * @return string Blood Group Label.
 */
function bloodGroupLabel($bloodGroup)
{
    $bloodGroups = bloodGroups();

    return $bloodGroups[$bloodGroup];
}


/**
 * Blood Group Label.
 *
 * @param string $bloodGroup Boold Group.
 *
 * @return string Blood Group Label.
 */
function statusYesNoLabel($status)
{
    if(empty($status)){
        return "";
    }
    $statusList = array(
        '1'    => __('Yes'),
        '0'    => __('No'),
        'yes'  => __('Yes'),
        'no'   => __('No'),
    );

    return $statusList[$status];
}

/**
 * Resolve Field Name.
 *
 * If the data is available in the column of current language, then get from there,
 * otherwise fall back to English column (by default).
 *
 * @param object $object        Data object.
 * @param string $column_prefix Column name prefix. Default: 'name_'.
 * @param string $fallback_lang Column langugage follback. Default: 'en'.
 *
 * @return string The available string from the available column.
 */
function resolveFieldName($object, $column_prefix = 'name_', $fallback_lang = 'en')
{
    if(empty($object)) return "";
    $lang = config('app.locale');

    $fallback_column = $column_prefix . $fallback_lang;
    $column          = $column_prefix . $lang;

    $column_value = $object->$column ?? $object->$fallback_column;

    return $column_value ?? '-';
}

/**
 * User Levels.
 *
 * User levels defined by the LGSP-3.
 *
 * @return array User levels.
 */
function userLevels()
{
    $userLevels = array(
        'super_admin'  => __('Super Admin')
    );
    if (!empty(Auth::user()->organization_id)) {
        unset($userLevels['super_admin']);
    }
    return $userLevels;
}

/**
 * User Level Label.
 *
 * @param string $level Level.
 *
 * @return string User level name.
 */
function userLevelLabel($level)
{
    $levels = userLevels();

    return $levels[$level];
}

/**
 * Genders.
 *
 * Defined genders.
 *
 * @return array Array of Genders.
 */
function genders()
{
    return array(
        'male'         => __('Male'),
        'female'       => __('Female'),
        'third_gender' => __('Transgender')
    );
}

/**
 * Gender Label.
 *
 * @param string $gender Gender.
 *
 * @return string Gender Label.
 */
function genderLabel($gender)
{
    $genders = genders();
    if(!empty($gender)){
        return $genders[$gender];
    }
    return '';

}

/**
 * Add number of days to a date
 *
 * @param $date date to add days
 * @param $days
 * @param $format date format that will be return
 * @author Mohammad Harun-Or-Rashid
 */
function addDaysToDate($date, $days, $format = 'd-m-Y')
{
    return date($format, strtotime($date . ' + ' . $days . ' days'));
}

/**
 * Format date
 * @author Nazmul
 */
function formatDate($date, $format = 'd-m-Y')
{
    if (!empty($date)) {
        return date($format, strtotime($date));
    }

    return "";
}

/**
 * GPS to Number.
 *
 * @param string $coordPart Coordinate part.
 *
 * @return float            GPS Number.
 */
function gps2Num($coordPart)
{
    $parts = explode('/', $coordPart);
    if (count($parts) <= 0) {
        return 0;
    } elseif (count($parts) == 1) {
        return $parts[0];
    }

    if (floatval($parts[1] != 0)) {
        return floatval($parts[0]) / floatval($parts[1]);
    }
}

/**
 * Get Image Location (Lat-Lng)
 *
 * @param string $file File with complete path.
 *
 * @return boolean|array False if unsuccessful | Array of lat-lng otherwise.
 */
function get_image_location($file)
{
    try {
        if (!function_exists('exif_read_data')) {
            return false;
        }

        $exif = @exif_read_data($file, 0, true);

        if (!empty($exif) && isset($exif['GPS'])) {
            $GPSLatitudeRef  = $exif['GPS']['GPSLatitudeRef'];
            $GPSLatitude     = $exif['GPS']['GPSLatitude'];
            $GPSLongitudeRef = $exif['GPS']['GPSLongitudeRef'];
            $GPSLongitude    = $exif['GPS']['GPSLongitude'];

            $lat_degrees = count($GPSLatitude) > 0 ? gps2Num($GPSLatitude[0]) : 0;
            $lat_minutes = count($GPSLatitude) > 1 ? gps2Num($GPSLatitude[1]) : 0;
            $lat_seconds = count($GPSLatitude) > 2 ? gps2Num($GPSLatitude[2]) : 0;

            $lon_degrees = count($GPSLongitude) > 0 ? gps2Num($GPSLongitude[0]) : 0;
            $lon_minutes = count($GPSLongitude) > 1 ? gps2Num($GPSLongitude[1]) : 0;
            $lon_seconds = count($GPSLongitude) > 2 ? gps2Num($GPSLongitude[2]) : 0;

            $lat_direction = ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
            $lon_direction = ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;

            $latitude  = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60 * 60)));
            $longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60 * 60)));

            if (!empty($latitude) && !empty($longitude)) {
                return array(
                    'latitude'  => $latitude,
                    'longitude' => $longitude,
                );
            }

            return false;
        }
    } catch (\Exception $e) {
        return false;
    }

    return false;
}



/**
 * Get Image Date Time
 *
 * @param string $file File with complete path.
 *
 * @return boolean|array False if unsuccessful
 */
function get_image_datetime($file)
{
    try {
        if (!function_exists('exif_read_data')) {
            return false;
        }

        $exif = @exif_read_data($file, 0, true);

        if (!empty($exif) && (isset($exif['IFD0']) || isset($exif['EXIF']) || isset($exif['GPS']))) {
            if (!empty($exif['EXIF']['DateTimeOriginal'])) {
                $dateTime = $exif['EXIF']['DateTimeOriginal'];
            } else if (!empty($exif['IFD0']['DateTime'])) {
                $dateTime = $exif['IFD0']['DateTime'];
            } else if (!empty($exif['GPS']['GPSDateStamp'])) {
                $dateTime = $exif['GPS']['GPSDateStamp'];
            } else {
                $dateTime = null;
            }

            return array(
                'dateTime'  => $dateTime,
            );
        }
    } catch (\Exception $e) {
        return false;
    }

    return false;
}

function getImageExifInfo($file)
{
    try {
        if (!function_exists('exif_read_data')) {
            return null;
        }

        $exif = @exif_read_data($file, 0, true);
        return serialize($exif);
    } catch (\Exception $e) {
        return null;
    }

    return null;
}


function getSchemeSector()
{
    return array(
        'pmu'  => __('PMU Level (Country)'),
        'ddlg' => __('DDLG Level (District)'),
        'df'   => __('DF Level (District)'),
        'ups'  => __('UPS Level (Union)'),
    );
}
/**
 * Training Zone.
 *
 * Training Zones defined by the LGSP-3.
 *
 * @return array Training Zones.
 */
function trainingZones()
{
    return array(
        'pmu_zone'           => __('PMU'),
        'division_zone'      => __('Division'),
        'district_zone'      => __('District'),
        'upazila_zone'       => __('Upazila'),
        'union_council_zone' => __('Union Council'),
    );
}

/**
 * Training Zone Label.
 *
 * @param string $zone Training Zone.
 *
 * @return string Training Zone.
 */
function trainingZoneLabel($zone)
{
    $zones = trainingZones();

    return $zones[$zone];
}

/**
 * Units.
 *
 * Units defined by the LGSP-3.
 *
 * @return array Units.
 */
function units()
{
    return array(
        'number'       => __('Number'),
        'meter'        => __('Meter'),
        'square_meter' => __('Square Meter'),
    );
}

/**
 * Unit Label.
 *
 * @param string $unit Unit.
 *
 * @return string Unit.
 */
function unitLabel($unit)
{
    $units = units();

    return $units[$unit];
}
/**
 * Scheme Status.
 *
 * Scheme Status defined by the LGSP-3.
 *
 * @return array Scheme Status.
 */
function schemeStatus($excludeId = null)
{
    $status = array(
        '1' => __('In process'),
        '2' => __('Running'),
        '3' => __('Done'),
        '4' => __('Not Applicable')
    );
    if (!empty($excludeId)) {
        unset($status[$excludeId]);
    }
    return $status;
}

/**
 * Scheme Status Label.
 *
 * @param string $statusId Scheme Status.
 *
 * @return int Scheme Statusid .
 */
function schemeStatusLabel($statusId)
{

    if (empty($statusId)) {
        return '';
    }

    $status = schemeStatus();

    return $status[$statusId];
}

/**
 * Scheme Procurement Process Type.
 *
 * Scheme Procurement Process Type defined by the LGSP-3.
 *
 * @return array Scheme Procurement Process Type.
 */
function procurementProcessType()
{
    return array(
        '1' => __('RFQ'),
        '2' => __('OTM'),
        '3' => __('Directly'),
        '4' => __('Community Procurement'),
        '5' => __('Need To Update')
    );
}
/**
 * Training Zone.
 *
 * Training Zones defined by the LGSP-3.
 *
 * @return array Training Zones.
 */
function getAccountHeadTypeLists()
{
    return array(
        1 => __('Income'),
        2 => __('Expense'),
        3 => __('Misc'),
        4 => __('Closing'),
    );
}

/**
 * Scheme procurement process Label.
 *
 * @param string $id Scheme procurement process id.
 *
 * @return int Scheme procurement process id.
 */
function procurementProcessLabel($id)
{
    if (empty($id)) {
        return '';
    }
    return procurementProcessType()[$id];
}

/**
 * Units.
 *
 * Units defined by the LGSP-3.
 *
 * @return array Units.
 */
function schemeUnits()
{
    return array(
        '1' => __('Meter'),
        '2' => __('Inch'),
        '3' => __('Feet'),
        '4' => __('Not Applicable')
    );
}

/**
 * Unit Label.
 *
 * @param string $unit Unit.
 *
 * @return int Unit.
 */
function schemeUnitLabel($unit)
{
    return schemeUnits()[$unit];
}
/* Head Label.
 *
 * @param string $headId Unit.
 *
 * @return string Head.
 */
function getHeadLabel($headId)
{
    $heads = getAccountHeadTypeLists();

    return $heads[$headId];
}

/**
 * Scheme safe guard community opinion.
 *
 * defined by the LGSP-3.
 *
 * @return array community opinion.
 */
function communityOpinion()
{
    return array(
        '1' => __('Satisfactory'),
        '2' => __('Moderate'),
        '3' => __('Unsatisfactory'),
    );
}

/**
 * safe guard community opinion Label.
 *
 * @param string $id community opinion id.
 *
 * @return int Opinion id
 */
function communityOpinionLabel($id)
{
    return communityOpinion()[$id];
}

function schemeSubSectorUnit()
{
    return ['1' => __('Number'), '2' => __('Length/Width'), '3' => __('Both')];
}


/**
 * Fundd type.
 *
 * defined by the LGSP-3.
 *
 * @return array Fund type.
 */
function fundType()
{
    return ['1' => __('Own Funds'), '2' => __('Development Fund'), '3' => __('Need To Update')];
}
/**
 * Fund Type Label.
 *
 * @param int $id fund type id.
 *
 */
function fundTypeLabel($id)
{
    return fundType()[$id];
}

/**
 * HR Categories.
 *
 * HR Categories defined by the LGSP-3.
 *
 * @return array Array of HR Categories.
 */
function hrCategories()
{
    return array(
        '1' => __('Assistant Office Manager (AOM)'),
        '2' => __('Individual Consultant'),
        '3' => __('District Facilitator (DF)'),
        '4' => __('Outsource')
    );
}

/**
 * HR Category Label.
 *
 * @param int $hrCategory HR Category.
 *
 * @return string HR Category Label.
 */
function hrCategoryLabel($hrCategory)
{
    return hrCategories()[$hrCategory];
}

/**
 * Communication Types.
 *
 * Defined communication types.
 *
 * @return array Array of Communication Types.
 */
function communicationTypes()
{
    return array(
        'phone'    => __('Phone'),
        'email'    => __('Email'),
        'meeting'  => __('Meeting'),
        'training' => __('Training')
    );
}

/**
 * Communication Type Label.
 *
 * @param string $communicationType Communication Type.
 *
 * @return string Communication Type Label.
 */
function communicationTypeLabel($communicationType)
{
    $communicationTypes = communicationTypes();

    return $communicationTypes[$communicationType];
}

/**
 * Safeguard Comment Status Status.
 *
 * Safeguard Comment Status defined by the LGSP-3.
 *
 * @return array Safeguard Comment Status.
 */
function safeguardCommentStatus($excludeId = null)
{
    $status = array(
        '1' => __('Major'),
        '2' => __('Minor'),
        '3' => __('Not Applicable')
    );
    if (!empty($excludeId)) {
        unset($status[$excludeId]);
    }
    return $status;
}

/**
 * Safeguard Comment Status Label.
 *
 * @param string $statusId Safeguard Comment Status.
 *
 * @return int Safeguard Comment Status Statusid .
 */
function safeguardCommentStatusLabel($statusId)
{
    if (empty($statusId)) {
        return '';
    };

    $status = safeguardCommentStatus();

    return $status[$statusId];
}

/**
 * Get YouTube Video Thumbnail.
 *
 * @param string $video_url YouTube Video URL.
 *
 * @return string Video thumbnail (Maximum Quality - Default).
 */
function getYoutubeVideoThumbnail($video_url)
{
    if (strpos($video_url, 'youtu.be/')) {
        $pieces = explode('youtu.be/', $video_url);
        $youtube_video_id = $pieces[1];
    } else {
        $query_string = parse_url($video_url, PHP_URL_QUERY);
        parse_str($query_string, $pieces);
        $youtube_video_id = $pieces['v'] ?? "";
    }

    return "https://img.youtube.com/vi/{$youtube_video_id}/mqdefault.jpg";
}


/**
 * Meeting Type.
 *
 * defined by the LGSP-3.
 *
 * @return array Meeting Type.
 */
function meetingType()
{
    return ['1' => __('Open Ward Meeting'), '2' => __('Open Budget Meeting')];
}
/**
 * Meeting Type. Label.
 *
 * @param int $id Meeting Type id.
 *
 */
function meetingTypeLabel($id)
{
    return meetingType()[$id];
}

function getTotalPendingScheme()
{
    $user       = Auth::user();
    $cache_key  = "scheme_pending_{$user->district_id}";
    $cache_time = 60 * 24 * 30; //30 days in minutes = minutes x hours x days

    if ($user->user_level == 'df' || $user->user_level == 'ddlg') {
        $values = Cache::remember(
            $cache_key,
            $cache_time,
            function () use ($user) {
                // Total Scheme Count
                $totalScheme = DB::table('schemes');
                $totalScheme = $totalScheme->leftJoin('districts', 'districts.id', '=', 'schemes.district_id');
                $totalScheme = $totalScheme->leftJoin('divisions', 'divisions.id', '=', 'districts.division_id');

                if (!empty($user->union_id)) {
                    // For UP User (Union Level)
                    $totalScheme = $totalScheme->where('schemes.district_id', $user->district_id);
                    $totalScheme = $totalScheme->where('schemes.upazilla_id', $user->upazila_id);
                    $totalScheme = $totalScheme->where('schemes.union_id', $user->union_id);
                } elseif (!empty($user->upazila_id)) {
                    // For UNO User (Upazila Level)
                    $totalScheme = $totalScheme->where('schemes.district_id', $user->district_id);
                    $totalScheme = $totalScheme->where('schemes.upazilla_id', $user->upazila_id);
                } elseif (!empty($user->district_id)) {
                    // For DF, DDLG and DC User (District Level)
                    $totalScheme = $totalScheme->where('schemes.district_id', $user->district_id);
                } elseif (!empty($user->division_id)) {
                    // For DivC User (Division Level)
                    $totalScheme = $totalScheme->where('districts.division_id', $user->division_id);
                }

                $totalScheme = $totalScheme->where('schemes.scheme_status', 3);
                $totalScheme = $totalScheme->count();

                // Total Scheme Count which scheme is approved
                $totalApproveScheme = DB::table('schemes');
                $totalApproveScheme = $totalApproveScheme->leftJoin('scheme_comment_approves AS cmnt', 'cmnt.scheme_id', '=', 'schemes.id');

                $totalApproveScheme = $totalApproveScheme->leftJoin('districts', 'districts.id', '=', 'schemes.district_id');
                $totalApproveScheme = $totalApproveScheme->leftJoin('divisions', 'divisions.id', '=', 'districts.division_id');

                if (!empty($user->union_id)) {
                    // For UP User (Union Level)
                    $totalApproveScheme = $totalApproveScheme->where('schemes.district_id', $user->district_id);
                    $totalApproveScheme = $totalApproveScheme->where('schemes.upazilla_id', $user->upazila_id);
                    $totalApproveScheme = $totalApproveScheme->where('schemes.union_id', $user->union_id);
                } elseif (!empty($user->upazila_id)) {
                    // For UNO User (Upazila Level)
                    $totalApproveScheme = $totalApproveScheme->where('schemes.district_id', $user->district_id);
                    $totalApproveScheme = $totalApproveScheme->where('schemes.upazilla_id', $user->upazila_id);
                } elseif (!empty($user->district_id)) {
                    // For DF, DDLG and DC User (District Level)
                    $totalApproveScheme = $totalApproveScheme->where('schemes.district_id', $user->district_id);
                } elseif (!empty($user->division_id)) {
                    // For DivC User (Division Level)
                    $totalApproveScheme = $totalApproveScheme->where('districts.division_id', $user->division_id);
                }

                $totalApproveScheme = $totalApproveScheme->where('schemes.scheme_status', 3);
                $totalApproveScheme = $totalApproveScheme->where('cmnt.is_approved', 1);
                $totalApproveScheme = $totalApproveScheme->count();

                // Total Pending Scheme
                $totalPendingScheme = $totalScheme - $totalApproveScheme;

                return $totalPendingScheme;
            }
        );

        return $values;
    }

    return 0;
}

function convertNumberToBengaliwords($number)
{
    /**
     * @ariful islam srabon
     * Function: convert_number
     *
     * Description:
     * Converts a given integer (in range [0..1T-1], inclusive) into
     * alphabetical format ("one", "two", etc.)
     * https://gist.github.com/techjewel/6645397
     * https://gitlab.com/arif-srabon/javascript/wikis/home
     * @int
     *
     * @return string
     *
     */

    $Koti = floor($number / 10000000); /* Koti */
    $number -= $Koti * 10000000;

    $lakh = floor($number / 100000); /* lakh */
    $number -= $lakh * 100000;

    $hajar = floor($number / 1000); /* Thousands (hajar) */
    $number -= $hajar * 1000;

    $Hn = floor($number / 100); /* Hundreds */
    $number -= $Hn * 100;

    $Dn = floor($number / 10); /* Tens (deca) */
    $n  = $number % 10; /* Ones */

    $res = "";

    if ($Koti) {
        $res .= convertNumberToBengaliwords($Koti) . " " . __('crore') . " ";
    }

    if ($lakh) {
        $res .= convertNumberToBengaliwords($lakh) . " " . __('lakh') . " ";
    }

    if ($hajar) {
        $res .= (empty($res) ? "" : " ") .
            convertNumberToBengaliwords($hajar) . " " . __('thousand') . " ";
    }

    if ($Hn) {
        $res .= (empty($res) ? "" : " ") .
            convertNumberToBengaliwords($Hn) . " " . __('hundred') . " ";
    }
    $words = array();

    if ('bn' == App::getLocale()) {
        $words = array(
            "", "এক",
            "দুই", "তিন", "চার", "পাঁচ", "ছয়", "সাত", "আট", "নয়", "দশ", "এগার", "বারো",
            "তের", "চৌদ্দ", "পনের", "ষোল", "সতের", "আঠার", "ঊনিশ", "বিশ", "একুশ", "বাইস",
            "তেইশ", "চব্বিশ", "পঁচিশ", "ছাব্বিশ", "সাতাশ", "আঠাশ", "ঊনত্রিশ", "ত্রিশ", "একত্রিস",
            "বত্রিশ", "তেত্রিশ", "চৌত্রিশ", "পঁয়ত্রি", "ছত্রিশ", "সাঁইত্রি", "আটত্রিশ", "ঊনচল্লিশ",
            "চল্লিশ", "একচল্লিশ", "বিয়াল্লিশ ", "তেতাল্লিশ ", "চুয়াল্লিশ ", "পঁয়তাল্লিশ", "ছেচল্লিশ ",
            "সাতচল্লিশ", "আটচল্লিশ", "ঊনপঞ্চাশ ", "পঞ্চাশ ", "একান্ন ", "বায়ান্ন ",
            "তিপ্পান্ন", "চুয়ান্ন ", "পঞ্চান্ন ", "ছাপ্পান্", "সাতান্ন", "আটান্ন", "ঊনষাট ", "ষাট ",
            "একষট্টি", "বাষট্টি", "তেষট্টি", "চৌষট্টি", "পঁয়ষট্টি", "ছেষট্টি", "সাতষট্টি", "আটষট্টি ",
            "ঊনসত্তর", "সত্তর", "একাত্তর ", "বাহাত্তর ", "তিয়াত্তর ", "চুয়াত্তর ", "পঁচাত্তর", "ছিয়াত্তর ",
            "সাতাত্তর", "আটাত্তর ", "ঊনআশি ", "আশি ", "একাশি ", "বিরাশি ", "তিরাশি ", "চুরাশি ", "পঁচাশি ",
            "ছিয়াশি ", "সাতাশি ", "আটাশি ", "ঊননব্বই ", "নব্বই ", "একানব্বই ", "বিরানব্বই ", "তিরানব্বই ",
            "চুরানব্বই ", "পঁচানব্বই ", "ছিয়ানব্বই", "সাতানব্বই", "আটানব্বই", "নিরানব্বই"
        );
    } else {
        $words = array(
            '', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ',
            'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen ', 'twenty ',
            'twenty one ', 'twenty two ', 'twenty three ', 'twenty four ', 'twenty five ', 'twenty six ', 'twenty seven ', 'twenty eight ', 'twenty nine ', 'thirty ',
            'thirty one ', 'thirty two ', 'thirty three ', 'thirty four ', 'thirty five ', 'thirty six ', 'thirty seven ', 'thirty eight ', 'thirty nine ', 'forty ',
            'forty one ', 'forty two ', 'forty three ', 'forty four ', 'forty five ', 'forty six ', 'forty seven ', 'forty eight ', 'forty nine ', 'fifty ',
            'fifty one ', 'fifty two ', 'fifty three ', 'fifty four ', 'fifty five ', 'fifty six ', 'fifty seven ', 'fifty eight ', 'fifty nine ', 'sixty ',
            'sixty one ', 'sixty two ', 'sixty three ', 'sixty four ', 'sixty five ', 'sixty six ', 'sixty seven ', 'sixty eight ', 'sixty nine ', 'seventy ',
            'seventy one ', 'seventy two ', 'seventy three ', 'seventy four ', 'seventy five ', 'seventy six ', 'seventy seven ', 'seventy eight ', 'seventy nine ', 'eighty ',
            'eighty one ', 'eighty two ', 'eighty three ', 'eighty four ', 'eighty five ', 'eighty six ', 'eighty seven ', 'eighty eight ', 'eighty nine ', 'ninety ',
            'ninety one ', 'ninety two ', 'ninety three ', 'ninety four ', 'ninety five ', 'ninety six ', 'ninety seven ', 'ninety eight ', 'ninety nine '
        );
    }


    if ($Dn || $n) {
        $index = $Dn * 10 + $n;
        $res .= $words[$index];
    }

    if (empty($res)) {
        $res = __('Zero');
    }

    return $res;
}

/**
 * Replace filter parameter(Division id, district id, upazilla id, union id)
 * with session parameter(Division id, district id, upazilla id, union id)
 *
 * @author Nazmul
 */
function resetUserLocationId($argument)
{
    $user = Auth::user();
    if (!empty($user->union_id)) {
        $argument['union_id'] = $user->union_id;
    }
    if (!empty($user->upazila_id)) {
        $argument['upazilla_id'] = $user->upazila_id;
    }
    if (!empty($user->district_id)) {
        $argument['district_id'] = $user->district_id;
    }
    if (!empty($user->division_id)) {
        $argument['division_id'] = $user->division_id;
    }
    return $argument;
}

/**
 * Remove URL Parameter.
 *
 * @param string $url   The URL to work on.
 * @param string $param Parameter to remove.
 *
 * @author kraftb
 * @link   https://stackoverflow.com/a/20049742/1743124
 *
 * @return string URL after removing parameter(s).
 */
function removeUrlParam($url, $param)
{
    $url = preg_replace('/(&|\?)' . preg_quote($param) . '=[^&]*$/', '', $url);
    $url = preg_replace('/(&|\?)' . preg_quote($param) . '=[^&]*&/', '$1', $url);
    return $url;
}

/**
 * FrontEnd Dashboard Filter URL.
 *
 * @param string $for Specific scope.
 *
 * @return string Stripped URL.
 */
function frontEndDashboardFilterUrl($for = '')
{
    // Grab URL with parameters.
    $url = url()->full();

    if ('home' === $for) {
        $url = removeUrlParam($url, 'division');
        $url = removeUrlParam($url, 'district');
        $url = removeUrlParam($url, 'upazila');
        $url = removeUrlParam($url, 'union');
    }

    if ('division' === $for) {
        $url = removeUrlParam($url, 'district');
        $url = removeUrlParam($url, 'upazila');
        $url = removeUrlParam($url, 'union');
    }

    if ('district' === $for) {
        $url = removeUrlParam($url, 'upazila');
        $url = removeUrlParam($url, 'union');
    }

    if ('upazila' === $for) {
        $url = removeUrlParam($url, 'union');
    }

    return $url;
}

/**
 * Add URL Parameter keeping valid params.
 *
 * @param string $for The scope.
 * @param integer $id Target ID.
 *
 * @return string URL String.
 */
function frontEndDashboardMaybeParameterizedUrl($for = '', $id = null)
{
    $fy         = abs(intval(Request::input('fy')));
    $divisionId = abs(intval(Request::input('division')));
    $districtId = abs(intval(Request::input('district')));
    $upazilaId  = abs(intval(Request::input('upazila')));

    $url = action('FrontEnd\DashboardController@index');

    $param = '';

    if ('division' === $for) {
        $param = "?division={$id}";
    }

    if ('district' === $for) {
        $param = "?division={$divisionId}&district={$id}";
    }

    if ('upazila' === $for) {
        $param = "?division={$divisionId}&district={$districtId}&upazila={$id}";
    }

    if ('union' === $for) {
        $param = "?division={$divisionId}&district={$districtId}&upazila={$upazilaId}&union={$id}";
    }

    if (!empty($fy)) {
        $param .= "&fy={$fy}";
    }

    return $url . $param;
}

/**
 * Priority List of Procurement Activities.
 *
 * Defined Priority.
 *
 * @return array Array of Priority.
 */
function priorityList()
{
    return array(
        'low'      => __('Low'),
        'medium'   => __('Medium'),
        'high'     => __('High'),
        'critical' => __('Critical'),
    );
}

/**
 * Priority Label of Procurement Activities.
 *
 * @param string $priority Priority.
 *
 * @return string Priority Label.
 */
function priorityLabel($priority)
{
    $priorityInfo = priorityList();

    return $priorityInfo[$priority];
}

/**
 * Activity Status List of Procurement Activities.
 *
 * Defined Activity Status.
 *
 * @return array Array of Activity Status.
 */
function activityStatusList()
{
    return array(
        'done'     => __('Done'),
        'pending'  => __('Pending'),
        'progress' => __('In Progress'),
        'cancel'   => __('Cancel'),
    );
}

/**
 * Activity Status Label of Procurement Activities.
 *
 * @param string $activityStatus Activity Status.
 *
 * @return string Activity Status Label.
 */
function activityStatusLabel($activityStatus)
{
    $activityStatusInfo = activityStatusList();

    return $activityStatusInfo[$activityStatus];
}

function concateValueToEachItemOfArray(array $arrayData, $concatItem)
{
    $message = "";
    foreach ($arrayData as $key => $value) {
        $message .= $concatItem . " " . $value . "\r\n"; //concatinate your existing array with new one
    }

    return $message;
}

/**
 * Exclude Financial Years
 *
 * Exclude financial years as per the defined scope
 *
 * @param string $scopeKey       Scope Key as defined in the options table.
 * @param object $financialYears Financial Years Laravel collection.
 */
function excludeFinancialYears($scopeKey, $financialYears)
{
    $fy = (array) getOption($scopeKey);

    foreach ($fy as $id) {
        $financialYears->forget((int) $id);
    }

    return $financialYears;
}

/**
 * NATP-2 Organization Code.
 *
 * Defined Organization Code.
 *
 * @return array Array of Organization Code.
 */
function getOrganizationCode()
{
    return array(
        'BARC'         => __('BARC'),
        'DAE'          => __('DAE'),
        'DOF'          => __('DOF'),
        'DLS'          => __('DLS'),
        'PMU'          => __('NATP2-PMU')
    );
}

/**
 * Organization Code Label.
 *
 * @param string $orgCode Organization Code.
 *
 * @return string Organization Code Label.
 */
function getOrganizationCodeLabel($orgCode)
{
    $organizationss = getOrganizationCode();

    return $organizationss[$orgCode];
}

/**
 * NATP-2 Office type.
 *
 * Defined Office type.
 *
 * @return array Array of Office type.
 */
function getOfficeType()
{
    return array(
        'pmu_office'              => __('PMU Office'),
        'regional_office'         => __('Regional Office'),
        'district_office'         => __('District Office'),
        'upazila_office'          => __('Upazila Office'),
        'union_office'            => __('Union Office')
    );
}

/**
 * NATP-2 Office type.
 *
 * Defined Office type.
 *
 * @return array Array of Office type.
 */
function getOfficeTypeLabel($officeType)
{
    return getOfficeType()[$officeType];
}


/**
 * NATP-2 Beneficiary Organization Type.
 *
 * Defined Beneficiary Organization Type.
 *
 * @return array Array of Beneficiary Organization Type.
 */
function getBeneficiaryOrganizationType()
{
    return array(
        'cig'                   => __('CIG'),
        'po'                    => __('PO'),
        'entrepreneur'          => __('Entrepreneur')
    );
}

/**
 * NATP-2 Beneficiary Organization Type.
 *
 * Defined Beneficiary Organization Type.
 *
 * @return array Array of Beneficiary Organization Type.
 */
function getBeneficiaryOrganizationTypeLabel($beneficiaryOrganizationType)
{
    return getBeneficiaryOrganizationType()[$beneficiaryOrganizationType];
}



/**
 * NATP-2 Fish Source Type.
 *
 * Defined Fish Source Type.
 *
 * @return array Array of Fish Source Type.
 */
function getFishSourceType()
{
    return array(
        'pond'                     => __('Pond'),
        'river'                    => __('River'),
        'beel_haor'                => __('Beel/Haor'),
        'sea'                      => __('Sea'),
    );
}

/**
 * NATP-2 Fish Source Type.
 *
 * Defined Fish Source Type.
 *
 * @return array Array of Fish Source Type.
 */
function getFishSourceTypeLabel($fishSourceType)
{
    return getFishSourceType()[$fishSourceType];
}

/**
 * NATP-2 Fish Culture Type.
 *
 * Defined Fish Culture Type.
 *
 * @return array Array of Fish Culture Type.
 */
function getFishCultureType()
{
    return array(
        'natural'                    => __('Natural'),
        'stocked'                    => __('Stocked'),
        'cultured'                   => __('Cultured')
    );
}

/**
 * NATP-2 Fish Culture Type.
 *
 * Defined Fish Culture Type.
 *
 * @return array Array of Fish Culture Type.
 */
function getFishCultureTypeLabel($fishCultureType)
{
    return getFishCultureType()[$fishCultureType];
}

/**
 * Religions.
 *
 * Defined religions.
 *
 * @return array Array of Religions.
 */
function religions()
{
    return array(
        'islam'     => __('Islam'),
        'hindu'     => __('Hindu'),
        'buddhist'  => __('Buddhist'),
        'christian' => __('Christian'),
        'other'     => __('Others')
    );
}

/**
 * Religion Label.
 *
 * @param string $religion Religion.
 *
 * @return string Religion Label.
 */
function religionLabel($religion)
{
    $religions = religions();

    return $religions[$religion];
}

function phaseNo()
{
    return [
        '1'   => __('1'),
        '2'   => __('2'),
        '3'     => __('3'),
        '4'     => __('4'),
        '5'     => __('5'),
        '6'     => __('6'),
        '7'     => __('7'),
        '8'     => __('8'),
        '9'     => __('9'),
        '10'     => __('10')
    ];
}

/**
 * Get CIG category.
 *
 * Defined cig category for monitoring module.
 *
 * @return array Array of CIG category.
 */
function cigCategory()
{
    return array(
        '1'     => __('Male'),
        '2'     => __('Female'),
        '3'  => __('Mix'),
    );
}

/**
 * Get CIG category by cig category index
 *
 */
function getCIGCategoryByIndex($category)
{
    return cigCategory()[$category];
}

/**
 * Get Organization (DoF, DAE, DLS) wise resource type.
 *
 * Defined resource type for monitoring module.
 *
 * @return array Array of Resource type.
 */
function getCIGMemberResourceType()
{
    switch (auth()->user()->organization_id) {
        case config('app.organization_id_dof'):
            return [config('app.organization_id_dof') => __('Pond')];
            break;
        case config('app.organization_id_dae'):
            return [config('app.organization_id_dae') => __('Land')];
            break;
        default:
            return [config('app.organization_id_dls') => __('Livestock')];
    }
}

function getCIGMemberResourceTypeNameById($resourceTypeId)
{
    return getCIGMemberResourceType()[$resourceTypeId];
}

/**
 * Get Organization (DoF, DAE, DLS) wise sub resource type.
 *
 * Defined sub resource type for monitoring module.
 *
 * @return array Array of sub Resource type.
 */
function getCIGMemberSubResourceType()
{
    switch (auth()->user()->organization_id) {
        case config('app.organization_id_dof'):
            return [
                '1' => __('Seasonal'),
                '2' => __('Perineal')
            ];
            break;
        case config('app.organization_id_dae'):
            return [];
            break;
        default:
            return [];
    }
}

function getCIGMemberSubResourceTypeNameById($subResourceTypeId)
{
    return getCIGMemberSubResourceType()[$subResourceTypeId];
}

/**
 * Get type of transaction in CIG account and transaction scope for Monitoring module
 */
function transactionType($transactionTypeId = null)
{
    $transactionTypes = array(
        '1'     => __('Opening'),
        '2'     => __('Deposit'),
        '3'  => __('Withdraw'),
    );

    if (!is_null($transactionTypeId)) {
        return $transactionTypes[$transactionTypeId];
    }

    return $transactionTypes;
}
/**
 * Caution : Don't Use this method
 * ===============================
 * Get type of deposite in CIG account and transaction scope for Monitoring module
 *
 * @depricated
 */
function depositType($depositTypeId = null)
{
    $depositTypeTypes = array(
        '1'     => __('Saving'),
        '2'     => __('Grant (AIF-2, AIF-3'),
        '3'  => __('Income (From Investment)'),
        '4'  => __('Widthdraw (Expenditure, Investment, Share)'),
        '5'  => __('Cash'),
    );

    if (!is_null($depositTypeId)) {
        return $depositTypeTypes[$depositTypeId];
    }

    return $depositTypeTypes;
}

/**
 * Get Pond number in CIG production scope for Monitoring module
 */
function pondNumber($pondNumberId = null)
{
    $pondNumbers = array(
        '1'   => __('1'),
        '2'   => __('2'),
        '3'     => __('3'),
        '4'     => __('4'),
        '5'     => __('5'),
        '6'     => __('6'),
        '7'     => __('7'),
        '8'     => __('8'),
        '9'     => __('9'),
        '10'     => __('10'),
    );

    if (!is_null($pondNumberId)) {
        return $pondNumbers[$pondNumberId];
    }

    return $pondNumbers;
}
/**
 * Get SAAO Gender.
 *
 * Defined saao gender for monitoring module.
 *
 * @return array Array of SAAO Gender.
 */

//  *Defined saao Educational Level for monitoring module.

function educationalLevel()
{
    return array(
        '1'     => __('Phd'),
        '2'     => __('Masters'),
        '3'     => __('Honours'),
        '4'     => __('HSC'),
        '5'     => __('SSC'),
        '6'     => __('Below SSC'),

    );
}

function saaoeducationalLevel($education)
{
    $educationalLevel = educationalLevel();
    if(!empty($education)){
        return $educationalLevel[$education];
    }
    return '';

}

/**
 * Get Input Types for DOF
 *
 */
function dofInputTypes(){
    $dofInputTypes  = array(
        'demonstration' => __('Demonstration'),
        'adapter'       => __('Adapter')
    );
    return $dofInputTypes;
}

/**
 * Get Input Type label
 *
 */
function getDofInputTypeLabels($inputTypeIndex)
{
    $inputTypes = dofInputTypes();

    if (!is_null($inputTypeIndex)) {
        return $inputTypes[$inputTypeIndex];
    }else{
        return "—";
    }


}

/**
 * Get Input Types for DOF
 *
 */
function dofTypes(){
    $dofTypes  = array(
        'cig'     => __('CIG'),
        'non-cig' => __('Non-CIG')
    );
    return  $dofTypes;
}

/**
 * Get Input Type label
 *
 */
function getDofTypeLabels($typeIndex)
{
    $types = dofTypes();

    if (!is_null($typeIndex)) {
        return $types[$typeIndex];
    }else{
        return "—";
    }
}

/**
 * Get grade wight in Indicator setup of Performance based evaluation scope for Monitoring module
 */
function unitGradeWeight($weight = null)
{
    $weights = array(
        '1'   => __('Poor'),
        '2'   => __('Average'),
        '3'     => __('Good'),
        '4'     => __('Very Good')
    );

    if (!is_null($weight)) {
        return $weights[$weight];
    }

    return $weights;
}

function cigMemberCategory($categoryId = null)
{
    $categories = array(
        '1'   => __('Landless'),
        '2'   => __('Marginal'),
        '3'     => __('Small'),
        '4'     => __('Medium'),
        '5'     => __('Large')
    );

    if (!is_null($categoryId)) {
        return $categories[$categoryId];
    }

    return $categories;
}

/**
 * Get grade for PO Seller info scope in monitoring module
 */
function poItemGrade($grade = null)
{
    $grades = array(
        '1'   => __('1'),
        '2'   => __('2'),
        '3'   => __('3'),
    );

    if (!is_null($grade)) {
        return $grades[$grade];
    }

    return $grades;
}

/**
 * Get code of AIF scope
 * Module: Monitoring
 */
function aifCode($code = null)
{
    $codes = array(
        'aif-2'   => __('AIF-2'),
        'aif-3'   => __('AIF-3')
    );

    if (!is_null($code)) {
        return $codes[$code];
    }

    return $codes;
}

/**
 * Get Eligible organization for AIF Fund type setup scope
 * Module: Monitoring
 */
function eligibleOrganizationType($orgTypeId = null)
{
    $organizationTpes = array(
        'cig'   => __('CIG'),
        'po'   => __('PO'),
        'enterpreneurs'   => __('Enterpreneurs'),
        'sao_leaf_ceal'   => __('SAAO/LEAF/CEAL')
    );

    if (!is_null($orgTypeId)) {
        return $organizationTpes[$orgTypeId];
    }

    return $organizationTpes;
}

/**
 * Get Units for Summary of project progress information
 * Module: Monitoring
 */
function summaryOfProjectProgressUnits($unitId = null)
{
    $units = array(
        '1'   => __('No.'),
        '2'   => __('Taka'),
        '3'   => __('Kg'),
        '4'   => __('Decimal')
    );

    if (!is_null($unitId)) {
        return $units[$unitId];
    }

    return $units;
}


 /**
 * Get Grievance redress Status
 * Module: Monitoring
 */
function getGrievanceRedreeStatus($status = null)
{

    $statusTpes = array(
        'forward'   => __('Forward'),
        'backward'  => __('Backward'),
        'resolve'   => __('Resolve'),
        'discard'   => __('Discard'),
    );

    if (!is_null($status)) {
        if($status == "ongoing"){
            return __('On Going');
        }else{
            return $statusTpes[$status];
        }


    }

    return $statusTpes;
}

/**
 * Get Response Type for AIF Impact Assessment Indicator setup scope
 * Module: Monitoring
 */
function indicatorResponseType($responseCode = null)
{
    $response = array(
        'text'   => __('Text'),
        'mcq'   => __('MCQ'),
        'number'   => __('Number'),
        'date'   => __('Date')
    );

    if (!is_null($responseCode)) {
        return $response[$responseCode];
    }

    return $response;
}

/**
 * Get Crop type
 *
 * @param int $cropTypeId
 * @return array list of crop types
 *
 * @Module Monitoring
 */
function cropType($cropTypeId = null)
{
    $cropTypes = array(
        '1'   => __('Crop'),
        '2'   => __('Vegetable'),
        '3'   => __('Fruits')
    );

    if (!is_null($cropTypeId)) {
        return $cropTypes[$cropTypeId];
    }

    return $cropTypes;
}

/**
 * Get Crop Life times
 *
 * @param int $cropLifetimeId
 * @return array list of crop life times
 *
 * @Module Monitoring
 */
function cropLifetime($cropLifetimeId = null)
{
    $cropLifetimes = array(
        '1'   => __('Annual'),
        '2'   => __('Biennial'),
        '3'   => __('Perennial'),
        '4'   => __('Seasona')
    );

    if (!is_null($cropLifetimeId)) {
        return $cropLifetimes[$cropLifetimeId];
    }

    return $cropLifetimes;
}

/**
 * Get Static indicator for AIF Impact Assessment Indicator configuration scope
 * Module: Monitoring
 */
function staticIndicator($key = null)
{
    $indicators = array(
        'division'   => __('Division'),
        'district'   => __('District'),
        'upazila'   => __('Upazila'),
        'union'   => __('Union'),
        'cig_name'   => __('Name of the CIG received AIF-2 fund'),
        'cig_village'   => __('Village'),   // CIG/Enterpreneur village or address
        'cig_regi_no'   => __('Registration number of the CIG'),
        'cig_total_member'   => __('Total number of members in the CIG'),
        'cig_total_female_member'   => __('Total number of female members in the CIG'),
        'cig_bank_acc'   => __('Bank account No'),
        'cig_bank_name'   => __('Name of the Bank'),
        'cig_bank_balance'   => __('Bank balance as on'),
        'alloc_prog_subproj_cost'   => __('Total cost of the sub-project (Tk)'),
        'alloc_fund_receiv'   => __('Total AIF-2 fund received (Tk)'),
        'alloc_prog_hired_mem_engage'   => __('Number of hired person engaged'),
        'alloc_prog_family_mem_engage'   => __('Number of family member engaged'),
        'alloc_prog_net_profit'   => __('Total net profit since operating (Tk)'),
        'alloc_prog_farmer_benefited'   => __('Total number of fish farmers benefited'),
        'alloc_prog_cigmem_benefited'   => __('Total number of CIG members benefited'),
        'name_of_po_ent_leaf'   => __('Name of Entrepreneur / PO/ LEAF received AIF-3 fund'),
        'source_of_own_fund'   => __('Source of own fund'),
        'trade_license_ent'   => __('Trade License of Entrepreneur'),
        'alloc_prog_total_cost'   => __('Total cost of operation and maintenance since operating (Tk)')
    );

    if (!is_null($key)) {
        return $indicators[$key];
    }

    return $indicators;
}

/**
 * Get Beel Baseline Setup Data
 * Module: Monitoring Beel Baseline
 */


function getExistenceOfCurrent($type = null)
{
    $existenceOfCurrent = array(
        '1'       => __('Year round'),
        '2'       => __('Less than 06 months'),
        '3'       => __('more than 06 months')
    );

    if (!is_null($type)) {
        return $existenceOfCurrent[$type];
    }

    return $existenceOfCurrent;
}


function getNatureOfTheBeelWaterBody($type = null)
{
    $natureOfTheBeelWaterBody = array(
        '1'       => __('Seasonal'),
        '2'       => __('Perennial')
    );

    if (!is_null($type)) {
        return $natureOfTheBeelWaterBody[$type];
    }

    return $natureOfTheBeelWaterBody;
}


function getLocationOfThePlace($type = null)
{
    $locationOfPlace = array(
        'east-side'    => __('East side'),
        'west-side'    => __('West side'),
        'north-side'   => __('North side'),
        'south-side'   => __('South side'),
        'middle'       => __('Middle')
    );

    if (!is_null($type)) {
        return $locationOfPlace[$type];
    }

    return $locationOfPlace;
}



function getImpactOnFishProduction($type = null)
{
    $impactList = array(
        '1'   => __('Increased'),
        '2'   => __('Decreased'),
        '3'   => __('Same as before')
    );

    if (!is_null($type)) {
        return $impactList[$type];
    }

    return $impactList;
}

function getPurposeForHabitatImprovement($type = null)
{
    $habitatImprovement = array(
        '1'   => __('Beel nursery pond'),
        '2'   => __('Fish sanctuary area'),
        '3'   => __('Others')
    );

    if (!is_null($type)) {
        return $habitatImprovement[$type];
    }

    return $habitatImprovement;
}



//=========================== Module: Training================================//


/**
 * Get Training Venue Type
 * Module: Training
 */
function getTrainingVenueType($venueType = null)
{
    $trainingVenueTypes = array(
        'residential'       => __('Residential'),
        'non-residential'   => __('Non-Residential')
    );

    if (!is_null($venueType)) {
        return $trainingVenueTypes[$venueType];
    }

    return $trainingVenueTypes;
}

/**
 * Get Trainee  Type
 * Module: Training
 */
function getTraineeType($traineeType = null)
{
    $traineeTypes = array(
        '1'       => __('CIG'),
        '2'   => __('CIG Leader'),
        '3'   => __('Nursery Operator'),
        '4'   => __('Hatchery Operator'),
        '5'   => __('LEAF'),
        '6'   => __('SEAL'),
        '7'   => __('SAO'),
    );

    if (!is_null($traineeType)) {
        return $traineeTypes[$traineeType];
    }

    return $traineeTypes;
}


/**
 * Get Trainee  Type
 * Module: Training
 */
function getTypeOfBeelDevelopmentActivity($devType = null)
{
    $beelDevTypes = array(
        'stocking'       => __('Indegenus Fish Fingerling stocking'),
        'nursery'   => __('Beel Nursery'),
        'santuary'   => __('Establishmen of Fish Santuary'),
        'habitat'   => __('Habitat Improvement'),
        'cbfm'   => __('Community based fisheries Management'),
        'gov'   => __('Govt. lease value'),
    );

    if (!is_null($devType)) {
        return $beelDevTypes[$devType];
    }

    return $beelDevTypes;
}




/**
 * Get Trainee  Type
 * Module: Training
 */
function getDevelopmentWork($developmentWork = null)
{
    $developmentWorks = array(
        '1'   => __('Re-Excavation'),
        '2'   => __('Construction On Embankment'),
        '3'   => __('Clearance Of Vegetation'),
    );

    if (!is_null($developmentWork)) {
        return $developmentWork[$developmentWork];
    }

    return $developmentWorks;
}

/**
 * Get Trainee  Type
 * Module: Training
 */
function getFishingMethod($fishingMethod = null)
{
    $fishingMethods = array(
        'katta fishing'   => __('Katta Fishing'),
        'other fishing'   => __('Other Fishing'),
        'both'   => __('Both'),
    );

    if (!is_null($fishingMethod)) {
        return $fishingMethod[$fishingMethod];
    }

    return $fishingMethods;
}


//=========================== Module: Inventory================================//

/**
 * Asset type for item information
 *
 * @param int $assetTypeId
 * @return array | string
 */
function getAssetType($assetTypeId = null)
{
    $assetTypes = array(
        '1'   => __('Fixed Asset'),
        '2'   => __('Accessories'),
        '3'   => __('Consumable/Moveable'),
    );

    if (!is_null($assetTypeId)) {
        return $assetTypes[$assetTypeId];
    }

    return $assetTypes;
}

/**
 * Item status information
 *
 * @param int $statusId
 * @return array | string
 */
function getItemStatus($statusId = null)
{
    $status = array(
        '1'   => __('Good'),
    );

    if (!is_null($statusId)) {
        return $status[$statusId];
    }

    return $status;
}
