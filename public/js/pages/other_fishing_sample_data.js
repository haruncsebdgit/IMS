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
 
     var fishSpeciesId;
     var fishSpeciesName;
     var elmFishiSpecies = document.getElementById('other_fish_species_name');
     var elmTableOtherFishing = $('#table_other_fish_sample_catch_data_details');
     $('body').on('click', '#btn-other_fishing_sample_catch_data_details', function() {
         dayNumber = document.getElementById('day_number').value;
         estimatedTotalCatch = document.getElementById('estimated_total_catch').value;
         sampleTotal = document.getElementById('sample_total').value;
         totalCatchForSeason = document.getElementById('total_catch_for_season').value;
         fishSpeciesName = elmFishiSpecies.options[elmFishiSpecies.selectedIndex].text;
         fishSpeciesId = elmFishiSpecies.value;
 
         // Validating form
         var isValidate = true;
         $('#other_fish_species_name').removeClass('is-invalid');
         $('#estimated_total_catch').removeClass('is-invalid');
         $('#day_number').removeClass('is-invalid');
         $('#total_catch_for_season').removeClass('is-invalid');
         $('#sample_total').removeClass('is-invalid');
         if(!fishSpeciesId) {
             $('#other_fish_species_name').addClass('is-invalid');
             isValidate = false;
         }

         if(!estimatedTotalCatch) {
            $('#sample_total').addClass('is-invalid');
            isValidate = false;
        }

        if(!dayNumber) {
            $('#estimated_total_catch').addClass('is-invalid');
            isValidate = false;
        } 
        if(!sampleTotal) {
            $('#day_number').addClass('is-invalid');
            isValidate = false;
        }
        if(!totalCatchForSeason) {
            $('#total_catch_for_season').addClass('is-invalid');
            isValidate = false;
        }

 
         if(!isValidate) {
             return;
         }
 
         var existingRowId = $('#other_fishing_sample_catch_data_details_row_uid').val();
         if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
            updateFishingGearData(existingRowId);
         } else {
             addFishingGearData();
         }
 
         $('#other_fishing_sample_catch_data_details_row_uid').val('');
         // Removing data from input field after successfully adding to list
         $('#other_fish_species_name').val('');
         $('#sample_total').val('');
         $('#estimated_total_catch').val('');
         $('#day_number').val('');
         $('#total_catch_for_season').val('');
     });
 
     function addFishingGearData() {
         var uid = uuidv4();
         // Build table row for added dynamically
         var row = "<tr class='rows text-center'><td><span id='fish-species-view-" + uid + "'>"+ fishSpeciesName + "</span>" +
                 "<input class='fish-species' id='fish-species-" + uid + "'name='other_fishing_species_name_id[]' type='hidden' value='"+fishSpeciesId+"'>" + "</td><td>"+
                 "<span id='day-number-view-" + uid + "'>" + dayNumber + "</span>" + 
                 "<input class='day-number' id='day-number-" + uid + "'name='other_fishing_day_number[]' type='hidden' value='"+dayNumber+"'>" + "</td><td>"+
                 "<span id='total-catch-view-" + uid + "'>" + estimatedTotalCatch + "</span>" + 
                 "<input class='total-catch' id='total-catch-" + uid + "'name='other_fishing_estimated_total_catch[]' type='hidden' value='"+estimatedTotalCatch+"'>" + "</td><td>"+
                 "<span id='sample-total-view-" + uid + "'>" + sampleTotal + "</span>" + 
                 "<input class='sample-total' id='sample-total-" + uid + "'name='other_fishing_sample_total[]' type='hidden' value='"+sampleTotal+"'>" + "</td><td>"+
                 "<span id='total-catch-for-season-view-" + uid + "'>" + totalCatchForSeason + "</span>" + 
                 "<input class='total-catch-for-season' id='total-catch-for-season-" + uid + "'name='other_fishing_total_catch_for_season[]' type='hidden' value='"+totalCatchForSeason+"'>" + "</td><td>"+
                 "<a class='edit-other-fishing-catch-data-details btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                 "<a class='remove-other-fishing-catch-data-details btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                 + "</td></tr>";
 
                 elmTableOtherFishing.find('tbody').append(row);
     }
 
     function updateFishingGearData(rowUid) {
         $('#fish-species-view-' + rowUid).text(fishSpeciesName);
         $('#fish-species' + rowUid).val(fishSpeciesId);
         
         $('#day-number-view-' + rowUid).text(dayNumber);
         $('#day-number-' + rowUid).val(dayNumber);

         $('#total-catch-view-' + rowUid).text(estimatedTotalCatch);
         $('#total-catch-' + rowUid).val(estimatedTotalCatch);

         $('#sample-total-view-' + rowUid).text(sampleTotal);
         $('#sample-total-' + rowUid).val(sampleTotal);

         $('#total-catch-for-season-view-' + rowUid).text(totalCatchForSeason);
         $('#total-catch-for-season-' + rowUid).val(totalCatchForSeason);
 
     }
 
     elmTableOtherFishing.on('click', '.rows a.edit-other-fishing-catch-data-details', function (e) {

         var rowUid = $(this).attr('uid');
         $('#other_fishing_sample_catch_data_details_row_uid').val(rowUid);
 
         $('#other_fish_species_name').val($('#fish-species-' + rowUid).val()).trigger('focus');
         $('#sample_total').val($('#sample-total-' + rowUid).val());
         $('#estimated_total_catch').val($('#total-catch-' + rowUid).val());
         $('#day_number').val($('#day-number-' + rowUid).val());
         $('#total_catch_for_season').val($('#total-catch-for-season-' + rowUid).val());
     });
     // Delete a pond details list row
     elmTableOtherFishing.on('click', '.rows a.remove-other-fishing-catch-data-details', function (event) {
         if( confirm('Are you sure?') ) {
             $(this).parents("tr:first").remove();
             $(this).parent().parent().remove();
         }
         
     });
    });
