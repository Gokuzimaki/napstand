<div class="box">
	<?php 
		// get the current active content categories
		$outs=getAllContentCategory("viewer","all");
	?>
    <div class="box-header with-border">
      <h3 class="box-title">Create User</h3>
      <div class="box-tools pull-right">
        <!-- <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button> -->
        <!-- <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
      </div>
    </div>
    <div class="box-body">
    	<form name="userform" action="../snippets/basicsignup.php" method="POST" enctype="multipart/form-data">
    		<input name="entryvariant" type="hidden" value="createuseradmin"/>
    		<div class="box-group" id="surveyaccordion">
    			<div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#surveyaccordion" href="#informationBlock">
                        <i class="fa fa-user"></i>  User Information
                      </a>
                    </h4>
                  </div>
                  <div id="informationBlock" class="panel-collapse collapse in">
                    <div class="box-body">
                    	<div class="col-xs-4">
                        	<div class="form-group">
		                      <label>First Name</label>
		                      <input type="text" class="form-control" name="firstname" placeholder="First Name"/>
		                    </div>
		                </div>
		                <div class="col-xs-4">
                        	<div class="form-group">
		                      <label>Middle Name</label>
		                      <input type="text" class="form-control" name="middlename" placeholder="Middle Name"/>
		                    </div>
		                </div>
		                <div class="col-xs-4">
                        	<div class="form-group">
		                      <label>Last Name</label>
		                      <input type="text" class="form-control" name="lastname" placeholder="Last Name"/>
		                    </div>
		                </div>
		                <div class="col-xs-6">
                        	<div class="form-group">
		                      <label>Nickname</label>
		                      <input type="text" class="form-control" name="nickname" placeholder="Nickname"/>
		                    </div>
		                </div>
		                <div class="col-xs-6">
                        	<div class="form-group">
		                      <label>Gender</label>
		                      <select class="form-control" name="gender" placeholder="Choose Gender">
		                      	<option value="">Choose Gender</option>
		                      	<option value="male">Male</option>
		                      	<option value="female">Female</option>
		                      </select>
		                    </div>
		                </div>
	                    <div class="col-xs-6">
	                      <label>Content Category</label>
	                      <select id="contentcategory" name="catid" class="form-control">
                    		<option value="">Choose Content Category</option>
                    		<?php echo $outs['selectionoutput'];?>
                    	  </select>
	                    </div>
	                    <div class="col-xs-6">
		                    <div class="form-group">
		                      <label for="profpic">Profile Picture</label>
		                      <input type="file" name="profpic" class="form-control" id="profpic"/>
		                    </div>
		                </div>
	                    <div class="col-xs-12">
                        	<div class="form-group">
			                  <label>Bio</label>
			                  <textarea class="form-control" rows="3" name="bio" placeholder="Provide a bio for this profile, something witty and simple would do"></textarea>
			                </div>
			            </div>
                    </div>
                  </div>
                </div>
                <div class="panel box box-info">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#surveyaccordion" href="#LocationBlock">
                        <i class="fa fa-map-marker"></i> Location Information
                      </a>
                    </h4>
                  </div>
                  <div id="LocationBlock" class="panel-collapse collapse">
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
		                  <label>Full Address</label>
		                  <textarea class="form-control" rows="3" name="address" placeholder="Provide an address"></textarea>
		                </div>
                    </div>
                  </div>
                </div>
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#surveyaccordion" href="#contactBlock">
                        <i class="fa fa-telephone"></i><i class="fa fa-envelope"></i> Contact Information
                      </a>
                    </h4>
                  </div>
                  <div id="contactBlock" class="panel-collapse collapse">
                    <div class="box-body">
                    	<div class="form-group">
            				<div class="col-xs-12">
			                    <div class="col-sm-4">
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
			                    <div class="col-sm-4">
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
			                    <div class="col-sm-4">
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
            				<div class="col-xs-12">
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

                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#surveyaccordion" href="#socialBlock">
                        <i class="fa fa-facebook-official"></i><i class="fa fa-twitter"></i>
                        <i class="fa fa-linkedin"></i><i class="fa fa-pinterest"></i> 
                        Social Information
                      </a>
                    </h4>
                  </div>
                  <div id="socialBlock" class="panel-collapse collapse">
                    <div class="box-body">
                		<div class="col-xs-12">
                			<input type="hidden" name="socialcount" value="7">
        					<div class="col-sm-4">
              				  <div class="form-group">
			                    <label>Facebook:</label>
			                    <div class="input-group">
			                      <div class="input-group-addon">
			                        <i class="fa fa-facebook"></i>
			                      </div>
			                      <input type="text" class="form-control" name="socialhandlefb" data-type="handle" data-pos="1" Placeholder="Social handle, e.g Age Comics"/>
			                      <input type="text" class="form-control" name="socialhandlefblink" data-type="link" data-pos="1" Placeholder="Social link, e.g http://facebook.com/AgeComics"/>
			                    </div><!-- /.input group -->
			                  </div><!-- /.form group -->
		                    </div>
		                    <div class="col-sm-4">
              				  <div class="form-group">
			                    <label>Twitter:</label>
			                    <div class="input-group">
			                      <div class="input-group-addon">
			                        <i class="fa fa-twitter"></i>
			                      </div>
			                      <input type="text" class="form-control" name="socialhandletw" data-type="handle" data-pos="2" Placeholder="Social handle, e.g @AgeComics"/>
			                      <input type="text" class="form-control" name="socialhandletwlink" data-type="link" data-pos="2" Placeholder="Social link, e.g http://twitter.com/AgeComics"/>
			                    </div><!-- /.input group -->
			                  </div><!-- /.form group -->
		                    </div>
		                    <div class="col-sm-4">
              				  <div class="form-group">
			                    <label>Google Plus:</label>
			                    <div class="input-group">
			                      <div class="input-group-addon">
			                        <i class="fa fa-google-plus"></i>
			                      </div>
			                      <input type="text" class="form-control" name="socialhandlegp" data-type="handle" data-pos="3" Placeholder="Social handle, e.g AgeComics"/>
			                      <input type="text" class="form-control" name="socialhandlegplink" data-type="link" data-pos="3" Placeholder="Social link, e.g http://plus.google.com/thelink"/>
			                    </div><!-- /.input group -->
			                  </div><!-- /.form group -->
		                    </div>
		                    <div class="col-sm-4">
              				  <div class="form-group">
			                    <label>LinkedIn:</label>
			                    <div class="input-group">
			                      <div class="input-group-addon">
			                        <i class="fa fa-linkedin"></i>
			                      </div>
			                      <input type="text" class="form-control" name="socialhandlein" data-type="handle" data-pos="4" Placeholder="Social handle, e.g AgeComics"/>
			                      <input type="text" class="form-control" name="socialhandleinlink" data-type="link" data-pos="4" Placeholder="Social link, e.g http://linkedin.com/thelink"/>
			                    </div><!-- /.input group -->
			                  </div><!-- /.form group -->
		                    </div>
		                    <div class="col-sm-4">
              				  <div class="form-group">
			                    <label>Pinterest:</label>
			                    <div class="input-group">
			                      <div class="input-group-addon">
			                        <i class="fa fa-pinterest"></i>
			                      </div>
			                      <input type="text" class="form-control" name="socialhandlepin" data-type="handle" data-pos="5" Placeholder="Social handle, e.g @AgeComics"/>
			                      <input type="text" class="form-control" name="socialhandlepinlink" data-type="link" data-pos="5" Placeholder="Social link, e.g http://pinterest.com/AgeComics"/>
			                    </div><!-- /.input group -->
			                  </div><!-- /.form group -->
		                    </div>
		                    <div class="col-sm-4">
              				  <div class="form-group">
			                    <label>Tumblr:</label>
			                    <div class="input-group">
			                      <div class="input-group-addon">
			                        <i class="fa fa-tumblr"></i>
			                      </div>
			                      <input type="text" class="form-control" name="socialhandletblr" data-type="handle" data-pos="6" Placeholder="Social handle, e.g @AgeComics"/>
			                      <input type="text" class="form-control" name="socialhandletblrlink" data-type="link" data-pos="6" Placeholder="Social link, e.g http://tumblr.com/AgeComics"/>
			                    </div><!-- /.input group -->
			                  </div><!-- /.form group -->
		                    </div>
		                    <div class="col-sm-4">
              				  <div class="form-group">
			                    <label>Instagram:</label>
			                    <div class="input-group">
			                      <div class="input-group-addon">
			                        <i class="fa fa-instagram"></i>
			                      </div>
			                      <input type="text" class="form-control" name="socialhandleig" data-type="handle" data-pos="7" Placeholder="Social handle, e.g @AgeComics"/>
			                      <input type="text" class="form-control" name="socialhandleiglink" data-type="link" data-pos="7" Placeholder="Social link, e.g http://instagram.com/AgeComics"/>
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
                    <input type="button" class="btn btn-danger" name="createuseradmin" value="Create User"/>
                    <div class="col-sm-3 ajax-msg-holder pull-right">
                    	<img src="<?php echo $host_addr;?>images/loading.gif" class="loadermini hidden"/>
                    	<div class="ajax-msg-box hidden">
                    		<!-- Checking email data -->
                    	</div>
                    </div>
                </div>
        	</div>
	    </form>
    </div><!-- /.box-body -->
    <div class="box-footer">
    </div><!-- /.box-footer-->
</div><!-- /.box -->
<script>
	if($){
		$(document).ready(function(){
			$("[data-mask]").inputmask();
		})
	}
</script>