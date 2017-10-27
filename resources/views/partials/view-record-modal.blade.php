<div class="modal fade" id="viewRecordModal" role="dialog" aria-hidden="true" style='display:none;'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<span class="modal-title">
					<i class="fa fa-plus-circle"></i> &nbsp;
					{{ $view_record_title }}
				</span>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="active" id="tab1li"><a href="#details_content" data-toggle="tab">Details</a></li>
                    <li id="tab2li"><a href="#history_content" data-toggle="tab">History</a></li>
                </ul>
                <div class="tab-content" id="view_record_content">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewFileModal" role="dialog" aria-hidden="true" style='display:none;'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
				<span class="modal-title">
					<i class="fa fa-plus-circle"></i> &nbsp;
                    View File
				</span>
            </div>
            <div class="modal-body" id="view_file_content">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>