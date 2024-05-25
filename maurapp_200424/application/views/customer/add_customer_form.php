<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_customer') ?></h1>
            <small><?php echo display('add_new_customer') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('customer') ?></a></li>
                <li class="active"><?php echo display('add_customer') ?></li>
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
                    if($this->permission1->method('manage_customer','read')->access()) { ?>
                        <a href="<?php echo base_url('Ccustomer/manage_customer')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_customer')?> </a>
                    <?php } ?>

                    <?php
                    if($this->permission1->method('credit_customer','read')->access()) { ?>
                        <a href="<?php echo base_url('Ccustomer/credit_customer')?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('credit_customer')?> </a>
                    <?php } ?>

                    <?php
                    if($this->permission1->method('paid_customer','read')->access()) { ?>
                        <a href="<?php echo base_url('Ccustomer/paid_customer')?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('paid_customer')?> </a>
                    <?php } ?>
                    <button type="button" class="btn btn-info m-b-5 m-r-2" data-toggle="modal" data-target="#Customer_modal">Upload CSV</button>
                </div>
            </div>
        </div>


        <?php
        if($this->permission1->method('add_customer','create')->access()) { ?>
        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_customer') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open('Ccustomer/insert_customer', array('class' => 'form-vertical','id' => 'insert_customer'))?>
                    <div class="panel-body"><?php
                        
                        if($this->session->userdata('user_type') == '1'){ 
                            ?><div class="form-group row">
                                <label for="customer_types" class="col-sm-3 col-form-label"><?php echo display('mr_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input type="text" name="mr_name" class=" form-control" placeholder='<?php echo display('mr_name') ?>' id="mr_name" tabindex="1" onkeyup="mr_autocomplete()" value="" required  />
                                    <input id="autocomplete_mr_id" class="mr_hidden_value abc" type="hidden" name="mr_id"  value="{mr_id}">
                                </div>
                            </div><?php 
                        } 

                    ?><div class="form-group row">
                            <label for="customer_types" class="col-sm-3 col-form-label"><?php echo display('customer_types') ?><i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                               <select name="customer_types" id="customer_types" class="form-control">
                                <option value="Doctor">Doctor</option>
                                <option value="Medical Store">Medical Store</option>
                                <option value="Stocker">Stocker</option>
                                <option value="Sample">Sample</option>
                                <option value="Others">Others</option>
                               </select>
                            </div>
                        </div>
                    	<div class="form-group row">
                            <label for="customer_name" class="col-sm-3 col-form-label"><?php echo display('customer_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="customer_name" id="customer_name" type="text" placeholder="<?php echo display('customer_name') ?>"  required="" tabindex="1">
                            </div>
                        </div>
   
                       	<div class="form-group row">
                            <label for="customer_email" class="col-sm-3 col-form-label"><?php echo display('customer_email') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="customer_email" id="customer_email" type="email" placeholder="<?php echo display('customer_email') ?>" tabindex="2"> 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="customer_password" class="col-sm-3 col-form-label"><?php echo display('customer_password') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name="password" id="password" type="password" placeholder="<?php echo display('customer_password') ?>" tabindex="2"> 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="customer_mobile" class="col-sm-3 col-form-label"><?php echo display('customer_mobile') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="customer_mobile" id="customer_mobile" type="text" placeholder="<?php echo display('customer_mobile') ?>" min="0" tabindex="3">
                            </div>
                        </div>
   
                        <div class="form-group row">
                            <label for="customer_address " class="col-sm-3 col-form-label"><?php echo display('customer_address') ?></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="customer_address" id="customer_address " rows="3" placeholder="<?php echo display('customer_address') ?>" tabindex="4"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="previous_balance" class="col-sm-3 col-form-label"><?php echo display('previous_balance') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name="previous_balance" id="previous_balance" type="number" placeholder="<?php echo display('previous_balance') ?>" tabindex="5">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_area" class="col-sm-3 col-form-label"><?php echo display('customer_area') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="area" id="area" type="text" placeholder="<?php echo display('customer_area') ?>" min="0" tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_district" class="col-sm-3 col-form-label"><?php echo display('customer_district') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="district" id="district" type="text" placeholder="<?php echo display('customer_district') ?>" min="0" tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_state" class="col-sm-3 col-form-label"><?php echo display('customer_state') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="state" id="state" type="text" placeholder="<?php echo display('customer_state') ?>" min="0" tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="state_code" class="col-sm-3 col-form-label"><?php echo display('state_code') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="state_code" id="state_code" type="text" placeholder="<?php echo display('state_code') ?>" min="0" tabindex="3">
                            </div>
                        </div>
                      
                        <div class="form-group row">
                            <label for="customer_gst_no" class="col-sm-3 col-form-label"><?php echo display('customer_gst_no') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="gst_no" id="gst_no" type="text" placeholder="<?php echo display('customer_gst_no') ?>" min="0" tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pancard" class="col-sm-3 col-form-label"><?php echo display('pancard') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="pancard" id="pancard" type="text" placeholder="<?php echo display('pancard') ?>" tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="rvc_no" class="col-sm-3 col-form-label"><?php echo display('rvc_no') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="rvc_no" id="rvc_no" type="text" placeholder="<?php echo display('rvc_no') ?>" tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_marriage_anniversary_date" class="col-sm-3 col-form-label"><?php echo display('customer_marriage_anniversary_date') ?></label>
                            <div class="col-sm-6">
                                <input class="datepicker form-control" name ="marriage_anniversary_date" id="marriage_anniversary_date" type="text" placeholder="<?php echo display('customer_marriage_anniversary_date') ?>" readonly tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_total_sale" class="col-sm-3 col-form-label"><?php echo display('customer_total_sale') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="total_sale" id="total_sale" type="text" placeholder="<?php echo display('customer_total_sale') ?>" min="0" tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_discount" class="col-sm-3 col-form-label"><?php echo display('customer_discount') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="discount" id="discount" type="text" placeholder="<?php echo display('customer_discount') ?>" min="0" tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_comment " class="col-sm-3 col-form-label"><?php echo display('customer_comment') ?></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="text" id="text" rows="3" placeholder="<?php echo display('customer_comment') ?>" tabindex="4"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-customer" class="btn btn-primary btn-large" name="add-customer" value="<?php echo display('save') ?>" tabindex="7"/>
								<input type="submit" value="<?php echo display('save_and_add_another') ?>" name="add-customer-another" class="btn btn-large btn-success" id="add-customer-another" tabindex="6">
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
<div id="Customer_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Csv Customer</h4>
      </div>
      <div class="modal-body">

                <div class="panel panel-bd">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo 'CSV Customer'; ?></h4> 
                        </div>
                    </div>
                    
                    <div class="panel-body">
                        <div class="col-sm-12"><a href="<?php echo base_url('assets/data/csv/customer_csv_sample.csv') ?>" class="btn btn-primary pull-right"><i class="fa fa-download"></i> Download Sample File</a></div>
                      <?php echo form_open_multipart('Ccustomer/uploadCsv_Customer',array('class' => 'form-vertical', 'id' => 'validate','name' => 'insert_customer'))?>
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
<!-- Add new customer end -->

<script>
    function mr_autocomplete(sl) {
        var mr_id = $('#mr_id').val();
        var options = {
            minLength: 0,
            source: function( request, response ) {
                var mr_name = $('#mr_name').val();
                $.ajax({
                    url: "<?php echo base_url('Cdemandrequest/mr_autocomplete_on_add_customer')?>",
                    method: 'post',
                    dataType: "json",
                    data: {
                        term:request.term,
                        mr_id:mr_name,
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            focus: function( event, ui ) {
                $(this).val(ui.item.label);
                return false;
            },
            select: function( event, ui ) {
                $(this).parent().parent().find("#autocomplete_mr_id").val(ui.item.value); 
                var mr_id = ui.item.value;
                $(this).unbind("change");
                return false;
            }
        }
        //$('body').on('keypress.autocomplete', '#mr_name', function(){ 
            $('#mr_name').autocomplete(options); 
        //});
    }
</script>



