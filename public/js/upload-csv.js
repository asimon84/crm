$(document).ready(function () {
    $("#uploadCSVForm").submit( function() {
        $('<input />').attr('type', 'hidden')
            .attr('name', "_token")
            .attr('value', $('[name="_token"]').val())
            .appendTo(this);
    });

    $('#save_upload_file').on('click', function (e) {
        e.preventDefault();

        //Disable it if clicking more than once
        if ($processing) {
            return false;
        }

        var error = false;

        if ($('#fileToUpload').val() == '') {
            error = true;
        }

        if (error) {
            alert('Please select a file to upload and the source it came from.');
        }
        else {
            var fileUpload = document.getElementById("fileToUpload");
            var regex      = /^([a-zA-Z0-9\s_\\.\-:])+(.csv)$/;
            if (regex.test(fileUpload.value.toLowerCase())) {
                if (typeof (FileReader) != "undefined") {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        var rows = e.target.result.split("\n");

                        if (typeof rows[0] == 'undefined') {
                            alert('Error! Uploaded file contains no data');
                        }
                        else {
                            //loading('start');

                            var headers = convertToOptions(rows[0]);

                            $('.key-dropdown').each(function () {
                                $(this).html(headers);
                            });

                            var sample = rows[1];

                            $('#sample_data').html(sample);

                            $('#uploadModal').modal('hide');
                            $('#mapModal').modal('show');

                            //loading();
                        }
                    }

                    reader.readAsText(fileUpload.files[0]);
                }
                else {
                    alert('Error! Your browser does not support HTML5. Please upgrade and try again.');
                }
            }
            else {
                alert('Error! Please upload a valid CSV file and try again.');
            }
        }
    });

    $('.key-dropdown').on('change', function (e) {
        e.preventDefault();

        var count = $(this).val();

        var key = this.id.substring(0, this.id.length - 4);

        if (count == '') {
            $('#' + key + '_example').html('');
        }
        else {
            var sample_data = $('#sample_data').html();
            sample_data     = sample_data.split(',');

            $('#' + key + '_example').html(sample_data[count]);
        }
    });

    $('#save_mapped_file').on('click', function (e) {
        e.preventDefault();

        //loading('start');

        var errors = 0;

        //Validate the mapping
        $('#uploadCSVForm .required').each(function () {
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
            $('#uploadCSVForm').submit();
        }
        //Else clear loading screen and show error pop up
        else {
            //loading();

            alert('Error! Please map a column for all required fields.');
        }
    });

    $('#save_format').on('click', function (e) {
        e.preventDefault();

        var errors = 0;

        //Validate the mapping
        $('#uploadCSVForm .required').each(function () {
            $(this).removeClass('error');

            if ($(this).val() == '') {
                if (errors == 0) {
                    errors = 1;
                }

                $(this).addClass('error');
            }
        });

        if (errors == 0) {
            $('#saveFormatModal').modal('show');
        }
        else {
            alert('Error! Please map all required columns first before saving the format.');
        }
    });

    $('#apply_save_format').on('click', function (e) {
        if ($('#format_name').val() != '') {
            //loading('start');

            var keys = [];

            $('#uploadCSVForm select').each(function () {
                keys.push($(this).val());
            });

            $.ajax({
                    method: "POST",
                    url: module+'/saveFormat',
                    data: {
                        _token: $('[name="_token"]').val(),
                        format_name: $('#format_name').val(),
                        keys: keys
                    }
                })
                .success(function(result) {
                    $('#saveFormatModal').modal('hide');

                    alert('Format saved successfully!');

                    //loading();
                })
                .fail(function() {
                    //loading();
                });
        }
        else {
            alert('Error! Please provide a format name to save this format as.');
        }
    });

    $('#load_format').on('click', function (e) {
        e.preventDefault();

        clearLoadFormatModal();

        $.ajax({
                method: "POST",
                url: module+'/refreshFormats',
                data: {
                    _token: $('[name="_token"]').val(),
                }
            })
            .success(function(result) {
                result = JSON.parse(result);

                var formats = result.formats;
                var output = '<option value="">Please Select</option>';

                $.each(formats, function (index, value) {
                    output += '<option value="' + value.id + '">' + value.format_name + '</option>';
                });

                $('#load_format_dropdown').html(output);

                $('#loadFormatModal').modal('show');

                //loading();
            })
            .fail(function() {
                alert(result.msg);

                //loading();
            });
    });

    $('#load_format_dropdown').on('change', function (e) {
        if ($('#load_format_dropdown').val() != '') {
            //loading('start');

            $.ajax({
                method: "POST",
                url: module+'/getFormat',
                data: {
                    _token: $('[name="_token"]').val(),
                    format_id: $('#load_format_dropdown').val(),
                }
            })
            .success(function(result) {
                result = JSON.parse(result);

                var format = result.format;
                var key;

                $.each(format, function (index, value) {
                    $('#loadFormatModal #'+index).val(value);

                    key = index.substring(0, index.length - 4);

                    if (value === null) {
                        $('#' + key + '_example').html('');
                    }
                    else {
                        var sample_data = $('#sample_data').html();
                        sample_data     = sample_data.split(',');

                        $('#' + key + '_example').html(sample_data[value]);
                    }
                });

                //loading();
            })
            .fail(function() {
                alert(result.msg);
                clearLoadFormatModal();

                //loading();
            });
        }
        else {
            clearLoadFormatModal();
        }
    });

    $('#apply_loaded_format').on('click', function (e) {
        e.preventDefault();

        if ($('#load_format_dropdown').val() != '') {
            clearMapModal();

            var sample_data = $('#sample_data').html();
            sample_data     = sample_data.split(',');

            $('#loadFormatModal select').each(function () {
                if($(this).attr('id') != 'load_format_dropdown') {
                    var index = $(this).val();
                    var id = $(this).attr('id');
                    var saveTo = id.substring(5, id.length);

                    $('#uploadCSVForm #'+saveTo).val($(this).val());

                    var example = saveTo.substring( 0, (saveTo.length - 4) ) + '_example';

                    if( $.isNumeric( index )  ) {
                        $('#'+example).html( sample_data[index] );
                    }
                    else {
                        $('#'+example).html('');
                    }
                }
            });

            clearLoadFormatModal();

            $('#loadFormatModal').modal('hide');
        }
        else {
            alert('Error! Please select a format to load or hit close to cancel.');
        }
    });

    $('#loadFormatModal').on('hidden.bs.modal', function () {
        clearLoadFormatModal();
    });

    $('#mapModal').on('hidden.bs.modal', function () {
        clearMapModal();
    });
});

function clearLoadFormatModal()
{
    $('#loadFormatModal select').each(function () {
        $(this).val('');
    });

    $('#loadFormatModal .example').each(function () {
        $(this).html('');
    });
}

function clearMapModal()
{
    $('#mapModal select').each(function () {
        $(this).val('');
    });

    $('#mapModal .example').each(function () {
        $(this).html('');
    });
}