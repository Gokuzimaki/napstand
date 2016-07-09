			<div id="form" style="background-color:#fefefe;">
				<form action="../snippets/basicsignup.php" name="surveycategory" method="post">
					<input type="hidden" name="entryvariant" value="createsurveycaytegory"/>
					<div id="formheader">Create Survey Category</div>
					* means the field is required.
						<div id="formend">
							Category Name *<br>
							<input type="text" placeholder="Enter Blog Name" name="name" class="curved"/>
						</div>
						<div id="formend">
							Category Description *<br>
							<textarea name="description" placeholder="Enter Survey Category Description" class=""></textarea>
						</div>
					<div id="formend">
						<input type="button" name="createsurveycategory" value="Submit" class="submitbutton"/>
					</div>
				</form>
			</div>