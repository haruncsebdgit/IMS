function uuidv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
      return v.toString(16);
    });
}
function validateInput(object)
{
  //console.log(object.className);
  if (object.value) {
    object.className = 'form-control';
  } else {
    object.className = 'form-control is-invalid';
  }
}

$(document).ready(function() {
    /**
     * Pond information form repeater for DoF
     */


    /**
     * DAE Participant Details
     */

     var participantDesignationId;
     var participantDesignationName;
     var elmParticipantDeignation = document.getElementById('participant_des_id');
     var participantNumber;
     var elmTableParticipant = $('#table-participant-details');
     $('body').on('click', '#btn-participant-details', function() {

         participantNumber = document.getElementById('num_of_participant').value;
         participantDesignationName = elmParticipantDeignation.options[elmParticipantDeignation.selectedIndex].text;
         participantDesignationId = elmParticipantDeignation.value;


         // Validating form
         var isValidate = true;
         $('#participant_des_id').removeClass('is-invalid');
         $('#num_of_participant').removeClass('is-invalid');
         if(!participantDesignationId) {
             $('#participant_des_id').addClass('is-invalid');
             isValidate = false;
         }

         if(!participantNumber) {
             $('#num_of_participant').addClass('is-invalid');
             isValidate = false;
         }

         if(!isValidate) {
             return;
         }

         var existingRowId = $('#participant_details_row_uid').val();
         if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
            updateParticipantDetailsData(existingRowId);
         } else {
             addParticipantDetailsData();
         }

         $('#participant_details_row_uid').val('');
         // Removing data from input field after successfully adding to list
         $('#participant_des_id').val('');
         $('#num_of_participant').val('');
     });

     function addParticipantDetailsData() {
         var uid = uuidv4();


         // Build table row for added dynamically
         var row = "<tr class='rows'><td><span id='participant-des-id-view-" + uid + "'>"+ participantDesignationName + "</span>" +
                 "<input class='participant-des-id' id='participant-des-id-" + uid + "'name='participant-designation[]' type='hidden' value='"+participantDesignationId+"'>" + "</td><td>"+
                 "<span id='participant-number-view-" + uid + "'>" + participantNumber + "</span>" +
                "<input class='participant-number' id='participant-number-id-" + uid + "'name='participant-number[]' type='hidden' value='"+participantNumber+"'>" + "</td><td>"+
                 "<a class='edit-participant-details btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                 "<a class='remove-participant-details btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                 + "</td></tr>";

                 elmTableParticipant.find('tbody').append(row);
     }

     function updateParticipantDetailsData(rowUid) {
         $('#participant-des-id-view-' + rowUid).text(participantDesignationName);
         $('#participant-des-id-' + rowUid).val(participantDesignationId);


         $('#participant-number-view-' + rowUid).text(participantNumber);
         $('#participant-number-id-' + rowUid).val(participantNumber);

     }

     elmTableParticipant.on('click', '.rows a.edit-participant-details', function (e) {
         var rowUid = $(this).attr('uid');
         $('#participant_details_row_uid').val(rowUid);

         $('#participant_des_id').val($('#participant-des-id-' + rowUid).val()).trigger('focus');
         $('#num_of_participant').val($('#participant-number-id-' + rowUid).val());
     });
     // Delete a pond details list row
     elmTableParticipant.on('click', '.rows a.remove-participant-details', function (event) {
         if( confirm('Are you sure?') ) {
             $(this).parents("tr:first").remove();
             $(this).parent().parent().remove();
         }

     });
    });
