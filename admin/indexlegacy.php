<?php 
session_start();
include('../snippets/connection.php');
?>
<!DOCTYPE html/>
<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Default home</title>
<meta name="description" content="">
<meta name="keywords" content=""/>
<link rel="stylesheet" href="../stylesheets/"/>
<link rel="shortcut icon" type="image/" href="../images/"/>
<script src="../scripts/jquery.js"></script>
<script src="../scripts/mylib.js"></script>
<script src="../scripts/muyiwasblog.js"></script>
<script src="../scripts/formchecker.js"></script>
</head>
<body>
	<div id="main">
	<div id="toppanel">

	</div>

<div id="contentpanel">
		<div id="logincontent">
			<h2>ADMIN LOGIN</h2>
			<form name="adminloginform" action="../snippets/basiclog.php" method="POST">
				<input type="hidden" name="logtype" value="adminlogin">
				Username:
				<div id="formend">					
				<input class="curved" type="text" name="username"/>
				</div><br>
				Password:
				<div id="formend">					
					<input class="curved" type="password" name="password"/>
				</div>
				<div id="formend">
					<input class="submitbutton" type="button" name="adminloginsubmit" value="Login"/>
				</div>
			</form>
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
</body>
</html>