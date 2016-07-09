<?php  
session_start();
include('./snippets/connection.php');
if(strpos($host_target_addr, "localhost/")||strpos($host_target_addr, "wamp")){
  	// for local server
	include('./snippets/cronit.php');
}
$logpart=md5($host_addr);
if (isset($_SESSION['logcheck'.$logpart.''])&&$_SESSION['logcheck'.$logpart.'']=="on"||$_SESSION['logcheck'.$logpart.'']==""||!isset($_SESSION['logcheck'.$logpart.''])) {
	header('location:index.php?error=true');
}
$uid=$_SESSION['aduid'.$logpart.'']?$_SESSION['aduid'.$logpart.'']:header('location:index.php?error=nosession');
$alevel=$_SESSION['accesslevel'.$logpart.''];
// echo $_SESSION['logcheck'.$logpart.''];
$mview="";
$sview="";
if(isset($_GET['sview'])&&isset($_GET['mview'])){
				$sview=$_GET['sview'];
				$mview=$_GET['mview'];
				// echo $sview." ".$mview;
}
$userdataout="";
$userdata="";
if(isset($_SESSION['userhnapstand'])){
	$uid=$_SESSION['userinapstand'];
	$userdata=getSingleUserPlain($uid);
}else{
	header('location:login.php');
}
// include('./snippets/useraccessleveloutput.php');
if(!isset($panelcontrolstyle)){
	$panelcontrolstyle=array();
	$panelcontrolstyle['options']="<h4>No priviledges Attached</h4>";
}


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- <link href="<?php echo $host_addr;?>stylesheets/napstandmain.css" rel="stylesheet" type="text/css" /> -->
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
	<link rel="stylesheet" href="<?php echo $host_addr;?>stylesheets/jquery.fileupload.css"/>
	<link rel="stylesheet" href="<?php echo $host_addr;?>stylesheets/jquery.fileupload-ui.css"/>
	<!-- CSS adjustments for browsers with JavaScript disabled -->
	<noscript><link rel="stylesheet" href="<?php echo $host_addr;?>stylesheets/jquery.fileupload-noscript.css"></noscript>
	<noscript><link rel="stylesheet" href="<?php echo $host_addr;?>stylesheets/jquery.fileupload-ui-noscript.css"></noscript>
    <!-- Bootstrap 3.3.2 -->
    <link href="<?php echo $host_addr;?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href='<?php echo $host_addr;?>plugins/select2/dist/css/select2-bootstrap.css' type="text/css"/>
	<link async href="<?php echo $host_addr;?>stylesheets/lightbox.css" rel="stylesheet"/>
	<!-- daterange picker -->
	<link href="<?php echo $host_addr;?>plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
	<!-- daterange picker -->
	<link href="<?php echo $host_addr;?>plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
	<!-- Bootstrap time Picker -->
	<link href="<?php echo $host_addr;?>plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet"/>
	<!-- Bootstrap Date-time Picker -->
	
    <!-- Font Awesome Icons -->
    <link href="<?php echo $host_addr;?>font-awesome/css/font-awesome.min.css" rel="stylesheet"  />
    <!-- Ionicons -->
    <link href="<?php echo $host_addr;?>ionicons/css/ionicons.min.css" rel="stylesheet"  />
    <!-- Select2 (Selcetion customizer) -->
    <link href='<?php echo $host_addr;?>plugins/select2/dist/css/select2.min.css' rel="stylesheet" />
    <!-- Bootstrap datetimepicker -->
    <link href='<?php echo $host_addr;?>plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css' rel="stylesheet" />
    <!-- Jquery Sortable -->
    <link href='<?php echo $host_addr;?>plugins/jquery-sortable/css/jquery-sortable.css' rel="stylesheet" />
    <!-- Theme style -->
    <link href="<?php echo $host_addr;?>dist/css/AdminLTE.min.css" rel="stylesheet"  />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo $host_addr;?>dist/css/skins/_all-skins.min.css" rel="stylesheet"  />
    <link rel="shortcut icon" href="<?php echo $host_addr;?>favicon.ico"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-yellow">
    <!-- Site wrapper -->
    <div class="wrapper">
		<header class="main-header">
		    <a href="index.php" class="logo"><b>NAPSTAND</b></a>
		    <!-- Header Navbar: style can be found in header.less -->
		    <nav class="navbar navbar-static-top" role="navigation">
		      <!-- Sidebar toggle button-->
		      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </a>
		      <div class="navbar-custom-menu">
		            <ul class="nav navbar-nav">
		              <!-- User Account: style can be found in dropdown.less -->
		              <li class="dropdown user user-menu">
			                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			                  <img src="<?php echo $userdata['thumbimage'];?>" class="user-image" alt="User Image"/>
			                  <span class="hidden-xs">
			                      <?php echo $userdata['nameout'];?>
			                  </span>
			                </a>
			                <ul class="dropdown-menu">
			                  <!-- User image -->
			                  <li class="user-header">
			                    <img src="<?php echo $userdata['thumbimage'];?>" class="img-circle" alt="User Image"/>
			                    <p>
			                      <?php echo $userdata['nameout'];?>
			                      <!-- <small>Member since Nov. 2012</small> -->
			                    </p>
			                  </li>
			                  
			                  <!-- Menu Footer-->
			                  <li class="user-footer">
			                    <div class="pull-right">
			                      <a href="<?php echo $host_addr;?>snippets/logout.php?type=<?php echo $userdata['usertype'];?>" class="btn btn-default btn-flat">Sign out</a>
			                    </div>
			                  </li>
			                </ul>
		              </li>
		            </ul>
		      </div>
		    </nav>
		</header>

      <!-- =============================================== -->

      <!-- Left side column. contains the sidebar -->
       	<aside class="main-sidebar">
	        <!-- sidebar: style can be found in sidebar.less -->
	        <section class="sidebar">
	          <!-- Sidebar user panel -->
	          <div class="user-panel">
	            <div class="pull-left image">
	              <img src="<?php echo $userdata['thumbimage'];?>" class="img-circle" alt="User Image" />
	            </div>
	            <div class="pull-left info">
	              <p>
						<?php echo $userdata['nameout'];?>
	              </p>
	            </div>
	          </div>
	          <!-- search form -->
	          
	          <!-- /.search form -->
	          <!-- sidebar menu: : style can be found in sidebar.less -->
	          <ul class="sidebar-menu">
		            <li class="header">MENU</li>
	          		<?php //echo $panelcontrolstyle['options']?>
		            <li class="treeview">
		              <a href="#" appdata-otype="mainlink" appdata-type="menulinkitem" appdata-name="userprofile" appdata-fa='<i class="fa fa-user"></i>' appdata-pcrumb="Profile">
		                <i class="fa fa-user"></i> <span>Profile</span>
		              </a>
		            </li>
		            <li class="treeview">
		              <a href="#" appdata-otype="mainlink">
		                <i class="fa fa-tasks"></i> <span>Content</span> <i class="fa fa-angle-left pull-right"></i>
		              </a>
		              <ul class="treeview-menu">
		                <li><a href="#New" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="newuserparentcontent" appdata-crumb="New Parent Content" appdata-fa='<i class="fa fa-tasks"></i>' appdata-pcrumb="Content"><i class="fa fa-plus"></i> New Parent Content</a></li>
		                <li><a href="#Edit" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="edituserparentcontent" appdata-crumb="Edit Parent Content" appdata-fa='<i class="fa fa-tasks"></i>' appdata-pcrumb="Content"><i class="fa fa-gear"></i> Edit Parent Content</a></li>
		                <li><a href="#Create/Edit Content Entries" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="createneditusercontententries" appdata-crumb="Edit Content" appdata-fa='<i class="fa fa-tasks"></i>' appdata-pcrumb="Content"><i class="fa fa-gears"></i> Create/Edit Content Entries</a></li>
		                <!-- <li><a href="#Statistics" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="viewcontentstatistics" appdata-crumb='Content Stats' appdata-fa='<i class="fa fa-sitemap"></i>' appdata-pcrumb="Content"><i class="fa fa-pie-chart"></i> Content Stats</a></li> -->
		              </ul>
		            </li>
		            
		            
		            <!-- <li class="treeview">
		              <a href="#" appdata-otype="mainlink">
		                <i class="fa fa-question"></i> <span>FAQ</span> <i class="fa fa-angle-left pull-right"></i>
		              </a>
		              <ul class="treeview-menu">
		                <li><a href="#New" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="newfaq" appdata-crumb="New FAQ" appdata-fa='<i class="fa fa-question"></i>' appdata-pcrumb="Frequently Asked Questions"><i class="fa fa-plus"></i> New FAQ</a></li>
		                <li><a href="#Edit" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="editfaq" appdata-crumb="Edit FAQ" appdata-fa='<i class="fa fa-question"></i>' appdata-pcrumb="Frequently Asked Questions"><i class="fa fa-gear"></i> Edit FAQ</a></li>
		              </ul>
		            </li> -->
		            <!-- <li class="treeview">
		              <a href="#" appdata-otype="mainlink" >
		                <i class="fa fa-sliders"></i> <span>Blog Type</span> <i class="fa fa-angle-left pull-right"></i>
		              </a>
		              <ul class="treeview-menu">
		                <li><a href="#New" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="newblogtype" appdata-fa='<i class="fa fa-sliders"></i>' appdata-pcrumb="Blog Type"><i class="fa fa-plus"></i> New</a></li>
		                <li><a href="#Edit" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="editblogtype" appdata-fa='<i class="fa fa-sliders"></i>' appdata-pcrumb="Blog Type"><i class="fa fa-gear"></i> Edit</a></li>
		              </ul>
		            </li>
		            <li class="treeview">
		              <a href="#" appdata-otype="mainlink" >
		                <i class="fa fa-sitemap"></i> <span>Blog Category</span> <i class="fa fa-angle-left pull-right"></i>
		              </a>
		              <ul class="treeview-menu">
		                <li><a href="#New" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="newblogcategory" appdata-fa='<i class="fa fa-sitemap"></i>' appdata-pcrumb="Blog Category"><i class="fa fa-plus"></i> New</a></li>
		                <li><a href="#Edit" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="editblogcategory" appdata-fa='<i class="fa fa-sitemap"></i>' appdata-pcrumb="Blog Category"><i class="fa fa-gear"></i> Edit</a></li>
		              </ul>
		            </li>
		            <li class="treeview">
		              <a href="#" appdata-otype="mainlink" >
		                <i class="fa fa-newspaper-o"></i> <span>Blog Post</span> <i class="fa fa-angle-left pull-right"></i>
		              </a>
		              <ul class="treeview-menu">
		                <li><a href="#New" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="newblogpost" appdata-fa='<i class="fa fa-text"></i>' appdata-pcrumb="Blog Post"><i class="fa fa-plus"></i> New</a></li>
		                <li><a href="#Edit" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="editblogposts" appdata-fa='<i class="fa fa-text"></i>' appdata-pcrumb="Blog Post"><i class="fa fa-gear"></i> Edit</a></li>
		              </ul>
		            </li>
		            <li class="treeview">
		              <a href="#" appdata-otype="mainlink" >
		                <i class="fa fa-comment-o"></i> <span>Comments</span> 
			                <?php echo $fullcomout;?>
		                <i class="fa fa-angle-left pull-right"></i>
		              </a>
		              <ul class="treeview-menu">
		                <li><a href="#AllComments" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="allcomments" appdata-fa='<i class="fa fa-comments-o"></i>' appdata-pcrumb="Comments"><i class="fa fa-cubes"></i> All</a></li>
		                <li><a href="#ActiveComments" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="activecomments" appdata-fa='<i class="fa fa-comments-o"></i>' appdata-pcrumb="Comments"><i class="fa fa-asterisk"></i> Active</a></li>
		                <li><a href="#PendingComments" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="inactivecomments" appdata-fa='<i class="fa fa-comments-o"></i>' appdata-pcrumb="Comments"><i class="fa fa-clock-o"></i> Pending</a></li>
		                <li><a href="#EDisabledcomments" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="disabledcomments" appdata-fa='<i class="fa fa-comments-o"></i>' appdata-pcrumb="Comments"><i class="fa fa-ban"></i> Disabled</a></li>
		              </ul>
		            </li> -->
		            <li class="treeview">
		              <a href="<?php echo $host_addr;?>snippets/logout.php?type=user" appdata-otype="mainlink" appdata-type="menulinkitem" appdata-name="logout">
		                <i class="fa fa-sign-out"></i> <span>Logout</span>
		              </a>
		            </li>
	          </ul>
	        </section>
	        <!-- /.sidebar -->
      	</aside>

      <!-- =============================================== -->

      <!-- Right side column. Contains the navbar and content of the page -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1 appdata-name="notifylinkheader">
            Welcome
            <small>Administrator</small>
          </h1>
          <ol class="breadcrumb" appdata-name="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- end last surveys taken box -->
          <!-- sTATS box -->
          <div class="box">
	            <div class="box-header with-border">
	              <h3 class="box-title">General Stats</h3>
	              <div class="box-tools pull-right">
	                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
	                <!-- <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
	              </div>
	            </div>
	            <div class="box-body">
	            	<?php
	            		/*$str='./images/fname.jpeg';
	            		$exts='jpg|.jpg|jpeg|.jpeg|png|.png|.svg|svg|gif|.gif';
	            		// $pattern='/(jpg|.jpg|jpeg|.jpeg|png|.png|.svg|svg|gif|.gif)/';
	            		$pattern='/('.$exts.')/';
	            		$matchout=preg_match($pattern, $str,$match);
	            		if(count($match)>0){
	            			echo "match found".$match[0];
	            		}else{
	            			echo "No match found";
	            		}*/
	            		/*$outimgs="No images";
	            		$outtest=sortThroughDir('<?php echo $host_addr;?>files/archives/test/temp/','jpg|.jpg|jpeg|.jpeg|png|.png|.svg|svg|gif|.gif',"plainsort");
	            		if($outtest['totalmatches']>0){
		            		$outimgs="";
	            			for($i=0;$i<$outtest['totalmatches'];$i++){
        						list($testwidth,$testheight)=getimagesize($outtest['matchedfilespath'][$i]);
        						$imagesize=filesize($outtest['matchedfilespath'][$i]);
        						$sortedsize=fileSizeConvert($imagesize);
        						$sortedsizemb=fileSizeConvert($imagesize,"MB");
	            				$outimgs.='
	            				<p>
	            					'.$outtest['matchedfiles'][$i].'
	            					'.$imagesize.'<br>
	            					'.$sortedsize.'<br>
	            					'.$sortedsizemb.'<br>
	            				</p>';

	            			}
	            			
	            		}
	            		echo $outimgs;*/
	            		$indicesServer = array('PHP_SELF', 
						'argv', 
						'argc', 
						'GATEWAY_INTERFACE', 
						'SERVER_ADDR', 
						'SERVER_NAME', 
						'SERVER_SOFTWARE', 
						'SERVER_PROTOCOL', 
						'REQUEST_METHOD', 
						'REQUEST_TIME', 
						'REQUEST_TIME_FLOAT', 
						'QUERY_STRING', 
						'DOCUMENT_ROOT', 
						'HTTP_ACCEPT', 
						'HTTP_ACCEPT_CHARSET', 
						'HTTP_ACCEPT_ENCODING', 
						'HTTP_ACCEPT_LANGUAGE', 
						'HTTP_CONNECTION', 
						'HTTP_HOST', 
						'HTTP_REFERER', 
						'HTTP_USER_AGENT', 
						'HTTPS', 
						'REMOTE_ADDR', 
						'REMOTE_HOST', 
						'REMOTE_PORT', 
						'REMOTE_USER', 
						'REDIRECT_REMOTE_USER', 
						'SCRIPT_FILENAME', 
						'SERVER_ADMIN', 
						'SERVER_PORT', 
						'SERVER_SIGNATURE', 
						'PATH_TRANSLATED', 
						'SCRIPT_NAME', 
						'REQUEST_URI', 
						'PHP_AUTH_DIGEST', 
						'PHP_AUTH_USER', 
						'PHP_AUTH_PW', 
						'AUTH_TYPE', 
						'PATH_INFO', 
						'ORIG_PATH_INFO') ; 

						/*echo '<table cellpadding="10">' ; 
						foreach ($indicesServer as $arg) { 
						    if (isset($_SERVER[$arg])) { 
						        echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ; 
						    } 
						    else { 
						        echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ; 
						    } 
						} 
						echo '</table>' ; */
						// echo "$host_addr <-hta";
	            		// echo $fulloutput;
	            	?>
	            </div><!-- /.box-body -->
	            <div class="box-footer">
	              These are the lastest general statistics available
	            </div><!-- /.box-footer-->
          </div><!-- /.box -->
          <!-- Stats Box end -->
          <!-- form box start -->
          	
			
          <!-- form box end -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <!-- General Modal display section -->
      <div id="mainPageModal" class="modal fade" data-backdrop="false" data-show="true" data-role="dialog">
      	<div class="modal-dialog">
      		<div class="modal-content">
		      	<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
					<h4 class="modal-title">Message</h4>
		        </div>
		      	<div class="modal-body">

		      	</div>
		      	<div class="modal-footer">
		      		<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
		      	</div>
		    </div>
      	</div>
      </div>
      <!-- end modal display -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Administrator Central.</b>
        </div>
        <strong>Copyright &copy; 2014-<?php echo date('Y');?> <a href="index.php">Napstand</a>.</strong> All rights reserved. Developed by Okebukola Olagoke.
      </footer>
    </div><!-- <?php echo $host_addr;?>wrapper -->

    <!-- jQuery 2.1.3 -->
    <script src="<?php echo $host_addr;?>plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo $host_addr;?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo $host_addr;?>scripts/js/jquery.jplayer.min.js"></script>
	<script src="<?php echo $host_addr;?>scripts/js/vendor/jquery.ui.widget.js"></script>
    <script src="<?php echo $host_addr;?>scripts/mylib.js" type="text/javascript"></script>
    <script src="<?php echo $host_addr;?>scripts/formchecker.js" type="text/javascript"></script>
    <!-- Select2 (Selcetion customizer) -->
    <script src='<?php echo $host_addr;?>plugins/select2/dist/js/select2.full.min.js'></script>
    <!-- Bootpag (oostrap paginator) -->
    <script src='<?php echo $host_addr;?>plugins/bootpag/jquery.bootpag.min.js'></script>
    <!-- SlimScroll -->
    <script src="<?php echo $host_addr;?>plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='<?php echo $host_addr;?>plugins/fastclick/fastclick.min.js'></script>
    <!-- InputMask -->
    <script src="<?php echo $host_addr;?>plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="<?php echo $host_addr;?>plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
    <!-- date-range-picker -->
    <script src="<?php echo $host_addr;?>plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="<?php echo $host_addr;?>plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <!-- date-picker -->
    <script src="<?php echo $host_addr;?>plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- bootstrap time picker -->
    <script src="<?php echo $host_addr;?>plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <!-- Moment js -->
    <script src="<?php echo $host_addr;?>plugins/moment/moment.js" type="text/javascript"></script>
    <!-- bootstrap Date-time picker -->
    <script src="<?php echo $host_addr;?>plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <!-- iCheck 1.0.1 -->
    <script src="<?php echo $host_addr;?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>

    <script src="<?php echo $host_addr;?>plugins/knob/jquery.knob.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="<?php echo $host_addr;?>plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- Jquery Sortable  -->
    <script src="<?php echo $host_addr;?>plugins/jquery-sortable/js/jquery-sortable.js" type="text/javascript"></script>
    <!-- RubaXa Sortable -->
	<script src="<?php echo $host_addr;?>plugins/rubaxa-sortable/js/Sortable.js"></script>
    
	
	<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
	<!--[if (gte IE 8)&(lt IE 10)]>
	<script src="js/cors/jquery.xdr-transport.js"></script>
	<![endif]-->
	<!-- end -->
    <!-- AdminLTE App -->
    <script src="<?php echo $host_addr;?>dist/js/app.js" type="text/javascript"></script>
    <script src="<?php echo $host_addr;?>scripts/lightbox.js" type="text/javascript"></script>
    <script src="<?php echo $host_addr;?>scripts/napstandadmin.js" type="text/javascript"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $host_addr;?>scripts/js/tinymce/jquery.tinymce.min.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo $host_addr;?>scripts/js/tinymce/tinymce.min.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo $host_addr;?>scripts/js/tinymce/basic_config.js"></script>
  </body>
</html>