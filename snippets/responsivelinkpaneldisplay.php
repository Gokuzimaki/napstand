<?php
	!isset($activepage)?$activepage=" ":$activepage=$activepage;
?>

<div class="selectlinks">
	<a href="#nav-panel" data-icon="bars" onClick="responsiveMenu()" data-iconpos="notext" style="" class="ui-link ui-btn-left ui-btn ui-icon-bars ui-btn-icon-notext ui-shadow ui-corner-all forcedminilink" data-role="button" role="button">Menu</a>
    <h1 class="curpagemini"><?php echo $activepage?></h1>
    <!-- <a href="#add-form" class="pull-right" data-icon="gear" data-iconpos="notext">Add</a> -->
</div>