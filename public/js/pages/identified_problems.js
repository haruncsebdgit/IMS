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

  

$(document).ready(function(){


    var elm_identified_problem = document.getElementById('identified-problem');
    var identified_problem;

    var elmIdentifiedProblem = $('#identifiedProblem');
    $('body').on('click', '#btn-add-identified-problem', function() {
        
        identified_problem = elm_identified_problem.value;
        
         
                
                
        var existingRowId = $('#row-id').val();
        if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
        updateRow(existingRowId);
        } else {
            addRow();
        }

        $('#row-id').val('');
        // Removing data from input field after successfully adding to list
        $('#identified-problem').val('');


    });

    function addRow() {
        var uid = uuidv4();
        
        // Build table row for added dynamically
        var row = "<tr class='rows'><td><span id='identified-problem-view-" + uid + "'>"+ identified_problem + "</span>" +
                "<input class='identified-problem' id='identified-problem-" + uid + "'name='list_of_identified_problem[]' type='hidden' value='"+identified_problem+"'>" + "</td><td>"+
                
                "<a class='edit btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                "<a class='remove btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                
                
                + "</td></tr>";

                elmIdentifiedProblem.find('tbody').append(row);
    }

    function updateRow(rowUid) {
        $('#identified-problem-view-' + rowUid).text(identified_problem);
        $('#identified-problem-' + rowUid).val(identified_problem);


    }

    elmIdentifiedProblem.on('click', '.rows a.edit', function (e) {
        var rowUid = $(this).attr('uid');
        $('#row-id').val(rowUid);

        $('#identified-problem').val($('#identified-problem-' + rowUid).val()).trigger('focus');
        
        
        
    });
    
    // Delete a pond details list row
    elmIdentifiedProblem.on('click', '.rows a.remove', function (event) {
        if( confirm('Are you sure?') ) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
        
    });
});