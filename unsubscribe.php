<?php 
session_start();
include('./snippets/connection.php');
if(isset($_GET['t'])&&isset($_GET['tp'])&&is_numeric($_GET['t'])&&$_GET['t']>0&&$_GET['t']<3&&is_numeric($_GET['tp'])){
if($_GET['t']==1){
$type="unsubscribeblogtype";
}else{
$type="unsubscribeblogcategory";	
}
$extraid=$_GET['tp'];
// $userid=$_GET['eu'];
}else{
	header('location:index.php');
}
?>
<!DOCTYPE html/>
<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Unsubscribe</title>
<meta name="description" content="">
<meta name="keywords" content=""/>
<link rel="stylesheet" href="./stylesheets/muyiwamain.css"/>
<link rel="shortcut icon" type="image/" href="./images/muyiwaslogo.png"/>
<script src="./scripts/jquery.js"></script>
<script src="./scripts/mylib.js"></script>
<script src="./scripts/muyiwaadmin.js"></script>
<script src="./scripts/formchecker.js"></script>
<script language="javascript" type="text/javascript" src="./scripts/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="./scripts/jscripts/tiny_mce/basic_config.js"></script>
</head>
<body>
	<div id="main">
	<div id="toppanel">
				<div id="mainlogopanel">
			<div id="mainimglogo" style="position:relative;width: 228px;height: 229px;top:0px;left:0px;">
				<?php include('./snippets/muyiwalogocontrol.php');?>
				
			</div>
		</div>
	</div>
<!-- the page gets trhe blogtype id and bo -->
<?php
isset($_GET['blogid'])?$blogtypeid=$_GET['blogid']:$blogtypeid="theblogid";
?>
<div id="contentpanel">
	<div id="form" style="background-color:#fefefe;">
		<form action="./snippets/edit.php" name="unsubscribe" method="post">
			<input type="hidden" name="entryvariant" value="unsubscribe"/>
			<div id="formheader">Unsubscribe</div>
			* means the field is required.
			<div id="formend">
				<input type="hidden" name="entryvariant" value="<?php echo $type?>">
				<input type="hidden" name="typeid" value="<?php echo $extraid?>">
				<input type="hidden" name="entryid" value="0">
					Email *
					<input type="text" name="email" Placeholder="Your email here" class="curved"/>


			</div>

			<div id="formend">
				<input type="button" name="unsubscribe" value="Submit" class="submitbutton"/>
			</div>
		</form>
	</div>
</div>
	<div id="footerpanel">
		<div id="footerpanelcontent">
			<div id="copyright">
	<?php include('./snippets/footer.php');?>
			</div>
		</div>
	</div>
	</div>
</body>
</html>