$(document).ready(function () {
    $("#edit_record_form").submit( function() {
        $('<input />').attr('type', 'hidden')
            .attr('name', "_token")
            .attr('value', $('[name="_token"]').val())
            .appendTo(this);
    });

    $body.on('click', '#save_edit_record', function (e) {
        e.preventDefault();

        //loading('start');

        var errors = 0;

        //Validate the mapping
        $('#edit_record_form .required').each(function () {
            $(this).removeClass('error');

            if ($(this).val() == '') {
                if (errors == 0) {
                    errors = 1;
                }

                $(this).addClass('error');
            }
        });

        //If mapping valid, submit form
        if (errors == 0) {
            $('#edit_record_form').submit();
        }
        //Else clear loading screen and show error pop up
        else {
            //loading();

            alert('Error! Please enter a value for all required fields.');
        }
    });

    $body.on('click', '#edit_record_button', function (e) {
        $.ajax({
            method: "POST",
            url: module+'/getRecord',
            data: {
                _token : $('[name="_token"]').val(),
                id : $(this).data('id')
            },
        })
        .done(function(result) {
            result = $.parseJSON( result );

            $('#editRecordModal #edit_record_id').val( result['id'] );

            $('#editRecordModal input:text').each( function() {
                $('#editRecordModal #'+$(this).attr('id')).val( result[$(this).attr('id')] );
            });

            $('#editRecordModal select').each( function() {
                $('#editRecordModal #'+$(this).attr('id')).val( result[$(this).attr('id')] );
            });

            $('#editRecordModal textarea').each( function() {
                $('#editRecordModal #'+$(this).attr('id')).html( result[$(this).attr('id')] );
            });

            $('#editRecordModal').modal('show');
        })
        .fail(function() {
            alert( 'Error! Unable to edit this record. Please refresh and try again.' );
        });
    });

    //Clear the modal upon closing
    $('#editRecordModal').on('hidden.bs.modal', function (e) {
        $('#editRecordModal input').each( function() {
            $(this).val('');
        });
    });
});