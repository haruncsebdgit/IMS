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


    var elm_problem_details = document.getElementById('problem-details');
    var problem_details;

    var is_solved_by_own_fund_name = $("input[name='is_solved_by_own_fund_repeater']:checked").val();
    if(is_solved_by_own_fund_name == 1){
            'Yes';
        }
        else{
            'No';
        }
    var is_solved_by_own_fund; 
    
    var is_project_fund_name = $("input[name='is_project_fund_repeater']:checked").val();
    if(is_project_fund_name == 1){
            'Yes';
        }
        else{
            'No';
        }
    var is_project_fund;

    var for_research_name = $("input[name='for_research_repeater']:checked").val();
    if(for_research_name == 1){
            'Yes';
        }
        else{
            'No';
        }
    var for_research;

    var elmProblemDetails = $('#problem');
    $('body').on('click', '#btn-add-problem-details', function() {
        
        problem_details = elm_problem_details.value;

        is_solved_by_own_fund = $("input[name='is_solved_by_own_fund_repeater']:checked").val();
        if(is_solved_by_own_fund == 1){
                   is_solved_by_own_fund_name = 'Yes';
                }
                else{
                    is_solved_by_own_fund_name =  'No';
                }
        
        is_project_fund = $("input[name='is_project_fund_repeater']:checked").val();
        if(is_project_fund == 1){
                    is_project_fund_name = 'Yes';
                }
                else{
                    is_project_fund_name =  'No';
                }
        
        for_research = $("input[name='for_research_repeater']:checked").val();
        if(for_research == 1){
                    for_research_name = 'Yes';
                }
                else{
                    for_research_name =  'No';
                }
        
         
                
                
        var existingRowId = $('#row-id').val();
        if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
        updateRow(existingRowId);
        } else {
            addRow();
        }

        $('#row-id').val('');
        // Removing data from input field after successfully adding to list
        $('#problem-details').val('');

        $('#is-solved-by-own-fund-1').prop('checked', true);
        $('#is-solved-by-own-fund-2').prop('checked', false);

        $('#is-project-fund-1').prop('checked', true);
        $('#is-project-fund-2').prop('checked', false);
        
        $('#for-research-1').prop('checked', true);
        $('#for-research-2').prop('checked', false);

    });

    function addRow() {
        var uid = uuidv4();
        
        // Build table row for added dynamically
        var row = "<tr class='rows'><td><span id='problem-details-view-" + uid + "'>"+ problem_details + "</span>" +
                "<input class='problem-details' id='problem-details-" + uid + "'name='problem_details[]' type='hidden' value='"+problem_details+"'>" + "</td><td>"+
                
                "<span id='is-solved-by-own-fund-view-" + uid + "'>" + is_solved_by_own_fund_name + "</span>" + 
                "<input class='is-solved-by-own-fund' id='is-solved-by-own-fund-" + uid + "'name='is_solved_by_own_fund[]' type='hidden' value='"+is_solved_by_own_fund+"'>" + "</td><td>"+
                
                "<span id='is-project-fund-view-" + uid + "'>" + is_project_fund_name + "</span>" + 
                "<input class='is-project-fund' id='is-project-fund-" + uid + "'name='is_project_fund[]' type='hidden' value='"+is_project_fund+"'>" + "</td><td>"+
                
                "<span id='for-research-view-" + uid + "'>" + for_research_name + "</span>" + 
                "<input class='for-research' id='for-research-" + uid + "'name='for_research[]' type='hidden' value='"+for_research+"'>" + "</td><td>"+
                
                "<a class='edit btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                "<a class='remove btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                + "</td></tr>";

                elmProblemDetails.find('tbody').append(row);
    }

    function updateRow(rowUid) {
        $('#problem-details-view-' + rowUid).text(problem_details);
        $('#problem-details-' + rowUid).val(problem_details);

        $('#is-solved-by-own-fund-view-' + rowUid).text(is_solved_by_own_fund_name);
        $('#is-solved-by-own-fund-' + rowUid).val(is_solved_by_own_fund);

        $('#is-project-fund-view-' + rowUid).text(is_project_fund_name);
        $('#is-project-fund-' + rowUid).val(is_project_fund);

        $('#for-research-view-' + rowUid).text(for_research_name);
        $('#for-research-' + rowUid).val(for_research);


    }

    elmProblemDetails.on('click', '.rows a.edit', function (e) {
        var rowUid = $(this).attr('uid');
        $('#row-id').val(rowUid);

        $('#problem-details').val($('#problem-details-' + rowUid).val()).trigger('focus');
        
        var solved = $('#is-solved-by-own-fund-' + rowUid).val();
        if(solved == 1){
            $('#is-solved-by-own-fund-2').prop('checked', false);
            $('#is-solved-by-own-fund-1').prop('checked', true);
        }
        else{
            $('#is-solved-by-own-fund-1').prop('checked', false);
            $('#is-solved-by-own-fund-2').prop('checked', true);
        }

        var project = $('#is-project-fund-' + rowUid).val();
        if(project == 1){
            $('#is-project-fund-2').prop('checked', false);
            $('#is-project-fund-1').prop('checked', true);
        }
        else{
            $('#is-project-fund-1').prop('checked', false);
            $('#is-project-fund-2').prop('checked', true);
        }

        var research = $('#for-research-' + rowUid).val();
        if(research == 1){
            $('#for-research-2').prop('checked', false);
            $('#for-research-1').prop('checked', true);
        }
        else{
            $('#for-research-1').prop('checked', false);
            $('#for-research-2').prop('checked', true);
        }
        
        
    });
    
    // Delete a pond details list row
    elmProblemDetails.on('click', '.rows a.remove', function (event) {
        if( confirm('Are you sure?') ) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
        
    });
});