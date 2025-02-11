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
    var stocking_number_nursery;
    var stocking_weight_nursery;
    var stocking_number_gov_project;
    var stocking_weight_gov_project;
    var stocking_number_beneficiary;
    var stocking_weight_beneficiary;
    var stocking_number_total_amount;
    var stocking_weight_total_amount;

    $('body').on('click', '#btn-stocking-details', function() {
        
        stocking_fish_species_name = stocking_fish_species_element.options[stocking_fish_species_element.selectedIndex].text;
        stocking_fish_species_id = stocking_fish_species_element.value;

        stocking_number_nursery = document.getElementById('stocking_number_nursery').value;
        stocking_weight_nursery = document.getElementById('stocking_weight_nursery').value;
        stocking_number_gov_project = document.getElementById('stocking_number_gov_project').value;
        stocking_weight_gov_project = document.getElementById('stocking_weight_gov_project').value;
        stocking_number_beneficiary = document.getElementById('stocking_number_beneficiary').value;
        stocking_weight_beneficiary = document.getElementById('stocking_weight_beneficiary').value;
        stocking_number_total_amount = document.getElementById('stocking_number_total_amount').value;
        stocking_weight_total_amount = document.getElementById('stocking_weight_total_amount').value;
      

        // Validating form
        var isValidate = true;

        $('#stocking_fish_species_id').removeClass('is-invalid');
        $('#stocking_number_nursery').removeClass('is-invalid');
        $('#stocking_weight_nursery').removeClass('is-invalid');
        $('#stocking_number_gov_project').removeClass('is-invalid');
        $('#stocking_weight_gov_project').removeClass('is-invalid');
        $('#stocking_number_beneficiary').removeClass('is-invalid');
        $('#stocking_weight_beneficiary').removeClass('is-invalid');
        $('#stocking_number_total_amount').removeClass('is-invalid');
        $('#stocking_weight_total_amount').removeClass('is-invalid');

        if(!stocking_fish_species_id) {
            $('#stocking_fish_species_id').addClass('is-invalid');
            isValidate = false;
        }

        if(!stocking_number_nursery) {
            $('#stocking_number_nursery').addClass('is-invalid');
            isValidate = false;
        }
        if(!stocking_weight_nursery) {
            $('#stocking_weight_nursery').addClass('is-invalid');
            isValidate = false;
        }

        if(!stocking_number_gov_project) {
            $('#stocking_number_gov_project').addClass('is-invalid');
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
        $('#stocking_number_nursery').val('');
        $('#stocking_weight_nursery').val('');
        $('#stocking_number_gov_project').val('');
        $('#stocking_weight_gov_project').val('');
        $('#stocking_number_beneficiary').val('');
        $('#stocking_weight_beneficiary').val('');
        $('#stocking_number_total_amount').val('');
        $('#stocking_weight_total_amount').val('');
    });

    function addPondDetailsData() {
        var uid = uuidv4();
        
        // Build table row for added dynamically
        var row = "<tr class='rows' align='center'>"+
                "<td><span id='stocking-fish-species-view-" + uid + "'>"+ stocking_fish_species_name + "</span>" +
                "<input class='stocking-fish-species' id='hidden-stocking-fish-species-" + uid + "'name='stocking_fish_species_id[]' type='hidden' value='"+stocking_fish_species_id+"'>"
                 + "</td>"+
                "<td> <span id='stocking-number-nursery-view-" + uid + "'>" + stocking_number_nursery + "</span>" + 
                "<input class='water-area' id='hidden-stocking-number-nursery-" + uid + "'name='stocking_number_nursery[]' type='hidden' value='"+stocking_number_nursery+"'>"
                + "</td>"+
                "<td><span id='stocking-weight-nursery-view-" + uid + "'>" + stocking_weight_nursery + "</span>" + 
                "<input class='used-technology' id='hidden-stocking-weight-nursery-" + uid + "'name='stocking_weight_nursery[]' type='hidden' value='"+stocking_weight_nursery+"'>" 
                + "</td>"+
                "<td><span id='stocking-number-gov-project-view-" + uid + "'>" + stocking_number_gov_project + "</span>" + 
                "<input class='used-technology' id='hidden-stocking-number-gov-project-" + uid + "'name='stocking_number_gov_project[]' type='hidden' value='"+stocking_number_gov_project+"'>" 
                + "</td>"+
                "<td><span id='stocking-weight-gov-project-view-" + uid + "'>" + stocking_weight_gov_project + "</span>" + 
                "<input class='used-technology' id='hidden-stocking-weight-gov-project-" + uid + "'name='stocking_weight_gov_project[]' type='hidden' value='"+stocking_weight_gov_project+"'>" 
                + "</td>"+
                "<td><span id='stocking-number-beneficiary-view-" + uid + "'>" + stocking_number_beneficiary + "</span>" + 
                "<input class='used-technology' id='hidden-stocking-number-beneficiary-" + uid + "'name='stocking_number_beneficiary[]' type='hidden' value='"+stocking_number_beneficiary+"'>" 
                + "</td>"+
                "<td><span id='stocking-weight-beneficiary-view-" + uid + "'>" + stocking_weight_beneficiary + "</span>" + 
                "<input class='used-technology' id='hidden-stocking-weight-beneficiary-" + uid + "'name='stocking_weight_beneficiary[]' type='hidden' value='"+stocking_weight_beneficiary+"'>" 
                + "</td>"+
                "<td><span id='stocking-number-total-amount-view-" + uid + "'>" + stocking_number_total_amount + "</span>" + 
                "<input class='used-technology' id='hidden-stocking-number-total-amount-" + uid + "'name='stocking_number_total_amount[]' type='hidden' value='"+stocking_number_total_amount+"'>" 
                + "</td>"+
                "<td><span id='stocking-weight-total-amount-view-" + uid + "'>" + stocking_weight_total_amount + "</span>" + 
                "<input class='used-technology' id='hidden-stocking-weight-total-amount-" + uid + "'name='stocking_weight_total_amount[]' type='hidden' value='"+stocking_weight_total_amount+"'>" 
                + "</td>"+
                "<td><a class='edit-stocking btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "" +
                "<a class='remove-stocking btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                + "</td></tr>";

                elmTableStocking.find('tbody').append(row);
    }

    function updatePondDetailsData(rowUid) {

        $('#stocking-fish-species-view-' + rowUid).text(stocking_fish_species_name);
        $('#hidden-stocking-fish-species-' + rowUid).val(stocking_fish_species_id);

        $('#stocking-number-nursery-view-' + rowUid).text(stocking_number_nursery);
        $('#hidden-stocking-number-nursery-' + rowUid).val(stocking_number_nursery);

        $('#stocking-weight-nursery-view-' + rowUid).text(stocking_weight_nursery);
        $('#hidden-stocking-weight-nursery-' + rowUid).val(stocking_weight_nursery);

        $('#stocking-number-gov-project-view-' + rowUid).text(stocking_number_gov_project);
        $('#hidden-stocking-number-gov-project-' + rowUid).val(stocking_number_gov_project);
        
        $('#stocking-weight-gov-project-view-' + rowUid).text(stocking_weight_gov_project);
        $('#hidden-stocking-weight-gov-project-' + rowUid).val(stocking_weight_gov_project);

        $('#stocking-number-beneficiary-view-' + rowUid).text(stocking_number_beneficiary);
        $('#hidden-stocking-number-beneficiary-' + rowUid).val(stocking_number_beneficiary);

        $('#stocking-weight-beneficiary-view-' + rowUid).text(stocking_weight_beneficiary);
        $('#hidden-stocking-weight-beneficiary-' + rowUid).val(stocking_weight_beneficiary);

        $('#stocking-number-total-amount-view-' + rowUid).text(stocking_number_total_amount);
        $('#hidden-stocking-number-total-amount-' + rowUid).val(stocking_number_total_amount);

        $('#stocking-weight-total-amount-view-' + rowUid).text(stocking_weight_total_amount);
        $('#hidden-stocking-weight-total-amount-' + rowUid).val(stocking_weight_total_amount);
    
    }

    elmTableStocking.on('click', '.rows a.edit-stocking', function (e) {
        var rowUid = $(this).attr('uid');
        $('#stocking-details-row-id').val(rowUid);

        $('#stocking_fish_species_id').val($('#hidden-stocking-fish-species-' + rowUid).val());
        $('#stocking_number_nursery').val($('#hidden-stocking-number-nursery-' + rowUid).val());
        $('#stocking_weight_nursery').val($('#hidden-stocking-weight-nursery-' + rowUid).val());
        $('#stocking_number_gov_project').val($('#hidden-stocking-number-gov-project-' + rowUid).val());
        $('#stocking_weight_gov_project').val($('#hidden-stocking-weight-gov-project-' + rowUid).val());
        $('#stocking_number_beneficiary').val($('#hidden-stocking-number-beneficiary-' + rowUid).val());
        $('#stocking_weight_beneficiary').val($('#hidden-stocking-weight-beneficiary-' + rowUid).val());
        $('#stocking_number_total_amount').val($('#hidden-stocking-number-total-amount-' + rowUid).val());
        $('#stocking_weight_total_amount').val($('#hidden-stocking-weight-total-amount-' + rowUid).val());
    });
    // Delete a pond details list row
    elmTableStocking.on('click', '.rows a.remove-stocking', function (event) {
        if( confirm('Are you sure?') ) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
        
    });



    /**
     * Production information form repeater for DoF
     */

     var elmTableProduction = $('#table-production-details');

     var production_fish_species_element = document.getElementById('production_fish_species_id');
     var production_fish_species_name;
     var production_fish_species_id;
     var production_stocked_amount_number;
     var production_stocked_amount_weight;
     var production_baseline_total_production;
     var production_baseline_unit_production;
     var production_annual_assessment_year;
     var production_increase_weight;
     var stocking_number_total_amount;
     var stocking_weight_total_amount;
 
     $('body').on('click', '#btn-production-details', function() {
         
        production_fish_species_name = production_fish_species_element.options[production_fish_species_element.selectedIndex].text;
        production_fish_species_id = production_fish_species_element.value;
 
        production_stocked_amount_number = document.getElementById('production_stocked_amount_number').value;
        production_stocked_amount_weight = document.getElementById('production_stocked_amount_weight').value;
        production_baseline_total_production = document.getElementById('production_baseline_total_production').value;
        production_baseline_unit_production = document.getElementById('production_baseline_unit_production').value;
        production_annual_assessment_year = document.getElementById('production_annual_assessment_year').value;

        production_increase_weight = document.getElementById('production_increase_weight').value;
        production_increase_percentage = document.getElementById('production_increase_percentage').value;
       
 
         // Validating form
         var isValidate = true;
 
         $('#production_fish_species_id').removeClass('is-invalid');
         $('#production_stocked_amount_number').removeClass('is-invalid');
         $('#production_stocked_amount_weight').removeClass('is-invalid');
         $('#production_baseline_total_production').removeClass('is-invalid');
         $('#production_baseline_unit_production').removeClass('is-invalid');
         $('#production_annual_assessment_year').removeClass('is-invalid');
         $('#production_increase_weight').removeClass('is-invalid');
         $('#production_increase_percentage').removeClass('is-invalid');

 
         if(!production_fish_species_id) {
             $('#production_fish_species_id').addClass('is-invalid');
             isValidate = false;
         }
 
         if(!production_stocked_amount_number) {
             $('#production_stocked_amount_number').addClass('is-invalid');
             isValidate = false;
         }
         if(!production_stocked_amount_weight) {
             $('#production_stocked_amount_weight').addClass('is-invalid');
             isValidate = false;
         }
 
         if(!production_baseline_total_production) {
             $('#production_baseline_total_production').addClass('is-invalid');
             isValidate = false;
         } 
         
         if(!production_baseline_unit_production) {
             $('#production_baseline_unit_production').addClass('is-invalid');
             isValidate = false;
         }
         if(!isValidate) {
             return;
         }
 
         $('#table-production-details').removeClass('d-none')
 
         var existingRowId = $('#production-details-row-id').val();
         if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
            updateProductionDetailsData(existingRowId);
         } else {
             addProductionDetailsData();
         }
         
         // Removing data from input field after successfully adding to lis
         $('#production-details-row-id').val('');
         $('#production_fish_species_id').val('');
         $('#production_stocked_amount_number').val('');
         $('#production_stocked_amount_weight').val('');
         $('#production_baseline_total_production').val('');
         $('#production_baseline_unit_production').val('');
         $('#production_annual_assessment_year').val('');
         $('#production_increase_weight').val('');
         $('#production_increase_percentage').val('');

     });
 
     function addProductionDetailsData() {
         var uid = uuidv4();
         
         // Build table row for added dynamically
         var row = "<tr class='rows' align='center'>"+
                 "<td><span id='production-fish-species-view-" + uid + "'>"+ production_fish_species_name + "</span>" +
                 "<input class='production-fish-species' id='hidden-production-fish-species-" + uid + "'name='production_fish_species_ids[]' type='hidden' value='"+production_fish_species_id+"'>"
                  + "</td>"+
                 "<td> <span id='production-stocked-amount-number-view-" + uid + "'>" + production_stocked_amount_number + "</span>" + 
                 "<input class='water-area' id='hidden-production-stocked-amount-number-" + uid + "'name='production_stocked_amount_numbers[]' type='hidden' value='"+production_stocked_amount_number+"'>"
                 + "</td>"+
                 "<td><span id='production-stocked-amount-weight-view-" + uid + "'>" + production_stocked_amount_weight + "</span>" + 
                 "<input class='used-technology' id='hidden-production-stocked-amount-weight-" + uid + "'name='production_stocked_amount_weights[]' type='hidden' value='"+production_stocked_amount_weight+"'>" 
                 + "</td>"+
                 "<td><span id='production-baseline-total-production-view-" + uid + "'>" + production_baseline_total_production + "</span>" + 
                 "<input class='used-technology' id='hidden-production-baseline-total-production-" + uid + "'name='production_baseline_total_productions[]' type='hidden' value='"+production_baseline_total_production+"'>" 
                 + "</td>"+
                 "<td><span id='production-baseline-unit-production-view-" + uid + "'>" + production_baseline_unit_production + "</span>" + 
                 "<input class='used-technology' id='hidden-production-baseline-unit-production-" + uid + "'name='production_baseline_unit_productions[]' type='hidden' value='"+production_baseline_unit_production+"'>" 
                 + "</td>"+
                 "<td><span id='production-annual-assessment-year-view-" + uid + "'>" + production_annual_assessment_year + "</span>" + 
                 "<input class='used-technology' id='hidden-production-annual-assessment-year-" + uid + "'name='production_annual_assessment_years[]' type='hidden' value='"+production_annual_assessment_year+"'>" 
                 + "</td>"+
                 "<td><span id='production-increase-weight-view-" + uid + "'>" + production_increase_weight + "</span>" + 
                 "<input class='used-technology' id='hidden-production-increase-weight-" + uid + "'name='production_increase_weights[]' type='hidden' value='"+production_increase_weight+"'>" 
                 + "</td>"+
                 "<td><span id='production-increase-percentage-view-" + uid + "'>" + production_increase_percentage + "</span>" + 
                 "<input class='used-technology' id='hidden-production-increase-percentage-" + uid + "'name='production_increase_percentages[]' type='hidden' value='"+production_increase_percentage+"'>" 
                 + "</td>"+
                 "<td><a class='edit-stocking btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "" +
                 "<a class='remove-stocking btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                 + "</td></tr>";
 
                 elmTableProduction.find('tbody').append(row);
     }
 
     function updateProductionDetailsData(rowUid) {
 
         $('#production-fish-species-view-' + rowUid).text(production_fish_species_name);
         $('#hidden-production-fish-species-' + rowUid).val(production_fish_species_id);
 
         $('#production-stocked-amount-number-view-' + rowUid).text(production_stocked_amount_number);
         $('#hidden-production-stocked-amount-number-' + rowUid).val(production_stocked_amount_number);
 
         $('#production-stocked-amount-weight-view-' + rowUid).text(production_stocked_amount_weight);
         $('#hidden-production-stocked-amount-weight-' + rowUid).val(production_stocked_amount_weight);
 
         $('#production-baseline-total-production-view-' + rowUid).text(production_baseline_total_production);
         $('#hidden-production-baseline-total-production-' + rowUid).val(production_baseline_total_production);
         
         $('#production-baseline-unit-production-view-' + rowUid).text(production_baseline_unit_production);
         $('#hidden-production-baseline-unit-production-' + rowUid).val(production_baseline_unit_production);
 
         $('#production-annual-assessment-year-view-' + rowUid).text(production_annual_assessment_year);
         $('#hidden-production-annual-assessment-year-' + rowUid).val(production_annual_assessment_year);
 
         $('#production-increase-weight-view-' + rowUid).text(production_increase_weight);
         $('#hidden-production-increase-weight-' + rowUid).val(production_increase_weight);
 
         $('#production-increase-percentage-view-' + rowUid).text(production_increase_percentage);
         $('#hidden-production-increase-percentage-' + rowUid).val(production_increase_percentage);
     
     }
 
     elmTableProduction.on('click', '.rows a.edit-stocking', function (e) {
         var rowUid = $(this).attr('uid');
         $('#production-details-row-id').val(rowUid);
         $('#production_fish_species_id').val($('#hidden-production-fish-species-' + rowUid).val());
         $('#production_stocked_amount_number').val($('#hidden-production-stocked-amount-number-' + rowUid).val());
         $('#production_stocked_amount_weight').val($('#hidden-production-stocked-amount-weight-' + rowUid).val());
         $('#production_baseline_total_production').val($('#hidden-production-baseline-total-production-' + rowUid).val());
         $('#production_baseline_unit_production').val($('#hidden-production-baseline-unit-production-' + rowUid).val());
         $('#production_annual_assessment_year').val($('#hidden-production-annual-assessment-year-' + rowUid).val());
         $('#production_increase_weight').val($('#hidden-production-increase-weight-' + rowUid).val());
         $('#production_increase_percentage').val($('#hidden-production-increase-percentage-' + rowUid).val());
     });
     // Delete a pond details list row
     elmTableProduction.on('click', '.rows a.remove-stocking', function (event) {
         if( confirm('Are you sure?') ) {
             $(this).parents("tr:first").remove();
             $(this).parent().parent().remove();
         }
     });


     // SIS Details from here

     $('#sis_fish_species_id').on('change', function() {
        var sisFishSpeciesId = $("#sis_fish_species_id option:selected").val();
        if (sisFishSpeciesId) {
            $.ajax({
                dataType: 'json',
                type: "GET",
                url: app.app_url + "admin/monitoring/get-fish-species-info-by-fish-species-id/" + sisFishSpeciesId + '/' + 'sis',
                cache: false,
                success: function(response) {
                    if (response !== '') {
                    
                        $('#sis_local_name').val(response.local_name);
                        $('#sis_english_name').val(response.scientific_name_en);
                        $('#sis_scienfific_name').val(response.scientific_name_bn);

                    }
                },
                error: function(x, e) {}
            });
        } else {
            triggerToast("Please Select Fish Species to add.", 'danger');
        }
    });


    /**
     * SIS information form repeater for DoF
     */

   var elmTableSIS = $('#table-sis-details');

   var sis_fish_species_element = document.getElementById('sis_fish_species_id');
   var sis_fish_species_name;
   var sis_fish_species_id;
   var sis_local_name;
   var sis_english_name;
   var sis_scienfific_name;
   var sis_increase_rate_of_production_percentage;


   $('body').on('click', '#btn-sis-details', function() {
       
    sis_fish_species_name = sis_fish_species_element.options[sis_fish_species_element.selectedIndex].text;
    sis_fish_species_id = sis_fish_species_element.value;

    sis_local_name = document.getElementById('sis_local_name').value;
    sis_english_name = document.getElementById('sis_english_name').value;
    sis_scienfific_name = document.getElementById('sis_scienfific_name').value;
    sis_increase_rate_of_production_percentage = document.getElementById('sis_increase_rate_of_production_percentage').value;

       // Validating form
       var isValidate = true;

       $('#sis_fish_species_id').removeClass('is-invalid');
       $('#sis_local_name').removeClass('is-invalid');
       $('#sis_english_name').removeClass('is-invalid');
       $('#sis_scienfific_name').removeClass('is-invalid');
       $('#sis_increase_rate_of_production_percentage').removeClass('is-invalid');


       if(!sis_fish_species_id) {
           $('#sis_fish_species_id').addClass('is-invalid');
           isValidate = false;
       }

       if(!sis_increase_rate_of_production_percentage) {
           $('#sis_increase_rate_of_production_percentage').addClass('is-invalid');
           isValidate = false;
       }

       if(!isValidate) {
           return;
       }

       $('#table-sis-details').removeClass('d-none')

       var existingRowId = $('#sis-details-row-id').val();
       if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
          updateSISDetailsData(existingRowId);
       } else {
           addSISDetailsData();
       }
       
      
       // Removing data from input field after successfully adding to lis
       $('#sis-details-row-id').val('');

       $('#sis_fish_species_id').val('');
       $('#sis_local_name').val('');
       $('#sis_english_name').val('');
       $('#sis_scienfific_name').val('');
       $('#sis_increase_rate_of_production_percentage').val('');

   });

   function addSISDetailsData() {
       var uid = uuidv4();
       
       // Build table row for added dynamically
       var row = "<tr class='rows' align='center'>"+
               "<td><span id='sis-fish-species-view-" + uid + "'>"+ sis_fish_species_name + "</span>" +
               "<input class='sis-fish-species' id='hidden-sis-fish-species-" + uid + "'name='sis_fish_species_id[]' type='hidden' value='"+sis_fish_species_id+"'>"
                + "</td>"+
               "<td> <span id='sis-local-name-view-" + uid + "'>" + sis_local_name + "</span>" + 
               "<input class='water-area' id='hidden-sis-local-name-" + uid + "'name='sis_local_name[]' type='hidden' value='"+sis_local_name+"'>"
               + "</td>"+
               "<td> <span id='sis-english-name-view-" + uid + "'>" + sis_english_name + "</span>" + 
               "<input class='water-area' id='hidden-sis-english-name-" + uid + "'name='sis_english_name[]' type='hidden' value='"+sis_english_name+"'>"
               + "</td>"+
               "<td> <span id='sis-scienfific-name-view-" + uid + "'>" + sis_scienfific_name + "</span>" + 
               "<input class='water-area' id='hidden-sis-scienfific-name-" + uid + "'name='sis_scienfific_name[]' type='hidden' value='"+sis_scienfific_name+"'>"
               + "</td>"+
               "<td> <span id='sis-production-percentage-view-" + uid + "'>" + sis_increase_rate_of_production_percentage + "</span>" + 
               "<input class='water-area' id='hidden-sis-production-percentage-" + uid + "'name='sis_increase_rate_of_production_percentage[]' type='hidden' value='"+sis_increase_rate_of_production_percentage+"'>"
               + "</td>"+
             
               "<td><a class='edit-sis btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "" +
               "<a class='remove-sis btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
               + "</td></tr>";

               elmTableSIS.find('tbody').append(row);
   }

   function updateSISDetailsData(rowUid) {

       $('sis-fish-species-view-' + rowUid).text(sis_fish_species_name);
       $('#hidden-sis-fish-species-' + rowUid).val(sis_fish_species_id);

       $('#sis-local-name-view-' + rowUid).text(sis_local_name);
       $('#hidden-sis-local-name-' + rowUid).val(sis_local_name);

       $('#sis-english-name-view-' + rowUid).text(sis_english_name);
       $('#hidden-sis-english-name-' + rowUid).val(sis_english_name);

       $('#sis-scienfific-name-view-' + rowUid).text(sis_scienfific_name);
       $('#hidden-sis-scienfific-name-' + rowUid).val(sis_scienfific_name);
       
       $('#sis-production-percentage-view-' + rowUid).text(sis_increase_rate_of_production_percentage);
       $('#hidden-sis-production-percentage-' + rowUid).val(sis_increase_rate_of_production_percentage);

   }

   elmTableSIS.on('click', '.rows a.edit-sis', function (e) {
       var rowUid = $(this).attr('uid');
       $('#sis-details-row-id').val(rowUid);


       $('#sis_fish_species_id').val($('#hidden-sis-fish-species-' + rowUid).val());
       $('#sis_local_name').val($('#hidden-sis-local-name-' + rowUid).val());
       $('#sis_english_name').val($('#hidden-sis-english-name-' + rowUid).val());
       $('#sis_scienfific_name').val($('#hidden-sis-scienfific-name-' + rowUid).val());
       $('#sis_increase_rate_of_production_percentage').val($('#hidden-sis-production-percentage-' + rowUid).val());

   });
   // Delete a pond details list row
   elmTableSIS.on('click', '.rows a.remove-sis', function (event) {
       if( confirm('Are you sure?') ) {
           $(this).parents("tr:first").remove();
           $(this).parent().parent().remove();
       }
       
   });



   // Rare Details from here

   $('#rare_fish_species_id').on('change', function() {
    var rareFishSpeciesId = $("#rare_fish_species_id option:selected").val();
    if (rareFishSpeciesId) {
        $.ajax({
            dataType: 'json',
            type: "GET",
            url: app.app_url + "admin/monitoring/get-fish-species-info-by-fish-species-id/" + rareFishSpeciesId + '/' + 'rare',
            cache: false,
            success: function(response) {
                if (response !== '') {
                
                    $('#rare_local_name').val(response.local_name);
                    $('#rare_english_name').val(response.scientific_name_en);
                    $('#rare_scienfific_name').val(response.scientific_name_bn);

                }
            },
            error: function(x, e) {}
        });
    } else {
        triggerToast("Please Select Fish Species to add.", 'danger');
    }
});


