<?php

namespace App\Http\Controllers\Settings;

use DB;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    /**
     * Minimum Requirements.
     *
     * Manadatory required requirements, without which the
     * application won't run, or won't run smooth.
     *
     * Laravel Requirements are as of Laravel 8
     * @link https://laravel.com/docs/8.x/upgrade#php-7.3.0-required
     *
     * @var array
     */
    public $minimumRequirements = array(
        'php_version'    => '7.3',
        'php_extensions' => array(
            'bcmath',
            'ctype',
            'json', // laravel/framework 8x dependency.
            'mbstring', // laravel/framework 8x dependency.
            'openssl', // laravel/framework 8x dependency.
            'PDO',
            'tokenizer',
            'xml', // laravel/framework 8x dependency. Also, maatwebsite/excel dependency.

            // Dependencies of maatwebsite/excel.
            'zip',
            'gd2',
            'iconv',
            'simplexml',
            'xmlreader',
            'zlib',
        ),
    );

    /**
     * Negligible Requirements.
     *
     * The following requirements are considered required, but
     * the absence of them is not causing any issue in our
     * application.
     *
     * ✋ VERY IMPORTANT ✋
     * In any subsequent test, if they cause any issue, the
     * item must need to be moved into the appropriate
     * position of the $minimumRequirements array.
     *
     * @var array
     */
    public $negligibleRequirements = array(
        'php_extensions' => array(
            // Dependencies of maatwebsite/excel.
            'gd2',
            'simplexml',
        )
    );

    /**
     * Upload Directories.
     *
     * Relative to /public/ path
     *
     * @var array
     * -----------------------------------------
     */
    public $uploadDirectories = array(
        'storage/uploads',
    );

    /**
     * Status Page.
     *
     * @return \Illuminate\Http\Response
     * -----------------------------------------
     */
    public function index()
    {
        $data = array();

        $data['minimumRequirements'] = $this->minimumRequirements;

        $data['debugStatus']             = $this->debugStatus();
        $data['mysqlVersion']            = $this->mySQLVersion();
        $data['missingPHPExtensions']    = $this->missingPHPExtensions();
        $data['negligiblePHPExtensions'] = $this->negligiblePHPExtensions();
        $data['uploadDirectoryStatus']   = $this->isDirectoryWritable();

        return view('settings.status')->with($data);
    }

    /**
     * Debug Status.
     *
     * @access private
     *
     * @return string
     * -----------------------------------------
     */
    private function debugStatus()
    {
        if (config('app.debug') == false) {
            return '<i class="icon-circle-small text-muted" aria-hidden="true"></i> '. __('Off');
        } else {
            return '<i class="icon-circle-small text-success" aria-hidden="true"></i> ' . __('On');
        }
    }

    /**
     * MySQL Version
     *
     * @link   https://stackoverflow.com/a/34536721/1743124
     * @author balping
     *
     * @access private
     *
     * @return string
     * -----------------------------------------
     */
    private function mySQLVersion()
    {
        $pdo = DB::connection()->getPdo();
        $version = $pdo->query('select version()')->fetchColumn();

        preg_match("/^[0-9\.]+/", $version, $match);

        $version = $match[0];

        return $version;
    }


    /**
     * Missing PHP Extensions.
     *
     * @access private
     *
     * @return array
     * -----------------------------------------
     */
    private function missingPHPExtensions()
    {
        $minimumRequirements = $this->minimumRequirements;
        $minimumExtensions   = $minimumRequirements['php_extensions'];

        $negligibleRequirements = $this->negligibleRequirements;
        $negligibleExtensions   = $negligibleRequirements['php_extensions'];

        $activeExtensions = get_loaded_extensions();

        $missingExtensions = array_diff($minimumExtensions, $activeExtensions); // Strip out active extensions.
        $missingExtensions = array_diff($missingExtensions, $negligibleExtensions); // Strip out negligible extensions.

        return $missingExtensions;
    }


    /**
     * Negligble PHP Extensions.
     *
     * @access private
     *
     * @return array
     * -----------------------------------------
     */
    private function negligiblePHPExtensions()
    {
        $negligibleRequirements = $this->negligibleRequirements;
        $negligibleExtensions   = $negligibleRequirements['php_extensions'];

        $activeExtensions = get_loaded_extensions();

        $missingExtensions = array_diff($negligibleExtensions, $activeExtensions); // Strip out active extensions.

        return $missingExtensions;
    }


    /**
     * Is Directory Writable?
     *
     * Return the directories and their writable statuses.
     *
     * @access private
     *
     * @return array
     * -----------------------------------------
     */
    private function isDirectoryWritable()
    {
        $uploadDirectories = $this->uploadDirectories;

        $directoryStatuses = array();
        foreach ($uploadDirectories as $path) {
            $directoryStatuses[$path] = is_writable(public_path($path));
        }

        return $directoryStatuses;
    }
}
