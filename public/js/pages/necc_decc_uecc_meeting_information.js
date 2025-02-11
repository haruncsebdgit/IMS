
    $(document).ready(function() {
        $('body').on('click', '.delete-upload', function(e) {
            if (confirm('Are you sure you want to delete this file permanently?')) {
                var this_btn = $(this);
                var uploadId = this_btn.data('id');
                var neId = this_btn.data('neid');          
                var this_group = this_btn.parents('.file-upload-group');

                $.ajax({
                    type: 'DELETE'
                    , url: '/bn/admin/monitoring/necc-decc-uecc-meeting-information/delete-attachment/' + neId + '/' + uploadId
                    , dataType: 'json'
                    , success: function(data) {

                            if (data.error == 0) {
                                this_group.find('.file-upload-display').slideUp('slow', function() {
                                    this_group.find('.file-upload-display').remove();
                                    this_group.find('.file-upload-item').removeClass('d-none');
                                });
    
                                $.notify('<strong>' + data.message, {
                                    type: 'success'
                                });
    
                            } else {
                                $.notify('<strong>' + data.message, {
                                    type: 'danger'
                                });
                            }
    
                            console.log($(this).parent().attr('class'));
                        }
                        , error: function(data) {
                            console.log('Error:', data);
                        }
                        
                });
            }

        });

    });