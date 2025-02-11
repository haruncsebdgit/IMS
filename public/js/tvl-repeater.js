
    /**
     * Edit the Row.
     */
     function editRepeatingData(dataArray) {
        $('body').on('click', '.edit-repeater-row', function () {
            var thisBtn = $(this);
            var thisId = thisBtn.attr('data-id');

            var thisRow = thisBtn.closest('tr');

            $.each(dataArray, function (index, obj) {
                var td = thisRow.find('.td-' + obj.name);

                var hiddenField = td.find('[type="hidden"]');

                var fieldValue = hiddenField.val();

                td.find('.data-view').html('');

                var field;
                if ('textarea' === obj.input_type) {
                    field = '<textarea class="repeater-edit-field ' + obj.input_class + '" rows="2">' + fieldValue + '</textarea>';
                } else if ('text' === obj.input_type) {
                    field = '<input type="text" class="repeater-edit-field ' + obj.input_class + '" value="' + fieldValue + '"/>';
                } else if ('number' === obj.input_type) {
                    field = '<input type="text" class="repeater-edit-field ' + obj.input_class + '" value="' + fieldValue + '"/>';
                }

                td.append(field);
            });

            thisRow.find('.edit-repeater-row').hide();
            thisRow.find('.delete-repeater-row').hide();
            thisRow.find('.accept-repeater-row').removeClass('d-none');
            thisRow.find('.cancel-repeater-row').removeClass('d-none');
        });
    }

    /**
     * Accept the Row Change.
     */
    function acceptRepeaterDataEdit(dataArray) {
        $('body').on('click', '.accept-repeater-row', function () {
            var thisBtn = $(this);
            var thisId = thisBtn.attr('data-id');

            var thisRow = thisBtn.closest('tr');

            $.each(dataArray, function (index, obj) {
                var td = thisRow.find('.td-' + obj.name);

                var editField = td.find('.repeater-edit-field');

                var fieldValue = editField.val();

                var hiddenField = td.find('[type="hidden"]');

                editField.remove();
                hiddenField.val(fieldValue);
                td.find('.data-view').html(fieldValue);
            });

            thisRow.find('.accept-repeater-row').addClass('d-none');
            thisRow.find('.cancel-repeater-row').addClass('d-none');
            thisRow.find('.edit-repeater-row').show();
            thisRow.find('.delete-repeater-row').show();
        });
    }

    /**
     * Cancel the Row change.
     */
    function cancelRepeaterDataEdit(dataArray) {
        $('body').on('click', '.cancel-repeater-row', function () {
            var thisBtn = $(this);
            var thisId = thisBtn.attr('data-id');

            var thisRow = thisBtn.closest('tr');

            $.each(dataArray, function (index, obj) {
                var td = thisRow.find('.td-' + obj.name);

                var editField = td.find('.repeater-edit-field');

                var hiddenField = td.find('[type="hidden"]');

                // Grab the value from the hidden fields instead of the inputs.
                var fieldValue = hiddenField.val();

                editField.remove();
                td.find('.data-view').html(fieldValue);
            });

            thisRow.find('.accept-repeater-row').addClass('d-none');
            thisRow.find('.cancel-repeater-row').addClass('d-none');
            thisRow.find('.edit-repeater-row').show();
            thisRow.find('.delete-repeater-row').show();
        });
    }