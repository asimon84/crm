$(document).ready(function () {
    $body.on('click', '#delete_record_button', function (e) {
        var q = confirm('Are you sure you want to delete this record?');

        if(q) {
            $.ajax({
                method: "POST",
                url: module+'/deleteRecord',
                data: {
                    id : $(this).data('id'),
                    _token : $('[name="_token"]').val()
                },
            })
            .done(function(result) {
                alert('Record Deleted!');

                refreshTables();
            })
            .fail(function() {
                alert( 'Error! Unable to delete this record. Please refresh and try again.' );
            });
        }
    });
});