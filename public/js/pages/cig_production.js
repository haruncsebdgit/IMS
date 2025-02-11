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

$(document).ready(function () {
     // Populate origin project dropdown by phase no
     let app = jQuery.parseJSON(app_data);
     $('#cig').change(function () {
         let app_locale = app.app_locale;
         
         var cig = $(this).val();
         if (cig) {
             $.get(app.app_url + 'admin/monitoring/cig-production/cig-member/' + cig, function (data) {
                 let cigMember = $('#cig-member');
                 data = JSON.parse(data);
                 if(cigMember.length > 0) {
                     //success data
                     cigMember.empty();
                     cigMember.append('<option value="">' + select + '</option>');

                     $.each(data, function (index, value) {
                         cigMember.append('<option value="' + index + '">' + value + '</option>');
                     });
 
                     /**
                      * Trigger only for select2
                      */
                      //method.val('').trigger('change');
                 }
             });
         }
     })

     /**
     * Fish stock information repeater for DoF
     */

      var fishSpeciesId;
      var fishSpeciesName;
      var elmfishSpecies = document.getElementById('fish-species');
      var stockedNumber;
      var size;
      var stockingDate;
      var pondNumberId;
      var pondNumber;
      var elmPondNumber = document.getElementById('pond-number');
      var elmTableFishstock = $('#table-fishstock-details');
      $('body').on('click', '#btn-fishstock-details', function() {
          
          
          fishSpeciesName = elmfishSpecies.options[elmfishSpecies.selectedIndex].text;
          fishSpeciesId = elmfishSpecies.value;
          stockedNumber = document.getElementById('stocked-number').value;
          size = document.getElementById('size').value;
          stockingDate = document.getElementById('stocking-date').value;
          pondNumber = elmPondNumber.options[elmPondNumber.selectedIndex].text;
          pondNumberId = elmPondNumber.value;
          
  
          // Validating form
          var isValidate = true;
          $('#fish-species').removeClass('is-invalid');
          $('#stocked-number').removeClass('is-invalid');
          $('#size').removeClass('is-invalid');
          $('#pond-number').removeClass('is-invalid');
          if(!fishSpeciesId) {
              $('#fish-species').removeClass('is-invalid');
              isValidate = false;
          }
          if(!stockedNumber) {
              $('#stocked-number').addClass('is-invalid');
              isValidate = false;
          }
          if(!size) {
              $('#size').addClass('is-invalid');
              isValidate = false;
          }
          if(!pondNumber) {
              $('#pond-number').addClass('is-invalid');
              isValidate = false;
          }
  
          if(!isValidate) {
              return;
          }
  
          var existingRowId = $('#fishstock-details-row-id').val();
          if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
             updateLivestockDetailsData(existingRowId);
          } else {
              addFishStockDetailsData();
          }
  
          $('#fishstock-details-row-id').val('');
          // Removing data from input field after successfully adding to list
          $('#fish-species').val('');
          $('#stocked-number').val('');
          $('#size').val('');
          $('#stocking-date').val('');
          $('#pond-number').val('');
      });
  
      function addFishStockDetailsData() {
          var uid = uuidv4();
          
          // Build table row for added dynamically
          var row = "<tr class='rows'><td><span id='fish-species-view-" + uid + "'>"+ fishSpeciesName + "</span>" +
                  "<input class='fish-species' id='fish-species-" + uid + "'name='fish_species_name_id[]' type='hidden' value='"+fishSpeciesId+"'>" + "</td><td>"+
                  "<span id='stocked-number-view-" + uid + "'>" + stockedNumber + "</span>" + 
                  "<input class='stocked-number' id='stocked-number-" + uid + "'name='total_number_of_stocked[]' type='hidden' value='"+stockedNumber+"'>" + "</td><td>"+
                  "<span id='size-view-" + uid + "'>" + size + "</span>" + 
                  "<input class='size' id='size-" + uid + "'name='size[]' type='hidden' value='"+size+"'>" + "</td><td>"+
                  "<span id='stocking-date-view-" + uid + "'>" + stockingDate + "</span>" + 
                  "<input class='stocking-date' id='stocking-date-" + uid + "'name='stocking_date[]' type='hidden' value='"+stockingDate+"'>" + "</td><td>"+
                  "<span id='pond-number-view-" + uid + "'>" + pondNumber + "</span>" + 
                  "<input class='pond-number' id='pond-number-" + uid + "'name='pond_number[]' type='hidden' value='"+pondNumberId+"'>" + "</td><td>"+
                  "<a class='edit-fishstock btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                  "<a class='remove-fishstock btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                  + "</td></tr>";
  
                  elmTableFishstock.find('tbody').append(row);
      }
  
      function updateLivestockDetailsData(rowUid) {
          $('#fish-species-view-' + rowUid).text(fishSpeciesName);
          $('#fish-species-' + rowUid).val(fishSpeciesId);
          
          $('#stocked-number-view-' + rowUid).text(stockedNumber);
          $('#stocked-number-' + rowUid).val(stockedNumber);
  
          $('#size-view-' + rowUid).text(size);
          $('#size-' + rowUid).val(size);

          $('#stocking-date-view-' + rowUid).text(stockingDate);
          $('#stocking-date-' + rowUid).val(stockingDate);

          $('#pond-number-view-' + rowUid).text(pondNumber);
          $('#pond-number-' + rowUid).val(pondNumberId);
  
      }
  
      elmTableFishstock.on('click', '.rows a.edit-fishstock', function (e) {
          var rowUid = $(this).attr('uid');
          $('#fishstock-details-row-id').val(rowUid);
  
          $('#fish-species').val($('#fish-species-' + rowUid).val());
          $('#stocked-number').val($('#stocked-number-' + rowUid).val());
          $('#size').val($('#size-' + rowUid).val());
          $('#stocking-date').val($('#stocking-date-' + rowUid).val());
          $('#pond-number').val($('#pond-number-' + rowUid).val());
      });
      // Delete a pond details list row
      elmTableFishstock.on('click', '.rows a.remove-fishstock', function (event) {
          if( confirm('Are you sure?') ) {
              $(this).parents("tr:first").remove();
              $(this).parent().parent().remove();
          }
          
      });
});