/**
 * Rare information form repeater for DoF
 */

var elmTableRARE = $('#table-rare-details');

var rare_fish_species_element = document.getElementById('rare_fish_species_id');
var rare_fish_species_name;
var rare_fish_species_id;
var rare_local_name;
var rare_english_name;
var rare_scienfific_name;
var rare_increase_rate_of_production_percentage;


$('body').on('click', '#btn-rare-details', function() {
   
rare_fish_species_name = rare_fish_species_element.options[rare_fish_species_element.selectedIndex].text;
rare_fish_species_id = rare_fish_species_element.value;

rare_local_name = document.getElementById('rare_local_name').value;
rare_english_name = document.getElementById('rare_english_name').value;
rare_scienfific_name = document.getElementById('rare_scienfific_name').value;
rare_increase_rate_of_production_percentage = document.getElementById('rare_increase_rate_of_production_percentage').value;

   // Validating form
   var isValidate = true;

   $('#rare_fish_species_id').removeClass('is-invalid');
   $('#rare_local_name').removeClass('is-invalid');
   $('#rare_english_name').removeClass('is-invalid');
   $('#rare_scienfific_name').removeClass('is-invalid');
   $('#rare_increase_rate_of_production_percentage').removeClass('is-invalid');


   if(!rare_fish_species_id) {
       $('#rare_fish_species_id').addClass('is-invalid');
       isValidate = false;
   }

   if(!rare_increase_rate_of_production_percentage) {
       $('#rare_increase_rate_of_production_percentage').addClass('is-invalid');
       isValidate = false;
   }

   if(!isValidate) {
       return;
   }

   $('#table-rare-details').removeClass('d-none')

   var existingRowId = $('#rare-details-row-id').val();
   if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
      updateRAREDetailsData(existingRowId);
   } else {
       addRAREDetailsData();
   }
   
  
   // Removing data from input field after successfully adding to lis
   $('#rare-details-row-id').val('');

   $('#rare_fish_species_id').val('');
   $('#rare_local_name').val('');
   $('#rare_english_name').val('');
   $('#rare_scienfific_name').val('');
   $('#rare_increase_rate_of_production_percentage').val('');

});

