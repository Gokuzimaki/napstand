<?php
	// This module is responsible for data entries into the notifications table
	// when actions are successfully carried out on the user or admin end
	// the "notifications" table columns are as follows
	/*
	*userid
	*usertype -the table where this user can be found
	*action - [create,retrieve,update,delete,login,loginattempt,logout,accountactivation]
	*actionid - id of the target of an action when it occurs
	*actiontype - the table name of the affected target
	*actiondetails - miniature details on an action carried out
	*entrydate
	*viewlevelid - [0,.....n] 0 represents the Super user only, 1 represents any other admin account
	*viewleveltype - represents the level of viewer that can see the notification
	*/
	function createNotification($userid,$usertype,$action,$actiondetails,$actionid="",$actiontype="",$viewlevelid="",$viewleveltype=""){
		include('globalsmodule.php');

	    $today=date("Y-m-d H:i:s");
	    $nextnot=getNextId('notifications');
        $mediaquery="INSERT INTO notifications
        (userid,usertype,action,actiondetails,actionid,actiontype,viewlevelid,viewleveltype,entrydate)
        VALUES
        ('$userid','$usertype','$action','$actiondetails','$actionid','$actiontype','$viewlevelid','$viewleveltype','$today')";

        $mediarun=mysql_query($mediaquery)or die(mysql_error()." Line ".__LINE__);
		// return $nextnot;
	};
	function getNotifications($tablename,$orderfield,$ordervalue){
		include('globalsmodule.php');
		$row=array();
		$numrows=0;
		if($tablename!==""&&$orderfield!==""&&$ordervalue!==""){
			if(is_array($orderfield) && is_array($ordervalue)&&count($orderfield)==count($ordervalue)){
				$orderfieldvals=count($orderfield)-1;
				for($i=0;$i<=$orderfieldvals;$i++){
					if($i!==$orderfieldvals){
						$ordervalues.="".$orderfield[$i]."='".$ordervalue[$i]."' AND ";
					}else{
						$ordervalues.=" ".$orderfield[$i]."='".$ordervalue[$i]."'";
					}
				}
				$query="SELECT * FROM $tablename WHERE $ordervalues";
			}else{
			  	$query="SELECT * FROM $tablename WHERE $orderfield=$ordervalue";
			}
			//// // echo$query;
			$run=mysql_query($query)or die(mysql_error()." Real number:".__LINE__." $query<br>");
			$numrows=mysql_fetch_assoc($run);
		}else{

			die('cant continue with missing ordervalues data'); 
		}

		$row['numrows']=$numrows;

		return $row;

	}

?>