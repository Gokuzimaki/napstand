<?php
	// menu option block
	$uservice="none";
	$ubookings="none";
	$utestimony="none";
	$umessages="none";
	$ucomments="none";
	// echo md5(3);
	/*Options
	* 1 = create/edit user
	* 2 = create/edit Home
	* 3 = create/edit General Info
	* 4 = create/edit NYSC Branches
	* 5 = create/edit CDS Projects
	* 6 = create/edit SAED
	* 7 = create/edit NYSC Gallery
	* 8 = create/edit faq
	* 9 = create/edit blogtype
	* 10 = create/edit blogcategory
	* 11 = create/edit blogpost
	* 12 = create/edit comments
	*/
  /*User Access Levels
  * 0 = Super User
  * 1 = Napstand User
  */
  // Search options
  
	$optioncount=12;
  $suboptioncount=26;
  $styleout=array();
  $substyleout=array(); //for hiding suboptions
  // set the default access levels
  for($i=1;$i<=$optioncount;$i++){
    $styleout[$i]='';
  }
  for($i=1;$i<=$suboptioncount;$i++){
    $substyleout[$i]='';
  }
  // get current admin info and set priiledges
  $accesslevel=$admindata['accesslevel'];
  $comdata=getAllComments("inactivecount","","");
  $comrows=$comdata['countout'];
  $comrows>0?$ucomments="":$ucomments=$ucomments;
  $fullcomout=$comrows>0?'<small class="label pull-right bg-red mainsmall">'.$comrows.'</small>':"";

  /*Priviledge block
  * Simply control the block by setting the values of the array with the "style="display:none;" value"
  * and the rest is history
  */
  if($accesslevel==0){
    $styleout[8]='style="display:none;"';
    $styleout[9]='style="display:none;"';
    $styleout[10]='style="display:none;"';
    $styleout[11]='style="display:none;"';
    $styleout[12]='style="display:none;"';
  }else if ($accesslevel==1) {
    # code...
    // $styleout[1]='style="display:none;"';
    // $styleout[2]='style="display:none;"';
    // $styleout[3]='style="display:none;"';
    // $styleout[4]='style="display:none;"';
    // $styleout[5]='style="display:none;"';
    // $styleout[6]='style="display:none;"';
    // $styleout[8]='style="display:none;"';
    // $styleout[9]='style="display:none;"';
    // $styleout[12]='style="display:none;"';

  }else if ($accesslevel==2) {
    # code...
    $styleout[1]='style="display:none;"';
    $styleout[2]='style="display:none;"';
    $styleout[3]='style="display:none;"';
    $styleout[4]='style="display:none;"';
    // $styleout[5]='style="display:none;"';
    $styleout[6]='style="display:none;"';
    $styleout[8]='style="display:none;"';
    $styleout[7]='style="display:none;"';
    $styleout[9]='style="display:none;"';
    $styleout[10]='style="display:none;"';
    $styleout[11]='style="display:none;"';
    $styleout[12]='style="display:none;"';


  }else if ($accesslevel==3) {
    # code...
    $styleout[1]='style="display:none;"';
    $styleout[2]='style="display:none;"';
    $styleout[3]='style="display:none;"';
    $styleout[4]='style="display:none;"';
    $styleout[5]='style="display:none;"';
    // $styleout[6]='style="display:none;"';
    $styleout[8]='style="display:none;"';
    $styleout[7]='style="display:none;"';
    $styleout[9]='style="display:none;"';
    $styleout[10]='style="display:none;"';
    $styleout[11]='style="display:none;"';
    $styleout[12]='style="display:none;"';
  }
	$panelcontrolstyle['options']='
		<li class="treeview" '.$styleout[1].'>
      <a href="#" appdata-otype="mainlink" appdata-type="">
        <i class="fa fa-users"></i> <span>Admin Users</span> <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li><a href="#New" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="newadminuser" appdata-crumb=\'Edit Admin Users\' appdata-fa=\'<i class="fa fa-user"></i>\' appdata-pcrumb="Admin User"><i class="fa fa-plus"></i> New</a></li>
        <li><a href="#Edit" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="editadminuser" appdata-crumb=\'Edit Admin Users\' appdata-fa=\'<i class="fa fa-user"></i>\' appdata-pcrumb="Admin User"><i class="fa fa-gear"></i> Edit</a></li>
      </ul>
    </li>
    <li class="treeview" '.$styleout[2].'>
      <a href="#" appdata-otype="mainlink" appdata-type="">
      <i class="fa fa-sitemap"></i> <span>Content Category\'s</span> <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">  
        <li><a href="#New" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="newcontentcategory" appdata-crumb=\'New Content Category\' appdata-fa=\'<i class="fa fa-sitemap"></i>\' appdata-pcrumb="Content Category"><i class="fa fa-plus"></i> New</a></li>
        <li><a href="#Edit" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="editcontentcategory" appdata-crumb=\'Edit Content Category\' appdata-fa=\'<i class="fa fa-sitemap"></i>\' appdata-pcrumb="Content Category"><i class="fa fa-gear"></i> Edit</a></li>
        <li><a href="#CategoryMurals" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="categorymurals" appdata-crumb=\'Create/Edit Murals\' appdata-fa=\'<i class="fa fa-file-image-o"></i>\' appdata-pcrumb="Content Category"><i class="fa fa-gear"></i> Create/Edit Mural</a></li>
      </ul>
    </li>
    <li class="treeview" '.$styleout[3].'>
        <a href="#" appdata-otype="mainlink">
          <i class="fa fa-tasks"></i> <span>Content</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><a href="#New" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="newparentcontent" appdata-crumb="New Parent Content" appdata-fa=\'<i class="fa fa-tasks"></i>\' appdata-pcrumb="Content"><i class="fa fa-plus"></i> New Parent Content</a></li>
          <li><a href="#Edit" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="editparentcontentadmin" appdata-crumb="Edit Parent Content" appdata-fa=\'<i class="fa fa-tasks"></i>\' appdata-pcrumb="Content"><i class="fa fa-gear"></i> Edit Parent Content</a></li>
          <li><a href="#Create/Edit Content Entries" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="createneditcontententries" appdata-crumb="Edit Content" appdata-fa=\'<i class="fa fa-tasks"></i>\' appdata-pcrumb="Content"><i class="fa fa-gears"></i> Create/Edit Content Entries</a></li>
          <li><a href="#Statistics" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="viewcontentstatistics" appdata-crumb=\'Content Stats\' appdata-fa=\'<i class="fa fa-sitemap"></i>\' appdata-pcrumb="Content"><i class="fa fa-pie-chart"></i> Content Stats</a></li>
        </ul>
    </li>
    <li class="treeview" '.$styleout[4].'>
      <a href="#" appdata-otype="mainlink" appdata-type="">
        <i class="fa fa-briefcase"></i> <span>Clients</span> <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li><a href="#New" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="newclient" appdata-crumb=\'New Client\' appdata-fa=\'<i class="fa fa-briefcase"></i>\' appdata-pcrumb="Client"><i class="fa fa-plus"></i> New</a></li>
        <li><a href="#Edit" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="editclient" appdata-crumb=\'Edit Client\' appdata-fa=\'<i class="fa fa-briefcase"></i>\' appdata-pcrumb="Client"><i class="fa fa-gear"></i> Edit</a></li>
      </ul>
    </li>
    <li class="treeview" '.$styleout[5].'>
      <a href="#" appdata-otype="mainlink" appdata-type="">
      <i class="fa fa-user"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li><a href="#New" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="createuseradmin" appdata-crumb=\'New User\' appdata-fa=\'<i class="fa fa-user"></i>\' appdata-pcrumb="User"><i class="fa fa-plus"></i> New</a></li>
        <li><a href="#Edit" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="edituseradmin" appdata-crumb=\'Edit User\' appdata-fa=\'<i class="fa fa-user"></i>\' appdata-pcrumb="User"><i class="fa fa-gear"></i> Edit</a></li>
      </ul>
    </li>
    <li class="treeview" '.$styleout[6].'>
      <a href="#" appdata-otype="mainlink" appdata-type="">
      <i class="fa fa-user"></i> <span>App Users</span> <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li><a href="#New" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="newappuser" appdata-crumb=\'New App User\' appdata-fa=\'<i class="fa fa-user"></i>\' appdata-pcrumb="App Users"><i class="fa fa-plus"></i> New</a></li>
        <li><a href="#Edit" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="editappuser" appdata-crumb=\'Edit App User\' appdata-fa=\'<i class="fa fa-user"></i>\' appdata-pcrumb="App Users"><i class="fa fa-gear"></i> Edit</a></li>
      </ul>
    </li>
    <li class="treeview" '.$styleout[7].'>
      <a href="#" appdata-otype="mainlink">
        <i class="fa fa-question"></i> <span>FAQ</span> <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li><a href="#New" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="newfaq" appdata-crumb="New FAQ" appdata-fa=\'<i class="fa fa-question"></i>\' appdata-pcrumb="Frequently Asked Questions"><i class="fa fa-plus"></i> New FAQ</a></li>
        <li><a href="#Edit" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="editfaq" appdata-crumb="Edit FAQ" appdata-fa=\'<i class="fa fa-question"></i>\' appdata-pcrumb="Frequently Asked Questions"><i class="fa fa-gear"></i> Edit FAQ</a></li>
      </ul>
    </li>
    <li class="treeview" '.$styleout[8].'>
      <a href="#" appdata-otype="mainlink" >
        <i class="fa fa-sliders"></i> <span>Blog Type</span> <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li><a href="#New" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="newblogtype" appdata-fa=\'<i class="fa fa-sliders"></i>\' appdata-pcrumb="Blog Type"><i class="fa fa-plus"></i> New</a></li>
        <li><a href="#Edit" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="editblogtype" appdata-fa=\'<i class="fa fa-sliders"></i>\' appdata-pcrumb="Blog Type"><i class="fa fa-gear"></i> Edit</a></li>
      </ul>
    </li>
    <li class="treeview" '.$styleout[9].'>
      <a href="#" appdata-otype="mainlink" >
        <i class="fa fa-sitemap"></i> <span>Blog Category</span> <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li><a href="#New" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="newblogcategory" appdata-fa=\'<i class="fa fa-sitemap"></i>\' appdata-pcrumb="Blog Category"><i class="fa fa-plus"></i> New</a></li>
        <li><a href="#Edit" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="editblogcategory" appdata-fa=\'<i class="fa fa-sitemap"></i>\' appdata-pcrumb="Blog Category"><i class="fa fa-gear"></i> Edit</a></li>
      </ul>
    </li>
    <li class="treeview" '.$styleout[10].'>
      <a href="#" appdata-otype="mainlink" >
        <i class="fa fa-newspaper-o"></i> <span>Blog Post</span> <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li><a href="#New" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="newblogpost" appdata-fa=\'<i class="fa fa-text"></i>\' appdata-pcrumb="Blog Post"><i class="fa fa-plus"></i> New</a></li>
        <li><a href="#Edit" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="editblogposts" appdata-fa=\'<i class="fa fa-text"></i>\' appdata-pcrumb="Blog Post"><i class="fa fa-gear"></i> Edit</a></li>
      </ul>
    </li>
    <li class="treeview" '.$styleout[11].'>
      <a href="#" appdata-otype="mainlink" >
        <i class="fa fa-comment-o"></i> <span>Comments</span> '.$fullcomout.'<i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li><a href="#AllComments" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="allcomments" appdata-fa=\'<i class="fa fa-comments-o"></i>\' appdata-pcrumb="Comments"><i class="fa fa-cubes"></i> All</a></li>
        <li><a href="#ActiveComments" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="activecomments" appdata-fa=\'<i class="fa fa-comments-o"></i>\' appdata-pcrumb="Comments"><i class="fa fa-asterisk"></i> Active</a></li>
        <li><a href="#PendingComments" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="inactivecomments" appdata-fa=\'<i class="fa fa-comments-o"></i>\' appdata-pcrumb="Comments"><i class="fa fa-clock-o"></i> Pending</a></li>
        <li><a href="#EDisabledcomments" appdata-otype="sublink" appdata-type="menulinkitem" appdata-name="disabledcomments" appdata-fa=\'<i class="fa fa-comments-o"></i>\' appdata-pcrumb="Comments"><i class="fa fa-ban"></i> Disabled</a></li>
      </ul>
    </li>

	';
?>