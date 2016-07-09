<?php
	function getSingleFAQ($id){
		global $host_addr;
		$row=array();
		$query="SELECT * FROM faq where id=$id";
		$run=mysql_query($query)or die(mysql_error()." Line 7");
		$numrows=mysql_num_rows($run);
		/*$query2="SELECT * FROM surveys where catid=$typeid";
		$run2=mysql_query($query2)or die(mysql_error()." Line 899");
		$row2=mysql_fetch_assoc($run2);*/

		$row=mysql_fetch_assoc($run);
		$id=$row['id'];
		$name=$row['title'];
		$content=$row['content'];
		$status=$row['status'];

		$row['adminoutput']='
			<tr data-id="'.$id.'">
				<td>'.$name.'</td><td>'.$status.'</td><td name="trcontrolpoint"><a href="#&id='.$id.'" name="edit" data-type="editsinglefaq" data-divid="'.$id.'">Edit</a></td>
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
						<form action="../snippets/edit.php" name="editfaq" method="post">
							<input type="hidden" name="entryvariant" value="editfaq"/>
							<input type="hidden" name="entryid" value="'.$id.'"/>
							<div id="formheader">Edit "'.$name.'"</div>
								<div id="formend">
									Change Faq title <br>
									<input type="text" placeholder="Enter Faq Title" name="title" value="'.$name.'" class="curved"/>
								</div>
								<div id="formend" style="">
									<span style="font-size:18px;">Change Details:</span><br>
									<textarea name="content" id="adminposter" Placeholder="" class="">'.$content.'</textarea>
								</div>
								<div id="formend">
									Change Status<br>
									<select name="status" class="curved2">
										<option value="">Change Status</option>
										<option value="active">Active</option>
										<option value="inactive">Inactive</option>
									</select>
								</div>
							<div id="formend">
								<input type="submit" name="Update" value="Submit" class="submitbutton"/>
							</div>
						</form>
					</div>
					<script>
							tinyMCE.init({
						        theme : "modern",
						        selector: "textarea#adminposter",
						        skin:"lightgray",
						        width:"94%",
						        height:"650px",
						        external_image_list_url : ""+host_addr+"snippets/mceexternalimages.php",
						        plugins : [
						         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
						         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
						         "save table contextmenu directionality emoticons template paste textcolor responsivefilemanager"
						        ],
						        // toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
						        toolbar1: "undo redo | bold italic underline | fontselect fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
						        toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
						        image_advtab: true ,
						        editor_css:""+host_addr+"stylesheets/mce.css?"+ new Date().getTime(),
						        content_css:""+host_addr+"stylesheets/mce.css?"+ new Date().getTime(),
						        external_filemanager_path:""+host_addr+"scripts/filemanager/",
						        filemanager_title:"Adsbounty Admin Blog Content Filemanager" ,
						        external_plugins: { "filemanager" : ""+host_addr+"scripts/filemanager/plugin.min.js"}
							});
							tinyMCE.init({
							        theme : "modern",
							        selector:"textarea#postersmalltwo",
							        menubar:false,
							        statusbar: false,
							        plugins : [
							         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
							         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
							         "save table contextmenu directionality emoticons template paste textcolor responsivefilemanager"
							        ],
							        width:"80%",
							        height:"300px",
							        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
							        toolbar2: "| link unlink anchor | emoticons",
							        image_advtab: true ,
							        editor_css:""+host_addr+"stylesheets/mce.css?"+ new Date().getTime(),
							        content_css:""+host_addr+"stylesheets/mce.css?"+ new Date().getTime(),
									external_filemanager_path:""+host_addr+"scripts/filemanager/",
								   	filemanager_title:"Adsbounty Admin Blog Content Filemanager" ,
								   	external_plugins: { "filemanager" : ""+host_addr+"scripts/filemanager/plugin.min.js"}
							});   
					</script>
		';
		$row['vieweroutput']='
			<a class="accordion-item" href="#">'.$name.'</a>
            <div class="accordion-item-content">
                
                '.$content.'
                
            </div><!-- end .accordion-item-content -->
		';
		return $row;
	}
	function getAllFAQ($viewer,$limit){
		global $host_addr;
		$row=array();
		$testit=strpos($limit,"-");
		$testit!==false?$limit="":$limit=$limit;
		$row=array();
		if($limit!==""&&$viewer=="admin"){
			$query="SELECT * FROM faq order by id desc ".$limit."";
		}else if($limit==""&&$viewer=="admin"){
			$query="SELECT * FROM faq order by id desc LIMIT 0,15";		
		}elseif($limit!==""&&$viewer=="viewer"){
			$query="SELECT * FROM faq WHERE status='active' ".$limit."";
		}else if($limit==""&&$viewer=="viewer"){
			$query="SELECT * FROM faq WHERE status='active'";		
		}
		/*if($typeid=="active"){
			$query="SELECT * FROM faq WHERE status='active'";
		}*/
		$selection="";
		$run=mysql_query($query)or die(mysql_error()." Line 77");
		$numrows=mysql_num_rows($run);
		$top='<table id="resultcontenttable" cellspacing="0">
					<thead><tr><th>Title</th><th>Status</th><th>View/Edit</th></tr></thead>
					<tbody>';
		$bottom='	</tbody>
				</table>';
		$adminoutput="No entries";
		$vieweroutput='No FAQs Yet, Sorry, we are working on it';
		$monitorpoint="";
		if($numrows>0){
			$vieweroutput="";
			$adminoutput="";
		while($row=mysql_fetch_assoc($run)){
		$outvar=getSingleFAQ($row['id']);
		$adminoutput.=$outvar['adminoutput'];
		$vieweroutput.=str_replace("../", "$host_addr",$outvar['vieweroutput']);
		$selection.='<option value="'.$outvar['id'].'">'.$outvar['title'].'</option>';

		}
		}
		$rowmonitor['chiefquery']="SELECT * FROM faq order by id desc";
		$outs=paginatejavascript($rowmonitor['chiefquery']);
		$paginatetop='
		<div id="paginationhold">
			<div class="meneame">
				<input type="hidden" name="curquery" value="'.$rowmonitor['chiefquery'].'"/>
				<input type="hidden" name="outputtype" value="faq"/>
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
		$row['vieweroutput']='
			<div class="accordion">'.$vieweroutput.'</div>	
		';
		$row['selection']=$selection;
		return $row;
	}
?>