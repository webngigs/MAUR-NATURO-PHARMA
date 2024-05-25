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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('purchase_detail') ?></h1>
            <small><?php echo display('purchase_detail') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('invoice') ?></a></li>
                <li class="active"><?php echo display('purchase_detail') ?></li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
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
	    if (isset($error_message)) {
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
	                        <div class="row">
	                        	{company_info}
	                            <div class="col-sm-8" style="display: inline-block;width: 64%">
	                                 <img src="<?php if (isset($Web_settings[0]['invoice_logo'])) {echo $Web_settings[0]['invoice_logo']; }?>" class="" alt="" style="margin-bottom:20px">
	                                <br>
	                                <span class="label label-success-outline m-r-15 p-10" ><?php echo display('billing_to') ?></span>
	                                <address style="margin-top:10px">
	                                    <strong>{company_name}</strong><br>
	                                    {address}<br>
	                                    <abbr><b><?php echo display('mobile') ?>:</b></abbr> {mobile}<br>
	                                    <abbr><b><?php echo display('email') ?>:</b></abbr>
	                                    {email}<br>
	                                    <abbr><b><?php echo display('website') ?>:</b></abbr>
	                                    {website}
	                                    {/company_info}<br>
	                                  
	                                </address>
	                            </div>
	                            <div class="col-sm-4 text-left" style="display: inline-block;margin-left: 5px;">
	                                <h2 class="m-t-0"><?php echo display('purchase') ?></h2>
	                                <div><?php echo display('voucher_no') ?>: <?php echo $purchase[0]['chalan_no'];?></div>
                                    <div><?php echo display('purchase_id') ?>: <?php echo $purchase[0]['purchase_id'];?></div>
	                                <div class="m-b-15"><?php echo display('billing_date') ?>: <?php echo $purchase[0]['purchase_date'];?></div>
	                                <span class="label label-success-outline m-r-15"><?php echo display('billing_from') ?></span>
                                    <address style="margin-top:10px;width: 300px">
                                        <strong><?php echo $manufacturer_info[0]['manufacturer_name']?> </strong><br><?php 
                                        if ($manufacturer_info[0]['address']) { echo $manufacturer_info[0]['address']; } 
                                        ?><br>
                                        <abbr><b><?php echo display('mobile') ?>:</b></abbr><?php 
                                        if($manufacturer_info[0]['mobile']) { 
                                            echo $manufacturer_info[0]['mobile'];
                                        }
                                        ?><br><abbr><b><?php echo display('gst') ?>:</b></abbr><?php
	                                    if($manufacturer_info[0]['gst']) { 
                                            echo $manufacturer_info[0]['gst'];
                                        }
                                    ?></address>
	                            </div>
	                        </div><hr>
	                        <div class="table-responsive m-b-20">
	                            <?php 
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
	                            ?>
	                            <table class="table table-striped table-bordered">
	                                <thead>
	                                    <tr>
	                                        <th class="text-center"><?php echo display('sl') ?></th>
	                                        <th class="text-center"><?php echo display('product_name') ?></th>
	                                        <th class="text-center"><?php echo display('quantity') ?></th>
	                                        <th class="text-center"><?php echo display('purchase_price') ?></th>
	                                        <th class="text-center"><?php echo display('ammount') ?></th>
	                                        <th class="text-center"><?php echo display('discount_percentage') ?> %</th>
	                                        <th class="text-right" width="4%">GST</th>
    	                                    <th class="text-center" width="4%">GST Amount</th>
	                                        <th class="text-center"><?php echo display('ammount') ?></th>
	                                    </tr>
	                                </thead>
	                                <tbody>
									<?php
									$sub_total = 0;
									$subqty = 0;
									$sl = 1;
									$ttlmAmount = 0;
									$gstTotalAmount = 0;
									 foreach($details as $purdetails){
									    $mAmount = $purdetails['quantity'] *$purdetails['rate'];
									    $ttlmAmount = $ttlmAmount + $mAmount;
									    ?><tr>
	                                    	<td class="text-center"><?php echo $sl;?></td>
	                                        <td class="text-center"><div><strong><?php echo $purdetails['product_name'].' - ('.$purdetails['strength'].')'; ?></strong></div></td>
	                                        <td align="center"><?php echo $purdetails['quantity']; $subqty += $purdetails['quantity']; ?></td>

	                                        <td align="center"><?php echo (($position==0)?$currency.' '.$purdetails['rate']:$purdetails['rate'].' '. $currency) ?></td>
	                                        <td class="text-right" align="center"><?php echo (($position==0)?$currency.' '.$mAmount:$mAmount.' '. $currency) ; ?></td>
	                                        <td align="center"><?php echo $purdetails['discount']; ?></td>
	                                        <td align="center"><?php echo $purdetails['tax0'].'%'; ?></td>
	                                        <td align="right"><?php 
	                                            $gstAmount = ((($mAmount-$purdetails['discount']) * $purdetails['tax0'])/100);
	                                            echo $currency.' '.$gstAmount; 
	                                            $gstTotalAmount = $gstTotalAmount+$gstAmount; 
	                                        ?></td>
	                                        <td align="right"><?php echo (($position==0)?$currency.' '.$purdetails['total_amount']:$purdetails['total_amount'].' '. $currency);
	                                        $sub_total += $purdetails['total_amount'];  ?></td>
	                                    </tr><?php 
	                                    $sl++;
	                                    
	                                    if($manufecturer_state_code == $admin_state_code){ 
    	                                    if($purdetails['tax0'] == '0.00')          {
    	                                        $taxSlapSameStateArray[0]['TaxableAmount']   =   $taxSlapSameStateArray[0]['TaxableAmount'] + ($mAmount-$purdetails['discount']);
    	                                    }
    	                                    else if($purdetails['tax0'] == '5.00'){     
    	                                        $taxSlapSameStateArray[5]['TaxableAmount']   =   $taxSlapSameStateArray[5]['TaxableAmount'] + ($mAmount-$purdetails['discount']);
    	                                    }
    	                                    else if($purdetails['tax0'] == '12.00'){   
    	                                        $taxSlapSameStateArray[12]['TaxableAmount']  =   $taxSlapSameStateArray[12]['TaxableAmount'] + ($mAmount-$purdetails['discount']);
    	                                    }
    	                                    else if($purdetails['tax0'] == '18.00'){    
    	                                        $taxSlapSameStateArray[18]['TaxableAmount']  =   $taxSlapSameStateArray[18]['TaxableAmount'] + ($mAmount-$purdetails['discount']);
    	                                    }
    	                                    else if($purdetails['tax0'] == '28.00'){   
    	                                        $taxSlapSameStateArray[28]['TaxableAmount']  =   $taxSlapSameStateArray[28]['TaxableAmount'] + ($mAmount-$purdetails['discount']);
    	                                    }
	                                    }
	                                    else{
    	                                    if($purdetails['tax0'] == '0.00')          {
    	                                        $taxSlapNotSameStateArray[0]['TaxableAmount']   =   $taxSlapNotSameStateArray[0]['TaxableAmount'] + ($mAmount-$purdetails['discount']);
    	                                    }
    	                                    else if($purdetails['tax0'] == '5.00'){     
    	                                        $taxSlapNotSameStateArray[5]['TaxableAmount']   =   $taxSlapNotSameStateArray[5]['TaxableAmount'] + ($mAmount-$purdetails['discount']);  
    	                                    }
    	                                    else if($purdetails['tax0'] == '12.00'){   
    	                                        $taxSlapNotSameStateArray[12]['TaxableAmount']  =   $taxSlapNotSameStateArray[12]['TaxableAmount'] + ($mAmount-$purdetails['discount']);
    	                                    }
    	                                    else if($purdetails['tax0'] == '18.00'){    
    	                                        $taxSlapNotSameStateArray[18]['TaxableAmount']  =   $taxSlapNotSameStateArray[18]['TaxableAmount'] + ($mAmount-$purdetails['discount']);
    	                                    }
    	                                    else if($purdetails['tax0'] == '28.00'){   
    	                                        $taxSlapNotSameStateArray[28]['TaxableAmount']  =   $taxSlapNotSameStateArray[28]['TaxableAmount'] + ($mAmount-$purdetails['discount']);
    	                                    }
	                                    }
                                    }
	                                ?></tbody>
	                                <tfoot>
	                                	<td align="center" colspan="1" style="border: 0px"><b><?php echo display('sub_total')?>:</b></td>
	                                	<td style="border: 0px"></td>
	                                	<td align="center"  style="border: 0px"><b><?php echo $subqty;?></b></td>
	                                	<td style="border: 0px"></td>
	                                	<td class="text-right" align="center"  style="border: 0px"><b><?php echo (($position==0)?$currency.' '. $ttlmAmount:$ttlmAmount.' '.$currency) ?></b></td>
	                                	<td style="border: 0px"></td>
	                                	<td style="border: 0px"></td>
	                                	<td class="text-right" align="center"  style="border: 0px"><b><?php echo (($position==0)?$currency.' '. $gstTotalAmount:$gstTotalAmount.' '.$currency) ?></b></td>
	                                	<td class="text-right" align="center"  style="border: 0px"><b><?php echo (($position==0)?$currency.' '. $sub_total:$sub_total.' '.$currency) ?></b></td>
	                                </tfoot>
	                            </table>
	                        </div>
	                        <div class="row">
	                        	<div class="col-xs-8" style="display: inline-block;width: 66%">
	                                <p><strong><?php echo $purchase[0]['purchase_details'];?></strong></p>
	                                <div class="table-responsive" ><?php 
	                                    if($manufecturer_state_code == $admin_state_code){ 
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
                                                        <td class="text-right"><?php echo $currency;?> 0</td>
                                                        <td class="text-right"><?php echo $currency;?> 0</td>
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
                                                    <tr>
                                                        <td><strong>18%</strong></td>
                                                        <td class="text-right"><?php echo $currency.' '.$taxSlapSameStateArray[18]['TaxableAmount']; 
                                                            $gstAmount = 0;
                                                            $gstAmount = (($taxSlapSameStateArray[18]['TaxableAmount'] * 18)/100);
                                                            $TotalGST = $TotalGST + ($taxSlapSameStateArray[18]['TaxableAmount']+$gstAmount);
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
                                                        <td class="text-right"><?php echo $currency.' '.($taxSlapSameStateArray[18]['TaxableAmount']+$gstAmount); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>28%</strong></td>
                                                        <td class="text-right"><?php echo $currency.' '.$taxSlapSameStateArray[28]['TaxableAmount'];
                                                            $gstAmount = 0;
                                                            $gstAmount = (($taxSlapSameStateArray[28]['TaxableAmount'] * 28)/100);
                                                            $TotalGST = $TotalGST + ($taxSlapSameStateArray[28]['TaxableAmount']+$gstAmount);
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
                                                        <td class="text-right"><?php echo $currency.' '.($taxSlapSameStateArray[28]['TaxableAmount']+$gstAmount); ?></td>
                                                    </tr>
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
                                        <th style="border-top: 0; border-bottom: 0;">Total Amount : </th>
                                        <td class="text-right" style="border-top: 0; border-bottom: 0;"><?php echo (($position == 0) ? $currency .' '.$sub_total : $sub_total.' '. $currency); ?> </td>
                                    </tr><?php
                                    if ($purchase[0]['total_discount'] != '') {
                                        ?><tr>
                                            <th style="border-top: 0; border-bottom: 0;"><?php echo display('total_discount') ?> : </th>
                                            <td class="text-right" style="border-top: 0; border-bottom: 0;"><?php echo (($position == 0) ? $currency .' '.$purchase[0]['total_discount'] : $purchase[0]['total_discount'].' '. $currency); ?> </td>
                                        </tr><?php 
                                    }
                                    
                                     ?>
                                     <tr>
                                        <th style="border-top: 0; border-bottom: 0;">Total Tax : </th>
                                        <td class="text-right" style="border-top: 0; border-bottom: 0;"><?php echo (($position == 0) ? $currency .' '.$purchase[0]['total_tax'] : $purchase[0]['total_tax'].' '. $currency); ?> </td>
                                    </tr>
                                     <tr>
                                        <th style="border-top: 0; border-bottom: 0;">Grand Total Amount : </th>
                                        <td class="text-right" style="border-top: 0; border-bottom: 0;"><?php echo (($position == 0) ? $currency .' '.$purchase[0]['grand_total_amount'] : $purchase[0]['grand_total_amount'].' '. $currency); ?> </td>
                                    </tr><?php 
                                    
                                    ?></table>
		                        </div>
		                        <div class="row">
		                        	<div class="col-sm-6">
		                        		 <div  style="float:left;width:40%;text-align:center;border-top:1px solid #e4e5e7;margin-top: 20px;font-weight: bold;">
												<?php echo display('received_by') ?>
										</div>
		                        	</div>
		                        	
		                        	<div class="col-sm-6">  <div  style="float:right;width:40%;text-align:center;border-top:1px solid #e4e5e7;margin-top: 20px;font-weight: bold;">
												<?php echo display('authorised_by') ?>
										</div></div>
		                        </div>
	                        </div>
	                    </div>
	                </div>

                     <div class="panel-footer text-left">
                     	<a  class="btn btn-danger" href="<?php echo base_url('Cinvoice');?>"><?php echo display('cancel') ?></a>
						<button  class="btn btn-info" onclick="printDiv('printableArea')"><span class="fa fa-print"></span></button>

                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        else{
        ?>
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('You do not have permission to access. Please contact with administrator.');?></h4>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->



