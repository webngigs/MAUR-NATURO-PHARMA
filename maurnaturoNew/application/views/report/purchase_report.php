<!-- Stock report start -->
<script type="text/javascript">
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
	document.body.style.marginTop="0px";
    window.print();
    document.body.innerHTML = originalContents;
}
</script>


<!-- Purchase Report Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('purchase_report') ?></h1>
	        <small><?php echo display('total_purchase_report')?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('report') ?></a></li>
	            <li class="active"><?php echo display('purchase_report') ?></li>
	        </ol>
	    </div>
	</section>

	<section class="content">

		<div class="row">
            <div class="col-sm-12">
                <div class="column">

                    <?php
                    if($this->permission1->method('todays_report','read')->access()){ ?>
                        <a href="<?php echo base_url('Admin_dashboard/all_report')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('todays_report')?> </a>
                    <?php } ?>

                    <?php
                    if($this->permission1->method('sales_report','read')->access()){ ?>
                        <a href="<?php echo base_url('Admin_dashboard/todays_sales_report')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('sales_report')?> </a>
                    <?php } ?>

                    <?php
                    if($this->permission1->method('sales_report_medicine_wise','read')->access()){ ?>
                        <a href="<?php echo base_url('Admin_dashboard/product_sales_reports_date_wise')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('sales_report_product_wise')?> </a>
                    <?php } ?>

                </div>
            </div>
        </div>

        <?php
        if($this->permission1->method('purchase_report','read')->access()){ ?>
		<!-- Purchase report -->
		<div class="row">
			<div class="col-sm-12">
		        <div class="panel panel-default">
		            <div class="panel-body"> 
		                <?php echo form_open('Admin_dashboard/retrieve_dateWise_PurchaseReports',array('class' => 'form-inline'))?>
		                <?php date_default_timezone_set("Asia/Dhaka"); $today = date('Y-m-d'); ?>
		                    <div class="form-group">
		                        <label class="" for="from_date"><?php echo display('start_date') ?></label>
		                        <input type="text" name="from_date" class="form-control datepicker" id="from_date" placeholder="<?php echo display('start_date') ?>" >
		                    </div> 

		                    <div class="form-group">
		                        <label class="" for="to_date"><?php echo display('end_date') ?></label>
		                        <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>" value="<?php echo $today?>">
		                    </div>  

		                    <button type="submit" class="btn btn-success"><?php echo display('search') ?></button>
		                    <a  class="btn btn-warning" href="#" onclick="printDiv('purchase_div')"><?php echo display('print') ?></a>
		               <?php echo form_close()?>
		            </div>
		        </div>
		    </div>
	    </div>

		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('purchase_report') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		            	<div id="purchase_div" style="margin-left:2px;">
			            	<div class="text-center">
								{company_info}
								<h3> {company_name} </h3>
								<h4 >{address} </h4>
								{/company_info}
								<h4> <?php echo display('print_date') ?>: <?php echo date("d/m/Y h:i:s"); ?> </h4>
							</div>
			                <div class="table-responsive">
			                    <table class="table table-bordered table-striped table-hover">
			                        <thead>
										<tr>
											<th style="text-align: center;"><?php echo display('sales_date') ?></th>
											<th><?php echo display('invoice_no') ?></th>
											<th><?php echo display('manufacturer_name') ?></th>
											<th style="text-align: right;">Taxable Amount</th>
											<th style="text-align: center;">CGST</th>
											<th style="text-align: center;">SGST</th>
											<th style="text-align: center;">IGST</th>
											<th style="text-align: right;"><?php echo display('total_ammount') ?></th>
										</tr>
									</thead>
									<tbody><?php
			                        $TaxableAmount  =   0;
			                        $CGST           =   0;
			                        $SGST           =   0;
			                        $IGST           =   0;
			                        $TotakAmount    =   0;
		                        	if($purchase_report) {
		                        	    foreach($purchase_report as $rdata){
		                        	        $TaxableAmount = $TaxableAmount + ($rdata['grand_total_amount'] - $rdata['total_tax']);
		                        	        $TotakAmount = $TotakAmount + $rdata['grand_total_amount'];
			                                ?><tr>
												<td style="text-align: center;"><?php echo $rdata['prchse_date']; ?></td>
												<td>
													<a href="<?php echo base_url().'cpurchase/purchase_details_data/'.$rdata['purchase_id']; ?>"><?php echo $rdata['chalan_no']; ?></a>
												</td>
												<td><?php echo $rdata['manufacturer_name']; ?></td>
												<td style="text-align: right;"><?php echo $currency.' '.($rdata['grand_total_amount'] - $rdata['total_tax']); ?></td>
    											<td style="text-align: right;"><?php 
        											if($rdata['state_code'] == $admin_state_code)    { echo $currency.' '.($rdata['total_tax']/2);  $CGST = $CGST + ($rdata['total_tax']/2); }   
        											else echo '--';
    											?></td>
    											<td style="text-align: right;"><?php 
        											if($rdata['state_code'] == $admin_state_code)    { echo $currency.' '.($rdata['total_tax']/2);  $SGST = $SGST + ($rdata['total_tax']/2); }     
        											else echo '--';
    											?></td>
    											<td style="text-align: right;"><?php 
        											if($rdata['state_code'] != $admin_state_code)    { echo $currency.' '.$rdata['total_tax'];    $IGST = $IGST + $rdata['total_tax']; }   
        											else echo '--';
    											?></td>
												<td style="text-align: right;"><?php echo $currency.' '.$rdata['grand_total_amount']; ?></td>
											</tr><?php
		                        	    }
									}
									?></tbody>
									<tfoot>
										<tr>
											<td colspan="3" align="right"  style="text-align:right;font-size:14px !Important">&nbsp;<b><?php echo display('total_sales') ?>:</b></td>
											<td style="text-align: right;"><b><?php echo $currency.' '.$TaxableAmount; ?></b></td>
											<td style="text-align: right;"><b><?php echo $currency.' '.$CGST; ?></b></td>
											<td style="text-align: right;"><b><?php echo $currency.' '.$SGST; ?></b></td>
											<td style="text-align: right;"><b><?php echo $currency.' '.$IGST; ?></b></td>
											<td style="text-align: right;"><b><?php echo $currency.' '.$TotakAmount; ?></b></td>
										</tr>
									</tfoot>
			                    </table>
			                </div>
			            </div>
			            <div class="text-right"><?php echo $links?></div>
		            </div>
		        </div>
		    </div>
		</div>
        <?php
        }else{
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('You do not have permission to access. Please contact with administrator.');?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
	</section>
</div>
 <!-- Purchase Report End -->