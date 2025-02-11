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
    var incomeHeadId;
    var incomeHeadName;
    var elmIncomeHead = document.getElementById('income-head');
    var elmTotalIncome = document.getElementById('total-income');
    var totalIncome;
    var elmTableDetails = $('#table-details');
    $('body').on('click', '#btn-add-meeting-details', function() {
        
        totalIncome = elmTotalIncome.value;
        incomeHeadName = elmIncomeHead.options[elmIncomeHead.selectedIndex].text;
        incomeHeadId = elmIncomeHead.value;

        // Validating form
        var isValidate = true;
        $('#income-head').removeClass('is-invalid');
        $('#total-income').removeClass('is-invalid');
        if(!incomeHeadId) {
            $('#income-head').addClass('is-invalid');
            isValidate = false;
        }

        if(!totalIncome) {
            $('#total-income').addClass('is-invalid');
            isValidate = false;
        }

        if(!isValidate) {
            return;
        }

        var existingRowId = $('#row-id').val();
        if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
        updateRow(existingRowId);
        } else {
            addRow();
        }

        $('#row-id').val('');
        // Removing data from input field after successfully adding to list
        $('#total-income').val('');
        $('#income-head').val('');
    });

    function addRow() {
        var uid = uuidv4();
        
        // Build table row for added dynamically
        var row = "<tr class='rows'><td><span id='income-head-view-" + uid + "'>"+ incomeHeadName + "</span>" +
                "<input class='income-head' id='income-head-" + uid + "'name='income_head_id[]' type='hidden' value='"+incomeHeadId+"'>" + "</td><td>"+
                "<span id='total-income-view-" + uid + "'>" + totalIncome + "</span>" + 
                "<input class='total-income' id='total-income-" + uid + "'name='total_income[]' type='hidden' value='"+totalIncome+"'>" + "</td><td>"+
                "<a class='edit btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                "<a class='remove btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                + "</td></tr>";

                elmTableDetails.find('tbody').append(row);
    }

    function updateRow(rowUid) {
        $('#total-income-view-' + rowUid).text(totalIncome);
        $('#total-income-' + rowUid).val(totalIncome);
        
        $('#income-head-view-' + rowUid).text(incomeHeadName);
        $('#income-head-' + rowUid).val(incomeHeadId);

    }

    elmTableDetails.on('click', '.rows a.edit', function (e) {
        var rowUid = $(this).attr('uid');
        $('#row-id').val(rowUid);

        $('#income-head').val($('#income-head-' + rowUid).val()).trigger('focus');
        $('#total-income').val($('#total-income-' + rowUid).val());
    });
    // Delete a pond details list row
    elmTableDetails.on('click', '.rows a.remove', function (event) {
        if( confirm('Are you sure?') ) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
        
    });
});