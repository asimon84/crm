<div class="modal fade" id="responseModal" role="dialog" aria-hidden="true" style='display:none;'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <span class="modal-title">
                        <i class="fa fa-bell"></i>&nbsp;
                        Response
                    </span>
            </div>
            <div class="modal-body">

                @if( isset($response) )
                    @foreach (explode('<br/>', $response) as $message)
                        <div class="row">
                            <div class="modal_entry">
                                <div class="col-md-12">
                                    {{ $message }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>