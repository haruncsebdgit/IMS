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
$(document).ready(function() {
    $('#unit-price, #total-qty').keyup(function(){
        var unitPrice = $('#unit-price').val();
        var totalQuantity = $('#total-qty').val();
        if(unitPrice && totalQuantity) {
           $('#total-sale-price').val(parseFloat(unitPrice) * parseFloat(totalQuantity)).removeClass('is-invalid');
           //$('#total-sale-price').removeClass('is-invalid');
        } else {
            $('#total-sale-price').val('');
        }
    });


    // Sales Fish details item repeater
    var fishSpeciesId;
    var fishSpeciesName;
    var elmFishSpecies = $('#fish-species');
    var unitPrice;
    var elmUnitPrice = $("#unit-price");

    var totalQuantity;
    var elmTotalQuantity = $("#total-qty");

    var totalSalePrice;
    var elmTotalSalePrice = $("#total-sale-price");

    var elmTableDetails = $("#table-details");
    $("body").on("click", "#btn-add-fish-details", function () {
        
        fishSpeciesId = elmFishSpecies.val();
        fishSpeciesName = elmFishSpecies.find('option:selected').text();

        unitPrice = elmUnitPrice.val();
        totalQuantity = elmTotalQuantity.val();
        totalSalePrice = elmTotalSalePrice.val();

        // Validating form
        //console.log("block");
        if (!validateDetailsForm()) {
            //console.log('return')
            return;
        }

        var existingRowId = $("#row-id").val();
        //console.log(existingRowId);
        if (existingRowId) {
            // If found existingRowId that means it is edit form otherwise add form
            updateDetailsData(existingRowId);
            $('.btn-sales-fish').text(labelAdd);
        } else {
            addDetailsData();
        }
        // Clearing field after adding

        elmFishSpecies.val("");

        elmUnitPrice.val("");
        elmTotalQuantity.val("");
        elmTotalSalePrice.val("");
    });

    function validateDetailsForm() {
        var isValidate = true;
        
        elmFishSpecies.removeClass("is-invalid");
        elmUnitPrice.removeClass("is-invalid");
        elmTotalQuantity.removeClass("is-invalid");
        elmTotalSalePrice.removeClass("is-invalid");

        if (!fishSpeciesId) {
            elmFishSpecies.addClass("is-invalid");
            isValidate = false;
        }
        if (!unitPrice) {
            elmUnitPrice.addClass("is-invalid");
            isValidate = false;
        }
        if (!totalQuantity) {
            elmTotalQuantity.addClass("is-invalid");
            isValidate = false;
        }
        if (!totalSalePrice) {
            elmTotalSalePrice.addClass("is-invalid");
            isValidate = false;
        }
        return isValidate;
    }

    function addDetailsData() {
        var uid = uuidv4();
        // Build table row for added dynamically
        var row = "<tr class='rows'><td><span id='fish-species-view-" + uid + "'>"+ fishSpeciesName + "</span>" +
        "<input class='fish-species' id='fish-species-" + uid + "'name='fish_species_id[]' type='hidden' value='"+fishSpeciesId+"'>" + "</td><td>"+
        "<span id='unit-price-view-" + uid + "'>" + unitPrice + "</span>" + 
        "<input class='unit-price' id='unit-price-" + uid + "'name='unit_price[]' type='hidden' value='"+unitPrice+"'>" + "</td><td>"+
        "<span id='total-qty-view-" + uid + "'>" + totalQuantity + "</span>" + 
        "<input class='total-qty' id='total-qty-" + uid + "'name='total_quantity[]' type='hidden' value='"+totalQuantity+"'>" + "</td><td>"+
        "<span id='total-sale-price-view-" + uid + "'>" + totalSalePrice + "</span>" + 
        "<input class='total-sale-price' id='total-sale-price-" + uid + "'name='total_sales_price[]' type='hidden' value='"+totalSalePrice+"'>" + "</td><td>"+
        "<div class='btn-group'><a class='edit btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
        "<a class='remove btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a></div>"
        + "</td></tr>";
        //console.log(row);
        elmTableDetails.find('tbody').append(row);
    }

    function updateDetailsData(rowUid) {
        //console.log("test");
        $('#fish-species-view-' + rowUid).text(fishSpeciesName);
        $('#fish-species-' + rowUid).val(fishSpeciesId);

        $('#unit-price-view-' + rowUid).text(unitPrice);
        $('#unit-price-' + rowUid).val(unitPrice);

        $('#total-qty-view-' + rowUid).text(totalQuantity);
        $('#total-qty-' + rowUid).val(totalQuantity);

        $('#total-sale-price-view-' + rowUid).text(totalSalePrice);
        $('#total-sale-price-' + rowUid).val(totalSalePrice);
    }

    elmTableDetails.on("click", ".rows a.edit", function (e) {
        var rowUid = $(this).attr("uid");
        $("#row-id").val(rowUid);

        elmFishSpecies.val($('#fish-species-' + rowUid).val());
        elmUnitPrice.val($('#unit-price-' + rowUid).val());
        elmTotalQuantity.val($('#total-qty-' + rowUid).val());
        elmTotalSalePrice.val($('#total-sale-price-' + rowUid).val());

        $('.btn-sales-fish').text(labelUpdate);
    });
    // Delete a pond details list row
    elmTableDetails.on("click", ".rows a.remove", function (event) {
        if (confirm("Are you sure?")) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
    });
});