function addRAREDetailsData() {
   var uid = uuidv4();
   
   // Build table row for added dynamically
   var row = "<tr class='rows' align='center'>"+
           "<td><span id='rare-fish-species-view-" + uid + "'>"+ rare_fish_species_name + "</span>" +
           "<input class='rare-fish-species' id='hidden-rare-fish-species-" + uid + "'name='rare_fish_species_id[]' type='hidden' value='"+rare_fish_species_id+"'>"
            + "</td>"+
           "<td> <span id='rare-local-name-view-" + uid + "'>" + rare_local_name + "</span>" + 
           "<input class='water-area' id='hidden-rare-local-name-" + uid + "'name='rare_local_name[]' type='hidden' value='"+rare_local_name+"'>"
           + "</td>"+
           "<td> <span id='rare-english-name-view-" + uid + "'>" + rare_english_name + "</span>" + 
           "<input class='water-area' id='hidden-rare-english-name-" + uid + "'name='rare_english_name[]' type='hidden' value='"+rare_english_name+"'>"
           + "</td>"+
           "<td> <span id='rare-scienfific-name-view-" + uid + "'>" + rare_scienfific_name + "</span>" + 
           "<input class='water-area' id='hidden-rare-scienfific-name-" + uid + "'name='rare_scienfific_name[]' type='hidden' value='"+rare_scienfific_name+"'>"
           + "</td>"+
           "<td> <span id='rare-production-percentage-view-" + uid + "'>" + rare_increase_rate_of_production_percentage + "</span>" + 
           "<input class='water-area' id='hidden-rare-production-percentage-" + uid + "'name='rare_increase_rate_of_production_percentage[]' type='hidden' value='"+rare_increase_rate_of_production_percentage+"'>"
           + "</td>"+
         
           "<td><a class='edit-rare btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "" +
           "<a class='remove-rare btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
           + "</td></tr>";

           elmTableRARE.find('tbody').append(row);
}

