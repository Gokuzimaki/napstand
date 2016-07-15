<?php
session_start();
include('connection.php');
if(isset($_GET['type'])||isset($_POST['type'])){
$type=isset($_GET['type'])?$_GET['type']:$_POST['type'];
if($type=="admin"){
	$logpart=md5($host_addr);
	$_SESSION['logcheck'.$logpart.'']="on";
	header('location:../admin/?l=true');
}elseif($type=="viewer"||$type=="user"){
	$uid=isset($_GET['uid'])?$_GET['uid']:0;
	$uhash=md5($uid);
	$userid=$_SESSION['userinapstand'];
	$msg='Successfully Logged out';
	createNotification($userid,"users","logout",$msg);
	unset($_SESSION['userhnapstand']);
	unset($_SESSION['userinapstand']);
	header('location:../login.php?e=dologout&t=user');

}elseif($type=="client"){
	$uid=isset($_GET['uid'])?$_GET['uid']:0;
	$uhash=md5($uid);
	$userid=$_SESSION['clientinapstand'];
	$msg='Successfully Logged out';
	createNotification($userid,"users","logout",$msg);
	unset($_SESSION['clienthnapstand']);
	unset($_SESSION['clientinapstand']);
	header('location:../clientlogin.php?e=dologout&t=client');
}elseif($type=="appuser"){
	$userid=isset($_GET['userid'])?$_GET['userid']:$_POST['userid'];
	// get previous login information
	$orderfield[0]='userid';
	$orderfield[1]='usertype';
	$orderfield[2]='action';
	$ordervalue[0]=$userid;
	$ordervalue[1]='users';
	$ordervalue[2]='login';
	$order=" ORDER BY id DESC";
	$limit=" LIMIT 0,1";
	$outlogprev=getNotifications('notifications',$orderfield,$ordervalue,$order,$limit);
	$lastloginid=0;
	// obtain last login id
	if($outlogprev['numrows']>0){
		$lastloginid=$outlogprev['id'];
	}
	// get log out information
	$orderfield[0]='userid';
	$orderfield[1]='usertype';
	$orderfield[2]='action';
	$ordervalue[0]=$userid;
	$ordervalue[1]='users';
	$ordervalue[2]='logout';
	$order=" ORDER BY id DESC";
	$limit=" LIMIT 0,1";
	$outlogprev2=getNotifications('notifications',$orderfield,$ordervalue,$order,$limit);
	$lastlogoutid=0;
	// obtain last logout date
	if($outlogprev2['numrows']>0){
		$lastlogoutid=$outlogprev2['id'];				
	}
	if($lastlogoutid<$lastloginid){
		// this means the current user is on a device that hasn't been logged in
		// or they are first timers
		$msg='Successfully Logged out';
		$success="true";
		createNotification($userid,"users","logout",$msg);
	}else{
		$msg='Already logged out';
		$success="false";		
	}
	echo json_encode(array('success' => "$success",'msg' => "$msg",'userid' =>"$userid"));
}


}else{
	header('location:../index.php');
}
?>