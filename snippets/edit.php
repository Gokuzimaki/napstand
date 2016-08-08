<?php
include('connection.php');
session_start();
$entryvariant=mysql_real_escape_string($_POST['entryvariant']);
$entryid=$_POST['entryid'];
$userrequest="";
if(isset($_POST['userrequest'])&&$_POST['userrequest']!==""){
	$userrequest=$_POST['userrequest'];
}
if($entryvariant==""){

}elseif ($entryvariant=="editgallery") {
	# code...
	// // echo "in here";
	$gallerytitle=mysql_real_escape_string($_POST['gallerytitle']);
	genericSingleUpdate("gallery","gallerytitle",$gallerytitle,"id",$entryid);
	$gallerydetails=mysql_real_escape_string($_POST['gallerydetails']);
	genericSingleUpdate("gallery","gallerydetails",$gallerydetails,"id",$entryid);
	$status=mysql_real_escape_string($_POST['status']);
	genericSingleUpdate("gallery","status",$status,"id",$entryid);
	$date=date("d, F Y H:i:s");
	$piccount=$_POST['piccount'];
	//// echo $piccount;
	if($piccount>0){
		for($i=1;$i<=$piccount;$i++){
		$albumpic=$_FILES['defaultpic'.$i.'']['tmp_name'];
	if($albumpic!==""){
	$image="defaultpic".$i."";
	if(isset($imagepath)){
	unset($imagepath);
	unset($imagesize);
	}
	$imagepath=array();
	$imagesize=array();
	$imgpath[0]='../files/medsizes/';
	$imgpath[1]='../files/thumbnails/';
	$imgsize[0]="default";
	$imgsize[1]=",107";
	// // echo count($imgsize);
	$acceptedsize="";
	$imgouts=genericImageUpload($image,"varying",$imgpath,$imgsize,$acceptedsize);
	$len=strlen($imgouts[0]);
	$imagepath=substr($imgouts[0], 1,$len);
	// echo $imgouts[0]."<br>".$len."<br>".$imagepath."<br>";
	$len2=strlen($imgouts[1]);
	$imagepath2=substr($imgouts[1], 1,$len2);
	// echo $imgouts[1]."<br>".$len2."<br>".$imagepath2."<br>";
	// get image size details
	$filedata=getFileDetails($imgouts[0],"image");
	$filesize=$filedata['size'];
	$width=$filedata['width'];
	$height=$filedata['height'];
	// get the cover photo's media table id for storage with the blog entry
	$mediaquery="INSERT INTO media(ownerid,ownertype,details,mediatype,location,filesize,width,height)VALUES('$entryid','gallery','$imagepath2','image','$imagepath','$filesize','$width','$height')";
	$mediarun=mysql_query($mediaquery)or die(mysql_error());
	}
	}
	}
	header('location:../admin/adminindex.php');
}elseif ($entryvariant=="editblogtype") {
	# code...
	$outs=getSingleBlogType($entryid);	
	$blogname=mysql_real_escape_string($_POST['name']);
	$blogdescription=mysql_real_escape_string($_POST['description']);
	$rssname=$outs['rssname'];
	$pattern2='/[\n\$!#\%\^<>@\(\),\'.\"\/\%\*\{\}\&\[\]\?\_\-\+\=:;’]/';
	$pagename=preg_replace($pattern2,"", $blogname);
	$pattern='/[\s]/';
	$pagename=preg_replace($pattern,"-", $pagename);
	$pagename=stripslashes($pagename);
	$foldername=$pagename;
	if($blogname!==""){
	genericSingleUpdate("blogtype","name",$blogname,"id",$entryid);
	genericSingleUpdate("blogtype","foldername",$foldername,"id",$entryid);
	genericSingleUpdate("blogtype","rssname",$rssname,"id",$entryid);
	// $pattern='/[\s]/';
	$pattern='/[\n\$!#\%\^<>@\(\),\'.\"\/\%\*\{\}\&\[\]\?\_\s\-\+\=:;’]/';
	$rssname=preg_replace($pattern,"", $blogname);
	$rssname=strtolower($rssname);
	$rssname=stripslashes($rssname);
	// echo $rssname;
	$targetfeed="../feeds/rss/".$rssname.".xml";
	// rename("../feeds/rss/".$outs['rssname'].".xml","../feeds/rss/".$rssname.".xml");
	/*uodateblog posts with new folder name info*/
	// $popquery="SELECT * FROM blogentries WHERE status='active' order by views desc LIMIT 0,5";
	// $poprun=mysql_query($popquery)or die(mysql_error()." Line 1835");
	// while($poprow=mysql_fetch_assoc($poprun)){
	// $outpop=getSingleBlogEntry($poprow['id']);
	// $popular.=$outpop['blogminioutput'];
	// }
	/*end*/
	if($entryid==1){
	$title='Blog | AdsBounty Website';
	$page='blog.php';
	}/*elseif ($entryid==2) {
		# code...
	$title='Christ Society International Outreach | Bayonle Arashi\'s Website';
	$page='csi.php';
	}elseif ($entryid==3) {
		# code...
	$title='Frankly Speaking Africa | Bayonle Arashi\'s Website';
	$page='franklyspeakingafrica.php';
	}*/else{
		$title=''.$blogname.' | AdsBounty Website';

		$page=''.$blogname.'.php';
	}
	$title=mysql_real_escape_string($title);
	$landingpage=$host_target_addr.$page;
	$rssheader='<?xml version="1.0" encoding="utf-8"?>
	<rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
	<channel>
	<title>'.$title.'</title>
	<atom:link href="'.$host_target_addr.'feeds/rss/'.$rssname.'.xml" rel="self" type="application/rss+xml"/>
	<description>
	'.$outs['description'].'
	</description>
	<link>'.$landingpage.'</link>
	';
	genericSingleUpdate("rssheaders","headerdetails",$rssheader,"blogtypeid",$entryid);
	rename("../blog/".$outs['foldername']."","../blog/".$foldername."");
		}
	//if the blogs description has changed
	if($blogdescription!==""&&$blogdescription!==$outs['description']){
	if($entryid==1){
	$title='Blog | AdsBounty Website';
	$page='blog.php';
	}/*elseif ($entryid==2) {
		# code...
	$title='Christ Society International Outreach | Bayonle Arashi\'s Website';
	$page='csi.php';
	}elseif ($entryid==3) {
		# code...
	$title='Frankly Speaking Africa | Bayonle Arashi\'s Website';
	$page='franklyspeakingafrica.php';
	}*/else{
		$title=''.$outs['name'].' | Adsbounty Website';
		$page=''.$outs['name'].'.php';
	}
	$landingpage=$host_addr.$page;
	$title=mysql_real_escape_string($title);
	$blogdescription=mysql_real_escape_string($blogdescription);
	$rssheader='<?xml version="1.0" encoding="utf-8"?>
	<rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
	<channel>
	<title>'.$title.'</title>
	<atom:link href="'.$host_target_addr.'feeds/rss/'.$rssname.'.xml" rel="self" type="application/rss+xml"/>
	<description>
	'.$blogdescription.'
	</description>
	<link>'.$landingpage.'</link>
	';
	// echo $blogdescription;
	genericSingleUpdate("rssheaders","headerdetails",$rssheader,"blogtypeid",$entryid);
	}
	$status=$_POST['status'];
	genericSingleUpdate("blogtype","status",$status,"id",$entryid);
	writeRssData($entryid,0);

	header('location:../admin/adminindex.php');
}elseif ($entryvariant=="editblogcategory") {
	$outs=getSingleBlogCategory($entryid);
	$blogid=$outs['blogtypeid'];
	$outstwo=getSingleBlogType($outs['blogtypeid']);
	$blogcategoryname=mysql_real_escape_string($_POST['name']);
	$title=''.$outstwo['name'].' | Bayonle Arashi\'s Website';
	$title=mysql_real_escape_string($title);
	/*if(!file_exists("".$host_addr."feeds/rss/".$outs['rssname'].".xml")){

		$query2="INSERT INTO rssheaders (blogtypeid,blogcatid,headerdetails,footerdetails)VALUES('$blogid','$entryid','$rssheader','$rssfooter')";
		$run2=mysql_query($query2)or die(mysql_error()."Line 116");
	}*/
	if($blogcategoryname!==""&&$blogcategoryname!==$outs['catname']){
		$landingpage=$host_target_addr."category.php?cid=".$entryid;
		$pattern2='/[\n\s\$!#\%\^<>@\(\),\'\"\/\%\*\{\}\&\[\]\?\_\-\+\=:;’]/';
		$rssname=preg_replace($pattern2,"", $blogcategoryname);
		$rssname=$outs['blogtypeid'].strtolower($rssname);
		$rssname=mysql_real_escape_string($rssname);	

	$rssheader='<?xml version="1.0" encoding="utf-8"?>
	<rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
	<channel>
	<title>'.$title.'</title>
	<atom:link href="'.$host_target_addr.'feeds/rss/'.$rssname.'.xml" rel="self" type="application/rss+xml"/>
	<description>
	Category: '.mysql_real_escape_string($outs['catname']).'
	</description>
	<link>'.$landingpage.'</link>
	';
	$rsstest=stripslashes($rssname);
	// echo $rssname."<br>";
	// echo $outs['catname']."<br>";
	rename("../feeds/rss/".$outs['rssname'].".xml","../feeds/rss/".$rssname.".xml");
	/*$rssheader='
	<?xml version="1.0" encoding="utf-8"?>
	<rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
	<channel>
	<title>'.$title.'</title>
	<atom:link href="'.$host_target_addr.'feeds/rss/'.$rssname.'.xml" rel="self" type="application/rss+xml"/>
	<description>
	Category: '.$blogcategoryname.'
	</description>
	<link>'.$landingpage.'</link>
	';*/
		genericSingleUpdate("rssheaders","headerdetails",$rssheader,"blogcatid",$entryid);
		genericSingleUpdate("blogcategories","rssname",$rssname,"id",$entryid);
		genericSingleUpdate("blogcategories","catname",$blogcategoryname,"id",$entryid);
		writeRssData(0,$entryid);
	}
	$status=mysql_real_escape_string($_POST['status']);
	genericSingleUpdate("blogcategories","status",$status,"id",$entryid);

	if($outstwo['name']=="Project Fix Nigeria"){
	$subtext=mysql_real_escape_string($_POST['subtext']);
	genericSingleUpdate("blogcategories","subtext",$subtext,"id",$entryid);
	$prevpic=$outs['profpic'];
	$imgid=$outs['profpicid'];
	$realprevpic=".".$prevpic;
	$profpic=$_FILES['profpic']['tmp_name'];
	if($_FILES['profpic']['tmp_name']!==""){
	$image="profpic";
	$imgpath[]='../images/categoryimages/';
	$imgsize[]="default";
	$acceptedsize="";
	$imgouts=genericImageUpload($image,"single",$imgpath,$imgsize,$acceptedsize);
	$len=strlen($imgouts[0]);
	$imagepath=substr($imgouts[0], 1,$len);
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
	genericSingleUpdate("media","location",$imagepath,"id",$imgid);
	genericSingleUpdate("media","filesize",$filesize,"id",$imgid);
	genericSingleUpdate("media","width",$width,"id",$imgid);
	genericSingleUpdate("media","height",$height,"id",$imgid);
	if(file_exists($realprevpic)){
	unlink($realprevpic);
	}
	}

	}
	header('location:../admin/adminindex.php');

}elseif ($entryvariant=="editblogpost") {
	# code...
	$outs=getSingleBlogEntry($entryid);
	$introparagraph=mysql_real_escape_string($_POST['introparagraph']);
	$blogentry=mysql_real_escape_string($_POST['blogentry']);
	$blogentrytype=mysql_real_escape_string($_POST['blogentrytype']);
	// echo $blogentrytype."<br>";
	$title=mysql_real_escape_string($_POST['title']);
	$status=mysql_real_escape_string($_POST['status']);
	$coverstyle=mysql_real_escape_string($_POST['coverstyle']);
	genericSingleUpdate("blogentries","coverphotoset",$coverstyle,"id",$entryid);
	$newpath="";
	$modified="";
	/*	// echo $title."<br>";
	// echo $introparagraph."<br>";
	// echo $blogentry."<br>";
	// echo $outs['title']."<br>";
	// echo $outs['introparagraph']."<br>";*/
	stripslashes($introparagraph)== $outs['title']? $echo="true":$echo="false";
	// // echo $echo;
	if(stripslashes($title)!==$outs['title']){
	// genericSingleUpdate("blogentries","title",$title,"id",$entryid);
	$pattern2='/[\n\$!#\%\^<>@\(\),\'\"\/\%\*\{\}\&\[\]\?\_\-\+\=:;’]/';
	$pagename=preg_replace($pattern2,"", $_POST['title']);
	$pattern='/[\s]/';
	$pagename=preg_replace($pattern,"-", $pagename);
	$pagename=stripslashes($pagename);
	$oldpath="".$outs['rellink']."";
	$newpath="".$outs['reldirectory']."".$pagename.".php";
	// echo $oldpath."<br>";
	// echo $newpath."<br>";
	rename(".".$outs['rellink']."",".".$outs['reldirectory']."".$pagename.".php");
	$pagename=mysql_real_escape_string($pagename);
	genericSingleUpdate("blogentries","title",$title,"id",$entryid);
	genericSingleUpdate("blogentries","pagename",$pagename,"id",$entryid);
	$modified="yes";

	}
	 if (stripslashes($blogentry)!==$outs['blogpost']) {
		# code...
	genericSingleUpdate("blogentries","blogpost",$blogentry,"id",$entryid);
	$modified="yes";

	}
	 if(stripslashes($introparagraph)!==$outs['introparagraph']){
	genericSingleUpdate("blogentries","introparagraph",$introparagraph,"id",$entryid);
	// // echo "in here";
	$modified="yes";

	}
	if($blogentrytype=="banner"){
	$bannerpic=$_FILES['bannerpic']['tmp_name'];
	$realprevpic=$outs['bannermain'];
	$realprevpicthumb=$outs['bannerthumb'];
	genericSingleUpdate("blogentries","introparagraph",$title,"id",$entryid);

if($_FILES['bannerpic']['tmp_name']!==""){
$bannerid=$_POST['bannerid'];
$image="bannerpic";
$imgpath[0]='../files/';
$imgpath[1]='../files/thumbnails';
$imgsize[0]="default";
$imgsize[1]="660,";
$acceptedsize="";
$imgouts=genericImageUpload($image,"varying",$imgpath,$imgsize,$acceptedsize);
$len=strlen($imgouts[0]);
$imagepath=substr($imgouts[0], 1,$len);
$len2=strlen($imgouts[1]);
$imagepath2=substr($imgouts[1], 1,$len2);
// get image size details
$filedata=getFileDetails($imgouts[0],"image");
$filesize=$filedata['size'];
$width=$filedata['width'];
$height=$filedata['height'];
// // echo '<img src="'.$imgouts[0].'"> '.$filesize.' '.$width.' '.$height.'';
// get the cover photo's media table id for storage with the blog entry
genericSingleUpdate("media","location",$imagepath,"id",$bannerid);
genericSingleUpdate("media","details",$imagepath2,"id",$bannerid);
genericSingleUpdate("media","filesize",$filesize,"id",$bannerid);
genericSingleUpdate("media","width",$width,"id",$bannerid);
genericSingleUpdate("media","height",$height,"id",$bannerid);	
if(file_exists($realprevpic)){
unlink($realprevpic);
}
if(file_exists($realprevpicthumb)){
unlink($realprevpicthumb);
}
$modified="yes";

}
}

if($blogentrytype=="gallery"){
	genericSingleUpdate("blogentries","introparagraph",$title,"id",$entryid);
	$piccount=$_POST['piccount'];
	//// echo $piccount;
	if($piccount>0){
	    for($i=1;$i<=$piccount;$i++){
	      $albumpic=$_FILES['defaultpic'.$i.'']['tmp_name'];
	      if($albumpic!==""){
	        $image="defaultpic".$i."";
	        if(isset($imagepath)){
	          unset($imagepath);
	          unset($imagesize);
	        }
	        $imagepath=array();
	        $imagesize=array();
	        $imgpath[0]='../files/originals/';
	        $imgpath[1]='../files/medsizes/';
	        $imgpath[2]='../files/thumbnails/';
	        $imgsize[0]="default";
	        $imgsize[1]=",530";
	        $imgsize[2]=",150";

	        // // echo count($imgsize);
	        $acceptedsize="";
	        $imgouts=genericImageUpload($image,"varying",$imgpath,$imgsize,$acceptedsize);
	        $len=strlen($imgouts[0]);
	        // // echo $imgouts[0]."<br>";
	        $imagepath=substr($imgouts[0], 1,$len);
	        $len2=strlen($imgouts[1]);
	        // // echo $imgouts[1]."<br>";
	        $imagepath2=substr($imgouts[1], 1,$len2);
	        $len3=strlen($imgouts[2]);
	        // // echo $imgouts[1]."<br>";
	        $imagepath3=substr($imgouts[2], 1,$len3);
	        // get image size details
	        $filedata=getFileDetails($imgouts[0],"image");
	        $filesize=$filedata['size'];
	        $width=$filedata['width'];
	        $height=$filedata['height'];
	        $coverid="";
	        // insert current blog gallery content into database as original image and thumbnail
	        $mediaquery="INSERT INTO media
	        (ownerid,ownertype,maintype,mediatype,location,medsize,thumbnail,details,filesize,width,height)
	        VALUES
	        ('$pageid','blogentry','gallerypic','image','$imagepath','$imagepath2','$imagepath3','','$filesize','$width','$height')";
	        $mediarun=mysql_query($mediaquery)or die(mysql_error());
	      }
	    }
	}
}

//change the cover photo if a new one is available
	$profpic=$_FILES['profpic']['tmp_name'];
	$realprevpic=$outs['absolutecover'];
if($_FILES['profpic']['tmp_name']!==""){
$image="profpic";
$imgpath[]='../files/';
$imgsize[]="default";
$acceptedsize=",200";
$imgouts=genericImageUpload($image,"single",$imgpath,$imgsize,$acceptedsize);
$len=strlen($imgouts[0]);
$imagepath=substr($imgouts[0], 1,$len);
// get image size details
$filedata=getFileDetails($imgouts[0],"image");
$filesize=$filedata['size'];
$width=$filedata['width'];
$height=$filedata['height'];
if($outs['coverphoto']>0){
genericSingleUpdate("media","location",$imagepath,"id",$outs['coverphoto']);
genericSingleUpdate("media","filesize",$filesize,"id",$outs['coverphoto']);
genericSingleUpdate("media","width",$width,"id",$outs['coverphoto']);
genericSingleUpdate("media","height",$height,"id",$outs['coverphoto']);	
}else{
	$coverid=getNextId("media");
$mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,filesize,width,height)VALUES('$entryid','blogentry','coverphoto','image','$imagepath','$filesize','$width','$height')";
$mediarun=mysql_query($mediaquery)or die(mysql_error());
genericSingleUpdate("blogentries","coverid",$coverid,"id",$entryid);
}
if(file_exists($realprevpic)){
unlink($realprevpic);
}
$modified="yes";

}
$pagepath=".".$outs['reldirectory']."".$pagename.".php";
$handle = fopen($pagepath, 'w') or die('Cannot open file:  '.$pagepath);
//set the new page up
$pagesetup = '<?php 
session_start();
include(\'../../snippets/connection.php\');
$outpage=blogPageCreate('.$entryid.');
 // echo $outpage[\'outputpageone\'];
$blogdata=getSingleBlogEntry('.$entryid.');
$newview=$blogdata[\'views\']+1;
genericSingleUpdate("blogentries","views",$newview,"id",'.$entryid.');

?>
';
fwrite($handle, $pagesetup);
fclose($handle);
if($modified=="yes"){
$outs2=getSingleBlogEntry($entryid);
$datetime= "".date("D, d M Y H:i:s")." +0100";
if($outs['feeddate']==""){
$feedout=$datetime;
genericSingleUpdate("blogentries","feeddate",$feedout,"id",$entryid);
}else{
$feedout=$outs['feeddate'];
}
$rssentry='<item>
<title>'.$outs2['title'].'</title>
<link>'.$outs2['pagelink'].'</link>
<pubDate>'.$feedout.'</pubDate>
<guid isPermaLink="false">'.$host_addr.'blog/?p='.$entryid.'</guid>
<description>
<![CDATA['.$outs2['introparagraph'].']]>
</description>
</item>
';
// echo'in here';
$rssentry=mysql_real_escape_string($rssentry);
//update feed database
genericSingleUpdate("rssentries","rssentry",$rssentry,"blogentryid",$entryid);
//update feeds
writeRssData($outs2['blogtypeid'],0);
writeRssData(0,$outs2['blogcatid']);
}
if($_FILES['profpic']['tmp_name']!==""){
$modified="yes";
}
$modifydate=date("d, F Y H:i:s");
//update last modified date here of any changes occured
$modified=="yes"?genericSingleUpdate("blogentries","modifydate",$modifydate,"id",$entryid):$modifydate="";
genericSingleUpdate("blogentries","status",$status,"id",$entryid);
header('location:../admin/adminindex.php');
}elseif($entryvariant=="unsubscribeblogtype"){
	$email=mysql_real_escape_string($_POST['email']);
	$typeid=$_POST['typeid'];
	$query="SELECT * FROM subscriptionlist WHERE email='$email' AND blogtypeid=$typeid";
	$run=mysql_query($query)or die(mysql_error()." line 301");
	$numrows=mysql_num_rows($run);
	if($numrows>0){
		$entryid=$row['id'];
		genericSingleUpdate("subscriptionlist","status","inactive",'id',$entryid);
	}
	header('location:../index.php');
}elseif($entryvariant=="unsubscribeblogcategory"){
	$typeid=mysql_real_escape_string($_POST['typeid']);
	$orderfield=array();
	$ordervalues=array();
	$orderfield[]="blogcatid";
	$orderfield[]="id";
	$ordervalues[]=$typeid;
	$ordervalues[]=$entryid;
	genericSingleUpdate("subscriptionlist","status","inactive",$orderfield,$ordervalues);
	header('location:../index.php');
}elseif ($entryvariant=="editsurveycategory") {
	# code...
	$catname=mysql_real_escape_string($_POST['name']);
	$status=mysql_real_escape_string($_POST['status']);
	genericSingleUpdate("surveycategories","catname",$catname,"id",$entryid);
	genericSingleUpdate("surveycategories","status",$status,"id",$entryid);
	header('location:../admin/adminindex.php');

}elseif ($entryvariant=="editfaq") {
	# code...
	$title=mysql_real_escape_string($_POST['title']);
	$content=mysql_real_escape_string($_POST['content']);
	$status=mysql_real_escape_string($_POST['status']);
	genericSingleUpdate("faq","title",$title,"id",$entryid);
	genericSingleUpdate("faq","content",$content,"id",$entryid);
	genericSingleUpdate("faq","status",$status,"id",$entryid);
	header('location:../admin/adminindex.php');

}elseif ($entryvariant=="resetpassword") {
	# code...
	$password=mysql_real_escape_string($_POST['password']);
	$confirmpassword=isset($_POST['confirmpassword'])?mysql_real_escape_string($_POST['confirmpassword']):"";
	$checksum=mysql_real_escape_string($_POST['checksum']);
	if ($password!==""&&$confirmpassword!==""&&$password==$confirmpassword) {
		# code...
		genericSingleUpdate("users","pword",$password,"id",$entryid);
		$orderfields[]="userid";
		$orderfields[]="checksum";
		$ordervalues[]=$entryid;
		$ordervalues[]=$checksum;
		// update resetpassword so the checksum cant be used again
		genericSingleUpdate("resetpassword","status","inactive",$orderfields,$ordervalues);
		if(isset($_POST['rettype'])&&$_POST['rettype']!==""){
			header('location:../reset.php?t=resetdone');
		}else{
			header('location:../index.php?t=reset');
		}
	}else{
		echo "Invalid data transaction, code: 10034";
	}

}elseif ($entryvariant=="rewardcategory") {
	# code...
	$catname=mysql_real_escape_string($_POST['name']);
	$status=mysql_real_escape_string($_POST['status']);
	genericSingleUpdate("rewardtype","typename",$catname,"id",$entryid);
	genericSingleUpdate("rewardtype","status",$status,"id",$entryid);
	header('location:../admin/adminindex.php');

}elseif ($entryvariant=="editclient") {
	# code...
	$clientdata=getSingleClient($entryid);
	$businessname=mysql_real_escape_string($_POST['businessname']);
	genericSingleUpdate("users","businessname",$businessname,"id",$entryid);
	$state=mysql_real_escape_string($_POST['state']);
	genericSingleUpdate("users","state",$state,"id",$entryid);
	$lga=mysql_real_escape_string($_POST['LocalGovt']);
	genericSingleUpdate("users","lga",$lga,"id",$entryid);
	$businessaddress=mysql_real_escape_string($_POST['businessaddress']);
	genericSingleUpdate("users","businessaddress",$businessaddress,"id",$entryid);
	$businessdescription=mysql_real_escape_string($_POST['businessdescription']);
	genericSingleUpdate("users","businessdescription",$businessdescription,"id",$entryid);
	$phoneone=mysql_real_escape_string($_POST['phoneone']);
	$phonetwo=mysql_real_escape_string($_POST['phonetwo']);
	$phonethree=mysql_real_escape_string($_POST['phonethree']);
	if($phoneone=="(234) ___-___-____"){
	    $phoneone="";
	  }
	if($phonetwo=="(234) ___-___-____"){
	    $phonetwo="";
	  }
	if($phonethree=="(234) ___-___-____"){
	    $phonethree="";
	  }
	$phoneout=$phoneone."[|><|]".$phonetwo."[|><|]".$phonethree;
	genericSingleUpdate("users","phonenumber",$phoneout,"id",$entryid);
	$email=mysql_real_escape_string($_POST['email']);
	genericSingleUpdate("users","email",$email,"id",$entryid);
	if(isset($_POST['password'])){
		$password=$_POST['password'];
	}else{
		$password=substr(md5(date("Y d m").time()),0,9);
	}
	genericSingleUpdate("users","pword",$password,"id",$entryid);
	$status=mysql_real_escape_string($_POST['status']);
	genericSingleUpdate("users","status",$status,"id",$entryid);

    
	/*$query="INSERT INTO users(usertype,state,lga,email,pword,phonenumber,businessname,businessdescription,businessaddress,regdate)
	VALUES('client','$state','$lga','$email','$password','$phoneout','$businessname','$businessdescription','$businessaddress',CURRENT_DATE())";
	$run=mysql_query($query)or die(mysql_error()." Line 58");*/
	// // echo $query;
	$bannerlogo=$_FILES['bannerlogo']['tmp_name'];
	$bannerid=$_POST['bannerlogoid'];

    $bizlogo=$_FILES['bizlogo']['tmp_name'];
    $bizid=$_POST['bizlogoid'];
	if($bizlogo!==""){
		$image="bizlogo";
		$imgpath[]='../files/medsizes/';
		$imgsize[]="default";
		$acceptedsize="110,";
		$imgouts=genericImageUpload($image,"single",$imgpath,$imgsize,$acceptedsize);
		$len=strlen($imgouts[0]);
		$imagepath=substr($imgouts[0], 1,$len);
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
		if($bizid>0){
			$prevpic=$clientdata['bizlogofile'];
			$realprevpic=".".$prevpic;
			if(file_exists($realprevpic)&&$realprevpic!=="."){
				unlink($realprevpic);
			}
			genericSingleUpdate("media","location",$imagepath,"id",$bizid);
			genericSingleUpdate("media","filesize",$filesize,"id",$bizid);
			genericSingleUpdate("media","width",$width,"id",$bizid);
			genericSingleUpdate("media","height",$height,"id",$bizid);	

		}else{
			//maintype variants are original, medsize, thumb for respective size image.
			$mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,filesize,width,height)VALUES('$entryid','client','bizlogo','image','$imagepath','$filesize','$width','$height')";
			$mediarun=mysql_query($mediaquery)or die(mysql_error()." Line 582");
		}
		//$coverpicid=getNextId("media");
		//maintype variants are original, medsize, thumb for respective size image.
		/*$mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,filesize,width,height)VALUES('$cid','client','bizlogo','image','$imagepath','$filesize','$width','$height')";
		$mediarun=mysql_query($mediaquery)or die(mysql_error());*/
	}


	if($bannerlogo!==""){
		$image="bannerlogo";
		$imgpath[]='../files/medsizes/';
		$imgsize[]="default";
		$acceptedsize=",460";
		$imgouts=genericImageUpload($image,"single",$imgpath,$imgsize,$acceptedsize);
		$len=strlen($imgouts[0]);
		$imagepath=substr($imgouts[0], 1,$len);
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
		if($bannerid>0){
			// $bannerid=$clientdata['bannerlogoid'];
			$prevpic2=$clientdata['bannerlogofile'];
			$realprevpic2=".".$prevpic2;
			// echo $realprevpic2." prev pic";
			// echo $prevpic2." main prev pic";
			if(file_exists($realprevpic2)&&$realprevpic2!=="."){
				unlink($realprevpic2);
			}
			genericSingleUpdate("media","location",$imagepath,"id",$bannerid);
			genericSingleUpdate("media","filesize",$filesize,"id",$bannerid);
			genericSingleUpdate("media","width",$width,"id",$bannerid);
			genericSingleUpdate("media","height",$height,"id",$bannerid);	

		}else{
			//maintype variants are original, medsize, thumb for respective size image.
			$mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,filesize,width,height)VALUES('$entryid','client','bannerlogo','image','$imagepath','$filesize','$width','$height')";
			$mediarun=mysql_query($mediaquery)or die(mysql_error()." line 628");
		}
	}
    header('location:../admin/adminindex.php');

}elseif ($entryvariant=="edituser") {
	# code...
	$userdata=getSingleUser($entryid);
	$dobchangedate=$userdata['dobchangedate'];
	$genderchangedate=$userdata['genderchangedate'];
	$maritalstatuschangedate=$userdata['maritalstatuschangedate'];
	$statechangedate=$userdata['statechangedate'];
	$statedata=explode("-",$statechangedate);
	$td=date("d");
	$tm=date("m");
	$ty=date("Y");
	$today=date("Y-m-d");
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
	$firstname=mysql_real_escape_string($_POST['firstname']);
	genericSingleUpdate("users","firstname",$firstname,"id",$entryid);
	$middlename=mysql_real_escape_string($_POST['middlename']);
	genericSingleUpdate("users","middlename",$middlename,"id",$entryid);
	$lastname=mysql_real_escape_string($_POST['lastname']);
	genericSingleUpdate("users","lastname",$lastname,"id",$entryid);
	$nickname=mysql_real_escape_string($_POST['nickname']);
	genericSingleUpdate("users","nickname",$nickname,"id",$entryid);
	$bio=mysql_real_escape_string($_POST['bio']);
	genericSingleUpdate("users","details",$bio,"id",$entryid);
	$fullname=$firstname." ".$middlename." ".$lastname;
	genericSingleUpdate("users","fullname",$fullname,"id",$entryid);
	$gender=isset($_POST['gender'])?mysql_real_escape_string($_POST['gender']):"";
	if($gy=="0000"&&$_POST['gender']!==$userdata['gender']){
		genericSingleUpdate("users","gender",$gender,"id",$entryid);
		genericSingleUpdate("users","genderchangedate",$today,"id",$entryid);
	}
	$maritalstatus=isset($_POST['maritalstatus'])?mysql_real_escape_string($_POST['maritalstatus']):"";
	if(($marcy>$ty||($marcy==$ty&&$tm>$marcm)||$marcy=="0000")&&$maritalstatus!==$userdata['maritalstatus']){
		genericSingleUpdate("users","maritalstatus",$maritalstatus,"id",$entryid);
		genericSingleUpdate("users","maritalstatuschangedate",$today,"id",$entryid);
	}
	//you can only change your date of birth once
	$dob=isset($_POST['dob'])?mysql_real_escape_string($_POST['dob']):"";
	if($doby=="0000"&&$dob!==""&&$dob!==$userdata['dob']){
		genericSingleUpdate("users","dob",$dob,"id",$entryid);
		genericSingleUpdate("users","dobchangedate",$today,"id",$entryid);
	}

	$state=isset($_POST['state'])?mysql_real_escape_string($_POST['state']):"";
	if(($sy>$ty||($sy==$ty&&$tm>$sm)||$sy=="0000")&&$state!==$userdata['state']){
		genericSingleUpdate("users","state",$state,"id",$entryid);
		genericSingleUpdate("users","statechangedate",$today,"id",$entryid);
	}
	$lga=isset($_POST['LocalGovt'])?mysql_real_escape_string($_POST['LocalGovt']):"";
	genericSingleUpdate("users","lga",$lga,"id",$entryid);
	$address=mysql_real_escape_string($_POST['address']);
	genericSingleUpdate("users","businessaddress",$address,"id",$entryid);
	$phoneone=mysql_real_escape_string($_POST['phoneone']);
	$phonetwo=mysql_real_escape_string($_POST['phonetwo']);
	$phonethree=mysql_real_escape_string($_POST['phonethree']);
	if($phoneone=="(234) ___-___-____"){
	    $phoneone="";
	  }
	if($phonetwo=="(234) ___-___-____"){
	    $phonetwo="";
	  }
	if($phonethree=="(234) ___-___-____"){
	    $phonethree="";
	  }
	$phoneout=$phoneone."[|><|]".$phonetwo."[|><|]".$phonethree;
	genericSingleUpdate("users","phonenumber",$phoneout,"id",$entryid);
	$email=mysql_real_escape_string($_POST['email']);
	$emaildata['email']="$email";
	$emaildata['fieldcount']=1;
	$emaildata['logic'][0]="AND";
	$emaildata['column'][0]="usertype";
	$emaildata['value'][0]="user";
 	$emaildata=checkEmail($email,"users","email");
 	if($emaildata['testresult']=="unmatched"&&$email!==""&&str_replace(" ", "", $email)!==""){
		genericSingleUpdate("users","email",$email,"id",$entryid);	
 	}
	if($userdata['email']!==$email&&str_replace(" ", "", $email)!==""){
		genericSingleUpdate("users","activationstatus","inactive","id",$entryid);
		$deadline=date('Y-m-d', strtotime('7 days'));
		genericSingleUpdate("users","activationdeadline",$deadline,"id",$entryid);
		$confirmationlink=$host_addr."userdashboard.php?t=activate&uh=".md5($entryid).".".$entryid."&utm_email='.$email.'";
	  $title="Change of Account Email";
	  $content='
	      <p>Hello there '.$fullname.',<br>
	      	It seems you have changed your email address for your account on Napstand, please endeavour to reconfirm your account by <a href="'.$confirmationlink.'">Clicking here</a><br>
	      </p>
	      <p style="text-align:right;">Thank You.</p>
	  ';
	  $footer='
	    <ul>
	        <li><strong>Phone 1: </strong>0701-682-9254</li>
	        <li><strong>Phone 2: </strong>0802-916-3891</li>
	        <li><strong>Phone 3: </strong>0803-370-7244</li>
	        <li><strong>Email: </strong><a href="mailto:info@napstand.com">info@napstand.com</a></li>
	    </ul>
	  ';
	  $emailout=generateMailMarkUp("Adsbounty.com","$email","$title","$content","$footer","");
	    // // echo $emailout['rowmarkup'];
	  if($host_email_send==true){
	  	if(mail($email,$title,$emailout['rowmarkup'],$headers)){

	  	}else{
	  		die("Confirmation Mail not sent, sorry!!!. Try using the back arrow in yout browser and trying what you were doing before again, it might resolve the issue, or hold on a few minutes and let us check it out.");
	  	}
	  }
	}
	$status=isset($_POST['status'])?mysql_real_escape_string($_POST['status']):"active";
	genericSingleUpdate("users","status",$status,"id",$entryid);
	/*$query="INSERT INTO users(usertype,state,lga,email,pword,phonenumber,businessname,businessdescription,businessaddress,regdate)
	VALUES('user','$state','$lga','$email','$password','$phoneout','$businessname','$businessdescription','$businessaddress',CURRENT_DATE())";
	$run=mysql_query($query)or die(mysql_error()." Line 58");*/
	// // echo $query;
    $bizlogo=$_FILES['profpic']['tmp_name'];
	if($bizlogo!==""){
		$image="profpic";
		$imgpath[]='../files/originals/';
		$imgpath[]='../files/medsizes/';
		$imgpath[]='../files/thumbnails/';
		$imgsize[]="default";
		$imgsize[]=",240";
		$imgsize[]=",150";
		$acceptedsize="";
		$imgouts=genericImageUpload($image,"varying",$imgpath,$imgsize,$acceptedsize);
		$len=strlen($imgouts[0]);
		$imagepath=substr($imgouts[0], 1,$len);
		// medium size
		$len2=strlen($imgouts[1]);
		$imagepath2=substr($imgouts[1], 1,$len2);
		//  thumbnail size
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
		if(str_replace(" ", "",$userdata['faceid'])!==""&&$userdata['faceid']>0){
			$bizid=$userdata['faceid'];
			$imgdata=getSingleMediaDataTwo($bizid);
			$prevpic=$userdata['facefile2'];
			$realprevpic=".".$prevpic;
			$realprevpicmed=".".$imgdata['medsize'];
			$realprevpicthumb=".".$imgdata['thumbnail'];
			// echo $realprevpic;
			if(file_exists($realprevpic)&&$realprevpic!=="."){
				unlink($realprevpic);
			}
			if(file_exists($realprevpicmed)&&$realprevpicmed!=="."){
				unlink($realprevpicmed);
			}
			if(file_exists($realprevpicthumb)&&$realprevpicthumb!=="."){
				unlink($realprevpicthumb);
			}
			genericSingleUpdate("media","location",$imagepath,"id",$bizid);
			genericSingleUpdate("media","medsize",$imagepath2,"id",$bizid);
			genericSingleUpdate("media","thumbnail",$imagepath3,"id",$bizid);
			genericSingleUpdate("media","filesize",$filesize,"id",$bizid);
			genericSingleUpdate("media","width",$width,"id",$bizid);
			genericSingleUpdate("media","height",$height,"id",$bizid);	
		}else{
			//maintype variants are original, medsize, thumb for respective size image.
			$mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,medsize,thumbnail,filesize,width,height)
			VALUES('$entryid','user','profpic','image','$imagepath','$imagepath2','$imagepath3','$filesize','$width','$height')";
			$mediarun=mysql_query($mediaquery)or die(mysql_error()." Line ".__LINE__);
		
			//$coverpicid=getNextId("media");
			//maintype variants are original, medsize, thumb for respective size image.
			/*$mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,filesize,width,height)VALUES('$cid','user','bizlogo','image','$imagepath','$filesize','$width','$height')";
			$mediarun=mysql_query($mediaquery)or die(mysql_error());*/
		}
		$password=$_POST['password'];
		$prevpassword=$_POST['prevpassword'];
		if($prevpassword!==""&&$prevpassword==$userdata['pword']&&$password!==""){
			genericSingleUpdate("users","pword",$password,"id",$entryid);
			// clear out user content, basically log them out and send em to the login page
		    // unset($_SESSION['useri']);
		    // unset($_SESSION['userh']);
		    // header('location:../signupin.php');
		}
	}
	$password=$_POST['password'];
	$prevpassword=$_POST['prevpassword'];
	if($prevpassword!==""&&$prevpassword==$userdata['pword']&&$password!==""){
		genericSingleUpdate("users","pword",$password,"id",$entryid);
		// clear out user content, basically log them out and send em to the login page
	    unset($_SESSION['userinapstand']);
	    unset($_SESSION['userhnapstand']);
	    header('location:../login.php');
	}
	/*perform social handles and links updates*/
		//  link and handles data are in the form tw|fb|gp|ln|pin|tblr|ig
		$totalhandles="";
		$totallinks="";
		// facebook
		$fbhandle=isset($_POST['socialhandlefb'])&&$_POST['socialhandlefb']!==""&&$_POST['socialhandlefblink']!==""?mysql_real_escape_string($_POST['socialhandlefb']):$userdata['cursocialhandles'][1];
		$fblink=isset($_POST['socialhandlefblink'])&&$_POST['socialhandlefblink']!==""&&$_POST['socialhandlefb']!==""?mysql_real_escape_string($_POST['socialhandlefblink']):$userdata['cursociallinks'][1];
		// twitter
		$twhandle=isset($_POST['socialhandletw'])&&$_POST['socialhandletw']!==""&&$_POST['socialhandletwlink']!==""?mysql_real_escape_string($_POST['socialhandletw']):$userdata['cursocialhandles'][0];
		$twlink=isset($_POST['socialhandletwlink'])&&$_POST['socialhandletwlink']!==""&&$_POST['socialhandletw']!==""?mysql_real_escape_string($_POST['socialhandletwlink']):$userdata['cursociallinks'][0];
		// gplus
		$gphandle=isset($_POST['socialhandlegp'])&&$_POST['socialhandlegp']!==""&&$_POST['socialhandlegplink']!==""?mysql_real_escape_string($_POST['socialhandlegp']):$userdata['cursocialhandles'][2];
		$gplink=isset($_POST['socialhandlegplink'])&&$_POST['socialhandlegplink']!==""&&$_POST['socialhandlegp']!==""?mysql_real_escape_string($_POST['socialhandlegplink']):$userdata['cursociallinks'][2];
		// Linkedin
		$inhandle=isset($_POST['socialhandlein'])&&$_POST['socialhandlein']!==""&&$_POST['socialhandleinlink']!==""?mysql_real_escape_string($_POST['socialhandlein']):$userdata['cursocialhandles'][3];
		$inlink=isset($_POST['socialhandleinlink'])&&$_POST['socialhandleinlink']!==""&&$_POST['socialhandlein']!==""?mysql_real_escape_string($_POST['socialhandleinlink']):$userdata['cursociallinks'][3];
		// Pinterest
		$pinhandle=isset($_POST['socialhandlepin'])&&$_POST['socialhandlepin']!==""&&$_POST['socialhandlepinlink']!==""?mysql_real_escape_string($_POST['socialhandlepin']):$userdata['cursocialhandles'][4];
		$pinlink=isset($_POST['socialhandlepinlink'])&&$_POST['socialhandlepinlink']!==""&&$_POST['socialhandlepin']!==""?mysql_real_escape_string($_POST['socialhandlepinlink']):$userdata['cursociallinks'][4];
		// tumblr
		$tblrhandle=isset($_POST['socialhandletblr'])&&$_POST['socialhandletblr']!==""&&$_POST['socialhandletblrlink']!==""?mysql_real_escape_string($_POST['socialhandletblr']):$userdata['cursocialhandles'][5];
		$tblrlink=isset($_POST['socialhandletblrlink'])&&$_POST['socialhandletblrlink']!==""&&$_POST['socialhandletblr']!==""?mysql_real_escape_string($_POST['socialhandletblrlink']):$userdata['cursociallinks'][5];
		// instagram
		$ighandle=isset($_POST['socialhandleig'])&&$_POST['socialhandleig']!==""&&$_POST['socialhandleiglink']!==""?mysql_real_escape_string($_POST['socialhandleig']):$userdata['cursocialhandles'][6];
		$iglink=isset($_POST['socialhandleiglink'])&&$_POST['socialhandleiglink']!==""&&$_POST['socialhandleig']?mysql_real_escape_string($_POST['socialhandleiglink']):$userdata['cursociallinks'][6];

		// concatenate the social content for output
		//  link and handles data tw|fb|gp|ln|pin|tblr|ig
		$totalhandles=$twhandle."[|><|]".$fbhandle."[|><|]".$gphandle."[|><|]".$inhandle."[|><|]".
		$pinhandle."[|><|]".$tblrhandle."[|><|]".$ighandle;
		$totallinks=$twlink."[|><|]".$fblink."[|><|]".$gplink."[|><|]".$inlink."[|><|]".
		$pinlink."[|><|]".$tblrlink."[|><|]".$iglink;
		
		genericSingleUpdate("users","socialhandles","$totalhandles","id",$entryid);
		genericSingleUpdate("users","socialurls","$totallinks","id",$entryid);
	/*end*/
    header('location:../userdashboard.php');

}elseif ($entryvariant=="edituseradmin") {
	# code...
	$userdata=getSingleUser($entryid);
	$dobchangedate=$userdata['dobchangedate'];
	$genderchangedate=$userdata['genderchangedate'];
	$maritalstatuschangedate=$userdata['maritalstatuschangedate'];
	$statechangedate=$userdata['statechangedate'];
	$statedata=explode("-",$statechangedate);
	$td=date("d");
	$tm=date("m");
	$ty=date("Y");
	$today=date("Y-m-d");
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
	$firstname=mysql_real_escape_string($_POST['firstname']);
	genericSingleUpdate("users","firstname",$firstname,"id",$entryid);
	$middlename=mysql_real_escape_string($_POST['middlename']);
	genericSingleUpdate("users","middlename",$middlename,"id",$entryid);
	$lastname=mysql_real_escape_string($_POST['lastname']);
	genericSingleUpdate("users","lastname",$lastname,"id",$entryid);
	$nickname=mysql_real_escape_string($_POST['nickname']);
	genericSingleUpdate("users","nickname",$nickname,"id",$entryid);
	$bio=mysql_real_escape_string($_POST['bio']);
	genericSingleUpdate("users","details","$bio","id",$entryid);
	$fullname=$firstname." ".$middlename." ".$lastname;
	genericSingleUpdate("users","fullname",$fullname,"id",$entryid);
	$gender=isset($_POST['gender'])?mysql_real_escape_string($_POST['gender']):"";
	// if($gy=="0000"&&$_POST['gender']!==$userdata['gender']){
		genericSingleUpdate("users","gender",$gender,"id",$entryid);
		// genericSingleUpdate("users","genderchangedate",$today,"id",$entryid);
	// }
	$maritalstatus=isset($_POST['maritalstatus'])?mysql_real_escape_string($_POST['maritalstatus']):"";
	// if(($marcy>$ty||($marcy==$ty&&$tm>$marcm)||$marcy=="0000")&&$maritalstatus!==$userdata['maritalstatus']){
		genericSingleUpdate("users","maritalstatus",$maritalstatus,"id",$entryid);
		// genericSingleUpdate("users","maritalstatuschangedate",$today,"id",$entryid);
	// }
	//you can only change your date of birth once
	$dob=isset($_POST['dob'])?mysql_real_escape_string($_POST['dob']):"";
	// if($doby=="0000"&&$dob!==""&&$dob!==$userdata['dob']){
		genericSingleUpdate("users","dob",$dob,"id",$entryid);
		// genericSingleUpdate("users","dobchangedate",$today,"id",$entryid);
	// }

	$state=isset($_POST['state'])?mysql_real_escape_string($_POST['state']):"";
	// if(($sy>$ty||($sy==$ty&&$tm>$sm)||$sy=="0000")&&$state!==$userdata['state']){
		genericSingleUpdate("users","state",$state,"id",$entryid);
		// genericSingleUpdate("users","statechangedate",$today,"id",$entryid);
	// }
	$lga=isset($_POST['LocalGovt'])?mysql_real_escape_string($_POST['LocalGovt']):"";
	genericSingleUpdate("users","lga",$lga,"id",$entryid);
	$address=mysql_real_escape_string($_POST['address']);
	genericSingleUpdate("users","businessaddress",$address,"id",$entryid);
	$phoneone=mysql_real_escape_string($_POST['phoneone']);
	$phonetwo=mysql_real_escape_string($_POST['phonetwo']);
	$phonethree=mysql_real_escape_string($_POST['phonethree']);
	if($phoneone=="(234) ___-___-____"){
	    $phoneone="";
	  }
	if($phonetwo=="(234) ___-___-____"){
	    $phonetwo="";
	  }
	if($phonethree=="(234) ___-___-____"){
	    $phonethree="";
	  }
	$phoneout=$phoneone."[|><|]".$phonetwo."[|><|]".$phonethree;
	genericSingleUpdate("users","phonenumber",$phoneout,"id",$entryid);

	$email=mysql_real_escape_string($_POST['email']);
	$emaildata['email']="$email";
	$emaildata['fieldcount']=1;
	$emaildata['logic'][0]="AND";
	$emaildata['column'][0]="usertype";
	$emaildata['value'][0]="user";
	$emaildata=checkEmail($emaildata,"users","email");
 	if($emaildata['testresult']=="unmatched"&&$email!==""&&str_replace(" ", "", $email)!==""){
		genericSingleUpdate("users","email",$email,"id",$entryid);	
 	}
	if($userdata['email']!==$email&&str_replace(" ", "", $email)!==""){
		genericSingleUpdate("users","activationstatus","inactive","id",$entryid);
		$deadline=date('Y-m-d', strtotime('7 days'));
		genericSingleUpdate("users","activationdeadline",$deadline,"id",$entryid);
		$confirmationlink=$host_addr."signupin.php?t=activate&uh=".md5($entryid).".".$entryid."&utm_email='.$email.'";
		  $title="Change of Account Email";
		  $content='
		      <p>Hello there '.$fullname.',<br>
		      	It seems you have changed your email address for your account on Adsbounty, please endeavour to reconfirm your account by <a href="'.$confirmationlink.'">Clicking here</a><br>
		      </p>
		      <p style="text-align:right;">Thank You.</p>
		  ';
		  $footer='
		    <ul>
		        <li><strong>Phone 1: </strong>0701-682-9254</li>
		        <li><strong>Phone 2: </strong>0802-916-3891</li>
		        <li><strong>Phone 3: </strong>0803-370-7244</li>
		        <li><strong>Email: </strong><a href="mailto:info@napstand.com">info@napstand.com</a></li>
		    </ul>
		  ';
	  $emailout=generateMailMarkUp("Adsbounty.com","$email","$title","$content","$footer","");
	    // // echo $emailout['rowmarkup'];
	  if($host_email_send==true){
	  	if(mail($email,$title,$emailout['rowmarkup'],$headers)){

	  	}else{
	  		die("Confirmation Mail not sent, sorry!!!. Try using the back arrow in yout browser and trying what you were doing.");
	  	}
	  }
	}
	$status=isset($_POST['status'])?mysql_real_escape_string($_POST['status']):"active";
	genericSingleUpdate("users","status",$status,"id",$entryid);
	/*$query="INSERT INTO users(usertype,state,lga,email,pword,phonenumber,businessname,businessdescription,businessaddress,regdate)
	VALUES('user','$state','$lga','$email','$password','$phoneout','$businessname','$businessdescription','$businessaddress',CURRENT_DATE())";
	$run=mysql_query($query)or die(mysql_error()." Line 58");*/
	// // echo $query;
    $bizlogo=$_FILES['profpic']['tmp_name'];
	if($bizlogo!==""){
		$image="profpic";
		$imgpath[]='../files/originals/';
		$imgpath[]='../files/medsizes/';
		$imgpath[]='../files/thumbnails/';
		$imgsize[]="default";
		$imgsize[]=",240";
		$imgsize[]=",150";
		$acceptedsize="";
		$imgouts=genericImageUpload($image,"varying",$imgpath,$imgsize,$acceptedsize);
		$len=strlen($imgouts[0]);
		$imagepath=substr($imgouts[0], 1,$len);
		// medium size
		$len2=strlen($imgouts[1]);
		$imagepath2=substr($imgouts[1], 1,$len2);
		//  thumbnail size
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
		if(str_replace(" ", "",$userdata['faceid'])!==""&&$userdata['faceid']>0){
			$bizid=$userdata['faceid'];
			$imgdata=getSingleMediaDataTwo($bizid);
			$prevpic=$userdata['facefile2'];
			$realprevpic=".".$prevpic;
			$realprevpicmed=".".$imgdata['medsize'];
			$realprevpicthumb=".".$imgdata['thumbnail'];
			// echo $realprevpic;
			if(file_exists($realprevpic)&&$realprevpic!=="."){
				unlink($realprevpic);
			}
			if(file_exists($realprevpicmed)&&$realprevpicmed!=="."){
				unlink($realprevpicmed);
			}
			if(file_exists($realprevpicthumb)&&$realprevpicthumb!=="."){
				unlink($realprevpicthumb);
			}
			genericSingleUpdate("media","location",$imagepath,"id",$bizid);
			genericSingleUpdate("media","medsize",$imagepath2,"id",$bizid);
			genericSingleUpdate("media","thumbnail",$imagepath3,"id",$bizid);
			genericSingleUpdate("media","filesize",$filesize,"id",$bizid);
			genericSingleUpdate("media","width",$width,"id",$bizid);
			genericSingleUpdate("media","height",$height,"id",$bizid);	
		}else{
			//maintype variants are original, medsize, thumb for respective size image.
			$mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,medsize,thumbnail,filesize,width,height)
			VALUES('$entryid','user','profpic','image','$imagepath','$imagepath2','$imagepath3','$filesize','$width','$height')";
			$mediarun=mysql_query($mediaquery)or die(mysql_error()." Line ".__LINE__);
		
			//$coverpicid=getNextId("media");
			//maintype variants are original, medsize, thumb for respective size image.
			/*$mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,filesize,width,height)VALUES('$cid','user','bizlogo','image','$imagepath','$filesize','$width','$height')";
			$mediarun=mysql_query($mediaquery)or die(mysql_error());*/
		}
		$password=$_POST['password'];
		$prevpassword=$_POST['prevpassword'];
		if($prevpassword!==""&&$prevpassword==$userdata['pword']&&$password!==""){
			genericSingleUpdate("users","pword",$password,"id",$entryid);
			// clear out user content, basically log them out and send em to the login page
		    // unset($_SESSION['useri']);
		    // unset($_SESSION['userh']);
		    // header('location:../signupin.php');
		}
	}
	/*perform social handles and links updates*/
		//  link and handles data are in the form tw|fb|gp|ln|pin|tblr|ig
		$totalhandles="";
		$totallinks="";
		// facebook
		$fbhandle=isset($_POST['socialhandlefb'])&&$_POST['socialhandlefb']!==""&&$_POST['socialhandlefblink']!==""?mysql_real_escape_string($_POST['socialhandlefb']):$userdata['cursocialhandles'][1];
		$fblink=isset($_POST['socialhandlefblink'])&&$_POST['socialhandlefblink']!==""&&$_POST['socialhandlefb']!==""?mysql_real_escape_string($_POST['socialhandlefblink']):$userdata['cursociallinks'][1];
		// twitter
		$twhandle=isset($_POST['socialhandletw'])&&$_POST['socialhandletw']!==""&&$_POST['socialhandletwlink']!==""?mysql_real_escape_string($_POST['socialhandletw']):$userdata['cursocialhandles'][0];
		$twlink=isset($_POST['socialhandletwlink'])&&$_POST['socialhandletwlink']!==""&&$_POST['socialhandletw']!==""?mysql_real_escape_string($_POST['socialhandletwlink']):$userdata['cursociallinks'][0];
		// gplus
		$gphandle=isset($_POST['socialhandlegp'])&&$_POST['socialhandlegp']!==""&&$_POST['socialhandlegplink']!==""?mysql_real_escape_string($_POST['socialhandlegp']):$userdata['cursocialhandles'][2];
		$gplink=isset($_POST['socialhandlegplink'])&&$_POST['socialhandlegplink']!==""&&$_POST['socialhandlegp']!==""?mysql_real_escape_string($_POST['socialhandlegplink']):$userdata['cursociallinks'][2];
		// Linkedin
		$inhandle=isset($_POST['socialhandlein'])&&$_POST['socialhandlein']!==""&&$_POST['socialhandleinlink']!==""?mysql_real_escape_string($_POST['socialhandlein']):$userdata['cursocialhandles'][3];
		$inlink=isset($_POST['socialhandleinlink'])&&$_POST['socialhandleinlink']!==""&&$_POST['socialhandlein']!==""?mysql_real_escape_string($_POST['socialhandleinlink']):$userdata['cursociallinks'][3];
		// Pinterest
		$pinhandle=isset($_POST['socialhandlepin'])&&$_POST['socialhandlepin']!==""&&$_POST['socialhandlepinlink']!==""?mysql_real_escape_string($_POST['socialhandlepin']):$userdata['cursocialhandles'][4];
		$pinlink=isset($_POST['socialhandlepinlink'])&&$_POST['socialhandlepinlink']!==""&&$_POST['socialhandlepin']!==""?mysql_real_escape_string($_POST['socialhandlepinlink']):$userdata['cursociallinks'][4];
		// tumblr
		$tblrhandle=isset($_POST['socialhandletblr'])&&$_POST['socialhandletblr']!==""&&$_POST['socialhandletblrlink']!==""?mysql_real_escape_string($_POST['socialhandletblr']):$userdata['cursocialhandles'][5];
		$tblrlink=isset($_POST['socialhandletblrlink'])&&$_POST['socialhandletblrlink']!==""&&$_POST['socialhandletblr']!==""?mysql_real_escape_string($_POST['socialhandletblrlink']):$userdata['cursociallinks'][5];
		// instagram
		$ighandle=isset($_POST['socialhandleig'])&&$_POST['socialhandleig']!==""&&$_POST['socialhandleiglink']!==""?mysql_real_escape_string($_POST['socialhandleig']):$userdata['cursocialhandles'][6];
		$iglink=isset($_POST['socialhandleiglink'])&&$_POST['socialhandleiglink']!==""&&$_POST['socialhandleig']?mysql_real_escape_string($_POST['socialhandleiglink']):$userdata['cursociallinks'][6];

		// concatenate the social content for output
		//  link and handles data tw|fb|gp|ln|pin|tblr|ig
		$totalhandles=$twhandle."[|><|]".$fbhandle."[|><|]".$gphandle."[|><|]".$inhandle."[|><|]".
		$pinhandle."[|><|]".$tblrhandle."[|><|]".$ighandle;
		$totallinks=$twlink."[|><|]".$fblink."[|><|]".$gplink."[|><|]".$inlink."[|><|]".
		$pinlink."[|><|]".$tblrlink."[|><|]".$iglink;
		
		genericSingleUpdate("users","socialhandles","$totalhandles","id",$entryid);
		genericSingleUpdate("users","socialurls","$totallinks","id",$entryid);
	/*end*/
    header('location:../admin/adminindex.php');
}else if($entryvariant=="editadminuser"){
    $maintype="";
    $fullname=mysql_real_escape_string($_POST['fullname']);
    genericSingleUpdate("admin","fullname",$fullname,"id",$entryid);
    $username=mysql_real_escape_string($_POST['username']);
    genericSingleUpdate("admin","username",$username,"id",$entryid);
    $password=mysql_real_escape_string($_POST['password']);
    genericSingleUpdate("admin","password",$password,"id",$entryid);
    $accesslevel=$_POST['accesslevel'];
    genericSingleUpdate("admin","accesslevel",$accesslevel,"id",$entryid);
    $status=isset($_POST['status'])?mysql_real_escape_string($_POST['status']):"active";
    genericSingleUpdate("admin","status",$status,"id",$entryid);

    $imgid=mysql_real_escape_string($_POST['coverid']);
    $contentpic=$_FILES['contentpic']['tmp_name'];
    if($contentpic!==""){
      $image="contentpic";
      $imgpath[]='../files/medsizes/';
      $imgpath[]='../files/thumbnails/';
      $imgsize[]="default";
      if($maintype=="about"){
        $imgsize[]="374,";
        $acceptedsize="";
        
      }else{
        $imgsize[]=",300";
        $acceptedsize="";
      }
      $imgouts=genericImageUpload($image,"varying",$imgpath,$imgsize,$acceptedsize);
      $len=strlen($imgouts[0]);
      $imagepath=substr($imgouts[0], 1,$len);
      // medsize
      $len2=strlen($imgouts[1]);
       $imagepath2=substr($imgouts[1], 1,$len2);
      // get image size details
      list($width,$height)=getimagesize($imgouts[0]);
      $imagesize=$_FILES[''.$image.'']['size'];
      $filesize=$imagesize/1024;
      //echo $filefirstsize;
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
      if($imgid<1){
        $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,details,filesize,width,height)VALUES
        ('$entryid','adminuser','coverphoto','image','$imagepath','$imagepath2','$filesize','$width','$height')";
        $mediarun=mysql_query($mediaquery)or die(mysql_error()." ".__LINE__);
        
      }else{
        $imgdata=getSingleMediaDataTwo($imgid);
        $prevpic=$imgdata['location'];
        $prevthumb=$imgdata['details'];
        $realprevpic=".".$prevpic;
        $realprevthumb=".".$prevthumb;
        if(file_exists($realprevpic)&&$realprevpic!=="."){
          unlink($realprevpic);
        }
        if(file_exists($realprevthumb)&&$realprevthumb!=="."){
          unlink($realprevthumb);
        }
        genericSingleUpdate("media","location",$imagepath,"id",$imgid);
        // genericSingleUpdate("media","details",$imagepath2,"id",$imgid);
        genericSingleUpdate("media","filesize",$filesize,"id",$imgid);
        genericSingleUpdate("media","width",$width,"id",$imgid);
        genericSingleUpdate("media","height",$height,"id",$imgid);
        // echo "in here";
      }
    }
    header('location:../admin/adminindex.php');
}else if ($entryvariant=="editappuser") {
	# code...
  	// header("Access-Control-Allow-Origin: *");
	$uid=$entryid;
	$uhash=md5($uid);
	$userdata=getSingleUser($entryid);

	$catid=0;
	$entrypoint=isset($_POST['entrypoint'])?$_POST['entrypoint']:"";
	// $catid=mysql_real_escape_string($_POST['catid']);
	$firstname=mysql_real_escape_string($_POST['firstname']);
	genericSingleUpdate("users","firstname",$firstname,"id",$entryid);
	$middlename=mysql_real_escape_string($_POST['middlename']);
	genericSingleUpdate("users","middlename",$middlename,"id",$entryid);
	$lastname=mysql_real_escape_string($_POST['lastname']);
	genericSingleUpdate("users","lastname",$lastname,"id",$entryid);
	// $nickname=mysql_real_escape_string($_POST['nickname']);
	$fullname=$firstname." ".$middlename." ".$lastname;
	genericSingleUpdate("users","fullname",$fullname,"id",$entryid);
	$status=isset($_POST['status'])?mysql_real_escape_string($_POST['status']):"active";
	genericSingleUpdate("users","status",$status,"id",$entryid);
	// $bio=mysql_real_escape_string($_POST['bio']);
	// $state=mysql_real_escape_string($_POST['state']);
	// $lga=mysql_real_escape_string($_POST['LocalGovt']);
	// $address=mysql_real_escape_string($_POST['address']);
	// $gender=mysql_real_escape_string($_POST['gender']);
	/*$doby=mysql_real_escape_string($_POST['dobyear']);
	$dobm=mysql_real_escape_string($_POST['dobmonth']);
	$dobd=mysql_real_escape_string($_POST['dobday']);
	$dob=$doby."-".$dobm."-".$dobd;*/
	// $maritalstatus=mysql_real_escape_string($_POST['maritalstatus']);
	/*$phoneone=mysql_real_escape_string($_POST['phoneone']);
	if($phoneone=="(234) ___-___-____"){
	$phoneone="";
	}
	$phonetwo=mysql_real_escape_string($_POST['phonetwo']);
	if($phonetwo=="(234) ___-___-____"){
	$phonetwo="";
	}
	$phonethree=mysql_real_escape_string($_POST['phonethree']);
	if($phonethree=="(234) ___-___-____"){
	$phonethree="";
	}
	$phoneout=$phoneone."[|><|]".$phonetwo."[|><|]".$phonethree;*/

	$email=mysql_real_escape_string($_POST['email']);
	$emaildata['email']="$email";
	$emaildata['fieldcount']=1;
	$emaildata['logic'][0]="AND";
	$emaildata['column'][0]="usertype";
	$emaildata['value'][0]="user";
	$emaildata=checkEmail($emaildata,"users","email");
	$password=$_POST['password'];
	$prevpassword=$_POST['prevpassword'];
	if($prevpassword!==""&&$prevpassword==$userdata['pword']&&$password!==""){
		genericSingleUpdate("users","pword",$password,"id",$entryid);
		// clear out user content, basically log them out and send em to the login page
	    // unset($_SESSION['useri']);
	    // unset($_SESSION['userh']);
	    // header('location:../signupin.php');
	}
	// upload user profile image
	$bizlogo=isset($_FILES['profpic']['tmp_name'])?$_FILES['profpic']['tmp_name']:"";
	if($bizlogo!==""){
	  $image="profpic";
	  $imgpath[]='../files/originals/';
	  $imgpath[]='../files/medsizes/';
	  $imgpath[]='../files/thumbnails/';
	  $imgsize[]="default";
	  $imgsize[]=",240";
	  $imgsize[]=",150";
	  $acceptedsize="";
	  $imgouts=genericImageUpload($image,"varying",$imgpath,$imgsize,$acceptedsize);
	  $len=strlen($imgouts[0]);
	  $imagepath=substr($imgouts[0], 1,$len);
	  // medium size
	  $len2=strlen($imgouts[1]);
	  $imagepath2=substr($imgouts[1], 1,$len2);
	  //  thumbnail size
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
	  
	  if($imgid<1){
	    $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,details,filesize,width,height)VALUES
	    ('$entryid','appuser','coverphoto','image','$imagepath','$imagepath2','$filesize','$width','$height')";
	    $mediarun=mysql_query($mediaquery)or die(mysql_error()." ".__LINE__);
	    
	  }else{
	    $imgdata=getSingleMediaDataTwo($imgid);
	    $prevpic=$imgdata['location'];
	    $prevthumb=$imgdata['details'];
	    $realprevpic=".".$prevpic;
	    $realprevthumb=".".$prevthumb;
	    if(file_exists($realprevpic)&&$realprevpic!=="."){
	      unlink($realprevpic);
	    }
	    if(file_exists($realprevthumb)&&$realprevthumb!=="."){
	      unlink($realprevthumb);
	    }
	    genericSingleUpdate("media","location",$imagepath,"id",$imgid);
	    // genericSingleUpdate("media","details",$imagepath2,"id",$imgid);
	    genericSingleUpdate("media","filesize",$filesize,"id",$imgid);
	    genericSingleUpdate("media","width",$width,"id",$imgid);
	    genericSingleUpdate("media","height",$height,"id",$imgid);
	    // echo "in here";
	  }
	}
	$successstatus="true";
	$msg="Updated Successfully";
	if($email!==""){
		// verify email once more and proceed only when the email is umatched
		if($emaildata['testresult']=="unmatched"||($emaildata['testresult']=="matched"&&$emaildata['usertype']!=="appuser")){    
			genericSingleUpdate("users","email",$email,"id",$entryid);	

			// create the users content folder
			/*$query="INSERT INTO users(usertype,fullname,firstname,middlename,lastname,uhash,email,pword)
			VALUES('appuser','$fullname','$firstname','$middlename','$lastname','$uhash',
			  '$email','$password',CURRENT_DATE())";*/
			// echo $query." ".__LINE__;
			// $run=mysql_query($query)or die(mysql_error()." Line ".__LINE__);

			if($entrypoint=="webapp"){

			}else {
			  	// echo json response here
			  	$successstatus="true";
			  	$msg="Updated Successfully";
	 			createNotification($entryid,"users","update","Profile was updated");
			  
			}
		} else{
			if($entrypoint=="webapp"){
			    echo "The email address you attempted registering is invalid";
			}else {

			  	// echo json response here
			  	$successstatus="false";
				$msg="The email address you attempted changing to is invalid or taken";

			}

		}
	}
	// end of email mark section
	if($entrypoint=="webapp"){
		header('location:../admin/adminindex.php?compid=4&type=0&v=admin&ctype='.$entryvariant.'');  
	}else {

	  // echo json response here
	  echo json_encode(array("success"=>"$successstatus","msg"=>"$msg"));

	}

}elseif ($entryvariant=="introentryupdate") {
	# code...
	$introtitle=isset($_POST['contenttitle'])?mysql_real_escape_string($_POST['contenttitle']):"";
	$intro=mysql_real_escape_string(str_replace("../", "$host_addr",$_POST['intro']));
	$maintype=mysql_real_escape_string($_POST['maintype']);
	$subtype=mysql_real_escape_string($_POST['subtype']);
	if($entryid!==""&&$entryid>0){
		// $status=mysql_real_escape_string($_POST['status']);
		genericSingleUpdate("generalinfo","title",$introtitle,"id",$entryid);
		genericSingleUpdate("generalinfo","intro",$intro,"id",$entryid);
		// genericSingleUpdate("generalinfo","content",$content,"id",$entryid);
		genericSingleUpdate("generalinfo","status",$status,"id",$entryid);
	}else{
	    // check to see if there is a match
	    $querytest="SELECT * FROM generalinfo WHERE maintype='$maintype' AND subtype='$subtype'";
	    $runtest=mysql_query($querytest)or die(mysql_error()." ".__LINE__);
	    $numrows=mysql_num_rows($runtest);
	    if($numrows<1){
	    		$entrydate=date("Y-m-d H:i:s");
	        $query="INSERT INTO generalinfo(maintype,subtype,title,intro,entrydate)VALUES
	    	   ('$maintype','$subtype','$introtitle','$intro','$entrydate')";
	        $run=mysql_query($query)or die(mysql_error()." ".__LINE__);
	    }
	    // // echo $numrows;
	}
	if($rurladmin==""){

		header('location:../admin/adminindex.php');
	}else{
		header('location:'.$rurladmin.'');

	}
}elseif ($entryvariant=="contententryupdate") {
	# code... this section is for pages that have a singular content
	$introtitle=isset($_POST['contenttitle'])?mysql_real_escape_string($_POST['contenttitle']):"";
	$intro=isset($_POST['intro'])?mysql_real_escape_string(str_replace("../", "$host_addr",$_POST['intro'])):"";
	$headerdescription = convert_html_to_text($intro);
	$headerdescription=html2txt($headerdescription);
	$monitorlength=strlen($headerdescription);
	$headerdescription=$monitorlength<600?$headerdescription."...":substr($headerdescription, 0,600)."...";
	$maintype=mysql_real_escape_string($_POST['maintype']);
	$subtype=mysql_real_escape_string($_POST['subtype']);
	$status=isset($_POST['status'])?mysql_real_escape_string($_POST['status']):"";
	if($entryid!==""&&$entryid>0){
	    // $status=mysql_real_escape_string($_POST['status']);
	    genericSingleUpdate("generalinfo","title",$introtitle,"id",$entryid);
	    genericSingleUpdate("generalinfo","intro",$headerdescription,"id",$entryid);
	    genericSingleUpdate("generalinfo","content",$intro,"id",$entryid);
	    genericSingleUpdate("generalinfo","status",$status,"id",$entryid);
	}else{
	    $entryid=getNextId('generalinfo');
	    // check to see if there is a match
	    $querytest="SELECT * FROM generalinfo WHERE maintype='$maintype' AND subtype='$subtype'";
	    $runtest=mysql_query($querytest)or die(mysql_error()." ".__LINE__);
	    $numrows=mysql_num_rows($runtest);
	    if($numrows<1){
	        $entrydate=date("Y-m-d H:i:s");
	        $query="INSERT INTO generalinfo(maintype,subtype,title,intro,content,entrydate)VALUES
	         ('$maintype','$subtype','$introtitle','$headerdescription','$intro','$entrydate')";
	        $run=mysql_query($query)or die(mysql_error()." ".__LINE__);
	    }
	    
	    // // echo $numrows;
	}
    $contentpic=isset($_FILES['contentpic']['tmp_name'])?$_FILES['contentpic']['tmp_name']:"";
    if($contentpic!==""){
      $imgid=isset($_POST['coverid'])?mysql_real_escape_string($_POST['coverid']):0;
      $image="contentpic";
      $imgpath[]='../files/medsizes/';
      $imgpath[]='../files/thumbnails/';
      $imgsize[]="default";
      if($maintype=="about"){
        $imgsize[]="374,";
        $acceptedsize="";
      }elseif($maintype=="productservices"){
        $imgsize[]="default";
        $acceptedsize="";
        
      }elseif($maintype=="ceoprofile"){
        $imgsize[1]=",950";
        $acceptedsize="";
      }else{
        $imgsize[]=",300";
        $acceptedsize="";
      }
      $imgouts=genericImageUpload($image,"varying",$imgpath,$imgsize,$acceptedsize);
      $len=strlen($imgouts[0]);
      $imagepath=substr($imgouts[0], 1,$len);
      // medsize
      $len2=strlen($imgouts[1]);
       $imagepath2=substr($imgouts[1], 1,$len2);
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
      $cid=$entryid;
      if($imgid<1){
        $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,details,filesize,width,height)VALUES
        ('$cid','$maintype','coverphoto','image','$imagepath','$imagepath2','$filesize','$width','$height')";
        $mediarun=mysql_query($mediaquery)or die(mysql_error()." ".__LINE__);
        
      }else{
        $imgdata=getSingleMediaDataTwo($imgid);
        $prevpic=$imgdata['location'];
        $prevthumb=$imgdata['details'];
        $realprevpic=".".$prevpic;
        $realprevthumb=".".$prevthumb;
        if(file_exists($realprevpic)&&$realprevpic!=="."){
          unlink($realprevpic);
        }
        if(file_exists($realprevthumb)&&$realprevthumb!=="."){
          unlink($realprevthumb);
        }
        genericSingleUpdate("media","location",$imagepath,"id",$imgid);
        genericSingleUpdate("media","details",$imagepath2,"id",$imgid);
        genericSingleUpdate("media","filesize",$filesize,"id",$imgid);
        genericSingleUpdate("media","width",$width,"id",$imgid);
        genericSingleUpdate("media","height",$height,"id",$imgid);
        // echo "in here";
      }
    }
    /*extra data section for handling specific or rare cases as per maintype or subtype data nature*/
      if($maintype=="productservices"){
          // check for the banner image for the product tab
          $contentpic=$_FILES['prodbannerimg']['tmp_name'];
          if($contentpic!==""){
            $image="prodbannerimg";
            $imgpath[0]='../files/medsizes/';
            $imgpath[1]='../files/thumbnails/';
            $imgsize[0]="default";
            $imgsize[1]=",200";
            $acceptedsize="";
            $imgid=isset($_POST['prodbannerimgid'])?mysql_real_escape_string($_POST['prodbannerimgid']):0;
            $imgouts=genericImageUpload($image,"varying",$imgpath,$imgsize,$acceptedsize);
            $len=strlen($imgouts[0]);
            $imagepath=substr($imgouts[0], 1,$len);
            // medsize
            $len2=strlen($imgouts[1]);
             $imagepath2=substr($imgouts[1], 1,$len2);
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
            if($imgid<1){
              $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,details,filesize,width,height)VALUES
              ('$entryid','$maintype','productbanner','image','$imagepath','$imagepath2','$filesize','$width','$height')";
              $mediarun=mysql_query($mediaquery)or die(mysql_error()." ".__LINE__);
              
            }else{
              $imgdata=getSingleMediaDataTwo($imgid);
              $prevpic=$imgdata['location'];
              $prevthumb=$imgdata['details'];
              $realprevpic=".".$prevpic;
              $realprevthumb=".".$prevthumb;
              if(file_exists($realprevpic)&&$realprevpic!=="."){
                unlink($realprevpic);
              }
              if(file_exists($realprevthumb)&&$realprevthumb!=="."){
                unlink($realprevthumb);
              }
              genericSingleUpdate("media","location",$imagepath,"id",$imgid);
              genericSingleUpdate("media","details",$imagepath2,"id",$imgid);
              genericSingleUpdate("media","filesize",$filesize,"id",$imgid);
              genericSingleUpdate("media","width",$width,"id",$imgid);
              genericSingleUpdate("media","height",$height,"id",$imgid);
              // // echo "in here";
            }
          }
          // proceed to check update or insert subproducts for this entry
          if(isset($_POST['cursubproductcount'])){
            $spcount=$_POST['cursubproductcount'];
            for ($i=1; $i <=$spcount ; $i++) { 
              # code...
              $subcontentid=$_POST['subcontentid'.$i.''];
              $subcontenttitle=mysql_real_escape_string($_POST['subcontenttitle'.$i.'']);
              if($subcontentid>0){
                $subprodstatus=$_POST['subprodstatus'.$i.''];
                genericSingleUpdate("generalinfo","title",$subcontenttitle,"id",$subcontentid);
                genericSingleUpdate("generalinfo","status",$subprodstatus,"id",$subcontentid);
                // // echo $subprodstatus." statsout";
              }else{
                if($subcontenttitle!==""){
                  $entrydate=date("Y-m-d H:i:s");
                  $query="INSERT INTO generalinfo(maintype,subtype,title,entrydate)VALUES
                   ('subproductservices','$entryid','$subcontenttitle','$entrydate')";
                  $run=mysql_query($query)or die(mysql_error()." ".__LINE__);
                }
              }
            }
          }
      }
    /*end*/
    if($rurladmin==""){

		header('location:../admin/adminindex.php');
	}else{
		header('location:'.$rurladmin.'');
	}
}else if ($entryvariant=="contententry") {
  # code...
  $maintype=mysql_real_escape_string($_POST['maintype']);
  $subtype=mysql_real_escape_string($_POST['subtype']);
  $title=isset($_POST['contenttitle'])?mysql_real_escape_string($_POST['contenttitle']):"";
  $intro=isset($_POST['contentintro'])?mysql_real_escape_string($_POST['contentintro']):"";
  $imgid=mysql_real_escape_string($_POST['coverid']);
  $content=isset($_POST['contentpost'])?mysql_real_escape_string(str_replace("../", "$host_addr",$_POST['contentpost'])):"";
  $status=isset($_POST['status'])?mysql_real_escape_string($_POST['status']):"active";
  if($intro!==""){
    $headerdescription = $intro;    
  }else{
    if($content!==""){
      $headerdescription = convert_html_to_text($content);
      $headerdescription=html2txt($headerdescription);
      $monitorlength=strlen($headerdescription);
      $headerdescription=$monitorlength<600?$headerdescription."...":substr($headerdescription, 0,600)."...";
    }else{
      $headerdescription="";
    }
  }
  genericSingleUpdate("generalinfo","title",$title,"id",$entryid);
  genericSingleUpdate("generalinfo","intro",$headerdescription,"id",$entryid);
  genericSingleUpdate("generalinfo","content",$content,"id",$entryid);
  genericSingleUpdate("generalinfo","status",$status,"id",$entryid);
  $contentpic=$_FILES['contentpic']['tmp_name'];
  if($contentpic!==""){
    $image="contentpic";
    $imgpath[]='../files/medsizes/';
    $imgpath[]='../files/thumbnails/';
    $imgsize[]="default";
    if($maintype=="about"){
      $imgsize[]="374,";
      $acceptedsize="";
      
    }elseif($maintype=="productservices"){
      $imgsize[]=",20";
      $acceptedsize="";
      
    }elseif($maintype=="ceoprofile"){
        $imgsize[1]=",950";
        $acceptedsize="";
    }else{
      $imgsize[]=",300";
      $acceptedsize="";
    }
    $imgouts=genericImageUpload($image,"varying",$imgpath,$imgsize,$acceptedsize);
    $len=strlen($imgouts[0]);
    $imagepath=substr($imgouts[0], 1,$len);
    // medsize
    $len2=strlen($imgouts[1]);
     $imagepath2=substr($imgouts[1], 1,$len2);
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
    if($imgid<1){
      $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,details,filesize,width,height)VALUES
      ('$entryid','$maintype','coverphoto','image','$imagepath','$imagepath2','$filesize','$width','$height')";
      $mediarun=mysql_query($mediaquery)or die(mysql_error()." ".__LINE__);
    	
    }else{
      $imgdata=getSingleMediaDataTwo($imgid);
      $prevpic=$imgdata['location'];
      $prevthumb=$imgdata['details'];
      $realprevpic=".".$prevpic;
      $realprevthumb=".".$prevthumb;
      if(file_exists($realprevpic)&&$realprevpic!=="."){
        unlink($realprevpic);
      }
      if(file_exists($realprevthumb)&&$realprevthumb!=="."){
        unlink($realprevthumb);
      }
    	genericSingleUpdate("media","location",$imagepath,"id",$imgid);
		genericSingleUpdate("media","details",$imagepath2,"id",$imgid);
		genericSingleUpdate("media","filesize",$filesize,"id",$imgid);
		genericSingleUpdate("media","width",$width,"id",$imgid);
		genericSingleUpdate("media","height",$height,"id",$imgid);
    // echo "in here";
    }
  }
  /*extra data section for handling specific or rare cases as per maintype or subtype data nature*/
    if($maintype=="productservices"){
        // check for the banner image for the product tab
        $contentpic=isset($_FILES['prodbannerimg']['tmp_name'])?$_FILES['prodbannerimg']['tmp_name']:"";
        if($contentpic!==""){
          $image="prodbannerimg";
          $imgpath[0]='../files/medsizes/';
          $imgpath[1]='../files/thumbnails/';
          $imgsize[0]="default";
          $imgsize[1]=",200";
          $acceptedsize="";
          $imgid=isset($_POST['prodbannerimgid'])?mysql_real_escape_string($_POST['prodbannerimgid']):0;
          $imgouts=genericImageUpload($image,"varying",$imgpath,$imgsize,$acceptedsize);
          $len=strlen($imgouts[0]);
          $imagepath=substr($imgouts[0], 1,$len);
          // medsize
          $len2=strlen($imgouts[1]);
          $imagepath2=substr($imgouts[1], 1,$len2);
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
          if($imgid<1){
            $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,details,filesize,width,height)VALUES
            ('$entryid','$maintype','productbanner','image','$imagepath','$imagepath2','$filesize','$width','$height')";
            $mediarun=mysql_query($mediaquery)or die(mysql_error()." ".__LINE__);
            
          }else{
            $imgdata=getSingleMediaDataTwo($imgid);
            $prevpic=$imgdata['location'];
            $prevthumb=$imgdata['details'];
            $realprevpic=".".$prevpic;
            $realprevthumb=".".$prevthumb;
            if(file_exists($realprevpic)&&$realprevpic!=="."){
              unlink($realprevpic);
            }
            if(file_exists($realprevthumb)&&$realprevthumb!=="."){
              unlink($realprevthumb);
            }
            genericSingleUpdate("media","location",$imagepath,"id",$imgid);
            genericSingleUpdate("media","details",$imagepath2,"id",$imgid);
            genericSingleUpdate("media","filesize",$filesize,"id",$imgid);
            genericSingleUpdate("media","width",$width,"id",$imgid);
            genericSingleUpdate("media","height",$height,"id",$imgid);
            // // echo "in here";
          }
        }
        // proceed to check update or insert subproducts for this entry
        if(isset($_POST['cursubproductcountedit'])){
          $spcount=$_POST['cursubproductcountedit'];
          for ($i=1; $i <=$spcount ; $i++) { 
            # code...
            $subcontentid=$_POST['subcontentid'.$i.''];
            $subcontenttitle=mysql_real_escape_string($_POST['subcontenttitle'.$i.'']);
            if($subcontentid>0){
              $subprodstatus=$_POST['subprodstatus'.$i.''];
              genericSingleUpdate("generalinfo","title",$subcontenttitle,"id",$subcontentid);
              genericSingleUpdate("generalinfo","status",$subprodstatus,"id",$subcontentid);
                // // echo $subprodstatus." statsout";
              
            }else{
              if($subcontenttitle!==""){
                  $entrydate=date("Y-m-d H:i:s");
                  $query="INSERT INTO generalinfo(maintype,subtype,title,entrydate)VALUES
                   ('subproductservices','$entryid','$subcontenttitle','$entrydate')";
                  $run=mysql_query($query)or die(mysql_error()." ".__LINE__);
              }
            }
          }
        }
    }
  /*end*/
  if($rurladmin==""){

		header('location:../admin/adminindex.php');
	}else{
		header('location:'.$rurladmin.'');

	}
}else if($entryvariant=="edituser"){
    $maintype="";
    $fullname=mysql_real_escape_string($_POST['fullname']);
    genericSingleUpdate("admin","fullname",$fullname,"id",$entryid);
    $username=mysql_real_escape_string($_POST['username']);
    genericSingleUpdate("admin","username",$username,"id",$entryid);
    $password=mysql_real_escape_string($_POST['password']);
    genericSingleUpdate("admin","password",$password,"id",$entryid);
    $accesslevel=$_POST['accesslevel'];
    genericSingleUpdate("admin","accesslevel",$accesslevel,"id",$entryid);
    $status=isset($_POST['status'])?mysql_real_escape_string($_POST['status']):"";
    genericSingleUpdate("admin","status",$status,"id",$entryid);

    $imgid=mysql_real_escape_string($_POST['coverid']);
    $contentpic=$_FILES['contentpic']['tmp_name'];
    if($contentpic!==""){
      $image="contentpic";
      $imgpath[]='../files/medsizes/';
      $imgpath[]='../files/thumbnails/';
      $imgsize[]="default";
      if($maintype=="about"){
        $imgsize[]="374,";
        $acceptedsize="";
        
      }else{
        $imgsize[]=",300";
        $acceptedsize="";
      }
      $imgouts=genericImageUpload($image,"varying",$imgpath,$imgsize,$acceptedsize);
      $len=strlen($imgouts[0]);
      $imagepath=substr($imgouts[0], 1,$len);
      // medsize
      $len2=strlen($imgouts[1]);
       $imagepath2=substr($imgouts[1], 1,$len2);
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
      if($imgid<1){
        $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,details,filesize,width,height)VALUES
        ('$entryid','adminuser','coverphoto','image','$imagepath','$imagepath2','$filesize','$width','$height')";
        $mediarun=mysql_query($mediaquery)or die(mysql_error()." ".__LINE__);
        
      }else{
        $imgdata=getSingleMediaDataTwo($imgid);
        $prevpic=$imgdata['location'];
        $prevthumb=$imgdata['details'];
        $realprevpic=".".$prevpic;
        $realprevthumb=".".$prevthumb;
        if(file_exists($realprevpic)&&$realprevpic!=="."){
          unlink($realprevpic);
        }
        if(file_exists($realprevthumb)&&$realprevthumb!=="."){
          unlink($realprevthumb);
        }
        genericSingleUpdate("media","location",$imagepath,"id",$imgid);
        // genericSingleUpdate("media","details",$imagepath2,"id",$imgid);
        genericSingleUpdate("media","filesize",$filesize,"id",$imgid);
        genericSingleUpdate("media","width",$width,"id",$imgid);
        genericSingleUpdate("media","height",$height,"id",$imgid);
        // // echo "in here";
      }
    }
    if($rurladmin==""){

		header('location:../admin/adminindex.php');
	}else{
		header('location:'.$rurladmin.'');

	}
}else if($entryvariant=="edithomebanner"){
       // update/delete old slides    
        $cursurveyslidedelete=$_POST['status'.$entryid.''];

          $picout=$_FILES['slide'.$entryid.'']['tmp_name'];
          if ($cursurveyslidedelete!=="inactive") {
            # code...
            $headercaption=$_POST['headercaption'.$entryid.''];
            $minicaption=$_POST['minicaption'.$entryid.''];
            $linkaddress=$_POST['linkaddress'.$entryid.''];
            $linktitle=$_POST['linktitle'.$entryid.''];
            $captioncombo=$headercaption.'[|><|]'.$minicaption.'[|><|]'.$linkaddress.'[|><|]'.$linktitle;
            genericSingleUpdate("media","details","$captioncombo","id","$entryid");
            // // echo $captioncombo;F
            if($picout!=="") {
                # code...
                $image="slide$entryid";
                $imgpath[]='../files/medsizes/';
                $imgsize[]="default";
                $acceptedsize=",460";
                $imgouts=genericImageUpload($image,"single",$imgpath,$imgsize,$acceptedsize);
                $len=strlen($imgouts[0]);
                $imagepath=substr($imgouts[0], 1,$len);
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
                genericSingleUpdate("media","location","$imagepath","id","$entryid");
                genericSingleUpdate("media","filesize","$filesize","id","$entryid");
                genericSingleUpdate("media","width","$width","id","$entryid");
                genericSingleUpdate("media","height","$height","id","$entryid");

            }
          }else if($cursurveyslidedelete=="inactive"){
            // make sure there is at least one slide available, in case an admin goes into a delete frenzy
            // by making use of sentinel control variables "newcount"-for ensuring there is a new entry 
            // and slidedeletecount for ensuring the total number iof deleted entries are within a reasonable range 

            /*$dquery="UPDATE media SET status='inactive' AND maintype='none' AND ownertype='' AND  WHERE id='$picoutid'";
            $drun=mysql_query($dquery)or die(mysql_error()." Line 722");*/
            deleteMedia($entryid);
        }
        if($rurladmin==""){

			header('location:../admin/adminindex.php');
		}else{
			header('location:'.$rurladmin.'');

		}
}elseif ($entryvariant=="editcontentcategory") {
    $catname=mysql_real_escape_string($_POST['catname']);
    
    $testquery="SELECT * FROM contentcategories WHERE catname='$catname'";
    // // echo $testquery;
    $testrun=mysql_query($testquery)or die(mysql_error()." Line ".__LINE__);
    $testnumrows=mysql_num_rows($testrun);
    if($testnumrows>0){
      header('location:../admin/adminindex.php?compid=0&type=editcontentcategory&v=admin&error=true&errort=nameexists');
    }else{
		genericSingleUpdate("contentcategories","catname",$catname,"id",$entryid);
	    
	    $description=mysql_real_escape_string($_POST['description']);
		genericSingleUpdate("contentcategories","description",$description,"id",$entryid);

		$status=mysql_real_escape_string($_POST['status']);
		genericSingleUpdate("contentcategories","status",$status,"id",$entryid);
	  $imgid=$_POST['imgid'];
	  //$coverpicid=getNextId("media");
	  $imgname=$_FILES['profpic']['tmp_name'];
	  if($imgname!==""){
	      	$image="profpic";
	      
		    $imgpath[]='../images/categoryimages/';
		    $imgpath[]='../images/categoryimages/medsizes/';
		    $imgpath[]='../images/categoryimages/thumbnails/';

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
			if($imgid>0){
				$imgdata=getSingleMediaDataTwo($imgid);
				$realprevpic=".".$imgdata['location'];
				$realprevpicmed=".".$imgdata['medsize'];
				$realprevpicthumb=".".$imgdata['thumbnail'];

				// echo $realprevpic;
				// delete previous file entries
				if(file_exists($realprevpic)&&$realprevpic!=="."){
					unlink($realprevpic);
				}
				if(file_exists($realprevpicmed)&&$realprevpicmed!=="."){
					unlink($realprevpicmed);
				}
				if(file_exists($realprevpicthumb)&&$realprevpicthumb!=="."){
					unlink($realprevpicthumb);
				}

				// perform updates on the image
				genericSingleUpdate("media","location",$imagepath,"id",$imgid);
				genericSingleUpdate("media","medsize",$imagepath2,"id",$imgid);
				genericSingleUpdate("media","thumbnail",$imagepath3,"id",$imgid);
				genericSingleUpdate("media","filesize",$filesize,"id",$imgid);
				genericSingleUpdate("media","width",$width,"id",$imgid);
				genericSingleUpdate("media","height",$height,"id",$imgid);	
			}else{
				//maintype variants are original, medsize, thumb for respective size image.
			    $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,medsize,thumbnail,filesize,width,height)VALUES('$entryid','contentcategory','coverphoto','image','$imagepath','$imagepath2','$imagepath3','$filesize','$width','$height')";
			    // echo "$mediaquery media query<br>";
		    	$mediarun=mysql_query($mediaquery)or die(mysql_error()." Line ".__LINE__);
			}
	  }
      header('location:../admin/adminindex.php?compid=0&type=contentcategories&v=admin&error=true');
    }
}elseif ($entryvariant=="editparentcontentadmin") {
    $contenttitle=mysql_real_escape_string($_POST['contenttitle']);    
	genericSingleUpdate("parentcontent","contenttitle",$contenttitle,"id",$entryid);
    $description=mysql_real_escape_string($_POST['description']);
	genericSingleUpdate("parentcontent","contentdescription",$description,"id",$entryid);
	$contentstatus=mysql_real_escape_string($_POST['contentstatus']);
	genericSingleUpdate("parentcontent","contentstatus",$contentstatus,"id",$entryid);
	$status=mysql_real_escape_string($_POST['status']);
	genericSingleUpdate("parentcontent","status",$status,"id",$entryid);
	$imgid=$_POST['imgid'];
	//$coverpicid=getNextId("media");
	$imgname=$_FILES['profpic']['tmp_name'];
	if($imgname!==""){
	  	$image="profpic";
	  
	    $imgpath[]='../images/contentcovers/';
	    $imgpath[]='../images/contentcovers/medsizes/';
	    $imgpath[]='../images/contentcovers/thumbnails/';

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
		if($imgid>0){
			$imgdata=getSingleMediaDataTwo($imgid);
			$realprevpic=".".$imgdata['location'];
			$realprevpicmed=".".$imgdata['medsize'];
			$realprevpicthumb=".".$imgdata['thumbnail'];

			// echo $realprevpic;
			// delete previous file entries
			if(file_exists($realprevpic)&&$realprevpic!=="."){
				unlink($realprevpic);
			}
			if(file_exists($realprevpicmed)&&$realprevpicmed!=="."){
				unlink($realprevpicmed);
			}
			if(file_exists($realprevpicthumb)&&$realprevpicthumb!=="."){
				unlink($realprevpicthumb);
			}

			// perform updates on the image
			genericSingleUpdate("media","location",$imagepath,"id",$imgid);
			genericSingleUpdate("media","medsize",$imagepath2,"id",$imgid);
			genericSingleUpdate("media","thumbnail",$imagepath3,"id",$imgid);
			genericSingleUpdate("media","filesize",$filesize,"id",$imgid);
			genericSingleUpdate("media","width",$width,"id",$imgid);
			genericSingleUpdate("media","height",$height,"id",$imgid);	
		}else{
			//maintype variants are original, medsize, thumb for respective size image.
		    $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,medsize,thumbnail,filesize,width,height)
		    VALUES
		    ('$entryid','parentcontent','coverphoto','image','$imagepath','$imagepath2','$imagepath3','$filesize','$width','$height')";
		    // echo "$mediaquery media query<br>";
	    	$mediarun=mysql_query($mediaquery)or die(mysql_error()." Line ".__LINE__);
		}

	}
	if(isset($_POST['retid'])){
		$donothing="";
		$userdata=getSingleUserPlain($_POST['retid']);
		$userdata['usertype']=="user"?header('location:../userdashboard.php'):
		($userdata['usertype']=="client"?header('location:../clientdashboard.php'):
		$donothing);
		// echo "in here";
    }else{
      
	 	header('location:../admin/adminindex.php?compid=0&type=editparentcontent&eid='.$entryid.'&c[]=&v=admin&error=true');
      
    }
    
}elseif ($entryvariant=="editcontententries") {
	# code...
	// get current date
	$currentdate=date("Y-m-d H:i:s");
	$releasedate=$currentdate;
	$currentdata=getSingleContentEntry($entryid);
	$parentid=$currentdata['parentid'];
	$curid=$entryid;
	$exit="";
	if($parentid>0){
  	
	    $parentdata=getSingleParentContent($parentid);
	    $catid=$parentdata['contenttypeid'];
	    $uploadpath="";
	  
	    if($parentdata['userid']>0){
	  
	      // get the user data
	      $userdata=getSingleUser($parentdata['userid']);
	      $userid=$parentdata['userid'];
	      $uhash=md5($parentdata['userid']);
	      
	      // based on user data, determine th type of user and 
	      // verify if the necessary folder for them is in place
	      if($userdata['usertype']=="client"){
	  
	        // check to see if the folder exists
	        if(!is_dir('../files/clients/'.$uhash.'/'.strtolower($parentdata['contenttitle']).''.$parentid.'/')){
	  
	          // userfoldersection
	          !file_exists('../files/clients/'.$uhash.'/')?mkdir('../files/clients/'.$uhash.'/',0777)or die("Error creating folder"):$exit;
	          $uploadpath='../files/clients/'.$uhash.'/'.strtolower($parentdata['contenttitle']).''.$parentid.'/';
	          !is_dir($uploadpath)?mkdir(''.$uploadpath.'',0777)or die("Error creating folder"):$exit;
	          !is_dir($uploadpath.'orignals/')?mkdir(''.$uploadpath.'originals/',0777)or die("Error creating folder"):$exit;
	          !is_dir($uploadpath.'medsizes/')?mkdir(''.$uploadpath.'medsizes/',0777)or die("Error creating folder"):$exit;
	          !is_dir($uploadpath.'thumbnails/')?mkdir(''.$uploadpath.'thumbnails/',0777)or die("Error creating folder"):$exit;
	        }else{
	          $uploadpath='../files/clients/'.$uhash.'/'.strtolower($parentdata['contenttitle']).''.$parentid.'/';
	          
	        }
	  
	      }else if($userdata['usertype']=="user"){
	        
	        if(!is_dir('../files/users/'.$uhash.'/'.strtolower($parentdata['contenttitle']).''.$parentid.'/')){
	        
	          // mkdir('../files/users/'.$uhash.'/',0777)or die("Error creating folder");
	          !file_exists('../files/users/'.$uhash.'/')?mkdir('../files/users/'.$uhash.'/',0777)or die("Error creating folder"):$exit;
	          $uploadpath='../files/users/'.$uhash.'/'.strtolower($parentdata['contenttitle']).''.$parentid.'/';
	          !is_dir($uploadpath)?mkdir(''.$uploadpath.'',0777)or die("Error creating folder"):$exit;
	          !is_dir($uploadpath.'orignals/')?mkdir(''.$uploadpath.'originals/',0777)or die("Error creating folder"):$exit;
	          !is_dir($uploadpath.'medsizes/')?mkdir(''.$uploadpath.'medsizes/',0777)or die("Error creating folder"):$exit;
	          !is_dir($uploadpath.'thumbnails/')?mkdir(''.$uploadpath.'thumbnails/',0777)or die("Error creating folder"):$exit;
	        }else{
	          $uploadpath='../files/users/'.$uhash.'/'.strtolower($parentdata['contenttitle']).''.$parentid.'/';

	        }
	      }
	    }else{
	  
	      // check to see if napstand files are intact
	      if(!is_dir('../files/napstand/'.strtolower($parentdata['contenttitle']).''.$parentid.'/')){
	  
	        // userfoldersection
	        $uploadpath='../files/napstand/'.strtolower($parentdata['contenttitle']).''.$parentid.'/';
	        !is_dir($uploadpath)?mkdir(''.$uploadpath.'',0777)or die("Error creating folder"):$exit;
	        !is_dir($uploadpath.'orignals/')?mkdir(''.$uploadpath.'originals/',0777)or die("Error creating folder"):$exit;
	        !is_dir($uploadpath.'medsizes/')?mkdir(''.$uploadpath.'medsizes/',0777)or die("Error creating folder"):$exit;
	        !is_dir($uploadpath.'thumbnails/')?mkdir(''.$uploadpath.'thumbnails/',0777)or die("Error creating folder"):$exit;
	      }else{
	        $uploadpath='../files/napstand/'.strtolower($parentdata['contenttitle']).''.$parentid.'/';
	          
	          
	      }
	    }
	    
	    $contenttitle=mysql_real_escape_string($_POST['editcontenttitle']);
		genericSingleUpdate("contententries","title",$contenttitle,"id",$entryid);
	    $description=mysql_real_escape_string($_POST['editdescription']);
		genericSingleUpdate("contententries","details",$description,"id",$entryid);
	    $price=mysql_real_escape_string($_POST['editpostprice']);
		genericSingleUpdate("contententries","price",$price,"id",$entryid);

	    $publishdata=isset($_POST['editpublishdata'])?mysql_real_escape_string($_POST['editpublishdata']):"";
		genericSingleUpdate("contententries","publishstatus",$publishdata,"id",$entryid);
	    $status=mysql_real_escape_string($_POST['status']);
		genericSingleUpdate("contententries","status",$status,"id",$entryid);

	    $scheduledate=isset($_POST['editscheduledate'])?mysql_real_escape_string($_POST['editscheduledate']):"";

	    if(strtolower($publishdata)=="scheduled"){
	      $releasedate="";
	      $scheduledata=explode(" ", $scheduledate);
	      $scheduledate-$scheduledata[0];
	      $scheduletime-$scheduledata[1];

	      //make sure schedule date and time have appropriate values
	      $scheduletime!==""&&$scheduledate!==""?$scheduletime=$scheduletime.":00":$scheduletime="";
	      $scheduledate==""?$scheduledate=date('Y-m-d', strtotime('1 day')):$scheduledate;
	      $scheduletime==""?$scheduletime="08:00:00":$scheduletime.":00";
	      $fullschedulepostperiod="";
	      //verify that the set date has not passed
	      $datetime1 = new DateTime("$scheduledate $scheduletime"); // specified scheduled time
	      $datetime2 = new DateTime(); // current time 
	      if($datetime2>$datetime1){
	        //if the current date time is greater than th eone specified then the user chose past date
	        //set date to a day ahead
	        // echo "inside comparison operator<br>";
	        $scheduledate=date('Y-m-d', strtotime('1 day')); 
	      }

	      // $enddate=date('Y-m-d', strtotime('2 days'));
	      
	      // echo "inside comparison operator<br>";
	      $fullschedulepostperiod=$scheduledate." ".$scheduletime."";
		  genericSingleUpdate("contententries","scheduledate",$fullschedulepostperiod,"id",$entryid);

	      $datetwo="0000-00-00 00:00:00";
	    }else if($publishdata=="published"){
			genericSingleUpdate("contententries","releasedate",$releasedate,"id",$entryid);
			// makes sure the schedule column value has no entry so monitoring aint done
		    genericSingleUpdate("contententries","scheduledate","0000-00-00 00:00:00","id",$entryid);

	    }

	    $uploadtype=mysql_real_escape_string($_POST['edituploadtype']);
	  	echo $uploadtype.":Up type";
	    // perform the content image uploads to the right directory
	    if($uploadtype=="imageuploadedit"){
	  
	      // get the total image count entering here
	      $imagecount=mysql_real_escape_string($_POST['imagecountedit']);
	      $ncount=1;
	      // echo $uploadpath;
	      for($i=1;$i<=$imagecount;$i++){
	        $image="image_$i";  
	        if(isset($_FILES[''.$image.'']['name'])&&$_FILES[''.$image.'']['name']!==""){
	          $imgpath[0]=''.$uploadpath.'originals/';
	          $imgpath[1]=''.$uploadpath.'medsizes/';
	          $imgpath[2]=''.$uploadpath.'thumbnails/';
	          
	          $imgsize[0]="default";
	          $imgsize[1]=",400";
	          $imgsize[2]=",150";

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
	          $filesize=fileSizeConvert($_FILES[''.$image.'']['size']);
	          


	          //$coverpicid=getNextId("media");
	          //maintype variants are original, medsize, thumb for respective size image.

	          // check the details of the media table to find out if there is an available space
	          // for the current content from an item that has been deleted
	          $testq="SELECT * FROM media WHERE status='inactive' and maintype='contententryimage'";
	          $testr=mysql_query($testq)or die(mysql_error()." Line ".__LINE__);
	          $testn=mysql_num_rows($testr);
	          $prevquery="SELECT * FROM media where ownerid=$entryid AND ownertype='contententry' AND maintype='contententryimage' AND mainid>0 AND status='active' ORDER BY mainid";
	          $prevrun=mysql_query($prevquery)or die(mysql_error()." Line ".__LINE__);
	          $prevcount=mysql_num_rows($prevrun);
	          $ncount=$prevcount>0?$prevcount+1:$ncount;
	          if($testn>0){
	            $testrow=mysql_fetch_assoc($testr);
	              # code...
	              $imgid=$testrow['id'];
	              // perform updates on the image
	              genericSingleUpdate("media","ownerid",$entryid,"id",$imgid);
	              genericSingleUpdate("media","ownertype","contententry","id",$imgid);
	              genericSingleUpdate("media","location",$imagepath,"id",$imgid);
	              genericSingleUpdate("media","medsize",$imagepath2,"id",$imgid);
	              genericSingleUpdate("media","thumbnail",$imagepath3,"id",$imgid);
	              genericSingleUpdate("media","filesize",$filesize,"id",$imgid);
	              genericSingleUpdate("media","mainid",$ncount,"id",$imgid);
	              genericSingleUpdate("media","width",$width,"id",$imgid);
	              genericSingleUpdate("media","height",$height,"id",$imgid);  
	              genericSingleUpdate("media","status","active","id",$imgid);  
	              $ncount++;
	          }else{
	            $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mainid,mediatype,location,medsize,thumbnail,filesize,width,height)VALUES
	            ('$entryid','contententry','contententryimage','$ncount','image','$imagepath','$imagepath2','$imagepath3','$filesize','$width','$height')";
	            // echo "<br>$mediaquery media query<br>";
	            $mediarun=mysql_query($mediaquery)or die(mysql_error()." Line" .__LINE__);
	            $ncount++;
	          }
	        }
	      }
	    }elseif ($uploadtype=="zipuploadedit") {
	      # code...
	      $defaultarchivelocation='../files/archives/';
	      $file_name = $_FILES['zipfileedit']['name'];
	      echo "<br> In here $file_name ->filename<br>";
	      $match=checkExistingFile($defaultarchivelocation,strtolower($file_name));
	      $nextentry=md5($match['totalfilecount']+1);
	      $new_file_name=$nextentry.".zip";
	      
	      $temppath=$defaultarchivelocation.$nextentry."temp/";
	      mkdir("$temppath", 0777, true);

	      $path= $defaultarchivelocation.''.$new_file_name;
	      if($file_name !==""){
	      	  echo "<br> In here 2 <br>";
	          if(move_uploaded_file($_FILES['zipfileedit']['tmp_name'], $path)){
	      		  echo "<br> In here 3<br>";

	              $zip = new ZipArchive;
	              $res = $zip->open($path);
	              if ($res === TRUE) {
	              	$ncount=1;
	                // extract the images from the archive to a temppath
	                $zip->extractTo($temppath);
	                $zip->close();
	                // echo 'extraction successful';
	                // proceed to get the image data by running through the tempdir iterating over 
	                // each valid image entry
	                $outextract=sortThroughDir("$temppath",'jpg|.jpg|jpeg|.jpeg|png|.png|.svg|svg|gif|.gif',"plainsort");
	                if($outextract['totalmatches']>0){
	                  $outimgs="";
	      			  echo "<br> In here 4<br>";
	                  for($i=0;$i<$outextract['totalmatches'];$i++){
	                    // $fulloutput.='<p>'.$outextract['matchedfiles'][$i].'</p>';
	                    $imagedata[0]=$outextract['matchedfiles'][$i]; // image name
	                    $imagedata[1]=$outextract['matchedfilespath'][$i]; // image path (img data)
	                    $imagedata[2]=filesize($outextract['matchedfilespath'][$i]); //imagesize
	                    $imagedata[3]="image/".$outextract['matchedfiles'][$i];
	                    $extension=getExtension($outextract['matchedfiles'][$i]);
	                    // proceed to get the image data by running through the tempdir iterating over 
	                    // each valid image entry
	                    $imgpath[0]=''.$uploadpath.'originals/';
	                    $imgpath[1]=''.$uploadpath.'medsizes/';
	                    $imgpath[2]=''.$uploadpath.'thumbnails/';

	                    $imgsize[0]="default";
	                    $imgsize[1]=",400";
	                    $imgsize[2]=",150";

	                    $acceptedsize="";
	                    $imgouts=genericImageUpload($imagedata,"varying",$imgpath,$imgsize,$acceptedsize);

	                    $len=strlen($imgouts[0]);
	                    $imagepath=substr($imgouts[0], 1,$len);
                    	list($width,$height)=getimagesize($imgouts[0]);
	                    $filesize=fileSizeConvert($imagedata[2]);

	                    // medium size 
	                    $len2=strlen($imgouts[1]);
	                    $imagepath2=substr($imgouts[1], 1,$len2);

	                    // thumb size
	                    $len3=strlen($imgouts[2]);
	                    $imagepath3=substr($imgouts[2], 1,$len3);
	                    
	                    // check the details of the media table to find out if there is an available space
	                    // for the current content from an item that has been deleted
	                    $testq="SELECT * FROM media WHERE status='inactive' and maintype='contententryimage'";
	                    $testr=mysql_query($testq)or die(mysql_error()." Line ".__LINE__);
	                    $testn=mysql_num_rows($testr);
	                    // get the current total image entries for this post
	                    $prevquery="SELECT * FROM media where ownerid=$entryid AND ownertype='contententry' AND maintype='contententryimage' AND mainid>0 AND status='active' ORDER BY mainid";
	                    $prevrun=mysql_query($prevquery)or die(mysql_error()." Line ".__LINE__);
	                    $prevcount=mysql_num_rows($prevrun);
	                    $ncount=$prevcount>0?$prevcount+1:$ncount;
	                    if($testn>0){
	                      while ($testrow=mysql_fetch_assoc($testr)) {
	                        # code...
	                        $imgid=$testrow['id'];
	                        // perform updates on the image
	                        genericSingleUpdate("media","ownerid",$entryid,"id",$imgid);
	                        genericSingleUpdate("media","ownertype","contententry","id",$imgid);
	                        genericSingleUpdate("media","location",$imagepath,"id",$imgid);
	                        genericSingleUpdate("media","medsize",$imagepath2,"id",$imgid);
	                        genericSingleUpdate("media","thumbnail",$imagepath3,"id",$imgid);
	                        genericSingleUpdate("media","filesize",$filesize,"id",$imgid);
	                        genericSingleUpdate("media","mainid",$ncount,"id",$imgid);
	                        genericSingleUpdate("media","width",$width,"id",$imgid);
	                        genericSingleUpdate("media","height",$height,"id",$imgid);  
	                        genericSingleUpdate("media","status","active","id",$imgid);
	                        $ncount++;
	                      }
	                    }else{
	                      $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mainid,mediatype,location,medsize,thumbnail,filesize,width,height)VALUES
	                      ('$entryid','contententry','contententryimage','$ncount','image','$imagepath','$imagepath2','$imagepath3','$filesize','$width','$height')";
	                      // echo "$mediaquery media query<br>";
	                      $mediarun=mysql_query($mediaquery)or die(mysql_error()." Line" .__LINE__);
	                      $ncount++;
	                    }
	                  }
	                  // delete the archive file and the temp folder
	                  if(file_exists($path)){
	                      unlink($path);
	                  }
	                  if(file_exists($temppath)){
	                    removeDirectory($temppath);
	                  }
	                }
	              } else {
	                 echo 'Extraction error';
	              }
	          }else{
	            echo "Error";
	          }
	      }
	    }

	    // insert the content into the database
	    /*$query="INSERT INTO contententries
	            (userid,catid,parentid,title,details,publishstatus,releasedate,scheduledate,price)
	            VALUES
	            ('$userid','$catid','$parentid','$contenttitle','$description','$publishdata','$releasedate','$scheduledate','$price')";*/
	    // echo "<br>".$query."<br>";
	    // $run=mysql_query($query)or die(mysql_error()." line ".__LINE__);
	    if(isset($_POST['retid'])){
			$donothing="";
			$userdata=getSingleUserPlain($_POST['retid']);
			$userdata['usertype']=="user"?header('location:../userdashboard.php'):
			($userdata['usertype']=="client"?header('location:../clientdashboard.php'):
			$donothing);
			// echo "in here";
	    }else{
	    	header('location:../admin/adminindex.php?compid=&t=3&v=admin&pt='.$entryvariant.'');
	    }  
  
	}else{
		echo"<p>Entry Invalidated, no parent content detected for this entry</p>";
	}
}elseif ($entryvariant=="sortcontententries") {
	# code...
	$entrycount=mysql_real_escape_string($_POST['entrycount']);
	for($i=1;$i<=$entrycount;$i++){
		$imgid=$_POST['imgid_'.$i.''];
		$mainid=$_POST['mainid_'.$i.''];
		$mediadata=getSingleMediaDataTwo("$imgid");
		// alter the table accordingly
		$ownerid=$mediadata['ownerid'];
		$prevmainid=$mediadata['mainid'];
		$ownertype=$mediadata['ownertype'];
		$maintype=$mediadata['maintype'];
		if($prevmainid!==$mainid){
			if($prevmainid<$mainid){
				$uptq="UPDATE media SET mainid=mainid+1 WHERE mainid>$mainid AND mainid<$prevmainid  AND ownerid='$ownerid'AND ownertype='$ownertype'AND maintype='$maintype'";
				$uptr=mysql_query($uptq)or die(mysql_error()." Line ".__LINE__);

			}else if($prevmainid>$mainid){
				$uptq="UPDATE media SET mainid=mainid-1 WHERE mainid<$mainid AND mainid>$prevmainid AND ownerid='$ownerid'AND ownertype='$ownertype'AND maintype='$maintype'";
				$uptr=mysql_query($uptq)or die(mysql_error()." Line ".__LINE__);
				
			}
			genericSingleUpdate("media","mainid",$mainid,"id",$imgid);
		}
	}
	if(isset($_POST['retid'])){
		$donothing="";
		$userdata=getSingleUserPlain($_POST['retid']);
		$userdata['usertype']=="user"?header('location:../userdashboard.php'):
		($userdata['usertype']=="client"?header('location:../clientdashboard.php'):
		$donothing);
		// echo "in here";
    }else{
	    header('location:../admin/adminindex.php?compid=0&type='.$entryvariant.'&v=admin&error=true');
    }  
  
}
?>