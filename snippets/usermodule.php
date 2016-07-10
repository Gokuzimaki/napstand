<?php 
	function getSingleUserPlain($id){
		global $host_addr;
		$row=array();
		$query="SELECT * FROM users where id=$id";
		$row=array();
		$run=mysql_query($query)or die(mysql_error()." Line ".__LINE__);
		$numrows=mysql_num_rows($run);
		/*query2="SELECT * FROM surveys where userid=$typeid";
		$run2=mysql_query($query2)or die(mysql_error()." Line 899");
		$row2=mysql_fetch_assoc($run2);*/
		/*Image output section*/
			$originalimage="";
			$medimage="";
			$thumbimage="";
			$banneroriginalimage="";
			$bannermedimage="";
			$bannerthumbimage="";
		/*end*/
		if($numrows>0){
			$row=mysql_fetch_assoc($run);
			$id=$row['id'];
			$fullname=$row['fullname'];
			$ndata=explode(" ",$fullname);
			$firstname=$ndata[0];
			$middlename=isset($ndata[1])?$ndata[1]:"";
			$lastname=isset($ndata[2])?$ndata[2]:"";
			$gender=$row['gender'];
			$maritalstatus=$row['maritalstatus'];
			$state=$row['state'];
			// $state==""?$state="None specified":$state=$state;
			$lga=$row['lga'];
			$lgdata=$lga!==""?getSingleLGA($lga):"";
			// $row['lgdata']=$lgdata;
			$localgovt=isset($lgdata['local_govt'])?$lgdata['local_govt']:"";
			$row['lgdata']=$localgovt;
			$password=$row['pword'];
			$email=$row['email'];
			$phonenumber=$row['phonenumber'];
			if($phonenumber!==""){
				$phonearr=explode("[|><|]", $phonenumber);
				$phoneone=strlen($phonearr[0])==11?substr($phonearr[0], 1,9):$phonearr[0];
				$phonetwo=strlen($phonearr[1])==11?substr($phonearr[1], 1,9):$phonearr[1];
				$phonethree=strlen($phonearr[2])==11?substr($phonearr[2], 1,9):$phonearr[2];
			}else{
				$phoneone="";$phonetwo="";$phonethree="";
			}
			$row['phoneone']=$phoneone;
			$row['phonetwo']=$phonetwo;
			$row['phonethree']=$phonethree;
			$dob=$row['dob'];
			$age="";
			if($dob!=="0000-00-00"){
				$dobdata=explode("-",$dob);
				$dobyear=$dobdata[0];
				$curyear=date("Y");
				$age=$dobyear>0?$curyear-$dobyear:0;
			}
			$row['age']=$age;
			$regdate=$row['regdate'];
			$dobchangedate=$row['dobchangedate'];
			$genderchangedate=$row['genderchangedate'];
			$maritalstatuschangedate=$row['maritalstatuschangedate'];
			$today=date("Y-m-d");
			$timenow=date("H:i:s");
			$statechangedate=$row['statechangedate'];
			$status=$row['status'];
			$nameout=$fullname; // variable holds default name by usertype
			if($row['usertype']=='user'){
				// get profilepicture
				$facequery2="SELECT * FROM media where ownerid=$id AND ownertype='user' AND maintype='profpic'";
				$facerun2=mysql_query($facequery2)or die(mysql_error()." Line 27");
				$facerow2=mysql_fetch_assoc($facerun2);
				$numrowface=mysql_num_rows($facerun2);
				$row['faceid']=$facerow2['id'];
				if($numrowface>0){
					$originalimage=$host_addr.$facerow2['location'];
					$medimage=$host_addr.$facerow2['medsize'];
					$thumbimage=$host_addr.$facerow2['thumbnail'];
				}
				$nameout=$fullname;
			}else if ($row['usertype']=='client') {
				# code...
				// get biz logo and banner
				$bizlogoquery2="SELECT * FROM media where ownerid=$id AND ownertype='client' AND maintype='bizlogo'";
				$bizlogorun2=mysql_query($bizlogoquery2)or die(mysql_error()." Line 27");
				$nameout=$row['businessname'];
				$bizlogorow2=mysql_fetch_assoc($bizlogorun2);
				$numrowbizlogo=mysql_num_rows($bizlogorun2);
				$row['bizlogoid']=$bizlogorow2['id'];
				$row['bizlogofile']=$bizlogorow2['location'];
				$bizlogoid=0;
				if($numrowbizlogo>0){
					$originalimage=$host_addr.$bizlogorow2['location'];
					$medimage=$host_addr.$bizlogorow2['medsize'];
					$thumbimage=$host_addr.$bizlogorow2['thumbnail'];
				}
				$bannerlogoquery2="SELECT * FROM media where ownerid=$id AND ownertype='client' AND maintype='bannerlogo'";
				$bannerlogorun2=mysql_query($bannerlogoquery2)or die(mysql_error()." Line 27");
				$bannerlogorow2=mysql_fetch_assoc($bannerlogorun2);
				$numrowbannerlogo=mysql_num_rows($bannerlogorun2);
				$row['bannerlogoid']=$bannerlogorow2['id'];
				$row['bannerlogofile']=$bannerlogorow2['location'];
				$bannerlogoid=0;
				if($numrowbannerlogo>0){
					$banneroriginalimage=$host_addr.$bannerlogorow2['location'];
					$bannermedimage=$host_addr.$bannerlogorow2['medsize'];
					$bannerthumbimage=$host_addr.$bannerlogorow2['thumbnail'];
				}
			}else if ($row['usertype']=='appuser') {
				# code...
				// get profilepicture
				$facequery2="SELECT * FROM media where ownerid=$id AND ownertype='appuser' AND maintype='profpic'";
				$facerun2=mysql_query($facequery2)or die(mysql_error()." Line 27");
				$facerow2=mysql_fetch_assoc($facerun2);
				$numrowface=mysql_num_rows($facerun2);
				$row['faceid']=$facerow2['id'];
				if($numrowface>0){
					$originalimage=$host_addr.$facerow2['location'];
					$medimage=$host_addr.$facerow2['medsize'];
					$thumbimage=$host_addr.$facerow2['thumbnail'];
				}
				$nameout=$fullname;
			}
		}
		$row['numrows']=$numrows;
		$row['nameout']=$nameout;
		$row['originalimage']=$originalimage;
		$row['medimage']=$medimage;
		$row['thumbimage']=$thumbimage;
		$row['banneroriginalimage']=$banneroriginalimage;
		$row['bannermedimage']=$bannermedimage;
		$row['bannerthumbimage']=$bannerthumbimage;
		return $row;
	}

	function getSingleUser($id){
		global $host_addr;
		$row=array();
		$query="SELECT * FROM users where id=$id";
		$run=mysql_query($query)or die(mysql_error()." Line  ".__LINE__);
		$numrows=mysql_num_rows($run);
		/*query2="SELECT * FROM surveys where userid=$typeid";
		$run2=mysql_query($query2)or die(mysql_error()." Line 899");
		$row2=mysql_fetch_assoc($run2);*/
		if($numrows>0){
			$row=mysql_fetch_assoc($run);
			$id=$row['id'];
			$fullname=$row['fullname'];
			$firstname=$row['firstname'];
			$middlename=isset($row['middlename'])?$row['middlename']:"";
			$lastname=isset($row['lastname'])?$row['lastname']:"";
			$nickname=isset($row['nickname'])?$row['nickname']:"";
			$details=isset($row['details'])?$row['details']:"";
			$catid=$row['catid'];
			if($catid>0){
				$catdata=getSingleContentCategory($catid);
				$catname=$catdata['catname'];
			}else{
				$catdata=array();
				$catname="";
			}
			$gender=$row['gender'];
			$maritalstatus=$row['maritalstatus'];
			$state=$row['state'];
			$lga=$row['lga'];
			$lgdata=$lga!==""?getSingleLGA($lga):"";
			$row['lgdata']=$lgdata;
			$localgovt=isset($lgdata['local_govt'])?$lgdata['local_govt']:"";
			$lgaoptions='<option value="">Choose your Local Government Area</option>';
			$lgquery="SELECT local_govt,id_no FROM local_govt WHERE state_id = (select id_no from state where state='$state')";
			// echo $lgquery;
			$lgrun=mysql_query($lgquery)or die(mysql_error()." Line 50");
			$lgnumrows=mysql_num_rows($lgrun);
			if($lgnumrows>0){
				while($lgrow=mysql_fetch_assoc($lgrun)){
					$lgaoptions.='<option value="'.$lgrow['id_no'].'">'.$lgrow['local_govt'].'</option>';
				}					
			}
			$businessaddress=$row['businessaddress'];
			$password=$row['pword'];
			$email=$row['email'];
			$phonenumber=$row['phonenumber'];
			if($phonenumber!==""){
				$phonearr=explode("[|><|]", $phonenumber);
				$phoneone=strlen($phonearr[0])==11?substr($phonearr[0], 1,9):$phonearr[0];
				$phonetwo=strlen($phonearr[1])==11?substr($phonearr[1], 1,9):$phonearr[1];
				$phonethree=strlen($phonearr[2])==11?substr($phonearr[2], 1,9):$phonearr[2];
			}else{
				$phoneone="";$phonetwo="";$phonethree="";
			}
			$row['phoneone']=$phoneone;
			$row['phonetwo']=$phonetwo;
			$row['phonethree']=$phonethree;
			$dob=$row['dob'];
			$age="";
			if($dob!=="0000-00-00"){
				$dobdata=explode("-",$dob);
				$dobyear=$dobdata[0];
				$curyear=date("Y");
				$age=$dobyear>0?$curyear-$dobyear:0;
			}
			$row['age']=$age;
			$regdate=$row['regdate'];
			$dobchangedate=$row['dobchangedate'];
			$genderchangedate=$row['genderchangedate'];
			$maritalstatuschangedate=$row['maritalstatuschangedate'];
			$today=date("Y-m-d");
			$timenow=date("H:i:s");
			$statechangedate=$row['statechangedate'];
			$statedata=explode("-",$statechangedate);
			$td=date("d");
			$tm=date("m");
			$ty=date("Y");
			$sy=$statedata[0];
			$sm=$statedata[1];
			$sd=$statedata[2];
			$maritalchangedata=explode("-",$maritalstatuschangedate);
			$marcy=$maritalchangedata[0];
			$marcm=$maritalchangedata[1];
			$marcd=$maritalchangedata[2];
			$genderdata=explode("-",$genderchangedate);
			$gy=$genderdata[0];
			$gm=$genderdata[1];
			$gd=$genderdata[2];
			$dobdata=explode("-",$dobchangedate);
			$doby=$dobdata[0];
			$dobm=$dobdata[1];
			$dobd=$dobdata[2];
			$statedisabled="";
			$dobdisabled="";
			$maritalstatusdisabled="";
			$genderdisabled="";
			if($gy!=="0000"){
				$genderdisabled='disabled title="Sorry you have editted this once already, you can\'t go on with this change, if you need help you can contact the Napstand team for help"';
			}
			if($marcy>=$ty&&$tm<=$marcm){
				$maritalstatusdisabled='disabled title="Sorry you have editted this once the month change it next month"';
			}

			if($doby!=="0000"){
				$dobdisabled='disabled title="Sorry, but you are not allowed to perform anymore changes on this"';
			}

			if($sy>=$ty&&$sm<=$tm){
				$statedisabled='disabled title="Sorry you have editted this once the month change it next month"';
			}

			// get social data
  			//  link and handles data are in the form tw|fb|gp|ln|pin|tblr|ig
  			$totalhandles=explode("[|><|]",$row['socialhandles']);
  			$totallinks=explode("[|><|]",$row['socialurls']);
  			$row['cursocialhandles']=$totalhandles;
  			$row['cursociallinks']=$totallinks;
  			$sociallinksection="";
  			if(count($totalhandles)>0&&$row['socialhandles']!==""){
				// twitter
				$twhandle=$totalhandles[0];
				$twlink=$totallinks[0];
				// facebook
				$fbhandle=$totalhandles[1];
				$fblink=$totallinks[1];
				// gplus
				$gphandle=$totalhandles[2];
				$gplink=$totallinks[2];
				// Linkedin
				$inhandle=$totalhandles[3];
				$inlink=$totallinks[3];
				// Pinterest
				$pinhandle=$totalhandles[4];
				$pinlink=$totallinks[4];
				// tumblr
				$tblrhandle=$totalhandles[5];
				$tblrlink=$totallinks[5];			
				// instagram
				$ighandle=$totalhandles[6];
				$iglink=$totallinks[6];
				$sociallinksection='
					<div class="col-xs-12">
            			<input type="hidden" name="socialcount" value="7">
    					<div class="col-sm-4">
          				  <div class="form-group">
		                    <label>Facebook:</label>
		                    <div class="input-group">
		                      <div class="input-group-addon">
		                        <i class="fa fa-facebook"></i>
		                      </div>
		                      <input type="text" class="form-control" name="socialhandlefb" data-type="handle" data-pos="1" value="'.$totalhandles[1].'" Placeholder="Social handle, e.g Age Comics"/>
		                      <input type="text" class="form-control" name="socialhandlefblink" data-type="link" data-pos="1" value="'.$totallinks[1].'" Placeholder="Social link, e.g http://facebook.com/AgeComics"/>
		                    </div><!-- /.input group -->
		                  </div><!-- /.form group -->
	                    </div>
	                    <div class="col-sm-4">
          				  <div class="form-group">
		                    <label>Twitter:</label>
		                    <div class="input-group">
		                      <div class="input-group-addon">
		                        <i class="fa fa-twitter"></i>
		                      </div>
		                      <input type="text" class="form-control" name="socialhandletw" data-type="handle" data-pos="2" value="'.$totalhandles[0].'" Placeholder="Social handle, e.g @AgeComics"/>
		                      <input type="text" class="form-control" name="socialhandletwlink" data-type="link" data-pos="2" value="'.$totallinks[0].'" Placeholder="Social link, e.g http://twitter.com/AgeComics"/>
		                    </div><!-- /.input group -->
		                  </div><!-- /.form group -->
	                    </div>
	                    <div class="col-sm-4">
          				  <div class="form-group">
		                    <label>Google Plus:</label>
		                    <div class="input-group">
		                      <div class="input-group-addon">
		                        <i class="fa fa-google-plus"></i>
		                      </div>
		                      <input type="text" class="form-control" name="socialhandlegp" data-type="handle" data-pos="3" value="'.$totalhandles[2].'" Placeholder="Social handle, e.g AgeComics"/>
		                      <input type="text" class="form-control" name="socialhandlegplink" data-type="link" data-pos="3" value="'.$totallinks[2].'" Placeholder="Social link, e.g http://plus.google.com/thelink"/>
		                    </div><!-- /.input group -->
		                  </div><!-- /.form group -->
	                    </div>
	                    <div class="col-sm-4">
          				  <div class="form-group">
		                    <label>LinkedIn:</label>
		                    <div class="input-group">
		                      <div class="input-group-addon">
		                        <i class="fa fa-linkedin"></i>
		                      </div>
		                      <input type="text" class="form-control" name="socialhandlein" data-type="handle" data-pos="4" value="'.$totalhandles[3].'" Placeholder="Social handle, e.g AgeComics"/>
		                      <input type="text" class="form-control" name="socialhandleinlink" data-type="link" data-pos="4" value="'.$totallinks[3].'" Placeholder="Social link, e.g http://linkedin.com/thelink"/>
		                    </div><!-- /.input group -->
		                  </div><!-- /.form group -->
	                    </div>
	                    <div class="col-sm-4">
          				  <div class="form-group">
		                    <label>Pinterest:</label>
		                    <div class="input-group">
		                      <div class="input-group-addon">
		                        <i class="fa fa-pinterest"></i>
		                      </div>
		                      <input type="text" class="form-control" name="socialhandlepin" data-type="handle" data-pos="5" value="'.$totalhandles[4].'" Placeholder="Social handle, e.g @AgeComics"/>
		                      <input type="text" class="form-control" name="socialhandlepinlink" data-type="link" data-pos="5" value="'.$totallinks[4].'" Placeholder="Social link, e.g http://pinterest.com/AgeComics"/>
		                    </div><!-- /.input group -->
		                  </div><!-- /.form group -->
	                    </div>
	                    <div class="col-sm-4">
          				  <div class="form-group">
		                    <label>Tumblr:</label>
		                    <div class="input-group">
		                      <div class="input-group-addon">
		                        <i class="fa fa-tumblr"></i>
		                      </div>
		                      <input type="text" class="form-control" name="socialhandletblr" data-type="handle" data-pos="6" value="'.$totalhandles[5].'" Placeholder="Social handle, e.g @AgeComics"/>
		                      <input type="text" class="form-control" name="socialhandletblrlink" data-type="link" data-pos="6" value="'.$totallinks[5].'" Placeholder="Social link, e.g http://tumblr.com/AgeComics"/>
		                    </div><!-- /.input group -->
		                  </div><!-- /.form group -->
	                    </div>
	                    <div class="col-sm-4">
          				  <div class="form-group">
		                    <label>Instagram:</label>
		                    <div class="input-group">
		                      <div class="input-group-addon">
		                        <i class="fa fa-instagram"></i>
		                      </div>
		                      <input type="text" class="form-control" name="socialhandleig" data-type="handle" data-pos="7" value="'.$totalhandles[6].'" Placeholder="Social handle, e.g @AgeComics"/>
		                      <input type="text" class="form-control" name="socialhandleiglink" data-type="link" data-pos="7" value="'.$totallinks[6].'" Placeholder="Social link, e.g http://instagram.com/AgeComics"/>
		                    </div><!-- /.input group -->
		                  </div><!-- /.form group -->
	                    </div>
	                </div>
				';
  			}

			

			/*edit block for irrelevant data objects that aren't currently used in the module*/
				/*Date of birth*/
				/*
				<div class="col-xs-12">
	            	<div class="form-group">
	                    <label>Date Of Birth:</label>
	                    <div class="input-group">
	                      <div class="input-group-addon">
	                        <i class="fa fa-calendar"></i>
	                      </div>
	                      <input type="text" '.$dobdisabled.' name="dob" class="form-control" data-inputmask="\'alias\': \'yyyy-mm-dd\'" data-mask value="'.$dob.'"/>
	                    </div><!-- /.input group -->
	                </div><!-- /.form group -->
	            </div>
	            */
	            /*Marital status*/
	            /*
				<div class="col-xs-12">
	                <div class="form-group">
	                    <label>Marital Status:</label>
	                    <div class="input-group">
	                      <div class="input-group-addon">
	                        <i class="fa fa-venus-mars"></i>
	                      </div>
	                      <select id="maritalstatus" name="maritalstatus" '.$maritalstatusdisabled.' class="form-control">
	                    		<option value="">--Choose Status--</option>
	                    		<option value="single">Single</option>
	                    		<option value="married">Married</option>
	                    		<option value="others">Others</option>
	                      </select>
	                    </div><!-- /.input group -->
	                </div><!-- /.form group -->
	            </div>
	            */
			/*end*/
			$status=$row['status'];

			// get profilepicture
			$facequery2="SELECT * FROM media where ownerid=$id AND ownertype='user' AND maintype='profpic'";
			$facerun2=mysql_query($facequery2)or die(mysql_error()." Line 27");
			$facerow2=mysql_fetch_assoc($facerun2);
			$numrowface=mysql_num_rows($facerun2);
			$row['faceid']=$facerow2['id'];
			if($numrowface>0){
				$face='<img src="'.$host_addr.''.$facerow2['thumbnail'].'">';
				$face2=''.$host_addr.''.$facerow2['thumbnail'].'';
			}else{
				$face2=''.$host_addr.'/images/default.gif';
				$face='<p style="text-align:center;"><i class="fa fa-user fa-3x"></i></p>';
				$row['faceid']=0;
			}
			$row['facefile']=$face2;
			$row['facefile2']=$facerow2['location'];

			$selectionscripts='
				<script>
					$(document).ready(function(){
						$("select[name=gender]").val("'.$gender.'");
						$("select[name=maritalstatus]").val("'.$maritalstatus.'");
						$("select[name=state]").val("'.$state.'");
						$("select[name=LocalGovt]").val("'.$lga.'");
						$("select[name=catid]").val("'.$catid.'");
						$("[data-mask]").inputmask();
						$(".timepicker").timepicker({
				          showInputs: true
				        });
					})
				</script>
			';
			$row['adminoutput']='
				<tr data-id="'.$id.'">
					<td class="tddisplayimg">'.$face.'</td><td>'.$fullname.'</td><td>'.$catname.'</td><td>'.$state.'</td><td>'.$localgovt.'</td><td>'.$phoneone.' '.$phonetwo.' '.$phonethree.'</td><td>'.$gender.'</td><td>'.$regdate.'</td><td>'.$status.'</td><td name="trcontrolpoint"><a href="#&id='.$id.'" name="edit" data-type="editsingleuseradmin" data-divid="'.$id.'">Edit</a></td>
				</tr>
				<tr name="tableeditcontainer" data-state="inactive" data-divid="'.$id.'">
					<td colspan="100%">
						<div id="completeresultdisplay" data-type="editmodal" data-load="unloaded" data-divid="'.$id.'">
							<div id="completeresultdisplaycontent" data-type="editdisplay" data-divid="'.$id.'">
								
							</div>
						</div>
					</td>
				</tr>
			';
			$row['adminoutputtwo']='
					<div id="form" style="background-color:#fefefe;">
						<form action="'.$host_addr.'snippets/edit.php" name="edituser" method="post" enctype="multipart/form-data">
							<input type="hidden" name="entryvariant" value="edituser"/>
							<input type="hidden" name="entryid" value="'.$id.'"/>
							<div id="formheader">Edit <!--"'.$fullname.'"\'s--> Profile</div>
							<div class="row textcenter">
				            		<div class="miniwiddy">
					            		<img src="'.$face2.'" class="heightfull"/>
					            			<span class="btn btn-success fileinput-button absbottom" name="changeprofpic">
						                    <i class="fa fa-plus"></i>
						                    <span>Change Photo</span>
						                    <input type="file" name="profpic"  />
						                </span>
					            	</div>
				            	</div>
				            	<div class="col-md-12">

					            	<div class="col-md-6">
						            	<div class="box overflowhidden box-primary">
						            		<div class="box-header">
							            		<h4 class="box-title"><b>Personal Information</b></h4>
							            		<div class="box-tools pull-right"><i class="fa fa-user fa-2x"></i></div>
						            		</div>
						            		<div class="box-body">
						            			<div class="form-group">
								                    <div class="col-xs-4">
				                      				  <label>Firstname</label>
								                      <input type="text" class="form-control" name="firstname" placeholder="Firstname" value="'.$firstname.'"/>
								                    </div>
								                    <div class="col-xs-4">
				                      				  <label>Middlename</label>
								                      <input type="text" class="form-control" name="middlename"placeholder="Middlename" value="'.$middlename.'"/>
								                    </div>
								                    <div class="col-xs-4">
				                      				  <label>Lastname</label>
								                      <input type="text" class="form-control" name="lastname" placeholder="Lastname" value="'.$lastname.'"/>
								                    </div>
									                <div class="col-xs-6">
							                        	<div class="form-group">
									                      <label>Nickname</label>
									                      <input type="text" class="form-control" name="nickname" value="'.$nickname.'" placeholder="Nickname"/>
									                    </div>
									                </div>
						                            <div class="col-xs-6">
									                    <div class="form-group">
										                    <label>Gender:</label>
										                    <div class="input-group">
										                      <div class="input-group-addon">
										                        <i class="fa fa-transgender"></i>
										                      </div>
										                      <select id="gender" '.$genderdisabled.' name="gender" class="form-control">
								                            		<option value="">--Choose Sex--</option>
								                            		<option value="male">Male</option>
								                            		<option value="female">Female</option>
								                              </select>
										                    </div><!-- /.input group -->
									                    </div><!-- /.form group -->
								                    </div>
								                    <div class="col-xs-12">
							                        	<div class="form-group">
										                  <label>Bio</label>
										                  <textarea class="form-control" rows="3" name="bio" placeholder="Provide a bio for this profile, something witty and simple would do">'.$details.'</textarea>
										                </div>
										            </div>
								              	</div>
						                    </div>
					            		</div>
					            	</div>
					            	<div class="col-md-6">							
					            		<div class="box overflowhidden box-info">
						            		<div class="box-header">
							            		<h4 class="box-title"><b>Location Information</b></h4>
							            		<div class="box-tools pull-right"><i class="fa fa-map-marker fa-2x"></i></div>
						            		</div>
						            		<div class="box-body">
						            			<div class="form-group">
								                    <div class="col-xs-12">
								                      <label>State</label>
								                      <select name="state" id="state" '.$statedisabled.' class="form-control" onchange="showLocalGovt(this.value)">
															<option value="">Select your State</option>
															<option value="Abia">Abia</option>
															<option value="Adamawa">Adamawa</option>
															<option value="Akwa Ibom">Akwa Ibom</option>
															<option value="Anambra">Anambra</option>
															<option value="Bauchi">Bauchi</option>
															<option value="Bayelsa">Bayelsa</option>
															<option value="Benue">Benue</option>
															<option value="Borno">Borno</option>
															<option value="Cross River">Cross River</option>
															<option value="Delta">Delta</option>
															<option value="Ebonyi">Ebonyi</option>
															<option value="Edo">Edo</option>
															<option value="Ekiti">Ekiti</option>
															<option value="Enugu">Enugu</option>
															<option value="FCT">FCT</option>
															<option value="Gombe">Gombe</option>
															<option value="Imo">Imo</option>
															<option value="Jigawa">Jigawa</option>
															<option value="Kaduna">Kaduna</option>
															<option value="Kano">Kano</option>
															<option value="Kastina">Kastina</option>
															<option value="Kebbi">Kebbi</option>
															<option value="Kogi">Kogi</option>
															<option value="Kwara">Kwara</option>
															<option value="Lagos">Lagos</option>
															<option value="Nasarawa">Nasarawa</option>
															<option value="Niger">Niger</option>
															<option value="Ogun">Ogun</option>
															<option value="Ondo">Ondo</option>
															<option value="Osun">Osun</option>
															<option value="Oyo">Oyo</option>
															<option value="Plateau">Plateau</option>
															<option value="Rivers">Rivers</option>
															<option value="Sokoto">Sokoto</option>
															<option value="Taraba">Taraba</option>
															<option value="Yobe">Yobe</option>
															<option value="Zamfara">Zamfara</option>
													  </select>
								                    </div>
								                    <div class="col-xs-12">
								                      <label>LocalGovt</label>
								                      <select id="LocalGovt" name="LocalGovt" class="form-control">
					                            		'.$lgaoptions.'
					                            	  </select>
								                    </div>
								                    <div class="form-group">
									                  <label>Full Address</label>
									                  <textarea class="form-control" rows="3" name="address" placeholder="Provide an address">'.$businessaddress.'</textarea>
									                </div>
								                </div>
						                    </div>
					            		</div>
					            	</div>
				            	</div>
				            	<div class="col-md-12">
					            	<div class="col-md-6">							
					            		<div class="box overflowhidden box-primary">
						            		<div class="box-header">
							            		<h4 class="box-title"><b>Contact Information & Status</b></h4>
							            		<div class="box-tools pull-right"><i class="fa fa-telephone fa-2x"></i><i class="fa fa-envelope fa-2x"></i></div>
						            		</div>
						            		<div class="box-body">
						            			<div class="form-group">
						            				<div class="col-md-12">
									                    <div class="col-md-4">
					                      				  <div class="form-group">
										                    <label>Phone One:</label>
										                    <div class="input-group">
										                      <div class="input-group-addon">
										                        <i class="fa fa-phone"></i>
										                      </div>
										                      <input type="text" class="form-control" name="phoneone" value="'.$phoneone.'" data-inputmask=\'"mask": "(234) 999-999-9999"\' data-mask/>
										                    </div><!-- /.input group -->
										                  </div><!-- /.form group -->
									                    </div>
									                    <div class="col-md-4">
					                      				  <div class="form-group">
										                    <label>Phone Two:</label>
										                    <div class="input-group">
										                      <div class="input-group-addon">
										                        <i class="fa fa-phone"></i>
										                      </div>
										                      <input type="text" class="form-control" name="phonetwo" value="'.$phonetwo.'" data-inputmask=\'"mask": "(234) 999-999-9999"\' data-mask/>
										                    </div><!-- /.input group -->
										                  </div><!-- /.form group -->
									                    </div>
									                    <div class="col-md-4">
					                      				  <div class="form-group">
										                    <label>Phone Three:</label>
										                    <div class="input-group">
										                      <div class="input-group-addon">
										                        <i class="fa fa-phone"></i>
										                      </div>
										                      <input type="text" class="form-control" name="phonethree" value="'.$phonethree.'" data-inputmask=\'"mask": "(234) 999-999-9999"\' data-mask/>
										                    </div><!-- /.input group -->
										                  </div><!-- /.form group -->
									                    </div>
									                </div>
								                    <div class="col-xs-12">
								                    	<div class="form-group">
										                    <label>Email Address:</label>
										                    <div class="input-group">
										                      <div class="input-group-addon">
										                        <i class="fa fa-envelope-square"></i>
										                      </div>
										                      <input type="email" class="form-control" name="email" value="'.$email.'"/>
										                    </div><!-- /.input group -->
										                  </div><!-- /.form group -->
								                    </div>
								                    <div class="col-xs-12">
								                    	<div class="form-group">
										                    <label> Change Password:</label>
										                    <div class="input-group">
										                      <div class="input-group-addon">
										                        <i class="fa fa-key"></i>
										                      </div>
										                      <input type="password" placeholder="Previous Password" class="form-control" name="prevpassword"/>
										                      <input type="password" placeholder="New Password" class="form-control" name="password"/>
										                    </div><!-- /.input group -->
										                  </div><!-- /.form group -->
								                    </div>
								              	</div>
						                    </div>
					            		</div>
					            	</div>
					            	<div class="col-md-6">							

					            		<div class="panel box box-primary">
					                      <div class="box-header with-border">
					                        <h4 class="box-title">
					                          <a data-toggle="collapse" data-parent="#surveyaccordion" href="#socialBlock">
					                            <i class="fa fa-facebook-official"></i><i class="fa fa-twitter"></i>
					                            <i class="fa fa-linkedin"></i><i class="fa fa-pinterest"></i> 
					                            Social Information
					                          </a>
					                        </h4>
					                      </div>
					                      <div id="socialBlock" class="panel-collapse collapse in">
					                        <div class="box-body">
				                        		'.$sociallinksection.'
											</div>
					                      </div>
					                    </div>
					                </div>
				                </div>
								<div id="formend">
									<input type="submit" name="Update" value="Submit" class="submitbutton"/>
								</div>
						</form>
					</div>
	 				'.$selectionscripts.'
			';
			$row['adminoutputthree']='
					<div id="form" style="background-color:#fefefe;">
						<form action="../snippets/edit.php" name="edituseradmin" method="post" enctype="multipart/form-data">
							<input type="hidden" name="entryvariant" value="edituseradmin"/>
							<input type="hidden" name="entryid" value="'.$id.'"/>
							<div id="formheader">Edit "'.$fullname.'"</div>
							<div class="box-group" id="surveyaccordion">
		            			<div class="panel box box-primary">
			                      <div class="box-header with-border">
			                        <h4 class="box-title">
			                          <a data-toggle="collapse" data-parent="#surveyaccordion" href="#PersonalBlock">
			                            <i class="fa fa-user"></i>  Personal Information
			                          </a>
			                        </h4>
			                      </div>
			                      <div id="PersonalBlock" class="panel-collapse collapse in">
			                        <div class="box-body">
			                        	<div class="form-group">
				            				<div class="col-xs-12">
							                    <div class="col-xs-4">
			                      				  <label>Firstname</label>
							                      <input type="text" class="form-control" name="firstname" placeholder="Firstname" value="'.$firstname.'"/>
							                    </div>
							                    <div class="col-xs-4">
			                      				  <label>Middlename</label>
							                      <input type="text" class="form-control" name="middlename"placeholder="Middlename" value="'.$middlename.'"/>
							                    </div>
							                    <div class="col-xs-4">
			                      				  <label>Lastname</label>
							                      <input type="text" class="form-control" name="lastname" placeholder="Lastname" value="'.$lastname.'"/>
							                    </div>
							                    <div class="col-xs-12">
						                        	<div class="form-group">
								                      <label>Nickname</label>
								                      <input type="text" class="form-control" name="nickname" value="'.$nickname.'" placeholder="Nickname"/>
								                    </div>
								                </div>
							                </div>
						                    <div class="col-xs-6">
							                    <div class="form-group">
								                    <label>Profile Picture:</label>
								                    <div class="input-group">
								                      <div class="input-group-addon">
								                        <i class="fa fa-file-image-o"></i>
								                      </div>
								                      <input type="file" name="profpic" class="form-control" placeholder="Upload Photo"/>
								                    </div><!-- /.input group -->
							                    </div><!-- /.form group -->
						                    </div>
						                    <div class="col-xs-6">
							                    <div class="form-group">
								                    <label>Gender:</label>
								                    <div class="input-group">
								                      <div class="input-group-addon">
								                        <i class="fa fa-transgender"></i>
								                      </div>
								                      <select id="gender" name="gender" class="form-control">
						                            		<option value="">--Choose Sex--</option>
						                            		<option value="male">Male</option>
						                            		<option value="female">Female</option>
						                              </select>
								                    </div><!-- /.input group -->
							                    </div><!-- /.form group -->
						                    </div>

						                    <div class="col-xs-12">
					                        	<div class="form-group">
								                  <label>Bio</label>
								                  <textarea class="form-control" rows="3" name="bio" placeholder="Provide a bio for this profile, something witty and simple would do">'.$details.'</textarea>
								                </div>
								            </div>
						              	</div>
			                        </div>
			                      </div>
			                    </div>
			                    <div class="panel box box-info">
			                      <div class="box-header with-border">
			                        <h4 class="box-title">
			                          <a data-toggle="collapse" data-parent="#surveyaccordion" href="#UserLocationBlock">
			                            <i class="fa fa-map-marker"></i> Location Information
			                          </a>
			                        </h4>
			                      </div>
			                      <div id="UserLocationBlock" class="panel-collapse collapse">
			                        <div class="box-body">
			                        	<div class="form-group">
						                    <div class="col-xs-12">
						                      <label>State</label>
						                      <select name="state" id="state" class="form-control" onchange="showLocalGovt(this.value)">
													<option value="">Select your State</option>
													<option value="Abia">Abia</option>
													<option value="Adamawa">Adamawa</option>
													<option value="Akwa Ibom">Akwa Ibom</option>
													<option value="Anambra">Anambra</option>
													<option value="Bauchi">Bauchi</option>
													<option value="Bayelsa">Bayelsa</option>
													<option value="Benue">Benue</option>
													<option value="Borno">Borno</option>
													<option value="Cross River">Cross River</option>
													<option value="Delta">Delta</option>
													<option value="Ebonyi">Ebonyi</option>
													<option value="Edo">Edo</option>
													<option value="Ekiti">Ekiti</option>
													<option value="Enugu">Enugu</option>
													<option value="FCT">FCT</option>
													<option value="Gombe">Gombe</option>
													<option value="Imo">Imo</option>
													<option value="Jigawa">Jigawa</option>
													<option value="Kaduna">Kaduna</option>
													<option value="Kano">Kano</option>
													<option value="Kastina">Kastina</option>
													<option value="Kebbi">Kebbi</option>
													<option value="Kogi">Kogi</option>
													<option value="Kwara">Kwara</option>
													<option value="Lagos">Lagos</option>
													<option value="Nasarawa">Nasarawa</option>
													<option value="Niger">Niger</option>
													<option value="Ogun">Ogun</option>
													<option value="Ondo">Ondo</option>
													<option value="Osun">Osun</option>
													<option value="Oyo">Oyo</option>
													<option value="Plateau">Plateau</option>
													<option value="Rivers">Rivers</option>
													<option value="Sokoto">Sokoto</option>
													<option value="Taraba">Taraba</option>
													<option value="Yobe">Yobe</option>
													<option value="Zamfara">Zamfara</option>
											  </select>
						                    </div>
						                    <div class="col-xs-12">
						                      <label>LocalGovt</label>
						                      <select id="LocalGovt" name="LocalGovt" class="form-control">
			                            		'.$lgaoptions.'
			                            	  </select>
						                    </div>
						                    <div class="form-group">
							                  <label>Full Address</label>
							                  <textarea class="form-control" rows="3" name="address" placeholder="Provide an address">'.$businessaddress.'</textarea>
							                </div>
						                </div>
			                        </div>
			                      </div>
			                    </div>
			                    <div class="panel box box-primary">
			                      <div class="box-header with-border">
			                        <h4 class="box-title">
			                          <a data-toggle="collapse" data-parent="#surveyaccordion" href="#usercontactBlock">
			                            <i class="fa fa-telephone"></i><i class="fa fa-envelope"></i> Contact Information
			                          </a>
			                        </h4>
			                      </div>
			                      <div id="usercontactBlock" class="panel-collapse collapse">
			                        <div class="box-body">
			                        	<div class="form-group">
				            				<div class="col-xs-12">
							                    <div class="col-xs-4">
			                      				  <div class="form-group">
								                    <label>Phone One:</label>
								                    <div class="input-group">
								                      <div class="input-group-addon">
								                        <i class="fa fa-phone"></i>
								                      </div>
								                      <input type="text" class="form-control" name="phoneone"  data-inputmask=\'"mask": "(234) 999-999-9999"\' data-mask value="'.$phoneone.'"/>
								                    </div><!-- /.input group -->
								                  </div><!-- /.form group -->
							                    </div>
							                    <div class="col-xs-4">
			                      				  <div class="form-group">
								                    <label>Phone Two:</label>
								                    <div class="input-group">
								                      <div class="input-group-addon">
								                        <i class="fa fa-phone"></i>
								                      </div>
								                      <input type="text" class="form-control" name="phonetwo"  data-inputmask=\'"mask": "(234) 999-999-9999"\' data-mask value="'.$phonetwo.'"/>
								                    </div><!-- /.input group -->
								                  </div><!-- /.form group -->
							                    </div>
							                    <div class="col-xs-4">
			                      				  <div class="form-group">
								                    <label>Phone Three:</label>
								                    <div class="input-group">
								                      <div class="input-group-addon">
								                        <i class="fa fa-phone"></i>
								                      </div>
								                      <input type="text" class="form-control" name="phonethree" data-inputmask=\'"mask": "(234) 999-999-9999"\' data-mask value="'.$phonethree.'"/>
								                    </div><!-- /.input group -->
								                  </div><!-- /.form group -->
							                    </div>
							                </div>
						                    <div class="col-xs-12">
						                    	<div class="form-group">
								                    <label>Email Address:</label>
								                    <div class="input-group">
								                      <div class="input-group-addon">
								                        <i class="fa fa-envelope-square"></i>
								                      </div>
								                      <input type="email" class="form-control" name="email" value="'.$email.'"/>
								                    </div><!-- /.input group -->
								                  </div><!-- /.form group -->
						                    </div>  
							            </div>
			                        </div>
			                      </div>
			                    </div>
			                    <div class="panel box box-primary">
			                      <div class="box-header with-border">
			                        <h4 class="box-title">
			                          <a data-toggle="collapse" data-parent="#surveyaccordion" href="#useraccessBlock">
			                            <i class="fa fa-key"></i><i class="fa fa-lock"></i> Login Information & Status
			                          </a>
			                        </h4>
			                      </div>
			                      <div id="useraccessBlock" class="panel-collapse collapse">
			                        <div class="box-body">
			                        	<div class="col-xs-12">
					                    	<div class="form-group">
							                    <label> Change Password:(<b>'.$password.'</b>)</label>
							                    <div class="input-group">
							                      <div class="input-group-addon">
							                        <i class="fa fa-key"></i>
							                      </div>
							                      <input type="hidden" placeholder="Previous Password" class="form-control" name="prevpassword" value="'.$password.'"/>
							                      <input type="password" placeholder="New Password" class="form-control" name="password"/>
							                    </div><!-- /.input group -->
							                  </div><!-- /.form group -->
					                    </div>
					                    <div class="col-xs-12">
					                    	<label>Status</label>
					                    	<select id="status" name="status" class="form-control">
			                            		<option value="">Change Status</option>
			                            		<option value="active">Active</option>
			                            		<option value="inactive">Inactive</option>
			                            	</select>
					                    </div>
			                        </div>
			                      </div>
			                    </div>
			                    <div class="panel box box-primary">
			                      <div class="box-header with-border">
			                        <h4 class="box-title">
			                          <a data-toggle="collapse" data-parent="#surveyaccordion" href="#socialBlock">
			                            <i class="fa fa-facebook-official"></i> <i class="fa fa-twitter"></i>
			                            <i class="fa fa-linkedin"></i> <i class="fa fa-pinterest"></i> 
			                            Social Information
			                          </a>
			                        </h4>
			                      </div>
			                      <div id="socialBlock" class="panel-collapse collapse">
			                        <div class="box-body">
		                        		'.$sociallinksection.'
									</div>
			                      </div>
			                    </div>
			            	</div>
							<div class="col-md-12">
		            			<div class="box-footer">
				                    <input type="submit" class="btn btn-danger" name="updateuseradmin" value="Update Data"/>
				                    <div class="col-sm-3 ajax-msg-holder pull-right">
				                    	<img src="<?php echo $host_addr;?>images/loading.gif" class="loadermini hidden"/>
				                    	<div class="ajax-msg-box hidden">
				                    		<!-- Checking email data -->
				                    	</div>
				                    </div>
				                </div>
			            	</div>
						</form>
					</div>
					'.$selectionscripts.'
			';
			$row['adminoutputappuser']='
				<tr data-id="'.$id.'">
					<td class="tddisplayimg">'.$face.'</td><td>'.$fullname.'</td><td>'.$email.'</td><td>'.$regdate.'</td><td>'.$status.'</td>
					<td name="trcontrolpoint">
						<a href="#&id='.$id.'" name="edit" data-type="editsingleappuseradmin" data-divid="'.$id.'">Edit</a>
					</td>
				</tr>
				<tr name="tableeditcontainer" data-state="inactive" data-divid="'.$id.'">
					<td colspan="100%">
						<div id="completeresultdisplay" data-type="editmodal" data-load="unloaded" data-divid="'.$id.'">
							<div id="completeresultdisplaycontent" data-type="editdisplay" data-divid="'.$id.'">
								
							</div>
						</div>
					</td>
				</tr>
			';
			$row['adminoutputtwoappuser']='
				<form name="editappuserform" action="'.$host_addr.'snippets/edit.php" method="POST" enctype="multipart/form-data">
	        		<input name="entryvariant" type="hidden" value="editappuser"/>
	        		<input name="entryid" type="hidden" value="'.$id.'"/>
	        		<input name="entrypoint" type="hidden" value="webapp"/>
	        		<div class="box-group" id="contentaccordion">
	        			<div class="panel box box-primary">
	                      <div class="box-header with-border">
	                        <h4 class="box-title">
	                          <a data-toggle="collapse" data-parent="#contentaccordion" href="#headBlock">
	                            <i class="fa fa-"></i>  Edit '.$fullname.' App user account
	                          </a>
	                        </h4>
	                      </div>
	                      <div id="headBlock" class="panel-collapse collapse in">
		                        <div class="box-body">
				                    <div class="col-md-4">
			                        	<div class="form-group">
					                      <label>First Name</label>
					                      <div class="input-group">
						                      <div class="input-group-addon">
						                        <i class="fa fa-file-text"></i>
						                      </div>
					                      	  <input type="text" class="form-control" name="firstname" placeholder="First Name" value="'.$firstname.'"/>
					                      </div>
					                    </div>
					                </div>
					                <div class="col-md-4">
			                        	<div class="form-group">
					                      <label>Middle Name</label>
					                      <div class="input-group">
						                      <div class="input-group-addon">
						                        <i class="fa fa-file-text"></i>
						                      </div>
					                      	  <input type="text" class="form-control" name="middlename" placeholder="Middle Name" value="'.$middlename.'"/>
					                      </div>
					                    </div>
					                </div><div class="col-md-4">
			                        	<div class="form-group">
					                      <label>Last Name</label>
					                      <div class="input-group">
						                      <div class="input-group-addon">
						                        <i class="fa fa-file-text"></i>
						                      </div>
					                      	  <input type="text" class="form-control" name="lastname" placeholder="Last Name" value="'.$lastname.'"/>
					                      </div>
					                    </div>
					                </div>
					                <div class="col-md-6">
			                        	<div class="form-group">
					                      <label>Email Address</label>
					                      <div class="input-group">
						                      <div class="input-group-addon">
						                        <i class="fa fa-at"></i>
						                      </div>
					                      	  <input type="email" class="form-control" name="email" placeholder="User email address" value="'.$email.'"/>
					                      </div>
					                    </div>
					                </div>
					                <div class="col-md-6">
			                        	<div class="form-group">
					                      <label>Password(<b>'.$password.'</b>)</label>
					                      <div class="input-group">
						                      <div class="input-group-addon">
						                        <i class="fa fa-lock"></i>
						                      </div>
					                      	  <input type="password" class="form-control" name="pword" placeholder="The user Password here" value="'.$password.'"/>
					                      </div>
					                    </div>
					                </div>
					                <div class="col-xs-12">
					                    	<label>Status</label>
					                    	<select id="status" name="status" class="form-control">
			                            		<option value="">Change Status</option>
			                            		<option value="active">Active</option>
			                            		<option value="inactive">Inactive</option>
			                            	</select>
					                    </div>
			                        <div class="col-md-12">
					        			<div class="box-footer">
	        								<input name="prevpassword" type="hidden" value="'.$password.'"/>
						                    <input type="submit" class="btn btn-danger" name="editappuser" value="Update"/>
						                </div>
					            	</div>
		                        </div>
	                      </div>
	                    </div>
	        		</div>
	        		
			    </form>
			';
		}
		
		return $row;
	}
	
	function getAllUsers($viewer,$limit,$user=''){
		global $host_addr;
		$row=array();
		$testit=strpos($limit,"-");
		$testit!==false?$limit="":$limit=$limit;
		$outputtype="user";
		$user==""?$user="user":$user=$user;
		$user==""?$outputtype="user":$outputtype=$user;

		$row=array();
		if($limit!==""&&$viewer=="admin"){
			$query="SELECT * FROM users WHERE usertype='$user' order by fullname,id,regdate desc ".$limit."";
			$rowmonitor['chiefquery']="SELECT * FROM users WHERE usertype='$user' order by fullname,id,regdate desc";
		}else if($limit==""&&$viewer=="admin"){
			$query="SELECT * FROM users WHERE usertype='$user' order by fullname,id,regdate desc LIMIT 0,15";		
			$rowmonitor['chiefquery']="SELECT * FROM users WHERE usertype='$user' order by fullname,id,regdate desc";
		}elseif($limit!==""&&$viewer=="viewer"){
			$query="SELECT * FROM users WHERE usertype='$user' AND status='active' ";
			$rowmonitor['chiefquery']="SELECT * FROM users WHERE usertype='$user' order by fullname,id desc";
		}else if($limit==""&&$viewer=="viewer"){
			$query="SELECT * FROM users WHERE usertype='$user' AND status='active'";		
			$rowmonitor['chiefquery']="SELECT * FROM users WHERE usertype='$user' AND status='active'";
		}else if($viewer=="inactiveviewer"){
			$query="SELECT * FROM users WHERE usertype='$user' AND status='inactive'";		
			$rowmonitor['chiefquery']="SELECT * FROM users WHERE usertype='$user' AND status='inactive'";
		}else if(is_array($viewer)){
			$subtype=$viewer[0];
			$searchval=$viewer[1];
			$viewer=$viewer[2];
 		  	$outputtype="usersearch|$subtype|$searchval|$viewer";
			if($subtype=="username"&&$viewer=="admin"){
				$query="SELECT * FROM users WHERE (fullname LIKE '%$searchval%' AND usertype='$user' AND status='active') OR (fullname LIKE '%$searchval%' AND usertype='$user' AND status='inactive') $limit";
		    	$rowmonitor['chiefquery']="SELECT * FROM users WHERE (fullname LIKE '%$searchval%' AND usertype='$user' AND status='active') OR (fullname LIKE '%$searchval%' AND usertype='$user' AND status='inactive')";
			}elseif($subtype=="userstatus"&&$viewer=="admin"){
				$query="SELECT * FROM users WHERE status ='$searchval' AND usertype='$user' $limit";
		    	$rowmonitor['chiefquery']="SELECT * FROM users WHERE status ='$searchval' AND usertype='$user'";
			}elseif($subtype=="useremail"&&$viewer=="admin"){
				$query="SELECT * FROM users WHERE email ='$searchval' AND usertype='$user' $limit";
		    	$rowmonitor['chiefquery']="SELECT * FROM users WHERE email ='$searchval' AND usertype='$user'";
			}elseif($subtype=="advancedusersearch"&&$viewer=="admin"){
				$query= $searchval." ".$limit;
		    	$rowmonitor['chiefquery']=$searchval;
			}else{
				echo "search parameters unrecognized, contact your developer";
			}
		}
		// echo $query;
		$selection="";
		$run=mysql_query($query)or die(mysql_error()." Line 77");
		$numrows=mysql_num_rows($run);
		$top='<table id="resultcontenttable" cellspacing="0">
					<thead><tr><th>Photo</th><th>FullName</th><th>Content Category</th><th>State</th><th>LGA</th><th>PhoneNumbers</th><th>Gender</th><th>Reg Date</th><th>Status</th><th>View/Edit</th></tr></thead>
					<tbody>';
		$toptwo='<table id="resultcontenttable" cellspacing="0">
					<thead><tr><th>Photo</th><th>FullName</th><th>Email</th><th>Reg Date</th><th>Status</th><th>View/Edit</th></tr></thead>
					<tbody>';
		$bottom='	</tbody>
				</table>';
		$adminoutput="";
		$adminoutputappuser="";
		$monitorpoint="";
		if($numrows>0){
			while($row=mysql_fetch_assoc($run)){
				$outvar=getSingleUser($row['id']);
				$adminoutput.=$outvar['adminoutput'];
				$adminoutputappuser.=$outvar['adminoutputappuser'];
				$selection.='<option value="'.$outvar['id'].'">'.$outvar['fullname'].'</option>';

			}
		}
		$outs=paginatejavascript($rowmonitor['chiefquery']);
		$paginatetop='
		<div id="paginationhold">
			<div class="meneame">
				<input type="hidden" name="curquery" value="'.$rowmonitor['chiefquery'].'"/>
				<input type="hidden" name="outputtype" value="'.$outputtype.'"/>
				<input type="hidden" name="currentview" data-ipp="15" data-page="1" value="1"/>
				<div class="pagination" data-name="paginationpageshold">'.$outs['pageout'].'</div>
				<div class="pagination">
					  '.$outs['usercontrols'].'
				</div>
			</div>
		</div>
		<div id="paginateddatahold" data-name="contentholder">';
		$paginatebottom='
		</div><div id="paginationhold">
			<div class="meneame">
				<div class="pagination" data-name="paginationpageshold">'.$outs['pageout'].'</div>
			</div>
		</div>';
		$row['adminoutput']=$paginatetop.$top.$adminoutput.$bottom.$paginatebottom;
		$row['adminoutputtwo']=$top.$adminoutput.$bottom;
		$row['adminoutputappuser']=$paginatetop.$toptwo.$adminoutputappuser.$bottom.$paginatebottom;
		$row['adminoutputtwoappuser']=$toptwo.$adminoutputappuser.$bottom;
		$row['selection']=$selection;
		$uarun=mysql_query($rowmonitor['chiefquery']);
		$numrowsactive=mysql_num_rows($uarun);
		$row['numrowsactive']=$numrowsactive;
		return $row;
	}


	function getUserGroup($viewer,$limit){
		$row=array();
		str_replace("-", "", $limit);

		$testit=strpos($limit,"-");

		$testit?$limit="":$limit=$limit;
		$testittwo=strpos($limit,",");
		if($testittwo===0||$testittwo===true||$testittwo>0){
			$limit=$limit;
		}else{
			if(strtolower($limit)=="all"){
				$limit="";
			}else{
				$limit="LIMIT 0,15";				
			}
		}
		if($viewer=="admin"){
			$query="SELECT * FROM users WHERE usertype='user' order by fullname,id desc ".$limit."";
			$rowmonitor['chiefquery']="SELECT * FROM users WHERE usertype='user' order by fullname,id desc";
		}elseif($viewer=="viewer"){
			$query="SELECT * FROM users WHERE usertype='user' AND status='active' $limit";
			$rowmonitor['chiefquery']="SELECT * FROM users WHERE usertype='user' AND status='active' order by fullname,id desc";
		}else if($viewer=="inactiveviewer"){
			$query="SELECT * FROM users WHERE usertype='user' AND status='inactive'";		
			$rowmonitor['chiefquery']="SELECT * FROM users WHERE usertype='user' AND status='inactive'order by fullname,id desc";
		}else if(is_array($viewer)){
			$prevval=$viewer;
			$subtype=$viewer[0];
			$searchval=mysql_real_escape_string($viewer[1]);
			$viewer=$viewer[2];
 		  	$outputtype="usersearch|$subtype|$searchval|$viewer";
			if($subtype=="username"&&$viewer=="admin"){
				$query="SELECT * FROM users WHERE (fullname LIKE '%$searchval%' AND usertype='user' AND status='active') OR (fullname LIKE '%$searchval%' AND usertype='user' AND status='inactive')  AND usertype='user' ORDER BY firstname,middlename,lastname,id $limit";
		    	$rowmonitor['chiefquery']="SELECT * FROM users WHERE (fullname LIKE '%$searchval%' AND usertype='user' AND status='active') OR (fullname LIKE '%$searchval%' AND usertype='user' AND status='inactive') AND usertype='user' ORDER BY fullname, id";
			}else if($subtype=="usercategorysearch"&&$viewer=="admin"){
				$catid=$prevval[3];
				$query="SELECT * FROM users WHERE catid ='$catid' AND usertype='user' AND fullname LIKE '%$searchval%' ORDER BY fullname,id $limit";
		    	$rowmonitor['chiefquery']="SELECT * FROM users WHERE catid ='$catid' AND usertype='user' AND fullname LIKE '%$searchval%' ORDER BY fullname,id";
			}elseif($subtype=="userstatus"&&$viewer=="admin"){
				$query="SELECT * FROM users WHERE status ='$searchval' AND usertype='user' $limit";
		    	$rowmonitor['chiefquery']="SELECT * FROM users WHERE status ='$searchval' AND usertype='user'";
			}elseif($subtype=="advancedusersearch"&&$viewer=="admin"){
				$query= $searchval." ".$limit;
		    	$rowmonitor['chiefquery']=$searchval;
			}else if($subtype=="userslist"&&$viewer=="admin"){
				$query="SELECT * FROM users WHERE usertype='user' ORDER BY fullname $limit";
		    	$rowmonitor['chiefquery']="SELECT * FROM users WHERE catid ='$searchval' AND usertype='user' ORDER BY fullname";
 		  		$outputtype="userslist|$subtype|$searchval|$viewer";
			}else if($subtype=="usercatlist"&&$viewer=="admin"){
				$catid=$prevval[3];
				$query="SELECT * FROM users WHERE catid =$catid AND usertype='user' ORDER BY fullname $limit";
		    	$rowmonitor['chiefquery']="SELECT * FROM users WHERE catid ='$catid' AND usertype='user' ORDER BY fullname";
 		  		$outputtype="usercatlist|$subtype|$searchval|$viewer";
			}else{
				echo "search parameters unrecognized, contact your developer";
			}
		}
		// echo $viewer."<br>";
		// echo $query;
		$selection='<option value="">Select a User</option>';
		$minisearch="";
		$run=mysql_query($query)or die(mysql_error()." Line ".__LINE__);
		$numrows=mysql_num_rows($run);
		// generate full user list
		if($numrows>0){
			$rowquery=mysql_query($rowmonitor['chiefquery']);
			while($fullrows=mysql_fetch_array($rowquery)){
				$selection.='<option value="'.$fullrows['id'].'">'.$fullrows['fullname'].'</option>';
				$minisearch.='<span class="username_display"><a href="##" data-id="'.$fullrows['id'].'">'.$fullrows['fullname'].'</a></span>';
			}
		}
		$row['selection']=$selection;
		$row['minisearch']=$minisearch;
		$row['numrows']=$numrows;
		return $row;
	}
?>