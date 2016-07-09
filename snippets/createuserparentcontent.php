<?php 
	// get the current active content categories
	
	if (isset($_SESSION['userinapstand'])||isset($_SESSION['clientinapstand'])) {
		# code...
		$doform="true";
		$userid=isset($_SESSION['userinapstand'])?$_SESSION['userinapstand']:$_SESSION['clientinapstand'];
		$list=isset($_SESSION['userinapstand'])?"userlist":"clientlist";
		$reallist=isset($_SESSION['userinapstand'])?"userreallist":"clientreallist";
		$userdata=getSingleUserPlain($userid);
		$formdetails='
			<input name="catid" type="hidden" value="'.$userdata['catid'].'"/>
			<input name="'.$list.'" type="hidden" value="yes"/>
			<input name="'.$reallist.'" type="hidden" value="'.$userid.'"/>
		';
	}else{
		$doform="false";

	}
?>
<?php
	if($doform=="true"){
?>
<form name="parentcontentform" action="<?php echo $host_addr;?>snippets/basicsignup.php" method="POST" enctype="multipart/form-data">
	<input name="entryvariant" type="hidden" value="parentcontent"/>
	<div class="box-group" id="contentaccordion">
		<div class="panel box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">
              <a data-toggle="collapse" data-parent="#contentaccordion" href="#headBlock">
                <i class="fa fa-plus"></i>  Create Parent Content
              </a>
            </h4>
          </div>
          <div id="headBlock" class="panel-collapse collapse in">
                <div class="box-body">
                	<div class="col-md-12">
                    	<div class="form-group">
	                      <label>Content Title</label>
	                      <div class="input-group">
		                      <div class="input-group-addon">
		                        <i class="fa fa-file-text"></i>
		                      </div>
	                      	  <input type="text" class="form-control" name="contenttitle" placeholder="Enter category name"/>

	                      </div>
	                    </div>
	                    <p class="help-block">Note, the parent content is the main title and description of a series you want to create.</p>
	                </div>
                	<div class="col-md-12">
		                    <div class="form-group">
		                      <label for="businesslogo">Brief Description</label>
		                      <div class="input-group">
			                      <div class="input-group-addon">
			                        <i class="fa fa-file-text-o"></i>
			                      </div>
			                      <textarea name="description" rows="3" class="form-control" placeholder="A brief description of what this contents entails, a synopsis"></textarea>
			                  </div>
		                    </div>
	                </div>
                	<div class="col-md-12">
	                    <div class="form-group">
	                      <label for="businessbanner">Cover Image</label>
	                      <div class="input-group">
		                      <div class="input-group-addon">
		                        <i class="fa fa-file-image-o"></i>
		                      </div>
		                      <input type="file" name="profpic" class="form-control">
		                  </div>
	                      <p class="help-block">Choose the cover image for this content</p>
	                    </div>
	                </div>
                    <div class="col-md-12">
	        			<div class="box-footer">
							<input name="rettbl" type="hidden" value="users"/>
							<input name="retid" type="hidden" value="<?php echo $userid;?>"/>
							<?php echo $formdetails;?>
		                    <input type="button" class="btn btn-danger" name="createparentcontent" value="Create Parent Content"/>
		                </div>
	            	</div>
                </div>
          </div>
        </div>
	</div>	
</form>
<?php
	}else{
?>
	<div class="box-group" id="contentaccordion">
		<div class="panel box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">
              <a data-toggle="collapse" data-parent="#contentaccordion" href="#headBlock">
                <i class="fa fa-"></i>  Create Parent Content
              </a>
            </h4>
          </div>
          <div id="headBlock" class="panel-collapse collapse in">
                <div class="box-body">
                	<div class="col-md-12">
	                    <p class="help-block">No active profile detected, please log out then login again, your session may have expired</p>
	                </div>
		                
                </div>
          </div>
        </div>
	</div>
<?php 
	}
?>