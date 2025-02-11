jQuery(function($) {
    let app = JSON.parse(app_data);

    // populate subproject list by fund type wise
    $('#fund-type').change(function () {
        let app_locale = app.app_locale;
        
        var fundType = $(this).val();
        var unionWard = $('#union-ward').val();

        if (fundType) {
            $.get(app.app_url + 'admin/monitoring/aif/fund-allocation/sub-project/' + fundType + '/' + unionWard, function (data) {
                let subProject = $('#sub-project');
                //data = JSON.parse(data);
                if(subProject.length > 0) {
                    //success data
                    subProject.empty();
                    subProject.append('<option value="">' + app.label_select + '</option>');
    
                    $.each(data, function (index, value) {
                        subProject.append('<option value="' + index + '">' + value + '</option>');
                    });
                }
            });
        }
    });

    $('#sub-project').on('change', function () {
        let app_locale = app.app_locale;
        
        var subProject = $(this).val();
        var subProjectType = $('#sub-project-type').val();
        var fundType = $('#fund-type').val();

        if (fundType && subProjectType) {
            $.get(app.app_url + 'admin/monitoring/aif/assessment/assessment-form/' + fundType + "/" + subProjectType + "/" + subProject, function (data) {
                $('.assessment-question').html(data);
                $('.assessment-question .datepicker-assessment').datepicker({
                    format: 'dd-mm-yyyy'
                });
            });
        }
    });

    $('.assessment-question .datepicker-assessment').datepicker({
        format: 'dd-mm-yyyy'
    });
});