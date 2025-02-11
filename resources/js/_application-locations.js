/**
 * Partial: Location Utilities
 *
 * Responsible for all the tweaks related to load
 * location data conditionally.
 */


// ------------------------------------------
// Get the application data in JavaScript.
// Coming from admin.blade.php
// ------------------------------------------

let app = jQuery.parseJSON(app_data);


jQuery(document).ready(function($) {

    let app_locale = app.app_locale;

    /**
     * Load District
     * Load the corresponding District based on the Division choice.
     * @return {mixed} Select field.
     * ---------------------------------------------------------------------
     */
    $('body').on('change', '#division', function() {
        let division_id = $(this).val();

        $.get(app.app_url + 'getDistrict/' + division_id, function (data) {
            let district_id = $('#district');
            if(district_id.length > 0) {
                //success data
                district_id.empty();
                district_id.append('<option value="">' + app.label_select + '</option>');

                $.each(data, function (index, subcatObj) {
                    district_id.append('<option value="' + subcatObj.id + '">' + (subcatObj[`name_${app_locale}`] ? subcatObj[`name_${app_locale}`] : subcatObj.name_en) + '</option>');
                });

                /**
                 * Trigger only for select2
                 */
                district_id.val('').trigger('change');
            }
        });
    });

    /**
     * Load Thana Upazila
     * Load the corresponding Thana Upazila based on the District choice.
     * @return {mixed} Select field.
     * ---------------------------------------------------------------------
     */
    $('body').on('change', '#district', function() {
        let district_id = $(this).val();

        $.get(app.app_url + 'getThanaUpazila/' + district_id, function (data) {
            let thana_upazila_id = $('#thana-upazila');
            if(thana_upazila_id.length > 0) {
                //success data
                thana_upazila_id.empty();
                thana_upazila_id.append('<option value="">' + app.label_select + '</option>');

                $.each(data, function (index, subcatObj) {
                    thana_upazila_id.append('<option value="' + subcatObj.id + '">' + (subcatObj[`name_${app_locale}`] ? subcatObj[`name_${app_locale}`] : subcatObj.name_en) + '</option>');
                });

                /**
                 * Trigger only for select2
                 */
                thana_upazila_id.val('').trigger('change');
            }
        });
    });

    /**
     * Load Union Ward
     * Load the corresponding Union Ward based on the Union Ward choice.
     * @return {mixed} Select field.
     * ---------------------------------------------------------------------
     */
    $('body').on('change', '#thana-upazila', function() {

        let thana_upazila_id = $(this).val();

        $.get(app.app_url + 'getUnionWard/' + thana_upazila_id, function (data) {
            let union_ward_id = $('#union-ward');
            if(union_ward_id.length > 0) {
                //success data
                union_ward_id.empty();
                union_ward_id.append('<option value="">' + app.label_select + '</option>');

                $.each(data, function (index, subcatObj) {
                    union_ward_id.append('<option value="' + subcatObj.id + '">' + (subcatObj[`name_${app_locale}`] ? subcatObj[`name_${app_locale}`] : subcatObj.name_en) + '</option>');
                });

                /**
                 * Trigger only for select2
                 */
                union_ward_id.val('').trigger('change');
            }
        });
    });

    /**
     * Load District For Repeater
     * Load the corresponding District based on the Division choice using Repeater.
     * @return {mixed} Select field.
     * ---------------------------------------------------------------------
     */
    $('body').on('change', '.repeater-division', function() {
        var this_item = $(this);
        let division_id = this_item.val();

        $.get(app.app_url + 'getDistrict/' + division_id, function (data) {
            let district_id = this_item.parents('.repeat-this').find('.repeater-district');
            if(district_id.length > 0) {
                //success data
                district_id.empty();
                district_id.append('<option value="">' + app.label_select + '</option>');

                $.each(data, function (index, subcatObj) {
                    district_id.append('<option value="' + subcatObj.id + '">' + (subcatObj[`name_${app_locale}`] ? subcatObj[`name_${app_locale}`] : subcatObj.name_en) + '</option>');
                });

                /**
                 * Trigger only for select2
                 */
                district_id.val('').trigger('change');
            }
        });
    });

    /**
     * Load Thana Upazila For Repeater
     * Load the corresponding Thana Upazila based on the District choice using Repeater.
     * @return {mixed} Select field.
     * ---------------------------------------------------------------------
     */
    $('body').on('change', '.repeater-district', function() {
        var this_item = $(this);
        let district_id = this_item.val();

        $.get(app.app_url + 'getThanaUpazila/' + district_id, function (data) {
            let thana_upazila_id = this_item.parents('.repeat-this').find('.repeater-thana-upazila');
            if(thana_upazila_id.length > 0) {
                //success data
                thana_upazila_id.empty();
                thana_upazila_id.append('<option value="">' + app.label_select + '</option>');

                $.each(data, function (index, subcatObj) {
                    thana_upazila_id.append('<option value="' + subcatObj.id + '">' + (subcatObj[`name_${app_locale}`] ? subcatObj[`name_${app_locale}`] : subcatObj.name_en) + '</option>');
                });

                /**
                 * Trigger only for select2
                 */
                thana_upazila_id.val('').trigger('change');
            }
        });
    });

    /**
     * Load Union Ward For Repeater
     * Load the corresponding Union Ward based on the Union Ward choice using Repeater.
     * @return {mixed} Select field.
     * ---------------------------------------------------------------------
     */
    $('body').on('change', '.repeater-thana-upazila', function() {
        var this_item = $(this);
        let thana_upazila_id = this_item.val();

        $.get(app.app_url + 'getUnionWard/' + thana_upazila_id, function (data) {
            let union_ward_id = this_item.parents('.repeat-this').find('.repeater-union-ward');
            if(union_ward_id.length > 0) {
                //success data
                union_ward_id.empty();
                union_ward_id.append('<option value="">' + app.label_select + '</option>');

                $.each(data, function (index, subcatObj) {
                    union_ward_id.append('<option value="' + subcatObj.id + '">' + (subcatObj[`name_${app_locale}`] ? subcatObj[`name_${app_locale}`] : subcatObj.name_en) + '</option>');
                });

                /**
                 * Trigger only for select2
                 */
                union_ward_id.val('').trigger('change');
            }
        });
    });

});