function updateRAREDetailsData(rowUid) {

   $('#rare-fish-species-view-' + rowUid).text(rare_fish_species_name);
   $('#hidden-rare-fish-species-' + rowUid).val(rare_fish_species_id);

   $('#rare-local-name-view-' + rowUid).text(rare_local_name);
   $('#hidden-rare-local-name-' + rowUid).val(rare_local_name);

   $('#rare-english-name-view-' + rowUid).text(rare_english_name);
   $('#hidden-rare-english-name-' + rowUid).val(rare_english_name);

   $('#rare-scienfific-name-view-' + rowUid).text(rare_scienfific_name);
   $('#hidden-rare-scienfific-name-' + rowUid).val(rare_scienfific_name);
   
   $('#rare-production-percentage-view-' + rowUid).text(rare_increase_rate_of_production_percentage);
   $('#hidden-rare-production-percentage-' + rowUid).val(rare_increase_rate_of_production_percentage);

}

elmTableRARE.on('click', '.rows a.edit-rare', function (e) {
   var rowUid = $(this).attr('uid');
   $('#rare-details-row-id').val(rowUid);


   $('#rare_fish_species_id').val($('#hidden-rare-fish-species-' + rowUid).val());
   $('#rare_local_name').val($('#hidden-rare-local-name-' + rowUid).val());
   $('#rare_english_name').val($('#hidden-rare-english-name-' + rowUid).val());
   $('#rare_scienfific_name').val($('#hidden-rare-scienfific-name-' + rowUid).val());
   $('#rare_increase_rate_of_production_percentage').val($('#hidden-rare-production-percentage-' + rowUid).val());

});
// Delete a pond details list row
elmTableRARE.on('click', '.rows a.remove-rare', function (event) {
   if( confirm('Are you sure?') ) {
       $(this).parents("tr:first").remove();
       $(this).parent().parent().remove();
   }
   
});



   // aquatic Details from here

   $('#aquatic_fish_species_id').on('change', function() {
    var aquaticFishSpeciesId = $("#aquatic_fish_species_id option:selected").val();
    if (aquaticFishSpeciesId) {
        $.ajax({
            dataType: 'json',
            type: "GET",
            url: app.app_url + "admin/monitoring/get-aquatic-species-info-by-id/" + aquaticFishSpeciesId + '/' + 'species',
            cache: false,
            success: function(response) {
                if (response !== '') {
                
                    $('#aquatic_local_name').val(response.local_name);
                    $('#aquatic_english_name').val(response.common_name_en);
                    $('#aquatic_scienfific_name').val(response.scientific_name_en);

                }
            },
            error: function(x, e) {}
        });
    } else {
        triggerToast("Please Select Fish Species to add.", 'danger');
    }
});


