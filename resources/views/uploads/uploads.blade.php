<?php
$is_required_label_class = isset($uploads) && count($uploads) > 0 ? 'd-none' : '';
$is_required             = isset($uploads) && count($uploads) > 0 ? '' : "";
$default_extensions      = config('uploads.default_extensions');
$accepted_extensions     = $accepted_extensions ?? $default_extensions;
$default_label           = __('Attachments');
$label                   = $label ?? $default_label;
?>

<div class="file-upload-group form-group">
    <label for="upload-file-path" class="font-weight-bold">
        {{ $label }}
        <sup id="upload-required-warning" class="text-danger {{ $is_required_label_class }}">*</sup>
    </label>

    <div class="input-group">
        <div class="custom-file">
            <input type="file" name="uploads[]" class="custom-file-input" {{ $is_required }} id="upload-file-path" multiple aria-describedby="file-upload-btn" accept="{{ $accepted_extensions }}">

            <label class="custom-file-label" for="upload-file-path">
                {{ __('Choose File') }}
            </label>
        </div>
    </div>

    <span class="text-muted small">
        {{ __('Allowed file types: :file_type. Maximum upload size: :file_size',['file_type' => $accepted_extensions,'file_size' => formatBytes((int)getOption('attachments_max_file_size'))]) }}
    </span>
</div>

@if(isset($uploads))
    <input type="hidden" name="upload_count" id="upload-count" value="{{ count($uploads) }}">

    <ul class="list-group mb-3">
        @foreach($uploads as $upload)
            <?php
            $filePath           = \App\Models\Upload::getFilePath($upload->file);
            $stripped_file_name = '...' . substr(basename($upload->file), -100);
            ?>

            <li class="list-group-item upload-file" id="upload-raw-{{ $upload->id }}">
                <button type="button" class="btn btn-danger btn-sm float-right delete-upload" data-id="{{ $upload->id }}">
                    <i class="icon-trash" aria-hidden="true"></i>
                    <span class="sr-only">{{ __('Delete Attachment') }}</span>
                </button>

                <a href="{{ $filePath }}" target="_blank" rel="noopener">
                    <span class="badge badge-secondary badge-pill"><i class="icon-attachment" aria-hidden="true"></i></span>
                    {{ $stripped_file_name }}
                </a>
            </li>
        @endforeach
    </ul>
@endif
