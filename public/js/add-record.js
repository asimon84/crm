$(document).ready(function () {
    $("#add_record_form").submit( function() {
        $('<input />').attr('type', 'hidden')
            .attr('name', "_token")
            .attr('value', $('[name="_token"]').val())
            .appendTo(this);
    });

    $body.on('click', '#save_add_record', function (e) {
        e.preventDefault();

        //loading('start');

        var errors = 0;

        //Validate the mapping
        $('#add_record_form .required').each(function () {
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
            $('#add_record_form').submit();
        }
        //Else clear loading screen and show error pop up
        else {
            //loading();

            alert('Error! Please enter a value for all required fields.');
        }
    });
});