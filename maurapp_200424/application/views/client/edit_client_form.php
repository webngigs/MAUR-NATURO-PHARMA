<!--Edit MR start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('client') ?></h1>
            <small><?php echo display('client_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('client') ?></a></li>
                <li class="active"><?php echo display('client_edit') ?></li>
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
        if($this->permission1->method('manage_client', 'update')->access()) { ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('client_edit') ?> </h4>
                            </div>
                        </div><?php 
                        echo form_open_multipart('Cclient/client_update',array('class' => 'form-vertical', 'id' => 'client_update'))
                        ?><div class="panel-body">
                            <div class="form-group row">
                                <label for="client_name" class="col-sm-3 col-form-label"><?php echo display('client_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="client_name" id="client_name" type="text" placeholder="<?php echo display('client_name') ?>"  required="" value="{client_name}" tabindex="1">
                                    <input type="hidden" value="{client_name}" name="oldname">
                                </div>
                            </div>   
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label"><?php echo display('client_email') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="email" value="{client_email}" id="email" type="email" placeholder="<?php echo display('client_email') ?>" tabindex="2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mobile" class="col-sm-3 col-form-label"><?php echo display('client_mobile') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="mobile" value="{client_mobile}" id="mobile" type="text" placeholder="<?php echo display('client_mobile') ?>" min="0" tabindex="3">
                                </div>
                            </div>   
                            <div class="form-group row">
                                <label for="address " class="col-sm-3 col-form-label"><?php echo display('client_address') ?></label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="address" id="address " rows="3" placeholder="<?php echo display('client_address') ?>" tabindex="4">{client_address} </textarea>
                                </div>
                            </div>
                            <input type="hidden" value="{client_id}" name="client_id">
                            <input type="hidden" value="{user_ref_id}" name="user_ref_id">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-6">
                                    <input type="submit" id="add-client" class="btn btn-success btn-large" name="add-client" value="<?php echo display('save_changes') ?>" tabindex="5"/>
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