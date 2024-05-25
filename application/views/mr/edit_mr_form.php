<!--Edit MR start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('mr') ?></h1>
            <small><?php echo display('mr_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('mr') ?></a></li>
                <li class="active"><?php echo display('mr_edit') ?></li>
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
        if($this->permission1->method('manage_mr', 'update')->access()) { ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('mr_edit') ?> </h4>
                            </div>
                        </div><?php 
                        echo form_open_multipart('Cmr/mr_update',array('class' => 'form-vertical', 'id' => 'mr_update'))
                        ?><div class="panel-body">
                            <div class="form-group row">
                                <label for="mr_name" class="col-sm-3 col-form-label"><?php echo display('mr_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="mr_name" id="mr_name" type="text" placeholder="<?php echo display('mr_name') ?>"  required="" value="{mr_name}" tabindex="1">
                                    <input type="hidden" value="{mr_name}" name="oldname">
                                </div>
                            </div>   
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label"><?php echo display('mr_email') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="mr_email" value="{mr_email}" id="mr_email" type="email" placeholder="<?php echo display('mr_email') ?>" tabindex="2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mobile" class="col-sm-3 col-form-label"><?php echo display('mr_mobile') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="mr_mobile" value="{mr_mobile}" id="mr_mobile" type="text" placeholder="<?php echo display('mr_mobile') ?>" min="0" tabindex="3">
                                </div>
                            </div>   
                            <div class="form-group row">
                                <label for="address " class="col-sm-3 col-form-label"><?php echo display('mr_address') ?></label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="mr_address" id="mr_address " rows="3" placeholder="<?php echo display('mr_address') ?>" tabindex="4">{mr_address} </textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_reference_by_joining" class="col-sm-3 col-form-label"><?php echo display('mr_reference_by_joining') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="reference_by_joining" id="reference_by_joining" value="{reference_by_joining}" type="text" placeholder="<?php echo display('mr_reference_by_joining') ?>" tabindex="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_joining_date" class="col-sm-3 col-form-label"><?php echo display('mr_joining_date') ?></label>
                                <div class="col-sm-6">
                                    <input class="datepicker form-control" name="joining_date" id="joining_date" value="{joining_date}" type="text" placeholder="<?php echo display('mr_joining_date') ?>" readonly tabindex="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_area_cover" class="col-sm-3 col-form-label"><?php echo display('mr_area_cover') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="area_cover" id="area_cover" value="{area_cover}" type="text" placeholder="<?php echo display('mr_area_cover') ?>" tabindex="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_police_verfication_date" class="col-sm-3 col-form-label"><?php echo display('mr_police_verfication_date') ?></label>
                                <div class="col-sm-6">
                                    <input class="datepicker form-control" name="police_verfication_date" id="police_verfication_date" value="{police_verfication_date}" type="text" placeholder="<?php echo display('mr_police_verfication_date') ?>" readonly tabindex="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_police_verfication_no" class="col-sm-3 col-form-label"><?php echo display('mr_police_verfication_no') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="police_verfication_no" id="police_verfication_no" value="{police_verfication_no}" type="text" placeholder="<?php echo display('mr_police_verfication_no') ?>" tabindex="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_id_proff" class="col-sm-3 col-form-label"><?php echo display('mr_id_proff') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="id_proff" id="id_proff" type="file" tabindex="1"><?php 
                                    if(isset($id_proff) && !empty($id_proff)){
                                        ?><img src="{id_proff}" style="width:95px; margin-top:5px;"/><?php 
                                    } 
                                ?></div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_photo" class="col-sm-3 col-form-label"><?php echo display('mr_photo') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="mr_photo" id="mr_photo" type="file" tabindex="1"><?php 
                                    if(isset($mr_photo) && !empty($mr_photo)){
                                        ?><img src="{mr_photo}" style="width:95px; margin-top:5px;"/><?php 
                                    } 
                                ?></div>
                            </div>
                            <div class="form-group row">
                                <label for="pancard" class="col-sm-3 col-form-label"><?php echo display('pancard') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="pancard" id="pancard" value="{pancard}" type="text" placeholder="<?php echo display('pancard') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="aadharcard" class="col-sm-3 col-form-label"><?php echo display('aadharcard') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="aadharcard" id="aadharcard" value="{aadharcard}" type="text" placeholder="<?php echo display('aadharcard') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="idno" class="col-sm-3 col-form-label"><?php echo display('idno') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="idno" id="idno" type="text" value="{idno}" placeholder="<?php echo display('idno') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_whatsapp_no" class="col-sm-3 col-form-label"><?php echo display('mr_whatsapp_no') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="whatsapp_no" id="whatsapp_no" value="{whatsapp_no}" type="text" placeholder="<?php echo display('mr_whatsapp_no') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mr_other_contact_no" class="col-sm-3 col-form-label"><?php echo display('mr_other_contact_no') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="other_contact_no" id="other_contact_no" value="{other_contact_no}" type="text" placeholder="<?php echo display('mr_other_contact_no') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="account_holder_name" class="col-sm-3 col-form-label"><?php echo display('account_holder_name') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="account_holder_name" id="account_holder_name" value="{account_holder_name}" type="text" placeholder="<?php echo display('account_holder_name') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="account_number" class="col-sm-3 col-form-label"><?php echo display('account_number') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="account_number" id="account_number" value="{account_number}" type="text" placeholder="<?php echo display('account_number') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bank_name" class="col-sm-3 col-form-label"><?php echo display('bank_name') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="bank_name" id="bank_name" type="text" value="{bank_name}" placeholder="<?php echo display('bank_name') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ifsc_code" class="col-sm-3 col-form-label"><?php echo display('ifsc_code') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="ifsc_code" id="ifsc_code" type="text" value="{ifsc_code}" placeholder="<?php echo display('ifsc_code') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <input type="hidden" value="{mr_id}" name="mr_id">
                            <input type="hidden" value="{user_id}" name="user_id">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-6">
                                    <input type="submit" id="add-mr" class="btn btn-success btn-large" name="add-mr" value="<?php echo display('save_changes') ?>" tabindex="5"/>
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
<!-- Edit MR end -->