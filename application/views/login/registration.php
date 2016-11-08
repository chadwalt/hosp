<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Admin Template">
        <meta name="keywords" content="admin dashboard, admin, flat, flat ui, ui kit, app, web app, responsive">
        <link rel="shortcut icon" href="img/ico/favicon.png">
        <title>Registration</title>

        <!-- Base Styles -->
        <link href="<?php echo base_url() ?>libraries/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>libraries/css/style-responsive.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="login-body">

        <div class="login-logo">
            <img src="<?php echo base_url() ?>libraries/img/login_logo.png" alt=""/>
        </div>

        <h2 class="form-heading">registration now</h2>
        <div class="container log-row">
            <?php echo $this->session->flashdata('reg_errors');?>
            <form class="form-signin" method="post" action="<?php echo site_url('Main_controller/register_details');?>">
                <p>Enter your personal details below</p>
                <input type="text" class="form-control" name="full_name" placeholder="Full Name" required="" autofocus>
                <input type="text" class="form-control" name="address" placeholder="City/Town"required=""  autofocus>
                <input type="text" class="form-control" name="contact" placeholder="Contact" required="" autofocus>
                <input type="text" class="form-control" name="email" placeholder="Email" autofocus>
                <div class="radio-custom radio-success">
                    <input type="radio" value="Male" checked="checked" name="gender" id="male">
                    <label for="male">Male</label>
                    <input type="radio"  value="female" name="gender" id="female">
                    <label for="female">Female</label>
                </div>

                <p> Enter your account details below</p>
                <div class="alert alert-block alert-danger fade in" id="password_model" style="display: none">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="fa fa-times"></i>
                    </button><i class="fa fa-exclamation-triangle"></i>
                    <strong>Passwords!</strong> didn't match.
                </div>
                <input type="text" class="form-control" name="username" placeholder="User Name" required="" autofocus>
                <input type="password" name="password" class="form-control" placeholder="Password" required="" id="password">
                <input type="password" name="retype_password" class="form-control" placeholder="Re-type Password" id="retype_password" required="">
                <!--                <label class="checkbox-custom check-success">
                                    <input type="checkbox" value="agree this condition" id="checkbox1"> <label for="checkbox1">I agree to the Terms of Service and Privacy Policy</label>
                                </label>-->

                <button class="btn btn-lg btn-success btn-block" type="submit">Submit</button>

                <div class="registration m-t-20 m-b-20">
                    Already Registered.
                    <a class="" href="<?php echo site_url('Main_controller/index'); ?>">
                        Login
                    </a>
                </div>
            </form>
        </div>

        <!--jquery-1.10.2.min-->
        <script src="<?php echo base_url() ?>libraries/js/jquery-1.11.1.min.js"></script>
        <!--Bootstrap Js-->
        <script src="<?php echo base_url() ?>libraries/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url() ?>libraries/js/jRespond/js/jRespond.min.js"></script>


        <script>
            $(function () {
                $('#password_model').hide();
                
                $('#retype_password').blur(function(){
                    var retype_pass = $(this).val();
                    var pass = $('#password').val();
                    
                    if (retype_pass !== pass){
                        $('#password_model').fadeIn();
                        $('button[type=submit]').prop('disabled', true);
                    } else {
                        $('#password_model').fadeOut();
                        $('button[type=submit]').prop('disabled', false);
                    }
                });

            });
        </script>
    </body>
</html>
