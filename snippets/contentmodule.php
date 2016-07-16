<?php
	// This module handles content on napstand
	// it has the function for data retrieval and operations concerning content
	
	function getSingleContentCategory($id){
		include('globalsmodule.php');
		$row=array();

		$query="SELECT * FROM contentcategories where id=$id";
		$run=mysql_query($query)or die(mysql_error()." Line 6 ".__LINE__);
		$numrows=mysql_num_rows($run);
		
		$row=mysql_fetch_assoc($run);
		
		$catname=$row['catname'];
		$description=$row['description'];
		$status=$row['status'];


		// get the cover image content for the category
		//set variable for holding the path to the coverimage for the survey;
		$coverpicprev=$host_addr."images/napstanddcover600x600.png";
		$coverpicmedsize=$host_addr."images/napstanddcover400x400.png";
		$coverpicthumb=$host_addr."images/napstanddcover50x50.png";

		// the image id for carrying out updates on its entry in the database
		$imgid=0;

		$mediaquery="SELECT * FROM media WHERE ownertype='contentcategory' AND ownerid='$id' AND maintype='coverphoto'";
		$mediarun=mysql_query($mediaquery);
		$medianumrows=mysql_num_rows($mediarun);
		if($medianumrows>0){
			$mediarow=mysql_fetch_assoc($mediarun);
			$imgid=$mediarow['id'];
			$coverpicprev=$host_addr.$mediarow['location'];
			$coverpicmedsize=$host_addr.$mediarow['medsize'];
			$coverpicthumb=$host_addr.$mediarow['thumbnail'];
		}
		$row['largecover']=$coverpicprev;
		$row['mediumcover']=$coverpicmedsize;
		$row['thumbcover']=$coverpicthumb;
		$row['selectionoutput']='<option value="'.$row['id'].'">'.$row['catname'].'</option>';
		$row['adminoutput']='
			<tr data-id="'.$id.'">
				<td class="tdimg"><img src="'.$coverpicmedsize.'"/></td><td>'.$catname.'</td><td>'.$status.'</td><td name="trcontrolpoint"><a href="#&id='.$id.'" name="edit" data-type="editsinglecontentcategory" data-divid="'.$id.'">Edit</a></td>
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
			<form name="contentcategoryform" action="../snippets/edit.php" method="POST" enctype="multipart/form-data">
        		<input name="entryvariant" type="hidden" value="editcontentcategory"/>
        		<input name="entryid" type="hidden" value="'.$id.'"/>
        		<div class="box-group" id="contentaccordion">
        			<div class="panel box box-primary">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a data-toggle="collapse" data-parent="#contentaccordion" href="#headBlock">
                            <i class="fa fa-"></i>  Edit '.$catname.'
                          </a>
                        </h4>
                      </div>
                      <div id="headBlock" class="panel-collapse collapse">
	                        <div class="box-body">
	                        	<div class="form-group">
			                      <label>Category Name</label>
			                      <div class="input-group">
				                      <div class="input-group-addon">
				                        <i class="fa fa-file-text"></i>
				                      </div>
			                      	  <input type="text" class="form-control" name="catname" value="'.$catname.'" placeholder="Enter category name"/>
			                      </div>
			                    </div>
			                    <div class="form-group">
			                      <label for="businesslogo">Brief Description</label>
			                      <div class="input-group">
				                      <div class="input-group-addon">
				                        <i class="fa fa-file-text-o"></i>
				                      </div>
				                      <textarea name="description" rows="3" class="form-control" placeholder="A brief description of what this category entails or has to offer">'.$description.'</textarea>
				                  </div>
			                    </div>
			                    <div class="form-group">
			                      <label for="businessbanner">Cover Image</label>
			                      <div class="input-group">
				                      <div class="input-group-addon">
				                        <i class="fa fa-file-image-o"></i>
				                      </div>
				                      <input type="file" name="profpic" class="form-control">
				                      <input type="hidden" name="imgid"  value="'.$imgid.'" class="form-control">

				                  </div>
			                      <p class="help-block">Choose the cover image for this category</p>
			                    </div>
			                    <div class="form-group">
			                      <label>Status</label>
			                      <div class="input-group">
				                      <div class="input-group-addon">
				                        <i class="fa fa-minus-o"></i>
				                      </div>
			                      	  <select class="form-control" name="status">
			                      	  	<option value="">Change Status</option>
			                      	  	<option value="active">Active</option>
			                      	  	<option value="inactive">Inactive</option>
			                      	  </select>
			                      </div>
			                    </div>
		                        <div class="col-md-12">
				        			<div class="box-footer">
					                    <input type="submit" class="btn btn-danger" name="createcontentcategory" value="Create Category"/>
					                </div>
				            	</div>
	                        </div>
                      </div>
                    </div>
        		</div>
        		
		    </form>
		';
		return $row;
	}

	function getAllContentCategory($viewer,$limit){
		global $host_addr;

		$row=array();

		$outputtype="contentcategory";

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


		$today=date("Y-m-d");

		$timenow=date("H:i:s");

		if($viewer=="admin"){
			$query="SELECT * FROM contentcategories $limit";
			$rowmonitor['chiefquery']="SELECT * FROM contentcategories";
		}else if ($viewer=="viewer") {
			# code...
			$query="SELECT * FROM contentcategories WHERE status='active' $limit";
			$rowmonitor['chiefquery']="SELECT * FROM contentcategories WHERE status='active'";
		}else if(is_array($viewer)){
				$subtype=$viewer[0];
				$searchval=$viewer[1];
				$viewer=$viewer[2];
	 		  	$outputtype="surveysearch|$subtype|$searchval|$viewer";
				if($subtype=="surveytitle"&&$viewer=="admin"){
					$query="SELECT * FROM survey WHERE (title LIKE '%$searchval%' AND status='active') OR (title LIKE '%$searchval%' AND status='inactive') $limit";
			    	$rowmonitor['chiefquery']="SELECT * FROM survey WHERE (title LIKE '%$searchval%' AND status='active') OR (title LIKE '%$searchval%' AND status='inactive')";
				}elseif($subtype=="surveystatus"&&$viewer=="admin"){
					$query="SELECT * FROM survey WHERE status ='$searchval' $limit";
			    	$rowmonitor['chiefquery']="SELECT * FROM survey WHERE status ='$searchval'";
				}elseif($subtype=="clientnamesurvey"&&$viewer=="admin"){
					$query="SELECT * FROM survey WHERE EXISTS(SELECT * FROM users WHERE usertype='client' AND businessname LIKE '%$searchval%' AND id=`survey`.`clientid`) $limit";
			    	$rowmonitor['chiefquery']="SELECT * FROM survey WHERE EXISTS(SELECT * FROM users WHERE usertype='client' AND businessname LIKE '%$searchval%' AND id=`survey`.`clientid`)";
				}elseif($subtype=="advancedusersearch"&&$viewer=="admin"){
					$query= $searchval." ".$limit;
			    	$rowmonitor['chiefquery']=$searchval;
				}else{
					echo "search parameters unrecognized, contact your developer";
				}
		}
		$run=mysql_query($query)or die(mysql_error()." Real number:".__LINE__." old number  1041");
		$numrows=mysql_num_rows($run);
		// echo $query."<br>";
		$adminoutput='<td colspan="100%">No entries yet</td>';
		$adminoutputtwo='No entries yet';
		$adminoutputthree='No entries yet';
		$vieweroutput="";
		$selectionoutput="";
		$catdata=array();
		if($numrows>0){
			$adminoutput="";
			$adminoutputthree="";
			while ($row=mysql_fetch_assoc($run)) {
				# code...
				$contentcategorydata=getSingleContentCategory($row['id']);
				$adminoutput.=$contentcategorydata['adminoutput'];
				$selectionoutput.=$contentcategorydata['selectionoutput'];
				$catdata[]=array(
							"id"=>$row['id'],
							"title"=>$row['catname'],
							"description"=>$row['description'],
							"largecover"=>$contentcategorydata['largecover'],
							"mediumcover"=>$contentcategorydata['mediumcover'],
							"thumbcover"=>$contentcategorydata['thumbcover']
							);
			}
		}

		$row['rowmonitor']=$rowmonitor['chiefquery'];
		$outs=paginatejavascript($rowmonitor['chiefquery']);
		$row['num_pages']=$outs['num_pages'];		
		$row['numrows']=$numrows;		
		$top='<table id="resultcontenttable" cellspacing="0">
					<thead><tr><th>CoverImg</th><th>Title</th><th>Status</th><th>View/Edit</th></tr></thead>
					<tbody>';
		$bottom='	</tbody>
				</table>';
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
			<div id="paginateddatahold" data-name="contentholder">
		';

		$paginatebottom='
			</div><div id="paginationhold">
				<div class="meneame">
					<div class="pagination" data-name="paginationpageshold">'.$outs['pageout'].'</div>
				</div>
			</div>
		';
		// for admin
		$row['adminoutput']=$paginatetop.$top.$adminoutput.$bottom.$paginatebottom;
		$row['adminoutputtwo']=$top.$adminoutput.$bottom;
		$row['catdata']=$catdata;
		$row['selectionoutput']=$selectionoutput;
		return $row;
	}

	function getMurals($viewer,$limit){
		include('globalsmodule.php');
		$row=array();
		if($viewer=="admin"){
			$query="SELECT * FROM media WHERE maintype='muralimage' AND status='active'";
		}else if($viewer=="admin"){
			$query="SELECT * FROM media WHERE maintype='muralimage' AND status='active'";		
		}elseif($limit!==""&&$viewer=="viewer"){
			$query="SELECT * FROM media WHERE maintype='muralimage' AND status='active'";
			// $rowmonitor['chiefquery']="SELECT * FROM generalinfo $frameout AND status='active' $ordercontent";
		}
		$run=mysql_query($query)or die(mysql_error()." Line".__LINE__);
		$numrows=mysql_num_rows($run);
		$adminoutput='';
		$vieweroutput='';
		$catdata=array();
		if($numrows>0){
			$adminoutput='';
			while ($row=mysql_fetch_assoc($run)) {
				# code...
				$original=$row['location'];
				$medsize=$row['medsize'];
				$thumbnail=$row['thumbnail'];
				$filesize=$row['filesize'];
				$adminoutput.='
					<div class="single_image_hold" name="albumimg'.$row['id'].'">
        				<div class="img_placeholder">
        					<img src="'.$host_addr.''.$thumbnail.'"/>
        				</div>
            			<div id="editimgsoptionlinks" class="img_options">
            				<ul> 
            					<li>
            						<a href="'.$host_addr.''.$original.'" data-lightbox="muralgallery" data-src="'.$host_addr.''.$original.'" name="viewpic">
            							<i class="fa fa-eye"></i>
            						</a>
            					</li>
            					<li><a href="##delete" data-id="'.$row['id'].'" name="deletepic"><i class="fa fa-trash"></i></a></li>
            				</ul>
            			</div>
        			</div>
				';
				$catdata[]= array(
								'largecover' =>''.$host_addr.$original.'', 
								'mediumcover' =>''.$host_addr.$medsize.'', 
								'thumbcover' =>''.$host_addr.$thumbnail.'' 
							);

			}
		}else{
			$adminoutput='<div class="default_no_entries">Nothing posted yet</div>';
		}

		$row['adminoutput']=$adminoutput;
		$row['numrows']=$numrows;
		$row['vieweroutput']=$vieweroutput;
		$row['catdata']=$catdata;
		return $row;
	}

	function getSingleParentContent($id,$usereditid=""){
		include('globalsmodule.php');
		$row=array();

		$query="SELECT * FROM parentcontent where id=$id";
		$run=mysql_query($query)or die(mysql_error()." Line ".__LINE__);
		$numrows=mysql_num_rows($run);
		
		$row=mysql_fetch_assoc($run);
		
		$userid=$row['userid'];
		$name="Napstand Admin";
		$type="Napstand";
		$ownerimage="";
		$ownerbanner="";
		if($userid>0){
			$userdata=getSingleUserPlain($userid);
			$ownerimage= array(
							'largecover' => $userdata['originalimage'],
							'mediumcover' => $userdata['medimage'],
							'thumbcovercover' => $userdata['thumbimage']
						 );
			$ownerbanner= array(
							'bannerlargecover' => $userdata['banneroriginalimage'],
							'bannermediumcover' => $userdata['bannermedimage'],
							'bannerthumbcovercover' => $userdata['bannerthumbimage']
						 );
			$type=$userdata['usertype'];
			$type=="user"?$name=$userdata['fullname']:$name=$userdata['businessname'];
			
		}
		$contenttitle=$row['contenttitle'];
		$description=$row['contentdescription'];
		$catid=$row['contenttypeid'];
		$catout=getSingleContentCategory($catid);
		$row['catout']=$catout;
		$contenttype=$catout['catname'];
		$contentstatus=$row['contentstatus']; // for user control
		$status=$row['status']; // for admin control
		$selectscript='
			<script>
				$(document).ready(function(){
					$("select[name=contentstatus]").val("'.$contentstatus.'");
					$("select[name=status]").val("'.$status.'");
				})
			</script>';


		// get the cover image content for the category
		//set variable for holding the path to the coverimage for the category;
		$coverpicprev=$host_addr."images/napstanddcover600x600.png";
		$coverpicmedsize=$host_addr."images/napstanddcover400x400.png";
		$coverpicthumb=$host_addr."images/napstanddcover50x50.png";

		// the image id for carrying out updates on its entry in the database
		$imgid=0;

		$mediaquery="SELECT * FROM media WHERE ownertype='parentcontent' AND ownerid='$id' AND maintype='coverphoto'";
		$mediarun=mysql_query($mediaquery);
		$medianumrows=mysql_num_rows($mediarun);
		if($medianumrows>0){
			$mediarow=mysql_fetch_assoc($mediarun);
			$imgid=$mediarow['id'];
			$coverpicprev=$host_addr.$mediarow['location'];
			$coverpicmedsize=$host_addr.$mediarow['medsize'];
			$coverpicthumb=$host_addr.$mediarow['thumbnail'];
		}

		/*Get last update information*/
			$lastupdatequery="SELECT * FROM contententries WHERE parentid='$id' AND status='active' AND publishstatus='published'";
			$lastupdaterun=mysql_query($lastupdatequery)or die(mysql_error()." LINE ".__LINE__);
			$lastupdatenumrows=mysql_num_rows($lastupdaterun);
			$lastupdated="";
			$lastupdateid=0;
			if($lastupdatenumrows>0){
				$lastupdaterow=mysql_fetch_assoc($lastupdaterun);
				$lastupdated=$lastupdaterow['releasedate'];
				$lastupdateid=$lastupdaterow['id'];
			}
		/*end*/
		$row['catdata']=array(
							'id'=>$id,
							'description'=>$description,
							'largcover'=>"$coverpicprev",
							'mediumcover'=>"$coverpicmedsize",
							'thumbcover'=>"$coverpicthumb",
							'ownerid'=>$userid,
							'ownertype'=>"$type",
							'ownername'=>"$name",
							'ownerimage'=>$ownerimage,
							'ownerbanner'=>$ownerbanner
						);
		$row['selectionoutput']='<option value="'.$row['id'].'">'.$row['contenttitle'].'</option>';
		$edittextout="editsingleparentcontentadmin";
		$retdataout="";
		if($usereditid>0){
			$retdataout='
				<input type="hidden" name="retid" value="'.$usereditid.'"/>
				<input type="hidden" name="rettbl" value="users"/>
			';
			$edittextout=$type=="user"?"editsingleuserparentcontent":($type=="client"?"editsingleclientparentcontent":$edittextout);
		}
		$row['adminoutput']='
			<tr data-id="'.$id.'">
				<td class="tdimg"><img src="'.$coverpicmedsize.'"/></td><td>'.$contenttitle.'</td><td>'.$name.'</td><td>'.$type.'</td><td>'.$contenttype.'</td><td>'.$contentstatus.'</td><td>'.$status.'</td>
				<td name="trcontrolpoint">
					<a href="#&id='.$id.'" name="edit" data-type="'.$edittextout.'" data-divid="'.$id.'">Edit</a>
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
		$row['adminoutputtwo']='
			<form name="contentcategoryform" action="'.$host_addr.'snippets/edit.php" method="POST" enctype="multipart/form-data">
        		<input name="entryvariant" type="hidden" value="editparentcontentadmin"/>
        		<input name="entryid" type="hidden" value="'.$id.'"/>
        		<div class="box-group" id="contentaccordion">
        			<div class="panel box box-primary">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a data-toggle="collapse" data-parent="#contentaccordion" href="#headBlock">
                            <i class="fa fa-"></i>  Edit '.$contenttitle.'
                          </a>
                        </h4>
                      </div>
                      <div id="headBlock" class="panel-collapse collapse in">
	                        <div class="box-body">
	                        	<div class="form-group">
			                      <label>Content Title</label>
			                      <div class="input-group">
				                      <div class="input-group-addon">
				                        <i class="fa fa-file-text"></i>
				                      </div>
			                      	  <input type="text" class="form-control" name="contenttitle" value="'.$contenttitle.'" placeholder="Enter the title"/>
			                      </div>
			                    </div>
			                    <div class="form-group">
			                      <label for="businesslogo"> Description</label>
			                      <div class="input-group">
				                      <div class="input-group-addon">
				                        <i class="fa fa-file-text-o"></i>
				                      </div>
				                      <textarea name="description" rows="3" class="form-control" placeholder="A brief description of what this category entails or has to offer">'.$description.'</textarea>
				                  </div>
			                    </div>
			                    <div class="form-group">
			                      <label for="businessbanner">Cover Image</label>
			                      <div class="input-group">
				                      <div class="input-group-addon">
				                        <i class="fa fa-file-image-o"></i>
				                      </div>
				                      <input type="file" name="profpic" class="form-control">
				                      <input type="hidden" name="imgid"  value="'.$imgid.'" class="form-control">

				                  </div>
			                      <p class="help-block">Choose the cover image for this category</p>
			                    </div>
			                    <div class="form-group">
			                      <label>Content Status</label>
			                      <div class="input-group">
				                      <div class="input-group-addon">
				                        <i class="fa fa-bolt"></i>
				                      </div>
			                      	  <select class="form-control" name="contentstatus">
			                      	  	<option value="">Change Content Status</option>
			                      	  	<option value="ongoing">Ongoing</option>
			                      	  	<option value="hiatus">Hiatus</option>
			                      	  	<option value="ended">Ended</option>
			                      	  </select>
			                      </div>
			                    </div>
			                    <div class="form-group">
			                      <label>Status</label>
			                      <div class="input-group">
				                      <div class="input-group-addon">
				                        <i class="fa fa-ban"></i>
				                      </div>
			                      	  <select class="form-control" name="status">
			                      	  	<option value="">Change Status</option>
			                      	  	<option value="active">Active</option>
			                      	  	<option value="inactive">Inactive</option>
			                      	  </select>
			                      </div>
			                    </div>
		                        <div class="col-md-12">
				        			<div class="box-footer">
						        		'.$retdataout.'
					                    <input type="submit" class="btn btn-danger" name="update" value="Update"/>
					                </div>
				            	</div>
				            	'.$selectscript.'
	                        </div>
                      </div>
                    </div>
        		</div>
		    </form>
		';
		return $row;
	}

	function getAllParentContent($viewer,$type,$typeid,$limit){
		include('globalsmodule.php');
		
		$row=array();
		$usereditid="";
		$extraquery="";
		$concat=$viewer=="admin"?"WHERE":"AND";
		if($type=='user'){
			$extraquery="$concat userid=$typeid";
		}
		if($type=='usertypeout'){
			$userid=$typeid[0];
			($userid=="yesfull"||$userid=="yes")&&$type=="usertypeout"?$userid=0:$userid=$userid;
			$contentid=$typeid[1];
			$typeid="$userid|$contentid";

			// echo $typeid."<br>";
			$extraquery="$concat userid='$userid' AND contenttypeid='$contentid'";
		}
		if($type=='usertypeoutedit'){
			$userid=$typeid;
			$usereditid=$userid;

			($userid=="yesfull"||$userid=="yes")&&$type=="usertypeoutedit"?$userid=0:$userid=$userid;
			// echo $typeid."<br>";
			$extraquery="$concat userid='$userid'";
		}
		if($type=='catid'||$type=='catidtwo'){
			$subcontent="";
			if($type=="catidtwo"){
				$typeid=$typeid[1];
				// this section handles the mobile apis catidtwo call under
				// "fetchcategoryusers"
				$subcontent=" AND status='active' GROUP BY userid ";	
			}
			$extraquery="$concat contenttypeid='$typeid' $subcontent";
		}
		if($type=="pullfromlastentrysetparentcontent"||$type=="pullfromnextentrysetparentcontent"){
			$subcontent="";
			$hold=$typeid;
			$userid=$hold[0];
			$typeid=$hold[1];
			$lastid=$hold[2];
			$nextid=$hold[3];
			$lncontent=$type=="pullfromlastentrysetparentcontent"?"id<$lastid":"id>$nextid";
			$extraquery="$concat contenttypeid='$typeid' $subcontent AND $lncontent";
			
		}

		if ($type=="napstandonly") {
			# code...
			$extraquery="$concat userid=0";

		}
		if ($type=="napstandall") {
			# code...
			
		}
		/*if($type==''){
			$extraquery="$concat contenttypeid=$typeid";
		}*/
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

		$today=date("Y-m-d");
		$timenow=date("H:i:s");

		$outputtype="parentcontent|$viewer|$type|$typeid";
		
		if($viewer=="admin"){
			$query="SELECT * FROM parentcontent $extraquery ORDER BY contenttitle $limit";
			$rowmonitor['chiefquery']="SELECT * FROM parentcontent $extraquery";
		}else if ($viewer=="viewer") {
			# code...
			$query="SELECT * FROM parentcontent WHERE status='active' $extraquery ORDER BY contenttitle $limit";
			$rowmonitor['chiefquery']="SELECT * FROM parentcontent WHERE status='active' $extraquery";
		}else if(is_array($viewer)){
				$subtype=$viewer[0];
				$searchval=$viewer[1];
				$viewer=$viewer[2];
	 		  	$outputtype="parentcontentsearch|$subtype|$searchval|$viewer";
				if($subtype=="parentcontenttitle"&&$viewer=="admin"){
					$query="SELECT * FROM parentcontent WHERE (contenttitle LIKE '%$searchval%' AND status='active') OR (title LIKE '%$searchval%' AND status='inactive') $limit";
			    	$rowmonitor['chiefquery']="SELECT * FROM parentcontent WHERE (contenttitle LIKE '%$searchval%' AND status='active') OR (title LIKE '%$searchval%' AND status='inactive')";
				}elseif($subtype=="parentcontentstatus"&&$viewer=="admin"){
					$query="SELECT * FROM parentcontent WHERE status ='$searchval' $limit";
			    	$rowmonitor['chiefquery']="SELECT * FROM parentcontent WHERE status ='$searchval'";
				}elseif($subtype=="clientnameparentcontent"&&$viewer=="admin"){
					$query="SELECT * FROM parentcontent WHERE EXISTS(SELECT * FROM users WHERE usertype='client' AND businessname LIKE '%$searchval%' AND id=`parentcontent`.`clientid`) $limit";
			    	$rowmonitor['chiefquery']="SELECT * FROM parentcontent WHERE EXISTS(SELECT * FROM users WHERE usertype='client' AND businessname LIKE '%$searchval%' AND id=`parentcontent`.`clientid`)";
				}elseif($subtype=="parentcontentsearchadvanced"&&$viewer=="admin"){
					$query= $searchval." ".$limit;
			    	$rowmonitor['chiefquery']=$searchval;
				}else{
					echo "search parameters unrecognized, contact your developer";
				}
		}
		// echo $query."<br>";
		$run=mysql_query($query)or die(mysql_error()." Real number:".__LINE__." old number  1041");
		$numrows=mysql_num_rows($run);
		$adminoutput='<td colspan="100%">No entries yet</td>';
		$adminoutputtwo='No entries yet';
		$adminoutputthree='No entries yet';
		$vieweroutput="";
		$selectionoutput='<option value="">Select a Content</option>';
		$catdata=array();
		$lastid=0;
		$nextid=0;
		$counter=0;
		if($numrows>0){
			$adminoutput="";
			$adminoutputthree="";
			while ($row=mysql_fetch_assoc($run)) {
				# code...
				$lastid=$lastid==0||$row['id']<$lastid?$row['id']:$lastid=$lastid;
				$nextid=$row['id']>$nextid?$row['id']:$nextid=$nextid;
				$contentcategorydata=getSingleParentContent($row['id'], $usereditid);
				$adminoutput.=$contentcategorydata['adminoutput'];
				$selectionoutput.=$contentcategorydata['selectionoutput'];
				$catdata[]=$contentcategorydata['catdata'];
				$counter++;
			}
		}
		$catdata['lastid']=$lastid;
		$catdata['nextid']=$nextid;
		$row['numrows']=$numrows;
		$row['rowmonitor']=$rowmonitor['chiefquery'];
		$outs=paginatejavascript($rowmonitor['chiefquery']);		
		$row['num_pages']=$outs['num_pages'];
		$top='<table id="resultcontenttable" cellspacing="0">
					<thead><tr><th>CoverImg</th><th>Title</th><th>User</th><th>Usertype</th><th>ContentType</th><th>ContentStatus</th><th>Status</th><th>View/Edit</th></tr></thead>
					<tbody>';
		$bottom='	</tbody>
				</table>';
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
			<div id="paginateddatahold" data-name="contentholder">
		';

		$paginatebottom='
			</div><div id="paginationhold">
				<div class="meneame">
					<div class="pagination" data-name="paginationpageshold">'.$outs['pageout'].'</div>
				</div>
			</div>
		';
		// for admin
		$row['adminoutput']=$paginatetop.$top.$adminoutput.$bottom.$paginatebottom;
		$row['adminoutputtwo']=$top.$adminoutput.$bottom;

		$row['catdata']=$catdata;
		$row['selectionoutput']=$selectionoutput;
		return $row;
	}

	function getSingleContentEntry($id, $trucount="",$appuserid="",$usereditid=""){
		include('globalsmodule.php');
		$row=array();
		$query="SELECT * FROM contententries WHERE id='$id'";
		$run=mysql_query($query)or die(mysql_error()." Line ".__LINE__);
		$row=mysql_fetch_assoc($run);
		$numrows=mysql_num_rows($run);
		if($numrows>0){
			$parentid=$row['parentid'];
			if($trucount==""){
				// get the trucount for this entry
				$trquery="SELECT * FROM contententries WHERE id<'$id' AND parentid='$parentid'";
				$trrun=mysql_query($trquery)or die(mysql_error()." Line ".__LINE__);
				$trnumrows=mysql_num_rows($trrun);
				$trucount=$trnumrows+1;
			}
			$row['trucount']=$trucount;
			$selectionoutput="";
			$userid=$row['userid'];
			// $usertype=$row['usertype'];
			$catid=$row['catid'];
			$catout=getSingleContentCategory($catid);
			$contenttype=$catout['catname'];
			$pq="SELECT * FROM parentcontent WHERE id='$parentid'";
			$prun=mysql_query($pq)or die(mysql_error()." Line ".__LINE__);
			$prow=mysql_fetch_assoc($prun);
			$row['prow']=$prow;
			$title=$row['title'];
			$description=$row['details'];
			$releasedate=$row['releasedate'];
			$price=$row['price'];

			$publishstatus=$row['publishstatus'];
			$scheduledate=$row['scheduledate'];
			$entrydate=$row['entrydate'];
			$status=$row['status'];

			$outdate="";
			$outcolor="";
			$outdatecolor="";
			$outstatustext="";
			$publishstatus=="published"?$outdate=$releasedate:($publishstatus=="dontpublish"?$outdate=$entrydate:($publishstatus=="scheduled"?$outdate=$scheduledate:$outdate));
			$publishstatus=="published"?$outcolor="color-darkgreen":($publishstatus=="dontpublish"?$outcolor="color-red":($publishstatus=="scheduled"?$outcolor="color-indigo":$outcolor));
			$publishstatus=="published"?$outdatecolor="color-darkgreen":($publishstatus=="dontpublish"?$outdatecolor="color-red":($publishstatus=="scheduled"?$outdatecolor="color-indigo":$outdatecolor));
			$publishstatus=="published"?$outstatustext="Published":($publishstatus=="dontpublish"?$outstatustext="Not Published":($publishstatus=="scheduled"?$outstatustext="Scheduled":$outstatustext));
			$cdate=$outdate;
	  		$maindayout=date('D, d F, Y h:i:s A', strtotime($cdate));
			if($title==""){
				$titlerow=$prow['contenttitle']." &nbsp;&nbsp;&nbsp;Entry: ".$trucount;
				$titleout=$prow['contenttitle']." &nbsp;&nbsp;&nbsp;Entry: ".$trucount." &nbsp;&nbsp;&nbsp;<span class=\"color-orange\">Publish Status:</span> <span class=\"$outcolor\">$outstatustext</span> &nbsp;&nbsp;&nbsp;<span class=\"color-orange\">Date:</span>  <span class=\"$outcolor\">$maindayout</span>";
			}else{
				$titlerow=$title;
				$titleout=$title." &nbsp;&nbsp;&nbsp;<span class=\"color-orange\">Publish Status:</span> <span class=\"$outcolor\">$outstatustext</span> &nbsp;&nbsp;&nbsp;<span class=\"color-orange\">Date:</span>  <span class=\"$outcolor\">$maindayout</span>";

			}
			$row['titlerow']=$titlerow;
			/*adjust the release and schedule dates to make room for null entries*/
				if($releasedate=="0000-00-00 00:00:00"){
					$releasedate="";
				}
				if($scheduledate=="0000-00-00 00:00:00"||$scheduledate=="0000-00-00 00:00"){
					$scheduledate="";
				}
			/*end*/
			

			$selectionoutput="$(''+formselector+' select[name=status]').val('$status');";
			/*go fetch the images for this content entry*/
				// get profilepicture
				$coverpicprev=$host_addr."images/napstanddcover600x600.png";
				$coverpicmedsize=$host_addr."images/napstanddcover400x400.png";
				$coverpicthumb=$host_addr."images/napstanddcover50x50.png";
				
				$mediaquery="SELECT * FROM media where ownerid=$id AND ownertype='contententry' AND maintype='contententryimage' AND mainid>0 AND status='active' ORDER BY mainid";
				$mediarun=mysql_query($mediaquery)or die(mysql_error()." Line ".__LINE__);
				$mediacount=mysql_num_rows($mediarun);
				$edit_display="<p>No images found</p>";
				// get the first and last pages for the content entries into variable
				$firstoriginalimage="";
				$firstmediumimage="";
				$firstthumbimage="";
				$lastoriginalimage="";
				$lastmediumimage="";
				$lastthumbimage="";
				$firstpage = array();
				$lastpage = array();
				$contentout = array();
				// end
				$img_count=0;
				if($mediacount>0){
					$edit_display='';
					$img_count=1;
					$coverpicprev="";
					$coverpicmedsize="";
					$coverpicthumb="";
					while ($mediarow=mysql_fetch_assoc($mediarun)) {
						# code...
						$coverpicprev==""?$coverpicprev=$host_addr.$mediarow['location']:$coverpicprev;
						$coverpicmedsize==""?$coverpicmedsize=$host_addr.$mediarow['medsize']:$coverpicmedsize;
						$coverpicthumb==""?$coverpicthumb=$host_addr.$mediarow['thumbnail']:$coverpicthumb;
						$imgid=$mediarow['id'];
						$mainid=$mediarow['mainid'];
						$originalimage=str_replace(" ", "%20", $mediarow['location']);
						$medimage=str_replace(" ", "%20", $mediarow['medsize']);
						$thumbimage=str_replace(" ", "%20", $mediarow['thumbnail']);
						$contentout[]= array(
											'largecover' => $host_addr."$originalimage",
											'mediumcover' => $host_addr."$medimage",
											'thumbcover' => $host_addr."$thumbimage",
										);
						if($img_count==1){
							$firstpage= array(
											'largecover' => $host_addr."$originalimage",
											'mediumcover' => $host_addr."$host_addr$medimage",
											'thumbcover' => $host_addr."$thumbimage",
										);
							$firstoriginalimage=$host_addr.$originalimage;
							$firstmediumimage=$host_addr.$medimage;
							$firstthumbimage=$host_addr.$thumbimage;
						}else if ($img_count==$mediacount) {
							# code...
							$lastoriginalimage=$host_addr.$originalimage;
							$lastmediumimage=$host_addr.$medimage;
							$lastthumbimage=$host_addr.$thumbimage;
							$lastpage= array(
											'largecover' => $host_addr."$originalimage",
											'mediumcover' => $host_addr."$medimage",
											'thumbcover' => $host_addr."$thumbimage",
										);
						}
						$edit_display.='
							<li class="col-lg-2 col-md-3 col-sm-4 col-xs-6" data-original-order="'.$img_count.'" data-order-attr="'.$mainid.'">
			                	<div class=" single_image_hold" data-id="'.$img_count.'">
			                		<div class="content_image_loader hidden" data-id="'.$img_count.'">
				                		<img class="loadermini" src="'.$host_addr.'images/waiting.gif"/>
				                	</div>
		            				<div class="img_placeholder text-center">
					                	<div class="dragimg_placeholder text-center">
			            					<i class="fa fa-arrows"></i>
			            				</div>
		            					<div class="img_list_position text-center">'.$mainid.'</div>
		            					<img src="'.$host_addr.''.$thumbimage.'"/>
		            				</div>
			            			<div id="editimgsoptionlinks" class="img_options _type2">
			            				<ul> 
			            					<li>
			            						<a href="'.$host_addr.''.$originalimage.'" data-lightbox="contentgallery'.$id.'" data-src="'.$host_addr.''.$originalimage.'" name="viewpic">
			            							<i class="fa fa-eye"></i>
			            						</a>
			            					</li>
			            					<li><a href="##delete" name="deletepic_contententry" data-order-id="'.$img_count.'" data-original-order-id="'.$img_count.'" data-id="'.$id.'" data-imgid="'.$imgid.'"><i class="fa fa-trash"></i></a></li>
			            				</ul>
			            			</div>
			            			<div class="col-sm-12 positionoptions">
			            				<div class="form-group">   
											<label>Sort Order</label>
											<div class="input-group">
											    <div class="input-group-addon">
											    	<i class="fa fa-sort-amount-asc"></i>
											    </div>
			            						<input type="hidden" name="imgid_'.$img_count.'" class="form-control" value="'.$imgid.'"/>
			            						<input type="hidden" name="mainid_'.$img_count.'" value="'.$mainid.'" class="form-control"/>
			            						<input type="number" name="changeorder" class="form-control low_padding text-center"  value="'.$mainid.'" min="1" data-id="'.$id.'" Placeholder="Change Order" max="'.$mediacount.'"/>
			            						<div class="input-group-addon like_a_link" onClick="reSortTwo(this,'.$id.');">
											    	<i class="fa fa-arrow-right"></i>
											    </div>
											</div>
							            </div>
			            			</div>
		            			</div>
		            		</li>
						';
						$img_count++;
					}
					
				}

			/*end*/

			// set all the hidden variables according to what they will be hiding
			$publishstatus=="scheduled"?$schedulehidden='':$schedulehidden='hidden';
			$publishstatus=="scheduled"||$publishstatus=="dontpublish"?$selectionoutput.=" $(''+formselector+' select[name=editpublishdata]').val('$publishstatus');":$selectionoutput;
			
			$publishdata='
				<div class="col-sm-8">
	    			<label>Publish Status</label>
	    			<div class="input-group">
					    <div class="input-group-addon">
					    	<i class="fa fa-bars"></i>
					    </div>
	        			<select class="form-control" name="editpublishdata">
	        				<option value="published">Publish on Upload</option>
	        				<option value="dontpublish">Dont Publish(use if you cant upload all content at once or want this stored for later)</option>
	        				<option value="scheduled">Scheduled</option>
	        			</select>
	            	</div>
	    			<p class="side-note color-red">
	                	*<b>Publish on Upload</b>: Your post will be available on the Napstand platform immediately you submit it<br>
	                	*<b>Dont Publish</b>: Your post wont be displayed on the Napstand platform, this allows you to further edit and upload more content to it<br> 
	                	*<b>Scheduled</b>: Your post will be available on the "<b>Schedule date</b>" you choose<br>
	                </p>
	    		</div>
			';
			$scheduledata='
				<div class="col-md-6 '.$schedulehidden.'" data-name="editschedulesection">
					<!-- Date range -->
	                <div class="form-group">
	                    <label>Schedule Date(Make sure it is a future date,you can also set the time by clicking the small time icon at the bottom of the popup):</label>
	                    <div class="input-group">
	                      <input type="text" name="scheduledate" id="editscheduleentry" value="'.$scheduledate.'" placeholder="click/tap to choose date" class="form-control pull-right"/>
	                      <div class="input-group-addon">
	                        <i class="fa fa-calendar"></i>
	                      </div>
	                    </div><!-- /.input group -->
	                </div><!-- /.form group -->	
				</div>
			';
			if($publishstatus=="published"){
				$publishdata='
					<div class="col-sm-8">
		    			<label>Publish Status</label>
		    			<div class="input-group">
						    <div class="input-group-addon">
						    	<i class="fa fa-ban"></i>
						    </div>
		        			<p class="form-control">Published On '.$releasedate.'</p>
		            	</div>
		    		</div>
					
				';
				$scheduledata='';
			}
			$selectionscripts='
				$(document).ready(function(){
	    			var formselector=\'form[name=editcontententryform][data-contentid='.$parentid.''.$id.'] \';
					'.$selectionoutput.'
					$(\'\'+formselector+\' input[name=scheduledate]\').datetimepicker({
			            format:"YYYY-MM-DD HH:mm",
			            keepOpen:true
			        })
				});
			';
			$sortentryscriptsout='
				<script>
					$(document).ready(function(){
						var el=$(\'ul.sortable_content_entries[data-id='.$id.']\')[0];
					    var sortable_'.$id.'=Sortable.create(el, {
					        handle: \'.dragimg_placeholder\',
					        filter: "#editimgsoptionlinks ul",
					        // dragging started
					        onStart: function (/**Event*/evt) {
					            evt.oldIndex;  // element index within parent
					        },

					        // dragging ended
					        onEnd: function (/**Event*/evt) {
					            evt.oldIndex;  // element\'s old index within parent
					            evt.newIndex;  // element\'s new index within parent
					            // console.log(evt.oldIndex,evt.newIndex,evt.from.getAttribute(\'data-id\'));
					            var cur_index=Math.floor(evt.newIndex)+1;
					            var old_index=Math.floor(evt.oldIndex)+1;
					            var dataid=evt.from.getAttribute(\'data-id\');
					            var parentul=$(\'ul.sortable_content_entries[data-id=\'+dataid+\']\');
					            var total_length=$(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li\').length;
					            // console.log(cur_index,old_index);
					            if(Math.floor(cur_index)<Math.floor(old_index)){

					                for(var i=cur_index;i<=old_index;i++){
					                    // change form input data and values
					                    var parent=$(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\')\');
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\')\').attr("data-order-attr",i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') .img_list_position\').text(i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') .content_image_loader\').attr("data-id",i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') .single_image_hold\').attr("data-id",i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') a[name=deletepic_contententry]\').attr("data-order-id",i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') input[name*=imgid_]\').attr("name","imgid_"+i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') input[name*=mainid_]\').attr("name","mainid_"+i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') input[name*=mainid_]\').val(i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') input[name=changeorder]\').val(i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') input[name=changeorder]\').attr("value",i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') input[name=changeorder]\').attr("data-id",i);
					                    // console.log(\'Affected: \', parent);
					                }
					            }else if (Math.floor(cur_index)>Math.floor(old_index)) {

					                for(var i=old_index;i<=cur_index;i++){
					                     // change form input data and values
					                    var parent=$(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\')\');
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\')\').attr("data-order-attr",i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') .img_list_position\').text(i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') .content_image_loader\').attr("data-id",i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') .single_image_hold\').attr("data-id",i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') a[name=deletepic_contententry]\').attr("data-order-id",i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') input[name*=imgid_]\').attr("name","imgid_"+i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') input[name*=mainid_]\').attr("name","mainid_"+i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') input[name*=mainid_]\').val(i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') input[name=changeorder]\').val(i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') input[name=changeorder]\').attr("value",i);
					                    $(\'ul.sortable_content_entries[data-id=\'+dataid+\'] > li:nth-of-type(\'+i+\') input[name=changeorder]\').attr("data-id",i);
					                    // console.log(\'Affected(Lower): \', parent);
					                }
					            }
					        }
					    });
						
					})
				</script>
			';
			$edittextout="editsingleparentcontentadmin";
			$retdataout="";
			// setup redirect data for the user
			if($usereditid>0){
				$retdataout='
					<input type="hidden" name="retid" value="'.$usereditid.'"/>
					<input type="hidden" name="rettbl" value="users"/>
				';
			}
			// create the edit images section
			$edit_images_section='
				<form name="sortcontentform" enctype="multipart/form-data" data-contentid="'.$id.'" method="POST" action="'.$host_addr.'snippets/edit.php">
	        		<input type="hidden" name="entryvariant" value="sortcontententries"/>
	        		<input type="hidden" name="entryid" value="'.$id.'"/>
	        		<input type="hidden" name="entrycount" value="'.$mediacount.'"/>
	            		<!-- <li class=""></li> -->
	            	<div class="col-md-12 clearboth">
	                	<div class="box-footer text-center">
	            			<input type="button" class="btn btn-danger" name="sortcontententryorder" data-id="'.$id.'" value="Save Sort Order"/>
	            		</div>
	                </div>
	        		<ul class="sortable_content_entries" data-id="'.$id.'">
	        			<!--<li class="placeholder"></li>-->
	            		'.$edit_display.'
	        		</ul>
	        		<div class="col-md-12 clearboth">
	                	<div class="box-footer text-center">
	            			<input type="button" class="btn btn-danger" name="sortcontententryorder" data-id="'.$id.'" value="Save Sort Order"/>
	            		</div>
	                </div>
	        		<div class="content_image_loader_main hidden">
	        			<img src="'.$host_addr.'images/loading.gif" class="loadermidi"/>
	        			<input type="hidden" name="formstate" value="loaded"/>
	        		</div>
	        		'.$sortentryscriptsout.'
	        		'.$retdataout.'
	    		</form>
			';

			// create the edit form section
			$edit_entry_data_section='
				<form name="editcontententryform" data-contentid="'.$parentid.''.$id.'" enctype="multipart/form-data" method="POST" action="'.$host_addr.'snippets/edit.php">
	            	<input type="hidden" name="entryvariant" value="editcontententries">
	            	<input type="hidden" name="entryid" value="'.$id.'">
	            	<div class="col-sm-6">
	        			<label>Entry Type</label>
	        			<div class="input-group">
						    <div class="input-group-addon">
						    	<i class="fa fa-file-image-o"></i>
						    </div>
	            			<select class="form-control" data-id="'.$parentid.''.$id.'" name="edituploadtype">
	            				<option value="">Specify Upload Type</option>
	            				<option value="imageuploadedit">Image Upload</option>
	            				<option value="zipuploadedit">Zip File Upload</option>
	            			</select>
	            		</div>
	        		</div>
					<div class="col-sm-6">
	                	<div class="form-group">   
							<label>Content/Release title(not compulsory)</label>
							<div class="input-group">
							    <div class="input-group-addon">
							    	<i class="fa fa-bars"></i>
							    </div>
							    <input type="text" class="form-control" name="editcontenttitle" value="'.$title.'" placeholder="Provide a good title for this entry"/>
							</div>
	                    </div>
	                </div>
	                
	                <div class="col-sm-12">
	                	<div class="form-group">
		                      <label for="businesslogo">Short Description(Optional)</label>
		                      <div class="input-group">
			                      <div class="input-group-addon">
			                        <i class="fa fa-file-text-o"></i>
			                      </div>
			                      <textarea name="editdescription" rows="3" class="form-control" placeholder="A brief description for this entry(Optional)">'.$description.'</textarea>
			                  </div>
	                    </div>
	                </div>
	                <div class="col-sm-12 emu-row">
						'.$publishdata.'
	            		<div class="col-sm-4">
							<div class="form-group">
	            				<label>Price(Set to zero if this issue is free)</label>
								<div class="input-group">
			                    	<div class="input-group-addon">
			                    		&#8358;
			                    	</div>
									<input type="number" class="form-control" Placeholder="Price" name="editpostprice" min="0" value="'.$price.'" max="'.$host_price_limit.'"/>
			                    </div>
							</div>
						</div>
						'.$scheduledata.'
					</div>
					<div class="col-md-12 upload-image-section hidden" data-name="upload-image-sectionedit" data-id="'.$parentid.''.$id.'">
						<h4 class="imguploadheader">Image Upload Section</h4>
						<div class="col-sm-12">
			                <div class="form-group">
			                    <label>Specify the amount of images You want to upload, max combined upload size is 30MB
			                    	(More can be uploaded afterwards, just make sure you change the publish status to dont publish):</label>
			                    <div class="input-group">
			                      <div class="input-group-addon">
			                        <i class="fa fa-list-ol"></i>
			                      </div>
			                      <input type="number" name="imagecountedit" placeholder="Maximimum of 20" min="1" data-id="'.$parentid.''.$id.'" max="20" data-max="20" class="form-control"/>
			                    </div><!-- /.input group -->
			                    <p class="side-note color-red">
			                    	Choose the amount then click/tap Below the field. NB. the upload order is how your content images will be displayed to users
			                    	<br>
			                    	To reduce or increase the number of entries, adjust the value in the field above
			                    </p>
			                </div><!-- /.form group -->
						</div>
						<div class="col-sm-12 image_upload_section edit">	
							<div class="entrymarker images">
								<p class="total-size" title="Total size of Files"></p>
								<input type="hidden" name="filesizeoutedit" value="0"/>
							</div>
						</div>
					</div>
					<div class="col-md-12 upload-zip-section hidden" data-name="upload-zip-sectionedit" data-id="'.$parentid.''.$id.'">
						<h4 class="imguploadheader">Zip File Upload Section</h4>
						<div class="col-sm-12">
			                <div class="form-group">
			                    <label>Max upload size is 30MB
			                    	(More can be uploaded afterwards, just make sure you change the publish status to dont publish):</label>
			                    <div class="input-group">
				                    <!-- <div class="input-group-addon">
				                    	<i class="fa fa-list-ol"></i>
				                    </div> -->
				                    <p class="zipfilehold">
				                        <span class="btn btn-success fileinput-button absbottomtwo bottom-left zipfile">
						                    <i class="fa fa-plus"></i>
						                    <span>Choose Zip archive with images only</span>
						                    <input type="file" id="zipupload" name="zipfileedit" data-edit="edit" onChange="readURLTwo($(this),\'napstanduserzipeditupload\')"/>
						                </span>
						            </p>
			                    </div><!-- /.input group-->
			                    <p class="side-note color-red">
			                    	Make sure that the compressed files are in the right naming format, i.e, names are numeric, e.g 1.png, 2.png ....e.t.c
			                    	<br>
			                    	NB the archive must only have image files, any other format will be ignored.
			                    </p>
			                </div><!-- /.form group -->
						</div>
						<div class="col-sm-12">	
							<div class="entrymarker zip">
								<p class="total-size" title="Total size of Files">
									
								</p>
								<input type="hidden" name="zipfilesizeoutedit" value="0"/>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
	        			<label>Status</label>
	        			<div class="input-group">
						    <div class="input-group-addon">
						    	<i class="fa fa-bars"></i>
						    </div>
	            			<select class="form-control" name="status">
	            				<option value="">Change Status</option>
	            				<option value="active">Active</option>
	            				<option value="inactive">Inactive</option>
	            			</select>
	            		</div>
	            		<p class="side-note color-red">
	                    	<b>Active</b>: This entry stays alive on the Napstand platform<br>
	                    	<b>Inactive</b>: This entry will not be displayed to users on the Napstand platform.<br>
	                    </p>
	        		</div>
					<div class="col-md-12">
	                	<div class="box-footer">
			        		'.$retdataout.'
	            			<input type="button" class="btn btn-danger" name="editcontententry" data-id="'.$parentid.''.$id.'" value="Submit"/>
	            		</div>
	                </div>
	                <script>
	                	'.$selectionscripts.'
	                </script>
	            </form>

			';
			$row['edit_images_section']=$edit_images_section;
			$row['edit_entry_data_section']=$edit_entry_data_section;
			$row['edittotaldatasection']='
				
	        	<div class="col-sm-12 edit_parentcontent">
	                <div class="box-group" id="contentaccordion_c'.$parentid.'">
						<div class="panel box box-primary">
				          <div class="box-header with-border">
				            <h4 class="box-title">
				              <a data-toggle="collapse" data-parent="#contentaccordion_c'.$parentid.'" href="#headBlock_c'.$parentid.'">
				                <i class="fa fa-gears"></i> '.$titleout.' 
				              </a>
				            </h4>
				          </div>
				          <div id="headBlock_c'.$parentid.'" class="panel-collapse collapse">
				                <div class="box-body">
				                	<div class="col-md-12">
				                		<div class="col-sm-12">
				                			<label>Select an Action</label>
				                			<div class="input-group">
											    <div class="input-group-addon">
											    	<i class="fa fa-bars"></i>
											    </div>
					                			<select class="form-control" name="editdata">
					                				<option value="">Specify which actions you want to take?</option>
					                				<option value="editprevious">Manage Images</option>
					                				<option value="editdetails">Create/Edit Data</option>
					                			</select>
						                	</div>
				                			<p class="side-note color-red">
						                    	*<b>Manage Images</b>:Edit previously uploaded image content, you can preview, delete or change the order of arrangement the images follow<br>
						                    	*<b>Create/Edit Data</b>:You can upload more images from here, as well as adjust your content price or change the details other details,like scheduling and publishing, if the options are available <br> 
						                    </p>
				                		</div>
				                		
				                	</div>
				                	
				                	<div class="col-md-12 edit_prev_uploads_section hidden">
				                		'.$edit_images_section.'
									</div>

				                	<div class="col-md-12 editcontententryform hidden">
				                		'.$edit_entry_data_section.'
				                	</div>
								</div>
				          </div>
				        </div>
					</div>
	            </div>
			';
			$row['selectionoutput']='<option value="'.$row['id'].'" data-image="'.$coverpicthumb.'">'.$row['title'].'</option>';
			$row['adminoutput']='
				<tr data-id="'.$id.'">
					<td class="tdimg"><img src="'.$coverpicmedsize.'"/></td><td>'.$title.'</td><td>'.$contenttype.'</td><td>'.$publishdata.'</td><td>'.$scheduledate.'</td><td>'.$releasedate.'</td><td>'.$status.'</td>
					<td name="trcontrolpoint">
						<a href="#&id='.$id.'" name="edit" data-type="editsinglecontententryadmin" data-divid="'.$id.'">Edit</a>
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
			$row['adminoutputtwo']='
				<div class="col-sm-12 edit_parentcontent">
	                <div class="box-group" id="contentaccordion_c'.$parentid.'">
						<div class="panel box box-primary">
				          <div class="box-header with-border">
				            <h4 class="box-title">
				              <a data-toggle="collapse" data-parent="#contentaccordion_c'.$parentid.''.$id.'" href="#headBlock_c'.$parentid.''.$id.'">
				                <i class="fa fa-gears"></i> '.$titleout.' 
				              </a>
				            </h4>
				          </div>
				          <div id="headBlock_c'.$parentid.''.$id.'" class="panel-collapse collapse">
				                <div class="box-body">
				                	<div class="col-md-12">
				                		<div class="col-sm-12">
				                			<label>Select an Action</label>
				                			<div class="input-group">
											    <div class="input-group-addon">
											    	<i class="fa fa-bars"></i>
											    </div>
					                			<select class="form-control" data-id="'.$parentid.''.$id.'" name="editdata">
					                				<option value="">Specify which actions you want to take?</option>
					                				<option value="editprevious">Manage Images</option>
					                				<option value="editdetails">Create/Edit Data</option>
					                			</select>
						                	</div>
				                			<p class="side-note color-red">
						                    	*<b>Manage Images</b>:Edit previously uploaded image content, you can preview, delete or change the order of arrangement the images follow<br>
						                    	*<b>Create/Edit Data</b>:You can upload more images from here, as well as adjust your content price or change the details other details,like scheduling and publishing, if the options are available <br> 
						                    </p>
				                		</div>
				                		
				                	</div>
				                	
				                	<div class="col-md-12 edit_prev_uploads_section hidden" data-id="'.$parentid.''.$id.'">
				                		'.$edit_images_section.'
									</div>

				                	<div class="col-md-12 editcontententryform hidden" data-id="'.$parentid.''.$id.'">
				                		'.$edit_entry_data_section.'
				                	</div>
								</div>
				          </div>
				        </div>
					</div>
	            </div>
			';
			// get transaction data if this is an app user request
			$paymentstatus="";
			if($appuserid>0){
				$outstransaction=getAllTransactions('viewer','','appuserpaymentstatus',$appuserid,$id);
				if($outstransaction['numrows']>0){
					$paymentstatus="Paid";
				}else{
					$paymentstatus="No Payment";
				}

			}
			$row['catdata']=array(
								'id' => "$id",
								'title' => "$titlerow",
								'parenttitle' => $prow['contenttitle'],
								'description' => "$description",
								'firstpage' => $firstpage,
								'lastpage' => $lastpage,
								'price' => "$price",
								'publishstatus' => "$publishstatus",
								'releasedate' => "$releasedate",
								'scheduledate' => "$scheduledate",
								'status' => "$status",
								'paymentstatus' => "$paymentstatus"
							);
			$row['catdatatwo']=array(
								'id' => "$id",
								'ownerid' => "$userid",
								'title' => "$titlerow",
								'parenttitle' => $prow['contenttitle'],
								'description' => "$description",
								'firstpage' => $firstpage,
								'lastpage' => $lastpage,
								'content' => $contentout,
								'price' => "$price",
								'publishstatus' => "$publishstatus",
								'releasedate' => "$releasedate",
								'scheduledate' => "$scheduledate",
								'status' => "$status",
								'paymentstatus' => "$paymentstatus"
							);
		}
		$row['numrows']=$numrows;
		return $row;	
	}

	function getAllContentEntries($viewer,$type,$typeid,$limit,$cattype="",$singletotal="",$appuserid=""){
		include('globalsmodule.php');
		$row=array();
	
		$extraquery="";
		$concat=$viewer=="admin"?"WHERE":"AND";
		$subquery="";
		$uid="";
		$lastid=0;
		$nextid=0;
		$userid="";
		$appuserstatcontrolextra="(status='active' OR status='inactive')";
		if(is_array($typeid)){
			$hold=$typeid;
			$typeid=$hold[0];
			$cattype=isset($hold[1])?$hold[1]:$cattype;
			$singletotal=isset($hold[2])?$hold[2]:$singletotal;
			$uid=isset($hold[3])?$hold[3]:"";
			$lastid=isset($hold[4])?$hold[4]:0;
			$nextid=isset($hold[5])?$hold[5]:0;
		}
		if($cattype=="published"||$cattype=="dontpublish"||$cattype=="scheduled"){
			$subquery=" AND publishstatus='$cattype'";
			$singletotal="|$cattype|$singletotal";
		}else if($cattype=="inactive"||$cattype=="active"){
			$subquery=" AND status='$cattype'";

		}else{
			$singletotal="||$singletotal";

		}

		if(($cattype=="pullfromlastentryset"||$cattype=="pullfromnextentryset")&&$appuserid>0){
			$lncontent=$cattype=="pullfromlastentryset"?"id<$lastid":"id>$nextid";
			$subquery.="  AND publishstatus='published' AND $lncontent";
		}
		if($type=='usertypeout'){
			if (isset($_SESSION['userinapstand'])||isset($_SESSION['clientinapstand'])) {
				# code...
				$userid=isset($_SESSION['userinapstand'])?$_SESSION['userinapstand']:$_SESSION['clientinapstand'];
				$extraquery="$concat userid=$userid AND parentid=$typeid $subquery ORDER BY id DESC";
				$typeid="$userid|$typeid";
			}
		}

		if($type=='usertypeouttwo'){
			# code...
			$extraquery="$concat userid=$userid AND parentid=$typeid $subquery ORDER BY id DESC";
			$typeid="$userid|$typeid";
		}

		if($type=='parentid'||$type=='parentiduseredit'){
			$userid=$type=="parentiduseredit"?$uid:"";
			$singletotal.=$type=="parentiduseredit"?"|".$uid:"";
			$extraquery="$concat parentid='$typeid' $subquery ORDER BY id DESC";
		}

		if($type=='catcontentout'){
			// gets all published data for a user under a category
			$extraquery="$concat catid='$typeid' AND userid='$uid' AND publishstatus='published' $subquery ORDER BY id DESC";
		}

		if ($type=="napstandonly") {
			# code...
			$extraquery="$concat userid=0 $subquery ORDER BY id DESC";
		}

		if ($type=="napstandall") {
			# code...
			
		}
		/*if($type==''){
			$extraquery="$concat contenttypeid=$typeid";
		}*/
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

		$today=date("Y-m-d");
		$timenow=date("H:i:s");
		// $singletotal!==""?$singletotal="|$singletotal":$singletotal;
		$outputtype="contententries|$viewer|$type|$typeid".$singletotal;

		if($viewer=="admin"){
			$query="SELECT * FROM contententries $extraquery $limit";
			$rowmonitor['chiefquery']="SELECT * FROM contententries $extraquery";
		}else if($viewer=="viewer"){
			
			if (isset($_SESSION['useri'])) {
				# code...
				$userid=$_SESSION['useri'];
				$query="SELECT * FROM contententries WHERE status='active' $extraquery $limit";
				$rowmonitor['chiefquery']="SELECT * FROM contententries status='active' $extraquery";
			}else if ($appuserid>0) {
				# code...
				$query="SELECT * FROM contententries WHERE $appuserstatcontrolextra $extraquery $limit";
				$rowmonitor['chiefquery']="SELECT * FROM contententries WHERE $appuserstatcontrolextra $extraquery";
			}else{
				$query="SELECT * FROM contententries WHERE id=0";
				$rowmonitor['chiefquery']="SELECT * FROM contententries WHERE id=0";
			}
		}

		// echo $query;
		$run=mysql_query($query)or die(mysql_error()." Line: ".__LINE__);
		$numrows=mysql_num_rows($run);
		$adminoutput='<td colspan="100%">No entries yet</td>';
		$adminoutputtwo='No entries yet';
		$adminoutputthree='No entries yet';
		$edittotaldatasection="<p>No data yet<p>";
		$vieweroutput="";
		$selectionoutput='<option value="">Select a Content</option>';
		$catdata=array();
		$catdatatwo=array();
		$lastid=0;
		$nextid=0;
		$counterout=0;
		if($numrows>0){
			$adminoutput="";
			$adminoutputthree="";
			$edittotaldatasection="";
			$counter=$numrows;
			while ($row=mysql_fetch_assoc($run)) {
				# code...
				$lastid=$lastid==0||$row['id']<$lastid?$row['id']:$lastid=$lastid;
				$nextid=$row['id']>$nextid?$row['id']:$nextid=$nextid;
				$contententrydata=getSingleContentEntry($row['id'],$counter,$appuserid,$userid);
				$adminoutput.=$contententrydata['adminoutput'];
				$edittotaldatasection.=$contententrydata['adminoutputtwo'];
				$selectionoutput.=$contententrydata['selectionoutput'];
				$catdata[]=$contententrydata['catdata'];
				$catdatatwo[]=$contententrydata['catdatatwo'];
				$counter--;
			}
		}
		$catdata['lastid']=$lastid;
		$catdata['nextid']=$nextid;
		$catdatatwo['lastid']=$lastid;
		$catdatatwo['nextid']=$nextid;
		$row['catdata']=$catdata;
		$row['catdatatwo']=$catdatatwo;
		$row['numrows']=$numrows;
		$row['rowmonitor']=$rowmonitor['chiefquery'];
		$outs=paginatejavascript($rowmonitor['chiefquery']);
		$row['num_pages']=$outs['num_pages'];		
		$top='<table id="resultcontenttable" cellspacing="0">
					<thead><tr><th>CoverImg</th><th>Title</th><th>ContentType</th><th>ContentStatus</th><th>Schedule Date</th><th>Release Date</th><th>Status</th><th>View/Edit</th></tr></thead>
					<tbody>';
		$bottom='	</tbody>
				</table>';
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
			<div id="paginateddatahold" data-name="contentholder">
		';

		$paginatebottom='
			</div><div id="paginationhold">
				<div class="meneame">
					<div class="pagination" data-name="paginationpageshold">'.$outs['pageout'].'</div>
				</div>
			</div>
		';
		// for admin
		$row['adminoutput']=$paginatetop.$top.$adminoutput.$bottom.$paginatebottom;
		$row['adminoutputtwo']=$top.$adminoutput.$bottom;
		// load combined content of a new entry form and corresponding data edit fields
		$initvars=array();
		$initvals=array();
		$parentid=$typeid;
		$initvars[]="parentid";
		$initvals[]=$parentid;
		if($type=="parentiduseredit"){
			$initvars[]="retid";
			$initvars[]="rettbl";
			$initvals[]=$uid;
			$initvals[]="users";
		}
		$entryform = get_include_contents('createcontententry.php',$initvars,$initvals);

		$row['edittotaldatasection']=$edittotaldatasection;
		$row['altadminoutput']='
        	<div class="nav-tabs-custom">
                <ul class="nav nav-tabs parent_content_nav_tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">New Post</a></li>
                  <li class=""><a href="#tab_2" data-toggle="tab">Edit Previous Posts</a></li>
                </ul>
                <div class="tab-content col-md-12">
                    <div class="tab-pane active" id="tab_1">
                    	'.$entryform.'
                    </div><!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                		<div class="col-md-12 generic_ajax_pages_hold pagination_pages _top text-center"></div>
	                	<div class="col-md-12 generic_ajax_page_hold page_content_out_hold" data-type="contentdisplay">
                			'.$edittotaldatasection.'
						</div>
	                	<div class="col-md-12 generic_ajax_pages_hold pagination_pages _bottom text-center"></div>
	                    <div class="content_image_loader_bootpag hidden">
	            			<img src="'.$host_addr.'images/loading.gif" class="loadermidi"/>
	            		</div>
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->

            </div><!-- nav-tabs-custom -->
            <script>
            	$(\'.generic_ajax_pages_hold._top,.generic_ajax_pages_hold._bottom\').bootpag({
				    total: '.$outs['num_pages'].',
				    page: 1,
				    maxVisible: 9,
				    leaps: true,
				    firstLastUse: true,
				    first: \'<i class="fa fa-arrow-left"></i>\',
				    last: \'<i class="fa fa-arrow-right"></i>\',
				    wrapClass: \'pagination\',
				    activeClass: \'active\',
				    disabledClass: \'disabled\',
				    nextClass: \'next\',
				    prevClass: \'prev\',
				    lastClass: \'last\',
				    dataquery:true,
				    datacurquery:"'.$rowmonitor['chiefquery'].'",
				    dataipp:15,
				    dataoutputtype:"'.$outputtype.'",
				    datavariant:true,
				    datapages:[15,25,40,60],
				    datatarget:\'div.generic_ajax_pages_hold div.page_content_out_hold\',
				    dataitemloader:\'div.content_image_loader_bootpag\',
				    firstClass: \'first\'
				}).on("page", function(event, num){
				    
					event.preventDefault();
				    var curtimestamp=parseInt(event.timeStamp);
				    var doajax="";
				    var timetest=0;
				    if(timestamp==0){
				        timestamp=curtimestamp;
				    }else{
				        timetest=parseInt(curtimestamp)-parseInt(timestamp);
				        if(timetest<=10){
				            doajax="false";
				        }
				    }
				    if(doajax==""){
				        timestamp=curtimestamp;
				        var dataparent=$(this)[0].childNodes[1];
				        if(dataparent.getAttribute("class").indexOf("pagination bootpag")>-1){
				            dataparent=$(this)[0].childNodes[2];
				        }
				        var endtarget=$(this)[0].parentNode.getElementsByClassName(\'page_content_out_hold\')[0];
				        var page=parseInt(num);
				        var dipp=15;
				        var curquery="";
				        var outputtype="";
				        // console.log($(this)[0].parentNode.getElementsByClassName(\'content_image_loader_bootpag\'),endtarget);
				        for(var i=0;i<dataparent.childNodes.length;i++){
				            // console.log(dataparent.childNodes[i],dataparent.childNodes[i].name);
				            if(dataparent.childNodes[i].name=="curquery"){
				                curquery=dataparent.childNodes[i].value;
				            }
				            if(dataparent.childNodes[i].name=="outputtype"){
				                outputtype=dataparent.childNodes[i].value;
				            }
				            if(dataparent.childNodes[i].name=="ipp"){
				                dipp=dataparent.childNodes[i].value;
				            }

				        }
				        // for testing purposes only
				        // outputtype="";

				        // var item_loader=$(this)[0].parentNode.getElementById(\'content_image_loader_bootpag\');
				        var item_loader=$(this)[0].parentNode.getElementsByClassName(\'content_image_loader_bootpag\')[0];
				        item_loader.className=item_loader.className.replace( /(?:^|\s)hidden(?!\S)/g , \'\' );
				        // console.log(item_loader,item_loader.className);
				        // item_loader.removeClass(\'hidden\');
				        var url=\'\'+host_addr+\'snippets/display.php\';
				        var opts = {
				                type: \'GET\',
				                url: url,
				                data: {
				                  displaytype:\'paginationpagesout\',
				                  ipp:dipp,
				                  curquery:curquery,
				                  outputtype:outputtype,
				                  page:num,
				                  loadtype:\'jsonloadalt\',
				                  extraval:"admin"
				                },
				                dataType: \'json\',
				                success: function(output) {
				                  console.log(endtarget);
				                  // console.log(output);
				                  item_loader.className +=\' hidden\';
				                  // item_loader.addClass(\'hidden\').css("display","");
				                  // item_loader.remove();
				                  if(output.success=="true"){
				                        endtarget.innerHTML=output.msg;
				                  }
				                },
				                error: function(error) {
				                    if(typeof(error)=="object"){
				                        console.log(error.responseText);
				                    }
				                    var errmsg="Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again";
				                    // item_loader.remove();
				                    item_loader.className +=\' hidden\';
				                    raiseMainModal(\'Failure!!\', \'\'+errmsg+\'\', \'fail\');
				                    // alert("Sorry, something went wrong, possibly your internet connect is inactive, we apologise if this is from our end. Try the action again ");
				                }
				        };
				        $.ajax(opts)
				        // console.log(event,$(this)[0].childNodes,dataparent);
				        // get the datadiv refereence
				        // $(".content4").html("Page " + num); // or some ajax content loading...
				        // $(this).addClass("current");
				        
				    }
				}); 
            </script>
		';
		return $row;
	}

?>