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
<div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header perheader">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('proforma_invoice_details') ?></h1>
            <small><?php echo display('proforma_invoice_details') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('proforma_invoice') ?></a></li>
                <li class="active"><?php echo display('proforma_invoice_details') ?></li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
    	<!-- Alert Message -->
	    <?php
		$message = $this->session->userdata('message');
		if (isset($message)) {
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
	    if($this->permission1->method('manage_proforma_invoice','read')->access() ){ 
			?><div class="row">
				<div class="col-sm-12">
					<div class="panel panel-bd">
						<div id="printableArea">
							<div class="panel-body">
								 <div class="row">
	                        	{company_info}
	                            <div class="col-sm-7 col-xs-7" style="display: inline-block;">
	                                 <img src="<?php if (isset($Web_settings[0]['invoice_logo'])) {echo $Web_settings[0]['invoice_logo']; }?>" class="" alt="" style="margin-bottom:20px">
	                                <br>
	                                <span class="label label-success-outline m-r-15 p-10" ><?php echo display('billing_from') ?></span>
	                                <address style="margin-top:10px">
	                                    <strong>{company_name}</strong><br>
	                                    {address}<br>
	                                    <abbr><b><?php echo display('mobile') ?>:</b></abbr> {mobile}<br>
	                                    <abbr><b><?php echo display('email') ?>:</b></abbr>
	                                    {email}<br>
	                                    <abbr><b><?php echo display('website') ?>:</b></abbr>
	                                    {website}
	                                    {/company_info}
	                                </address>
	                            </div>
	                            
	                            
	                            <div class="col-sm-5 col-xs-5 text-left" style="display: inline-block;">
	                                <h2 class="m-t-0">Performa <?php echo display('invoice') ?></h2>
	                              <div><?php echo display('proforma_no') ?>: {proforma_no}</div>
										<div class="m-b-15"><?php echo display('proforma_invoice_date') ?>: {final_date}</div>


	                                <span class="label label-success-outline m-r-15"><?php echo display('billing_to') ?></span>

	                                  <address style="margin-top:10px;">
	                                    <strong>{customer_name} </strong><br>
	                                    <?php if ($customer_address) { ?>
		                                {customer_address}
		                                <?php } ?>
	                                    <br>
	                                    <abbr><b><?php echo display('mobile') ?>:</b></abbr>
	                                    <?php if ($customer_mobile) { ?>
	                                    {customer_mobile}
	                                    <?php }if ($customer_email) {
	                                    ?>
	                                    <br>
	                                    <abbr><b><?php echo display('email') ?>:</b></abbr>
	                                    {customer_email}
	                                   	<?php } ?>
	                                   	<?php if ($gst_no) { ?>
		                                <b> GST No : </b> {gst_no}
		                                <?php } ?>

		                                 <br>

		                                <?php if ($pancard) { ?>
		                                <b> PAN CARD : </b> {pancard}
		                                <?php } ?>
	                                    <br>

	                                    <?php if ($rvc_no) { ?>
		                                <b> <?php echo display('rvc_no') ?> : </b> {rvc_no}
		                                <?php } ?>
	                                    <br>
	                                </address>
	                            </div>
	                        </div> <hr>

	                        <style>
	                        	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
	                        		    padding: 7px 5px;
	                        	}
	                        	@page  {
  margin: 0;
}
	                        </style>
								<div class="table-responsive m-b-20">
									<table class="table table-striped table-bordered">
										<thead>
	                                    <tr>
	                                        <th class="text-center" width="3%"><?php echo display('sl') ?></th>
	                                        <th class="text-center" width="20%"><?php echo display('Particulars') ?></th>
	                                        <th class="text-center" width="5%">Pack</th>
	                                        <th class="text-center" width="6%">HSN</th>

	                                        <th class="text-center" width="5%">Qty</th>
	                                        <th class="text-center" width="8%"><?php echo display('Batch_ID') ?></th>
	                                        <th class="text-center" width="7%">Exp</th>
	                                        <th class="text-right" width="6%">MRP</th>
	                                        <?php if ($discount_type == 1) { ?>
	                                        <th class="text-center" width="5%">DIS</th>
	                                        <?php }elseif($discount_type == 2){ ?>
	                                        <th class="text-center" width="5%">DIS</th>
	                                        <?php }elseif($discount_type == 3) { ?>
	                                        <th class="text-center" width="5%"><?php echo display('fixed_dis') ?> </th>
	                                        <?php } ?>

	                                        <th class="text-right" width="5%">Rate</th>
	                                        <th class="text-right" width="4%">GST</th>
	                                        <th class="text-right" width="8%">Total</th>
	                                    </tr>
	                                </thead>
										<tbody>
										<?php if(isset($invoice_all_data) && count($invoice_all_data)>0){
                                            foreach($invoice_all_data as $dts){
                                                $discountAmtor = $dts['item_rate'] - (($dts['item_rate'] * $dts['discount'])/100);
                                                $finalamtor = $discountAmtor * $dts['quantity'];
                                                $discountAmt = $dts['rate'] - (($dts['rate'] * $dts['discount'])/100);
                                                ?><tr>
    	                                    	<td class="text-center"><?php echo $dts['sl']; ?></td>
    	                                        <td class="text-center"><div><strong><?php echo $dts['product_name'].' - '.$dts['strength']; ?></strong></div></td>
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
	                                </tbody>
										<tfoot>
	                                	<td style="border: 0px"></td>
	                                	<td align="center" colspan="1" style="border: 0px"><b><?php echo display('sub_total')?>:</b></td>
	                                	
	                                	<td style="border: 0px"></td>
	                                	<td style="border: 0px"></td>
	                                	<td align="center"  style="border: 0px"><b>{subTotal_quantity}</b></td>
	                                	<td style="border: 0px"></td>
	                                	<td style="border: 0px"></td>
	                                	<td style="border: 0px"></td>
	                                	<td style="border: 0px"></td>
	                                	<td style="border: 0px"></td>
	                                	<td style="border: 0px"></td>
	                                	<td class="text-right" align="center"  style="border: 0px"><b><?php echo (($position==0)?"{total_amount}":"{total_amount} $currency") ?></b></td>
	                                	
	                                </tfoot>
									</table>
								</div>
								<div class="row">
									<div class="col-xs-8" style="display: inline-block;width: 66%">
										<p></p>
										<p><strong>{invoice_details}</strong></p>		                               
									</div>
									<div class="col-xs-4" style="display: inline-block;">
										<table class="table"><?php
											if ($invoice_all_data[0]['total_discount'] != 0) {
												?><tr>
													<th style="border-top: 0; border-bottom: 0;"><?php echo display('total_discount') ?> : </th>
													<td class="text-right" style="border-top: 0; border-bottom: 0;"><?php echo (($position == 0) ? "$currency {total_discount}" : "{total_discount} $currency") ?> </td>
												</tr><?php
											} ?>
											<tr>
											<th class="text-left" style="border-top: 0; border-bottom: 0;">Taxable Value : </th>
													<td  class="text-right" style="border-top: 0; border-bottom: 0;"><?php echo (($position == 0) ? "$currency {subTotal_ammount}" : "{subTotal_ammount} $currency") ?> </td>
											</tr>
											<?php
											if ($invoice_all_data[0]['total_tax'] != 0) {
												?><tr>
													<th class="text-left" style="border-top: 0; border-bottom: 0;"><?php echo display('tax') ?> : </th>
													<td  class="text-right" style="border-top: 0; border-bottom: 0;"><?php echo (($position == 0) ? "$currency {total_tax}" : "{total_tax} $currency") ?> </td>
												</tr><?php 
											} 
											?>
											<tr>
												<th class="text-left grand_total"><?php echo display('grand_total') ?> :</th>
												<td class="text-right grand_total"><?php echo (($position == 0) ? "$currency {total_amount}" : "{total_amount} $currency") ?></td>
											</tr>
										</table>
									</div>
								</div>
								<div class="row">
                                    <div class="col-sm-12">
                                        <img src="https://app.maurnaturo.com/bank.png" style="width: 100%;">
                                    </div>
                                </div>
							</div>
						</div>
						<div class="panel-footer text-left"><?php 
				if(isset($convert_into_invoice) && $convert_into_invoice==0 && $user_type==1) {
					?><button  class="btn btn-success pull-right" data-toggle="tooltip" data-placement="left" title="Click to Convert Proform to Invoice" onclick="convertIntoInvoice(<?php echo $invoice_id; ?>);">Convert Invoice</button><?php 
				} 
							?><button  class="btn btn-info" onclick="printDiv('printableArea')"><span class="fa fa-print"></span></button>
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

<script>
	function convertIntoInvoice(invoice_id){
        if(confirm('Do you want to convert proforma to invoice?\nPress OK otherwise Cancel!')==true){
			var dataString = 'invoice_id='+invoice_id;
			$.ajax({
				type: "POST",
				url: '<?=base_url()?>Cproformainvoice/convertIntoInvoice',
				data: dataString,
				cache: false,
				dataType: 'json',
				success: function(data){
					if(data['status'] == true){
						window.location.href = '<?=base_url()?>Cinvoice/invoice_inserted_data/'+data['invoice_id'];		
					}
					else{
						alert('Error while Convert Proforma into Invoice!!');
					}
				}
			});
        }
    }
</script>