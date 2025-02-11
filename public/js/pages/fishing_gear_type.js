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
     
     $("#sample_unit,#total_unit").keyup(function(){
        var sampleUnit = document.getElementById('sample_unit').value;
        var totalUnit = document.getElementById('total_unit').value;
        var myraisingFactor = parseInt(totalUnit)/parseInt(sampleUnit);
        if(isNaN(myraisingFactor)){
            $("#raising_factor").prop('disabled', true);
        }else{
            console.log(myraisingFactor.toFixed(2));
            $('#raising_factor').val(myraisingFactor.toFixed(2));
            $("#raising_factor").prop('disabled', true);
        }
       
      });  


     var fishingGearId;
     var fishingGearName;
     var elmFishingGear = document.getElementById('fishing_gear_type_id');
     var gearNumber;
     var totalUnit;
     var sampleUnit;
     var raisingFactor;
     var elmTableFishingGear = $('#table_fishing_gear_type_details');
     $('body').on('click', '#btn_fishing_gear_type_details', function() {
         gearNumber = document.getElementById('gear_number').value;
         totalUnit = document.getElementById('total_unit').value;
         sampleUnit = document.getElementById('sample_unit').value;
         raisingFactor = document.getElementById('raising_factor').value;
         fishingGearName = elmFishingGear.options[elmFishingGear.selectedIndex].text;
         fishingGearId = elmFishingGear.value;


 
         // Validating form
         var isValidate = true;
         $('#fishing_gear_type_id').removeClass('is-invalid');
         $('#total_unit').removeClass('is-invalid');
         $('#sample_unit').removeClass('is-invalid');
         $('#raising_factor').removeClass('is-invalid');
         if(!fishingGearId) {
             $('#fishing_gear_type_id').addClass('is-invalid');
             isValidate = false;
         }

         if(!totalUnit) {
            $('#total_unit').addClass('is-invalid');
            isValidate = false;
        }

        if(!sampleUnit) {
            $('#sample_unit').addClass('is-invalid');
            isValidate = false;
        } 
        if(!raisingFactor) {
            $('#raising_factor').addClass('is-invalid');
            isValidate = false;
        }
 
         if(!isValidate) {
             return;
         }
 
         var existingRowId = $('#fishing_gear_type_details_row_uid').val();
         if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
            updateFishingGearData(existingRowId);
         } else {
             addFishingGearData();
         }
 
         $('#fishing_gear_type_details_row_uid').val('');
         // Removing data from input field after successfully adding to list
         $('#fishing_gear_type_id').val('');
         $('#total_unit').val('');
         $('#sample_unit').val('');
         $('#raising_factor').val('');
     });
 
     function addFishingGearData() {
         var uid = uuidv4();
         // Build table row for added dynamically
         var row = "<tr class='rows text-center'><td><span id='fishing-gear-id-view-" + uid + "'>"+ fishingGearName + "</span>" +
                 "<input class='fishing-gear-id' id='fishing-gear-id-" + uid + "'name='gear_type_fishing_gear_type_id[]' type='hidden' value='"+fishingGearId+"'>" + "</td><td>"+
                 "<span id='fishing-gear-total-unit-view-" + uid + "'>" + totalUnit + "</span>" + 
                 "<input class='fishing-gear-total-unit' id='fishing-gear-total-unit-" + uid + "'name='gear_type_total_unit[]' type='hidden' value='"+totalUnit+"'>" + "</td><td>"+
                 "<span id='fishing-gear-sample-unit-view-" + uid + "'>" + sampleUnit + "</span>" + 
                 "<input class='fishing-gear-sample-unit' id='fishing-gear-sample-unit-" + uid + "'name='gear_type_sample_unit[]' type='hidden' value='"+sampleUnit+"'>" + "</td><td>"+
                 "<span id='fishing-gear-raising-factor-view-" + uid + "'>" + raisingFactor + "</span>" + 
                 "<input class='fishing-gear-raising-factor' id='fishing-gear-raising-factor-" + uid + "'name='gear_type_raising_factor[]' type='hidden' value='"+raisingFactor+"'>" + "</td><td>"+
                 "<a class='edit-fishing-gear-type-details btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                 "<a class='remove-fishing-gear-type-details btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                 + "</td></tr>";
 
                 elmTableFishingGear.find('tbody').append(row);
     }
 
     function updateFishingGearData(rowUid) {
         $('#fishing-gear-id-view-' + rowUid).text(fishingGearName);
         $('#fishing-gear-id-' + rowUid).val(fishingGearId);
         
 
         $('#fishing-gear-total-unit-view-' + rowUid).text(totalUnit);
         $('#fishing-gear-total-unit-' + rowUid).val(totalUnit);

         $('#fishing-gear-sample-unit-view-' + rowUid).text(sampleUnit);
         $('#fishing-gear-sample-unit-' + rowUid).val(sampleUnit);

         $('#fishing-gear-raising-factor-view-' + rowUid).text(raisingFactor);
         $('#fishing-gear-raising-factor-' + rowUid).val(raisingFactor);
 
     }
 
     elmTableFishingGear.on('click', '.rows a.edit-fishing-gear-type-details', function (e) {
         var rowUid = $(this).attr('uid');
         $('#fishing_gear_type_details_row_uid').val(rowUid);
 
         $('#fishing_gear_type_id').val($('#fishing-gear-id-' + rowUid).val()).trigger('focus');
         $('#total_unit').val($('#fishing-gear-total-unit-' + rowUid).val());
         $('#sample_unit').val($('#fishing-gear-sample-unit-' + rowUid).val());
         $('#raising_factor').val($('#fishing-gear-raising-factor-' + rowUid).val());
     });
     // Delete a pond details list row
     elmTableFishingGear.on('click', '.rows a.remove-fishing-gear-type-details', function (event) {
         if( confirm('Are you sure?') ) {
             $(this).parents("tr:first").remove();
             $(this).parent().parent().remove();
         }
         
     });
    });
