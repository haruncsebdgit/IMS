function uuidv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
      return v.toString(16);
    });
}
function validateInput(object)
{
  if (object.value) {
    $(object).removeClass('is-invalid')
    // Clearing red border from select2 dropdown 
    if ($(object).hasClass("select2-hidden-accessible")) {
        $(object).siblings(".select2-container").find('.select2-selection').removeClass('is-invalid-select2');
    }
  }
}

$(document).ready(function(){
    var fishSpeciesId;
    var fishSpeciesName;
    var elmFishSpecies = $('#fish-species');

    var fishAvailableDate;
    var elmFishAvailableDate = $('#fish-available-date');

    var elmTableDetails = $('#table-details');
    $('body').on('click', '#btn-add', function() {
        
        fishSpeciesId = elmFishSpecies.val();
        fishSpeciesName = elmFishSpecies.find('option:selected').text();
        fishAvailableDate = elmFishAvailableDate.val();

        // Validating form
        var isValidate = true;
        elmFishSpecies.removeClass('is-invalid');
        elmFishAvailableDate.removeClass('is-invalid');
        if(!fishSpeciesId) {
            elmFishSpecies.addClass('is-invalid');
            elmFishSpecies.siblings(".select2-container").find('.select2-selection').addClass('is-invalid-select2');

            isValidate = false;
        }

        if(!fishAvailableDate) {
            elmFishAvailableDate.addClass('is-invalid');
            isValidate = false;
        }

        if(!isValidate) {
            return;
        }

        var existingRowId = $('#row-id').val();
        if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
            updateRow(existingRowId);
            $('.btn-add-fish-species').text(labelAdd);
        } else {
            addRow();
        }

        $('#row-id').val('');
        // Removing data from input field after successfully adding to list
        elmFishSpecies.val('').trigger('change');
        elmFishAvailableDate.val('');
    });

    function addRow() {
        var uid = uuidv4();
        
        // Build table row for added dynamically
        var row = "<tr class='rows'><td><span id='fish-species-view-" + uid + "'>"+ fishSpeciesName + "</span>" +
                "<input class='fish-species' id='fish-species-" + uid + "'name='fish_species_id[]' type='hidden' value='"+fishSpeciesId+"'>" + "</td><td>"+
                "<span id='fish-available-date-view-" + uid + "'>" + fishAvailableDate + "</span>" + 
                "<input class='fish-available-date' id='fish-available-date-" + uid + "'name='fish_available_date[]' type='hidden' value='"+fishAvailableDate+"'>" + "</td><td>"+
                "<a class='edit btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                "<a class='remove btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                + "</td></tr>";

                elmTableDetails.find('tbody').append(row);
    }

    function updateRow(rowUid) {
        $('#fish-species-view-' + rowUid).text(fishSpeciesName);
        $('#fish-species-' + rowUid).val(fishSpeciesId);
        
        $('#fish-available-date-view-' + rowUid).text(fishAvailableDate);
        $('#fish-available-date-' + rowUid).val(fishAvailableDate);

    }

    elmTableDetails.on('click', '.rows a.edit', function (e) {
        var rowUid = $(this).attr('uid');
        $('#row-id').val(rowUid);

        elmFishSpecies.val($('#fish-species-' + rowUid).val()).trigger('focus');
        elmFishAvailableDate.val($('#fish-available-date-' + rowUid).val());

        $('.btn-add-fish-species').text(labelUpdate);
    });
    // Delete a pond details list row
    elmTableDetails.on('click', '.rows a.remove', function (event) {
        if( confirm('Are you sure?') ) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
        
    });
});