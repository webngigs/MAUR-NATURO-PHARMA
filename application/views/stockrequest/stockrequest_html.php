<?php
$CI =& get_instance();
$CI->load->model('Web_settings');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
?>
<!-- Printable area start -->
<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
    function printDiv(divName) {
        var printContents       =   document.getElementById(divName).innerHTML;
        var originalContents    =   document.body.innerHTML;
        document.body.innerHTML =   printContents;
        window.print();
        document.body.innerHTML =   originalContents;
    }
    function ApproveStockRequest(stockrequest_id) {
        $.ajax({
            type: "POST",
            url: base_url + "Cstockrequest/ApproveStockRequest",
            data: {
                stockrequest_id: stockrequest_id
            },
            cache: !1,
            success: function(e) {
                alert("Stock Request Successfully Approved"); 
                window.location.href = window.location.href;
            }
        });
    }
    function CancelledStockRequest(stockrequest_id) {
        $.ajax({
            type: "POST",
            url: base_url + "Cstockrequest/CancelledStockRequest",
            data: {
                stockrequest_id: stockrequest_id
            },
            cache: !1,
            success: function(e) {
                alert("Stock Request Successfully Cancelled");
                window.location.href = window.location.href;
            }
        });
    }
    function ReceivedStockRequest(stockrequest_id) {
        $.ajax({
            type: "POST",
            url: base_url + "Cstockrequest/ReceivedStockRequest",
            data: {
                stockrequest_id: stockrequest_id
            },
            cache: !1,
            success: function(e) {
                alert("Stock Request Successfully Received");
                window.location.href = window.location.href;
            }
        });
    }
