<?php
    $CI =& get_instance();
    $CI->load->model('Web_settings');
    $Web_settings = $CI->Web_settings->retrieve_setting_editdata();
?>

<!-- Printable area start -->
<script type="text/javascript">
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
	// document.body.style.marginTop="-45px";
    window.print();
    document.body.innerHTML = originalContents;
}
</script>
<!-- Printable area end -->
<style>
    @media(max-width:767px){
    .perheader{
        display:none!important;
    }
}

@media print{
    .content-wrapper{
        padding-top:0px!important;
    }
    .panel-bd .panel-footer{
        display:none!important;
    }
    .main-footer{
        display:none!important;
    }
}

</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header perheader">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('invoice_details') ?></h1>
            <small><?php echo display('invoice_details') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('invoice') ?></a></li>
                <li class="active"><?php echo display('invoice_details') ?></li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
    <section class="content"><?php
        $message = $this->session->userdata('message');
        if(isset($message)) {
	        ?><div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?php echo $message ?></div><?php
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
        if($this->permission1->method('manage_invoice','read')->access() ){ 
            ?><div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd">
    	                <div id="printableArea">
    	                    <div class="panel-body">
    	                        <div class="table-responsive">
    	                        <table class="table no-border">
    	                            <tr>
    	                                <td width="60%">
    	                                    {company_info}
    	                                     <img src="<?php if (isset($Web_settings[0]['invoice_logo'])) {echo $Web_settings[0]['invoice_logo']; }?>" class="" alt="" style="margin-bottom:20px">
    	                                <br>
    	                                <span class="label label-success-outline m-r-15 p-10" ><?php echo display('billing_from') ?></span>
    	                                <address style="margin-top:10px; margin-bottom :0;">
    	                                    <strong>{company_name}</strong><br>
    	                                    {address}<br>
    	                                    <abbr><b><?php echo display('mobile') ?>:</b></abbr> {mobile}<br>
    	                                    <abbr><b><?php echo display('email') ?>:</b></abbr>
    	                                    {email}<br>
    	                                    <abbr><b><?php echo display('website') ?>:</b></abbr>
    	                                    {website}
    	                                    {/company_info}
    	                                </address>
    	                                </td>
    	                                <td width="40%">
    	                                     <h2 class="m-t-0">GST <?php echo display('invoice') ?></h2>
    	                                <div><b><?php echo display('invoice_no') ?> </b>: {invoice_no}</div>
    	                                <div class="m-b-15"><b><?php echo display('billing_date') ?></b>: {final_date}</div>
    	                                <span class="label label-success-outline m-r-15"><?php echo display('billing_to') ?></span>
    	                                <address style="margin-top:10px; margin-bottom :0;">
    	                                    <strong>{customer_name} </strong><br>
    	                                    <?php if ($customer_address) { ?>
    		                                {customer_address}
    		                                <?php } ?>
    	                                    <br>
    	                                    <abbr><b><?php echo display('mobile') ?>:</b></abbr>
    	                                    <?php if ($customer_mobile) { ?>
    	                                    {customer_mobile} <br>
    	                                    <?php }if ($customer_email) {
    	                                    ?>
    	                                    
    	                                    <abbr><b><?php echo display('email') ?>:</b></abbr>
    	                                    {customer_email}
    	                                   	<?php } ?>
                                            <br>
    	                                   	<?php if ($gst_no) { ?>
    		                                <b> GST No : </b> {gst_no}
    		                                <br>
    		                                <?php } ?>
    
    		                                 
    
    		                                <?php if ($pancard) { ?>
    		                                <b> PAN CARD : </b> {pancard}
    		                                  <br>
    		                                <?php } ?>
    	                                  
    
    	                                    <?php if ($rvc_no) { ?>
    		                                <b> <?php echo display('rvc_no') ?> : </b> {rvc_no}
    		                                <br>
    		                                <?php } ?>
    	                                    
    	                                </address>
    	                                </td>
    	                            </tr>
    	                        </table>
    	                        </div>
    	                        <style>
    	                        	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{padding: 7px 5px;}
    	                        	@page  { margin: 0; }
    	                        </style><?php 
        	                        $taxSlapSameStateArray                      =   array(); 
        	                        $taxSlapSameStateArray[0]['TaxableAmount']  =   0;
        	                        $taxSlapSameStateArray[5]['TaxableAmount']  =   0;
        	                        $taxSlapSameStateArray[12]['TaxableAmount'] =   0;
        	                        $taxSlapSameStateArray[18]['TaxableAmount'] =   0;
        	                        $taxSlapSameStateArray[28]['TaxableAmount'] =   0;
        	                        
        	                        $taxSlapNotSameStateArray                       =   array(); 
        	                        $taxSlapNotSameStateArray[0]['TaxableAmount']   =   0;
        	                        $taxSlapNotSameStateArray[5]['TaxableAmount']   =   0;
        	                        $taxSlapNotSameStateArray[12]['TaxableAmount']  =   0;
        	                        $taxSlapNotSameStateArray[18]['TaxableAmount']  =   0;
        	                        $taxSlapNotSameStateArray[28]['TaxableAmount']  =   0;
    	                        
    	                        ?><div class="table-responsive m-b-20">
    	                            <table class="table table-striped table-bordered">
    	                                <thead>
    	                                    <tr>
    	                                        <th class="text-center" width="3%"><?php echo display('sl') ?></th>
    	                                        <th class="text-left" width="18%"><?php echo display('Particulars') ?></th>
    	                                        <th class="text-center" width="6%">HSN</th>    	                                        
    	                                        <th class="text-center" width="8%"><?php echo display('Batch_ID') ?></th>
    	                                        <th class="text-center" width="7%">Expiry</th>
    	                                        <th class="text-right" width="6%">MRP (<?php echo $currency ?>)</th>
    	                                        <?php if ($discount_type == 1) { ?>
    	                                        <th class="text-center" width="5%">DIS</th>
    	                                        <?php }elseif($discount_type == 2){ ?>
    	                                        <th class="text-center" width="5%">DIS</th>
    	                                        <?php }elseif($discount_type == 3) { ?>
    	                                        <th class="text-center" width="5%"><?php echo display('fixed_dis') ?> </th>
    	                                        <?php } ?>
                                                <th class="text-right" width="5%">Rate (<?php echo $currency ?>)</th>
                                                <th class="text-center" width="5%">Qty</th>
    	                                        <th class="text-right" width="4%">GST</th>
    	                                       <!--  <th class="text-center" width="4%">GST Amount</th> -->
    	                                        <th class="text-right" width="8%">Total (<?php echo $currency ?>)</th>
    	                                    </tr>
    	                                </thead>
    	                                <tbody>
    										<?php $gstTotalAmount = 0; $grandTotalAmount = 0; $TotalAmount = 0; if(isset($invoice_all_data) && count($invoice_all_data)>0){
                                                foreach($invoice_all_data as $dts){
                                                    $discountAmtor = $dts['item_rate'] - (($dts['item_rate'] * $dts['discount'])/100);
                                                    $discountAmt = $dts['rate'] - (($dts['rate'] * $dts['discount'])/100);
                                                    ?><tr>
            	                                    	<td class="text-center"><?php echo $dts['sl']; ?></td>
            	                                        <td class="text-left"><div><strong><?php 
            	                                            echo $dts['product_name'].' - '.$dts['strength']; 
            	                                            
            	                                        ?></strong><?php if ($dts['discount'] == 100)    echo '<span class=""><b>(Sample)</b></span>'; ?></div></td>
            	                                        <td align="center"><?php echo $dts['HSNcode']; ?></td>
            	                                        
                                                    	<td align="center"><?php echo $dts['batch_id']; ?></td>
                                                    	<td align="center"><?php echo $dts['expeire_date']; ?></td>
                                                    	<td align="right"><?php 
                                                    	    if($position==0)  echo $dts['item_rate'];
                                                    	    else echo $dts['rate'];
                                                        ?></td><?php 
                                                    	if ($discount_type == 1) { ?><td align="center"><?php echo $dts['discount']; ?>%</td><?php }
                                                        else{ ?><td align="center"><?php 
                                                            if($position==0)  echo $dts['discount'];
                                                    	    else echo $dts['discount'];
                                                        ?></td><?php } 
                                                        ?><td align="right"><?php if($position==0)   echo $discountAmtor;  else echo $discountAmtor; ?></td>
            	                                        <td align="center"><?php echo $dts['quantity']; ?></td>
            	                                        
            	                                        <td align="center"><?php $gstp = $dts['tax0']; $gst = ($gstp); echo $gst.'%'; ?></td>
<!--             	                                        <td align="right"><?php 
            	                                            $gstAmount = (($dts['total_price'] * $gstp)/100);
            	                                      //      echo $currency.' '.$gstAmount; 
            	                                            $gstTotalAmount = $gstTotalAmount+$gstAmount; 
            	                                        ?></td> -->
            	                                        <td align="right"><?php 
            	                                            if($position==0)  echo ($dts['total_price']+$gstAmount); 
            	                                            else echo ($dts['total_price']+$gstAmount);
            	                                            
            	                                            $grandTotalAmount = $grandTotalAmount + ($dts['total_price']+$gstAmount)
            	                                        ?></td>
            	                                    </tr><?php
            	                                    
            	                                    if($customer_state_code == $admin_state_code){ 
                	                                    if($dts['tax0'] == '0.00')          {
                	                                        $taxSlapSameStateArray[0]['TaxableAmount']   =   $taxSlapSameStateArray[0]['TaxableAmount'] + $dts['total_price'];
                	                                    }
                	                                    else if($dts['tax0'] == '5.00'){     
                	                                        $taxSlapSameStateArray[5]['TaxableAmount']   =   $taxSlapSameStateArray[5]['TaxableAmount'] + $dts['total_price'];
                	                                    }
                	                                    else if($dts['tax0'] == '12.00'){   
                	                                        $taxSlapSameStateArray[12]['TaxableAmount']  =   $taxSlapSameStateArray[12]['TaxableAmount'] + $dts['total_price'];
                	                                    }
                	                                    else if($dts['tax0'] == '18.00'){    
                	                                        $taxSlapSameStateArray[18]['TaxableAmount']  =   $taxSlapSameStateArray[18]['TaxableAmount'] + $dts['total_price'];
                	                                    }
                	                                    else if($dts['tax0'] == '28.00'){   
                	                                        $taxSlapSameStateArray[28]['TaxableAmount']  =   $taxSlapSameStateArray[28]['TaxableAmount'] + $dts['total_price'];
                	                                    }
            	                                    }
            	                                    else{
                	                                    if($dts['tax0'] == '0.00')          {
                	                                        $taxSlapNotSameStateArray[0]['TaxableAmount']   =   $taxSlapNotSameStateArray[0]['TaxableAmount'] + $dts['total_price'];
                	                                    }
                	                                    else if($dts['tax0'] == '5.00'){     
                	                                        $taxSlapNotSameStateArray[5]['TaxableAmount']   =   $taxSlapNotSameStateArray[5]['TaxableAmount'] + $dts['total_price'];  
                	                                    }
                	                                    else if($dts['tax0'] == '12.00'){   
                	                                        $taxSlapNotSameStateArray[12]['TaxableAmount']  =   $taxSlapNotSameStateArray[12]['TaxableAmount'] + $dts['total_price'];
                	                                    }
                	                                    else if($dts['tax0'] == '18.00'){    
                	                                        $taxSlapNotSameStateArray[18]['TaxableAmount']  =   $taxSlapNotSameStateArray[18]['TaxableAmount'] + $dts['total_price'];
                	                                    }
                	                                    else if($dts['tax0'] == '28.00'){   
                	                                        $taxSlapNotSameStateArray[28]['TaxableAmount']  =   $taxSlapNotSameStateArray[28]['TaxableAmount'] + $dts['total_price'];
                	                                    }
            	                                    }
                                                }
    										}   
    										?>
    	                                </tbody>
    	                                <tfoot>
    	                                	<td align="left" colspan="3" style="border: 0px"><b><?php echo display('sub_total')?>:</b></td>
    	                                
    	                                	<td style="border: 0px"></td>
    	                                	<td style="border: 0px"></td>
    	                                	<td style="border: 0px"></td>
    	                                	<td style="border: 0px"></td>
    	                                	<td style="border: 0px"></td>
    	                                	<td align="center"  style="border: 0px"><b>{subTotal_quantity}</b></td>
    	                                	<td style="border: 0px"></td>
    	                                <!-- 	<td class="text-right" align="center"  style="border: 0px"><b><?php // echo $currency.' '.$gstTotalAmount; ?></b></td> -->
    	                                	<td class="text-right" align="center"  style="border: 0px"><b><?php echo $currency.' '.$grandTotalAmount; ?></b></td>
    	                                </tfoot>
    	                            </table>
    	                        </div>
    	                        <div class="row">
		                        	<div class="col-xs-8" style="display: inline-block;">
		                        	    <p><strong>{invoice_details}</strong></p>
		                                <div class="table-responsive" ><?php 
		                                    if($customer_state_code == $admin_state_code){ 
    	                                        $TaxableAmount =  0; $CGST =  0; $SGST =  0; $TotalGST  =  0; 
    	                                        $TaxableAmount = $TaxableAmount + $taxSlapSameStateArray[0]['TaxableAmount'];
    	                                        $TaxableAmount = $TaxableAmount + $taxSlapSameStateArray[5]['TaxableAmount'];
    	                                        $TaxableAmount = $TaxableAmount + $taxSlapSameStateArray[12]['TaxableAmount'];
    	                                        $TaxableAmount = $TaxableAmount + $taxSlapSameStateArray[18]['TaxableAmount'];
    	                                        $TaxableAmount = $TaxableAmount + $taxSlapSameStateArray[28]['TaxableAmount'];
    		                                    ?><table class="table table-striped table-bordered" cellspacing="0" width="100%" id="InvList"> 
                                                    <thead>
                                                        <tr>
                                                            <th>Class</th>
                                                            <th class="text-right">Taxable Amount</th>
                                                            <th class="text-right">CGST</th>
                                                            <th class="text-right">SGST</th>
                                                            <th class="text-center">IGST</th>
                                                            <th class="text-right">Total GST</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><strong>0% / NIL</strong></td>
                                                            <td class="text-right"><?php echo $currency.' '.$taxSlapSameStateArray[0]['TaxableAmount']; 
                                                            $gstAmount = 0; 
                                                            $TotalGST = $TotalGST + ($taxSlapSameStateArray[0]['TaxableAmount']+$gstAmount); 
                                                            ?></td>
                                                            <td class="text-right">0</td>
                                                            <td class="text-right">0</td>
                                                            <td class="text-center">--</td>
                                                            <td class="text-right"><?php echo $currency.' '.($taxSlapSameStateArray[0]['TaxableAmount']+$gstAmount); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>5%</strong></td>
                                                            <td class="text-right"><?php echo $currency.' '.$taxSlapSameStateArray[5]['TaxableAmount']; 
                                                                $gstAmount = 0;
                                                                $gstAmount = (($taxSlapSameStateArray[5]['TaxableAmount'] * 5)/100);
                                                                
                                                                $TotalGST = $TotalGST + ($taxSlapSameStateArray[5]['TaxableAmount']+$gstAmount);
                                                            ?></td>
                                                            <td class="text-right"><?php 
                                                                if($gstAmount>0) { echo $currency.' '.($gstAmount/2); $CGST = $CGST +($gstAmount/2); } 
                                                                else echo $currency.' 0';  
                                                            ?></td>
                                                            <td class="text-right"><?php 
                                                                if($gstAmount>0) { echo $currency.' '.($gstAmount/2); $SGST = $SGST +($gstAmount/2); }  
                                                                else echo $currency.' 0'; 
                                                            ?></td>
                                                            <td class="text-center">--</td>
                                                            <td class="text-right"><?php 
                                                                echo $currency.' '.($taxSlapSameStateArray[5]['TaxableAmount']+$gstAmount); 
                                                            ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>12%</strong></td>
                                                            <td class="text-right"><?php echo $currency.' '.$taxSlapSameStateArray[12]['TaxableAmount']; 
                                                                $gstAmount = 0;
                                                                $gstAmount = (($taxSlapSameStateArray[12]['TaxableAmount'] * 12)/100); 
                                                                $TotalGST = $TotalGST + ($taxSlapSameStateArray[12]['TaxableAmount']+$gstAmount);
                                                            ?></td>
                                                            <td class="text-right"><?php 
                                                                if($gstAmount>0) { echo $currency.' '.($gstAmount/2); $CGST = $CGST +($gstAmount/2); } 
                                                                else echo $currency.' 0';  
                                                            ?></td>
                                                            <td class="text-right"><?php 
                                                                if($gstAmount>0) { echo $currency.' '.($gstAmount/2); $SGST = $SGST +($gstAmount/2); }  
                                                                else echo $currency.' 0'; 
                                                            ?></td>
                                                            <td class="text-center">--</td>
                                                            <td class="text-right"><?php echo $currency.' '.($taxSlapSameStateArray[12]['TaxableAmount']+$gstAmount); ?></td>
                                                        </tr>
                                                        <!--<tr>
                                                            <td><strong>18%</strong></td>
                                                            <td class="text-right"><?php // echo $currency.' '.$taxSlapSameStateArray[18]['TaxableAmount']; 
                                                                $gstAmount = 0;
                                                                $gstAmount = (($taxSlapSameStateArray[18]['TaxableAmount'] * 18)/100);
                                                                $TotalGST = $TotalGST + ($taxSlapSameStateArray[18]['TaxableAmount']+$gstAmount);
                                                            ?></td>
                                                            <td class="text-right"><?php 
                                                             //   if($gstAmount>0) { echo $currency.' '.($gstAmount/2); $CGST = $CGST +($gstAmount/2); } 
                                                               // else echo $currency.' 0';  
                                                            ?></td>
                                                            <td class="text-right"><?php 
                                                               // if($gstAmount>0) { echo $currency.' '.($gstAmount/2); $SGST = $SGST +($gstAmount/2); }  
                                                               // else echo $currency.' 0'; 
                                                            ?></td>
                                                            <td class="text-center">--</td>
                                                            <td class="text-right"><?php // echo $currency.' '.($taxSlapSameStateArray[18]['TaxableAmount']+$gstAmount); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>28%</strong></td>
                                                            <td class="text-right"><?php // echo $currency.' '.$taxSlapSameStateArray[28]['TaxableAmount'];
                                                                $gstAmount = 0;
                                                                $gstAmount = (($taxSlapSameStateArray[28]['TaxableAmount'] * 28)/100);
                                                                $TotalGST = $TotalGST + ($taxSlapSameStateArray[28]['TaxableAmount']+$gstAmount);
                                                            ?></td>
                                                            <td class="text-right"><?php 
                                                               // if($gstAmount>0) { echo $currency.' '.($gstAmount/2); $CGST = $CGST +($gstAmount/2); } 
                                                               // else echo $currency.' 0';  
                                                            ?></td>
                                                            <td class="text-right"><?php 
                                                               // if($gstAmount>0) { echo $currency.' '.($gstAmount/2); $SGST = $SGST +($gstAmount/2); }  
                                                               // else echo $currency.' 0'; 
                                                            ?></td>
                                                            <td class="text-center">--</td>
                                                            <td class="text-right"><?php // echo $currency.' '.($taxSlapSameStateArray[28]['TaxableAmount']+$gstAmount); ?></td>
                                                        </tr>-->
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Total</th>
                                                            <th class="text-right"><?php echo $currency.' '.$TaxableAmount; ?></th>
                                                            <th class="text-right"><?php echo $currency.' '.$CGST; ?></th>
                                                            <th class="text-right"><?php echo $currency.' '.$SGST; ?></th>
                                                            <th class="text-center">--</th>
                                                            <th class="text-right"><?php echo $currency.' '.$TotalGST; ?></th>
                                                        </tr>
                                                    </tfoot>
                                                </table><?php 
		                                    }
                                            else{
    	                                        $TaxableAmount =  0; $IGST =  0; $TotalGST  =  0; 
    	                                        $TaxableAmount = $TaxableAmount + $taxSlapNotSameStateArray[0]['TaxableAmount'];
    	                                        $TaxableAmount = $TaxableAmount + $taxSlapNotSameStateArray[5]['TaxableAmount'];
    	                                        $TaxableAmount = $TaxableAmount + $taxSlapNotSameStateArray[12]['TaxableAmount'];
    	                                        $TaxableAmount = $TaxableAmount + $taxSlapNotSameStateArray[18]['TaxableAmount'];
    	                                        $TaxableAmount = $TaxableAmount + $taxSlapNotSameStateArray[28]['TaxableAmount'];
    		                                    ?><table class="table table-striped table-bordered" cellspacing="0" width="100%" id="InvList"> 
                                                    <thead>
                                                        <tr>
                                                            <th>Class</th>
                                                            <th class="text-right">Taxable Amount</th>
                                                            <th class="text-center">CGST</th>
                                                            <th class="text-center">SGST</th>
                                                            <th class="text-right">IGST</th>
                                                            <th class="text-right">Total GST</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><strong>0% / NIL</strong></td>
                                                            <td class="text-right"><?php echo $currency.' '.$taxSlapNotSameStateArray[0]['TaxableAmount'];
                                                                $gstAmount = 0;
                                                                $TotalGST = $TotalGST + ($taxSlapNotSameStateArray[0]['TaxableAmount']+$gstAmount);
                                                            ?></td>
                                                            <td class="text-center">--</td>
                                                            <td class="text-center">--</td>
                                                            <td class="text-right"><?php 
                                                                if($gstAmount>0) { echo $currency.' '.$gstAmount; $IGST = $IGST +$gstAmount; }  
                                                                else echo $currency.' 0'; 
                                                            ?></td>
                                                            <td class="text-right"><?php echo $currency.' '.($taxSlapNotSameStateArray[0]['TaxableAmount']+$gstAmount); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>5%</strong></td>
                                                            <td class="text-right"><?php echo $currency.' '.$taxSlapNotSameStateArray[5]['TaxableAmount'];
                                                                $gstAmount = 0;
                                                                $gstAmount = (($taxSlapNotSameStateArray[5]['TaxableAmount'] * 5)/100);
                                                                $TotalGST = $TotalGST + ($taxSlapNotSameStateArray[5]['TaxableAmount']+$gstAmount);
                                                            ?></td>
                                                            <td class="text-center">--</td>
                                                            <td class="text-center">--</td>
                                                            <td class="text-right"><?php 
                                                                if($gstAmount>0) { echo $currency.' '.$gstAmount; $IGST = $IGST +$gstAmount; }  
                                                                else echo $currency.' 0'; 
                                                            ?></td>
                                                            <td class="text-right"><?php echo $currency.' '.($taxSlapNotSameStateArray[5]['TaxableAmount']+$gstAmount); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>12%</strong></td>
                                                            <td class="text-right"><?php echo $currency.' '.$taxSlapNotSameStateArray[12]['TaxableAmount'];
                                                                $gstAmount = 0;
                                                                $gstAmount = (($taxSlapNotSameStateArray[12]['TaxableAmount'] * 12)/100);
                                                                $TotalGST = $TotalGST + ($taxSlapNotSameStateArray[12]['TaxableAmount']+$gstAmount);
                                                            ?></td>
                                                            <td class="text-center">--</td>
                                                            <td class="text-center">--</td>
                                                            <td class="text-right"><?php 
                                                                if($gstAmount>0) { echo $currency.' '.$gstAmount; $IGST = $IGST +$gstAmount; }  
                                                                else echo $currency.' 0'; 
                                                            ?></td>
                                                            <td class="text-right"><?php echo $currency.' '.($taxSlapNotSameStateArray[12]['TaxableAmount']+$gstAmount); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>18%</strong></td>
                                                            <td class="text-right"><?php echo $currency.' '.$taxSlapNotSameStateArray[18]['TaxableAmount'];
                                                                $gstAmount = 0;
                                                                $gstAmount = (($taxSlapNotSameStateArray[18]['TaxableAmount'] * 18)/100);
                                                                $TotalGST = $TotalGST + ($taxSlapNotSameStateArray[18]['TaxableAmount']+$gstAmount);
                                                            ?></td>
                                                            <td class="text-center">--</td>
                                                            <td class="text-center">--</td>
                                                            <td class="text-right"><?php 
                                                                if($gstAmount>0) { echo $currency.' '.$gstAmount; $IGST = $IGST +$gstAmount; }  
                                                                else echo $currency.' 0'; 
                                                            ?></td>
                                                            <td class="text-right"><?php echo $currency.' '.($taxSlapNotSameStateArray[18]['TaxableAmount']+$gstAmount); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>28%</strong></td>
                                                            <td class="text-right"><?php echo $currency.' '.$taxSlapNotSameStateArray[28]['TaxableAmount'];
                                                                $gstAmount = 0;
                                                                $gstAmount = (($taxSlapNotSameStateArray[28]['TaxableAmount'] * 28)/100);
                                                                $TotalGST = $TotalGST + ($taxSlapNotSameStateArray[28]['TaxableAmount']+$gstAmount);
                                                            ?></td>
                                                            <td class="text-center">--</td>
                                                            <td class="text-center">--</td>
                                                            <td class="text-right"><?php 
                                                                if($gstAmount>0) { echo $currency.' '.$gstAmount; $IGST = $IGST +$gstAmount; }  
                                                                else echo $currency.' 0'; 
                                                            ?></td>
                                                            <td class="text-right"><?php echo $currency.' '.($taxSlapNotSameStateArray[28]['TaxableAmount']+$gstAmount); ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Total</th>
                                                            <th class="text-right"><?php echo $currency.' '.$TaxableAmount; ?></th>
                                                            <th class="text-center">--</th>
                                                            <th class="text-center">--</th>
                                                            <th class="text-right"><?php echo $currency.' '.$IGST; ?></th>
                                                            <th class="text-right"><?php echo $currency.' '.$TotalGST; ?></th>
                                                        </tr>
                                                    </tfoot>
                                                </table><?php
                                            }
                                        ?></div>
		                            </div>
    		                        <div class="col-xs-4" style="display: inline-block;">
    				                    <table class="table">
                                            <tr>
                                                <th style="border-top: 0; border-bottom: 0;"><?php echo display('total_discount') ?> : </th>
                                                <td class="text-right" style="border-top: 0; border-bottom: 0;"><?php echo (($position == 0) ? "$currency {total_discount}" : "{total_discount} $currency") ?> </td>
                                            </tr>
                                            <tr>
                                                <th style="border-top: 0; border-bottom: 0;">Taxable Amount : </th>
                                                <td class="text-right" style="border-top: 0; border-bottom: 0;"><?php echo $currency.' '.$TaxableAmount; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="border-top: 0; border-bottom: 0;">Tax Amount : </th>
                                                <td class="text-right" style="border-top: 0; border-bottom: 0;"><?php echo $currency.' '.$gstTotalAmount; ?></td>
                                            </tr>
                                           <!-- <tr style="display:none">
                                                <th class="text-left grand_total"><?php // echo display('previous'); ?> :</th>
                                                <td class="text-right grand_total"><?php // echo (($position == 0) ? "$currency {previous}" : "{previous} $currency") ?></td>
                                            </tr>-->
                                            <tr>
                                                <th colspan="2"></th>
                                            </tr>
                                            <tr>
                                                <th style="border-top: 0; border-bottom: 0;">Grand Total : </th>
                                                <td class="text-right" style="border-top: 0; border-bottom: 0;"><?php echo $currency.' '.$grandTotalAmount; ?></td>
                                            </tr>
                                            <!--<tr style="display:none">
                                                <th class="text-left grand_total" style="border-top: 0; border-bottom: 0;"><?php // echo display('paid_ammount') ?> : </th>
                                                <td class="text-right grand_total" style="border-top: 0; border-bottom: 0;"><?php // echo (($position == 0) ? "$currency {paid_amount}" : "{paid_amount} $currency") ?></td>
                                            </tr>--><?php
                                            if ($invoice_all_data[0]['due_amount'] != 0) {
                                                ?><!--<tr style="display:none">
                                                    <th class="text-left grand_total"><?php // echo display('due') ?> : </th>
                                                    <td  class="text-right grand_total"><?php // echo (($position == 0) ? "$currency {due_amount}" : "{due_amount} $currency") ?></td>
                                                </tr>--><?php
                                            }
                                        ?></table>
    		                        </div>
		                        </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <img src="https://app.maurnaturo.com/bank.png" style="width: 100%;">
                                    </div>
                                </div>
		                        <!-- <div class="row">
		                        	<div class="col-sm-4">
		                        		 <div style="float:left;width:40%;text-align:center;border-top:1px solid #e4e5e7;margin-top: 100px;font-weight: bold;">
											<?php //echo display('received_by') ?>
										</div>
		                        	</div>
		                        	<div class="col-sm-4"></div>
		                        	<div class="col-sm-4">
		                        	    <div  style="float:right;width:40%;text-align:center;border-top:1px solid #e4e5e7;margin-top: 100px;font-weight: bold;">
										    <?php //echo display('authorised_by') ?>
									    </div>
									</div>
		                        </div>
		                        <hr>
		                        <div class="row">
    		                        	<div class="col-sm-6">
    	                        			<div style="padding-left: 30px;">
        		                        		<b>Payment Details</b> <br >
        		                        		BANK : PUNJAB & SIND BANK <br />
        		                        		IFSC : PSIB0000871 <br />
        		                        		A/C No : 08711300007106 <br />
        		                        		PHONEPE : 9571616729
                                            </div>
    		                        	</div>
    		                        	<div class="col-sm-6">
    	                        			<b>Trems & Conditions</b> <br />
    	                        			<p>* All Disputes Subject to JAIPUR Jurisdication</p>
    	                        			<p>* E.& O.E.</p>
    		                        	</div>
    		                        </div> -->
    	                    </div>
    	                </div>
                         <div class="panel-footer text-left">
                         	<a  class="btn btn-danger" href="<?php echo base_url('Cinvoice');?>"><?php echo display('cancel') ?></a>
    						<button  class="btn btn-info" onclick="printDiv('printableArea')"><span class="fa fa-print"></span></button>
                        </div>
                    </div>
                </div>
            </div><?php
        }
        else{
            ?><div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('You do not have permission to access. Please contact with administrator.');?></h4>
                        </div>
                    </div>
                </div>
            </div><?php
        }
    ?></section> <!-- /.content -->
</div> <!-- /.content-wrapper -->



