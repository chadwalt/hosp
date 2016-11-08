<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Admin Template">
        <meta name="keywords" content="admin dashboard, admin, flat, flat ui, ui kit, app, web app, responsive">
        <link rel="shortcut icon" href="<?php echo base_url() ?>libraries/img/ico/favicon.png">
        <title>Login</title>

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

        <h2 class="form-heading">login</h2>
        <div class="container log-row">
            <form class="form-signin" id="login_form">
                <div class="login-wrap">
                    <input type="text" class="form-control" placeholder="Username" name="username" autofocus required="">
                    <input type="password" class="form-control" placeholder="Password" name="password" required="">
                    <button class="btn btn-lg btn-success btn-block" type="submit">LOGIN</button>
                    <label class="checkbox-custom check-success">
                        <input type="checkbox" value="remember-me" id="checkbox1"> <label for="checkbox1">Remember me</label>
                        <a class="pull-right" data-toggle="modal" href="#forgotPass"> Forgot Password?</a>
                    </label>
                </div>

                <!-- Modal -->
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="forgotPass" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Forgot Password ?</h4>
                            </div>
                            <div class="modal-body">
                                <p>Enter your Username below to reset your password.</p>
                                <input type="text" name="text" id="forgot_username" placeholder="Username" autocomplete="off" class="form-control placeholder-no-fix">

                            </div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-default" id="forgetCancelBtn" type="button">Cancel</button>
                                <button class="btn btn-success" type="button" id="forgotPassSubmit">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal -->

            </form>
        </div>

        <!--jquery-1.10.2.min-->
        <script src="<?php echo base_url() ?>libraries/js/jquery-1.11.1.min.js"></script>
        <!--Bootstrap Js-->
        <script src="<?php echo base_url() ?>libraries/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url() ?>libraries/js/bootbox/bootbox.js"></script>
        <script src="<?php echo base_url() ?>libraries/js/jRespond/js/jRespond.min.js"></script>        
        <script src="<?php echo base_url() ?>assets/mine/js/login.js"></script> 
        <script>
            var site_url = "<?php echo site_url() ?>";
        </script>
    </body>
</html>
