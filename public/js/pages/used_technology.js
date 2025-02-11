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

       
    var name_of_technology_id;
    var name_of_technology_name;
    var elm_name_of_technology = document.getElementById('name-of-technology');

    var elm_number_of_applied_area = document.getElementById('number-of-applied-area');
    var number_of_applied_area;

    var elm_total_area = document.getElementById('total-area');
    var total_area;  

    var elmUsedTechnology = $('#used-technology');
    $('body').on('click', '#btn-add-used-technology', function() {

        name_of_technology_id = elm_name_of_technology.value;
        if(!name_of_technology_id){
            name_of_technology_name = '';
        }
        else{
            name_of_technology_name = elm_name_of_technology.options[elm_name_of_technology.selectedIndex].text;
        }
        

        number_of_applied_area = elm_number_of_applied_area.value;

        total_area = elm_total_area.value;


        var existingRowId = $('#row-id').val();
        if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
        updateRow(existingRowId);
        } else {
            addRow();
        }

        $('#row-id').val('');
        // Removing data from input field after successfully adding to list
        $('#name-of-technology').val('');
        $('#number-of-applied-area').val('');
        $('#total-area').val('');

    });

    function addRow() {
        var uid = uuidv4();
        
        // Build table row for added dynamically
        var row = "<tr class='rows'><td><span id='name-of-technology-view-" + uid + "'>"+ name_of_technology_name + "</span>" +
                "<input class='name-of-technology' id='name-of-technology-" + uid + "'name='name_of_technology_id[]' type='hidden' value='"+name_of_technology_id+"'>" + "</td><td>"+
                
                "<span id='number-of-applied-area-view-" + uid + "'>" + number_of_applied_area + "</span>" + 
                "<input class='number-of-applied-area' id='number-of-applied-area-" + uid + "'name='number_of_applied_area[]' type='hidden' value='"+number_of_applied_area+"'>" + "</td><td>"+
                
                "<span id='total-area-view-" + uid + "'>" + total_area + "</span>" + 
                "<input class='total-area' id='total-area-" + uid + "'name='total_area[]' type='hidden' value='"+total_area+"'>" + "</td><td>"+
                
                "<a class='edit btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                "<a class='remove btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                + "</td></tr>";

                elmUsedTechnology.find('tbody').append(row);
    }

    function updateRow(rowUid) {
        $('#name-of-technology-view-' + rowUid).text(name_of_technology_name);
        $('#name-of-technology-' + rowUid).val(name_of_technology_id);

        $('#number-of-applied-area-view-' + rowUid).text(number_of_applied_area);
        $('#number-of-applied-area-' + rowUid).val(number_of_applied_area);

        $('#total-area-view-' + rowUid).text(total_area);
        $('#total-area-' + rowUid).val(total_area);

    }

    elmUsedTechnology.on('click', '.rows a.edit', function (e) {
        var rowUid = $(this).attr('uid');
        $('#row-id').val(rowUid);

        $('#name-of-technology').val($('#name-of-technology-' + rowUid).val()).trigger('focus');
        $('#number-of-applied-area').val($('#number-of-applied-area-' + rowUid).val());
        $('#total-area').val($('#total-area-' + rowUid).val());
    });
    // Delete a pond details list row
    elmUsedTechnology.on('click', '.rows a.remove', function (event) {
        if( confirm('Are you sure?') ) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
        
    });
});