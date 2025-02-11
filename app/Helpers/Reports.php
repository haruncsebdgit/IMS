<?php

namespace App\Helpers;

use PDF;

/**
 * Report Helper Class.
 * php version 7.1.3
 *
 * @category Application/Helpers
 * @package  LGSP3
 * @author   Mayeenul Islam <wz.islam@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class Reports
{
    /**
     * Report Modes.
     *
     * Mention the modes of reports.
     * Mention their respective icons and labels too.
     *
     * @return array
     * --------------------------------------------------
     */
    public static function modes()
    {
        $preview_mode = array(
            'preview' => array(
                'icon'  => 'icon-eye8',
                'label' => __('Preview')
            )
        );

        $export_modes = array(
            'pdf'     => array(
                'icon'    => 'icon-file-pdf',
                'label'   => __('Export as PDF'),
                'acronym' => __('Portable Document Format (Extension: .pdf)')
            ),
            'xls'    => array(
                'icon'    => 'icon-file-excel',
                'label'   => __('Export as XLS'),
                'acronym' => __('Microsoft Excel Spreadsheet (Extension: .xls)')
            ),
            'doc'    => array(
                'icon'    => 'icon-file-word',
                'label'   => __('Export as DOC'),
                'acronym' => __('Microsoft Word document  (Extension: .doc)')
            ),
            'print'   => array(
                'icon'  => 'icon-printer2',
                'label' => __('Print')
            )
        );

        $modes = array_merge($preview_mode, $export_modes);

        return $modes;
    }


    /**
     * Manage Report Layouts.
     *
     * @param string $mode Report Mode.
     *
     * @return string Designated Template String.
     * --------------------------------------------------
     */
    public static function manageLayout($mode)
    {
        if ('preview' === $mode) {
            return 'layouts.report-preview';
        } else {
            return 'layouts.report-export';
        }
    }

    /**
     * Report Index.
     *
     * @param string $template Report Index Template.
     * @param array  $data     Report Data Array.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public static function indexMaster($template, $data = array())
    {
        $defaults = array(
            'modes'  => self::modes(),
            'layout' => self::manageLayout('preview')
        );

        $info = parseArguments($data, $defaults);

        echo view($template)->with($info);
    }


    /**
     * Report Result View.
     *
     * Defaults:
     * @param string $template Report Result Template.
     * @param array  $inputs   Parameter Form Data.
     * @param array  $data     Report Data Array.
     *
     * The default parameters can be overridden from
     * the implementing methods, by keeping the same
     * key-value pair.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public static function showMaster($template, $inputs, $data = array())
    {
        $defaults = array(
            'mode'   => $inputs['mode'],
            'layout' => self::manageLayout($inputs['mode'])
        );

        $info = parseArguments($data, $defaults);

        // Set the filename, and set fallback.
        $filename = $inputs['mode'];

        if (isset($info['filename'])) {
            $filename = self::sanitizeFileName($info['filename']);
            $filename = $inputs['mode'] .'-'. $filename;
        }

        switch ($inputs['mode']) {
            case 'pdf':
                self::exportPDF($template, $info, $filename);
                break;
            case 'xls':
                self::exportXLS($template, $info, $filename);
                break;
            case 'doc':
                self::exportDOC($template, $info, $filename);
                break;
            case 'print':
                self::print($template, $info);
                break;
            case 'preview':
            default:
                echo view($template)->with($info);
                break;
        }
    }


    /**
     * Export Report as a Doc file.
     *
     * @param string $template Template file path.
     * @param array  $data     Array of data to be passed.
     * @param string $filename (Optional) additional filename for the exported files.
     *
     * @see self::makeFilename()
     *
     * @return void
     * --------------------------------------------------
     */
    private static function exportDOC($template, $data, $filename = '')
    {
        $file = self::makeFilename($filename, 'doc');

        header('Content-type: application/vnd.ms-word');
        header("Content-Disposition: attachment;Filename=$file");

        echo view($template)->with($data);
    }


    /**
     * Generate the PDF Report.
     *
     * @param string $template Template file path.
     * @param array  $data     Array of data to be passed.
     * @param string $filename (Optional) additional filename for the exported files.
     *
     * In the $data parameter the following keys are acceptable. See the link below for
     * the official documentaion of mPDF:
     *
     *  - 'config'     array Array of configuration information. Default: empty array.
     *
     * @link: https://mpdf.github.io/getting-started/creating-your-first-file.html
     *
     * @access private
     *
     * @see self::makeFilename()
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    private static function exportPDF($template, $data, $filename = '')
    {
        $file = self::makeFilename($filename, 'pdf');

        // See the official method for more insights:
        // https://mpdf.github.io/getting-started/creating-your-first-file.html
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $config = [
            'fontDir' => array_merge($fontDirs, config('mpdf.font_path')),
            'fontdata' => $fontData + config('mpdf.font_data'),
            //'default_font' => 'bangla',
            'mode' => config('mpdf.mode'),
            'tempDir' => config('mpdf.tempDir'),  // Enable this line in live linux server
            'format' => config('mpdf.format')
        ];

        if(!empty($data['config'])) {
            $config     = array_merge($config, $data['config']);
        }
        $pdf = new \Mpdf\Mpdf($config);
        if(ob_get_length() > 0) {
            ob_clean();
        }
        ob_start();
        $contents = \View::make($template)->with($data);
        $stylesheet = '<style>' . asset('css/admin.css') . '</style>';
        // Apply External CSS
        $pdf->WriteHTML($stylesheet, 1);

        $pdf->WriteHTML($contents);  // write the HTML into the PDF
        // Here, I for "inline" to send the PDF to the Browser, opposed to F to Save it as a File and Download it D
        $pdf->Output($file, "I"); // Save to file because we can
        ob_end_flush();
    }


    /**
     * Generate the XLS Report.
     *
     * @param string $template Template file path.
     * @param array  $data     Array of data to be passed.
     * @param string $filename (Optional) additional filename for the exported files.
     *
     * @access private
     *
     * @see self::makeFilename()
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    private static function exportXLS($template, $data, $filename = '')
    {
        $file = self::makeFilename($filename, 'xls');

        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename={$file}");

        echo view($template)->with($data);
    }


    /**
     * Print Report.
     *
     * @param string $template Template path.
     * @param array  $data     Data array.
     *
     * @access private
     *
     * @return void
     * --------------------------------------------------
     */
    private static function print($template, $data)
    {
        $contents = \View::make($template)->with($data);

        echo $contents;
    }


    /**
     * Sanitize Filename.
     *
     * @param string $filename Developer input for filename.
     *
     * @access private
     *
     * @link https://stackoverflow.com/a/11330527/1743124
     *
     * @return string           Sanitized filename.
     * --------------------------------------------------
     */
    private static function sanitizeFileName($filename)
    {
        // Remove extra white spaces, and make lowercase.
        $string = trim(strtolower($filename));
        // Make alphanumeric (removes all other characters).
        $string = preg_replace('/[^a-z0-9_\s-]/', '', $string);
        // Clean up multiple dashes or whitespaces.
        $string = preg_replace('/[\s-]+/', ' ', $string);
        // Convert whitespaces and underscore to dash.
        $string = preg_replace('/[\s_]/', '-', $string);

        return $string;
    }

    /**
     * Make Filename.
     *
     * @param string $filename  Filename string.
     * @param string $extension Extension string.
     *
     * @access private
     *
     * @return string
     * --------------------------------------------------
     */
    private static function makeFilename($filename, $extension)
    {
        $datetimenow = date('Y-m-d-His');

        if (!empty($filename)) {
            return "{$filename}-{$datetimenow}.{$extension}";
        }

        return "{$datetimenow}.{$extension}";
    }

    /**
     * Generate Toggle Columns HTML.
     *
     * @param array $array Array of fields with respective labels.
     *
     * @return mixed       HTML code
     * --------------------------------------------------
     */
    public static function generateToggleColumns($array)
    {
        echo '<div class="btn-group-toggle p-2" data-toggle="buttons">';
        foreach ($array as $field => $label) {
            echo '<label class="btn-checkbox btn btn-outline-info btn-sm active mr-1 mb-1">';
                echo '<input type="checkbox" name="columns['. $field .']" checked> '. $label;
            echo '</label>';
        }
        echo '</div>';
    }

    /**
     * Report: Check Visible Column.
     *
     * @param string $field   Field to be checked.
     * @param array  $columns All the columns.
     *
     * @return boolean        True if checked, false otherwise.
     * --------------------------------------------------
     */
    public static function isColumnChecked($field, $columns)
    {
        if (array_key_exists($field, $columns)) {
            return true;
        }
        return false;
    }
}
