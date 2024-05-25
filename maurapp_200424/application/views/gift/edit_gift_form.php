<!--Edit gift start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('gift') ?></h1>
            <small><?php echo display('gift_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('gift') ?></a></li>
                <li class="active"><?php echo display('gift_edit') ?></li>
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
        if($this->permission1->method('manage_gift', 'update')->access()) { ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('gift_edit') ?> </h4>
                            </div>
                        </div><?php 
                        echo form_open_multipart('Cgift/gift_update',array('class' => 'form-vertical', 'id' => 'gift_update'))
                        ?><div class="panel-body">
                            <div class="form-group row">
                                <label for="gift_name" class="col-sm-3 col-form-label"><?php echo display('gift_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="gift_name" id="gift_name" type="text"  value="{name}" placeholder="<?php echo display('gift_name') ?>"  required="" value="{gift_name}" tabindex="1">
                                    <input type="hidden" value="{name}" name="oldname">
                                </div>
                            </div>   
                            <div class="form-group row">
                                <label for="gift_photo" class="col-sm-3 col-form-label"><?php echo display('gift_photo') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="gift_photo" id="gift_photo" type="file" placeholder="<?php echo display('gift_photo') ?>" tabindex="2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gift_amount" class="col-sm-3 col-form-label"><?php echo display('worth') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="gift_amount" value="{amount}" id="gift_amount" type="gift_amount" placeholder="<?php echo display('worth') ?>" tabindex="2"> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="minimum_target" class="col-sm-3 col-form-label"><?php echo display('points') ?></label>
                                <div class="col-sm-6">
                                    <input class=" form-control" name ="minimum_target" value="{mintarget}" id="minimum_target" type="minimum_target" placeholder="<?php echo display('points') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <input type="hidden" value="{id}" name="gift_id">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-6">
                                    <input type="submit" id="add-gift" class="btn btn-success btn-large" name="add-gift" value="<?php echo display('save_changes') ?>" tabindex="5"/>
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
<!-- Edit gift end -->