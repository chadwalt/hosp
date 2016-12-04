/* 
 * This file will control the general operations of the application.
 */

/* Adding functionalit for the ward datagrid.
 * *************************************************** */

$(function () {
    var base_url = "http://localhost/hosp/";
    var site_url = "http://localhost/hosp/index.php/";
    
    $('.toggle-btn').click(function () {
        $('#ward_dg').datagrid({width: '100%'});
    });

    $('#ward_dg').edatagrid({
        url: site_url + 'Main_controller/get_wards',
        saveUrl: site_url + 'Main_controller/save_ward',
        updateUrl: site_url + 'Main_controller/save_ward',
        //destroyUrl: site_url + 'Main_controller/delete_ward',
        onLoadSuccess: function (data) {
            var rows = data.rows;
            var rows_num = rows.length;

            $("#wards_num").html('Wards: ' + rows_num);
        }
    });

    /* Delete ward from the system.
     * *****************************************/
    $('#delete_ward').on('click', function (event) {
        event.preventDefault();

        var row = $('#ward_dg').datagrid('getSelected');
        if (row) {
            var delete_url = site_url + 'Main_controller/delete_ward';

            $.messager.confirm('Confirmation', 'Do you want to delete ward <strong>' + row.name + ' </strong>from the system?', function (r) {
                if (r) {
                    $.post(delete_url, {
                        ward_id: row.ward_id
                    }, function (data) {
                        if (data.success) {
                            $.messager.show({
                                title: 'Info',
                                msg: 'Ward deleted successfully'
                            });
                            $('#ward_dg').datagrid('reload');
                        } else {
                            $.messager.show({
                                title: 'Info',
                                msg: 'Ward not deleted. Please try again later'
                            });
                        }
                    }, 'JSON');
                }
            });
        } else {
            $.messager.show({
                title: 'Info',
                msg: 'Please select ward to delete.'
            });
        }

    });

    /* Search for the wards in the system and display them
     * *******************************************************/
    $(document).on('keyup', "input[type='search']", function () {
        var search_item = $(this).val();
        var search_url = site_url + "Main_controller/search_ward" + '?search_name=' + search_item;
        $('#ward_dg').datagrid({
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