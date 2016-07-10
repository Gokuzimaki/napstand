<?php 
    
    if(isset($mpagefooterclass)&&$mpagefooterclass!==""){

    }else{
        $mpagefooterclass="main-footer";
    }
?>
<!-- General Modal display section -->
      <div id="mainPageModal" class="modal fade" data-backdrop="false" data-show="true" data-role="dialog">
      	<div class="modal-dialog">
      		<div class="modal-content">
		      	<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
					<h4 class="modal-title">Message</h4>
		        </div>
		      	<div class="modal-body">

		      	</div>
		      	<div class="modal-footer">
		      		<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
		      	</div>
		    </div>
      	</div>
      </div>
      <!-- end modal display -->
      <footer class="<?php echo $mpagefooterclass;?>">
        <div class="pull-right hidden-xs">
          <b>Administrator Central.</b>
        </div>
        <strong>Copyright &copy; 2014-<?php echo date('Y');?> <a href="index.php">Napstand</a>.</strong> All rights reserved. Developed by Okebukola Olagoke.
      </footer>
    </div><!-- ../wrapper -->
<?php 
    include('themescriptsdumpadmin.php');
    if(isset($mpagescriptextras)){
        echo $mpagescriptextras;
    }
?>

    