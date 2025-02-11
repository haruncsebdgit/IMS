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
     var elmFishiSpecies = document.getElementById('katta_fishing_species_name');
     var elmTableKattaFishing = $('#table_katta_fish_sample_catch_data_details');
     $('body').on('click', '#btn-katta_fishing_sample_catch_data_details', function() {
         console.log("ami moin");
         KattaFishingDayNumber = document.getElementById('katta_fishing_day_number').value;
         KattaFishingEstimatedTotalCatch = document.getElementById('katta_fishing_estimated_total_catch').value;
         KattaFishingSampleTotal = document.getElementById('katta_fishing_sample_total').value;
         KattatotalCatchForSeason = document.getElementById('katta_fishing_total_catch_for_season').value;
         fishSpeciesName = elmFishiSpecies.options[elmFishiSpecies.selectedIndex].text;
         fishSpeciesId = elmFishiSpecies.value;
 
         // Validating form
         var isValidate = true;
         $('#katta_fishing_species_name').removeClass('is-invalid');
         $('#katta_fishing_estimated_total_catch').removeClass('is-invalid');
         $('#katta_fishing_day_number').removeClass('is-invalid');
         $('#katta_fishing_total_catch_for_season').removeClass('is-invalid');
         $('#katta_fishing_sample_total').removeClass('is-invalid');
         if(!fishSpeciesId) {
             $('#katta_fishing_species_name').addClass('is-invalid');
             isValidate = false;
         }

         if(!KattaFishingEstimatedTotalCatch) {
            $('#katta_fishing_sample_total').addClass('is-invalid');
            isValidate = false;
        }

        if(!KattaFishingDayNumber) {
            $('#katta_fishing_estimated_total_catch').addClass('is-invalid');
            isValidate = false;
        } 
        if(!KattaFishingSampleTotal) {
            $('#katta_fishing_day_number').addClass('is-invalid');
            isValidate = false;
        }
        if(!KattatotalCatchForSeason) {
            $('#katta_fishing_total_catch_for_season').addClass('is-invalid');
            isValidate = false;
        }

 
         if(!isValidate) {
             return;
         }
 
         var existingRowId = $('#kattaa_fishing_sample_catch_data_details_row_uid').val();
         if(existingRowId) { // If found existingRowId that means it is edit form kattawise add form
            updateFishingGearData(existingRowId);
         } else {
             addFishingGearData();
         }
 
         $('#kattaa_fishing_sample_catch_data_details_row_uid').val('');
         // Removing data from input field after successfully adding to list
         $('#katta_fishing_species_name').val('');
         $('#katta_fishing_sample_total').val('');
         $('#katta_fishing_estimated_total_catch').val('');
         $('#katta_fishing_day_number').val('');
         $('#katta_fishing_total_catch_for_season').val('');
     });
 
     function addFishingGearData() {
         var uid = uuidv4();
         console.log("kemom");
         // Build table row for added dynamically
         var row = "<tr class='rows text-center'><td><span id='katta-fishing-fish-species-view-" + uid + "'>"+ fishSpeciesName + "</span>" +
                 "<input class='katta-fishing-fish-species' id='katta-fishing-fish-species-" + uid + "'name='katta_fishing_species_name_id[]' type='hidden' value='"+fishSpeciesId+"'>" + "</td><td>"+
                 "<span id='katta-fishing-day-number-view-" + uid + "'>" + KattaFishingDayNumber + "</span>" + 
                 "<input class='katta-fishing-day-number' id='katta-fishing-day-number-" + uid + "'name='katta_fishing_katta_fishing_day_number[]' type='hidden' value='"+KattaFishingDayNumber+"'>" + "</td><td>"+
                 "<span id='katta-fishing-total-catch-view-" + uid + "'>" + KattaFishingEstimatedTotalCatch + "</span>" + 
                 "<input class='katta-fishing-total-catch' id='katta-fishing-total-catch-" + uid + "'name='katta_fishing_katta_fishing_estimated_total_catch[]' type='hidden' value='"+KattaFishingEstimatedTotalCatch+"'>" + "</td><td>"+
                 "<span id='katta-fishing-sample-total-view-" + uid + "'>" + KattaFishingSampleTotal + "</span>" + 
                 "<input class='katta-fishing-sample-total' id='katta-fishing-sample-total-" + uid + "'name='katta_fishing_katta_fishing_sample_total[]' type='hidden' value='"+KattaFishingSampleTotal+"'>" + "</td><td>"+
                 "<span id='katta-fishing-total-catch-for-season-view-" + uid + "'>" + KattatotalCatchForSeason + "</span>" + 
                 "<input class='katta-fishing-total-catch-for-season' id='katta-fishing-total-catch-for-season-" + uid + "'name='katta_fishing_katta_fishing_total_catch_for_season[]' type='hidden' value='"+KattatotalCatchForSeason+"'>" + "</td><td>"+
                 "<a class='edit-katta-fishing-catch-data-details btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                 "<a class='remove-katta-fishing-catch-data-details btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                 + "</td></tr>";
 
                 elmTableKattaFishing.find('tbody').append(row);
     }
 
     function updateFishingGearData(rowUid) {
         $('#katta-fishing-fish-species-view-' + rowUid).text(fishSpeciesName);
         $('#katta-fishing-fish-species' + rowUid).val(fishSpeciesId);
         
         $('#katta-fishing-day-number-view-' + rowUid).text(KattaFishingDayNumber);
         $('#katta-fishing-day-number-' + rowUid).val(KattaFishingDayNumber);

         $('#katta-fishing-total-catch-view-' + rowUid).text(KattaFishingEstimatedTotalCatch);
         $('#katta-fishing-total-catch-' + rowUid).val(KattaFishingEstimatedTotalCatch);

         $('#katta-fishing-sample-total-view-' + rowUid).text(KattaFishingSampleTotal);
         $('#katta-fishing-sample-total-' + rowUid).val(KattaFishingSampleTotal);

         $('#katta-fishing-total-catch-for-season-view-' + rowUid).text(KattatotalCatchForSeason);
         $('#katta-fishing-total-catch-for-season-' + rowUid).val(KattatotalCatchForSeason);
 
     }
 
     elmTableKattaFishing.on('click', '.rows a.edit-katta-fishing-catch-data-details', function (e) {

         var rowUid = $(this).attr('uid');
         $('#kattaa_fishing_sample_catch_data_details_row_uid').val(rowUid);
 
         $('#katta_fishing_species_name').val($('#katta-fishing-fish-species-' + rowUid).val()).trigger('focus');
         $('#katta_fishing_sample_total').val($('#katta-fishing-sample-total-' + rowUid).val());
         $('#katta_fishing_estimated_total_catch').val($('#katta-fishing-total-catch-' + rowUid).val());
         $('#katta_fishing_day_number').val($('#katta-fishing-day-number-' + rowUid).val());
         $('#katta_fishing_total_catch_for_season').val($('#katta-fishing-total-catch-for-season-' + rowUid).val());
     });
     // Delete a pond details list row
     elmTableKattaFishing.on('click', '.rows a.remove-katta-fishing-catch-data-details', function (event) {
         if( confirm('Are you sure?') ) {
             $(this).parents("tr:first").remove();
             $(this).parent().parent().remove();
         }
         
     });
    });