/**
 * aquatic information form repeater for DoF
 */

var elmTableAquatic = $('#table-aquatic-details');

var aquatic_fish_species_element = document.getElementById('aquatic_fish_species_id');
var aquatic_fish_species_name;
var aquatic_fish_species_id;
var aquatic_local_name;
var aquatic_english_name;
var aquatic_scienfific_name;
var aquatic_increase_rate_of_production_percentage;


$('body').on('click', '#btn-aquatic-details', function() {
   
aquatic_fish_species_name = aquatic_fish_species_element.options[aquatic_fish_species_element.selectedIndex].text;
aquatic_fish_species_id = aquatic_fish_species_element.value;

aquatic_local_name = document.getElementById('aquatic_local_name').value;
aquatic_english_name = document.getElementById('aquatic_english_name').value;
aquatic_scienfific_name = document.getElementById('aquatic_scienfific_name').value;
aquatic_increase_rate_of_production_percentage = document.getElementById('aquatic_increase_rate_of_production_percentage').value;

   // Validating form
   var isValidate = true;

   $('#aquatic_fish_species_id').removeClass('is-invalid');
   $('#aquatic_local_name').removeClass('is-invalid');
   $('#aquatic_english_name').removeClass('is-invalid');
   $('#aquatic_scienfific_name').removeClass('is-invalid');
   $('#aquatic_increase_rate_of_production_percentage').removeClass('is-invalid');


   if(!aquatic_fish_species_id) {
       $('#aquatic_fish_species_id').addClass('is-invalid');
       isValidate = false;
   }

   if(!aquatic_increase_rate_of_production_percentage) {
       $('#aquatic_increase_rate_of_production_percentage').addClass('is-invalid');
       isValidate = false;
   }

   if(!isValidate) {
       return;
   }

   $('#table-aquatic-details').removeClass('d-none')

   var existingRowId = $('#aquatic-details-row-id').val();
   if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
      updateAquaticDetailsData(existingRowId);
   } else {
       addAquaticDetailsData();
   }
   
  
   // Removing data from input field after successfully adding to lis
   $('#aquatic-details-row-id').val('');

   $('#aquatic_fish_species_id').val('');
   $('#aquatic_local_name').val('');
   $('#aquatic_english_name').val('');
   $('#aquatic_scienfific_name').val('');
   $('#aquatic_increase_rate_of_production_percentage').val('');

});

