<?php
include('connection.php');
session_start();
$entryvariant="";
$entryvariant=isset($_POST['entryvariant'])?$_POST['entryvariant']:$_GET['entryvariant'];
if($entryvariant==""){
  // echo $_POST['uploadtype'];
  echo"No variant recieved";
}elseif($entryvariant=="createmedia"){
$piccount=$_POST['piccount'];
//// echo $piccount;
if($piccount>0){
  for($i=1;$i<=$piccount;$i++){
    $filename='defaultpic'.$i.'';
  $albumpic=$_FILES['defaultpic'.$i.'']['tmp_name'];
  if($albumpic!==""){
  $filetypedata=getFileType($filename);
  if($filetypedata=="image"){
    $image="defaultpic".$i."";
    if(isset($imagepath)){
    unset($imagepath);
    unset($imagesize);
  }
  $imagepath=array();
  $imagesize=array();
  $imgpath[0]='../media/multimedia/';
  $imgpath[1]='../media/thumbs/';
  $imgsize[0]="default";
  $imgsize[1]=",100";
  // // echo count($imgsize);
  $acceptedsize="";
  $imgouts=genericImageUpload($image,"varying",$imgpath,$imgsize,$acceptedsize);
  $len=strlen($imgouts[0]);
  // // echo $imgouts[0]."<br>";
  $contentpath=substr($imgouts[0], 1,$len);
  $len2=strlen($imgouts[1]);
  // // echo $imgouts[1]."<br>";
  $contentpath2=substr($imgouts[1], 1,$len2);
  // get image size details
  $filedata=getFileDetails($imgouts[0],"image");
  $filesize=$filedata['size'];
  $width=$filedata['width'];
  $height=$filedata['height'];
  $contenttype='image';
}else if($filetypedata=="audio"||$filetypedata=="video"){
if($filetypedata=='audio'){
$outscontent=simpleUpload($filename,'../media/multimedia/audio/');
$contenttype="audio";
}elseif ($filetypedata=='video') {
  # code...
$outscontent=simpleUpload($filename,'../media/multimedia/videos/');
$contenttype="video";
}

$contentfilepath=$outscontent['filelocation'];
$len=strlen($contentfilepath);
$contentpath=substr($contentfilepath, 1,$len);
$filesize=$outscontent['filesize'];
$contentpath2="";
$width="";
$height="";
}/*else if($filetypedata=="others"){

}*/
// insert file content info into database
$mediaquery="INSERT INTO media(ownertype,details,mediatype,location,filesize,width,height)VALUES('contentmedia','$contentpath2','$contenttype','$contentpath','$filesize','$width','$height')";
// // echo $mediaquery."<br>";
$mediarun=mysql_query($mediaquery)or die(mysql_error());
}
}
}
header('location:../admin/adminindex.php');
}elseif ($entryvariant=="createblogtype") {
  # code...
  $blogname=mysql_real_escape_string($_POST['name']);
  $pattern2='/[\n\$!#\%\^<>@\(\),\'.\"\/\%\*\{\}\&\[\]\?\_\-\+\=:;’]/';
  $pagename=preg_replace($pattern2,"", $blogname);
  $pattern='/[\s]/';
  $pagename=preg_replace($pattern,"-", $pagename);
  $pagename=stripslashes($pagename);
  $foldername=$pagename;
  $rssname=preg_replace('/[\'.\s-\"$]/',"", $pagename);
  // $rssname=mysql_real_escape_string($rssname);
  $rssname=strtolower($rssname);
  $foldername=preg_replace('/[\'.\"$]/',"",$foldername);
  // $blogname=mysql_real_escape_string($blogname);
  $testquery="SELECT * FROM blogtype WHERE name='$blogname' OR rssname='$rssname'";
  // // echo $testquery;
  $testrun=mysql_query($testquery)or die(mysql_error()." Line 91");
  $testnumrows=mysql_num_rows($testrun);
  if($testnumrows>0){
    // // echo "in here";
    header('location:../admin/adminindex.php?compid=0&type=404&v=admin&error=true');
  }
  $blogdescription=mysql_real_escape_string($_POST['description']);
  $blogid=getNextId("blogtype");
  $query="INSERT INTO blogtype (name,foldername,rssname,description)VALUES('$blogname','$foldername','$rssname','$blogdescription')";
  // // echo $query;
  $run=mysql_query($query)or die(mysql_error()."Line 56");
  mkdir('../blog/'.$foldername.'/',0777)or die("Error creating folder");
  $title=''.stripslashes($blogname).' | Napstand';
  $title=mysql_real_escape_string($title);
  $page=''.$pagename.'.php';
  /*   // echo $foldername."<br>";
    // echo $rssname."<br>";
    // echo $pagename."<br>";
    // echo $blogname."<br>";
    // echo $blogdescription."<br>";*/

    if($blogname=="Napstand Blog"||$blogname=="Napstand Blog"){
     $page='blog.php';
    }/*elseif($blogname=="Christ Society International Outreach"){
    $page='csi.php';

  }elseif($blogname=="Project Fix Nigeria"){
    $page='projectfixnigeria.php';

  }*/
  $landingpage=$host_addr.$page;
  $rssheader='<?xml version="1.0" encoding="utf-8"?>
  <rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
  <channel>
  <title>'.$title.'</title>
  <atom:link href="'.$host_addr.'feeds/rss/'.$rssname.'.xml" rel="self" type="application/rss+xml"/>
  <description>
  '.$blogdescription.'
  </description>
  <link>'.$landingpage.'</link>
  ';
  $rssfooter='</channel></rss>';
  $rsscontent=$rssheader.$rssfooter;
  // // echo stripslashes($rsscontent);
  // $handle=fopen("../".$blogname.".php","w")or die('cant open the file');
  $handle2=fopen("../feeds/rss/".$rssname.".xml","w")or die('cant open the file');
  fwrite($handle2,stripslashes($rsscontent)); 
  // fclose($handle);
  fclose($handle2);
    // // echo $query;
  $query2="INSERT INTO rssheaders (blogtypeid,headerdetails,footerdetails)VALUES('$blogid','$rssheader','$rssfooter')";
  $run2=mysql_query($query2)or die(mysql_error()."Line 85");  
  // // echo $query2;
  // header('location:../admin/adminindex.php?compid=1&type=0&v=admin');
}elseif ($entryvariant=="createblogcategory") {
  $categoryid=$_POST['categoryid'];
  $blogcategory=mysql_real_escape_string($_POST['name']);
    $pattern2='/[\n\s\$!#\%\^<>@\(\),\'\"\/\%\*\{\}\&\[\]\?\_\-\+\=:;’]/';
    $rssname=preg_replace($pattern2,"", $blogcategory);
  $rssname=mysql_real_escape_string($rssname);
    $rssname=$categoryid.strtolower($rssname);
  $testquery="SELECT * FROM blogcategories WHERE blogtypeid=$categoryid AND catname='$blogcategory' OR blogtypeid=$categoryid AND rssname='$rssname'";
  // // echo $testquery;
  $testrun=mysql_query($testquery)or die(mysql_error()." Line 91");
  $testnumrows=mysql_num_rows($testrun);
  if($testnumrows>0){
    // // echo "in here";
  header('location:../admin/adminindex.php?compid=0&type=404&v=admin&error=true');
  }
  $curid=getNextId("blogcategories");
  $outs=getSingleBlogType($categoryid);
  $subtext="";
  if($outs['name']=="Project Fix Nigeria"){
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
    //$coverpicid=getNextId("media");
    //maintype variants are original, medsize, thumb for respective size image.
    $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,filesize,width,height)VALUES('$curid','blogcategory','original','image','$imagepath','$filesize','$width','$height')";
    $mediarun=mysql_query($mediaquery)or die(mysql_error());
    $subtext=mysql_real_escape_string($_POST['subtext']);
  }
  $query="INSERT INTO blogcategories (blogtypeid,catname,rssname,subtext)VALUES('$categoryid','$blogcategory','$rssname','$subtext')";
  // // echo $query;
  $run=mysql_query($query)or die(mysql_error()."Line 97");
      $title=''.$outs['name'].' | Muyiwa Afolabi\'s Website';
  $title=mysql_real_escape_string($title);

    $page=''.$outs['name'].'.php';
    $landingpage=$host_addr."category.php?cid=".$curid;
  $rssheader='<?xml version="1.0" encoding="utf-8"?>
  <rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
  <channel>
  <title>'.$title.'</title>
  <atom:link href="'.$host_addr.'feeds/rss/'.$rssname.'.xml" rel="self" type="application/rss+xml"/>
  <description>
  Category '.$blogcategory.'
  </description>
  <link>'.$landingpage.'</link>
  ';
  $rssfooter='</channel></rss>';

  $rsscontent=$rssheader.$rssfooter;
  $handle2=fopen("../feeds/rss/".$rssname.".xml","w")or die('cant open the file');
  fwrite($handle2,stripslashes($rsscontent));
  // fclose($handle2);
    // // echo $query;
  $query2="INSERT INTO rssheaders (blogtypeid,blogcatid,headerdetails,footerdetails)VALUES('$categoryid','$curid','$rssheader','$rssfooter')";
  $run2=mysql_query($query2)or die(mysql_error()."Line 85");
  header('location:../admin/adminindex.php');

}elseif ($entryvariant=="createcontentcategory") {
    $catname=mysql_real_escape_string($_POST['catname']);
    $description=mysql_real_escape_string($_POST['description']);
    
    $testquery="SELECT * FROM contentcategories WHERE catname='$catname'";
    // // echo $testquery;
    $testrun=mysql_query($testquery)or die(mysql_error()." Line ".__LINE__);
    $testnumrows=mysql_num_rows($testrun);
    if($testnumrows>0){
      header('location:../admin/adminindex.php?compid=0&type=&v=admin&error=true');
    }else{
      $curid=getNextId("contentcategories");
    
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
      //$coverpicid=getNextId("media");
      //maintype variants are original, medsize, thumb for respective size image.
      $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,medsize,thumbnail,filesize,width,height)VALUES('$curid','contentcategory','coverphoto','image','$imagepath','$imagepath2','$imagepath3','$filesize','$width','$height')";
      // echo "$mediaquery media query<br>";
      $mediarun=mysql_query($mediaquery)or die(mysql_error());

      $query="INSERT INTO contentcategories (catname,description)VALUES('$catname','$description')";
      // echo $query;
      $run=mysql_query($query)or die(mysql_error()." Line ".__LINE__);
      header('location:../admin/adminindex.php?compid=0&type=contentcategories&v=admin&error=true');
    }
}elseif ($entryvariant=="parentcontent") {
    $contenttitle=mysql_real_escape_string($_POST['contenttitle']);
    $catid=mysql_real_escape_string($_POST['catid']);
    $userlist=isset($_POST['userlist'])?mysql_real_escape_string($_POST['userlist']):"";
    $napstandlist=isset($_POST['napstandlist'])?mysql_real_escape_string($_POST['napstandlist']):"";
    $clientlist=isset($_POST['clientlist'])?mysql_real_escape_string($_POST['clientlist']):"";
    $userreallist=isset($_POST['userreallist'])?mysql_real_escape_string($_POST['userreallist']):"";
    $clientreallist=isset($_POST['clientreallist'])?mysql_real_escape_string($_POST['clientreallist']):"";
    $userid=0;
    if($userlist=="yes"){
      $userid=$userreallist;
    }
    if($clientlist=="yes"){
      $userid=$clientreallist;
    }
    $description=mysql_real_escape_string($_POST['description']);
    $curid=getNextId("parentcontent");
  
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
    //$coverpicid=getNextId("media");
    //maintype variants are original, medsize, thumb for respective size image.
    $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,medsize,thumbnail,filesize,width,height)VALUES
    ('$curid','parentcontent','coverphoto','image','$imagepath','$imagepath2','$imagepath3','$filesize','$width','$height')";
    // echo "$mediaquery media query<br>";
    $mediarun=mysql_query($mediaquery)or die(mysql_error());
    $currentdate=date("Y-m-d H:i:s");
    $query="INSERT INTO parentcontent 
    (contenttitle,userid,contentdescription,contenttypeid,entrydate)
    VALUES
    ('$contenttitle','$userid','$description','$catid','$currentdate')";
    // echo $query;
    $run=mysql_query($query)or die(mysql_error()." Line ".__LINE__);
    if(isset($_POST['retid'])){
      $userid=$_POST['retid'];
      $msg='Successfully created a parent content';
      createNotification($userid,"users","parentcontent",$msg,$curid,'parentcontent',"",0);
      $donothing="";
      $userdata=getSingleUserPlain($_POST['retid']);
      $userdata['usertype']=="user"?header('location:../userdashboard.php'):
      ($userdata['usertype']=="client"?header('location:../clientdashboard.php'):
        $donothing);
      // echo "in here";
    }else{
      $logpart=md5($host_addr);
      $userid=$_SESSION['aduid'.$logpart.'']?$_SESSION['aduid'.$logpart.'']:"";
      createNotification($userid,"admin","parentcontent",$msg,$curid,'parentcontent',"",0);
      header('location:../admin/adminindex.php?compid=0&type=parentcontent&v=admin&error=true');
      
    }
}else if($entryvariant=="createcontententry"){
  // get the nextid of the contententries table
  $curid=getNextId('contententries');

  // get current date
  $currentdate=date("Y-m-d H:i:s");
  $releasedate=$currentdate;
  $parentid=mysql_real_escape_string($_POST['parentid']);
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
    
    $contenttitle=mysql_real_escape_string($_POST['contenttitle']);
    $description=mysql_real_escape_string($_POST['description']);
    $price=mysql_real_escape_string($_POST['postprice']);

    $publishdata=mysql_real_escape_string($_POST['publishdata']);
    $scheduledate=mysql_real_escape_string($_POST['scheduledate']);
    $fullschedulepostperiod=$scheduledate;
    $scheduletime="";
    if(strtolower($publishdata)=="scheduled"){
      $releasedate="";
      $scheduledata=explode(" ", $scheduledate);
      $scheduledate=$scheduledata[0];
      $scheduletime=$scheduledata[1];

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
      $datetwo="0000-00-00 00:00:00";
    }

    $uploadtype=mysql_real_escape_string($_POST['uploadtype']);
  
    // perform the content image uploads to the right directory
    if($uploadtype=="imageupload"){
  
      // get the total image count entering here
      $imagecount=mysql_real_escape_string($_POST['imagecount']);
      $ncount=1;
      // echo $uploadpath;
      for($i=1;$i<=$imagecount;$i++){
        $image="image_$i";  
        if(isset($_FILES[''.$image.'']['name'])&&$_FILES[''.$image.'']['name']!==""){
          $imgpath[0]=''.$uploadpath.'originals/';
          $imgpath[1]=''.$uploadpath.'medsizes/';
          $imgpath[2]=''.$uploadpath.'thumbnails/';
          
          /*echo $imgpath[0]."<br>";
          echo $imgpath[1]."<br>";
          echo $imgpath[2]."<br>";*/
          
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
          /*$imagesize=$_FILES[''.$image.'']['size'];
          $filesize=$imagesize/1024;
          //// echo $filefirstsize;
          $filesize=round($filesize, 0, PHP_ROUND_HALF_UP);

          if(strlen($filesize)>3){
            $filesize=$filesize/1024;
            $filesize=round($filesize,2); 
            $filesize="".$filesize."MB";
          }else{
            $filesize="".$filesize."KB";
          }*/


          //$coverpicid=getNextId("media");
          //maintype variants are original, medsize, thumb for respective size image.

          // check the details of the media table to find out if there is an available space
          // for the current content from an item that has been deleted
          $testq="SELECT * FROM media WHERE status='inactive' and maintype='contententryimage'";
          $testr=mysql_query($testq)or die(mysql_error()." Line ".__LINE__);
          $testn=mysql_num_rows($testr);
          $prevquery="SELECT * FROM media where ownerid=$curid AND ownertype='contententry' AND maintype='contententryimage' AND mainid>0 AND status='active' ORDER BY mainid";
          $prevrun=mysql_query($prevquery)or die(mysql_error()." Line ".__LINE__);
          $prevcount=mysql_num_rows($prevrun);
          $ncount=$prevcount>0?$prevcount+1:$ncount;
          if($testn>0){
            $testrow=mysql_fetch_assoc($testr);
              # code...
              $imgid=$testrow['id'];
              // perform updates on the image
              genericSingleUpdate("media","ownerid",$curid,"id",$imgid);
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
            ('$curid','contententry','contententryimage','$ncount','image','$imagepath','$imagepath2','$imagepath3','$filesize','$width','$height')";
            // echo "<br>$mediaquery media query<br>";
            $mediarun=mysql_query($mediaquery)or die(mysql_error()." Line" .__LINE__);
            $ncount++;
          }
        }
      }
    }elseif ($uploadtype=="zipupload") {
      # code...
      $defaultarchivelocation='../files/archives/';
      $file_name = $_FILES['zipfile']['name'];
      
      $match=checkExistingFile($defaultarchivelocation,strtolower($file_name));
      $nextentry=md5($match['totalfilecount']+1);
      $new_file_name=$nextentry.".zip";
      
      $temppath=$defaultarchivelocation.$nextentry."temp/";
      mkdir("$temppath", 0777, true);

      $path= $defaultarchivelocation.''.$new_file_name;
      if($file_name !==""){
          if(move_uploaded_file($_FILES['zipfile']['tmp_name'], $path)){
              $zip = new ZipArchive;
              $res = $zip->open($path);
              if ($res === TRUE) {
                // extract the images from the archive to a temppath
                $zip->extractTo($temppath);
                $zip->close();
                // echo 'extraction successful';
                // proceed to get the image data by running through the tempdir iterating over 
                // each valid image entry
                $outextract=sortThroughDir("$temppath",'jpg|.jpg|jpeg|.jpeg|png|.png|.svg|svg|gif|.gif',"plainsort");
                if($outextract['totalmatches']>0){
                  $ncount=1;
                  $outimgs="";
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
                    /*$fulloutput.='
                      <p>
                        '.$imagepath.'<br>
                        '.$imagepath2.'<br>
                        '.$imagepath3.'<br>
                        '.$filesize.'<br>
                      </p>
                    ';*/
                    // check the details of the media table to find out if there is an available space
                    // for the current content from an item that has been deleted
                    $testq="SELECT * FROM media WHERE status='inactive' and maintype='contententryimage'";
                    $testr=mysql_query($testq)or die(mysql_error()." Line ".__LINE__);
                    $testn=mysql_num_rows($testr);
                    $prevquery="SELECT * FROM media where ownerid=$curid AND ownertype='contententry' AND maintype='contententryimage' AND mainid>0 AND status='active' ORDER BY mainid";
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
                      ('$curid','contententry','contententryimage','$ncount','image','$imagepath','$imagepath2','$imagepath3','$filesize','$width','$height')";
                      // echo "$mediaquery media query<br>";
                      $mediarun=mysql_query($mediaquery)or die(mysql_error()." Line" .__LINE__);
                      $ncount++;
                    }
                  }
                  // delete the archive file and the temp folder
                  if(file_exists($path)){
                    unlink($path);
                  }
                  if(is_dir($temppath)){
                    // $temppath=str_replace("temp/", "temp",$temppath);
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
    $query="INSERT INTO contententries
            (userid,catid,parentid,title,details,publishstatus,releasedate,scheduledate,entrydate,price)
            VALUES
            ('$userid','$catid','$parentid','$contenttitle','$description','$publishdata','$releasedate','$fullschedulepostperiod','$currentdate','$price')";
    // echo "<br>".$query."<br>";
    $run=mysql_query($query)or die(mysql_error()." line ".__LINE__); 
    if(isset($_POST['retid'])){
      $userid=$_POST['retid'];
      $msg='Successfully created a parent content entry';
      createNotification($userid,"users","contententry",$msg,$curid,'contententries',"",0);
      $donothing="";
      $userdata=getSingleUserPlain($_POST['retid']);
      $userdata['usertype']=="user"?header('location:../userdashboard.php'):
      ($userdata['usertype']=="client"?header('location:../clientdashboard.php'):
        $donothing);
      // echo "in here";
    }else{
      header('location:../admin/adminindex.php?compid=&t=3&v=admin&type='.$entryvariant.'');
      
    } 

  }else{
    echo"<p>Entry Invalidated, no parent content detected for this entry</p>";
  }


}elseif($entryvariant=="createblogpost"){
$blogtypeid=$_POST['blogtypeid'];
//the id of the blog page when itgoes into the database
$pageid=getNextId('blogentries');
//getting the main blog type informatoin
$outblog=getSingleBlogType($blogtypeid);
$foldername=$outblog['foldername'];
$blogcategoryid=$_POST['blogcategoryid'];
//blog cover photo management
$blogentrytype=$_POST['blogentrytype'];
$profpic=$_FILES['profpic']['tmp_name'];
if($_FILES['profpic']['tmp_name']!==""&&($blogentrytype==""||$blogentrytype=="normal")){
$image="profpic";
$imgpath[]='../files/';
$imgsize[]="default";
$acceptedsize=",250";
$imgouts=genericImageUpload($image,"single",$imgpath,$imgsize,$acceptedsize);
$len=strlen($imgouts[0]);
$imagepath=substr($imgouts[0], 1,$len);
// get image size details
$filedata=getFileDetails($imgouts[0],"image");
$filesize=$filedata['size'];
$width=$filedata['width'];
$height=$filedata['height'];
// // echo '<img src="'.$imgouts[0].'"> '.$filesize.' '.$width.' '.$height.'';
// get the cover photo's media table id for storage with the blog entry
$coverid=getNextId("media");
$mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,filesize,width,height)VALUES('$pageid','blogentry','coverphoto','image','$imagepath','$filesize','$width','$height')";
$mediarun=mysql_query($mediaquery)or die(mysql_error());
}

$title=mysql_real_escape_string($_POST['title']);
//create physical pagename for the blog by using regex to remove whitespaces and replacing it with -
  $pattern2='/[\n\$!#\%\^<>@\(\),\'\"\/\%\*\{\}\&\[\]\?\_\-\+\=:;’]/';
  $pagename=preg_replace($pattern2,"", $title);
  $pattern='/[\s]/';
  $pagename=preg_replace($pattern,"-", $pagename);
  $pagename=stripslashes($pagename);
if(file_exists('../blog/'.$foldername.'/'.$pagename.'.php')){
    $pagename=$pagename.$pageid;
  }
// // echo "<br>".$title."<br>";
$introparagraph=mysql_real_escape_string($_POST['introparagraph']);
$blogentrymain=$_POST['blogentry'];
// // echo $blogentrymain;
$blogentry=mysql_real_escape_string($_POST['blogentry']);
// $bannerpic=$_FILES['bannerpic']['tmp_name'];
if($_FILES['bannerpic']['tmp_name']!==""&&$blogentrytype=="banner"){
$introparagraph=$title;
$image="bannerpic";
$imgpath[0]='../files/';
$imgpath[1]='../files/thumbnails/';
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
$coverid=getNextId("media");
$mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,details,filesize,width,height)VALUES('$pageid','blogentry','bannerpic','image','$imagepath','$imagepath2','$filesize','$width','$height')";
$mediarun=mysql_query($mediaquery)or die(mysql_error());
}

if($blogentrytype=="gallery"){
  $introparagraph=$introparagraph==""?$title:$introparagraph;
  $piccount=$_POST['piccount'];
  // echo $piccount;
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
        $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,medsize,thumbnail,details,filesize,width,height)VALUES('$pageid','blogentry','gallerypic','image','$imagepath','$imagepath2','$imagepath3','$imagepath3','$filesize','$width','$height')";
        $mediarun=mysql_query($mediaquery)or die(mysql_error());
      }
    }
  }
}
// // echo "<br>".$blogentry;
//create the rss pubDate format for rss entry
$datetime= date("D, d M Y H:i:s")." +0100";
$date=date("d, F Y H:i:s");
$fullpage="$pagename.php";
// // echo $fullpage;
//create the physical page based on preobtained page name
$pagepath='../blog/'.$foldername.'/'.$pagename.'.php';
$handle = fopen($pagepath, 'w') or die('Cannot open file:  '.$pagepath);
//set the new page up
$pagesetup = '<?php 
session_start();
include(\'../../snippets/connection.php\');
$outpage=blogPageCreate('.$pageid.');
echo $outpage[\'outputpageone\'];
$blogdata=getSingleBlogEntry('.$pageid.');
$newview=$blogdata[\'views\']+1;
genericSingleUpdate("blogentries","views",$newview,"id",'.$pageid.');
?>
';
fwrite($handle, $pagesetup);
fclose($handle);
//create blog post rss entry
$introrssentry=str_replace("../",$host_addr,$introparagraph);
$rssentry='<item>
<title>'.$title.'</title>
<link>'.$host_addr.'blog/'.$foldername.'/'.$pagename.'.php</link>
<pubDate>'.$datetime.'</pubDate>
<guid isPermaLink="false">'.$host_addr.'blog/?p='.$pageid.'</guid>
<description>
<![CDATA['.$introrssentry.']]>
</description>
</item>
';
$rssentry=mysql_real_escape_string($rssentry);
// // echo $rssentry;
$rssquery="INSERT INTO rssentries(blogtypeid,blogcategoryid,blogentryid,rssentry)VALUES('$blogtypeid','$blogcategoryid','$pageid','$rssentry')";
$rssrun=mysql_query($rssquery)or die(mysql_error());
//write rss information to respective blog type(for autoposting) and blog category
writeRssData($blogtypeid,0);
writeRssData(0,$blogcategoryid);
//insert the new blog entry to the database
$pagename=mysql_real_escape_string($pagename);
$query="INSERT INTO blogentries(blogtypeid,blogcatid,blogentrytype,title,introparagraph,blogpost,entrydate,coverphoto,pagename)VALUES('$blogtypeid','$blogcategoryid','$blogentrytype','$title','$introparagraph','$blogentry','$date','$coverid','$pagename')";
$run=mysql_query($query)or die(mysql_error()." Line 244");
//send new email on blog post to all subscribed users
sendSubscriberEmail($pageid);
//end
header('location:../admin/adminindex.php?compid=3&t=3&v=admin');
}elseif ($entryvariant=="createblogcomment") {
  # code...
  $blogentryid=mysql_real_escape_string($_POST['blogentryid']);
  $name=mysql_real_escape_string($_POST['name']);
  $email=mysql_real_escape_string($_POST['email']);
  $sectester=mysql_real_escape_string($_POST['sectester']);
  $secnumber=mysql_real_escape_string($_POST['secnumber']);
  $comment=mysql_real_escape_string($_POST['comment']);
  $date=date("d, F Y H:i:s");
  $query="INSERT INTO comments(fullname,email,blogentryid,comment,datetime)VALUES('$name','$email','$blogentryid','$comment','$date')";
if($sectester==$secnumber||$comment==""){
$run=mysql_query($query)or die(mysql_error()." Line 244");
}
header('location:../blog/?p='.$blogentryid.'&c=true');
}elseif ($entryvariant=="napstandblogsubscription") {
  # code...
  $email=mysql_real_escape_string($_POST['email']);
  $catid=1; 
  $testquery="SELECT * FROM subscriptionlist WHERE email='$email' AND blogtypeid=$catid";
  $testrun=mysql_query($testquery)or die(mysql_error()." Line 226");
  $testnumrows=mysql_num_rows($testrun);
  if($testnumrows<1){ 
    $query="INSERT INTO subscriptionlist(blogtypeid,blogcatid,email)VALUES('$catid','0','$email')";
    $run=mysql_query($query)or die(mysql_error()." Line 42");
    echo "OK";
  }else{
    echo "Sorry, it seems you have subscribed already to this";
  }
// header('location:../blog.php');
}elseif ($entryvariant=="categorysubscription") {
  # code...
  $email=mysql_real_escape_string($_POST['email']);
  $pageid=mysql_real_escape_string($_POST['pageid']);
  $catid=$_POST['categoryid'];
$testquery="SELECT * FROM blogcategories WHERE id=$catid";
$testrun=mysql_query($testquery)or die(mysql_error()." Line 91");
$testnumrows=mysql_num_rows($testrun);
if($testnumrows>0){
$testquery="SELECT * FROM subscriptionlist WHERE email='$email' AND blogtypeid=$catid";
  $testrun=mysql_query($testquery)or die(mysql_error()." Line 226");
  $testnumrows=mysql_num_rows($testrun);
  if($testnumrows<1){ 
$query="INSERT INTO subscriptionlist(blogtypeid,blogcatid,email)VALUES('0','$catid','$email')";
$run=mysql_query($query)or die(mysql_error()." Line 58");
}
// $testnumrows=mysql_num_rows($testrun);
}else{
  header('location:../index.php');
}
}else if($entryvariant=="surveyrating"){
// echo"OK";
  $nextid=getNextIdExplicit('surveyrating');
  // check to see if the user is currently signed in
  if(isset($_SESSION['useri'])&&$_SESSION['useri']!==""){

    // first get the surveys outlink and post data
    $sid=$_POST['entryid'];
    $surveydata=getSingleSurvey($sid);
    $userid=$_SESSION['useri'];
    $surveyrating=$_POST['surveyrating'];
    $echo="";
    // check to see if this survey has been rated by this person
    $cquery="SELECT * FROM surveyrating WHERE userid='$userid' AND surveyid='$sid' ORDER BY id DESC";
    $crun=mysql_query($cquery)or die(mysql_error()." Line".__LINE__);
    $cnumrows=mysql_num_rows($crun);
    if($cnumrows<1){
      // get other details and insert
      $query="INSERT INTO surveyrating(userid,surveyid,rating,entrydate)VALUES('$userid','$sid','$surveyrating',CURRENT_DATE())";
      $run=mysql_query($query)or die(mysql_error()." Line ".__LINE__);
      isset($_POST['type'])&&strtolower($_POST['type'])=="ajax"?$echo="Thank you for rating this survey/ad-campaign":header('location:../'.$surveydata['usersurveylink'].'&r=0');
    }else{
      // update the survey rating
      $crow=mysql_fetch_assoc($crun);
      genericSingleUpdate("surveyrating","rating","$surveyrating","id",$crow['id']);
      isset($_POST['type'])&&strtolower($_POST['type'])=="ajax"?$echo="Your rating for this survey has been updated":header('location:../'.$surveydata['usersurveylink'].'&r=1');
    }
    echo $echo;
  }else{
    //make em signin
    header('location:../signupin.php?error=true&type=rating');
  }
}else if($entryvariant=="contacthelpdesk"){
  $email=mysql_real_escape_string($_POST['email']);
  $name=mysql_real_escape_string($_POST['name']);
  $message=mysql_real_escape_string($_POST['message']);
  $title="A help request";
  $content='
    <p style="text-align:left;">Hello admin,<br>
    An individual named '.$name.' sent/asked the following, <br>
    '.$message.'
    </p>
    <a href="mailto:'.$email.'">Click to reply</a>
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
  $emailout=generateMailMarkUp("Napstand.com","$email","$title","$content","$footer","");
  // // echo $emailout['rowmarkup'];
  $toemail="admin@napstand.com";
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $headers .= 'From: <no-reply@napstandsupport.com>' . "\r\n";
  $headers .= 'Cc: info@napstand.com' . "\r\n";
  $subject="A new Help request";
  if($host_email_send===true){
    if(mail($toemail,$subject,$emailout['rowmarkup'],$headers)){

    }else{
      die('could not send Your email, something went wrong and we are handling it, meantime you could click the back button in your browser to get you out of here, we are really sorry');
    }
  }
  // echo "OK";
}else if($entryvariant=="contactform"){
  $email=mysql_real_escape_string($_POST['email']);
  $name=mysql_real_escape_string($_POST['name']);
  $message=mysql_real_escape_string($_POST['message']);
  $title="A help request";
  $content='
    <p style="text-align:left;">Hello admin,<br>
    An individual named '.$name.' sent/asked the following, <br>
    '.$message.'
    </p>
    <a href="mailto:'.$email.'">Click to reply</a>
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
  $emailout=generateMailMarkUp("Napstand.com","$email","$title","$content","$footer","");
  // // echo $emailout['rowmarkup'];
  $toemail="admin@napstand.com";
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $headers .= 'From: <no-reply@napstandsupport.com>' . "\r\n";
  $headers .= 'Cc: info@napstand.com' . "\r\n";
  $subject=isset($_POST['subject'])?mysql_real_escape_string($_POST['subject']):"A Contact Form Message";
  if($host_email_send===true){
    if(mail($toemail,$subject,$emailout['rowmarkup'],$headers)){

    }else{
      die('could not send Your email, something went wrong and we are handling it, meantime you could click the back button in your browser to get you out of here, we are really sorry');
    }
  }
  // echo "OK";
}elseif ($entryvariant=="createsurveycategory") {
  # code...
  $catname=mysql_real_escape_string($_POST['name']);
  $query="INSERT INTO surveycategories (catname)VALUES('$catname')";
  // // echo $query;
  $run=mysql_query($query)or die(mysql_error()."Line 56");
  header('location:../admin/adminindex.php?compid=1&type=0&v=admin');
}elseif ($entryvariant=="createfaq") {
  # code...
  $title=mysql_real_escape_string($_POST['title']);
  $content=mysql_real_escape_string($_POST['content']);
  $query="INSERT INTO faq (title,content)VALUES('$title','$content')";
  // // echo $query;
  $run=mysql_query($query)or die(mysql_error()."Line 56");
  header('location:../admin/adminindex.php?compid=7&type=0&v=admin');
}elseif ($entryvariant=="createrewardcategory") {
  # code...
  $catname=mysql_real_escape_string($_POST['name']);
  $query="INSERT INTO rewardtype (typename)VALUES('$catname')";
  // // echo $query;
  $run=mysql_query($query)or die(mysql_error()."Line 56");
  header('location:../admin/adminindex.php?compid=1&type=0&v=admin');
}else if ($entryvariant=="userregistration") {
  # code...
  $uid=getNextIdExplicit("users");
  $uhash=md5($uid);
  $firstname=mysql_real_escape_string($_POST['firstname']);
  $middlename=mysql_real_escape_string($_POST['middlename']);
  $lastname=mysql_real_escape_string($_POST['lastname']);
  $fullname=$firstname." ".$middlename." ".$lastname;
  $state=mysql_real_escape_string($_POST['state']);
  $lga=mysql_real_escape_string($_POST['LocalGovt']);
  $doby=mysql_real_escape_string($_POST['dobyear']);
  $dobm=mysql_real_escape_string($_POST['dobmonth']);
  $dobd=mysql_real_escape_string($_POST['dobday']);
  $dob=$doby."-".$dobm."-".$dobd;
  $maritalstatus=mysql_real_escape_string($_POST['maritalstatus']);
  $gender=mysql_real_escape_string($_POST['gender']);
  $phoneone=mysql_real_escape_string($_POST['phoneone']);
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
  $phoneout=$phoneone."[|><|]".$phonetwo."[|><|]".$phonethree;

  $email=mysql_real_escape_string($_POST['useremail']);
  $emaildata=checkEmail($email,"users","email");
  if($emaildata['testresult']=="unmatched"){    
    if(isset($_POST['upassword'])){
      $password=$_POST['upassword'];
    }else{
      $password=substr(md5(date("Y d m").time()),0,9);
    }
    $pinpage=isset($_POST['surveyid'])?mysql_real_escape_string($_POST['surveyid']):0;
    $deadline=date('Y-m-d', strtotime('7 days'));
    $_SESSION['firstlog']="true";
    $_SESSION['userh']=$uhash;
    $_SESSION['useri']=$uid;
    $query="INSERT INTO users(usertype,fullname,uhash,gender,maritalstatus,dob,state,lga,email,pword,phonenumber,regdate,activationdeadline)
    VALUES('user','$fullname','$uhash','$gender','$maritalstatus','$dob','$state','$lga','$email','$password','$phoneout',CURRENT_DATE(),'$deadline')";
    // // echo $query;
    $run=mysql_query($query)or die(mysql_error()." Line 58");
    $confirmationlink=$host_addr."signupin.php?t=activate&uh=".$uhash.".".$uid."&utm_email=".$email."";
    $title="WELCOME TO ADSBOUNTY!!!";
    $content='
        <p style="text-align:left;">Hello there '.$fullname.',<br>
        We at napstand are really happy you took your time to come on board our website, <br>
        We hope to deliver a lovely user experience as you move on to partake in surveys which<br>
        could help boost productivity in your favourite brand or help you obtain better services.<br>
        Seeing as you have just registered, all thats left is for you to confirm you account by <a href="'.$confirmationlink.'">Clicking here</a><br>
        and thats it. note that your account will remain active for the next 7 days without being activated</p>
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
    $toemail=$email;
    $emailout=generateMailMarkUp("Napstand.com","$email","$title","$content","$footer","");
    // // echo $emailout['rowmarkup'];
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <no-reply@napstand.com>' . "\r\n";
    $subject="Welcome to Napstand";
    if($host_email_send===true){
      if(mail($toemail,$subject,$emailout['rowmarkup'],$headers)){

      }else{
        die('could not send Your email, something went wrong and we are handling it, meantime you could click the back button in your browser to get you out of here, we are really sorry');
      }

    }
    if($pinpage>0){
      header('location:../interfprev.php?h='.$userh.'.'.$userid.'&pref='.$pinpage.'');
    }else if(isset($_POST['prereg'])){
      echo "ok";
    }else{
      header('location:../userdashboard.php');
    }
  }else{
    die("Your email address already exists, it seems you are using a slightly primitive browser for this, please you should navigate using the back button in your browser and address the email issue on the form there, it should still hold the values you inputed before, though you");
  }

}else if ($entryvariant=="userpartregistration") {
  # code...
  $uid=getNextIdExplicit("users");
  $uhash=md5($uid);
  $firstname=mysql_real_escape_string($_POST['firstname']);
  $middlename=isset($_POST['middlename'])?mysql_real_escape_string($_POST['middlename']):"";
  $lastname=mysql_real_escape_string($_POST['lastname']);
  $fullname=$firstname." ".$middlename." ".$lastname;
  $doby=isset($_POST['dobyear'])?mysql_real_escape_string($_POST['dobyear']):"0000";
  $dobm=isset($_POST['dobmonth'])?mysql_real_escape_string($_POST['dobmonth']):"00";
  $dobd=isset($_POST['dobday'])?mysql_real_escape_string($_POST['dobday']):"00";
  $dob=$doby."-".$dobm."-".$dobd;
  $gender=isset($_POST['dobyear'])?mysql_real_escape_string($_POST['gender']):"";
  $email=mysql_real_escape_string($_POST['useremail']);
  $emaildata=checkEmail($email,"users","email");
  if($emaildata['testresult']=="unmatched"){    
    if(isset($_POST['upassword'])){
      $password=$_POST['upassword'];
    }else{
      $password=substr(md5(date("Y d m").time()),0,9);
    }
    $pinpage=isset($_POST['surveyid'])?mysql_real_escape_string($_POST['surveyid']):0;
    $deadline=date('Y-m-d', strtotime('7 days'));
    $_SESSION['firstlog']="true";
    $_SESSION['userh']=$uhash;
    $_SESSION['useri']=$uid;
    $query="INSERT INTO users(usertype,fullname,uhash,gender,dob,email,pword,regdate,activationdeadline)
    VALUES('user','$fullname','$uhash','$gender','$dob','$email','$password',CURRENT_DATE(),'$deadline')";
    // // echo $query;
    $run=mysql_query($query)or die(mysql_error()." Line 58");
    $confirmationlink=$host_addr."signupin.php?t=activate&uh=".$uhash.".".$uid."&utm_email=".$email."";
    $title="WELCOME TO ADSBOUNTY!!!";
    $content='
        <p style="text-align:left;">Hello there '.$fullname.',<br>
        We at napstand are really happy you took your time to come on board our website, <br>
        We hope to deliver a lovely user experience as you move on to partake in surveys which<br>
        could help boost productivity in your favourite brand or help you obtain better services.<br>
        You used the "<b>Part Registration</b>" form to signup, please note that to take full advantage of our platform, you might need to provide more information as time progresses. This
        is done by editting your profile.
        Seeing as you have just registered, all thats left is for you to confirm you account by <a href="'.$confirmationlink.'">Clicking here</a><br>
        and thats it. note that your account will remain active for the next 7 days without being activated</p>
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
    $toemail=$email;
    $emailout=generateMailMarkUp("Napstand.com","$email","$title","$content","$footer","");
    // // echo $emailout['rowmarkup'];
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <no-reply@napstand.com>' . "\r\n";
    $subject="Welcome to Napstand";
    if($host_email_send===true){
      if(mail($toemail,$subject,$emailout['rowmarkup'],$headers)){

      }else{
        die('could not send Your email, something went wrong and we are handling it, meantime you could click the back button in your browser to get you out of here, we are really sorry');
      }
    }
    if($pinpage>0){
      header('location:../interfprev.php?h='.$userh.'.'.$userid.'&pref='.$pinpage.'');
    }else if(isset($_POST['prereg'])){
      echo "ok";
    }else{
      header('location:../userdashboard.php');
    }
  }else{
    die("Your email address already exists, it seems you are using a slightly primitive browser for this, please you should navigate using the back button in your browser and address the email issue on the form there, it should still hold the values you inputsed before.");
  }

}else if ($entryvariant=="createuseradmin") {
  # code...
  $uid=getNextIdExplicit("users");
  $uhash=md5($uid);
  $catid=mysql_real_escape_string($_POST['catid']);
  $firstname=mysql_real_escape_string($_POST['firstname']);
  $middlename=mysql_real_escape_string($_POST['middlename']);
  $lastname=mysql_real_escape_string($_POST['lastname']);
  $nickname=mysql_real_escape_string($_POST['nickname']);
  $fullname=$firstname." ".$middlename." ".$lastname;
  $bio=mysql_real_escape_string($_POST['bio']);
  $state=mysql_real_escape_string($_POST['state']);
  $lga=mysql_real_escape_string($_POST['LocalGovt']);
  $address=mysql_real_escape_string($_POST['address']);
  $gender=mysql_real_escape_string($_POST['gender']);
  /*$doby=mysql_real_escape_string($_POST['dobyear']);
  $dobm=mysql_real_escape_string($_POST['dobmonth']);
  $dobd=mysql_real_escape_string($_POST['dobday']);
  $dob=$doby."-".$dobm."-".$dobd;*/
  // $maritalstatus=mysql_real_escape_string($_POST['maritalstatus']);
  $phoneone=mysql_real_escape_string($_POST['phoneone']);
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
  $phoneout=$phoneone."[|><|]".$phonetwo."[|><|]".$phonethree;

  $email=mysql_real_escape_string($_POST['email']);
  $emaildata['email']="$email";
  $emaildata['fieldcount']=1;
  $emaildata['logic'][0]="AND";
  $emaildata['column'][0]="usertype";
  $emaildata['value'][0]="user";
  $emaildata=checkEmail($emaildata,"users","email");
  // create user social data 
  //  link and handles data are in the form tw|fb|gp|ln|pin|tblr|ig
  $totalhandles="";
  $totallinks="";
  // facebook
  $fbhandle=mysql_real_escape_string($_POST['socialhandlefb']);
  $fblink=mysql_real_escape_string($_POST['socialhandlefblink']);
  // twitter
  $twhandle=mysql_real_escape_string($_POST['socialhandletw']);
  $twlink=mysql_real_escape_string($_POST['socialhandletwlink']);
  // gplus
  $gphandle=mysql_real_escape_string($_POST['socialhandlegp']);
  $gplink=mysql_real_escape_string($_POST['socialhandlegplink']);
  // Linkedin
  $inhandle=mysql_real_escape_string($_POST['socialhandlein']);
  $inlink=mysql_real_escape_string($_POST['socialhandleinlink']);
  // Pinterest
  $pinhandle=mysql_real_escape_string($_POST['socialhandlepin']);
  $pinlink=mysql_real_escape_string($_POST['socialhandlepinlink']);
  // tumblr
  $tblrhandle=mysql_real_escape_string($_POST['socialhandletblr']);
  $tblrlink=mysql_real_escape_string($_POST['socialhandletblrlink']);
  // instagram
  $ighandle=mysql_real_escape_string($_POST['socialhandleig']);
  $iglink=mysql_real_escape_string($_POST['socialhandleiglink']);

  // concatenate the social content for output
  //  link and handles data tw|fb|gp|ln|pin|tblr|ig
  $totalhandles=$twhandle."[|><|]".$fbhandle."[|><|]".$gphandle."[|><|]".$inhandle."[|><|]".
  $pinhandle."[|><|]".$tblrhandle."[|><|]".$ighandle;
  $totallinks=$twlink."[|><|]".$fblink."[|><|]".$gplink."[|><|]".$inlink."[|><|]".
  $pinlink."[|><|]".$tblrlink."[|><|]".$iglink;

  // verify email once more and proceed only when the email is umatched
  if($emaildata['testresult']=="unmatched"){    
    if(isset($_POST['password'])){
      $password=$_POST['password'];
    }else{
      $password=substr(md5(date("Y d m").time()),0,9);
    }
    $deadline=date('Y-m-d', strtotime('7 days'));
    $_SESSION['firstlog']="false";
    $_SESSION['userh']=$uhash;
    $_SESSION['useri']=$uid;
    
    // userfoldersection
    mkdir('../files/users/'.$uhash.'/',0777)or die("Error creating folder");
    mkdir('../files/users/'.$uhash.'/originals/',0777)or die("Error creating folder");
    mkdir('../files/users/'.$uhash.'/medsizes/',0777)or die("Error creating folder");
    mkdir('../files/users/'.$uhash.'/thumbnails/',0777)or die("Error creating folder");

    // upload user profile image
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
      
      //maintype variants are original, medsize, thumb for respective size image.
      $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,medsize,thumbnail,filesize,width,height)
                    VALUES
                  ('$uid','user','profpic','image','$imagepath','$imagepath2','$imagepath3','$filesize','$width','$height')";
      $mediarun=mysql_query($mediaquery)or die(mysql_error()." Line ".__LINE__);
    }
    $password=$_POST['password'];

    // create the users content folder
    $query="INSERT INTO users(usertype,catid,fullname,firstname,middlename,lastname,nickname,uhash,
      gender,details,socialhandles,socialurls,state,lga,businessaddress,email,pword,phonenumber,regdate,activationdeadline)
    VALUES('user','$catid','$fullname','$firstname','$middlename','$lastname','$nickname','$uhash',
      '$gender','$bio','$totalhandles','$totallinks','$state','$lga','$address','$email','$password','$phoneout',CURRENT_DATE(),'$deadline')";
    // echo $query." ".__LINE__;

    $run=mysql_query($query)or die(mysql_error()." Line ".__LINE__);
    $confirmationlink=$host_addr."userdashboard.php?t=activate&uh=".$uhash.".".$uid."&utm_email=".$email."";
    $title="WELCOME TO NAPSTAND!!!";
    $content='
        <p style="text-align:left;">Hello there '.$fullname.',<br>
        We at Napstand are really happy you took your time to come on board our website, <br>
        We hope to deliver a lovely user experience as you move on to utilise our platform<br>
        to post your content, reach a wider range of individuals, and raise awareness as well.<br>
        Seeing as you have just registered, all thats left is for you to confirm your account by <a href="'.$confirmationlink.'">Clicking here</a><br>
        and thats it. note that your account will remain active for the next 7 days without being activated</p>
        <p style="text-align:right;">Thank You.</p>
    ';
    $footer='
      <ul>
          <li><strong>Phone 1: </strong>0807-207-6302</li>
          <li><strong>Email: </strong><a href="mailto:info@napstand.com">info@napstand.com</a></li>
      </ul>
    ';
    $toemail=$email;
    $emailout=generateMailMarkUp("napstand.com","$email","$title","$content","$footer","");
    // // echo $emailout['rowmarkup'];
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <no-reply@napstand.com>' . "\r\n";
    $subject="Welcome to Napstand";
    if($host_email_send===true){
      if(mail($toemail,$subject,$emailout['rowmarkup'],$headers)){

      }else{
        die('could not send Your email, something went wrong and we are handling it, meantime you could click the back button in your browser to get you out of here, we are really sorry');
      }

    }
  }else{
    die("This email address already exists");
  }
  header('location:../admin/adminindex.php?compid=4&type=0&v=admin&ctype='.$entryvariant.'');

}else if ($entryvariant=="createappuser") {
  # code...
  // allow full access in here
  // header("Access-Control-Allow-Ori  gin: *");
  $uid=getNextIdExplicit("users");
  $uhash=md5($uid);
  $catid=0;
  $entrypoint=isset($_POST['entrypoint'])?$_POST['entrypoint']:"";
  // $catid=mysql_real_escape_string($_POST['catid']);
  $firstname=mysql_real_escape_string($_POST['firstname']);
  $middlename=mysql_real_escape_string($_POST['middlename']);
  $lastname=mysql_real_escape_string($_POST['lastname']);
  // $nickname=mysql_real_escape_string($_POST['nickname']);
  $fullname=$firstname." ".$middlename." ".$lastname;
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
  
  // create the users content folder
    if(!is_dir('../files/appusers/'.$uhash.'/')){
      mkdir('../files/appusers/'.$uhash.'/',0777)or die("Error creating folder");
      mkdir('../files/appusers/'.$uhash.'/originals/',0777)or die("Error creating folder");
      mkdir('../files/appusers/'.$uhash.'/medsizes/',0777)or die("Error creating folder");
      mkdir('../files/appusers/'.$uhash.'/thumbnails/',0777)or die("Error creating folder");
    }

  // verify email once more and proceed only when the email is umatched
  if($emaildata['testresult']=="unmatched"||($emaildata['testresult']=="matched"&&$emaildata['usertype']!=="appuser")){    
    if(isset($_POST['pword'])){
      $password=$_POST['pword'];
    }else{
      $password=substr(md5(date("Y d m").time()),0,9);
    }
    $deadline=date('Y-m-d', strtotime('7 days'));
    $_SESSION['firstlog']="false";
    $_SESSION['userhnapstand']=$uhash;
    $_SESSION['userinapstand']=$uid;

    // upload user profile image
    $bizlogo=isset($_FILES['profpic']['tmp_name'])?$_FILES['profpic']['tmp_name']:"";
    if($bizlogo!==""){
      $image="profpic";
      $imgpath[]='../files/appusers/'.$uhash.'/originals/';
      $imgpath[]='../files/appusers/'.$uhash.'/medsizes/';
      $imgpath[]='../files/appusers/'.$uhash.'/thumbnails/';
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
      
      //maintype variants are original, medsize, thumb for respective size image.
      $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,medsize,thumbnail,filesize,width,height)
                    VALUES
                  ('$uid','appuser','profpic','image','$imagepath','$imagepath2','$imagepath3','$filesize','$width','$height')";
      $mediarun=mysql_query($mediaquery)or die(mysql_error()." Line ".__LINE__);
    }

    
    // create the users content folder
    $query="INSERT INTO users(usertype,fullname,firstname,middlename,lastname,uhash,
      email,pword,regdate)
    VALUES('appuser','$fullname','$firstname','$middlename','$lastname','$uhash',
      '$email','$password',CURRENT_DATE())";
    // echo $query." ".__LINE__;
    $run=mysql_query($query)or die(mysql_error()." Line ".__LINE__);
    $confirmationlink=$host_addr."mobpoint.php?displaytype=accountactivation&uh=".$uhash.".".$uid."&utm_email=".$email."";
    $title="WELCOME TO NAPSTAND!!!";
    $content='
        <p style="text-align:left;">Hello there '.$fullname.',<br>
        We at Napstand are really happy you took your time to come on board our platform, <br>
        We hope to deliver a lovely user experience as you move on to utilise our platform<br>
        to post your content, reach a wider range of individuals, and raise awareness as well.<br>
        Seeing as you have just registered, all thats left is for you to confirm your account by <a href="'.$confirmationlink.'">Clicking here</a><br>
        and thats it. note that your account will remain active for the next 7 days without being activated</p>
        <p style="text-align:right;">Thank You.</p>
    ';
    $footer='
      <ul>
          <li><strong>Phone 1: </strong>0807-207-6302</li>
          <li><strong>Email: </strong><a href="mailto:info@napstand.com">info@napstand.com</a></li>
      </ul>
    ';
    $toemail=$email;
    $emailout=generateMailMarkUp("napstand.com","$email","$title","$content","$footer","");
    // // echo $emailout['rowmarkup'];
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <no-reply@napstand.com>' . "\r\n";
    $subject="Welcome to Napstand";
    if($host_email_send===true){
      if(mail($toemail,$subject,$emailout['rowmarkup'],$headers)){

      }else{
        die('could not send Your email, something went wrong and we are handling it, meantime you could click the back button in your browser to get you out of here, we are really sorry');
      }

    }
    if($entrypoint=="webapp"){
      header('location:../admin/adminindex.php?compid=4&type=0&v=admin&ctype='.$entryvariant.'');
    }else {
      // echo json response here
      $msg="Registered Successfully";
      echo json_encode(array("success"=>"true","msg"=>"$msg","userid"=>"$uid"));
    }
  } else{
    if($entrypoint=="webapp"){
        echo "The email address you attempted registering is invalid";
    }else {

      // echo json response here
      $msg="The email address you attempted registering is invalid";
      echo json_encode(array("success"=>"false","msg"=>"$msg","userid"=>"0"));

    }
    
  }

}else if ($entryvariant=="createclientadmin") {
  # code...
  $cid=getNextId("users");
  $catid=mysql_real_escape_string($_POST['catid']);
  $businessname=mysql_real_escape_string($_POST['businessname']);
  $state=mysql_real_escape_string($_POST['state']);
  $lga=mysql_real_escape_string($_POST['LocalGovt']);
  $businessaddress=mysql_real_escape_string($_POST['businessaddress']);
  $businessdescription=mysql_real_escape_string($_POST['businessdescription']);
  $phoneone=mysql_real_escape_string($_POST['phoneone']);
  $password=isset($_POST['password'])?mysql_real_escape_string($_POST['password']):"";
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
  $phoneout=$phoneone."[|><|]".$phonetwo."[|><|]".$phonethree;

  $email=mysql_real_escape_string($_POST['email']);
  if(isset($_POST['password'])){
    $password=$_POST['password'];
  }else{
    $password=substr(md5(date("Y d m").time()),0,9);
  }

    
  $query="INSERT INTO users(usertype,catid,state,lga,email,pword,phonenumber,businessname,businessdescription,businessaddress,regdate)
  VALUES('client','$catid','$state','$lga','$email','$password','$phoneout','$businessname','$businessdescription','$businessaddress',CURRENT_DATE())";
  $run=mysql_query($query)or die(mysql_error()." Line ".__LINE__);

  $pcontentid=getNextId("parentcontent");
  $query2="INSERT INTO parentcontent 
  (contenttitle,userid,contentdescription,contenttypeid,entrydate)
  VALUES
  ('$businessname','$cid','$businessdescription','$catid',CURRENT_DATE() CURRENT_TIME())";
  $run2=mysql_query($query)or die(mysql_error()." Line ".__LINE__);

  // // echo $query;
  $bizlogo=$_FILES['bizlogo']['tmp_name'];
  $bannerlogo=$_FILES['bannerlogo']['tmp_name'];
  if($bizlogo!==""){
    $image="bizlogo";
    $imgpath[]='../files/originals/';
    $imgpath[]='../files/thumbnails/';
    $imgsize[]="default";
    $imgsize[]=",240";
    $acceptedsize="";
    $imgouts=genericImageUpload($image,"varying",$imgpath,$imgsize,$acceptedsize);
    $len=strlen($imgouts[0]);
    $imagepath=substr($imgouts[0], 1,$len);
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
    $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,thumbnail,filesize,width,height)VALUES('$cid','client','bizlogo','image','$imagepath','$imagepath2','$filesize','$width','$height')";
    $mediarun=mysql_query($mediaquery)or die(mysql_error());
    // create parentcontent entry
    $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,thumbnail,filesize,width,height)VALUES('$pcontentid','parentcontent','coverphoto','image','$imagepath','$imagepath2','$filesize','$width','$height')";
    $mediarun=mysql_query($mediaquery)or die(mysql_error());
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
    //maintype variants are original, medsize, thumb for respective size image.
    $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,filesize,width,height)VALUES('$cid','client','bannerlogo','image','$imagepath','$filesize','$width','$height')";
    $mediarun=mysql_query($mediaquery)or die(mysql_error());
  }
  header('location:../admin/adminindex.php?compid=4&type=0&v=admin&ctype='.$entryvariant.'');

}else if ($entryvariant=="contententry") {
  # code...
  $cid=getNextId("generalinfo");
  $maintype=mysql_real_escape_string($_POST['maintype']);
  $subtype=mysql_real_escape_string($_POST['subtype']);
  $title=mysql_real_escape_string($_POST['contenttitle']);
  $intro=isset($_POST['contentintro'])?mysql_real_escape_string($_POST['contentintro']):"";
  $content=mysql_real_escape_string(str_replace("../", "$host_addr",$_POST['contentpost']));
  if($intro!==""){
    $headerdescription = $intro;    
  }else if($intro==""&&$content==""){
    $headerdescription="";
  }else{
    // $headerdescription = $content!==""?convert_html_to_text($content):"";
    $headerdescription=$content!==""?html2txt($content):"";
    $monitorlength=strlen($headerdescription);
    $headerdescription=$montorlength<600?$headerdescription."...":substr($headerdescription, 0,600)."...";
  }
  $entrydate=date("Y-m-d H:i:s");
      $query="INSERT INTO generalinfo(maintype,subtype,title,intro,content,entrydate)VALUES
    ('$maintype','$subtype','$title','$headerdescription','$content','$entrydate')";
    // echo $query;
    $run=mysql_query($query)or die(mysql_error()." ".__LINE__);
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
      $mediaquery="INSERT INTO media(ownerid,ownertype,maintype,mediatype,location,details,filesize,width,height)VALUES('$cid','$maintype','coverphoto','image','$imagepath','$imagepath2','$filesize','$width','$height')";
      $mediarun=mysql_query($mediaquery)or die(mysql_error());
    }
    if($rurladmin==""){
      header('location:../admin/adminindex.php');
  }else{
    header('location:'.$rurladmin.'');
  }
}
?>
