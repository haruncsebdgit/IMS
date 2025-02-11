// ------------------------------------------
// Get the application data in JavaScript.
// Coming from admin.blade.php
// ------------------------------------------

let app = jQuery.parseJSON(app_data);

if(typeof c3 === 'object') {
    c3.generate({
        bindto: '#chart-public-contents',
        data: {
            columns: app.dash_contents,
            type: 'donut',
        },
        color: {
            pattern: [
                '#1f77b4', '#17becf', '#9edae5', '#aec7e8', '#2ca02c', '#98df8a', '#d62728', '#ff9896', '#9467bd', '#c5b0d5', '#8c564b', '#c49c94', '#e377c2', '#f7b6d2', '#7f7f7f', '#bcbd22', '#dbdb8d'
            ]
        },
        donut: {
            title: app.dash_total_label + " " + app.dash_total_count,
            label: {
                format: function (value, ratio, id) {
                    return d3.format('')(value);
                }
            }
        }
    });
}
