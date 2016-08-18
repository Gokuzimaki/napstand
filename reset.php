<?php  
session_start();
include('./snippets/connection.php');
$activemainlink="current activemainlink";
<<<<<<< HEAD
$activepage2="active";
// obtain data
include('snippets/headcontentfrjobconnect.php');
=======
$activepage=0;
$activepage_type="resetpassword";
  $mpagefooterclass="hidden";// hide the footer section
// obtain data
include('snippets/headcontentadmin.php');
$fullscript="";
>>>>>>> 45db6625e0494a8c8964ce2a582e22a2e47a988b
$mpagecrumbpath="";
$activemainlink6="current activemainlink";
$messageout="<h3>Password reset link sent</h3><p>A link has been sent to the email address you used, follow the link to reset your account password, sorry for any inconvenience</p>";
// get the user email
<<<<<<< HEAD
$email=isset($_POST['resetemail'])?mysql_real_escape_string($_POST['resetemail']):"";
$t=isset($_GET['t'])?mysql_real_escape_string($_GET['t']):"";
if($email!==""){
    // check if email exists in database of reg users
    else{
        $message="<h3>Password reset link sent</h3>
                    <p>The email address you put in did not belong to any registered users on the Frontiers Job-Connect platform, please use a correct email or if you made a mistake, contact us.</p>";
    }
}else if($t!==""&&$t=="reset"&&isset($_GET['h'])&&isset($_GET['checksum'])){
=======
// $email=isset($_POST['resetemail'])?mysql_real_escape_string($_POST['resetemail']):"";
$t=isset($_GET['t'])?mysql_real_escape_string($_GET['t']):"";
if($t!==""&&$t=="reset"&&isset($_GET['h'])&&isset($_GET['checksum'])){
>>>>>>> 45db6625e0494a8c8964ce2a582e22a2e47a988b
    $checksum=mysql_real_escape_string($_GET['checksum']);
    $userhash=mysql_real_escape_string($_GET['h']);
    // check the database for a match on the user
    $query="SELECT * FROM users WHERE MD5(id)='$userhash' AND EXISTS(SELECT * FROM resetpassword WHERE userid=`users`.`id` AND checksum='$checksum' AND status='active')";
    $run=mysql_query($query)or die(mysql_error()." ".__LINE__);
    $numrows=mysql_num_rows($run);
    if($numrows>0){
        $row=mysql_fetch_assoc($run);
        $messageout='
<<<<<<< HEAD
            <form class="fixed" name="presetform" action="snippets/edit.php" method="POST">
                <fieldset>
                    <input type="hidden" name="entryvariant" value="resetpassword">
                    <input type="hidden" name="entryid" value="'.$row['id'].'"/>
                    <input type="hidden" name="checksum" value="'.$checksum.'"/>
                    <p>
                        <input type="password" class="maxwidth" id="" name="password" placeholder="Reset Password"/>
                    </p>
                    <p>
                        <input type="password" class="maxwidth"  name="confirmpassword" placeholder="Confirm Password"/>
                    </p>                            
                     <p class="last">
                        <input class="btn text-uppercase"  type="button" name="resetpasswordsubmit" value="Submit">
                    </p>
                </fieldset>
            </form>
        ';
    }else{
        $messageout="<p>Sorry there seems to be a problem here, its either you have already run a reset through this link before or you attempted toying with the url, we strongly advice against that.</p>";
    }
=======
            <form class="fixed" name="resetform" action="snippets/edit.php" method="POST">
                    <input type="hidden" name="entryvariant" value="resetpassword">
                    <input type="hidden" name="entryid" value="'.$row['id'].'"/>
                    <input type="hidden" name="checksum" value="'.$checksum.'"/>
                    <input type="hidden" name="rettype" value="'.$row['usertype'].'"/>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" id="resetpassword" name="password" placeholder="New Password"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control"  id="confirmpassword" name="confirmpassword" placeholder="Confirm Password"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>                            
                    <div class="col-xs-4">
                      <input class="btn btn-primary btn-block btn-flat text-uppercase"  type="submit" name="resetpasswordsubmit" value="Submit">
                    </div><!-- /.col -->
                </fieldset>
            </form>
        ';
        $fullscript='
            <script>
                function handleResetForm() {
                    if(typeof $.fn.validate !== \'undefined\'){
                        $(\'form[name=resetform]\').validate({
                            errorClass: \'validation-error\', // so that it doesn\'t conflict with the error class of alert boxes
                            rules: {
                                password: {
                                        required: true,
                                        minlength: 6
                                    },
                                confirmpassword: {
                                    required: true,
                                    equalTo: "#resetpassword"
                                }
                            },
                            messages: {
                                password: {
                                        required: "Provide your new password"
                                    },
                                confirmpassword: {
                                    required: "Confirm your password"
                                }
                            },
                            submitHandler: function(form) {
                                $(form).submit();
                            }
                        });
                        console.log($.fn.validate);
                    }else{
                        window.alert("Library Missing");
                    }

                }
                handleResetForm();
            </script>
        ';
    }else{
        $messageout="<p>Sorry there seems to be a problem here, its either you have already run a reset through this link before or you attempted toying with the url, we strongly advice against that.</p>";
    }
}else if($t!==""&&$t=="resetdone"){
    $messageout='Password reset was successfully done, please go to your login view and try getting into your account with your new password.';
>>>>>>> 45db6625e0494a8c8964ce2a582e22a2e47a988b
}else{
    $messageout='NO data detected.';
}
?>
<<<<<<< HEAD
	<body>
		<noscript>
	        <div class="javascript-required">
	            <i class="fa fa-times-circle"></i> You seem to have Javascript disabled. This website needs javascript in order to function properly!
	        </div>
	    </noscript>
		<div id="main-wrapper">
	    	<?php include('snippets/toplinksfjobconnect.php');?>
			<div id="page-content">
				<div class="container">
					<div class="span8">
                        <?php echo $messageout;?>
                        
                    </div>
				</div> <!-- end .container -->
			</div> <!-- end #page-content -->
		</div>
		<?php 
		  include('./snippets/footerfjc.php');
		  include('./snippets/themescriptsdumpfjc.php');
		?>
	</body>
</html>
=======
  <body class="register-page">
    <div class="register-box">
      <div class="register-logo">
        <a href=""><b>Napstand</b> Password Reset</a>
      </div>
    </div><!-- /.register-box -->
    <div class="content-header">
      <!-- Main content -->
      <div class="register-box-body">
        <div class="login-box">
      
          <div class="login-box-body">
            <p class="login-box-msg">Reset your password</p>
            <?php echo $messageout;?>
            
          </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->
      </div>
    <script src="<?php echo $host_addr;?>plugins/jQuery/jQuery-2.1.3.min.js"></script>

    <script src="<?php echo $host_addr;?>scripts/mylib.js" type="text/javascript"></script>
    <!--Jquery validate   -->
    <script src='<?php echo $host_addr;?>plugins/jquery-validate/js/jquery.validate.js'></script>
    <script src="<?php echo $host_addr;?>scripts/formchecker.js" type="text/javascript"></script>
    <?php echo $fullscript;?>
  </body>
</html>
    
>>>>>>> 45db6625e0494a8c8964ce2a582e22a2e47a988b
