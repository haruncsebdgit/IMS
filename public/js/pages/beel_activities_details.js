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

    let app = JSON.parse(app_data);

    /**
     * Stocking information form repeater for DoF
     */

    var elmTableStocking = $('#table-stocking-details');

    var stocking_fish_species_element = document.getElementById('stocking_fish_species_id');
    var stocking_fish_species_name;
    var stocking_fish_species_id;
    var stocking_number_fingerling;
    var average_individual_size;
    var average_individual_weight;
    var amount_fingerling_stocked;
   
    $('body').on('click', '#btn-stocking-details', function() {
        
        stocking_fish_species_name = stocking_fish_species_element.options[stocking_fish_species_element.selectedIndex].text;
        stocking_fish_species_id = stocking_fish_species_element.value;

        stocking_number_fingerling = document.getElementById('stocking_number_fingerling').value;
        average_individual_size = document.getElementById('average_individual_size').value;
        average_individual_weight = document.getElementById('average_individual_weight').value;
        amount_fingerling_stocked = document.getElementById('amount_fingerling_stocked').value;
      

        // Validating form
        var isValidate = true;

        $('#stocking_fish_species_id').removeClass('is-invalid');
        $('#stocking_number_fingerling').removeClass('is-invalid');
        $('#average_individual_size').removeClass('is-invalid');
        $('#average_individual_weight').removeClass('is-invalid');
        $('#amount_fingerling_stocked').removeClass('is-invalid');

        if(!stocking_fish_species_id) {
            $('#stocking_fish_species_id').addClass('is-invalid');
            isValidate = false;
        }

        if(!stocking_number_fingerling) {
            $('#stocking_number_fingerling').addClass('is-invalid');
            isValidate = false;
        }
        if(!average_individual_size) {
            $('#average_individual_size').addClass('is-invalid');
            isValidate = false;
        }

        if(!average_individual_weight) {
            $('#average_individual_weight').addClass('is-invalid');
            isValidate = false;
        }
        if(!amount_fingerling_stocked) {
            $('#amount_fingerling_stocked').addClass('is-invalid');
            isValidate = false;
        }
        if(!isValidate) {
            return;
        }

        $('#table-stocking-details').removeClass('d-none')

        var existingRowId = $('#stocking-details-row-id').val();
        if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
            updatePondDetailsData(existingRowId);
        } else {
            addPondDetailsData();
        }
        
       
        // Removing data from input field after successfully adding to lis
        $('#stocking-details-row-id').val('');

        $('#stocking_fish_species_id').val('');
        $('#stocking_number_fingerling').val('');
        $('#average_individual_size').val('');
        $('#average_individual_weight').val('');
        $('#amount_fingerling_stocked').val('');
    });

    function addPondDetailsData() {
        var uid = uuidv4();
        
        // Build table row for added dynamically
        var row = "<tr class='rows' align='center'><input name='indegenus_detail_id[]' type='hidden' value=''>"+
                "<td><span id='stocking-fish-species-view-" + uid + "'>"+ stocking_fish_species_name + "</span>" +
                "<input class='stocking-fish-species' id='hidden-stocking-fish-species-" + uid + "'name='stocking_fish_species_id[]' type='hidden' value='"+stocking_fish_species_id+"'>"
                 + "</td>"+
                "<td> <span id='stocking-number-fingerling-view-" + uid + "'>" + stocking_number_fingerling + "</span>" + 
                "<input class='water-area' id='hidden-stocking-number-fingerling-" + uid + "'name='stocking_number_fingerling[]' type='hidden' value='"+stocking_number_fingerling+"'>"
                + "</td>"+
                "<td><span id='average-individual-size-view-" + uid + "'>" + average_individual_size + "</span>" + 
                "<input class='used-technology' id='hidden-average-individual-size-" + uid + "'name='average_individual_size[]' type='hidden' value='"+average_individual_size+"'>" 
                + "</td>"+
                "<td><span id='average-individual-weight-view-" + uid + "'>" + average_individual_weight + "</span>" + 
                "<input class='used-technology' id='hidden-average-individual-weight-" + uid + "'name='average_individual_weight[]' type='hidden' value='"+average_individual_weight+"'>" 
                + "</td>"+
                "<td><span id='amount-fingerling-stocked-view-" + uid + "'>" + amount_fingerling_stocked + "</span>" + 
                "<input class='used-technology' id='hidden-amount-fingerling-stocked-" + uid + "'name='amount_fingerling_stocked[]' type='hidden' value='"+amount_fingerling_stocked+"'>" 
                + "</td>"+
            
                "<td><a class='edit-stocking btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "" +
                "<a class='remove-stocking btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                + "</td></tr>";

                elmTableStocking.find('tbody').append(row);
    }

    function updatePondDetailsData(rowUid) {

        $('#stocking-fish-species-view-' + rowUid).text(stocking_fish_species_name);
        $('#hidden-stocking-fish-species-' + rowUid).val(stocking_fish_species_id);

        $('#stocking-number-fingerling-view-' + rowUid).text(stocking_number_fingerling);
        $('#hidden-stocking-number-fingerling-' + rowUid).val(stocking_number_fingerling);

        $('#average-individual-size-view-' + rowUid).text(average_individual_size);
        $('#hidden-average-individual-size-' + rowUid).val(average_individual_size);

        $('#average-individual-weight-view-' + rowUid).text(average_individual_weight);
        $('#hidden-average-individual-weight-' + rowUid).val(average_individual_weight);

        $('#amount-fingerling-stocked-view-' + rowUid).text(amount_fingerling_stocked);
        $('#hidden-amount-fingerling-stocked-' + rowUid).val(amount_fingerling_stocked);
        
      
    
    }

    elmTableStocking.on('click', '.rows a.edit-stocking', function (e) {
        var rowUid = $(this).attr('uid');
        $('#stocking-details-row-id').val(rowUid);

        $('#stocking_fish_species_id').val($('#hidden-stocking-fish-species-' + rowUid).val());
        $('#stocking_number_fingerling').val($('#hidden-stocking-number-fingerling-' + rowUid).val());
        $('#average_individual_size').val($('#hidden-average-individual-size-' + rowUid).val());
        $('#average_individual_weight').val($('#hidden-average-individual-weight-' + rowUid).val());
        $('#amount_fingerling_stocked').val($('#hidden-amount-fingerling-stocked-' + rowUid).val());
       
    });
    // Delete a pond details list row
    elmTableStocking.on('click', '.rows a.remove-stocking', function (event) {
        if( confirm('Are you sure?') ) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
        
    });



    /**
     * Spawn information form repeater for DoF
     */

     var elmTableSpwan = $('#table-spwan-details');

     var spawn_fish_species_element = document.getElementById('spawn_fish_species_id');
     var spawn_fish_species_name;
     var spawn_fish_species_id;
     var amount_of_spawn_stocked;
     var number_fingerling_released;
     var weight_fingerling_released;
 
     $('body').on('click', '#btn-spwan-details', function() {
         
        spawn_fish_species_name = spawn_fish_species_element.options[spawn_fish_species_element.selectedIndex].text;
        spawn_fish_species_id = spawn_fish_species_element.value;
 
        amount_of_spawn_stocked = document.getElementById('amount_of_spawn_stocked').value;
        number_fingerling_released = document.getElementById('number_fingerling_released').value;
        weight_fingerling_released = document.getElementById('weight_fingerling_released').value;
       
         // Validating form
         var isValidate = true;
 
         $('#spawn_fish_species_id').removeClass('is-invalid');
         $('#amount_of_spawn_stocked').removeClass('is-invalid');
         $('#number_fingerling_released').removeClass('is-invalid');
         $('#weight_fingerling_released').removeClass('is-invalid');

 
         if(!spawn_fish_species_id) {
             $('#spawn_fish_species_id').addClass('is-invalid');
             isValidate = false;
         }
 
         if(!amount_of_spawn_stocked) {
             $('#amount_of_spawn_stocked').addClass('is-invalid');
             isValidate = false;
         }
         if(!number_fingerling_released) {
             $('#number_fingerling_released').addClass('is-invalid');
             isValidate = false;
         }
 
         if(!weight_fingerling_released) {
             $('#weight_fingerling_released').addClass('is-invalid');
             isValidate = false;
         } 
         
    
         if(!isValidate) {
             return;
         }
 
         $('#table-spawn-etails').removeClass('d-none')
 
         var existingRowId = $('#spwan-details-row-id').val();
         if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
            updateSpwanDetailsData(existingRowId);
         } else {
             addSpwanDetailsData();
         }
         
         // Removing data from input field after successfully adding to lis
         $('#spwan-details-row-id').val('');
         $('#spawn_fish_species_id').val('');
         $('#amount_of_spawn_stocked').val('');
         $('#number_fingerling_released').val('');
         $('#weight_fingerling_released').val('');

     });
 
     function addSpwanDetailsData() {
         var uid = uuidv4();
         
         // Build table row for added dynamically
         var row = "<tr class='rows' align='center'><input name='spwan_details_id[]' type='hidden' value=''>"+
                 "<td><span id='spwan-fish-species-view-" + uid + "'>"+ spawn_fish_species_name + "</span>" +
                 "<input class='spwan-fish-species' id='hidden-spwan-fish-species-" + uid + "'name='spawn_fish_species_id[]' type='hidden' value='"+spawn_fish_species_id+"'>"
                  + "</td>"+
                 "<td> <span id='amount-of-spawn-stocked-view-" + uid + "'>" + amount_of_spawn_stocked + "</span>" + 
                 "<input class='water-area' id='hidden-amount-of-spawn-stocked-" + uid + "'name='amount_of_spawn_stocked[]' type='hidden' value='"+amount_of_spawn_stocked+"'>"
                 + "</td>"+
                 "<td><span id='number-fingerling-released-view-" + uid + "'>" + number_fingerling_released + "</span>" + 
                 "<input class='used-technology' id='hidden-number-fingerling-released-" + uid + "'name='number_fingerling_released[]' type='hidden' value='"+number_fingerling_released+"'>" 
                 + "</td>"+
                 "<td><span id='weight-fingerling-released-view-" + uid + "'>" + weight_fingerling_released + "</span>" + 
                 "<input class='used-technology' id='hidden-weight-fingerling-released-" + uid + "'name='weight_fingerling_released[]' type='hidden' value='"+weight_fingerling_released+"'>" 
                 + "</td>"+
                 "<td><a class='edit-spwan btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "" +
                 "<a class='remove-spwan btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                 + "</td></tr>";
 
                 elmTableSpwan.find('tbody').append(row);
     }
 
     function updateSpwanDetailsData(rowUid) {
 
         $('#spwan-fish-species-view-' + rowUid).text(spawn_fish_species_name);
         $('#hidden-spwan-fish-species-' + rowUid).val(spawn_fish_species_id);
 
         $('#amount-of-spawn-stocked-view-' + rowUid).text(amount_of_spawn_stocked);
         $('#hidden-amount-of-spawn-stocked-' + rowUid).val(amount_of_spawn_stocked);
 
         $('#number-fingerling-released-view-' + rowUid).text(number_fingerling_released);
         $('#hidden-number-fingerling-released-' + rowUid).val(number_fingerling_released);
 
         $('#weight-fingerling-released-view-' + rowUid).text(weight_fingerling_released);
         $('#hidden-weight-fingerling-released-' + rowUid).val(weight_fingerling_released);

     
     }
 
     elmTableSpwan.on('click', '.rows a.edit-spwan', function (e) {
         var rowUid = $(this).attr('uid');
         $('#spwan-details-row-id').val(rowUid);
         $('#spawn_fish_species_id').val($('#hidden-spwan-fish-species-' + rowUid).val());
         $('#amount_of_spawn_stocked').val($('#hidden-amount-of-spawn-stocked-' + rowUid).val());
         $('#number_fingerling_released').val($('#hidden-number-fingerling-released-' + rowUid).val());
         $('#weight_fingerling_released').val($('#hidden-weight-fingerling-released-' + rowUid).val());
         
     });
     // Delete a pond details list row
     elmTableSpwan.on('click', '.rows a.remove-spwan', function (event) {
         if( confirm('Are you sure?') ) {
             $(this).parents("tr:first").remove();
             $(this).parent().parent().remove();
         }
     });


});