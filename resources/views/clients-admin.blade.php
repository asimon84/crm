@extends('layouts.portal')

@section('css')
    <link href="{{ asset('vendor/datatables/datatables/media/css/dataTables.bootstrap.css') }}" rel="stylesheet">

    <link href="{{ asset('vendor/pnikolov/bootstrap-daterangepicker/css/daterangepicker.min.css') }}" rel="stylesheet">

    <link href="{{ asset('public/css/global.css') }}" rel="stylesheet">

    <link href="{{ asset('public/css/clients-admin.css') }}" rel="stylesheet">
@endsection



@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Clients Admin</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Client Management
                        <div class="component-options">
                            <div class="field-group">

                            </div>
                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-functions">
                            <div class="btns-left">
                                @if (in_array('add_clients', $permissions))
                                    <button class="btn btn-primary" data-toggle="modal"
                                            data-target="#uploadModal"
                                            id="upload_button"><span class="fa fa-upload"></span> {{ $upload_csv_title  }}
                                    </button>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#addRecordModal"
                                            id="add_record_button"><span class="fa fa-plus"></span> {{ $add_record_title  }}
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="table-functions">
                            <div class="btns-left">

                            </div>
                            <div class="btns-right">

                            </div>
                        </div>
                        <table width="100%" class="table table-striped table-bordered table-hover" id="clientsTable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Client Name</th>
                                <th>Contact</th>
                                <th>Contact Phone</th>
                                <th>Contact Email</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.view-record-modal', [
            'module' => $module,
            'view_record_title' => $view_record_title,
        ]
    )

    @include('partials.add-record-modal', [
            'module' => $module,
            'record_fields' => $record_fields,
            'add_record_title' => $add_record_title,
        ]
    )

    @include('partials.edit-record-modal', [
            'module' => $module,
            'editable_fields' => $editable_fields,
            'edit_record_title' => $edit_record_title,
        ]
    )

    @include('partials.upload-csv-modal', [
            'module' => $module,
            'record_fields' => $record_fields,
            'upload_csv_title' => $upload_csv_title,
        ]
    )

    @include('partials.format-mapping-modals', [
            'module' => $module,
            'record_fields' => $record_fields,
            'formats' => $formats,
        ]
    )

    @if( isset($response['message']) )
        @include('partials.response-modal', ['response' => $response['message']])
    @endif

    {{ csrf_field() }}
@endsection



@section('js')
            <!-- DataTables JavaScript -->
    <script src="{{ asset('vendor/datatables/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/datatables/media/js/dataTables.bootstrap.min.js') }}"></script>

    <!-- Datepicker JavaScript -->
    <script src="{{ asset('vendor/moment/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/pnikolov/bootstrap-daterangepicker/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/eternicode/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>

    <!-- Custom JavaScript -->
    <script language="javascript">
        var module = '{{ $module }}';
    </script>

    <!-- Page Specific JavaScript -->
    <script src="{{ asset('public/js/clients-admin.js') }}"></script>
    <script src="{{ asset('public/js/view-record.js') }}"></script>
    <script src="{{ asset('public/js/add-record.js') }}"></script>
    <script src="{{ asset('public/js/edit-record.js') }}"></script>
    <script src="{{ asset('public/js/delete-record.js') }}"></script>
    <script src="{{ asset('public/js/upload-csv.js') }}"></script>

    @if( isset($response['message']) )
        <!-- Response Modal -->
        <script language="javascript">
            $(document).ready(function () {
                $('#responseModal').modal('show');
            });
        </script>
    @endif
@endsection