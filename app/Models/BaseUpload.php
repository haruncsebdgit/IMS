<?php

namespace App\Models;

use DB;
use Cache;
use Image; //Intervention Image
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; //Laravel Filesystem

/**
 * BaseUpload Model Class.
 *
 * @category CMS
 * @package  Vista_CMS
 * @author   Mayeenul Islam <wz.islam@gmail.com>
 * @author   Mowshana Farhana <mowshana.farhana@technovista.com.bd>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class BaseUpload extends Model
{
    public $image_path;
    public $image_medium_path;
    public $image_thumb_path;

    public $file_path;

    protected $table = 'uploads';

    protected $fillable = [
        'file',
        'mime_type',
        'title_en',
        'title_bn',

        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->image_path        = storage_path('app/public/uploads/images/');
        $this->image_medium_path = storage_path('app/public/uploads/images/medium/');
        $this->image_thumb_path  = storage_path('app/public/uploads/images/thumbnail/');
        $this->file_path         = storage_path('app/public/uploads/files/');
    }

    /**
     * Get Uploads Information.
     *
     * @param array $args Array of arguments.
     *
     * @return object Object of fetch uploads otherwise null.
     */
    public static function getUploadsInfo($args = array())
    {
        $defaults = array(
            'exclude'           => array(),
            'title'             => null,
            'mime_type'         => null, // array
            'created_date_from' => null,
            'created_date_to'   => null,
            'author'            => null, // int|array
            'order'             => array(
                'uploads.id'       => 'desc',
                'uploads.title_en' => 'asc'
            ),
            'items_per_page'    => -1,
            'paginate'          => false, // ignored, if 'items_per_page' = -1
        );

        $arguments = parseArguments($args, $defaults);

        $uploadsInfo = DB::table('uploads');

        $uploadsInfo = $uploadsInfo->select(
            'uploads.*'
        );

        if (!empty($arguments['exclude'])) {
            $uploadsInfo = $uploadsInfo->whereNotIn('uploads.id', $arguments['exclude']);
        }

        if (!empty($arguments['title'])) {
            $search_query = $arguments['title'];

            $uploadsInfo = $uploadsInfo->where(
                function ($uploadsInfo) use ($search_query) {
                    $uploadsInfo->where('uploads.title_en', 'LIKE', "%$search_query%");
                    $uploadsInfo->orWhere('uploads.title_bn', 'LIKE', "%$search_query%");
                    $uploadsInfo->orWhere('uploads.file', 'LIKE', "%$search_query%");
                }
            );
        }

        if (!empty($arguments['mime_type'])) {
            if (is_array($arguments['mime_type'])) {
                $uploadsInfo = $uploadsInfo->whereIn('uploads.mime_type', $arguments['mime_type']);
            } else {
                $uploadsInfo = $uploadsInfo->where('uploads.mime_type', $arguments['mime_type']);
            }
        }

        // Created Date
        if (!empty($arguments['created_date_from'])) {
            $createdDateForm = date("Y-m-d", strtotime($arguments['created_date_from']));
        }

        if (!empty($arguments['created_date_to'])) {
            $createdDateTo = date("Y-m-d", strtotime($arguments['created_date_to']));
        }

        if (!empty($arguments['created_date_from']) && empty($arguments['created_date_to'])) {
            $uploadsInfo = $uploadsInfo->where('uploads.created_at', '>=', $createdDateForm);
        }
        // Only 'To' Date is Set
        if ($arguments['created_date_from'] == null && $arguments['created_date_to'] != null) {
            $uploadsInfo = $uploadsInfo->where('uploads.created_at', '<=', $createdDateTo);
        }
        if (!empty($arguments['created_date_from']) && !empty($arguments['created_date_to'])) {
            $uploadsInfo = $uploadsInfo->whereBetween('uploads.created_at', [$createdDateForm, $createdDateTo]);
        }

        if (!empty($arguments['author'])) {
            if (is_array($arguments['author'])) {
                $uploadsInfo = $uploadsInfo->whereIn('uploads.created_by', $arguments['author']);
            } else {
                $uploadsInfo = $uploadsInfo->where('uploads.created_by', $arguments['author']);
            }
        }

        foreach ($arguments['order'] as $orderBy => $order) {
            $uploadsInfo = $uploadsInfo->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $uploadsInfo = $uploadsInfo->get();
        } else {
            if (true == $arguments['paginate']) {
                $uploadsInfo = $uploadsInfo->paginate(intval($arguments['items_per_page']));
            } else {
                $uploadsInfo = $uploadsInfo->take(intval($arguments['items_per_page']));
                $uploadsInfo = $uploadsInfo->get();
            }
        }

        return $uploadsInfo;
    }

    /**
     * Localize Upload Data.
     *
     * An interim method to localize upload data where applicable.
     *
     * @param Object $uploadsInfo Upload object.
     *
     * @return Object mixed
     */
    public static function localizeUploadData($uploadsInfo)
    {
        if (config('app.locale') !== config('app.fallback_locale')) {
            $app_locale = config('app.locale');
        } else {
            $app_locale = config('app.locale');
        }

        $column_title = "title_{$app_locale}";

        $title = $uploadsInfo->$column_title;

        //Check and set overwrite value
        $uploadsInfo->title = empty($title) ? $uploadsInfo->title_en : $title;

        return $uploadsInfo;
    }

    /**
     * Get Upload Data by ID.
     *
     * @param string $upload_id Upload ID.
     *
     * @return object           Upload Object.
     */
    public static function getUploadDataById($upload_id)
    {
        // Cache time.
        $cacheTime = 2592000; // Seconds (60 seconds x 60 min x 24 hr x 30 = 30 days).

        $cacheKey = "uploads_{$upload_id}";

        return Cache::remember(
            $cacheKey,
            $cacheTime,
            function () use ($upload_id) {
                return self::where('id', $upload_id)->first();
            }
        );
    }

    /**
     * Get Upload title.
     *
     * @param integer $upload_id Upload ID.
     *
     * @return mixed|string
     */
    public static function getUploadTitle($upload_id)
    {
        $uploadData = self::getUploadDataById($upload_id);

        if (empty($uploadData)) {
            return false;
        }

        // Localize Upload Data if applicable.
        $uploadData = self::localizeUploadData($uploadData);

        return $uploadData->title;
    }


    /**
     * Get Upload Author Information.
     *
     * @param integer $user_id Upload author id.
     *
     * @return object          Upload author object.
     */
    public function getUploadAuthor($user_id)
    {
        $user_id = intval($user_id);

        return DB::table('users')->where('id', $user_id)->first();
    }

    /**
     * Get Upload File Icon Information.
     *
     * @param string $mime_type Upload mime type.
     *
     * @return object           Upload File Icon object.
     */
    public static function getFileIcon($mime_type)
    {
        switch ($mime_type) {
            case 'image/jpeg':
            case 'image/gif':
            case 'image/png':
            case 'image/tiff':
            case 'image/webp':
            case 'image/svg+xml':
                $icon = 'icon-file-picture';
                break;

            case 'application/pdf':
                $icon = 'icon-file-pdf';
                break;

            case 'application/msword':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                $icon = 'icon-file-word';
                break;

            case 'application/vnd.ms-excel':
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                $icon = 'icon-file-excel';
                break;

            case 'application/vnd.ms-powerpoint':
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                $icon = 'icon-file-presentation';
                break;

            case 'application/zip':
                $icon = 'icon-file-zip';
                break;
                break;

            case 'application/octet-stream':
                $icon = 'icon-map';
                break;
                break;

            case 'application/vnd.google-earth.kml+xml':
            case 'application/gpx+xml':
                $icon = 'icon-file-xml';
                break;

            case 'audio/mp4':
            case 'audio/ogg':
            case 'audio/mpeg':
            case 'audio/x-wav':
            case 'audio/x-ms-wma':
            case 'audio/webm':
                $icon = 'icon-file-play';
                break;

            case 'video/mp4':
            case 'application/mp4':
            case 'video/ogg':
            case 'application/ogg':
            case 'video/mpeg':
            case 'video/webm':
                $icon = 'icon-file-video';
                break;

            default:
                $icon = 'icon-file-empty';
                break;
        }

        return $icon;
    }

    /**
     * Get All MIME Types.
     *
     * @return array MIME types.
     */
    public function getMimeTypesFromUploadedFiles()
    {
        $mimeTypeList = DB::table('uploads')
            ->pluck('uploads.mime_type')->toArray();

        $mimeTypes = $this->mimeTypes();
        $_array    = array();

        foreach ($mimeTypes as $extension => $mimeType) {
            if (in_array($mimeType, $mimeTypeList)) {
                $_array[$extension] = $mimeType;
            }
        }

        return $_array;
    }

    /**
     * Image MIME Types.
     *
     * @return array MIME types for image.
     */
    public static function imageMimeTypes()
    {
        $image_mime_types = array(
            'image/jpeg',
            'image/gif',
            'image/png',
            'image/x-ms-bmp',
            'image/tiff'
        );

        return $image_mime_types;
    }

    /**
     * Media MIME Types.
     *
     * @return array MIME types for media.
     */
    public static function mediaMimeTypes()
    {
        return array(
            'audio/mp4',
            'video/mp4',
            'application/mp4',
            'audio/ogg',
            'video/ogg',
            'application/ogg',
            'audio/mpeg',
            'audio/x-wav',
            'audio/x-ms-wma',
            'audio/webm',
            'video/webm'
        );
    }

    /**
     * Get the MIME_TYPE from file Extension.
     *
     * Returns the MIME type of a file based on its file extension.
     *
     * @param string $fileExtension File extension.
     *
     * @return string               MIME type.
     */
    public static function mimeTypeFromExtension($fileExtension)
    {
        //default
        $mime = $fileExtension;

        $mimeTypesMap = self::mimeTypes();

        if (array_key_exists($fileExtension, $mimeTypesMap)) {
            $mime = $mimeTypesMap[$fileExtension];
        }

        return $mime;
    }

    /**
     * MIME types from Extensions.
     *
     * @param string $fileExtensions Comma separated string of file extensions.
     *
     * @return array                 MIME types for allowed file types.
     */
    public static function mimeTypesFromExtensions($fileExtensions)
    {
        //Specifies where to break the string
        $fileTypes = explode(',', $fileExtensions);

        $mimeTypes = array();

        foreach ($fileTypes as $fileExtension) {
            //Strip out whitespaces, if any.
            $fileExtension = preg_replace('/\s+/', '', $fileExtension);

            //Strip out dots, if any.
            $fileExtension = strtr($fileExtension, array('.' => ''));

            //Get MIME TYPE
            $mimeTypes[$fileExtension] = self::mimeTypeFromExtension($fileExtension);
        }

        return $mimeTypes;
    }

    /**
     * Change bytes to megabytes.
     *
     * @param integer $bytes       Bytes.
     * @param boolean $round       Boolean Value
     * @param integer $roundTo     Bytes.
     * @param integer $roundMethod Round halves up.
     *
     * @return integer Megabytes.
     */
    public static function bytesToMb($bytes, $round = false, $roundTo = 2, $roundMethod = PHP_ROUND_HALF_UP)
    {
        $megaByteValue = ($bytes / 1024) / 1024;

        if ($round) {
            $megaByteValue = round($megaByteValue, $roundTo, $roundMethod);
        }

        return $megaByteValue;
    }

    /**
     * Accepted Extensions.
     *
     * Grab the defined accepted file extensions, and
     * sanitize them to put 'em in an array for easy
     * use.
     *
     * @return array Array of extensions.
     */
    public function acceptedExtensions()
    {
        // Proceed with the default accepted files.
        $accepted_extensions = (string)config('uploads.default_extensions');

        $extension_array = explode(',', $accepted_extensions);

        $extensions = array();

        foreach ($extension_array as $extension) {
            // Strip out whitespaces, if any.
            $extension = preg_replace('/\s+/', '', $extension);

            // Strip out dots, if any.
            $extension = strtr($extension, array('.' => ''));

            $extensions[] = $extension;
        }

        return $extensions;
    }

    /**
     * Checks whether image File or not.
     *
     * @param string $fileName File Name.
     *
     * @return boolean True if succeed, False otherwise.
     */
    public static function isImage($fileName)
    {
        //Image MIME Types
        $image_mime_types = self::imageMimeTypes();

        //File Extension Form Filename
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        //File MIME Type Form "fileExtension'
        $fileMimeType = self::mimeTypesFromExtensions($fileExtension);

        foreach ($fileMimeType as $key => $value) {
            $mimeType = $value;

            if (in_array($mimeType, $image_mime_types)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks whether video File or not.
     *
     * @param string $fileName File Name.
     *
     * @return boolean True if succeed, False otherwise.
     */
    public function isMedia($fileName)
    {
        // Video MIME types.
        $image_mime_types = self::mediaMimeTypes();

        // File extension from filename.
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // File MIME type from file extension.
        $fileMimeType = self::mimeTypesFromExtensions($fileExtension);

        foreach ($fileMimeType as $key => $value) {
            $mimeType = $value;

            if (in_array($mimeType, $image_mime_types)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks whether a PDF File or not.
     *
     * @param string $fileName File Name.
     *
     * @return boolean True if succeed, False otherwise.
     */
    public function isPDF($fileName)
    {
        // File extension from filename.
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // File MIME type from file extension.
        $mimeType = self::mimeTypeFromExtension($fileExtension);

        if ('application/pdf' === $mimeType) {
            return true;
        }

        return false;
    }

    /**
     * Get File Path.
     *
     * @param string $fileName Filename.
     * @param string $fileSize Filesize.
     *
     * @return string          URL to the file.
     */
    public static function getFilePath($fileName, $fileSize = 'full')
    {
        if (self::isImage($fileName)) {
            if ('full' === $fileSize) {
                $filePath = '/storage/uploads/images/';
            } elseif ('medium' === $fileSize) {
                $filePath = '/storage/uploads/images/medium/';
            } elseif ('thumbnail' === $fileSize) {
                $filePath = '/storage/uploads/images/thumbnail/';
            }
        } else {
            $filePath = '/storage/uploads/files/';
        }

        return url($filePath . $fileName);
    }

    /**
     * Make the Title from the File.
     *
     * @param string $filename File with extension.
     *
     * @return string          Spaced title.
     */
    public function makeUploadTitleFromFile($filename)
    {
        // Remove extension.
        $title = preg_replace('/\.[^.\s]{2,4}$/', '', $filename);

        // Replace underscores, hyphens, and dots with ' ' (space).
        $title = str_replace('_', ' ', $title);
        $title = str_replace('-', ' ', $title);
        $title = str_replace('.', ' ', $title);

        return $title;
    }

    /**
     * Sanitize Filename.
     *
     * Rudimentary version of WordPress' sanitize_file_name()
     *
     * @param string $filename Unsanitized filename.
     *
     * @link https://developer.wordpress.org/reference/functions/sanitize_file_name/
     *
     * @return string          Sanitized filename.
     */
    public function sanitizeFilename($filename)
    {
        $special_chars = array('?', '[', ']', '/', '\\', '=', '<', '>', ':', ';', ',', "'", '"', '&', '$', '#', '*', '(', ')', '|', '~', '`', '!', '{', '}', '%', '+', chr(0));

        $filename = preg_replace("#\x{00a0}#siu", ' ', $filename);
        $filename = str_replace($special_chars, '', $filename);
        $filename = str_replace(array('%20', '+'), '-', $filename);
        $filename = preg_replace('/[\r\n\t -]+/', '-', $filename);
        $filename = trim($filename, '.-_');

        return $filename;
    }

    /**
     * Deal with the non-standard MIME Types.
     *
     * Decision can be taken to proceed or not in the case of non-standard MIME Types
     * that are showing sometimes in different browsers.
     *
     * The function will deal with the variations of:
     * - mp3
     * - zip
     * - pdf
     *
     * @param string $extension File Extension.
     * @param string $mime_type File MIME Type.
     *
     * @return boolean True if extension matches with the MIME, false otherwise.
     */
    public function isValidAltMimeTypes($extension, $mime_type)
    {
        // Array of accepted extensions.
        $accepted_extensions = $this->acceptedExtensions();

        if (!in_array($extension, $accepted_extensions, true)) {
            return false;
        }

        if ('mp3' === $extension && 'audio/mp3' === $mime_type) {
            return true;
        } elseif ('zip' === $extension && in_array($mime_type, array('application/octet-stream', 'application/x-zip-compressed'))) {
            return true;
        } elseif ('pdf' === $extension && 'application/octet-stream' === $mime_type) {
            return true;
        }

        return false;
    }

    /**
     * Get all the MIME Types.
     *
     * Get all the mime types as we know in this world.
     *
     * @link https://cdn.rawgit.com/jshttp/mime-db/master/db.json
     *
     * @return array Array of MIME types.
     */
    public static function mimeTypes()
    {
        return array(
            '123'          => 'application/vnd.lotus-1-2-3',
            '3dml'         => 'text/vnd.in3d.3dml',
            '3ds'          => 'image/x-3ds',
            '3g2'          => 'video/3gpp2',
            '3gp'          => 'video/3gpp',
            '7z'           => 'application/x-7z-compressed',
            'aab'          => 'application/x-authorware-bin',
            'aac'          => 'audio/x-aac',
            'aam'          => 'application/x-authorware-map',
            'aas'          => 'application/x-authorware-seg',
            'abw'          => 'application/x-abiword',
            'ac'           => 'application/pkix-attr-cert',
            'acc'          => 'application/vnd.americandynamics.acc',
            'ace'          => 'application/x-ace-compressed',
            'acu'          => 'application/vnd.acucobol',
            'acutc'        => 'application/vnd.acucorp',
            'adp'          => 'audio/adpcm',
            'aep'          => 'application/vnd.audiograph',
            'afm'          => 'application/x-font-type1',
            'afp'          => 'application/vnd.ibm.modcap',
            'ahead'        => 'application/vnd.ahead.space',
            'ai'           => 'application/postscript',
            'aif'          => 'audio/x-aiff',
            'aifc'         => 'audio/x-aiff',
            'aiff'         => 'audio/x-aiff',
            'air'          => 'application/vnd.adobe.air-application-installer-package+zip',
            'ait'          => 'application/vnd.dvb.ait',
            'ami'          => 'application/vnd.amiga.ami',
            'apk'          => 'application/vnd.android.package-archive',
            'appcache'     => 'text/cache-manifest',
            'application'  => 'application/x-ms-application',
            'apr'          => 'application/vnd.lotus-approach',
            'arc'          => 'application/x-freearc',
            'asc'          => 'application/pgp-signature',
            'asf'          => 'video/x-ms-asf',
            'asm'          => 'text/x-asm',
            'aso'          => 'application/vnd.accpac.simply.aso',
            'asx'          => 'video/x-ms-asf',
            'atc'          => 'application/vnd.acucorp',
            'atom'         => 'application/atom+xml',
            'atomcat'      => 'application/atomcat+xml',
            'atomsvc'      => 'application/atomsvc+xml',
            'atx'          => 'application/vnd.antix.game-component',
            'au'           => 'audio/basic',
            'avi'          => 'video/x-msvideo',
            'aw'           => 'application/applixware',
            'azf'          => 'application/vnd.airzip.filesecure.azf',
            'azs'          => 'application/vnd.airzip.filesecure.azs',
            'azw'          => 'application/vnd.amazon.ebook',
            'bat'          => 'application/x-msdownload',
            'bcpio'        => 'application/x-bcpio',
            'bdf'          => 'application/x-font-bdf',
            'bdm'          => 'application/vnd.syncml.dm+wbxml',
            'bed'          => 'application/vnd.realvnc.bed',
            'bh2'          => 'application/vnd.fujitsu.oasysprs',
            'bin'          => 'application/octet-stream',
            'blb'          => 'application/x-blorb',
            'blorb'        => 'application/x-blorb',
            'bmi'          => 'application/vnd.bmi',
            'bmp'          => 'image/x-ms-bmp',
            'book'         => 'application/vnd.framemaker',
            'box'          => 'application/vnd.previewsystems.box',
            'boz'          => 'application/x-bzip2',
            'bpk'          => 'application/octet-stream',
            'btif'         => 'image/prs.btif',
            'buffer'       => 'application/octet-stream',
            'bz'           => 'application/x-bzip',
            'bz2'          => 'application/x-bzip2',
            'c'            => 'text/x-c',
            'c11amc'       => 'application/vnd.cluetrust.cartomobile-config',
            'c11amz'       => 'application/vnd.cluetrust.cartomobile-config-pkg',
            'c4d'          => 'application/vnd.clonk.c4group',
            'c4f'          => 'application/vnd.clonk.c4group',
            'c4g'          => 'application/vnd.clonk.c4group',
            'c4p'          => 'application/vnd.clonk.c4group',
            'c4u'          => 'application/vnd.clonk.c4group',
            'cab'          => 'application/vnd.ms-cab-compressed',
            'caf'          => 'audio/x-caf',
            'cap'          => 'application/vnd.tcpdump.pcap',
            'car'          => 'application/vnd.curl.car',
            'cat'          => 'application/vnd.ms-pki.seccat',
            'cb7'          => 'application/x-cbr',
            'cba'          => 'application/x-cbr',
            'cbr'          => 'application/x-cbr',
            'cbt'          => 'application/x-cbr',
            'cbz'          => 'application/x-cbr',
            'cc'           => 'text/x-c',
            'cct'          => 'application/x-director',
            'ccxml'        => 'application/ccxml+xml',
            'cdbcmsg'      => 'application/vnd.contact.cmsg',
            'cdf'          => 'application/x-netcdf',
            'cdkey'        => 'application/vnd.mediastation.cdkey',
            'cdmia'        => 'application/cdmi-capability',
            'cdmic'        => 'application/cdmi-container',
            'cdmid'        => 'application/cdmi-domain',
            'cdmio'        => 'application/cdmi-object',
            'cdmiq'        => 'application/cdmi-queue',
            'cdx'          => 'chemical/x-cdx',
            'cdxml'        => 'application/vnd.chemdraw+xml',
            'cdy'          => 'application/vnd.cinderella',
            'cer'          => 'application/pkix-cert',
            'cfs'          => 'application/x-cfs-compressed',
            'cgm'          => 'image/cgm',
            'chat'         => 'application/x-chat',
            'chm'          => 'application/vnd.ms-htmlhelp',
            'chrt'         => 'application/vnd.kde.kchart',
            'cif'          => 'chemical/x-cif',
            'cii'          => 'application/vnd.anser-web-certificate-issue-initiation',
            'cil'          => 'application/vnd.ms-artgalry',
            'cla'          => 'application/vnd.claymore',
            'class'        => 'application/java-vm',
            'clkk'         => 'application/vnd.crick.clicker.keyboard',
            'clkp'         => 'application/vnd.crick.clicker.palette',
            'clkt'         => 'application/vnd.crick.clicker.template',
            'clkw'         => 'application/vnd.crick.clicker.wordbank',
            'clkx'         => 'application/vnd.crick.clicker',
            'clp'          => 'application/x-msclip',
            'cmc'          => 'application/vnd.cosmocaller',
            'cmdf'         => 'chemical/x-cmdf',
            'cml'          => 'chemical/x-cml',
            'cmp'          => 'application/vnd.yellowriver-custom-menu',
            'cmx'          => 'image/x-cmx',
            'cod'          => 'application/vnd.rim.cod',
            'com'          => 'application/x-msdownload',
            'conf'         => 'text/plain',
            'cpio'         => 'application/x-cpio',
            'cpp'          => 'text/x-c',
            'cpt'          => 'application/mac-compactpro',
            'crd'          => 'application/x-mscardfile',
            'crl'          => 'application/pkix-crl',
            'crt'          => 'application/x-x509-ca-cert',
            'crx'          => 'application/x-chrome-extension',
            'cryptonote'   => 'application/vnd.rig.cryptonote',
            'csh'          => 'application/x-csh',
            'csml'         => 'chemical/x-csml',
            'csp'          => 'application/vnd.commonspace',
            'css'          => 'text/css',
            'cst'          => 'application/x-director',
            'csv'          => 'text/csv',
            'cu'           => 'application/cu-seeme',
            'curl'         => 'text/vnd.curl',
            'cww'          => 'application/prs.cww',
            'cxt'          => 'application/x-director',
            'cxx'          => 'text/x-c',
            'dae'          => 'model/vnd.collada+xml',
            'daf'          => 'application/vnd.mobius.daf',
            'dart'         => 'application/vnd.dart',
            'dataless'     => 'application/vnd.fdsn.seed',
            'davmount'     => 'application/davmount+xml',
            'dbk'          => 'application/docbook+xml',
            'dcr'          => 'application/x-director',
            'dcurl'        => 'text/vnd.curl.dcurl',
            'dd2'          => 'application/vnd.oma.dd2+xml',
            'ddd'          => 'application/vnd.fujixerox.ddd',
            'deb'          => 'application/x-debian-package',
            'def'          => 'text/plain',
            'deploy'       => 'application/octet-stream',
            'der'          => 'application/x-x509-ca-cert',
            'dfac'         => 'application/vnd.dreamfactory',
            'dgc'          => 'application/x-dgc-compressed',
            'dic'          => 'text/x-c',
            'dir'          => 'application/x-director',
            'dis'          => 'application/vnd.mobius.dis',
            'dist'         => 'application/octet-stream',
            'distz'        => 'application/octet-stream',
            'djv'          => 'image/vnd.djvu',
            'djvu'         => 'image/vnd.djvu',
            'dll'          => 'application/x-msdownload',
            'dmg'          => 'application/x-apple-diskimage',
            'dmp'          => 'application/vnd.tcpdump.pcap',
            'dms'          => 'application/octet-stream',
            'dna'          => 'application/vnd.dna',
            'doc'          => 'application/msword',
            'docm'         => 'application/vnd.ms-word.document.macroenabled.12',
            'docx'         => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'dot'          => 'application/msword',
            'dotm'         => 'application/vnd.ms-word.template.macroenabled.12',
            'dotx'         => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
            'dp'           => 'application/vnd.osgi.dp',
            'dpg'          => 'application/vnd.dpgraph',
            'dra'          => 'audio/vnd.dra',
            'dsc'          => 'text/prs.lines.tag',
            'dssc'         => 'application/dssc+der',
            'dtb'          => 'application/x-dtbook+xml',
            'dtd'          => 'application/xml-dtd',
            'dts'          => 'audio/vnd.dts',
            'dtshd'        => 'audio/vnd.dts.hd',
            'dump'         => 'application/octet-stream',
            'dvb'          => 'video/vnd.dvb.file',
            'dvi'          => 'application/x-dvi',
            'dwf'          => 'model/vnd.dwf',
            'dwg'          => 'image/vnd.dwg',
            'dxf'          => 'image/vnd.dxf',
            'dxp'          => 'application/vnd.spotfire.dxp',
            'dxr'          => 'application/x-director',
            'ecelp4800'    => 'audio/vnd.nuera.ecelp4800',
            'ecelp7470'    => 'audio/vnd.nuera.ecelp7470',
            'ecelp9600'    => 'audio/vnd.nuera.ecelp9600',
            'ecma'         => 'application/ecmascript',
            'edm'          => 'application/vnd.novadigm.edm',
            'edx'          => 'application/vnd.novadigm.edx',
            'efif'         => 'application/vnd.picsel',
            'ei6'          => 'application/vnd.pg.osasli',
            'elc'          => 'application/octet-stream',
            'emf'          => 'application/x-msmetafile',
            'eml'          => 'message/rfc822',
            'emma'         => 'application/emma+xml',
            'emz'          => 'application/x-msmetafile',
            'eol'          => 'audio/vnd.digital-winds',
            'eot'          => 'application/vnd.ms-fontobject',
            'eps'          => 'application/postscript',
            'epub'         => 'application/epub+zip',
            'es3'          => 'application/vnd.eszigno3+xml',
            'esa'          => 'application/vnd.osgi.subsystem',
            'esf'          => 'application/vnd.epson.esf',
            'et3'          => 'application/vnd.eszigno3+xml',
            'etx'          => 'text/x-setext',
            'eva'          => 'application/x-eva',
            'event-stream' => 'text/event-stream',
            'evy'          => 'application/x-envoy',
            'exe'          => 'application/x-msdownload',
            'exi'          => 'application/exi',
            'ext'          => 'application/vnd.novadigm.ext',
            'ez'           => 'application/andrew-inset',
            'ez2'          => 'application/vnd.ezpix-album',
            'ez3'          => 'application/vnd.ezpix-package',
            'f'            => 'text/x-fortran',
            'f4v'          => 'video/x-f4v',
            'f77'          => 'text/x-fortran',
            'f90'          => 'text/x-fortran',
            'fbs'          => 'image/vnd.fastbidsheet',
            'fcdt'         => 'application/vnd.adobe.formscentral.fcdt',
            'fcs'          => 'application/vnd.isac.fcs',
            'fdf'          => 'application/vnd.fdf',
            'fe_launch'    => 'application/vnd.denovo.fcselayout-link',
            'fg5'          => 'application/vnd.fujitsu.oasysgp',
            'fgd'          => 'application/x-director',
            'fh'           => 'image/x-freehand',
            'fh4'          => 'image/x-freehand',
            'fh5'          => 'image/x-freehand',
            'fh7'          => 'image/x-freehand',
            'fhc'          => 'image/x-freehand',
            'fig'          => 'application/x-xfig',
            'flac'         => 'audio/flac',
            'fli'          => 'video/x-fli',
            'flo'          => 'application/vnd.micrografx.flo',
            'flv'          => 'video/x-flv',
            'flw'          => 'application/vnd.kde.kivio',
            'flx'          => 'text/vnd.fmi.flexstor',
            'fly'          => 'text/vnd.fly',
            'fm'           => 'application/vnd.framemaker',
            'fnc'          => 'application/vnd.frogans.fnc',
            'for'          => 'text/x-fortran',
            'fpx'          => 'image/vnd.fpx',
            'frame'        => 'application/vnd.framemaker',
            'fsc'          => 'application/vnd.fsc.weblaunch',
            'fst'          => 'image/vnd.fst',
            'ftc'          => 'application/vnd.fluxtime.clip',
            'fti'          => 'application/vnd.anser-web-funds-transfer-initiation',
            'fvt'          => 'video/vnd.fvt',
            'fxp'          => 'application/vnd.adobe.fxp',
            'fxpl'         => 'application/vnd.adobe.fxp',
            'fzs'          => 'application/vnd.fuzzysheet',
            'g2w'          => 'application/vnd.geoplan',
            'g3'           => 'image/g3fax',
            'g3w'          => 'application/vnd.geospace',
            'gac'          => 'application/vnd.groove-account',
            'gam'          => 'application/x-tads',
            'gbr'          => 'application/rpki-ghostbusters',
            'gca'          => 'application/x-gca-compressed',
            'gdl'          => 'model/vnd.gdl',
            'geo'          => 'application/vnd.dynageo',
            'gex'          => 'application/vnd.geometry-explorer',
            'ggb'          => 'application/vnd.geogebra.file',
            'ggt'          => 'application/vnd.geogebra.tool',
            'ghf'          => 'application/vnd.groove-help',
            'gif'          => 'image/gif',
            'gim'          => 'application/vnd.groove-identity-message',
            'gml'          => 'application/gml+xml',
            'gmx'          => 'application/vnd.gmx',
            'gnumeric'     => 'application/x-gnumeric',
            'gph'          => 'application/vnd.flographit',
            'gpx'          => 'application/gpx+xml',
            'gqf'          => 'application/vnd.grafeq',
            'gqs'          => 'application/vnd.grafeq',
            'gram'         => 'application/srgs',
            'gramps'       => 'application/x-gramps-xml',
            'gre'          => 'application/vnd.geometry-explorer',
            'grv'          => 'application/vnd.groove-injector',
            'grxml'        => 'application/srgs+xml',
            'gsf'          => 'application/x-font-ghostscript',
            'gtar'         => 'application/x-gtar',
            'gtm'          => 'application/vnd.groove-tool-message',
            'gtw'          => 'model/vnd.gtw',
            'gv'           => 'text/vnd.graphviz',
            'gxf'          => 'application/gxf',
            'gxt'          => 'application/vnd.geonext',
            'h'            => 'text/x-c',
            'h261'         => 'video/h261',
            'h263'         => 'video/h263',
            'h264'         => 'video/h264',
            'hal'          => 'application/vnd.hal+xml',
            'hbci'         => 'application/vnd.hbci',
            'hdf'          => 'application/x-hdf',
            'hh'           => 'text/x-c',
            'hlp'          => 'application/winhlp',
            'hpgl'         => 'application/vnd.hp-hpgl',
            'hpid'         => 'application/vnd.hp-hpid',
            'hps'          => 'application/vnd.hp-hps',
            'hqx'          => 'application/mac-binhex40',
            'htc'          => 'text/x-component',
            'htke'         => 'application/vnd.kenameaapp',
            'htm'          => 'text/html',
            'html'         => 'text/html',
            'hvd'          => 'application/vnd.yamaha.hv-dic',
            'hvp'          => 'application/vnd.yamaha.hv-voice',
            'hvs'          => 'application/vnd.yamaha.hv-script',
            'i2g'          => 'application/vnd.intergeo',
            'icc'          => 'application/vnd.iccprofile',
            'ice'          => 'x-conference/x-cooltalk',
            'icm'          => 'application/vnd.iccprofile',
            'ico'          => 'image/x-icon',
            'ics'          => 'text/calendar',
            'ief'          => 'image/ief',
            'ifb'          => 'text/calendar',
            'ifm'          => 'application/vnd.shana.informed.formdata',
            'iges'         => 'model/iges',
            'igl'          => 'application/vnd.igloader',
            'igm'          => 'application/vnd.insors.igm',
            'igs'          => 'model/iges',
            'igx'          => 'application/vnd.micrografx.igx',
            'iif'          => 'application/vnd.shana.informed.interchange',
            'imp'          => 'application/vnd.accpac.simply.imp',
            'ims'          => 'application/vnd.ms-ims',
            'in'           => 'text/plain',
            'ink'          => 'application/inkml+xml',
            'inkml'        => 'application/inkml+xml',
            'install'      => 'application/x-install-instructions',
            'iota'         => 'application/vnd.astraea-software.iota',
            'ipfix'        => 'application/ipfix',
            'ipk'          => 'application/vnd.shana.informed.package',
            'irm'          => 'application/vnd.ibm.rights-management',
            'irp'          => 'application/vnd.irepository.package+xml',
            'iso'          => 'application/x-iso9660-image',
            'itp'          => 'application/vnd.shana.informed.formtemplate',
            'ivp'          => 'application/vnd.immervision-ivp',
            'ivu'          => 'application/vnd.immervision-ivu',
            'jad'          => 'text/vnd.sun.j2me.app-descriptor',
            'jam'          => 'application/vnd.jam',
            'jar'          => 'application/java-archive',
            'java'         => 'text/x-java-source',
            'jisp'         => 'application/vnd.jisp',
            'jlt'          => 'application/vnd.hp-jlyt',
            'jnlp'         => 'application/x-java-jnlp-file',
            'joda'         => 'application/vnd.joost.joda-archive',
            'jpe'          => 'image/jpeg',
            'jpeg'         => 'image/jpeg',
            'jpg'          => 'image/jpeg',
            'jpgm'         => 'video/jpm',
            'jpgv'         => 'video/jpeg',
            'jpm'          => 'video/jpm',
            'js'           => 'application/javascript',
            'json'         => 'application/json',
            'jsonml'       => 'application/jsonml+json',
            'kar'          => 'audio/midi',
            'karbon'       => 'application/vnd.kde.karbon',
            'kfo'          => 'application/vnd.kde.kformula',
            'kia'          => 'application/vnd.kidspiration',
            'kml'          => 'application/vnd.google-earth.kml+xml',
            'kmz'          => 'application/vnd.google-earth.kmz',
            'kne'          => 'application/vnd.kinar',
            'knp'          => 'application/vnd.kinar',
            'kon'          => 'application/vnd.kde.kontour',
            'kpr'          => 'application/vnd.kde.kpresenter',
            'kpt'          => 'application/vnd.kde.kpresenter',
            'kpxx'         => 'application/vnd.ds-keypoint',
            'ksp'          => 'application/vnd.kde.kspread',
            'ktr'          => 'application/vnd.kahootz',
            'ktx'          => 'image/ktx',
            'ktz'          => 'application/vnd.kahootz',
            'kwd'          => 'application/vnd.kde.kword',
            'kwt'          => 'application/vnd.kde.kword',
            'lasxml'       => 'application/vnd.las.las+xml',
            'latex'        => 'application/x-latex',
            'lbd'          => 'application/vnd.llamagraphics.life-balance.desktop',
            'lbe'          => 'application/vnd.llamagraphics.life-balance.exchange+xml',
            'les'          => 'application/vnd.hhe.lesson-player',
            'lha'          => 'application/x-lzh-compressed',
            'link66'       => 'application/vnd.route66.link66+xml',
            'list'         => 'text/plain',
            'list3820'     => 'application/vnd.ibm.modcap',
            'listafp'      => 'application/vnd.ibm.modcap',
            'lnk'          => 'application/x-ms-shortcut',
            'log'          => 'text/plain',
            'lostxml'      => 'application/lost+xml',
            'lrf'          => 'application/octet-stream',
            'lrm'          => 'application/vnd.ms-lrm',
            'ltf'          => 'application/vnd.frogans.ltf',
            'lua'          => 'text/x-lua',
            'luac'         => 'application/x-lua-bytecode',
            'lvp'          => 'audio/vnd.lucent.voice',
            'lwp'          => 'application/vnd.lotus-wordpro',
            'lzh'          => 'application/x-lzh-compressed',
            'm13'          => 'application/x-msmediaview',
            'm14'          => 'application/x-msmediaview',
            'm1v'          => 'video/mpeg',
            'm21'          => 'application/mp21',
            'm2a'          => 'audio/mpeg',
            'm2v'          => 'video/mpeg',
            'm3a'          => 'audio/mpeg',
            'm3u'          => 'audio/x-mpegurl',
            'm3u8'         => 'application/x-mpegURL',
            'm4a'          => 'audio/mp4',
            'm4p'          => 'application/mp4',
            'm4u'          => 'video/vnd.mpegurl',
            'm4v'          => 'video/x-m4v',
            'ma'           => 'application/mathematica',
            'mads'         => 'application/mads+xml',
            'mag'          => 'application/vnd.ecowin.chart',
            'maker'        => 'application/vnd.framemaker',
            'man'          => 'text/troff',
            'manifest'     => 'text/cache-manifest',
            'mar'          => 'application/octet-stream',
            'markdown'     => 'text/x-markdown',
            'mathml'       => 'application/mathml+xml',
            'mb'           => 'application/mathematica',
            'mbk'          => 'application/vnd.mobius.mbk',
            'mbox'         => 'application/mbox',
            'mc1'          => 'application/vnd.medcalcdata',
            'mcd'          => 'application/vnd.mcd',
            'mcurl'        => 'text/vnd.curl.mcurl',
            'md'           => 'text/x-markdown',
            'mdb'          => 'application/x-msaccess',
            'mdi'          => 'image/vnd.ms-modi',
            'me'           => 'text/troff',
            'mesh'         => 'model/mesh',
            'meta4'        => 'application/metalink4+xml',
            'metalink'     => 'application/metalink+xml',
            'mets'         => 'application/mets+xml',
            'mfm'          => 'application/vnd.mfmp',
            'mft'          => 'application/rpki-manifest',
            'mgp'          => 'application/vnd.osgeo.mapguide.package',
            'mgz'          => 'application/vnd.proteus.magazine',
            'mid'          => 'audio/midi',
            'midi'         => 'audio/midi',
            'mie'          => 'application/x-mie',
            'mif'          => 'application/vnd.mif',
            'mime'         => 'message/rfc822',
            'mj2'          => 'video/mj2',
            'mjp2'         => 'video/mj2',
            'mk3d'         => 'video/x-matroska',
            'mka'          => 'audio/x-matroska',
            'mkd'          => 'text/x-markdown',
            'mks'          => 'video/x-matroska',
            'mkv'          => 'video/x-matroska',
            'mlp'          => 'application/vnd.dolby.mlp',
            'mmd'          => 'application/vnd.chipnuts.karaoke-mmd',
            'mmf'          => 'application/vnd.smaf',
            'mmr'          => 'image/vnd.fujixerox.edmics-mmr',
            'mng'          => 'video/x-mng',
            'mny'          => 'application/x-msmoney',
            'mobi'         => 'application/x-mobipocket-ebook',
            'mods'         => 'application/mods+xml',
            'mov'          => 'video/quicktime',
            'movie'        => 'video/x-sgi-movie',
            'mp2'          => 'audio/mpeg',
            'mp21'         => 'application/mp21',
            'mp2a'         => 'audio/mpeg',
            'mp3'          => 'audio/mpeg',
            'mp4'          => 'video/mp4',
            'mp4a'         => 'audio/mp4',
            'mp4s'         => 'application/mp4',
            'mp4v'         => 'video/mp4',
            'mpc'          => 'application/vnd.mophun.certificate',
            'mpe'          => 'video/mpeg',
            'mpeg'         => 'video/mpeg',
            'mpg'          => 'video/mpeg',
            'mpg4'         => 'video/mp4',
            'mpga'         => 'audio/mpeg',
            'mpkg'         => 'application/vnd.apple.installer+xml',
            'mpm'          => 'application/vnd.blueice.multipass',
            'mpn'          => 'application/vnd.mophun.application',
            'mpp'          => 'application/vnd.ms-project',
            'mpt'          => 'application/vnd.ms-project',
            'mpy'          => 'application/vnd.ibm.minipay',
            'mqy'          => 'application/vnd.mobius.mqy',
            'mrc'          => 'application/marc',
            'mrcx'         => 'application/marcxml+xml',
            'ms'           => 'text/troff',
            'mscml'        => 'application/mediaservercontrol+xml',
            'mseed'        => 'application/vnd.fdsn.mseed',
            'mseq'         => 'application/vnd.mseq',
            'msf'          => 'application/vnd.epson.msf',
            'msh'          => 'model/mesh',
            'msi'          => 'application/x-msdownload',
            'msl'          => 'application/vnd.mobius.msl',
            'msty'         => 'application/vnd.muvee.style',
            'mts'          => 'model/vnd.mts',
            'mus'          => 'application/vnd.musician',
            'musicxml'     => 'application/vnd.recordare.musicxml+xml',
            'mvb'          => 'application/x-msmediaview',
            'mwf'          => 'application/vnd.mfer',
            'mxf'          => 'application/mxf',
            'mxl'          => 'application/vnd.recordare.musicxml',
            'mxml'         => 'application/xv+xml',
            'mxs'          => 'application/vnd.triscape.mxs',
            'mxu'          => 'video/vnd.mpegurl',
            'n-gage'       => 'application/vnd.nokia.n-gage.symbian.install',
            'n3'           => 'text/n3',
            'nb'           => 'application/mathematica',
            'nbp'          => 'application/vnd.wolfram.player',
            'nc'           => 'application/x-netcdf',
            'ncx'          => 'application/x-dtbncx+xml',
            'nfo'          => 'text/x-nfo',
            'ngdat'        => 'application/vnd.nokia.n-gage.data',
            'nitf'         => 'application/vnd.nitf',
            'nlu'          => 'application/vnd.neurolanguage.nlu',
            'nml'          => 'application/vnd.enliven',
            'nnd'          => 'application/vnd.noblenet-directory',
            'nns'          => 'application/vnd.noblenet-sealer',
            'nnw'          => 'application/vnd.noblenet-web',
            'npx'          => 'image/vnd.net-fpx',
            'nsc'          => 'application/x-conference',
            'nsf'          => 'application/vnd.lotus-notes',
            'ntf'          => 'application/vnd.nitf',
            'nzb'          => 'application/x-nzb',
            'oa2'          => 'application/vnd.fujitsu.oasys2',
            'oa3'          => 'application/vnd.fujitsu.oasys3',
            'oas'          => 'application/vnd.fujitsu.oasys',
            'obd'          => 'application/x-msbinder',
            'obj'          => 'application/x-tgif',
            'oda'          => 'application/oda',
            'odb'          => 'application/vnd.oasis.opendocument.database',
            'odc'          => 'application/vnd.oasis.opendocument.chart',
            'odf'          => 'application/vnd.oasis.opendocument.formula',
            'odft'         => 'application/vnd.oasis.opendocument.formula-template',
            'odg'          => 'application/vnd.oasis.opendocument.graphics',
            'odi'          => 'application/vnd.oasis.opendocument.image',
            'odm'          => 'application/vnd.oasis.opendocument.text-master',
            'odp'          => 'application/vnd.oasis.opendocument.presentation',
            'ods'          => 'application/vnd.oasis.opendocument.spreadsheet',
            'odt'          => 'application/vnd.oasis.opendocument.text',
            'oga'          => 'audio/ogg',
            'ogg'          => 'audio/ogg',
            'ogv'          => 'video/ogg',
            'ogx'          => 'application/ogg',
            'omdoc'        => 'application/omdoc+xml',
            'onepkg'       => 'application/onenote',
            'onetmp'       => 'application/onenote',
            'onetoc'       => 'application/onenote',
            'onetoc2'      => 'application/onenote',
            'opf'          => 'application/oebps-package+xml',
            'opml'         => 'text/x-opml',
            'oprc'         => 'application/vnd.palm',
            'org'          => 'application/vnd.lotus-organizer',
            'osf'          => 'application/vnd.yamaha.openscoreformat',
            'osfpvg'       => 'application/vnd.yamaha.openscoreformat.osfpvg+xml',
            'otc'          => 'application/vnd.oasis.opendocument.chart-template',
            'otf'          => 'font/opentype',
            'otg'          => 'application/vnd.oasis.opendocument.graphics-template',
            'oth'          => 'application/vnd.oasis.opendocument.text-web',
            'oti'          => 'application/vnd.oasis.opendocument.image-template',
            'otp'          => 'application/vnd.oasis.opendocument.presentation-template',
            'ots'          => 'application/vnd.oasis.opendocument.spreadsheet-template',
            'ott'          => 'application/vnd.oasis.opendocument.text-template',
            'oxps'         => 'application/oxps',
            'oxt'          => 'application/vnd.openofficeorg.extension',
            'p'            => 'text/x-pascal',
            'p10'          => 'application/pkcs10',
            'p12'          => 'application/x-pkcs12',
            'p7b'          => 'application/x-pkcs7-certificates',
            'p7c'          => 'application/pkcs7-mime',
            'p7m'          => 'application/pkcs7-mime',
            'p7r'          => 'application/x-pkcs7-certreqresp',
            'p7s'          => 'application/pkcs7-signature',
            'p8'           => 'application/pkcs8',
            'pas'          => 'text/x-pascal',
            'paw'          => 'application/vnd.pawaafile',
            'pbd'          => 'application/vnd.powerbuilder6',
            'pbm'          => 'image/x-portable-bitmap',
            'pcap'         => 'application/vnd.tcpdump.pcap',
            'pcf'          => 'application/x-font-pcf',
            'pcl'          => 'application/vnd.hp-pcl',
            'pclxl'        => 'application/vnd.hp-pclxl',
            'pct'          => 'image/x-pict',
            'pcurl'        => 'application/vnd.curl.pcurl',
            'pcx'          => 'image/x-pcx',
            'pdb'          => 'application/vnd.palm',
            'pdf'          => 'application/pdf',
            'pfa'          => 'application/x-font-type1',
            'pfb'          => 'application/x-font-type1',
            'pfm'          => 'application/x-font-type1',
            'pfr'          => 'application/font-tdpfr',
            'pfx'          => 'application/x-pkcs12',
            'pgm'          => 'image/x-portable-graymap',
            'pgn'          => 'application/x-chess-pgn',
            'pgp'          => 'application/pgp-encrypted',
            'pic'          => 'image/x-pict',
            'pkg'          => 'application/octet-stream',
            'pki'          => 'application/pkixcmp',
            'pkipath'      => 'application/pkix-pkipath',
            'plb'          => 'application/vnd.3gpp.pic-bw-large',
            'plc'          => 'application/vnd.mobius.plc',
            'plf'          => 'application/vnd.pocketlearn',
            'pls'          => 'application/pls+xml',
            'pml'          => 'application/vnd.ctc-posml',
            'png'          => 'image/png',
            'pnm'          => 'image/x-portable-anymap',
            'portpkg'      => 'application/vnd.macports.portpkg',
            'pot'          => 'application/vnd.ms-powerpoint',
            'potm'         => 'application/vnd.ms-powerpoint.template.macroenabled.12',
            'potx'         => 'application/vnd.openxmlformats-officedocument.presentationml.template',
            'ppam'         => 'application/vnd.ms-powerpoint.addin.macroenabled.12',
            'ppd'          => 'application/vnd.cups-ppd',
            'ppm'          => 'image/x-portable-pixmap',
            'pps'          => 'application/vnd.ms-powerpoint',
            'ppsm'         => 'application/vnd.ms-powerpoint.slideshow.macroenabled.12',
            'ppsx'         => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
            'ppt'          => 'application/vnd.ms-powerpoint',
            'pptm'         => 'application/vnd.ms-powerpoint.presentation.macroenabled.12',
            'pptx'         => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'pqa'          => 'application/vnd.palm',
            'prc'          => 'application/x-mobipocket-ebook',
            'pre'          => 'application/vnd.lotus-freelance',
            'prf'          => 'application/pics-rules',
            'ps'           => 'application/postscript',
            'psb'          => 'application/vnd.3gpp.pic-bw-small',
            'psd'          => 'image/vnd.adobe.photoshop',
            'psf'          => 'application/x-font-linux-psf',
            'pskcxml'      => 'application/pskc+xml',
            'ptid'         => 'application/vnd.pvi.ptid1',
            'pub'          => 'application/x-mspublisher',
            'pvb'          => 'application/vnd.3gpp.pic-bw-var',
            'pwn'          => 'application/vnd.3m.post-it-notes',
            'pya'          => 'audio/vnd.ms-playready.media.pya',
            'pyv'          => 'video/vnd.ms-playready.media.pyv',
            'qam'          => 'application/vnd.epson.quickanime',
            'qbo'          => 'application/vnd.intu.qbo',
            'qfx'          => 'application/vnd.intu.qfx',
            'qps'          => 'application/vnd.publishare-delta-tree',
            'qt'           => 'video/quicktime',
            'qwd'          => 'application/vnd.quark.quarkxpress',
            'qwt'          => 'application/vnd.quark.quarkxpress',
            'qxb'          => 'application/vnd.quark.quarkxpress',
            'qxd'          => 'application/vnd.quark.quarkxpress',
            'qxl'          => 'application/vnd.quark.quarkxpress',
            'qxt'          => 'application/vnd.quark.quarkxpress',
            'ra'           => 'audio/x-pn-realaudio',
            'ram'          => 'audio/x-pn-realaudio',
            'rar'          => 'application/x-rar-compressed',
            'ras'          => 'image/x-cmu-raster',
            'rcprofile'    => 'application/vnd.ipunplugged.rcprofile',
            'rdf'          => 'application/rdf+xml',
            'rdz'          => 'application/vnd.data-vision.rdz',
            'rep'          => 'application/vnd.businessobjects',
            'res'          => 'application/x-dtbresource+xml',
            'rgb'          => 'image/x-rgb',
            'rif'          => 'application/reginfo+xml',
            'rip'          => 'audio/vnd.rip',
            'ris'          => 'application/x-research-info-systems',
            'rl'           => 'application/resource-lists+xml',
            'rlc'          => 'image/vnd.fujixerox.edmics-rlc',
            'rld'          => 'application/resource-lists-diff+xml',
            'rm'           => 'application/vnd.rn-realmedia',
            'rmi'          => 'audio/midi',
            'rmp'          => 'audio/x-pn-realaudio-plugin',
            'rms'          => 'application/vnd.jcp.javame.midlet-rms',
            'rmvb'         => 'application/vnd.rn-realmedia-vbr',
            'rnc'          => 'application/relax-ng-compact-syntax',
            'roa'          => 'application/rpki-roa',
            'roff'         => 'text/troff',
            'rp9'          => 'application/vnd.cloanto.rp9',
            'rpss'         => 'application/vnd.nokia.radio-presets',
            'rpst'         => 'application/vnd.nokia.radio-preset',
            'rq'           => 'application/sparql-query',
            'rs'           => 'application/rls-services+xml',
            'rsd'          => 'application/rsd+xml',
            'rss'          => 'application/rss+xml',
            'rtf'          => 'text/rtf',
            'rtx'          => 'text/richtext',
            's'            => 'text/x-asm',
            's3m'          => 'audio/s3m',
            'saf'          => 'application/vnd.yamaha.smaf-audio',
            'sbml'         => 'application/sbml+xml',
            'sc'           => 'application/vnd.ibm.secure-container',
            'scd'          => 'application/x-msschedule',
            'scm'          => 'application/vnd.lotus-screencam',
            'scq'          => 'application/scvp-cv-request',
            'scs'          => 'application/scvp-cv-response',
            'scurl'        => 'text/vnd.curl.scurl',
            'sda'          => 'application/vnd.stardivision.draw',
            'sdc'          => 'application/vnd.stardivision.calc',
            'sdd'          => 'application/vnd.stardivision.impress',
            'sdkd'         => 'application/vnd.solent.sdkm+xml',
            'sdkm'         => 'application/vnd.solent.sdkm+xml',
            'sdp'          => 'application/sdp',
            'sdw'          => 'application/vnd.stardivision.writer',
            'see'          => 'application/vnd.seemail',
            'seed'         => 'application/vnd.fdsn.seed',
            'sema'         => 'application/vnd.sema',
            'semd'         => 'application/vnd.semd',
            'semf'         => 'application/vnd.semf',
            'ser'          => 'application/java-serialized-object',
            'setpay'       => 'application/set-payment-initiation',
            'setreg'       => 'application/set-registration-initiation',
            'sfd-hdstx'    => 'application/vnd.hydrostatix.sof-data',
            'sfs'          => 'application/vnd.spotfire.sfs',
            'sfv'          => 'text/x-sfv',
            'sgi'          => 'image/sgi',
            'sgl'          => 'application/vnd.stardivision.writer-global',
            'sgm'          => 'text/sgml',
            'sgml'         => 'text/sgml',
            'sh'           => 'application/x-sh',
            'shar'         => 'application/x-shar',
            'shf'          => 'application/shf+xml',
            'shp'          => 'application/octet-stream',
            'shx'          => 'application/octet-stream',
            'sid'          => 'image/x-mrsid-image',
            'sig'          => 'application/pgp-signature',
            'sil'          => 'audio/silk',
            'silo'         => 'model/mesh',
            'sis'          => 'application/vnd.symbian.install',
            'sisx'         => 'application/vnd.symbian.install',
            'sit'          => 'application/x-stuffit',
            'sitx'         => 'application/x-stuffitx',
            'skd'          => 'application/vnd.koan',
            'skm'          => 'application/vnd.koan',
            'skp'          => 'application/vnd.koan',
            'skt'          => 'application/vnd.koan',
            'sldm'         => 'application/vnd.ms-powerpoint.slide.macroenabled.12',
            'sldx'         => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
            'slt'          => 'application/vnd.epson.salt',
            'sm'           => 'application/vnd.stepmania.stepchart',
            'smf'          => 'application/vnd.stardivision.math',
            'smi'          => 'application/smil+xml',
            'smil'         => 'application/smil+xml',
            'smv'          => 'video/x-smv',
            'smzip'        => 'application/vnd.stepmania.package',
            'snd'          => 'audio/basic',
            'snf'          => 'application/x-font-snf',
            'so'           => 'application/octet-stream',
            'spc'          => 'application/x-pkcs7-certificates',
            'spf'          => 'application/vnd.yamaha.smaf-phrase',
            'spl'          => 'application/x-futuresplash',
            'spot'         => 'text/vnd.in3d.spot',
            'spp'          => 'application/scvp-vp-response',
            'spq'          => 'application/scvp-vp-request',
            'spx'          => 'audio/ogg',
            'sql'          => 'application/x-sql',
            'src'          => 'application/x-wais-source',
            'srt'          => 'application/x-subrip',
            'sru'          => 'application/sru+xml',
            'srx'          => 'application/sparql-results+xml',
            'ssdl'         => 'application/ssdl+xml',
            'sse'          => 'application/vnd.kodak-descriptor',
            'ssf'          => 'application/vnd.epson.ssf',
            'ssml'         => 'application/ssml+xml',
            'st'           => 'application/vnd.sailingtracker.track',
            'stc'          => 'application/vnd.sun.xml.calc.template',
            'std'          => 'application/vnd.sun.xml.draw.template',
            'stf'          => 'application/vnd.wt.stf',
            'sti'          => 'application/vnd.sun.xml.impress.template',
            'stk'          => 'application/hyperstudio',
            'stl'          => 'application/vnd.ms-pki.stl',
            'str'          => 'application/vnd.pg.format',
            'stw'          => 'application/vnd.sun.xml.writer.template',
            'sub'          => 'text/vnd.dvb.subtitle',
            'sus'          => 'application/vnd.sus-calendar',
            'susp'         => 'application/vnd.sus-calendar',
            'sv4cpio'      => 'application/x-sv4cpio',
            'sv4crc'       => 'application/x-sv4crc',
            'svc'          => 'application/vnd.dvb.service',
            'svd'          => 'application/vnd.svd',
            'svg'          => 'image/svg+xml',
            'svgz'         => 'image/svg+xml',
            'swa'          => 'application/x-director',
            'swf'          => 'application/x-shockwave-flash',
            'swi'          => 'application/vnd.aristanetworks.swi',
            'sxc'          => 'application/vnd.sun.xml.calc',
            'sxd'          => 'application/vnd.sun.xml.draw',
            'sxg'          => 'application/vnd.sun.xml.writer.global',
            'sxi'          => 'application/vnd.sun.xml.impress',
            'sxm'          => 'application/vnd.sun.xml.math',
            'sxw'          => 'application/vnd.sun.xml.writer',
            't'            => 'text/troff',
            't3'           => 'application/x-t3vm-image',
            'taglet'       => 'application/vnd.mynfc',
            'tao'          => 'application/vnd.tao.intent-module-archive',
            'tar'          => 'application/x-tar',
            'tcap'         => 'application/vnd.3gpp2.tcap',
            'tcl'          => 'application/x-tcl',
            'teacher'      => 'application/vnd.smart.teacher',
            'tei'          => 'application/tei+xml',
            'teicorpus'    => 'application/tei+xml',
            'tex'          => 'application/x-tex',
            'texi'         => 'application/x-texinfo',
            'texinfo'      => 'application/x-texinfo',
            'text'         => 'text/plain',
            'tfi'          => 'application/thraud+xml',
            'tfm'          => 'application/x-tex-tfm',
            'tga'          => 'image/x-tga',
            'thmx'         => 'application/vnd.ms-officetheme',
            'tif'          => 'image/tiff',
            'tiff'         => 'image/tiff',
            'tmo'          => 'application/vnd.tmobile-livetv',
            'torrent'      => 'application/x-bittorrent',
            'tpl'          => 'application/vnd.groove-tool-template',
            'tpt'          => 'application/vnd.trid.tpt',
            'tr'           => 'text/troff',
            'tra'          => 'application/vnd.trueapp',
            'trm'          => 'application/x-msterminal',
            'ts'           => 'video/MP2T',
            'tsd'          => 'application/timestamped-data',
            'tsv'          => 'text/tab-separated-values',
            'ttc'          => 'application/x-font-ttf',
            'ttf'          => 'application/x-font-ttf',
            'ttl'          => 'text/turtle',
            'twd'          => 'application/vnd.simtech-mindmapper',
            'twds'         => 'application/vnd.simtech-mindmapper',
            'txd'          => 'application/vnd.genomatix.tuxedo',
            'txf'          => 'application/vnd.mobius.txf',
            'txt'          => 'text/plain',
            'u32'          => 'application/x-authorware-bin',
            'udeb'         => 'application/x-debian-package',
            'ufd'          => 'application/vnd.ufdl',
            'ufdl'         => 'application/vnd.ufdl',
            'ulx'          => 'application/x-glulx',
            'umj'          => 'application/vnd.umajin',
            'unityweb'     => 'application/vnd.unity',
            'uoml'         => 'application/vnd.uoml+xml',
            'uri'          => 'text/uri-list',
            'uris'         => 'text/uri-list',
            'urls'         => 'text/uri-list',
            'ustar'        => 'application/x-ustar',
            'utz'          => 'application/vnd.uiq.theme',
            'uu'           => 'text/x-uuencode',
            'uva'          => 'audio/vnd.dece.audio',
            'uvd'          => 'application/vnd.dece.data',
            'uvf'          => 'application/vnd.dece.data',
            'uvg'          => 'image/vnd.dece.graphic',
            'uvh'          => 'video/vnd.dece.hd',
            'uvi'          => 'image/vnd.dece.graphic',
            'uvm'          => 'video/vnd.dece.mobile',
            'uvp'          => 'video/vnd.dece.pd',
            'uvs'          => 'video/vnd.dece.sd',
            'uvt'          => 'application/vnd.dece.ttml+xml',
            'uvu'          => 'video/vnd.uvvu.mp4',
            'uvv'          => 'video/vnd.dece.video',
            'uvva'         => 'audio/vnd.dece.audio',
            'uvvd'         => 'application/vnd.dece.data',
            'uvvf'         => 'application/vnd.dece.data',
            'uvvg'         => 'image/vnd.dece.graphic',
            'uvvh'         => 'video/vnd.dece.hd',
            'uvvi'         => 'image/vnd.dece.graphic',
            'uvvm'         => 'video/vnd.dece.mobile',
            'uvvp'         => 'video/vnd.dece.pd',
            'uvvs'         => 'video/vnd.dece.sd',
            'uvvt'         => 'application/vnd.dece.ttml+xml',
            'uvvu'         => 'video/vnd.uvvu.mp4',
            'uvvv'         => 'video/vnd.dece.video',
            'uvvx'         => 'application/vnd.dece.unspecified',
            'uvvz'         => 'application/vnd.dece.zip',
            'uvx'          => 'application/vnd.dece.unspecified',
            'uvz'          => 'application/vnd.dece.zip',
            'vcard'        => 'text/vcard',
            'vcd'          => 'application/x-cdlink',
            'vcf'          => 'text/x-vcard',
            'vcg'          => 'application/vnd.groove-vcard',
            'vcs'          => 'text/x-vcalendar',
            'vcx'          => 'application/vnd.vcx',
            'vis'          => 'application/vnd.visionary',
            'viv'          => 'video/vnd.vivo',
            'vob'          => 'video/x-ms-vob',
            'vor'          => 'application/vnd.stardivision.writer',
            'vox'          => 'application/x-authorware-bin',
            'vrml'         => 'model/vrml',
            'vsd'          => 'application/vnd.visio',
            'vsf'          => 'application/vnd.vsf',
            'vss'          => 'application/vnd.visio',
            'vst'          => 'application/vnd.visio',
            'vsw'          => 'application/vnd.visio',
            'vtt'          => 'text/vtt',
            'vtu'          => 'model/vnd.vtu',
            'vxml'         => 'application/voicexml+xml',
            'w3d'          => 'application/x-director',
            'wad'          => 'application/x-doom',
            'wav'          => 'audio/x-wav',
            'wax'          => 'audio/x-ms-wax',
            'wbmp'         => 'image/vnd.wap.wbmp',
            'wbs'          => 'application/vnd.criticaltools.wbs+xml',
            'wbxml'        => 'application/vnd.wap.wbxml',
            'wcm'          => 'application/vnd.ms-works',
            'wdb'          => 'application/vnd.ms-works',
            'wdp'          => 'image/vnd.ms-photo',
            'weba'         => 'audio/webm',
            'webapp'       => 'application/x-web-app-manifest+json',
            'webm'         => 'video/webm',
            'webp'         => 'image/webp',
            'wg'           => 'application/vnd.pmi.widget',
            'wgt'          => 'application/widget',
            'wks'          => 'application/vnd.ms-works',
            'wm'           => 'video/x-ms-wm',
            'wma'          => 'audio/x-ms-wma',
            'wmd'          => 'application/x-ms-wmd',
            'wmf'          => 'application/x-msmetafile',
            'wml'          => 'text/vnd.wap.wml',
            'wmlc'         => 'application/vnd.wap.wmlc',
            'wmls'         => 'text/vnd.wap.wmlscript',
            'wmlsc'        => 'application/vnd.wap.wmlscriptc',
            'wmv'          => 'video/x-ms-wmv',
            'wmx'          => 'video/x-ms-wmx',
            'wmz'          => 'application/x-msmetafile',
            'woff'         => 'application/x-font-woff',
            'wpd'          => 'application/vnd.wordperfect',
            'wpl'          => 'application/vnd.ms-wpl',
            'wps'          => 'application/vnd.ms-works',
            'wqd'          => 'application/vnd.wqd',
            'wri'          => 'application/x-mswrite',
            'wrl'          => 'model/vrml',
            'wsdl'         => 'application/wsdl+xml',
            'wspolicy'     => 'application/wspolicy+xml',
            'wtb'          => 'application/vnd.webturbo',
            'wvx'          => 'video/x-ms-wvx',
            'x32'          => 'application/x-authorware-bin',
            'x3d'          => 'model/x3d+xml',
            'x3db'         => 'model/x3d+binary',
            'x3dbz'        => 'model/x3d+binary',
            'x3dv'         => 'model/x3d+vrml',
            'x3dvz'        => 'model/x3d+vrml',
            'x3dz'         => 'model/x3d+xml',
            'xaml'         => 'application/xaml+xml',
            'xap'          => 'application/x-silverlight-app',
            'xar'          => 'application/vnd.xara',
            'xbap'         => 'application/x-ms-xbap',
            'xbd'          => 'application/vnd.fujixerox.docuworks.binder',
            'xbm'          => 'image/x-xbitmap',
            'xdf'          => 'application/xcap-diff+xml',
            'xdm'          => 'application/vnd.syncml.dm+xml',
            'xdp'          => 'application/vnd.adobe.xdp+xml',
            'xdssc'        => 'application/dssc+xml',
            'xdw'          => 'application/vnd.fujixerox.docuworks',
            'xenc'         => 'application/xenc+xml',
            'xer'          => 'application/patch-ops-error+xml',
            'xfdf'         => 'application/vnd.adobe.xfdf',
            'xfdl'         => 'application/vnd.xfdl',
            'xht'          => 'application/xhtml+xml',
            'xhtml'        => 'application/xhtml+xml',
            'xhvml'        => 'application/xv+xml',
            'xif'          => 'image/vnd.xiff',
            'xla'          => 'application/vnd.ms-excel',
            'xlam'         => 'application/vnd.ms-excel.addin.macroenabled.12',
            'xlc'          => 'application/vnd.ms-excel',
            'xlf'          => 'application/x-xliff+xml',
            'xlm'          => 'application/vnd.ms-excel',
            'xls'          => 'application/vnd.ms-excel',
            'xlsb'         => 'application/vnd.ms-excel.sheet.binary.macroenabled.12',
            'xlsm'         => 'application/vnd.ms-excel.sheet.macroenabled.12',
            'xlsx'         => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xlt'          => 'application/vnd.ms-excel',
            'xltm'         => 'application/vnd.ms-excel.template.macroenabled.12',
            'xltx'         => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
            'xlw'          => 'application/vnd.ms-excel',
            'xm'           => 'audio/xm',
            'xml'          => 'application/xml',
            'xo'           => 'application/vnd.olpc-sugar',
            'xop'          => 'application/xop+xml',
            'xpi'          => 'application/x-xpinstall',
            'xpl'          => 'application/xproc+xml',
            'xpm'          => 'image/x-xpixmap',
            'xpr'          => 'application/vnd.is-xpr',
            'xps'          => 'application/vnd.ms-xpsdocument',
            'xpw'          => 'application/vnd.intercon.formnet',
            'xpx'          => 'application/vnd.intercon.formnet',
            'xsl'          => 'application/xml',
            'xslt'         => 'application/xslt+xml',
            'xsm'          => 'application/vnd.syncml+xml',
            'xspf'         => 'application/xspf+xml',
            'xul'          => 'application/vnd.mozilla.xul+xml',
            'xvm'          => 'application/xv+xml',
            'xvml'         => 'application/xv+xml',
            'xwd'          => 'image/x-xwindowdump',
            'xyz'          => 'chemical/x-xyz',
            'xz'           => 'application/x-xz',
            'yang'         => 'application/yang',
            'yin'          => 'application/yin+xml',
            'z1'           => 'application/x-zmachine',
            'z2'           => 'application/x-zmachine',
            'z3'           => 'application/x-zmachine',
            'z4'           => 'application/x-zmachine',
            'z5'           => 'application/x-zmachine',
            'z6'           => 'application/x-zmachine',
            'z7'           => 'application/x-zmachine',
            'z8'           => 'application/x-zmachine',
            'zaz'          => 'application/vnd.zzazz.deck+xml',
            'zip'          => 'application/zip',
            'zir'          => 'application/vnd.zul',
            'zirz'         => 'application/vnd.zul',
            'zmm'          => 'application/vnd.handheld-entertainment+xml'
        );
    }

    /**
     * Delete the Physical File from path.
     *
     * NOTE:
     * Public path with unlink() function won't work if
     * symlink is not activated.
     *
     * SOLUTION:
     * php artisan storage:link
     *
     * @param string $fileName File Name.
     *
     * @return boolean True if succeed, False otherwise.
     */
    public function deleteFileFromPath($fileName)
    {
        if ($this->isImage($fileName)) {
            $theImage = $this->image_path . $fileName;

            if (file_exists($theImage)) {
                unlink($theImage);
                unlink($this->image_medium_path . $fileName);
                unlink($this->image_thumb_path . $fileName);

                return true;
            }
        } else {
            $theFile = $this->file_path . $fileName;

            if (file_exists($theFile)) {
                unlink($theFile);

                return true;
            }
        }

        return false;
    }

    /**
     * Upload Single File.
     *
     * Uniform method for uploading image and non-image files
     * in separate directories. Image files will be resized
     * in two other sizes: 'medium' and 'thumbnail'.
     *
     * @param string $fileName File to upload.
     * @param string $existing_file Existing File if exists, default empty.
     * @param string $existing_mime_type Existing MIME Type if exists, default empty.
     *
     * @link https://artisansweb.net/upload-resize-multiple-images-laravel/
     *
     * @return array If uploaded successfully then array of file info, array of errors otherwise.
     */
    public function uploadFile($fileName, $existing_file = '', $existing_mime_type = '')
    {
        $errors           = array();
        $new_file         = $fileName;
        $image_mime_types = $this->imageMimeTypes();

        $accepted_extensions = (string)config('uploads.default_extensions');
        $accepted_mime_types = $this->mimeTypesFromExtensions($accepted_extensions);

        $maximum_upload_size = (int)getOption('attachments_max_file_size');

        if (!empty($new_file) || !empty($existing_file)) {
            if (!empty($new_file)) {
                // File MIME type.
                $new_mime_type = $new_file->getClientMimeType();

                // Get filename with extension, eg. 'abc.jpg'.
                $filenameWithExtension = $new_file->getClientOriginalName();

                // Get filename without extension, eg. 'abc'.
                $filenameWithoutExtension = pathinfo($filenameWithExtension, PATHINFO_FILENAME);

                // Get file extension, eg. 'jpg'.
                $fileExtension = $new_file->getClientOriginalExtension();

                // File size exceeds - bail out.
                if ((filesize($new_file) > $maximum_upload_size) || (filesize($new_file) == 0)) {
                    $errors['file_size'] = sprintf(__('File size exceeds %sMB'), $this->bytesToMb($maximum_upload_size, true));
                }

                // MIME type mismatch - bail out.
                if (!empty($new_mime_type) && !in_array($new_mime_type, $accepted_mime_types)) {
                    if (false === $this->isValidAltMimeTypes($fileExtension, $new_mime_type)) {
                        $errors['mime_type'] = __('File type not supported');
                    }
                }

                if (0 === count($errors)) {
                    if (in_array($new_mime_type, $accepted_mime_types)) {
                        // Filename to Store.
                        $fileNameToStore = $this->sanitizeFilename($filenameWithoutExtension) . '-' . time() . '.' . strtolower($fileExtension); // Filename stored by filename, time & extension.

                        if (in_array($new_mime_type, $image_mime_types)) {
                            // THE IMAGE -----------------.
                            // NOTE: We're keeping the same file in three directories, but
                            // we'll resize and overrite them using intervension/image.
                            Storage::put('public/uploads/images/' . $fileNameToStore, fopen($new_file, 'r+'), 'public');
                            Storage::put('public/uploads/images/medium/' . $fileNameToStore, fopen($new_file, 'r+'), 'public');
                            Storage::put('public/uploads/images/thumbnail/' . $fileNameToStore, fopen($new_file, 'r+'), 'public');

                            // Medium: Resize and Replace.
                            $mediumPath = $this->image_medium_path . $fileNameToStore;
                            $mediumImg  = Image::make($mediumPath)->resize(
                                400,
                                null,
                                function ($constraint) {
                                    $constraint->aspectRatio();
                                    $constraint->upsize();
                                }
                            );
                            $mediumImg->save($mediumPath);

                            // Thumbnail: Resize and Replace.
                            $thumbnailPath = $this->image_thumb_path . $fileNameToStore;
                            $thumbImg      = Image::make($thumbnailPath)->fit(150, 150);
                            $thumbImg->save($thumbnailPath);
                        } else {
                            // THE FILE ------------------.
                            $new_file->storeAs('public/uploads/files/', $fileNameToStore);
                        }

                        // Delete existing_file before Updating new_file.
                        if (!empty($new_file) && !empty($existing_file)) {
                            $this->deleteFileFromPath($existing_file);
                        }

                        return array(
                            'mime_type' => $new_mime_type,
                            'file'      => $fileNameToStore
                        );
                    }
                } else {
                    return array(
                        '_error' => $errors
                    );
                }
            } else {
                // Existing file - do nothing.
                if (!empty($existing_file) && ($new_file == null)) {
                    // Extra layer of security, if altered from the UI.
                    if (in_array($existing_mime_type, $accepted_mime_types)) {
                        return array(
                            'mime_type' => $existing_mime_type,
                            'file'      => $existing_file
                        );
                    }
                }
            }
        } else {
            $errors['mandatory'] = __('A file must be provided');

            return array(
                '_error' => $errors
            );
        }
    }

    /**
     * Save Upload.
     *
     * @param  array $file Array of Form file.
     * @param string $existing_file Existing File if exists, default empty.
     * @param string $existing_mime_type Existing MIME Type if exists, default empty.
     * @param  array $args Array of Arguments.
     *
     * @return object                 upload object.
     * -----------------------------------
     */
    public function uploadAndSaveFile($file, $existing_file = '', $existing_mime_type = '', $args = [])
    {
        $inputs = [];
        $defaults = array(
            'author'   => Auth::id(),
            'title_en' => '',
            'title_bn' => '',
        );

        $arguments = parseArguments($args, $defaults);

        $inputs['created_by'] = $arguments['author'];
        $upload = $this->uploadFile($file, $existing_file, $existing_mime_type);

        if (isset($upload['_error'])) {
            return $upload;
        }

        $inputs['title_en']  = empty($arguments['title_en']) ? $this->makeUploadTitleFromFile($upload['file']) : $arguments['title_en'];
        $inputs['title_bn']  = empty($arguments['title_bn']) ? $this->makeUploadTitleFromFile($upload['file']) : $arguments['title_bn'];
        $inputs['mime_type'] = $upload['mime_type'];
        $inputs['file']      = $upload['file'];

        return DB::table('uploads')->insertGetId($inputs);
    }

    public function uploadAndSaveMultipleFiles($files)
    {
        $file_info = array();

        $counter = 1;

        if (!empty($files)) {
            foreach ($files as $file) {
                $upload = $this->uploadAndSaveFile($file);

                if (!empty($upload['_error'])) {
                    // When errors.
                    $file_info["_error_{$counter}"] = current($upload['_error']) . ' ' . sprintf(__('for the file %s'), $file->getClientOriginalName());
                } else {
                    // When succeeded.
                    $file_info["_success_{$counter}"] = $upload;
                }

                $counter++;
            }
        } else {
            $file_info['_error'] = __('A file must be provided');
        }

        return $file_info;

       //TODO:: For Store Controller
       //$fileName = $request->file('uploads');
       //$this->upload->uploadAndSaveFile($fileName); // for Single File
       //$uploads = $this->upload->uploadAndSaveMultipleFiles($fileName); // for Multiple File
    }

    /**
     * Delete the specified resource in storage Using Ajax.
     *
     * @param int $upload_id Upload ID.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteUpload($upload_id)
    {
        $upload = $this->find($upload_id);

        if (!empty($upload->file)) {
            $this->deleteFileFromPath($upload->file);
            $upload->delete();
        }

        return response()->json(array(
            'success' => __('File Deleted Successfully!')
        ));
    }

    /**
     * Validate Mandatory Upload File
     *
     * @param string $uploads Upload File.
     *
     * @return array
     */
    public function validateMandatoryUpload($uploads)
    {
        if (isset($uploads['_error']) && $uploads['_error']) {
            return $uploads['_error'];
        }

        $success = array();
        $error   = array();

        foreach ($uploads as $key => $upload) {
            if (strpos($key, '_success') !== false) {
                $success[] = $upload;
            } else {
                $error[] = $upload;
            }
        }

        if (count($success) > 0) {
            return false;
        }

        return $error;
    }

    /**
     * Attach Upload File
     *
     * @param string $uploads Upload File.
     * @param string $table Upload Table name.
     * @param string $data Upload Data.
     *
     * @return array
     */
    public function attachUploads($uploads, $table, $data)
    {
        $err = array();

        foreach ($uploads as $key => $upload) {
            $data = array_merge($data, array('upload_id' => $upload));

            if (strpos($key, '_error') === false) {
                DB::table($table)->insert($data);
            } else {
                $err[] = $upload;
            }
        }

        return $err;
    }
}
