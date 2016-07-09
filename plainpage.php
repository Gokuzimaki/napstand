<?php  
  session_start();
  include('./snippets/connection.php');
  
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Check Out Page</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- <link href="<?php echo $host_addr;?>stylesheets/napstandmain.css" rel="stylesheet" type="text/css" /> -->
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="<?php echo $host_addr;?>stylesheets/jquery.fileupload.css"/>
    <link rel="stylesheet" href="<?php echo $host_addr;?>stylesheets/jquery.fileupload-ui.css"/>
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="<?php echo $host_addr;?>stylesheets/jquery.fileupload-noscript.css"></noscript>
    <noscript><link rel="stylesheet" href="<?php echo $host_addr;?>stylesheets/jquery.fileupload-ui-noscript.css"></noscript>
    <!-- Bootstrap 3.3.2 -->
    <link href="<?php echo $host_addr;?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href='<?php echo $host_addr;?>plugins/select2/dist/css/select2-bootstrap.css' type="text/css"/>
    <link async href="<?php echo $host_addr;?>stylesheets/lightbox.css" rel="stylesheet"/>
    <!-- daterange picker -->
    <link href="<?php echo $host_addr;?>plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- daterange picker -->
    <link href="<?php echo $host_addr;?>plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Bootstrap time Picker -->
    <link href="<?php echo $host_addr;?>plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet"/>
    <!-- Bootstrap Date-time Picker -->
  
    <!-- Font Awesome Icons -->
    <link href="<?php echo $host_addr;?>font-awesome/css/font-awesome.min.css" rel="stylesheet"  />
    <!-- Ionicons -->
    <link href="<?php echo $host_addr;?>ionicons/css/ionicons.min.css" rel="stylesheet"  />
    <!-- Select2 (Selcetion customizer) -->
    <link href='<?php echo $host_addr;?>plugins/select2/dist/css/select2.min.css' rel="stylesheet" />
    <!-- Bootstrap datetimepicker -->
    <link href='<?php echo $host_addr;?>plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css' rel="stylesheet" />
    <!-- Jquery Sortable -->
    <link href='<?php echo $host_addr;?>plugins/jquery-sortable/css/jquery-sortable.css' rel="stylesheet" />
    <!-- Theme style -->
    <link href="<?php echo $host_addr;?>dist/css/AdminLTE.min.css" rel="stylesheet"  />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo $host_addr;?>dist/css/skins/_all-skins.min.css" rel="stylesheet"  />
    <link rel="shortcut icon" href="<?php echo $host_addr;?>favicon.ico"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="register-page">
    <div class="register-box">
      <div class="register-logo">
        <a href="../../index2.html"><b>Admin</b>LTE</a>
      </div>

      <div class="register-box-body">
        <p class="login-box-msg">Register a new membership</p>
        <form action="../../index.html" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Full name"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Retype password"/>
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> I agree to the <a href="#">terms</a>
                </label>
              </div>                        
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
            </div><!-- /.col -->
          </div>
        </form>        

        <div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using Facebook</a>
          <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign up using Google+</a>
        </div>

        <a href="login.html" class="text-center">I already have a membership</a>
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->

    <!-- jQuery 2.1.3 -->
    <script src="<?php echo $host_addr;?>plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo $host_addr;?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="<?php echo $host_addr;?>scripts/js/jquery.jplayer.min.js"></script>
  <script src="<?php echo $host_addr;?>scripts/js/vendor/jquery.ui.widget.js"></script>
    <script src="<?php echo $host_addr;?>scripts/mylib.js" type="text/javascript"></script>
    <script src="<?php echo $host_addr;?>scripts/formchecker.js" type="text/javascript"></script>
    <!-- Select2 (Selcetion customizer) -->
    <script src='<?php echo $host_addr;?>plugins/select2/dist/js/select2.full.min.js'></script>
    <!-- Bootpag (oostrap paginator) -->
    <script src='<?php echo $host_addr;?>plugins/bootpag/jquery.bootpag.min.js'></script>
    <!-- SlimScroll -->
    <script src="<?php echo $host_addr;?>plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='<?php echo $host_addr;?>plugins/fastclick/fastclick.min.js'></script>
    <!-- InputMask -->
    <script src="<?php echo $host_addr;?>plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="<?php echo $host_addr;?>plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
    <!-- date-range-picker -->
    <script src="<?php echo $host_addr;?>plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="<?php echo $host_addr;?>plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <!-- date-picker -->
    <script src="<?php echo $host_addr;?>plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- bootstrap time picker -->
    <script src="<?php echo $host_addr;?>plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <!-- Moment js -->
    <script src="<?php echo $host_addr;?>plugins/moment/moment.js" type="text/javascript"></script>
    <!-- bootstrap Date-time picker -->
    <script src="<?php echo $host_addr;?>plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <!-- iCheck 1.0.1 -->
    <script src="<?php echo $host_addr;?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>

    <script src="<?php echo $host_addr;?>plugins/knob/jquery.knob.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="<?php echo $host_addr;?>plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- Jquery Sortable  -->
    <script src="<?php echo $host_addr;?>plugins/jquery-sortable/js/jquery-sortable.js" type="text/javascript"></script>
    <!-- RubaXa Sortable -->
  <script src="<?php echo $host_addr;?>plugins/rubaxa-sortable/js/Sortable.js"></script>
    
  
  <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
  <!--[if (gte IE 8)&(lt IE 10)]>
  <script src="js/cors/jquery.xdr-transport.js"></script>
  <![endif]-->
  <!-- end -->
    <!-- AdminLTE App -->
    <script src="<?php echo $host_addr;?>dist/js/app.js" type="text/javascript"></script>
    <script src="<?php echo $host_addr;?>scripts/lightbox.js" type="text/javascript"></script>
    <script src="<?php echo $host_addr;?>scripts/napstandadmin.js" type="text/javascript"></script>
  <script language="javascript" type="text/javascript" src="<?php echo $host_addr;?>scripts/js/tinymce/jquery.tinymce.min.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo $host_addr;?>scripts/js/tinymce/tinymce.min.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo $host_addr;?>scripts/js/tinymce/basic_config.js"></script>
  </body>
</html>