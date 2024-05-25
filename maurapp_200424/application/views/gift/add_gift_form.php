<!-- Add New gift start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('gift') ?></h1>
            <small><?php echo display('add_gift') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('gift') ?></a></li>
                <li class="active"><?php echo display('add_gift') ?></li>
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
                    if($this->permission1->method('manage_gift','read')->access()) { 
                        ?><a href="<?php echo base_url('Cgift/manage_gift')?>" class="btn btn-info m-b-5 m-r-2">
                            <i class="ti-align-justify"> </i> <?php echo display('manage_gift')?> 
                        </a><?php 
                    } 
                ?></div>
            </div>
        </div><?php
        if($this->permission1->method('add_gift','create')->access()) { 
            ?><div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('add_gift') ?> </h4>
                            </div>
                        </div><?php 
                        echo form_open('Cgift/insert_gift', array('class' => 'form-vertical','id' => 'insert_gift   '))
                        ?><div class="panel-body">
                            <div class="form-group row">
                                <label for="gift_name" class="col-sm-3 col-form-label"><?php echo display('gift_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="gift_name" id="gift_name" type="text" placeholder="<?php echo display('gift_name') ?>"  required="" tabindex="1">
                                </div>
                            </div>   
                            <div class="form-group row">
                                <label for="gift_photo" class="col-sm-3 col-form-label"><?php echo display('gift_photo') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="gift_photo" id="gift_photo" type="file" placeholder="<?php echo display('gift_photo') ?>" tabindex="2"> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gift_amount" class="col-sm-3 col-form-label"><?php echo display('worth') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="gift_amount" id="gift_amount" type="gift_amount" placeholder="<?php echo display('worth') ?>" tabindex="2"> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="minimum_target" class="col-sm-3 col-form-label"><?php echo display('points') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="minimum_target" id="minimum_target" type="minimum_target" placeholder="<?php echo display('points') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-6">
                                    <input type="submit" id="add-gift" class="btn btn-primary btn-large" name="add-gift" value="<?php echo display('save') ?>" tabindex="7"/>
                                    <input type="submit" value="<?php echo display('save_and_add_another') ?>" name="add-gift-another" class="btn btn-large btn-success" id="add-gift-another" tabindex="6">
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
<!-- Add New gift end -->