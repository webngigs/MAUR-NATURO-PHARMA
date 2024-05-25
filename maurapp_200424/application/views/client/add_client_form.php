<!-- Add New MR start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('client') ?></h1>
            <small><?php echo display('add_new_client') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('client') ?></a></li>
                <li class="active"><?php echo display('add_client') ?></li>
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
                    if($this->permission1->method('manage_client','read')->access()) { 
                        ?><a href="<?php echo base_url('Cclient/manage_client')?>" class="btn btn-info m-b-5 m-r-2">
                            <i class="ti-align-justify"> </i> <?php echo display('manage_client')?> 
                        </a><?php 
                    } 
                ?></div>
            </div>
        </div><?php
        if($this->permission1->method('add_client','create')->access()) { 
            ?><div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('add_client') ?> </h4>
                            </div>
                        </div><?php 
                        echo form_open('Cclient/insert_client', array('class' => 'form-vertical','id' => 'insert_client'))
                        ?><div class="panel-body">
                            <div class="form-group row">
                                <label for="client_name" class="col-sm-3 col-form-label"><?php echo display('client_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="client_name" id="client_name" type="text" placeholder="<?php echo display('client_name') ?>"  required="" tabindex="1">
                                </div>
                            </div>   
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label"><?php echo display('client_email') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="email" id="email" type="email" placeholder="<?php echo display('client_email') ?>" tabindex="2"> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-3 col-form-label"><?php echo display('client_password') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name="password" id="password" type="password" placeholder="<?php echo display('client_password') ?>" tabindex="2"> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mobile" class="col-sm-3 col-form-label"><?php echo display('client_mobile') ?></label>
                                <div class="col-sm-6">
                                    <input class="form-control" name ="mobile" id="mobile" type="text" placeholder="<?php echo display('client_mobile') ?>" min="0" tabindex="3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address " class="col-sm-3 col-form-label"><?php echo display('client_address') ?></label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="address" id="address " rows="3" placeholder="<?php echo display('client_address') ?>" tabindex="4"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-6">
                                    <input type="submit" id="add-client" class="btn btn-primary btn-large" name="add-client" value="<?php echo display('save') ?>" tabindex="7"/>
                                    <input type="submit" value="<?php echo display('save_and_add_another') ?>" name="add-client-another" class="btn btn-large btn-success" id="add-client-another" tabindex="6">
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