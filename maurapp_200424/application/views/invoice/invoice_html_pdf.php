<?php
$CI =& get_instance();
$CI->load->model('Web_settings');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();

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
		    <p><strong>GST Invoice</strong></p>
		    <?php echo display('invoice_no') ?>: <?php echo $invoice_no; ?><br/>
		    <?php echo 'Billing Date' ?>: <?php echo $final_date;
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
<br/><br/>
<table border="1" style="border:1px solid #0000; border-collapse:collapse; font-size:14px;" width="100%" cellpadding="2" cellspacing="1">
    <thead>
        <tr>
            <th class="text-center" width="3%"><?php echo display('sl') ?></th>
            <th class="text-left" width="18%"><?php echo display('Particulars') ?></th>
            <th class="text-center" width="6%">HSN</th>    	                                        
            <th class="text-center" width="8%"><?php echo display('Batch_ID') ?></th>
            <th class="text-center" width="7%">Expiry</th>
            <th width="6%">MRP</th>
            <?php if ($discount_type == 1) { ?>
            <th class="text-center" width="5%">DIS</th>
            <?php }elseif($discount_type == 2){ ?>
            <th class="text-center" width="5%">DIS</th>
            <?php }elseif($discount_type == 3) { ?>
            <th class="text-center" width="5%"><?php echo display('fixed_dis') ?> </th>
            <?php } ?>
            <th width="5%">Rate</th>
            <th class="text-center" width="5%">Qty</th>
            <th width="4%">GST</th>
           <!--  <th class="text-center" width="4%">GST Amount</th> -->
            <th width="8%">Total</th>
        </tr>
    </thead>
    <tbody><?php 
        $gstTotalAmount = 0; $grandTotalAmount = 0; $TotalAmount = 0; if(isset($invoice_all_data) && count($invoice_all_data)>0){
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
	?></tbody>
    <tfoot>
    	<td align="left" colspan="3" style="border: 0px"><b><?php echo display('sub_total')?>:</b></td>
    	<td style="border: 0px"></td>
    	<td style="border: 0px"></td>
    	<td style="border: 0px"></td>
    	<td style="border: 0px"></td>
    	<td style="border: 0px"></td>
    	<td align="center"  style="border: 0px"><b><?php echo $subTotal_quantity; ?></b></td>
    	<td style="border: 0px"></td>
    	<td align="right"  style="border: 0px"><b><?php echo $currency.' '.$grandTotalAmount; ?></b></td>
    </tfoot>
</table>
<br/><br/>
<table cellspacing="0" width="100%">
    <tr>
        <td width="55%" align="left" valign="top"><?php
        if($customer_state_code == $admin_state_code){ 
            $TaxableAmount =  0; $CGST =  0; $SGST =  0; $TotalGST  =  0; 
            $TaxableAmount = $TaxableAmount + $taxSlapSameStateArray[0]['TaxableAmount'];
            $TaxableAmount = $TaxableAmount + $taxSlapSameStateArray[5]['TaxableAmount'];
            $TaxableAmount = $TaxableAmount + $taxSlapSameStateArray[12]['TaxableAmount'];
            $TaxableAmount = $TaxableAmount + $taxSlapSameStateArray[18]['TaxableAmount'];
            $TaxableAmount = $TaxableAmount + $taxSlapSameStateArray[28]['TaxableAmount'];
            ?><table border="1" style="border:1px solid #0000; border-collapse:collapse; font-size:14px;" width="100%" cellpadding="2" cellspacing="1"> 
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Taxable Amount</th>
                        <th>CGST</th>
                        <th>SGST</th>
                        <th class="text-center">IGST</th>
                        <th>Total GST</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>0% / NIL</strong></td>
                        <td><?php echo $currency.' '.$taxSlapSameStateArray[0]['TaxableAmount']; 
                        $gstAmount = 0; 
                        $TotalGST = $TotalGST + ($taxSlapSameStateArray[0]['TaxableAmount']+$gstAmount); 
                        ?></td>
                        <td>0</td>
                        <td>0</td>
                        <td class="text-center">--</td>
                        <td><?php echo $currency.' '.($taxSlapSameStateArray[0]['TaxableAmount']+$gstAmount); ?></td>
                    </tr>
                    <tr>
                        <td><strong>5%</strong></td>
                        <td><?php echo $currency.' '.$taxSlapSameStateArray[5]['TaxableAmount']; 
                            $gstAmount = 0;
                            $gstAmount = (($taxSlapSameStateArray[5]['TaxableAmount'] * 5)/100);
                            
                            $TotalGST = $TotalGST + ($taxSlapSameStateArray[5]['TaxableAmount']+$gstAmount);
                        ?></td>
                        <td><?php 
                            if($gstAmount>0) { echo $currency.' '.($gstAmount/2); $CGST = $CGST +($gstAmount/2); } 
                            else echo $currency.' 0';  
                        ?></td>
                        <td><?php 
                            if($gstAmount>0) { echo $currency.' '.($gstAmount/2); $SGST = $SGST +($gstAmount/2); }  
                            else echo $currency.' 0'; 
                        ?></td>
                        <td class="text-center">--</td>
                        <td><?php 
                            echo $currency.' '.($taxSlapSameStateArray[5]['TaxableAmount']+$gstAmount); 
                        ?></td>
                    </tr>
                    <tr>
                        <td><strong>12%</strong></td>
                        <td><?php echo $currency.' '.$taxSlapSameStateArray[12]['TaxableAmount']; 
                            $gstAmount = 0;
                            $gstAmount = (($taxSlapSameStateArray[12]['TaxableAmount'] * 12)/100); 
                            $TotalGST = $TotalGST + ($taxSlapSameStateArray[12]['TaxableAmount']+$gstAmount);
                        ?></td>
                        <td><?php 
                            if($gstAmount>0) { echo $currency.' '.($gstAmount/2); $CGST = $CGST +($gstAmount/2); } 
                            else echo $currency.' 0';  
                        ?></td>
                        <td><?php 
                            if($gstAmount>0) { echo $currency.' '.($gstAmount/2); $SGST = $SGST +($gstAmount/2); }  
                            else echo $currency.' 0'; 
                        ?></td>
                        <td class="text-center">--</td>
                        <td><?php echo $currency.' '.($taxSlapSameStateArray[12]['TaxableAmount']+$gstAmount); ?></td>
                    </tr>
                    <tr>
                        <td><strong>18%</strong></td>
                        <td><?php echo $currency.' '.$taxSlapSameStateArray[18]['TaxableAmount']; 
                            $gstAmount = 0;
                            $gstAmount = (($taxSlapSameStateArray[18]['TaxableAmount'] * 18)/100);
                            $TotalGST = $TotalGST + ($taxSlapSameStateArray[18]['TaxableAmount']+$gstAmount);
                        ?></td>
                        <td><?php 
                            if($gstAmount>0) { echo $currency.' '.($gstAmount/2); $CGST = $CGST +($gstAmount/2); } 
                            else echo $currency.' 0';  
                        ?></td>
                        <td><?php 
                            if($gstAmount>0) { echo $currency.' '.($gstAmount/2); $SGST = $SGST +($gstAmount/2); }  
                            else echo $currency.' 0'; 
                        ?></td>
                        <td class="text-center">--</td>
                        <td><?php echo $currency.' '.($taxSlapSameStateArray[18]['TaxableAmount']+$gstAmount); ?></td>
                    </tr>
                    <tr>
                        <td><strong>28%</strong></td>
                        <td><?php echo $currency.' '.$taxSlapSameStateArray[28]['TaxableAmount'];
                            $gstAmount = 0;
                            $gstAmount = (($taxSlapSameStateArray[28]['TaxableAmount'] * 28)/100);
                            $TotalGST = $TotalGST + ($taxSlapSameStateArray[28]['TaxableAmount']+$gstAmount);
                        ?></td>
                        <td><?php 
                            if($gstAmount>0) { echo $currency.' '.($gstAmount/2); $CGST = $CGST +($gstAmount/2); } 
                            else echo $currency.' 0';  
                        ?></td>
                        <td><?php 
                            if($gstAmount>0) { echo $currency.' '.($gstAmount/2); $SGST = $SGST +($gstAmount/2); }  
                            else echo $currency.' 0'; 
                        ?></td>
                        <td class="text-center">--</td>
                        <td><?php echo $currency.' '.($taxSlapSameStateArray[28]['TaxableAmount']+$gstAmount); ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <th><?php echo $currency.' '.$TaxableAmount; ?></th>
                        <th><?php echo $currency.' '.$CGST; ?></th>
                        <th><?php echo $currency.' '.$SGST; ?></th>
                        <th class="text-center">--</th>
                        <th><?php echo $currency.' '.$TotalGST; ?></th>
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
            ?><table border="1" style="border:1px solid #0000; border-collapse:collapse; font-size:14px;" width="100%" cellpadding="2" cellspacing="1"> 
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Taxable Amount</th>
                        <th class="text-center">CGST</th>
                        <th class="text-center">SGST</th>
                        <th>IGST</th>
                        <th>Total GST</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>0% / NIL</strong></td>
                        <td><?php echo $currency.' '.$taxSlapNotSameStateArray[0]['TaxableAmount'];
                            $gstAmount = 0;
                            $TotalGST = $TotalGST + ($taxSlapNotSameStateArray[0]['TaxableAmount']+$gstAmount);
                        ?></td>
                        <td class="text-center">--</td>
                        <td class="text-center">--</td>
                        <td><?php 
                            if($gstAmount>0) { echo $currency.' '.$gstAmount; $IGST = $IGST +$gstAmount; }  
                            else echo $currency.' 0'; 
                        ?></td>
                        <td><?php echo $currency.' '.($taxSlapNotSameStateArray[0]['TaxableAmount']+$gstAmount); ?></td>
                    </tr>
                    <tr>
                        <td><strong>5%</strong></td>
                        <td><?php echo $currency.' '.$taxSlapNotSameStateArray[5]['TaxableAmount'];
                            $gstAmount = 0;
                            $gstAmount = (($taxSlapNotSameStateArray[5]['TaxableAmount'] * 5)/100);
                            $TotalGST = $TotalGST + ($taxSlapNotSameStateArray[5]['TaxableAmount']+$gstAmount);
                        ?></td>
                        <td class="text-center">--</td>
                        <td class="text-center">--</td>
                        <td><?php 
                            if($gstAmount>0) { echo $currency.' '.$gstAmount; $IGST = $IGST +$gstAmount; }  
                            else echo $currency.' 0'; 
                        ?></td>
                        <td><?php echo $currency.' '.($taxSlapNotSameStateArray[5]['TaxableAmount']+$gstAmount); ?></td>
                    </tr>
                    <tr>
                        <td><strong>12%</strong></td>
                        <td><?php echo $currency.' '.$taxSlapNotSameStateArray[12]['TaxableAmount'];
                            $gstAmount = 0;
                            $gstAmount = (($taxSlapNotSameStateArray[12]['TaxableAmount'] * 12)/100);
                            $TotalGST = $TotalGST + ($taxSlapNotSameStateArray[12]['TaxableAmount']+$gstAmount);
                        ?></td>
                        <td class="text-center">--</td>
                        <td class="text-center">--</td>
                        <td><?php 
                            if($gstAmount>0) { echo $currency.' '.$gstAmount; $IGST = $IGST +$gstAmount; }  
                            else echo $currency.' 0'; 
                        ?></td>
                        <td><?php echo $currency.' '.($taxSlapNotSameStateArray[12]['TaxableAmount']+$gstAmount); ?></td>
                    </tr>
                    <tr>
                        <td><strong>18%</strong></td>
                        <td><?php echo $currency.' '.$taxSlapNotSameStateArray[18]['TaxableAmount'];
                            $gstAmount = 0;
                            $gstAmount = (($taxSlapNotSameStateArray[18]['TaxableAmount'] * 18)/100);
                            $TotalGST = $TotalGST + ($taxSlapNotSameStateArray[18]['TaxableAmount']+$gstAmount);
                        ?></td>
                        <td class="text-center">--</td>
                        <td class="text-center">--</td>
                        <td><?php 
                            if($gstAmount>0) { echo $currency.' '.$gstAmount; $IGST = $IGST +$gstAmount; }  
                            else echo $currency.' 0'; 
                        ?></td>
                        <td><?php echo $currency.' '.($taxSlapNotSameStateArray[18]['TaxableAmount']+$gstAmount); ?></td>
                    </tr>
                    <tr>
                        <td><strong>28%</strong></td>
                        <td><?php echo $currency.' '.$taxSlapNotSameStateArray[28]['TaxableAmount'];
                            $gstAmount = 0;
                            $gstAmount = (($taxSlapNotSameStateArray[28]['TaxableAmount'] * 28)/100);
                            $TotalGST = $TotalGST + ($taxSlapNotSameStateArray[28]['TaxableAmount']+$gstAmount);
                        ?></td>
                        <td class="text-center">--</td>
                        <td class="text-center">--</td>
                        <td><?php 
                            if($gstAmount>0) { echo $currency.' '.$gstAmount; $IGST = $IGST +$gstAmount; }  
                            else echo $currency.' 0'; 
                        ?></td>
                        <td><?php echo $currency.' '.($taxSlapNotSameStateArray[28]['TaxableAmount']+$gstAmount); ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <th><?php echo $currency.' '.$TaxableAmount; ?></th>
                        <th class="text-center">--</th>
                        <th class="text-center">--</th>
                        <th><?php echo $currency.' '.$IGST; ?></th>
                        <th><?php echo $currency.' '.$TotalGST; ?></th>
                    </tr>
                </tfoot>
            </table><?php
        }
        ?></td>
        <td width="20%" align="right" valign="top"></td>
        <td width="25%" align="right" valign="top">
            <table width="100%" cellpadding="1" cellspacing="1" style="font-size:14px;">
                <tr>
                    <th align="right"><?php echo display('total_discount') ?> : </th>
                    <td align="right"><?php echo (($position == 0) ? "$currency {total_discount}" : "{total_discount} $currency") ?> </td>
                </tr>
                <tr>
                    <th align="right">Taxable Amount : </th>
                    <td align="right"><?php echo $currency.' '.$TaxableAmount; ?></td>
                </tr>
                <tr>
                    <th align="right">Tax Amount : </th>
                    <td align="right"><?php echo $currency.' '.$gstTotalAmount; ?></td>
                </tr>
                <tr>
                    <th colspan="2"><hr/></th>
                </tr>
                <tr>
                    <th align="right">Grand Total : </th>
                    <td align="right"><?php echo $currency.' '.$grandTotalAmount; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<p><img src="bank.png" width="100%" alt=""/></p>