function addAquaticDetailsData() {
   var uid = uuidv4();
   
   // Build table row for added dynamically
   var row = "<tr class='rows' align='center'>"+
           "<td><span id='aquatic-fish-species-view-" + uid + "'>"+ aquatic_fish_species_name + "</span>" +
           "<input class='aquatic-fish-species' id='hidden-aquatic-fish-species-" + uid + "'name='aquatic_fish_species_id[]' type='hidden' value='"+aquatic_fish_species_id+"'>"
            + "</td>"+
           "<td> <span id='aquatic-local-name-view-" + uid + "'>" + aquatic_local_name + "</span>" + 
           "<input class='water-area' id='hidden-aquatic-local-name-" + uid + "'name='aquatic_local_name[]' type='hidden' value='"+aquatic_local_name+"'>"
           + "</td>"+
           "<td> <span id='aquatic-english-name-view-" + uid + "'>" + aquatic_english_name + "</span>" + 
           "<input class='water-area' id='hidden-aquatic-english-name-" + uid + "'name='aquatic_english_name[]' type='hidden' value='"+aquatic_english_name+"'>"
           + "</td>"+
           "<td> <span id='aquatic-scienfific-name-view-" + uid + "'>" + aquatic_scienfific_name + "</span>" + 
           "<input class='water-area' id='hidden-aquatic-scienfific-name-" + uid + "'name='aquatic_scienfific_name[]' type='hidden' value='"+aquatic_scienfific_name+"'>"
           + "</td>"+
           "<td> <span id='aquatic-production-percentage-view-" + uid + "'>" + aquatic_increase_rate_of_production_percentage + "</span>" + 
           "<input class='water-area' id='hidden-aquatic-production-percentage-" + uid + "'name='aquatic_increase_rate_of_production_percentage[]' type='hidden' value='"+aquatic_increase_rate_of_production_percentage+"'>"
           + "</td>"+
         
           "<td><a class='edit-aquatic btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "" +
           "<a class='remove-aquatic btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
           + "</td></tr>";

           elmTableAquatic.find('tbody').append(row);
}

