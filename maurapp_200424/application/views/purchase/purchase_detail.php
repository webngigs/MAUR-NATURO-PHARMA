<!-- Purchase Payment Ledger Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('purchase') ?></h1>
	        <small><?php echo display('purchase_detail') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('purchase') ?></a></li>
	            <li class="active"><?php echo display('purchase_detail') ?></li>
	        </ol>
	    </div>
	</section>

	<!-- Invoice information -->
	<section class="content">

		<!-- Alert Message -->
	    <?php
	        $message = $this->session->userdata('message');
	        if (isset($message)) {
	    ?>
	    <div class="alert alert-info alert-dismissable">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	        <?php echo $message ?>                    
	    </div>
	    <?php 
	        $this->session->unset_userdata('message');
	        }
	        $error_message = $this->session->userdata('error_message');
	        if (isset($error_message)) {
	    ?>
	    <div class="alert alert-danger alert-dismissable">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	        <?php echo $error_message ?>                    
	    </div>
	    <?php 
	        $this->session->unset_userdata('error_message');
	        }
	    ?>
	    <div class="row">
            <div class="col-sm-12">
                <div class="column">
                    <?php
                    if($this->permission1->method('add_purchase','create')->access()){ ?>
                        <a href="<?php echo base_url('Cpurchase')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_purchase')?> </a>
                    <?php
                    } ?>

                    <?php
                    if($this->permission1->method('manage_purchase','read')->access() || $this->permission1->method('manage_purchase','update')->access() || $this->permission1->method('manage_purchase','delete')->access()){ ?>
                        <a href="<?php echo base_url('Cpurchase/manage_purchase')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_purchase')?> </a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <?php
        if( $this->permission1->method('manage_purchase','read')->access()){ ?>
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('purchase_information') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
	  					<div style="float:left">
							<th width="100%" colspan="5" style="font-weight:normal">
				        	{company_info}
				        	<h5> <u> {company_name}</u> </h5> 
				        	{/company_info}
				        	 <?php echo display('manufacturer_name') ?> : &nbsp;<span style="font-weight:normal">{manufacturer_name}</span>  <span style="margin-left:800px;float:right"><?php echo display('manufacturer_invoice') ?> </span> <br />
				            Date :&nbsp;{final_date} <br /><?php echo display('invoice_no') ?> :&nbsp; {chalan_no}<br> <?php echo display('details') ?> :&nbsp;{purchase_details} 
				            </th>
						</div>
		            </div>
		        </div>
		    </div>
		</div>

		<!-- Purchase Ledger -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('purchase_information') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th><?php echo display('sl') ?></th>
										<th><?php echo display('product_name') ?></th>
										<th><?php echo display('quantity') ?></th>
										<th><?php echo display('purchase_price') ?></th>
										<th class="text-center"><?php echo display('ammount') ?></th>
	                                    <th class="text-center"><?php echo display('discount_percentage') ?> %</th>
										<th class="text-right"><?php echo display('total_ammount') ?></th>
									</tr>
								</thead>
								<tbody><?php
								$TotalAmount = 0;
								if($purchase_all_data) {
								    foreach($purchase_all_data as $dts){
								        $rate = $dts['rate'];
								        $quantity = $dts['quantity'];
								        $total_amount = $dts['total_amount'];
								        $TotalAmount = $TotalAmount + $total_amount;
    								    ?><tr>
    										<td><?php echo $dts['sl']; ?></td>
    										<td>
    											<a href="<?php echo base_url().'Cproduct/product_details/'.$dts['product_id']; ?>">
    											    <?php echo $dts['product_name'].' - '.$dts['strength']; ?>
    											</a>
    										</td>
    										<td style="text-align: right"><?php echo $dts['quantity']; ?></td>
    										<td style="text-align: right;"><?php echo (($position==0)?"$currency $rate":"$rate $currency") ?></td>
    										<td style="text-align: right"><?php echo $currency.' '.$rate*$quantity;  ?></td>
    										<td style="text-align: center"><?php echo $dts['discount']; ?></td>
    										<td style="text-align:right;padding-right:20px !important;"><?php echo $currency.' '.$total_amount; ?></td>
    									</tr><?php
    								}
								}
								?></tbody>
		                    </table>
		                </div>
		                
		                <div class="row">
		                    <div class="col-md-8"></div>
		                    <div class="col-md-4">
		                        <div class="table-responsive">    
        		                    <table class="table">
                                        <tr>
                                            <td style="border-top: 0; border-bottom: 0; width:65%" align="right"><strong>Total Amount : </strong></td>
                                            <td class="text-right" style="border-top: 0; border-bottom: 0; width:35%"><?php echo $currency.' '.$TotalAmount; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border-top: 0; border-bottom: 0;" align="right"><strong>Total Discount : </strong></td>
                                            <td class="text-right" style="border-top: 0; border-bottom: 0;"><?php echo $currency.' '.$total_discount; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border-top: 0; border-bottom: 0;" align="right"><strong>Total Tax  : </strong></td>
                                            <td class="text-right" style="border-top: 0; border-bottom: 0;"><?php echo $currency.' '.$total_tax; ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2"></th>
                                        </tr>
                                        <tr>
                                            <td style="border-top: 0; border-bottom: 0;" align="right"><strong>Grand Total : </strong></td>
                                            <td class="text-right" style="border-top: 0; border-bottom: 0;"><?php echo $currency.' '.$grand_total_amount; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
		            </div>
		        </div>
		    </div>
		</div>
            <?php
        }
        else{
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
<!-- Purchase ledger End  -->