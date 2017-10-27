<div class="modal fade" id="loadFormatModal" role="dialog" aria-hidden="true" style='display:none;'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<span class="modal-title">
					<i class="fa fa-plus-circle"></i> &nbsp;
					Load Format
				</span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="modal_entry">
                        <label class="col-md-3 text-right">Format: </label>
                        <div class="col-md-8">
                            <select class="form-control select2" id="load_format_dropdown" name="load_format_dropdown">
                                <option value="">Please Select</option>
                                @foreach ($formats as $format)
                                    <option value="{{ $format['id'] }}">{{ $format['format_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="modal_entry">
                        <div class="col-md-12" id="load_format_data">

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
                                                <select class="form-control key-dropdown {{ $field['required'] ? 'required' : '' }}" id="load_{{ $field['name'] }}_key"
                                                        name="load_{{ $field['name'] }}_key" disabled>
                                                </select>
                                            </td>
                                            <td class="example" id="load_{{ $field['name'] }}_example">&nbsp;</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="apply_loaded_format"><i class="fa fa-arrow-right"></i>
                    Load
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="saveFormatModal" role="dialog" aria-hidden="true" style='display:none;'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<span class="modal-title">
					<i class="fa fa-plus-circle"></i> &nbsp;
					Save Format
				</span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="modal_entry">
                        <label class="col-md-3 text-right">Format Name: </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="format_name" name="format_name"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="apply_save_format"><i class="fa fa-arrow-right"></i>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>