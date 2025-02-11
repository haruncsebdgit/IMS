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

    var elm_name_of_task = document.getElementById('name-of-task');
    var name_of_task;

    var elm_task_details = document.getElementById('task-details');
    var task_details;
    
    var elm_area = document.getElementById('area');
    var area;

    var elm_weight = document.getElementById('weight');
    var weight;

    var elm_implementation_time_1 = document.getElementById('implementation-time-1');
    var implementation_time_1;

    var elm_implementation_time_2 = document.getElementById('implementation-time-2');
    var implementation_time_2;

    var elm_expense_of_cig = document.getElementById('expense-of-cig');
    var expense_of_cig;

    var elm_project_grant = document.getElementById('project-grant');
    var project_grant;

    var elm_total_expense = document.getElementById('total-expense');
    var total_expense;

    var elm_responsible = document.getElementById('responsible');
    var responsible;

    var elmProblemResolvePlan = $('#problem-resolve-plan');
    $('body').on('click', '#btn-add-problem-resolved-plan', function() {

        name_of_task = elm_name_of_task.value;

        task_details = elm_task_details.value;

        area = elm_area.value;

        weight = elm_weight.value;

        implementation_time_1 = elm_implementation_time_1.value;

        implementation_time_2 = elm_implementation_time_2.value;

        expense_of_cig = elm_expense_of_cig.value;

        project_grant = elm_project_grant.value;

        total_expense = elm_total_expense.value;

        responsible = elm_responsible.value;


        var existingRowId = $('#row-id').val();
        if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
        updateRow(existingRowId);
        } else {
            addRow();
        }

        $('#row-id').val('');
        // Removing data from input field after successfully adding to list
        $('#name-of-task').val('');
        $('#task-details').val('');
        $('#area').val('');
        $('#weight').val('');
        $('#implementation-time-1').val('');
        $('#implementation-time-2').val('');
        $('#expense-of-cig').val('');
        $('#project-grant').val('');
        $('#total-expense').val('');
        $('#responsible').val('');

    });

    function addRow() {
        var uid = uuidv4();
        
        // Build table row for added dynamically
        var row = "<tr class='rows'><td><span id='name-of-task-view-" + uid + "'>"+ name_of_task + "</span>" +
                "<input class='name-of-task' id='name-of-task-" + uid + "'name='name_of_task[]' type='hidden' value='"+name_of_task+"'>" + "</td><td>"+
                
                "<span id='task-details-view-" + uid + "'>" + task_details + "</span>" + 
                "<input class='task-details' id='task-details-" + uid + "'name='task_details[]' type='hidden' value='"+task_details+"'>" + "</td><td>"+
                
                "<span id='area-view-" + uid + "'>" + area + "</span>" + 
                "<input class='area' id='area-" + uid + "'name='area[]' type='hidden' value='"+area+"'>" + "</td><td>"+
                
                "<span id='weight-view-" + uid + "'>" + weight + "</span>" + 
                "<input class='weight' id='weight-" + uid + "'name='weight[]' type='hidden' value='"+weight+"'>" + "</td><td>"+
                
                "<span id='implementation-time-1-view-" + uid + "'>" + implementation_time_1 + "</span>" + 
                "<input class='implementation-time-1' id='implementation-time-1-" + uid + "'name='implementation_time_1[]' type='hidden' value='"+implementation_time_1+"'>" + "</td><td>"+
                
                "<span id='implementation-time-2-view-" + uid + "'>" + implementation_time_2 + "</span>" + 
                "<input class='implementation-time-2' id='implementation-time-2-" + uid + "'name='implementation_time_2[]' type='hidden' value='"+implementation_time_2+"'>" + "</td><td>"+
                
                "<span id='expense-of-cig-view-" + uid + "'>" + expense_of_cig + "</span>" + 
                "<input class='expense-of-cig' id='expense-of-cig-" + uid + "'name='expense_of_cig[]' type='hidden' value='"+expense_of_cig+"'>" + "</td><td>"+
                
                "<span id='project-grant-view-" + uid + "'>" + project_grant + "</span>" + 
                "<input class='project-grant' id='project-grant-" + uid + "'name='project_grant[]' type='hidden' value='"+project_grant+"'>" + "</td><td>"+
                
                "<span id='total-expense-view-" + uid + "'>" + total_expense + "</span>" + 
                "<input class='total-expense' id='total-expense-" + uid + "'name='total_expense[]' type='hidden' value='"+total_expense+"'>" + "</td><td>"+
                
                "<span id='responsible-view-" + uid + "'>" + responsible + "</span>" + 
                "<input class='responsible' id='responsible-" + uid + "'name='responsible[]' type='hidden' value='"+responsible+"'>" + "</td><td>"+
                
                "<a class='edit btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                "<a class='remove btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                + "</td></tr>";

                elmProblemResolvePlan.find('tbody').append(row);
    }

    function updateRow(rowUid) {
       
        $('#name-of-task-view-' + rowUid).text(name_of_task);
        $('#name-of-task-' + rowUid).val(name_of_task);

        $('#task-details-view-' + rowUid).text(task_details);
        $('#task-details-' + rowUid).val(task_details);

        $('#area-view-' + rowUid).text(area);
        $('#area-' + rowUid).val(area);

        $('#weight-view-' + rowUid).text(weight);
        $('#weight-' + rowUid).val(weight);
        
        $('#implementation-time-1-view-' + rowUid).text(implementation_time_1);
        $('#implementation-time-1-' + rowUid).val(implementation_time_1);

        $('#implementation-time-2-view-' + rowUid).text(implementation_time_2);
        $('#implementation-time-2-' + rowUid).val(implementation_time_2);

        $('#expense-of-cig-view-' + rowUid).text(expense_of_cig);
        $('#expense-of-cig-' + rowUid).val(expense_of_cig);

        $('#project-grant-view-' + rowUid).text(project_grant);
        $('#project-grant-' + rowUid).val(project_grant);

        $('#total-expense-view-' + rowUid).text(total_expense);
        $('#total-expense-' + rowUid).val(total_expense);

        $('#responsible-view-' + rowUid).text(responsible);
        $('#responsible-' + rowUid).val(responsible);

    }

    elmProblemResolvePlan.on('click', '.rows a.edit', function (e) {
        var rowUid = $(this).attr('uid');
        $('#row-id').val(rowUid);

        $('#name-of-task').val($('#name-of-task-' + rowUid).val()).trigger('focus');
        $('#task-details').val($('#task-details-' + rowUid).val());
        $('#area').val($('#area-' + rowUid).val());
        $('#weight').val($('#weight-' + rowUid).val());
        $('#implementation-time-1').val($('#implementation-time-1-' + rowUid).val());
        $('#implementation-time-2').val($('#implementation-time-2-' + rowUid).val());
        $('#expense-of-cig').val($('#expense-of-cig-' + rowUid).val());
        $('#project-grant').val($('#project-grant-' + rowUid).val());
        $('#total-expense').val($('#total-expense-' + rowUid).val());
        $('#responsible').val($('#responsible-' + rowUid).val());
    });
    // Delete a pond details list row
    elmProblemResolvePlan.on('click', '.rows a.remove', function (event) {
        if( confirm('Are you sure?') ) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
        
    });
});