<?php 
    $parentid=isset($parentid)?$parentid:0;
    $retid=isset($retid)?$retid:0;
    $rettbl=isset($rettbl)?$rettbl:"";
    $retdata="";
    if($retid>0){
        $retdata='
            <input name="retid" type="hidden" value="'.$retid.'"/>
            <input name="rettbl" type="hidden" value="users"/>
        ';
    }
	$host_price_limit=isset($host_price_limit)?$host_price_limit:3000;
?>
<form name="contententryform" action="<?php echo $host_addr?>snippets/basicsignup.php" method="POST" enctype="multipart/form-data">
	<input name="entryvariant" type="hidden" value="createcontententry"/>
	<input name="parentid" type="hidden" value="<?php echo $parentid;?>"/>
	<div class="col-sm-6">
		<label>Entry Type</label>
		<div class="input-group">
		    <div class="input-group-addon">
		    	<i class="fa fa-file-image-o"></i>
		    </div>
			<select class="form-control" name="uploadtype">
				<option value="">Specify Upload Type</option>
				<option value="imageupload">Image Upload</option>
				<option value="zipupload">Zip File Upload</option>
			</select>
		</div>
	</div>
	<div class="col-sm-6">
    	<div class="form-group">   
			<label>Content/Release title(not compulsory)</label>
			<div class="input-group">
			    <div class="input-group-addon">
			    	<i class="fa fa-bars"></i>
			    </div>
			    <input type="text" class="form-control" name="contenttitle"  placeholder="Provide a good title for this entry"/>
			</div>
        </div>
    </div>
    
    <div class="col-sm-12">
    	<div class="form-group">
              <label for="businesslogo">Short Description(Optional)</label>
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-file-text-o"></i>
                  </div>
                  <textarea name="description" rows="3" class="form-control" placeholder="A brief description for this entry(Optional)"></textarea>
              </div>
        </div>
    </div>
    <div class="col-sm-12 emu-row">
		<div class="col-sm-8">
			<label>Publish Status</label>
			<div class="input-group">
			    <div class="input-group-addon">
			    	<i class="fa fa-bars"></i>
			    </div>
    			<select class="form-control" name="publishdata">
    				<option value="published">Publish on Upload</option>
    				<option value="dontpublish">Dont Publish(use if you cant upload all content at once or want this stored for later)</option>
    				<option value="scheduled">Scheduled</option>
    			</select>
        	</div>
			<p class="side-note color-red">
            	*<b>Publish on Upload</b>: Your post will be available on the Napstand platform immediately you submit it<br>
            	*<b>Dont Publish</b>: Your post wont be displayed on the Napstand platform, this allows you to further edit and upload more content to it<br> 
            	*<b>Scheduled</b>: Your post will be available on the "<b>Schedule date</b>" you choose<br>
            </p>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Price(Set to zero if this issue is free)</label>
				<div class="input-group">
                	<div class="input-group-addon">
                		&#8358;
                	</div>
					<input type="number" class="form-control" Placeholder="Price" name="postprice" min="0" max="<?php echo $host_price_limit;?>"/>
                </div>
			</div>
		</div>
		<div class="col-md-6 hidden" data-name="schedulesection">
			<!-- Date range -->
            <div class="form-group">
                <label>Schedule Date(Make sure it is a future date,you can also set the time by clicking the small time icon at the bottom of the popup):</label>
                <div class="input-group">
                  <input type="text" name="scheduledate" id="scheduleentry" placeholder="click/tap to choose date" class="form-control pull-right"/>
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                </div><!-- /.input group -->
            </div><!-- /.form group -->	
		</div>
	</div>
	<div class="col-md-12 upload-image-section hidden" data-name="upload-image-section">
		<h4 class="imguploadheader">Image Upload Section</h4>
		<div class="col-sm-12">
            <div class="form-group">
                <label>Specify the amount of images You want to upload, max combined upload size is 30MB
                	(More can be uploaded afterwards, just make sure you change the publish status to dont publish):</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-list-ol"></i>
                  </div>
                  <input type="number" name="imagecount" placeholder="Maximimum of 20" min="1" max="20" data-max="20" class="form-control"/>
                </div><!-- /.input group -->
                <p class="side-note color-red">
                	Choose the amount then click/tap Below the field. NB. the upload order is how your content images will be displayed to users
                	<br>
                	To reduce or increase the number of entries, adjust the value in the field above
                </p>
            </div><!-- /.form group -->
		</div>
		<div class="col-sm-12 image_upload_section">	
			<div class="entrymarker images">
				<p class="total-size" title="Total size of Files"></p>
				<input type="hidden" name="filesizeout" value="0"/>
			</div>
		</div>
	</div>
	<div class="col-md-12 upload-zip-section hidden" data-name="upload-zip-section">
		<h4 class="imguploadheader">Zip File Upload Section</h4>
		<div class="col-sm-12">
            <div class="form-group">
                <label>Max upload size is 30MB
                	(More can be uploaded afterwards, just make sure you change the publish status to dont publish):</label>
                <div class="input-group">
                    <!-- <div class="input-group-addon">
                    	<i class="fa fa-list-ol"></i>
                    </div> -->
                    <p class="zipfilehold">
                        <span class="btn btn-success fileinput-button absbottomtwo bottom-left zipfile">
		                    <i class="fa fa-plus"></i>
		                    <span>Choose Zip archive with images only</span>
		                    <input type="file" id="zipupload" name="zipfile" onChange="readURLTwo($(this),'napstanduserzipupload')"/>
		                </span>
		            </p>
                </div><!-- /.input group-->
                <p class="side-note color-red">
                	Make sure that the compressed files are in the right naming format, i.e, names are numeric, e.g 1.png, 2.png ....e.t.c
                	<br>
                	NB the archive must only have image files, any other format will be ignored.
                </p>
            </div><!-- /.form group -->
		</div>
		<div class="col-sm-12">	
			<div class="entrymarker zip">
				<p class="total-size" title="Total size of Files">
					
				</p>
				<input type="hidden" name="zipfilesizeout" value="0"/>
			</div>
		</div>
	</div>
    <div class="col-md-12">
    	<div class="box-footer">
            <?php echo $retdata;?>
            <input type="button" class="btn btn-danger" name="createcontententry" value="Submit"/>
        </div>
    </div>
    <script>
    	$(document).ready(function(){
    		$('#scheduleentry').datetimepicker({
	            format:"YYYY-MM-DD HH:mm",
	            keepOpen:true
        	})
    	});
    </script>
</form>
          