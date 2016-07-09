<?php 
	// get the current active content categories
	$outs=getAllContentCategory("viewer","all");
?>
<div class="box-group" id="contentaccordion">
	<div class="panel box box-primary">
      <div class="box-header with-border">
        <h4 class="box-title">
          <a data-toggle="collapse" data-parent="#contentaccordion" href="#headBlock">
            <i class="fa fa-"></i>  Create/Edit Content Series
          </a>
        </h4>
      </div>
      <div id="headBlock" class="panel-collapse collapse in">
            <div class="box-body">
            	<div class="col-md-12">
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
                			<div class="form-group">   
	                			<label>Users List</label>
	                			<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-bars"></i>
									</div>
	                    			<select class="form-control" name="userlist">
	                    				<option value="">Use a User Account?</option>
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
                		</div>
                		<div class="col-sm-4">
                			<label>NAPSTAND</label>
                			<select class="form-control" name="napstandlist">
                				<option value="">Post as NAPSTAND</option>
                				<option value="yes">Yes(NAPSTAND Only)</option>
                				<option value="yesfull">Yes(All Parent Content)</option>
                			</select>
                		</div>
                		<div class="col-sm-4">
                			<label>Clients List</label>
                			<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-bars"></i>
								</div>
                    			<select class="form-control" name="clientlist">
                    				<option value="">Use a Client Account?</option>
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
                    <div class="col-md-7">
                		<div class="form-group">   
                			<label>Parent Content List</label>
                			<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-bars"></i>
								</div>
								<p class="alertparentcontent itemloader">

								</p>
                    			<select class="form-control" name="parentcontentlist">
                    				<option value="">Select a Content</option>
                    			</select>
                    		</div>
                		</div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">   
                            <label>Content Status</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-bars"></i>
                                </div>
                                <select class="form-control" name="publishstatustypeout">
                                    <option value="">All</option>
                                    <option value="published">Published</option>
                                    <option value="dontpublish">Not Published</option>
                                    <option value="scheduled">Scheduled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                    	<label class="nolabel"></label>
            			<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-angle-double-right"></i>
							</div>
            				<input type="button" class="btn btn-danger form-control" name="loadcontentseries" value="GO"/>
                		</div>
                		<p class="parent_content_loader"> 
                		</p>
                    </div>

                    <div class="col-md-12 parent_content_display">
                    	<div class="content_image_loader_bootpag hidden">
                			<img src="<?php echo $host_addr;?>images/loading.gif" class="loadermidi"/>
                		</div>
                    </div>
            	</div>
            </div>
      </div>
    </div>
</div>