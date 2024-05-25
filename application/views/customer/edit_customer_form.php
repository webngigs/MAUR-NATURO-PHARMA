<!--Edit customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('customer_edit') ?></h1>
            <small><?php echo display('customer_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('customer') ?></a></li>
                <li class="active"><?php echo display('customer_edit') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- alert message -->
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

        <?php
        if($this->permission1->method('manage_customer','update')->access()) { ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('customer_edit') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('Ccustomer/customer_update',array('class' => 'form-vertical', 'id' => 'customer_update'))?>
                    <div class="panel-body">

                    <div class="form-group row">
                            <label for="customer_types" class="col-sm-3 col-form-label"><?php echo display('customer_types') ?><i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                               <select name="customer_types" id="customer_types" class="form-control">
                                <option value="Doctor" <?php if($customer_types == 'Doctor') echo 'selected="selected"'; ?>>Doctor</option>
                                <option value="Medical Store" <?php if($customer_types == 'Medical Store') echo 'selected="selected"'; ?>>Medical Store</option>
                                <option value="Stocker" <?php if($customer_types == 'Stocker') echo 'selected="selected"'; ?>>Stocker</option>
                                <option value="Sample" <?php if($customer_types == 'Sample') echo 'selected="selected"'; ?>>Sample</option>
                                <option value="Others" <?php if($customer_types == 'Others') echo 'selected="selected"'; ?>>Others</option>
                               </select>
                            </div>
                        </div>
                    	<div class="form-group row">
                            <label for="customer_name" class="col-sm-3 col-form-label"><?php echo display('customer_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="customer_name" id="customer_name" type="text" placeholder="<?php echo display('customer_name') ?>"  required="" value="{customer_name}" tabindex="1">
                                 <input type="hidden" value="{customer_name}" name="oldname">
                            </div>
                        </div>
   
                       	<div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label"><?php echo display('customer_email') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="customer_email" value="{customer_email}" id="email" type="email" placeholder="<?php echo display('customer_email') ?>" tabindex="2">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label"><?php echo display('customer_mobile') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="customer_mobile" value="{customer_mobile}" id="mobile" type="text" placeholder="<?php echo display('customer_mobile') ?>" min="0" tabindex="3">
                            </div>
                        </div>
   
                        <div class="form-group row">
                            <label for="customer_address " class="col-sm-3 col-form-label"><?php echo display('customer_address') ?></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="customer_address" id="customer_address " rows="3" placeholder="<?php echo display('customer_address') ?>" tabindex="4">{customer_address}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_area" class="col-sm-3 col-form-label"><?php echo display('customer_area') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="area" id="area" value="{area}" type="text" placeholder="<?php echo display('customer_area') ?>" min="0" tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_district" class="col-sm-3 col-form-label"><?php echo display('customer_district') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="district" id="district" value="{district}" type="text" placeholder="<?php echo display('customer_district') ?>" min="0" tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_state" class="col-sm-3 col-form-label"><?php echo display('customer_state') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="state" id="state" value="{state}" type="text" placeholder="<?php echo display('customer_state') ?>" min="0" tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="state_code" class="col-sm-3 col-form-label"><?php echo display('state_code') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="state_code" id="state_code" value="{state_code}" type="text" placeholder="<?php echo display('state_code') ?>" min="0" tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_gst_no" class="col-sm-3 col-form-label"><?php echo display('customer_gst_no') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" readonly name ="gst_no" id="gst_no" value="{gst_no}" type="text" placeholder="<?php echo display('customer_gst_no') ?>" min="0" tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pancard" class="col-sm-3 col-form-label"><?php echo display('pancard') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="pancard" id="pancard" type="text" value="{pancard}" placeholder="<?php echo display('pancard') ?>" tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="rvc_no" class="col-sm-3 col-form-label"><?php echo display('rvc_no') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="rvc_no" id="rvc_no" type="text" value="{rvc_no}" placeholder="<?php echo display('rvc_no') ?>" tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_birthday_date" class="col-sm-3 col-form-label"><?php echo display('customer_birthday_date') ?></label>
                            <div class="col-sm-6">
                                <input class="datepicker form-control" name ="birthday_date" id="birthday_date" value="{birthday_date}" type="text" placeholder="<?php echo display('customer_birthday_date') ?>" readonly tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_marriage_anniversary_date" class="col-sm-3 col-form-label"><?php echo display('customer_marriage_anniversary_date') ?></label>
                            <div class="col-sm-6">
                                <input class="datepicker form-control" name ="marriage_anniversary_date" id="marriage_anniversary_date" value="{marriage_anniversary_date}" type="text" placeholder="<?php echo display('customer_marriage_anniversary_date') ?>" readonly tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_total_sale" class="col-sm-3 col-form-label"><?php echo display('customer_total_sale') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="total_sale" id="total_sale" value="{total_sale}" type="text" placeholder="<?php echo display('customer_total_sale') ?>" min="0" tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_discount" class="col-sm-3 col-form-label"><?php echo display('customer_discount') ?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="discount" id="discount" value="{discount}" type="text" placeholder="<?php echo display('customer_discount') ?>" min="0" tabindex="3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_comment " class="col-sm-3 col-form-label"><?php echo display('customer_comment') ?></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="text" id="text" rows="3" placeholder="<?php echo display('customer_comment') ?>" tabindex="4">{text}</textarea>
                            </div>
                        </div>
                        <input type="hidden" value="{customer_id}" name="customer_id">
                        <input type="hidden" value="{user_ref_id}" name="user_ref_id">
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-Customer" class="btn btn-success btn-large" name="add-Customer" value="<?php echo display('save_changes') ?>" tabindex="5"/>
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
    </section>
</div>
<!-- Edit customer end -->

