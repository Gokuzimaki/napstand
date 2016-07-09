<?php
include("connection.php");
if($_GET['id']!==""){
if($_GET['id']==1){
/*$pathToFile='../files/documents/RULES and regulations boat club.docx';
$filename='Rules&Regulations.docx';*/
if(file_exists($pathToFile)&&is_readable($pathToFile)&&preg_match('/\.docx$/',$pathToFile)){
/*header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$filename\"");
readfile($pathToFile);*/
}else{
	echo'<script> window.alert("Sorry but there was a problem downloading the requested file '.$filename.' '.$pathToFile.'")</script>';
}
}
}else{
	header('location:../index.php');
}
?>