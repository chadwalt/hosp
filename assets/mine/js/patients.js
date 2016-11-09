/* 
 * This file will control the general operations of the application.
 */

/* Adding functionalit for the patients page.
 * *************************************************** */

$(function () {
    var base_url = "http://localhost/hosp/";
    var site_url = "http://localhost/hosp/index.php/";

    //Make the text fields wider.
    $("#patient_form input").not("input[type='radio']").css('width', '200px');

    //Get the inactive and active users total.
    $('#patients_dg').datagrid({
        onLoadSuccess: function (data) {
            var rows = data.rows;

            $("#patients_dash").html('Patients: ' + rows.length);
        }
    });

    /* When the add student button is clicked the student dialog will open.
     * *********************************************************************/
    $('#add_patient').on('click', function (event) {
        event.preventDefault();

        $("#patient_dlg").dialog('open').dialog('setTitle', 'Register New Patient');
        $('.user_picture').attr('src', base_url + 'blank_user_images/blank-profile.jpg');
        document.getElementById('patient_form').reset();
        $('#patients_dg').datagrid('unselectAll'); //Unselect all rows.
    });

    /* Close the student dialog and clear the form.
     * **********************************************/
    $('#cancel_patient_dlg').on('click', function (event) {
        event.preventDefault();
        $('#patient_dlg').dialog('close');
    });


    /* Save the students information, Submit the student form.
     * ************************************************************/
    $('#save_patient').on('click', function (event) {
        //event.preventDefault();
        var form_data = document.getElementById('patient_form');

        var full_name = $('#name').val();
        var birth_date = $('#birth_date').combobox('getValue');
        var address = $('#address').val();
        var contact = $('#phone').val();


        if (full_name.length < 1 || contact.length < 1 || address.length < 1 || birth_date.length < 1) {
            $.messager.show({title: 'Info', msg: 'Please fill in all the required fields.'});
            return false;
        }

        $.ajax({
            url: $("#patient_form").attr('action'),
            type: "POST",
            data: new FormData(form_data),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'JSON',
            success: function (data) {
                if (data.success) {
                    $("#patient_dlg").dialog('close');
                    document.getElementById('patient_form').reset();
                    $('#patients_dg').datagrid('reload');
                    $.messager.show({title: 'Info', msg: 'Data successfully saved'});
                } else {
                    $.messager.show({title: 'Info', msg: 'Error occurred while processing the data. Please try again.'});
                }
            },
            error: function () {
                $.messager.show({title: 'Info', msg: 'Data not saved. Please correct errors and try again.'});
            }
        });
    });

    // On changing the picture show before uploading.
    $(document).on('change', "input[name='upload_picture']", function (event) {
        //alert('working');
        readURL(this);
    });

    /* Edit student. show dialog with student information.
     * ******************************************************/
    $('#edit_patient').on('click', function (event) {
        event.preventDefault();
        //            document.getElementById('user_form').reset();
        var row = $('#patients_dg').datagrid('getSelected');

        if (row) {
            $('#patient_form').form('load', row);

            if (row.gender === 'M') {
                $('#male').prop('checked', true);
            } else {
                $('#female').prop('checked', true);
            }

            $('#birth_date').datebox('setValue', row.birth_date);

            $("#patient_dlg").dialog('open').dialog('setTitle', 'Edit Patient');

            if (row.picture === null || row.picture === undefined) {
                $('.user_picture').attr('src', base_url + 'blank_user_images/blank-profile.jpg');
            } else {
                $('.user_picture').attr('src', base_url + 'patients_pictures/' + row.picture);
            }

            // $('#patient_id').val(row.patient_id);
        } else {
            $.messager.show({title: 'Info', msg: 'Please select patient to view'});
        }
    });


    /* Delete student from the system.
     * *****************************************/
    $('#delete_patient').on('click', function (event) {
        event.preventDefault();

        var row = $('#patients_dg').datagrid('getSelected');
        if (row) {
            var delete_url = site_url + "/Main_controller/delete_patient";

            $.messager.confirm('Confirmation', 'Do you want to delete <strong> ' + row.name + ' </strong>from the system?', function (r) {
                if (r) {
                    $.getJSON(delete_url, {
                        patient_id: row.patient_id
                    }, function (data) {
                        if (data.success) {
                            $.messager.show({title: 'Info', msg: 'Patient deleted successfully'});
                            $('#patients_dg').datagrid('reload');
                        } else {
                            $.messager.show({title: 'Info', msg: 'Patient not deleted'});
                        }
                    });
                }
            });
        } else {
            $.messager.show({title: 'Info', msg: 'Please select student to view.'});
        }

    });

    /* Search for the students in the system and display them
     * *******************************************************/
    $(document).on('keyup', "input[type='search']", function () {
        var search_item = $(this).val();
        var search_url = site_url + "/Main_controller/search_patient" + '?search_name=' + search_item;
        $('#patients_dg').datagrid({
            url: search_url
        });

        $(this).focus();
    });



});

/* Refresh the datagrid
 * ***********************/

function refresh(dg) {
    setTimeout(function () {
        $(dg).datagrid('reload');
    }, 800);
}

function sex_formatter(value, row) {
    if (row) {
        if (value == 'M') {
            return value = 'Male';
        } else {
            return value = 'Female';
        }
    }
}

/* This function will be used to load the images into the page after its selected.
 * ********************************************************************************/
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.user_picture').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function myformatter(date) {
    var y = date.getFullYear();
    var m = date.getMonth() + 1;
    var d = date.getDate();
    return y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d);
}

function myparser(s) {
    if (!s)
        return new Date();
    var ss = (s.split('-'));
    var y = parseInt(ss[0], 10);
    var m = parseInt(ss[1], 10);
    var d = parseInt(ss[2], 10);
    if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
        return new Date(y, m - 1, d);
    } else {
        return new Date();
    }
}