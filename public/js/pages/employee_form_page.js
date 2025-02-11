/**
 * Created by Farhana on 5/31/2020.
 */
var app = jQuery.parseJSON(app_data);

function getOrganogramId (organogramId) {
    $('#organogram-id').val(organogramId);
}

jQuery(document).ready(function ($) {
    // ------------------------------------------
    // Control the Employee Image Upload and Existing Employee Image
    // conditional block.
    // ------------------------------------------
    var employee_image_upload_group   = $('.employee-image-upload-group');
    var employee_image_existing_group = $('.employee-image-existing-group');

    $(document).on('click', '.employee-image-upload-holder .employee-image-existing-group .btn-employee-image-remove', function () {
        employee_image_upload_group.removeClass('d-none');
        employee_image_existing_group.addClass('d-none');

        $("#remove-existing-employee-image").val("yes");
    });

    // ------------------------------------------
    // Display the file when file is chosen.
    // @link https://github.com/twbs/bootstrap/issues/20813
    // ------------------------------------------
    const default_file_label = $('.custom-file-label').text();
    $(document).on('change', '.custom-file-input', function () {
        var fileName   = $(this).val().replace(/\\/g, '/').replace(/.*\//, '');
        var file_label = $(this).parent('.custom-file').find('.custom-file-label');
        if (fileName.length > 0) {
            file_label.text(fileName);
        } else {
            file_label.text(default_file_label);
        }
    });
});
