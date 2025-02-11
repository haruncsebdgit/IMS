/**
 * Partial: User Tweaks
 *
 * Responsible for maintaining conditional fields
 * on the user add/edit and edit profile pages.
 */

jQuery(document).ready(function ($) {
    if ($('body.add-user, body.edit-user').length > 0) {
        var user_level = $('#user-level');

        var division_label = $('.js-conditional-req-division');
        var district_label = $('.js-conditional-req-district');
        var upazila_label  = $('.js-conditional-req-upazila');
        var union_label    = $('.js-conditional-req-union');

        var division_field = $('#division');
        var district_field = $('#district');
        var upazila_field  = $('#thana-upazila');
        var union_field    = $('#union-ward');

        const mandate_division = () => {
            division_label.show();
            division_field.prop('required', true);
        }

        const free_division = () => {
            division_label.hide();
            division_field.removeAttr('required');
        }

        const mandate_district = () => {
            district_label.show();
            district_field.prop('required', true);
        }

        const free_district = () => {
            district_label.hide();
            district_field.removeAttr('required');
        }

        const mandate_upazila = () => {
            upazila_label.show();
            upazila_field.prop('required', true);
        }

        const free_upazila = () => {
            upazila_label.hide();
            upazila_field.removeAttr('required');
        }

        const mandate_union = () => {
            union_label.show();
            union_field.prop('required', true);
        }

        const free_union = () => {
            union_label.hide();
            union_field.removeAttr('required');
        }

        function mandate_free_on_user_level() {
            // District  – DDLG, DF
            // Upazilla   – UPS
            // Union  – UPS
            switch (user_level.val()) {
                case 'ups':
                    mandate_division()
                    mandate_district()
                    mandate_upazila()
                    mandate_union()
                    break;

                case 'uno':
                    mandate_division()
                    mandate_district()
                    mandate_upazila()
                    free_union()
                    break;

                case 'dc':
                case 'ddlg':
                case 'df':
                    mandate_division()
                    mandate_district()
                    free_upazila()
                    free_union()
                    break;

                case 'dv':
                    mandate_division()
                    free_district()
                    free_upazila()
                    free_union()
                    break;

                default:
                    free_division()
                    free_district()
                    free_upazila()
                    free_union()
                    break;
            }
        }

        // Active on load.
        mandate_free_on_user_level();

        // Active on change.
        // TRIED REALLY HARD TO NOT REPEAT. BUT COULDN'T MAKE IT WORK IN A SINGLE FUNCTION. :(
        $('#user-level').on('change', function() {
            {
                // District  – DDLG, DF
                // Upazilla   – UPS
                // Union  – UPS
                switch ($(this).val()) {
                    case 'ups':
                        mandate_division()
                        mandate_district()
                        mandate_upazila()
                        mandate_union()
                        break;

                    case 'uno':
                        mandate_division()
                        mandate_district()
                        mandate_upazila()
                        free_union()
                        break;

                    case 'dc':
                    case 'ddlg':
                    case 'df':
                        mandate_division()
                        mandate_district()
                        free_upazila()
                        free_union()
                        break;

                    case 'dv':
                        mandate_division()
                        free_district()
                        free_upazila()
                        free_union()
                        break;

                    default:
                        free_division()
                        free_district()
                        free_upazila()
                        free_union()
                        break;
                }
            }
        })
    }

});
