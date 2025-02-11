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
     * Fishing Gear Type Info Repeater
     */


     var fishingGearId;
     var fishingGearName;
     var elmFishingGear = document.getElementById('sample_data_fishing_gear_id');
     var elmFishSpecies = document.getElementById('species_name_id');
     var speciesName;
     var sampleDay;
     var previousDay;
     var elmTableSampleCatch = $('#table_sample_catch_data_details');
     $('body').on('click', '#btn_sample_catch_data_details', function() {
         console.log("sample data my");
         sampleDay = document.getElementById('sample_day').value;
         previousDay = document.getElementById('previous_day').value;
         fishingGearName = elmFishingGear.options[elmFishingGear.selectedIndex].text;
         fishingGearId = elmFishingGear.value;
         fishSpeciesName = elmFishSpecies.options[elmFishSpecies.selectedIndex].text;
         fishiSpeciesId = elmFishSpecies.value;


 
         // Validating form
         var isValidate = true;
         $('#sample_data_fishing_gear_id').removeClass('is-invalid');
         $('#species_name_id').removeClass('is-invalid');
         $('#sample_day').removeClass('is-invalid');
         $('#previous_day').removeClass('is-invalid');
         if(!fishingGearId) {
             $('#sample_data_fishing_gear_id').addClass('is-invalid');
             isValidate = false;
         }

         if(!fishiSpeciesId) {
            $('#species_name_id').addClass('is-invalid');
            isValidate = false;
        }

        if(!sampleDay) {
            $('#sample_day').addClass('is-invalid');
            isValidate = false;
        } 
        if(!previousDay) {
            $('#previous_day').addClass('is-invalid');
            isValidate = false;
        }
 
         if(!isValidate) {
             return;
         }
 
         var existingRowId = $('#sample_catch_data_details_row_uid').val();
         if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
            updateFishingGearData(existingRowId);
         } else {
             addFishingGearData();
         }
 
         $('#sample_catch_data_details_row_uid').val('');
         // Removing data from input field after successfully adding to list
         $('#sample_data_fishing_gear_id').val('');
         $('#species_name_id').val('');
         $('#sample_day').val('');
         $('#previous_day').val('');
     });
 
     function addFishingGearData() {
         console.log('my sample');
         var uid = uuidv4();
         // Build table row for added dynamically
         var row = "<tr class='rows text-center'><td><span id='sample-fishing-gear-id-view-" + uid + "'>"+ fishingGearName + "</span>" +
                 "<input class='sample-fishing-gear-id' id='sample-fishing-gear-id-" + uid + "'name='sample_fishing_gear_id[]' type='hidden' value='"+fishingGearId+"'>" + "</td><td>"+
                 "<span id='sample-fish-species-view-" + uid + "'>" + fishSpeciesName + "</span>" + 
                 "<input class='sample-fish-species' id='sample-fish-species-" + uid + "'name='sample_species_name_id[]' type='hidden' value='"+fishiSpeciesId+"'>" + "</td><td>"+
                 "<span id='sample-day-unit-view-" + uid + "'>" + sampleDay + "</span>" + 
                 "<input class='sample-day-unit' id='sample-day-unit-" + uid + "'name='sample_day[]' type='hidden' value='"+sampleDay+"'>" + "</td><td>"+
                 "<span id='previous-day-view-" + uid + "'>" + previousDay + "</span>" + 
                 "<input class='previous-day' id='previous-day-" + uid + "'name='sample_previous_day[]' type='hidden' value='"+previousDay+"'>" + "</td><td>"+
                 "<a class='edit-sample-fishing-gear-type-details btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                 "<a class='remove-sample-fishing-gear-type-details btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                 + "</td></tr>";
 
                 elmTableSampleCatch.find('tbody').append(row);
     }
 
     function updateFishingGearData(rowUid) {
         $('#sample-fishing-gear-id-view-' + rowUid).text(fishingGearName);
         $('#sample-fishing-gear-id-' + rowUid).val(fishingGearId);
         
 
         $('#sample-fish-species-view-' + rowUid).text(fishSpeciesName);
         $('#sample-fish-species-' + rowUid).val(fishiSpeciesId);

         $('#sample-day-unit-view-' + rowUid).text(sampleDay);
         $('#sample-day-unit-' + rowUid).val(sampleDay);

         $('#previous-day-view-' + rowUid).text(previousDay);
         $('#previous-day-' + rowUid).val(previousDay);
 
     }
 
     elmTableSampleCatch.on('click', '.rows a.edit-sample-fishing-gear-type-details', function (e) {
         var rowUid = $(this).attr('uid');
         $('#sample_catch_data_details_row_uid').val(rowUid);
 
         $('#sample_data_fishing_gear_id').val($('#sample-fishing-gear-id-' + rowUid).val()).trigger('focus');
         $('#species_name_id').val($('#sample-fish-species-' + rowUid).val());
         $('#sample_day').val($('#sample-day-unit-' + rowUid).val());
         $('#previous_day').val($('#previous-day-' + rowUid).val());
     });
     // Delete a pond details list row
     elmTableSampleCatch.on('click', '.rows a.remove-sample-fishing-gear-type-details', function (event) {
         if( confirm('Are you sure?') ) {
             $(this).parents("tr:first").remove();
             $(this).parent().parent().remove();
         }
         
     });
    });
