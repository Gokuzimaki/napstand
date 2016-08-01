<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
require_once 'paginator.class.php';
require_once "gifresizer.class.php";    //Including our class $host_addr="http://localhost/muyiwasblog/";
require_once 'html2text.class.php';
require_once('php_image_magician.php');
require_once "SocialAutoPoster/SocialAutoPoster.php";
require_once('tmhOAuth-master/tmhOAuth.php');
require 'PHPMailer-master/PHPMailerAutoload.php';
date_default_timezone_set("Africa/Lagos");
$host_target_addr="http://".$_SERVER['SERVER_NAME']."/";
$host_email_addr="admin@napstand.com";
$host_info_email_addr="info@napstand.com";
$host_support_email_addr="support@napstand.com";
$host_phonenumbers="+234 807 207 6302";
// test variable for holding server url type values
$host_test="localhost";
//set to true on upload emails
$host_email_send=false;
$hostname_pvmart = "localhost";
$db = "napstand";
$username_pvmart = "root";
//change pword when uploading to server
$password_pvmart = "";
if($host_target_addr=="http:///"){
  $host_target_addr="http://".$_SERVER['HTTP_HOST']."/";
}
// echo $host_target_addr;
$host_price_limit=3000;
$host_app_pull_limit=15;

// host session prefix and suffix
$host_sessionvar_prefix='';
$host_sessionvar_suffix='napstand';

$host_admin_cron="";
if(strpos($host_target_addr, "localhost")||strpos($host_target_addr, "wamp")){
  // for local server
  $host_admin_cron="on";
  $host_addr="http://localhost/napstand/";
}else if(strpos($host_target_addr, "ngrok.io/napstand")){
  $host_test="ngrok1";
  $host_addr=$host_target_addr!=="http://"&&$host_target_addr!=="https://"?$host_target_addr."":"http://napstand.com/";
  header("Access-Control-Allow-Origin: *");

}else if(strpos($host_target_addr, "ngrok.io")){
  $host_test="ngrok2";
  $host_addr=$host_target_addr!=="http://"&&$host_target_addr!=="https://"?$host_target_addr."napstand/":"http://napstand.com/";
  header("Access-Control-Allow-Origin: *");

}else if(strpos($host_target_addr, "ngrok")){
  $host_test="ngrok3";
  $host_addr=$host_target_addr!=="http://"&&$host_target_addr!=="https://"?$host_target_addr."napstand/":"http://napstand.com/";
  header("Access-Control-Allow-Origin: *");

}else if(strpos($host_target_addr, "orgfree.com")){
  $host_test="orgfree"; 
  $host_addr=$host_target_addr!=="http://"&&$host_target_addr!=="https://"?$host_target_addr."napstand/":"http://napstand.com/";
  $host_email_send=true;
  $db="1170406";
  $username_pvmart = "1170406";
  $password_pvmart = "edotensei";
}else{
  // for remote server
  $host_addr=$host_target_addr!=="http://"&&$host_target_addr!=="https://"?$host_target_addr:"http://napstand.com/";
  $host_email_send=true;
  $username_pvmart = "theuploadusername";
  $password_pvmart = "theuploadpassword";
  // check for gzip config on godaddy
  if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); 
    
  
}
//vogue pay controller sections
  $host_naira_symbol='&#8358;';
  $host_vogue_merchantid="demo";
  $host_vogue_transaction_url="https://voguepay.com/pay/";
  $host_vogue_default_storeid="";
  $host_vogue_success_url=''.$host_addr.'success.php';
  $host_vogue_failure_url=''.$host_addr.'failure.php';
  $host_vogue_notification_url=''.$host_addr.'snippets/notification.php';
  $host_vogue_success_url_fieldname="success_url";
  $host_vogue_failure_url_fieldname="failure_url";
  $host_vogue_notification_url_fieldname="notification_url";
  $host_vogue_image_url=$host_addr."images/voguepay.png";
  $host_vogue_poweredby_text="This transaction is powered by VoguePay";
// end
/*Google Analytics*/
  $host_gacode="000000";
  $host_gaurl="$host_addr";
/*end*/
$host_default_poster=$host_addr.'images/napstandcover400x400.png';
$host_default_cover_image=$host_addr.'images/napstandcover400x400.png';
$wasl = @mysql_connect($hostname_pvmart, $username_pvmart, $password_pvmart) or die(mysql_error());
mysql_select_db($db) or die ("Unable to select database!");
// for mysqli upgrade, db connection
// $host_connection_link = mysqli_connect("$hostname_pvmart", "$username_pvmart", "$password_pvmart", "$db");
function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return false; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 function getFilename($filepath){
  $i = strrpos($filepath,"/");
         if (!$i) { return $filepath; }
  $filename=explode("/",$filepath);
  $tot=count($filename);
  return $filename[$tot-2];
 }

function getFileDetails($filepath,$typeoffile){
  $retvals=array();
file_exists($filepath)?$filesize=filesize($filepath):$filesize="0B";
  if($typeoffile=="image"){
if($filesize!=="0B"&&$filesize>0){
list($width,$height)=getimagesize($filepath);
$filesize=$filesize/1024;
$filesize=round($filesize, 0, PHP_ROUND_HALF_UP);
if(strlen($filesize)>3){
  $filesize=$filesize/1024;
  $filesize=round($filesize,2); 
  $filesize="".$filesize."MB";
  }else{
  $filesize="".$filesize."KB";
  }
}
$retvals['width']=$width;
$retvals['height']=$height;
$retvals['size']=$filesize;
}else{
if($filesize!=="0B"&&$filesize>0){
list($width,$height)=getimagesize($filepath);
$filesize=$filesize/1024;
$filesize=round($filesize, 0, PHP_ROUND_HALF_UP);
if(strlen($filesize)>3){
  $filesize=$filesize/1024;
  $filesize=round($filesize,2); 
  $filesize="".$filesize."MB";
  }else{
  $filesize="".$filesize."KB";
  }
}
$retvals['size']=$filesize;
}

  return $retvals;
 }
//for performing targeted single update functions
function genericSingleUpdate($tablename,$updateField,$updateValue,$orderfield,$ordervalue){
  $ordervalues="";
  if($tablename!==""&&$updateField!==""&&$orderfield!==""&&$ordervalue!==""){
  if(is_array($orderfield) && is_array($ordervalue)){
  $orderfieldvals=count($orderfield)-1;
  for($i=0;$i<=$orderfieldvals;$i++){
    if($i!==$orderfieldvals){
    $ordervalues.="".$orderfield[$i]."='".$ordervalue[$i]."' AND ";
    }else{
    $ordervalues.=" ".$orderfield[$i]."='".$ordervalue[$i]."'";
    }
  }
  $query="UPDATE $tablename SET $updateField='$updateValue' WHERE $ordervalues";
  }else{
  $query="UPDATE $tablename SET $updateField='$updateValue' WHERE $orderfield=$ordervalue";
  }
  //// // echo$query;
  if($updateValue!==""&&str_replace(" ", "", $updateValue)!==""){
  $run=mysql_query($query)or die(mysql_error()." Real number:".__LINE__." old number  96 $query");
  }
  }else{

  die('cant Update with empty value in critical column'); 
  }
}
// for performing blank entry updates
//for performing targeted single update functions
function genericSingleUpdateTwo($tablename,$updateField,$updateValue,$orderfield,$ordervalue){
  $ordervalues="";
  if($tablename!==""&&$updateField!==""&&$orderfield!==""&&$ordervalue!==""){
    if(is_array($orderfield) && is_array($ordervalue)){
      $orderfieldvals=count($orderfield)-1;
      for($i=0;$i<=$orderfieldvals;$i++){
        if($i!==$orderfieldvals){
        $ordervalues.="".$orderfield[$i]."='".$ordervalue[$i]."' AND ";
        }else{
        $ordervalues.=" ".$orderfield[$i]."='".$ordervalue[$i]."'";
        }
      }
      $query="UPDATE $tablename SET $updateField='$updateValue' WHERE $ordervalues";
    }else{
      $query="UPDATE $tablename SET $updateField='$updateValue' WHERE $orderfield=$ordervalue";
    }
    //// // echo$query;
    $run=mysql_query($query)or die(mysql_error()." Real number:".__LINE__." old number  96 $query");
  }else{

  die('cant Update with empty value in critical column'); 
  }
}


