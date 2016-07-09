<?php 
	// get the current active content categories
	$outs=getAllContentCategory("viewer","all");
?>
<form name="parentcontentform" action="../snippets/basicsignup.php" method="POST" enctype="multipart/form-data">
	<input name="entryvariant" type="hidden" value="parentcontent"/>
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
                		<div class="form-group">   
	                      <label>Content Category</label>
	                      <div class="input-group">
		                      <div class="input-group-addon">
		                        <i class="fa fa-bars"></i>
		                      </div>
		                      <select id="usercontentcategory" name="catid" class="form-control">
	                    		<option value="">Choose Content Category</option>
	                    		<?php echo $outs['selectionoutput'];?>
	                    	  </select>
	                      </div>
	                    </div>
	                    <p class="category_loader">

	                    </p>
                	</div>
                	<div class="col-md-12">
                		<div class="col-sm-4">
                			<label>Users List</label>
                			<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-bars"></i>
								</div>
                    			<select class="form-control" name="userlist">
                    				<option value="">Post with User Account?</option>
                    				<option value="yes">Yes</option>
                    			</select>
                      	    	<input type="text" class="form-control hidden" name="searchuserslist" data-target="username_display" placeholder="Enter users name"/>
                      	    	<p class="username_display" data-type="searchuserslist" data-target="userreallist">
                      	    		
                      	    	</p>
                    			<select class="form-control hidden" name="userreallist">
                    				<option value="">Select a User</option>
                    				
                    			</select>
                    		</div>
                		</div>
                		<div class="col-sm-4">
                			<label>NAPSTAND</label>
                			<select class="form-control" name="napstandlist">
                				<option value="">Post as NAPSTAND</option>
                				<option value="yes">Yes</option>
                			</select>
                		</div>
                		<div class="col-sm-4">
                			<label>Clients List</label>
                			<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-bars"></i>
								</div>
                    			<select class="form-control" name="clientlist">
                    				<option value="">Post with Client Account?</option>
                    				<option value="yes">Yes</option>
                    			</select>
                      	    	<input type="text" class="form-control hidden" name="searchclientslist" data-target="username_display" placeholder="Enter clients name"/>
                      	    	<p class="username_display" data-type="searchclientslist" data-target="clientreallist">
                      	    	</p>
                    			<select class="form-control hidden" name="clientreallist">
                    				<option value="">Select a Client</option>
                    			</select>
                    		</div>
                		</div>
                	</div>
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
		                    <input type="button" class="btn btn-danger" name="createparentcontent" value="Create Parent Content"/>
		                </div>
	            	</div>
                </div>
          </div>
        </div>
	</div>
	
</form>