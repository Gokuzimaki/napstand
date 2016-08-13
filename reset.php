<?php  
session_start();
include('./snippets/connection.php');
$activemainlink="current activemainlink";
$activepage2="active";
// obtain data
include('snippets/headcontentfrjobconnect.php');
$mpagecrumbpath="";
$activemainlink6="current activemainlink";
$messageout="<h3>Password reset link sent</h3><p>A link has been sent to the email address you used, follow the link to reset your account password, sorry for any inconvenience</p>";
// get the user email
$email=isset($_POST['resetemail'])?mysql_real_escape_string($_POST['resetemail']):"";
$t=isset($_GET['t'])?mysql_real_escape_string($_GET['t']):"";
if($email!==""){
    // check if email exists in database of reg users
    else{
        $message="<h3>Password reset link sent</h3>
                    <p>The email address you put in did not belong to any registered users on the Frontiers Job-Connect platform, please use a correct email or if you made a mistake, contact us.</p>";
    }
}else if($t!==""&&$t=="reset"&&isset($_GET['h'])&&isset($_GET['checksum'])){
    $checksum=mysql_real_escape_string($_GET['checksum']);
    $userhash=mysql_real_escape_string($_GET['h']);
    // check the database for a match on the user
    $query="SELECT * FROM users WHERE MD5(id)='$userhash' AND EXISTS(SELECT * FROM resetpassword WHERE userid=`users`.`id` AND checksum='$checksum' AND status='active')";
    $run=mysql_query($query)or die(mysql_error()." ".__LINE__);
    $numrows=mysql_num_rows($run);
    if($numrows>0){
        $row=mysql_fetch_assoc($run);
        $messageout='
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
}else{
    $messageout='NO data detected.';
}
?>
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