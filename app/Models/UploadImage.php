<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Upload as BaseUpload;
use Auth;
use Illuminate\Support\Facades\Storage; //Laravel Filesystem
use DB;
use Cache;
use Image; //Intervention Image

class UploadImage extends Model
{
    private $baseUpload;
    public $uploadPath;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->baseUpload = new BaseUpload;
        //$this->uploadPath  = 'scheme/' .date('Y-m') . "/";
    }

    /**
     * Delete the specified resource in storage Using Ajax.
     *
     * @param int $upload_id Upload ID.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteUpload($fileName)
    {
        //$upload = $this->find($upload_id);

        if (!empty($fileName)) {
            $this->deleteFileFromPath($fileName);
            //$upload->delete();
        }

        return response()->json(array(
            'success' => __('File Deleted Successfully!')
        ));
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
        if ($this->baseUpload->isImage($fileName)) {
            $theImage = $this->baseUpload->image_path . $fileName;

            if (file_exists($theImage)) {
                unlink($theImage);

                return true;
            }
        } else {
            $theFile = $this->baseUpload->file_path . $fileName;

            if (file_exists($theFile)) {
                unlink($theFile);

                return true;
            }
        }

        return false;
    }

      /**
     * Save Upload.
     *
     * @param  array $file Array of Form file.
     * @param $moduleName Module name of uploading image
     * @param string $existing_file Existing File if exists, default empty.
     * @param string $existing_mime_type Existing MIME Type if exists, default empty.
     * @param  array $args Array of Arguments.
     *
     * @return object                 upload object.
     * -----------------------------------
     */
    public function uploadAndSaveFile($file, $moduleName = "scheme", $existing_file = '', $existing_mime_type = '', $args = [])
    {
        $this->uploadPath  = $moduleName . '/' .date('Y-m') . "/";

        $upload = $this->uploadFile($file, $existing_file, $existing_mime_type);
        // dd($upload);
        if (isset($upload['_error'])) {
            return $upload;
        }

        return  $this->uploadPath . $upload['file'];
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
        $image_mime_types = $this->baseUpload->imageMimeTypes();

        $accepted_extensions = (string)config('uploads.default_extensions');
        $accepted_mime_types = $this->baseUpload->mimeTypesFromExtensions($accepted_extensions);

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
                    $errors['file_size'] = sprintf(__('File size exceeds %sMB'), $this->baseUpload->bytesToMb($maximum_upload_size, true));
                }

                // MIME type mismatch - bail out.
                if (!empty($new_mime_type) && !in_array($new_mime_type, $accepted_mime_types)) {
                    if (false === $this->baseUpload->isValidAltMimeTypes($fileExtension, $new_mime_type)) {
                        $errors['mime_type'] = __('File type not supported');
                    }
                }

                if (0 === count($errors)) {
                    if (in_array($new_mime_type, $accepted_mime_types)) {
                        // Filename to Store.
                        $fileNameToStore = $this->baseUpload->sanitizeFilename($filenameWithoutExtension) . '-' . time() . '.' . strtolower($fileExtension); // Filename stored by filename, time & extension.

                        if (in_array($new_mime_type, $image_mime_types)) {
                            // THE IMAGE -----------------.
                            // NOTE: We're keeping the same file in three directories, but
                            // we'll resize and overrite them using intervension/image.
                            //Storage::put('public/uploads/images/' . $fileNameToStore, fopen($new_file, 'r+'), 'public');
                            Storage::put('public/uploads/images/'. $this->uploadPath . $fileNameToStore, fopen($new_file, 'r+'), 'public');
                            //Storage::put('public/uploads/images/thumbnail/' . $fileNameToStore, fopen($new_file, 'r+'), 'public');

                            // Medium: Resize and Replace.
                            $mediumPath = storage_path('app/public/uploads/images/' . $this->uploadPath) . $fileNameToStore;
                            $mediumImg  = Image::make($mediumPath)->resize(
                                3000,
                                null,
                                function ($constraint) {
                                    $constraint->aspectRatio();
                                    $constraint->upsize();
                                }
                            );
                            //$mediumImg  = Image::make($mediumPath)->encode('jpg', 80);
                            $mediumImg->save($mediumPath, 60);

                            // Thumbnail: Resize and Replace.
                            /* $thumbnailPath = $this->image_thumb_path . $fileNameToStore;
                            $thumbImg      = Image::make($thumbnailPath)->fit(150, 150);
                            $thumbImg->save($thumbnailPath); */
                        } else {
                            // THE FILE ------------------.
                            $new_file->storeAs('public/uploads/files/'. $this->uploadPath, $fileNameToStore);
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
}
