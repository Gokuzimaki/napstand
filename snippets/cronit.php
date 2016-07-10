<?php
	if(isset($host_target_addr) && (strpos($host_target_addr, "localhost/")||strpos($host_target_addr, "wamp")||strpos($host_target_addr, "ngrok.io"))){
	  	// for local server, connection file will already be included
	}else{
		include('connection.php');
	}
	
	$today=date("Y-m-d");
	$timenow=date("H:i:s");
	$fullperiod=$today." ".$timenow;
	$query1="SELECT * FROM blogentries WHERE (postperiod<'$fullperiod' OR postperiod='$fullperiod') AND status='schedule' AND scheduledpost='yes' AND entrydate!='25, January 1970 00:00:00'";
	$run1=mysql_query($query1)or die(mysql_error()." Line".__LINE__);
	$numrows1=mysql_num_rows($run1);
	if($numrows1>0){
		while ($row1=mysql_fetch_assoc($run1)) {
			# code...
			$postid=$row1['id'];
			publishPost($postid);
		}
	}
	// next delete duplicate entries from users table that are users
	// first test if the table exists
	if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'recruits'"))==1) {
		$queryuserd="DELETE email1 FROM recruits email1, recruits email2 WHERE email1.id < email2.id AND email1.email = email2.email";
		$runuserd=mysql_query($queryuserd)or die(mysql_error()." Real number: ".__LINE__);		
	}

	//change the publish status of scheduled content entries
	if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'contententries'"))==1) {
		$query1="UPDATE contententries SET releasedate='$fullperiod', publishstatus='published' WHERE (scheduledate<'$fullperiod' OR scheduledate='$fullperiod' OR scheduledate='0000-00-00 00:00:00') AND publishstatus='scheduled'";
		$run1=mysql_query($query1)or die(mysql_error()." Line".__LINE__);
		// echo $query1;
		// echo "cron here";
	}
		// echo "cron there";
?>