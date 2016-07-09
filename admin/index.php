<?php  
session_start();
include('../snippets/connection.php');


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="../stylesheets/napstandmain.css" rel="stylesheet" type="text/css" />
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
	<link rel="stylesheet" href="../stylesheets/jquery.fileupload.css"/>
	<link rel="stylesheet" href="../stylesheets/jquery.fileupload-ui.css"/>
	<!-- CSS adjustments for browsers with JavaScript disabled -->
	<noscript><link rel="stylesheet" href="../stylesheets/jquery.fileupload-noscript.css"></noscript>
	<noscript><link rel="stylesheet" href="../stylesheets/jquery.fileupload-ui-noscript.css"></noscript>
    <!-- Bootstrap 3.3.2 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="../favicon.ico"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../dist/js/app.js" type="text/javascript"></script>
    <script src="../scripts/mylib.js" type="text/javascript"></script>
    <script src="../scripts/formchecker.js" type="text/javascript"></script>
    <script src="../scripts/adsbountyadmin.js" type="text/javascript"></script>
    <script src="../plugins/iCheck/icheck.min.js" type="text/javascript"></script>

  </head>
  <body class="skin-yellow login-page">
  	<div class="login-box">
      <div class="login-logo">
        <a href="index.php"><b>NAPSTAND ADMIN</b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in as Power User(Administrator)</p>
        <form action="../snippets/basiclog.php" name="adminloginform" method="post">
        	<input type="hidden" name="logtype" value="adminlogin"/>
          <div class="form-group has-feedback"
          >
            <input type="text" class="form-control"  name="username" placeholder="Username"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="Password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <!-- <div class="col-xs-8">    
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>                        
            </div> --> <!-- /.col-->
            <div class="col-xs-4">
              <input type="button" name="adminloginsubmit" value="Log In" class="btn btn-primary btn-block btn-flat"/>
            </div><!-- /.col -->
          </div>
        </form>

        <!-- <div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
          <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
        </div> --><!-- /.social-auth-links -->

        <!-- <a href="#">I forgot my password</a><br>
        <a href="signupin.html" class="text-center">Register a new membership</a>-->
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>