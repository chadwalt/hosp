/* 
 * This file will control the general operations of the application.
 */

/* Adding functionalit for the drugs page.
 * ***************************************** */

$(function () {
    var base_url = "http://localhost/hosp/";
    var site_url = "http://localhost/hosp/index.php/";

    $('.toggle-btn').click(function () {
        $('#drugs_dg').datagrid({width: '100%'});
    });


    $('#drugs_dg').datagrid({
        onLoadSuccess: function (data) {
            var rows = data.rows;

            $("#drugs_dash").html('Drug: ' + rows.length);
        }
    });

    $('#category').combobox({
        url: site_url + "Main_controller/get_categories",
        valueField: 'id',
        textField: 'name',
        required: true,
        panelHeight: '150',
        panelWidth: '250',
    });

    $('#supplier').combogrid({
        url: site_url + "Main_controller/get_suppliers",
        idField: 'id',
        textField: 'name',
        required: true,
        panelHeight: '150',
        panelWidth: '300',
        fitColumns: true,
        columns: [[
                {field: 'name', title: 'Name', width: 150},
                {field: 'phone', title: 'Phone', width: 100},
                {field: 'address', title: 'Address', width: 120},
            ]]
    });

    /* When the add student button is clicked the student dialog will open.
     * *********************************************************************/
    $('#add_drug').on('click', function (event) {
        event.preventDefault();

        $("#drug_dlg").dialog('open').dialog('setTitle', 'Add New Drug');
        document.getElementById('drug_form').reset();
        $('#batch_nbr').numberbox('clear');
        $('#quantity').numberbox('clear');
        $('#cost_price').numberbox('clear');
        $('#selling_price').numberbox('clear');
        $('#drugs_dg').datagrid('unselectAll'); //Unselect all rows.
    });

    /* Close the student dialog and clear the form.
     * **********************************************/
    $('#cancel_drug_dlg').on('click', function (event) {
        event.preventDefault();
        $('#drug_dlg').dialog('close');
    });


    /* Save the students information, Submit the student form.
     * ************************************************************/
    $('#save_drug').on('click', function (event) {
        //event.preventDefault();
        var form_data = document.getElementById('drug_form');

        var full_name = $('#name').val();
        var batch_nbr = $('#batch_nbr').numberbox();
        var category = $('#category').combobox('getValue');
        var supplier = $('#supplier').combogrid('getValue');
        var mfg_date = $('#mfg_date').datebox('getValue');
        var exp_date = $('#exp_date').datebox('getValue');
        var quantity = $('#quantity').numberbox('getValue');
        var cost_price = $('#cost_price').numberbox('getValue');
        var selling_price = $('#selling_price').numberbox('getValue');
        var date_received = $('#date_received').datebox('getValue');


        //if (full_name.length < 1 || selling_price.length || date_received.length < 1 || cost_price.length < 1 || quantity.length < 1 || batch_nbr.length < 1 || category.length < 1 || supplier.length < 1 || mfg_date.length < 1 || exp_date.length < 1) {
            //$.messager.show({title: 'Info', msg: 'Please fill in all the required fields.'});
            //return false;
       // }

        $.ajax({
            url: $("#drug_form").attr('action'),
            type: "POST",
            data: new FormData(form_data),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'JSON',
            success: function (data) {
                if (data.success) {
                    $("#drug_dlg").dialog('close');
                    document.getElementById('drug_form').reset();
                    $('#drugs_dg').datagrid('reload');
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

    /* Edit student. show dialog with student information.
     * ******************************************************/
    $('#edit_drug').on('click', function (event) {
        event.preventDefault();

        var row = $('#drugs_dg').datagrid('getSelected');

        if (row) {
            $('#drug_form').form('load', row);
            $('#supplier').combogrid('setValue', row.supplier);
            $('#category').combobox('setValue', row.category);
            $("#drug_dlg").dialog('open').dialog('setTitle', 'Edit Drug');
        } else {
            $.messager.show({title: 'Info', msg: 'Please select drug to view'});
        }
    });


    /* Delete student from the system.
     * *****************************************/
    $('#delete_drug').on('click', function (event) {
        event.preventDefault();

        var row = $('#drugs_dg').datagrid('getSelected');
        if (row) {
            var delete_url = site_url + "/Main_controller/delete_drug";

            $.messager.confirm('Confirmation', 'Do you want to delete <strong> ' + row.name + ' </strong>from the system?', function (r) {
                if (r) {
                    $.getJSON(delete_url, {
                        id: row.id
                    }, function (data) {
                        if (data.success) {
                            $.messager.show({title: 'Info', msg: 'Drug deleted successfully'});
                            $('#drugs_dg').datagrid('reload');
                        } else {
                            $.messager.show({title: 'Info', msg: 'Drug not deleted'});
                        }
                    });
                }
            });
        } else {
            $.messager.show({title: 'Info', msg: 'Please select drug to delete.'});
        }

    });

    /* Search for the drug in the system and display them
     * *******************************************************/
    $(document).on('keyup', "input[type='search']", function () {
        var search_item = $(this).val();
        var search_url = site_url + "/Main_controller/search_drug" + '?search_name=' + search_item;
        $('#drugs_dg').datagrid({
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