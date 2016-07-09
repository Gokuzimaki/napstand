<?php
function getSingleAdvert($advertid){
global $host_addr,$host_target_addr,$bantype;
$row=array();
$query="SELECT * FROM adverts WHERE id=$advertid";
$run=mysql_query($query)or die(mysql_error()." Line 3085");
$row=mysql_fetch_assoc($run);
$pagearr="";
$shortdescarr="";
$shortdescout="";
$shortdescout2="";
isset($bantype)&&$bantype!==""?$bantype=$bantype:$bantype="nothing";
$pwidth=-320;
	$px=30;
	$py=0;
	$pxlink=30;
	$pylink=230;
	$ease1="easeOut";
	$ease2="easeOutExpo";

	if($bantype=="trepid"){
		$pwidth=400;
		$px=50;
		$pxlink=50;
		$pylink=390;
		$ease1="Power4.easeOut";
		$ease1="Power4.easeOutExpo";
	}
// echo $bantype;
$id=$row['id'];
$owner=$row['owner'];
$landingpage=$row['landingpage'];
$advertstyle=$row['style'];
$title=$row['title'];
$type=$row['type'];/*types are subimage or full image */
$shortdesc=$row['miniinfo'];
$fulldesc=$row['maininfo'];
$page=$row['activepage'];
// retrieve list of valid pages for this
$pagearr=explode(";", $page);
$clicks=$row['clicks'];
$status=$row['status'];
 $f1="";
 $f2="";
 $f3="";
 $f4="";
 $f5="";
 $f6="";
 $f7="";
 $f8="";
 $f9="";
 $testit=strpos($page,"all");
 if($testit!==false){
 	$f1='selected="true"';
 }
 $testit=strpos($page,"Home");
 if($testit!==false){
 	$f2='selected="true"';
 }
 $testit=strpos($page,"Portfolio");
 if($testit!==false){
 	$f3='selected="true"';
 }
 $testit=strpos($page,"Blog");
 if($testit!==false){
 	$f4='selected="true"';
 }
 $testit=strpos($page,"About");
 if($testit!==false){
 	$f5='selected="true"';
 }
 $testit=strpos($page,"Audio Channel");
 if($testit!==false){
 	$f6='selected="true"';
 }
 $testit=strpos($page,"Video Channel");
 if($testit!==false){
 	$f7='selected="true"';
 }
$row['adlink']="";
$placie="";
$truelandingpage=$landingpage;
if($landingpage==""){
	$landingpage=$host_addr."adverts.php?id=".$id;
}
	$placie=$host_addr."adverts.php?id=".$id;

$row['adlink']='
	<a href="'.$landingpage.'" class="btn btn-large text-uppercase" target="_blank" title="Click to view.">See more.</a>
';
$linkout='
	<a href="'.$landingpage.'" class="ilny-transparent-btn btn btn-large text-uppercase" target="_blank" title="Click to view.">See more.</a>
';
if($bantype=="trepid"){
$linkout='
<a href="'.$landingpage.'" target="_blank" class="ilny-transparent-btn">See More</a>
';
}
/*style content handling zonme*/
$editstyletwo=0;
$shortdescarr[0]="";
$shortdescarr[1]="";
$shortdescarr[2]="";
$shortdescarr[3]="";
if($advertstyle=="styletwo"){
	$shortdescarr=explode("|",$shortdesc);
	$editstyletwo='style="display:block;"';
	$f8='selected="true"';
	$posxarr[]="$px";

	$posyarr[]="30";
	$posspeedarr[]="1000";
	$posstartarr[]="1800";

	$posxarr[]="$px";
	$posyarr[]="100";
	$posspeedarr[]="1000";
	$posstartarr[]="2200";

	$posxarr[]="$px";
	$posyarr[]="170";
	$posspeedarr[]="1000";
	$posstartarr[]="2700";

	$posxarr[]="$px";
	$posyarr[]="240";
	$posspeedarr[]="1500";
	$posstartarr[]="3200";
	$count=0;
	$arcount=count($shortdescarr);
foreach($shortdescarr as $outit){
	$shortdescout==""?$shortdescout=$outit:$shortdescout.="<br>".$outit;
	$shortdescout2.='
		<div class="caption title-2 lfl"
             data-x="'.$posxarr[$count].'"
             data-y="'.$posyarr[$count].'"
             data-speed="'.$posspeedarr[$count].'"
             data-start="'.$posstartarr[$count].'"
             data-easing="easeOutExpo">
			 '.$outit.'
        </div>
	';
	$count++;
}
}else{
	$shortdescout=$shortdesc;
	$pwidth=-320;
	if($bantype=="trepid"){
		$pwidth=400;
	}
	$shortdescout2='
		<div class="caption title sft"
             data-x="'.($px-0).'"
             data-y="10"
             data-speed="1000"
             data-start="1500"
             data-width="'.$pwidth.'"
             data-easing="'.$ease1.'">
             '.$title.'                              
        </div>
        
        <div class="caption text"
             data-x="'.($px-0).'"
             data-y="100"
             data-speed="1000"
             data-start="2000"
             data-easing="'.$ease1.'">
             '.$shortdesc.'                            
        </div>
        <div class="caption sfb"
             data-x="'.$pxlink.'"
             data-y="'.$pylink.'"
             data-speed="1000"
             data-start="2500"
             data-easing="'.$ease1.'">
             '.$linkout.'                           
        </div>
	';
}

// $page=="fc"?$typeout="Frontiers Consulting":($page=="pfn"?$typeout="Project Fix Nigeria":($page=="csi"?$typeout="Christ Society International Outreach":($page=="fs"?$typeout="Frankly Speaking With Muyiwa Afolabi":($page=="all"?$typeout="All Blog Pages":$typeout=""))));
//get complete cover images;
$imgid=0;
$mediaquery="SELECT * FROM media WHERE ownerid=$id AND ownertype='advert' AND maintype='$type' AND status='active' ORDER BY id DESC";
$mediarun=mysql_query($mediaquery)or die(mysql_error()." Line 3092");
$medianumrows=mysql_num_rows($mediarun);

$count=0;
$cover="";
$cover2="";
$cover3="";
if($medianumrows>0){
$mediarow=mysql_fetch_assoc($mediarun);
$imgid=$mediarow['id'];
		$maincoverphoto=$mediarow['location'];
		$subcoverphoto=$mediarow['details'];

}else{
	$imgid=0;
	$maincoverphoto="./images/defadbanpgback.jpg";
	$subcoverphoto="./images/defadbanpgback.jpg";
}
$editbantwo="";
	# code...
	if($type=="banneradvertone"||$type=="banneradverttwo"||$type=="miniadvert"){
$cover='<img src="'.$host_addr.''.$maincoverphoto.'" name="advert" alt="title" data-id="'.$id.'"/>';
	
if($type=="banneradverttwo"){
	$editbantwo='style="display:block;"';

	$cover3='<img src="'.$host_addr.''.$subcoverphoto.'" name="advert" data-id="'.$id.'"/>';
	$cover2='
		<li data-transition="fade">                   
        '.$cover.'
        
        <div class="caption fade"
             data-x="'.($px+505).'"
             data-y="10"
             data-speed="1000"
             data-start="1300"
             data-easing="'.$ease1.'">
             '.$cover3.'                              
        </div>
        '.$shortdescout2.'

			</li>
	';
}elseif($type=="banneradvertone"){
$cover2='
	<li data-transition="slidedown">
        '.$cover.'
        
        <div class="caption bg fade"
             data-x="'.($px-10).'"
             data-y="10"
             data-speed="1000"
             data-start="1000"
             data-easing="'.$ease1.'">                                 
        </div>
        
        <div class="caption title sft"
             data-x="'.($px-0).'"
             data-y="10"
             data-speed="1000"
             data-start="1500"
             data-width="440"
             data-easing="'.$ease1.'">
             '.$title.'                              
        </div>
        
        <div class="caption text"
             data-x="'.($px-0).'"
             data-y="100"
             data-speed="1000"
             data-start="2000"
             data-easing="'.$ease1.'">
             '.$shortdescout.'                            
        </div>
        
        <div class="caption sfb"
             data-x="'.$pxlink.'"
             data-y="'.$pylink.'"
             data-speed="1000"
             data-start="2500"
             data-easing="'.$ease1.'">
             '.$linkout.'                           
        </div>
	</li>
';
}elseif ($type=="miniadvert") {
	# code...
	$cover2='
		<div id="adcontentholdshort">
			<p class="contentholdertitle-2">'.$title.'</p>
			<div class="blogminihold">
				<div class="blogminiimghold">
					'.$cover.'
				</div>
				<div class="adtextcontenthold">
					<div class="adtextcontent">'.$shortdescout.'</div>
					<div class="blogminilinkhold">'.$linkout.'</div>
				</div>
			</div>
			
		</div>
	';
}
	}elseif ($type=="videoadvert") {
		# code...
$cover='
	<video title="" id="example_video_1" class="video-js vjs-default-skin" controls preload="true" width="" height="150px" poster="" data-setup="{}">
		<source src="'.$host_addr.''.$maincoverphoto.'"/>
	</video>
';
$cover2='
	<div id="adcontentholdshort" name="videoadvert">
		'.$title.'<br>
		'.$cover.'
	</div>
';
	}
$row['adminoutput']='
	<tr data-id="'.$id.'">
		<td>'.$cover.'</td><td>'.$type.'</td><td>'.$title.'</td><td>'.str_replace(";", " ", $page).'</td><td>'.$shortdescout.'</td><td>'.$linkout.'</td><td>'.$clicks.'</td><td>'.$status.'</td><td name="trcontrolpoint"><a href="#&id='.$id.'" name="edit" data-type="editsingleadvert" data-divid="'.$id.'">Edit</a></td>
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
$out1=$advertstyle=="styletwo"?" ":$shortdesc;
$out2= isset($shortdescarr[0])&&$shortdescarr[0]!==""?$shortdescarr[0]:"";
$out3= isset($shortdescarr[1])&&$shortdescarr[1]!==""?$shortdescarr[1]:"";
$out4= isset($shortdescarr[2])&&$shortdescarr[2]!==""?$shortdescarr[2]:"";
$out5= isset($shortdescarr[3])&&$shortdescarr[3]!==""?$shortdescarr[3]:"";
$row['adminoutputtwo']='
	<script src="'.$host_addr.'scripts/js/tinymce/jquery.tinymce.min.js"></script>
	<script src="'.$host_addr.'scripts/js/tinymce/tinymce.min.js"></script>
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
		        filemanager_title:"Bayonle Arashi\'s Admin Blog Content Filemanager" ,
		        external_plugins: { "filemanager" : ""+host_addr+"scripts/filemanager/plugin.min.js"}
		});
	</script>
	<div id="form" style="background-color:#fefefe;">
		<form action="../snippets/edit.php" name="editadvertform" method="post" enctype="multipart/form-data">
			<input type="hidden" name="entryvariant" value="editadvert"/>
			<input type="hidden" name="entryid" value="'.$id.'"/>
			<input type="hidden" name="imgid" value="'.$imgid.'"/>
			<div id="formheader">Edit '.$title.'</div>
						<div id="formend">
								Advert Page *<br>
								<select name="advertpage[]" multiple="multiple" class="curved2">
									<option value="all" '.$f1.'>All Website Pages</option>
									<option value="Home" '.$f2.'>Home</option>
									<option value="Portfolio" '.$f3.'>Portfolio</option>
									<option value="Blog" '.$f4.'>Blog</option>
									<option value="About" '.$f5.'>About</option>
									<option value="Audio Channel" '.$f6.'>Audio Channel</option>
									<option value="Video Channel" '.$f7.'>Video Channel</option>
								</select>
						</div>
						<div id="formend" style="display:none;">
								Advert owner<br>
								<input type="text" name="advertowner" Placeholder="'.$owner.'" class="curved"/>
						</div>
						<div id="formend">
								Advert title (Make this short and descriptive)<br>
								<input type="text" name="adverttitle" Placeholder="The advert title." value="'.$title.'" class="curved"/>
						</div>
						<div id="formend">
								Advert Landing Page<br>
								<input type="text" name="advertlandingpage" Placeholder="'.$placie.'" value="'.$truelandingpage.'" class="curved"/>
						</div>
						<div id="formend">
							Advert Image<!--/ File(Video file less than 15MB please in mp4 format) --> <br>
							<input type="file" placeholder="Choose image" name="profpic" class="curved"/>
						</div>
						<div id="formend" data-name="banneradverttwo" '.$editbantwo.'>
							<p class="forcecover3">'.$cover3.'</p><br>
							Advert Image Two<!--/ File(Video file less than 15MB please in mp4 format) --> *<br>
							<input type="file" placeholder="Choose image" name="profpic2" class="curved"/>
						</div>
						<div id="formend">
							Text Output style(hover your mouse on any of the styles displayed to read more info)<br>
							<select name="advertstyletype" class="curved2">
								<option value="styleone" title="This is the default style, it involves only the introductory text and main information">Text Style One</option>
								<option value="styletwo" '.$f8.' title="This style type allows four text entries, these entries are displayed for the advert in a simple sequential order, useful for delivering \n brief but powerful information">Text Style Two</option>
							</select>
						</div>
						<div id="formend" data-name="styleone">
							Advert Short Description *<br>
							<textarea name="shortdesc" Placeholder="A short description of the advert" class="curved3">'.$out1.'</textarea>
						</div>
						<div id="formend" data-name="styletwo" '.$editstyletwo.'>
							Style two text(Use short and concise words or sentences, endeavour to check the display out on the website to see how best you can edit or present the text)<br>
								<input type="text" name="styletwo1" Placeholder="Text One." value="'.$out2.'" class="curved"/><br>
								<input type="text" name="styletwo2" Placeholder="Text Two."  value="'.$out3.'" class="curved"/><br>
								<input type="text" name="styletwo3" Placeholder="Text Three" value="'.$out4.'" class="curved"/><br>
								<input type="text" name="styletwo4" Placeholder="Text Four." value="'.$out5.'" class="curved"/><br>

						</div>
						<div id="formend">
							<span style="font-size:18px;">The Advert Complete Content*:</span><br>
							<textarea name="fulldesc" id="adminposter" Placeholder="" class="curved3">'.$fulldesc.'</textarea>
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
				<input type="submit" name="updateadvert" value="Update" class="submitbutton"/>
			</div>
		</form>
	</div>
