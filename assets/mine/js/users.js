/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var user_form_url;

$(function () {
    
    //Get the inactive and active users total.
    $('#users_dg').datagrid({
        onLoadSuccess: function(data){
            var rows = data.rows;
            var active = 0;
            var inactive = 0;
            
            $.each(rows, function(index, value){
                if(parseInt(value.active_status) === 0){
                    active++;
                } else {
                    inactive++;
                }
            });
            //console.log(data);
            
            $("#active_users_dash").html('Active Users: ' + active);
            $("#inactive_users_dash").html('Inactive Users: ' + inactive);
        }
    });
    
    $('#username').blur(function () {
        var username = $(this).val();

        //Check if the username already exists.
        if (username.length > 3) {
            $.post(site_url + '/Users/username_check', {username: username}, function (data) {
                var exists = data.result;
                if (exists) {
                    $.messager.show({title: 'Info', msg: 'Username already taken'});
                    $('#save_student').prop('disabled', true);
                } else {
                    $.messager.show({title: 'Info', msg: 'Username available'});
                    $('#save_student').prop('disabled', false);
                }
            }, 'JSON');
        }
    });

    $('#position').combobox({
        valueField: 'id',
        textField: 'label',
        required: true,
        panelHeight: 'auto',
        data: [
            {id: 'admin', label: 'Administrator'},
            {id: 'accountant', label: 'Accountant'},
            {id: 'doctor', label: 'doctor'},
            {id: 'laboratorist', label: 'Laboratorist'},
            {id: 'nurse', label: 'Nurse'},
            {id: 'receptionist', label: 'Receptionist'},
            {id: 'pharmacist', label: 'Pharmacist'},
        ]
    });

    /* Active or Deactive the user in the system
     * *********************************************/
    $('#active-deactive').on('click', function () {
        var row = $('#users_dg').datagrid('getSelected');

        if (row) {
            var status = row.active_status;
            var user_id = row.id;
            $.post(site_url + "/Users/active_status", {status: status, user_id: user_id}, function (response) {
                if (response.success) {
                    $.messager.show({
                        title: 'Info',
                        msg: 'User updated successfully'
                    });
                    $('#users_dg').datagrid('reload');
                } else {
                    $.messager.show({
                        title: 'Info',
                        msg: 'User not updated'
                    });
                }
            }, 'JSON');
        } else {
            $.messager.show({title: 'Info', msg: 'Please first select user to deactivate/activate'});
        }
    });

    /* When the add student button is clicked the student dialog will open.
     * *********************************************************************/
    $('#add_user').on('click', function (event) {
        event.preventDefault();

        $('#user_id').val('');
        $('#user_form :input').prop('disabled', false);// Enable all form input elements.

        $("#user_dlg").dialog('open').dialog('setTitle', 'Register New User');
        $('.user_picture').attr('src', base_url + 'blank_user_images/blank-profile.jpg');
        document.getElementById('user_form').reset();
        $('#users_dg').datagrid('unselectAll'); //Unselect all rows.
        $('#save_student').prop('disabled', false); // Enable the save button;
        $('#password_group').show();
    });

    /* Close the student dialog and clear the form.
     * **********************************************/
    $('#cancel_user_dlg').on('click', function (event) {
        event.preventDefault();
        $('#user_dlg').dialog('close');
    });


    /* Save the students information, Submit the student form.
     * ************************************************************/
    $('#save_student').on('click', function (event) {
        //event.preventDefault();
        var form_data = document.getElementById('user_form');

        var full_name = $('#full_name').val();
        var position = $('#position').combobox('getValue');
        var username = $('#username').val();
        var password = $('#password').val();


        if (full_name.length < 1 || position.length < 1 || username.length < 1 || password.length < 1) {
            $.messager.show({
                title: 'Info',
                msg: 'Please fill in all the required fields.'
            });
            return;
        }

        $.ajax({
            url: $("#user_form").attr('action'),
            type: "POST",
            data: new FormData(form_data),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'JSON',
            success: function (data) {
                if (data.success) {
                    $("#user_dlg").dialog('close');
                    document.getElementById('user_form').reset();
                    $('#users_dg').datagrid('reload');
                    $.messager.show({title: 'Info', msg: 'Data successfully saved'});
                } else {
                    $.messager.show({title: 'Info', msg: 'Error occurred while processing the data. Please try again.'});
                }
            },
            error: function () {
                $.messager.show({
                    title: 'Info',
                    msg: 'Data not saved. Please correct errors and try again.'
                });
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
    $('#edit_user').on('click', function (event) {
        event.preventDefault();
        //            document.getElementById('user_form').reset();
        var row = $('#users_dg').datagrid('getSelected');

        if (row) {
            if (row.sex === 'Male') {
                $('#male').prop('checked', true);
            } else {
                $('#female').prop('checked', true);
            }

            $('#user_form :input').prop('disabled', true);// Disable all form input elements.
            $('#save_student').prop('disabled', true) // Disable the save button;

            $('#user_form').form('load', row);
            

            $('#phone').val(row.contact);

            $('#password_group').hide();

            $("#user_dlg").dialog('open').dialog('setTitle', 'Edit User');

            if (row.picture === null || row.picture === undefined) {
                $('.user_picture').attr('src', base_url + 'blank_user_images/blank-profile.jpg');
            } else {
                $('.user_picture').attr('src', base_url + 'user_pictures/' + row.picture);
            }

            $('#tt').tabs('select', 'User Information');
            $('#course').prop('disabled', false);
            $('#user_id').val(row.id);
        } else {
            $.messager.show({
                title: 'Info',
                msg: 'Please select student to view.'
            });
        }
    });


    /* Delete student from the system.
     * *****************************************/
    $('#delete_user').on('click', function (event) {
        event.preventDefault();

        var row = $('#users_dg').datagrid('getSelected');
        if (row) {
            var delete_url = site_url + "/Users/delete_user";

            $.messager.confirm('Confirmation', 'Do you want to delete <strong> ' + row.full_name + ' </strong>from the system?', function (r) {
                if (r) {
                    $.getJSON(delete_url, {
                        id: row.id
                    }, function (data) {
                        if (data.success) {
                            $.messager.show({
                                title: 'Info',
                                msg: 'User deleted successfully'
                            });
                            $('#users_dg').datagrid('reload');
                        } else {
                            $.messager.show({
                                title: 'Info',
                                msg: 'User not deleted'
                            });
                        }
                    });
                }
            });
        } else {
            $.messager.show({
                title: 'Info',
                msg: 'Please select student to view.'
            });
        }

    });

    /* Search for the students in the system and display them
     * *******************************************************/
    $(document).on('keyup', "input[type='search']", function () {
        var search_item = $(this).val();
        var search_url = site_url + "/Users/search_user" + '?search_name=' + search_item;
        $('#users_dg').datagrid({
            url: search_url
        });

        $(this).focus();
    });


    //Setting the pagination size.
    //        $('#users_dg').datagrid({
    //            pageList: [100, 300, 500, 700, 800, 1000]
    //        });

});

/* This function formats the activated and deactived.
 * 0 - Active 1- deactived.
 * ********************************************************/
function active_formatter(value, row) {
    if (row) {
        value = parseInt(value);
        if (value === 0) {
            return 'Active';
        } else {
            return 'Deactived';
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