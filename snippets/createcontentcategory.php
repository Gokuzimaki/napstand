			<form name="contentcategoryform" action="../snippets/basicsignup.php" method="POST" enctype="multipart/form-data">
        		<input name="entryvariant" type="hidden" value="createcontentcategory"/>
        		<div class="box-group" id="contentaccordion">
        			<div class="panel box box-primary">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a data-toggle="collapse" data-parent="#contentaccordion" href="#headBlock">
                            <i class="fa fa-"></i>  Create Content Category
                          </a>
                        </h4>
                      </div>
                      <div id="headBlock" class="panel-collapse collapse in">
	                        <div class="box-body">
	                        	<div class="form-group">
			                      <label>Category Name</label>
			                      <div class="input-group">
				                      <div class="input-group-addon">
				                        <i class="fa fa-file-text"></i>
				                      </div>
			                      	  <input type="text" class="form-control" name="catname" placeholder="Enter category name"/>
			                      </div>
			                    </div>
			                    <div class="form-group">
			                      <label for="businesslogo">Brief Description</label>
			                      <div class="input-group">
				                      <div class="input-group-addon">
				                        <i class="fa fa-file-text-o"></i>
				                      </div>
				                      <textarea name="description" rows="3" class="form-control" placeholder="A brief description of what this category entails or has to offer"></textarea>
				                  </div>
			                    </div>
			                    <div class="form-group">
			                      <label for="businessbanner">Cover Image</label>
			                      <div class="input-group">
				                      <div class="input-group-addon">
				                        <i class="fa fa-file-image-o"></i>
				                      </div>
				                      <input type="file" name="profpic" class="form-control">
				                  </div>
			                      <p class="help-block">Choose the cover image for this category</p>
			                    </div>
		                        <div class="col-md-12">
				        			<div class="box-footer">
					                    <input type="button" class="btn btn-danger" name="createcontentcategory" value="Create Category"/>
					                </div>
				            	</div>
	                        </div>
                      </div>
                    </div>
        		</div>
        		
		    </form>