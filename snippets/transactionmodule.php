<?php 
	//merchant id = 5489-0034957 for maxmigold
	//store data
	//Courses(1330)
	//Payment Buttons(1331)
	function getSingleTransaction($id,$appuserid=""){
		global $host_addr,$host_target_addr;
		$row=array();
		$query="SELECT * FROM transaction WHERE id=$id";
		$run=mysql_query($query)or die(mysql_error()." Line 3085");
		$row=mysql_fetch_assoc($run);
		// initialise field display styling
		$transactiontypestyle="";
		$apitypestyle="";
		$voguerefidstyle="";
		$amountpaidstyle="";
		$emailstyle="";
		$useralphanumericstyle="display:none;";
		$fullnamestyle='style="display:none;"';
		$phonenumberstyle='style="display:none;"';
		$usernamestyle='style="display:none;"';
		$coursegroupsstyle='style="display:none;"';
		$coursesubjectsstyle='style="display:none;"';
		$fileidstyle="";
		$downloadsstyle="";
		$transactiontimestyle="";
		$startdatestyle="";
		$voguestatusstyle="";
		$storenamestyle="";
		$titlestyle='';
		$vieweditstyle='style="display:none;"';
		$id=$row['id'];
		
		$transactiontype=$row['transactiontype'];
		if($transactiontype=="course"){
			$transactiontypestyle='style="display:none;"';
			$apitypestyle='style="display:none;"';
			$voguerefidstyle="";
			$amountpaidstyle="";
			$emailstyle="";
			$useralphanumericstyle="";
			$fullnamestyle='';
			$phonenumberstyle='';
			$usernamestyle='';
			$coursegroupsstyle='';
			$coursesubjectsstyle='';
			$fileidstyle='style="display:none;"';
			$downloadsstyle='style="display:none;"';
			$transactiontimestyle='';
			$startdatestyle='style="display:none;"';
			$voguestatusstyle="";
			$storenamestyle='style="display:none;"';
			$titlestyle='style="display:none;"';
			$vieweditstyle='';
		}else if($transactiontype=="napstandtransaction"){

		}


		$apitype=$row['apitype'];
		$voguerefid=$row['voguerefid'];
		$amountpaid=$row['amountpaid']!==""&&is_numeric($row['amountpaid'])?$row['amountpaid']:0;
		$email=$row['email'];
		$useralphanumeric=$row['useralpha'].$row['usernumeric'];
		$row['useralphanumeric']=$useralphanumeric;
		$fullname=$row['fullname'];
		$phonenumber=$row['phonenumber'];
		$phoneout=$phonenumber;
		$username=$row['username'];
		$userid=$row['userid'];
		$usertype=$row['usertype'];
		if($userid>0&&($usertype=="users"||$usertype=="appuser"||$usertype=="user"||$usertype=="client")){
			if (function_exists('getSingleUserPlain')) {
				# code...
				$outuser=getSingleUserPlain($userid);
				$fullname=$outuser['nameout'];
				$email=$outuser['email'];
				$phoneout=array("phoneone"=>$outuser['phoneone'],"phonetwo"=>$outuser['phonetwo'],"phonethree"=>$outuser['phonethree']);
			}
		}
		$row['coursegroupsout']=''; //holds the email portion of the entry
		$coursegroups=$row['coursegroups'];		
		//format the coursegroups and subjects into seperate parts
		$coursedatadisplayone="";
		$coursedatadisplaytwo=""; // for export purposes
		$coursecount=0;
		$coursedata=array();
		if($coursegroups!==""){
			$fload=explode("|||", $coursegroups);
			$coursecount=count($fload);
			// echo $coursecount."<br>";
			if(count($fload)>1){
				//run through the values of the exploded array
				for ($i=0; $i < count($fload); $i++) { 
					$floadtwo=explode("||", $fload[$i]);
					// [0]=
					$coursedatadisplayone.='
						<div class="col-md-3">
							Title: <b>'.$floadtwo[0].'</b><br> 
							Discount: <b>'.$floadtwo[1].'</b><br>
							Cost: <b>'.number_format($floadtwo[2]).'</b><br>
						</div>
					';
					$coursedatadisplaytwo.="".$floadtwo[0]." D:".$floadtwo[1]." C:".number_format($floadtwo[2])."\n";
					$coursedata[]=array(
								"title"=>$floadtwo[0],
								"discount"=>$floadtwo[1],
								"cost"=>number_format($floadtwo[2])
							);
				}
			}else{
				$floadtwo=explode("||", $coursegroups);
					// [0]=
				$coursecount=1;
				$coursedatadisplayone='
					<div class="col-md-3">
						Title: <b>'.$floadtwo[0].'</b><br> 
						Discount: <b>'.$floadtwo[1].'</b><br>
						Cost: <b>&#8358;'.number_format($floadtwo[2]).'</b><br>
					</div>
				';
				$coursedatadisplaytwo.="".$floadtwo[0]." D:".$floadtwo[1]." C:".number_format($floadtwo[2])."\n";
				$coursedata=array(
								"title"=>$floadtwo[0],
								"discount"=>$floadtwo[1],
								"cost"=>number_format($floadtwo[2])
							);
			}

			$row['coursegroupsout']=$coursedatadisplayone;
			$row['coursegroupsexportout']=$coursedatadisplaytwo;
		}

		$coursesubjects=$row['coursesubjects'];
		$subjectdatadisplayone="";
		$subjectdatadisplaytwo="";
		$subjectcount=0;
		$coursesubjectdata=array();
		$row['coursesubjectsout']='';
		if($coursesubjects!==""){
			$fload=explode("|||", $coursesubjects);
			$subjectcount=count($fload);
			if(count($fload)>1){
				//run through the values of the exploded array
				for ($i=0; $i < count($fload); $i++) { 
					$floadtwo=explode("||", $fload[$i]);
					// [0]=
					$subjectdatadisplayone.='
						<div class="col-md-3">
							Title: <b>'.$floadtwo[0].'</b><br> 
							Discount: <b>'.$floadtwo[1].'</b><br>
							Cost: <b>'.number_format($floadtwo[2]).'</b><br>
						</div>
					';
					$subjectdatadisplaytwo.="".$floadtwo[0]." C:".number_format($floadtwo[2])."\n";
					$coursesubjectdata[]=array(
											"title"=>$floadtwo[0],
											"discount"=>$floadtwo[1],
											"cost"=>number_format($floadtwo[2])
										);
				}
			}else{
				$floadtwo=explode("||", $coursesubjects);
				$subjectcount=1;
				$subjectdatadisplayone.='
					<div class="col-md-3">
						Title: <b>'.$floadtwo[0].'</b><br> 
						Discount: <b>'.$floadtwo[1].'</b><br>
						Cost: <b>'.number_format($floadtwo[2]).'</b>
					</div>
				';
				$subjectdatadisplaytwo.="".$floadtwo[0]." C:".number_format($floadtwo[2])."\n";
				$coursesubjectdata=array(
										"title"=>$floadtwo[0],
										"discount"=>$floadtwo[1],
										"cost"=>number_format($floadtwo[2])
									);
			}
			
			$row['coursesubjectsout']=$subjectdatadisplayone;
			$row['coursesubjectsexportout']=$subjectdatadisplaytwo;
		}
		/*get the contentid and contenttype portion sorted if they have values*/
			$contentid=$row['contentid'];
			$contenttype=$row['contenttype'];
			$contentobjectnameout=""; //variable holding final content title info
			$contentimageout=array(); //variable holding final content imagedata if available
			$cfirstpage=array();
			$clastpage=array();
			if($contentid>0){
				$cquery="SELECT * FROM $contenttype WHERE id='$contentid'";
				$crun=mysql_query($cquery)or die(mysql_error()." Line ".__LINE__);
				$crow=mysql_fetch_assoc($crun);
				if($contenttype=="contententries"){
					$objout=getSingleContentEntry($crow['id']);
					$contentobjectnameout=$objout['titlerow'];
					$cfirstpage=$objout['firstpage'];
					$clastpage=$objout['lastpage'];
				}
			}
		/*end*/
		$fileid=$row['fileid'];
		$downloads=$row['downloads']>5?"5":$row['downloads'];
		$transactiontime=$row['transactiontime'];
		$startdate=$row['startdate'];
		$voguestatus=$row['voguestatus']!==""?$row['voguestatus']:"No payment yet";
		
		// get the main point for this transaction
		$storename="";
		$title="";
		if($fileid!==0){
			// $mediadata=getSingleMediaDataTwo($fileid);
			// $storedata=getSingleStoreAudio($mediadata['ownerid']);
			// $storename=$storedata['storename'];
			// $title=$storedata['title'];
		}
		$row['adminoutput']='
			<tr data-id="'.$id.'">
				<td '.$voguerefidstyle.'>'.$voguerefid.'</td>
				<td '.$storenamestyle.'>'.$storename.'</td>
				<td '.$titlestyle.'>'.$title.'</td>
				<td '.$useralphanumericstyle.'>'.$useralphanumeric.'</td>
				<td '.$fullnamestyle.'>'.$fullname.'</td>
				<td '.$usernamestyle.'>'.$username.'</td>
				<td '.$phonenumberstyle.'>'.$phonenumber.'</td>
				<td '.$emailstyle.'>'.$email.'</td>
				<td '.$coursegroupsstyle.'>'.$coursecount.'</td>
				<td '.$coursesubjectsstyle.'>'.$subjectcount.'</td>
				<td '.$amountpaidstyle.'>'.number_format($amountpaid).'</td>
				<td '.$downloadsstyle.'>'.$downloads.'</td>
				<td '.$transactiontimestyle.'>'.$transactiontime.'</td>
				<td '.$startdatestyle.'>'.$startdate.'</td>
				<td '.$voguestatusstyle.'>'.$voguestatus.'</td>
				<td name="trcontrolpoint" '.$vieweditstyle.'><a href="#&id='.$id.'" name="edit" data-type="editsingletransaction" data-divid="'.$id.'">Edit</a></td>
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
		// show all details for the transaction
		$row['adminoutputtwo']='
			<div class="col-md-12 transaction_style_hold">
				<div class="col-md-4" '.$voguerefidstyle.'>Vogueref: '.$voguerefid.'</div>
				<div class="col-md-4" '.$storenamestyle.'>Store Name: '.$storename.'</div>
				<div class="col-md-4" '.$titlestyle.'>Title: '.$title.'</div>
				<div class="col-md-4" '.$useralphanumericstyle.'>User ReferenceId: <b>'.$useralphanumeric.'</b></div>
				<div class="col-md-4" '.$fullnamestyle.'>Fullname: <b>'.$fullname.'</b></div>
				<div class="col-md-4" '.$usernamestyle.'>Username: <b>'.$username.'</b></div>
				<div class="col-md-4" '.$phonenumberstyle.'>Phonenumber: <b>'.$phonenumber.'</b></div>
				<div class="col-md-4" '.$emailstyle.'>Email Address: <b>'.$email.'</b></div>
				<div class="col-md-12" '.$coursegroupsstyle.'><h4>Course Groups:</h4><br> '.$coursedatadisplayone.'</div>
				<div class="col-md-12" '.$coursesubjectsstyle.'><h4>Modules:</h4><br> '.$subjectdatadisplayone.'</div>
				<div class="col-md-4" '.$amountpaidstyle.'>AmountPaid: '.number_format($amountpaid).'</div>
				<div class="col-md-4" '.$downloadsstyle.'>Downloads'.$downloads.'</div>
				<div class="col-md-4" '.$transactiontimestyle.'>Transaction Time: '.$transactiontime.'</div>
				<div class="col-md-4" '.$startdatestyle.'>Start Date'.$startdate.'</div>
				<div class="col-md-4" '.$voguestatusstyle.'>VoguePay Transaction Status: <b>'.$voguestatus.'</b></div>
			</div>
		';
		$row['catdata']=array(
							'transactiontype' => $transactiontype,
							'apitype' => "$apitype",
							'refid' => "$voguerefid",
							'userid' => "$userid",
							'usertype' => "$usertype",
							'contentid' => "$contentid",
							'contenttype' => "$contenttype",
							'contenttitle' => "$contentobjectnameout",
							'firstpage' => $cfirstpage,
							'lastpage' => $clastpage,
							'email' => "$email",
							'phonenumber' => "$phonenumber",
							'amountpaid' => "$amountpaid",
							'stublink' => $row['stublink'],
							'fileid' => "$fileid",
							'email' => "$email",
							/*'coursedata' => $coursedata,
							'coursesubjectdata' => $coursesubjectdata,*/
							'transactionstatus' => "$voguestatus",
							'transactiontime' => "$transactiontime",
							'downloads' => "$downloads",
							'startdate' => "$startdate",
							'enddate' => $row['enddate'],
							'status' => $row['status'],
						);
		return $row;
	}
	function getAllTransactions($viewer,$limit,$type="",$appuserid="",$contentid=""){
		include('globalsmodule.php');
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
		$joiner='';
		$joiner2='';
		$queryorder='ORDER BY id DESC';
		$type==""?$type="all":$type;
		if($type!==""&&$type!=="all"&&is_numeric($type)){
			$joiner='AND contentid='.$type.'';
			$joiner2='WHERE contentid='.$type.'';
		}else if($type!==""&&$type!=="all"&&!is_numeric($type)){
			if($type=="courses"){
				$joiner2="WHERE transactiontype='course'";
				$queryorder='ORDER BY id DESC, status';
			}else if(preg_match('/exportrangecourses/', $type)){
				//explosion variable
				// ymd format for data search delimiter for daterange= ||
				$limit="";
				$phold=explode("exportrangecourses", $type);
				// secondary explosion variable
				$phold2=explode("||", $phold[1]);
				if(count($phold2)>1){
					$datetime1 = $phold2[0]; // specified scheduled time
		    		$datetime2 = $phold2[1];
		    		$time="00:00:00";
		    		$c1=new DateTime("$datetime1 $time");
		    		$c2=new DateTime("$datetime2 $time");
		    		if($c2<$c1){
		    			// compare the dates and sort them if they former is greateer than the latter
		    			$dateh=$datetime1;
		    			$datetime1=$datetime2;
		    			$datetime2=$dateh;
		    		}
		    		$joiner2="WHERE transactiontype='course' AND transactiontime >= '$datetime1' AND transactiontime <= '$datetime2'";
				}

			}else if($type=="exportallcourses"){
				$limit="";
			}else if($type=="appuserpaymentstatus"){
				$joiner="AND userid='$appuserid' AND usertype='users' AND contentid='$contentid'
						 AND contenttype='contententries'  
						 AND (lower(`voguestatus`)='approved' 
						 OR lower(`voguestatus`)='success' 
						 OR lower(`voguestatus`)='vogue successful' 
						 OR lower(`voguestatus`)='completed')";
				$joiner2="WHERE userid='$appuserid' AND usertype='users' AND contentid='$contentid'
						 AND contenttype='contententries'  
						 AND (lower(`voguestatus`)='approved' 
						 OR lower(`voguestatus`)='success' 
						 OR lower(`voguestatus`)='vogue successful' 
						 OR lower(`voguestatus`)='completed')";
			}else if($type=="appusertransactions"){
				$joiner="AND userid='$appuserid' AND usertype='users'"; 
				$joiner2="WHERE userid='$appuserid' AND usertype='users'"; 
			}else if($type=="verifytransactionid"){
				$joiner="AND voguerefid='$contentid' AND status='active'"; 
				$joiner2="WHERE voguerefid='$contentid' AND status='active'"; 
			}			
		}
		if($viewer=="admin"){
			$query="SELECT * FROM transaction $joiner2 $queryorder $limit";
			$rowmonitor['chiefquery']="SELECT * FROM transaction $joiner2 ORDER BY id DESC";
		}elseif($viewer=="viewer"){
			// $limit==""?$limit="LIMIT 0,15":$limit=$limit;
			$query="SELECT * FROM transaction WHERE status='active' $joiner $queryorder $limit";
			$rowmonitor['chiefquery']="SELECT * FROM transaction WHERE status='active' $joiner";	
		}
		// echo $query;
		$run=mysql_query($query)or die(mysql_error()." ".__LINE__);
		$numrows=mysql_num_rows($run);
		$adminoutput="<td colspan=\"100%\">No entries</td>";
		$adminoutputtwo="";
		// $vieweroutput='<font color="#fefefe">Sorry No store entries have been made</font>';
		$vieweroutputtwo='<font color="#fefefe">Sorry No store entries have been made</font>';
		$vieweroutput=$viewer=="search"?'Sorry, your search on <b>'.$search.'</b> yielded no results':'<font color="#fefefe">Sorry No store entries have been made</font>';
		$scriptoout="";
		// initialise field display styling
		$transactiontypestyle="";
		$apitypestyle="";
		$voguerefidstyle="";
		$amountpaidstyle="";
		$emailstyle="";
		$useralphanumericstyle='style="display:none;"';
		$fullnamestyle='style="display:none;"';
		$phonenumberstyle='style="display:none;"';
		$usernamestyle='style="display:none;"';
		$coursegroupsstyle='style="display:none;"';
		$coursesubjectsstyle='style="display:none;"';
		$fileidstyle="";
		$downloadsstyle="";
		$transactiontimestyle="";
		$startdatestyle="";
		$voguestatusstyle="";
		$storenamestyle="";
		$titlestyle='';
		$vieweditstyle='style="display:none;"';
		$catdata=array();
		if($numrows>0){
			$adminoutput="";
			$adminoutputtwo="";
			$vieweroutput="";
			while($row=mysql_fetch_assoc($run)){
				$outs=getSingleTransaction($row['id']);
				if($row['transactiontype']=="course"){
					$transactiontypestyle='style="display:none;"';
					$apitypestyle='style="display:none;"';
					$voguerefidstyle="";
					$amountpaidstyle="";
					$emailstyle="";
					$useralphanumericstyle='';
					$fullnamestyle='';
					$phonenumberstyle='';
					$usernamestyle='';
					$coursegroupsstyle='';
					$coursesubjectsstyle='';
					$fileidstyle='style="display:none;"';
					$downloadsstyle='style="display:none;"';
					$transactiontimestyle='';
					$startdatestyle='style="display:none;"';
					$voguestatusstyle="";
					$storenamestyle='style="display:none;"';
					$titlestyle='style="display:none;"';
					$vieweditstyle='';
				}
				$adminoutput.=$outs['adminoutput'];
				$adminoutputtwo.=$outs['adminoutputtwo'];
				$catdata[]=$outs['catdata'];
			}

		}
		$top='<table id="resultcontenttable" cellspacing="0">
				<thead>
					<tr>
						<th '.$voguerefidstyle.'>Vogueref</th>
						<th '.$storenamestyle.'>Store Name</th>
						<th '.$titlestyle.'>Title</th>
						<th '.$useralphanumericstyle.'>User RefId</th>
						<th '.$fullnamestyle.'>Fullname</th>
						<th '.$usernamestyle.'>Username</th>
						<th '.$phonenumberstyle.'>Phonenumber</th>
						<th '.$emailstyle.'>Email Address</th>
						<th '.$coursegroupsstyle.'>Modules</th>
						<th '.$coursesubjectsstyle.'>Courses</th>
						<th '.$amountpaidstyle.'>Amount Paid(&#8358;)</th>
						<th '.$downloadsstyle.'>Downloads</th>
						<th '.$transactiontimestyle.'>Transaction Time</th>
						<th '.$startdatestyle.'>PaymentDate</th>
						<th '.$voguestatusstyle.'>VogueStatus</th>
						<th '.$vieweditstyle.'>View/Edit</th>
					</tr>
				</thead>
			    <tbody>';
		$bottom='	</tbody>
				</table>';
		$row['chiefquery']=$rowmonitor['chiefquery'];
		$outs=paginatejavascript($rowmonitor['chiefquery']);
		$row['numrows']=$numrows;
		$row['num_pages']=$outs['num_pages'];
		$outsviewer=paginate($rowmonitor['chiefquery']);
		$paginatetop='
		<div id="paginationhold">
			<div class="meneame">
				<input type="hidden" name="curquery" value="'.$rowmonitor['chiefquery'].'"/>
				<input type="hidden" name="outputtype" value="transaction|'.$type.'"/>
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
		$row['catdata']=$catdata;
		return $row;
	}

	//  Export function
	function exportAllTransactions($viewer,$limit,$type){
		$row=array();
		$testit=strpos($limit,"-");
		$testit!==false?$limit="":$limit=$limit;
		if($limit==""){
			$limit="LIMIT 0,15";
		}
		$joiner='';
		$joiner2='';
		$queryorder='ORDER BY id DESC';
		$type==""?$type="all":$type;
		$periodout="All"; //Default excel periodout display for export
		if($type!==""&&$type!=="all"&&is_numeric($type)){
			$joiner='AND typeid='.$type.'';
			$joiner2='WHERE typeid='.$type.'';
		}else if($type!==""&&$type!=="all"&&!is_numeric($type)){
			if($type=="courses"){
				$joiner2="WHERE transactiontype='course'";
				$queryorder='ORDER BY id DESC, status';
			}else if(preg_match('/exportrangecourses/', $type)){
				//explosion variable
				// ymd format for data search delimiter for daterange= ||
				$limit="";
				$phold=explode("exportrangecourses", $type);
				// secondary explosion variable
				$phold2=explode("||", $phold[1]);
				if(count($phold2)>1){
					$datetime1 = $phold2[0]; // specified scheduled time
		    		$datetime2 = $phold2[1];
		    		$time="00:00:00";
		    		$c1=new DateTime("$datetime1 $time");
		    		$c2=new DateTime("$datetime2 $time");
		    		if($c2<$c1){
		    			// compare the dates and sort them if they former is greateer than the latter
		    			$dateh=$datetime1;
		    			$datetime1=$datetime2;
		    			$datetime2=$dateh;
		    		}
		    		$joiner2="WHERE transactiontype='course' AND transactiontime >= '$datetime1' AND transactiontime <= '$datetime2' AND voguestatus='Approved'";
				}
				$periodout=$datetime1." ".$datetime2;
			}else if($type=="exportallcourses"){
				$limit="";
				$joiner2="WHERE voguestatus='Approved'";
			}			
		}
		if($limit==""&&$viewer=="admin"){
			$query="SELECT * FROM transaction $joiner2 $queryorder $limit";
			$rowmonitor['chiefquery']="SELECT * FROM transaction $joiner2 ORDER BY id DESC";
		}elseif($limit!==""&&$viewer=="admin"){
			$query="SELECT * FROM transaction $joiner2 $queryorder $limit";
			$rowmonitor['chiefquery']="SELECT * FROM transaction $joiner2 ORDER BY id DESC";
		}elseif($viewer=="viewer"){
			$limit==""?$limit="LIMIT 0,15":$limit=$limit;
			$query="SELECT * FROM transaction WHERE status='active' $joiner $queryorder $limit";
			$rowmonitor['chiefquery']="SELECT * FROM transaction WHERE status='active' $joiner";	
		}
		$run=mysql_query($query)or die(mysql_error()." ".__LINE__);
		$numrows=mysql_num_rows($run);
		if($numrows>0){

			$adminoutput="";
			$adminoutputtwo="";
			$vieweroutput="";

			require_once 'phpexcel/Classes/PHPExcel.php';
		    $objPHPExcel = new PHPExcel();
		    // initialise setup variable
		     // Set properties
		    $objPHPExcel->getProperties()->setCreator("Max-Migold Administrator")
		                ->setLastModifiedBy("Admin Section User")
		                ->setTitle("Course Transactions List")
		                ->setSubject("Generated on ".date("Y-m-d H:i:s")."")
		                ->setDescription("Document contains Max-Migold Course Transactions information.")
		                ->setKeywords("office 2007 openxml php")
		                ->setCategory("Transactions Files");
		    // $objPHPExcel->getActiveSheet()->setTitle("Course Transactions List");
		    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'UserRefID')
                ->setCellValue('B1', 'Fullname')
                ->setCellValue('C1', 'Username')
                ->setCellValue('D1', 'Email')
                ->setCellValue('E1', 'Phonenumber')
                ->setCellValue('F1', 'Courses')
                ->setCellValue('G1', 'Modules')
                ->setCellValue('H1', 'Total Amount')
                ->setCellValue('I1', 'Time')
                ->setCellValue('J1', 'Payment Status');
            $count=2;
			while($row=mysql_fetch_assoc($run)){

				$outs=getSingleTransaction($row['id']);
				
				$objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A".$count."", "".$outs["useralphanumeric"]."")
                ->setCellValue("B".$count."", "".$outs["fullname"]."")
                ->setCellValue("C".$count."", "".$outs["username"]."")
                ->setCellValue("D".$count."", "".$outs["email"]."")
                ->setCellValue("E".$count."", "".$outs["phonenumber"]."")
                ->setCellValue("F".$count."", "".$outs["coursegroupsexportout"]."")
                ->setCellValue("G".$count."", "".$outs["coursesubjectsexportout"]."")
                ->setCellValue("H".$count."", "".number_format($outs["amountpaid"])."")
                ->setCellValue("I".$count."", "".$outs["transactiontime"]."")
                ->setCellValue("J".$count."", "".$outs["voguestatus"]."");
                
                /*->setCellValue('A'.$count.'', ''.$outs['useralphanumeric'].'')
                ->setCellValue('B'.$count.'', ''.$outs['fullname'].'')
                ->setCellValue('C'.$count.'', ''.$outs['username'].'')
                ->setCellValue('D'.$count.'', ''.$outs['email'].'')
                ->setCellValue('E'.$count.'', ''.$outs['phonenumber'].'')
                ->setCellValue('F'.$count.'', ''.mysql_real_escape_string($outs['coursegroupsexportout']).'')
                ->setCellValue('G'.$count.'', ''.mysql_real_escape_string($outs['coursesubjectsexportout']).'')
                ->setCellValue('H'.$count.'', ''.number_format($outs['amountpaid']).'')
                ->setCellValue('I'.$count.'', ''.$outs['transactiontime'].'')
                ->setCellValue('J'.$count.'', ''.$outs['voguestatus'].'');*/

                $count++;
				
			}
			$objPHPExcel->setActiveSheetIndex(0);
			// require_once 'phpexcel/Classes/PHPExcel/IOFactory.php';
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="Course_Transactions_'.$periodout.'.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;
		}else{
			$row['donout']="There are currently no Approved";
		}
		return $row;
	}

?>