				<?php
					$outs=getAllBlogTypes("admin","");
				?>
				<script>
				//reload tinymce to see this DOM entry
					$(document).ready(function(){
/*$.cachedScript( "../scripts/js/tinymce/tinymce.min.js" ).done(function( script, textStatus ) {
  console.log( textStatus );
});
$.cachedScript( "../scripts/js/tinymce/basic_config.js" ).done(function( script, textStatus ) {
  console.log( textStatus );
});
*/
					});
				</script>
			<div id="form" style="background-color:#fefefe;">
				<form action="../snippets/basicsignup.php" id="formblogpost" onSubmit="// return false;" name="blogpost" method="post" enctype="multipart/form-data">
					<input type="hidden" name="entryvariant" value="createblogpost"/>
					<div id="formheader">Create Blog Post</div>
					* means the field is required, make sure you choose a blog type first, then click on the
					category selection to load the associated categories there for you to choose.
						<div id="formend">
							Choose a blog type *<br>
							<select name="blogtypeid" class="curved2">
								<option value="">--Choose--</option>
								<?php echo $outs['selection'];?>
							</select>
						</div>
						<div id="formend" data-name="categoryselection">
							Choose a category*<br>
							<select name="blogcategoryid" class="curved2">
								<option value="">--Choose--</option>
							</select>
						</div>
						<div id="formend" data-name="blogentryselection">
							Blog Entry Type<br>
							<select name="blogentrytype" class="curved2">
								<option value="normal">Normal</option>
								<option value="gallery">Gallery</option>
								<option value="banner">Banner</option>
							</select>
						</div>
						<div id="formend" data-name="galleryentry">
							<div id="formend">
								Choose Gallery Photos for this post(More can be uploaded later):<br>
								<input type="hidden" name="piccount" value=""/>
								<select name="photocount" class="curved2" title="Choose the amount of photos you want to upload, max of 10, then click below the selection to continue">
								<option value="">--choose amount--</option>
								<?php
								for($i=1;$i<=10;$i++){
									$pic="";
									$i>1?$pic="photos":$pic="photo";		
									echo'<option value="'.$i.'">'.$i.''.$pic.'</option>';
								}
								?>
								</select>							
							</div>
						</div>
						<div id="formend" data-name="bannerpicentry">
							Banner Image *<br>
							<input type="file" placeholder="Choose image" name="bannerpic" class="curved"/>
						</div>
						<div id="formend" data-name="coverphoto">
							Cover Photo *<br>
							<input type="file" placeholder="Choose image" name="profpic" class="curved"/>
						</div>
						<div id="formend" data-name="coverphotofloat">
						Cover Photo Float(Controls the position of the cover photo image place your mouse on an option to see a description of what it would do)<br>
							<select name="coverstyle" class="curved2">
								<option value="">Change Style</option>
								<option value="0" title="The Blog text starts inline beside the cover photo on it's left">Left</option>
								<option value="1" title="The Blog text starts underneath the cover photo">New Line</option>
								<option value="2" title="The Blog text starts inline beside the cover photo on it's right">Right</option>
							</select>
						</div>
						<div id="formend">
							Title*<br>
							<input type="text" placeholder="Blog Title" name="title" style="width:90%;" class="curved"/>

						</div>
						<div id="formend" data-name="introparagraph">
							<span style="font-size:18px;">Introductory Paragraph*:</span><br>
							<textarea name="introparagraph" id="postersmalltwo" Placeholder="" class=""></textarea>
						</div>
						<div id="formend" data-name="blogentry">
							<span style="font-size:18px;">The Blog Post*:</span><br>
							<textarea name="blogentry" id="adminposter" Placeholder="" class="curved3"></textarea>
						</div>
					<div id="formend">
						<input type="button" name="createblogpost" value="Submit" class="submitbutton"/>
					</div>
				</form>
			</div>
			<script>
				tinyMCE.init({
			        theme : "modern",
			        selector: "textarea#adminposter",
			        skin:"lightgray",
			        width:"94%",
			        height:"650px",
			        external_image_list_url : ""+host_addr+"snippets/mceexternalimages.php",
			        plugins : [
			         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
			         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			         "save table contextmenu directionality emoticons template paste textcolor responsivefilemanager"
			        ],
			        // toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
			        toolbar1: "undo redo | bold italic underline | fontselect fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
			        toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
			        image_advtab: true ,
			        editor_css:""+host_addr+"stylesheets/mce.css?"+ new Date().getTime(),
			        content_css:""+host_addr+"stylesheets/mce.css?"+ new Date().getTime(),
			        external_filemanager_path:""+host_addr+"scripts/filemanager/",
			        filemanager_title:"Content Filemanager" ,
			        external_plugins: { "filemanager" : ""+host_addr+"scripts/filemanager/plugin.min.js"}
				});
				tinyMCE.init({
				        theme : "modern",
				        selector:"textarea#postersmalltwo",
				        menubar:false,
				        statusbar: false,
				        plugins : [
				         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
				         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
				         "save table contextmenu directionality emoticons template paste textcolor responsivefilemanager"
				        ],
				        width:"80%",
				        height:"300px",
				        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
				        toolbar2: "| link unlink anchor | emoticons",
				        image_advtab: true ,
				        editor_css:""+host_addr+"stylesheets/mce.css?"+ new Date().getTime(),
				        content_css:""+host_addr+"stylesheets/mce.css?"+ new Date().getTime(),
						external_filemanager_path:""+host_addr+"scripts/filemanager/",
					   	filemanager_title:"Content Filemanager" ,
					   	external_plugins: { "filemanager" : ""+host_addr+"scripts/filemanager/plugin.min.js"}
				});   
				//Date range picker
			  if($(document).datepicker){

			  		$('#reservation').datepicker();
			  		//Timepicker
			        $(".timepicker").timepicker({
			          showInputs: false
			        });
				  //Date range picker with time picker
				  $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
			  }
			  if($(document).inputmask){
			      $("#datemask").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
			      //Datemask2 mm/dd/yyyy
			      $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
			      //Money Euro
			      $("[data-mask]").inputmask();
			      $(".timemask").inputmask("hh:mm", {"placeholder": "hh:mm"});

			  }
			</script>