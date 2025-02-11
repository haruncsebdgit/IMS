function uuidv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
      return v.toString(16);
    });
}
function validateInput(object)
{
  if (object.value) {
    $(object).removeClass('is-invalid')
    // Clearing red border from select2 dropdown 
    if ($(object).hasClass("select2-hidden-accessible")) {
        $(object).siblings(".select2-container").find('.select2-selection').removeClass('is-invalid-select2');
    }
  }
}
$(document).ready(function() {
    showHideBeneficiaryTypeWiseEnterpreneur($('#beneficiary-type').val())

    let app = jQuery.parseJSON(app_data);
     $('#beneficiary').change(function () {
         let app_locale = app.app_locale;
         
         var beneficiary = $(this).val();
         var beneficiaryType = $('#beneficiary-type').val();
         if (beneficiaryType && beneficiaryType === 'cig') {
            populateCigMember(beneficiary)
         } else if(beneficiaryType == 'po') {
            populatePoMember(beneficiary)
         }
     });

     function populateCigMember(cigId){
        $.get(app.app_url + 'admin/monitoring/cig-production/cig-member/' + cigId, function (data) {
            let cigMember = $('#cig-po-member');
            data = JSON.parse(data);
            if(cigMember.length > 0) {
                //success data
                cigMember.empty();
                cigMember.append('<option value="">' + app.label_select + '</option>');

                $.each(data, function (index, value) {
                    cigMember.append('<option value="' + index + '">' + value + '</option>');
                });
            }
        });
     }

     function populatePoMember(poId)
     {
        $.get(app.app_url + 'admin/monitoring/po-member/getMemberByPoId/' + poId, function (data) {
            let poMember = $('#cig-po-member');
            //data = JSON.parse(data);
            if(poMember.length > 0) {
                //success data
                poMember.empty();
                poMember.append('<option value="">' + app.label_select + '</option>');

                $.each(data, function (index, value) {
                    poMember.append('<option value="' + index + '">' + value + '</option>');
                });
            }
        });
     }

     $('#beneficiary-type').change(function () {
        let app_locale = app.app_locale;
        
        var beneficiaryType = $(this).val();
        showHideBeneficiaryTypeWiseEnterpreneur(beneficiaryType);

        if (beneficiaryType === 'po' || beneficiaryType === 'sao_leaf_ceal') {
            $.get(app.app_url + 'admin/monitoring/aif/getPoSaaoCealLeafList/' + beneficiaryType, function (data) {
                let beneficiary = $('#beneficiary');
                //data = JSON.parse(data);
                if(beneficiary.length > 0) {
                    //success data
                    beneficiary.empty();
                    beneficiary.append('<option value="">' + app.label_select + '</option>');
    
                    $.each(data, function (index, value) {
                        beneficiary.append('<option value="' + index + '">' + value + '</option>');
                    });
                }
            });
        }
    });

    function showHideBeneficiaryTypeWiseEnterpreneur(beneficiaryType)
    {
        if(beneficiaryType === 'enterpreneurs') {
            $('.enterpreneur').removeClass('d-none');
            $('.cig-po').addClass('d-none');
            $('.cig-po-mem').addClass('d-none');
        } else {
            $('.enterpreneur').addClass('d-none');
            $('.cig-po').removeClass('d-none');
            $('.cig-po-mem').removeClass('d-none');
        }
    }

    // Calculating matching grant by grant percent and bdt from fund type setup
    $('#total-project-value').on('keyup', function(){
        var totalProjectValue = $(this).val();
        matchingGrantPercent = parseFloat(matchingGrantPercent);
        matchingGrantBdt = parseFloat(matchingGrantBdt);

        var matchigGrantAllocation = (matchingGrantPercent * parseFloat(totalProjectValue))/100;
        //console.log(matchigGrantAllocation);
        if(matchigGrantAllocation > matchingGrantBdt) {
            matchigGrantAllocation = matchingGrantBdt;
        }

        $('#matching-grant').val(matchigGrantAllocation);
        $('#share-amount').val(parseFloat(totalProjectValue) - matchigGrantAllocation);
    });

    $('#tools-technology').change(function (e, selectedUsage) {
        let app_locale = app.app_locale;
        
        var technologyId = $(this).val();

        if (technologyId) {
            $.get(app.app_url + 'admin/monitoring/aif/getTechnologyUsageById/' + technologyId, function (data) {
                let usage = $('#tools-technology-usage');
                //data = JSON.parse(data);
                if(usage.length > 0) {
                    //success data
                    usage.empty();
                    usage.append('<option value="">' + app.label_select + '</option>');
    
                    $.each(data, function (index, value) {
                        usage.append('<option value="' + index + '">' + value + '</option>');
                    });

                    if(selectedUsage) {
                        console.log("aa" + selectedUsage);
                        $('#tools-technology-usage').val(selectedUsage.data).trigger('change');
                    }
                }
            });
        }
    });

    /**
     * Tools and Technology repeater starting
     */

    var toolsTechnologyId;
    var toolsTechnologyName;
    var elmToolsTechnology = $('#tools-technology');

    var purchaseDate;
    var elmPurchaseDate = $('#purchase-date');

    var operationStartDate;
    var elmOperationStartDate = $("#operation-start-date");

    var quantity;
    var elmQuantity = $("#quantity");

    var unitId;
    var unit;
    var elmUnit = $("#unit");

    var technologyUsageIds;
    var technologyUsage;
    var elmTechnologyUsage = $("#tools-technology-usage");

    var usageOther;
    var elmUsageOther = $("#usage-other");
    
    var remarks;
    var elmRemarks = $("#remarks");

    var elmToolsTechnologyDetails = $("#tools-technology-accordion");
    $("body").on("click", "#btn-add-technology", function () {
        
        toolsTechnologyId = elmToolsTechnology.val();
        toolsTechnologyName = elmToolsTechnology.find('option:selected').text();

        technologyUsageIds = elmTechnologyUsage.val();
        technologyUsage = elmTechnologyUsage.find('option:selected')
                .toArray().map(item => item.text).join(", ");

        purchaseDate = elmPurchaseDate.val();
        operationStartDate = elmOperationStartDate.val();
        quantity = elmQuantity.val();
        unitId = elmUnit.val();
        unit = elmUnit.find('option:selected').text();
        usageOther = elmUsageOther.val();
        remarks = elmRemarks.val();

        // Validating form
        if (!validateForm()) {
            return;
        }

        var existingRowId = $("#row-id").val();
        //console.log(existingRowId);
        if (existingRowId) {
            // If found existingRowId that means it is edit form otherwise add form
            updateDetailsData(existingRowId);
            // $('.btn-sales-details').text(labelAddSalesDetails);
        } else {
            addDetailsData();
        }
        // Clearing field after adding
        resetToolsTechnologyForm();

        $('#technology-modal').modal('hide');
        
    });

    // Clearing tools technology repeater form
    function resetToolsTechnologyForm()
    {
        elmToolsTechnology.val("").trigger('change');
        elmPurchaseDate.val("");

        elmOperationStartDate.val("");
        elmQuantity.val("");
        elmUnit.val("");
        elmTechnologyUsage.val("").trigger('change');
        elmUsageOther.val("");
        elmRemarks.val("");
    }
    // Clearing tools technology form during modal close
    $('#technology-modal').on('hidden.bs.modal', function () {
        resetToolsTechnologyForm();
        $('.btn-add-tools-technology').text(labelAddToolsTech);
      })

      // Validating tools technology form
    function validateForm() {
        var isValidate = true;
        
        elmToolsTechnology.removeClass("is-invalid");
        elmPurchaseDate.removeClass("is-invalid");
        elmQuantity.removeClass("is-invalid");

        if (!toolsTechnologyId) {
            elmToolsTechnology.addClass("is-invalid");
            elmToolsTechnology.siblings(".select2-container").find('.select2-selection').addClass('is-invalid-select2');

            isValidate = false;
        }
        if (!purchaseDate) {
            elmPurchaseDate.addClass("is-invalid");
            isValidate = false;
        }
        if (!quantity) {
            elmQuantity.addClass("is-invalid");
            isValidate = false;
        }
        return isValidate;
    }

    function addDetailsData() {
        //console.log($("div#tools-technology-accordion").children().length)
        var uid = uuidv4();
        var index = $("div#tools-technology-accordion").children().length;
        // Build html for added dynamically
        
        var html =  `
                <div class="card visibility-holder card-tools-technology">
                    <div id="collapse-head-${uid}" class="card-header p-1">
                        <div class="row clearfix hover-container">
                            <div class="col-sm-8 py-1">
                                <button type="button" class="btn btn-sm btn-link btn-block text-left font-weight-bold collapsed" data-toggle="collapse" data-target="#collapse-${uid}" aria-expanded="false" aria-controls="collapse-${uid}">
                                    <i class="icon-cogs mr-1 border-right border-secondary pr-2" aria-hidden="true"></i> <span id="tools-technology-heading-${uid}"></span> ${toolsTechnologyName} <span class="small" id="tools-technology-usage-heading-${uid}">— ${technologyUsage}</span>
                                </button>
                            </div>
                            <div class="col-sm-4 text-sm-right visible-on-hover py-1">
                                <button type="button" uid="${uid}" class="edit btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#technology-modal"><i class="ion-edit mr-1" aria-hidden="true"></i> Edit</button>
                                <button type="button" uid="${uid}" class="remove btn btn-sm btn-outline-danger"><i class="ion-close-round mr-1" aria-hidden="true"></i> Remove</button>
                            </div>
                        </div>
                    </div>
                    <div id="collapse-${uid}" class="collapse" aria-labelledby="collapse-head-${uid}" data-parent="#tools-technology-accordion" style="">
                        <div class="card-body p-2 small">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="font-weight-bold">Tools Technology</div>
                                    <div class="mb-2" id="tools-technology-view-${uid}">${toolsTechnologyName}</div>
                                    <input type="hidden" id="tools-technology-${uid}" name="tools_tech[${index}][tools_tech_goods_id]" value="${toolsTechnologyId}">

                                    <div class="font-weight-bold">Tools Technology Usage</div>
                                    <div class="mb-2" id="tools-technology-usage-view-${uid}">${technologyUsage}</div>
                                    <input type="hidden" id="tools-technology-usage-${uid}" name="tools_tech[${index}][tools_tech_goods_usage_id]" value="${technologyUsageIds}">
                                </div>
                                <div class="col-sm-4">
                                    <div class="font-weight-bold">Purchase Date</div>
                                    <div class="mb-2" id="purchase-date-view-${uid}">${purchaseDate}</div>
                                    <input type="hidden" id="purchase-date-${uid}" name="tools_tech[${index}][purchase_date]" value="${purchaseDate}">

                                    <div class="font-weight-bold">Operation Start Date</div>
                                    <div class="mb-2" id="operation-start-date-view-${uid}">${operationStartDate}</div>
                                    <input type="hidden" id="operation-start-date-${uid}" name="tools_tech[${index}][operation_start_date]" value="${operationStartDate}">

                                    <div class="font-weight-bold">Quantity</div>
                                    <div class="mb-2">
                                        <span id="quantity-view-${uid}"> ${quantity} </span> 
                                        <span id="unit-view-${uid}"> ${unit} </span> 
                                    </div>
                                    <input type="hidden" id="quantity-${uid}" name="tools_tech[${index}][quantity]" value="${quantity}">
                                    <input type="hidden" id="unit-${uid}" name="tools_tech[${index}][unit_id]" value="${unitId}">
                                </div>
                                <div class="col-sm-4">
                                    <div class="font-weight-bold">Technology Usage Other</div>
                                    <div class="mb-2" id="usage-other-view-${uid}">${usageOther}</div>
                                    <input type="hidden" id="usage-other-${uid}" name="tools_tech[${index}][technology_usage_other]" value="${usageOther}">

                                    <div class="font-weight-bold">Remarks</div>
                                    <div class="mb-2" id="remarks-view-${uid}">${remarks}</div>
                                    <input type="hidden" id="remarks-${uid}" name="tools_tech[${index}][remarks]" value="${remarks}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- /#alleged-persons-accordion.accordion -->

        `;
        //console.log(row);
        elmToolsTechnologyDetails.append(html);
        $("#notice-tools-technology-info").addClass('d-none');
        //renumber_blocks();
    }

    // Update tools technology data
    function updateDetailsData(rowUid) {

        $('#tools-technology-heading-view-' + rowUid).text(toolsTechnologyName);
        $('#tools-technology-view-' + rowUid).text(toolsTechnologyName);
        $('#tools-technology-' + rowUid).val(toolsTechnologyId);
        
        $('#purchase-date-view-' + rowUid).text(purchaseDate);
        $('#purchase-date-' + rowUid).val(purchaseDate);

        $('#operation-start-date-view-' + rowUid).text(operationStartDate);
        $('#operation-start-date-' + rowUid).val(operationStartDate);

        $('#quantity-view-' + rowUid).text(quantity);
        $('#quantity-' + rowUid).val(quantity);

        $('#unit-view-' + rowUid).text(unit);
        $('#unit-' + rowUid).val(unitId);

        $('#tools-technology-usage-heading-' + rowUid).text(technologyUsage);
        $('#tools-technology-usage-view-' + rowUid).text(technologyUsage);
        $('#tools-technology-usage-' + rowUid).val(technologyUsageIds);

        $('#usage-other-view-' + rowUid).text(usageOther);
        $('#usage-other-' + rowUid).val(usageOther);
        
        $('#remarks-view-' + rowUid).text(remarks);
        $('#remarks-' + rowUid).val(remarks);

        triggerToast('Tools Technology Information Updated.', 'success');

    }

    $('#tools-technology-accordion').on("click", ".edit", function (e) {
       
        var rowUid = $(this).attr("uid");
        $("#row-id").val(rowUid);

        var techUsage = $('#tools-technology-usage-' + rowUid).val();
        // console.log(techUsage.split(','));
        elmToolsTechnology.val($('#tools-technology-' + rowUid).val()).trigger('change', [{data: techUsage.split(',')}]);
        elmPurchaseDate.val($('#purchase-date-' + rowUid).val());
        elmOperationStartDate.val($('#operation-start-date-' + rowUid).val());
        elmQuantity.val($('#quantity-' + rowUid).val());
        elmUnit.val($('#unit-' + rowUid).val());
        elmUsageOther.val($('#usage-other-' + rowUid).val());
        elmRemarks.val($('#remarks-' + rowUid).val());

        $('.btn-add-tools-technology').text(labelUpdateToolsTech);
    });

    $('#tools-technology-accordion').on("click", ".remove", function (e) {
       
        if( confirm('Are you sure?') ) {
            $(this).parents(".card-tools-technology").remove();
            $(this).parent().parent().parent().parent().remove();
            reindex_inputname();
        }
    });

    function reindex_inputname() {
        $(".card-tools-technology").each(function(index) {
            var prefix = "tools_tech[" + index + "]";
            
            $(this).find("input[name]").each(function() {
               this.name = this.name.replace(/tools_tech\[]/, prefix);  // Replacing tools_tech[] name 
               this.name = this.name.replace(/tools_tech\[\d+\]/, prefix); // Replacing tools_tech[{digit}] name  
            //    console.log(this.name.replace(/tools_tech\[]/, prefix));
            });
        });
    }

});