function updateAquaticDetailsData(rowUid) {

   $('#aquatic-fish-species-view-' + rowUid).text(aquatic_fish_species_name);
   $('#hidden-aquatic-fish-species-' + rowUid).val(aquatic_fish_species_id);

   $('#aquatic-local-name-view-' + rowUid).text(aquatic_local_name);
   $('#hidden-aquatic-local-name-' + rowUid).val(aquatic_local_name);

   $('#aquatic-english-name-view-' + rowUid).text(aquatic_english_name);
   $('#hidden-aquatic-english-name-' + rowUid).val(aquatic_english_name);

   $('#aquatic-scienfific-name-view-' + rowUid).text(aquatic_scienfific_name);
   $('#hidden-aquatic-scienfific-name-' + rowUid).val(aquatic_scienfific_name);
   
   $('#aquatic-production-percentage-view-' + rowUid).text(aquatic_increase_rate_of_production_percentage);
   $('#hidden-aquatic-production-percentage-' + rowUid).val(aquatic_increase_rate_of_production_percentage);

}

elmTableAquatic.on('click', '.rows a.edit-aquatic', function (e) {
   var rowUid = $(this).attr('uid');
   $('#aquatic-details-row-id').val(rowUid);


   $('#aquatic_fish_species_id').val($('#hidden-aquatic-fish-species-' + rowUid).val());
   $('#aquatic_local_name').val($('#hidden-aquatic-local-name-' + rowUid).val());
   $('#aquatic_english_name').val($('#hidden-aquatic-english-name-' + rowUid).val());
   $('#aquatic_scienfific_name').val($('#hidden-aquatic-scienfific-name-' + rowUid).val());
   $('#aquatic_increase_rate_of_production_percentage').val($('#hidden-aquatic-production-percentage-' + rowUid).val());

});
// Delete a pond details list row
elmTableAquatic.on('click', '.rows a.remove-aquatic', function (event) {
   if( confirm('Are you sure?') ) {
       $(this).parents("tr:first").remove();
       $(this).parent().parent().remove();
   }
   
});




