<?php
function writeRssData($blogid,$blogcatid){
	$row=array();
	if($blogid!==""&&$blogid>0){
		$outs=getSingleBlogType($blogid);
		$feedpath="../feeds/rss/".$outs['rssname'].".xml";
		$query="SELECT * FROM rssentries WHERE blogtypeid=$blogid order by id desc";
		$query2="SELECT * FROM rssheaders WHERE blogtypeid=$blogid";
	}elseif ($blogcatid!==""&&$blogcatid>0) {
		# code...
		$outs=getSingleBlogCategory($blogcatid);
		$feedpath="../feeds/rss/".$outs['rssname'].".xml";
		$blogmainid=$outs['blogtypeid'];
		$outs=getSingleBlogType($blogmainid);
		$query="SELECT * FROM rssentries WHERE blogcategoryid=$blogcatid order by id desc";
		$query2="SELECT * FROM rssheaders WHERE blogcatid=$blogcatid";
	}else{
		return false;
	}
	$run=mysql_query($query)or die(mysql_error()." Line 896");
	$numrows=mysql_num_rows($run);
	$run2=mysql_query($query2)or die(mysql_error()." Line 897");
	$numrows2=mysql_num_rows($run2);
	$feedentries="";
	if($numrows2>0){
		$row2=mysql_fetch_assoc($run2);
		$header=stripslashes($row2['headerdetails']);
		$footer=$row2['footerdetails'];
	}
	if($numrows>0){
	//get rss entries
	while ($row=mysql_fetch_assoc($run)) {
		# code...
		$feedentries.=stripslashes($row['rssentry']);
	}

	}
	if ($numrows>0||$numrows2>0) {
		# code...
	$content=$header.$feedentries.$footer;
	// echo $content;
	$handle=fopen($feedpath,"w");
	fwrite($handle,$content);
	fclose($handle);
	}
	return $row;
}

function sendSubscriberEmail($blogpostid){
  global $host_addr,$host_target_addr,$host_email_addr,$host_email_send;
$outs=getSingleBlogEntry($blogpostid);
$blogtypeid=$outs['blogtypeid'];
$blogcategoryid=$outs['blogcatid'];
 $blogtypename=$outs['blogtypename'];
$blogcatname=$outs['blogcatname'];
 $query="SELECT * FROM subscriptionlist WHERE blogtypeid=$blogtypeid AND status='active'";
 $query2="SELECT * FROM subscriptionlist WHERE blogcatid=$blogcategoryid AND status='active'";
 $run=mysql_query($query)or die(mysql_error()." Line 929");
 $run2=mysql_query($query2)or die(mysql_error()." Line 930");
$numrows=mysql_num_rows($run);
$numrows2=mysql_num_rows($run2);
$coverphoto=$outs['absolutecover'];
$y=date('Y');
$mail = new PHPMailer;
$mail->Mailer='smtp';
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'relay-hosting.secureserver.net';
$mail->Username = 'no-reply@adsbounty.com';
$mail->Password = 'noreply';
$mail->From = ''.$host_email_addr.'';
$mail->FromName = 'Adsbounty website';
// echo $numrows."<br>the numrows";

$message='
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	 <head>
	  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	  <title>Adsbounty | '.stripslashes($outs['title']).'</title>
	  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>
	<style type="text/css">
	  body{
	    margin: 0; padding: 0; background-color:#fff;font-family: \'Microsoft Tai Le\';
	  }
	  table{
	    border:0px;
	    width:100%;
	  }
	  tbody{
	    max-width: 1170px;  position: relative;  display: block;  margin: auto;  text-align: center;
	  }
	  tr{
	    display: block;  width: 100%;  text-align: center;
	  }
	  td{
	    display:block;
	    overflow: hidden;
	  }
	  .heading{
	    text-align: center;border:0px; font-size: 32px;color: #c0c0c0;
	  }
	  .heading2{
	    font-size: 22px;text-align: center;color:#606893;border: 0px;border-bottom: 1px solid #979797;
	  }
	  .content{
	    font-size:13px;border: 0px;border-bottom: 1px solid #979797;  MAX-WIDTH: 640px;
	  }
	  .minifoot{
	    border: 0px;border-bottom: 1px solid #979797;font-size: 12px;
	  }
	  .footing{
	      text-align: center;
	  font-size: 13px;
	  background: #373737;
	  color: #FFFFFF;
	  }
	  #sociallinks{
	    position: relative;
	    min-height: 68px;
	    width: auto;
	    /* padding-bottom: 4px; */
	    /* border: 1px solid white; */
	    top: 30px;
	    margin-bottom: 30px;
	    left: 0px;
	    z-index: 15;
	    -webkit-transition: all 0.5s;
	    -moz-transition: all 0.5s;
	    -ms-transition: all 0.5s;
	    -o-transition: all 0.5s;
	    transition: all 0.5s;
	  }
	  #sociallinks:hover{
	  /*right: 2px;*/
	  }
	  #socialholder{
	    position: relative;
	    width: 34px;
	    height: 34px;
	    display: inline-block;
	    margin-top: 8px;
	  }
	</style>
	<body>
	 <table cellpadding="0" cellspacing="0">
	  <tbody>
	  <tr>
	   <td class="heading">
	   	<img src="'.$host_addr.'images/adsbounty3.png"  alt="Adsbounty" width="220" height="206" style="display: inline-block;" /><br>
	    A new blog post in '.$blogtypename.' Blog
	   </td>
	 </tr>
	  <tr>
	   <td class="heading2">
	    '.stripslashes($outs['title']).'
	   </td>
	  </tr>
	  <tr>
	   <td class="content">
	    <img src="'.$coverphoto.'" height="112px"style="float:left;"/>'.stripslashes($outs['introparagraph']).'
	   </td>
	  </tr>
	  <tr>
	   <td class="minifoot">
	    <div id="sociallinks">
	      <div id="socialholder" name="socialholdfacebook"><a href="##" target="_blank"><img src="'.$host_addr.'images/Facebook-Icon.png" alt="Facebook" class="total"/></a></div>
	      <div id="socialholder" name="socialholdlinkedin"><a href="##" target="_blank"><img src="'.$host_addr.'images/Linkedin-Icon.png" alt="LinkedIn" class="total"/></a></div>
	      <div id="socialholder" name="socialholdtwitter"><a href="##" target="_blank"><img src="'.$host_addr.'images/Twitter-Icon.png" alt="Twitter" class="total"/></a></div>
	      <div id="socialholder" name="socialholdgoogleplus"><a href="##" target="_blank"><img src="'.$host_addr.'images/google-plus-icon.png" alt="Google+" class="total"/></a></div>
	      <div id="socialholder" name="socialholdyoutube"><a href="##" target="_blank"><img src="'.$host_addr.'images/YouTube-Icon.png" alt="YouTube" class="total"/></a></div>
	    </div>
		    Posted under '.$blogcatname.', on '.$outs['entrydate'].' 
			<a href="'.$host_addr.'blog/?p='.$outs['id'].'" target="_blank" title="Continue reading this post">Continue Reading</a>

	   </td>
	  </tr>
	 <tr>
	    <td class="footing">
	        &copy; Adsbounty '.$y.' Developed by Okebukola Olagoke.<br>
			<a href="'.$host_target_addr.'unsubscribe.php?t=1&tp='.$blogtypeid.'" style="color: #FD9D9D;">Unsubscribe</a>
	    </td>
	 </tr>
	</tbody>
	 </table>
	</body>
	</html>

';
$mail->WordWrap = 50;
$mail->isHTML(true);

$mail->Subject = ''.stripslashes($outs['title']).'';
$mail->Body    = ''.$message.'';
$mail->AltBody = 'A new blog post from the Adsbounty website\n
'.stripslashes($outs['title']).'
Please visit '.$outs['pagelink'].' or '.$host_target_addr.'unsubscribe.php?t=1&tp='.$blogtypeid.'" to unsubscribe.
';
if($numrows>0){
  $count=0;
  //try to break the emails into packets of 300
while($row=mysql_fetch_assoc($run)){
$userid=$row['id'];
$useremail=$row['email'];
/* if($count>0){
$mail->addBCC(''.$useremail.'');
}else{*/
$mail->AddAddress(''.$useremail.'');
// }
//send the email to th
if($count==10){
if($host_email_send===true){ 
if(!$mail->send()) {
  die('Message could not be sent.'. $mail->ErrorInfo);
/*   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;*/
   // exit;
}else{
}
}
$mail->ClearAllRecipients(); // reset the `To:` list to empty
$count=-1;
}
$count++;
}
if($count<10){
if($host_email_send===true){ 
if(!$mail->send()) {
  die('Message could not be sent.'. $mail->ErrorInfo);
/*   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;*/
   // exit;
}
}
}

}


}
function getSingleBlogType($blogtypeid){
	global $host_addr,$host_target_addr;
	$query="SELECT * FROM blogtype where id=$blogtypeid";
	$row=array();
	$run=mysql_query($query)or die(mysql_error()." Line 926");
	$numrows=mysql_num_rows($run);
	/*$query2="SELECT * FROM rssheaders where blogtypeid=$blogtypeid";
	$run2=mysql_query($query2)or die(mysql_error()." Line 899");
	$row2=mysql_fetch_assoc($run2);*/

	$row=mysql_fetch_assoc($run);
	$id=$row['id'];
	$name=$row['name'];
	$foldername=$row['foldername'];
	$description=$row['description'];
	$status=$row['status'];

	$row['adminoutput']='
	<tr data-id="'.$id.'">
		<td>'.$name.'</td><td>'.$foldername.'</td><td>'.$description.'</td><td>'.$status.'</td><td name="trcontrolpoint"><a href="#&id='.$id.'" name="edit" data-type="editsingleblogtype" data-divid="'.$id.'">Edit</a></td>
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
					<form action="../snippets/edit.php" name="editblogtype" method="post">
						<input type="hidden" name="entryvariant" value="editblogtype"/>
						<input type="hidden" name="entryid" value="'.$id.'"/>
						<div id="formheader">Edit '.$name.'</div>
							<div id="formend">
								Change Blog Name <br>
								<input type="text" placeholder="Enter Blog Name" name="name" class="curved"/>
							</div>
							<div id="formend">
								Blog Description *<br>
								<textarea name="description" placeholder="Enter Blog Description" class="" value="'.$description.'" class=""></textarea>
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
	';
	return $row;
}

