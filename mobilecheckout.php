<?php  
  session_start();
  include('./snippets/connection.php');
  $activepage=0;
  $activepage_type="mobilecheckout";
  $test='';
  $transtype='';
  $transactionimage="";
  $transactionpoweredby="";
  $tsuccessurl="";
  $tfailureurl="";
  $tnotificationurl="";
  $tsuccessurl_fieldname="";
  $tfailureurl_fieldname="";
  $tnotificationurl_fieldname="";
  $userid=0;
  $cid=0;
  $totalprice=0;
  $contentdataoutput="";
  $formpostdata="";
  $transactionurl="";
  $userdata=array();
  $contentdata=array();
  $dotable="false";
  $dotablemsg="No transaction data detected";
  $cdate=date("Y-m-d H:i:s");
  $maindayout=date('D, d F, Y h:i:s A', strtotime($cdate));
  $counter=1;
  if (isset($_GET['test'])) {
    $test=$_GET['test'];  
  }

  if (isset($_POST['test'])) {
    $test=$_POST['test']; 
  }
  if(isset($_GET['ttype'])){
    $transtype=$_GET['ttype'];
  }
  if(isset($_POST['ttype'])){
    $transtype=$_POST['ttype'];
  }
  if($test!==""&&isset($_GET['userid'])){
    $userid=mysql_real_escape_string($_GET['userid']);
    $cid=mysql_real_escape_string($_GET['cid']);
    
  }else if ($test==""&&isset($_POST['userid'])) {
    # code...
    $userid=mysql_real_escape_string($_POST['userid']);
    $cid=mysql_real_escape_string($_POST['cid']);
  }
  if($cid>0&&$userid>0){
    $transdata=getAllTransactions('viewer',"all","appuserpaymentstatus",$userid,$cid);
    if(strtolower($transtype)=="voguepay"){
      $transactionurl=$host_vogue_transaction_url;
      $tsuccessurl=$host_vogue_success_url;
      $tfailureurl=$host_vogue_failure_url;
      $tnotificationurl=$host_vogue_notification_url;
      $tsuccessurl_fieldname=$host_vogue_success_url_fieldname;
      $tfailureurl_fieldname=$host_vogue_failure_url_fieldname;
      $tnotificationurl_fieldname=$host_vogue_notification_url_fieldname;
      $transactionimage='<img src="'.$host_vogue_image_url.'" alt="Vogue Pay"/>';
      $transactionpoweredby=$host_vogue_poweredby_text;
    }
    if($transdata['numrows']<1){
      $contentdata=getSingleContentEntry($cid);
      $userdata=getSingleUserPlain($userid);

      // verify the content data
      if($contentdata['numrows']>0){
        $parentdata=getSingleParentContent($contentdata['parentid']);
      
        // verify the user account
        if($userdata['numrows']>0){
          if($userdata['usertype']=='appuser'){
            $merchant_ref=array();
            $merchant_ref['fid']=$cid;
            $merchant_ref['platform']="mobileapp";
            $merchant_ref['ttype']="$transtype";
            $merchant_ref['uid']="$userid";
            $formpostdata='
              <input type="hidden" name="v_merchant_id" value="'.$host_vogue_merchantid.'">
              <input type="hidden" name="memo" value="Payment for Content Entry on the Napstand Platform">
              <input type="hidden" name="merchant_ref" value="'.str_replace('"', "'",json_encode($merchant_ref)).'">
              <input type="hidden" name="store_id" value="">
              <input type="hidden" name="item_1" value="'.str_replace('"', "'", $contentdata['prow']['contenttitle']).'">
              <input type="hidden" name="discount_1" value="0%">
              <input type="hidden" name="price_1"  value="'.$contentdata['price'].'">
              <input type="hidden" name="description_1" data-type="cartpaymentdata" value="'.$contentdata['titlerow'].'">
              <input type="hidden" name="'.$tnotificationurl_fieldname.'" value="'.$tnotificationurl.'?fid='.$cid.'&platform=mobileapp&ttype='.$transtype.'&uid='.$userid.'" />
              <input type="hidden" name="'.$tsuccessurl_fieldname.'" value="'.$tsuccessurl.'?fid='.$cid.'&platform=mobileapp&ttype='.$transtype.'&uid='.$userid.'"/>
              <input type="hidden" name="'.$tfailureurl_fieldname.'" value="'.$tfailureurl.'?er=error&msg=Something went wrong, and your transaction was unsuccessful&fid='.$cid.'&platform=mobileapp&ttype='.$transtype.'&uid='.$userid.'" />
            ';
            $dotable="true";
            $contentdataoutput='
                <tr>
                  <td>'.$counter.'</td>
                  <td>'.$parentdata['catout']['catname'].'</td>
                  <td>'.$contentdata['prow']['contenttitle'].'</td>
                  <td>'.$contentdata['titlerow'].'</td>
                  <td>'.$contentdata['price'].'</td>
                </tr>
            ';
            $totalprice=$contentdata['price'];
          }else{
            $dotable="false";
            $dotablemsg="This is not a valid Napstand Mobile App user account";  
          }
        }else{
          $dotable="false";
          $dotablemsg="No valid user found";  
        }

        // verify the content price
        if($contentdata['price']<=0){
          $dotable="false";
          $dotablemsg="The content you are attempting to purchase is free.";
        }
        
      }else{
        $dotable="false";
        $dotablemsg="This is an invalid content entry";
      }
    }else{
      $dotable="false";
      $dotablemsg="A purchase has already been made by you for this content entry, contact support if any issue persists.";
    }
  }
  $mpagefooterclass="hidden";// hide the footer section
  include('./snippets/headcontentadmin.php');
