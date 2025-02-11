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
     * Fishing Gear Info Repeater
     */

     var fishingGearId;
     var fishingGearName;
     var elmFishingGear = document.getElementById('fishing_gear_id');
     var gearNumber;
     var elmTableFishingGear = $('#table-fishing_gear-details');
     $('body').on('click', '#btn-fishing-gear-details', function() {
         
         gearNumber = document.getElementById('gear_number').value;
         fishingGearName = elmFishingGear.options[elmFishingGear.selectedIndex].text;
         fishingGearId = elmFishingGear.value;

 
         // Validating form
         var isValidate = true;
         $('#fishing_gear_id').removeClass('is-invalid');
         $('#gear_number').removeClass('is-invalid');
         if(!fishingGearId) {
             $('#fishing_gear_id').addClass('is-invalid');
             isValidate = false;
         }

         if(!gearNumber) {
             $('#gear_number').addClass('is-invalid');
             isValidate = false;
         }
 
         if(!isValidate) {
             return;
         }
 
         var existingRowId = $('#fishing_gear_details_row_uid').val();
         if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
            updateFishingGearData(existingRowId);
         } else {
             addFishingGearData();
         }
 
         $('#fishing_gear_details_row_uid').val('');
         // Removing data from input field after successfully adding to list
         $('#fishing_gear_id').val('');
         $('#gear_number').val('');
     });
 
     function addFishingGearData() {
         var uid = uuidv4();
         // Build table row for added dynamically
         var row = "<tr class='rows text-center'><td><span id='fishing-gear-id-view-" + uid + "'>"+ fishingGearName + "</span>" +
                 "<input class='fishing-gear-id' id='fishing-gear-id-" + uid + "'name='fishing_gear[]' type='hidden' value='"+fishingGearId+"'>" + "</td><td>"+
                 "<span id='fishing-gear-number-view-" + uid + "'>" + gearNumber + "</span>" + 
                 "<input class='fishing-gear-number' id='fishing-gear-number-" + uid + "'name='gear_number[]' type='hidden' value='"+gearNumber+"'>" + "</td><td>"+
                 "<a class='edit-participant-details btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                 "<a class='remove-participant-details btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                 + "</td></tr>";
 
                 elmTableFishingGear.find('tbody').append(row);
     }
 
     function updateFishingGearData(rowUid) {
         $('#fishing-gear-id-view-' + rowUid).text(fishingGearName);
         $('#fishing-gear-id-' + rowUid).val(fishingGearId);
         
 
         $('#fishing-gear-number-view-' + rowUid).text(gearNumber);
         $('#fishing-gear-number-' + rowUid).val(gearNumber);
 
     }
 
     elmTableFishingGear.on('click', '.rows a.edit-participant-details', function (e) {
         var rowUid = $(this).attr('uid');
         $('#fishing_gear_details_row_uid').val(rowUid);
 
         $('#fishing_gear_id').val($('#fishing-gear-id-' + rowUid).val()).trigger('focus');
         $('#gear_number').val($('#fishing-gear-number-' + rowUid).val());
     });
     // Delete a pond details list row
     elmTableFishingGear.on('click', '.rows a.remove-participant-details', function (event) {
         if( confirm('Are you sure?') ) {
             $(this).parents("tr:first").remove();
             $(this).parent().parent().remove();
         }
         
     });
    });
