/* 
 * This file will control the general operations of the application.
 */

/* Adding functionalit for the department datagrid.
 * *************************************************** */

$(function () {
    var base_url = "http://localhost/hosp/";
    var site_url = "http://localhost/hosp/index.php/";
    
    $('.toggle-btn').click(function () {
        $('#departments_dg').datagrid({width: '100%'});
    });

    $('#departments_dg').edatagrid({
        url: site_url + 'Admin/get_departments',
        saveUrl: site_url + 'Admin/save_department',
        updateUrl: site_url + 'Admin/save_department',
        //destroyUrl: site_url + 'Admin/delete_department',
        onLoadSuccess: function (data) {
            var rows = data.rows;
            var rows_num = rows.length;

            $("#departments_num").html('Departments: ' + rows_num);
        }
    });

    /* Delete department from the system.
     * *****************************************/
    $('#delete_department').on('click', function (event) {
        event.preventDefault();

        var row = $('#departments_dg').datagrid('getSelected');
        if (row) {
            var delete_url = site_url + 'Admin/delete_department';

            $.messager.confirm('Confirmation', 'Do you want to delete department <strong>' + row.name + ' </strong>from the system?', function (r) {
                if (r) {
                    $.post(delete_url, {
                        department_id: row.department_id
                    }, function (data) {
                        if (data.success) {
                            $.messager.show({
                                title: 'Info',
                                msg: 'Department deleted successfully'
                            });
                            $('#departments_dg').datagrid('reload');
                        } else {
                            $.messager.show({
                                title: 'Info',
                                msg: 'Department not deleted. Please try again later'
                            });
                        }
                    }, 'JSON');
                }
            });
        } else {
            $.messager.show({
                title: 'Info',
                msg: 'Please select department to delete.'
            });
        }

    });

    /* Search for the departments in the system and display them
     * *******************************************************/
    $(document).on('keyup', "input[type='search']", function () {
        var search_item = $(this).val();
        var search_url = site_url + "Admin/search_department" + '?search_name=' + search_item;
        $('#departments_dg').datagrid({
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