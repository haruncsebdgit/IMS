/**
 * Created by Farhana on 02/16/2021.
 */

jQuery(function ($) {
   
    $('body').on('click', '.request-add-new-farmer', function (e) {
        e.preventDefault();
        var correctionModal = $('#add-new-farmer-modal');
        var modalBody = correctionModal.find('.content');
        correctionModal.modal('show');
    });


    // Clear the modal field on modal hide.
    $('#add-new-farmer-modal').on('hidden.bs.modal', function (e) {
        location.reload();
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Update Existing Data using Ajax (For Update Button)
    var modal_form = $('#correctiondata');
    modal_form.on('submit', function (e) {
       alert("dsfasdf");
        if (modal_form[0].checkValidity()) {
            var correctionComments = $('#correction-comments').val();
            
            var formData = {
                comments: correctionComments
            };

        
            $.ajax({
                type: 'put',
                url: app.app_url + 'admin/monitoring/scheme/bgcc-meeting/correction/update-ajax',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    if (data.error == 0) {
                       
                        if (data.message == 'submitMessage') {
                            var successMsg = app.submit_message;
                        }else if (data.message == 'updateMessage') {
                            var successMsg = app.update_message;
                        }

                        $.notify('<strong>' + successMsg, {
                            type: 'success'
                        });
                    } else {
                        $.notify('<strong>' + data.message, {
                            type: 'danger'
                        });
                    }

                    $('#correctiondata').trigger("reset");
                    $('#add-new-farmer-modal').modal('hide');
                    window.location.reload(true);
                },
            });
        }
    });
});