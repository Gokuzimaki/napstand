<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Upload/Edit Default Backgrounds</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <!-- <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
      </div>
    </div>
    <div class="box-body">
    	<div class="col-md-12">
    		<div class="col-md-12">
    			<form id="fileupload" name="testupload" action="<?php echo $host_addr;?>snippets/basicsignup.php" class="file_upload_form" method="POST" enctype="multipart/form-data">
        			<div class="img_point">
        				<input type="hidden" name="entryvariant" value="createmurals"/>
        				<input type="hidden" name="displaytype" value="muralupload"/>
        				<input type="hidden" name="extraval" value="admin"/>
        				
        				<div class="new_img">
                			<img src="" data-target-load="true" class="img_prev hidden"/>
                			<img src="<?php echo $host_addr;?>images/loading.gif" class="loadermini hidden" data-target-loader="true" data-form-name="testupload" class="img_prev hidden"/>
			                <div id="progress" class="progress" data-name="testupload-progress">
						        <div class="progress-bar progress-bar-success progress-bar-control"></div>
						        <div class="progress-percent">0%</div>
						    </div>
        				</div>
        				<span class="btn btn-primary fileinput-button ajax_upload_button bottom-right">
        					<i class="fa fa-arrow-circle-o-up"></i>
        					<!-- <span>Start Upload</span> -->
			                <input type="button" data-ajax-upload="true" data-form-name="testupload" data-target-field="img.img_prev" data-upload-path="<?php echo $host_addr;?>snippets/display.php?displaytype=muralupload" data-upload-type="image" value="Start Upload"/>
			            </span>
					    <span class="btn btn-success fileinput-button absbottomtwo bottom-left" name="changeprofpic">
		                    <i class="fa fa-plus"></i>
		                    <span>Choose Pic</span>
		                    <input type="file" id="profpic" onchange="readURL($(this), 'img.img_prev')" data-preview="true" data-ajax-upload="true" data-form-name="testupload" data-monitor="true" name="profpic"/>
                			<!-- <input type="button" class="btn btn-danger" name="createclientadmin" value="Process"/> -->
		                </span>
        			</div>
        		</form>
    		</div>
    		<div class="col-md-12">
        		<div class="mural_content_display" name="testupload_display">
        			<?php
        				$outsmurals=getMurals("admin","");
        				echo $outsmurals['adminoutput'];
        			?>
        		</div>
    		</div>
    	</div>
    </div><!-- /.box-body -->
    <div class="box-footer">
      These are the lastest general statistics available
    </div><!-- /.box-footer-->
</div><!-- /.box -->