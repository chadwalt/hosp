/* 
 * This file will control the general operations of the application.
 */

/* Adding functionalit for the category datagrid.
 * *************************************************** */

$(function () {
    var base_url = "http://localhost/hosp/";
    var site_url = "http://localhost/hosp/index.php/";
    
    $('.toggle-btn').click(function () {
        $('#categories_dg').datagrid({width: '100%'});
    });

    $('#categories_dg').edatagrid({
        url: site_url + 'Admin/get_med_categories',
        saveUrl: site_url + 'Admin/save_category',
        updateUrl: site_url + 'Admin/save_category',
        //destroyUrl: site_url + 'Admin/delete_category',
        onLoadSuccess: function (data) {
            var rows = data.rows;
            var rows_num = rows.length;

            $("#categories_num").html('Categories: ' + rows_num);
        }
    });

    /* Delete category from the system.
     * *****************************************/
    $('#delete_category').on('click', function (event) {
        event.preventDefault();

        var row = $('#categories_dg').datagrid('getSelected');
        if (row) {
            var delete_url = site_url + 'Admin/delete_category';

            $.messager.confirm('Confirmation', 'Do you want to delete category <strong>' + row.name + ' </strong>from the system?', function (r) {
                if (r) {
                    $.post(delete_url, {
                        id: row.id
                    }, function (data) {
                        if (data.success) {
                            $.messager.show({
                                title: 'Info',
                                msg: row.name + ' Category deleted successfully'
                            });
                            $('#categories_dg').datagrid('reload');
                        } else {
                            $.messager.show({
                                title: 'Info',
                                msg: 'Category not deleted. Please try again later'
                            });
                        }
                    }, 'JSON');
                }
            });
        } else {
            $.messager.show({
                title: 'Info',
                msg: 'Please select category to delete.'
            });
        }

    });

    /* Search for the categorys in the system and display them
     * *******************************************************/
    $(document).on('keyup', "input[type='search']", function () {
        var search_item = $(this).val();
        var search_url = site_url + "Admin/search_category" + '?search_name=' + search_item;
        $('#categories_dg').datagrid({
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