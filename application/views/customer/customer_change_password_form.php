<!--Edit customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Change Customer Password</h1>
            <small>Update Password</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('customer') ?></a></li>
                <li class="active">Update Password</li>
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
                            <h4>Change Customer Password</h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('Ccustomer/customer_update_password',array('class' => 'form-vertical', 'id' => 'customer_update_password'))?>
                    <div class="panel-body">
                    	<div class="form-group row">
                            <label for="customer_name" class="col-sm-3 col-form-label">Name </label>
                            <div class="col-sm-4"><label><?php echo $customer_name; ?></label></div>
                            <div class="col-sm-5"></div>
                        </div>
                        <div class="form-group row">
                            <label for="customer_name" class="col-sm-3 col-form-label">Login ID </label>
                            <div class="col-sm-4"><label><?php echo $customer_email; ?></label></div>
                            <div class="col-sm-5"></div>
                        </div>
                    	<div class="form-group row">
                            <label for="customer_name" class="col-sm-3 col-form-label">Current Password </label>
                            <div class="col-sm-4"><label><?php echo $password; ?></label></div>
                            <div class="col-sm-5"></div>
                        </div>
                    	<div class="form-group row">
                            <label for="customer_name" class="col-sm-3 col-form-label">New Password <i class="text-danger">*</i></label>
                            <div class="col-sm-4">
                                <input class="form-control" name ="password" id="password" type="text" placeholder="<?php echo display('password') ?>"  required="" value="" tabindex="1">
                            </div>
                            <div class="col-sm-5">
                                <input type="hidden" value="{customer_id}" name="customer_id">
                                <input type="hidden" value="{user_ref_id}" name="user_ref_id">
                                <input type="submit" id="add-Customer" class="btn btn-success btn-large" name="add-Customer" value="Update" tabindex="5"/>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div><?php
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

