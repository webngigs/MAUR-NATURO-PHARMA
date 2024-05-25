<?php
$CI =& get_instance();
$CI->load->model('Web_settings');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
?><img src="6df0495d7bbcb1985f0064a807ad4e23.jpeg" alt=""/>
<table width="100%" cellpadding="3" cellspacing="1" style="font-size:14px;">
    <tr>
		<td align="left" valign="top" width="40%"><?php 
		foreach($company_info as $cinfo){
		    ?><p><strong><?php echo display('billing_from') ?></strong></p>
	        <strong><?php echo $cinfo['company_name']; ?></strong><br>
	        <?php echo $cinfo['address']; ?><br>
            <b><?php echo display('mobile') ?>: <?php echo $cinfo['mobile']; ?></b><br>
            <b><?php echo display('email') ?>: <?php echo $cinfo['email']; ?></b><br>
            <b><?php echo display('website') ?> <?php echo $cinfo['website']; ?>:</b><?php
		} 
		?></td>
		<td align="left" valign="top" width="30%">
		    <p><strong>Proforma Invoice</strong></p>
		    <?php echo display('proforma_no') ?>: <?php echo $proforma_no; ?><br/>
		    <?php echo 'Date' ?>: <?php echo $final_date;
        ?></td>
		<td align="left" valign="top" width="30%">
		    <p><strong><?php echo display('billing_to') ?></strong></p>
		    <strong>{customer_name} </strong><br>
            <?php if ($customer_address) { echo $customer_address; } ?><br>
            <b><?php echo display('mobile') ?>: </b><?php if ($customer_mobile) { echo $customer_mobile.'<br>'; }
            if ($customer_email) { echo '<b>Email: </b>'.$customer_email.'<br>'; }
            if ($gst_no) { echo '<b>GST No: </b>'.$gst_no.'<br>'; }
            if ($pancard) { echo '<b>PAN CARD: </b>'.$pancard.'<br>'; }
            if ($rvc_no) { echo '<b>'.display('rvc_no').'</b>: '.$rvc_no.'<br>'; }
        ?></td>
	</tr>
</table>
<table border="1" style="border:1px solid #0000; border-collapse:collapse; font-size:14px;" width="100%" cellpadding="2" cellspacing="1">
	<thead>
        <tr>
            <th><?php echo display('sl') ?></th>
            <th><?php echo display('Particulars') ?></th>
            <th>Pack</th>
            <th>HSN</th>
            <th>Qty</th>
            <th><?php echo display('Batch_ID') ?></th>
            <th>Exp</th>
            <th>MRP</th>
            <?php if ($discount_type == 1) { ?>
            <th>DIS</th>
            <?php }elseif($discount_type == 2){ ?>
            <th>DIS</th>
            <?php }elseif($discount_type == 3) { ?>
            <th><?php echo display('fixed_dis') ?> </th>
            <?php } ?>
            <th>Rate</th>
            <th>GST</th>
            <th>Total</th>
        </tr>
    </thead>
	<tbody><?php 
		if(isset($invoice_all_data) && count($invoice_all_data)>0){
            foreach($invoice_all_data as $dts){
                $discountAmtor = $dts['item_rate'] - (($dts['item_rate'] * $dts['discount'])/100);
                $finalamtor = $discountAmtor * $dts['quantity'];
                $discountAmt = $dts['rate'] - (($dts['rate'] * $dts['discount'])/100);
                ?><tr>
                	<td align="center"><?php echo $dts['sl']; ?></td>
                    <td><strong><?php echo $dts['product_name'].' - '.$dts['strength']; ?></strong></td>
                    <td align="center"><?php echo $dts['box_size']; ?></td>
                    <td align="center"><?php echo $dts['HSNcode']; ?></td>
                    <td align="center"><?php echo $dts['quantity']; ?></td>
                	<td align="center"><?php echo $dts['batch_id']; ?></td>
                	<td align="center"><?php echo $dts['expeire_date']; ?></td>
                	<td align="right"><?php 
                	    if($position==0)  echo $dts['item_rate'];
                	    else echo $dts['item_rate'].' '.$currency;
                    ?></td><?php 
                	if ($discount_type == 1) { ?><td align="center"><?php echo $dts['discount']; ?>%</td><?php }
                    else{ ?><td align="center"><?php 
                        if($position==0)  echo $dts['discount'];
                	    else echo $dts['discount'].' '.$currency;
                    ?></td><?php } 
                    ?><td align="right"><?php if($position==0)   echo $discountAmtor;  else echo $discountAmtor.' '.$currency; ?></td>
                    <td align="center"><?php $gstp = $dts['tax0']; $gst = $gstp; echo $gst.'%'; ?></td>
                    <td align="right"><?php $amt = $dts['total_price']; $taxr = $dts['tax']; $finalamt = $amt+$taxr; ?><?php 
                         if($position==0)  echo $finalamtor; else echo $finalamtor.' '.$currency;
                    ?></td>
                </tr><?php
            }
		}   
	?>
	<tfoot>
	    <tr>
        	<td style="border: 0px"></td>
        	<td align="center" colspan="1" style="border: 0px"><b>Sub Total:</b></td>
        	<td style="border: 0px"></td>
        	<td style="border: 0px"></td>
        	<td align="center"  style="border: 0px"><b><?php echo $subTotal_quantity; ?></b></td>
        	<td style="border: 0px"></td>
        	<td style="border: 0px"></td>
        	<td style="border: 0px"></td>
        	<td style="border: 0px"></td>
        	<td style="border: 0px"></td>
        	<td style="border: 0px"></td>
        	<td align="center"  style="border: 0px"><b><?php echo (($position==0)?"{total_amount}":"{total_amount} $currency") ?></b></td>
    	</tr>
    </tbody>
</table>
<table width="100%" cellpadding="1" cellspacing="1" style="font-size:14px;"><?php
	if($invoice_all_data[0]['total_discount'] != 0) {
		?><tr>
		    <td align="right" width="85%"><?php echo display('total_discount') ?>:</td>
			<td align="right" width="15%"><?php echo (($position == 0) ? "$currency {total_discount}" : "{total_discount} $currency") ?> </td>
		</tr><?php
	} 
	?><tr>
	    <td align="right" width="85%">Taxable Value:</td>
		<td align="right" width="15%"><?php echo (($position == 0) ? "$currency {subTotal_ammount}" : "{subTotal_ammount} $currency") ?> </td>
	</tr><?php
	if ($invoice_all_data[0]['total_tax'] != 0) {
		?><tr>
		    <td align="right" width="85%"><?php echo display('tax') ?>:</td>
			<td align="right" width="15%"><?php echo (($position == 0) ? "$currency {total_tax}" : "{total_tax} $currency") ?> </td>
		</tr><?php 
	} 
	?><tr>
	    <td align="right" width="85%"><?php echo display('grand_total') ?>:</td>
		<td align="right" width="15%"><?php echo (($position == 0) ? "$currency {total_amount}" : "{total_amount} $currency") ?></td>
	</tr>
</table>
<p><img src="bank.png" width="100%" alt=""/></p>
