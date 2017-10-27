@extends('layouts.portal')

@section('css')
    <link href="{{ asset('vendor/datatables/datatables/media/css/dataTables.bootstrap.css') }}" rel="stylesheet">

    <link href="{{ asset('vendor/pnikolov/bootstrap-daterangepicker/css/daterangepicker.min.css') }}" rel="stylesheet">

    <link href="{{ asset('public/css/global.css') }}" rel="stylesheet">

    <link href="{{ asset('public/css/products-admin.css') }}" rel="stylesheet">

    <link href="{{ asset('bower_components/bootstrap-wysiwyg/index.css') }}" rel="stylesheet">
@endsection



@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Products Admin</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Product Management
                        <div class="component-options">
                            <div class="field-group">

                            </div>
                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-functions">
                            <div class="btns-left">
                                @if (in_array('add_products', $permissions))
                                    <button class="btn btn-success" data-toggle="modal" data-target="#addRecordModal"
                                            id="add_record_button"><span class="fa fa-plus"></span> {{ $add_record_title  }}
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="tab-block mb15 mt15">
                            <br/>
                            <ul class="nav nav-tabs">
                                <li class="active" id="tab1li"><a href="#tab1" id="tab1lia" data-toggle="tab">Clients</a></li>
                                <li id="tab2li"><a href="#tab2" id="tab2lia" data-toggle="tab">Products</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab1" class="tab-pane active">
                                    <div class="table-functions">
                                        <div class="btns-left">
                                            &nbsp;
                                        </div>
                                        <div class="btns-right">
                                            <a href="#tab2" data-toggle="tab" class="btn btn-success margin10" id="view_all_button"><span
                                                        class="fa fa-eye"></span> View All Products
                                            </a>
                                        </div>
                                    </div>

                                    <table width="100%" class="table table-striped table-bordered table-hover" id="clientsTable">
                                        <thead>
                                        <tr>
                                            <th>Client ID</th>
                                            <th>Client Name</th>
                                            <th>Products</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <!-- /.table-responsive -->
                                </div>
                                <div id="tab2" class="tab-pane">
                                    <div class="table-functions">
                                        <div class="btns-left">

                                        </div>
                                        <div class="btns-right">
                                            @if (in_array('download_products', $permissions))
                                                <button class="btn btn-success margin10" data-toggle="modal" data-target="#downloadProducts"><span
                                                            class="fa fa-download"></span> Download Products
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="productsTable">
                                        <thead>
                                        <tr>
                                            <th>Product ID</th>
                                            <th>Client Name</th>
                                            <th>Product Name</th>
                                            <th>Product Type</th>
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

    @include('partials.html-editor-modal', [])

    @if( isset($response['message']) )
        @include('partials.response-modal', array('response' => $response['message']))
    @endif

    <input type="hidden" id="viewed_client" name="viewed_client" value=""/>

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

    <!-- WYSIWYG HTML Editor -->
    <script src="{{ asset('bower_components/bootstrap-wysiwyg/external/jquery.hotkeys.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap-wysiwyg/external/google-code-prettify/prettify.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap-wysiwyg/bootstrap-wysiwyg.js') }}"></script>

    <!-- Custom JavaScript -->
    <script language="javascript">
        var module = '{{ $module }}';
    </script>

    <!-- Page Specific JavaScript -->
    <script src="{{ asset('public/js/products-admin.js') }}"></script>
    <script src="{{ asset('public/js/view-record.js') }}"></script>
    <script src="{{ asset('public/js/add-record.js') }}"></script>
    <script src="{{ asset('public/js/edit-record.js') }}"></script>
    <script src="{{ asset('public/js/delete-record.js') }}"></script>
    <script src="{{ asset('public/js/upload-csv.js') }}"></script>
    <script src="{{ asset('public/js/html-editor.js') }}"></script>

    @if( isset($response['message']) )
        <!-- Response Modal -->
        <script language="javascript">
            $(document).ready(function () {
                $('#responseModal').modal('show');
            });
        </script>
    @endif
@endsection