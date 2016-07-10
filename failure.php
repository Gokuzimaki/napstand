<?php 
session_start();
include('./snippets/connection.php');
$activemainlink8="activemainlink";
$tid="";
$er="";
$msg="";
$demout="";
if(isset($host_vogue_merchantid)&&$host_vogue_merchantid=="demo"){
	$demout="&demo=true";
}
$extraout="An error occured and your transaction was unsuccessfull";
if(isset($_GET['er'])&&isset($_GET['msg'])&&isset($_GET['tid'])){
	$tid=$_GET['tid'];
	$er=$_GET['er'];
	$msg=$_GET['msg'];
	/*if($er=="status"){

	}*/
}else{
	// header('location:onlinestore.php');
}
$mpagefooterclass="hidden";// hide the footer section
include('./snippets/headcontentadmin.php');

?>
  <body class="register-page">
	    <div class="register-box">
	      <div class="register-logo">
	        <a href=""><b>Napstand</b> Purchases</a>
	      </div>
	    </div><!-- /.register-box -->
	    <div class="content-header">
	      <!-- Main content -->
	        <section class="invoice">
	        	<div class="row">
	                <div class="col-md-12 text-center invoice-col">
	                  <?php echo $extraout;?>
	                </div><!-- /.col -->

	              </div><!-- /.row -->
	        </section>
	    <?php include('./snippets/footeradmin.php');?>
	</body>
</html>