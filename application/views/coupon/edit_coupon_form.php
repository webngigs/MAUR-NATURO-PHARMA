<!--Edit coupon start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('coupon') ?></h1>
            <small><?php echo display('coupon_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('coupon') ?></a></li>
                <li class="active"><?php echo display('coupon_edit') ?></li>
            </ol>
        </div>
    </section>

    <section class="content"><?php
        $message = $this->session->userdata('message');
        if (isset($message)) {
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
        if($this->permission1->method('manage_coupon', 'update')->access()) { ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('coupon_edit') ?> </h4>
                            </div>
                        </div><?php 
                        echo form_open_multipart('Ccoupon/coupon_update',array('class' => 'form-vertical', 'id' => 'coupon_update'))
                        ?><div class="panel-body">
                            <div class="form-group row">
                                <label for="value" class="col-sm-3 col-form-label"><?php echo display('coupon_code') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="value" id="value" type="text"  value="{value}" placeholder="<?php echo display('coupon_code') ?>"  required="" value="{coupon_text}" tabindex="1">
                                    <input type="hidden" value="{value}" name="oldname">
                                </div>
                            </div>   
                            <div class="form-group row">
                                <label for="amount" class="col-sm-3 col-form-label"><?php echo display('amount') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="amount" value="{amount}" id="amount" type="amount" placeholder="<?php echo display('amount') ?>" tabindex="2">
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
                                <label for="start_date" class="col-sm-3 col-form-label"><?php echo display('start_date') ?></label>
                                <div class="col-sm-6">
                                    <input class="datepicker form-control" name ="start_date" value="{start_date}" id="start_date" type="start_date" placeholder="<?php echo display('start_date') ?>" min="0" tabindex="3">
                                </div>
                            </div>   
                            <div class="form-group row">
                                <label for="start_time " class="col-sm-3 col-form-label"><?php echo display('start_time') ?></label>
                                <div class="col-sm-6">
                                <input class="form-control" name ="start_time" value="{start_time}" id="start_time" type="start_time" placeholder="<?php echo display('start_time') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="expiry_date " class="col-sm-3 col-form-label"><?php echo display('expiry_date') ?></label>
                                <div class="col-sm-6">
                                <input class="datepicker form-control" name ="expiry_date" value="{expiry_date}" id="expiry_date" type="expiry_date" placeholder="<?php echo display('expiry_date') ?>" min="0" tabindex="3">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="expiry_time " class="col-sm-3 col-form-label"><?php echo display('expiry_time') ?></label>
                                <div class="col-sm-6">
                                <input class="form-control" name ="expiry_time" value="{expiry_time}" id="expiry_time" type="expiry_time" placeholder="<?php echo display('start_date') ?>" min="0" tabindex="3">
 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="minimum_purchase " class="col-sm-3 col-form-label"><?php echo display('minimum_purchase') ?></label>
                                <div class="col-sm-6">
                                <input class="form-control" name ="minimum_purchase" value="{minimum_purchase}" id="minimum_purchase" type="text" placeholder="<?php echo display('minimum_purchase') ?>" min="0" tabindex="3">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="no_of_uses " class="col-sm-3 col-form-label"><?php echo display('no_of_uses') ?></label>
                                <div class="col-sm-6">
                                <input class="form-control" name ="minimum_purchase" value="{no_of_uses}" id="no_of_uses" type="text" placeholder="<?php echo display('no_of_uses') ?>" min="0" tabindex="3">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="freq_of_use_per_customer " class="col-sm-3 col-form-label"><?php echo display('freq_of_use_per_customer') ?></label>
                                <div class="col-sm-6">
                                <input class="form-control" name ="freq_of_use_per_customer" value="{freq_of_use_per_customer}" id="freq_of_use_per_customer" type="text" placeholder="<?php echo display('freq_of_use_per_customer') ?>" min="0" tabindex="3">
 
                                </div>
                            </div>
                 
                            <input type="hidden" value="{id}" name="coupon_id">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-6">
                                    <input type="submit" id="add-coupon" class="btn btn-success btn-large" name="add-coupon" value="<?php echo display('save_changes') ?>" tabindex="5"/>
                                </div>
                            </div>
                        </div><?php 
                        echo form_close()
                    ?></div>
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
<!-- Edit coupon end -->