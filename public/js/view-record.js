$(document).ready(function () {
    $body.on('click', '#view_record_button', function (e) {
        e.preventDefault();

        //loading('start');

        $('#viewRecordModal #view_record_content').html('');

        $.ajax({
            method: "POST",
            url: module+'/viewRecord',
            data: {
                _token : $('[name="_token"]').val(),
                id : $(this).data('id')
            },
        })
        .done(function(result) {
            $('#viewRecordModal #tab1li').removeClass('active');
            $('#viewRecordModal #tab2li').removeClass('active');

            $('#viewRecordModal #tab1li').addClass('active');

            $('#viewRecordModal #view_record_content').html(result);

            $('#viewRecordModal').modal('show');
        })
        .fail(function() {
            alert( 'Error! Unable to view this record. Please refresh and try again.' );
        });
    });

    $body.on('click', '#view_html_button', function (e) {
        e.preventDefault();

        $('#view_file_content').html($('#viewRecordModal #'+$(this).data('field')).val());

        $('#viewFileModal').modal('show');
    });
});