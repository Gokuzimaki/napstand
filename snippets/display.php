<?php
include('connection.php');
session_start();
$displaytype="";
$extraval="admin";
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


if($displaytype==""){
// echo $displaytype;

}else if($displaytype=="userlogin"){
	// echo $displaytype;
	echo "Login test Successful";
}elseif ($displaytype=="calenderout") {
	$extraout=explode("-:-", $extraval);
	// $theme=mysql_real_escape_string($_GET['theme']);
	$ecount=count($extraout);
	if($ecount>3){
		$day=$extraout[0];
		$month=$extraout[1];
		$year=$extraout[2];
		$data_target=$extraout[3];
		$theme=$extraout[4];
	}
	if(count($extraout)>4){
		$data_target=array();
		$data_target[0]=$extraout[3];
		$data_target[1]=$extraout[5];
	}
	// echo $day.$month.$year;
	$outs=calenderOut($day,$month,$year,'',$data_target,$theme,'');
	// echo $theme;
	echo $outs['totaldaysout'];
}else if($displaytype=="userslist"){
	$viewer="admin";
	$outs=getUserGroup($viewer,"all");
	$msg=$outs['selection'];
	$resultcount=$outs['numrows'];
	$scripts='
	<script>
		$(document).ready(function() {
			if($(document).select2){
		  		$("select[name=userlist]").select2();
			}
		});
	</script>';
 	echo json_encode(array("success"=>"true","msg"=>"$msg","scripts"=>"$scripts","resultcount"=>"$resultcount"));
}else if($displaytype=="usercatlist"){
	$catid=$_GET['catid'];
	$viewer=array();
	$viewer[0]="usercatlist";
	$viewer[1]="nothing";
	$viewer[2]="admin";
	$viewer[3]="$catid";
	$outs=getUserGroup($viewer,"all");
	$msg=$outs['selection'];
	$resultcount=$outs['numrows'];
 	echo json_encode(array("success"=>"true","msg"=>"$msg","resultcount"=>"$resultcount"));
}else if($displaytype=="clientslist"){
	$viewer="admin";
	$outs=getClientGroup($viewer,"all");
	$msg=$outs['selection'];
	$resultcount=$outs['numrows'];
 	echo json_encode(array("success"=>"true","msg"=>"$msg","resultcount"=>"$resultcount","extra"=>"<option value=\"\">Select a Client</option>"));
}else if($displaytype=="clientcatlist"){
	$catid=$_GET['catid'];
	$viewer=array();
	$viewer[0]="clientcatlist";
	$viewer[1]="nothing";
	$viewer[2]="admin";
	$viewer[3]="$catid";
	$outs=getClientGroup($viewer,"all");
	$msg=$outs['selection'];
	$resultcount=$outs['numrows'];
	// echo $msg;
 	echo json_encode(array("success"=>"true","msg"=>"".stripslashes($msg)."","resultcount"=>"$resultcount"));
}else if($displaytype=="searchuserslist"){
	$searchval=$_GET['searchval'];
	$catid=$_GET['catid'];
	$viewer=array();
	$viewer[0]="usercategorysearch";
	$viewer[1]="$searchval";
	$viewer[2]="admin";
	$viewer[3]="$catid";
	$outs=getUserGroup($viewer,"all");
	$msg=$outs['minisearch'];
	$resultcount=$outs['numrows'];
 	echo json_encode(array("success"=>"true","msg"=>"$msg","resultcount"=>"$resultcount"));
}else if($displaytype=="searchclientslist"){
	$searchval=$_GET['searchval'];
	$catid=$_GET['catid'];
	$viewer=array();
	$viewer[0]="clientcategorysearch";
	$viewer[1]="$searchval";
	$viewer[2]="admin";
	$viewer[3]="$catid";
	$outs=getClientGroup($viewer,"all");
	$msg=$outs['minisearch'];
	$resultcount=$outs['numrows'];
 	echo json_encode(array("success"=>"true","msg"=>"$msg","resultcount"=>"$resultcount"));
}else if($displaytype=="userparentcontentlist"){
	$userid=$_GET['userid'];
	$catid=$_GET['catid'];
	$viewer=array();
	$viewer[0]="$userid";
	$viewer[1]="$catid";
	$outs=getAllParentContent("admin","usertypeout",$viewer,"all");
	$msg=$outs['selectionoutput'];
	$resultcount=$outs['numrows'];
 	echo json_encode(array("success"=>"true","msg"=>"$msg","resultcount"=>"$resultcount"));
}else if($displaytype=="newparentcontent"){
	include('createparentcontent.php');
}else if($displaytype=="editparentcontentadmin"){
	$outs=getAllParentContent("admin","","","");
	echo $outs['adminoutput'];
}else if($displaytype=="editsingleparentcontentadmin"){
	$editid=$_GET['editid'];
	$outs=getSingleParentContent($editid);
	echo $outs['adminoutputtwo'];
}else if($displaytype=="newuserparentcontent"||$displaytype=="newclientparentcontent"){
	$userid="";
	if (isset($_SESSION['userinapstand'])||isset($_SESSION['clientinapstand'])) {
		# code...
		$userid=$displaytype=="newsuserparentcontent"&&isset($_SESSION['userinapstand'])?$_SESSION['userinapstand']:($displaytype=="newsclientparentcontent"&&isset($_SESSION['clientinapstand'])?$_SESSION['clientinapstand']:$userid);

	}
	include('createuserparentcontent.php');
}else if($displaytype=="edituserparentcontent"||$displaytype=="editclientparentcontent"){
	$userid="";
	if (isset($_SESSION['userinapstand'])||isset($_SESSION['clientinapstand'])) {
		# code...
		$userid=$displaytype=="edituserparentcontent"&&isset($_SESSION['userinapstand'])?$_SESSION['userinapstand']:($displaytype=="editclientparentcontent"&&isset($_SESSION['clientinapstand'])?$_SESSION['clientinapstand']:$userid);
	}
	if($userid!==""){
		$outs=getAllParentContent("viewer","usertypeoutedit","$userid","");
		echo $outs['adminoutput'];
		
	}else{
		echo "No profile detected. please logout then login to your account to carry out
			  changes as it seems you session has expired
		";
	}
}else if($displaytype=="editsingleuserparentcontent"||$displaytype=="editsingleclientparentcontent"){
	$userid="";
	if (isset($_SESSION['userinapstand'])||isset($_SESSION['clientinapstand'])) {
		# code...
		$userid=$displaytype=="editsingleuserparentcontent"&&isset($_SESSION['userinapstand'])?$_SESSION['userinapstand']:($displaytype=="editsingleclientparentcontent"&&isset($_SESSION['clientinapstand'])?$_SESSION['clientinapstand']:$userid);
	}
	if($userid!==""){
		$editid=$_GET['editid'];
		$outs=getSingleParentContent($editid,$userid);
		echo $outs['adminoutputtwo'];
		
	}else{
		echo "No profile detected. please logout then login to your account to carry out
			  changes as it seems you session has expired
		";
	}
}else if($displaytype=="createneditcontententries"){
	include('contententryprelude.php');
}else if($displaytype=="editsinglecontententryadmin"){
	$editid=$_GET['editid'];
	$outs=getSingleContentEntry($editid);
	echo $outs['adminoutputtwo'];
}else if($displaytype=="createneditusercontententries"||$displaytype=="createneditclientcontententries"){
	$userid="";
	if (isset($_SESSION['userinapstand'])||isset($_SESSION['clientinapstand'])) {
		# code...
		$userid=$displaytype=="createneditusercontententries"&&isset($_SESSION['userinapstand'])?$_SESSION['userinapstand']:($displaytype=="createneditclientcontententries"&&isset($_SESSION['clientinapstand'])?$_SESSION['clientinapstand']:$userid);
	}
	include('contententrypreludeuser.php');
}else if($displaytype=="editsingleusercontententry"||$displaytype=="editsingleclientcontententry"){
	$userid="";
	if (isset($_SESSION['userinapstand'])||isset($_SESSION['clientinapstand'])) {
		# code...
		$userid=$displaytype=="editsingleuserparentcontent"&&isset($_SESSION['userinapstand'])?$_SESSION['userinapstand']:($displaytype=="editsingleclientparentcontent"&&isset($_SESSION['clientinapstand'])?$_SESSION['clientinapstand']:$userid);
	}
	if($userid!==""){
		$editid=$_GET['editid'];
		$outs=getSingleContentEntry($editid);
		echo $outs['adminoutputtwo'];
		
	}else{
		echo "No profile detected. please logout then login to your account to carry out
			  changes as it seems you session has expired
		";
	}
}else if($displaytype=="loadcontentseriesadmin"){
	$parentid=$_GET['parentid'];
	$pstat=isset($_GET['publishstatus'])?$_GET['publishstatus']:"";
	
	$outs=getAllContentEntries('admin',"parentid","$parentid","all","$pstat","loadalt");
	$msg=$outs['altadminoutput'];
	$resultcount=$outs['numrows'];
 	echo json_encode(array("success"=>"true","msg"=>"$msg","resultcount"=>"$resultcount"));
}else if($displaytype=="loadcontentseriesuser"){
	$userid="";
	$parentid=$_GET['parentid'];
	$pdataout=getSingleParentContent($parentid);
	$userid=$pdataout['userid'];
	$resultcount=0;
	if (isset($_SESSION['userinapstand'])||isset($_SESSION['clientinapstand'])) {
		# code...
		$parentdata[]=$parentid;
		$parentdata[]="";
		$parentdata[]="";
		$parentdata[]=$userid;
		$pstat=isset($_GET['publishstatus'])?$_GET['publishstatus']:"";
		$outs=getAllContentEntries('admin',"parentiduseredit",$parentdata,"all","$pstat","loadalt");
		$msg=$outs['altadminoutput'];
		$resultcount=$outs['numrows'];
	}else{
		$msg= "No profile detected. please logout then login to your account to carry out
			  changes as it seems you session has expired
		";
	}
	echo json_encode(array("success"=>"true","msg"=>"$msg","resultcount"=>"$resultcount"));

}else if($displaytype=="edittestdisplay"){
	echo 'Test display working
		  <div class="row">
				<div class="col-md-6">
	              <!-- Custom Tabs -->
	              <div class="nav-tabs-custom">
	                <ul class="nav nav-tabs">
	                  <li class="active"><a href="#tab_1" data-toggle="tab">Tab 1</a></li>
	                  <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
	                  <li class="dropdown">
	                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
	                      Dropdown <span class="caret"></span>
	                    </a>
	                    <ul class="dropdown-menu">
	                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
	                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
	                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
	                      <li role="presentation" class="divider"></li>
	                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
	                    </ul>
	                  </li>
	                  <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
	                </ul>
	                <div class="tab-content">
	                  <div class="tab-pane active" id="tab_1">
	                    <b>How to use:</b>
	                    <p>Exactly like the original bootstrap tabs except you should use
	                      the custom wrapper <code>.nav-tabs-custom</code> to achieve this style.</p>
	                    A wonderful serenity has taken possession of my entire soul,
	                    like these sweet mornings of spring which I enjoy with my whole heart.
	                    I am alone, and feel the charm of existence in this spot,
	                    which was created for the bliss of souls like mine. I am so happy,
	                    my dear friend, so absorbed in the exquisite sense of mere tranquil existence,
	                    that I neglect my talents. I should be incapable of drawing a single stroke
	                    at the present moment; and yet I feel that I never was a greater artist than now.
	                  </div><!-- /.tab-pane -->
	                  <div class="tab-pane" id="tab_2">
	                    The European languages are members of the same family. Their separate existence is a myth.
	                    For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
	                    in their grammar, their pronunciation and their most common words. Everyone realizes why a
	                    new common language would be desirable: one could refuse to pay expensive translators. To
	                    achieve this, it would be necessary to have uniform grammar, pronunciation and more common
	                    words. If several languages coalesce, the grammar of the resulting language is more simple
	                    and regular than that of the individual languages.
	                  </div><!-- /.tab-pane -->
	                </div><!-- /.tab-content -->
	              </div><!-- nav-tabs-custom -->
	            </div>
		  </div>
	';
}else if($displaytype=="surveyrating"){
	echo "OK";
}else if($displaytype=="contacthelpdesk"){
	echo"OK".$displaytype;
}else if($displaytype=="userdashboard"){
	// echo $displaytype;
	if(isset($_SESSION['userh'])){
		$uid=$_SESSION['useri'];
		$userdata=getSingleUser($uid);
		$userdataout='<input name="userdata" data-userid="'.$uid.'" data-usertype="user"/>';
		$surveydataone=getAllSurvey("viewer","userspecific",$uid,"");
		$surveydatarewards=getAllSurvey("viewer","rewards",$uid,"");	
		// $sdata=$data['predetoutput'];

		echo'
			<!--Last Taken ad campaigns box -->
	          <div class="box overflowhidden">
		            <div class="box-header with-border">
		              <h3 class="box-title">Last Results</h3>
		              <div class="box-tools pull-right">
		                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
		                <!-- <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
		              </div>
		            </div>
		            <div class="box-body">
		            	<div class="row">
		            		'.$userdata['latestperformance'].'
		            	</div>
		            </div><!-- /.box-body -->
		            <div class="box-footer">
		              These are the last ad campaigns you took part in and your results.
		            </div><!-- /.box-footer-->
	          </div><!-- /.box -->
	        <!-- end last ad campaigns taken box -->
			<!--Last Taken Surveys box -->
			<div class="box overflowhidden">
			    <div class="box-header with-border">
			      <h3 class="box-title">Latest Ad Campaign</h3>
			      <div class="box-tools pull-right">
			        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
			        <!-- <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
			      </div>
			    </div>
			    <div class="box-body">
			    	<div class="row">
			        	'.  $surveydataone['viewerlatesttwo'].'  
			        </div>
			    </div><!-- /.box-body -->
			    <div class="box-footer">
			      These are the latest Ad Campaigns available (for you), monitor them and pick the one that you can truly participate in (where applicable).
			    </div><!-- /.box-footer-->
			</div><!-- /.box -->
			<!-- end last surveys taken box -->

			<!-- Rewards box -->
			<div class="box overflowhidden">
			    <div class="box-header with-border">
			      <h3 class="box-title">Latest Reward Stats</h3>
			      <div class="box-tools pull-right">
			        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
			        <!-- <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
			      </div>
			    </div>
			    <div class="box-body">
			    	<div class="row">
						'.  $surveydatarewards['viewerlatest'].'  
			        </div>
			    </div><!-- /.box-body -->
			    <div class="box-footer">
				      These are the recent rewards you qualify or can be selected for, please note that the moment the reward is given out and you claim it, you will no longer see the stat here, check the "Rewards" section to get more info in case you won.<br>
				      Info on <b>Selection Status</b><br>
				      "<b>Selected</b>" means you are in the reward-pool for an ad-campaign, not that you\'ve been given a reward, use the <b>Rewards</b> tab to view available rewards<br>
				      "<b>Not yet Selected</b>" means your result didn\'t meet the expected mark for an ad-campaign, or you are eligible but the reward-pool picker hasn\'t chosen you yet<br>
				      "<b>Never</b>" means it\'s not happening. You\'re not getting any reward for the atttempt but you probably didn\'t finish the survey/ad-campaign or provided wrong answers<br>			    
			      </div><!-- /.box-footer-->
			</div><!-- /.box -->
			<!-- Rewards Box end -->

			<!-- STATS box -->
			<div class="box overflowhidden">
			    <div class="box-header with-border">
			      <h3 class="box-title">Your Stats</h3>
			      <div class="box-tools pull-right">
			        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
			        <!-- <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
			      </div>
			    </div>
			    <div class="box-body">
			    	<div class="row">
			    		<div class="col-lg-3 col-xs-6">
			              <!-- small box -->
			              <div class="small-box bg-aqua">
			                <div class="inner">
			                  <p>
			                    Total Available ad campaigns
			                  </p>
			                  <h3>
			                    '.  $userdata['availablesurveys'].'  
			                  </h3>
			                </div>
			                <div class="icon">
			                  <i class="fa fa-archive"></i>
			                </div>
			                
			              </div>
			            </div><!-- ./col -->
			            <div class="col-lg-3 col-xs-6">
			              <!-- small box -->
			              <div class="small-box bg-green">
			                <div class="inner">
			                  <p>
			                    % Attempted from Available
			                  </p>
			                  <h3>
			                    '.$userdata['surveypercentcomplete'].'  <sup style="font-size: 20px">%</sup>
			                  </h3>
			                </div>
			                <div class="icon">
			                  <i class="ion ion-stats-bars"></i>
			                </div>
			              </div>
			            </div><!-- ./col -->
			            <div class="col-lg-3 col-xs-6">
			              <!-- small box -->
			              <div class="small-box bg-green">
			                <div class="inner">
			                  <p>
			                    Total % Passed from Attempts(When Applicable)
			                  </p>
			                  <h3>
			                    '.$userdata['percentpassed'].'  <sup style="font-size: 20px">%</sup>
			                  </h3>
			                </div>
			                <div class="icon">
			                  <i class="fa fa-check-square-o"></i>
			                </div>
			              </div>
			            </div><!-- ./col -->
			            <div class="col-lg-3 col-xs-6">
			              <!-- small box -->
			              <div class="small-box bg-green">
			                <div class="inner">
			                  <p>
			                    Total Rewards Obtained
			                  </p>
			                  <h3>
			                    '.  $userdata['claimedrewards'].'  
			                  </h3>
			                </div>
			                <div class="icon">
			                  <i class="fa fa-money"></i>
			                </div>
			              </div>
			            </div><!-- ./col -->
			    	</div>
			    </div><!-- /.box-body -->
			    <div class="box-footer">
			      This is how you\'ve been doing so far, a certain combination of your statistics is used to qualify for some very special surveys, so stay active and have fun.
			    </div><!-- /.box-footer-->
			</div><!-- /.box -->
			<!-- Stats Box end -->
			<script>
					if($(document).knob){
					      $(function () {
					      	 $(\'[data-toggle="tooltip"]\').tooltip();
					        /* jQueryKnob */
					        $(".knob").knob({
					          /*change : function (value) {
					           //console.log("change : " + value);
					           },
					           release : function (value) {
					           console.log("release : " + value);
					           },
					           cancel : function () {
					           console.log("cancel : " + this.value);
					           },*/
					          draw: function () {

					            // "tron" case
					            if (this.$.data(\'skin\') == \'tron\') {

					              var a = this.angle(this.cv)  // Angle
					                      , sa = this.startAngle          // Previous start angle
					                      , sat = this.startAngle         // Start angle
					                      , ea                            // Previous end angle
					                      , eat = sat + a                 // End angle
					                      , r = true;

					              this.g.lineWidth = this.lineWidth;

					              this.o.cursor
					                      && (sat = eat - 0.3)
					                      && (eat = eat + 0.3);

					              if (this.o.displayPrevious) {
					                ea = this.startAngle + this.angle(this.value);
					                this.o.cursor
					                        && (sa = ea - 0.3)
					                        && (ea = ea + 0.3);
					                this.g.beginPath();
					                this.g.strokeStyle = this.previousColor;
					                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
					                this.g.stroke();
					              }

					              this.g.beginPath();
					              this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
					              this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
					              this.g.stroke();

					              this.g.lineWidth = 2;
					              this.g.beginPath();
					              this.g.strokeStyle = this.o.fgColor;
					              this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
					              this.g.stroke();

					              return false;
					            }
					          }
					        });
					        /* END JQUERY KNOB */

					        //INITIALIZE SPARKLINE CHARTS
					        $(".sparkline").each(function () {
					          var $this = $(this);
					          $this.sparkline(\'html\', $this.data());
					        });

					        /* SPARKLINE DOCUMENTAION EXAMPLES http://omnipotent.net/jquery.sparkline/#s-about */
					        drawDocSparklines();
					        drawMouseSpeedDemo();
					      });

					}
			</script>
		';
	}else{
		echo'Please you have to logout then login, your session has expired'; 
		// header('location:signupin.php');
	}
}else if($displaytype=="userprofile"){
	if(isset($_SESSION['userhnapstand'])){
		$uid=$_SESSION['userinapstand'];
		$userdata=getSingleUser($uid);
		echo $userdata['adminoutputtwo'];
	}else{
		echo'Please you have to logout then login, your session has expired'; 
		// header('location:signupin.php');
	}
}else if($displaytype=="clientprofile"){
	if(isset($_SESSION['clienthnapstand'])){
		$uid=$_SESSION['clientinapstand'];
		$userdata=getSingleClient($uid);
		echo $userdata['adminoutputtwo'];
	}else{
		echo 'Please you have to logout then login, your session has expired'; 
		// header('location:signupin.php');
	}
}else if($displaytype=="clientdashboard"){
	// echo $displaytype;
	if(isset($_SESSION['clienth'])){
		$uid=$_SESSION['clienti'];
		$squery="SELECT * FROM survey WHERE clientid='$uid' ORDER BY id desc";
		$srun=mysql_query($squery)or die(mysql_error());
		$snumrows=mysql_num_rows($srun);
		$sdata="No Survey/adcampaign Posted yet";
		if($snumrows>0){
			$srow=mysql_fetch_assoc($srun);
			$data=collateAllSurveyResults("adminviewer",$srow['id']);
			$sdata=$data['predetoutput'];
		}
		echo $sdata;
	}else{
		echo "Apologies but your session has expired and you currently have limited access to features, Logout then login again";
	}
}else if($displaytype=="campaigns"){
	// echo $displaytype;
	if(isset($_SESSION['clienth'])){
		$uid=$_SESSION['clienti'];
		$outs=getAllSurvey("admin","clientcampaigns","$uid","");
		echo $outs['adminoutputseven'];
	}else{
		echo'Please you have to logout then login, your session has expired'; 
		// header('location:signupin.php');
	}
	// getAllSurvey($viewer,$type,$typeid,$limit);

}else if($displaytype=="datarequest"){
	// echo $displaytype;
	if(isset($_SESSION['clienth'])){
		$uid=$_SESSION['clienti'];
		$outs=getAllSurvey("admin","datarequest","$uid","");
		echo $outs['adminoutputnine'];
	}else{
		echo'Please you have to logout then login, your session has expired'; 
		// header('location:signupin.php');
	}
}else if($displaytype=="singledatarequest"){
	// echo $displaytype;
	$editid=$_GET['editid'];
	if(isset($_SESSION['clienth'])){
		$uid=$_SESSION['clienti'];
		$data=getSingleClient($uid);
		$surveydata=getSingleSurvey($editid);
		$title="A data request has been made";
		$content='
	      <p style="text-align:left;">From our client '.$data['businessname'].',<br>
	      Requesting current data for our survey, <br>
	     	<a href="'.$host_addr.'/snippets/printmodule.php?sid='.$editid.'">'.$surveydata['title'].'</a>
	      </p>
	      <p style="text-align:right;">Thank You.</p>
	  	';
	  	$footer='
		    <ul>
		        <li><strong>Phone 1: </strong>0701-682-9254</li>
		        <li><strong>Phone 2: </strong>0802-916-3891</li>
		        <li><strong>Phone 3: </strong>0803-370-7244</li>
		        <li><strong>Email: </strong><a href="mailto:info@adsbounty.com">info@adsbounty.com</a></li>
		    </ul>
	  	';
	  	$emailout=generateMailMarkUp("Adsbounty.com",$data['email'],"$title","$content","$footer","");
	    // echo $emailout['rowmarkup'];
	    $toemail=$data['email'];
	    $headers = "MIME-Version: 1.0" . "\r\n";
	    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	    $headers .= 'From: <no-reply@adsbounty.com>' . "\r\n";
	    $subject="A data request has been made";
	    if($host_email_send===true){
	      if(mail($toemail,$subject,$emailout['rowmarkup'],$headers)){
	      	echo "Your request has been sent we will get back to you with your data or email you with it, thank you";
	      }else{
	        echo 'could not send Your email, something went wrong and we are handling it, meantime you could click the back button in your browser to get you out of here, we are really sorry';
	      }
	    }else{
	    	echo "Mail settings for sending are currently OFF, contact the help ";
	    }
	}else{
		echo'Please you have to logout then login, your session has expired'; 
		// header('location:signupin.php');
	}
	// send an email to the admin concerning the request
}else if($displaytype=="singlecampaignrequest"){
	// echo $displaytype;
	$editid=$_GET['editid'];
	$data=collateAllSurveyResults("adminviewer",$editid);
	$sdata=$data['predetoutput'];
	echo $sdata;
	// send an email to the admin concerning the request
}else if($displaytype=="allsurveysuser"){
	//	echo $displaytype;
	if(isset($_SESSION['userh'])){
		$uid=$_SESSION['useri'];
		$outs=getAllSurvey("viewer","allsurveysuser","$uid","");
		echo $outs['vieweroutputfive'];
	}else{
		echo'Please you have to logout then login, your session has expired'; 
		// header('location:signupin.php');
	}
}else if($displaytype=="rewards"){
	// echo $displaytype;
	if(isset($_SESSION['userh'])){
		$uid=$_SESSION['useri'];
		$sid[]="userrewards";
		$sid[]=$uid;
		$udata=getSingleUser($uid);
		$fullname=$udata['fullname'];
		$email=$udata['email'];
		$outs=getAllSurveyRewards("viewer",$sid,"");
		echo $outs['vieweroutput'];
	}else{
		echo'Please you have to logout then login, your session has expired'; 
		// header('location:signupin.php');
	}
}else if($displaytype=="topratedsurveysuser"){
	// echo $displaytype;
	if(isset($_SESSION['userh'])){
		$uid=$_SESSION['useri'];
		$outs=getAllSurvey("viewer","toprateduser","$uid","");
		echo $outs['vieweroutputfive'];
	}else{
		echo'Please you have to logout then login, your session has expired'; 
		// header('location:signupin.php');
	}
}else if($displaytype=="faquser"){
	echo "The FAQ page should be open or opening in a new tab, check it out.";

}else if($displaytype=="helpmessage"){
	echo $displaytype;

}else if($displaytype=="newcontentcategory"){
	// echo $displaytype;
	include 'createcontentcategory.php';

}else if($displaytype=="editcontentcategory"){
	$outs=getAllContentCategory($extraval,"");
	echo $outs['adminoutput'];
}else if($displaytype=="editsinglecontentcategory"){
	$editid=$_GET['editid'];
	$outs=getSingleContentCategory($editid);
	echo $outs['adminoutputtwo'];
}else if($displaytype=="categorymurals"){
	include("createeditmural.php");
}else if($displaytype=="newfaq"){
	// echo $displaytype;
	include 'createfaq.php';

}else if($displaytype=="editfaq"){
	$outs=getAllFAQ($extraval,"","");
	echo $outs['adminoutput'];
}else if($displaytype=="editsinglefaq"){
	$editid=$_GET['editid'];
	$outs=getSingleFAQ($editid);
	echo $outs['adminoutputtwo'];
}elseif($displaytype=="editsinglegeneraldata"){
	// echo $displaytype;
	$editid=mysql_real_escape_string($_GET['editid']);
	$outs=getSingleGeneralInfo($editid);
	echo $outs['adminoutputtwo'];
}else if($displaytype=="newcontent"){
	include("createcontent.php");
}else if($displaytype=="editcontent"){
	$outs=getAllContent("admin","","","");
	echo $outs['adminoutput'];
}else if($displaytype=="editsinglesurvey"){
	$editid=$_GET['editid'];
	$outs=getSingleSurvey($editid);
	echo $outs['adminoutputtwo'];
}else if($displaytype=="viewsurveystatistics"){
	$outs=getAllSurvey("admin","statistics","","");
	echo $outs['adminoutputthree'];
}else if($displaytype=="generatesinglesurveystatistics"){
	$editid=$_GET['editid'];
	$editarray[0]="printresults";
	$editarray[1]=$editid;
	// $outs=getSingleSurvey($editarray);
	// echo $outs['printoutput'];
	echo "The survey data should be opened/opening in a seperate tab";
}else if($displaytype=="rewardselection"){
	$outs=getAllSurvey("admin","rewardsadmin","","");
	echo $outs['adminoutputfour'];
}else if($displaytype=="generatesinglesurveyrewards"){
	$editid=$_GET['editid'];
	$outs=generateReward($editid);
	echo $outs['winnerdata'];
	// run through the pool if reward entries
	// echo $outs['adminoutputtwo'];
}else if($displaytype=="getsinglesurveypremiumad"){
	$editid=$_GET['editid'];
	$outs=getSinglePremiumAd($editid);
	echo $outs['adminoutputtwo'];
}else if($displaytype=="editpremiumads"){
	$outs=getAllPremiumAds("admin","","");
	echo $outs['adminoutput'];
}else if($displaytype=="activeads"){
	$outs=getAllPremiumAds("activeads","","");
	echo $outs['adminoutput'];
}else if($displaytype=="verifyemail"){
 $email=mysql_real_escape_string($_GET['email']);
 $emaildata=checkEmail($email,"users","email");
 $loadoutextra=isset($_GET['loadoutextra'])?$_GET['loadoutextra']:"";
 if($emaildata['testresult']=="unmatched"){
 	if($loadoutextra!==""){
 		$msg="Email address is available";
 		echo json_encode(array("success"=>"true","msg"=>"$msg","resultcount"=>"1"));

 	}else{
 		echo "OK";
 	}
 }else {
 	if($loadoutextra!==""){
 		if($loadoutextra=="appuser"){
 			if($emaildata['testresult']=="matched"&&$emaildata['testresult']!==$loadoutextra){
 				$msg="Email address is available";
 				echo json_encode(array("success"=>"true","msg"=>"$msg","resultcount"=>"1"));

 			}else{
				$msg="An email address already exists with a matching user type hw_api_attribute()";
 				echo json_encode(array("success"=>"False","msg"=>"$msg","resultcount"=>"1")); 				
 			}
 		}

 	}else{
 		echo "Your email address already exists for another user. Try using a different email address, thank you";

 	}
 }
	// include("createsurvey.php");
}else if($displaytype=="verifyemailuseradmin"){
 $emaildata=array();
 if(isset($_GET['email'])){
	$email=mysql_real_escape_string($_GET['email']);
	$usertype=mysql_real_escape_string($_GET['usertype']);

 }else{
 	$email=mysql_real_escape_string($_POST['email']);
	$usertype=mysql_real_escape_string($_POST['usertype']);
 }
 $emaildata['email']="$email";
 $emaildata['fieldcount']=1;
 $emaildata['logic'][0]="AND";
 $emaildata['column'][0]="usertype";
 $emaildata['value'][0]="$usertype";
 $emaildata=checkEmail($emaildata,"users","email");
 if($emaildata['testresult']=="unmatched"){
 	echo json_encode(array("mailtest"=>"unmatched","msg"=>"<span class=\"color-green\">Email is OK!!!</span>","testquery"=>"".$emaildata["testquery"].""));
 }else {
 	echo json_encode(array("mailtest"=>"matched",
 		"msg"=>"<span class=\"color-red\">The email address already exists for another user. Try using a different email address, thank you</span>",
 		"testquery"=>"".$emaildata["testquery"].""));
 }
	// include("createsurvey.php");
}else if($displaytype=="newclient"){
	include 'createclient.php';
}else if($displaytype=="editclient"){
	$outs=getAllClients($extraval,"");
	echo $outs['adminoutput'];
}else if($displaytype=="editsingleclient"){
	$editid=$_GET['editid'];
	$outs=getSingleClient($editid);
	echo $outs['adminoutputtwo'];
}else if($displaytype=="createuseradmin"){
	include 'createuseradmin.php';
}else if($displaytype=="edituseradmin"){
	$outs=getAllusers("admin","");
	echo $outs['adminoutput'];
}else if($displaytype=="editsingleuseradmin"){
	$editid=$_GET['editid'];
	$typeset="adminfullout";
	$outs=getSingleUser($editid);
	echo $outs['adminoutputthree'];
}else if ($displaytype=="claimreward") {
	# code...
	if (session_id()=="") {
		# code...
		session_start();
	}
	$uid=0;
	if(isset($_SESSION['userh'])){
		$uid=$_SESSION['useri'];
		$editid=$_GET['editid'];
		$udata=getSingleUser($uid);
		$outs=getSingleSurveyReward($editid,'');
		//check the blank values in the user account
		//gender,state,lga,maritalstatus,phoneone,phonetwo,phonethree
		//variable for holding output list
		$outelist="";
		if($udata['gender']==""){
			$outelist.="<b>Gender</b><br>";
		}
		if($udata['state']==""){
			$outelist.="<b>Resident State</b><br>";
		}
		if($udata['lga']==""||$udata['lga']=="0"){
			$outelist.="<b>Local Government Area</b><br>";
		}
		if($udata['maritalstatus']==""){
			$outelist.="<b>Marital Status</b><br>";
		}
		if($udata['phoneone']==""&&$$udata['phonetwo']==""&&$udata['phonethree']==""){
			$outelist.="<b>Phone Two</b><br>";
		}
		if($outelist!==""){
			$outelist="In addition, we noticed the following fields are still blank on your profile<br> 
						$outelist
						Please endeavor to fill them as they will allow our platform serve you more targeted ad campaigns and open more ways for you 
						to get rewarded
						";
		}
		$title="YOU GOT A REWARD!!!";
    	$content='
	      <p style="text-align:left;">Hello '.$udata['fullname'].',<br>
	      You took part in a survey/adcampaign and got selected for a reward, <br>
	      Here is the reward:<br>
	      '.$outs['rewardvalue'].' - '.$outs['rewardtype'].'
	      </p>
	      '.$outelist.'
	      <p style="text-align:right;">Thank You.</p>
	  	';
	  	$footer='
		    <ul>
		        <li><strong>Phone 1: </strong>0701-682-9254</li>
		        <li><strong>Phone 2: </strong>0802-916-3891</li>
		        <li><strong>Phone 3: </strong>0803-370-7244</li>
		        <li><strong>Email: </strong><a href="mailto:info@adsbounty.com">info@adsbounty.com</a></li>
		    </ul>
	  	';
	  	$emailout=generateMailMarkUp("Adsbounty.com",$udata['email'],"$title","$content","$footer","");
	    // echo $emailout['rowmarkup'];
	    $toemail=$udata['email'];
	    $headers = "MIME-Version: 1.0" . "\r\n";
	    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	    $headers .= 'From: <no-reply@adsbounty.com>' . "\r\n";
	    $subject="Here is your reward";
	    if($host_email_send===true){
	      if(mail($toemail,$subject,$emailout['rowmarkup'],$headers)){

	      }else{
	        die('could not send Your email, something went wrong and we are handling it, meantime you could click the back button in your browser to get you out of here, we are really sorry');
	      }
	    }
		echo $outs['rewardvalue'];
		$today=date("Y-m-d");
		genericSingleUpdate("rewards","claimstatus","claimed","rewardid","$editid");
		genericSingleUpdate("rewards","claimdate","$today","rewardid","$editid");
		// echo $outs['vieweroutputtwo'];
	}else{
		echo "Please Logout and Login again, session has expired";
	}
}else if($displaytype=="lgout"){
	/*$state = $_GET['state'];
    $conn = new mysqli (DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die("Connection to Database Failed");
    $stmt = $conn->stmt_init();
    $sql = "SELECT local_govt FROM local_govt WHERE state_id = (select id_no from state where state like '$state%')";
    $stmt->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    echo "<option>Select Your Local Government</option>";
    while($resultRow = $result->fetch_array(MYSQLI_NUM))
        echo "<option>$resultRow[0]</option>";
    $result->close();
    $stmt->close();*/
    $state = $_GET['state'];
    $query="SELECT local_govt,id_no FROM local_govt WHERE state_id = (select id_no from state where state like '%$state%')";
    $run=mysql_query($query)or die(mysql_error()." Line 48");
    echo '<option value="">Choose your Local Government Area</option>';
    while($row=mysql_fetch_assoc($run)){
    	echo '<option value="'.$row['id_no'].'">'.$row['local_govt'].'</option>';
    }
    // echo "went through";
}elseif ($displaytype=="newblogtype") {
	# code...
	// echo $displaytype;
	include 'createblogtype.php';
}elseif ($displaytype=="editblogtype") {
	# code...
	 $outs=getAllBlogTypes($extraval,"");
	echo $outs['adminoutput'];

}elseif($displaytype=="editsingleblogtype"){
	$editid=$_GET['editid'];
	$outs=getSingleBlogType($editid);
	echo $outs['adminoutputtwo'];
}elseif ($displaytype=="newblogcategory") {
	# code...
	// echo $displaytype;

	include 'createblogcategory.php';
}elseif ($displaytype=="editblogcategory") {
	# code...
	// echo $displaytype;
	$outs=getAllBlogTypes("admin","");
	echo'
		<div id="formend" style="background:#fefefe;">
		Select a Blog type to edit categories under it.<br>
			<select name="editblogcategory" class="curved2">
				<option value="">Choose a Blog Type</option>
				'.$outs['selection'].'
			</select>
		</div>
	';
}elseif ($displaytype=="editblogcategorymain") {
	// echo $displaytype;
	$blogtypeid=$_GET['blogtypeid'];
	$outs=getAllBlogCategories("admin","",$blogtypeid);
	echo $outs['adminoutput'];
	}elseif($displaytype=="editsingleblogcategory"){
	$editid=$_GET['editid'];
	$outs=getSingleBlogCategory($editid);
	echo $outs['adminoutputtwo'];
}elseif ($displaytype=="getblogcategories") {
	# code...
	$blogtypeid=mysql_real_escape_string($_GET['blogtypeid']);
	$outs=getAllBlogCategories("admin","",$blogtypeid);
	$select='<option value="">--Choose--</option>';
	$select.=$outs['selection'];
	echo $select;
}elseif ($displaytype=="verifyname") {
	# code...
	// echo $displaytype;
	$fullname=strtolower($_GET['fullname']);
	$query="SELECT * FROM users WHERE fullname LIKE '%$fullname%' OR fullname LIKE '%$fullname2%'";
}elseif ($displaytype=="newblogpost") {
	# code...
	// echo $displaytype;
	include 'createblogposttwo.php';
}elseif ($displaytype=="editblogposts") {
	# code...
	// echo $displaytype;
	$outs=getAllBlogTypes("admin","");
	echo'
		<div id="formend" style="background:#fefefe;">
		Select a Blog type first then click away from the selection box, the second selection box will be populated with the categories under the chosen blog type, now you can choose to either edit all blog posts under a category or under a blog type by chosing a type the a category (view category) or only a type(view all posts under the blog, click the go button when done to view your output).<br>
		<div id="formend">
			<select name="blogtypeid" class="curved2">
				<option value="">Choose a Blog Type</option>
				'.$outs['selection'].'
			</select>
		</div>
		<div id="formend">
			<select name="blogcategoryid" class="curved2">
				<option value="">Choose Category</option>
			</select>
		</div>
			<div id="formend">
				<input type="button" name="viewblogposts" value="GO" class="submitbutton"/>
			</div>
		</div>';

}elseif ($displaytype=="viewblogposts") {
	# code...
	// echo $displaytype;
	$blogtypeid=mysql_real_escape_string($_GET['blogtypeid']);
	$blogcategoryid=mysql_real_escape_string($_GET['blogcategoryid']);
	if($blogtypeid!==""&&$blogcategoryid==""){
	$outs=getAllBlogEntries("admin","",$blogtypeid,'blogtype');
			echo $outs['adminoutput'];
	}elseif ($blogcategoryid!=="") {
		# code...
		$outs=getAllBlogEntries("admin","",$blogcategoryid,'category');
			echo $outs['adminoutput'];
	}
}elseif ($displaytype=="editsingleblogpost") {
	# code...
	// echo $displaytype;
	$editid=$_GET['editid'];
	$outs=getSingleBlogEntry($editid);
	$query="SELECT * FROM comments where blogentryid=$editid";
	$run=mysql_query($query)or die(mysql_error()." Line 135");
	$numrows=mysql_num_rows($run);
	if($numrows>0){
		while($row=mysql_fetch_assoc($run)){
			if($row['status']!=="disabled"){
			genericSingleUpdate("comments","status",'active',"id",$row['id']);
			}
		}
	}
	echo $outs['adminoutputtwo'];
	/*echo'
		<iframe target="">

		</iframe>
	';*/
}elseif ($displaytype=="newgallery") {
	# code...
	// echo $displaytype;
	include'creategallery.php';
}elseif ($displaytype=="editgallery") {
	# code...
	// echo $displaytype;
	$outs=getAllGalleries("admin","");
	echo $outs['adminoutput'];
}elseif ($displaytype=="editsinglegallery") {
	# code...
	$editid=$_GET['editid'];
	$outs=getSingleGallery($editid);
	echo $outs['adminoutputtwo'];
	
}elseif ($displaytype=="deletepic") {
	# code...
	$imgid=$extraval;
	$outs=deleteMedia($imgid);
	echo $outs;
		
}elseif($displaytype=="newadminuser"){
	// echo $displaytype;
	include('createnewuser.php');
}elseif($displaytype=="editadminuser"){
	// echo $displaytype;
	$outs=getAllAdminUsers("admin",'','');
	echo $outs['adminoutput'];
}elseif($displaytype=="editsingleuserdata"){
	// echo $displaytype;
	$editid=$_GET['editid'];
	$outs=getSingleAdminUser($editid);
	echo $outs['adminoutputtwo'];
}elseif($displaytype=="newappuser"){
	// echo $displaytype;
	include('createappuser.php');
}elseif($displaytype=="editappuser"){
	// echo $displaytype;
	$outs=getAllusers("admin","",'appuser');
	echo $outs['adminoutputappuser'];
}elseif($displaytype=="editsingleappuseradmin"){
	// echo $displaytype;
	$editid=$_GET['editid'];
	$outs=getSingleUser($editid);
	echo $outs['adminoutputtwoappuser'];
}elseif ($displaytype=="deletepic_contententry") {
	# code...
	$imgid=$extraval;
	$outs=deleteMedia($imgid,"$displaytype");
    // $msg="Image was successfully deleted ";

    // $outs=json_encode(array("success"=>"true","msg"=>"$msg"));

	echo $outs;
		
}elseif ($displaytype=="editsubscribers") {
	# code...
	// echo $displaytype;
	$outs=getAllBlogTypes("admin","");
	echo'
		<div id="formend" style="background:#fefefe;">
		Select a Blog type first then click away from the selection box, the second selection box will be populated with the categories under the chosen blog type, or choose only a type(view all subscribers to selected blog, click the go button when done to view your output).<br>
		<div id="formend">
			<select name="blogtypeid" class="curved2">
				<option value="">Choose a Blog Type</option>
				'.$outs['selection'].'
			</select>
		</div>
		<div id="formend">
			<select name="blogcategoryid" class="curved2">
				<option value="">Choose Category</option>
			</select>
		</div>
			<div id="formend">
				<input type="button" name="viewsubscribers" value="GO" class="submitbutton"/>
			</div>
		</div>';
}elseif ($displaytype=="franklyspeakingsubscribe") {
	# code...
	// echo $displaytype;
	$outs=getAllSubscribers('admin','',1,'blogtype');
	echo $outs['adminoutput'];
}
elseif ($displaytype=="viewsubscribers") {
	# code...
	// echo $displaytype;
	$blogtypeid=mysql_real_escape_string($_GET['blogtypeid']);
	$blogcategoryid=mysql_real_escape_string($_GET['blogcategoryid']);
	if($blogtypeid!==""&&$blogcategoryid==""){
		$outs=getAllSubscribers("admin","",$blogtypeid,'blogtype');
		echo $outs['adminoutput'];
	}elseif ($blogcategoryid!=="") {
		# code...
		$outs=getAllSubscribers("admin","",$blogcategoryid,'category');
		echo $outs['adminoutput'];
	}
}elseif ($displaytype=="activatesubscriber") {
	$editid=$_GET['editid'];
	genericSingleUpdate("subscriptionlist","status","active","id",$editid);
}elseif ($displaytype=="disablesubscriber") {
	$editid=$_GET['editid'];
	genericSingleUpdate("subscriptionlist","status","inactive","id",$editid);
}elseif ($displaytype=="allcomments") {
	# code...
	// echo $displaytype;
	$typeout="all";
	$outs=getAllComments("admin","",$typeout);
	echo $outs['adminoutput'];
}elseif ($displaytype=="activecomments") {
	# code...
	// echo $displaytype;
	$typeout="active";
	$outs=getAllComments("admin","",$typeout);
	echo $outs['adminoutput'];
}elseif ($displaytype=="inactivecomments") {
	# code...
	// echo $displaytype;
	$typeout="inactive";
	$outs=getAllComments("admin","",$typeout);
	echo $outs['adminoutput'];
}elseif ($displaytype=="disabledcomments") {
	# code...
	// echo $displaytype;
	$typeout="disabled";	
	$outs=getAllComments("admin","",$typeout);
	echo $outs['adminoutput'];
}elseif ($displaytype=="activatecomment"||$displaytype=="reactivatecomment") {
	$editid=$_GET['editid'];
	genericSingleUpdate("comments","status","active","id",$editid);
}elseif ($displaytype=="disablecomment") {
	$editid=$_GET['editid'];
	genericSingleUpdate("comments","status","disabled","id",$editid);
}elseif ($displaytype=="newadvert") {
	# code...
	// echo $displaytype;
	include 'createadvert.php';
}elseif ($displaytype=="editadverts") {
	# code...
	// echo $displaytype;
		echo'
		<div id="formend" style="background:#fefefe;">
		Select a type first then click away from the selection box then click the GO button.<br>
		<div id="formend">
			<select name="advertcat" class="curved2">
				<option value="">Choose an advert page Category</option>
				<option value="all">All(adverts that show up on each blog page type)</option>
				<option value="pfn">Project Fix Nigeria Blog Page</option>
				<option value="csi">Christ Society International Outreach Blog Page</option>
				<option value="fs">Frankly Speaking With Muyiwa Afolabi Blog Page.</option>
			</select>
		</div>

		<div id="formend">
				<input type="button" name="viewadverts" value="GO" class="submitbutton"/>
			</div>
		</div>';	
}elseif ($displaytype=="viewadverts") {
	# code...
	$advertcat=mysql_real_escape_string($_GET['advertcat']);
	$outs=getAllAdverts("admin","","",$advertcat);
	echo $outs['adminoutput'];
}elseif ($displaytype=="editsingleadvert") {
	# code...
	$editid=mysql_real_escape_string($_GET['editid']);
	$outs=getSingleAdvert($editid);
	echo $outs['adminoutputtwo'];
}elseif ($displaytype=="paginationpages") {
	# code...
	// echo $displaytype;
	$typeout=isset($_GET['loadtype'])?$_GET['loadtype']:"";
	$curquery=$_GET['curquery'];
	$curquery=str_replace("_asterisk_","*",$curquery);
	$testq=strpos($curquery,"%'");
	if($testq===0||$testq===true||$testq>0){
	// $curquery=str_replace("%'","%",$curquery);
	}
	// $curquery=stripslashes($curquery);
	$outs=paginatejavascript($curquery,$typeout);
	if($typeout==""){
		echo $outs['pageout'];
		
	}else if($typeout=="bootpag"){
		$resultcount=$outs['num_pages'];
		$msg="";
	 	echo json_encode(array("success"=>"true","msg"=>"$msg","resultcount"=>"$resultcount"));
	}
}elseif ($displaytype=="paginationpagesout") {
	# code...
	// echo $displaytype;
	$curquery=$_GET['curquery'];
	$curquery=str_replace("_asterisk_","*",$curquery);
	$testq=strpos($curquery,"%'");
	if($testq===0||$testq===true||$testq>0){
	// $curquery=str_replace("%'","%",$curquery);
	}
	$outs=paginatejavascript($curquery);
	$limit=$outs['limit'];
	$type=mysql_real_escape_string($_GET['outputtype']);
	$query2="".$curquery.$outs['limit']."";
	$run=mysql_query($query2)or die(mysql_error());
	$otype=$type;
	$nexttype=strpos($type,'mediacontent');
	$nexttype2=strpos($type,'comments');
	$nexttype3=strpos($type,'testimony');
	$nexttype4=strpos($type,'subscribers');
	$nexttype5=strpos($type,'advert');
	$nexttype6=strpos($type,'parentcontent');
	$nexttype7=strpos($type,'usersearch');
	$nexttype8=strpos($type,'clientsearch');
	$nexttype9=strpos($type,'surveysearch');
	$nexttype10=strpos($type,'contententries');
	if($nexttype===0||$nexttype===true||$nexttype>0){
	$type="mediacontent";
	}elseif ($nexttype2===0||$nexttype2===true||$nexttype2>0) {
		# code...
	$type="comment";
	}elseif ($nexttype3===0||$nexttype3===true||$nexttype3>0) {
		# code...
	$type="testimony";
	}elseif ($nexttype4===0||$nexttype4===true||$nexttype4>0) {
		# code...
	$type="subscribers";
	}elseif ($nexttype5===0||$nexttype5===true||$nexttype5>0) {
		# code...
	$type="advert";
	}elseif ($nexttype6===0||$nexttype6===true||$nexttype6>0) {
		# code...
		$type="parentcontent";
	}elseif ($nexttype10===0||$nexttype10===true||$nexttype10>0) {
		# code...
		$type="contententries";
	}elseif ($nexttype7===0||$nexttype7===true||$nexttype7>0) {
		# code...
		$type="usersearch";
	}elseif ($nexttype8===0||$nexttype8===true||$nexttype8>0) {
		# code...
		$type="clientsearch";
	}elseif ($nexttype9===0||$nexttype9===true||$nexttype9>0) {
		# code...
		$type="surveysearch";
	}elseif ($nexttype10===0||$nexttype10===true||$nexttype10>0) {
		# code...
		$type="contententries";
	}

	$numrows=mysql_num_rows($run);
	if($type!==""){
		if($numrows>0){
			if ($type=="mediacontent") {
				# code...
				$data=explode('|',$otype);
				$etype=$data[1];
				$outs=getAllContentMedia("admin",$limit,$etype);
				echo $outs['adminoutputtwo'];
			}elseif ($type=="blogtype") {
				# code...
				$outs=getAllBlogTypes("admin",$limit);
				echo $outs['adminoutputtwo'];
			}elseif ($type=="blogcategory") {
				# code...
				$row=mysql_fetch_assoc($run);
				$blogtypeid=$row['blogtypeid'];
				$outs=getAllBlogCategories("admin",$limit,$blogtypeid);
				echo $outs['adminoutputtwo'];
			}elseif ($type=="blogpostcategory") {
				# code...
				$row=mysql_fetch_assoc($run);
				$blogcatid=$row['blogcatid'];
				$outs=getAllBlogEntries("admin",$limit,$blogcatid,'category');
				echo $outs['adminoutputtwo'];
			}elseif ($type=="blogpostblogtype") {
				# code...
				$row=mysql_fetch_assoc($run);
				$blogtypeid=$row['blogtypeid'];
				$outs=getAllBlogEntries("admin",$limit,$blogtypeid,'blogtype');
				echo $outs['adminoutputtwo'];
			}elseif ($type=="blogpostsearch") {
				# code...
				// echo $type;
				$inquery=array();
				$inquery[0]=$extraval;
				$inquery[1]=$curquery;
				// echo $curquery;
				$etypeid=0;
				$etype='nil';
				$row=mysql_fetch_assoc($run);
				$outs=getAllBlogEntries($inquery,$limit,$etypeid,$etype);
				if($extraval=="admin"){			
				echo $outs['adminoutputtwo'];
				}elseif ($extraval=="viewer") {
					# code...
				echo $outs['vieweroutput'];
				}
			}elseif ($type=="comment") {
				# code...
				$data=explode('|',$otype);
				$etype=$data[1];
				$outs=getAllComments("admin",$limit,$etype);
				echo $outs['adminoutputtwo'];
			}elseif ($type=="gallery") {
				# code...
				$row=mysql_fetch_assoc($run);
				$outs=getAllGalleries("admin",$limit);
				echo $outs['adminoutputtwo'];
			}elseif ($type=="advert") {
				# code...
				$data=explode('|',$otype);
				$etype=$data[1];
				$page=$data[2];
				$row=mysql_fetch_assoc($run);
				$outs=getAllAdverts("admin",$limit,$etype,$page);
				echo $outs['adminoutputtwo'];
			}elseif ($type=="subscribers") {
				# code...
				$data=explode('|',$otype);
				$etypeid=$data[1];
				$etype=$data[2];
				$row=mysql_fetch_assoc($run);
				$outs=getAllSubscribers("admin",$limit,$etypeid,$etype);
				echo $outs['adminoutputtwo'];
			}elseif ($type=="surveycategory") {
				# code...
				$outs=getAllSurveyCategories("admin","",$limit);
				echo $outs['adminoutputtwo'];
			}elseif ($type=="survey") {
				# code...
				$outs=getAllSurvey("admin","","",$limit);
				echo $outs['adminoutputtwo'];
			}elseif ($type=="surveystatistics") {
				# code...
				$outs=getAllSurvey("admin","statistics","",$limit);
				echo $outs['adminoutputfive'];
			}elseif ($type=="userspecificsurvey") {
				# code...
				if (session_id()=="") {
					# code...
					session_start();
				}
				$uid=0;
				if(isset($_SESSION['userh'])){
					$uid=$_SESSION['useri'];
					$outs=getAllSurvey("viewer","userspecific","$uid",$limit);
					echo $outs['vieweroutputtwo'];
				}else{
					echo "Please Logout and Login again, session has expired";
				}
			}elseif ($type=="allsurveysusersurvey") {
				# code...
				if (session_id()=="") {
					# code...
					session_start();
				}
				$uid=0;
				if(isset($_SESSION['userh'])){
					$uid=$_SESSION['useri'];
					$outs=getAllSurvey("viewer","allsurveysuser","$uid",$limit);
					echo $outs['vieweroutputfour'];
				}else{
					echo "Please Logout and Login again, session has expired";
				}
			}elseif ($type=="topratedusersurvey") {
				# code...
				if (session_id()=="") {
					# code...
					session_start();
				}
				$uid=0;
				if(isset($_SESSION['userh'])){
					$uid=$_SESSION['useri'];
					$outs=getAllSurvey("viewer","toprateduser","$uid",$limit);
					echo $outs['vieweroutputfour'];
				}else{
					echo "Please Logout and Login again, session has expired";
				}
			}elseif ($type=="rewards") {
				# code...
				if (session_id()=="") {
					# code...
					session_start();
				}
				$uid=0;
				if(isset($_SESSION['userh'])){
					$uid=$_SESSION['useri'];
					$outs=getAllSurvey("viewer","rewards","$uid",$limit);
					echo $outs['vieweroutputtwo'];
				}else{
					echo "Please Logout and Login again, session has expired";
				}
			}elseif ($type=="userrewards") {
				# code...
				if (session_id()=="") {
					# code...
					session_start();
				}
				$uid=0;
				if(isset($_SESSION['userh'])){
					$uid=$_SESSION['useri'];
					$sid[]="userrewards";
					$sid[]=$uid;
					$udata=getSingleUser($uid);
					$fullname=$udata['fullname'];
					$email=$udata['email'];
					$outs=getAllSurveyRewards("viewer",$sid,"$limit");
					echo $outs['vieweroutputtwo'];
				}else{
					echo'Please you have to logout then login, your session has expired'; 
					// header('location:signupin.php');
				}
			}elseif ($type=="rewardsadmin") {
				# code...
				$outs=getAllSurvey("admin","rewardsadmin","",$limit);
				echo $outs['adminoutputsix'];
			}elseif ($type=="clientsurveyout"||$type=="clientcampaigns"||$type=="datarequest") {
				# code...
				if (session_id()=="") {
					# code...
					session_start();
				}
				$uid=0;
				if(isset($_SESSION['clienth'])){
					$uid=$_SESSION['clienti'];
					$outs=getAllSurvey("admin","$type","$uid",$limit);
					if($type=="clientcampaigns"){
						$outs['adminoutputeight'];
					}else if ($type=="datarequest") {
						# code...
						$outs['adminoutputten'];
					}					
				}else{
					echo "Please Logout and Login again, session has expired";
				}
			}elseif ($type=="faq") {
				# code...
				$outs=getAllFAQ("admin","",$limit);
				echo $outs['adminoutputtwo'];
			}elseif ($type=="contentcategory") {
				# code...
				$outs=getAllContentCategory("admin",$limit);
				echo $outs['adminoutputtwo'];
			}elseif ($type=="parentcontent") {
				# code...
				$data=explode('|',$otype);
				$viewer=$data[1];
				$type=$data[2];
				$typeid=$data[3];
				if(count($data)==5){
					$typeid[0]=$data[3];
					$typeid[1]=$data[4];
				}

				$outs=getAllParentContent("$viewer",$type,$typeid,$limit);
				if($viewer=="admin"){
					echo $outs['adminoutputtwo'];
				}else if($viewer=="viewer"){
					echo $outs['adminoutputtwo'];
					// echo $outs['vieweroutputtwo'];
				}

			}elseif ($type=="contententries") {
				# code...
				$data=explode('|',$otype);
				$viewer=$data[1];
				$type=$data[2];
				if(count($data)>3){
					$typeid[0]=isset($data[3])?$data[3]:"";
					$typeid[1]=isset($data[4])?$data[4]:"";
					$typeid[2]=isset($data[5])?$data[5]:"";
					$typeid[3]=isset($data[6])?$data[6]:"";

				}else{
					$typeid=$data[3];

				}

				$outs=getAllContentEntries("$viewer",$type,$typeid,$limit);
				if(!isset($_GET['loadtype'])){
					if($viewer=="admin"){
						echo $outs['adminoutputtwo'];
					}else if($viewer=="viewer"){
						echo $outs['vieweroutputtwo'];
					}else if(isset($data[4])&&isset($data[4])=="loadalt"){
						echo $outs['altadminoutput'];
					}

				}else{
					if(isset($_GET['loadtype'])&&$_GET['loadtype']){
						// this parameter if for bootpag type pagination
						// which sends the outputtype with one
						if($_GET['loadtype']=="jsonloadalt"){
							$msg=$outs['edittotaldatasection'];
							$resultcount=$outs['numrows'];
	 						echo json_encode(array("success"=>"true","msg"=>"$msg","resultcount"=>"$resultcount"));

						}
					}
				}

			}elseif ($type=="client") {
				# code...
				$outs=getAllClients("admin",$limit);
				echo $outs['adminoutputtwo'];
			}elseif ($type=="user") {
				# code...
				$outs=getAllUsers("admin",$limit);
				echo $outs['adminoutputtwo'];
			}elseif ($type=="appuser") {
				# code...
				$outs=getAllUsers("admin",$limit,'appuser');
				echo $outs['adminoutputtwoappuser'];
			}elseif ($type=="premiumads") {
				# code...
				$data=explode('|',$otype);
				$etype=$data[1];
				if($etype!=="searchpremiumads"){
					$outs=getAllPremiumAds("$etype",$limit,"");
				}else{
					$datain[]=$data[1]; //search entry maintype
					$datain[]=$data[2]; // searchval
					$outs=getAllPremiumAds($datain,$limit,"");
				}
				echo $outs['adminoutputtwo'];
			}elseif ($type=="usersearch"||$type=="clientsearch") {
				# code...
				$data=explode('|',$otype);
				$edatain[]=$data[1]; // subtype
				$edatain[]=$data[2]; // searchval
				$edatain[]=$data[3]; // viewer
				$row=mysql_fetch_assoc($run);
				$outs=getAllUsers($edatain,$limit);
				echo $outs['adminoutputtwo'];
			}elseif ($type=="surveysearch") {
				# code...
				$data=explode('|',$otype);
				$edatain[]=$data[1]; // subtype
				$edatain[]=$data[2]; // searchval
				$edatain[]=$data[3]; // viewer
				$row=mysql_fetch_assoc($run);
				$outs=getAllSurvey($edatain,"","",$limit);
				echo $outs['adminoutputtwo'];
			}
		}else{
				echo'No database entries ';
			
		}
	}elseif ($type=="") {
		# code...
		$msg="";
		while($row=mysql_fetch_assoc($run)){
			$msg.='<p>code:'.$row['code'].'&nbsp;';
			$msg.='description:'.$row['description'].'&nbsp;';
			$msg.='subclass:'.$row['subclass'].'&nbsp;';
			$msg.='Class:'.$row['class'].'&nbsp;</p><br>';
		}
		if($_GET['loadtype']=="jsonloadalt"){
			$resultcount=mysql_num_rows($run);
			echo json_encode(array("success"=>"true","msg"=>"$msg","resultcount"=>"$resultcount"));
		}
			
	}elseif ($displaytype=="newpagination") {
		# code...
	}
}elseif ($displaytype=="delete") {
	# code...
	$mediaid=$extraval;
	$outs=deleteMedia($mediaid);
	echo $outs;
}elseif ($displaytype=="searchcomments") {
	# code...
	$searchval=mysql_real_escape_string($_GET['searchval']);
	$blogentryid=mysql_real_escape_string($_GET['blogid']);
	if($searchval=="gwolcomments"){
	$query="SELECT * FROM comments where blogentryid=$blogentryid order by id desc";
	$adminoutput='NO comments were found under this blog post';
	}else{
	$query="SELECT * FROM comments where fullname LIKE '%$searchval%' AND blogentryid=$blogentryid OR comment LIKE \"%$searchval%\" AND blogentryid=$blogentryid order by id desc";
	$adminoutput='NO results were found for your search "<b>'.$searchval.'</b>" under this blog post';
	}
	// echo $query."over here";
	$run=mysql_query($query)or die(mysql_error()." Line 287");
	$numrows=mysql_num_rows($run);
	if($numrows>0){
		$adminoutput="";
		while($row=mysql_fetch_assoc($run)){
			$outs=getSingleComment($row['id']);
			$adminoutput.=$outs['adminoutput'];
		}
	}
	echo $adminoutput;
}elseif($displaytype=="removecomment"){
	$cid=mysql_real_escape_string($_GET['cid']);
	genericSingleUpdate("comments","status",'disabled',"id",$cid);
	echo "removed";
}elseif ($displaytype=="mainsearch") {
	# code...
	$searchby=mysql_real_escape_string($_GET['searchby']);
	$searchval=mysql_real_escape_string($_GET['mainsearch']);
	if($searchby=="blogtitle"){
		$viewer=$extraval;
		$query="SELECT * FROM blogentries WHERE title LIKE '%$searchval%'";
		$vout=array();
		$vout[0]=$extraval;
		$vout[1]=$query;
		$type="nil";
		$typeid=0;
		$outs=getAllBlogEntries($vout,'',$typeid,$type);
		if($extraval=="admin"){			
			echo $outs['adminoutput'];
		}elseif ($extraval=="viewer") {
			# code...
			echo $outs['vieweroutput'];
		}
	}elseif($searchby=="blogentry"){
		$viewer=$extraval;
		$query="SELECT * FROM blogentries WHERE blogpost LIKE '%$searchval%'";
		$vout=array();
		$vout[0]=$extraval;
		$vout[1]=$query;
		$type="nil";
		$typeid=0;
		$outs=getAllBlogEntries($vout,'',$typeid,$type);
		if($extraval=="admin"){			
		echo $outs['adminoutput'];
		}elseif ($extraval=="viewer") {
			# code...
		echo $outs['vieweroutput'];
		}
	}elseif($searchby=="blogintro"){
		$viewer=$extraval;
		$query="SELECT * FROM blogentries WHERE introparagraph LIKE '%$searchval%'";
		$vout=array();
		$vout[0]=$extraval;
		$vout[1]=$query;
		$type="nil";
		$typeid=0;
		$outs=getAllBlogEntries($vout,'',$typeid,$type);
		if($extraval=="admin"){			
		echo $outs['adminoutput'];
		}elseif ($extraval=="viewer") {
			# code...
		echo $outs['vieweroutput'];
		}
	}elseif(
		/*New search block for users*/
		$searchby=="username"||$searchby=="userstatus"
		/*search for clients by name and status*/
		||$searchby=="useremail"){
		$viewer=$extraval;
		$vout=array();
		$vout[0]=$searchby;
		$vout[1]=$searchval;
		$vout[2]="admin";
		$type="nil";
		$typeid=0;
		$outs=getAllUsers($vout,'');
		if($extraval=="admin"){			
			echo $outs['adminoutput'];
		}elseif ($extraval=="viewer") {
			# code...
			echo $outs['vieweroutput'];
		}
	}elseif(
		/*search for clients by name and status*/
		$searchby=="clientname"||$searchby=="clientstatus"){
		$viewer=$extraval;
		$vout=array();
		$vout[0]=$searchby;
		$vout[1]=$searchval;
		$vout[2]="admin";
		$type="nil";
		$typeid=0;
		$outs=getAllClients($vout,'');
		if($extraval=="admin"){			
			echo $outs['adminoutput'];
		}elseif ($extraval=="viewer") {
			# code...
			echo $outs['vieweroutput'];
		}
	}elseif(
		/*New search block for surveys*/
		$searchby=="surveytitle"||$searchby=="surveystatus"
		/*search for surveys by creationdate and expirystatus*/
		||$searchby=="creationdate"||$searchby=="expirystatus"
		||$searchby=="clientnamesurvey"){
		$viewer=$extraval;
		$vout=array();
		$vout[0]=$searchby;
		$vout[1]=$searchval;
		$vout[2]="admin";
		$type="nil";
		$typeid=0;
		$outs=getAllSurvey($vout,'','','');
		if($extraval=="admin"){			
			echo $outs['adminoutput'];
		}elseif ($extraval=="viewer") {
			# code...
			echo $outs['vieweroutput'];
		}
	}else{
		echo "Unrecognized searchby option <b>$searchby</b>";
	}
}elseif ($displaytype=="muralupload") {
	# code...
	$file=$_FILES['profpic']['name'];
	if($file!==""){

		$image="profpic";
		  
		$imgpath[]='../files/originals/';
		$imgpath[]='../files/medsizes/';
		$imgpath[]='../files/thumbnails/';

		$imgsize[]="default";
		$imgsize[]=",400";
		$imgsize[]=",150";

		$acceptedsize="";
		$imgouts=genericImageUpload($image,"varying",$imgpath,$imgsize,$acceptedsize);
		$len=strlen($imgouts[0]);
		$imagepath=substr($imgouts[0], 1,$len);
		// medium size
		$len2=strlen($imgouts[1]);
		$imagepath2=substr($imgouts[1], 1,$len2);
		$len3=strlen($imgouts[2]);
		$imagepath3=substr($imgouts[2], 1,$len3);
		// get image size details
		list($width,$height)=getimagesize($imgouts[0]);
		$imagesize=$_FILES[''.$image.'']['size'];
		$filesize=$imagesize/1024;
		//// echo $filefirstsize;
		$filesize=round($filesize, 0, PHP_ROUND_HALF_UP);
		if(strlen($filesize)>3){
			$filesize=$filesize/1024;
			$filesize=round($filesize,2); 
			$filesize="".$filesize."MB";
		}else{
			$filesize="".$filesize."KB";
		}
		//$coverpicid=getNextId("media");
		//maintype variants are original, medsize, thumb for respective size image.
		// check for a loose/inactive mural entry in the media table and if any perform update
		$cquery="SELECT * FROM media WHERE maintype='muralimage' AND status='inactive'";
		$crun=mysql_query($cquery)or die(mysql_error()." Line ".__LINE__);
		$cnrows=mysql_num_rows($crun);

		$crow="";
		if($cnrows>0){
			$crow=mysql_fetch_assoc($crun);
			$imgid=$crow['id'];
			genericSingleUpdate("media","location",$imagepath,"id",$imgid);
			genericSingleUpdate("media","medsize",$imagepath2,"id",$imgid);
			genericSingleUpdate("media","thumbnail",$imagepath3,"id",$imgid);
			genericSingleUpdate("media","filesize",$filesize,"id",$imgid);
			genericSingleUpdate("media","width",$width,"id",$imgid);
			genericSingleUpdate("media","height",$height,"id",$imgid);	
			genericSingleUpdate("media","status","active","id",$imgid);
		}else{
			$imgid=getNextIdExplicit('media');
			$mediaquery="INSERT INTO media(maintype,mediatype,location,medsize,thumbnail,filesize,width,height)VALUES('muralimage','image','$imagepath','$imagepath2','$imagepath3','$filesize','$width','$height')";
			// echo "$mediaquery media query<br>";
			$mediarun=mysql_query($mediaquery)or die(mysql_error()." Line ".__LINE__);
		}
		echo json_encode( array( "original"=>"$imagepath","medsize"=>"$imagepath2","thumbnail"=>"$imagepath3","imgid"=>"$imgid","filesize"=>"$filesize","filetitle"=>"$file") );
	}else{
		echo json_encode( array( "error"=>"Something went wrong"));

	}

}
?>