			<div class="box">
          		<?php 
          			// get the current active content categories
          			$outs=getAllContentCategory("viewer","");
          		?>
	            <div class="box-header with-border">
	              <h3 class="box-title">Create Client</h3>
	              <div class="box-tools pull-right">
	                <!-- <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button> -->
	                <!-- <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
	              </div>
	            </div>
	            <div class="box-body">
	            	<form name="clientform" action="../snippets/basicsignup.php" method="POST" enctype="multipart/form-data">
	            		<input name="entryvariant" type="hidden" value="createclientadmin"/>
	            		<div class="box-group" id="surveyaccordion">
	            			<div class="panel box box-primary">
		                      <div class="box-header with-border">
		                        <h4 class="box-title">
		                          <a data-toggle="collapse" data-parent="#surveyaccordion" href="#BusinessBlock">
		                            <i class="fa fa-user"></i>  Client Information
		                          </a>
		                        </h4>
		                      </div>
		                      <div id="BusinessBlock" class="panel-collapse collapse in">
		                        <div class="box-body">
		                        	<div class="form-group">
				                      <label>Business Name</label>
				                      <input type="text" class="form-control" name="businessname"placeholder="Enter business name"/>
				                    </div>
				                    <div class="col-xs-12">
				                      <label>Content Category</label>
				                      <select id="contentcategory" name="catid" class="form-control">
	                            		<option value="">Choose Content Category</option>
	                            		<?php echo $outs['selectionoutput'];?>
	                            	  </select>
				                    </div>
				                    <div class="form-group">
				                      <label for="businesslogo">Business Logo</label>
				                      <input type="file" name="bizlogo" id="businesslogo"/>
				                      <p class="help-block">Choose the  business logo if available</p>
				                    </div>
				                    <div class="form-group">
				                      <label for="businessbanner">Business Banner</label>
				                      <input type="file" name="bannerlogo" id="businessbanner" >
				                      <p class="help-block">Choose the  business Banner image in the event of adverts, if available</p>
				                    </div>
		                        	<div class="form-group">
					                  <label>Business Description</label>
					                  <textarea class="form-control" rows="3" name="businessdescription" placeholder="Give a brief explanation about the business"></textarea>
					                </div>
		                        </div>
		                      </div>
		                    </div>
		                    <div class="panel box box-info">
		                      <div class="box-header with-border">
		                        <h4 class="box-title">
		                          <a data-toggle="collapse" data-parent="#surveyaccordion" href="#ClientLocationBlock">
		                            <i class="fa fa-map-marker"></i> Location Information
		                          </a>
		                        </h4>
		                      </div>
		                      <div id="ClientLocationBlock" class="panel-collapse collapse">
		                        <div class="box-body">
		                        	<div class="col-xs-12">
				                        <label>State</label>
				                        <select name="state" id="state" class="form-control" onchange="showLocalGovt(this.value)">
											<option value="">Select your State</option>
											<option value="Abia">Abia</option>
											<option value="Adamawa">Adamawa</option>
											<option value="Akwa Ibom">Akwa Ibom</option>
											<option value="Anambra">Anambra</option>
											<option value="Bauchi">Bauchi</option>
											<option value="Bayelsa">Bayelsa</option>
											<option value="Benue">Benue</option>
											<option value="Borno">Borno</option>
											<option value="Cross River">Cross River</option>
											<option value="Delta">Delta</option>
											<option value="Ebonyi">Ebonyi</option>
											<option value="Edo">Edo</option>
											<option value="Ekiti">Ekiti</option>
											<option value="Enugu">Enugu</option>
											<option value="FCT">FCT</option>
											<option value="Gombe">Gombe</option>
											<option value="Imo">Imo</option>
											<option value="Jigawa">Jigawa</option>
											<option value="Kaduna">Kaduna</option>
											<option value="Kano">Kano</option>
											<option value="Kastina">Kastina</option>
											<option value="Kebbi">Kebbi</option>
											<option value="Kogi">Kogi</option>
											<option value="Kwara">Kwara</option>
											<option value="Lagos">Lagos</option>
											<option value="Nasarawa">Nasarawa</option>
											<option value="Niger">Niger</option>
											<option value="Ogun">Ogun</option>
											<option value="Ondo">Ondo</option>
											<option value="Osun">Osun</option>
											<option value="Oyo">Oyo</option>
											<option value="Plateau">Plateau</option>
											<option value="Rivers">Rivers</option>
											<option value="Sokoto">Sokoto</option>
											<option value="Taraba">Taraba</option>
											<option value="Yobe">Yobe</option>
											<option value="Zamfara">Zamfara</option>
								  	    </select>
				                    </div>
				                    <div class="col-xs-12">
				                      <label>LocalGovt</label>
				                      <select id="LocalGovt" name="LocalGovt" class="form-control">
	                            		<option value="">Select Your Local Government</option>
	                            	  </select>
				                    </div>
		                        	<div class="form-group">
					                  <label>Business Address</label>
					                  <textarea class="form-control" rows="3" name="businessaddress" placeholder="Provide the business address"></textarea>
					                </div>
		                        </div>
		                      </div>
		                    </div>
		                    <div class="panel box box-primary">
		                      <div class="box-header with-border">
		                        <h4 class="box-title">
		                          <a data-toggle="collapse" data-parent="#surveyaccordion" href="#clientcontactBlock">
		                            <i class="fa fa-telephone"></i><i class="fa fa-envelope"></i> Contact Information
		                          </a>
		                        </h4>
		                      </div>
		                      <div id="clientcontactBlock" class="panel-collapse collapse">
		                        <div class="box-body">
		                        	<div class="form-group">
			            				<div class="col-xs-12">
						                    <div class="col-xs-4">
		                      				  <div class="form-group">
							                    <label>Phone One:</label>
							                    <div class="input-group">
							                      <div class="input-group-addon">
							                        <i class="fa fa-phone"></i>
							                      </div>
							                      <input type="text" class="form-control" name="phoneone" data-inputmask='"mask": "(234) 999-999-9999"' data-mask/>
							                    </div><!-- /.input group -->
							                  </div><!-- /.form group -->
						                    </div>
						                    <div class="col-xs-4">
		                      				  <div class="form-group">
							                    <label>Phone Two:</label>
							                    <div class="input-group">
							                      <div class="input-group-addon">
							                        <i class="fa fa-phone"></i>
							                      </div>
							                      <input type="text" class="form-control" name="phonetwo" data-inputmask='"mask": "(234) 999-999-9999"' data-mask/>
							                    </div><!-- /.input group -->
							                  </div><!-- /.form group -->
						                    </div>
						                    <div class="col-xs-4">
		                      				  <div class="form-group">
							                    <label>Phone Three:</label>
							                    <div class="input-group">
							                      <div class="input-group-addon">
							                        <i class="fa fa-phone"></i>
							                      </div>
							                      <input type="text" class="form-control" name="phonethree"data-inputmask='"mask": "(234) 999-999-9999"' data-mask/>
							                    </div><!-- /.input group -->
							                  </div><!-- /.form group -->
						                    </div>
						                </div>
					                    <div class="col-xs-6">
					                    	<div class="form-group">
							                    <label>Email Address:</label>
							                    <div class="input-group">
							                      <div class="input-group-addon">
							                        <i class="fa fa-envelope-square"></i>
							                      </div>
							                      <input type="email" class="form-control" name="email"/>
							                    </div><!-- /.input group -->
							                  </div><!-- /.form group -->
					                    </div>
					                    <div class="col-xs-6">
					                    	<div class="form-group">
							                    <label>Specify Password?(not compulsory):</label>
							                    <div class="input-group">
							                      <div class="input-group-addon">
							                        <i class="fa fa-key"></i>
							                      </div>
							                      <input type="password" class="form-control" name="password"/>
							                    </div><!-- /.input group -->
							                  </div><!-- /.form group -->
					                    </div>  
						            </div>
		                        </div>
		                      </div>
		                    </div>
	            		</div>
	            		<div class="col-md-12">
	            			<div class="box-footer">
			                    <input type="button" class="btn btn-danger" name="createclientadmin" value="Create Client"/>
			                </div>
		            	</div>
				    </form>
	            </div><!-- /.box-body -->
	            <div class="box-footer">
	            </div><!-- /.box-footer-->
          	</div><!-- /.box -->
            <script>
				$(document).ready(function(){
				$("[data-mask]").inputmask();

				})
		    </script>