function getAllBlogTypes($viewer,$limit){
	global $host_addr,$host_target_addr;
  $testit=strpos($limit,"-");
$testit!==false?$limit="":$limit=$limit;
$row=array();
	if($limit!==""&&$viewer=="admin"){
$query="SELECT * FROM blogtype order by id desc ".$limit."";
	}else if($limit==""&&$viewer=="admin"){
$query="SELECT * FROM blogtype order by id desc LIMIT 0,15";		
	}/*elseif($limit!==""&&$viewer=="viewer"){
$query="SELECT * FROM blogtype ".$limit." order by id desc";
	}else if($limit==""&&$viewer=="viewer"){
$query="SELECT * FROM blogtype order by id desc";		
	}*/
$selection="";
$run=mysql_query($query)or die(mysql_error()." Line 998");
$numrows=mysql_num_rows($run);
$top='<table id="resultcontenttable" cellspacing="0">
			<thead><tr><th>Name</th><th>FolderName</th><th>Description</th><th>Status</th><th>View/Edit</th></tr></thead>
			<tbody>';
$bottom='	</tbody>
		</table>';
$adminoutput="";
$monitorpoint="";
if($numrows>0){
while($row=mysql_fetch_assoc($run)){
$outvar=getSingleBlogType($row['id']);
$adminoutput.=$outvar['adminoutput'];
$selection.='<option value="'.$outvar['id'].'">'.$outvar['name'].'</option>';

}
}
$rowmonitor['chiefquery']="SELECT * FROM blogtype order by id desc";
$outs=paginatejavascript($rowmonitor['chiefquery']);
$paginatetop='
<div id="paginationhold">
	<div class="meneame">
		<input type="hidden" name="curquery" value="'.$rowmonitor['chiefquery'].'"/>
		<input type="hidden" name="outputtype" value="blogtype"/>
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
return $row;
}
function getSingleBlogCategory($blogtypeid){
	global $host_addr,$host_target_addr;
$query="SELECT * FROM blogcategories WHERE id=$blogtypeid";
$run=mysql_query($query)or die(mysql_error()." Line 799");
$numrows=mysql_num_rows($run);
$row=array();
if($numrows>0){
$row=mysql_fetch_assoc($run);
$id=$row['id'];
$blogtypeid=$row['blogtypeid'];
$catname=$row['catname'];
$subtext=$row['subtext'];
$status=$row['status'];
$outs=getSingleBlogType($blogtypeid);
$postquery="SELECT * FROM blogentries WHERE blogcatid=$id AND status='active' order by id desc";
$postrun=mysql_query($postquery)or die(mysql_error()." Line 1594");
$postcount=mysql_num_rows($postrun);
$postcountmain=$postcount;
if($postcount>1000){
$postcountmain=$postcount/1000;
$postcountmain=round($postcountmain, 0, PHP_ROUND_HALF_UP);
$postcountmain=$postcountmain."K";
}elseif ($postcount>1000000) {
	# code...
	$postcountmain=$postcount/1000000;
$postcountmain=round($postcountmain, 0, PHP_ROUND_HALF_UP);
$postcountmain=$postcountmain."M";
}
$subtextout="";
$coverout="";
}
$row['completeoutput']='
<div id="bloghold">
Sorry but there is no entry here.
</div>
';
$row['pfncatminoutput']="";
if($outs['name']=="Project Fix Nigeria"||$outs['name']=="Frankly Speaking Africa"){
//for page type latest post content
	$theme=array();
	$theme[]="pfntoppurple";
	$theme[]="pfntoporange";
	$theme[]="pfntopred";
	$theme[]="pfntopblue";
	$theme[]="pfntopgreen";
	$theme[]="pfntopyellow";
$random=rand(0,5);
$curtheme=$theme[$random];
$curtheme2="";
$cattotquery="SELECT * FROM blogcategories WHERE blogtypeid=$blogtypeid AND status='active' order by id desc";
$cattotrun=mysql_query($cattotquery)or die(mysql_error()." Line 1629");
$catcurcount=mysql_num_rows($cattotrun);
$catrowouts=array();
$count=0;
if($catcurcount>0){
while($cattotrow=mysql_fetch_assoc($cattotrun)){
$catrowouts[]=$cattotrow['id'];
if($count<6){
if($id==$cattotrow['id']){
$curtheme2=$theme[$count];
}
$count++;
}else{
	$count=0;
	if($id==$cattotrow['id']){
$random2=rand(0,5);		
$curtheme2=$theme[$random2];
}
$count++;
}
}
}
	//for miniature type previous posts
$pfncattop='<div id="bottomcatdetailhold">
				<a href="'.$host_addr.'category.php?cid='.$id.'" data-id="cattitle" title="'.$subtext.'">'.$catname.'</a>';
$pfncattopentries='<div id="microbloghold">No posts under this yet.</div>';
$pfncatbottom="</div>";
$catmainpost='
<div id="bloghold">
Sorry but there is no entry here.
</div>
';
if($postcount>0){
$count=0;
	$pfncattopentries="<div id=\"microbloghold\">No extra posts here</div>";
while ($postrows=mysql_fetch_assoc($postrun)) {
	# code...
$postid=$postrows['id'];
$postdata=getSingleBlogEntry($postid);
if($count==0){
$catmainpost=$postdata['vieweroutput'];
}
if($count>0&&$count<6){
$pfncattopentries=="<div id=\"microbloghold\">No extra posts here</div>"?$pfncattopentries="":$testpfn="holding";
$introparagraph=stripslashes($postdata['introparagraph']);
$headerdescription = convert_html_to_text($introparagraph);
$headerdescription=html2txt($headerdescription);
$monitorlength=strlen($headerdescription);
$headerminidescription=$headerdescription;
$pfncattopentries.='
	<a href="'.$postdata['pagelink'].'"title="'.$headerminidescription.'"><div id="microbloghold">'.$postdata['title'].'<br><span class="microblogdatehold">'.$postdata['entrydate'].'</span> <span class="microblogviewcommenthold">Views: '.$postdata['views'].' <img src="./images/comments.png"/> <font color="orange">'.$postdata['commentcount'].'</font></span></div></a>
';	
}
$count++;
}
}
$pfncatmindispcontent=$pfncattop.$pfncattopentries.$pfncatbottom;
$row['pfncatminoutput']=$pfncatmindispcontent;
$mediaquery="SELECT * FROM media WHERE ownerid=$id AND ownertype='blogcategory' AND maintype='original'";
$mediarun=mysql_query($mediaquery)or die(mysql_error()." Line 1683");
$mediarow=mysql_fetch_assoc($mediarun);
/*echo $mediaquery;
echo $mediarow['location']."here";*/
$row['profpic']=$mediarow['location'];
$row['profpicid']=$mediarow['id'];
if($mediarow['id']>0){
$coverphoto='<img src=".'.$mediarow['location'].'" title="'.$catname.'"/>';
}else{
  $coverphoto="";
}
$postcount==1?$s="":$s='s';

$pfnmaincattop='
<div id="pfndisplayhold" name="'.$curtheme2.'" data-id="'.$id.'">
	<div id="pfnprevcatcontent" title="Click to see the latest post under "'.$catname.'"" data-targetid="'.$id.'" data-state="inactive">
		<img src="'.$mediarow['location'].'"/>
		<div id="postcounthold">
			'.$postcountmain.'<br>
			Post'.$s.'.
		</div>
		<div id="pfnprevcatcontentdetailsmini">'.$row['subtext'].'</div>
		<div id="pfnprevcatcontentdetails">'.$catname.'</div>
	</div>
	<div id="pfnlatestposthold" data-value="'.$id.'">
';
$pfnmaincatentry='
'.$catmainpost.'
';	
$pfnmaincatbottom='
	</div>
</div>
';
$row['completeoutput']=$pfnmaincattop.$pfnmaincatentry.$pfnmaincatbottom;
$coverout='<td>'.$coverphoto.'</td>';
$subtext='<td>'.$row['subtext'].'</td>';
$subtextout='
<div id="formend">
	Change Sub text<br>
	<input type="text" placeholder="'.$row['subtext'].'" name="subtext" class="curved"/>
</div>
<div id="formend">
	Change Image<br>
	<input type="file" name="profpic" class="curved"/>
</div>
';
}
$catnamelength=strlen($catname);
$catnamemini=$catname;
if($catname>48){
$catnamemini=substr($catname,0,45)."...";
}
$row['linkout']='<a href="'.$host_addr.'category.php?cid='.$id.'" title="Click to view the category '.$catname.'">'.$catnamemini.'</a>';
$row['linkouttwo']='<li class="cat-item"><a href="'.$host_addr.'category.php?cid='.$id.'" title="Click to view the category '.$catname.'">'.$catnamemini.'</a></li>';
$row['adminoutput']='
	<tr data-id="'.$id.'">
		'.$coverout.'<td>'.$outs['name'].'</td><td>'.$catname.'</td>'.$subtext.'<td>'.$postcount.'</td><td>'.$status.'</td><td name="trcontrolpoint"><a href="#&id='.$id.'" name="edit" data-type="editsingleblogcategory" data-divid="'.$id.'">Edit</a></td>
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
				<form action="../snippets/edit.php" name="editblogcategory" method="post" enctype="multipart/form-data">
					<input type="hidden" name="entryvariant" value="editblogcategory"/>
					<input type="hidden" name="entryid" value="'.$id.'"/>
					<div id="formheader">Edit '.$catname.'</div>
						<div id="formend">
							Change Category Name<br>
							<input type="text" placeholder="'.$catname.'" name="name" class="curved"/>
						</div>
						'.$subtextout.'
						<div id="formend">
							Change Status<br>
							<select name="status" class="curved2">
								<option value="">Change Status</option>
								<option value="active">Active</option>
								<option value="inactive">Inactive</option>
							</select>
						</div>
					<div id="formend">
						<input type="submit" name="updateblogcategory" value="Update" class="submitbutton"/>
					</div>
				</form>
			</div>
';
$row['pfnpageout']='';
return $row;
}
function getAllBlogCategories($viewer,$limit,$blogtypeid){
	global $host_addr,$host_target_addr;
  	$testit=strpos($limit,"-");
	$testit!==false?$limit="":$limit=$limit;
	if($limit!==""&&$viewer=="admin"){
		$query="SELECT * FROM blogcategories WHERE blogtypeid=$blogtypeid order by id desc ".$limit."";
		$rowmonitor['chiefquery']="SELECT * FROM blogcategories WHERE blogtypeid=$blogtypeid order by id desc";
	}else if($limit==""&&$viewer=="admin"){
		$query="SELECT * FROM blogcategories WHERE blogtypeid=$blogtypeid order by id desc LIMIT 0,15";		
		$rowmonitor['chiefquery']="SELECT * FROM blogcategories WHERE blogtypeid=$blogtypeid order by id desc";
	}else if($viewer=="viewer"){
		$query="SELECT * FROM blogcategories where blogtypeid=$blogtypeid and status='active' order by id desc";		
		$rowmonitor['chiefquery']="SELECT * FROM blogcategories WHERE blogtypeid=$blogtypeid and status='active' order by id desc";
	}
	$row=array();
	$selection="";
	$run=mysql_query($query)or die(mysql_error()." Line 1156");
	$numrows=mysql_num_rows($run);
	$adminoutput="";
	$monitorpoint="";
	$outs=getSingleBlogType($blogtypeid);
	$coverout="";
	$subtext="";
	if($outs['name']=="Project Fix Nigeria"||$outs['name']=="Frankly Speaking Africa"||$outs['id']==3){
		$coverout='<th>Cover Image</th>';		
		$subtext='<th>Subtext</th>';		

	}

	$top='<table id="resultcontenttable" cellspacing="0">
			<thead><tr>'.$coverout.'<th>Blogtype</th><th>Category Name</th>'.$subtext.'<th>Posts</th><th>Status</th><th>View/Edit</th></tr></thead>
			<tbody>';
	$bottom='	</tbody>
			</table>';
		$completeoutput="No categories created yet";
		$catminoutput="";
		$allcatlinkouts="No categories created yet";
		$linkouttwo="No categories created yet";
	if($numrows>0){
		$completeoutput="";
		$allcatlinkouts="";
		$linkouttwo="";
		while($row=mysql_fetch_assoc($run)){
			$outvar=getSingleBlogCategory($row['id']);
			$adminoutput.=$outvar['adminoutput'];
			$completeoutput.=$outvar['completeoutput'];
			$catminoutput.=$outvar['pfncatminoutput'];
		}

		$queryselect="SELECT * FROM blogcategories where blogtypeid=$blogtypeid and status='active' order by id desc";    
		$runselect=mysql_query($queryselect)or die(mysql_error()." Line 1156");
		while($rowselect=mysql_fetch_assoc($runselect)){
			$outvar=getSingleBlogCategory($rowselect['id']);
			$selection.='<option value="'.$outvar['id'].'">'.$outvar['catname'].'</option>';
			$linkouttwo.=$outvar['linkouttwo'];
			$allcatlinkouts.=$outvar['linkout'];
		}
	}
	$outs=paginatejavascript($rowmonitor['chiefquery']);
	$paginatetop='
	<div id="paginationhold">
		<div class="meneame">
			<input type="hidden" name="curquery" value="'.$rowmonitor['chiefquery'].'"/>
			<input type="hidden" name="outputtype" value="blogcategory"/>
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
	$row['completeoutput']=$completeoutput;
	$row['pfncatminoutput']=$catminoutput;
	$row['adminoutputtwo']=$top.$adminoutput.$bottom;
	$row['chiefquery']=$rowmonitor['chiefquery'];
	$row['selection']=$selection;
	$row['linkout']=$allcatlinkouts;
	$row['linkouttwo']=$linkouttwo;
	return $row;
}
function getSingleComment($commentid){
	global $host_addr,$host_target_addr;
	//include gravatar
	$gravatar=new emberlabs\GravatarLib\Gravatar();
	// set options
	$gravatar->setAvatarSize(150);
	$row=array();
	$query="SELECT * FROM comments WHERE id=$commentid";
	$run=mysql_query($query)or die(mysql_error()." Line 1166");
	$row=mysql_fetch_assoc($run);
	$id=$row['id'];
	$fullname=$row['fullname'];
	$email=$row['email'];
	$avatar = $gravatar->buildGravatarURL(''.$email.'');
	$blogpostid=$row['blogentryid'];
	$blogquery="SELECT * FROM blogentries where id=$blogpostid";
	$blogrun=mysql_query($blogquery)or die(mysql_error()." Line 1145");
	$blognumrows=mysql_num_rows($blogrun);
	$blogrow=mysql_fetch_assoc($blogrun);
	$blogtypeid=$blogrow['blogtypeid'];
	$blogtypedata=getSingleBlogType($blogtypeid);
	$pagename=$blogrow['pagename'];
	$pagelink=''.$host_addr.'blog/'.$blogtypedata['foldername'].'/'.$pagename.'.php';
	$link='<a href="'.$pagelink.'" target="_blank" title="click to view this blog post">'.$blogrow['title'].'</a>';
	$rellink='./blog/'.$blogtypedata['foldername'].'/'.$pagename.'.php';
	$comment=$row['comment'];
	$comment=str_replace("../../",$host_addr,$comment);
	$date=$row['datetime'];
	$datetwo=$date;
	$status=$row['status'];
	$userid=isset($row['userid'])?$row['userid']:0;
	$tableout='';
	if($status=="active"){
	$tableout='<a href="#&id='.$id.'" name="disablecomment" data-type="disablecomment" data-divid="'.$id.'">Disable</a>';
	}elseif($status=="inactive"){
	$tableout='<a href="#&id='.$id.'" name="activatecomment" data-type="activatecomment" data-divid="'.$id.'">Activate</a>';
	}elseif($status=="disabled"){
	$tableout='<a href="#&id='.$id.'" name="reactivatecomment" data-type="reactivatecomment" data-divid="'.$id.'">Reactivate</a>';
	}
	if($userid>0){
		$udata=getSingleUser($userid);
		$img=$udata['facefile'];
		$fullname=$udata['fullname'];
	}else{
		$img=$avatar;
	}
	$row['vieweroutput']='
	<li class="comment alt thread-alt depth-1 parent">                           
        <div class="comment-body">
            <div class="comment-author vcard">
                <img width="80" height="80" class="avatar avatar-32 photo" src="'.$img.'" alt="">			
                <cite class="fn"><a class="url" rel="external nofollow" href="#">'.$fullname.'</a></cite> 
                <span class="says">says:</span>		
            </div>

            <div class="comment-meta commentmetadata">
                <a href="#">'.$datetwo.'</a>
            </div>

            '.$comment.'
        </div>
        
    </li>
	';
	$row['adminoutput']='
	<div id="commentholder" data-id="'.$id.'">
		<div id="commentimg">
			<img src="'.$host_addr.'images/default.gif" class="total">
		</div>
		<div id="commentdetails">
			<div id="commentdetailsheading">
				'.$fullname.'&nbsp;&nbsp;&nbsp;&nbsp;<span>'.$date.'</span>
			</div>
			'.$comment.'
			<a href="##removeComment" class="adminremoval" name="removecomment" title="click here to remove this comment" data-cid="'.$id.'">Click to remove</a>
			<div id="bulkoperation"><input type="checkbox" data-state="off" data-parent="" value="'.$id.'"></div>
		</div>
	</div>
	';
	$row['adminoutputtwo']='
	<tr data-id="'.$id.'">
		<td>'.$fullname.'</td><td>'.$email.'</td><td>'.$date.'</td><td>'.$comment.'</td><td>'.$link.'</td><td name="commentstatus'.$id.'">'.$status.'</td><td name="trcontrolpoint">'.$tableout.'</td>
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
	return $row;
}
function getAllComments($viewer,$limit,$blogpostid){
	global $host_addr,$host_target_addr,$logpart;
 	$testit=strpos($limit,"-");
	$testit!==false?$limit="":$limit=$limit;
	$row=array();
	$paginateout="";
	$extraqdata="";
	$alevel=isset($_SESSION['accesslevel'.$logpart.''])?$_SESSION['accesslevel'.$logpart.'']:0;
	if(is_numeric($blogpostid)){
		if($viewer=="admin"){
			if($limit=="" && $blogpostid==""){
			$query="SELECT * FROM comments WHERE status!='disabled' $extraqdata order by id,status desc LIMIT 0,15";
			$rowmonitor['chiefquery']="SELECT * FROM comments WHERE status!='disabled' $extraqdata order by id,status desc";
			}else if($limit!==""&& $blogpostid==""){
			$query="SELECT * FROM comments WHERE status!='disabled' $extraqdata order by id,status desc $limit";
			$rowmonitor['chiefquery']="SELECT * FROM comments WHERE status!='disabled' $extraqdata order by id,status desc";
			}elseif ($limit==""&&$blogpostid!=="") {
			  # code...
			$query="SELECT * FROM comments WHERE blogentryid=$blogpostid AND status!='disabled' $extraqdata order by id,status desc";
			$rowmonitor['chiefquery']="SELECT * FROM comments WHERE blogentryid=$blogpostid AND status!='disabled' $extraqdata order by id,status desc";
			}elseif ($limit!==""&&$blogpostid!=="") {
			  # code...
			$query="SELECT * FROM comments WHERE blogentryid=$blogpostid AND status!='disabled' $extraqdata order by id,status desc $limit";
			$rowmonitor['chiefquery']="SELECT * FROM comments WHERE blogentryid=$blogpostid AND status!='disabled' $extraqdata order by id,status desc $limit";
			}
		}elseif ($viewer=="viewer") {
		  # code...
		$query="SELECT * FROM comments WHERE blogentryid=$blogpostid AND status!='disabled' AND status!='inactive'";
		$rowmonitor['chiefquery']="SELECT * FROM comments WHERE blogentryid=$blogpostid AND status!='disabled' AND status!='inactive' order by id,status desc";
		}
	}else{
	 if($blogpostid=='all'){
	  $limit==""?$limit="LIMIT 0,15":$limit=$limit;
	  $query="SELECT * FROM comments order by id desc $limit";
	  $rowmonitor['chiefquery']="SELECT * FROM comments $extraqdata order by id,status desc";
	 }elseif($limit=="" && $blogpostid!==""){
	  $query="SELECT * FROM comments WHERE status='$blogpostid' $extraqdata order by id,status desc LIMIT 0,15";
	  $rowmonitor['chiefquery']="SELECT * FROM comments WHERE status='$blogpostid' $extraqdata order by id,status desc";
	 }else if($limit!==""&& $blogpostid!==""){
	  $query="SELECT * FROM comments WHERE status='$blogpostid' $extraqdata order by id,status desc $limit";
	  $rowmonitor['chiefquery']="SELECT * FROM comments WHERE status='$blogpostid' $extraqdata order by id,status desc";
	 }else if($viewer=="inactivecount"){
		$query="SELECT * FROM comments WHERE status='inactive' $extraqdata order by id,status desc $limit";
		$rowmonitor['chiefquery']="SELECT * FROM comments WHERE status='inactive' $extraqdata order by id,status desc $limit";
	 }
	 $paginateout=$blogpostid;
	}
 
	$run=mysql_query($query)or die(mysql_error()." Line 1189");
	$numrows=mysql_num_rows($run);
	$adminoutput='<td>No comments yet</td>';
	$vieweroutput='No comments yet';
	$commentoutput="";
	$row['commentout']="No comments here yet.<br>";
	$countout=0;
	if ($numrows>0) {
		# code...
		$adminoutput="";
		$vieweroutput="";
		while($row=mysql_fetch_assoc($run)){
			$commentout=getSingleComment($row['id']);
			$id=$row['id'];
			$commentoutput.=$commentout['adminoutput'];
			// adjust comment view as per access level
			// echo $alevel;
			if($alevel==1){
				// check for eko kopa valid comments only
				$bdataid=$row['blogentryid'];
				$cquery="SELECT * FROM blogentries WHERE id=$bdataid";
				$crun=mysql_query($cquery)or die(mysql_error()." line ".__LINE__);
				$cnumrows=mysql_num_rows($crun);
				$cnumrows>0?$crow=mysql_fetch_assoc($crun):$crow['id']=0;
				$typeid=$crow['blogtypeid'];
				$btypedata=getSingleBlogType($typeid);
				if(strtolower($btypedata['name'])=="eko kopa"){
			  		// echo $btypedata['name']." level";
					$adminoutput.=$commentout['adminoutputtwo'];
					$countout++;
				}
			}else{
					$adminoutput.=$commentout['adminoutputtwo'];
					$countout=$numrows;
			}
				$vieweroutput.=$commentout['vieweroutput'];
		}
		$row['commentout']=$commentoutput;
	}
	// echo $countout;
	$row['countout']=$countout;
	$row['commentcount']=$numrows;
	$top='<table id="resultcontenttable" cellspacing="0">
				<thead><tr><th>Fullname</th><th>Email</th><th>Date</th><th>Comment Entry</th><th>InBlogPost</th><th>Status</th><th>View/Edit</th></tr></thead>
				<tbody>';
	$bottom='	</tbody>
			</table>';
	$outs=paginatejavascript($rowmonitor['chiefquery']);
	$paginatetop='
	<div id="paginationhold">
		<div class="meneame">
			<input type="hidden" name="curquery" value="'.$rowmonitor['chiefquery'].'"/>
			<input type="hidden" name="outputtype" value="comments|'.$paginateout.'"/>
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

	return $row;
}
function getSingleBlogEntry($blogentryid){
	global $host_addr,$host_target_addr;
	$row=array();
	$query="SELECT * FROM blogentries where id=$blogentryid";
	$run=mysql_query($query)or die(mysql_error()." Line 1145");
	$numrows=mysql_num_rows($run);
	$row=mysql_fetch_assoc($run);
	$id=$row['id'];
	$row['numrows']=$numrows;
	$commentdata=getAllComments("admin","",$id);
	$commentdatatwo=getAllComments("viewer","",$id);
	$blogtypeid=$row['blogtypeid'];
	$blogtypedata=getSingleBlogType($blogtypeid);
	$blogtypeid=$row['blogcatid'];
	// $blogtypedata=getSingleBlogType($blogtypeid);
	$blogcatquery="SELECT * FROM blogcategories WHERE id=$blogtypeid";
	$blogcatrun=mysql_query($blogcatquery)or die(mysql_error()." Line 1642");
	$blogcategorydata=mysql_fetch_assoc($blogcatrun);
	$blogentrytype=$row['blogentrytype'];
	$title=$row['title'];
	$introparagraph=$row['introparagraph'];
	if($blogentrytype!=="gallery" && $blogentrytype!=="banner"){
	$headerdescription = convert_html_to_text($introparagraph);
	$headerdescription=html2txt($headerdescription);
	$monitorlength=strlen($headerdescription);
	$headerminidescription=$headerdescription;
	if($monitorlength>140){
	$headerminidescription=substr($headerdescription,0,137);
	$headerminidescription=$headerminidescription."...";
	}
	}else{
	  $headerdescription=$title;
	 $monitorlength=strlen($headerdescription);
	$headerminidescription=$headerdescription;
	if($monitorlength>140){
	$headerminidescription=substr($headerdescription,0,137);
	$headerminidescription=$headerminidescription."...";
	} 
	}

	$blogpost=$row['blogpost'];
	$blogpostout=str_replace("../", $host_addr, $blogpost);
	$row['blogpostout']=$blogpostout;
	$entrydate=$row['entrydate'];
	$entrycomp=explode(" ", $entrydate);
	$daydata=explode(",",$entrycomp[0]);
	$datedata=$daydata[0];
	$monthdata=$entrycomp[1];
	$monthout=strtoupper(substr($monthdata, 0,3));
	$yeardata=$entrycomp[2];
	$timedata=$entrycomp[3];

	$modifydate=$row['modifydate'];
	if($modifydate==""){
		$modifydate="never";
	}
	$row['modifydate']=$modifydate;
	$views=$row['views'];
	$coverid=$row['coverphoto'];
	// work on images based on blog entry types
	$row['valbum']="";
	$row['vfalbum']="";
	$row['bannerthumb']="";
	$row['bannermain']="";
	$bannerpathdata='';
	$albumdataoutput='';

	if ($blogentrytype==""||$blogentrytype=="normal") {
	  # code...
	//get complete gallery images and create thumbnail where necessary;
	$mediaquery="SELECT * FROM media WHERE id=$coverid AND status='active' ORDER BY id DESC";
	$mediarun=mysql_query($mediaquery)or die(mysql_error()." Line 2846");
	$coverdata=mysql_fetch_assoc($mediarun);
	$coverphoto=$coverdata['location'];
	$medianumrows=mysql_num_rows($mediarun);
	if($coverid<1){
	$coverphoto=$host_addr."images/default.gif";
	}
	$extraformdata='
	<input type="hidden" name="blogentrytype" value="normal"/>
	';
	$editcoverphotostyle="";
	$editcoverphotofloatstyle="";
	$editintroparagraphstyle="";
	$editblogpoststyle="";
	}elseif($blogentrytype=="banner"){
	$mediaquery="SELECT * FROM media WHERE ownerid=$id AND ownertype='blogentry' AND maintype='bannerpic' AND status='active' ORDER BY id DESC";
	$mediarun=mysql_query($mediaquery)or die(mysql_error()." Line 2846");
	$coverdata=mysql_fetch_assoc($mediarun);
	$coverphoto=$coverdata['location'];
	$row['bannermain']=$host_addr.$coverphoto;
	$coverphotothumb=$coverdata['details'];
	$row['bannerthumb']=$host_addr.$coverphotothumb;
	$coverphotothumb==""?$coverphoto=$coverphoto:$coverphoto=$coverphotothumb;
	$medianumrows=mysql_num_rows($mediarun);
	$extraformdata='
	<div id="formend">
	  Change Banner Image<br>
	  <input type="file" placeholder="Choose image" name="bannerpic" class="curved"/>
	</div>
	<input type="hidden" name="blogentrytype" value="banner"/>
	<input type="hidden" name="bannerid" value="'.$coverdata['id'].'"/>
	';
	$editcoverphotostyle="display:none;";
	$editcoverphotofloatstyle="display:none;";
	$editintroparagraphstyle="display:none;";
	$editblogpoststyle="display:none;";
	}elseif($blogentrytype=="gallery"){
	  $editcoverphotostyle="display:none;";
	  $editcoverphotofloatstyle="display:none;";
	  $editintroparagraphstyle="display:none;";
	  $editblogpoststyle="display:none;";
	    $outselect="";
	  for($i=1;$i<=10;$i++){
	    $pic="";
	    $i>1?$pic="photos":$pic="photo";    
	    $outselect.='<option value="'.$i.'">'.$i.''.$pic.'</option>';
	  }
	  $mediaquery="SELECT * FROM media WHERE ownerid=$id AND ownertype='blogentry' AND maintype='gallerypic' AND status='active' ORDER BY id DESC";
	  $mediarun=mysql_query($mediaquery)or die(mysql_error()." Line 2087");
	  $medianumrows=mysql_num_rows($mediarun);
	  $thumbstack="";
	  $locationstack="";
	  $dimensionstack="";
	  $locationstack2="";
	  $dimensionstack2="";
	  $mediacount=$medianumrows;
	  //get the blog gallery
	  $album="No Gallery Photos Available";
	  $valbum="No Gallery Photos Available for this post";
	  $vfalbum="No Gallery Photos Available for this post";
	  if($medianumrows>0){
	    $count=0;
	    $album="";
	    $valbum="";
	    $vfalbum="";
	  while ($mediarow=mysql_fetch_assoc($mediarun)) {
	    # code...
	    if($count==0){
	      // $coverphoto=$mediarow['details'];
	      $coverphoto=$mediarow['location'];
		  $coverphotothumb=$mediarow['details'];
		  $coverphotothumb==""?$coverphoto=$coverphoto:$coverphoto=$coverphotothumb;
		  $coverphoto==""?$coverphoto="./images/muyiwalogo5.png":$coverphoto=$coverphoto;
	      $maincoverphoto=$mediarow['location'];
	    }

	  $imgid=$mediarow['id'];
	  $realimg=$mediarow['location'];
	  $thumb=$mediarow['details'];
	  $width=$mediarow['width'];
	  $height=$mediarow['height'];
	  $locationstack==""?$locationstack.=$host_addr.$realimg:$locationstack.=">".$host_addr.$realimg;
	  $dimensionstack==""?$dimensionstack.=$width.",".$height:$dimensionstack.="|".$width.",".$height;
	  $album.='
		  <div id="editimgs" name="albumimg'.$imgid.'">
		    <div id="editimgsoptions">
		      <div id="editimgsoptionlinks">
		        <a href="##" name="deletepic" data-id="'.$imgid.'"data-galleryid="'.$id.'"data-arraypoint="'.$count.'" data-src="'.$host_addr.''.$realimg.'"><img name="deletepic" src="../images/trashfirst.png" title="Delete this photo?" class="total"></a>
		        <a href="##" name="viewpic" data-id="'.$imgid.'" data-galleryid="'.$id.'" data-arraypoint="'.$count.'" data-src="'.$host_addr.''.$realimg.'"><img name="viewpic" src="../images/viewpicfirst.png" title="View full image" class="total"></a>                
		      </div>
		    </div>  
		    <img src=".'.$mediarow['details'].'" name="realimage" data-width="'.$width.'" data-height="'.$height.'" style="height:100%;margin:auto;">
		  </div>
	  ';
	  $vfalbum.='
		  <div class="blogpostgalleryimgholdtwo">
		      <img src="'.$host_addr.''.$mediarow['details'].'" data-id="'.$imgid.'" data-galleryid="'.$id.'" data-galleryname="bloggallerydata" data-arraypoint="'.$count.'" data-src="'.$host_addr.''.$realimg.'" style="height:100%;margin:auto;float:none;">
		  </div>
	  ';
	  if($count<8){
	  $locationstack2==""?$locationstack2.=$host_addr.$realimg:$locationstack2.=">".$host_addr.$realimg;
	  $dimensionstack2==""?$dimensionstack2.=$width.",".$height:$dimensionstack2.="|".$width.",".$height;
	  $valbum.='
	  <div class="blogpostgalleryimgholdone">
	      <img src="'.$mediarow['details'].'" data-id="'.$imgid.'" data-galleryid="'.$id.'" data-galleryname="bloggallerydata" data-arraypoint="'.$count.'" data-src="'.$host_addr.''.$realimg.'" style="height:100%;margin:auto;float:none;">
	  </div>
	  ';
	  }
	  $count++;
	  }
	  $valbum.='<input type="hidden" name="bloggallerydata'.$id.'" data-title="'.$title.'" data-mainimg="'.$host_addr.''.$maincoverphoto.'" data-images="'.$locationstack2.'" data-sizes="'.$dimensionstack2.'" data-details="">';
	  $vfalbum.='<input type="hidden" name="bloggallerydata'.$id.'" data-title="'.$title.'" data-mainimg="'.$host_addr.''.$maincoverphoto.'" data-images="'.$locationstack.'" data-sizes="'.$dimensionstack.'" data-details="">';
	  $row['valbum']=$valbum;
	  $row['vfalbum']=$vfalbum;
	  }
	$extraformdata='
		<div id="formend" >
		    <input type="hidden" name="gallerydata'.$id.'" data-title="'.$title.'" data-mainimg="'.$host_addr.''.$maincoverphoto.'" data-images="'.$locationstack.'" data-sizes="'.$dimensionstack.'" data-details=""/>
		    Edit Photos from this blog post album.<br>
		  '.$album.'
		  <div id="formend">
		    Add Gallery Photos for this post:<br>
		    <input type="hidden" name="piccount" value=""/>
		    <select name="photocount" class="curved2" title="Choose the amount of photos you want to upload, max of 10, then click below the selection to continue">
		    <option value="">--choose amount--</option>
		    '.$outselect.'
		    </select>             
		  </div>
		</div>
		<input type="hidden" name="blogentrytype" value="gallery"/>

	';
	}
	// $coverdata=getSingleMediaData($coverid,'id');

	$row['maincoverphoto']=$coverphoto;
	$admincover="../".$coverphoto;
	$row['admincover']=$admincover;
	$absolutecover="".$host_addr."".$coverphoto;
	$row['absolutecover']=$absolutecover;
	$pagename=$row['pagename'];
	$status=$row['status'];
	$pagelink=''.$host_addr.'blog/'.$blogtypedata['foldername'].'/'.$pagename.'.php';
	$rellink='./blog/'.$blogtypedata['foldername'].'/'.$pagename.'.php';
	$row['pagelink']=$pagelink;
	$row['rellink']=$rellink;
	$row['pagedirectory']=''.$host_addr.'blog/'.$blogtypedata['foldername'].'/';
	$row['reldirectory']='./blog/'.$blogtypedata['foldername'].'/';
	$link='<a href="'.$pagelink.'" target="_blank" title="click to view this blog post">'.$title.'</a>';
	$commentcontent='
	<div id="formend" name="minicommentsearchhold" style="">
		<font style="font-size:18px;">Comments</font><br>
		<div id="formend" name="commentsearchpanehold">
		After a search, if you want to view all comments again simply type in "<b>*fullcommentsview*</b>" to do so.<br>
		<input type="text" class="curved" name="minisearch'.$id.'" data-id="'.$id.'" title="Use this search bar to search by comment word, i.e offensive or in appropriate words or by comment poster name" Placeholder="Search for words within comments..."/>
		</div>
		 <input type="button" name="updateblogentry" style="max-width:150px;" value="Search" onClick="searchComment('.$id.')" class="submitbutton"/>
		<div id="formend" name="commentfullhold'.$id.'">
		'.$commentdata['commentout'].'
		</div>
	</div>
	';
	$row['viewercomment']=$commentdatatwo['vieweroutput'];
	$row['commentcount']=$commentdatatwo['commentcount'];
	$row['blogtypename']=$blogtypedata['name'];
	$row['blogcatname']=$blogcategorydata['catname'];
	//configure viewer output 
	if($blogentrytype==""||$blogentrytype=="normal"){
	$viewerbodyoutone='   <img src="'.$absolutecover.'"/>'.$introparagraph.'';
	$linkcontentout="Continue Reading";
	}elseif ($blogentrytype=="banner") {
	  # code...
	$viewerbodyoutone='<img src="'.$absolutecover.'" style="width:98%;max-height:660px;"/>';
	$linkcontentout="View Banner";
	}elseif ($blogentrytype=="gallery") {
	  # code...
	$viewerbodyoutone=$valbum;
	$linkcontentout="View All Photos";
	}
	$row['adminoutput']='
		<tr data-id="'.$id.'">
			<td><img src="'.$host_addr.''.$coverphoto.'"style="height:150px;"/></td><td>'.$link.'</td><td>'.$blogtypedata['name'].'</td><td>'.$blogcategorydata['catname'].'</td><td>'.$commentdata['commentcount'].'</td><td>'.$views.'</td><td>'.$entrydate.'</td><td>'.$modifydate.'</td><td>'.$status.'</td><td name="trcontrolpoint"><a href="#&id='.$id.'" name="edit" data-type="editsingleblogpost" data-divid="'.$id.'">Edit</a></td>
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
	$blogplatformshares='
			<div id="blogplatformshares">
				<div class="fb-like" data-href="'.$pagelink.'" data-layout="box_count" data-action="like" data-show-faces="true" data-share="true"></div>
			</div>
			<div id="blogplatformshares">
				<div class="g-plusone" data-action="share" data-annotation="bubble" data-size="tall" data-href="'.$pagelink.'"></div>
			</div>
			<div id="blogplatformshares">
				<a href="https://twitter.com/share" class="twitter-share-button" data-related="twitterapi:midassoccer"data-count="vertical" data-url="'.$pagelink.'">Tweet</a>
			</div>
			<div id="blogplatformshares">
				<script type="IN/Share" data-url="'.$pagelink.'" data-counter="top"></script>
			</div>
	';
	$blogplatformminishares='
		<div class="minisharecontainers">
			<a href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]='.$pagelink.'&p[images][0]='.$absolutecover.'&p[title]='.$title.'&p[summary]='.$headerdescription.'" target="_blank"><img src="../images/facebookshareimg.jpg"/></a>
		</div>
		<div class="minisharecontainers">
			<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url='.$pagelink.'&amp;title='.$title.'&amp;summary='.$headerminidescription.'" target="_blank"><img alt="" src="'.$host_addr.'/images/linkedinshareimg.jpg" /></a>
		</div>
	    <div class="minisharecontainers">
	      <a href="http://twitter.com/home?status='.$pagelink.'" target="_blank"><img src="../images/twittershareimg.jpg"></a>
	    </div>
	    <div class="minisharecontainers">
	    <a href="https://plus.google.com/share?url='.$pagelink.'"target="_blank">
	      <img src="../images/googleshareimg.jpg">
	    </a>
	    </div>
	';
	$row['blogpageshare']='
		<div class="mainblogshare">
			<div class="fb-like" data-href="'.$pagelink.'" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
		</div>
		<div class="mainblogshare">
			<div class="g-plus" data-action="share" data-annotation="bubble" data-href="'.$pagelink.'"></div>
		</div>
		<div class="mainblogshare">
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="'.$pagelink.'">Tweet</a>
		</div>
		<div class="mainblogshare">
			<script type="IN/Share" data-url="'.$pagelink.'" data-counter="right"></script>
		</div>
	';
	$row['blogpagesharreshare']='
		
	';
	$horizontalshare='
		<div class="blogsharepoint">
				<a href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]='.$pagelink.'&p[images][0]='.$absolutecover.'&p[title]='.$title.'&p[summary]='.$headerdescription.'" target="_blank" name="facebookpagelink">
					<div class="socialiconpoint facebookicon"></div>
				</a>
				<a href="http://twitter.com/home?status='.$pagelink.'" target="_blank" name="twitterpagelink">
					<div class="socialiconpoint twittericon"></div>
				</a>
				<a href="https://plus.google.com/share?url='.$pagelink.'" target="_blank" name="googlepluspagelink">
					<div class="socialiconpoint googleplusicon"></div>
				</a>
				<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url='.$pagelink.'&amp;title='.$title.'&amp;summary='.$headerminidescription.'" target="_blank" name="linkedinpagelink">
					<div class="socialiconpoint linkedinicon"></div>
				</a>
			</div>
			';
	$row['coverphotoset']==0?$floatsetout="Left":($row['coverphotoset']==1?$floatsetout="New Line":($row['coverphotoset']==2?$floatsetout="Right":$floatsetout=""));


	$row['adminoutputtwo']='
					<script src="'.$host_addr.'scripts/js/tinymce/jquery.tinymce.min.js"></script>
					<script src="'.$host_addr.'scripts/js/tinymce/tinymce.min.js"></script>
					<script>
					        //reload tinymce to see this DOM entry
					          $(document).ready(function(){
					/*$.cachedScript( "'.$host_addr.'scripts/js/tinymce/jquery.tinymce.min.js" ).done(function( script, textStatus ) {
					  console.log( textStatus );
					});
					$.cachedScript( "'.$host_addr.'scripts/js/tinymce/tinymce.min.js" ).done(function( script, textStatus ) {
					  console.log( textStatus );
					});
					$.cachedScript( "'.$host_addr.'scripts/js/tinymce/basic_config.js" ).done(function( script, textStatus ) {
					  console.log( textStatus );
					});
					*/
					    });
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
							<div id="form" style="background-color:#fefefe;">
								<form action="../snippets/edit.php" name="editblogpost" method="post" enctype="multipart/form-data">
									<input type="hidden" name="entryvariant" value="editblogpost"/>
									<input type="hidden" name="entryid" value="'.$id.'"/>
									<div id="formheader">Edit '.$title.'</div>
										<div id="formend" style="'.$editcoverphotostyle.'">
											Change Cover Photo <br>
											<input type="file" placeholder="Choose image" name="profpic" class="curved"/>
										</div>
										<div id="formend" style="'.$editcoverphotofloatstyle.'">
										Cover Photo Float(Controls the position of the cover photo image, currently set to "'.$floatsetout.'")<br>
											<select name="coverstyle" class="curved2">
												<option value="">Change Status</option>
												<option value="0" title="The Blog text starts inline beside the cover photo on it\'s left">Left</option>
												<option value="1" title="The Blog text starts underneath the cover photo">New Line</option>
												<option value="2" title="The Blog text starts inline beside the cover photo on it\'s right">Right</option>
											</select>
										</div>
										<div id="formend">
										Manually share this post, this is done as a site user so if you want to post to Bayonle\'s account be sure to log in as him first then share, don\'t worry the dialog box for sharing will have a login interface for you to do so unless you have logged in as someone else to any of these social networks, in that case you would have to logout and login as Administrator, then you can post. <br>
										<div id="elementholder" style="float:none; margin:auto;">
										'.$blogplatformminishares.'
										</div>
										</div>
										<div id="formend">
											Change Title<br>
											<input type="text" style="max-width:98%;width:87%;" placeholder="Blog Title" name="title" style="width:90%;" value="'.$title.'" class="curved"/>
										</div>
				            '.$extraformdata.'
										<div id="formend" style="'.$editintroparagraphstyle.'">
											<span style="font-size:18px;">Change Introductory Paragraph:</span><br>
											<textarea name="introparagraph" id="postersmalltwo" Placeholder="" class="">'.$introparagraph.'</textarea>
										</div>
										<div id="formend" style="'.$editblogpoststyle.'">
											<span style="font-size:18px;">Change The Blog Post:</span><br>
											<textarea name="blogentry" id="adminposter" Placeholder="" class="curved3">'.$blogpost.'</textarea>
										</div>
										'.$commentcontent.'
										<div id="formend">
											Change Status<br>
											<select name="status" class="curved2">
												<option value="">Change Status</option>
												<option value="active">Active</option>
												<option value="inactive">Inactive</option>
											</select>
										</div>
									<div id="formend">
										<input type="submit" name="updateblogentry" value="Update" class="submitbutton"/>
									</div>
								</form>
							</div>
	';

	$row['blogminioutput']='
		<li>                        	
            <img src="'.$absolutecover.'" alt="'.$title.'">
            <p class="title">
            	<a href="'.$pagelink.'">'.$title.'</a>
            </p>
            
            <p class="post-details">
                <a href="'.$host_addr.'category.php?cid='.$blogtypeid.'">'.$blogcategorydata['catname'].'</a> | 
                <a href="#">'.$commentdata['commentcount'].' comments</a> | by 
                <a href="#">Administrator</a>
            </p>
            
            <p>'.$headerdescription.'</p>
            
        </li>
	';
	$row['blogminioutputtwo']='
		<div class="feed-holder">
			<div>
				<a href="'.$pagelink.'">
				  <img src="'.$absolutecover.'" height="66" width="79" alt="Blog Image" class="img-responsive">
				</a>
			</div>
			<div>
			<h4><a href="'.$pagelink.'" title="'.$headerdescription.'">'.$title.'</a></h4>
			<span><i class="fa fa-clock-o"></i> &nbsp;'.$entrydate.'</span>
			</div>
		</div>
	';
	$row['blogtinyoutput']='
	<div id="postundercat">
		<div id="postundercatleft"><a href="'.$pagelink.'">'.$title.'</a></div>
		<div id="postundercatright">'.$entrydate.'</div>
	</div>
	';
	$row['datedata']=$datedata;
	$row['monthout']=$monthout;
	$row['vieweroutput']='
		<div class="blog-post">
                    
        	<div class="blog-post-thumb">
            	
                <img src="'.$absolutecover.'" alt="">
                
                <div class="blog-post-info">
                	'.$datedata.'
                    <small>'.$monthout.'</small>
                </div><!-- end .blog-post-info -->
                
            </div><!-- end .blog-post-thumb -->
            
            <div class="blog-post-title">
            	
                <h4>
                	<a href="##">'.$title.'</a>
                </h4>
                
                <p>
                	<a href="'.$host_addr.'category.php?cid='.$blogtypeid.'">'.$blogcategorydata['catname'].'</a> | 
	                <a href="#">'.$commentdata['commentcount'].' comments</a> | by 
	                <a href="#">Administrator</a>
                </p>
                
            </div><!-- end .blog-post-title -->
            '.$introparagraph.'            
            <a class="btn" target="_blank" href="'.$pagelink.'">
            	read more
                <i class="fa fa-angle-right"></i>
            </a>
            
        </div><!-- end .blog-post -->
		
	';
	$row['vieweroutputtwo']='
	<div class="bloghold">
		<div class="blogheader">
			<p class="postdate">'.$datedata.' '.$monthout.' '.$yeardata.'</p>
			<p class="posttitle">'.$title.'</p>
		</div>
		<div class="blogcontent">
			<div class="blogdetails">
			'.$viewerbodyoutone.'
			</div>
			'.$row['blogpageshare'].'
			<div class="blogheaderdetailsleft">
				By Administrator, at '.$timedata.', in the Category <a href="'.$host_addr.'category.php?cid='.$blogtypeid.'" class="displayedlink" target="_blank" ><span name="titletype">'.$blogcategorydata['catname'].'</span></a>.Total Views '.$views.'.
			</div>
		</div>
		<div class="blogfooter">
			<a href="'.$pagelink.'" target="_blank" title="Continue reading this post">Continue Reading...</a>
		</div>
	</div>
	<!--<div id="bloghold">
		<div id="blogheader">
			<span name="title">'.$title.'.</span>
			<div id="blogheaderdetailshold">
				<div id="blogheaderdetailsleft">
					By Muyiwa Afolabi, On '.$entrydate.'. Total Views '.$views.'.
				</div>
				<div id="blogheaderdetailsright"><img src="'.$host_addr.'images/comments.png"/> '.$commentdata['commentcount'].' Comments</div>
			</div>
		</div>
		<div id="blogbody">
			<img src="'.$absolutecover.'"/>'.$introparagraph.'
			<div id="blogreadermorehold">
				<a href="'.$pagelink.'" target="_blank" title="Continue reading this post">Continue Reading</a>
			</div>
		</div>
		<div id="blogfooter">
			'.$blogplatformshares.'
		</div>
	</div>-->
	';
	$row['vieweroutputthree']='
		<div class="row article-wrapp">
	        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	          <div class="article-img" style="max-height:250px!important; overflow:hidden;">
	            <a href="'.$pagelink.'">
	              <img src="'.$absolutecover.'" height="auto" width="auto" alt="Blog Image" class="img-responsive">
	              <span><i class="fa fa-search"></i></span>
	            </a>
	          </div>
	          <h1><a href="'.$pagelink.'">'.$title.'</a></h1>
	          <div class="article-meta">
	            <ul>
	              <li>
	                <i class="fa fa-clock-o"></i>&nbsp; '.$entrydate.'
	              </li>
	              <li>
	                <i class="fa fa-comments-o"></i>&nbsp; <a href="##">Comments: '.$commentdata['commentcount'].' </a>
	              </li>
	              <li>
	                <i class="fa fa-eye"></i>&nbsp; <a href="##">Views: '.$views.'</a>
	              </li>
	            </ul>
	          </div>
	          '.$introparagraph.'
	          <a href="'.$pagelink.'" class="ilny-shadowed">Read More</a>
	        </div>
	      </div>
	';
	return $row;
}
function getAllBlogEntries($viewer,$limit,$typeid,$type){
	global $host_addr,$host_target_addr;
	$testit=strpos($limit,"-");
	$testit!==false?$limit="":$limit=$limit;
	// echo $testit."testitval".$limit;
	$row=array();
	if(!is_array($viewer)&&$viewer=="admin"){	
	if($type=="category"){
	if($limit==""){
	$query="SELECT * FROM blogentries WHERE blogcatid=$typeid order by id desc LIMIT 0,15";
	$rowmonitor['chiefquery']="SELECT * FROM blogentries WHERE blogcatid=$typeid order by id desc";
	// echo $query.$rowmonitor['chiefquery'];
	}else{
	$query="SELECT * FROM blogentries WHERE blogcatid=$typeid order by id desc $limit";
	$rowmonitor['chiefquery']="SELECT * FROM blogentries WHERE blogcatid=$typeid order by id desc";	
	}
	}elseif ($type=="blogtype") {
		# code...
	if($limit==""){
	$query="SELECT * FROM blogentries WHERE blogtypeid=$typeid order by id desc LIMIT 0,15";
	$rowmonitor['chiefquery']="SELECT * FROM blogentries WHERE blogtypeid=$typeid order by id desc";
	}else{
	$query="SELECT * FROM blogentries WHERE blogtypeid=$typeid order by id desc $limit";
	$rowmonitor['chiefquery']="SELECT * FROM blogentries WHERE blogtypeid=$typeid order by id desc";	
	}
	}
	}else if(!is_array($viewer)&&$viewer=="viewer"){
	if($type=="category"){
	if($limit==""){
	$query="SELECT * FROM blogentries WHERE blogcatid=$typeid AND status='active' order by id desc LIMIT 0,15";
	$rowmonitor['chiefquery']="SELECT * FROM blogentries WHERE blogcatid=$typeid AND status='active' order by id desc";
	// echo $query.$rowmonitor['chiefquery'];
	}else{
	$query="SELECT * FROM blogentries WHERE blogcatid=$typeid AND status='active' order by id desc $limit";
	$rowmonitor['chiefquery']="SELECT * FROM blogentries WHERE blogcatid=$typeid AND status='active' order by id desc";	
	}
	}elseif ($type=="blogtype") {
		# code...
	if($limit==""){
	$query="SELECT * FROM blogentries WHERE blogtypeid=$typeid AND status='active' order by id desc LIMIT 0,15";
	$rowmonitor['chiefquery']="SELECT * FROM blogentries WHERE blogtypeid=$typeid AND status='active' order by id desc";
	}else{
	$query="SELECT * FROM blogentries WHERE blogtypeid=$typeid AND status='active' order by id desc $limit";
	$rowmonitor['chiefquery']="SELECT * FROM blogentries WHERE blogtypeid=$typeid AND status='active' order by id desc";	
	}
	}
	}elseif (is_array($viewer)) {
	  # code...
	$rviewer=$viewer[0];
	if($rviewer=="admin"&&$limit==""){
	$query=$viewer[1]." LIMIT 0,15";
	$rowmonitor['chiefquery']=$viewer[1];
	}if($rviewer=="admin"&&$limit!==""){
	$query=$viewer[1].$limit;
	$rowmonitor['chiefquery']=$viewer[1];
	}elseif($rviewer=="viewer"&&$limit==""){
	  $query=$viewer[1]." AND status='active' LIMIT 0,15";
	$rowmonitor['chiefquery']=$viewer[1];
	}elseif ($rviewer=="viewer"&&$limit!=="") {
	  # code...
	$query=$viewer[1]." AND status='active' $limit";
	$rowmonitor['chiefquery']=$viewer[1];
	}
	$type="search";
	}
	$run=mysql_query($query)or die(mysql_error()." Line 1384");
	$numrows=mysql_num_rows($run);
	$row['adminoutput']="No Entries yet here";
	$row['vieweroutput']="No Entries yet here";
	$row['tinyoutput']="<div id=\"postundercat\">No more entries here</div>";
	$row['popularposts']="<br>No posts here yet";
	$row['recentposts']="<br>No Posts here yet";
	$row['adminoutputtwo']="";
	$row['vieweroutputtwo']="";
	$minioutput="<li>No Posts Yet.</li>";
	$row['chiefquery']=$rowmonitor['chiefquery'];
	$row['numrows']=$numrows;
	$evenout="";
	$oddout="";
	$countevod=1;
	if($numrows>0){
		$adminoutput="";
		$vieweroutput="";
		$vieweroutputtwo="";
		$vieweroutputthree="";
		$tinyoutput="";
		$minioutput="";
	$row['adminoutput']="";
	$row['vieweroutput']="";
	$row['tinyoutput']="";

	while($row=mysql_fetch_assoc($run)){
		$id=$row['id'];
		$blogpostdata=getSingleBlogEntry($id);
		$adminoutput.=$blogpostdata['adminoutput'];
		$vieweroutput.=$blogpostdata['vieweroutput'];
		$vieweroutputtwo.=$blogpostdata['vieweroutputtwo'];
		$vieweroutputthree.=$blogpostdata['vieweroutputthree'];
		$tinyoutput.=$blogpostdata['blogtinyoutput'];
		$minioutput.=$blogpostdata['blogminioutput'];
		if($countevod%2==0){
			$evenout.=$blogpostdata['vieweroutput'];;
		}else{
			$oddout.=$blogpostdata['vieweroutput'];;
		}
		$countevod++;
	}
	$top='<table id="resultcontenttable" cellspacing="0">
				<thead><tr><th>Coverphoto</th><th>PageAddress</th><th>Blogtype</th><th>Category</th><th><img src="'.$host_addr.'images/comments.png" style="height:20px;margin:auto;"></th><th>Views</th><th>PostDate</th><th>LastModified</th><th>Status</th><th>View/Edit</th></tr></thead>
				<tbody>';
	$bottom='	</tbody>
			</table>';
	$outs=paginatejavascript($rowmonitor['chiefquery']);
	$outsviewer=paginate($rowmonitor['chiefquery']);
	  $testq=strpos($rowmonitor['chiefquery'],"%'");
	  if($testq===0||$testq===true||$testq>0){
		// $rowmonitor['chiefquery']=str_replace("%","%'",$rowmonitor['chiefquery']);
	  }
	$paginatetop='
	<div id="paginationhold">
		<div class="meneame">
			<input type="hidden" name="curquery" value="'.$rowmonitor['chiefquery'].'"/>
			<input type="hidden" name="outputtype" value="blogpost'.$type.'"/>
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
	$row['vieweroutputtwo']=$vieweroutputtwo;
	$row['vieweroutputthree']=$vieweroutputthree;
	$evenfullout='
			<div class="span4">'.$evenout.'</div>
		';
	$oddfullout='
			<div class="span4">'.$oddout.'</div>
		';
	
	$row['chiefquery']=$rowmonitor['chiefquery'];
	$row['tinyoutput']=$tinyoutput;
	$row['minioutput']=$minioutput;
	$row['numrows']=$numrows;
	// produce recent blog posts

	}
	if($oddout==""&&$evenout!==""){
		$oddfullout="";
		$evenfullout='
			<div class="span8">'.$evenout.'</div>
		';
	}else if($evenout==""&&$oddout!==""){
		$evenfullout="";
		$oddfullout='
			<div class="span8">'.$oddout.'</div>
		';
	}elseif($oddout==""&&$evenout==""){
		$oddfullout='<div class="span8"><p>Sorry NO posts yet</p></div>';
		$evenfullout="";	
	}
	$exitstrat='
		'.$oddfullout.'
		'.$evenfullout.'
	';
	$row['vieweroutputfour']=$exitstrat;
	$recents="No Posts yet";
	$recentslarge="No Posts yet";
	$popular="No posts yet";
	$popularlarge="No posts yet";
	$popular2="No posts yet";
	if($viewer=="viewer"){

	$recquery="SELECT * FROM blogentries WHERE status='active' order by id desc LIMIT 0,4";
	$recrun=mysql_query($recquery)or die(mysql_error()." Line 1835");
	$recnumrows=mysql_num_rows($recrun);
	if($recnumrows>0){
		$recents="";
		$recentslarge="";
	while($recrow=mysql_fetch_assoc($recrun)){
	$outrec=getSingleBlogEntry($recrow['id']);
	$recents.=$outrec['blogminioutput'];
	$recentslarge.='<div class="span3">'.$outrec['vieweroutput'].'</div>';
	}
	}
	// produce popular blog posts
	$popquery="SELECT * FROM blogentries WHERE status='active' order by views desc LIMIT 0,4";
	$poprun=mysql_query($popquery)or die(mysql_error()." Line 1835");
	$popnumrows=mysql_num_rows($poprun);
	if($popnumrows>0){
	$popular="";
	$popularlarge="";
	$popular2="";
	while($poprow=mysql_fetch_assoc($poprun)){
	$outpop=getSingleBlogEntry($poprow['id']);
	$popularlarge.='<div class="span3">'.$outpop['vieweroutput'].'</div>';
	$popular.=$outpop['blogminioutput'];
	$popular2.=$outpop['blogminioutputtwo'];
	}
	}
	}
	$row['popularposts']=$popular;
	$row['popularpostslarge']=$popularlarge;
	$row['popularposts2']=$popular2;
	$row['recentposts']=$recents;
	$row['recentpostslarge']=$recentslarge;
	return $row;
}

