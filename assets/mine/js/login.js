/* 
 * This script will controll the login of the index page.
 */

$(function () {
    $('#login_form').on('submit', function (event) {
        event.preventDefault(); // Prevent the default submit action and perform the tasks below.

        var myform = document.getElementById('login_form');
        var formData = new FormData(myform);

        // Makeing the ajax call.
        $.ajax({
            url: site_url + "/Main_controller/validate_login",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            method: "POST",
            success: function (response) {
                if (response.msg) {
                    window.location.href = response.redirect_url;
                } else {
                    var box = bootbox.dialog({
                        size: "medium",
                        message: "<div style='text-align: center;'>Wrong Username/Password</div>",
                    });
                    setTimeout(function () {
                        box.modal('hide');
                    }, 2000);
                }
            },
            error: function () {
                var box = bootbox.alert("Error while processing the form. Please try again later");
                setTimeout(function () {
                    box.modal('hide');
                }, 2000);
            }
        });
    });

    /* Reset user password when the request for password reset is clicked
     * ********************************************************************/
    $('#forgotPassSubmit').on('click', function () {
        var username = $('#forgot_username').val();
        
        $.post(site_url + '/Main_controller/reset_password', {username: username}, function (response) {
            if (response.success) {
                $("#forgetCancelBtn").trigger('click');
                var box = bootbox.dialog({
                    size: "medium",
                    message: "<div style='text-align: center;'>" + response.msg + "</div>",
                });
                setTimeout(function () {
                    box.modal('hide');
                }, 4000);
            } else {
                var box = bootbox.dialog({
                    size: "medium",
                    message: "<div style='text-align: center;'>" + response.msg + "</div>",
                });
                setTimeout(function () {
                    box.modal('hide');
                }, 4000);
            }
        }, 'JSON');
    });
});
