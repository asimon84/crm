@extends('layouts.portal')

@section('css')
    <link href="{{ asset('vendor/datatables/datatables/media/css/dataTables.bootstrap.css') }}" rel="stylesheet">

    <link href="{{ asset('vendor/pnikolov/bootstrap-daterangepicker/css/daterangepicker.min.css') }}" rel="stylesheet">

    <link href="{{ asset('public/css/global.css') }}" rel="stylesheet">

    <link href="{{ asset('public/css/dashboard.css') }}" rel="stylesheet">

    <link href="{{ asset('bower_components/c3/c3.css') }}" rel="stylesheet">
@endsection



@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Overview
                        <div class="component-options">
                            <div class="field-group">
                                <input type="text" class="form-control rangepicker mtn" id="daterange"
                                       name="daterange"/>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="flot-chart">
                            <div class="flot-chart-content" id="overview-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
    </div>

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

    <!-- Load d3.js and c3.js -->
    <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <script src="{{ asset('bower_components/c3/c3.min.js') }}"></script>

    <!-- Page Specific JavaScript -->
    <script src="{{ asset('public/js/dashboard-admin.js') }}"></script>
@endsection
