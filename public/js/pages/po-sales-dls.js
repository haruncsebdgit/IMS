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
    
    $('#po').change(function (e, selectedItemsCompany) {
        let app_locale = app.app_locale;
        
        var poId = $(this).val();
        if (poId) {
            $.get(app.app_url + 'admin/monitoring/po-member/getMemberByPoId/' + poId, function (data) {
                let poMember = $('#po-member');
                //data = JSON.parse(data);
                if(poMember.length > 0) {
                    //success data
                    poMember.empty();
                    poMember.append('<option value="">' + app.label_select + '</option>');

                    $.each(data, function (index, value) {
                        poMember.append('<option value="' + index + '">' + value + '</option>');
                    });
                }
            });
        }
    });
    
    $('#product-type').change(function (e, selectedItemsCompany) {
        let app_locale = app.app_locale;
        
        var productTypeId = $(this).val();
        if (productTypeId) {
            $.get(app.app_url + 'admin/monitoring/po-product-information/getProductByType/' + productTypeId, function (data) {
                let product = $('#product-name');
                //data = JSON.parse(data);
                if(product.length > 0) {
                    //success data
                    product.empty();
                    product.append('<option value="">' + app.label_select + '</option>');

                    $.each(data, function (index, value) {
                        product.append('<option value="' + index + '">' + value + '</option>');
                    });
                }
            });
        }
    });
    // Calculating total sales from unit price and total qty
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


    // Sales details repeater
    var productTypeId;
    var productTypeName;
    var elmProductTypes = $('#product-type');

    var productId;
    var productName;
    var elmProducts = $('#product-name');

    var unitPrice;
    var elmUnitPrice = $("#unit-price");

    var totalQuantity;
    var elmTotalQuantity = $("#total-qty");

    var totalSalePrice;
    var elmTotalSalePrice = $("#total-sale-price");

    var noOfProduct;
    var elmNoOfProduct = $("#no-of-product");

    var noOfSale;
    var elmNoOfSale = $("#no-of-sale");

    var elmTableDetails = $("#table-details");
    $("body").on("click", "#btn-add-sales-details", function () {
        
        productTypeId = elmProductTypes.val();
        productTypeName = elmProductTypes.find('option:selected').text();

        productId = elmProducts.val();
        productName = elmProducts.find('option:selected').text();

        unitPrice = elmUnitPrice.val();
        totalQuantity = elmTotalQuantity.val();
        totalSalePrice = elmTotalSalePrice.val();
        noOfProduct = elmNoOfProduct.val();
        noOfSale = elmNoOfSale.val();

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
            $('.btn-sales-details').text(labelAddSalesDetails);
        } else {
            addDetailsData();
        }
        // Clearing field after adding

        elmProductTypes.val("").trigger('change');
        elmProducts.val("").trigger('change');

        elmUnitPrice.val("");
        elmTotalQuantity.val("");
        elmTotalSalePrice.val("");
        elmNoOfProduct.val("");
        elmNoOfSale.val("");
    });

    function validateDetailsForm() {
        var isValidate = true;
        
        elmProductTypes.removeClass("is-invalid");
        elmProducts.removeClass("is-invalid");
        elmUnitPrice.removeClass("is-invalid");
        elmTotalQuantity.removeClass("is-invalid");
        elmTotalSalePrice.removeClass("is-invalid");
        elmNoOfProduct.removeClass("is-invalid");
        elmNoOfSale.removeClass("is-invalid");

        if (!productTypeId) {
            elmProductTypes.addClass("is-invalid");
            elmProductTypes.siblings(".select2-container").find('.select2-selection').addClass('is-invalid-select2');

            isValidate = false;
        }
        if (!productId) {
            elmProducts.addClass("is-invalid");
            elmProducts.siblings(".select2-container").find('.select2-selection').addClass('is-invalid-select2');

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
        if (!noOfProduct) {
            elmNoOfProduct.addClass("is-invalid");
            isValidate = false;
        }
        if (!noOfSale) {
            elmNoOfSale.addClass("is-invalid");
            isValidate = false;
        }
        return isValidate;
    }

    function addDetailsData() {
        var uid = uuidv4();
        // Build table row for added dynamically
        var row = "<tr class='rows'><td><span id='product-type-view-" + uid + "'>"+ productTypeName + "</span>" +
        "<input class='product-type' id='product-type-" + uid + "'name='product_type_id[]' type='hidden' value='"+productTypeId+"'>" + "</td><td>"+
        "<span id='product-name-view-" + uid + "'>" + productName + "</span>" + 
        "<input class='product-name' id='product-name-" + uid + "'name='product_id[]' type='hidden' value='"+productId+"'>" + "</td><td>"+
        "<span id='unit-price-view-" + uid + "'>" + unitPrice + "</span>" + 
        "<input class='unit-price' id='unit-price-" + uid + "'name='unit_price[]' type='hidden' value='"+unitPrice+"'>" + "</td><td>"+
        "<span id='total-qty-view-" + uid + "'>" + totalQuantity + "</span>" + 
        "<input class='total-qty' id='total-qty-" + uid + "'name='total_quantity[]' type='hidden' value='"+totalQuantity+"'>" + "</td><td>"+
        "<span id='total-sale-price-view-" + uid + "'>" + totalSalePrice + "</span>" + 
        "<input class='total-sale-price' id='total-sale-price-" + uid + "'name='total_sales_price[]' type='hidden' value='"+totalSalePrice+"'>" + "</td><td>"+
        "<span id='no-of-sale-product-view-" + uid + "'>" + noOfProduct + ", " + noOfSale + "</span>" + 
        "<input class='no-of-product' id='no-of-product-" + uid + "'name='number_of_product[]' type='hidden' value='"+noOfProduct+"'>" +
        "<input class='no-of-sale' id='no-of-sale-" + uid + "'name='number_of_sale[]' type='hidden' value='"+noOfSale+"'>" + "</td><td>"+
        "<div class='btn-group'><a class='edit btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
        "<a class='remove btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a></div>"
        + "</td></tr>";
        //console.log(row);
        elmTableDetails.find('tbody').append(row);
    }

    function updateDetailsData(rowUid) {
        //console.log("test");
        $('#product-type-view-' + rowUid).text(productTypeName);
        $('#product-type-' + rowUid).val(productTypeId);

        $('#product-name-view-' + rowUid).text(productName);
        $('#product-name-' + rowUid).val(productId);

        $('#unit-price-view-' + rowUid).text(unitPrice);
        $('#unit-price-' + rowUid).val(unitPrice);

        $('#total-qty-view-' + rowUid).text(totalQuantity);
        $('#total-qty-' + rowUid).val(totalQuantity);

        $('#total-sale-price-view-' + rowUid).text(totalSalePrice);
        $('#total-sale-price-' + rowUid).val(totalSalePrice);

        $('#no-of-sale-product-view-' + rowUid).text(noOfProduct + ", " + noOfSale);
        $('#no-of-product-' + rowUid).val(noOfProduct);
        $('#no-of-sale-' + rowUid).val(noOfSale);
    }

    elmTableDetails.on("click", ".rows a.edit", function (e) {
        var rowUid = $(this).attr("uid");
        $("#row-id").val(rowUid);

        elmProductTypes.val($('#product-type-' + rowUid).val()).trigger('change');
        elmProducts.val($('#product-name-' + rowUid).val()).trigger('change');;
        elmUnitPrice.val($('#unit-price-' + rowUid).val());
        elmTotalQuantity.val($('#total-qty-' + rowUid).val());
        elmTotalSalePrice.val($('#total-sale-price-' + rowUid).val());
        elmNoOfProduct.val($('#no-of-product-' + rowUid).val());
        elmNoOfSale.val($('#no-of-sale-' + rowUid).val());

        $('.btn-sales-details').text(labelUpdateSalesDetails);
    });
    // Delete a pond details list row
    elmTableDetails.on("click", ".rows a.remove", function (event) {
        if (confirm("Are you sure?")) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
    });
});