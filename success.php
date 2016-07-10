<?php 
session_start();
include('./snippets/connection.php');
$tid="no trans id";
$fid="no file id";
$dquery="Noquery found";
$outputheading='';
$date=date("Y-m-d H:i:s");
$extraout='
	Your transaction was successful<br> 
	You can go back to the application now
	and enjoy your purchase
';
if(isset($_SESSION['transaction_id'])&&$_SESSION['transaction_id']!==""){
	$tid=$_SESSION['transaction_id'];
	$dquery=$_SESSION['noquery'];
	// $fid=$_SESSION[''.$tid.''];
}
$demout="";
if(isset($host_vogue_merchantid)&&$host_vogue_merchantid=="demo"){
	$demout="&demo=true";
}
$transtype="voguepay";
if(isset($_GET['ttype'])&&$_GET['ttype']!==""){
	$transtype=strtolower($_GET['ttype']);
}
if(isset($_POST['transaction_id'])&&$transtype=="voguepay"){
	$merchant_id=$host_vogue_merchantid;
	$tid=$_POST['transaction_id'];
	// $extraout.=" Transid :=> $tid ";
	//get the full transaction details as a json from voguepay
	$json = file_get_contents('https://voguepay.com/?v_transaction_id='.$_POST['transaction_id'].'&type=json'.$demout.'');
	//create new array to store our transaction detail
	$transaction = json_decode($json, true);
	/*
	Now we have the following keys in our $transaction array
	$transaction['merchant_id'],
	$transaction['transaction_id'],
	$transaction['email'],
	$transaction['total'], 
	$transaction['merchant_ref'], 
	$transaction['memo'],
	$transaction['status'],
	$transaction['date'],
	$transaction['referrer'],
	$transaction['method']
	*/
	// verify the current transaction as unique in the transactions database
	$ttransdata=getAllTransactions("admin","all","verifytransactionid","",$_POST['transaction_id']);
	if($ttransdata['numrows']<1){
		$fid=0;
		if($transaction['merchant_ref']!==""){
			// $parsedata=json_encode($transaction['merchant_ref']);
			$truetrans=str_replace("\'",'',str_replace("{", "", str_replace("}", "", $transaction['merchant_ref'])));
			$mercdata=explode(",",$truetrans);
			$merchcount=count($mercdata);
			for($i=0;$i<$merchcount;$i++){
				$curdat=$mercdata[$i];
				// explode it
				$curdata=explode(":", $curdat);
				// create variables and associated values
				$$curdata[0]=$curdata[1];
			}
			// $extraout.=" Parsedata: ".$fid." $platform, $ttype";
		}
		if((isset($_GET['fid'])&&$_GET['fid']>0)||$fid>0){
			$fid=isset($fid)?$fid:$_GET['fid'];// the local id for transaction or value for contentidcolumn
			$tid=$_POST['transaction_id'];
			$ftype="";// the table name for the associated content purchased
			$_SESSION['transaction_id']=$_POST['transaction_id'];
			// $_SESSION[''.$tid.'']=$_GET['fid'];
			$email=$transaction['email'];
			$price=$transaction['total'];
			$vstatus=$transaction['status'];
			$transactiontype=isset($platform)?$platform:(isset($_GET['platform'])&&$_GET['platform']!==""?$_GET['platform']:"");
		
			//redirection block for failed transactions
			if($transaction['total'] == 0)header('location:failure.php?er=total&msg=Invalid Amount&tid='.$tid.'');
			if($transaction['status'] !== 'Approved')header('location:failure.php?er=status&msg=Unapproved transaction&tid='.$tid.'');
			// $stub=md5($fid.$tid);
			// $_SESSION['stub_download']=$host_addr."snippets/download.php?stub=$stub";
			/*$stubfile=$host_addr."snippets/download.php?stub=$stub";
			$date= date("Y-m-d")."";
			$enddate=date('Y-m-d', strtotime('2 days'));
			$query="INSERT INTO transaction(voguerefid,amountpaid,email,fileid,stublink,startdate,enddate,voguestatus)VALUES
			('$tid','$price','$email','$fid','$stub','$date','$enddate','$vstatus')";*/
			// echo $query;

			// work on getting the last entry into the database
		    //and sort out the next entry for it
		    $query="SELECT * FROM transaction WHERE transactiontype='$transactiontype' AND voguestatus='Approved' ORDER BY id DESC";
		    $run=mysql_query($query)or die(mysql_error()." Line ".__LINE__);
		    $numrowsfetch=mysql_num_rows($run);
		    $nextnumeric="";
		    $nextalpha="";
		    if($numrowsfetch>0){
			    $row=mysql_fetch_assoc($run);
		        //check the current alphabet section and numeric counter part
		        // numeric check
		        $usernumeric=$row['usernumeric'];
		        $useralpha=$row['useralpha'];
		        if($usernumeric<999){
		        	$nextnumeric=$usernumeric+1;
		        	//sort out the xtra zeros to be added to the numeric character
		        	//for the user reference id
		        	$nextnumeric=$nextnumeric<10?"00$nextnumeric":($nextnumeric>10&&$nextnumeric<100?"0$nextnumeric":$nextnumeric);
		        	$nextalpha=$useralpha;
		        }else{
		        	$nextnumeric="001";
		        	$nextalpha=++$useralpha;
		        }
		    }else{
		      $nextalpha="AA";
		      $nextnumeric="001";
		    }

			//run the necessary updates, affected fields are status voguerefid,voguestatus
			if($transactiontype=="course"){
				$tdata=getSingleTransaction($fid);//get the transaction data
				genericSingleUpdate("transaction","useralpha","$nextalpha","id","$fid");
				genericSingleUpdate("transaction","usernumeric","$nextnumeric","id","$fid");
				genericSingleUpdate("transaction","status","active","id","$fid");
				genericSingleUpdate("transaction","voguestatus","$vstatus","id","$fid");
				genericSingleUpdate("transaction","voguerefid","$tid","id","$fid");

				$tdata=getSingleTransaction($fid);//refresh transaction data
				$messageone="Thank you for making a purchase from our Course list.<br> 
					Your transaction reference number is - $tid.<br>
					Your User reference ID is - '.$nextalpha.''.$nextnumeric.'.<br>
					We will contact you in the next 24 hours with the details of your courses and your
					login information to our Learning Management System. If you are encountering any problems,
					please use the contact details below, we will attend to you promptly.
					<br>
					Helpline :  +234 (0) 818 645 5541<br>
					Email: <a href=\"mailto:services@maxmigold.com\">services@maxmigold.com</a>  <br>
					Thank you.
				";
				//Admin notification email
				$messagetwo='
					A new transaction was successfully completed on the Max-Migold website<br>
					The details are as follows:<br>
					User Reference ID: <b>'.$nextalpha.''.$nextnumeric.'</b>
					Fullname: <b>'.$tdata['fullname'].'
					Username: <b>'.$tdata['username'].'
					Phonenumber: <b>'.$tdata['phonenumber'].'
					Email: <b>'.$tdata['email'].'
					Details:<br>
						Courses: '.$tdata['coursegroupsout'].'<br>
						Modules: '.$tdata['coursesubjectsout'].'
				';
			}else if ($transactiontype=="mobileapp") {
				# code...
				$curid=getNextIdExplicit('transaction');
				$ftype='contententries';
				$userid=0;
				$usertype="users";
				if((isset($_GET['uid'])&&$_GET['uid']>0)||$uid>0){
					$userid=isset($uid)&&$uid>0?$uid:$_GET['uid'];
					$userdata=getSingleUserPlain($userid);
					$contentdata=getSingleContentEntry($fid);
					$query="INSERT INTO transaction(voguerefid,amountpaid,email,contentid,contenttype,
						transactiontime,userid,usertype,voguestatus)VALUES
						('$tid','$price','$email','$fid','$ftype','$date','$userid','$usertype','$vstatus')";
					$run=mysql_query($query)or die(mysql_error()." Line ".__LINE__);
					$tdata=getSingleTransaction($curid);//refresh transaction data
					$emailsubjectone='Napstand, Content Purchase.';
					$messageone="Thank you for making a purchase from our Platform.<br> 
						Your transaction reference number is - $tid.<br>
						You now have full access to the content you purchased, simply head
						back to the mobile-app and check it out there.<br>
						Purchase Details:<br>
						".$contentdata['prow']['contenttitle']." - ".$contentdata['titlerow']."
						<br>
						Helpline : $host_phonenumbers<br>
						Email: <a href=\"mailto:$host_support_email_addr\">$host_support_email_addr</a>  <br>
						Thank you.
					";
					//Admin notification email
					$emailsubjecttwo='Content Purchase on Napstand.';
					$messagetwo='
						A new transaction was successfully completed on the Napstand Platform<br>
						The details are as follows:<br>
						Transaction Type: <b>'.$transtype.'</b>
						Refnumber : <b>'.$transtype.'</b>
						Fullname: <b>'.$userdata['nameout'].'
						Email: <b>'.$tdata['email'].'
						Purchase Details:<br>
						'.$contentdata['prow']['contenttitle'].' - '.$contentdata['titlerow'].'
					';
				}
			}
			// $extraout.=$messagetwo;
			$_SESSION['noquery']=$query;
			// if($transaction['merchant_id'] !== $merchant_id){header('location:failure.php?er=mid&msg=Invalid Merchant&tid='.$tid.'');}

			// $run=mysql_query($query)or die(mysql_error()." Line 57");
			$toemail=$email;
			$subject="$emailsubjectone";
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: <store@napstand.com>' . "\r\n";
			if($host_email_send===true){
				if(mail($toemail,$subject,$messageone,$headers)){

				}else{
					$extraout='Something went wrong and we are handling it, meantime you could click the back button in your browser to get you out of here, we are really sorry';
					// die('could not send Your email, something went wrong and we are handling it, meantime you could click the back button in your browser to get you out of here, we are really sorry');
				}
			}

			
			$toemail="$host_info_email_addr";
			$subject="$emailsubjecttwo";
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: <paymentservices@napstand.com>' . "\r\n";
			if($host_email_send===true){
				if(mail($toemail,$subject,$messagetwo,$headers)){

				}else{
					$extraout='Something went wrong and we are handling it, meantime you could click the back button in your browser to get you out of here, we are really sorry';
					// die('could not send Your email, something went wrong and we are handling it, meantime you could click the back button in your browser to get you out of here, we are really sorry');
				}
			}
			/*You can do anything you want now with the transaction details or the merchant reference.
			You should query your database with the merchant reference and fetch the records you saved for this transaction.
			Then you should compare the $transaction['total'] with the total from your database.*/

			// header('location:transactionsuccess.php');
			
		}
	}
}
$activepage6="current_page_item current-menu-ancestor current-menu-parent current_page_parent current_page_ancestor";
$mpagefooterclass="hidden";// hide the footer section

include('./snippets/headcontentadmin.php');

?>
  <body class="register-page">
	    <div class="register-box">
	      <div class="register-logo">
	        <a href=""><b>Napstand</b> Purchases</a>
	      </div>
	    </div><!-- /.register-box -->
	    <div class="content-header">
	      <!-- Main content -->
	        <section class="invoice">
	        	<div class="row">
	                <div class="col-md-12 text-center invoice-col">
	                  <?php echo $extraout;?>
	                </div><!-- /.col -->

	              </div><!-- /.row -->
	        </section>
	    <?php include('./snippets/footeradmin.php');?>
	</body>
</html>