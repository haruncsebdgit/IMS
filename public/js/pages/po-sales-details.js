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
    var app = jQuery.parseJSON(app_data);
    
    $('#buyer-trader').change(function (e, selectedItemsCompany) {
        let app_locale = app.app_locale;
        
        var buyerTraderId = $(this).val();
        if (buyerTraderId) {
            $.get(app.app_url + 'admin/monitoring/po-sales-details/getItemExportCompanyByTraderId/' + buyerTraderId, function (data) {
                let items = $('#items');
                let expCompany = $('#exporter-company');
                //data = JSON.parse(data.savedCropItems);
                if(items.length > 0) {
                    //success data
                    items.empty();
                    items.append('<option value="">' + app.label_select + '</option>');

                    $.each(data.savedCropItems, function (index, value) {
                        items.append('<option value="' + index + '">' + value + '</option>');
                    });

                    if(selectedItemsCompany){
                        items.val(selectedItemsCompany.item);
                    }
                }

                if(expCompany.length > 0) {
                    //success data
                    expCompany.empty();
                    expCompany.append('<option value="">' + app.label_select + '</option>');

                    $.each(data.savedAgents, function (index, value) {
                        expCompany.append('<option value="' + index + '">' + value + '</option>');
                    });

                    if(selectedItemsCompany){
                        expCompany.val(selectedItemsCompany.company);
                    }
                }
            });
        }
    });

    // Calculating damaged quantity from total transported qty and total sales qty
    $('#transported-qty, #sales-qty').keyup(function(){
        var transportedQty = $('#transported-qty').val();
        var totalSalesQty = $('#sales-qty').val();
        if(transportedQty && totalSalesQty) {
           $('#damaged-qty').val(parseFloat(transportedQty) - parseFloat(totalSalesQty)).removeClass('is-invalid');
        } else {
            $('#damaged-qty').val("");
        }
    });
    
    var buyerTraderId;
    var buyerTraderName;
    var elmBuyerTrader = $('#buyer-trader');

    var newBuyerTraderName;
    var elmNewBuyerTrader = $('#new-buyer-trader');

    var itemId;
    var itemName;
    var elmItem = $('#items');

    var transportedQty;
    var elmTransportedQty = $('#transported-qty');

    var salesQty;
    var elmSalesQty = $('#sales-qty');

    var damagedQty;
    var elmDamagedQty = $('#damaged-qty');

    var expCompanyId;
    var expCompany;
    var elmExpCompany = $('#exporter-company');

    var expCountryId;
    var expCountry;
    var elmExpCountry = $('#exporter-country');

    var elmTableDetails = $('#table-details');

    $('body').on('click', '#btn-add-details', function() {
        
        buyerTraderId = elmBuyerTrader.val();
        buyerTraderName = elmBuyerTrader.find('option:selected').text();
        newBuyerTraderName = elmNewBuyerTrader.val();

        if(!buyerTraderId) {
            buyerTraderName = newBuyerTraderName;
        }

        itemId = elmItem.val();
        itemName = elmItem.find('option:selected').text();
        console.log(itemName);

        transportedQty = elmTransportedQty.val();
        salesQty = elmSalesQty.val();
        damagedQty = elmDamagedQty.val();

        expCompanyId = elmExpCompany.val();
        expCompany = elmExpCompany.find('option:selected').text();

        expCountryId = elmExpCountry.val();
        expCountry = elmExpCountry.find('option:selected').text();

        // Validating form
        if(!validateSalesDetailItemForm()) {
            //console.log('return')
            return;
        }

        var existingRowId = $('#row-id').val();
        if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
            updateRow(existingRowId);
            $('.btn-sales-item').text(labelAdd);
        } else {
            addRow();
        }

        $('#row-id').val('');
        // Removing data from input field after successfully adding to list
        elmBuyerTrader.val('').trigger('change');
        elmNewBuyerTrader.val('');
        elmItem.val('').trigger('change');
        elmTransportedQty.val('');
        elmSalesQty.val('');
        elmDamagedQty.val('');
        elmExpCompany.val('').trigger('change');
        elmExpCountry.val('').trigger('change');
    });

    function validateSalesDetailItemForm()
      {
        var isValidate = true;
        elmBuyerTrader.removeClass('is-invalid');
        elmNewBuyerTrader.removeClass('is-invalid');
        elmItem.removeClass('is-invalid');
        elmTransportedQty.removeClass('is-invalid');
        elmSalesQty.removeClass('is-invalid');
        elmDamagedQty.removeClass('is-invalid');
        elmExpCompany.removeClass('is-invalid');
        elmExpCountry.removeClass('is-invalid');

        if(!buyerTraderId && !newBuyerTraderName) {
            elmNewBuyerTrader.addClass('is-invalid');

            elmBuyerTrader.addClass('is-invalid');
            elmBuyerTrader.siblings(".select2-container").find('.select2-selection').addClass('is-invalid-select2');

            isValidate = false;
        }

        if(!itemId) {
            elmItem.addClass('is-invalid');
            elmItem.siblings(".select2-container").find('.select2-selection').addClass('is-invalid-select2');
            isValidate = false;
        }
        if(!transportedQty) {
            elmTransportedQty.addClass('is-invalid');
            isValidate = false;
        }
        if(!salesQty) {
            elmSalesQty.addClass('is-invalid');
            isValidate = false;
        }
        if(!expCompanyId) {
            elmExpCompany.addClass('is-invalid');
            elmExpCompany.siblings(".select2-container").find('.select2-selection').addClass('is-invalid-select2');
            isValidate = false;
        }
        if(!expCountryId) {
            elmExpCountry.addClass('is-invalid');
            elmExpCountry.siblings(".select2-container").find('.select2-selection').addClass('is-invalid-select2');
            isValidate = false;
        }
        return isValidate;
      }

    function addRow() {
        var uid = uuidv4();
        
        // Build table row for added dynamically
        var row = "<tr class='rows'><td><span id='buyer-trader-view-" + uid + "'>"+ buyerTraderName + "</span>" +
                "<input class='buyer-trader' id='buyer-trader-" + uid + "'name='buyer_trader_id[]' type='hidden' value='"+buyerTraderId+"'>" + 
                "<input class='new-buyer-trader' id='new-buyer-trader-" + uid + "'name='new_buyer_trader_name[]' type='hidden' value='"+newBuyerTraderName+"'>" + "</td><td>"+
                "<span id='items-view-" + uid + "'>" + itemName + "</span>" + 
                "<input class='items' id='items-" + uid + "'name='items_id[]' type='hidden' value='"+itemId+"'>" + "</td><td>"+
                "<span id='transported-qty-view-" + uid + "'>" + transportedQty + "</span>" + 
                "<input class='transported-qty' id='transported-qty-" + uid + "'name='total_transported_quantity[]' type='hidden' value='"+transportedQty+"'>" + "</td><td>"+
                "<span id='sales-qty-view-" + uid + "'>" + salesQty + "</span>" + 
                "<input class='sales-qty' id='sales-qty-" + uid + "'name='total_sales_quantity[]' type='hidden' value='"+salesQty+"'>" + "</td><td>"+
                "<span id='damaged-qty-view-" + uid + "'>" + damagedQty + "</span>" + 
                "<input class='damaged-qty' id='damaged-qty-" + uid + "'name='damaged_quantity[]' type='hidden' value='"+damagedQty+"'>" + "</td><td>"+
                "<span id='exp-company-country-view-" + uid + "'>" + expCompany + ", " + expCountry + "</span>" + 
                "<input class='exporter-company' id='exporter-company-" + uid + "' name='exporter_company_id[]' type='hidden' value='"+expCompanyId+"'>" +
                "<input class='exporter-country' id='exporter-country-" + uid + "' name='exporter_country_id[]' type='hidden' value='"+expCountryId+"'>" + "</td><td>"+
                "<div class='btn-group'><a class='edit btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                "<a class='remove btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a></div>"
                + "</td></tr>";
                //console.log(row);
                elmTableDetails.find('tbody').append(row);
    }

    function updateRow(rowUid) {
        $('#buyer-trader-view-' + rowUid).text(buyerTraderName);
        $('#buyer-trader-' + rowUid).val(buyerTraderId);
        $('#new-buyer-trader-' + rowUid).val(newBuyerTraderName);
        
        $('#items-view-' + rowUid).text(itemName);
        $('#items-' + rowUid).val(itemId);

        $('#transported-qty-view-' + rowUid).text(transportedQty);
        $('#transported-qty-' + rowUid).val(transportedQty);

        $('#sales-qty-view-' + rowUid).text(salesQty);
        $('#sales-qty-' + rowUid).val(salesQty);

        $('#damaged-qty-view-' + rowUid).text(damagedQty);
        $('#damaged-qty-' + rowUid).val(damagedQty);

        $('#exp-company-country-view-' + rowUid).text(expCompany + ", " + expCountry);
        $('#exporter-company-' + rowUid).val(expCompanyId);
        $('#exporter-country-' + rowUid).val(expCountryId);

    }

    elmTableDetails.on('click', '.rows a.edit', function (e) {
        var rowUid = $(this).attr('uid');
        $('#row-id').val(rowUid);
        var item = $('#items-' + rowUid).val();
        var company = $('#exporter-company-' + rowUid).val();
        varItemCompany = [{item:item, company:company}];
        elmBuyerTrader.val($('#buyer-trader-' + rowUid).val()).trigger('focus').trigger('change', varItemCompany);
        elmNewBuyerTrader.val($('#new-buyer-trader-' + rowUid).val());
        elmItem.val($('#items-' + rowUid).val()).trigger('change');
        elmTransportedQty.val($('#transported-qty-' + rowUid).val());
        elmSalesQty.val($('#sales-qty-' + rowUid).val());
        elmDamagedQty.val($('#damaged-qty-' + rowUid).val());
        elmExpCompany.val($('#exporter-company-' + rowUid).val()).trigger('change');
        elmExpCountry.val($('#exporter-country-' + rowUid).val()).trigger('change');

        $('.btn-sales-item').text(labelUpdate);
    });
    // Delete a pond details list row
    elmTableDetails.on('click', '.rows a.remove', function (event) {
        if( confirm('Are you sure?') ) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
        
    });
});