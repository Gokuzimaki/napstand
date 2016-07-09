<?php 
	// get the current active content categories
    $formdetails="";
	if ((isset($_SESSION['userinapstand'])||isset($_SESSION['clientinapstand']))) {
        # code...
        $doform="true";
        $userid=isset($_SESSION['userinapstand'])?$_SESSION['userinapstand']:$_SESSION['clientinapstand'];
        $list=isset($_SESSION['userinapstand'])?"userlist":"clientlist";
        $reallist=isset($_SESSION['userinapstand'])?"userreallist":"clientreallist";
        $userdata=getSingleUserPlain($userid);
        
        $outs=getAllParentContent("viewer","usertypeoutedit","$userid","all");
    }else{
        $doform="false";

    }
    
?>

<?php
    if($doform=="true"){
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
            		
                    <div class="col-md-7">
                		<div class="form-group">   
                			<label>Parent Content List</label>
                			<div class="input-group select2-bootstrap-prepend">
								<div class="input-group-addon">
									<i class="fa fa-bars"></i>
								</div>
                    			<select class="form-control" name="parentcontentlist">
                                    <?php echo $outs['selectionoutput'];?>
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
            				<input type="button" class="btn btn-danger form-control" name="loadcontentseriesuser" value="GO"/>
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
            <script>
                $(document).ready(function(){
                    $('select[name=parentcontentlist]').select2({
                        theme: "bootstrap"
                    });
                });
            </script>
      </div>
    </div>
</div>
<?php
    }else{
?>
    <div class="box-group" id="contentaccordion">
        <div class="panel box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">
              <a data-toggle="collapse" data-parent="#contentaccordion" href="#headBlock">
                <i class="fa fa-"></i>  Create Content Entry
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