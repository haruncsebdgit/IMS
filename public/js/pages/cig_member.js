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
     * Pond information form repeater for DoF
     */
    var pondName;
    var waterArea;
    var usedTechnologyId;
    var usedTechnologyName;
    var usedTechnologyElement = document.getElementById('used-technology');
    var elmTablePond = $('#table-pond-details');
    $('body').on('click', '#btn-pond-details', function() {
        
        pondName = document.getElementById('pond-name-number').value;
        waterArea = document.getElementById('water-area').value;
        usedTechnologyName = usedTechnologyElement.options[usedTechnologyElement.selectedIndex].text;
        usedTechnologyId = usedTechnologyElement.value;

        // Validating form
        var isValidate = true;
        $('#pond-name-number').removeClass('is-invalid');
        $('#water-area').removeClass('is-invalid');
        $('#used-technology').removeClass('is-invalid');
        if(!pondName) {
            $('#pond-name-number').addClass('is-invalid');
            isValidate = false;
        }

        if(!waterArea) {
            $('#water-area').addClass('is-invalid');
            isValidate = false;
        }
        if(!usedTechnologyId) {
            $('#used-technology').addClass('is-invalid');
            isValidate = false;
        }

        if(!isValidate) {
            return;
        }

        var existingRowId = $('#pond-details-row-id').val();
        if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
            updatePondDetailsData(existingRowId);
        } else {
            addPondDetailsData();
        }

        $('#pond-details-row-id').val('');
        // Removing data from input field after successfully adding to list
        $('#pond-name-number').val('');
        $('#water-area').val('');
        $('#used-technology').val('');
    });

    function addPondDetailsData() {
        var uid = uuidv4();
        
        // Build table row for added dynamically
        var row = "<tr class='rows'><td><span id='pond-name-number-view-" + uid + "'>"+ pondName + "</span>" +
                "<input class='pond-name-number' id='pond-name-number-" + uid + "'name='pond_name_number[]' type='hidden' value='"+pondName+"'>" + "</td><td>"+
                "<span id='water-area-view-" + uid + "'>" + waterArea + "</span>" + 
                "<input class='water-area' id='water-area-" + uid + "'name='water_area[]' type='hidden' value='"+waterArea+"'>" + "</td><td>"+
                "<span id='used-technology-view-" + uid + "'>" + usedTechnologyName + "</span>" + 
                "<input class='used-technology' id='used-technology-" + uid + "'name='used_technology_id[]' type='hidden' value='"+usedTechnologyId+"'>" + "</td><td>"+
                "<a class='edit-pond btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                "<a class='remove-pond btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                + "</td></tr>";

                elmTablePond.find('tbody').append(row);
    }

    function updatePondDetailsData(rowUid) {
        $('#pond-name-number-view-' + rowUid).text(pondName);
        $('#pond-name-number-' + rowUid).val(pondName);
        
        $('#water-area-view-' + rowUid).text(waterArea);
        $('#water-area-' + rowUid).val(waterArea);

        $('#used-technology-view-' + rowUid).text(usedTechnologyName);
        $('#used-technology-' + rowUid).val(usedTechnologyId);

    }

    elmTablePond.on('click', '.rows a.edit-pond', function (e) {
        var rowUid = $(this).attr('uid');
        $('#pond-details-row-id').val(rowUid);

        $('#pond-name-number').val($('#pond-name-number-' + rowUid).val());
        $('#water-area').val($('#water-area-' + rowUid).val());
        $('#used-technology').val($('#used-technology-' + rowUid).val());
    });
    // Delete a pond details list row
    elmTablePond.on('click', '.rows a.remove-pond', function (event) {
        if( confirm('Are you sure?') ) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
        
    });

    /**
     * Livestock information repeater for DLS
     */

     var animalTypeId;
     var animalTypeName;
     var elmAnimalType = document.getElementById('animal-type');
     var breedTypeId;
     var breedTypeName;
     var elmBreedType = document.getElementById('breed-type');
     var animalNumber;
     var elmTableLivestock = $('#table-livestock-details');
     $('body').on('click', '#btn-livestock-details', function() {
         
         animalNumber = document.getElementById('animal-number').value;
         animalTypeName = elmAnimalType.options[elmAnimalType.selectedIndex].text;
         animalTypeId = elmAnimalType.value;
         breedTypeName = elmBreedType.options[elmBreedType.selectedIndex].text;
         breedTypeId = elmBreedType.value;
 
         // Validating form
         var isValidate = true;
         $('#animal-type').removeClass('is-invalid');
         $('#breed-type').removeClass('is-invalid');
         $('#animal-number').removeClass('is-invalid');
         if(!animalTypeId) {
             $('#animal-type').addClass('is-invalid');
             isValidate = false;
         }
 
         if(!breedTypeId) {
             $('#breed-type').addClass('is-invalid');
             isValidate = false;
         }
         if(!animalNumber) {
             $('#animal-number').addClass('is-invalid');
             isValidate = false;
         }
 
         if(!isValidate) {
             return;
         }
 
         var existingRowId = $('#livestock-details-row-id').val();
         if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
            updateLivestockDetailsData(existingRowId);
         } else {
             addLivestockDetailsData();
         }
 
         $('#livestock-details-row-id').val('');
         // Removing data from input field after successfully adding to list
         $('#animal-type').val('');
         $('#breed-type').val('');
         $('#animal-number').val('');
     });
 
     function addLivestockDetailsData() {
         var uid = uuidv4();
         
         // Build table row for added dynamically
         var row = "<tr class='rows'><td><span id='animal-type-view-" + uid + "'>"+ animalTypeName + "</span>" +
                 "<input class='animal-type' id='animal-type-" + uid + "'name='animal_type_id[]' type='hidden' value='"+animalTypeId+"'>" + "</td><td>"+
                 "<span id='breed-type-view-" + uid + "'>" + breedTypeName + "</span>" + 
                 "<input class='breed-type' id='breed-type-" + uid + "'name='breed_type_id[]' type='hidden' value='"+breedTypeId+"'>" + "</td><td>"+
                 "<span id='animal-number-view-" + uid + "'>" + animalNumber + "</span>" + 
                 "<input class='animal-number' id='animal-number-" + uid + "'name='number_of_animal[]' type='hidden' value='"+animalNumber+"'>" + "</td><td>"+
                 "<a class='edit-livestock btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                 "<a class='remove-livestock btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                 + "</td></tr>";
 
                 elmTableLivestock.find('tbody').append(row);
     }
 
     function updateLivestockDetailsData(rowUid) {
         $('#animal-type-view-' + rowUid).text(animalTypeName);
         $('#animal-type-' + rowUid).val(animalTypeId);
         
         $('#breed-type-view-' + rowUid).text(breedTypeName);
         $('#breed-type-' + rowUid).val(breedTypeId);
 
         $('#animal-number-view-' + rowUid).text(animalNumber);
         $('#animal-number-' + rowUid).val(animalNumber);
 
     }
 
     elmTableLivestock.on('click', '.rows a.edit-livestock', function (e) {
         var rowUid = $(this).attr('uid');
         $('#livestock-details-row-id').val(rowUid);
 
         $('#animal-type').val($('#animal-type-' + rowUid).val()).trigger('focus');
         $('#breed-type').val($('#breed-type-' + rowUid).val());
         $('#animal-number').val($('#animal-number-' + rowUid).val());
     });
     // Delete a pond details list row
     elmTableLivestock.on('click', '.rows a.remove-livestock', function (event) {
         if( confirm('Are you sure?') ) {
             $(this).parents("tr:first").remove();
             $(this).parent().parent().remove();
         }
         
     });

});