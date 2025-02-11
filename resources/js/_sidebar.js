// ------------------------------------------
// Get the application data in JavaScript.
// Coming from admin.blade.php
// ------------------------------------------

let app = jQuery.parseJSON(app_data);

import CMS from "./_cms";

jQuery(document).ready(function($) {

    // ------------------------------------------
    // Make the Sidebar toggleable on Mobile viewports.
    // ------------------------------------------

    $('body').on('click', '.sidebar-toggle', function() {
        // Resolve sidebar toggle issue in mobile.
        if($('body').hasClass('sidebar-mini')) {
            $('body').removeClass('sidebar-mini');
        }
        $('.sidebar').slideToggle();
    });


    // ------------------------------------------
    // Sidebar Submenu toggle.
    // ------------------------------------------

    // Thanks to Limitless Admin Framework.
    // Define default class names and options.
    let navClass = 'sidebar';
    let navItemClass = 'nav-item';
    let navItemOpenClass = 'active';
    let navLinkClass = 'nav-link';
    let navSubmenuClass = 'submenu';
    let navSlidingSpeed = 250;

    // Configure collapsible functionality.
    $('.' + navClass).find('.' + navItemClass).has('.' + navSubmenuClass).children('.' + navItemClass + ' > ' + '.' + navLinkClass).not('.disabled').on('click', function (e) {
        e.preventDefault();

        let trigger = $(this);
        let navMini = $('.sidebar-mini').find('.' + navClass).find('.' + navItemClass);

        // Collapsible.
        if (trigger.parent('.' + navItemClass).hasClass(navItemOpenClass)) {
            trigger.parent('.' + navItemClass).not(navMini).removeClass(navItemOpenClass).children('.' + navSubmenuClass).slideUp(navSlidingSpeed);
        } else {
            trigger.parent('.' + navItemClass).not(navMini).addClass(navItemOpenClass).children('.' + navSubmenuClass).slideDown(navSlidingSpeed);
        }

        // Accordion: Close others when one is clicked.
        if ('accordion' === trigger.parents('.' + navClass).data('navtype')) {
            trigger.parent('.' + navItemClass).not(navMini).siblings(':has(.' + navSubmenuClass + ')').removeClass(navItemOpenClass).children('.' + navSubmenuClass).slideUp(navSlidingSpeed);
        }
    });


    // ------------------------------------------
    // Mini Sidebar
    // Toggle on click.
    // ------------------------------------------

    $('#toggle-sidebar-mini').on('click', function(e) {
        e.preventDefault();

        let body                = $('body');
        let toggle_sidebar_icon = $('.toggle-sidebar-icon');
        let toggle_label        = $(this).find('span');

        if( body.hasClass('sidebar-mini') ) {
            body.removeClass('sidebar-mini');
            toggle_sidebar_icon.removeClass('icon-circle-right2').addClass('icon-circle-left2');
            toggle_label.text(app.sidebar_collapse);

            CMS.updateUserMeta($(this), {key: '_sidebar_mini'}); // delete while value is empty
        } else {
            body.addClass('sidebar-mini');
            toggle_sidebar_icon.removeClass('icon-circle-left2').addClass('icon-circle-right2');
            toggle_label.text(app.sidebar_expand);

            CMS.updateUserMeta($(this), {key: '_sidebar_mini', value: true});
        }
    });

    // Revert Bottom Menus.
    // Flip 2nd level if menu overflows the bottom edge of browser window.
    // Thanks to Limitless Admin Framework.
    $('.sidebar-mini').find('ul.nav').children('.has-submenu').hover(function () {
        let totalHeight = 0;
        let thisListItem = $(this);
        let navSubmenuClass = 'submenu';
        let navSubmenuReversedClass = 'submenu-reversed';

        totalHeight += thisListItem.find('.' + navSubmenuClass).filter(':visible').outerHeight();
        if (thisListItem.children('.' + navSubmenuClass).length) {
            if ((thisListItem.children('.' + navSubmenuClass).offset().top + thisListItem.find('.' + navSubmenuClass).filter(':visible').outerHeight()) > document.body.clientHeight) {
                thisListItem.addClass(navSubmenuReversedClass)
            } else {
                thisListItem.removeClass(navSubmenuReversedClass)
            }
        }
    });
});
