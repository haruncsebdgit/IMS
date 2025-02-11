// ------------------------------------------
// Get the application data in JavaScript.
// Coming from admin.blade.php
// ------------------------------------------

let app = jQuery.parseJSON(app_data);

/**
 * Class CMS
 *
 * All the methods specific to the CMS noted here.
 */
 class CMS
 {
    // Update User Meta Data.
    //
    // Using AJAX post method to store data in Database using
    // updateUserMeta() and deleteUserMeta() functions.
    // --------------------------------------------------
    static updateUserMeta(selector, forced_values = array())
    {
        // Values from data attributes.
        let _user_id    = selector.attr('data-user-id');
        let _meta_key   = selector.attr('data-key');
        let _meta_value = selector.attr('data-value');

        // Values from function parameters.
        let forced_user_id = forced_values.user_id;
        let forced_key     = forced_values.key;
        let forced_value   = forced_values.value;

        let id    = '';
        let key   = '';
        let value = '';

        if( typeof forced_values.user_id !== 'undefined' ) {
            id = forced_user_id;
        } else if( typeof _user_id !== 'undefined' && _user_id !== '' ) {
            id = _user_id;
        } else {
            console.error('User ID is not defined');
        }

        if( typeof forced_values.key !== 'undefined' ) {
            key = forced_key;
        } else if( typeof _meta_key !== 'undefined' && _meta_key !== '' ) {
            key = _meta_key;
        } else {
            console.error('Meta Key is not defined');
        }

        if( typeof forced_values.value !== 'undefined' ) {
            value = forced_value;
        } else if( typeof _meta_value !== 'undefined' && _meta_key !== '' ) {
            value = _meta_value;
        }

        let post_data = 'user_id=' + id + '&meta_key=' + key + '&meta_value=' + value;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            // TODO VistaCMS Framework Update Required
            url: app.app_url + 'users/meta/save',
            data: post_data
        }).done(function (msg) {
            if( 'updated' == msg ) {
                console.info('User meta data updated successfully!');
            } else if( 'deleted' == msg ) {
                console.warn('User meta data deleted successfully!');
            } else {
                console.error('There was an error updating User meta data');
            }
        });
    }
}

export default CMS;
