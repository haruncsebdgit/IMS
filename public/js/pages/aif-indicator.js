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

    $('#response-type').change(function () {
        if($(this).val() === 'mcq') {
            $('.answers').removeClass('d-none');
        } else {
            $('.answers').addClass('d-none');
        }
    });

    /**
     * Indicator information form repeater for DoF
     */
     var weight;
     var answerEn
     var answerBn
     var elmWeight = document.getElementById('weight');
     var elmTable = $('#table-indicator-answer');
     $('body').on('click', '#btn-add-answer', function() {
         
         answerEn = document.getElementById('answer-en').value;
         answerBn = document.getElementById('answer-bn').value;
         weight = document.getElementById('weight').value;
 
         // Validating form
         var isValidate = true;
         $('#answer-en').removeClass('is-invalid');
         $('#answer-bn').removeClass('is-invalid');
         if(!answerEn) {
             $('#answer-en').addClass('is-invalid');
             isValidate = false;
         }
 
         if(!answerBn) {
             $('#answer-bn').addClass('is-invalid');
             isValidate = false;
         }
 
         if(!isValidate) {
             return;
         }
 
         var existingRowId = $('#indicator-answer-row-id').val();
         if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
             updateAnswers(existingRowId);
         } else {
             addIndicatorAnswers();
         }
 
         $('#indicator-answer-row-id').val('');
         // Removing data from input field after successfully adding to list
         $('#weight').val('');
         $('#answer-en').val('');
         $('#answer-bn').val('');
     });
 
     function addIndicatorAnswers() {
         var uid = uuidv4();
         
         // Build table row for added dynamically
         var row = "<tr class='rows'><td><span id='answer-en-view-" + uid + "'>" + answerEn + "</span>" + 
                    "<input class='answer-en' id='answer-en-" + uid + "'name='answer_name_en[]' type='hidden' value='"+answerEn+"'>" + "</td><td>"+
                    "<span id='answer-bn-view-" + uid + "'>" + answerBn + "</span>" + 
                    "<input class='answer-bn' id='answer-bn-" + uid + "'name='answer_name_bn[]' type='hidden' value='"+answerBn+"'>" + "</td><td>"+
                    "<span id='weight-view-" + uid + "'>"+ weight + "</span>" +
                    "<input class='weight' id='weight-" + uid + "'name='mark_weight[]' type='hidden' value='"+weight+"'>" + "</td><td>"+
                    "<a class='edit-answer btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                    "<a class='remove-answer btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                    + "</td></tr>";
 
                 elmTable.find('tbody').append(row);
     }
 
     function updateAnswers(rowUid) {
         $('#weight-view-' + rowUid).text(weight);
         $('#weight-' + rowUid).val(weight);
         
         $('#answer-en-view-' + rowUid).text(answerEn);
         $('#answer-en-' + rowUid).val(answerEn);
 
         $('#answer-bn-view-' + rowUid).text(answerBn);
         $('#answer-bn-' + rowUid).val(answerBn);
 
     }
 
     elmTable.on('click', '.rows a.edit-answer', function (e) {
         var rowUid = $(this).attr('uid');
         $('#indicator-answer-row-id').val(rowUid);
 
         $('#weight').val($('#weight-' + rowUid).val());
         $('#answer-en').val($('#answer-en-' + rowUid).val());
         $('#answer-bn').val($('#answer-bn-' + rowUid).val());
     });
     // Delete a pond details list row
     elmTable.on('click', '.rows a.remove-answer', function (event) {
         if( confirm('Are you sure?') ) {
             $(this).parents("tr:first").remove();
             $(this).parent().parent().remove();
         }
         
     });
});