</script>
<!-- Printable area end -->

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon"><i class="pe-7s-note2"></i></div>
        <div class="header-title">
            <h1><?php echo display('stockrequests_details') ?></h1>
            <small><?php echo display('stockrequests_details') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('stockrequest') ?></a></li>
                <li class="active"><?php echo display('details') ?></li>
            </ol>
        </div>
    </section>
    <section class="content"><?php
        $message = $this->session->userdata('message');
        if(isset($message)) {
	        ?><div class="alert alert-info alert-dismissable">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <?php echo $message ?>
	        </div><?php
	        $this->session->unset_userdata('message');
	    }
	    $error_message = $this->session->userdata('error_message');
	    if(isset($error_message)) {
	        ?><div class="alert alert-danger alert-dismissable">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <?php echo $error_message ?>
	        </div><?php
	        $this->session->unset_userdata('error_message');
	    }
        if($this->permission1->method('manage_stockrequest','read')->access() ){
            if($status == 1)        $stockrequest_status = '<strong class="text-primary">Pending</strong>';
            else if($status == 2)   $stockrequest_status = '<strong class="text-danger">Cancelled</strong>';
            elseif($status == 3)    $stockrequest_status = '<strong class="text-success">Approved</strong>';
            elseif($status == 4)    $stockrequest_status = '<strong class="text-success">Received</strong>';    

            ?><div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd">
                        <div id="printableArea">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-8" style="display: inline-block;width: 64%"><?php 
                                    if($user_type == 3){
                                        ?><img src="<?php if(isset($Web_settings[0]['invoice_logo'])) echo $Web_settings[0]['invoice_logo']; ?>" class="" alt="" style="margin-bottom:20px"><?php    
                                    }
                                    elseif($user_type == 4){
                                        if(isset($user_logo) && !empty($user_logo)){
                                            ?><img src="<?php echo $user_logo; ?>" class="" alt="" style="margin-bottom:20px"><?php
                                        }
                                        else{
                                            ?><img src="<?php if(isset($Web_settings[0]['invoice_logo'])) echo $Web_settings[0]['invoice_logo']; ?>" class="" alt="" style="margin-bottom:20px"><?php
                                        }                                        
                                    }
                                    else{
                                        ?><img src="<?php if(isset($Web_settings[0]['invoice_logo'])) echo $Web_settings[0]['invoice_logo']; ?>" class="" alt="" style="margin-bottom:20px"><?php
                                    }
                                    ?></div>
                                    <div class="col-sm-4 text-left" style="display: inline-block;margin-left: 5px;">
                                        <h3 class="m-t-0"><?php echo display('stockrequests_details') ?></h3>
                                        <div><?php echo display('stockrequest_no') ?> : {stockrequest_no}</div>
                                        <div><?php echo display('stockrequest_date') ?> : {final_date}</div>
                                        <div class="m-b-15"><?php echo display('status') ?> : <?php echo $stockrequest_status; ?></div>
                                    </div>
                                </div><hr>
                                <div class="table-responsive m-b-20">
	                                <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-left"><?php echo display('sl'); ?></th>
                                                <th class="text-left"><?php echo display('product_name'); ?></th>
                                                <th class="text-right"><?php echo display('quantity'); ?></th>
                                                <th class="text-right"><?php echo display('rate'); ?></th>
                                                <th class="text-right"><?php echo display('ammount'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {stockrequest_all_data}
                                            <tr>
                                                <td class="text-left">{sl}</td>
                                                <td class="text-left"><div><strong>{product_name} - ({strength})</strong></div></td>
                                                <td class="text-right">{quantity}</td>
                                                <td class="text-right"><?php echo (($position==0)?"$currency {rate}":"{rate} $currency") ?></td>
                                                <td class="text-right"><?php echo (($position==0)?"$currency {total_price}":"{total_price} $currency") ?></td>
                                            </tr>
                                            {/stockrequest_all_data}
                                        </tbody>
                                        <tfoot>
                                            <td class="text-right" colspan="2" style="border:0px"><b><?php echo display('sub_total')?>:</b></td>
                                            <td class="text-right" style="border: 0px"><b>{subTotal_quantity}</b></td>
                                            <td style="border:0px"></td>
                                            <td class="text-right" align="center" style="border:0px"><b><?php echo (($position==0)?"$currency {subTotal_ammount}":"{subTotal_ammount} $currency") ?></b></td>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="row">
		                        	<div class="col-xs-12" style="display: inline-block;">
		                                <p></p>
		                                <p><strong>{stockrequest_detail}</strong></p>		                               
		                            </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div  style="float:left;width:40%;text-align:center;border-top:1px solid #e4e5e7;margin-top: 100px;font-weight: bold;">
                                            <?php echo display('received_by') ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-4">
                                        <div  style="float:right;width:40%;text-align:center;border-top:1px solid #e4e5e7;margin-top: 100px;font-weight: bold;">
                                            <?php echo display('authorised_by') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-left"><?php
                        if($user_id == 1) {
                            if($status == 1) {
                                ?><button class="btn btn-success" onclick="ApproveStockRequest(<?php echo $stockrequest_id; ?>);"><i class="fa fa-thumbs-up"></i> <?php echo display('approve'); ?></button> &nbsp;&nbsp;
                                <button class="btn btn-danger" onclick="CancelledStockRequest(<?php echo $stockrequest_id; ?>);"><i class="fa fa-trash"></i> <?php echo display('cancel'); ?></button> &nbsp;&nbsp;<?php
                            }
                        } else {                            
                            if(($request_by == 'mr' || $request_by == 'admin') && $user_type == 3){
                                if($status == 3) {
                                    ?><button class="btn btn-success" onclick="ReceivedStockRequest(<?php echo $stockrequest_id; ?>);"><i class="fa fa-thumbs-up"></i> <?php echo display('received'); ?></button> &nbsp;&nbsp;<?php
                                }
                            }
                            if($request_by == 'customer'  && $user_type == 4){
                                if($status == 3) {
                                    ?><button class="btn btn-success" onclick="ReceivedStockRequest(<?php echo $stockrequest_id; ?>);"><i class="fa fa-thumbs-up"></i> <?php echo display('received'); ?></button> &nbsp;&nbsp;<?php
                                }
                            }

                            if($request_by == 'customer' && $user_type == 3) {
                                if($status == 1) {
                                    ?><button class="btn btn-success" onclick="ApproveStockRequest(<?php echo $stockrequest_id; ?>);"><i class="fa fa-thumbs-up"></i> <?php echo display('approve'); ?></button> &nbsp;&nbsp;
                                    <button class="btn btn-danger" onclick="CancelledStockRequest(<?php echo $stockrequest_id; ?>);"><i class="fa fa-trash"></i> <?php echo display('cancel'); ?></button> &nbsp;&nbsp;<?php
                                }
                            }                            
                        }
                            ?><button class="btn btn-info" onclick="printDiv('printableArea')"><span class="fa fa-print"></span> <?php echo display('print'); ?></button>
                        </div>
                    </div>
                </div>
            </div><?php
        }
        else{
            ?><div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title"><h4><?php 
                            echo display('You do not have permission to access. Please contact with administrator.');
                        ?></h4></div>
                    </div>
                </div>
            </div><?php
        }
	?></section>
</div>