<!-- Add new coupon start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_coupon') ?></h1>
            <small><?php echo display('add_new_coupon') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('coupon') ?></a></li>
                <li class="active"><?php echo display('add_coupon') ?></li>
            </ol>
        </div>
    </section>

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
                    if($this->permission1->method('manage_coupon','read')->access()) { ?>
                        <a href="<?php echo base_url('Ccoupon/manage_coupon')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_coupon')?> </a>
                    <?php } ?>

                </div>
            </div>
        </div>


        <?php
        if($this->permission1->method('add_coupon','create')->access()) { ?>
        <!-- New coupon -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_coupon') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open('Ccoupon/insert_coupon', array('class' => 'form-vertical','id' => 'insert_coupon'))?>
                    <div class="panel-body">

                    	<div class="form-group row">
                            <label for="value" class="col-sm-3 col-form-label"><?php echo display('coupon_code') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="value" id="value" type="text" placeholder="<?php echo display('coupon_code') ?>"  required="" tabindex="1">
                            </div>
                        </div>
   
                       	<div class="form-group row">
                            <label for="amount" class="col-sm-3 col-form-label"><?php echo display('amount') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="amount" id="amount" type="amount" placeholder="<?php echo display('amount') ?>" tabindex="2"> 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="types" class="col-sm-3 col-form-label"><?php echo display('coupon_types') ?></label>
                            <div class="col-sm-6">
                               <select name="types" id="types" class="form-control">
                                <option value="Percentage of total customer">Percentage of total customer</option>
                                <option value="Percentage of total customer">Fixed amount of total customer purchase</option>
                               </select>
                            </div>
                        </div>
   
                        <div class="form-group row">
                            <label for="start_date " class="col-sm-3 col-form-label"><?php echo display('start_date') ?></label>
                            <div class="col-sm-6">
                            <input class="datepicker form-control" name ="start_date" id="start_date" type="start_date" placeholder="<?php echo display('start_date') ?>" min="0" tabindex="3">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start_time" class="col-sm-3 col-form-label"><?php echo display('start_time') ?></label>
                            <div class="col-sm-6">
                                <input class="datetimepicker form-control" name="start_time" id="start_time" type="start_time" placeholder="<?php echo display('start_time') ?>" tabindex="5">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="expiry_date" class="col-sm-3 col-form-label"><?php echo display('expiry_date') ?></label>
                            <div class="col-sm-6">
                                <input class="datepicker form-control" name="expiry_date" id="expiry_date" type="expiry_date" placeholder="<?php echo display('expiry_date') ?>" tabindex="5">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="expiry_time" class="col-sm-3 col-form-label"><?php echo display('expiry_time') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name="expiry_time" id="expiry_time" type="expiry_time" placeholder="<?php echo display('expiry_time') ?>" tabindex="5">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="minimum_purchase" class="col-sm-3 col-form-label"><?php echo display('minimum_purchase') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name="minimum_purchase" id="minimum_purchase" type="text" placeholder="<?php echo display('minimum_purchase') ?>" tabindex="5">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_of_uses" class="col-sm-3 col-form-label"><?php echo display('no_of_uses') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name="no_of_uses" id="no_of_uses" type="text" placeholder="<?php echo display('no_of_uses') ?>" tabindex="5">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="freq_of_use_per_customer" class="col-sm-3 col-form-label"><?php echo display('freq_of_use_per_customer') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name="freq_of_use_per_customer" id="freq_of_use_per_customer" type="text" placeholder="<?php echo display('freq_of_use_per_customer') ?>" tabindex="5">
                            </div>
                        </div>

                      

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-coupon" class="btn btn-primary btn-large" name="add-coupon" value="<?php echo display('save') ?>" tabindex="7"/>
								<input type="submit" value="<?php echo display('save_and_add_another') ?>" name="add-coupon-another" class="btn btn-large btn-success" id="add-coupon-another" tabindex="6">
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
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
<div id="Coupon_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Csv Coupon</h4>
      </div>
      <div class="modal-body">

                <div class="panel panel-bd">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo 'CSV Coupon'; ?></h4> 
                        </div>
                    </div>
                    
                    <div class="panel-body">
                        <div class="col-sm-12"><a href="<?php echo base_url('assets/data/csv/coupon_csv_sample.csv') ?>" class="btn btn-primary pull-right"><i class="fa fa-download"></i> Download Sample File</a></div>
                      <?php echo form_open_multipart('Ccoupon/uploadCsv_Coupon',array('class' => 'form-vertical', 'id' => 'validate','name' => 'insert_coupon'))?>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="upload_csv_file" class="col-sm-4 col-form-label"><?php echo display('upload_csv_file') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="upload_csv_file" type="file" id="upload_csv_file" placeholder="<?php echo display('upload_csv_file') ?>" required>
                                    </div>
                                </div>
                            </div>
                        
                       <div class="col-sm-12">
                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                                <input type="submit" id="add-product" class="btn btn-primary btn-large" name="add-product" value="<?php echo display('submit') ?>" />
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                               
                            </div>
                        </div>
                        </div>
                          <?php echo form_close()?>
                    </div>
                    </div>
                  
               
     
      </div>
     
    </div>

  </div>
</div>
    </section>
</div>
<!-- Add new coupon end -->



