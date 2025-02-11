/**
 * Class CMSRepeater
 *
 * All the methods specific to the Repeater associated with the CMS.
 */

 class CMSRepeater
 {
    /**
	 * Function: DefaultFor
	 * @param  {string} arg Variable.
	 * @param  {mixed}  val Default value.
	 * @return {mixed}      The passed value or the default.
	 * ...
	 */
    static defaultFor(arg, val) {
        return typeof arg !== 'undefined' ? arg : val;
    }

    static repeat(element, data, initEmpty) {
        if (window.jQuery().repeater) {
            data      = this.defaultFor(data, []);
            initEmpty = this.defaultFor(initEmpty, false);

            var repeater_item = $(element).repeater({
                initEmpty: initEmpty,
                show: function () {
                    var this_elem = $(this);
                    this_elem.slideDown();

                    this_elem.find('.form-control[required]').prop('required', true);

                    if (window.jQuery().select2) {
                        this_elem.find('.form-control.enable-select2').select2();
                    }

                    if (window.jQuery().datepicker) {
                        this_elem.find('.datepicker').datepicker({
                            format: 'dd-mm-yyyy'
                        });
                    }

                    if (window.jQuery().datetimepicker) {
                        var picker_format = this_elem.find('.datetimepicker').data('picker-format');
                        picker_format = 'undefined' !== typeof picker_format ? picker_format : 'DD-MM-YYYY hh:mm A';
                        this_elem.find('.datetimepicker').datetimepicker({
                            format: picker_format,
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
                },
                hide: function (remove) {
                    var this_elem = $(this);
                    if (confirm('Are you sure, you want to delete the row?')) {
                        this_elem.slideUp(remove);
                    }
                }
            });

            // Set data on edit mode
            if (typeof data !== 'undefined' && !$.isEmptyObject(data)) {
                repeater_item.setList(data);
            }
        }
    };
}

export default CMSRepeater;
