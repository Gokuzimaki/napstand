			<div id="form" style="background-color:#fefefe;">
				<form action="../snippets/basicsignup.php" name="faq" method="post">
					<input type="hidden" name="entryvariant" value="createfaq"/>
					<div id="formheader">Create FAQ</div>
					* means the field is required.
						<div id="formend">
							FAQ Title *<br>
							<input type="text" placeholder="Enter FAQ Title" name="title" class="curved"/>
						</div>
						<div id="formend" style="">
							<span style="font-size:18px;">FAQ Details:</span><br>
							<textarea name="content" id="adminposter" Placeholder="Details" class=""></textarea>
						</div>
					<div id="formend">
						<input type="button" name="createfaq" value="Submit" class="submitbutton"/>
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
				        filemanager_title:"Adsbounty Admin Blog Content Filemanager" ,
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
						   	filemanager_title:"Adsbounty Admin Blog Content Filemanager" ,
						   	external_plugins: { "filemanager" : ""+host_addr+"scripts/filemanager/plugin.min.js"}
					});   
			</script>