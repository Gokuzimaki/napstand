<?php
include('connection.php');
/*if(isset()){

}*/
// header("Access-Control-Allow-Origin: *");
session_start();

$displaytype="";
$test="";
$extraval="admin";
$todaynow=date("Y-m-d H:i:s");

if(isset($_GET['displaytype'])){
	$displaytype=$_GET['displaytype'];
}

if(isset($_GET['extraval'])){
	$extraval=$_GET['extraval'];
}
if(isset($_POST['extraval'])){
	$extraval=$_POST['extraval'];
}
if (isset($_POST['displaytype'])) {
	$displaytype=$_POST['displaytype'];	
}

if (isset($_GET['test'])) {
	$test=$_GET['test'];	
}

if (isset($_POST['test'])) {
	$test=$_POST['test'];	
}

if($displaytype==""){
// echo $displaytype;

}elseif($displaytype=="appuserlogin"){
	$logtype=$displaytype;
	// echo $logtype;
	if($test!==""){
		$username=mysql_real_escape_string($_GET['username']);
		$password=mysql_real_escape_string($_GET['password']);
		
	}else if ($test=="") {
		# code...
		$username=mysql_real_escape_string($_POST['username']);
		$password=mysql_real_escape_string($_POST['password']);
	}
	$iniquery="SELECT * FROM users WHERE email='$username' AND pword='$password' AND usertype='appuser'";
	$inirun=mysql_query($iniquery)or die(mysql_error()." ".__LINE__);
	$numrows=mysql_num_rows($inirun);
	if($numrows>0){
		$row=mysql_fetch_assoc($inirun);
		$userid=$row['id'];
		$userdata=getSingleUser($userid);
		$firstname=$row['firstname'];
		$middlename=$row['middlename'];
		$lastname=$row['lastname'];
		$status=$row['status'];
		$msg="Logged in Successfully";
		// notificationtable entry
		// $notificationdetails="Logged into napstand";
		if($status=="active"){
			// get a login hash for this user
			$hashvar=$userid."_".date("Y-m-d H:i:s");
			$hashvar=md5($hashvar);
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
			$lastloghash="";
			// obtain last login id
			if($outlogprev['numrows']>0){
				// $lastloginid=$outlogprev['numrows']>1?$outlogprev[0]['id']:$outlogprev['id'];
				$lastloginid=$outlogprev['id'];
				// get last loginhash
				$lastloghash=$outlogprev['actionhash'];
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
			$outlogprev2=getNotifications('',$orderfield,$ordervalue,$order,$limit);
			$lastlogoutid=0;
			// obtain last logout date
			if($outlogprev2['numrows']>0){
				// $lastlogoutid=$outlogprev2['numrows']>1?$outlogprev2[0]['id']:$outlogprev2['id'];				
				$lastlogoutid=$outlogprev2['id'];				
			}
			if(($lastlogoutid>$lastloginid)||($lastloginid>$lastlogoutid&&$lastloghash=="")){
				// this means the current user is on a device that hasn't been logged in
				// or they are first timers
				createNotification($userid,"users","login","$msg","","","$hashvar");
	 			echo json_encode(array(	"success"=>"true",
	 									"msg"=>"$msg",
	 									"userid"=>"$userid",
	 									"firstname"=>"$firstname",
	 									"lastname"=>"$lastname",
	 									"middlename"=>"$middlename",
	 									"devicehash"=>"$hashvar",
	 									"status"=>"$status"));
			}else{
				$devicehash="";
				if(isset($_GET['devicehash'])){
					$devicehash=$_GET['devicehash'];
				}
				if(isset($_POST['devicehash'])){
					$devicehash=$_POST['devicehash'];
				}
				// $devicehash="b395107a236cd564a1ce82ef25f642b9";
				if($devicehash!==""&&$devicehash==$lastloghash){
					genericSingleUpdate('notifications',"entrydate","$todaynow",'id',"$lastloginid");
					// createNotification($userid,"users","login",$msg,"","","$hashvar");
		 			echo json_encode(array(	"success"=>"true","msg"=>"$msg","userid"=>"$userid","firstname"=>"$firstname","lastname"=>"$lastname","middlename"=>"$middlename","devicehash"=>"$lastloghash","status"=>"$status"));					
				}else{
					$msg="Login Failure, Account is still active on a device";
					// $curhashvar=$outlogprev['numrows']>1?$outlogprev[0]['actionhash']:$outlogprev['actionhash'];
					$curhashvar=$outlogprev['actionhash'];
		 			echo json_encode(array("success"=>"false","msg"=>"$msg","userid"=>"$userid","firstname"=>"$firstname","lastname"=>"$lastname","middlename"=>"$middlename","devicehash"=>"","status"=>"$status"));

				}

			}
			if($test!==""){

			}
		}else{
			$msg="Account has been disabled";
			if($test==""){
				createNotification($userid,"users","loginfailure",$msg);
 			}
 			echo json_encode(array("success"=>"false","msg"=>"$msg","userid"=>"","firstname"=>"","middlename"=>"","lastname"=>"","status"=>""));
		}
	}else{
		$msg="Log in failure";
		createNotification($userid,"users","login",$msg);
 		echo json_encode(array("success"=>"false","msg"=>"$msg","userid"=>"","firstname"=>"","middlename"=>"","lastname"=>"","status"=>""));
	}
}else if ($displaytype=="fetchcategories") {
	# code...
	if($test!==""){
		$page=mysql_real_escape_string($_GET['page']);
		$userid=mysql_real_escape_string($_GET['userid']);
		
	}else if ($test=="") {
		# code...
		$page=mysql_real_escape_string($_POST['page']);
		$userid=mysql_real_escape_string($_POST['userid']);
	}
	$prevlimit=($page*$host_app_pull_limit)-$host_app_pull_limit>0?($page*$host_app_pull_limit)-$host_app_pull_limit:0;
	$nextlimit=$page*$host_app_pull_limit;
	$limit="LIMIT $prevlimit,$nextlimit";
	// echo $limit."<br>";
	$outs=getAllContentCategory('viewer',$limit);
	$totalpages=$outs['num_pages'];
	$numrows=$outs['numrows'];
	if($numrows>0){
		$msg="Retrieval Successful";
	 	echo json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalpages"=>"$totalpages"));
	 	if($test!==""){
			$scriptout='
			<script>
				var sdata='.json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalpages"=>"$totalpages")).';
			</script>
			';
			echo $scriptout;
		}	
	}else{
		$msg="Retrieval fail";
		echo json_encode(array("success"=>"false","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"totalpages"=>"0"));

	}
}else if ($displaytype=="fetchcategoryusers") {
	# code...
	if($test!==""){
		$page=mysql_real_escape_string($_GET['page']);
		$userid=mysql_real_escape_string($_GET['userid']);
		$catid=mysql_real_escape_string($_GET['catid']);
		
	}else if ($test=="") {
		# code...
		$page=mysql_real_escape_string($_POST['page']);
		$userid=mysql_real_escape_string($_POST['userid']);
		$catid=mysql_real_escape_string($_POST['catid']);
	}
	$prevlimit=($page*$host_app_pull_limit)-$host_app_pull_limit>0?($page*$host_app_pull_limit)-$host_app_pull_limit:0;
	$nextlimit=$page*$host_app_pull_limit;
	$limit="LIMIT $prevlimit,$nextlimit";
	// echo $limit."<br>";
	$type="catidtwo";
	$typeid=array();
	$typeid[0]=$userid;
	$typeid[1]=$catid;
	$outs=getAllParentContent('viewer',$type,$typeid,$limit);
	$totalpages=$outs['num_pages'];
	$numrows=$outs['numrows'];
	if($numrows>0){
		$msg="Retrieval Successful";
	 	echo json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalpages"=>"$totalpages"));
	 	if($test!==""){
			$scriptout='
			<script>
				var sdata='.json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalpages"=>"$totalpages")).';
			</script>
			';
			echo $scriptout;
		}	
	}else{
		$msg="Retrieval fail";
		echo json_encode(array("success"=>"false","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"totalpages"=>"0"));

	}
}else if ($displaytype=="fetchcategoryuserentries") {
	# code...
	if($test!==""){
		$page=mysql_real_escape_string($_GET['page']);
		$catid=mysql_real_escape_string($_GET['catid']);
		$userid=mysql_real_escape_string($_GET['userid']);
		$webuserid=mysql_real_escape_string($_GET['webuserid']);
		
	}else if ($test=="") {
		# code...
		$page=mysql_real_escape_string($_POST['page']);
		$userid=mysql_real_escape_string($_POST['userid']);
		$catid=mysql_real_escape_string($_POST['catid']);
		$webuserid=mysql_real_escape_string($_POST['webuserid']);
	}
	$prevlimit=($page*$host_app_pull_limit)-$host_app_pull_limit>0?($page*$host_app_pull_limit)-$host_app_pull_limit:0;
	$nextlimit=$page*$host_app_pull_limit;
	$limit="LIMIT $prevlimit,$nextlimit";
	// echo $limit."<br>";
	$type="usertypeout";
	$typeid=array();
	$typeid[0]=$webuserid;
	$typeid[1]=$catid;
	$outs=getAllParentContent('viewer',$type,$typeid,$limit);
	$totalpages=$outs['num_pages'];
	$numrows=$outs['numrows'];
	if($numrows>0){
		$msg="Retrieval Successful";
	 	echo json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalpages"=>"$totalpages"));
	 	if($test!==""){
			$scriptout='
			<script>
				var sdata='.json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalpages"=>"$totalpages")).';
			</script>
			';
			echo $scriptout;
		}	
	}else{
		$msg="Retrieval fail";
		echo json_encode(array("success"=>"false","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"totalpages"=>"0"));

	}
}else if ($displaytype=="pullfromnextentrysetparentcontent"||$displaytype=="pullfromlastentrysetparentcontent") {
	# code...	
	if($test!==""){
		$page=mysql_real_escape_string($_GET['page']);
		$catid=mysql_real_escape_string($_GET['catid']);
		$userid=mysql_real_escape_string($_GET['userid']);
		$webuserid=mysql_real_escape_string($_GET['webuserid']);
		$lastid=isset($_GET['lastid'])?mysql_real_escape_string($_GET['lastid']):0;
		$nextid=isset($_GET['nextid'])?mysql_real_escape_string($_GET['nextid']):0;
	}else if ($test=="") {
		# code...
		$page=mysql_real_escape_string($_POST['page']);
		$userid=mysql_real_escape_string($_POST['userid']);
		$catid=mysql_real_escape_string($_POST['catid']);
		$webuserid=mysql_real_escape_string($_POST['webuserid']);
		$lastid=isset($_POST['lastid'])?mysql_real_escape_string($_POST['lastid']):0;
		$nextid=isset($_POST['nextid'])?mysql_real_escape_string($_POST['nextid']):0;
	}
	$prevlimit=($page*$host_app_pull_limit)-$host_app_pull_limit>0?($page*$host_app_pull_limit)-$host_app_pull_limit:0;
	$nextlimit=$page*$host_app_pull_limit;
	$limit="LIMIT $prevlimit,$nextlimit";
	// echo $limit."<br>";
	$type="$displaytype";
	$typeid=array();
	$typeid[0]=$webuserid;
	$typeid[1]=$catid;
	$typeid[2]=$lastid;
	$typeid[3]=$nextid;
	$outs=getAllParentContent('viewer',$type,$typeid,$limit);
	$totalpages=$outs['num_pages'];
	$numrows=$outs['numrows'];
	if($numrows>0){
		$msg="Retrieval Successful";
	 	echo json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalpages"=>"$totalpages"));
	 	if($test!==""){
			$scriptout='
			<script>
				var sdata='.json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalpages"=>"$totalpages")).';
			</script>
			';
			echo $scriptout;
		}	
	}else{
		$msg="Retrieval fail";
		echo json_encode(array("success"=>"false","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"totalpages"=>"0"));

	}
}else if ($displaytype=="fetchmurals") {
	# code...
	if($test!==""){
		$page=mysql_real_escape_string($_GET['page']);
		$userid=mysql_real_escape_string($_GET['userid']);
		
	}else if ($test=="") {
		# code...
		$page=mysql_real_escape_string($_POST['page']);
		$userid=mysql_real_escape_string($_POST['userid']);
	}
	$prevlimit=($page*$host_app_pull_limit)-$host_app_pull_limit>0?($page*$host_app_pull_limit)-$host_app_pull_limit:0;
	$nextlimit=$page*$host_app_pull_limit;
	$limit="LIMIT $prevlimit,$nextlimit";
	// echo $limit."<br>";
	$outs=getMurals('viewer',"$limit");
	// $totalpages=$outs['num_pages'];
	$totalpages=$outs['numrows'];
	$numrows=$outs['numrows'];
	if($numrows>0){
		$msg="Retrieval Successful";
	 	echo json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalmurals"=>"$totalpages"));
	 	if($test!==""){
			$scriptout='
			<script>
				var sdata='.json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalmurals"=>"$totalpages")).';
			</script>
			';
			echo $scriptout;
		}	
	}else{
		$msg="Retrieval fail";
		echo json_encode(array("success"=>"false","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"totalpages"=>"0"));

	}
}else if ($displaytype=="fetchparentcontentuserslist") {
	# code...
	if($test!==""){
		$page=mysql_real_escape_string($_GET['page']);
		$catid=mysql_real_escape_string($_GET['catid']);
		$userid=mysql_real_escape_string($_GET['userid']);
		$webuserid=mysql_real_escape_string($_GET['webuserid']);
		
	}else if ($test=="") {
		# code...
		$page=mysql_real_escape_string($_POST['page']);
		$userid=mysql_real_escape_string($_POST['userid']);
		$catid=mysql_real_escape_string($_POST['catid']);
		$webuserid=mysql_real_escape_string($_POST['webuserid']);
	}
	$prevlimit=($page*$host_app_pull_limit)-$host_app_pull_limit>0?($page*$host_app_pull_limit)-$host_app_pull_limit:0;
	$nextlimit=$page*$host_app_pull_limit;
	$limit="LIMIT $prevlimit,$nextlimit";
	// echo $limit."<br>";
	$type="catcontentout";
	$typeid=array();
	$typeid[0]=$catid;
	$typeid[1]="";
	$typeid[2]="";
	$typeid[3]=$webuserid;
	$outs=getAllContentEntries('viewer',$type,$typeid,$limit,"","",$userid);
	$totalpages=$outs['num_pages'];
	$numrows=$outs['numrows'];
	if($numrows>0){
		$msg="Retrieval Successful";
	 	echo json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalpages"=>"$totalpages"));
	 	if($test!==""){
			$scriptout='
			<script>
				var sdata='.json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalpages"=>"$totalpages")).';
			</script>
			';
			echo $scriptout;
		}	
	}else{
		$msg="Retrieval fail";
		echo json_encode(array("success"=>"false","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"totalpages"=>"0"));

	}
}else if ($displaytype=="fetchparentcontententries") {
	# code...
	if($test!==""){
		$page=mysql_real_escape_string($_GET['page']);
		$pcid=mysql_real_escape_string($_GET['pcid']);
		$userid=mysql_real_escape_string($_GET['userid']);
		
	}else if ($test=="") {
		# code...
		$page=mysql_real_escape_string($_POST['page']);
		$userid=mysql_real_escape_string($_POST['userid']);
		$pcid=mysql_real_escape_string($_POST['pcid']);
	}
	$prevlimit=($page*$host_app_pull_limit)-$host_app_pull_limit>0?($page*$host_app_pull_limit)-$host_app_pull_limit:0;
	$nextlimit=$page*$host_app_pull_limit;
	$limit="LIMIT $prevlimit,$nextlimit";
	// echo $limit."<br>";
	$type="parentidtwo";
	$typeid=array();
	$typeid[0]=$pcid;
	$typeid[1]="published";
	$typeid[2]="";
	$typeid[3]="";
	$outs=getAllContentEntries('viewer',$type,$typeid,$limit,"","",$userid);
	$totalpages=$outs['num_pages'];
	$numrows=$outs['numrows'];
	if($numrows>0){
		$msg="Retrieval Successful";
	 	echo json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalpages"=>"$totalpages"));
	 	if($test!==""){
			$scriptout='
			<script>
				var sdata='.json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalpages"=>"$totalpages")).';
			</script>
			';
			echo $scriptout;
		}	
	}else{
		$msg="Retrieval fail";
		echo json_encode(array("success"=>"false","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"totalpages"=>"0"));

	}
}else if ($displaytype=="pullfromnextentryset"||$displaytype=="pullfromlastentryset") {
	# code...
	if($test!==""){
		$page=mysql_real_escape_string($_GET['page']);
		$pcid=mysql_real_escape_string($_GET['pcid']);
		$userid=mysql_real_escape_string($_GET['userid']);
		$lastid=isset($_GET['lastid'])?mysql_real_escape_string($_GET['lastid']):0;
		$nextid=isset($_GET['nextid'])?mysql_real_escape_string($_GET['nextid']):0;
	}else if ($test=="") {
		# code...
		$page=mysql_real_escape_string($_POST['page']);
		$userid=mysql_real_escape_string($_POST['userid']);
		$pcid=mysql_real_escape_string($_POST['pcid']);
		$lastid=isset($_POST['lastid'])?mysql_real_escape_string($_POST['lastid']):0;
		$nextid=isset($_POST['nextid'])?mysql_real_escape_string($_POST['nextid']):0;
	}
	$prevlimit=($page*$host_app_pull_limit)-$host_app_pull_limit>0?($page*$host_app_pull_limit)-$host_app_pull_limit:0;
	$nextlimit=$page*$host_app_pull_limit;
	$limit="LIMIT $prevlimit,$nextlimit";
	// echo $limit."<br>";
	$type="parentid";
	$typeid=array();
	$typeid[0]=$pcid;
	$typeid[1]="$displaytype";
	$typeid[2]="";
	$typeid[3]="";
	$typeid[4]=$lastid;
	$typeid[5]=$nextid;
	$outs=getAllContentEntries('viewer',$type,$typeid,$limit,"","",$userid);
	$totalpages=$outs['num_pages'];
	$numrows=$outs['numrows'];
	if($numrows>0){
		$msg="Retrieval Successful";
	 	echo json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalpages"=>"$totalpages"));
	 	if($test!==""){
			$scriptout='
			<script>
				var sdata='.json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalpages"=>"$totalpages")).';
			</script>
			';
			echo $scriptout;
		}	
	}else{
		$msg="Retrieval fail";
		echo json_encode(array("success"=>"false","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"totalpages"=>"0"));

	}
}else if ($displaytype=="fetchcontententry") {
	# code...
	if($test!==""){
		$page=mysql_real_escape_string($_GET['page']);
		$userid=mysql_real_escape_string($_GET['userid']);
		$cid=mysql_real_escape_string($_GET['cid']);
		
	}else if ($test=="") {
		# code...
		$page=mysql_real_escape_string($_POST['page']);
		$userid=mysql_real_escape_string($_POST['userid']);
		$cid=mysql_real_escape_string($_POST['cid']);
	}
	$prevlimit=($page*$host_app_pull_limit)-$host_app_pull_limit>0?($page*$host_app_pull_limit)-$host_app_pull_limit:0;
	$nextlimit=$page*$host_app_pull_limit;
	$limit="LIMIT $prevlimit,$nextlimit";
	// echo $limit."<br>";
	$outs=getSingleContentEntry($cid,"",$userid);
	$totalpages=1;
	$numrows=1;
	if($numrows>0){
		$msg="Retrieval Successful";
	 	echo json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdatatwo'],"page"=>"$page","totalpages"=>"$totalpages"));
	 	if($test!==""){
			$scriptout='
			<script>
				var sdata='.json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdatatwo'],"page"=>"$page","totalpages"=>"$totalpages")).';
			</script>
			';
			echo $scriptout;
		}	
	}else{
		$msg="Retrieval fail";
		echo json_encode(array("success"=>"false","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdatatwo'],"totalpages"=>"0"));

	}
}else if ($displaytype=="fetchclientdata"||$displaytype=="fetchuserdata"||$displaytype=="fetchappuserdata") {
	# code...
	if($test!==""){
		$page=mysql_real_escape_string($_GET['page']);
		$userid=mysql_real_escape_string($_GET['userid']);		
	}else if ($test=="") {
		# code...
		$page=mysql_real_escape_string($_POST['page']);
		$userid=mysql_real_escape_string($_POST['userid']);
	}
	$prevlimit=($page*$host_app_pull_limit)-$host_app_pull_limit>0?($page*$host_app_pull_limit)-$host_app_pull_limit:0;
	$nextlimit=$page*$host_app_pull_limit;
	$limit="LIMIT $prevlimit,$nextlimit";
	// echo $limit."<br>";
	$usertestout="";
	$outs=getSingleUserPlain($userid);
	$numval=0;
	if($displaytype=="fetchappuserdata"&&$outs['usertype']=='appuser'){
		$numval=1;
	}else if($displaytype=="fetchuserdata"&&$outs['usertype']=='user'){
		$numval=1;

	}else if($displaytype=="fetchclientdata"&&$outs['usertype']=='client'){
		$numval=1;
		
	}
	$totalpages=$numval;
	$numrows=$numval;
	if($numrows>0){
		$msg="Retrieval Successful";
	 	echo json_encode(array("success"=>"true","msg"=>"$msg","catdata"=>$outs,"page"=>"$page","totalpages"=>"$totalpages"));
	 	if($test!==""){
			$scriptout='
			<script>
				var sdata='.json_encode(array("success"=>"true","msg"=>"$msg","catdata"=>$outs,"page"=>"$page","totalpages"=>"$totalpages")).';
			</script>
			';
			echo $scriptout;
		}	
	}else{
		$msg="Retrieval fail";
		echo json_encode(array("success"=>"false","msg"=>"$msg","userid"=>"$userid","catdata"=>"","totalpages"=>"0"));

	}
}else if ($displaytype=="transactions") {
	# code...
	if($test!==""){
		$page=mysql_real_escape_string($_GET['page']);
		$userid=mysql_real_escape_string($_GET['userid']);
		
	}else if ($test=="") {
		# code...
		$page=mysql_real_escape_string($_POST['page']);
		$userid=mysql_real_escape_string($_POST['userid']);
	}
	$prevlimit=($page*$host_app_pull_limit)-$host_app_pull_limit>0?($page*$host_app_pull_limit)-$host_app_pull_limit:0;
	$nextlimit=$page*$host_app_pull_limit;
	$limit="LIMIT $prevlimit,$nextlimit";
	// echo $limit."<br>";
	$outs=getAllTransactions('viewer','all','appusertransactions',$userid);
	$totalpages=$outs['num_pages'];
	$numrows=$outs['numrows'];
	if($numrows>0){
		$msg="Retrieval Successful";
	 	echo json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalpages"=>"$totalpages"));
	 	if($test!==""){
			$scriptout='
			<script>
				var sdata='.json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalpages"=>"$totalpages")).';
			</script>
			';
			echo $scriptout;
		}	
	}else{
		$msg="Retrieval fail";
		echo json_encode(array("success"=>"false","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"totalpages"=>"0"));

	}
}else if ($displaytype=="paymentstatus") {
	# code...
	if($test!==""){
		$page=mysql_real_escape_string($_GET['page']);
		$userid=mysql_real_escape_string($_GET['userid']);
		$cid=mysql_real_escape_string($_GET['cid']);
		
	}else if ($test=="") {
		# code...
		$page=mysql_real_escape_string($_POST['page']);
		$userid=mysql_real_escape_string($_POST['userid']);
		$cid=mysql_real_escape_string($_POST['cid']);
	}
	$prevlimit=($page*$host_app_pull_limit)-$host_app_pull_limit>0?($page*$host_app_pull_limit)-$host_app_pull_limit:0;
	$nextlimit=$page*$host_app_pull_limit;
	$limit="LIMIT $prevlimit,$nextlimit";
	// echo $limit."<br>";
	$outs=getAllTransactions('viewer','all','appuserpaymentstatus',$userid,$cid);
	$totalpages=$outs['num_pages'];
	$numrows=$outs['numrows'];
	if($numrows>0){
		$msg="Retrieval Successful";
	 	echo json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalpages"=>"$totalpages"));
	 	if($test!==""){
			$scriptout='
			<script>
				var sdata='.json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$outs['catdata'],"page"=>"$page","totalpages"=>"$totalpages")).';
			</script>
			';
			echo $scriptout;
		}	
	}else{
		$totalpages=0; 
		$msg="Retrieval fail";
		$catdata[0]['transactionstatus']="no payment made";
		echo json_encode(array("success"=>"false","msg"=>"$msg","userid"=>"$userid","catdata"=>$catdata,"totalpages"=>"0"));
		if($test!==""){
			$scriptout='
			<script>
				var sdata='.json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$userid","catdata"=>$catdata,"page"=>"$page","totalpages"=>"$totalpages")).';
			</script>
			';
			echo $scriptout;
		}	
	}
}else if ($displaytype=="accountactivation") {
	# code...
}
?>