function genericMultipleInsert($tablename,$colname,$colval){
 $totalcolnamecount=count($colname)-1;
 $totalcolvalscount=count($colval)-1;
// // // echo$totalcolvalscount;
$columnnames="";
$columnvalues="";
for($i=0;$i<=$totalcolnamecount;$i++){
if ($i==0) {
//  // // echo$colname[$i];
$columnnames.="".$colname[$i]."";
//// // echo$columnnames.'<br>';
}else{
//    // // echo$colname[$i];
$columnnames.=",".$colname[$i]."";

}
}
//// // echo'<br>'.$totalcolvalscount.'<br><br>';
$increment=$totalcolnamecount+1;
for($i=0;$i<=$totalcolvalscount;$i+=$increment){
$nextsize=$i+$totalcolnamecount;
//// // echo$nextsize.'<br>';
//// // echo$i.'<br>';
$columnvalues="";
for($t=$i;$t<=$nextsize;$t++){

//// // echo$t.'<br>'.$i.'<br>';
if ($t==$i) {
$columnvalues.=''.$colval[$t].'';
//// // echo$columnvalues.'<br>';
}else{
$columnvalues.=','.$colval[$t].'';
}
}
$query="INSERT INTO $tablename ($columnnames)VALUES($columnvalues)";
// // // echo$query.'<br>';
$run=mysql_query($query)or die(mysql_error());
}
};
function image_check_memory_usage($img, $max_breedte, $max_hoogte){
    if(file_exists($img)){
  $K64 = 65536;    // number of bytes in 64K
  $memory_usage = memory_get_usage();
  $memory_limit = abs(intval(str_replace('M','',ini_get('memory_limit'))*1024*1024));
  $image_properties = getimagesize($img);
  $image_width = $image_properties[0];
  $image_height = $image_properties[1];
  $image_bits = $image_properties['bits'];
  $image_memory_usage = $K64 + ($image_width * $image_height * ($image_bits )  * 2);
  $thumb_memory_usage = $K64 + ($max_breedte * $max_hoogte * ($image_bits ) * 2);
  $memory_needed = intval($memory_usage + $image_memory_usage + $thumb_memory_usage);
 
        if($memory_needed > $memory_limit){
                ini_set('memory_limit',(intval($memory_needed/1024/1024)+5) . 'M');
                if(ini_get('memory_limit') == (intval($memory_needed/1024/1024)+5) . 'M'){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
      }else{
      return false;
    }
}
function fix_dirname($str){
    return str_replace('~',' ',dirname(str_replace(' ','~',$str)));
}

function fix_strtoupper($str){
    if( function_exists( 'mb_strtoupper' ) )
  return mb_strtoupper($str);
    else
  return strtoupper($str);
}


function fix_strtolower($str){
    if( function_exists( 'mb_strtoupper' ) )
  return mb_strtolower($str);
    else
  return strtolower($str);
}
function getSizeByFixedWidth($newWidth,$newHeight,$width,$height,$forceStretch)
    {
    // *** If forcing is off...
    if ($forceStretch===false) {

      // *** ...check if actual width is less than target width
      if ($width < $newWidth) {
        return array('optimalWidth' => $width, 'optimalHeight' => $height);
      }
    }

    $ratio = $height / $width;

        $newHeight = $newWidth * $ratio;

        //return $newHeight;
    return array('optimalWidth' => $newWidth, 'optimalHeight' => $newHeight);
    }
 function getSizeByFixedHeight($newWidth,$newHeight,$width,$height,$forceStretch)
    {
    // *** If forcing is off...
    if ($forceStretch===false) {

      // *** ...check if actual height is less than target height
      if ($height < $newHeight) {
        return array('optimalWidth' => $width, 'optimalHeight' => $height);
      }
    }

        $ratio = $width / $height;

        $newWidth = $newHeight * $ratio;

        //return $newWidth;
    return array('optimalWidth' => $newWidth, 'optimalHeight' => $newHeight);
    }
    function getSizeByAuto($newWidth,$newHeight,$width,$height,$forceStretch)
    # Purpose:    Depending on the height, choose to resize by 0, 1, or 2
    # Param in:   The new height and new width
    # Notes:
    #
    {
    // *** If forcing is off...
    if ($forceStretch===false) {

      // *** ...check if actual size is less than target size
      if ($width < $newWidth && $height < $newHeight) {
        return array('optimalWidth' => $width, 'optimalHeight' => $height);
      }
    }

        if ($height < $width)
        // *** Image to be resized is wider (landscape)
        {
            //$optimalWidth = $newWidth;
            //$optimalHeight= $getSizeByFixedWidth($newWidth);

            $dimensionsArray = $getSizeByFixedWidth($newWidth, $newHeight);
      $optimalWidth = $dimensionsArray['optimalWidth'];
      $optimalHeight = $dimensionsArray['optimalHeight'];
        }
        elseif ($height > $width)
        // *** Image to be resized is taller (portrait)
        {
            //$optimalWidth = $getSizeByFixedHeight($newHeight);
            //$optimalHeight= $newHeight;

            $dimensionsArray = $getSizeByFixedHeight($newWidth, $newHeight);
      $optimalWidth = $dimensionsArray['optimalWidth'];
      $optimalHeight = $dimensionsArray['optimalHeight'];
        }
    else
        // *** Image to be resizerd is a square
        {

      if ($newHeight < $newWidth) {
          //$optimalWidth = $newWidth;
        //$optimalHeight= $getSizeByFixedWidth($newWidth);
                $dimensionsArray = $getSizeByFixedWidth($newWidth, $newHeight);
        $optimalWidth = $dimensionsArray['optimalWidth'];
        $optimalHeight = $dimensionsArray['optimalHeight'];
      } else if ($newHeight > $newWidth) {
          //$optimalWidth = $getSizeByFixedHeight($newHeight);
            //$optimalHeight= $newHeight;
                $dimensionsArray = $getSizeByFixedHeight($newWidth, $newHeight);
        $optimalWidth = $dimensionsArray['optimalWidth'];
        $optimalHeight = $dimensionsArray['optimalHeight'];
      } else {
        // *** Sqaure being resized to a square
        $optimalWidth = $newWidth;
        $optimalHeight= $newHeight;
      }
        }

    return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
    }
function getDimensions($newWidth, $newHeight, $width,$height,$forceStretch,$option)
  #
  #       To clarify the $option input:
    #               0 = The exact height and width dimensions you set.
    #               1 = Whatever height is passed in will be the height that
    #                   is set. The width will be calculated and set automatically
    #                   to a the value that keeps the original aspect ratio.
    #               2 = The same but based on the width.
    #               3 = Depending whether the image is landscape or portrait, this
    #                   will automatically determine whether to resize via
    #                   dimension 1,2 or 0.
  {

        switch (strval($option))
        {
            case '0':
      case 'exact':
                $optimalWidth = $newWidth;
                $optimalHeight= $newHeight;
                break;
            case '1':
      case 'portrait':
               $dimensionsArray = getSizeByFixedHeight($newWidth, $newHeight,$width,$height,$forceStretch);
        $optimalWidth = round($dimensionsArray['optimalWidth'],0, PHP_ROUND_HALF_UP);
        $optimalHeight = round($dimensionsArray['optimalHeight'],0, PHP_ROUND_HALF_UP);
                break;
            case '2':
      case 'landscape':
                $dimensionsArray = getSizeByFixedWidth($newWidth,$newHeight,$width,$height,$forceStretch);
        $optimalWidth = round($dimensionsArray['optimalWidth'],0, PHP_ROUND_HALF_UP);
        $optimalHeight = round($dimensionsArray['optimalHeight'],0, PHP_ROUND_HALF_UP);
                break;
            case '3':
      case 'auto':
                $dimensionsArray = getSizeByAuto($newWidth, $newHeight,$width,$height,$forceStretch);
        $optimalWidth = round($dimensionsArray['optimalWidth'],0, PHP_ROUND_HALF_UP);
        $optimalHeight = round($dimensionsArray['optimalHeight'],0, PHP_ROUND_HALF_UP);
                break;
              }

    return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
  }
function imageResize($imagefile,$newwidth,$newheight,$imgextension,$watermarkval,$watermarkimg,$imgpath){
/*
My image Resizer
resizes images based on the above passed parameters
####First Parameter $imagefile
-the image itself 
####Second Parameter $newwidth
-the new width of the image
####Third Parameter $newheight
-the new height of the image
####Fourth Parameter $imgextension
-the type of the image
####Fifth Parameter $watermarkvalue
-the watermark value for the image, values are"true" if water mark is
to be added to the image or "false" if not.
####Sixth Parameter $watermarkimg
-watermark image file path
####Seventh Parameter $imgpath
-path to place the new file in, must have the name of the new file
present in it
*/
if(is_array($imagefile)){
  // $imagefilename=$imagefile[2];
  $originalimage=$imagefile[0];
  $imagefile2=$imagefile[1];
list($width,$height)=getimagesize($originalimage);
$forceStretch=true;
if ($newwidth==""&&$newheight!=="") {
$option=1;$newwidth=0;

}elseif($newwidth!==""&&$newheight==""){
$option=2;
$newheight=0; 
}elseif ($newwidth!==""&&$newwidth>0&&$newheight!==""&&$newheight>0) {
  # code...
  $option=0;
}else{
  $option=3;
}
}else{
list($width,$height)=getimagesize($imagefile);
}

$tmp="oops something went wrong";

if($imgextension=="jpeg"||$imgextension=="jpg"){
if($watermarkval===true){
if(is_array($imagefile)){

}else{

}
}else{
if(is_array($imagefile)){
  // $matchtwo=checkExistingFile($uploadimgpaths[$i],$imagename2);
if(image_check_memory_usage($originalimage,$newwidth,$newheight)){
  $magicianObj = new imageLib($originalimage);
  // // echo$newwidth.$newheight.$option."<br>here";
  $magicianObj -> resizeImage($newwidth, $newheight, "".$option."");
  $magicianObj -> saveImage($imagefile2,80);
  return true;
    }
}else{
  $src = imagecreatefromjpeg($imagefile);
  $tmp=imagecreatetruecolor($newwidth,$newheight);
  imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
  imagejpeg($tmp,$imgpath,100);
  imagedestroy($src);
  imagedestroy($tmp);
  $tmp="successful";  
}




}
}elseif ($imgextension=="gif") {
if($watermarkval===true){

}else{
if(is_array($imagefile)){
$gr = new gifresizer;    //New Instance Of GIFResizer 
$gr->temp_dir = "frames"; //Used for extracting GIF Animation Frames
$dimensionwork=getDimensions($newwidth,$newheight,$width,$height,$forceStretch,$option); 
$cwidth=$dimensionwork['optimalWidth'];
$cheight=$dimensionwork['optimalHeight'];
$gr->resize($originalimage,$imagefile2,$cheight,$cheight); //Resizing the animation into a new file. 
}else{
$src = imagecreatefromgif($imagefile);
  $tmp=imagecreatetruecolor($newwidth,$newheight);
  imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
  imagegif($tmp,$imgpath);
  imagedestroy($src);
  imagedestroy($tmp);
  $tmp="successful";  
}



}
  

}elseif ($imgextension=="png") {
if($watermarkval===true){

}else{
if(is_array($imagefile)){
if(image_check_memory_usage($originalimage,$newwidth,$newheight)){

  $magicianObj = new imageLib($originalimage);
  $magicianObj -> resizeImage($newwidth, $newheight, "".$option."");
  $magicianObj -> saveImage($imagefile2,80);
  return true;
    }
}else{
  $src = @imagecreatefrompng($imagefile);
  $tmp=imagecreatetruecolor($newwidth,$newheight);
  imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
  imagePNG($tmp,$imgpath);
  imagedestroy($src);
  imagedestroy($tmp);
  $tmp="successful";
}
}
}else{
  // no editable format
  // copy the file into the new dir
  copy($imagefile,$imgpath);
}
return $tmp;
}
function checkExistingFile($filepath,$filename){
  $retvals=array();
  $files=array();
  $dhandle= opendir($filepath);
  if($dhandle){

    while(false !== ($fname = readdir($dhandle))){

      if(($fname!='.') && ($fname!='..') && ($fname!= basename($_SERVER['PHP_SELF']))){
        //check if the file in mention is a directory , if no add it to the files array
        $files[]=(is_dir("./$fname")) ? "":$fname;
      }
    }

    $totalfiles=count($files);
    $retvals['totalfilecount']=$totalfiles;
    $arraycount=$totalfiles-1;
    $match="false";

    for($i=0;$i<=$arraycount;$i++){
      if($filename==$files[$i]){
        $match="true";
      }
    }
    $testfile=$filepath.$filename;
    $httppresent=strpos($filepath,"http://localhost/");
    $httppresent2=strpos($filepath,"http://");
    $httppresent3=strpos($filepath,"ssl://");
    if($httppresent===0){
      $patharr=explode("/",$filepath);
      $count=count($patharr);
      $end=$count-1;
      $start=3;
      $construct="";
      for($i=4;$i<=$end;$i++){
        $construct==""?$construct.="../".$patharr[$i]."/":($construct!==""&&$i!==$end?$construct.=$patharr[$i]."/":($construct!==""&&$i==$end?$construct.=$patharr[$i]:$construct=$construct));
      }
      // echo$construct;
      $testfile=$construct;
    }elseif ($httppresent2===0) {
      # code...
      $patharr=explode("/",$filepath);
      $count=count($patharr);
      $end=$count-1;
      $start=3;
      $construct="";
      for($i=3;$i<=$end;$i++){
        $construct==""?$construct.="../".$patharr[$i]."/":($construct!==""&&$i!==$end?$construct.=$patharr[$i]."/":($construct!==""&&$i==$end?$construct.=$patharr[$i]:$construct=$construct));
      }
      // // echo$construct;
      $testfile=$construct;
    }
    if(file_exists($testfile)){
      $match="true";  
      // // echo$match;
    }
    $retvals['matchval']=$match;
    $extensions=getExtension($filename);
    $extension=strtolower($extensions);
    $retvals['extension']=$extension;
    // get file size
    closedir($dhandle);
    return $retvals;
  }
}
function sortThroughDir($filepath,$filetype,$sorttype=""){
  global $host_addr;
  //this function runs through a given directory and matches all files in there
  // that fit the filetype parameter regex the returns them in a multidimensional array
  $pattern='/('.$filetype.')/i';
  $row=array();
  $files=array();
  $multicount=0;
  $totalfiles=0;
  $row['matchedfiles']="";
  $row['matchedextensions']="";
  if($filetype!==""){

    $dhandle= opendir($filepath);
    if($dhandle){

      while(false !== ($fname = readdir($dhandle))){

        if(($fname!='.') && ($fname!='..') && ($fname!= basename($_SERVER['PHP_SELF']))){
          //check if the file in mention is a directory , if no add it to the files array
          $files[]=(is_dir("./$fname")) ? "":$fname;
        }
      }
      if($sorttype=="plainsort"){
        // echo "were here";
        natcasesort($files);
        $count=0;
        foreach ($files as $value) {
          # code...
          $files[$count]=$value;
          // echo "<br>".$value."<br>";
          $count++;
        }
        // print_r($files);
      }
      $totalfiles=count($files);
      $row['totalfilecount']=$totalfiles;
      $arraycount=$totalfiles-1;
      $match="false";
      // echo "Arraycount: $arraycount<br>";
      for($i=0;$i<=$arraycount;$i++){
        // echo "<br>".$files[$i]."<br>";
        $curextension=getExtension($files[$i]);
        $matchout=preg_match($pattern, $files[$i],$matchdone);
        if(count($matchdone)>0){
          $match="true";
          $row['matchedextensions'][$multicount]=$curextension;
          $row['matchedfiles'][$multicount]=$files[$i];
          $row['matchedfilespath'][$multicount]=$filepath.$files[$i];
          $multicount++;
        }

      }
    }
  }
  
  $row['totalfilecount']=$totalfiles;
  $row['totalmatches']=$multicount;

  return $row;
}
function getRelativePathToSnippets($filepath){
  $retvals=array();
  $httppresent=strpos($filepath,"http://localhost/");
  $httppresent2=strpos($filepath,"http://");
  $httppresent3=strpos($filepath,"ssl://");
  if($httppresent===0){
    $patharr=explode("/",$filepath);
    $count=count($patharr);
    $end=$count-1;
    $start=3;
    $construct="";
    for($i=4;$i<=$end;$i++){
      $construct==""?$construct.="../".$patharr[$i]."/":($construct!==""&&$i!==$end?$construct.=$patharr[$i]."/":($construct!==""&&$i==$end?$construct.=$patharr[$i]:$construct=$construct));
    }
    // echo$construct;
    $retvals['testfile']=$construct;
  }elseif ($httppresent===0) {
    # code...
    $patharr=explode("/",$filepath);
    $count=count($patharr);
    $end=$count-1;
    $start=3;
    $construct="";
    for($i=3;$i<=$end;$i++){
      $construct==""?$construct.="../".$patharr[$i]."/":($construct!==""&&$i!==$end?$construct.=$patharr[$i]."/":($construct!==""&&$i==$end?$construct.=$patharr[$i]:$construct=$construct));
    }
    // // echo$construct;
    $retvals['testfile']=$construct;
  }else{
    $retvals['testfile']=$filepath;
  }
  return $retvals;
}

function getFileType($filename){
  $entrytype="";
  if(isset($_FILES[''.$filename.'']['name'])&&$_FILES[''.$filename.'']['name']!==""){
    $filerealname=$_FILES[''.$filename.'']['name'];
    //get img binaries
    $file=$_FILES[''.$filename.'']['tmp_name'];
    //get image type
    $filetype=$_FILES[''.$filename.'']['type'];
    //get image data size
    $filesize=$_FILES[''.$filename.'']['size'];
  }else if($filename!==""){
    $filerealname=$filename;
  }
  $extension=getExtension($filerealname);
  $extension=strtolower($extension);
  if ($extension=="jpg"||$extension=="jpeg"||$extension=="png"||$extension=="gif") {
    # code...
    $entrytype="image";
  } elseif($extension=="mp4"||$extension=="3gp"||$extension=="flv"||$extension=="swf"||$extension=="webm") {
    $entrytype="video";   
  }elseif ($extension=="doc"||$extension=="docx"||$extension=="xls"||$extension=="xlsx"||$extension=="ppt"||$extension=="pptx") {
    # code...
    $entrytype="office";
  }elseif ($extension=="pdf") {
    # code...
    $entrytype="pdf";

  }elseif($extension=="mp3"||$extension=="ogg"||$extension=="wav"||$extension=="amr"){
    $entrytype="audio";
  }else{
    $entrytype="others";
  }
  return $entrytype;
}

function simpleUpload($filename,$path){
  $outs=array();
  $fileoutnormal="";
  $filerealname=$_FILES[''.$filename.'']['name'];
  //get img binaries
  $file=$_FILES[''.$filename.'']['tmp_name'];
  //get image type
  $filetype=$_FILES[''.$filename.'']['type'];
  //get image data size
  $anothersize="";
  $filefirstsize=$_FILES[''.$filename.'']['size'];
  $filesize=$filefirstsize/1024;
  //// // echo$filefirstsize;
  $filesize=round($filesize, 0, PHP_ROUND_HALF_UP);
  if(strlen($filesize)>3){
  $filesize=$filesize/1024;
  $filesize=round($filesize,2); 
  $filesize="".$filesize."MB";
  }else{
    $filesize="".$filesize."KB";
  }
  $filename2 = stripslashes($filerealname);
  $extension=getExtension($filename2);
  $extension=strtolower($extension);
  $realimage=explode(".",$filename2);
  $dataname=$realimage[0];
  $match=checkExistingFile($path,$filerealname);
  if($match['matchval']=="true"){
    $nextentry=md5($match['totalfilecount']+1);
    $filerealname2=$dataname.$nextentry.".".$extension;
  }else{
    $filerealname2=$filerealname;
  }
  $filelocation=$path.$filerealname2;
  move_uploaded_file("$file","$filelocation");
  $fileoutnormal=str_replace("../", "./", $filelocation);
  $fileoutnormal==""?$fileoutnormal=$filelocation:$fileoutnormal=$fileoutnormal;
  $outs['filelocation']=$filelocation;
  $outs['fileoutnormal']=$fileoutnormal;
  $outs['filesize']=$filesize;
  $outs['realsize']=$filefirstsize;
  return $outs;
}

function genericImageUpload($imagefile,$uploadtype,$uploadimgpaths,$uploadimgsizes,$acceptedsize){
  /*
  My upload manager.
  -uploads image to server and returns the upload path of the image in an array for database storage
  ####First parameter $imagefile
  -the image file to be uploaded obviously this.
  ####Second parameter $uploadtype
  -type of upload, values are "single" and "varying",
  *single=simple image migration to a folder using move_uploaded file 
  function, end of story
  *varying=for image upload in multiple sizes...this is inclusive of the 
  original images size.
  ####Third parameter $uploadimgpaths
  -this is an array containing the path to which to uplaod the image to,
  it can also contain the paths for the varying image sizes if varying is
  specified.
  ####Fourth parameter $uploadimgsizes
  -this is an array of values in the form "width,height"..i.e "400,300"
  it can also hold the value of "default" meaning that for that entry the 
  original size of the image is to be used for that entry
  ####Fifth parameter $acceptedsize
  -The accepted default size of the image when in multiples or otherwise
  */
  //get image name
  if(is_array($imagefile)){
    $imagename=$imagefile[0];
    $image=$imagefile[1];
    $imagetype=$imagefile[2];
    $imagesize=$imagefile[3];
  }else{
    $imagename=$_FILES[''.$imagefile.'']['name'];
    //get img binaries
    $image=$_FILES[''.$imagefile.'']['tmp_name'];
    //get image type
    $imagetype=$_FILES[''.$imagefile.'']['type'];
    //get image data size
    $imagesize=$_FILES[''.$imagefile.'']['size'];

  }

  if($imagename!==""){

    list($curimgwidth,$curimgheight)=getimagesize($image);
      
    $filename = stripslashes($imagename);
    $extension=getExtension($filename);
    $extension=strtolower($extension);
    $realimage=explode(".",$filename);
    $imgname=$realimage[0];
    $imgpathcount=count($uploadimgpaths);
    $imgsizecount=count($uploadimgsizes);
    $defaultimglocation=$uploadimgpaths[0];
    $defaultsize=$uploadimgsizes[0];
    $path=array();
    if ($uploadtype=="varying") {
      if($imgpathcount>1&&$imgpathcount==$imgsizecount){
        $match=checkExistingFile($defaultimglocation,$imagename);
        if($match['matchval']=="true"){
          $nextentry=md5($match['totalfilecount']+1);
          $imagename2=$imgname.$nextentry.".".$extension;
        }else{
          $imagename2=$imagename;
        }
        //upload original image
        $imagelocation=$defaultimglocation.$imagename2;
        if(move_uploaded_file("$image","$imagelocation")){

        }else{
          // move the image to a new location
          rename("$image","$imagelocation");   
        }
        list($testwidth,$testheight)=getimagesize($imagelocation);
        $path[]=$imagelocation;
        $reallength=$imgpathcount-1;
        // echo "<br> Real length".$reallength."<br>";
        $locationentry=array();
        for($i=0;$i<=$reallength;$i++){
          if($i!==0&&$uploadimgsizes[$i]!=="default"){
            //check to make sure no conflict in next directory folder using the name
            //of the currently uploaded file to maintain consistency
            $match=checkExistingFile($uploadimgpaths[$i],$imagename);
            // echo "<br>".$match['matchval']." ".$uploadimgpaths[$i].$imagename2."<br>";
            if($match['matchval']=="true"){
              $nextentry=md5($match['totalfilecount']+1);
              $imagename2=$imgname.$nextentry.".".$extension;
              // // echo"in here";
            }else{
              $imagename2=$imagename2;
            }

            $curpath=$uploadimgpaths[$i].$imagename2;
            // // echo$uploadimgsizes[$i]."the one".$curpath;
            $cursize=explode(",",$uploadimgsizes[$i]);
            $newwidth=$cursize[0];
            $newheight=$cursize[1];
            unset($locationentry);
            $locationentry[]=$imagelocation;
            $locationentry[]=$curpath;
            imageResize($locationentry,$newwidth,$newheight,$extension,false,"",$curpath);
            $path[]=$curpath;
          }
        }
        // // echo"<br>".$reallength." thereallengthafter<br>";

        // move_uploaded_file("$image","$imagelocation");
      }else{
        $match=checkExistingFile($defaultimglocation,$imagename);
        if($match['matchval']=="true"){
          $nextentry=md5($match['totalfilecount']+1);
          $imagename2=$imgname.$nextentry.".".$extension;
        }else{
          $imagename2=$imagename;
        }
        $imagelocation=$defaultimglocation.$imagename2;
        if(move_uploaded_file("$image","$imagelocation")){

        }else{
          rename("$image","$imagelocation");   
        }
        $path[]=$imagelocation;
      }   
    }else{
      $match=checkExistingFile($defaultimglocation,$imagename);
      if($match['matchval']=="true"){
        $nextentry=md5($match['totalfilecount']+1);
        $imagename2=$imgname.$nextentry.".".$extension;
        // echo"in here";
      }else{
        $imagename2=$imagename;
      }
      $imagelocation=$defaultimglocation.$imagename2;
      if(move_uploaded_file("$image","$imagelocation")){

      }else{
        rename("$image","$imagelocation");   
      }
      $exists=file_exists($imagelocation);
      $exists===true?$exist="true":$exist="false";
      // // echo$exist;
      if($acceptedsize!==""){
        $match=checkExistingFile($defaultimglocation,$imagename2);
        if($match['matchval']=="true"){
          $nextentry=md5($match['totalfilecount']+1);
          $imagename2=$imgname.$nextentry.".".$extension;
        }else{
          $imagename2=$imagename;
        }
        $curpath=$defaultimglocation.$imagename2;
        // echo$curpath;
        $acceptedsize=explode(",",$acceptedsize);
        $acceptedwidth=$acceptedsize[0];
        $acceptedheight=$acceptedsize[1];
        $locationentry=array();
        $locationentry[]=$imagelocation;
        $locationentry[]=$curpath;
        imageResize($locationentry,$acceptedwidth,$acceptedheight,$extension,false,"",$curpath);
        unlink($imagelocation);     
        $imagelocation=$curpath;
      }
      $path[]=$imagelocation;
    }
  }else{
    $path="no image";
  }
      return $path;
  
}
function produceImageFitSize($location,$contwidth,$contheight,$auto){
global $host_addr;
$output=array();
$output['width']="20px";
$output['height']="20px";
$output['style']="";
$output['truewidth']="";
$output['trueheight']="";
$style="";
if($location!==""&&$contwidth!==""&&$contheight!==""){
  $imagefile=$host_addr.$location;
  $imagefile=str_replace(" ","%20",$imagefile);

list($curwidth,$curheight)=getimagesize(''.$imagefile.'');
$output['truewidth']=$curwidth;
$output['trueheight']=$curheight;
if ($contwidth>$contheight) {
if($curwidth>$contwidth||$curheight>$contheight){

if($curwidth>$curheight&&$curheight>=$contheight&&$curwidth>$contwidth){
$curwidth=$contwidth;

$style='cursor:pointer;height:'.$contheight.'px;width:'.$curwidth.'px;margin:auto;';
}else if($curwidth<$curheight&&$curheight>$contheight&&$curwidth>$contwidth){
  $extrawidth=floor($curwidth-$contheight);
  $dimensionratio=$curwidth/$curheight;
// console.log(dimensionratio);

   $curwidth=floor($contheight*$dimensionratio);
    $widthdiff=$contwidth-$curwidth;
    if($widthdiff>0){
    $marginleft=floor($widthdiff/2);
    }else{
      $marginleft=0;
    }
  if($extrawidth>$contwidth&&$extrawidth>$contheight){
    $extrawidth=$curwidth-$extrawidth;
  }/*else if ($curwidth>$contwidth&&$curwidth>$contheight) {
    $curwidth=$curwidth-120;
}*/

$style='cursor:pointer;width:'.$curwidth.'px;height:'.$contheight.'px;margin-left:'.$marginleft.'px;';
if($auto=="on"){
$style='cursor:pointer;width:'.$curwidth.'px;height:'.$contheight.'px;';
}
}else if($curwidth<$curheight&&$curheight>=$contheight&&$curwidth<$contwidth){
  $dimensionratio=$curwidth/$curheight;

   $curwidth=floor($contheight*$dimensionratio);
    $widthdiff=$contwidth-$curwidth;
    if($widthdiff>0){
    $marginleft=floor($widthdiff/2);
    }else{
      $marginleft=0;
    }

$style='cursor:pointer;width:'.$curwidth.'px;height:'.$contheight.'px;margin-left:'.$marginleft.'px;';
}else if($curwidth>$curheight&&$curheight<$contheight&&$curwidth>$contwidth){
  $dimensionratio=$curwidth/$curheight;
// console.log(dimensionratio);
   $curwidth=floor($contheight*$dimensionratio);
    $difference=$contheight-$curheight;
    $margintop=floor($difference/2);
    if($auto=="on"){
$style='cursor:pointer;width:'.$contwidth.'px;height:'.$curheight.'px;margin-top:auto;'; 
    }else{      
$style='cursor:pointer;width:'.$contwidth.'px;height:'.$curheight.'px;margin-top:'.$margintop.'px;'; 
    }
  }else if($curwidth<$curheight&&$curheight<$contheight){
    $difference=$contheight-$curheight;
    $margintop=floor($difference/2);
  $curwidth=$curheight-10;
    if($auto=="on"){
$style='cursor:pointer;width:'.$curwidth.'px;height:'.$curheight.'px;margin-top:auto;'; 
    }else{      
$style='cursor:pointer;width:'.$curwidth.'px;height:'.$curheight.'px;margin-top:'.$margintop.'px;'; 
    }
  }else if($curwidth==$curheight&&$curheight>$contheight){
  $marginleft=$contwidth-$contheight;
  $marginleft=$marginleft/2;
$style='cursor:pointer;width:'.$contheight.'px;height:'.$contheight.'px;margin-left:'.$marginleft.'px;'; 
  }

}else{
    $difference=$contheight-$curheight;
    $margintop=floor($difference/2);
    $widthdiff=$contwidth-$curwidth;
    $marginleft=floor($widthdiff/2);
$style='cursor:pointer;width:'.$curwidth.'px;height:'.$curheight.'px;margin-left:'.$marginleft.'px;margin-top:'.$margintop.'px;';
}
}elseif ($contwidth<$contheight) {
  # code...
}
}
$style.='float:left;';
$output['width']=$curwidth;
$output['height']=$curheight;
$output['style']=$style;
return $output;
}

function fileSizeConvert($bytes,$units=""){
  $bytes = floatval($bytes);
  $arBytes = array(
      0 => array(
          "UNIT" => "TB",
          "VALUE" => pow(1024, 4)
      ),
      1 => array(
          "UNIT" => "GB",
          "VALUE" => pow(1024, 3)
      ),
      2 => array(
          "UNIT" => "MB",
          "VALUE" => pow(1024, 2)
      ),
      3 => array(
          "UNIT" => "KB",
          "VALUE" => 1024
      ),
      4 => array(
          "UNIT" => "B",
          "VALUE" => 1
      ),
  );


  foreach($arBytes as $arItem)
  {   
    if($units==""){
      // test the value in bytes against the prestored ones in the array
      // if a match is found then the byte range is valid for that unit
      if($bytes >= $arItem["VALUE"]){
          $result = $bytes / $arItem["VALUE"];
          $result = strval(round($result, 2))." ".$arItem["UNIT"];
          break;
      }else{
          $result=0;
      }
    }else{
      // check and validate if the specified unit required is available 
      // among the storeds units of the array.
      if($units == $arItem["UNIT"]){
          $result = $bytes / $arItem["VALUE"];
          $result = strval(round($result, 2))." ".$arItem["UNIT"];
          break;
      }else{
          $result=0;
      }
    }
  }
  return $result;
}

function numberSizeConvert($val,$units=""){
  $val = floatval($val);
  $arBytes = array(
      0 => array(
          "UNIT" => "t",
          "VALUE" => pow(1000, 4)
      ),
      1 => array(
          "UNIT" => "b",
          "VALUE" => pow(1000, 3)
      ),
      2 => array(
          "UNIT" => "m",
          "VALUE" => pow(1000, 2)
      ),
      3 => array(
          "UNIT" => "K",
          "VALUE" => 1000
      )
  );


  foreach($arBytes as $arItem)
  {   
    if($units==""){
      // test the value in thousands against the prestored ones in the array
      // if a match is found then the value range is valid for that unit
      if($val >= $arItem["VALUE"]){
          $result = $val / $arItem["VALUE"];
          $result = strval(round($result, 2))." ".$arItem["UNIT"];
          break;
      }else{
          $result=0;
      }
    }else{
      // check and validate if the specified unit required is available 
      // among the storeds units of the array.
      if($units == $arItem["UNIT"]){
          $result = $val / $arItem["VALUE"];
          $result = strval(round($result, 2))." ".$arItem["UNIT"];
          break;
      }else{
          $result=0;
      }
    }
  }
  if($result==0){
    $result=$val;
  }
  return $result;
}
function get_include_contents($filename,$initvars="",$initvals="") {
    include("globalsmodule.php");
    if($initvars!==""&&!is_array($initvars)){
      // create the variable name and assign it the value
      $$initvars=$initvals;
    }else if(is_array($initvars)&&is_array($initvals)){
      $cvals=count($initvars);
      // create the variable names based on array values
      for($i=0;$i<$cvals;$i++){
        $$initvars[$i]=$initvals[$i];
      }
    }
    if (is_file($filename)) {
        ob_start();
        include $filename;
        return ob_get_clean();
    }
    return false;
}
function getNextId($tablename){
$query="SELECT * FROM $tablename";
$run=mysql_query($query);
$numrows=mysql_num_rows($run);
$nextid=$numrows+1;
return $nextid;
}
function getNextIdExplicit($tablename){
$query="SELECT * FROM $tablename ORDER BY id DESC";
$run=mysql_query($query);
$row=mysql_fetch_assoc($run);
// $numrows=mysql_num_rows($run);
$nextid=$row['id']+1;
return $nextid;
}
function getSingleMediaData($partid,$parttype){
  $ordervalues="";
  if(is_array($partid) && is_array($parttype)){
    //proceed to generate combined test params for valid entry
    $orderfieldvals=count($parttype)-1;
    for($i=0;$i<=$orderfieldvals;$i++){
      if($i!==$orderfieldvals){
        $ordervalues.="".$parttype[$i]."='".$partid[$i]."' AND ";
      }else{
       $ordervalues.=" ".$parttype[$i]."='".$partid[$i]."'";
      }
        $query="SELECT * FROM media WHERE $ordervalues";
    }
  }else{
    $query="SELECT * FROM media WHERE $parttype=$partid";
  }
$run=mysql_query($query)or die(mysql_error());
$numrows=mysql_num_rows($run);
$row=array();
$row=mysql_fetch_assoc($run);
return $row;
}


function getSingleMediaDataTwo($partid){
  $numrows=0;
  
  $query="SELECT * FROM media WHERE id=$partid";
  
  $run=mysql_query($query)or die(mysql_error());
  $numrows=mysql_num_rows($run);
  
  
  $row=array();
  $row['adminoutput']="";
  $row['vieweroutput']="";
  if($numrows>0){
    $row=mysql_fetch_assoc($run);
    $id=$row['id'];
    $ownerid=$row['ownerid'];
    $maintype=$row['maintype'];
    $mediatype=$row['mediatype'];
    $category=$row['categoryid'];
    $location=$row['location'];
    $details=$row['details'];
    $filesize=$row['filesize'];
    $width=$row['width'];
    $height=$row['height'];
    $title=$row['title'];
    $status=$row['status'];
  }
return $row;
}
function checkEmail($email,$tablename,$columnname){
  $row=array();
  $extraquery="";
  if(is_array($email)){
    $contentdata=$email;
    $email=$contentdata['email'];
    $extrafieldcount=$contentdata['fieldcount'];

    for($i=0;$i<$extrafieldcount;$i++){
        // echo json_encode(array("ef"=>"$extrafieldcount"));
        $logic=strtoupper($contentdata['logic'][$i]);// OR | AND | LIKE
        $column=$contentdata['column'][$i];
        $value=$contentdata['value'][$i];
        $extraquery.="$logic $column = '$value'";
    }

  }
  $row['testquery']="";
  // verify the email address first using regex
  $query="SELECT * FROM $tablename where $columnname='$email' $extraquery";
  if(filter_var($email, FILTER_VALIDATE_EMAIL)){
    $run=mysql_query($query)or die(mysql_error());
    $numrows=mysql_num_rows($run);
    $row['testresult']="";
    if($numrows>0){
      $row=mysql_fetch_assoc($run);
      $row['testresult']="matched";
    }else{
      $row['testresult']="unmatched";
    }
    $row['testquery']="$query";
  }else{
    $row['testquery']="$query";
    $row['testresult']="unmatched";
  }
  return $row;
}
function produceOptionDates($from,$to,$display){
$output='<option value="">--'.$display.'--</option>';
if($to=="current"){
$to=date('Y');
for($i=$from;$i<=$to;$i++){
  $output.='<option value="'.$i.'">'.$i.'</option>';
}
}else{
for($i=$from;$i<=$to;$i++){
  $output.='<option value="'.$i.'">'.$i.'</option>';
} 
}
return $output;
}
function produceStates($countryid,$stateid){
if(($countryid==""||$countryid==0)&&($stateid==""||$stateid==0)){ 
$query="SELECT * FROM states";
}
if(($countryid!==""&&$countryid!==0)&&($stateid==""||$stateid==0)){
$query="SELECT * FROM states where cid=$countryid"; 
}
if(($countryid==""||$countryid==0)&&($stateid!==""&&$stateid!==0)){
$query="SELECT * FROM states where id=$stateid";  
}

$run=mysql_query($query)or die(mysql_error().'line 472');

$statetotal="";
$state="";
$row=array();
while ($row=mysql_fetch_assoc($run)) {
  # code...
  $statetotal.='<option value="'.$row['id'].'">'.$row['state'].'</option>';
  $state=$row['state'];
}
// $row2=mysql_fetch_array($run);

$row['statename']=$state;
$row['selectionoutput']='
<select name="state" class="curved2">
<option value="">--State--</option>
'.$statetotal.'
</select>
';
$row['selectionoptions']='
'.$statetotal.'
';
return $row;
}
function calenderOut($day,$month,$year,$viewer,$targetcontainermain,$theme,$controlquery){
  $occurencedates=array();
  if(is_array($targetcontainermain)){
    // // echo"in here";
    $targetcontainer=$targetcontainermain[0];
    //for miscellaneous customization for any other entry you want to customize
    $controlviewtype=$targetcontainermain[1];
    // // echo$controlviewtype;
    $occurencedates=explode(",",$controlviewtype);
    // // echo"<br>".$occurencedates[1];
  }else{
    $controlviewtype="";
    $targetcontainer=$targetcontainermain;
  }
  $controloption='data-control="'.$controlviewtype.'"';
global $host_addr,$host_target_addr;
$row=array();
$calHold="";
$caltop="";
$calDaynameholdcalday="";
$calDaysHoldcalday="";
$calDaysHoldweekend="";
$calInfobox="";
if($theme=="green"){
$calHold='style="background:#053307;"';
$caltop='style="color:#05D558;"';
$calDaynameholdcalday='style="color:#05D558;"';
$calDaysHoldcalday='style="color:#18FA7B;"';
$calDaysHoldweekend='style="background:#D59D28;color:#fff;text-shadow:0px 0px 3px #DA2020;"';
$calInfobox='style="color:#05D558;"';
}elseif($theme=="red"){

}
$row['errorout']="Sorry you seem to have either left a value empty, or entered the wrong type of required data";
//get current date value.
$currentday=date('d');
$currentmonth=date('m');
$currentyear=date('Y');
$currentdate="".$currentday."-".$currentmonth."-".$currentyear."";
if($day!=="" && $month!=="" && $year!==""){
//convert the month value into a numeric type if it is not already numeric
  $entrymonth=$month;
//control values exceeding or less than the total number of months in the year
  if($entrymonth>12){
    $entrymonth=12;

  }else if ($entrymonth<1) {
    # code...
    $entrymonth=1;
  }
  if($entrymonth>0 && $entrymonth<13){
$firstdate="1-".$entrymonth."-".$year."";
$firstdate=strtotime($firstdate);
  $entrymonth2=date('F',$firstdate);
  }
$row['errorout']="no error";
$monthcount=31;
$firstdate="1-".$entrymonth."-".$year."";
$firstdate=strtotime($firstdate);
$msd=date('D',$firstdate);
$lst=0;
$ledt="nada";
$monthcount=date('t',$firstdate);
//get number of days that
$msd=="Mon"?$lst=1:($msd=="Tue"?$lst=2:($msd=="Wed"?$lst=3:($msd=="Thu"?$lst=4:($msd=="Fri"?$lst=5:($msd=="Sat"?$lst=6:$ledt)))));
$excessdays="";
$realdays="";
if($lst>0){
for($i=1;$i<=$lst;$i++){
if($i==1){
$excessdays.='
<div id="calDay" name="" '.$calDaysHoldweekend.'title=""></div>
';  
}else{
$excessdays.='
<div id="calDay" name="" title=""></div>
';  
}
}
}

for($t=1;$t<=$monthcount;$t++){
$testdate=''.$t.'-'.$entrymonth.'-'.$year.'';
$entrymonth<10&&strlen($entrymonth)<2?$testdatemonitor=''.$t.'-0'.$entrymonth.'-'.$year.'':$testdatemonitor=$testdate;
$daytype="".date("l",mktime(0,0,0,$entrymonth,$t,$year))."";
$today="";
// // echo$testdatemonitor." ".$occurencedates[0]." ".$occurencedates[1]."<br>";
$calDaysHoldweekend2=$calDaysHoldweekend;
$datapoint="";
if($t==$currentday&&$entrymonth==$currentmonth&&$year==$currentyear){
$today="today";
$datapoint=$today;
}elseif(in_array($testdatemonitor,$occurencedates)){
$datapoint="eventdate";
}

if($daytype=="Sunday") {
  $teser=0;
$today=="today"?$realdays.='<div id="calDay" name="'.$testdate.'" data-point="'.$datapoint.'" title="'.$t.'-'.$entrymonth.'-'.$year.'"data-target="'.$targetcontainer.'">'.$t.'</div>':$realdays.='<div id="calDay" name="'.$testdate.'" '.$calDaysHoldweekend.' data-point="'.$today.'" title="'.$t.'-'.$entrymonth.'-'.$year.'"data-target="'.$targetcontainer.'">'.$t.'</div>';

}

if($daytype!=="Sunday"){
$realdays.='
<div id="calDay" name="'.$testdate.'" '.$calDaysHoldcalday.' data-point="'.$datapoint.'" title="'.$t.'-'.$entrymonth.'-'.$year.'"data-target="'.$targetcontainer.'">'.$t.'</div>
';  
}

}
$totaldays=$excessdays.$realdays;
//outputs
$row['totaldaysout']=$totaldays;
$admindisplay="";
$adminstyle="";
if($viewer=="admin"){
$admindisplay=".";
$adminstyle='style="float:none;"';
}
$row['formoutput']='
    <div id="calHold" '.$calHold.' '.$adminstyle.'>
      <div id="caltop" '.$caltop.'>
        <div id="calmonthpointer" name="calpointleft" data-target="'.$targetcontainer.'" data-theme="'.$theme.'" '.$controloption.'>
          <img src="'.$admindisplay.'./images/leftarrow.png" class="total"/>
        </div>
        <div id="calDispDetails" data-curmonth="'.$entrymonth.'" data-year="'.$year.'">
          '.$entrymonth2.', '.$year.'
        </div>
        <div id="calmonthpointer" name="calpointright"data-target="'.$targetcontainer.'" data-theme="'.$theme.'" '.$controloption.'>
          <img src="'.$admindisplay.'./images/rightarrow.png" class="total"/>
        </div>
      </div>      
      <div id="calBody">
        <div id="calDaynamehold">
          <div id="calDay" '.$calDaynameholdcalday.'>Sun</div>
          <div id="calDay" '.$calDaynameholdcalday.'>Mon</div>
          <div id="calDay" '.$calDaynameholdcalday.'>Tue</div>
          <div id="calDay" '.$calDaynameholdcalday.'>Wed</div>
          <div id="calDay" '.$calDaynameholdcalday.'>Thu</div>
          <div id="calDay" '.$calDaynameholdcalday.'>Fri</div>
          <div id="calDay" '.$calDaynameholdcalday.'>Sat</div>
        </div>
        <div id="calDaysHold"name="'.$targetcontainer.'">
          <!--<div id="calDay" name="theday-themonth-theyear" title="The date goes here:-12 Appointments">1</div>-->
          '.$totaldays.'
        </div>
      </div>
      <div id="calInfobox" '.$calInfobox.'>
        Click on a day to choose or view it.
      </div>
    </div>
';
$row['totaloutput']='
    <div id="calHold">
      <div id="caltop">
        <div id="calmonthpointer" name="calpointleft" data-target="'.$targetcontainer.'" '.$controloption.'>
          <img src="'.$admindisplay.'./images/leftarrow.png" class="total"/>
        </div>
        <div id="calDispDetails" data-curmonth="'.$entrymonth.'" data-year="'.$year.'">
          '.$entrymonth2.', '.$year.'
        </div>
        <div id="calmonthpointer" name="calpointright" data-target="'.$targetcontainer.'" '.$controloption.'>
          <img src="'.$admindisplay.'./images/rightarrow.png" class="total"/>
        </div>
      </div>      
      <div id="calBody">
        <div id="calDaynamehold">
          <div id="calDay">Sun</div>
          <div id="calDay">Mon</div>
          <div id="calDay">Tue</div>
          <div id="calDay">Wed</div>
          <div id="calDay">Thu</div>
          <div id="calDay">Fri</div>
          <div id="calDay">Sat</div>
        </div>
        <div id="calDaysHold" name="'.$targetcontainer.'">
          <!--<div id="calDay" name="theday-themonth-theyear" title="The date goes here:-12 Appointments">1</div>-->
          '.$totaldays.'
        </div>
      </div>
      <div id="calInfobox" '.$calInfobox.'>
        Click on the day to view schedule for choosen date.
      </div>
    </div>
';
}
return $row;
}
function removeDirectory($dirPath){
  include('globalsmodule.php');
  if (! is_dir($dirPath)) {
      throw new InvalidArgumentException("$dirPath must be a directory");
  }
  if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
      $dirPath .= '/';
  }
  $files = glob($dirPath . '*', GLOB_MARK);
  foreach ($files as $file) {
      if (is_dir($file)) {
          self::deleteDir($file);
      } else {
          unlink($file);
      }
    }
    rmdir($dirPath);
  
}
function paginate($query){
  require_once 'paginator.class.php';
  $pages = new Paginator;  
  $run=mysql_query($query)or die(mysql_error()."Line 646");
  $numrows=mysql_num_rows($run);
  $pages->items_total = $numrows;  
  $pages->mid_range = 9;  
  $pages->paginate();  
  $pages->display_pages();
  $row['limitout']=$pages->limit;
  $query2=$query.$row['limitout'];
  // // // echo$pages;
  $row=array();

  $row['outputcount']=$numrows;
  $row['pageout']=$pages->display_pages();
  $row['usercontrols']="<br><span> ".$pages->display_jump_menu()." ".$pages->display_items_per_page()."</span>";
  $row['limit']=$pages->limit;
  $row['num_pages']=$pages->num_pages;
return $row;
}
function paginatejavascript($query,$type=""){
  require_once 'paginator.class.php';
  $pages = new Paginator;  
  $run=mysql_query($query)or die(mysql_error()." $query Line".__LINE__);
  $numrows=mysql_num_rows($run);
  $pages->items_total = $numrows;  
  $pages->mid_range = 9;  
  $pages->paginatejavascript($type);  
  $pages->display_pages($type);
  $row['limitout']=$pages->limit;
  $query2=$query.$row['limitout'];
  // // // echo$pages;
  $row=array();

  $row['numrows']=$numrows;
  $row['pageout']=$pages->display_pages($type);
  $row['usercontrols']="<br><span> ".$pages->display_items_per_page_javascript($type)."</span>";
  $row['singlecontrols']=$pages->display_items_per_page_javascript($type);
  $row['limit']=$pages->limit;
  $row['num_pages']=$pages->num_pages;
  return $row;
}
function paginateCustom($query,$param){
  require_once 'paginator.class.php';
  $pages = new Paginator;  
  if(!is_numeric($query)){
    $run=mysql_query($query)or die(mysql_error()."Line 646");
    $numrows=mysql_num_rows($run);
  }else if(is_numeric($query)){
    $numrows=$query;
  }
  // // echo$query;
  $pages->items_total = $numrows; 
  $pages->pagetype=$param; 
  $pages->mid_range = 9;  
  $pages->paginate();  
  $pages->display_pages();
  $row['limitout']=$pages->limit;
  $query2=$query.$row['limitout'];
  // // // echo$pages;
  $row=array();
  $row['outputcount']=$numrows;
  $row['pageout']=$pages->display_pages();
  $row['usercontrols']="<br><span> ".$pages->display_jump_menu()." ".$pages->display_items_per_page()."</span>";
  $row['limit']=$pages->limit;
  return $row;
}
function getSingleContentMedia($mediaid){
global $host_addr,$host_target_addr;
$row=array();
$query="SELECT * FROM media WHERE id=$mediaid";
$run=mysql_query($query)or die(mysql_error()." Real number:".__LINE__." old number  999");
$row=mysql_fetch_assoc($run);
$relpath=$row['location'];
$mainpath=$host_addr.$row['location'];
$filenamesplit=explode("/",$relpath);
$medianame=$filenamesplit[count($filenamesplit)-1];
$filetype=getFileType($mainpath);
$extension=getExtension($relpath);
if($filetype=="image"){
$datasrc=$host_addr.$row['details'];
}elseif($filetype=="audio"){
$datasrc=''.$host_addr.'/images/audiodisp.jpg';
}elseif($filetype=="video"){
$datasrc=''.$host_addr.'/images/videodisp.jpg';
}
$row['adminoutput']='
<div id="editmediacontent" name="mediacontent'.$mediaid.'">
      <div id="editmediacontentoptions">
        <div id="editmediacontentoptionlinks">
          <a href="##" name="delete" data-id="'.$mediaid.'" data-medianame="'.$medianame.'" data-mediatype="'.$filetype.'" data-src=".'.$relpath.'"data-width="'.$row['width'].'" data-height="'.$row['height'].'"><img name="delete" src="../images/trashfirst.png" title="Delete media?" class="total"></a>
          <a href="##" name="view" data-id="'.$mediaid.'" data-medianame="'.$medianame.'" data-mediatype="'.$filetype.'" data-src=".'.$relpath.'" data-width="'.$row['width'].'" data-height="'.$row['height'].'"><img name="view" src="../images/viewpicfirst.png" title="View media" class="total"></a>               
        </div>
      </div>  
      <img src="'.$datasrc.'" title="'.$medianame.','.$filetype.','.$row['filesize'].'" name="realimage" style="height:100%;margin:auto;">
    </div>
';
return $row;

}
function getAllContentMedia($viewer,$limit,$type){
global $host_addr,$host_target_addr;
$row=array();
$type==""?$type="all":$type=$type;
$testit=strpos($limit,"-");
$testit===0||$testit===true||$testit>0?$limit="":$limit=$limit;
$limit==""?$limit="LIMIT 0,15":$limit=$limit;
if($limit==""&&$viewer=="admin"&&$type=="all"){
$query="SELECT * FROM media WHERE ownertype='contentmedia' ORDER BY id DESC $limit";
$rowmonitor['chiefquery']="SELECT * FROM media WHERE ownertype='contentmedia' ORDER BY id DESC";
}elseif($limit!==""&&$viewer=="admin"&&$type=="all"){
$query="SELECT * FROM media WHERE ownertype='contentmedia' ORDER BY id DESC $limit";
$rowmonitor['chiefquery']="SELECT * FROM media WHERE ownertype='contentmedia' ORDER BY id DESC";
}elseif($viewer=="admin"&&($type=="images"||$type=="image")){
  $type="image";
$query="SELECT * FROM media WHERE ownertype='contentmedia' AND mediatype='$type' AND status='active' ORDER BY id asc $limit";
$rowmonitor['chiefquery']="SELECT * FROM media WHERE ownertype='contentmedia' AND mediatype='$type' AND status='active' ORDER BY id asc";  
}elseif($viewer=="admin"&&$type=="audio"){
$query="SELECT * FROM media WHERE ownertype='contentmedia' AND mediatype='$type' AND status='active' ORDER BY id asc $limit";
$rowmonitor['chiefquery']="SELECT * FROM media WHERE ownertype='contentmedia' AND mediatype='$type' AND status='active' ORDER BY id asc";  
}elseif($viewer=="admin"&&$type=="video"){
$query="SELECT * FROM media WHERE ownertype='contentmedia' AND mediatype='$type' AND status='active' ORDER BY id asc $limit";
$rowmonitor['chiefquery']="SELECT * FROM media WHERE ownertype='contentmedia' AND mediatype='$type' AND status='active' ORDER BY id asc";  
}
// // echo$query;
$run=mysql_query($query)or die(mysql_error()." Real number:".__LINE__." old number  2744");
$numrows=mysql_num_rows($run);
$adminoutput="<td colspan=\"100%\">No entries</td>";
$adminoutputtwo="";
$vieweroutput='<font color="#1a1a1a">Sorry, No Boats have been created yet</font>';
$vieweroutputtwo='<font color="#1a1a1a">Sorry, No boats have been created with that brand and name</font>';
$boattotal='<option value="">Choose a Boat Brand & make</option>';
if($numrows>0){
$adminoutput="";
$adminoutputtwo="";
$vieweroutput="";
while($row=mysql_fetch_assoc($run)){
$outs=getSingleContentMedia($row['id']);
$adminoutput.=$outs['adminoutput'];
// $adminoutputtwo.=$outs['adminoutputtwo'];
// $vieweroutput.=$outs['vieweroutput'];
// $vieweroutputtwo=$outs['vieweroutputtwo'];
// $boattotal.='<option value="'.$row['id'].'">'.$row['name'].' - Year '.$row['year'].'</option>';
}

}
$top="";
$bottom="";
/*$top='<table id="resultcontenttable" cellspacing="0">
      <thead><tr><th>CoverPhoto</th><th>Boat Type</th><th>Name</th><th>Year</th><th>Price</th><th>location</th><th>status</th><th>View/Edit</th></tr></thead>
      <tbody>';
$bottom=' </tbody>
    </table>';*/
  $row['chiefquery']=$rowmonitor['chiefquery'];
$outs=paginatejavascript($rowmonitor['chiefquery']);
$outsviewer=paginate($rowmonitor['chiefquery']);
$paginatetop='
<div id="paginationhold">
  <div class="meneame">
    <input type="hidden" name="curquery" value="'.$rowmonitor['chiefquery'].'"/>
    <input type="hidden" name="outputtype" value="mediacontent|'.$type.'"/>
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
// $row['vieweroutput']=$vieweroutput;

return $row;

}
/*Converts numbers to english word equivalent*/
function convertNumber($number)
{
    list($integer, $fraction) = explode(".", (string) $number);

    $output = "";

    if ($integer{0} == "-")
    {
        $output = "negative ";
        $integer    = ltrim($integer, "-");
    }
    else if ($integer{0} == "+")
    {
        $output = "positive ";
        $integer    = ltrim($integer, "+");
    }

    if ($integer{0} == "0")
    {
        $output .= "zero";
    }
    else
    {
        $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
        $group   = rtrim(chunk_split($integer, 3, " "), " ");
        $groups  = explode(" ", $group);

        $groups2 = array();
        foreach ($groups as $g)
        {
            $groups2[] = convertThreeDigit($g{0}, $g{1}, $g{2});
        }

        for ($z = 0; $z < count($groups2); $z++)
        {
            if ($groups2[$z] != "")
            {
                $output .= $groups2[$z] . convertGroup(11 - $z) . (
                        $z < 11
                        && !array_search('', array_slice($groups2, $z + 1, -1))
                        && $groups2[11] != ''
                        && $groups[11]{0} == '0'
                            ? " and "
                            : ", "
                    );
            }
        }

        $output = rtrim($output, ", ");
    }

    if ($fraction > 0)
    {
        $output .= " point";
        for ($i = 0; $i < strlen($fraction); $i++)
        {
            $output .= " " . convertDigit($fraction{$i});
        }
    }

    return $output;
}

function convertGroup($index)
{
    switch ($index)
    {
        case 11:
            return " decillion";
        case 10:
            return " nonillion";
        case 9:
            return " octillion";
        case 8:
            return " septillion";
        case 7:
            return " sextillion";
        case 6:
            return " quintrillion";
        case 5:
            return " quadrillion";
        case 4:
            return " trillion";
        case 3:
            return " billion";
        case 2:
            return " million";
        case 1:
            return " thousand";
        case 0:
            return "";
    }
}

function convertThreeDigit($digit1, $digit2, $digit3)
{
    $buffer = "";

    if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0")
    {
        return "";
    }

    if ($digit1 != "0")
    {
        $buffer .= convertDigit($digit1) . " hundred";
        if ($digit2 != "0" || $digit3 != "0")
        {
            $buffer .= " and ";
        }
    }

    if ($digit2 != "0")
    {
        $buffer .= convertTwoDigit($digit2, $digit3);
    }
    else if ($digit3 != "0")
    {
        $buffer .= convertDigit($digit3);
    }

    return $buffer;
}

function convertTwoDigit($digit1, $digit2)
{
    if ($digit2 == "0")
    {
        switch ($digit1)
        {
            case "1":
                return "ten";
            case "2":
                return "twenty";
            case "3":
                return "thirty";
            case "4":
                return "forty";
            case "5":
                return "fifty";
            case "6":
                return "sixty";
            case "7":
                return "seventy";
            case "8":
                return "eighty";
            case "9":
                return "ninety";
        }
    } else if ($digit1 == "1")
    {
        switch ($digit2)
        {
            case "1":
                return "eleven";
            case "2":
                return "twelve";
            case "3":
                return "thirteen";
            case "4":
                return "fourteen";
            case "5":
                return "fifteen";
            case "6":
                return "sixteen";
            case "7":
                return "seventeen";
            case "8":
                return "eighteen";
            case "9":
                return "nineteen";
        }
    } else
    {
        $temp = convertDigit($digit2);
        switch ($digit1)
        {
            case "2":
                return "twenty-$temp";
            case "3":
                return "thirty-$temp";
            case "4":
                return "forty-$temp";
            case "5":
                return "fifty-$temp";
            case "6":
                return "sixty-$temp";
            case "7":
                return "seventy-$temp";
            case "8":
                return "eighty-$temp";
            case "9":
                return "ninety-$temp";
        }
    }
}

function convertDigit($digit)
{
    switch ($digit)
    {
        case "0":
            return "zero";
        case "1":
            return "one";
        case "2":
            return "two";
        case "3":
            return "three";
        case "4":
            return "four";
        case "5":
            return "five";
        case "6":
            return "six";
        case "7":
            return "seven";
        case "8":
            return "eight";
        case "9":
            return "nine";
    }
}
/*end*/
function deleteMedia($partid,$loadjson="",$usermonitor=""){
  global $host_addr,$host_target_addr;
  $mediadata=getSingleMediaDataTwo($partid);
  $realpath=".".$mediadata['location']."";
  $medpath=".".$mediadata['medsize']."";
  $thumbpath=".".$mediadata['thumbnail']."";
  $realpaththumb=".".$mediadata['details']."";
  $go="dodelete";
  if($usermonitor=="viewer"){
    // check if the user exists then verify if they own the file
  }
  if($go=="dodelete"){
    if(file_exists($realpath)){
        unlink($realpath);
        if($mediadata['ownertype']=="boat"){
          if(file_exists($realpaththumb)){
            unlink($realpaththumb);
          }
       }
    }
    if(file_exists($medpath)){

        unlink($medpath);

    }
    if(file_exists($thumbpath)){

        unlink($thumbpath);

    }

    genericSingleUpdate("media","status","inactive","id",$partid);
    genericSingleUpdate("media","mainid","0","id",$partid);
    genericSingleUpdate("media","ownertype","none","id",$partid);
    genericSingleUpdate("media","ownerid","0","id",$partid);
    $output="done";
    // check to validate content that can be reused later so you dont unset the maintype
    // value
    if($mediadata['maintype']!=="muralimage"&&$mediadata['maintype']!=="contententryimage"){
      genericSingleUpdate("media","maintype","none","id",$partid);
    }
    if($loadjson=="deletepic_contententry"){
      $msg="Image was successfully deleted ";

      $output=json_encode(array("success"=>"true","msg"=>"$msg"));
    }
    
  }
  
  return $output;
}
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
function getSingleLGA($id){
  $query="SELECT * FROM local_govt WHERE id_no=$id";
  // echo $query;
  $run=mysql_query($query)or die(mysql_error()." Real number:".__LINE__." old number  1579");
  $row=mysql_fetch_assoc($run);
  return $row;
} 
function generateMailMarkup($from,$to,$title,$content,$footer,$type){
  include('globalsmodule.php');
  $row=array();
  $phpmailermarkup='';
  $rowmarkup='
      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
          <title>Napstand | '.$title.'</title>
          <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
              max-width: 767px;
              margin: auto;
            }
            .heading{
              text-align: center;border:0px; font-size: 32px;color: #c0c0c0;
            }
            .heading2{
              font-size: 22px;text-align: center;color:#606893;border: 0px;border-bottom: 1px solid #979797;
            }
            .content{
              font-size:13px;border: 0px;border-bottom: 1px solid #979797;
            }
            .minifoot{
              border: 0px;border-bottom: 1px solid #979797;font-size: 12px;
            }
            .minifoot ul{
                list-style-type: none;
            }
            .footing{
                text-align: center;
            font-size: 13px;
            background: #373737;
            color: #FFFFFF;
            }
            .footing ul{
                list-style-type: none;
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
            #socialholder a{
                display: block;
                height: 34px;
                width: 34px;
                position: relative;
                overflow: hidden;
            }
            #socialholder a img{
              width:100%;
            }
          </style>
        </head>
        <body>
         <table cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
             <td class="heading">
              <img src="'.$host_addr.'images/adsbounty5.png"  alt="Adsbounty" width="220" height="" style="display: inline-block;" /><br>
             </td>
            </tr>
            <tr>
             <td class="heading2">
              '.$title.'
             </td>
            </tr>
            <tr>
             <td class="content">
              '.$content.'
             </td>
            </tr>
            <tr>
             <td class="minifoot">
              <div id="sociallinks">
                <div id="socialholder" name="socialholdfacebook"><a href="##" target="_blank"><img src="'.$host_addr.'images/Facebook-Icon.png" alt="Facebook"/></a></div>
                <div id="socialholder" name="socialholdlinkedin"><a href="##" target="_blank"><img src="'.$host_addr.'images/Linkedin-Icon.png" alt="LinkedIn"/></a></div>
                <div id="socialholder" name="socialholdtwitter"><a href="##" target="_blank"><img src="'.$host_addr.'images/Twitter-Icon.png" alt="Twitter"/></a></div>
                <div id="socialholder" name="socialholdgoogleplus"><a href="##" target="_blank"><img src="'.$host_addr.'images/google-plus-icon.png" alt="Google+"/></a></div>
                <div id="socialholder" name="socialholdyoutube"><a href="##" target="_blank"><img src="'.$host_addr.'images/YouTube-Icon.png" alt="YouTube"/></a></div>
              </div>
              '.$footer.'
             </td>
            </tr>
            <tr>
              <td class="footing">
                &copy; AdsBounty '.date("Y").' Developed by Okebukola Olagoke.<br>
              </td>
            </tr>
          </tbody>
         </table>
        </body>
      </html>
  ';
  $row['rowmarkup']=$rowmarkup;
  return $row;
}
function getAdmin($uid){
  $query="SELECT * FROM admin WHERE id=$uid";
  $run=mysql_query($query)or die(mysql_error()." ".__LINE__);
  $row=mysql_fetch_assoc($run);
  return $row;
}
function in_array_func($products, $field, $value)
{
   $row=array();
   $matchkey="";
   $matchbool=false;
   $arr_count=0;
   foreach($products as $key => $product)
   {
      $arr_count++;
      if ( isset($product[$field]) && $product[$field] === $value ){
         $matchkey=$key;
         $matchbool=true;
        
      }
   }
   $row['matchkey']=$matchkey;
   $row['matchbool']=$matchbool;
   $row['count']=$arr_count;
   return $row;
}
function doPageVisitCount($url){
  $today=date("Y-m-d");
}

function convertAgeByNumber($age){
  $curyear=date("Y");
  $dobyear=$curyear-$age;
  $dob=$dobyear."-01-01";
  return $dob;
}
include('Gravatar.php');
include('blogmodule.php');
include('adminusersmodule.php');
include('advertsmodule.php');
include('clientmodule.php');
include('usermodule.php');
include('faqmodule.php');
include('contentmodule.php');
include('notificationsmodule.php');
include('transactionmodule.php');

?>