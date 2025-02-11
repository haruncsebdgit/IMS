<?php
/**
 * ---------------------------------------------------------------------
 * Configurations for Upload
 * ---------------------------------------------------------------------
 */

return [
    /**
     * Upload Path
     *
     * Path where to upload files.
     *
     * Accepts: string
     *
     * Default: (string) 'uploads/' - relative to /storage/app/public/
     * ---------------------------------------------------------------------
     */
    'upload_path'        => 'uploads/',

    /**
     * Maximum Upload Size.
     *
     * Maximum size of upload per file.
     *
     * Accepts: integer
     *
     * Default: (integer) 5242880 - 5mb in binary bytes
     * ---------------------------------------------------------------------
     */
    'upload_max_size'    => 5242880,  // 5mb in binary bytes

    /**
     * Maximum Number of Files.
     *
     * Maximum number of files allowed when using bulk uploader.
     *
     * Accepts: integer
     *
     * Default: (integer) 20 (files)
     * ---------------------------------------------------------------------
     */
    'maximum_files'      => 20, // files.

    /**
     * Default File Extensions.
     *
     * Default accepted file extensions are mentioned here.
     * Will be applicable when per file extensions
     * are not available.
     *
     * Accepts: string
     *
     * Default: (string) '.jpg, .jpeg, .gif, .png, .pdf, .doc, .docx, .xls, .xlsx, .mp4, .mp3, .ogg, .wav, .wma, .webm, .mpeg'
     * ---------------------------------------------------------------------
     */
    'default_extensions' => '.jpg, .jpeg, .gif, .png, .pdf, .doc, .docx, .xls, .xlsx, .mp4, .mp3, .ogg, .wav, .wma, .webm, .mpeg',
];
