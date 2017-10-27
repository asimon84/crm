$(document).ready(function () {
    $processing = false;

    //Initialize jquery selectors
    $body = $('body');
    $rangepicker = $('.rangepicker');

    //initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    //Initialize single date datepicker
    $('.datepicker').datepicker({
        "format": 'yyyy-mm-dd',
    });

    //Initialize date range picker
    $rangepicker.daterangepicker({
        "locale": {
            "format": 'YYYY-MM-DD'
        },
        // "showDropdowns": true,
        "showWeekNumbers": true,
        "ranges": {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        "linkedCalendars": false,
        "startDate": moment().subtract(6, 'days'),
        "endDate": moment(),
        "minDate": "2017-01-01",
        "maxDate": moment(),
        "opens": "left",
        "buttonClasses": "btn btn-md"
    });

    //When date range is change, refresh the tables
    $rangepicker.on('apply.daterangepicker', function (ev, picker) {
        refreshTables();
    });

    $body.on('click', '#logout_button', function (e) {
        $('#logout_form').submit();
    });
});

function convertToOptions (rows) {
    var output = '<option value="">Please Select</option>';
    rows       = rows.split(',');

    for (i = 0; i < rows.length; i++) {
        output += '<option value="' + i + '">' + rows[i] + '</option>';
    }

    return output;
}