';
$row['file']=$cover;
$row['filepath']=$host_addr.$maincoverphoto;
$row['filepath2']=$host_addr.$subcoverphoto;
$row['vieweroutput']=$cover2;

return $row;
}
function getAllAdverts($viewer,$limit,$type,$page){
$row=array();
$testit=strpos($limit,"-");
$testit!==false?$limit="":$limit=$limit;
$joiner="";
$spectype=explode(";",$page);
$specout="";
foreach($spectype as $adcat){
  $specout==""?$specout=" OR activepage LIKE '%".$adcat."%' AND type LIKE '%$type%'":$specout.=" OR activepage LIKE '%".$adcat."%' AND type LIKE '%$type%'";
}
if($type!=="" AND $page==""){
$joiner="AND type LIKE '%$type%'";
$joiner2="WHERE type LIKE '%$type%'";
}elseif($type=="" AND $page!==""){
$joiner="AND activepage LIKE '%$page%' $specout";
$joiner2="WHERE activepage LIKE '%$page%' $specout";
}elseif($type!=="" AND $page!==""){
$joiner="AND type LIKE '%$type%' AND activepage LIKE '%$page%' $specout";
$joiner2="WHERE type LIKE '%$type%' AND activepage LIKE '%$page%' $specout";
}
if($limit==""&&$viewer=="admin"){
$query="SELECT * FROM adverts $joiner2 ORDER BY id DESC LIMIT 0,15";
$rowmonitor['chiefquery']="SELECT * FROM adverts $joiner2 ORDER BY id DESC";
}elseif($limit!==""&&$viewer=="admin"){
$query="SELECT * FROM adverts $joiner2 ORDER BY id DESC $limit";
$rowmonitor['chiefquery']="SELECT * FROM adverts $joiner2 ORDER BY id DESC";
}elseif($viewer=="viewer"){
$query="SELECT * FROM adverts WHERE status='active' $joiner ORDER BY id DESC";
$rowmonitor['chiefquery']="SELECT * FROM adverts WHERE status='active' $joiner";	
}
// echo $query;
$run=mysql_query($query)or die(mysql_error()." Line 4526");
$numrows=mysql_num_rows($run);
$adminoutput="<td colspan=\"100%\">No entries</td>";
$adminoutputtwo="";
$vieweroutput='<font color="#fefefe">This space is free for your adverts, contact us for more information</font>';
$vieweroutputtwo='<font color="#fefefe">This space is free for your adverts, contact us for more information</font>';
if($numrows>0){
$adminoutput="";
$adminoutputtwo="";
$vieweroutput="";
while($row=mysql_fetch_assoc($run)){
$outs=getSingleAdvert($row['id']);
$adminoutput.=$outs['adminoutput'];
$adminoutputtwo.=$outs['adminoutputtwo'];
$vieweroutput.=$outs['vieweroutput'];
}

}
$top='<table id="resultcontenttable" cellspacing="0">
			<thead><tr><th>Content</th><th>Type</th><th>Title</th><th>Pages</th><th>Short Decription</th><th>LandingPage</th><th>Views</th><th>status</th><th>View/Edit</th></tr></thead>
			<tbody>';
$bottom='	</tbody>
		</table>';
	$row['chiefquery']=$rowmonitor['chiefquery'];
$testq=strpos($rowmonitor['chiefquery'],"%'");
  if($testq===0||$testq===true||$testq>0){
// $rowmonitor['chiefquery']=str_replace("%","%'",$rowmonitor['chiefquery']);
  }
$outs=paginatejavascript($rowmonitor['chiefquery']);
$outsviewer=paginate($rowmonitor['chiefquery']);
$paginatetop='
<div id="paginationhold">
	<div class="meneame">
		<input type="hidden" name="curquery" value="'.$rowmonitor['chiefquery'].'"/>
		<input type="hidden" name="outputtype" value="advert;'.$type.';'.$page.'"/>
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
$row['vieweroutput']=$vieweroutput;
$row['vieweroutputbanner']='
	<div class="row">
    			<div class="fullwidthbanner-container" id="home">
                    <div class="fullwidthbanner">
                        <ul>
'.$vieweroutput.'
	</ul>
	</div>
	</div>
	</div>
';

return $row;
}
?>