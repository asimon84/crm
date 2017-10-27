<form id='uploadCSVForm' action='{{ $module  }}/uploadCSV' method='post' enctype='multipart/form-data'>
    <div class="modal fade" id="uploadModal" role="dialog" aria-hidden="true" style='display:none;'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
					<span class="modal-title">
						<i class="fa fa-plus-circle"></i> &nbsp;
                        {{ $upload_csv_title  }}
					</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="modal_entry" style="">
                            <label class="col-md-3 text-right">Strip Headers: </label>
                            <div class="col-md-8">
                                <input type="checkbox" id="strip_headers" name="strip_headers" checked/>
                                    <span class="fa fa-question-circle" id="strip_headers_help" data-toggle="tooltip"
                                          data-placement="right"
                                          data-original-title="Check this if you do NOT want the first row of the CSV inserted into the database."><i></i></span>
                            </div>

                            <br/><br/>
                        </div>

                        <div class="modal_entry">
                            <label class="col-md-3 text-right">Select File: </label>
                            <div class="col-md-8">
                                <input type="file" class="btn btn-default" id="fileToUpload" name="fileToUpload"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save_upload_file"><i
                                class="fa fa-arrow-right"></i> Map Columns
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mapModal" role="dialog" aria-hidden="true" style='display:none;'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
					<span class="modal-title">
						<i class="fa fa-plus-circle"></i> &nbsp;
						Map Columns
					</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div id="format_buttons">
                            <button type="button" class="btn btn-success" id="load_format"><i class="fa fa-upload"></i>
                                Load Format
                            </button>
                            <button type="button" class="btn btn-success" id="save_format"><i
                                        class="fa fa-download"></i> Save Format
                            </button>
                        </div>
                    </div>
                    <div class="row">

                        <table class="table table-striped table-bordered table-hover column_mapper scrollHeader">
                            <thead>
                            <tr>
                                <th>Table Column</th>
                                <th>CSV Header</th>
                                <th>CSV Example</th>
                            </tr>
                            </thead>
                        </table>

                        <div class="scrollTable">
                            <table class="table table-striped table-bordered table-hover column_mapper">
                                <tbody>
                                @foreach($record_fields as $field)
                                    <tr id="{{ $field['name'] }}_row">
                                        <td>{{ $field['label'] }}</td>
                                        <td>
                                            <select class="form-control key-dropdown {{ $field['required'] ? 'required' : '' }}" id="{{ $field['name'] }}_key" name="{{ $field['name'] }}_key">
                                            </select>
                                        </td>
                                        <td class="example" id="{{ $field['name'] }}_example">&nbsp;</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div style="display:none;" id="sample_data">
                            &nbsp;
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save_mapped_file"><i
                                class="fa fa-arrow-right"></i> {{ $upload_csv_title  }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>