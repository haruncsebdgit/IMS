
$(document).ready(function() {

    $('.indicator-row').click(function(){
        // $(this).addClass('active');
    });

    
     var elmTable = $('#table-selected-indicator-answer');
     $('body').on('click', '#btn-add-indicator', function() {
        var html = "";
        $('.indicator-checkboxes').each(function () {
            //sList += "(" + $(this).val() + "-" + (this.checked ? "checked" : "not checked") + ")";
            var indicatorId = $(this).val();
            var indicator = $('#indicator-label-' + indicatorId).text();
            var indicatorType = $('#indicator-type-' + indicatorId).val();
            if(this.checked) {
                html += ` 
                <div class='row border-bottom mb-2' id='indicator-row-${indicatorId}'>
                    <input type="hidden" name="indicator_type[${indicatorId}]" value="${indicatorType}">

                    <div class="col-sm-4">
                        <label for="element-id" class="font-weight-bold d-block d-sm-none">
                            {{ __('Indicator') }}
                        </label>
                        <table class="">
                            <tr class="table-light">
                                <td>
                                    <span class="float-left">
                                        <a class='pl-0 remove-indicator btn btn-link text-danger' uid='${indicatorId}' href='javascript:void(0)'><i class='icon-trash'></i></a>
                                    </span>
                                </td>
                                <td>
                                    ${indicator}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="element-id" class="font-weight-bold d-block d-sm-none">
                                {{ __('Serial (English)') }}
                            </label>
                            <input class="form-control" name="serial_en[${indicatorId}]" type="text">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="element-id" class="font-weight-bold d-block d-sm-none">
                                {{ __('Serial (Bengali)') }}
                            </label>
                            <input class="form-control " name="serial_bn[${indicatorId}]" type="text">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="element-id" class="font-weight-bold d-block d-sm-none">
                                {{ __('Order') }}
                            </label>
                            <input class="form-control " name="order[${indicatorId}]" type="text">
                        </div>
                    </div>
                </div>
                `;
                // Uncheck checkbox after adding to from
                $(this).prop('checked', false);
                // Hiding checkbox after adding to form
                $('#list-group-indicator-' + indicatorId).addClass('d-none');
            }

            
            
        });
        $('#selected-indicator-answer').append(html);
        $('#indicator-modal').modal('hide');

     });
     // Delete a selected indicator
     $('#selected-indicator-answer').on('click', 'a.remove-indicator', function (event) {
         if( confirm('Are you sure?') ) {
            var indicatorId = $(this).attr('uid');
            $('#list-group-indicator-' + indicatorId).removeClass('d-none')
            $('#indicator-row-' + indicatorId).remove();
         }
     });
     
});