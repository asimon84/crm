$(document).ready(function () {
    //initialize tables
    $clientsTable = false; //clients table
    $midsTable = false; //clients table

    $body.on('click', '#view_client_button', function () {
        var client_id = $(this).data('client_id');

        if( client_id != $('#viewed_client').val() )
        {
            $midsTable.state.clear();
            $('#viewed_client').val(client_id);
        }

        $('#tab1li').removeClass('active');
        $('#tab2li').addClass('active');

        loadMIDsTable({});
    });

    $body.on('click', '#view_all_button', function () {
        $midsTable.state.clear();

        $('#viewed_client').val('');

        $('#tab1li').removeClass('active');
        $('#tab2li').addClass('active');

        loadMIDsTable({});
    });

    //Initial table load
    refreshTables();
});

function refreshTables () {
    loadClientsTable();
    loadMIDsTable();
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
                url: "mids/clients",
                type: "POST",
                data: function (d) {
                    d._token = $('[name="_token"]').val();
                }
            },
            columnDefs: [
                {sortable: false, targets: [-1, -2, -3]},
                {orderable: false, targets: [-1, -2, -3]},
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

function loadMIDsTable () {
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

    if ($('#midsTable').find('tbody tr').length != 0) {
        $midsTable.ajax.reload(function () {
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
                url: "mids/mids",
                type: "POST",
                data: function (d) {
                    d._token = $('[name="_token"]').val();
                    d.client_id = $('#viewed_client').val();
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

        $midsTable = $('#midsTable').DataTable($.extend(dtSettings, $dataTablesConfig, $serverSideConfig));

        // Add Placeholder text to datatables filter bar
        $('.dataTables_filter input').attr("placeholder", "Search For...");
    }
}
