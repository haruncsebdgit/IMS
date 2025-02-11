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

    // console.log('hi');
    // noOfBatch = document.getElementById('number_of_batch').value;
    //     participantPerBatch = document.getElementById('participant_per_batch').value;
    //     totalParticipants = noOfBatch*participantPerBatch;
    // $('#no_of_total_participants').val(totalParticipants);
    
    $("#number_of_batch,#participant_per_batch").keyup(function(){
        var noOfBatch = document.getElementById('number_of_batch').value;
        var participantPerBatch = document.getElementById('participant_per_batch').value;
        $('#no_of_total_participants').val(noOfBatch*participantPerBatch);
        $("#no_of_total_participants").prop('disabled', true);
      });  
      
      $("#training_duration,#number_of_batch,#participant_per_batch").keyup(function(){
        var trainingDuration = document.getElementById('training_duration').value;
        var noOfBatch = document.getElementById('number_of_batch').value;
        var participantPerBatch = document.getElementById('participant_per_batch').value;
        $('#total_client_days').val(trainingDuration*(noOfBatch*participantPerBatch));
        $("#total_client_days").prop('disabled', true);
      });
  $("#no_of_female_participants").keyup(function(){
        var totalParticipants = document.getElementById('no_of_total_participants').value;
        var femaleParticipant = document.getElementById('no_of_female_participants').value;
        $('#no_of_male_participants').val(totalParticipants-femaleParticipant);
        $("#no_of_male_participants").prop('disabled', true);
      });


    /**
     * Pond information form repeater for DoF
     */



    var trainingTitleId;

    var trainingTitleName;

    var trainingTitle = document.getElementById('training_title_id');
    var elmTablePond = $('#table-training-open-details');
    $('body').on('click', '#btn-training-open-details', function() {

        

        trainingDuration = document.getElementById('training_duration').value;
        noOfBatch = document.getElementById('number_of_batch').value;
        participantPerBatch = document.getElementById('participant_per_batch').value;
        totalParticipants = document.getElementById('no_of_total_participants').value;
        femaleParticipants = document.getElementById('no_of_female_participants').value;
        maleParticipants = document.getElementById('no_of_male_participants').value;
        ethnicParticipants = document.getElementById('total_ethnic_participants').value;
        femaleethnicParticipants = document.getElementById('total_ethnic_female_participants').value;
        totalClientDays = document.getElementById('total_client_days').value;



        trainingTitleName = trainingTitle.options[trainingTitle.selectedIndex].text;
        trainingTitleId = trainingTitle.value;

        // Validating form
        var isValidate = true;
        $('#training_title_id').removeClass('is-invalid');
        $('#training_duration').removeClass('is-invalid');
        $('#number_of_batch').removeClass('is-invalid');
        $('#no_of_total_participants').removeClass('is-invalid');
        $('#no_of_female_participants').removeClass('is-invalid');
        $('#no_of_male_participants').removeClass('is-invalid');
        $('#total_ethnic_participants').removeClass('is-invalid');
        $('#total_ethnic_female_participants').removeClass('is-invalid');
        $('#total_client_days').removeClass('is-invalid');


        
        if(!trainingTitleId) {
            $('#training_title_id').addClass('is-invalid');
            isValidate = false;
        }
        if(!trainingDuration) {
            $('#training_duration').addClass('is-invalid');
            isValidate = false;
        }
        if(!noOfBatch) {
            $('#number_of_batch').addClass('is-invalid');
            isValidate = false;
        }
        if(!totalParticipants) {
            $('#no_of_total_participants').addClass('is-invalid');
            isValidate = false;
        }
         if(!femaleParticipants) {
            $('#no_of_female_participants').addClass('is-invalid');
            isValidate = false;
        } 
        if(!maleParticipants) {
            $('#no_of_male_participants').addClass('is-invalid');
            isValidate = false;
        } 
        if(!ethnicParticipants) {
            $('#total_ethnic_participants').addClass('is-invalid');
            isValidate = false;
        }
        if(!femaleethnicParticipants) {
            $('#total_ethnic_female_participants').addClass('is-invalid');
            isValidate = false;
        } 
        if(!totalClientDays) {
            $('#total_client_days').addClass('is-invalid');
            isValidate = false;
        }

        if(!isValidate) {
            return;
        }

        var existingRowId = $('#training_open_details_row_uid').val();
        if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
            updateTrainingOpenDetailsData(existingRowId);
        } else {
            addTrainingOpenDetailsData();
        }

        $('#training_open_details_row_uid').val('');
        // Removing data from input field after successfully adding to list
        $('#training_title_id').val('');
        $('#training_duration').val('');
        $('#number_of_batch').val('');
        $('#participant_per_batch').val('');
        $('#no_of_total_participants').val('');
        $('#no_of_female_participants').val('');
        $('#no_of_male_participants').val('');
        $('#total_ethnic_participants').val('');
        $('#total_ethnic_female_participants').val('');
        $('#total_client_days').val('');
    });

    function addTrainingOpenDetailsData() {
        var uid = uuidv4();
        
        // Build table row for added dynamically
        var row = "<tr class='rows'><td><span id='training-title-view-" + uid + "'>" + trainingTitleName + "</span>" + 
                "<input class='training-title' id='training-title-" + uid + "'name='training_title[]' type='hidden' value='"+trainingTitleId+"'>" + "</td><td>"+
                "<span id='training-duration-view-" + uid + "'>" + trainingDuration + "</span>" + 
                "<input class='training-duration' id='training-duration-" + uid + "'name='training_duration[]' type='hidden' value='"+trainingDuration+"'>" + "</td><td>"+
                "<span id='no-of-batch-view-" + uid + "'>" + noOfBatch + "</span>" + 
                "<input class='no-of-batch' id='no-of-batch-" + uid + "'name='no_of_batch[]' type='hidden' value='"+noOfBatch+"'>" + "</td><td>"+
                "<span id='participant-per-batch-view-" + uid + "'>" + participantPerBatch + "</span>" +  
                "<input class='participant-per-batch' id='participant-per-batch-" + uid + "'name='participantPerBatch[]' type='hidden' value='"+participantPerBatch+"'>" + "</td><td>"+
                "<span id='total-participants-view-" + uid + "'>" + totalParticipants + "</span>" + 
                "<input class='total-participants' id='total-participants-" + uid + "'name='total_participants[]' type='hidden' value='"+totalParticipants+"'>" + "</td><td>"+
                "<span id='female-participants-view-" + uid + "'>" + femaleParticipants + "</span>" + 
                "<input class='female-participants' id='female-participants-" + uid + "'name='female_participants[]' type='hidden' value='"+femaleParticipants+"'>" + "</td><td>"+
                "<span id='male-participants-view-" + uid + "'>" + maleParticipants + "</span>" + 
                "<input class='male-participants' id='male-participants-" + uid + "'name='male_participants[]' type='hidden' value='"+maleParticipants+"'>" + "</td><td>"+ 
                "<span id='ethnic-participants-view-" + uid + "'>" + ethnicParticipants + "</span>" + 
                "<input class='ethnic-participants' id='ethnic-participants-" + uid + "'name='ethnic_participants[]' type='hidden' value='"+ethnicParticipants+"'>" + "</td><td>"+ 
                "<span id='female-ethnic-participants-view-" + uid + "'>" + femaleethnicParticipants + "</span>" + 
                "<input class='female-ethnic-participants' id='female-ethnic-participants-" + uid + "'name='female_ethnic_participants[]' type='hidden' value='"+femaleethnicParticipants+"'>" + "</td><td>"+ 
                "<span id='total-client-days-view-" + uid + "'>" + totalClientDays + "</span>" + 
                "<input class='total-client-days' id='total-client-days-" + uid + "'name='total_client_days[]' type='hidden' value='"+totalClientDays+"'>" + "</td><td>"+ 
                "<a class='edit-training-open-details btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                "<a class='remove-training-open-details btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                + "</td></tr>";

                elmTablePond.find('tbody').append(row);
    }

    function updateTrainingOpenDetailsData(rowUid) {

        
        $('#training-title-view-' + rowUid).text(trainingTitleName);
        $('#training-title-' + rowUid).val(trainingTitleId);

        
        $('#training-duration-view-' + rowUid).text(trainingDuration);
        $('#training-duration-' + rowUid).val(trainingDuration);

        $('#no-of-batch-view-' + rowUid).text(noOfBatch);
        $('#no-of-batch-' + rowUid).val(noOfBatch);
        
        $('#participant-per-batch-view-' + rowUid).text(participantPerBatch);
        $('#participant-per-batch-' + rowUid).val(participantPerBatch);
        
        $('#total-participants-view-' + rowUid).text(totalParticipants);
        $('#total-participants-' + rowUid).val(totalParticipants);

        $('#female-participants-view-' + rowUid).text(femaleParticipants);
        $('#female-participants-' + rowUid).val(femaleParticipants);
 
        $('#male-participants-view-' + rowUid).text(maleParticipants);
        $('#male-participants-' + rowUid).val(maleParticipants);


        $('#female-ethnic-participants-view-' + rowUid).text(femaleethnicParticipants);
        $('#female-ethnic-participants' + rowUid).val(femaleethnicParticipants);

        $('#total-client-days-view-' + rowUid).text(totalClientDays);
        $('#total-client-days-' + rowUid).val(totalClientDays);

        $('#ethnic-participants-view-' + rowUid).text(ethnicParticipants);
        $('#ethnic-participants-' + rowUid).val(ethnicParticipants);
 

    }

    elmTablePond.on('click', '.rows a.edit-training-open-details', function (e) {
        var rowUid = $(this).attr('uid');
        $('#training_open_details_row_uid').val(rowUid);

        $('#training_title_id').val($('#training-title-' + rowUid).val());
        $('#training_duration').val($('#training-duration-' + rowUid).val());
        $('#number_of_batch').val($('#no-of-batch-' + rowUid).val());
        $('#participant_per_batch').val($('#participant-per-batch-' + rowUid).val());
        $('#no_of_total_participants').val($('#total-participants-' + rowUid).val());
        $('#no_of_female_participants').val($('#female-participants-' + rowUid).val());
        $('#no_of_male_participants').val($('#male-participants-' + rowUid).val());
        $('#total_ethnic_participants').val($('#ethnic-participants-' + rowUid).val());
        $('#total_ethnic_female_participants').val($('#female-ethnic-participants-' + rowUid).val());
        $('#total_client_days').val($('#total-client-days-' + rowUid).val());
    });
    // Delete a pond details list row
    elmTablePond.on('click', '.rows a.remove-training-open-details', function (event) {
        if( confirm('Are you sure?') ) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
        
    });


});