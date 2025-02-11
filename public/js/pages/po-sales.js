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

    // Show hide CIG dropdwon by CIG Type (CIG and NON CIG)
    $('.cig-type').click(function() {
        var checkedCigType = $(".cig-type:checked").val();
        cigTypeWiseShowHideCigMember(checkedCigType);

    });

     // Populate CIG Member by CIG
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
                     cigMember.append('<option value="">' + app.label_select + '</option>');

                     $.each(data, function (index, value) {
                         cigMember.append('<option value="' + index + '">' + value + '</option>');
                     });
                 }
             });
         }
     });

     $('#items').change(function () {
        let app_locale = app.app_locale;

        var itemID = $(this).val();
        if (itemID) {
            $.get(app.app_url + 'admin/crop-variety/getUnitByCropItemId/' + itemID, function (data) {
                //data = JSON.parse(data);
                if(data) {
                    $('#unit').val(data);
                }
            });
        }
    });

     $('#unit-price, #total-qty').keyup(function(){
         var unitPrice = $('#unit-price').val();
         var totalQuantity = $('#total-qty').val();
         if(unitPrice && totalQuantity) {
            $('#total-sale-price').val(parseFloat(unitPrice) * parseFloat(totalQuantity)).removeClass('is-invalid');
            //$('#total-sale-price').removeClass('is-invalid');
         }
         //alert(unitPrice);
     });


     /**
     * PO Sales collection repeater
     */

      var cigId;
      var cigName;
      var elmCig = $('#cig-id');
      var sellerId;
      var sellerName;
      var elmSeller = $('#cig-member-id');

      var sellerOtherId;
      var sellerOther;
      var elmSellerOther = $('#farmer-list');

      var memberTypeId;
      var memberType;
      var elmMemberType = $('#cigType');

      var itemId;
      var itemName;
      var elmItem = $('#items');

      var unitId;
      var unitName;
      var elmUnit = $('#unit');

      var gradeId;
      var gradeName;
      var elmGrade = $('#grade');

      var unitPrice;
      var elmUnitPrice = $('#unit-price');

      var totalQuantity;
      var elmTotalQuantity = $('#total-qty');

      var totalSalePrice;
      var elmTotalSalePrice = $('#total-sale-price');

      var marketUnitPrice;
      var elmMarketUnitPrice = $('#market-price');

      var ccmcProcessingCost;
      var elmCcmcProcessing = $('#ccmc-processing-cost');

      var buyer;
      var elmBuyer = $('#buyer');

      var checkedCigType;

      var elmTableDetails = $('#table-details');
      $('body').on('click', '#btn-add-sales-collection', function() {

        checkedCigType = $(".cig-type:checked").val();

        cigId = elmCig.val();
        cigName = elmCig.find('option:selected').text();

        sellerId = elmSeller.val();
        sellerName = elmSeller.find('option:selected').text();

        // sellerOther = elmSellerOther.val();
        sellerOtherId = elmSellerOther.val();
        sellerOther = elmSellerOther.find('option:selected').text();
        console.log(sellerOther);

        memberTypeId = elmMemberType.val();
        memberType = elmMemberType.find('option:selected').text();

        itemId = elmItem.val();
        itemName = elmItem.find('option:selected').text();

        unitId = elmUnit.val();
        unitName = elmUnit.find('option:selected').text();

        gradeId = elmGrade.val();
        gradeName = elmGrade.find('option:selected').text();

        unitPrice = elmUnitPrice.val();
        totalQuantity = elmTotalQuantity.val();
        totalSalePrice = elmTotalSalePrice.val();
        marketUnitPrice = elmMarketUnitPrice.val();
        ccmcProcessingCost = elmCcmcProcessing.val();
        buyer = elmBuyer.val();

        if(memberTypeId == 'non-cig'){
            cigId = "";
            sellerId = "";
            cigName = memberType;
            sellerName = sellerOther;
        }

          // Validating form
          //console.log("block");
          if(!validateCollectionDetailsForm()) {
              //console.log('return')
              return;
          }

          var existingRowId = $('#row-id').val();
          //console.log(existingRowId);
          if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
            updateCollectionDetailsData(existingRowId);
          } else {
             addCollectionDetailsData();
          }
        // Clearing field after adding
        elmMemberType.val('').trigger('change');
        elmCig.val('').trigger('change');

        elmSeller.val('').trigger('change');

        elmSellerOther.val('').trigger('change');
        elmMemberType.val('');

        elmItem.val('');
        elmUnit.val('');

        elmGrade.val('');

        elmUnitPrice.val('');
        elmTotalQuantity.val('');
        elmTotalSalePrice.val('');
        elmMarketUnitPrice.val('');
        elmCcmcProcessing.val('');
      });

      function validateCollectionDetailsForm()
      {
        var isValidate = true;
        elmMemberType.removeClass('is-invalid');
        elmCig.removeClass('is-invalid');
        elmSeller.removeClass('is-invalid');
        elmItem.removeClass('is-invalid');
        elmUnit.removeClass('is-invalid');
        elmGrade.removeClass('is-invalid');
        elmUnitPrice.removeClass('is-invalid');
        elmTotalQuantity.removeClass('is-invalid');
        elmTotalSalePrice.removeClass('is-invalid');
        elmMarketUnitPrice.removeClass('is-invalid');
        elmCcmcProcessing.removeClass('is-invalid');

        if(memberTypeId == 'cig') {
            if(!cigId) {
                elmCig.addClass('is-invalid');
                isValidate = false;
            }
            if(!sellerId) {
                elmSeller.addClass('is-invalid');
                isValidate = false;
            }
        } else {
            if(!sellerOther) {
                elmSellerOther.addClass('is-invalid');
                isValidate = false;
            }
        }
        if(!itemId) {
            elmItem.addClass('is-invalid');
            isValidate = false;
        }
        if(!unitId) {
            elmUnit.addClass('is-invalid');
            isValidate = false;
        }
        if(!gradeId) {
            elmGrade.addClass('is-invalid');
            isValidate = false;
        }
        if(!unitPrice) {
            elmUnitPrice.addClass('is-invalid');
            isValidate = false;
        }
        if(!totalQuantity) {
            elmTotalQuantity.addClass('is-invalid');
            isValidate = false;
        }
        if(!totalSalePrice) {
            elmTotalSalePrice.addClass('is-invalid');
            isValidate = false;
        }
        if(!marketUnitPrice) {
            elmMarketUnitPrice.addClass('is-invalid');
            isValidate = false;
        }
        if(!ccmcProcessingCost) {
            elmCcmcProcessing.addClass('is-invalid');
            isValidate = false;
        }
       // alert(isValidate);
        return isValidate;
      }

      function addCollectionDetailsData() {
          var uid = uuidv4();

          // Build table row for added dynamically
          var row = "<tr class='rows'><td> <small class='text-muted' title='Type of Seller' data-toggle='tooltip'> <span id='cig-view-" + uid + "'>"+ cigName + "</span></small>" +
                  "<input class='cig' id='cig-" + uid + "' name='cig_id[]' type='hidden' value='"+cigId+"'>" +
                  "<div><span id='cig-member-view-" + uid + "'>" + sellerName + "</div></span>" +
                  "<input class='cig-member' id='cig-member-" + uid + "'name='seller_name_id[]' type='hidden' value='"+sellerId+"'>" +
                  "<input class='member-type' id='member-type-" + uid + "'name='member_type_details[]' type='hidden' value='"+memberTypeId+"'>" +
                  "<input class='seller-name-other' id='seller-name-other-" + uid + "'name='farmer_id_details[]' type='hidden' value='"+sellerOtherId+"'>" + "</td><td>"+
                  "<span id='items-view-" + uid + "'>" + itemName + "</span>" +
                  "<input class='items' id='items-" + uid + "'name='item_id[]' type='hidden' value='"+itemId+"'>" + "</td><td>"+
                  "<span id='grade-view-" + uid + "'>" + gradeName + "</span>" +
                  "<input class='grade' id='grade-" + uid + "'name='grade[]' type='hidden' value='"+gradeId+"'>" + "</td><td>"+
                  "<span id='unit-price-view-" + uid + "'>" + unitPrice + "</span>" +
                  "<input class='unit-price' id='unit-price-" + uid + "'name='unit_price[]' type='hidden' value='"+unitPrice+"'>" + "</td><td>"+
                  "<span id='total-qty-view-" + uid + "'>" + totalQuantity + "</span>" +
                  "<span id='unit-view-" + uid + "'>" + unitName + "</span>" +
                  "<input class='total-qty' id='total-qty-" + uid + "'name='total_quantity[]' type='hidden' value='"+totalQuantity+"'>" +
                  "<input class='unit' id='unit-" + uid + "'name='unit_id[]' type='hidden' value='"+unitId+"'>" + "</td><td>"+
                  "<span id='total-sale-price-view-" + uid + "'>" + totalSalePrice + "</span>" +
                  "<input class='total-sale-price' id='total-sale-price-" + uid + "'name='total_sales_price[]' type='hidden' value='"+totalSalePrice+"'>" + "</td><td>"+
                  "<span id='market-price-view-" + uid + "'>" + marketUnitPrice + "</span>" +
                  "<input class='market-price' id='market-price-" + uid + "'name='market_unit_price[]' type='hidden' value='"+marketUnitPrice+"'>" + "</td><td>"+
                  "<span id='ccmc-processing-cost-view-" + uid + "'>" + ccmcProcessingCost + "</span>" +
                  "<input class='ccmc-processing-cost' id='ccmc-processing-cost-" + uid + "'name='ccmc_processing_cost[]' type='hidden' value='"+ccmcProcessingCost+"'>" +
                  "<input class='buyer' id='buyer-" + uid + "'name='buyer_name[]' type='hidden' value='"+buyer+"'>" + "</td><td>"+
                  "<div class='btn-group'><a class='edit btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                  "<a class='remove btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a></div>"
                  + "</td></tr>";
                    // console.log(row);
                  elmTableDetails.find('tbody').append(row);
      }


      function updateCollectionDetailsData(rowUid) {
          $('#cig-' + rowUid).val(cigId);
          $('#cig-view-' + rowUid).text(cigName);
          $('#cig-member-' + rowUid).val(sellerId);
          $('#cig-member-view-' + rowUid).text(sellerName);
          //console.log(sellerName);

          if (memberTypeId != 'cig') {
             $('#seller-name-other-' + rowUid).val(sellerOtherId);
          }

          $('#items-view-' + rowUid).text(itemName);
          $('#items-' + rowUid).val(itemId);

          $('#unit-view-' + rowUid).text(unitName);
          $('#unit-' + rowUid).val(unitId);

          $('#grade-view-' + rowUid).text(gradeName);
          $('#grade-' + rowUid).val(gradeId);

          $('#unit-price-view-' + rowUid).text(unitPrice);
          $('#unit-price-' + rowUid).val(unitPrice);

          $('#total-qty-view-' + rowUid).text(totalQuantity);
          $('#total-qty-' + rowUid).val(totalQuantity);

          $('#total-sale-price-view-' + rowUid).text(totalSalePrice);
          $('#total-sale-price-' + rowUid).val(totalSalePrice);

          $('#market-price-view-' + rowUid).text(marketUnitPrice);
          $('#market-price-' + rowUid).val(marketUnitPrice);

          $('#ccmc-processing-cost-view-' + rowUid).text(ccmcProcessingCost);
          $('#ccmc-processing-cost-' + rowUid).val(ccmcProcessingCost);
          $('#buyer-' + rowUid).val(buyer);

      }

      elmTableDetails.on('click', '.rows a.edit', function (e) {
          var rowUid = $(this).attr('uid');
          $('#row-id').val(rowUid);
          elmMemberType.val($('#member-type-' + rowUid).val()).trigger('change');
          var cigId = $('#cig-'+rowUid).val();
          if (!cigId) {
            elmSellerOther.val($('#seller-name-other-' + rowUid).val()).trigger('change').trigger('focus');
          } else {
              var cigMem = $('#cig-member-' + rowUid).val();
              selectedMem = [{member_id:cigMem}];
              elmCig.val($('#cig-' + rowUid).val()).trigger('change', selectedMem);
            // elmSeller.val($('#cig-member-' + rowUid).val()).trigger('change');
          }

          elmItem.val($('#items-' + rowUid).val());
          elmUnit.val($('#unit-' + rowUid).val());
          elmGrade.val($('#grade-' + rowUid).val());
          elmUnitPrice.val($('#unit-price-' + rowUid).val());
          elmTotalQuantity.val($('#total-qty-' + rowUid).val());
          elmTotalSalePrice.val($('#total-sale-price-' + rowUid).val());
          elmMarketUnitPrice.val($('#market-price-' + rowUid).val());
          elmCcmcProcessing.val($('#ccmc-processing-cost-' + rowUid).val());
          elmBuyer.val($('#buyer-' + rowUid).val());

      });
      // Delete a pond details list row
      elmTableDetails.on('click', '.rows a.remove', function (event) {
          if( confirm('Are you sure?') ) {
              $(this).parents("tr:first").remove();
              $(this).parent().parent().remove();
          }

      });
});
