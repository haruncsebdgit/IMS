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

       
    var item_id;
    var item_name;
    var elm_item = document.getElementById('item');

    var item_status_id;
    var item_status_name;
    var elm_item_status = document.getElementById('item-status');

    var elm_quantity = document.getElementById('quantity');
    var quantity;

    var elm_serial = document.getElementById('serial');
    var serial;  

    var elm_fixed_asset_id = document.getElementById('fixed-asset-id');
    var fixed_asset_id;

    var elm_remarks = document.getElementById('remarks');
    var remarks;

    var elmSupplierItemInfo = $('#supplier-item-info');
    $('body').on('click', '#btn-add-supplier-item-info', function() {
        
        item_name = elm_item.options[elm_item.selectedIndex].text;
        item_id = elm_item.value;

        item_status_name = elm_item_status.options[elm_item_status.selectedIndex].text;
        item_status_id = elm_item_status.value;

        quantity = elm_quantity.value;

        serial = elm_serial.value;
        
        fixed_asset_id = elm_fixed_asset_id.value;

        remarks = elm_remarks.value;


        // Validating form
        var isValidate = true;
        $('#item').removeClass('is-invalid');
        $('#item-status').removeClass('is-invalid');
        $('#quantity').removeClass('is-invalid');
        $('#fixed-asset-id').removeClass('is-invalid');
        
        if(!item_id) {
            $('#item').addClass('is-invalid');
            isValidate = false;
        }
        
        if(!item_status_id) {
            $('#item-status').addClass('is-invalid');
            isValidate = false;
        }

        if(!quantity) {
            $('#quantity').addClass('is-invalid');
            isValidate = false;
        }

        if(!fixed_asset_id) {
            $('#fixed-asset-id').addClass('is-invalid');
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
        $('#item').val('');
        $('#item-status').val('');
        $('#quantity').val('');
        $('#serial').val('');
        $('#fixed-asset-id').val('');
        $('#remarks').val('');

    });

    function addRow() {
        var uid = uuidv4();
        
        // Build table row for added dynamically
        var row = "<tr class='rows'><td><span id='item-view-" + uid + "'>"+ item_name + "</span>" +
                "<input class='item' id='item-" + uid + "'name='item_id[]' type='hidden' value='"+item_id+"'>" + "</td><td>"+
                
                "<span id='item-status-view-" + uid + "'>"+ item_status_name + "</span>" +
                "<input class='item-status' id='item-status-" + uid + "'name='item_status_id[]' type='hidden' value='"+item_status_id+"'>" + "</td><td>"+
                
                "<span id='quantity-view-" + uid + "'>" + quantity + "</span>" + 
                "<input class='quantity' id='quantity-" + uid + "'name='quantity[]' type='hidden' value='"+quantity+"'>" + "</td><td>"+
                
                "<span id='serial-view-" + uid + "'>" + serial + "</span>" + 
                "<input class='serial' id='serial-" + uid + "'name='serial[]' type='hidden' value='"+serial+"'>" + "</td><td>"+
                
                "<span id='fixed-asset-id-view-" + uid + "'>" + fixed_asset_id + "</span>" + 
                "<input class='fixed-asset-id' id='fixed-asset-id-" + uid + "'name='fixed_asset_id[]' type='hidden' value='"+fixed_asset_id+"'>" + "</td><td>"+
                
                "<span id='remarks-view-" + uid + "'>" + remarks + "</span>" + 
                "<input class='remarks' id='remarks-" + uid + "'name='remarks[]' type='hidden' value='"+remarks+"'>" + "</td><td>"+
                
                
                "<a class='edit btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                "<a class='remove btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                + "</td></tr>";

                elmSupplierItemInfo.find('tbody').append(row);
    }

    function updateRow(rowUid) {
        $('#item-view-' + rowUid).text(item_name);
        $('#item-' + rowUid).val(item_id);

        $('#item-status-view-' + rowUid).text(item_status_name);
        $('#item-status-type-' + rowUid).val(item_status_id);

        $('#quantity-view-' + rowUid).text(quantity);
        $('#quantity-' + rowUid).val(quantity);

        $('#serial-view-' + rowUid).text(serial);
        $('#serial-' + rowUid).val(serial);

        $('#fixed-asset-id-view-' + rowUid).text(fixed_asset_id);
        $('#fixed-asset-id-' + rowUid).val(fixed_asset_id);

        $('#remarks-view-' + rowUid).text(remarks);
        $('#remarks-' + rowUid).val(remarks);


    }

    elmSupplierItemInfo.on('click', '.rows a.edit', function (e) {
        var rowUid = $(this).attr('uid');
        $('#row-id').val(rowUid);

        $('#item').val($('#item-' + rowUid).val()).trigger('focus');
        $('#item-status').val($('#item-status-' + rowUid).val());
        $('#quantity').val($('#quantity-' + rowUid).val());
        $('#serial').val($('#serial-' + rowUid).val());
        $('#fixed-asset-id').val($('#fixed-asset-id-' + rowUid).val());
        $('#remarks').val($('#remarks-' + rowUid).val());
    });
    // Delete a pond details list row
    elmSupplierItemInfo.on('click', '.rows a.remove', function (event) {
        if( confirm('Are you sure?') ) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
        
    });
});