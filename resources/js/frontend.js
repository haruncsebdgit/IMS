let app = JSON.parse(app_data);

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
jQuery(function($) {

    // ----------------------------
    // JavaScripts loaded
    // ----------------------------
    $('html').removeClass('no-js').addClass('js');

    // ----------------------------
    // jQuery CountTo
    // ----------------------------
    if (window.jQuery().countTo) {
        $('.counter').countTo();
    }

    // ----------------------------
    // Bootstrap Tooltip
    // ----------------------------
    $('[data-toggle="tooltip"]').tooltip();

    // ----------------------------
    // Automatic Submit the Filter form on change.
    // ----------------------------
    $('.js-filter-fy-column').removeClass('col-sm-9 col-lg-3 mb-3 mb-lg-0').addClass('col-sm-12 col-lg-4');
    $('.js-filter-btn-column').removeClass('col-sm-3 col-lg-1').addClass('d-none');
    $('#division, #district, #upazila, #union, #financial-year').on('change', function() {
        $('#filter-form').trigger('submit');
    });

    // ----------------------------
    // Show Bootstrap Spinner on 'Filter' button click.
    // ----------------------------
    /* $('#filter-form').on('submit', function() {
        let btn_filter = $('.btn-filter');

        // Change tooltip text.
        btn_filter
            .tooltip('hide')
            .attr('title', app.filter_loading)
            .attr('data-original-title', app.filter_loading)
            .tooltip('show');

        // Make the button disabled.
        btn_filter.addClass('disabled').prop('disabled', true);

        // Change the icon to loading...
        btn_filter.find('.js-filter-icon')
            .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

        // Change the text to loading...
        btn_filter.find('.js-filter-text')
            .text(app.filter_loading);
    }); */

});
