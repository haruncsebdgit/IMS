
    $(document).ready(function() {
        // ------------------------------------------
    // Control the attachment Upload and Existing attachment
    // conditional block.
    // ------------------------------------------
    var file_upload_group   = $('.file-upload-group');
    var file_existing_group = $('.file-existing-group');

    $(document).on('click', '.file-existing-group .btn-file-remove', function () {
        file_upload_group.removeClass('d-none');
        file_existing_group.addClass('d-none');

        
    });
        $('body').on('click', '.delete-upload', function(e) {
            if (confirm('Are you sure you want to delete this file permanently?')) {
                var this_btn = $(this);
                var upload_count  = $('#upload-count').val();
                var uploadId = this_btn.data('id');
                var neId = this_btn.data('neid');          
                // var this_group = this_btn.parents('.file-upload-group');

                $.ajax({
                    type: 'DELETE'
                    , url: '/bn/admin/procurement/committee-info/delete-attachment/' + neId + '/' + uploadId
                    , dataType: 'json'
                    , success: function(data) {

                            if (data.error == 0) {
                                var upload_row = $('#upload-raw-' + neId);
                                upload_row.slideUp('slow', function () {
                                    upload_row.remove();
        
                                    $('#upload-count').val(upload_count - 1);
        
                                    if ($('.upload-file').length == 0) {
                                        $('.attach-file').prop('required', true);
        
                                        $('#upload-required-warning').removeClass('d-none');
                                    }
        
                                   
                                });
    
                                $.notify('<strong>' + data.message, {
                                    type: 'success'
                                });
    
                            } else {
                                $.notify('<strong>' + data.message, {
                                    type: 'danger'
                                });
                            }
                            // Redirect to edit page.
                        window.location.href = '/bn/admin/procurement/committee-info/edit/' + neId ;
    
                            console.log($(this).parent().attr('class'));
                        }
                        , error: function(data) {
                            console.log('Error:', data);
                        }
                        
                });
            }

        });

    });


    // Handle Delete Upload of Video.
    // $('.delete-upload').click(function (e) {
    //     if (confirm('Are you sure you want to delete this file permanently?')) {
    //         var upload_count  = $('#upload-count').val();
    //         var master_id = $(this).data('id');

    //         $.ajax({
    //             type: 'DELETE',
    //             url: app.app_url + 'admin/' + app.common_url + 'video/' + master_id + '/delete',
    //             dataType: 'json',
    //             success: function (data) {
    //                 if('video_delete' === data){
    //                     var upload_row = $('#upload-raw-' + master_id);

    //                     upload_row.slideUp('slow', function () {
    //                         upload_row.remove();

    //                         $('#upload-count').val(upload_count - 1);

    //                         if ($('.upload-file').length == 0) {
    //                             $('#upload-file-path').prop('required', true);

    //                             $('#upload-required-warning').removeClass('d-none');
    //                         }

    //                         $('#video-view').hide();
    //                     });

    //                     // Redirect to add page.
    //                     window.location.href = app.app_url + 'admin/' + app.common_url + master_id + '/add';

    //                     // Redirect to edit page.
    //                     // window.location.href = app.app_url + 'admin/' + app.common_url + master_id + '/edit';
    //                 }
    //             },
    //             error: function (data) {
    //                 // console.log('Error:', data);

    //                 if('video_delete' !== data){
    //                     alert(app.video_id_not_matched);

    //                     // Redirect to add page.
    //                     window.location.href = app.app_url + 'admin/' + app.common_url + master_id + '/add';
    //                 }
    //             }
    //         });
    //     }
    // });