<div data-role="panel" appdata-name="responsivepanel" appdata-monitor="responsiveplain" appdata-state="" data-display="push" data-theme="b" id="nav-panel" class="ui-panel ui-panel-position-left ui-panel-display-push ui-body-b ui-panel-animate ui-panel-open">
    <div class="ui-panel-inner"><ul data-role="listview" class="ui-listview">
	    <li data-icon="delete"class="ui-first-child"><a href="#" data-rel="close" onClick="responsiveMenu()" class="ui-btn ui-btn-icon-right ui-icon-delete">Close</a></li>
	        <li><a href="<?php echo $host_addr;?>index.php" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Home</a></li>
	        <li><a href="<?php echo $host_addr;?>portfolio.php" data-transition="flip" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Portfolio</a></li>
	        <li><a href="<?php echo $host_addr;?>blog.php" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-ajax="false">Blog</a></li>
	        <li><a href="<?php echo $host_addr;?>videochannel.php" class="ui-btn ui-btn-icon-right ui-icon-carat-r">Video Channel</a></li>
	        <li><a href="<?php echo $host_addr;?>audiochannel.php" class="ui-btn ui-btn-icon-right ui-icon-carat-r"data-ajax="false">Audio Channel</a></li>
	        <li><a href="<?php echo $host_addr;?>about.php" class="ui-btn ui-btn-icon-right ui-icon-carat-r"data-ajax="false">About</a></li>
	</ul></div>
</div>
<script>
	 windowwidth=$(window).width();
 if(typeof($.mobile)=="undefined"){
  var windowheight=$(window).height();
$('div#main').css("min-height",""+windowheight+"px");
}
</script>