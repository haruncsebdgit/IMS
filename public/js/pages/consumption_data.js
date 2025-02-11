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
     $("#unit_price,#sold_quantity").keyup(function(){
        var unitPrice = document.getElementById('unit_price').value;
        var soldQuantity = document.getElementById('sold_quantity').value;
        var totalPrice = parseInt(unitPrice)*parseInt(soldQuantity);
        if(isNaN(totalPrice)){
            $("#total_price").prop('disabled', true);
        }else{
            $('#total_price').val(totalPrice);
            $("#total_price").prop('disabled', true);
        }
       
      });  

     var fishSpeciesId;
     var speciesName;
     var elmFishSpecies = document.getElementById('consumption_species_name_id');
     var marketplace;
     var consumptionQuantity;
     var soldQuantity;
     var elmTableFishingGear = $('#table_fish-consumption-data-details');
     $('body').on('click', '#btn-fish-consumption-data-details', function() {
         marketplace = document.getElementById('marketplace').value;
         consumptionQuantity = document.getElementById('consumption_quantity').value;
         fishDrying = document.getElementById('fish_drying').value;
         soldQuantity = document.getElementById('sold_quantity').value;
         unitPrice = document.getElementById('unit_price').value;
         totalPrice = document.getElementById('total_price').value;
         speciesName = elmFishSpecies.options[elmFishSpecies.selectedIndex].text;
         fishSpeciesId = elmFishSpecies.value;

        // console.log("hello");
 
         // Validating form
         var isValidate = true;
         $('#consumption_species_name_id').removeClass('is-invalid');
         $('#marketplace').removeClass('is-invalid');
         $('#consumption_quantity').removeClass('is-invalid');
         $('#fish_drying').removeClass('is-invalid');
         $('#sold_quantity').removeClass('is-invalid');
         $('#unit_price').removeClass('is-invalid');
         $('#total_price').removeClass('is-invalid');
         if(!fishSpeciesId) {
             $('#consumption_species_name_id').addClass('is-invalid');
             isValidate = false;
         }

         if(!marketplace) {
            $('#marketplace').addClass('is-invalid');
            isValidate = false;
        }

        if(!consumptionQuantity) {
            $('#consumption_quantity').addClass('is-invalid');
            isValidate = false;
        } 
        if(!fishDrying) {
            $('#fish_drying').addClass('is-invalid');
            isValidate = false;
        }
        if(!unitPrice) {
            $('#unit_price').addClass('is-invalid');
            isValidate = false;
        }
        if(!totalPrice) {
            $('#total_price').addClass('is-invalid');
            isValidate = false;
        }
        if(!soldQuantity) {
            $('#sold_quantity').addClass('is-invalid');
            isValidate = false;
        }
 
         if(!isValidate) {
             return;
         }
 
         var existingRowId = $('#consumption_details_row_uid').val();
         console.log(existingRowId);
         if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
            updateFishingGearData(existingRowId);
         } else {
             addFishingGearData();
         }
 
         $('#consumption_details_row_uid').val('');
         // Removing data from input field after successfully adding to list
         $('#consumption_species_name_id').val('');
         $('#marketplace').val('');
         $('#consumption_quantity').val('');
         $('#fish_drying').val('');
         $('#unit_price').val('');
         $('#total_price').val('');
         $('#sold_quantity').val('');
     });
 
     function addFishingGearData() {
         var uid = uuidv4();
         // Build table row for added dynamically
         var row = "<tr class='rows text-center'><td><span id='fish-species-id-view-" + uid + "'>"+ speciesName + "</span>" +
                 "<input class='fish-species-id' id='fish-species-id-" + uid + "'name='sample_consumption_species_name_id[]' type='hidden' value='"+fishSpeciesId+"'>" + "</td><td>"+
                 "<span id='marketplace-view-" + uid + "'>" + marketplace + "</span>" + 
                 "<input class='marketplace' id='marketplace-" + uid + "'name='sample_consumption_marketplace[]' type='hidden' value='"+marketplace+"'>" + "</td><td>"+
                 "<span id='consumption-quantity-view-" + uid + "'>" + consumptionQuantity + "</span>" + 
                 "<input class='consumption-quantity' id='consumption-quantity-" + uid + "'name='sample_consumption_consumption_quantity[]' type='hidden' value='"+consumptionQuantity+"'>" + "</td><td>"+
                 "<span id='fish-drying-view-" + uid + "'>" + fishDrying + "</span>" + 
                 "<input class='fish-drying' id='fish-drying-" + uid + "'name='sample_consumption_fish_drying[]' type='hidden' value='"+fishDrying+"'>" + "</td><td>"+
                 "<span id='sold-quantity-view-" + uid + "'>" + soldQuantity + "</span>" + 
                 "<input class='sold-quantity' id='sold-quantity-" + uid + "'name='sample_consumption_sold_quantity[]' type='hidden' value='"+soldQuantity+"'>" + "</td><td>"+
                 "<span id='unit-price-view-" + uid + "'>" + unitPrice + "</span>" + 
                 "<input class='unit-price' id='unit-price-" + uid + "'name='sample_consumption_unit_price[]' type='hidden' value='"+unitPrice+"'>" + "</td><td>"+
                 "<span id='total-price-view-" + uid + "'>" + totalPrice + "</span>" + 
                 "<input class='total-price' id='total-price-" + uid + "'name='sample_consumption_total_price[]' type='hidden' value='"+totalPrice+"'>" + "</td><td>"+
                 "<a class='edit-fishing-gear-type-details btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                 "<a class='remove-fishing-gear-type-details btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                 + "</td></tr>";
 
                 elmTableFishingGear.find('tbody').append(row);
     }
 
     function updateFishingGearData(rowUid) {
         $('#fish-species-id-view-' + rowUid).text(speciesName);
         $('#fish-species-id-' + rowUid).val(fishSpeciesId);
         
 
         $('#marketplace-view-' + rowUid).text(marketplace);
         $('#marketplace-' + rowUid).val(marketplace);

         $('#consumption-quantity-view-' + rowUid).text(consumptionQuantity);
         $('#consumption-quantity-' + rowUid).val(consumptionQuantity);

         $('#fish-drying-view-' + rowUid).text(fishDrying);
         $('#fish-drying-' + rowUid).val(fishDrying);

         $('#sold-quantity-view-' + rowUid).text(soldQuantity);
         $('#sold-quantity-' + rowUid).val(soldQuantity);
 
         $('#unit-price-view-' + rowUid).text(unitPrice);
         $('#unit-price-' + rowUid).val(unitPrice);

         $('#total-price-view-' + rowUid).text(totalPrice);
         $('#total-price-' + rowUid).val(totalPrice);
 
 
     }
 
     elmTableFishingGear.on('click', '.rows a.edit-fishing-gear-type-details', function (e) {
         var rowUid = $(this).attr('uid');
         $('#consumption_details_row_uid').val(rowUid);
 
         $('#consumption_species_name_id').val($('#fish-species-id-' + rowUid).val()).trigger('focus');
         $('#marketplace').val($('#marketplace-' + rowUid).val());
         $('#consumption_quantity').val($('#consumption-quantity-' + rowUid).val());
         $('#fish_drying').val($('#fish-drying-' + rowUid).val());
         $('#unit_price').val($('#sold-quantity-' + rowUid).val());
         $('#total_price').val($('#unit-price-' + rowUid).val());
         $('#sold_quantity').val($('#total-price-' + rowUid).val());
     });
     // Delete a pond details list row
     elmTableFishingGear.on('click', '.rows a.remove-fishing-gear-type-details', function (event) {
         if( confirm('Are you sure?') ) {
             $(this).parents("tr:first").remove();
             $(this).parent().parent().remove();
         }
         
     });
    });
