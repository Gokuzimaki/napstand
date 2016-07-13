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
	$uid=isset($_GET['uid'])?$_GET['uid']:0;
	$uhash=md5($uid);
	$userid=$_SESSION['userinapstand'];
	$msg='Successfully Logged out';
	createNotification($userid,"users","logout",$msg);
	unset($_SESSION['userhnapstand']);
	unset($_SESSION['userinapstand']);
	header('location:../login.php?e=dologout&t=user');
}


}else{
	header('location:../index.php');
}
?>