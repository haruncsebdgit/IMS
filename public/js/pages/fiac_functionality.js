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
    var serviceId;
    var serviceName;
    var elmService = document.getElementById('service');
    var elmNumberOfFarmer = document.getElementById('number-of-farmer');
    var NumberOfFarmer;
    var elmTableDetails = $('#table-details');
    $('body').on('click', '#btn-add-fiac-functionality-details', function() {
        
        NumberOfFarmer = elmNumberOfFarmer.value;
        serviceName = elmService.options[elmService.selectedIndex].text;
        serviceId = elmService.value;

        // Validating form
        var isValidate = true;
        $('#service').removeClass('is-invalid');
        $('#number-of-farmer').removeClass('is-invalid');
        if(!serviceId) {
            $('#service').addClass('is-invalid');
            isValidate = false;
        }

        if(!NumberOfFarmer) {
            $('#number-of-farmer').addClass('is-invalid');
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
        $('#number-of-farmer').val('');
        $('#service').val('');
    });

    function addRow() {
        var uid = uuidv4();
        
        // Build table row for added dynamically
        var row = "<tr class='rows'><td><span id='service-view-" + uid + "'>"+ serviceName + "</span>" +
                "<input class='service' id='service-" + uid + "'name='service_id[]' type='hidden' value='"+serviceId+"'>" + "</td><td>"+
                "<span id='number-of-farmer-view-" + uid + "'>" + NumberOfFarmer + "</span>" + 
                "<input class='number-of-farmer' id='number-of-farmer-" + uid + "'name='number_of_farmer[]' type='hidden' value='"+NumberOfFarmer+"'>" + "</td><td>"+
                "<a class='edit btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                "<a class='remove btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                + "</td></tr>";

                elmTableDetails.find('tbody').append(row);
    }

    function updateRow(rowUid) {
        $('#number-of-farmer-view-' + rowUid).text(NumberOfFarmer);
        $('#number-of-farmer-' + rowUid).val(NumberOfFarmer);
        
        $('#service-view-' + rowUid).text(serviceName);
        $('#service-' + rowUid).val(serviceId);

    }

    elmTableDetails.on('click', '.rows a.edit', function (e) {
        var rowUid = $(this).attr('uid');
        $('#row-id').val(rowUid);

        $('#service').val($('#service-' + rowUid).val()).trigger('focus');
        $('#number-of-farmer').val($('#number-of-farmer-' + rowUid).val());
    });
    // Delete a pond details list row
    elmTableDetails.on('click', '.rows a.remove', function (event) {
        if( confirm('Are you sure?') ) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
        
    });
});