/**
 * ------------------------------------------------------------
 * Admin end
 * ------------------------------------------------------------
 *
 * JavaScripts specific to the admin end of the Application.
 *
 * Get the compiled file under:
 * public/js/admin.js
 * ------------------------------------------------------------
 */

// ------------------------------------------
// Get the application data in JavaScript.
// Coming from admin.blade.php
// ------------------------------------------

let app = JSON.parse(app_data);

import "./_bootstrap-form-validation";
import "./_sidebar";
import "./_dashboard";
import "./_application-locations";
import "./_application";
import bsCustomFileInput from 'bs-custom-file-input';
import "./_user-tweaks";
// import * as cookies from './_cookie.js';


jQuery(function ($) {

    $('html').removeClass('no-js').addClass('js');


	// ----------------------------
	// PLUGIN INITIATIONS
	// ----------------------------
	bsCustomFileInput.init();

    // ----------------------------
    // Pass the CSRF Token for AJAX.
    // ----------------------------
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ------------------------------------------
    // Select2
    // ------------------------------------------

    if (window.jQuery().select2) {
        let select2_elem = $('.enable-select2');
        if (select2_elem.length > 0) {
            select2_elem.select2();
        }
    }


    // ------------------------------------------
    // Tooltip
    // using: Bootstrap tooltip
    // ------------------------------------------

    if (window.jQuery().tooltip) {
        $('[data-toggle="tooltip"]').tooltip();
    }

    // ------------------------------------------
    // Grid Pagination.
    // Set items per page to the URL.
    // ------------------------------------------

    let items_per_page = $('#items-per-page');
    if (items_per_page.length > 0) {
        items_per_page.on('change', function() {
            if (history.pushState) {
                let params = new URLSearchParams(window.location.search);

                // Set items per page to the URL.
                params.set('ipp', $(this).val());

                // Remove 'page' parameter [to deactivate pagination] as it displays no result found in increased items per page.
                params.delete('page');

                // Build the new URL.
                let newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + params.toString();
                window.history.pushState({ path: newUrl }, '', newUrl);

                // Redirect to the new URL.
                window.location.href = newUrl;
            }
        });
    }


    // ------------------------------------------
    // DatePicker
    // ------------------------------------------
    if (window.jQuery().datepicker) {
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy'
        });
        // $('.datepicker-trigger').on('click', function() {
            //     $(this).parents('.input-group').find('.form-control').datepicker({
                //         format: 'dd-mm-yyyy'
                //     });
                // });
                $('.monthpicker').datepicker({
                    format: 'mm'
                });
                $('.monthyearpicker').datepicker({
            format: 'mm-yyyy'
        });
        $('.yearpicker').datepicker({
            format: 'yyyy'
        });
    }

    // ------------------------------------------
    // DateTimePicker
    // using: Bootstrap DateTimePicker
    // @link https://github.com/technovistalimited/bootstrap4-datetimepicker
    // ------------------------------------------
    if (window.jQuery().datetimepicker) {
        $('.datetimepicker').datetimepicker({
            format: 'DD-MM-YYYY hh:mm A',
            icons: {
                time: 'icon-alarm',
                date: 'icon-calendar2',
                up: 'icon-chevron-up',
                down: 'icon-chevron-down',
                previous: 'icon-chevron-left',
                next: 'icon-chevron-right',
                today: 'icon-alarm-check',
                clear: 'icon-trash-alt',
                close: 'icon-cross3'
            }
        });
    }


    // ----------------------------
    // ROLES: CHANGE URL BASED ON SELECTION
    // ----------------------------

    if ($('body').hasClass('roles')) {

        $('[name="role"]').on('change', function () {
            let parameter = $(this).val();
            let baseUrl = window.location.href;
            let withoutLastChunk = baseUrl.slice(0, baseUrl.lastIndexOf("roles"));
            window.location.href = withoutLastChunk + 'roles/' + parameter;
        });
    }

    // ----------------------------
    // COMMON SETUPS: CHANGE URL BASED ON SELECTION
    // ----------------------------

    if ($('body').hasClass('common-setups')) {

        $('[name="data_type"]').on('change', function () {
            let parameter = $(this).val();
            let baseUrl = window.location.href;
            let withoutLastChunk = baseUrl.slice(0, baseUrl.lastIndexOf("setups"));
            window.location.href = withoutLastChunk + 'setups/' + parameter;
        });
    }

    // ----------------------------
    // CHANGE USER PASSWORD FIELDS TOGGLER
    // ----------------------------

    let change_password_btn = $('#change-password');
    let user_password_block = $('.user-password-block');

    change_password_btn.on('click', function () {
        change_password_btn.hide();
        user_password_block.show();
        user_password_block.find('#password').focus();
    });


    let capabilities_table = $('.table-capabilities');

    if (capabilities_table.length > 0) {

        // ----------------------------
        // USER CAPABILITIES CHECK/UNCHECK ALL
        // ----------------------------

        $('#check-all').on('click', function () {
            $('.caps-checkboxes').prop('checked', true);
        });

        $('#uncheck-all').on('click', function () {
            $('.caps-checkboxes').prop('checked', false);
        });

    }


    // ----------------------------
    // ACTIVATE TAB ON URL HASH.
    // @author dubbe
    // @link   https://stackoverflow.com/a/9393768/1743124
    // ----------------------------

    let options_page = $('body.settings');
    if (options_page.length > 0) {
        let url = document.location.toString();
        let prefix = 'tab_';

        // Set the tab active, that has the has in the URL.
        if (url.match('#')) {
            let tab = url.split('#')[1].replace(prefix, '');
            $('.nav-tabs a[href="#' + tab + '"]').tab('show');
        }

        // Set currently active tab info on URL as a Hash.
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            window.location.hash = e.target.hash.replace('#', '#' + prefix);
        });
    }


    // ----------------------------
    // EMPTY FORM (apart from RESET)
    // ----------------------------

    // Clear and Reload Page from within the form.
    $('body').on('click', '.btn-clear-filter', function () {
        let this_form = $(this).parents('form');
        this_form.find('.form-control').val('').attr('value', '').trigger('change');
        this_form.find('.custom-select').val('').trigger('change');

        // Load the page without parameters.
        window.location.href = window.location.href.split('?')[0];
    });

    // Clear and Reload Page from outside the form.
    $('body').on('click', '.btn-clear-filter-outside', function (event) {
        event.preventDefault();
        let this_form = $(this).closest('form');
        this_form.find('.form-control').val('').attr('value', '').trigger('change');
        this_form.find('.custom-select').val('').trigger('change');

        // Load the page without parameters.
        window.location.href = window.location.href.split('?')[0];
    });

    // Clear but DON'T RELOAD Page.
    $('body').on('click', '.btn-clear-filter-no-reload', function () {
        let this_form = $(this).parents('form');
        this_form.find('.form-control').val('').attr('value', '').trigger('change');
        this_form.find('.custom-select').val('').trigger('change');

        // hard coded for report checkbox buttons for columns.
        this_form.find('.btn-checkbox').addClass('active');
    });


    // ----------------------------
    // RESET FORM (apart from empty)
    // Only for Select2
    // ----------------------------

    $('body').on('click', 'button[type="reset"]', function () {
        $(this).parents('form').find('.enable-select2').trigger('change');
    });

    // ----------------------------
    // Submit Report form on 'Enter' keyup.
    // ----------------------------

    // Execute when the user releases a key on the keyboard
    var report_btn = $('.btn-sm.report-trigger');
    if (report_btn.length > 0) {
        document.addEventListener('keyup', function (event) {
            // Number 13 is the "Enter" key on the keyboard.
            if (13 === event.keyCode) {
                // Submit the report filtering form.
                report_btn.click();
            }
        });
    }


    /**
     * Match the Heights.
     * using jQuery MatchHeight library.
     * -------------------------------------------------
     */
    if (window.jQuery().matchHeight) {
        var matchHeightElem = $('.match-height');
        if (matchHeightElem.length > 0) {
            matchHeightElem.matchHeight();
        }
    }

});





