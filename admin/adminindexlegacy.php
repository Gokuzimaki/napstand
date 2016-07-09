<?php 
session_start();
include('../snippets/connection.php');
$logpart=md5($host_addr);
if (isset($_SESSION['logcheck'.$logpart.''])&&$_SESSION['logcheck'.$logpart.'']=="on"||$_SESSION['logcheck'.$logpart.'']==""||!isset($_SESSION['logcheck'.$logpart.''])) {
	header('location:indexlegacy.php?error=true');
}
// echo $_SESSION['logcheck'.$logpart.''];
$mview="";
$sview="";
if(isset($_GET['sview'])&&isset($_GET['mview'])){
				$sview=$_GET['sview'];
				$mview=$_GET['mview'];
				// echo $sview." ".$mview;
}
?>
<!DOCTYPE html/>
<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Default Admin</title>
<meta name="description" content="">
<meta name="keywords" content=""/>
<link rel="stylesheet" href="../stylesheets/"/>
<link rel="shortcut icon" type="image/" href="../images/"/>
<script src="../scripts/jquery.js"></script>
<script src="../scripts/mylib.js"></script>
<script language="javascript" type="text/javascript" src="../scripts/jscripts/tiny_mce/jquery.tinymce.js"></script>
<script language="javascript" type="text/javascript" src="../scripts/jscripts/tiny_mce/tiny_mce.js"></script>
<!-- <script language="javascript" type="text/javascript" src="../scripts/js/tinymce/jquery.tinymce.min.js"></script>
<script language="javascript" type="text/javascript" src="../scripts/js/tinymce/tinymce.min.js"></script> -->
<script language="javascript" type="text/javascript" src="../scripts/jscripts/tiny_mce/basic_config.js"></script>
<script src="../scripts/"></script>
<script src="../scripts/formchecker.js"></script>
</head>
<body>
	<div id="main">
	<div id="toppanel">
		<div id="mainsearchbarhold">
			<form action="../display.php">
			<input name="displaytype" type="hidden" value="mainsearch"/>
			<select name="searchby" class="curved2">
				<option value="">Search By</option>
				<option value="">Searchbyoption</option>
			</select>
			<input type="text" placeholder="Choose a 'searchby' option then enter search"class="curved" name="mainsearch"/>
			<div id="formend" style="">
				<input type="button" name="mainsearch" value="Search" class="submitbutton"/>
			</div>
		</form>
		</div>
	</div>

<div id="contentpanel" style="max-width:100%;">
	<div id="menubarhold">
		<div id="menubar">
			<span name="specialheader" style="font-family:ebrima;font-size:40px;clear:both;">MENU</span>
			<div id="menulinkcontainer" data-state="inactive">
				<a href="#?mview=themenuname&sview=none" data-type="mainlink">The menu name</a>
				<a href="#?mview=themenuname&sview=new" data-name="newthemenuname" data-type="sublink" data-state="">New</a>
				<a href="#?mview=themenuname&sview=edit" data-name="editthemenuname" data-type="sublink">Edit</a>
			</div>
			<div id="menulinkcontainer" <?php $mview=="media"?$datamediastate="active":$datamediastate="inactive";?>data-state="<?php echo $datamediastate;?>">
				<a href="#?mview=media&sview=none" data-name="medias" data-type="mainlink">MEDIA</a>
				<a href="#?mview=media&sview=new" <?php $mview=="medias"&&$sview=="new"?$datamediasubstate="active":$datamediasubstate="inactive";?>data-state="<?php echo $datamediasubstate;?>" data-name="newmedia" data-type="sublink" data-state="active">New</a>
				<!-- <a href="#?mview=media&sview=edit" data-name="editmediaall" data-type="sublink">All</a> -->
				<a href="#?mview=media&sview=edit" data-name="editmediaimages" data-type="sublink">Images</a>
				<!-- <a href="#?mview=media&sview=edit" data-name="editmediaaudio" data-type="sublink">Audio</a> -->
				<!-- <a href="#?mview=media&sview=edit" data-name="editmediavideo" data-type="sublink">Video</a> -->
			</div>
			<div id="menulinkcontainer" data-state="inactive">
				<a href="../snippets/logout.php?type=admin"data-name="logout" data-type="mainlink">Logout</a>

			</div>
		</div>
	</div>
	<div id="contentdisplayhold">
					<table id="resultcontenttable" cellspacing="0">
				<thead><tr><th>Name</th><th>Name</th><th>Name</th><th>Name</th><th>Status</th><th>View/Edit</th></tr></thead>
				<tbody>
					<tr data-id="theid">
						<td>The Blog Name</td><td>active</td><td>The Blog Name</td><td>active</td><td>active</td><td name="trcontrolpoint"><a href="#&id=12" name="edit" data-type="editsingleblogtype" data-divid="theid">Edit</a></td>
					</tr>
					<tr name="tableeditcontainer" data-state="inactive" data-divid="theid">
						<td colspan="100%">
							<div id="completeresultdisplay" data-type="editmodal" data-load="unloaded" data-divid="theid">
								<div id="completeresultdisplaycontent" data-type="editdisplay" data-divid="theid">
									
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php 
$teststring="the quick brown fox jumped jumped over the lazy dogs $$,!!,@@ ## %%./ * () ^^ % _ - ++ 
			Fergie's BITSTREAM <>? & = %{html}[ghj].:;
			";
			$teststring2="fullname:yes;age:56;height:747cm;";
			$pattern='/[\s\n\$!#\%\^<>@\(\),.\/\%\*\{\}\&\[\]\?\_\-\+\=:;]/';
			$pattern2='/\/d/';
			$pattern='/[\s]/';
			$regextest=preg_replace($pattern,"-",$teststring);
			$regextest=preg_replace('/[\'.\"$]/',"",$regextest);

			/*echo $regextest."<br>";
			echo $teststring."<br>";*/

			$regextest2=preg_split("/\;/",$teststring2);

?>
	</div>
	</div>
</div>
	<div id="footerpanel">
		<div id="footerpanelcontent">
			<div id="copyright">
	<?php include('../snippets/footer.php');?>
			</div>
		</div>
	</div>
	</div>
	<div id="fullbackground"></div>
	<div id="fullcontenthold">
		<div id="fullcontent">
			<div id="closecontainer" name="closefullcontenthold" data-id="theid" class="altcloseposfour"><img src="../images/closefirst.png" title="Close"class="total"/></div>
 			<img src="" name="galleryimgdisplay" title="gallerytitle" />
 			<img src="http://localhost/muyiwasblog/images/waiting.gif" name="fullcontentwait"/>
		</div>
		<div id="fullcontentheader">
			<input type="hidden" name="gallerycount" value="0"/>
			<input type="hidden" name="currentgalleryview" value="0"/>			
		</div>
		<div id="fullcontentdetails">
		</div>

		<div id="fullcontentpointerhold">
			<div id="fullcontentpointerholdholder">
				<div id="fullcontentpointerleft">
					<img src="../images/pointerleft.png" name="pointleft" id="" data-pointer="" class="total"/>
				</div>
				<div id="fullcontentpointerright">
					<img src="../images/pointerright.png" name="pointright" id="" data-pointer="" class="total"/>
				</div>
			</div>
		</div>
	</div>
</body>
</html>