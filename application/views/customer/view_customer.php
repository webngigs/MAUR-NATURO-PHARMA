<!--Edit customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Customer Details</h1>
            <small>Customer Details</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('customer') ?></a></li>
                <li class="active">Details</li>
            </ol>
        </div>
    </section>
    <section class="content"><?php
        if($this->permission1->method('manage_customer','update')->access()) { 
            ?><div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4>Customer Details</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group row">
                                <label for="customer_types" class="col-sm-4 col-form-label"><?php echo display('customer_types') ?><i class="text-danger">*</i></label>
                                <div class="col-sm-6"><label><?php echo $customer_types; ?></label></div>
                            </div>
                        	<div class="form-group row">
                                <label for="customer_name" class="col-sm-4 col-form-label"><?php echo display('customer_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6"><label><?php if(!empty($customer_name)) echo $customer_name; else echo '--'; ?></label></div>
                            </div>
       
                           	<div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label"><?php echo display('customer_email') ?></label>
                                <div class="col-sm-6"><label><?php if(!empty($customer_email)) echo $customer_email; else echo '--'; ?></label></div>
                            </div>
    
                            <div class="form-group row">
                                <label for="mobile" class="col-sm-4 col-form-label"><?php echo display('customer_mobile') ?></label>
                                <div class="col-sm-6"><label><?php if(!empty($customer_mobile)) echo $customer_mobile; else echo '--'; ?></label></div>
                            </div>
       
                            <div class="form-group row">
                                <label for="customer_address " class="col-sm-4 col-form-label"><?php echo display('customer_address') ?></label>
                                <div class="col-sm-6"><label><?php if(!empty($customer_address)) echo $customer_address; else echo '--'; ?></label></div>
                            </div>
                            <div class="form-group row">
                                <label for="customer_area" class="col-sm-4 col-form-label"><?php echo display('customer_area') ?></label>
                                <div class="col-sm-6"><label><?php if(!empty($area)) echo $area; else echo '--'; ?></label></div>
                            </div>
                            <div class="form-group row">
                                <label for="customer_district" class="col-sm-4 col-form-label"><?php echo display('customer_district') ?></label>
                                <div class="col-sm-6"><label><?php if(!empty($district)) echo $district; else echo '--'; ?></label></div>
                            </div>
                            <div class="form-group row">
                                <label for="customer_state" class="col-sm-4 col-form-label"><?php echo display('customer_state') ?></label>
                                <div class="col-sm-6"><label><?php if(!empty($state)) echo $state; else echo '--'; ?></label></div>
                            </div>
                            <div class="form-group row">
                                <label for="state_code" class="col-sm-4 col-form-label"><?php echo display('state_code') ?></label>
                                <div class="col-sm-6"><label><?php if(!empty($state_code)) echo $state_code; else echo '--'; ?></label></div>
                            </div>
                            <div class="form-group row">
                                <label for="customer_gst_no" class="col-sm-4 col-form-label"><?php echo display('customer_gst_no') ?></label>
                                <div class="col-sm-6"><label><?php if(!empty($gst_no)) echo $gst_no; else echo '--'; ?></label></div>
                            </div>
                            <div class="form-group row">
                                <label for="pancard" class="col-sm-4 col-form-label"><?php echo display('pancard') ?></label>
                                <div class="col-sm-6"><label><?php if(!empty($pancard)) echo $pancard; else echo '--'; ?></label></div>
                            </div>
                            <div class="form-group row">
                                <label for="rvc_no" class="col-sm-4 col-form-label"><?php echo display('rvc_no') ?></label>
                                <div class="col-sm-6"><label><?php if(!empty($rvc_no)) echo $rvc_no; else echo '--'; ?></label></div>
                            </div>
                            <div class="form-group row">
                                <label for="customer_birthday_date" class="col-sm-4 col-form-label"><?php echo display('customer_birthday_date') ?></label>
                                <div class="col-sm-6"><label><?php if(!empty($birthday_date)) echo $birthday_date; else echo '--'; ?></label></div>
                            </div>
                            <div class="form-group row">
                                <label for="customer_marriage_anniversary_date" class="col-sm-4 col-form-label"><?php echo display('customer_marriage_anniversary_date') ?></label>
                                <div class="col-sm-6"><label><?php if(!empty($marriage_anniversary_date)) echo $marriage_anniversary_date; else echo '--'; ?></label></div>
                            </div>
                            <div class="form-group row">
                                <label for="customer_total_sale" class="col-sm-4 col-form-label"><?php echo display('customer_total_sale') ?></label>
                                <div class="col-sm-6"><label><?php if(!empty($total_sale)) echo $total_sale; else echo '--'; ?></label></div>
                            </div>
                            <div class="form-group row">
                                <label for="customer_discount" class="col-sm-4 col-form-label"><?php echo display('customer_discount') ?></label>
                                <div class="col-sm-6"><label><?php if(!empty($discount)) echo $discount; else echo '--'; ?></label></div>
                            </div>
                            <div class="form-group row">
                                <label for="customer_comment " class="col-sm-4 col-form-label"><?php echo display('customer_comment') ?></label>
                                <div class="col-sm-6"><label><?php if(!empty($customer_comment)) echo $customer_comment; else echo '--'; ?></label></div>
                            </div>
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
    ?></section>
</div>
<!-- Edit customer end -->

