<?php
include('connection.php');
$logtype=$_POST['logtype'];
// echo $logtype;
if($logtype=="adminlogin"){
	$username=mysql_real_escape_string($_POST['username']);
	$password=mysql_real_escape_string($_POST['password']);
	$iniquery="SELECT * FROM admin WHERE username='$username' AND password='$password'";
	$inirun=mysql_query($iniquery)or die(mysql_error()." ".__LINE__);
	$numrows=mysql_num_rows($inirun);
	if($numrows>0){
		$row=mysql_fetch_assoc($inirun);
		session_start();
		$logpart=md5($host_addr);
		$_SESSION['logcheck'.$logpart.'']="off";
		$_SESSION['aduid'.$logpart.'']=$row['id'];
		$_SESSION['accesslevel'.$logpart.'']=$row['accesslevel'];
		header('location:../admin/adminindex.php');
	}else{
		$_SESSION['adminerror']=$_SESSION['adminerror']+1;
		//	echo $_SESSION['adminerror'];
		header('location:../admin/index.php?error=true');
	}
}elseif($logtype=="user"){
	$username=mysql_real_escape_string($_POST['username']);
	$password=mysql_real_escape_string($_POST['password']);
	$iniquery="SELECT * FROM users WHERE email='$username' AND pword='$password' AND usertype='user' AND status='active'";
		// echo $iniquery;
	$inirun=mysql_query($iniquery)or die(mysql_error()." ".__LINE__);
	$numrows=mysql_num_rows($inirun);
	if($numrows>0){
		$row=mysql_fetch_assoc($inirun);
		$id=$row['id'];
		session_start();
		$md5id=md5($id);
		$_SESSION['userhnapstand']=$md5id;
		$_SESSION['userinapstand']=$id;
		// echo $id;
		header('location:../userdashboard.php');
	}else{
		//	echo $_SESSION['adminerror'];
		header('location:../login.php?t=error');
	}
}elseif($logtype=="client"){
	$username=mysql_real_escape_string($_POST['username']);
	$password=mysql_real_escape_string($_POST['password']);
	$iniquery="SELECT * FROM users WHERE email='$username' AND pword='$password' AND usertype='client' and status='active'";
	$inirun=mysql_query($iniquery)or die(mysql_error()." ".__LINE__);
	$numrows=mysql_num_rows($inirun);
	if($numrows>0){
		$row=mysql_fetch_assoc($inirun);
		$id=$row['id'];
		session_start();
		$md5id=md5($id);
		$_SESSION['clienthnapstand']=$md5id;
		$_SESSION['clientinapstand']=$id;
		header('location:../clientdashboard.php');
	}else{
		//	echo $_SESSION['adminerror']; 
		header('location:../clientlogin.php?error=true');
	}
}
?>