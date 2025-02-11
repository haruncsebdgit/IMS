/**
 * Created by Farhana on 8/17/2020.
 */

let app = jQuery.parseJSON(app_data);

function getOrganogramId (organogramId) {
    $('#organogram-id').val(organogramId);
}

jQuery(document).ready(function ($) {

    // Loading employee by employee designation
     $('#emp-designation').change(function () {
         let app_locale = app.app_locale;
         
         var designationId = $(this).val();
         if (designationId) {
             $.get(app.app_url + 'admin/users/getEmployeeByDesignation/' + designationId, function (data) {
                 let employee = $('#emp-id');
                 data = JSON.parse(data);
                 if(employee.length > 0) {
                     //success data
                     employee.empty();
                     employee.append('<option value="">' + app.label_select + '</option>');

                     $.each(data, function (index, value) {
                         employee.append('<option value="' + index + '">' + value + '</option>');
                     });
 
                     /**
                      * Trigger only for select2
                      */
                      //method.val('').trigger('change');
                 }
             });
         }
     })

     // Getting employe basic data by selecting employee dropdown
     $('#emp-id').change(function () {
        var employeeId = $(this).val();
        if (employeeId) {
            $('#employee-id-hidden').val(employeeId);
            $.get(app.app_url + 'admin/users/getEmployeeByEmployeeId/' + employeeId, function (data) {
                data = JSON.parse(data);
                console.log(data.organogram_ids);
                $('#name-en').val(data.name_en);
                $('#name-bn').val(data.name_bn);
                $('#email').val(data.email);
                // console.log(data.employee_image);
                if(data.employee_image) {
                    $('#employee-image').val(data.employee_image);
                    $('#user-image-fullview').attr('href', '/storage/uploads/images/' + data.employee_image);
                    $('#user-image-preview').attr('src', '/storage/uploads/images/' + data.employee_image);
                }
                
                $('.organogram-jstree').jstree('select_node', data.organogram_ids);
            });
        }
    })
    $('.user-type').change(function () {
        var type = $(this).val();
        //alert(type);
        $('#designation-div').addClass('d-none');
        $('#emp-div').addClass('d-none');
        if(type == 'internal') {
            $('#designation-div').removeClass('d-none');
            $('#emp-div').removeClass('d-none');
        }
        
    });

    $('#project-id').select2({
        placeholder: "Choose User...",
        ajax: {
            url: app.app_url + 'admin/users/project/getProjectsBySearchParam',
            dataType: 'json',
            data: function (params) {
                return {
                    q: $.trim(params.term) || '',
                    page: params.page || 1
                };
            },
            processResults: function (data) {
                return {
                    results: data.results,
                    pagination: {
                        more: data.more
                    }
                };
            },
            cache: true
        }
    });
    // ------------------------------------------
    // Control the User Image Upload and Existing User Image
    // conditional block.
    // ------------------------------------------
    var user_image_upload_group   = $('.user-image-upload-group');
    var user_image_existing_group = $('.user-image-existing-group');

    $(document).on('click', '.user-image-upload-holder .user-image-existing-group .btn-user-image-remove', function () {
        user_image_upload_group.removeClass('d-none');
        //alert(userImage);
        $('#user-image-preview').attr('src', userImage);
        //user_image_existing_group.addClass('d-none');

        $("#remove-existing-user-image").val("yes");
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

    $("#user-image").change(function() {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                $('#user-image-preview').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
});