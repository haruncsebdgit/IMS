/**
 * Application Javascripts
 *
 * All the javascripts associated with the application.
 */

// ------------------------------------------
// Get the application data in JavaScript.
// Coming from admin.blade.php
// ------------------------------------------

let app = jQuery.parseJSON(app_data);

import CMSRepeater from "./_cms-repeater";

jQuery(document).ready(function ($) {

    if ($('body').hasClass('common-labels')) {

        // ----------------------------
        // REDIRECT TO DATA TYPE
        // ----------------------------
        $('[name="data_type"]').on('change', function () {
            let parameter = $(this).val();
            let baseUrl = window.location.href;
            let withoutLastChunk = baseUrl.slice(0, baseUrl.lastIndexOf("common-labels"));
            window.location.href = withoutLastChunk + 'common-labels/' + parameter;
        });

    }

    if (window.jQuery().repeater) {
        // ----------------------------
        // MANAGE REPEATER FIELDS
        // ----------------------------
        //DAE-Demonstration
        CMSRepeater.repeat('#repeater-dae-supplied-equipment', app.repeater_dae_supplied_equipment, true);
        CMSRepeater.repeat('#repeater-dof-work-date-time', app.repeater_dof_work_date_time, true);
        CMSRepeater.repeat('#repeater-dae-participant-details', app.repeater_dae_participant_details, true);
        CMSRepeater.repeat('#repeater-soil-health-detail', app.repeater_soil_health_detail, true);
        CMSRepeater.repeat('#repeater-training-schedule-detail', app.repeater_training_schedule_details, true);
        
    }

    if (window.jQuery().areYouSure) {
        // ----------------------------
        // WARN USERS TO SAVE FORM DATA
        // ----------------------------
        $('form.needs-validation').areYouSure({
            'message': 'You have unsaved changes! Save them before leaving.'
        });
    }

});
