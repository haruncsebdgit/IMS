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

function maxLengthCheck(object)
{
  if (object.value.length > object.maxLength) {
      object.value = object.value.slice(0, object.maxLength)
  }
  if (object.value > object.max) {
    object.value = object.value.slice(0, 2)
  }
  if (object.value && object.value < object.min) {
    object.value = '';
  }
  //console.log(object.className);
}

$(document).ready(function() {

    /**
     * Add fund source item as list.
     */
     var fundSource
     var fundSourceItem
     var isLoanGrant
     var fundSourceItemId
     var isLoanGrantItem
     var creditLoanNo;
     var fundContributionPercent;
     var fundContributionUsd;
     var fundContributionBdt;
    $('body').on('click', '#btn-fund-source', function() {
        
        fundSource = document.getElementById('fund-src-id');
        fundSourceItem = fundSource.options[fundSource.selectedIndex].text;
        fundSourceItemId = fundSource.value;

        isLoanGrant = -1;
        isLoanGrantItem = '';

        if ($('#is_loan_grant1'). prop("checked") == true) {
            isLoanGrant = 1;
            isLoanGrantItem = 'Loan';
        } else if ($('#is_loan_grant0'). prop("checked") == true){
            isLoanGrant = 0;
            isLoanGrantItem = 'Grant';
        }
        creditLoanNo = document.getElementById('credit-loan-number').value;
        fundContributionPercent = document.getElementById('fund-contribution').value;
        fundContributionUsd = document.getElementById('fund-contribution-usd').value;
        fundContributionBdt = document.getElementById('fund-contribution-bdt').value;

        // Checking required validation
        var isValidate = true;
        $('#fund-src-id').removeClass('is-invalid');
        $('#credit-loan-number').removeClass('is-invalid');
        $('#fund-contribution').removeClass('is-invalid');
        $('#fund-contribution-usd').removeClass('is-invalid');
        $('#fund-contribution-bdt').removeClass('is-invalid');
        if(!fundSourceItemId) {
            $('#fund-src-id').addClass('is-invalid');
            isValidate = false;
        }
        if(!creditLoanNo) {
            $('#credit-loan-number').addClass('is-invalid');
            isValidate = false;
        }
        if(!fundContributionPercent) {
            $('#fund-contribution').addClass('is-invalid');
            isValidate = false;
        }
        if(!fundContributionUsd) {
            $('#fund-contribution-usd').addClass('is-invalid');
            isValidate = false;
        }
        if(!fundContributionBdt) {
            $('#fund-contribution-bdt').addClass('is-invalid');
            isValidate = false;
        }

        if(!isValidate) {
            return;
        }

        var existingRowId = $('#fund-source-list-row-id').val();
        if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
            updateFundsourceData(existingRowId);
        } else {
            addFundsourceData();
        }

        $('#fund-source-list-row-id').val('');

        // Removing data from input field after successfully adding to list
        $('#fund-src-id').val('');
        $('#credit-loan-number').val('');
        $('#fund-contribution').val('');
        $('#fund-contribution-usd').val('');
        $('#fund-contribution-bdt').val('');
    });

    function updateFundsourceData(rowUid) {
        $('#fund-source-name-view-' + rowUid).text(fundSourceItem);
        $('#fund-source-name-' + rowUid).val(fundSourceItemId);
        
        $('#loan-grant-view-' + rowUid).text(isLoanGrantItem);
        $('#loan-grant-' + rowUid).val(isLoanGrant);
        
        $('#credit-loan-no-view-' + rowUid).text(creditLoanNo);
        $('#credit-loan-no-' + rowUid).val(creditLoanNo);

        $('#fund-contribution-view-' + rowUid).text(fundContributionPercent);
        $('#fund-contribution-' + rowUid).val(fundContributionPercent);

        $('#fund-contribution-usd-view-' + rowUid).text(fundContributionUsd);
        $('#fund-contribution-usd-' + rowUid).val(fundContributionUsd);

        $('#fund-contribution-bdt-view-' + rowUid).text(fundContributionBdt);
        $('#fund-contribution-bdt-' + rowUid).val(fundContributionBdt);

    }

    function addFundsourceData() {
        var uid = uuidv4();
        
        // Build table row for added dynamically
        var row = "<tr class='rows'><td><span id='fund-source-name-view-" + uid + "'>"+ fundSourceItem + "</span>" +
                "<input class='fund-source-name' id='fund-source-name-" + uid + "'name='fund_source_name_id[]' type='hidden' value='"+fundSourceItemId+"'>" + "</td><td>"+
                "<span id='loan-grant-view-" + uid + "'>" + isLoanGrantItem + "</span>" + 
                "<input class='loan-grant' id='loan-grant-" + uid + "'name='is_loan_grant[]' type='hidden' value='"+isLoanGrant+"'>" + "</td><td>"+
                "<span id='credit-loan-no-view-" + uid + "'>" + creditLoanNo + "</span>" + 
                "<input class='credit_loan_number' id='credit-loan-no-" + uid + "'name='credit_loan_number[]' type='hidden' value='"+creditLoanNo+"'>" + "</td><td class='text-right'>"+
                "<span id='fund-contribution-view-" + uid + "'>" + fundContributionPercent + "</span>" +
                "<input class='fund_contribution' id='fund-contribution-" + uid + "'name='fund_contribution[]' type='hidden' value='"+fundContributionPercent+"'>" + "</td><td class='text-right'>"+
                "<span id='fund-contribution-usd-view-" + uid + "'>" + fundContributionUsd + "</span>" +
                "<input class='fund_contribution_usd' id='fund-contribution-usd-" + uid + "'name='fund_source_contribution_usd[]' type='hidden' value='"+fundContributionUsd+"'>" + "</td><td class='text-right'>"+
                "<span id='fund-contribution-bdt-view-" + uid + "'>" + fundContributionBdt + "</span>" +
                "<input class='fund_contribution_bdt' id='fund-contribution-bdt-" + uid + "'name='fund_source_contribution_bdt[]' type='hidden' value='"+fundContributionBdt+"'>" + "</td><td>"+
                "<a class='edit-row editRow btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                "<a class='remove-row-fundsource btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                + "</td></tr>";

        $('#table-fund-source').find('tbody').append(row);
    }


    $('#table-fund-source').on('click', '.rows a.editRow', function (e) {
        var rowUid = $(this).attr('uid');
        $('#fund-source-list-row-id').val(rowUid);

        $('#credit-loan-number').val($('#credit-loan-no-' + rowUid).val());
        $('#fund-contribution').val($('#fund-contribution-' + rowUid).val());
        $('#fund-contribution-usd').val($('#fund-contribution-usd-' + rowUid).val());
        $('#fund-contribution-bdt').val($('#fund-contribution-bdt-' + rowUid).val());
        $('#fund-src-id').val($('#fund-source-name-' + rowUid).val());
        var isLoanGrant = $('#loan-grant-' + rowUid).val();

        if (isLoanGrant == 1) {
            $('#is_loan_grant1').prop('checked', true);
        } else if (isLoanGrant == 0) {
            $('#is_loan_grant0').prop('checked', true);
        }
    });
    // Delete a fund source row
    $('#table-fund-source').on('click', '.rows a.remove-row-fundsource', function (event) {
        if( confirm('Are you sure?') ) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        }
        
    });

    // Adding project cost center to lis
    var organogramName;
    var organogramId;
    var phaseNo;
    var phaseNoId;
    var originProject = '';
    var originProjectId;
    $('body').on('click', '#btn-cost-center', function() {
        // Initializing var
       
        originProject = '';
        
        organogramName = $('#organogram-name').val();
        organogramId = $('#organogram-id').val();
        //alert(organogramName);
        phaseNoId = document.getElementById('phase-no').value;
        phaseNo = document.getElementById('phase-no').options[document.getElementById('phase-no').selectedIndex].text;
        originProjectId = document.getElementById('origin-project-id').value;
        if(originProjectId) {
            originProject = document.getElementById('origin-project-id').options[document.getElementById('origin-project-id').selectedIndex].text;
        }

        // Checking required validation
        var isValidate = true;
        $('#phase-no').removeClass('is-invalid');
        if(!phaseNoId) {
            $('#phase-no').addClass('is-invalid');
            isValidate = false;
        }
        if(!organogramId) {
            $('.required-organogram').text('Please select office');
            isValidate = false;
        }

        if(!isValidate) {
            return;
        }

        var existingRowId = $('#cost-center-list-row-id').val();
        if(existingRowId) { // If found existingRowId that means it is edit form otherwise add form
            updateCostCenterData(existingRowId);
        } else {
            addCostCenterData();
        }

        $('#cost-center-list-row-id').val('');

        // Removing data from input field after successfully adding to list
        $('#phase-no').val('');
        $('#origin-project-id').val('');
    });

    function updateCostCenterData(rowUid) {
        $('#organogram-name-' + rowUid).text(organogramName);
        $('#organogram-id-' + rowUid).val(organogramId);
        //alert(phaseNo);
        $('#phase-no-view-' + rowUid).text(phaseNo);
        $('#phase-no-' + rowUid).val(phaseNoId);
        
        $('#credit-loan-no-view-' + rowUid).text(creditLoanNo);
        $('#credit-loan-no-' + rowUid).val(creditLoanNo);

        $('#origin-project-' + rowUid).text(originProject);
        $('#origin-project-id-' + rowUid).val(originProjectId);

    }

    function addCostCenterData() {
        var uid = uuidv4();
        
        // Build table row for added dynamically
        var row = "<tr class='rows'><td><span id='organogram-name-" + uid + "'>"+ organogramName + "</span>" +
                "<input class='organogram-name' id='organogram-id-" + uid + "'name='organogram_id[]' type='hidden' value='" + organogramId+"'>" + "</td><td>"+
                "<span id='phase-no-view-" + uid + "'>" + phaseNo + "</span>" + 
                "<input class='phase-no' id='phase-no-" + uid + "'name='phase_no[]' type='hidden' value='"+phaseNoId+"'>" + "</td><td>"+
                "<span id='origin-project-" + uid + "'>" + originProject + "</span>" + 
                "<input class='origin-project' id='origin-project-id-" + uid + "'name='origin_project_id[]' type='hidden' value='"+originProjectId+"'>" + "</td><td>"+
                "<a class='edit-row-cost-center btn btn-link' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-pencil7'></i></a>" + "&nbsp;" +
                "<a class='remove-row-cost-center btn btn-link text-danger' uid='" + uid +  "'href='javascript:void(0)'><i class='icon-trash'></i></a>"
                + "</td></tr>";

        $('#table-cost-center').find('tbody').append(row);
    }

    $('#table-cost-center').on('click', '.rows a.edit-row-cost-center', function (e) {
        var rowUid = $(this).attr('uid');
        $('#cost-center-list-row-id').val(rowUid);

        $('#phase-no').val($('#phase-no-' + rowUid).val());
        $('#origin-project-id').val($('#origin-project-id-' + rowUid).val());
        $('#organogram-id').val($('#organogram-id-' + rowUid).val());
        $('#organogram-name').val($('#organogram-name-' + rowUid).text());
    });

    // Delete a project cost center row
    $('#table-cost-center').on('click', '.rows a.remove-row-cost-center', function (event) {
        if( confirm('Are you sure?') ) {
            $(this).parents("tr:first").remove();
            $(this).parent().parent().remove();
        } 
    });

    // Populate origin project dropdown by phase no
    let app = jQuery.parseJSON(app_data);
    $('#phase-no').change(function () {
        let app_locale = app.app_locale;
        
        var phaseNo = $(this).val();
        if (phaseNo) {
            $.get(app.app_url + 'admin/project/origin-project/' + phaseNo, function (data) {
                let originProject = $('#origin-project-id');
                if(originProject.length > 0) {
                    //success data
                    originProject.empty();
                    originProject.append('<option value="">' + select + '</option>');

                    $.each(data, function (index, subcatObj) {
                        originProject.append('<option value="' + subcatObj.id + '">' + (subcatObj[`project_name_${app_locale}`] ? subcatObj[`project_name_${app_locale}`] : subcatObj.project_name_en) + '</option>');
                    });

                    /**
                     * Trigger only for select2
                     */
                     //method.val('').trigger('change');
                }
            });
        }
    })

});

function getOrganogramId (organogramId, organogramName) {
    $('#organogram-id').val(organogramId);
    $('#organogram-name').val(organogramName);

    $('.required-organogram').text('');
}