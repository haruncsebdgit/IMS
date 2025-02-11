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

  

$(document).ready(function(){
       
    var fish_species_fingerlings_id;
    var fish_species_fingerlings_name;
    var elm_fish_species_fingerlings = document.getElementById('fish-species-fingerlings');

    var type_id;
    var type_name;
    var elm_type = document.getElementById('type');

    var elm_avg_weight_fingerlings = document.getElementById('avg-weight-fingerlings');
    var avg_weight_fingerlings;

    var elm_total_number = document.getElementById('total-number');
    var total_number;  

    
    var elm_production_date = document.getElementById('production-date');
    var production_date;

    var elm_sale_start_date = document.getElementById('sale-start-date');
    var sale_start_date;

    var elmTableFingerlingsDetails = $('#table-fingerlings-production');
    $('body').on('click', '#btn-add-fingerlings-production', function() {
        
        fish_species_fingerlings_name = elm_fish_species_fingerlings.options[elm_fish_species_fingerlings.selectedIndex].text;
        fish_species_fingerlings_id = elm_fish_species_fingerlings.value;

        type_name = elm_type.options[elm_type.selectedIndex].text;
        type_id = elm_type.value;

        avg_weight_fingerlings = elm_avg_weight_fingerlings.value;

        total_number = elm_total_number.value;

        production_date = elm_production_date.value;

        sale_start_date = elm_sale_start_date.value;

        // Validating form
        var isValidate = true;
        $('#fish-species-fingerlings').removeClass('is-invalid');
        $('#type').removeClass('is-invalid');
        if(!fish_species_fingerlings_id) {
            $('#fish-species-fingerlings').addClass('is-invalid');
            isValidate = false;
        }
        if(!type_id) {
            $('#type').addClass('is-invalid');
            isValidate = false;
        }

        if(!isValidate) {
            return;
        }


        var existingRowId = $('#row-id').val();
        if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
        updateRow(existingRowId);
        } else {
            addRow();
        }

        $('#row-id').val('');
        // Removing data from input field after successfully adding to list
        $('#fish-species-fingerlings').val('');
        $('#type').val('');
        $('#avg-weight-fingerlings').val('');
        $('#total-number').val('');
        $('#production-date').val('');
        $('#sale-start-date').val('');
    });

    function addRow() {
        var uid = uuidv4();
        
        // Build table row for added dynamically
        var row = "<tr class='rows'><td><span id='fish-species-fingerlings-view-" + uid + "'>"+ fish_species_fingerlings_name + "</span>" +
                "<input class='fish-species-fingerlings' id='fish-species-fingerlings-" + uid + "'name='fish_species_fingerlings_id[]' type='hidden' value='"+fish_species_fingerlings_id+"'>" + "</td><td>"+
                
                "<span id='type-view-" + uid + "'>" + type_name + "</span>" + 
                "<input class='type' id='type-" + uid + "'name='type_id[]' type='hidden' value='"+type_id+"'>" + "</td><td>"+
            
                "<span id='avg-weight-fingerlings-view-" + uid + "'>" + avg_weight_fingerlings + "</span>" + 
                "<input class='avg-weight-fingerlings' id='avg-weight-fingerlings-" + uid + "'name='avg_weight_fingerlings[]' type='hidden' value='"+avg_weight_fingerlings+"'>" + "</td><td>"+
                
                "<span id='total-number-view-" + uid + "'>" + total_number + "</span>" + 
                "<input class='total-number' id='total-number-" + uid + "'name='total_number[]' type='hidden' value='"+total_number+"'>" + "</td><td>"+
                
                "<span id='production-date-view-" + uid + "'>" + production_date + "</span>" + 
                "<input class='production-date' id='production-date-" + uid + "'name='production_date[]' type='hidden' value='"+production_date+"'>" + "</td><td>"+
                
                "<span id='sale-start-date-view-" + uid + "'>" + sale_start_date + "</span>" + 
                "<input class='sale-start-date' id='sale-start-date-" + uid + "'name='sale_start_date[]' type='hidden' value='"+sale_start_date+"'>" + "</td><td>"+
                
                "<a class='edit btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                "<a class='remove btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                + "</td></tr>";

                elmTableFingerlingsDetails.find('tbody').append(row);
    }

    function updateRow(rowUid) {
        $('#fish-species-fingerlings-view-' + rowUid).text(fish_species_fingerlings_name);
        $('#fish-species-fingerlings-' + rowUid).val(fish_species_fingerlings_id);

        $('#type-view-' + rowUid).text(type_name);
        $('#type-' + rowUid).val(type_id);

        $('#avg-weight-fingerlings-view-' + rowUid).text(avg_weight_fingerlings);
        $('#avg-weight-fingerlings-' + rowUid).val(avg_weight_fingerlings);

        $('#total-number-view-' + rowUid).text(total_number);
        $('#total-number-' + rowUid).val(total_number);

        $('#production-date-view-' + rowUid).text(production_date);
        $('#production-date-' + rowUid).val(production_date);

        $('#sale-start-date-view-' + rowUid).text(sale_start_date);
        $('#sale-start-date-' + rowUid).val(sale_start_date);

    }

    elmTableFingerlingsDetails.on('click', '.rows a.edit', function (e) {
        var rowUid = $(this).attr('uid');
        $('#row-id').val(rowUid);
        $('#fish-species-fingerlings').val($('#fish-species-fingerlings-' + rowUid).val()).trigger('focus');
        $('#type').val($('#type-' + rowUid).val());
        $('#avg-weight-fingerlings').val($('#avg-weight-fingerlings-' + rowUid).val());
        $('#total-number').val($('#total-number-' + rowUid).val());
        $('#production-date').val($('#production-date-' + rowUid).val());
        $('#sale-start-date').val($('#sale-start-date-' + rowUid).val());
    });
    // Delete a pond details list row
    elmTableFingerlingsDetails.on('click', '.rows a.remove', function (event) {
        if( confirm('Are you sure?') ) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
        
    });
});