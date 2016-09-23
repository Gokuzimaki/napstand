<?php  
session_start();
include('../snippets/connection.php');
$activepage_type="admin";
$activepage=0;
if(isset($host_admin_cron)&&$host_admin_cron=="on"){
  	// for local server
	include('../snippets/cronit.php');
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
$uservice="none";
$ubookings="none";
$utestimony="none";
$umessages="none";
$ucomments="none";
// echo md5(3);
$comquery="SELECT * FROM comments WHERE status='inactive'";
$comrun=mysql_query($comquery)or die(mysql_error()." Line 16");
$comrows=mysql_num_rows($comrun);
$comrows>0?$ucomments="":$ucomments=$ucomments;
$fullcomout=$comrows>0?'<small class="label pull-right bg-red mainsmall">'.$comrows.'</small>':"";

// $admindata=getAdmin($uid);
$admindata=getSingleAdminUser($uid);
include('../snippets/useraccessleveloutput.php');
if(!isset($panelcontrolstyle)){
	$panelcontrolstyle=array();
	$panelcontrolstyle['options']="<h4>No priviledges Attached</h4>";
}
/*$fulloutput="";
$path='../files/archives/napstandtestphotos.zip';
$basepath='../files/archives/test/';
$zip = new ZipArchive;
$res = $zip->open($path);
$temppath='../files/archives/test/temp/';
if ($res === TRUE) {
    // extract the images from the archive to a temppath
    $zip->extractTo($temppath);
    $zip->close();
    $outextract=sortThroughDir("$temppath",'jpg|.jpg|jpeg|.jpeg|png|.png|.svg|svg|gif|.gif',"plainsort");
    if($outextract['totalmatches']>0){
		$outimgs="";
		for($i=0;$i<$outextract['totalmatches'];$i++){
			$fulloutput.='<p>'.$outextract['matchedfiles'][$i].'</p>';
			$imagedata[0]=$outextract['matchedfiles'][$i]; // image name
			$imagedata[1]=$outextract['matchedfilespath'][$i]; // image path (img data)
			$imagedata[2]=filesize($outextract['matchedfilespath'][$i]); //imagesize
			$imagedata[3]="image/".$outextract['matchedfiles'][$i];
			$extension=getExtension($outextract['matchedfiles'][$i]);
	        // proceed to get the image data by running through the tempdir iterating over 
	        // each valid image entry
	        $imgpath[0]=''.$basepath.'originals/';
	        $imgpath[1]=''.$basepath.'medsizes/';
	        $imgpath[2]=''.$basepath.'thumbnails/';

	        $imgsize[0]="default";
	        $imgsize[1]=",400";
	        $imgsize[2]=",150";

	        $acceptedsize="";
	        $imgouts=genericImageUpload($imagedata,"varying",$imgpath,$imgsize,$acceptedsize);

	        $len=strlen($imgouts[0]);
	        $imagepath=substr($imgouts[0], 1,$len);
	        $filesize=fileSizeConvert($imagedata[2]);

	        // medium size 
	        $len2=strlen($imgouts[1]);
	        $imagepath2=substr($imgouts[1], 1,$len2);

	        // thumb size
	        $len3=strlen($imgouts[2]);
	        $imagepath3=substr($imgouts[2], 1,$len3);
	        $fulloutput.='
		        <p>
		        	'.$imagepath.'<br>
		        	'.$imagepath2.'<br>
		        	'.$imagepath3.'<br>
		        	'.$filesize.'<br>
		        </p>
		    ';
		}
	}
	// echo $fulloutput;
} else {
    $fulloutput.= 'extraction error';
}*/
// $userdata=getAllUsers("admin","");

// $clientdata=getAllClients("admin","");

// $surveydata=getAllSurvey("admin","","","");


?>
<?php include('../snippets/headcontentadmin.php');?>

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
			                  <img src="<?php echo $admindata['absolutecover'];?>" class="user-image" alt="User Image"/>
			                  <span class="hidden-xs">
			                      <?php echo $admindata['fullname'];?>
			                  </span>
			                </a>
			                <ul class="dropdown-menu">
			                  <!-- User image -->
			                  <li class="user-header">
			                    <img src="<?php echo $admindata['absolutecover'];?>" class="img-circle" alt="User Image"/>
			                    <p>
			                      <?php echo $admindata['fullname'];?>
			                      <!-- <small>Member since Nov. 2012</small> -->
			                    </p>
			                  </li>
			                  
			                  <!-- Menu Footer-->
			                  <li class="user-footer">
			                    <div class="pull-right">
			                      <a href="../snippets/logout.php?type=admin" class="btn btn-default btn-flat">Sign out</a>
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
	              <img src="<?php echo $admindata['absolutecover'];?>" class="img-circle" alt="User Image" />
	            </div>
	            <div class="pull-left info">
	              <p>
						<?php echo $admindata['fullname'];?>
	              </p>
	            </div>
	          </div>
	          <!-- search form -->
	          <form action="#" method="get" name="mainsearchform" class="sidebar-form">
		            <div class="input-group">
		              <input type="text" name="q" class="form-control" placeholder="Search..."/>
		              <span class="input-group-btn">
		                <button type='button' name='mainsearch' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
		              </span>
		            </div>
		            <div class="input-group">
	                    <div class="input-group-btn">
	                      <button type="button" class="btn btn-warning dropdown-toggle customsearchbtn" data-name="searchbyspace" data-toggle="dropdown" aria-expanded="false">Search By <span class="fa fa-caret-down"></span></button>
	                      <input type="hidden" name="searchby" value=""/>
	                      <ul class="dropdown-menu customdrop" data-type="appsearchbyoption">
	                        <li><a href="##Search" data-name="mainsearchbyoption" data-value="username" data-placeholder="The name of a user">User Name</a></li>
	                        <li><a href="##Search" data-name="mainsearchbyoption" data-value="paidorfree" data-placeholder="paid or free">Content Paid/Inactive</a></li>
	                        <li><a href="##Search" data-name="mainsearchbyoption" data-value="clientname" data-placeholder="Client Name">Client</a></li>
	                        <li><a href="##Search" data-name="mainsearchbyoption" data-value="clientnamecontent" data-placeholder="Client Name here">Client(Content view)</a></li>
	                        <li><a href="##Search" data-name="mainsearchbyoption" data-value="username" data-placeholder="Firstname Othernames">User Name</a></li>
	                        <li><a href="##Search" data-name="mainsearchbyoption" data-value="useremail" data-placeholder="Place User email">User Email</a></li>
	                        <li><a href="##Search" data-name="mainsearchbyoption" data-value="usernamecontent" data-placeholder="User Name here, email also allowed">Users (Content view)</a></li>
	                        <!-- <li><a href="##Search" data-name="mainsearchbyoption" data-value="orgname" data-placeholder="Organisation Name">Organisation Name</a></li> -->
	                        <!-- <li><a href="##Search" data-name="mainsearchbyoption" data-value="blogtitle" data-placeholder="Blog title Search...">Blog Title</a></li> -->
	                        <!-- <li><a href="##Search" data-name="mainsearchbyoption" data-value="blogintro" data-placeholder="Intro Paragraph Search...">Blog Intro</a></li>                         -->
	                        <!-- <li><a href="##Search" data-name="mainsearchbyoption" data-value="blogentry" data-placeholder="Blog Post Search...">Blog Post</a></li>                         -->
	                        <!-- <li class="divider"></li>
	                        <li><a href="#">Separated link</a></li> -->
	                      </ul>
	                    </div>
	                </div>
	          </form>
	          <!-- /.search form -->
	          <!-- sidebar menu: : style can be found in sidebar.less -->
	          <ul class="sidebar-menu">
		            <li class="header">MENU</li>
	          		<?php echo $panelcontrolstyle['options']?>
		            
		            <li class="treeview">
		              <a href="../snippets/logout.php?type=admin" appdata-otype="mainlink" appdata-type="menulinkitem" appdata-name="logout">
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
	            	<!-- <select class="form-control" name="testdropdown">
            			<option value="some text" data-image="../images/default.gif">A val one</option>
            			<option value="no text" data-image="../images/facebookshareimg.jpg">A val two</option>
            			<option value="great text" data-image="../images/imgdisp.jpg">A val three</option>
            			<option value="made text" data-image="../images/default.gif">A val four</option>
            		</select> -->
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
	            		$outtest=sortThroughDir('../files/archives/test/temp/','jpg|.jpg|jpeg|.jpeg|png|.png|.svg|svg|gif|.gif',"plainsort");
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
							'ORIG_PATH_INFO') 
	            		; 

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
      <!-- wrapper closing div present in footer admin file -->
	  <?php include('../snippets/themescriptsdumpadmin.php');?>
	  	<script>
			$(document).ready(function(){
				$('select[name=testdropdown]').msDropdown();
			});
		</script>
  </body>
</html>