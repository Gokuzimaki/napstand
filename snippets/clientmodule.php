<?php
	function getSingleClient($id){
		global $host_addr;
		$row=array();
		$query="SELECT * FROM users where id=$id";
		$row=array();
		$run=mysql_query($query)or die(mysql_error()." Line 6");
		$numrows=mysql_num_rows($run);
		/*query2="SELECT * FROM surveys where userid=$typeid";
		$run2=mysql_query($query2)or die(mysql_error()." Line 899");
		$row2=mysql_fetch_assoc($run2);*/
		$row=mysql_fetch_assoc($run);
		$id=$row['id'];
		$catid=$row['catid'];
		$catdata=getSingleContentCategory($catid);
		$catname=$catdata['catname'];
		$name=$row['businessname'];
		$description=$row['businessdescription'];
		$businessaddress=$row['businessaddress'];
		$state=$row['state'];
		$lga=$row['lga'];
		$lgdata=getSingleLGA($lga);
		$localgovt=$lgdata['local_govt'];
		$password=$row['pword'];
		$email=$row['email'];
		$phonenumber=$row['phonenumber'];
		$phonearr=explode("[|><|]", $phonenumber);
		$phoneone=$phonearr[0];
		$phonetwo=$phonearr[1];
		$phonethree=$phonearr[2];
		$regdate=$row['regdate'];
		$status=$row['status'];
		// get biz logo and banner
		$bizlogoquery2="SELECT * FROM media where ownerid=$id AND ownertype='client' AND maintype='bizlogo'";
		$bizlogorun2=mysql_query($bizlogoquery2)or die(mysql_error()." Line 27");
		$bizlogorow2=mysql_fetch_assoc($bizlogorun2);
		$numrowbizlogo=mysql_num_rows($bizlogorun2);
		$row['bizlogoid']=$bizlogorow2['id'];
		$row['bizlogofile']=$bizlogorow2['location'];
		$bizlogoid=0;
		if($numrowbizlogo>0){
			$bizlogo='<img src="'.$host_addr.''.$bizlogorow2['location'].'">';
			// $row['bizlogofile']=$bizlogorow2['location'];
		$bizlogoid=$bizlogorow2['id'];

		}else{
			$bizlogo='<p style="text-align:center;"><i class="fa fa-suitcase fa-3x"></i></p>';
			$row['bizlogofile']=''.$host_addr.'images/default.png';
		}
		$row['bizlogoout']=$bizlogo;
		$bannerlogoquery2="SELECT * FROM media where ownerid=$id AND ownertype='client' AND maintype='bannerlogo'";
		$bannerlogorun2=mysql_query($bannerlogoquery2)or die(mysql_error()." Line 27");
		$bannerlogorow2=mysql_fetch_assoc($bannerlogorun2);
		$numrowbannerlogo=mysql_num_rows($bannerlogorun2);
		$row['bannerlogoid']=$bannerlogorow2['id'];
		$row['bannerlogofile']=$bannerlogorow2['location'];
		$bannerlogoid=0;
		if($numrowbannerlogo>0){
			$bannerlogo='<div style="text-align:left; overflow:hidden; min-height:150px"><img src="'.$host_addr.''.$bannerlogorow2['location'].'" style="height:320px;"/></div>';
			$bannerlogoid=$bannerlogorow2['id'];
		}else{
			$bannerlogo='<p>No banner provided</p>';
		}
		$row['adminoutput']='
			<tr data-id="'.$id.'">
				<td class="tddisplayimg">'.$bizlogo.'</td><td>'.$name.'</td><td>'.$catname.'</td><td>'.$state.'</td><td>'.$localgovt.'</td><td>'.$phoneone.' '.$phonetwo.' '.$phonethree.'</td><td>'.$regdate.'</td><td>'.$status.'</td><td name="trcontrolpoint"><a href="#&id='.$id.'" name="edit" data-type="editsingleclient" data-divid="'.$id.'">Edit</a></td>
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
					<form action="../snippets/edit.php" name="editclient" method="post" enctype="multipart/form-data">
						<input type="hidden" name="entryvariant" value="editclient"/>
						<input type="hidden" name="entryid" value="'.$id.'"/>
						<div id="formheader">Edit "'.$name.'"</div>
						<div class="box-group" id="surveyaccordion">
	            			<div class="panel box box-primary">
		                      <div class="box-header with-border">
		                        <h4 class="box-title">
		                          <a data-toggle="collapse" data-parent="#surveyaccordion" href="#BusinessBlock">
		                            <i class="fa fa-user"></i>  Client Information
		                          </a>
		                        </h4>
		                      </div>
		                      <div id="BusinessBlock" class="panel-collapse collapse in">
		                        <div class="box-body">
		                        	<div class="form-group">
				                      <label>Business Name</label>
				                      <input type="text" class="form-control" name="businessname" value="'.$name.'" placeholder="Enter business name"/>
				                    </div>
				                    <div class="form-group">
				                      <label for="businesslogo">Business Logo</label>
				                      <input type="hidden" name="bizlogoid" value="'.$bizlogoid.'"/>
				                      <input type="file" name="bizlogo" id="businesslogo"/>
				                      <p class="help-block">Choose the  business logo if available</p>
				                    </div>
				                    <div class="form-group">
				                      <label for="businessbanner">Business Banner</label>
				                      '.$bannerlogo.'
				                      <input type="hidden" name="bannerlogoid" value="'.$bannerlogoid.'"/>
				                      <input type="file" name="bannerlogo" id="businessbanner">
				                      <p class="help-block">Choose the  business Banner image in the event of adverts, if available</p>
				                    </div>
		                        	<div class="form-group">
					                  <label>Business Description</label>
					                  <textarea class="form-control" rows="3" name="businessdescription" placeholder="Give a brief explanation about the business">'.$description.'</textarea>
					                </div>
		                        </div>
		                      </div>
		                    </div>
		                    <div class="panel box box-info">
		                      <div class="box-header with-border">
		                        <h4 class="box-title">
		                          <a data-toggle="collapse" data-parent="#surveyaccordion" href="#ClientLocationBlock">
		                            <i class="fa fa-map-marker"></i> Location Information
		                          </a>
		                        </h4>
		                      </div>
		                      <div id="ClientLocationBlock" class="panel-collapse collapse">
		                        <div class="box-body">
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
	                            		<option value="">Select Your Local Government</option>
	                            	  </select>
				                    </div>
		                        	<div class="form-group">
					                  <label>Business Address</label>
					                  <textarea class="form-control" rows="3" name="businessaddress" placeholder="Provide the business address">'.$businessaddress.'</textarea>
					                </div>
		                        </div>
		                      </div>
		                    </div>
		                    <div class="panel box box-primary">
		                      <div class="box-header with-border">
		                        <h4 class="box-title">
		                          <a data-toggle="collapse" data-parent="#surveyaccordion" href="#clientcontactBlock">
		                            <i class="fa fa-telephone"></i><i class="fa fa-envelope"></i> Contact Information
		                          </a>
		                        </h4>
		                      </div>
		                      <div id="clientcontactBlock" class="panel-collapse collapse">
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
		                          <a data-toggle="collapse" data-parent="#surveyaccordion" href="#clientaccessBlock">
		                            <i class="fa fa-key"></i><i class="fa fa-lock"></i> Login Information
		                          </a>
		                        </h4>
		                      </div>
		                      <div id="clientaccessBlock" class="panel-collapse collapse">
		                        <div class="box-body">
		                        	<div class="form-group">
			            				<div class="col-xs-12">
						                    <div class="col-xs-4">
		                      				  <div class="form-group">
							                    <label>Password:</label>
							                    <div class="input-group">
							                      <div class="input-group-addon">
							                        <i class="fa fa-key"></i>
							                      </div>
							                      <input type="text" class="form-control" name="password" value="'.$password.'"/>
							                    </div><!-- /.input group -->
							                  </div><!-- /.form group -->
						                    </div>
						                </div>
						                 <div class="col-xs-12">
					                    	<label>Status</label>
					                    	<select id="status" name="status" class="form-control">
			                            		<option value="active">Active</option>
			                            		<option value="inactive">Inactive</option>
			                            	</select>
					                    </div>
						            </div>
		                        </div>
		                      </div>
		                    </div>
		            	</div>
						<div class="col-md-12">
		        			<div class="box-footer">
			                    <input type="subtmit" class="btn btn-danger" name="Update" value="Submit"/>
			                </div>
		            	</div>
					</form>
				</div>
				<script>
 					$(document).ready(function(){
        				$("[data-mask]").inputmask();

 					})
 				</script>
		';
		return $row;
	}
	function getAllClients($viewer,$limit){
		global $host_addr;
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
		$outputtype="clients";
		$row=array();
		if($limit!==""&&$viewer=="admin"){
			$query="SELECT * FROM users WHERE usertype='client' order by businessname,id desc ".$limit."";
			$rowmonitor['chiefquery']="SELECT * FROM users WHERE usertype='client' order by businessname,id desc";
		}else if($limit==""&&$viewer=="admin"){
			$query="SELECT * FROM users WHERE usertype='client' order by businessname,id desc LIMIT 0,15";		
			$rowmonitor['chiefquery']="SELECT * FROM users WHERE usertype='client' order by businessname,id desc";
		}elseif($limit!==""&&$viewer=="viewer"){
			$query="SELECT * FROM users WHERE usertype='client' AND status='active' ";
			$rowmonitor['chiefquery']="SELECT * FROM users WHERE usertype='client' AND status='active' order by businessname,id desc";
		}else if($limit==""&&$viewer=="viewer"){
			$query="SELECT * FROM users WHERE usertype='client' AND status='active'";		
			$rowmonitor['chiefquery']="SELECT * FROM users WHERE usertype='client' AND status='active' order by businessname,id desc";
		}else if($viewer=="inactiveviewer"){
			$query="SELECT * FROM users WHERE usertype='client' AND status='inactive'";		
			$rowmonitor['chiefquery']="SELECT * FROM users WHERE usertype='client' AND status='inactive'order by businessname,id desc";
		}else if(is_array($viewer)){
			$subtype=$viewer[0];
			$searchval=$viewer[1];
			$viewer=$viewer[2];
 		  	$outputtype="clientsearch|$subtype|$searchval|$viewer";
			if($subtype=="clientname"&&$viewer=="admin"){
				$query="SELECT * FROM users WHERE (fullname LIKE '%$searchval%' AND usertype='client' AND status='active') OR (fullname LIKE '%$searchval%' AND usertype='client' AND status='inactive')  AND usertype='client' $limit";
		    	$rowmonitor['chiefquery']="SELECT * FROM users WHERE (fullname LIKE '%$searchval%' AND usertype='client' AND status='active') OR (fullname LIKE '%$searchval%' AND usertype='client' AND status='inactive') AND usertype='client'";
			}elseif($subtype=="clientstatus"&&$viewer=="admin"){
				$query="SELECT * FROM users WHERE status ='$searchval' AND usertype='client' $limit";
		    	$rowmonitor['chiefquery']="SELECT * FROM users WHERE status ='$searchval' AND usertype='client'";
			}elseif($subtype=="advancedusersearch"&&$viewer=="admin"){
				$query= $searchval." ".$limit;
		    	$rowmonitor['chiefquery']=$searchval;
			}else if($subtype=="clientlist"&&$viewer=="admin"){

				$query="SELECT * FROM users WHERE catid ='$searchval' AND usertype='client' $limit";
		    	$rowmonitor['chiefquery']="SELECT * FROM users WHERE catid ='$searchval' AND usertype='client' $limit";
 		  		$outputtype="clientlist|$subtype|$searchval|$viewer";
			}else{
				echo "search parameters unrecognized, contact your developer";
			}
		}
			// echo $query;
		$selection="";
		$run=mysql_query($query)or die(mysql_error()." Line 77");
		$numrows=mysql_num_rows($run);
		$top='<table id="resultcontenttable" cellspacing="0">
					<thead><tr><th>Logo</th><th>Name</th><th>Content Category</th><th>State</th><th>LGA</th><th>PhoneNumbers</th><th>Reg Date</th><th>Status</th><th>View/Edit</th></tr></thead>
					<tbody>';
		$bottom='	</tbody>
				</table>';
		$adminoutput="";
		$monitorpoint="";
		if($numrows>0){
			while($row=mysql_fetch_assoc($run)){
				$outvar=getSingleClient($row['id']);
				$adminoutput.=$outvar['adminoutput'];
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
		$row['selection']=$selection;
		$row['numrows']=$numrows;
		return $row;
	}
	function getClientGroup($viewer,$limit){
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
		if($limit!==""&&$viewer=="admin"){
			$query="SELECT * FROM users WHERE usertype='client' order by businessname,id desc ".$limit."";
			$rowmonitor['chiefquery']="SELECT * FROM users WHERE usertype='client' order by businessname,id desc";
		}else if($limit==""&&$viewer=="admin"){
			$query="SELECT * FROM users WHERE usertype='client' order by businessname,id desc LIMIT 0,15";		
			$rowmonitor['chiefquery']="SELECT * FROM users WHERE usertype='client' order by businessname,id desc";
		}elseif($limit!==""&&$viewer=="viewer"){
			$query="SELECT * FROM users WHERE usertype='client' AND status='active' ";
			$rowmonitor['chiefquery']="SELECT * FROM users WHERE usertype='client' AND status='active' order by businessname,id desc";
		}else if($limit==""&&$viewer=="viewer"){
			$query="SELECT * FROM users WHERE usertype='client' AND status='active'";		
			$rowmonitor['chiefquery']="SELECT * FROM users WHERE usertype='client' AND status='active' order by businessname,id desc";
		}else if($viewer=="inactiveviewer"){
			$query="SELECT * FROM users WHERE usertype='client' AND status='inactive'";		
			$rowmonitor['chiefquery']="SELECT * FROM users WHERE usertype='client' AND status='inactive'order by businessname,id desc";
		}else if(is_array($viewer)){
			$prevval=$viewer;
			$subtype=$viewer[0];
			$searchval=$viewer[1];
			$viewer=$viewer[2];
 		  	$outputtype="clientsearch|$subtype|$searchval|$viewer";
			if($subtype=="clientname"&&$viewer=="admin"){
				$query="SELECT * FROM users WHERE (businessname LIKE '%$searchval%' AND usertype='client' AND status='active') OR (businessname LIKE '%$searchval%' AND usertype='client' AND status='inactive')  AND usertype='client' ORDER BY businessname,id $limit";
		    	$rowmonitor['chiefquery']="SELECT * FROM users WHERE (businessname LIKE '%$searchval%' AND usertype='client' AND status='active') OR (businessname LIKE '%$searchval%' AND usertype='client' AND status='inactive') AND usertype='client' ORDER BY businessname,id";
			}else if($subtype=="clientcategorysearch"&&$viewer=="admin"){
				$catid=$prevval[3];
				$query="SELECT * FROM users WHERE catid ='$catid' AND usertype='client' AND businessname LIKE '%$searchval%' ORDER BY businessname,id $limit";
		    	$rowmonitor['chiefquery']="SELECT * FROM users WHERE catid ='$catid' AND usertype='client' AND businessname LIKE '%$searchval%' ORDER BY businessname,id";
			}elseif($subtype=="clientstatus"&&$viewer=="admin"){
				$query="SELECT * FROM users WHERE status ='$searchval' AND usertype='client' $limit";
		    	$rowmonitor['chiefquery']="SELECT * FROM users WHERE status ='$searchval' AND usertype='client'";
			}elseif($subtype=="advancedusersearch"&&$viewer=="admin"){
				$query= $searchval." ".$limit;
		    	$rowmonitor['chiefquery']=$searchval;
			}else if($subtype=="clientlist"&&$viewer=="admin"){
				$query="SELECT * FROM users WHERE usertype='client' AND businessname LIKE '%$searchval%' $limit";
		    	$rowmonitor['chiefquery']="SELECT * FROM users WHERE catid ='$catid' AND usertype='client' $limit";
 		  		$outputtype="clientlist|$subtype|$searchval|$viewer|$catid";
			}else if($subtype=="clientcatlist"&&$viewer=="admin"){
				$catid=$prevval[3];
				$query="SELECT * FROM users WHERE catid ='$catid' AND usertype='client' ORDER BY businessname $limit";
		    	$rowmonitor['chiefquery']="SELECT * FROM users WHERE catid ='$catid' AND usertype='client' $limit";
 		  		$outputtype="clientcatlist|$subtype|$searchval|$viewer|$catid";
			}else{
				echo "search parameters unrecognized, contact your developer";
			}
		}
		// echo $query;
		$selection='<option value="">Select a Client</option>';
		$minisearch="";
		$run=mysql_query($query)or die(mysql_error()." Line ".__LINE__);
		$numrows=mysql_num_rows($run);
		// generate full client list
		if($numrows>0){
			$rowquery=mysql_query($rowmonitor['chiefquery']);
			while($fullrows=mysql_fetch_array($rowquery)){
				$selection.='<option value="'.$fullrows['id'].'">'.$fullrows['businessname'].'</option>';
				$minisearch.='<span class="username_display"><a href="##" data-id="'.$fullrows['id'].'">'.$fullrows['businessname'].'</a></span>';
			}

		}
		$row['selection']=$selection;
		$row['minisearch']=$minisearch;
		$row['numrows']=$numrows;
		return $row;
	}
?>