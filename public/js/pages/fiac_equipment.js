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
    var equipmentId;
    var equipmentName;
    var elmEquipment = document.getElementById('equipment');
    var elmNumberOfUser = document.getElementById('number-of-user');
    var elmTotalNumberOfEquipment = document.getElementById('total_equipment');
    var NumberOfUser;
    var TotalNumberOfEquipment;
    var elmTableDetails = $('#table-equipments');
    $('body').on('click', '#btn-add-fiac-functionality-equipments', function() {
        
        NumberOfUser = elmNumberOfUser.value;
        TotalNumberOfEquipment = elmTotalNumberOfEquipment.value;
        equipmentName = elmEquipment.options[elmEquipment.selectedIndex].text;
        equipmentId = elmEquipment.value;

        // Validating form
        var isValidate = true;
        $('#equipment').removeClass('is-invalid');
        $('#number-of-user').removeClass('is-invalid');
        $('#total_equipment').removeClass('is-invalid');
        if(!equipmentId) {
            $('#equipment').addClass('is-invalid');
            isValidate = false;
        }

        if(!NumberOfUser) {
            $('#number-of-user').addClass('is-invalid');
            isValidate = false;
        }

        if(!TotalNumberOfEquipment) {
            $('#total_equipment').addClass('is-invalid');
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
        $('#total_equipment').val('');
        $('#number-of-user').val('');
        $('#equipment').val('');
    });

    function addRow() {
        var uid = uuidv4();
        
        // Build table row for added dynamically
        var row = "<tr class='rows'><td><span id='equipment-view-" + uid + "'>"+ equipmentName + "</span>" +
                "<input class='equipment' id='equipment-" + uid + "'name='equipment_id[]' type='hidden' value='"+equipmentId+"'>" + "</td><td>"+
                "<span id='number-of-user-view-" + uid + "'>" + NumberOfUser + "</span>" + 
                "<input class='number-of-user' id='number-of-user-" + uid + "'name='users[]' type='hidden' value='"+NumberOfUser+"'>" + "</td><td>"+
                "<span id='total-number-of-equipment-view-" + uid + "'>" + TotalNumberOfEquipment + "</span>" + 
                "<input class='total-number-of-equipment' id='total-number-of-equipment-" + uid + "'name='total_equipment[]' type='hidden' value='"+TotalNumberOfEquipment+"'>" + "</td><td>"+
                "<a class='edit btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                "<a class='remove btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                + "</td></tr>";

                elmTableDetails.find('tbody').append(row);
    }

    function updateRow(rowUid) {
        $('#total-number-of-equipment-view-' + rowUid).text(TotalNumberOfEquipment);
        $('#total-number-of-equipment-' + rowUid).val(TotalNumberOfEquipment);

        $('#number-of-user-view-' + rowUid).text(NumberOfUser);
        $('#number-of-user-' + rowUid).val(NumberOfUser);
        
        $('#equipment-view-' + rowUid).text(equipmentName);
        $('#equipment-' + rowUid).val(equipmentId);

    }

    elmTableDetails.on('click', '.rows a.edit', function (e) {
        var rowUid = $(this).attr('uid');
        $('#row-id').val(rowUid);

        $('#equipment').val($('#equipment-' + rowUid).val()).trigger('focus');
        $('#total_equipment').val($('#total-number-of-equipment-' + rowUid).val());
        $('#number-of-user').val($('#number-of-user-' + rowUid).val());
    });
    // Delete a pond details list row
    elmTableDetails.on('click', '.rows a.remove', function (event) {
        if( confirm('Are you sure?') ) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
        
    });
});