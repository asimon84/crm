$(document).ready(function () {
    initToolbarBootstrapBindings();
    $('#editor').wysiwyg({ fileUploadError: showErrorAlert} );
    window.prettyPrint && prettyPrint();
    $('#editor').cleanHtml();

    $body.on('click', '#html_editor_button', function (e) {
        e.preventDefault();

        var modal = '';
        var type = $(this).data('type');
        var field = $(this).data('field');

        if( type === 'add' ) {
            modal = '#addRecordModal';
        } else {
            modal = '#editRecordModal';
        }

        $('#editor_type').val(type);

        $('#editor_field_name').val(field);

        $('#editor').html($(modal+' #'+field).val());

        $('#htmlEditorModal').modal('show');
    });

    $body.on('click', '#html_editor_save', function (e) {
        e.preventDefault();

        $('#htmlEditorModal').modal('hide');

        var modal = '';
        var type = $('#editor_type').val();

        if( type === 'add' ) {
            modal = '#addRecordModal';
        } else {
            modal = '#editRecordModal';
        }

        $(modal+' #'+$('#editor_field_name').val()).val($('#editor').html());

        $('#editor_field_name').val('');
        $('#editor').html('');
        $('#editor_type').val('');
    });
});

function initToolbarBootstrapBindings() {
    var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'],
        fontTarget = $('[title=Font]').siblings('.dropdown-menu');
    $.each(fonts, function (idx, fontName) {
        fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
    });
    $('a[title]').tooltip({container:'body'});
    $('.dropdown-menu input').click(function() {return false;})
        .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
        .keydown('esc', function () {this.value='';$(this).change();});

    $('[data-role=magic-overlay]').each(function () {
        var overlay = $(this), target = $(overlay.data('target'));
        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
    });
    if ("onwebkitspeechchange"  in document.createElement("input")) {
        var editorOffset = $('#editor').offset();
        $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
    } else {
        $('#voiceBtn').hide();
    }
}

function showErrorAlert (reason, detail) {
    var msg='';
    if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
    else {
        console.log("error uploading file", reason, detail);
    }
    $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+
        '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
}