function blogPageCreate($blogentryid){
	global $host_addr,$host_target_addr;
	$outs=getSingleBlogEntry($blogentryid);
	$c="";
	if(isset($_GET['c'])&&$_GET['c']){
	   $c=$_GET['c'];
	}
	  $alerter="";
	if($c=="true"){
	$alerter="Thank you for dropping your comment, we will approve it at our end if its appropriate and then it will be available for all to see.<br>";
	}
	$securitynumber=rand(0,10).rand(1,8).rand(0,5).rand(10,30).rand(200,250).rand(50,80).rand(34,55).rand(46,57);
	$blogtypeid=$outs['blogtypeid'];
	$blogcatid=$outs['blogcatid'];
	$outs2=getSingleBlogType($outs['blogtypeid']);
	$outs3=getSingleBlogCategory($outs['blogcatid']);
	$catout=getAllBlogCategories("viewer","",1);
	$coverset=$outs['coverphotoset'];
	$coverstyle="";
	if($coverset==1){
	$coverstyle='style="float:none; display:block; margin:auto;"';
	}else if($coverset==2){$coverstyle='style="float:right;"';
	}
	$logocontrol='<img src="'.$host_addr.'images/adsbounty5.png" alt="AdsBounty">';
	$sociallinks='
		<div id="sociallinks">
			<div id="socialholder" name="socialholdfacebook"><a href="http://www.facebook.com/franklyspeakingwithmuyiwaafolabi" target="_blank"><img src="../../images/Facebook-Icon.png" class="total"/></a></div>
			<div id="socialholder" name="socialholdlinkedin"><a href="http://www.linkedin.com/profile/view?id=37212987" target="_blank"><img src="../../images/Linkedin-Icon.png" class="total"/></a></div>
			<div id="socialholder" name="socialholdtwitter"><a href="http://www.twitter.com/franklyafolabi" target="_blank"><img src="../../images/Twitter-Icon.png" class="total"/></a></div>
			<div id="socialholder" name="socialholdgoogleplus"><a href="https://plus.google.com/u/0/115702519121823219689/posts" target="_blank"><img src="../../images/google-plus-icon.png" class="total"/></a></div>
			<div id="socialholder" name="socialholdyoutube"><a href="http://www.youtube.com/channel/UCYIZaonCbNxdLBrKpTQdYXA" target="_blank"><img src="../../images/YouTube-Icon.png" class="total"/></a></div>
		</div>
	';
	$footer='&copy; Administrator '.date('Y').' Developed by Okebukola Olagoke.';
	$footermain='
		<div id="footer-wrapper">
			<div class="row">
				<div class="span12">
			    	
			        <div id="footer">
			        	
			            <!-- /// FOOTER     ///////////////////////////////////////////////////////////////////////////////////////// -->
							
			                <div class="row">
			                	<div class="span4" id="footer-widget-area-1">
			                    	
			                        <div class="widget widget_text">
			                        
			                            <div class="textwidget">
			                                
			                                <img class="img-align-left hidden-tablet bottomimgdim" src="'.$host_addr.'images/adsbounty5.png" alt="">
			                                
			                                <address>
			                                	<span class="text-uppercase">AdsBounty<sup>&copy;</sup></span><br>
			                                    Lagos, <br>
												Nigeria. 
			                                </address>
			                                
			                            </div><!-- end .textwidget -->
			                            
			                        </div><!-- end .widget_text -->
			                        
			                    </div><!-- end .span4 -->
								<div class="span4" id="footer-widget-area-2">
			                    	
			                        <div class="widget ewf_widget_contact_info">
			                        	
			                            <ul>
			                            	<li><strong>Phone 1: </strong>0701-682-9254</li>
			                                <li><strong>Phone 2: </strong>0802-916-3891</li>
			                                <li><strong>Phone 3: </strong>0803-370-7244</li>
			                                <li><strong>Email: </strong><a href="mailto:#">info@adsbounty.com</a></li>
			                            </ul>
			                            
			                        </div><!-- end .ewf_widget_contact_info -->
			                        
			                    </div><!-- end .span4 -->
			                    <div class="span4" id="footer-widget-area-3">
			                    
			                    	<div class="widget ewf_widget_latest_tweets">
			                            
                                		<a class="twitter-timeline" href="https://twitter.com/AdsBounty" data-widget-id="609835696895954944">Tweets by @AdsBounty</a>
			                            
			                            
			                        </div><!-- end .ewf_widget_latest_tweets -->
			                        
			                    </div><!-- end .span4 -->
			                </div><!-- end .row -->
			                
			            <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
			        
			        </div><!-- end #footer -->
			        <div id="footer-bottom">
			        	
			            <!-- /// FOOTER BOTTOM     ////////////////////////////////////////////////////////////////////////////////// -->
							
			                <div class="row">
			                	<div class="span6" id="footer-bottom-widget-area-1">
			                    	
			                        <div class="widget widget_text">
			                        
			                            <div class="textwidget">
			                                
			                                <p class="text-uppercase last">
													&copy; AdsBounty
													'.date('Y').'
													Developed by Okebukola Olagoke.

			                                </p>
			                                
			                            </div><!-- end .textwidget -->
			                            
			                        </div><!-- end .widget_text -->
			                        
			                    </div><!-- end .span6 -->
			                    <div class="span6" id="footer-bottom-widget-area-2">
			                    	
			                        <div class="widget ewf_widget_social_media">
			                        	
			                            <div class="fixed">
							
			                                <a href="http://facebook.com/AdsBounty" class="facebook-icon social-icon">
			                                    <i class="fa fa-facebook"></i>
			                                </a>
			                                
			                                <a href="http://twitter.com/AdsBounty" class="twitter-icon social-icon">
			                                    <i class="fa fa-twitter"></i>
			                                </a>
			                                
			                                <a href="#" class="googleplus-icon social-icon">
			                                    <i class="fa fa-google-plus"></i>
			                                </a>
			                                
			                                <a href="#" class="linkedin-icon social-icon">
			                                    <i class="fa fa-linkedin"></i>
			                                </a>
			                                
			                                <a href="#" class="youtube-icon social-icon">
			                                    <i class="fa fa-youtube"></i>
			                                </a>
			                                
			                                <a href="#" class="pinterest-icon social-icon">
			                                    <i class="fa fa-pinterest"></i>
			                                </a>
			                                                                            
			                            </div>
			                            
			                        </div><!-- end .ewf_widget_social_media -->
			                        
			                    </div><!-- end .span6 -->
			                </div><!-- end .row -->
			                
			            <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
			        
			        </div><!-- end #footer-bottom -->                    
			        
			    </div><!-- end .span12 -->
			</div>
		</div><!-- end #footer-wrapper -->
	';
	// for collecting custom styles
	$bodystyles='
			<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,700,700italic,900,900italic">
			<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Raleway:400,300,700">
			<link rel="stylesheet" href="'.$host_addr.'_layout/css/iconfontcustom/icon-font-custom.css">
			<link rel="stylesheet" href="'.$host_addr.'_layout/css/base.css">
			<link rel="stylesheet" href="'.$host_addr.'_layout/css/grid.css">
			<link rel="stylesheet" href="'.$host_addr.'_layout/css/layout.css">
			<link rel="stylesheet" href="'.$host_addr.'_layout/css/elements.css">
			<link rel="stylesheet" href="'.$host_addr.'_layout/js/revolutionslider/css/settings.css">
			<link rel="stylesheet" href="'.$host_addr.'_layout/js/revolutionslider/css/custom.css">
			<link rel="stylesheet" href="'.$host_addr.'_layout/js/bxslider/jquery.bxslider.css">
			<link rel="stylesheet" href="'.$host_addr.'_layout/js/magnificpopup/magnific-popup.css">
			<link rel="stylesheet" href="'.$host_addr.'_layout/js/owlcarousel/owl.carousel.css">
			<link rel="stylesheet" href="'.$host_addr.'_layout/js/animations/animate.min.css">
			<link rel="stylesheet" href="'.$host_addr.'_layout/js/itplayer/css/YTPlayer.css">
			<link rel="stylesheet" href="'.$host_addr.'_layout/js/odometer/odometer.css">
			<link rel="stylesheet" href="'.$host_addr.'_layout/css/skins/default.css" id="executive-skin">
			<link rel="stylesheet" href="'.$host_addr.'_layout/css/skins/blue.css">
	';
	// for collecting custom scripts
	$bodyscripts='
			<!-- /// ViewPort ////////  -->
			<script src="'.$host_addr.'_layout/js/viewport/jquery.viewport.js"></script>
		    
		    <!-- /// Easing ////////  -->
			<script src="'.$host_addr.'_layout/js/easing/jquery.easing.1.3.js"></script>

		    <!-- /// SimplePlaceholder ////////  -->
			<script src="'.$host_addr.'_layout/js/simpleplaceholder/jquery.simpleplaceholder.js"></script>

		    <!-- /// Fitvids ////////  -->
		    <script src="'.$host_addr.'_layout/js/fitvids/jquery.fitvids.js"></script>
		    
		    <!-- /// Animations ////////  -->
		    <script src="'.$host_addr.'_layout/js/animations/animate.js"></script>
		     
		    <!-- /// Superfish Menu ////////  -->
			<script src="'.$host_addr.'_layout/js/superfish/hoverIntent.js"></script>
		    <script src="'.$host_addr.'_layout/js/superfish/superfish.js"></script>
		    
		    <!-- /// Revolution Slider ////////  -->
		    <script src="'.$host_addr.'_layout/js/revolutionslider/js/jquery.themepunch.tools.min.js"></script>
		    <script src="'.$host_addr.'_layout/js/revolutionslider/js/jquery.themepunch.revolution.min.js"></script>
		    
		    <!-- /// bxSlider ////////  -->
			<script src="'.$host_addr.'_layout/js/bxslider/jquery.bxslider.min.js"></script>
		    
		   	<!-- /// Magnific Popup ////////  -->
			<script src="'.$host_addr.'_layout/js/magnificpopup/jquery.magnific-popup.min.js"></script>
		    
		    <!-- /// Isotope ////////  -->
			<script src="'.$host_addr.'_layout/js/isotope/imagesloaded.pkgd.min.js"></script>
			<script src="'.$host_addr.'_layout/js/isotope/isotope.pkgd.min.js"></script>
		    
		    <!-- /// Parallax ////////  -->
			<script src="'.$host_addr.'_layout/js/parallax/jquery.parallax.min.js"></script>

			<!-- /// EasyPieChart ////////  -->
			<!-- // <script src="'.$host_addr.'_layout/js/easypiechart/jquery.easypiechart.min.js"></script> -->
		    
			<!-- /// YTPlayer ////////  -->
			<script src="'.$host_addr.'_layout/js/itplayer/jquery.mb.YTPlayer.js"></script>
			
		    <!-- /// Easy Tabs ////////  -->
		    <script src="'.$host_addr.'_layout/js/easytabs/jquery.easytabs.min.js"></script>	
		    
		    <!-- /// Form validate ////////  -->
		    <script src="'.$host_addr.'_layout/js/jqueryvalidate/jquery.validate.min.js"></script>
		    
			<!-- /// Form submit ////////  -->
		    <script src="'.$host_addr.'_layout/js/jqueryform/jquery.form.min.js"></script>
		     <!-- /// OwlCarousel ////////  -->
		    <script src="'.$host_addr.'_layout/js/owlcarousel/owl.carousel.min.js"></script>.
		    <!-- /// gMap ////////  -->
			<!-- // <script src="http://maps.google.com/maps/api/js?sensor=false"></script> -->
			<!-- // <script src="'.$host_addr.'_layout/js/gmap/jquery.gmap.min.js"></script> -->

			<!-- /// Twitter ////////  -->
		    <script src="'.$host_addr.'_layout/js/twitter/twitterfetcher.js"></script>
		    
		    <!-- /// Odometer ////////  -->
		    <script src="'.$host_addr.'_layout/js/odometer/odometer.min.js"></script>
			
			<!-- /// Custom JS ////////  -->
			<script src="'.$host_addr.'_layout/js/plugins.js"></script>	
			<script src="'.$host_addr.'_layout/js/scripts.js"></script>
		    
		    <!-- /// Style Switcher ////////  -->
			<script src="'.$host_addr.'_layout/js/switcher/jquery_cookie.js"></script>
		    <script src="'.$host_addr.'_layout/js/switcher/switcher.js"></script>
	';
	$toplinks='
		<nav>					
			<ul class="sf-menu fixed" id="menu">
				<li class="">
					<a href="'.$host_addr.'index.php">Home</a>
				</li>
				<li class="">
					<a href="'.$host_addr.'howitworks.php">How it Works</a>
				</li>
				<li class="">                        	
					<a href="'.$host_addr.'featuredads.php">Featured Ads</a>
				</li>
				<li class="">
					<a href="'.$host_addr.'blog.php">Blog</a>
				</li>
				<li class="">
					<a href="'.$host_addr.'signupin.php">Login/Register</a>
				</li>
				<li class="">
					<a href="'.$host_addr.'faq.php">FAQ</a>
				</li>
			</ul>	
		</nav>
	';
	$headerdescription = convert_html_to_text($outs['introparagraph']);
	$headerdescription=html2txt($headerdescription);
	$nextblogout="End of posts here";
	$nextlink="##";
	$nextquery="SELECT * FROM blogentries WHERE blogtypeid=$blogtypeid AND id>$blogentryid AND status='active'";
	$nextrun=mysql_query($nextquery)or die(mysql_error()." Line 1847");
	$nextnumrows=mysql_num_rows($nextrun);
	if($nextnumrows>0){
		$nextrow=mysql_fetch_assoc($nextrun);
		$nextouts=getSingleBlogEntry($nextrow['id']);
		$nextblogout=$nextouts['title'];
		$nextlink=$nextouts['pagelink'];
	}

	$prevblogout="End of posts here";
	$prevlink="##";
	$prevquery="SELECT * FROM blogentries WHERE blogtypeid=$blogtypeid AND id<$blogentryid AND status='active' ORDER BY id DESC";
	// $previd=$blogentryid-1;
	$prevrun=mysql_query($prevquery)or die(mysql_error()." Line 1847");
	$prevnumrows=mysql_num_rows($prevrun);
	if($prevnumrows>0){
		$prevrow=mysql_fetch_assoc($prevrun);	
		$prevouts=getSingleBlogEntry($prevrow['id']);
		$prevblogout=$prevouts['title'];
		$prevlink=$prevouts['pagelink'];
	}

	// produce recent blog posts
	$recents="";
	$recents2="";
	$recquery="SELECT * FROM blogentries WHERE status='active' order by id desc LIMIT 0,3";
	$recrun=mysql_query($recquery)or die(mysql_error()." Line 1835");
	while($recrow=mysql_fetch_assoc($recrun)){
		$outrec=getSingleBlogEntry($recrow['id']);
		$recents.=$outrec['blogminioutput'];
		$recents2.=$outrec['blogminioutputtwo'];
	}
	// produce recent SPECIFIC blog posts
	$recentspecific="";
	$recentspecific2="";
	$recquery="SELECT * FROM blogentries WHERE blogtypeid=$blogtypeid AND status='active' order by id desc LIMIT 0,3";
	$recrun=mysql_query($recquery)or die(mysql_error()." Line 1835");
	while($recrow=mysql_fetch_assoc($recrun)){
		$outrec=getSingleBlogEntry($recrow['id']);
		$recentspecific.=$outrec['blogminioutput'];
		$recentspecific2.=$outrec['blogminioutputtwo'];
	}
	// produce popular blog posts
	$popular="";
	$popular2="";
	$popquery="SELECT * FROM blogentries WHERE status='active' order by views desc LIMIT 0,3";
	$poprun=mysql_query($popquery)or die(mysql_error()." Line 1835");
	while($poprow=mysql_fetch_assoc($poprun)){
		$outpop=getSingleBlogEntry($poprow['id']);
		$popular.=$outpop['blogminioutput'];
		$popular2.=$outpop['blogminioutputtwo'];
	}
	// produce popular SPECIFIC blog posts
	$popularspecific="";
	$popularspecific2="";
	$popquery="SELECT * FROM blogentries WHERE blogtypeid=$blogtypeid AND status='active' order by views desc LIMIT 0,3";
	$poprun=mysql_query($popquery)or die(mysql_error()." Line 1835");
	while($poprow=mysql_fetch_assoc($poprun)){
		$outpop=getSingleBlogEntry($poprow['id']);
		$popularspecific.=$outpop['blogminioutput'];
		$popularspecific2.=$outpop['blogminioutputtwo'];
	}
	//
	$catpostsquery="SELECT * FROM blogentries WHERE blogcatid=$blogcatid AND blogtypeid=$blogtypeid AND id<$blogentryid AND status='active' order by id desc";
	$catpostrun=mysql_query($catpostsquery)or die(mysql_error()." Line 1867");
	$catnumrow=mysql_num_rows($catpostrun);
	$tinyoutput="No more posts for this ";
	$count=0;
	$catids=array();
	$curlastid="";
	if($catnumrow>0){
	  // echo $catnumrow;
	$tinyoutput="";
	while($catpostrow=mysql_fetch_assoc($catpostrun)){
	$outcatpost=getSingleBlogEntry($catpostrow['id']);
	$catids[]=$catpostrow['id'];
	if($count<15){
	  // echo "inhere";
	$tinyoutput.=$outcatpost['blogtinyoutput'];
	$curlastid=$catpostrow['id'];
	}
	$count++;
	}
	}
	$lastvalidkey=array_search($curlastid,$catids);
	if($lastvalidkey<1||$lastvalidkey==""){
	$nextcatpostentryid=0;
	}else{
	$catpostnextid=$lastvalidkey+1;
	if(array_key_exists($catpostnextid,$catids)){

	$nextcatpostentryid=$catids[$catpostnextid];
	}else{
		$nextcatpostentryid="";
	}
	if(!in_array($nextcatpostentryid,$catids)){
	$nextcatpostentryid=0;
	}
	}
	$commentcount=$outs['commentcount'];
	if($commentcount>0){
	$comments=$outs['viewercomment'];
	}else{
		$comments="No comments yet";
	}
	$subimgpos='';
	$pagetag="";
	$feedjitsidebar="";
	$quoteout="";
	$pagetypemini="";
	if($outs2['id']==1){
		$pagetag='';
		$pagetypemini="fs";
		$subimgpos='
			<div id="subimglogo" class="subimgpostwo">
				<img src="../../images/franklyspeakingtwo.png" style="width: 100%;position: relative;left: 5px;top: 3px;" class="">
			</div>
		';
	$descbanner='
	<div id="formend">
	      <img src="'.$host_addr.'images/mabanner3.jpg" style="width:100%;"/>
	</div>
	    ';
	// $feedjitsidebar=file_get_contents('../../snippets/feedjitblogpage.php');
	/*$outsquote=getAllQuotes('viewer','','general');
	$quoteout=$outsquote['randomoutput'];*/
	}
	$pagesidecontent='
					<!--<div class="widget widget_search">
                    
                        <form action="#" class="searchform" id="searchform" method="POST" name="searchform">
                            <div>                                
                                <input id="t" name="t" type="hidden" value="blog"> 
                                <input id="s" name="s" type="text" placeholder="Search" value=""> 
                                <input id="searchsubmit" type="submit" value="">
                            </div>
                        </form>
                        
                    </div>--><!-- end .widget_search -->
                    <div class="widget ewf_widget_surveysocial">      
                        <h3 class="headline widget-title">Share This</h3>
                        <div class="totalwidth">
                        	'.$outs['blogpageshare'].'
                        </div>
                    </div><!-- end .ewf_widget_surveysocial -->
                    <div class="widget widget_categories">
                       
                        <h3 class="widget-title">Categories</h3>
                    
                        <ul>
                            '.$catout['linkouttwo'].'
                        </ul>
                        
                    </div><!-- end .widget_categories -->
                    
                    
                    
                    <div class="widget ewf_widget_newsletter">
                            
                        <h3 class="widget-title">Subscribe to Adsbounty</h3>
                        
                        <form id="newsletter-subscribe-form" action="'.$host_addr.'snippets/basicsignup.php" method="POST">
                            <div id="formstatus"></div>
                            <fieldset>
                                <input type="hidden" name="entryvariant" value="adsbountyblogsubscription"/>
                                <input type="text" name="email" placeholder="Enter your email address">
                                <input class="btn" type="submit" name="submit" value="Subscribe me!">
                            </fieldset>
                        </form>
                        
                    </div><!-- end .ewf_widget_newsletter -->
                    
                    <div class="widget ewf_widget_latest_posts">
                    	
                        <h3 class="widget-title">Latest Posts</h3>
                        
                        <div class="latest-posts-slider">
                            <ul class="slides">
                        	   '.$recentspecific.'
                            </ul>                                                        
                            
                        </div><!-- end .latest-posts-slider -->
                        
                        <div class="slider-control">
                            <span id="prev"></span>
                            <span id="next"></span>
                        </div><!-- end .slider-control -->
                        
                    </div><!-- end .ewf_widget_most_viewed_posts -->
                    <div class="widget ewf_widget_most_viewed_posts">
                    	
                        <h3 class="widget-title">Most Viewed posts</h3>
                        
                        <div class="most-viewed-posts-slider">
                            <ul class="slides">
                        	   '.$popularspecific.'
                            </ul>                                                        
                            
                        </div><!-- end .latest-posts-slider -->
                        
                        <div class="slider-control">
                            <span id="prevmostviewed"></span>
                            <span id="nextmostviewed"></span>
                        </div><!-- end .slider-control -->
                        
                    </div><!-- end .ewf_widget_Most_viewed_posts -->
	';
	$logoout='<a href="'.$host_addr.'index.php">
                <img src="'.$host_addr.'images/adsbounty5.png" alt="AdsBounty">
            </a>';
	$advertsidecontent='';
	$advertbottomcontent='';
	$adbannerquery="SELECT * FROM adverts WHERE type='banneradvert' and activepage='$pagetypemini' AND status='active' OR type='banneradvert' and activepage='all' AND status='active' order by id desc";
	$adbannerrun=mysql_query($adbannerquery)or die(mysql_error()."Line 2497");
	$adbannernumrow=mysql_num_rows($adbannerrun);
	if($adbannernumrow>0){
		while($adbannerrow=mysql_fetch_assoc($adbannerrun)){
			$adid=$adbannerrow['id'];
			$outbanner=getSingleAdvert($adid);
			$advertbottomcontent.=$outbanner['vieweroutput'];
		}
	}
	$adminiquery="SELECT * FROM adverts WHERE type='miniadvert' and activepage='$pagetypemini' AND status='active' OR type='videoadvert' and activepage='$pagetypemini' AND status='active' OR type='miniadvert' and activepage='all' AND status='active' OR type='videoadvert' and activepage='all' AND status='active' order by id desc";
	$adminirun=mysql_query($adminiquery)or die(mysql_error()."Line 2497");
	$admininumrow=mysql_num_rows($adminirun);
	if($admininumrow>0){
		while($adminirow=mysql_fetch_assoc($adminirun)){
			$adid=$adminirow['id'];
			$outmini=getSingleAdvert($adid);
			$advertsidecontent.=$outmini['vieweroutput'];
		}
	}
	$outgallery=getAllGalleries("viewer","");
	// echo $headerdescription;
	$maincontentstyle="";
	$adcontentholdstyle="";
	$adcontentholdlongstyle="";
	// produce blog display output
	if($outs['blogentrytype']==""||$outs['blogentrytype']=="normal"){
	$blogdisplayoutput='
        <div class="blog-post-thumb">	
	        <img src="'.$outs['absolutecover'].'" alt="">
        </div><!-- end .blog-post-thumb -->
		'.$outs['blogpostout'].'
	';
	}elseif ($outs['blogentrytype']=="gallery") {
	  # code...
	  $blogdisplayoutput=$outs['vfalbum'];
	}elseif ($outs['blogentrytype']=="banner") {
	  # code...
	$blogdisplayoutput='
		<img src="'.$outs['bannermain'].'" style="width:100%;"/>
	';
	$maincontentstyle='style="width:100%;"';
	$adcontentholdstyle='style="width:100%;"';
	$adcontentholdlongstyle='
		<style type="text/css">
		  #adcontentholdlong{
			  	float: left;
				margin-left: 6%;
				max-width: 258px;
		  }
		</style>
	';
	}
	$outputs=array();
	$bgstyle[0]="blogpagemain";
	// $bgstyle[1]="blogpageone";
	// $bgstyle[2]="blogpagetwo";
	// $bgstyle[3]="blogpagethree";
	$bgout=$bgstyle[rand(0,count($bgstyle)-1)];
	$outputs['outputpageone']="";
	$ga="
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-49730962-1', 'muyiwaafolabi.com');
		  ga('send', 'pageview');
		</script>
	";
	$ogimage=str_replace(" ","%20",$outs['absolutecover']);
	$ogimage=str_replace("./","../../",$outs['absolutecover']);
	$facebooksdk='<div id="fb-root"></div><script>  window.fbAsyncInit = function() {    FB.init({      appId      : \'1406231673004362\',      xfbml      : true,      version    : \'v2.2\'    });  };  (function(d, s, id){     var js, fjs = d.getElementsByTagName(s)[0];     if (d.getElementById(id)) {return;}     js = d.createElement(s); js.id = id;     js.src = "//connect.facebook.net/en_US/sdk.js";     fjs.parentNode.insertBefore(js, fjs);   }(document, \'script\', \'facebook-jssdk\'));</script><!-- For google plus --><script type="text/javascript">  (function() {    var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;    po.src = \'https://apis.google.com/js/platform.js\';    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);  })();</script><!-- For twitter --><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\'://platform.twitter.com/widgets.js\';fjs.parentNode.insertBefore(js,fjs);}}(document, \'script\', \'twitter-wjs\');</script><!-- For LinkedIn --><script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script><script type="text/javascript">// console.log(typeof(FB ))  if(typeof(FB)=="undefined"){  }else{  FB.XFBML.parse();  }  if(typeof(twttr)=="undefined"){  }else{  twttr.widgets.load();  }  if(typeof(IN)=="undefined"){  }else{      IN.parse();  }</script><script>if(typeof($.mobile)=="undefined"){  var windowheight=$(window).height();$(\'div#main\').css("min-height",""+windowheight+"px");}</script>';
	$panelsnippet='
	<div data-role="panel" appdata-name="responsivepanel" appdata-monitor="responsiveplain" appdata-state="" data-display="push" data-theme="b" id="nav-panel" class="ui-panel ui-panel-position-left ui-panel-display-push ui-body-b ui-panel-animate ui-panel-open">
	    <div class="ui-panel-inner"><ul data-role="listview" class="ui-listview">
		    <li data-icon="delete"class="ui-first-child"><a href="#" data-rel="close" onClick="responsiveMenu()" class="ui-btn ui-btn-icon-right ui-icon-delete">Close</a></li>
		        <li><a href="'.$host_addr.'index.php" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Home</a></li>
		        <li><a href="'.$host_addr.'portfolio.php" data-transition="flip" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Portfolio</a></li>
		        <li><a href="'.$host_addr.'blog.php" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Blog</a></li>
		        <li><a href="'.$host_addr.'videochannel.php" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Video Channel</a></li>
		        <li><a href="'.$host_addr.'audiochannel.php" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Audio Channel</a></li>
		        <li><a href="'.$host_addr.'about.php" class="ui-btn ui-btn-icon-right ui-icon-carat-r">About</a></li>
		</ul></div>
	</div>
	';
			!isset($activemainlink)?$activemainlink="":$activemainlink=$activemainlink;
			!isset($activemainlink2)?$activemainlink2="":$activemainlink2=$activemainlink2;
			!isset($activemainlink3)?$activemainlink3="":$activemainlink3=$activemainlink3;
			!isset($activemainlink4)?$activemainlink4="":$activemainlink4=$activemainlink4;
			!isset($activemainlink5)?$activemainlink5="":$activemainlink5=$activemainlink5;
			!isset($activemainlink6)?$activemainlink6="":$activemainlink6=$activemainlink6;
			!isset($activemainlink7)?$activemainlink7="":$activemainlink7=$activemainlink7;

	/*$toplinks='
			<a href="'.$host_addr.'index.php" name="home" title="Welcome to Adsbounty Website" class="'.$activemainlink.'"><li class="">Home</li></a>
			<a href="'.$host_addr.'portfolio.php" name="" title="CHeck out Bayonle\'s Portfolio, see for yourself what he has done and is capable of" data-transition="flip" class="'.$activemainlink3.'"><li>Portfolio</li></a>
			<a href="'.$host_addr.'blog.php" name="" title="Adsbounty Official Blog" class="'.$activemainlink2.'" data-ajax="false"><li>Blog</li></a>
			<a href="'.$host_addr.'videochannel.php" name="" title="Visit this page for viewing exciting videos from Administrator" class="'.$activemainlink4.'"><li>Video Channel</li></a>
			<a href="'.$host_addr.'audiochannel.php" name="" title="Visit this page for listening to radio broadcasts from Administrator" class="'.$activemainlink5.'"><li>Audio Channel</li></a>
			<a href="'.$host_addr.'about.php" name="" title="About Midas" class="'.$activemainlink6.'"><li>About</li></a>
	';*/
	
	
	!isset($activepage)?$activepage=" ":$activepage=$activepage;
	$responsivelinkpaneldisplay='
		<div class="selectlinks">
			<a href="#nav-panel" data-icon="bars" onClick="responsiveMenu()" data-iconpos="notext" style="" class="ui-link ui-btn-left ui-btn ui-icon-bars ui-btn-icon-notext ui-shadow ui-corner-all forcedminilink" data-role="button" role="button">Menu</a>
		    <h1 class="curpagemini">'.$activepage.'</h1>
		    <!-- <a href="#add-form" class="pull-right" data-icon="gear" data-iconpos="notext">Add</a> -->
		</div>
	';
	/*main advert section control*/
	$activepage="Blog";
	$activemainlink2="activemainlink";
	$outsads=getAllAdverts("viewer","","banneradvert","all;$activepage");
	$outsadsmini=getAllAdverts("viewer","","miniadvert","all;$activepage");
	if($outs['status']=="active"){
		$outputs['outputpageone']='
		<!DOCTYPE html>
		<html>
		<head>
		<title>'.stripslashes($outs['title']).'</title>
		<meta http-equiv="Content-Language" content="en-us">
		<meta charset="utf-8"/>
		<meta http-equiv="Content-Type" content="text/html;"/>
		<meta property="fb:app_id" content="578838318855511"/>
		<meta property="fb:admins" content=""/>
		<meta property="og:locale" content="en_US">
		<meta property="og:type" content="website">
		<meta property="og:title" content="'.stripslashes($outs['title']).'">
		<meta property="og:description" content="'.$headerdescription.'">
		<meta property="og:url" content="'.$outs['pagelink'].'">
		<meta property="og:site_name" content="Adsbounty Website">
		<meta property="og:image" content="'.$ogimage.'">
		<meta name="keywords" content="'.stripslashes($outs['title']).', Midas football Academy,Administrator Ahmed, Administrator, Broadcast Entrprenure, Football Scout in Nigeria, Broadcast content provider"/>
		<meta name="description" content="'.stripslashes($outs['title']).''.$headerdescription.'">
		<link rel="icon" href="'.$host_addr.'images/favicon2.ico" sizes="16x16 32x32 64x64" type="image/vnd.microsoft.icon">
		<link rel="stylesheet" href="'.$host_addr.'font-awesome/css/font-awesome.min.css"/>
		'.$bodystyles.'
		<script src="'.$host_addr.'scripts/jquery.js"></script>
		<script src="'.$host_addr.'scripts/mylib.js"></script>
		<script src="'.$host_addr.'scripts/responsive.js"></script>
		<script src="'.$host_addr.'scripts/formchecker.js"></script>
		<script src="'.$host_addr.'scripts/adsbounty.js"></script>
		<script language="javascript" type="text/javascript" src="'.$host_addr.'scripts/js/tinymce/jquery.tinymce.min.js"></script>
		<script language="javascript" type="text/javascript" src="'.$host_addr.'scripts/js/tinymce/tinymce.min.js"></script>
		<script language="javascript" type="text/javascript" src="'.$host_addr.'scripts/js/tinymce/basic_config.js"></script>
	  </head>
	  <body>
	    <noscript>
	        <div class="javascript-required">
	            <i class="fa fa-times-circle"></i> You seem to have Javascript disabled. This website needs javascript in order to function properly!
	        </div>
	    </noscript>
	    '.$facebooksdk.'
		    
		<div id="wrap">
			
			<div id="header">
	        
				<!-- /// HEADER  //////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

					<div class="row">
						<div class="span3">
						
							<!-- // Logo // -->
							
		                    <div id="logo">
		                        '.$logoout.'
		                        
		                    </div><!-- end #logo -->
						
						</div><!-- end .span3 -->
						<div class="span9">
						
							<!-- // Mobile menu trigger // -->
							
		                	<a href="#" id="mobile-menu-trigger">
		                    	<i class="fa fa-bars"></i>
		                    </a>
		                    
							
							
							<!-- // Menu // -->
							
							'.$toplinks.'

						</div><!-- end .span9 -->
					</div><!-- end .row -->		

				<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

			</div><!-- end #header -->
			<div id="content">
				<div id="page-header">
	                <div class="row">
	                	<div class="span12">
                        	<img src="'.$host_addr.'images/slideimgs/slide2.jpg" class="posabsbannerimg"/>
	                    	
	                        <h1>
	                        	Blog Post 
	                            <small></small>
	                        </h1>
	                        
	                    </div><!-- end .span12 -->
	                </div><!-- end .row -->
	            </div>
	            <div class="row">
	            	<div class="span8">
	            		<div class="blog-post">                    	
			                <div class="blog-post-info">
			                	'.$outs['datedata'].'
			                    <small>'.$outs['monthout'].'</small>
			                </div><!-- end .blog-post-info -->
			                
			                <div class="blog-post-title">
			                	
			                    <h4>'.$outs['title'].'</h4>
			                                                
			                    <a href="../../#">'.$outs3['catname'].'</a> | 
			                    <a href="../../#">Views '.$outs['views'].'</a> | by 
			                    <a href="../../#">Administrator</a>                            
			                </div><!-- end .blog-post-title -->
			                '.$blogdisplayoutput.'      
			            </div><!-- end .blog-post -->
				      <div class="prevblogpointer">
				        <a href="'.$prevlink.'"title="'.$prevblogout.'">'.$prevblogout.'</a>
				        <i class="fa fa-arrow-circle-left" appdata-name=""></i>
						Previous Post
				      </div>
				      <div class="nextblogpointer">
				       Up Next <i class="fa fa-arrow-circle-right" appdata-name=""></i>
				        <a href="'.$nextlink.'" title="'.$nextblogout.'">'.$nextblogout.'</a>
				      </div>
		                    <div id="comments" class="comments-area">
		                        <h2 class="comments-title">Comments</h2>
								  '.$alerter.'
								<ol class="commentlist">
								  	'.$outs['viewercomment'].'
								</ol>
		               		</div><!-- #comments .comments-area -->

				        <div id="form" appdata-name="commentsform" style="background-color:#fefefe;">
				          <form action="'.$host_addr.'snippets/basicsignup.php" name="blogcommentform" method="post">
				            <input type="hidden" name="entryvariant" value="createblogcomment"/>
				            <input type="hidden" name="sectester" value="'.$securitynumber.'"/>
				            <input type="hidden" name="blogentryid" value="'.$blogentryid.'"/>
				            <div id="formheader">Add a Comment</div>
				            * means the field is required.
				            <div class="row">
				              <div class="span4">
				                Name *
				                <input type="text" name="name" Placeholder="Firstname Lastname" class="curved maxplain"/>
				              </div>
				              <div class="span4">
				                Email *
				                <input type="text" name="email" Placeholder="Your email here" class="curved maxplain"/>
				              </div>
				              <div class="span4">
				                Security('.$securitynumber.');
				                <input type="text" name="secnumber" Placeholder="The above digits here" class="curved maxplain"/>
				              </div>
				            </div>
 			                <div class="row">
			                	Comment:
			                	<textarea name="comment" id="postersmall" Placeholder="" class="curved3"></textarea>
			                </div>

				            <div id="formend">
				              <input type="button" name="createblogcomment" value="Submit" class="submitbutton"/>
				              <br><!--By clicking the submit button, you are agreeing to:-->
				            </div>
				          </form>
				        </div>
		            	</div>
		            	<div class="span4">
		            		'.$pagesidecontent.'
		            	</div>
		            </div>
		        </div>
		        '.$footermain.'
		    </div>
		</div>
		'.$bodyscripts.'
	  </body>
    </html>
	';

	}else if($outs['status']=="inactive"){
		$outputs['outputpageone']='
		<!DOCTYPE html>
		<html>
		<head>
		<title>Post Disabled</title>
		<meta http-equiv="Content-Language" content="en-us">
		<meta charset="utf-8"/>
		<meta http-equiv="Content-Type" content="text/html;"/>
		<meta property="fb:app_id" content="578838318855511"/>
		<meta property="fb:admins" content=""/>
		<meta property="og:locale" content="en_US">
		<meta property="og:type" content="website">
		<meta property="og:title" content="'.$outs['title'].'">
		<meta property="og:description" content="'.$headerdescription.'">
		<meta property="og:url" content="'.$outs['pagelink'].'">
		<meta property="og:site_name" content="Muyiwa Afolabi\'s Website">
		<meta property="og:image" content="'.$outs['absolutecover'].'">
		<meta name="keywords" content="'.$outs['title'].', Muyiwa Afolabi, muyiwa afolabi, frontiers consulting, frankly speaking with muyiwa afolabi, frankly speaking, motivational speaker in nigeria, business strategists in the world, reformation packages, Christ Society International Outreach, Project Fix Nigeria, Own Your Own, Nigerian career radio talk show"/>
		<meta name="description" content="'.$outs['title'].'">
		<link rel="stylesheet" href="../../stylesheets/muyiwamain.css"/>
		<link rel="shortcut icon" type="image/png" href="../../images/muyiwaslogo.png"/>
		</head>
		<body>
			<div id="main">
			<div id="toppanel">
				<div id="mainheaderdesigndisplayhold">
					<div id="mainheaderdesigndisplay">
					</div>
				</div>
				<div id="mainlogopanel">
					<div id="mainimglogo" style="position:relative;">
						'.$logocontrol.'
					</div>
					'.$subimgpos.'
				</div>
				<div id="linkspanel">
					<ul>
						'.$toplinks.'
					</ul>
				</div>
			</div>

		<div id="contentpanel">
			<div id="contentmiddle">
				<div id="maincontenthold">
				<div name="specialheader" style="font-family:ebrima;font-size:40px;clear:both;">Post Disabled</div><br>	
					<div class="blogfulldetails">
					We are sorry but this blog post for some reason or the other has been disabled.
					</div>
				</div>
				<div id="adcontentholder">
				'.$pagesidecontent.'
				'.$advertsidecontent.'
				</div>
			</div>
			
		</div>
			<div id="footerpanel">
				<div id="footerpanelcontent">
					<div id="copyright">
			'.$footer.'
					</div>
				</div>
			</div>
			</div>
		</body>
		</html>
		';
	}
		// $outputs['outputpageone']=$outputs['outputpagetwo'];

	if(isset($_SESSION['bantype'])&&$_SESSION['bantype']=="trepid"){
	$bantype="trepid";
		$outputs['outputpageone']=$outputs['outputpagetwo'];
	}
	// echo $outs['status'];
	return $outputs;
}

