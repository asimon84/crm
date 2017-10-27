$(document).ready(function() {
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
        "startDate": moment().subtract(30, 'days'),
        "endDate": moment(),
        "minDate": "2017-01-01",
        "maxDate": moment(),
        "opens": "left",
        "buttonClasses": "btn btn-md"
    });

    //When date range is change, refresh the tables
    $rangepicker.on('apply.daterangepicker', function (ev, picker) {
        refreshCharts();
    });

    refreshCharts();
});

function refreshCharts() {
    plotOverviewChart();
}

function plotOverviewChart() {
    $.ajax({
        method: "POST",
        url: "dashboard/getOverviewChartData",
        data: {
            _token: $('[name="_token"]').val(),
            start_date: $('.rangepicker').data('daterangepicker').startDate.format('YYYY-MM-DD'),
            end_date: $('.rangepicker').data('daterangepicker').endDate.format('YYYY-MM-DD')
        },
    })
    .success(function(result) {
        result = JSON.parse(result);

        c3.generate({
            bindto: '#overview-chart',
            data: {
                x: 'x',
                columns: result.data
            },
            axis: {
                x: {
                    type: 'timeseries',
                    tick: {
                        format: '%Y-%m-%d'
                    }
                }
            }
        });
    })
    .fail(function() {
        alert( 'Error loading overview chart!  Please refresh and try again.' );
    });
}
