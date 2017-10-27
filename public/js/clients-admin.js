$(document).ready(function () {
    //initialize tables
    $clientsTable = false; //clients table

    $body.on('click', '#view_client_button', function () {
        $('.highlighted_row').removeClass('highlighted_row');

        var elem = $(this);

        elem.parent('td').parent('tr').addClass('highlighted_row');

        $.ajax({
            method: "POST",
            url: "clients/viewClient",
            data: {
                _token : $('[name="_token"]').val(),
                id : elem.data('client_id')
            },
        })
        .done(function(result) {
            result = $.parseJSON( result );

            $('#view_content').html(result.client_output);
            $('#services_content').html(result.services_output);

            $('#viewModal').modal('show');
        })
        .fail(function() {
            alert( 'Error! Unable to view this client. Please refresh and try again.' );
        });
    });

    $body.on('click', '.service_checkbox', function (e) {
        $.ajax({
            method: "POST",
            url: "clients/toggleServices",
            data: {
                _token : $('[name="_token"]').val(),
                client_id : $(this).data('client_id'),
                service_id : $(this).data('service_id'),
                active: $(this).is(':checked')
            }
        })
        .done(function(result) {
            //result = $.parseJSON( result );

            refreshTables();
        })
        .fail(function() {
            alert( 'Error! Unable to update this client\'s service. Please refresh and try again.' );
        });
    });

    //Initial table load
    refreshTables();
});

function refreshTables () {
    loadClientsTable();
}

function loadClientsTable () {
    //loading('start');

    $dataTablesConfig = {
        colReorder: {
            reorderCallback: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
        },
        dom: '<"panel-menu dt-panelmenu"fr>B<"clearfix">t<"row"<"col-sm-5"i><"col-sm-7"p>><"row"<"col-sm-12"l>>',
        aLengthMenu: [
            [
                5,
                10,
                25,
                50,
                -1
            ],
            [
                5,
                10,
                25,
                50,
                "All"
            ]
        ],
        iDisplayLength: 25,
        pagingType: "simple_numbers",
        drawCallback: function (settings) {
            $('[data-toggle="tooltip"]').tooltip();
            //loading();
        }
    };

    $serverSideConfig = {
        serverSide: true,
        processing: true,
        searchDelay: 2000,
    };

    if ($('#clientsTable').find('tbody tr').length != 0) {
        $clientsTable.ajax.reload(function () {
            //loading();
        }, false );
    }
    else {
        var dtSettings = {
            sDom: 'T<"panel-menu dt-panelmenu"lfr><"clearfix">tip',
            aLengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            oLanguage: {oPaginate: {sPrevious: "", sNext: ""}},
            bAutoWidth : false,
            bProcessing : true,
            bServerSide : true,
            ajax: {
                url: "clients/clients",
                type: "POST",
                data: function (d) {
                    d._token = $('[name="_token"]').val();
                }
            },
            columnDefs: [
                {sortable: false, targets: [-1]},
                {orderable: false, targets: [-1]},
                {responsivePriority: 1, targets: -1}
            ],
        };
        dtSettings.fnDrawCallback = function (oSettings, iStart, iEnd, iMax, iTotal) {
            $('[data-toggle="tooltip"]').tooltip();
            //loading();
        };

        $clientsTable = $('#clientsTable').DataTable($.extend(dtSettings, $dataTablesConfig, $serverSideConfig));

        // Add Placeholder text to datatables filter bar
        $('.dataTables_filter input').attr("placeholder", "Search For...");
    }
}


