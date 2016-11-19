/* 
 * This file will control the general operations of the application.
 */

/* Adding functionalit for the supplier datagrid.
 * *************************************************** */

$(function () {
    var base_url = "http://localhost/hosp/";
    var site_url = "http://localhost/hosp/index.php/";
    
    $('.toggle-btn').click(function () {
        $('#suppliers_dg').datagrid({width: '100%'});
    });

    $('#suppliers_dg').edatagrid({
        url: site_url + 'Admin/get_med_suppliers',
        saveUrl: site_url + 'Admin/save_supplier',
        updateUrl: site_url + 'Admin/save_supplier',
        //destroyUrl: site_url + 'Admin/delete_supplier',
        onLoadSuccess: function (data) {
            var rows = data.rows;
            var rows_num = rows.length;

            $("#suppliers_num").html('Suppliers: ' + rows_num);
        }
    });

    /* Delete supplier from the system.
     * *****************************************/
    $('#delete_supplier').on('click', function (event) {
        event.preventDefault();

        var row = $('#suppliers_dg').datagrid('getSelected');
        if (row) {
            var delete_url = site_url + 'Admin/delete_supplier';

            $.messager.confirm('Confirmation', 'Do you want to delete supplier <strong>' + row.name + ' </strong>from the system?', function (r) {
                if (r) {
                    $.post(delete_url, {
                        id: row.id
                    }, function (data) {
                        if (data.success) {
                            $.messager.show({
                                title: 'Info',
                                msg: row.name + ' Supplier deleted successfully'
                            });
                            $('#suppliers_dg').datagrid('reload');
                        } else {
                            $.messager.show({
                                title: 'Info',
                                msg: 'Supplier not deleted. Please try again later'
                            });
                        }
                    }, 'JSON');
                }
            });
        } else {
            $.messager.show({
                title: 'Info',
                msg: 'Please select supplier to delete.'
            });
        }

    });

    /* Search for the suppliers in the system and display them
     * *******************************************************/
    $(document).on('keyup', "input[type='search']", function () {
        var search_item = $(this).val();
        var search_url = site_url + "Admin/search_supplier" + '?search_name=' + search_item;
        $('#suppliers_dg').datagrid({
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