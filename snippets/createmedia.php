<div id="form" style="background-color:#fefefe;">
					<div id="formheader">Create New Media Entries</div>
	<form name="mediaregistration" action="../snippets/basicsignup.php"  method="POST" onSubmit="return false;"enctype="multipart/form-data">
		<input type="hidden" name="entryvariant" value="createmedia"/>
		You can upload your media files here (Images) for later use in the articles section.
		<div id="formend">
			Choose New Media Files:<br>
			<input type="hidden" name="piccount" value=""/>
			<select name="photocount" class="curved2" title="Choose the amount of photos you want to upload, max of 10, then click below the selection to continue">
			<option value="">--choose amount--</option>
<?php
for($i=1;$i<=10;$i++){
	$pic="";
	$i>1?$pic="files":$pic="file";		
	echo'<option value="'.$i.'">'.$i.''.$pic.'</option>';
}
?>
			</select>							
		</div>
		<div id="formend">
			<input type="button" name="createmedia" style="width: 144px;float:none;" class="submitbutton" value="Upload"/>
		</div>
	</form>	
</div>