/**
 * Problem and Suggestion information form repeater for DoF
 */

 var elmTableProblemAndSuggestion = $('#table-problem-details');


 var problems;
 var suggestion_recommendation;

 
 $('body').on('click', '#btn-problem-details', function() {

    problems = document.getElementById('problems').value;
    suggestion_recommendation = document.getElementById('suggestion_recommendation').value;
 
    // Validating form
    var isValidate = true;
 
    $('#problems').removeClass('is-invalid');
    $('#suggestion_recommendation').removeClass('is-invalid');
 
 
    if(!problems) {
        $('#problems').addClass('is-invalid');
        isValidate = false;
    }
 
    if(!suggestion_recommendation) {
        $('#suggestion_recommendation').addClass('is-invalid');
        isValidate = false;
    }
 
    if(!isValidate) {
        return;
    }
 
    $('#table-problem-details').removeClass('d-none')
 
    var existingRowId = $('#problem-details-row-id').val();
    if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
        updateProblemAndSuggestionDetailsData(existingRowId);
    } else {
        addProblemAndSuggestionDetailsData();
    }
    
   
    // Removing data from input field after successfully adding to lis
    $('#problem-details-row-id').val('');
 
    $('#problems').val('');
    $('#suggestion_recommendation').val('');

 
 });
 
 function addProblemAndSuggestionDetailsData() {
    var uid = uuidv4();
    
    // Build table row for added dynamically
    var row = "<tr class='rows' align='center'>"+
            
            "<td> <span id='problems-view-" + uid + "'>" + problems + "</span>" + 
            "<input class='water-area' id='hidden-problems-" + uid + "'name='problems[]' type='hidden' value='"+problems+"'>"
            + "</td>"+
            "<td> <span id='suggestion-recommendation-view-" + uid + "'>" + suggestion_recommendation + "</span>" + 
            "<input class='water-area' id='hidden-suggestion-recommendation-" + uid + "'name='suggestion_recommendation[]' type='hidden' value='"+suggestion_recommendation+"'>"
            + "</td>"+
            "<td><a class='edit-problem btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "" +
            "<a class='remove-problem btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
            + "</td></tr>";
 
            elmTableProblemAndSuggestion.find('tbody').append(row);
 }
 
 function updateProblemAndSuggestionDetailsData(rowUid) {
 
    $('#problems-view-' + rowUid).text(problems);
    $('#hidden-problems-' + rowUid).val(problems);
 
    $('#suggestion-recommendation-view-' + rowUid).text(suggestion_recommendation);
    $('#hidden-suggestion-recommendation-' + rowUid).val(suggestion_recommendation);
 
 }
 
 elmTableProblemAndSuggestion.on('click', '.rows a.edit-problem', function (e) {
    var rowUid = $(this).attr('uid');
    $('#problem-details-row-id').val(rowUid);
 
     $('#problems').val($('#hidden-problems-' + rowUid).val());
    $('#suggestion_recommendation').val($('#hidden-suggestion-recommendation-' + rowUid).val());
 
 });
 // Delete a pond details list row
 elmTableProblemAndSuggestion.on('click', '.rows a.remove-problem', function (event) {
    if( confirm('Are you sure?') ) {
        $(this).parents("tr:first").remove();
        $(this).parent().parent().remove();
    }
    
 });
 




});