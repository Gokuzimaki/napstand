            <div class="box-group" id="contentaccordion">
              <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#contentaccordion" href="#headBlock">
                        <i class="fa fa-"></i>  Create Admin User
                      </a>
                    </h4>
                  </div>
                  <div id="headBlock" class="panel-collapse collapse in">
                      <div class="box-body">
                        <div class="row">
                        	<form name="userform" method="POST" enctype="multipart/form-data" action="../snippets/basicsignup.php">
                        		    <input type="hidden" name="entryvariant" value="createnewuser"/>
                                <div class="col-md-12">
                            		<div class="form-group">
                                      <label>User Image</label>
                                      <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-bars"></i>
                                          </div>
                                          <input type="file" class="form-control" name="contentpic" value=""/>
                                       </div><!-- /.input group -->
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label>Access Level</label>
                                    <select name="accesslevel" id="surveycategory" class="form-control">
                                    	<option value="0">Super User</option>
                                    	<option value="1">Napstand User</option>

                        	  	    </select>
                                </div>
                                <div class="col-md-12" style="">
                            		<div class="form-group">
                                      <label>Fullname</label>
                                      <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-bars"></i>
                                          </div>
                        				   <input type="text" class="form-control" name="fullname" value="" Placeholder="Provide the fullname"/>
                                       </div><!-- /.input group -->
                                    </div>
                                </div>
                                <div class="col-md-12" style="">
                            		<div class="form-group">
                                      <label>Username</label>
                                      <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-bars"></i>
                                          </div>
                                          <input type="text" class="form-control" name="username" value="" Placeholder="Provide the username"/>
                                       </div><!-- /.input group -->
                                    </div>
                                </div>
                                <div class="col-md-12" style="">
                            		<div class="form-group">
                                      <label>Password</label>
                                      <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-bars"></i>
                                          </div>
                                          <input type="password" class="form-control" name="password" value="" Placeholder="Place user password here"/>
                                       </div><!-- /.input group -->
                                    </div>
                                </div>
                                <div class="col-md-12">
                        			     <div class="box-footer">
                                        <input type="button" class="btn btn-danger" name="submituser" value="Create/Update"/>
                                    </div>
                            	 </div>
                            </form>
                        </div>
                      </div>
                  </div>
              </div>
          </div>