function getSingleGallery($galleryid){
	global $host_addr,$host_target_addr,$glob_options;
	$row=array();
	$query="SELECT * FROM gallery WHERE id=$galleryid";
	$run=mysql_query($query)or die(mysql_error()." Line 2627");
	$row=mysql_fetch_assoc($run);
	$id=$row['id'];
	$gallerytype=$row['type'];
	$gallerytitle=$row['gallerytitle'];
	$gallerydetails=$row['gallerydetails'];
	$date=$row['entrydate'];
	$status=$row['status'];
	$outselect="";
	$styledelete="";
	$styleview="";
	$stylecaptiondetail="";
	$row['caption'][0]="";
	$row['imgdetails'][0]="";
	for($i=1;$i<=10;$i++){
		$pic="";
		$i>1?$pic="photos":$pic="photo";		
		$outselect.='<option value="'.$i.'">'.$i.''.$pic.'</option>';
	}
	//get complete gallery images and create thumbnail where necessary;
	$mediaquery="SELECT * FROM media WHERE ownerid=$galleryid AND ownertype='$gallerytype' AND status='active' ORDER BY id DESC";
	// echo $mediaquery;
	$mediarun=mysql_query($mediaquery)or die(mysql_error()." Line 2846");
	$medianumrows=mysql_num_rows($mediarun);
	$album="No album photos yet.";
	$cover='<div id="bottomgalleryholders" title="'.$gallerytitle.'" data-mainimg="" data-images="" data-sizes="" data-details="'.$gallerydetails.'">
	  No Photos Yet.
	</div>';
	$thumbstack="";
	$locationstack="";
	$dimensionstack="";
	$captionstack="";
	$imgdetailstack="";
	$captionedit="";
	$extramsg="";
	$caption="";
	$imgdetails="";
	$trepid="";
	$trepout="";
	$trepcontainer='<div>
	                  <img src="'.$host_addr.'images/portfoliodefault.png" height="500" width="1170" alt="Slider Image">
	                  <div class="captionspace">
	                    <p class="captiontitle"></p>
	                    <p class="captiontext">There are no photos here yet</p>
	                  </div>
	                </div>';
	$trepcap="";
	$treptitle="";
	$gallerytype=="portfoliogallery"||$gallerytype=="bloggallery"?$extramonitor="two":$extramonitor="";
	$gallerytype=="portfoliogallery"||$gallerytype=="bloggallery"?$extraout='<div appdata-name="othergalleryphotoholder"><div></div></div>':$extraout="";
	$mediacount=$medianumrows;
	$maincoverphoto="";
	if($medianumrows>0){
		$count=0;
		$album="";
		$trepcontainer="";
	while ($mediarow=mysql_fetch_assoc($mediarun)) {
		# code...
		$caption="";
		$imgdetails="";
		$trepout="";
		if($count==0){
			$coverphoto=$mediarow['details'];
			$maincoverphoto=$mediarow['location'];
		}
		$row['thumbphotos'][$count]=$mediarow['details'];
		$row['mainphotos'][$count]=$mediarow['location'];
	$imgid=$mediarow['id'];
	$realimg=$mediarow['location'];
	$thumb=$mediarow['details'];
	$width=$mediarow['width'];
	$height=$mediarow['height'];
	$row['dimension'][$count]=$width."x".$height;

	if($gallerytype=="portfoliogallery"||$gallerytype=="bloggallery"){
	$captiondata=$mediarow['title'];
	$captiondata=explode("];[", $captiondata);
	if(count($captiondata)>1){
	$caption=$captiondata[0];
	$imgdetails=$captiondata[1];
	$row['caption'][$count]=$caption;
	$row['imgdetails'][$count]=$imgdetails;
	}
	$treptitle='<p class="captiontitle">'.$caption.'</p>';
	$captionstack==""?$captionstack.=$caption:$captionstack.=">".$caption;
	$trepcap='<p class="captiontext">'.$imgdetails.'</p>';
	if($caption!==""||$imgdetails!==""){
	$trepout='<div class="captionspace">
	            '.$treptitle.'
	            '.$trepcap.'                    
	          </div>';
	}
	$imgdetailstack==""?$imgdetailstack.=$imgdetails:$imgdetailstack.="|".$imgdetails;
	// echo"here";
	$captionedit='<a href="##" name="captiondetails"  title="Edit caption and details for this image, when editpane is in view, click this again to hide it" data-id="'.$imgid.'" data-galleryid="'.$id.'" data-arraypoint="'.$count.'" data-src="'.$host_addr.''.$realimg.'" data-caption="'.$caption.'" data-imgdetails="'.$imgdetails.'"><i name="viewpic" class="fa fa-gear fa-spin"></i></a>';
	$extramsg="Click the gear icon to edit caption and photo details information";
	}

	$locationstack==""?$locationstack.=$host_addr.$realimg:$locationstack.=">".$host_addr.$realimg;
	$dimensionstack==""?$dimensionstack.=$width.",".$height:$dimensionstack.="|".$width.",".$height;
	if($glob_options=="nodelete"){
	$styledelete="display:none;";
	}else{
		
	}
	$album.='
	<div id="editimgs" name="albumimg'.$imgid.'">
		<div id="editimgsoptions">
			<div id="editimgsoptionlinks">
				<a href="##" name="deletepic" style="'.$styledelete.'" data-id="'.$imgid.'"data-galleryid="'.$id.'"data-arraypoint="'.$count.'" data-src="'.$host_addr.''.$realimg.'"><img name="deletepic" src="../images/trashfirst.png" title="Delete this photo?" class="total"></a>
				<a href="##" name="viewpic" data-id="'.$imgid.'" data-galleryid="'.$id.'" data-arraypoint="'.$count.'" data-src="'.$host_addr.''.$realimg.'"><img name="viewpic" src="../images/viewpicfirst.png" title="View full image" class="total"></a>								
				'.$captionedit.'
			</div>
		</div>	
		<div id="editextradatapoint" data-id="'.$imgid.'" data-galleryid="'.$id.'" data-arraypoint="'.$count.'"></div>
		<img src=".'.$mediarow['details'].'" name="realimage" data-width="'.$width.'" data-height="'.$height.'" style="height:100%;margin:auto;">
	</div>
	';
	$trepcontainer.='<div><img src="'.$host_addr.''.$mediarow['location'].'" height="500" width="'.$width.'"/>'.$trepout.'</div>';
	$count++;
	}
	$cover='
	<div id="bottomgalleryholders" title="'.$gallerytitle.'" data-mainimg="'.$host_addr.''.$maincoverphoto.'" data-images="'.$locationstack.'" data-sizes="'.$dimensionstack.'" data-details="'.$gallerydetails.'">
		<img src="'.$host_addr.''.$coverphoto.'" height="100%" class=""/>
	</div>';	
	}
	/*$album.='
	<div id="editimgsimgs" name="albumimg'.$imgid.'">
		<div id="editimgsoptions">
			<div id="editimgsoptionlinks">
				<a href="##" name="deletepic" data-id="'.$imgid.'"><img name="deletepic" src="../images/trashfirst.png" title="Delete this photo?" class="total"></a>
				<a href="##" name="viewpic" data-id="'.$imgid.'"><img name="viewpic" src="../images/viewpicfirst.png" title="View full image" class="total"></a>								
			</div>
		</div>	
		<img src=".'.$mediarow['details'].'" name="realimage" data-width="'.$width.'" data-height="'.$height.'" style="height:100%;margin:auto;">
	</div>
	';*/
	$row['trepgallery']=$trepcontainer;
	$row['adminoutput']='
	<tr data-id="'.$id.'">
		<td>'.$gallerytype.'</td><td>'.$gallerytitle.'</td><td>'.$gallerydetails.'</td><td>'.$mediacount.'</td><td>'.$date.'</td><td>'.$status.'</td><td name="trcontrolpoint"><a href="#&id='.$id.'" name="edit" data-type="editsinglegallery" data-divid="'.$id.'">Edit</a></td>
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
		<form action="../snippets/edit.php" name="editgallery" method="post" enctype="multipart/form-data">
			<input type="hidden" name="entryvariant" value="editgallery"/>
			<input type="hidden" name="entryid" value="'.$id.'"/>
			<input type="hidden" name="gallerytype" value="'.$gallerytype.'"/>
			<div id="formheader">Edit '.$gallerytitle.'</div>
			<div id="formend">
					Gallery Title *<br>
					<input type="text" name="gallerytitle" value="'.$gallerytitle.'" Placeholder="The album title here." class="curved"/>
			</div>
			<div id="formend">
				 Gallery Details*<br>
				<textarea name="gallerydetails" id="" placeholder="Place all details of the album here." class="curved3" style="width:447px;height:206px;">'.$gallerydetails.'</textarea>
			</div>
			<div id="formend">
				Upload some more album photos to this Gallery:<br>
				<input type="hidden" name="piccount'.$extramonitor.'" value=""/>
				<select name="photocount'.$extramonitor.'" class="curved2" title="Choose the amount of photos you want to upload, max of 10, then click below the selection to continue">
				<option value="">--choose amount--</option>
					'.$outselect.'
				</select>	
				'.$extraout.'						
			</div>
			<div id="formend" name="galleryfullholder'.$id.'">
			Gallery Images, click the target icon to view, click the trash icon to.....trash it,'.$extramsg.' its that simple.<br>
			<input type="hidden" name="gallerydata'.$id.'" data-title="'.$gallerytitle.'" data-mainimg="'.$host_addr.''.$maincoverphoto.'" data-images="'.$locationstack.'" data-sizes="'.$dimensionstack.'" data-details="'.$gallerydetails.'"data-captiondetails="'.$caption.'"/>
				'.$album.'
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
				<input type="submit" name="updategallery" value="Update" class="submitbutton"/>
			</div>
		</form>
	</div>
	';
	$row['adminoutputthree']='<input type="hidden" name="gallerydata'.$id.'" data-title="'.$gallerytitle.'" data-mainimg="'.$host_addr.''.$maincoverphoto.'" data-images="'.$locationstack.'" data-sizes="'.$dimensionstack.'" data-details="'.$gallerydetails.'"data-caption="'.$captionstack.'" data-imgdetails="'.$imgdetailstack.'"/>'.$album;
	$row['adminoutputfour']='<input type="hidden" name="gallerydata'.$id.'" data-title="'.$gallerytitle.'" data-mainimg="'.$host_addr.''.$maincoverphoto.'" data-images="'.$locationstack.'" data-sizes="'.$dimensionstack.'" data-details="'.$gallerydetails.'"data-caption="'.$captionstack.'" data-imgdetails="'.$imgdetailstack.'"/>';
	$row['mediacount']=$mediacount;
	$row['maincoverphoto']=$maincoverphoto;

	$row['vieweroutput']=$cover;
	return $row;
}
function getAllGalleries($viewer,$limit){
	$row=array();
	$testit=strpos($limit,"-");
	$testit!==false?$limit="":$limit=$limit;
	if($limit==""&&$viewer=="admin"){
	$query="SELECT * FROM gallery ORDER BY id DESC LIMIT 0,15";
	$rowmonitor['chiefquery']="SELECT * FROM gallery ORDER BY id DESC";
	}elseif($limit!==""&&$viewer=="admin"){
	$query="SELECT * FROM gallery ORDER BY id DESC $limit";
	$rowmonitor['chiefquery']="SELECT * FROM gallery ORDER BY id DESC";
	}elseif($viewer=="viewer"){
	$query="SELECT * FROM gallery WHERE status='active' ORDER BY id DESC ";
	$rowmonitor['chiefquery']="SELECT * FROM gallery WHERE status='active'";	
	}elseif(is_array($viewer)){
		if($viewer[0]=="selection"){
			$ownertype=$viewer[1];
			$query="SELECT * FROM gallery WHERE type='$ownertype' AND status='active' ORDER BY id DESC ";
			$rowmonitor['chiefquery']="SELECT * FROM gallery WHERE type='$ownertype' AND status='active'";	
	/*		$query="SELECT * FROM gallery WHERE ownertype='$ownertype' AND status='active' ORDER BY id DESC ";
			$rowmonitor['chiefquery']="SELECT * FROM gallery WHERE ownertype='$ownertype' AND status='active'";	*/

		}else if($viewer[0]=="specific"){
			$ownerid=$viewer[1];
			$query="SELECT * FROM gallery WHERE id=$ownerid AND status='active' ORDER BY id DESC ";
			$rowmonitor['chiefquery']="SELECT * FROM gallery WHERE id=$ownerid AND status='active'";
		}
	}
	// echo $query;
	$run=mysql_query($query)or die(mysql_error()." Line 2744");
	$numrows=mysql_num_rows($run);
	$adminoutput="<td colspan=\"100%\">No entries</td>";
	$adminoutputtwo="";
	$vieweroutput='<font color="#fefefe">Sorry, No Galleries have been created Yet</font>';
	$vieweroutputtwo='<font color="#fefefe">Sorry, No Galleries have been created Yet</font>';
	$selectionoutput='<option value="">-Choose Gallery-</option>';

	if($numrows>0){
	$adminoutput="";
	$adminoutputtwo="";
	$vieweroutput="";
	while($row=mysql_fetch_assoc($run)){
	$outs=getSingleGallery($row['id']);
	$adminoutput.=$outs['adminoutput'];
	$adminoutputtwo.=$outs['adminoutputtwo'];
	$vieweroutput.=$outs['vieweroutput'];
	$selectionoutput.='<option value="'.$row['id'].'">'.$row['gallerytitle'].'</option>';
	}

	}
	$top='<table id="resultcontenttable" cellspacing="0">
				<thead><tr><th>Type</th><th>Title</th><th>Details</th><th>Photos</th><th>Date</th><th>status</th><th>View/Edit</th></tr></thead>
				<tbody>';
	$bottom='	</tbody>
			</table>';
		$row['chiefquery']=$rowmonitor['chiefquery'];
	$outs=paginatejavascript($rowmonitor['chiefquery']);
	$outsviewer=paginate($rowmonitor['chiefquery']);
	$paginatetop='
	<div id="paginationhold">
		<div class="meneame">
			<input type="hidden" name="curquery" value="'.$rowmonitor['chiefquery'].'"/>
			<input type="hidden" name="outputtype" value="gallery"/>
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
	$row['selectionoutput']=$selectionoutput;

	return $row;
}


?>