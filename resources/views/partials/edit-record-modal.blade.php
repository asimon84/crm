<?php
    $record_count = count($editable_fields);
    $large = 0;
    $modal_class = '';
    $modal_entry_class = '';
    if($record_count >= 10) {
        $large = 1;
        $modal_class = 'modal-lg';
        $modal_entry_class = 'col-md-6';
    }
?>
<div class="modal fade" id="editRecordModal" role="dialog" aria-hidden="true" style='display:none;'>
    <div class="modal-dialog {{ $modal_class }}">
        <div class="modal-content">
            <div class="modal-header">
				<span class="modal-title">
					<i class="fa fa-plus-circle"></i> &nbsp;
                    {{ $edit_record_title }}
				</span>
            </div>
            <form id="edit_record_form" action="{{ $module }}/editRecord" method="post" enctype="multipart/form-data">
                <input type="hidden" id="edit_record_id" name="edit_record_id" value=""/>
                <div class="modal-body admin-modal-body">
                    <div class="row">
                        @for ($i = 0; $i < $record_count; $i++)
                            @if($large)
                                @if($i % 2 == 0)
                                    <div class="col-md-12 text-right">
                                @endif
                            @else
                                <div class="col-md-12 text-right">
                            @endif

                            @if($editable_fields[$i]['name'] == 'client_id')
                                <div class="modal_entry {{ $modal_entry_class }}">
                                    <label class="col-md-4 text-right">{{ $editable_fields[$i]['label'] }}: </label>
                                    <div class="col-md-8 text-left">
                                        <select class="form-control select2 {{ $editable_fields[$i]['required'] ? 'required' : '' }}" id="{{ $editable_fields[$i]['name'] }}" name="{{ $editable_fields[$i]['name'] }}">
                                            <option value="">Please Select</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client['id'] }}">{{ $client['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br/><br/>
                                </div>
                            @elseif($editable_fields[$i]['name'] == 'product_type_id')
                                <div class="modal_entry {{ $modal_entry_class }}">
                                    <label class="col-md-4 text-right">{{ $editable_fields[$i]['label'] }}: </label>
                                    <div class="col-md-8 text-left">
                                        <select class="form-control select2 {{ $editable_fields[$i]['required'] ? 'required' : '' }}" id="{{ $editable_fields[$i]['name'] }}" name="{{ $editable_fields[$i]['name'] }}">
                                            <option value="">Please Select</option>
                                            @foreach ($product_types as $product_type)
                                                <option value="{{ $product_type['id'] }}">{{ $product_type['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br/><br/>
                                </div>
                            @elseif ($editable_fields[$i]['name'] == 'source_id')
                                <div class="modal_entry {{ $modal_entry_class }}">
                                    <label class="col-md-4 text-right">{{ $editable_fields[$i]['label'] }}: </label>
                                    <div class="col-md-8 text-left">
                                        <select class="form-control select2 {{ $editable_fields[$i]['required'] ? 'required' : '' }}" id="{{ $editable_fields[$i]['name'] }}" name="{{ $editable_fields[$i]['name'] }}">
                                            <option value="">Please Select</option>
                                            @foreach ($sources as $source)
                                                <option value="{{ $source['id'] }}">{{ $source['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br/><br/>
                                </div>
                            @elseif ($editable_fields[$i]['name'] == 'card_association_id')
                                <div class="modal_entry {{ $modal_entry_class }}">
                                    <label class="col-md-4 text-right">{{ $editable_fields[$i]['label'] }}: </label>
                                    <div class="col-md-8 text-left">
                                        <select class="form-control select2 {{ $editable_fields[$i]['required'] ? 'required' : '' }}" id="{{ $editable_fields[$i]['name'] }}" name="{{ $editable_fields[$i]['name'] }}">
                                            <option value="">Please Select</option>
                                            @foreach ($card_associations as $card_association)
                                                <option value="{{ $card_association['id'] }}">{{ $card_association['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br/><br/>
                                </div>
                            @elseif($editable_fields[$i]['name'] == 'product_id')
                                <div class="modal_entry {{ $modal_entry_class }}">
                                    <label class="col-md-4 text-right">{{ $editable_fields[$i]['label'] }}: </label>
                                    <div class="col-md-8 text-left">
                                        <select class="form-control select2 {{ $editable_fields[$i]['required'] ? 'required' : '' }}" id="{{ $editable_fields[$i]['name'] }}" name="{{ $editable_fields[$i]['name'] }}">
                                            <option value="">Please Select</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product['id'] }}">{{ $product['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br/><br/>
                                </div>
                            @elseif ($editable_fields[$i]['name'] == 'mid_id')
                                <div class="modal_entry {{ $modal_entry_class }}">
                                    <label class="col-md-4 text-right">{{ $editable_fields[$i]['label'] }}: </label>
                                    <div class="col-md-8 text-left">
                                        <select class="form-control select2 {{ $editable_fields[$i]['required'] ? 'required' : '' }}" id="{{ $editable_fields[$i]['name'] }}" name="{{ $editable_fields[$i]['name'] }}">
                                            <option value="">Please Select</option>
                                            @foreach ($mids as $mid)
                                                <option value="{{ $mid['id'] }}">{{ $mid['mid'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br/><br/>
                                </div>
                            @elseif ($editable_fields[$i]['name'] == 'currency_id')
                                <div class="modal_entry {{ $modal_entry_class }}">
                                    <label class="col-md-4 text-right">{{ $editable_fields[$i]['label'] }}: </label>
                                    <div class="col-md-8 text-left">
                                        <select class="form-control select2 {{ $editable_fields[$i]['required'] ? 'required' : '' }}" id="{{ $editable_fields[$i]['name'] }}" name="{{ $editable_fields[$i]['name'] }}">
                                            <option value="">Please Select</option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency['id'] }}">{{ $currency['code'] }} - {{ $currency['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br/><br/>
                                </div>
                            @elseif ($editable_fields[$i]['name'] == 'reason_code_id')
                                <div class="modal_entry {{ $modal_entry_class }}">
                                    <label class="col-md-4 text-right">{{ $editable_fields[$i]['label'] }}: </label>
                                    <div class="col-md-8 text-left">
                                        <select class="form-control select2 {{ $editable_fields[$i]['required'] ? 'required' : '' }}" id="{{ $editable_fields[$i]['name'] }}" name="{{ $editable_fields[$i]['name'] }}">
                                            <option value="">Please Select</option>
                                            @foreach ($reason_codes as $reason_code)
                                                <option value="{{ $reason_code['id'] }}">{{ $reason_code['code'] }} - {{ $reason_code['description'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br/><br/>
                                </div>
                            @elseif ($editable_fields[$i]['type'] == 'date')
                                <div class="modal_entry {{ $modal_entry_class }}">
                                    <label class="col-md-4 text-right">{{ $editable_fields[$i]['label'] }}: </label>
                                    <div class="col-md-8 text-left">
                                        <input type="text" class="form-control datepicker {{ $editable_fields[$i]['required'] ? 'required' : '' }}" id="{{ $editable_fields[$i]['name'] }}" name="{{ $editable_fields[$i]['name'] }}" maxlength="{{ $editable_fields[$i]['size'] }}"/>
                                    </div>
                                    <br/><br/>
                                </div>
                            @elseif ($editable_fields[$i]['type'] == 'html')
                                <div class="modal_entry {{ $modal_entry_class }}">
                                    <label class="col-md-4 text-right">{{ $editable_fields[$i]['label'] }}: </label>
                                    <div class="col-md-8 text-left">
                                        <textarea style="display:none;" id="{{ $editable_fields[$i]['name'] }}" name="{{ $editable_fields[$i]['name'] }}"></textarea>
                                        <button class="btn btn-success" id="html_editor_button" data-type="edit" data-field="{{ $editable_fields[$i]['name']  }}"><i class="fa fa-file-o"></i></button>
                                    </div>
                                    <br/><br/>
                                </div>
                            @elseif ($editable_fields[$i]['type'] == 'file')
                                <div class="modal_entry {{ $modal_entry_class }}">
                                    <label class="col-md-4 text-right">{{ $editable_fields[$i]['label'] }}: </label>
                                    <div class="col-md-8 text-left">
                                        <input type="file" class="form-control" id="{{ $editable_fields[$i]['name'] }}" name="{{ $editable_fields[$i]['name'] }}" data-toggle="tooltip" data-placement="bottom" data-original-title="Only upload a file in order to change the currently attached file. Leave empty if you want to leave the current file attached."/>
                                    </div>
                                   <br/><br/>
                                </div>
                            @else
                                <div class="modal_entry {{ $modal_entry_class }}">
                                    <label class="col-md-4 text-right">{{ $editable_fields[$i]['label'] }}: </label>
                                    <div class="col-md-8 text-left">
                                        <input type="text" class="form-control {{ $editable_fields[$i]['required'] ? 'required' : '' }}" id="{{ $editable_fields[$i]['name'] }}" name="{{ $editable_fields[$i]['name'] }}" maxlength="{{ $editable_fields[$i]['size'] }}"/>
                                    </div>
                                    <br/><br/>
                                </div>
                            @endif

                            @if($large)
                                @if($i % 2 == 1)
                                    </div>
                                @endif
                            @else
                                </div>
                            @endif
                        @endfor

                        @if($large && ($record_count % 2 == 1))
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save_edit_record"><i class="fa fa-arrow-right"></i>
                        {{ $edit_record_title }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>