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

    $("#total-number").on('change', function() {
       var number = $(this).val() ? $(this).val() : 0;
       var price = $('#unit-price').val() ? $('#unit-price').val() : 0;
       var total = parseInt(number) * parseInt(price);
       $("#total-price").val(total);
      });

      $("#unit-price").on('change', function() {
        var price = $(this).val() ? $(this).val() : 0;
        var number = $('#total-number').val() ? $('#total-number').val() : 0;
        var total = parseInt(price) * parseInt(number);
        $("#total-price").val(total);
       });
       
    var fish_species_id;
    var fish_species_name;
    var elm_fish_species = document.getElementById('fish-species');

    var sale_info_type_id;
    var sale_info_type_name;
    var elm_sale_info_type = document.getElementById('sale-info-type');

    var elm_total_weight = document.getElementById('total-weight');
    var total_weight;

    var elm_total_number = document.getElementById('total-number');
    var total_number;  

    var elm_unit_price = document.getElementById('unit-price');
    var unit_price;

    var elm_total_price = document.getElementById('total-price');
    var total_price;

    var elmSaleInfo = $('#sale-info');
    $('body').on('click', '#btn-add-sale-info', function() {
        
        fish_species_name = elm_fish_species.options[elm_fish_species.selectedIndex].text;
        fish_species_id = elm_fish_species.value;

        sale_info_type_name = elm_sale_info_type.options[elm_sale_info_type.selectedIndex].text;
        sale_info_type_id = elm_sale_info_type.value;

        total_weight = elm_total_weight.value;

        total_number = elm_total_number.value;
        
        unit_price = elm_unit_price.value;

        total_price = elm_total_price.value;


        // Validating form
        var isValidate = true;
        $('#fish-species').removeClass('is-invalid');
        $('#sale-info-type').removeClass('is-invalid');
        if(!fish_species_id) {
            $('#fish-species').addClass('is-invalid');
            isValidate = false;
        }
        if(!sale_info_type_id) {
            $('#sale-info-type').addClass('is-invalid');
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
        $('#fish-species').val('');
        $('#sale-info-type').val('');
        $('#total-weight').val('');
        $('#total-number').val('');
        $('#unit-price').val('');
        $('#total-price').val('');

    });

    function addRow() {
        var uid = uuidv4();
        
        // Build table row for added dynamically
        var row = "<tr class='rows'><td><span id='fish-species-view-" + uid + "'>"+ fish_species_name + "</span>" +
                "<input class='fish-species' id='fish-species-" + uid + "'name='fish_species_id[]' type='hidden' value='"+fish_species_id+"'>" + "</td><td>"+
                
                "<span id='sale-info-type-view-" + uid + "'>"+ sale_info_type_name + "</span>" +
                "<input class='sale-info-type' id='sale-info-type-" + uid + "'name='sale_info_type_id[]' type='hidden' value='"+sale_info_type_id+"'>" + "</td><td>"+
                
                "<span id='total-weight-view-" + uid + "'>" + total_weight + "</span>" + 
                "<input class='total-weight' id='total-weight-" + uid + "'name='total_weight[]' type='hidden' value='"+total_weight+"'>" + "</td><td>"+
                
                "<span id='total-number-view-" + uid + "'>" + total_number + "</span>" + 
                "<input class='total-number' id='total-number-" + uid + "'name='total_number[]' type='hidden' value='"+total_number+"'>" + "</td><td>"+
                
                "<span id='unit-price-view-" + uid + "'>" + unit_price + "</span>" + 
                "<input class='unit-price' id='unit-price-" + uid + "'name='unit_price[]' type='hidden' value='"+unit_price+"'>" + "</td><td>"+
                
                "<span id='total-price-view-" + uid + "'>" + total_price + "</span>" + 
                "<input class='total-price' id='total-price-" + uid + "'name='total_price[]' type='hidden' value='"+total_price+"'>" + "</td><td>"+
                
                
                "<a class='edit btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                "<a class='remove btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                + "</td></tr>";

                elmSaleInfo.find('tbody').append(row);
    }

    function updateRow(rowUid) {
        $('#fish-species-view-' + rowUid).text(fish_species_name);
        $('#fish-species-' + rowUid).val(fish_species_id);

        $('#sale-info-type-view-' + rowUid).text(sale_info_type_name);
        $('#sale-info-type-' + rowUid).val(sale_info_type_id);

        $('#total-weight-view-' + rowUid).text(total_weight);
        $('#total-weight-' + rowUid).val(total_weight);

        $('#total-number-view-' + rowUid).text(total_number);
        $('#total-number-total-' + rowUid).val(total_number);

        $('#unit-price-view-' + rowUid).text(unit_price);
        $('#unit-price-' + rowUid).val(unit_price);

        $('#total-price-view-' + rowUid).text(total_price);
        $('#total-price-' + rowUid).val(total_price);


    }

    elmSaleInfo.on('click', '.rows a.edit', function (e) {
        var rowUid = $(this).attr('uid');
        $('#row-id').val(rowUid);

        $('#fish-species').val($('#fish-species-' + rowUid).val()).trigger('focus');
        $('#sale-info-type').val($('#sale-info-type-' + rowUid).val());
        $('#total-weight').val($('#total-weight-' + rowUid).val());
        $('#total-number').val($('#total-number-' + rowUid).val());
        $('#unit-price').val($('#unit-price-' + rowUid).val());
        $('#total-price').val($('#total-price-' + rowUid).val());
    });
    // Delete a pond details list row
    elmSaleInfo.on('click', '.rows a.remove', function (event) {
        if( confirm('Are you sure?') ) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
        
    });
});