?>
  <body class="register-page">
    <div class="register-box">
      <div class="register-logo">
        <a href=""><b>Napstand</b> Purchases</a>
      </div>
    </div><!-- /.register-box -->
    <div class="content-header">
      <!-- Main content -->
      <div class="register-box-body">
          <section class="invoice">
            <?php
              if($dotable=="true"){
            ?>
              <form type="post" name="transactionform" method="POST" action="<?php echo $transactionurl;?>">
                <?php echo $formpostdata;?>
                  <!-- title row -->
                  <div class="row">
                    <div class="col-xs-12">
                      <h2 class="page-header">
                        <i class="fa fa-globe"></i> Napstand.
                        <small class="pull-right">Date: <?php echo $maindayout;?></small>
                      </h2>
                    </div><!-- /.col -->
                  </div>
                  <!-- info row -->
                  <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                      From
                      <address>
                        <strong>Napstand</strong><br>
                        Phone: <?php echo $host_phonenumbers;?><br/>
                        Email: <?php echo $host_info_email_addr;?>
                      </address>
                    </div><!-- /.col -->
                    <div class="col-sm-4 pull-right invoice-col">
                      To
                      <address>
                        <strong><?php echo $userdata['nameout'];?></strong><br>
                        <br>
                        Email: <?php echo $userdata['email'];?>
                      </address>
                    </div><!-- /.col -->

                  </div><!-- /.row -->

                  <!-- Table row -->
                  <div class="row">
                    <div class="col-xs-12 table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Qty</th>
                            <th>Category</th>
                            <th>Main Title</th>
                            <th>Issue Title </th>
                            <th>Subtotal (<?php echo $host_naira_symbol;?>)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php echo $contentdataoutput;?>
                        </tbody>
                      </table>
                    </div><!-- /.col -->
                  </div><!-- /.row -->

                  <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-xs-12 col-sm-6 pull-right">
                      <!-- <p class="lead">Amount Due 2/22/2014</p> -->
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:50%; text-align:right;">Subtotal:</th>
                            <td><?php echo "<b>$host_naira_symbol</b> $totalprice";?></td>
                          </tr>
                          <!-- <tr>
                            <th>Tax (9.3%)</th>
                            <td>$10.34</td>
                          </tr> -->
                          <!-- <tr>
                            <th>Shipping:</th>
                            <td>$5.80</td>
                          </tr> -->
                          <tr>
                            <th style="text-align:right;">Total:</th>
                            <td><?php echo "<b>$host_naira_symbol</b> $totalprice";?></td>
                          </tr>
                        </table>
                      </div>
                    </div><!-- /.col -->
                    <div class="col-xs-12 col-sm-6 pull-left">
                      <p class="lead">Payment Method:</p>
                      <?php echo $transactionimage;?>

                      <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                        <?php echo $transactionpoweredby;?>
                      </p>
                    </div><!-- /.col -->
                  </div><!-- /.row -->

                  <!-- this row will not appear when printing -->
                  <div class="row no-print">
                    <div class="col-xs-12">
                      <!-- <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a> -->
                      <button type="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Make Payment</button>
                      <!-- <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button> -->
                    </div>
                  </div>
              <form>
            <?php 
              }else{
            ?>
                <div class="row">
                  <div class="col-md-12 text-center invoice-col">
                    <?php echo $dotablemsg;?>
                  </div><!-- /.col -->

                </div><!-- /.row -->
            <?php
              }
            ?>
          </section><!-- /.content -->
      </div>
      <?php include('./snippets/footeradmin.php');?>    
  </body>
</html>