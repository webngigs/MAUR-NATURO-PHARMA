<!-- Add New MR start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('mr') ?></h1>
            <small><?php echo display('add_new_mr') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('mr') ?></a></li>
                <li class="active"><?php echo display('add_mr') ?></li>
            </ol>
        </div>
    </section>

    <section class="content"><?php
        $message = $this->session->userdata('message');
        if(isset($message)) {
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

        ?><div class="row">
            <div class="col-sm-12">
                <div class="column"><?php
                    if($this->permission1->method('manage_mr','read')->access()) { 
                        ?><a href="<?php echo base_url('Cmr/manage_mr')?>" class="btn btn-info m-b-5 m-r-2">
                            <i class="ti-align-justify"> </i> <?php echo display('manage_mr')?> 
                        </a><?php 
                    } 
                ?></div>
            </div>
        </div><?php
        if($this->permission1->method('add_mr','create')->access()) { 
            ?><div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('add_mr') ?> </h4>
                            </div>
                        </div><?php 
                        echo form_open('Cmr/insert_mr', array('class' => 'form-vertical','id' => 'insert_mr'))
                        ?><div class="panel-body">
                            <div class="form-group row">
                                <label for="mr_name" class="col-sm-3 col-form-label"><?php echo display('mr_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="mr_name" id="mr_name" type="text" placeholder="<?php echo display('mr_name') ?>"  required="" tabindex="1">
                                </div>
                            </div>   
                            <div class="form-group row">
                                <label for="mr_email" class="col-sm-3 col-form-label"><?php echo display('mr_email') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="mr_email" id="mr_email" type="email" placeholder="<?php echo display('mr_email') ?>" required tabindex="2"> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_password" class="col-sm-3 col-form-label"><?php echo display('mr_password') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="mr_password" id="mr_password" type="password" placeholder="<?php echo display('mr_password') ?>" required tabindex="2"> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_mobile" class="col-sm-3 col-form-label"><?php echo display('mr_mobile') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="mr_mobile" id="mr_mobile" type="text" placeholder="<?php echo display('mr_mobile') ?>" required minlength="10" maxlength="10" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_address " class="col-sm-3 col-form-label"><?php echo display('mr_address') ?></label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="mr_address" id="mr_address" rows="3" placeholder="<?php echo display('mr_address') ?>" tabindex="4"></textarea>
                                </div>
                            </div>
                              <div class="form-group row">
                                <label for="mr_reference_by_joining" class="col-sm-3 col-form-label"><?php echo display('mr_reference_by_joining') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="reference_by_joining" id="reference_by_joining" type="text" placeholder="<?php echo display('mr_reference_by_joining') ?>" tabindex="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_joining_date" class="col-sm-3 col-form-label"><?php echo display('mr_joining_date') ?></label>
                                <div class="col-sm-6">
                                    <input class="datepicker form-control" name="joining_date" id="joining_date" type="text" placeholder="<?php echo display('mr_joining_date') ?>" readonly tabindex="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_area_cover" class="col-sm-3 col-form-label"><?php echo display('mr_area_cover') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="area_cover" id="area_cover" type="text" placeholder="<?php echo display('mr_area_cover') ?>" tabindex="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_police_verfication_date" class="col-sm-3 col-form-label"><?php echo display('mr_police_verfication_date') ?></label>
                                <div class="col-sm-6">
                                    <input class="datepicker form-control" name="police_verfication_date" id="police_verfication_date" type="text" placeholder="<?php echo display('mr_police_verfication_date') ?>" readonly tabindex="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_police_verfication_no" class="col-sm-3 col-form-label"><?php echo display('mr_police_verfication_no') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="police_verfication_no" id="police_verfication_no" type="text" placeholder="<?php echo display('mr_police_verfication_no') ?>" tabindex="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_id_proff" class="col-sm-3 col-form-label"><?php echo display('mr_id_proff') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="id_proff" id="id_proff" type="file" placeholder="<?php echo display('mr_id_proff') ?>" tabindex="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_photo" class="col-sm-3 col-form-label"><?php echo display('mr_photo') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="mr_photo" id="mr_photo" type="file" placeholder="<?php echo display('mr_photo') ?>" tabindex="1">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="pancard" class="col-sm-3 col-form-label"><?php echo display('pancard') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="pancard" id="pancard" type="text" placeholder="<?php echo display('pancard') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="aadharcard" class="col-sm-3 col-form-label"><?php echo display('aadharcard') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="aadharcard" id="aadharcard" type="text" placeholder="<?php echo display('aadharcard') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="idno" class="col-sm-3 col-form-label"><?php echo display('idno') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="idno" id="idno" type="text" placeholder="<?php echo display('idno') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_whatsapp_no" class="col-sm-3 col-form-label"><?php echo display('mr_whatsapp_no') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="whatsapp_no" id="whatsapp_no" type="text" placeholder="<?php echo display('mr_whatsapp_no') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_other_contact_no" class="col-sm-3 col-form-label"><?php echo display('mr_other_contact_no') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="other_contact_no" id="other_contact_no" type="text" placeholder="<?php echo display('mr_other_contact_no') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="account_holder_name" class="col-sm-3 col-form-label"><?php echo display('account_holder_name') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="account_holder_name" id="account_holder_name" type="text" placeholder="<?php echo display('account_holder_name') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="account_number" class="col-sm-3 col-form-label"><?php echo display('account_number') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="account_number" id="account_number" type="text" placeholder="<?php echo display('account_number') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bank_name" class="col-sm-3 col-form-label"><?php echo display('bank_name') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="bank_name" id="bank_name" type="text" placeholder="<?php echo display('bank_name') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ifsc_code" class="col-sm-3 col-form-label"><?php echo display('ifsc_code') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="ifsc_code" id="ifsc_code" type="text" placeholder="<?php echo display('ifsc_code') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-6">
                                    <input type="submit" id="add-mr" class="btn btn-primary btn-large" name="add-mr" value="<?php echo display('save') ?>" tabindex="7"/>
                                    <input type="submit" value="<?php echo display('save_and_add_another') ?>" name="add-mr-another" class="btn btn-large btn-success" id="add-mr-another" tabindex="6">
                                </div>
                            </div>
                        </div><?php 
                        echo form_close()
                    ?></div>
                </div>
            </div><?php
        }
        else{
            ?><div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('You do not have permission to access. Please contact with administrator.');?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div><?php
        }
    ?></section>
</div>
<!-- Add New MR end -->