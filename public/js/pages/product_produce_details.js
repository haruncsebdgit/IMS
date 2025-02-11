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

     var ParameterId;
     var ParameterName;
     var elmParameter = document.getElementById('parameter');
     var elmTableProductProduce = $('#table_product_produce_details');
     $('body').on('click', '#btn_product_produce__details', function() {
         measureBeforeIntervention = document.getElementById('measure_before_intervention').value;
         console.log(measureBeforeIntervention);
         measureAfterIntervention = document.getElementById('measure_after_intervention').value;
         takenActions = document.getElementById('taken_actions').value;
         takenActionsCig = document.getElementById('taken_actions_cig').value;
         takenActionsNonCig = document.getElementById('taken_actions_non_cig').value;
         pondWaterCig = document.getElementById('pond_water_cig').value;
         remarks = document.getElementById('remarks').value;
         pondWaterNonCig = document.getElementById('pond_water_non_cig').value;
         ParameterName = elmParameter.options[elmParameter.selectedIndex].text;
         ParameterId = elmParameter.value;

         // Validating form
         var isValidate = true;
         $('#parameter').removeClass('is-invalid');
         $('#measure_before_intervention').removeClass('is-invalid');
         $('#measure_after_intervention').removeClass('is-invalid');
         $('#taken_actions').removeClass('is-invalid');
         $('#taken_actions_cig').removeClass('is-invalid');
         $('#taken_actions_non_cig').removeClass('is-invalid');
         $('#pond_water_cig').removeClass('is-invalid');
         $('#pond_water_non_cig').removeClass('is-invalid');
         $('#remarks').removeClass('is-invalid');
         if(!ParameterId) {
             $('#parameter').addClass('is-invalid');
             isValidate = false;
         }

         if(!measureBeforeIntervention) {
            $('#measure_before_intervention').addClass('is-invalid');
            isValidate = false;
        }

        if(!measureAfterIntervention) {
            $('#measure_after_intervention').addClass('is-invalid');
            isValidate = false;
        }
        if(!takenActions) {
            $('#taken_actions').addClass('is-invalid');
            isValidate = false;
        }
        if(!takenActionsCig) {
            $('#taken_actions_cig').addClass('is-invalid');
            isValidate = false;
        }
        if(!takenActionsNonCig) {
            $('#taken_actions_non_cig').addClass('is-invalid');
            isValidate = false;
        }
        if(!pondWaterCig) {
            $('#pond_water_cig').addClass('is-invalid');
            isValidate = false;
        }
        if(!pondWaterNonCig) {
            $('#pond_water_non_cig').addClass('is-invalid');
            isValidate = false;
        }
        if(!remarks) {
            $('#remarks').addClass('is-invalid');
            isValidate = false;
        }

         if(!isValidate) {
             return;
         }

         var existingRowId = $('#product_produce_details_row_uid').val();
         if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
            updateProductProduceData(existingRowId);
         } else {
             addProductProduceData();
         }

         $('#product_produce_details_row_uid').val('');
         // Removing data from input field after successfully adding to list
         $('#parameter').val('');
         $('#measure_before_intervention').val('');
         $('#measure_after_intervention').val('');
         $('#taken_actions').val('');
         $('#taken_actions_cig').val('');
         $('#taken_actions_non_cig').val('');
         $('#pond_water_cig').val('');
         $('#pond_water_non_cig').val('');
         $('#remarks').val('');
     });

     function addProductProduceData() {
         var uid = uuidv4();
         // Build table row for added dynamically
         var row = "<tr class='rows text-center'><td><span id='parameter-id-view-" + uid + "'>"+ ParameterName + "</span>" +
                 "<input class='parameter-id' id='parameter-id-" + uid + "'name='parameter_name[]' type='hidden' value='"+ParameterId+"'>" + "</td><td>"+
                 "<span id='pond-water-cig-view-" + uid + "'>" + pondWaterCig + "</span>" +
                 "<input class='pond-water-cig' id='pond-water-cig-" + uid + "'name='pond_water_cig[]' type='hidden' value='"+pondWaterCig+"'>" + "</td><td>"+
                 "<span id='pond-water-non-view-" + uid + "'>" + pondWaterNonCig + "</span>" +
                 "<input class='pond-water-non' id='pond-water-non-" + uid + "'name='pond_water_non_cig[]' type='hidden' value='"+pondWaterNonCig+"'>" + "</td><td>"+
                 "<span id='measure-before-intervention-view-" + uid + "'>" + measureBeforeIntervention + "</span>" +
                 "<input class='measure-before-intervention' id='measure-before-intervention-" + uid + "'name='measure_before_intervention[]' type='hidden' value='"+measureBeforeIntervention+"'>" + "</td><td>"+
                 "<span id='measure-after-intervention-view-" + uid + "'>" + measureAfterIntervention + "</span>" +
                 "<input class='measure-after-intervention' id='measure-after-intervention-" + uid + "'name='measure_after_intervention[]' type='hidden' value='"+measureAfterIntervention+"'>" + "</td><td>"+
                 "<span id='taken-actions-view-" + uid + "'>" + takenActions + "</span>" +
                 "<input class='taken-actions' id='taken-actions-" + uid + "'name='taken_actions[]' type='hidden' value='"+takenActions+"'>" + "</td><td>"+
                 "<span id='taken-actions-cig-view-" + uid + "'>" + takenActionsCig + "</span>" +
                 "<input class='taken-actions-cig' id='taken-actions-cig-" + uid + "'name='taken_actions_cig[]' type='hidden' value='"+takenActionsCig+"'>" + "</td><td>"+
                 "<span id='taken-actions-non-cig-view-" + uid + "'>" + takenActionsNonCig + "</span>" +
                 "<input class='taken-actions-non-cig' id='taken-actions-non-cig-" + uid + "'name='taken_actions_non_cig[]' type='hidden' value='"+takenActionsNonCig+"'>" + "</td><td>"+
                 "<span id='remarks-view-" + uid + "'>" + remarks + "</span>" +
                 "<input class='remarks' id='remarks-" + uid + "'name='remarks[]' type='hidden' value='"+remarks+"'>" + "</td><td>"+



                 "<a class='edit-product-produce-details btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                 "<a class='remove-product-produce-details btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                 + "</td></tr>";

                 elmTableProductProduce.find('tbody').append(row);
     }

     function updateProductProduceData(rowUid) {
         $('#parameter-id-view-' + rowUid).text(ParameterName);
         $('#parameter-id-' + rowUid).val(ParameterId);


         $('#pond-water-cig-view-' + rowUid).text(pondWaterCig);
         $('#pond-water-cig-' + rowUid).val(pondWaterCig);

         $('#pond-water-non-view-' + rowUid).text(pondWaterNonCig);
         $('#pond-water-non-' + rowUid).val(pondWaterNonCig);

         $('#measure-before-intervention-view-' + rowUid).text(measureBeforeIntervention);
         $('#measure-before-intervention-' + rowUid).val(measureBeforeIntervention);

         $('#measure-after-intervention-view-' + rowUid).text(measureAfterIntervention);
         $('#measure-after-intervention-' + rowUid).val(measureAfterIntervention);


         $('#taken-actions-view-' + rowUid).text(takenActions);
         $('#taken-actions-' + rowUid).val(takenActions);

         $('#taken-actions-cig-view-' + rowUid).text(takenActionsCig);
         $('#taken-actions-cig-' + rowUid).val(takenActionsCig);

         $('#taken-actions-non-cig-view-' + rowUid).text(takenActionsNonCig);
         $('#taken-actions-non-cig-' + rowUid).val(takenActionsNonCig);

         $('#remarks-view-' + rowUid).text(remarks);
         $('#remarks-' + rowUid).val(remarks);

     }

     elmTableProductProduce.on('click', '.rows a.edit-product-produce-details', function (e) {
         console.log("errors");
         var rowUid = $(this).attr('uid');
         $('#product_produce_details_row_uid').val(rowUid);

         $('#parameter').val($('#parameter-id-' + rowUid).val()).trigger('focus');
         $('#measure_before_intervention').val($('#measure-before-intervention-' + rowUid).val());
         $('#measure_after_intervention').val($('#measure-after-intervention-' + rowUid).val());
         $('#taken_actions').val($('#taken-actions-' + rowUid).val());
         $('#taken_actions_cig').val($('#taken-actions-cig-' + rowUid).val());
         $('#taken_actions_non_cig').val($('#taken-actions-non-cig-' + rowUid).val());
         $('#pond_water_cig').val($('#pond-water-cig-' + rowUid).val());
         $('#pond_water_non_cig').val($('#pond-water-non-' + rowUid).val());
         $('#remarks').val($('#remarks-' + rowUid).val());
     });
     // Delete a pond details list row
     elmTableProductProduce.on('click', '.rows a.remove-product-produce-details', function (event) {
         if( confirm('Are you sure?') ) {
             $(this).parents("tr:first").remove();
             $(this).parent().parent().remove();
         }

     });
    });
