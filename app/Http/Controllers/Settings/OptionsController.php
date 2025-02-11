<?php

/**
 * Options Controller.
 * php version 7.1.3
 *
 * @category CMS/Admin
 * @package  LGSP3
 * @author   Mayeenul Islam <wz.islam@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */

namespace App\Http\Controllers\Settings;

use Session;
use Storage;
use DateTime;
use Illuminate\Http\Request;
use App\Models\Settings\Option;
use App\Http\Controllers\Controller;

/**
 * Options Controller.
 * php version 7.1.3
 *
 * @category CMS/Admin
 * @package  LGSP3
 * @author   Mayeenul Islam <wz.islam@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class OptionsController extends Controller
{
    private $options;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->options = new Option();
    }

    /**
     * Display the Options Page.
     *
     * @return json View for the options settings.
     * ---------------------------------------------------------------------
     */
    public function index()
    {
        $options = $this->options->get();

        $data = [];

        return view('settings.options.options', compact('options'))->with($data);
    }


    /**
     * Store the options data.
     *
     * @param \Illuminate\Http\Request $request Options request.
     *
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------
     */
    public function save(Request $request)
    {
        try {
            $inputs = $request->all();
            $inputs = $this->solveEmptyKeys($inputs);
            // Save all the fields one by one.
            $this->options->updateAllOptions($inputs);

            Session::flash('success', 'Updated Successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(array('Something went wrong'))
                ->withInput($request->all);
        }
    }


    /**
     * Solve empty keys.
     *
     * - Select Multiple
     * - Checkbox Input
     *
     * The method is to solve a bug identified that, select multiple and
     * input type checkbox doesn't send any field key into $REQUEST,
     * hence we're putting their empty values on their behalf.
     *
     * Developer have to mention each of their such field's key into the
     * respective array inside the method to solve the issue.
     *
     * @param array $inputs Array of inputs.
     *
     * @see https://gitlab.com/technovistaltd/IKMS_ILO/issues/278
     *
     * @return array        Pushed empty keys into array of inputs.
     * ---------------------------------------------------------------------
     */
    private function solveEmptyKeys($inputs)
    {
        $emptyCheckboxes = [
            'is_register_open',
            // 'checkbox_field_name',
        ];

        $emptySelectMultiples = [
            // 'select_multiple_field_name',
        ];

        foreach ($emptyCheckboxes as $key) {
            if (!isset($inputs[$key])) {
                $inputs[$key] = '0'; //string is important as we're fetching string from db
            }
        }

        foreach ($emptySelectMultiples as $key) {
            if (!isset($inputs[$key])) {
                $inputs[$key] = array();
            }
        }

        return $inputs;
    }


    /**
     * Backup Directories.
     *
     * Define all the directories that are to be backed up.
     *
     * @access private
     *
     * @return array Array of directory information.
     * ---------------------------------------------------------------------
     */
    private function backupDirectories()
    {
        // TODO VistaCMS Framework Update Required.
        return array(
            'uploads'  => array(
                'path'  => '/storage/uploads/',
                'label' => __('Uploads'),
            ),
        );
    }


    /**
     * Back up the Site's content.
     *
     * @return void
     * ---------------------------------------------------------------------
     */
    public function backup()
    {
        $data = [];

        $storage_path = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $storage_path = rtrim($storage_path, '/\\'); // untrailingSlahIt
        $backup_path  = "{$storage_path}/public/backups/";

        // Create the backup directory if not exists.
        if (!is_dir($backup_path)) {
            mkdir($backup_path, 0777, true);
        }

        // Scan for all the backups in the backup directory.
        $files = scandir($backup_path);
        // Remove unwanted glitches.
        $files = array_diff($files, ['.', '..']);
        // Make it a LIFO list.
        rsort($files);

        $data['files'] = $files;

        return view('settings.backup.index')->with($data);
    }

    /**
     * Back up the Site's content.
     *
     * Backup
     *  - photos
     *  - files
     *  - database
     *
     * @param Request $request Options request.
     *
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------
     */
    public function createBackup(Request $request)
    {
        $_error      = array();
        $_success    = array();
        $_redirect   = redirect()->back();

        $last_backup = getOption('_last_backup');
        $time_now    = new DateTime('now');

        if (!empty($last_backup)) {
            $since_last_backup  = $time_now->diff(new DateTime($last_backup));
            $backup_window      = 10; // in minutes
            $next_backup_winodw = $backup_window - $since_last_backup->i;

            if ($since_last_backup->i < $backup_window) {
                return $_redirect->withErrors(trans_choice(__('You can&rsquo;t run backup too frequently. Your next backup window will resume in <strong>:time minute</strong>.|You can&rsquo;t run backup too frequently. Your next backup window will resume in <strong>:time minutes</strong>.', ['time' => $next_backup_winodw]), $next_backup_winodw));
            }
        }

        $public_path  = public_path();
        $storage_path = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $storage_path = rtrim($storage_path, '/\\'); // untrailingSlahIt

        $datetime     = date('Ymd-His');

        foreach ($this->backupDirectories() as $key => $directory) {
            $_public_path      = $public_path . $directory['path'];
            $_directory_backup = createZip($_public_path, "{$storage_path}/public/backups/{$datetime}-{$key}.zip");

            if (false == $_directory_backup) {
                $_error["{$key}_error"] = __(':directory directory could not be backed up', ['directory' => $directory['label']]);
            } else {
                $_success["{$key}_success"] = __('Backup of :directory directory created successfully', ['directory' => $directory['label']]);
            }
        }

        $mysqldump_path = hasMySQLDump();
        $hasGZip        = hasGZip();
        if (false === $mysqldump_path) {
            $mysql_backup_status = 0;
        } else {
            $database = env('DB_DATABASE');
            $user     = env('DB_USERNAME');
            $pass     = env('DB_PASSWORD');
            $host     = env('DB_HOST');
            $dir_file = "{$storage_path}/public/backups/{$datetime}-database.sql";
            if ($hasGZip) {
                $dir_file .= ".gzip";
            }

            // escape unwanted shell command
            $mysqldump = escapeshellarg($mysqldump_path);

            if ($hasGZip) {
                $backup_cmd = "{$mysqldump} --user={$user} --password={$pass} --host={$host} {$database} | gzip > {$dir_file}";
            } else {
                $backup_cmd = "{$mysqldump} --user={$user} --password={$pass} --host={$host} {$database} > {$dir_file}";
            }

            // Run the command and take the backup.
            exec($backup_cmd, $output, $mysql_backup_status);
        }

        if ($mysql_backup_status !== 0) {
            $_error['db_error'] = __('Database could not be backed up');
        } else {
            $_success['db_success'] = __('Backup of Database created successfully');
        }

        if (!empty($_error)) {
            $_redirect = $_redirect->withErrors($_error);
        }
        if (!empty($_success)) {
            Session::flash('success', $_success);
            // Record the backup time to prohibit frequent use.
            updateOption('_last_backup', date('Y-m-d H:i:s'));
        }

        return $_redirect;
    }


    /**
     * Download the Backup.
     *
     * Download the Backup file individually.
     *
     * @param string $file File to download.
     *
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------
     */
    public function downloadBackup($file = null)
    {
        return response()->download(storage_path("app/public/backups/{$file}"));
    }

    /**
     * Delete/Unlink the Backup file.
     *
     * Delete Backup file individually.
     *
     * @param string $file File to delete.
     *
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------
     */
    public function deleteBackup($file)
    {
        $storage_path = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $storage_path = rtrim($storage_path, '/\\'); // untrailingSlahIt
        $storage_path = "{$storage_path}/public/backups/";

        $the_file = $storage_path . $file;

        // For UX, regarding error/success message.
        $year     = substr($file, 0, 4);
        $month    = substr($file, 4, 2);
        $day      = substr($file, 6, 2);
        $hour     = substr($file, 9, 2);
        $minute   = substr($file, 11, 2);
        $second   = substr($file, 13, 2);
        $datetime = "{$year}-{$month}-{$day} {$hour}:{$minute}:{$second}";
        $filename = substr($file, 16);

        // Delete the file.
        if (!unlink($the_file)) {
            return redirect()->back()->withErrors(__('Backup file <strong>:filename</strong> of <strong>:date</strong> could not be deleted', ['filename' => $filename, 'date' => displayDateTime($datetime, 'd F Y h:i A')]));
        } else {
            Session::flash('success', __('Backup file <strong>:filename</strong> of <strong>:date</strong> deleted Successfully!', ['filename' => $filename, 'date' => displayDateTime($datetime, 'd F Y h:i A')]));
        }

        return redirect()->back();
    }


    /**
     * Delete/Unlink all the Backup files.
     *
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------
     */
    public function deleteAllBackup()
    {
        $storage_path = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $storage_path = rtrim($storage_path, '/\\'); // untrailingSlahIt
        $storage_path = "{$storage_path}/public/backups";

        // get all files
        $files = glob("{$storage_path}/*");
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }

        // Delete last backup's trace.
        // Let the user create new backup at once.
        deleteOption('_last_backup');

        Session::flash('success', __('All the backup files deleted Successfully!'));

        return redirect()->back();
    }


    /**
     * Save mysqldump path.
     *
     * Used if there's no valid path detected to run mysqldump command.
     *
     * @param Request $request HTTP request.
     *
     * @return \Illuminate\Http\Response
     * ---------------------------------------------------------------------
     */
    public function saveMysql(Request $request)
    {

        $inputs = $request->all();

        if (empty($inputs['_path_to_mysqld'])) {
            deleteOption('_path_to_mysqld');
        } else {
            updateOption('_path_to_mysqld', $inputs['_path_to_mysqld']);
        }

        return redirect()->back();
    }
}
