<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$CI->load->model('Reports');
$CI->load->model('Users');

$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
$users = $CI->Users->profile_edit_data();
$out_of_stock = $CI->Reports->out_of_stock_count();
$out_of_date = $CI->Reports->out_of_date_count();
?>
<!-- Admin header end -->
<style type="text/css">
   .navbar .btn-success{
        margin: 13px 2px;
   }
</style>
<header class="main-header">
    <a href="<?php echo base_url() ?>" class="logo"> <!-- Logo -->
        <span class="logo-mini">
            <!--<b>A</b>BD-->
            <img src="<?php if (isset($Web_settings[0]['favicon'])) {
                echo $Web_settings[0]['favicon'];
            } ?>" alt="">
        </span>
        <span class="logo-lg">
            <!--<b>Admin</b>BD-->
            <img src="<?php if (isset($Web_settings[0]['logo'])) {
                echo $Web_settings[0]['logo'];
            } ?>" alt="">
        </span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top text-center">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->
            <span class="sr-only"><?php echo display('toggle_navigation') ?></span>
            <span class="pe-7s-keypad"></span>
        </a>

        <?php
        $urcolp = '0';
        if ($this->uri->segment(2) == "gui_pos") {
            $urcolp = "gui_pos";
        }
        if ($this->uri->segment(2) == "pos_invoice") {
            $urcolp = "pos_invoice";
        }

        if ($this->uri->segment(2) != $urcolp) {
            if ($this->permission1->method('new_invoice', 'create')->access()) { ?>
                <a href="<?php echo base_url('Cinvoice') ?>" class="btn btn-success btn-outline" style=""><i class="fa fa-balance-scale"></i> <?php echo display('invoice') ?></a>
            <?php } ?>

            <?php
            if ($this->permission1->method('customer_receive', 'create')->access()) { ?>
                <!--      <a href="<?php // echo base_url('accounts/customer_receive') ?>" class="btn btn-success btn-outline" style=""><i class="fa fa-money"></i> <?php // echo display('customer_receive') ?></a> -->
            <?php } ?>

            <?php
            if ($this->permission1->method('manufacturer_payment', 'create')->access()) { ?>
                <!--  <a href="<?php // echo base_url('accounts/manufacturer_payment') ?>" class="btn btn-success btn-outline" style=""><i class="fa fa-paypal" aria-hidden="true"></i> <?php // echo display('manufacturer_payment') ?></a> -->
            <?php } ?>



            <?php
            if ($this->permission1->method('add_purchase', 'create')->access()) { ?>
                <a href="<?php echo base_url('Cpurchase') ?>" class="btn btn-success btn-outline" style=""><i class="ti-shopping-cart"></i> <?php echo display('purchase') ?></a>
            <?php }
        } ?>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                   <li class="dropdown notifications-menu">
                    <a href="<?php echo base_url('Creport/out_of_date') ?>" >
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-danger"><?php echo $out_of_date ?></span>
                    </a>
                </li>
                <li class="dropdown notifications-menu">
                    <a href="<?php echo base_url('Creport/out_of_stock') ?>" >
                        <i class="pe-7s-attention" title="<?php echo display('out_of_stock') ?>"></i>
                        <span class="label label-danger"><?php echo $out_of_stock ?></span>
                    </a>
                </li>
                <!-- settings -->
                <li class="dropdown dropdown-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="pe-7s-settings"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url('Admin_dashboard/edit_profile') ?>"><i class="pe-7s-users"></i><?php echo display('user_profile') ?></a></li>
                        <li><a href="<?php echo base_url('Admin_dashboard/change_password_form') ?>"><i class="pe-7s-settings"></i><?php echo display('change_password') ?></a></li>
                        <li><a href="<?php echo base_url('Admin_dashboard/logout') ?>"><i class="pe-7s-key"></i><?php echo display('logout') ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<aside class="main-sidebar">
    <!-- sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel text-center">
            <div class="image">
                <img src="<?php echo $users[0]['logo'] ?>" class="img-circle" alt="User Image">
            </div>
            <div class="info">
                <p><?php echo $this->session->userdata('user_name') ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> <?php echo display('online') ?></a>
            </div>
        </div>
        <!-- sidebar menu -->
        <ul class="sidebar-menu">
            <li class="<?php if ($this->uri->segment('1') == ("")) echo "active"; else echo " "; ?>">
                <a href="<?php echo base_url() ?>"><i class="ti-dashboard"></i> <span><?php echo display('dashboard') ?></span>
                    <span class="pull-right-container">
                        <span class="label label-success pull-right"></span>
                    </span>
                </a>
            </li><?php 
            if($this->session->userdata('user_type') == '1'){ ?>
                <li class=" <?php if ($this->uri->segment('1') == ("Cgst")){ echo "active";} else{ echo " ";} ?>">
                    <a href="<?php echo base_url('Cgst/index') ?>"><i class="ti-bar-chart"></i> <span><?php echo 'GST Report'; ?></span>
                        <span class="pull-right-container">
                            <span class="label label-success pull-right"></span>
                        </span>
                    </a>
                </li><?php
            }
            
            if($this->permission1->module('new_invoice')->access() || $this->permission1->module('manage_invoice')->access() || $this->permission1->module('pos_invoice')->access() || $this->permission1->module('gui_pos')->access()) { ?>
                <li class="treeview <?php if ($this->uri->segment('1') == ("Cinvoice")) {
                    echo "active";
                } else {
                    echo " ";
                } ?>">
                    <a href="#">
                        <i class="fa fa-balance-scale"></i><span><?php echo display('invoice') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php
                        if ($this->permission1->method('manage_invoice', 'read')->access() || $this->permission1->method('manage_invoice', 'update')->access() || $this->permission1->method('manage_invoice', 'delete')->access()) { ?>
                            <li class="treeview <?php if ($this->uri->segment('2') == ("manage_invoice")) {
                                echo "active";
                            } else {
                                echo " ";
                            } ?>"><a href="<?php echo base_url('Cinvoice/manage_invoice') ?>"><?php echo display('manage_invoice') ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } 
            
            if($this->permission1->module('add_proforma_invoice')->access() || $this->permission1->module('manage_proforma_invoice')->access()) { 
                ?><li class="treeview <?php if ($this->uri->segment('1')=="Cproformainvoice") echo "active"; ?>">
                    <a href="#">
                        <i class="fa fa-balance-scale"></i><span><?php echo display('proforma_invoice') ?></span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu"><?php
                        if ($this->permission1->method('add_proforma_invoice', 'create')->access()) { ?>
                            <li  class="treeview <?php if ($this->uri->segment('1')=="Cproformainvoice") echo "active"; ?>">
                                <a href="<?php echo base_url('Cproformainvoice') ?>"><?php echo display('add_proforma_invoice') ?></a>
                            </li><?php 
                        }
                        if($this->permission1->method('manage_proforma_invoice', 'read')->access() || $this->permission1->method('manage_proforma_invoice', 'update')->access() || $this->permission1->method('manage_proforma_invoice', 'delete')->access()) { 
                            ?><li class="treeview <?php if ($this->uri->segment('2')=="manage_proforma_invoice") echo "active"; ?>">
                                <a href="<?php echo base_url('Cproformainvoice/manage_proforma_invoice') ?>"><?php echo display('manage_proforma_invoice') ?></a>
                            </li><?php 
                        } 
                    ?></ul>
                </li><?php 
            } 
            
            if ($this->permission1->module('add_demandrequest')->access() || $this->permission1->module('manage_demandrequest')->access()) {
                ?><li class="treeview <?php if ($this->uri->segment('1') == ("Cdemandrequest")) {
                    echo "active";
                } else {
                    echo " ";
                } ?>">
                    <a href="#">
                        <i class="fa fa-handshake-o"></i><span><?php echo display('demandrequest') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu"><?php
                    if ($this->permission1->method('add_demandrequest', 'create')->access()) { ?>
                        <li  class="treeview <?php if ($this->uri->segment('1') == ("Cdemandrequest") && $this->uri->segment('2') == ("")) {
                            echo "active";
                        } else {
                            echo " ";
                        } ?>"><a href="<?php echo base_url('Cdemandrequest') ?>"><?php echo display('add_demandrequest') ?></a></li>
                        <?php }
                        if ($this->permission1->method('manage_demandrequest', 'read')->access() || $this->permission1->method('manage_demandrequest', 'update')->access() || $this->permission1->method('manage_demandrequest', 'delete')->access()) { ?>
                            <li class="treeview <?php if ($this->uri->segment('2') == ("manage_demandrequest")) {
                                echo "active";
                            } else {
                                echo " ";
                            } ?>"><a href="<?php echo base_url('Cdemandrequest/manage_demandrequest') ?>"><?php echo display('manage_demandrequest') ?></a></li>
                        <?php }
                        
                        if ($this->permission1->method('customer_demandrequest', 'read')->access() || $this->permission1->method('customer_demandrequest', 'update')->access() || $this->permission1->method('customer_demandrequest', 'delete')->access()) { ?>
                            <li class="treeview <?php if ($this->uri->segment('2') == ("customer_demandrequest")) {
                                echo "active";
                            } else {
                                echo " ";
                            } ?>"><a href="<?php echo base_url('Cdemandrequest/customer_demandrequest') ?>"><?php echo display('customer_demandrequest') ?></a></li>
                        <?php }?>   
                    </ul>
                </li><?php
            }

            if ($this->permission1->module('add_stockrequest')->access() || $this->permission1->module('manage_stockrequest')->access()) {
                ?><li class="treeview <?php if ($this->uri->segment('1') == ("Cstockrequest")) {
                    echo "active";
                } else {
                    echo " ";
                } ?>">
                    <a href="#">
                        <i class="fa fa-handshake-o"></i><span><?php echo display('stockrequest') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu"><?php
                    if ($this->permission1->method('add_stockrequest', 'create')->access()) { ?>
                        <li  class="treeview <?php if ($this->uri->segment('1') == ("Cstockrequest") && $this->uri->segment('2') == ("")) {
                            echo "active";
                        } else {
                            echo " ";
                        } ?>"><a href="<?php echo base_url('Cstockrequest') ?>"><?php echo display('add_stockrequest') ?></a></li>
                        <?php }
                        if ($this->permission1->method('manage_stockrequest', 'read')->access() || $this->permission1->method('manage_stockrequest', 'update')->access() || $this->permission1->method('manage_stockrequest', 'delete')->access()) { ?>
                            <li class="treeview <?php if ($this->uri->segment('2') == ("manage_stockrequest")) {
                                echo "active";
                            } else {
                                echo " ";
                            } ?>"><a href="<?php echo base_url('Cstockrequest/manage_stockrequest') ?>"><?php echo display('manage_stockrequest') ?></a></li>
                        <?php }
                        ?>   
                    </ul>
                </li><?php
            }

        if($this->session->userdata('user_type') != '1'){
            if ($this->permission1->module('inventory')->access()) {
                ?><li class="treeview <?php if ($this->uri->segment('1') == ("Cinventory"))
                    echo "active"; ?>">
                    <a href="#">
                        <i class="fa fa-handshake-o"></i><span><?php echo display('stockinventory') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu"><?php
                    if ($this->permission1->method('inventory', 'read')->access()) { ?>
                                                        <li class="treeview <?php if ($this->uri->segment('2') == ("inventory"))
                                                            echo "active"; ?>">
                                                            <a href="<?php echo base_url('Cinventory/inventory') ?>"><?php echo display('stockinhand') ?></a>
                                                        </li><?php
                    }
                    if ($this->permission1->method('upcomingstock', 'read')->access()) { ?>
                                        <li class="treeview <?php if ($this->uri->segment('2') == ("upcomingstock"))
                                            echo "active"; ?>">
                                            <a href="<?php echo base_url('Cinventory/upcomingstock') ?>"><?php echo display('upcomingstock') ?></a>
                                        </li><?php
                    }
                    ?></ul>
                </li><?php
            }
        }    
            ?>

            <!-- Invoice menu end -->

            <!-- Customer menu start -->
            <?php
            if ($this->permission1->module('add_customer')->access() || $this->permission1->module('manage_customer')->access() || $this->permission1->module('credit_customer')->access() || $this->permission1->module('paid_customer')->access()) { ?>
                                            <li class="treeview <?php if ($this->uri->segment('1') == ("Ccustomer")) {
                                                echo "active";
                                            } else {
                                                echo " ";
                                            } ?>">
                                                <a href="#">
                                                    <i class="fa fa-handshake-o"></i><span><?php echo display('customer') ?></span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php
                                                    if ($this->permission1->method('add_customer', 'create')->access()) { ?>
                                                                                <li  class="treeview <?php if ($this->uri->segment('1') == ("Ccustomer") && $this->uri->segment('2') == ("")) {
                                                                                    echo "active";
                                                                                } else {
                                                                                    echo " ";
                                                                                } ?>"><a href="<?php echo base_url('Ccustomer') ?>"><?php echo display('add_customer') ?></a></li>
                                                    <?php } ?>

                                                    <?php
                                                    if ($this->permission1->method('manage_customer', 'read')->access() || $this->permission1->method('manage_customer', 'update')->access() || $this->permission1->method('manage_customer', 'delete')->access()) { ?>
                                                                                    <li class="treeview <?php if ($this->uri->segment('2') == ("manage_customer")) {
                                                                                        echo "active";
                                                                                    } else {
                                                                                        echo " ";
                                                                                    } ?>"><a href="<?php echo base_url('Ccustomer/manage_customer') ?>"><?php echo display('manage_customer') ?></a></li>
                                                    <?php } ?>

                                                   
                                                </ul>
                                            </li>
            <?php } ?>
            <!-- Customer menu end -->

            <!-- Medical Representive menu start -->
            <?php
            if ($this->permission1->module('add_mr')->access() || $this->permission1->module('manage_mr')->access()) {
                ?><li class="treeview <?php if ($this->uri->segment('1') == ("Cmr")) {
                    echo "active";
                } else {
                    echo " ";
                } ?>">
                                                <a href="#">
                                                    <i class="fa fa-handshake-o"></i><span><?php echo display('mr') ?></span>
                                                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                                </a>
                                                <ul class="treeview-menu"><?php
                                                if ($this->permission1->method('add_mr', 'create')->access()) {
                                                    ?><li  class="treeview <?php if ($this->uri->segment('1') == ("Cmr") && $this->uri->segment('2') == (""))
                                                        echo "active"; ?>">
                                                                                        <a href="<?php echo base_url('Cmr') ?>"><?php echo display('add_mr') ?></a>
                                                                                    </li><?php
                                                }
                                                if ($this->permission1->method('manage_mr', 'read')->access() || $this->permission1->method('manage_mr', 'update')->access() || $this->permission1->method('manage_mr', 'delete')->access()) {
                                                    ?><li class="treeview <?php if ($this->uri->segment('2') == ("manage_mr"))
                                                        echo "active"; ?>">
                                                                                        <a href="<?php echo base_url('Cmr/manage_mr') ?>"><?php echo display('manage_mr') ?></a>
                                                                                    </li><?php
                                                }
                                                ?></ul>
                                            </li><?php
            }
            ?>
            <!-- Medical Representive menu start -->

            <!-- Target Manager menu start -->
            <?php 

            if($this->permission1->module('add_mr_payment')->access() || $this->permission1->module('manage_mr_payment')->access()) {
                ?><li class="treeview <?php if ($this->uri->segment('1') == ("Cmrpayments")) { echo "active"; } else { echo " "; } ?>">
                    <a href="#">
                        <i class="fa fa-handshake-o"></i><span>MR Received Payments</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu"><?php
                    if($this->permission1->method('add_mr_payment', 'create')->access()) { 
                        ?><li  class="treeview <?php if ($this->uri->segment('1') == ("Cmrpayment") && $this->uri->segment('2') == ("")) { echo "active"; } else { echo " "; } ?>">
                            <a href="<?php echo base_url('Cmrpayments') ?>"><?php echo display('add_mr_payment') ?></a>
                        </li><?php 
                    }
                    if($this->permission1->method('manage_mr_payment', 'read')->access() || $this->permission1->method('manage_mr_payment', 'update')->access() || $this->permission1->method('manage_mr_payment', 'delete')->access()) { 
                        ?><li class="treeview <?php if ($this->uri->segment('2') == ("manage_mr_payment")) { echo "active"; } else { echo " "; } ?>">
                            <a href="<?php echo base_url('Cmrpayments/manage_mr_payment') ?>"><?php echo display('manage_mr_payment') ?></a>
                        </li><?php 
                    } 
                    ?></ul>
                </li><?php
            }
            
            
            if($this->permission1->module('add_payment')->access() || $this->permission1->module('manage_payment')->access()) {
                ?><li class="treeview <?php if ($this->uri->segment('1') == ("Cpayments")) { echo "active"; } else { echo " "; } ?>">
                    <a href="#">
                        <i class="fa fa-handshake-o"></i><span>MR Payments</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu"><?php
                    if($this->permission1->method('add_payment', 'create')->access()) { 
                        ?><li  class="treeview <?php if ($this->uri->segment('1') == ("Cpayment") && $this->uri->segment('2') == ("")) { echo "active"; } else { echo " "; } ?>">
                            <a href="<?php echo base_url('Cpayments') ?>"><?php echo display('add_payment') ?></a>
                        </li><?php 
                    }
                    if($this->permission1->method('manage_payment', 'read')->access() || $this->permission1->method('manage_payment', 'update')->access() || $this->permission1->method('manage_payment', 'delete')->access()) { 
                        ?><li class="treeview <?php if ($this->uri->segment('2') == ("manage_payment")) { echo "active"; } else { echo " "; } ?>">
                            <a href="<?php echo base_url('Cpayments/manage_payment') ?>"><?php echo display('manage_payment') ?></a>
                        </li><?php 
                    } 
                    ?></ul>
                </li><?php
            }

            if($this->permission1->module('add_salary')->access() || $this->permission1->module('manage_salary')->access()) {
                ?><li class="treeview <?php if ($this->uri->segment('1') == ("Csalary")) { echo "active"; } else { echo " "; } ?>">
                    <a href="#">
                        <i class="fa fa-handshake-o"></i><span>MR Salary</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu"><?php
                    if($this->permission1->method('add_salary', 'create')->access()) { 
                        ?><li  class="treeview <?php if ($this->uri->segment('1') == ("Csalary") && $this->uri->segment('2') == ("")) { echo "active"; } else { echo " "; } ?>">
                            <a href="<?php echo base_url('Csalary') ?>"><?php echo display('add_salary') ?></a>
                        </li><?php 
                    }
                    if($this->permission1->method('manage_salary', 'read')->access() || $this->permission1->method('manage_salary', 'update')->access() || $this->permission1->method('manage_salary', 'delete')->access()) { 
                        ?><li class="treeview <?php if ($this->uri->segment('2') == ("manage_salary")) { echo "active"; } else { echo " "; } ?>">
                            <a href="<?php echo base_url('Csalary/manage_salary') ?>"><?php echo display('manage_salary') ?></a>
                        </li><?php 
                    } 
                    ?></ul>
                </li><?php
            }
            
            
            if($this->permission1->module('add_expenses')->access() || $this->permission1->module('manage_expenses')->access()) {
                ?><li class="treeview <?php if ($this->uri->segment('1') == ("Cexpenses")) { echo "active"; } else { echo " "; } ?>">
                    <a href="#">
                        <i class="fa fa-handshake-o"></i><span>MR Expenses</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu"><?php
                    if($this->permission1->method('add_expenses', 'create')->access()) { 
                        ?><li  class="treeview <?php if ($this->uri->segment('1') == ("Cexpenses") && $this->uri->segment('2') == ("")) { echo "active"; } else { echo " "; } ?>">
                            <a href="<?php echo base_url('Cexpenses') ?>"><?php echo display('add_expenses') ?></a>
                        </li><?php 
                    }
                    if($this->permission1->method('manage_expenses', 'read')->access() || $this->permission1->method('manage_expenses', 'update')->access() || $this->permission1->method('manage_expenses', 'delete')->access()) { 
                        ?><li class="treeview <?php if ($this->uri->segment('2') == ("manage_expenses")) { echo "active"; } else { echo " "; } ?>">
                            <a href="<?php echo base_url('Cexpenses/manage_expenses') ?>"><?php echo display('manage_expenses') ?></a>
                        </li><?php 
                    } 
                    ?></ul>
                </li><?php
            }
            
            ?>
            <!-- Target Manager start -->

            <!-- Target Manager menu start -->
            <?php if($this->permission1->module('add_target')->access() || $this->permission1->module('manage_target')->access()) {
                ?><li class="treeview <?php if ($this->uri->segment('1') == ("Ctarget")) { echo "active"; } else { echo " "; } ?>">
                    <a href="#">
                        <i class="fa fa-handshake-o"></i><span><?php echo display('target') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu"><?php
                    if($this->permission1->method('add_target', 'create')->access()) { 
                        ?><li  class="treeview <?php if ($this->uri->segment('1') == ("Ctarget") && $this->uri->segment('2') == ("")) { echo "active"; } else { echo " "; } ?>">
                            <a href="<?php echo base_url('Ctarget') ?>"><?php echo display('add_target') ?></a>
                        </li><?php 
                    }
                    if($this->permission1->method('manage_target', 'read')->access() || $this->permission1->method('manage_target', 'update')->access() || $this->permission1->method('manage_target', 'delete')->access()) { 
                        ?><li class="treeview <?php if ($this->uri->segment('2') == ("manage_target")) { echo "active"; } else { echo " "; } ?>">
                            <a href="<?php echo base_url('Ctarget/manage_target') ?>"><?php echo display('manage_target') ?></a>
                        </li><?php 
                    } 
                    ?></ul>
                </li><?php
            } ?>
            <!-- Target Manager start -->

            <!-- Coupon Manager menu start -->
            <?php
            if ($this->permission1->module('add_coupon')->access() || $this->permission1->module('manage_coupon')->access()) {
                ?><li style="display:none;" class="treeview <?php if ($this->uri->segment('1') == ("Ccoupon")) {
                    echo "active";
                } else {
                    echo " ";
                } ?>">
                                                <a href="#">
                                                    <i class="fa fa-handshake-o"></i><span><?php echo display('coupon') ?></span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>
                                                <ul class="treeview-menu"><?php
                                                if ($this->permission1->method('add_coupon', 'create')->access()) { ?>
                                                                                <li  class="treeview <?php if ($this->uri->segment('1') == ("Ccoupon") && $this->uri->segment('2') == ("")) {
                                                                                    echo "active";
                                                                                } else {
                                                                                    echo " ";
                                                                                } ?>"><a href="<?php echo base_url('Ccoupon') ?>"><?php echo display('add_coupon') ?></a></li>
                                                    <?php } ?>

                                                    <?php
                                                    if ($this->permission1->method('manage_coupon', 'read')->access() || $this->permission1->method('manage_coupon', 'update')->access() || $this->permission1->method('manage_coupon', 'delete')->access()) { ?>
                                                                                    <li class="treeview <?php if ($this->uri->segment('2') == ("manage_coupon")) {
                                                                                        echo "active";
                                                                                    } else {
                                                                                        echo " ";
                                                                                    } ?>"><a href="<?php echo base_url('Ccoupon/manage_coupon') ?>"><?php echo display('manage_coupon') ?></a></li>
                                                    <?php } ?>   
                                                </ul>
                                            </li><?php
            }

            if($this->permission1->module('add_gift')->access() || $this->permission1->module('manage_gift')->access()) { 
                ?><li class="treeview <?php if ($this->uri->segment('1') == ("Cgift")){ echo "active";} else{ echo " ";} ?>">
                    <a href="#">
                        <i class="fa fa-handshake-o"></i><span><?php echo display('gift') ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu"><?php
                        if($this->permission1->method('add_gift','create')->access()) { ?>
                        <li  class="treeview <?php if ($this->uri->segment('1') == ("Cgift") && $this->uri->segment('2') == ("")){
                            echo "active";
                        } else {
                            echo " ";
                        }?>"><a href="<?php echo base_url('Cgift')?>"><?php echo display('add_gift') ?></a></li>
                        <?php } ?>

                        <?php
                        if($this->permission1->method('manage_gift','read')->access() || $this->permission1->method('manage_gift','update')->access() || $this->permission1->method('manage_coupon','delete')->access()) { ?>
                            <li class="treeview <?php  if ($this->uri->segment('2') == ("manage_gift")){
                            echo "active";
                        } else {
                            echo " ";
                        }?>"><a href="<?php echo base_url('Cgift/manage_gift')?>"><?php echo display('manage_gift') ?></a></li>
                        <?php } ?>

                        <?php
                        if($this->permission1->method('gift_request','read')->access() || $this->permission1->method('gift_request','update')->access() || $this->permission1->method('gift_request','delete')->access()) { ?>
                            <li class="treeview <?php  if ($this->uri->segment('2') == ("gift_request")){
                            echo "active";
                        } else {
                            echo " ";
                        }?>"><a href="<?php echo base_url('Cgift/gift_request')?>"><?php echo display('gift_request') ?></a></li>
                        <?php } ?>   
                    </ul>
                </li><?php
            }

            if ($this->permission1->module('medicine_type')->access() || $this->permission1->module('add_medicine')->access() || $this->permission1->module('import_medicine_csv')->access() || $this->permission1->module('manage_medicine')->access() || $this->uri->segment('1') == ("Ccategory") || $this->permission1->module('add_category')->access()) { ?>
                                            <li class="treeview <?php if ($this->uri->segment('1') == "Cproduct" || $this->uri->segment('1') == ("Ccategory")) {
                                                echo "active";
                                            } else {
                                                echo " ";
                                            } ?>">
                                                <a href="#">
                                                    <i class="ti-bag"></i><span><?php echo display('product') ?></span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>
                                                <ul class="treeview-menu">

                                                    <!-- Category menu start -->

           
                                                    <?php
                                                    if ($this->permission1->method('add_category', 'create')->access() || $this->permission1->method('add_category', 'read')->access() || $this->permission1->method('add_category', 'update')->access() || $this->permission1->method('add_category', 'delete')->access()) { ?>
                                                                                  <li   class="treeview <?php if ($this->uri->segment('1') == ("Ccategory")) {
                                                                                      echo "active";
                                                                                  } else {
                                                                                      echo " ";
                                                                                  } ?>"><a href="<?php echo base_url('Ccategory') ?>"><?php echo display('category') ?></a></li>
                                                 <?php } ?>
               
                                                        <!-- Category menu end -->
                                                    <?php
                                                    if ($this->permission1->method('medicine_type', 'create')->access() || $this->permission1->method('medicine_type', 'read')->access() || $this->permission1->method('medicine_type', 'update')->access() || $this->permission1->method('medicine_type', 'delete')->access()) { ?>
                                                                                 <li  class="treeview <?php if ($this->uri->segment('2') == ("typeindex")) {
                                                                                     echo "active";
                                                                                 } else {
                                                                                     echo " ";
                                                                                 } ?>"><a href="<?php echo base_url('Cproduct/typeindex') ?>"><?php echo display('product_type') ?></a></li>
                                                    <?php } ?>

                                                     <?php
                                                     if ($this->permission1->module('add_unit')->access() || $this->permission1->module('unit_list')->access()) { ?>
                                                                        <li class="treeview <?php if ($this->uri->segment('2') == ("unit_form") || $this->uri->segment('2') == ("unit_list")) {
                                                                            echo "active";
                                                                        } else {
                                                                            echo " ";
                                                                        } ?>">
                                                                            <a href="#">
                                                                                <i class="fa fa-universal-access"></i><span><?php echo display('unit') ?></span>
                                                                                <span class="pull-right-container">
                                                                                    <i class="fa fa-angle-left pull-right"></i>
                                                                                </span>
                                                                            </a>
                                                                            <ul class="treeview-menu">
                                                                                  <li   class="treeview <?php if ($this->uri->segment('1') == ("Cproduct") && $this->uri->segment('2') == ("unit_form")) {
                                                                                      echo "active";
                                                                                  } else {
                                                                                      echo " ";
                                                                                  } ?>"><a href="<?php echo base_url('Cproduct/unit_form') ?>"><?php echo display('add_unit') ?></a></li>

                                                                             <li   class="treeview <?php if ($this->uri->segment('1') == ("Cproduct") && $this->uri->segment('2') == ("unit_list")) {
                                                                                 echo "active";
                                                                             } else {
                                                                                 echo " ";
                                                                             } ?>"><a href="<?php echo base_url('Cproduct/unit_list') ?>"><?php echo display('unit_list') ?></a></li>
                                                                            </ul>
                                                                        </li>
                                        <?php } ?>

                                                    <?php
                                                    if ($this->permission1->method('add_medicine', 'create')->access()) { ?>
                                                                                    <li class="treeview <?php if ($this->uri->segment('1') == ("Cproduct") && $this->uri->segment('2') == ("")) {
                                                                                        echo "active";
                                                                                    } else {
                                                                                        echo " ";
                                                                                    } ?>"><a href="<?php echo base_url('Cproduct') ?>"><?php echo display('add_product') ?></a></li>
                                                    <?php } ?>

                                                    <?php
                                                    if ($this->permission1->method('import_medicine_csv', 'create')->access()) { ?>
                                                                                    <li  class="treeview <?php if ($this->uri->segment('2') == ("add_product_csv")) {
                                                                                        echo "active";
                                                                                    } else {
                                                                                        echo " ";
                                                                                    } ?>"><a href="<?php echo base_url('Cproduct/add_product_csv') ?>"><?php echo display('import_product_csv') ?></a></li>
                                                    <?php } ?>


                                                    <?php
                                                    if ($this->permission1->method('manage_medicine', 'read')->access() || $this->permission1->method('manage_medicine', 'update')->access() || $this->permission1->method('manage_medicine', 'delete')->access()) { ?>
                                                                                  <li class="treeview <?php if ($this->uri->segment('2') == ("manage_product")) {
                                                                                      echo "active";
                                                                                  } else {
                                                                                      echo " ";
                                                                                  } ?>"><a href="<?php echo base_url('Cproduct/manage_product') ?>"><?php echo display('manage_product') ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
            <?php } ?>
            <!-- Product menu end -->

            <!-- manufacturer menu start -->
            <?php
            if ($this->permission1->module('add_manufacturer')->access() || $this->permission1->module('manage_manufacturer')->access() || $this->permission1->module('manufacturer_ledger')->access() || $this->permission1->module('manufacturer_sales_details')->access()) { ?>
                                            <li class="treeview <?php if ($this->uri->segment('1') == ("Cmanufacturer")) {
                                                echo "active";
                                            } else {
                                                echo " ";
                                            } ?>">
                                                <a href="#">
                                                    <i class="ti-user"></i><span><?php echo display('manufacturer') ?></span>
                                                    <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php
                                                    if ($this->permission1->method('add_manufacturer', 'create')->access()) { ?>
                                                                                     <li  class="treeview <?php if ($this->uri->segment('1') == ("Cmanufacturer") && $this->uri->segment('2') == ("")) {
                                                                                         echo "active";
                                                                                     } else {
                                                                                         echo " ";
                                                                                     } ?>"><a href="<?php echo base_url('Cmanufacturer') ?>"><?php echo display('add_manufacturer') ?></a></li>
                                                    <?php } ?>

                                                    <?php
                                                    if ($this->permission1->method('manage_manufacturer', 'read')->access() || $this->permission1->method('manage_manufacturer', 'update')->access() || $this->permission1->method('manage_manufacturer', 'delete')->access()) { ?>
                                                                                    <li  class="treeview <?php if ($this->uri->segment('2') == ("manage_manufacturer")) {
                                                                                        echo "active";
                                                                                    } else {
                                                                                        echo " ";
                                                                                    } ?>"><a href="<?php echo base_url('Cmanufacturer/manage_manufacturer') ?>"><?php echo display('manage_manufacturer') ?></a></li>
                                                    <?php } ?>

                                                   

                                                </ul>
                                            </li>
                                            <?php
            }
            ?>
            <!-- manufacturer menu end -->


            <!-- Purchase menu start --> 
            <?php
            if ($this->permission1->module('add_purchase')->access() || $this->permission1->module('manage_purchase')->access()) { ?>
                                         <li class="treeview <?php if ($this->uri->segment('1') == ("Cpurchase")) {
                                             echo "active";
                                         } else {
                                             echo " ";
                                         } ?>">
                                            <a href="#">
                                                <i class="ti-shopping-cart"></i><span><?php echo display('purchase') ?></span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <?php
                                                if ($this->permission1->method('add_purchase', 'create')->access()) { ?>
                                                                              <li class="treeview <?php if ($this->uri->segment('1') == ("Cpurchase") && $this->uri->segment('2') == ("")) {
                                                                                  echo "active";
                                                                              } else {
                                                                                  echo " ";
                                                                              } ?>"><a href="<?php echo base_url('Cpurchase') ?>"><?php echo display('add_purchase') ?></a></li>
                                                                            <?php
                                                } ?>

                                                <?php
                                                if ($this->permission1->method('manage_purchase', 'read')->access() || $this->permission1->method('manage_purchase', 'update')->access() || $this->permission1->method('manage_purchase', 'delete')->access()) { ?>
                                                                                <li  class="treeview <?php if ($this->uri->segment('2') == ("manage_purchase")) {
                                                                                    echo "active";
                                                                                } else {
                                                                                    echo " ";
                                                                                } ?>"><a href="<?php echo base_url('Cpurchase/manage_purchase') ?>"><?php echo display('manage_purchase') ?></a></li>
                                                                            <?php
                                                }
                                                ?>
                                            </ul>
                                         </li>
           <?php } ?>
            <!-- Purchase menu end -->
             <!-- stock menu start -->
              <?php
              if ($this->permission1->module('stock_report')->access() || $this->permission1->module('stock_report_manufacturer_wise')->access() || $this->permission1->module('stock_report_product_wise')->access() || $this->permission1->module('stock_report_batch_wise')->access()) { ?>
                                        <!-- Stock menu start -->
                                        <li class="treeview <?php if ($this->uri->segment('1') == ("Creport")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        } ?>">
                                            <a href="#">
                                                <i class="ti-bar-chart"></i><span><?php echo display('stock') ?></span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <?php
                                                if ($this->permission1->method('stock_report', 'read')->access()) { ?>
                                                                              <li class="treeview <?php if ($this->uri->segment('1') == ("Creport") && $this->uri->segment('2') == ("")) {
                                                                                  echo "active";
                                                                              } else {
                                                                                  echo " ";
                                                                              } ?>"><a href="<?php echo base_url('Creport') ?>"><?php echo display('stock_report') ?></a></li>
                                                <?php } ?>

                

                                                <?php
                                                if ($this->permission1->method('stock_report_batch_wise', 'read')->access()) { ?>
                                                                              <li class="treeview <?php if ($this->uri->segment('2') == ("stock_report_batch_wise")) {
                                                                                  echo "active";
                                                                              } else {
                                                                                  echo " ";
                                                                              } ?>"><a href="<?php echo base_url('Creport/stock_report_batch_wise') ?>"><?php echo display('stock_report_batch_wise') ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                       <?php
              }
              ?>
            <!-- Stock menu end -->
            <li>
                <a href="https://g.page/r/CW5pMnI9mVFxEBM/review" target="_blank"><i class="fa fa-star"></i> <span>Google Review</span></a>
            </li>
              <!-- start return -->
           <?php
           if ($this->permission1->module('return')->access() || $this->permission1->module('stock_return_list')->access() || $this->permission1->module('manufacturer_return_list')->access() || $this->permission1->module('wastage_return_list')->access()) { ?>
                                          <li class="treeview <?php if ($this->uri->segment('1') == ("Cretrun_m")) {
                                              echo "active";
                                          } else {
                                              echo " ";
                                          } ?>">
                                            <a href="#">
                                               <i class="fa fa-retweet" aria-hidden="true"></i><span><?php echo display('return'); ?></span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">

                                                <?php
                                                if ($this->permission1->method('return', 'create')->access()) { ?>
                                                                              <li class="treeview <?php if ($this->uri->segment('1') == ("Cretrun_m") && $this->uri->segment('2') == ("")) {
                                                                                  echo "active";
                                                                              } else {
                                                                                  echo " ";
                                                                              } ?>"><a href="<?php echo base_url('Cretrun_m') ?>"><?php echo display('return'); ?></a></li>
                                                <?php } ?>

                                                <?php
                                                if ($this->permission1->method('stock_return_list', 'read')->access()) { ?>
                                                                                <li class="treeview <?php if ($this->uri->segment('2') == ("return_list")) {
                                                                                    echo "active";
                                                                                } else {
                                                                                    echo " ";
                                                                                } ?>"><a href="<?php echo base_url('Cretrun_m/return_list') ?>"><?php echo display('stock_return_list') ?></a></li>
                                                <?php } ?>

                                                <?php
                                                if ($this->permission1->method('manufacturer_return_list', 'read')->access()) { ?>
                                                                                <li  class="treeview <?php if ($this->uri->segment('2') == ("manufacturer_return_list")) {
                                                                                    echo "active";
                                                                                } else {
                                                                                    echo " ";
                                                                                } ?>"><a href="<?php echo base_url('Cretrun_m/manufacturer_return_list') ?>"><?php echo display('manufacturer_return_list') ?></a></li>
                                                <?php } ?>

                                                <?php
                                                if ($this->permission1->method('wastage_return_list', 'read')->access()) { ?>
                                                                                <li class="treeview <?php if ($this->uri->segment('2') == ("wastage_return_list")) {
                                                                                    echo "active";
                                                                                } else {
                                                                                    echo " ";
                                                                                } ?>"><a href="<?php echo base_url('Cretrun_m/wastage_return_list') ?>"><?php echo display('wastage_return_list') ?></a></li>
                                                <?php } ?>

                                            </ul>
                                          </li>
                                       <?php
           }
           ?>
            <!-- Return menu end -->
            <!-- Report menu start -->
             <?php
             if ($this->permission1->module('todays_report')->access() || $this->permission1->module('sales_report')->access() || $this->permission1->module('purchase_report')->access() || $this->permission1->module('sales_report_medicine_wise')->access() || $this->permission1->module('profit_loss')->access()) { ?>
                                            <!-- Report menu start -->
                                        <li class="treeview <?php if ($this->uri->segment('2') == ("all_report") || $this->uri->segment('2') == ("todays_sales_report") || $this->uri->segment('2') == ("todays_purchase_report") || $this->uri->segment('2') == ("product_sales_reports_date_wise") || $this->uri->segment('2') == ("total_profit_report") || $this->uri->segment('2') == ("profit_manufacturer_form") || $this->uri->segment('2') == ("profit_productwise_form") || $this->uri->segment('2') == ("profit_productwise") || $this->uri->segment('2') == ("profit_manufacturer")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        } ?>">
                                            <a href="#">
                                                <i class="ti-book"></i><span><?php echo display('report') ?></span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <?php
                                                if ($this->permission1->method('todays_report', 'read')->access()) { ?>
                                                                              <li class="treeview <?php if ($this->uri->segment('2') == ("all_report")) {
                                                                                  echo "active";
                                                                              } else {
                                                                                  echo " ";
                                                                              } ?>"><a href="<?php echo base_url('Admin_dashboard/all_report') ?>"><?php echo display('todays_report') ?></a></li>
                                                <?php } ?>

                                                <?php
                                                if ($this->permission1->method('sales_report', 'read')->access()) { ?>
                                                                               <li class="treeview <?php if ($this->uri->segment('2') == ("todays_sales_report")) {
                                                                                   echo "active";
                                                                               } else {
                                                                                   echo " ";
                                                                               } ?>"><a href="<?php echo base_url('Admin_dashboard/todays_sales_report') ?>"><?php echo display('sales_report') ?></a></li>
                                                <?php } ?>

                                                <?php
                                                if ($this->permission1->method('purchase_report', 'read')->access()) { ?>
                                                                              <li class="treeview <?php if ($this->uri->segment('2') == ("todays_purchase_report")) {
                                                                                  echo "active";
                                                                              } else {
                                                                                  echo " ";
                                                                              } ?>"><a href="<?php echo base_url('Admin_dashboard/todays_purchase_report') ?>"><?php echo display('purchase_report') ?></a></li>
                                                <?php } ?>

                                                <?php
                                                if ($this->permission1->method('sales_report_medicine_wise', 'read')->access()) { ?>
                                                                               <li class="treeview <?php if ($this->uri->segment('2') == ("product_sales_reports_date_wise")) {
                                                                                   echo "active";
                                                                               } else {
                                                                                   echo " ";
                                                                               } ?>"><a href="<?php echo base_url('Admin_dashboard/product_sales_reports_date_wise') ?>"><?php echo display('sales_report_product_wise') ?></a></li>
                                                 <?php } ?>

                                                <?php
                                                if ($this->permission1->method('profit_loss', 'read')->access()) { ?>
                                                                            <li class="treeview <?php if ($this->uri->segment('2') == ("profit_manufacturer_form") || $this->uri->segment('2') == ("profit_productwise_form") || $this->uri->segment('2') == ("profit_productwise") || $this->uri->segment('2') == ("profit_manufacturer")) {
                                                                                echo "active";
                                                                            } else {
                                                                                echo " ";
                                                                            } ?>">

                                                                                    <a href="#"><span><?php echo display('profitloss') ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                                                                                    <ul class="treeview-menu">
                                                                                        <li class="treeview <?php if ($this->uri->segment('2') == ("profit_manufacturer_form")) {
                                                                                            echo "active";
                                                                                        } else {
                                                                                            echo " ";
                                                                                        } ?>"><a href="<?php echo base_url('Admin_dashboard/profit_manufacturer_form') ?>"><?php echo display('manufacturer_wise') ?></a></li>
                                                                                        <li class="treeview <?php if ($this->uri->segment('2') == ("profit_productwise_form")) {
                                                                                            echo "active";
                                                                                        } else {
                                                                                            echo " ";
                                                                                        } ?>"><a href="<?php echo base_url('Admin_dashboard/profit_productwise_form') ?>"><?php echo display('product_wise') ?></a></li>
                                                                                    </ul>
                                                                                </li>
                                                <?php } ?>

                                            </ul>
                                        </li>
            <?php } ?>
            <!-- Report menu end -->
        
<!-- bank menu start -->

              <!-- Tax menu start -->
                         <?php if ($this->permission1->method('add_incometax', 'create')->access() || $this->permission1->method('manage_income_tax', 'read')->access() || $this->permission1->method('tax_settings', 'create')->access() || $this->permission1->method('tax_report', 'read')->access() || $this->permission1->method('invoice_wise_tax_report', 'read')->access()) { ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Caccounts") || $this->uri->segment('1') == ("Account_Controller") || $this->uri->segment('1') == ("Cpayment")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>">
                                            <a href="#">
                                                <i class="fa fa-money"></i><span><?php echo display('tax') ?></span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                       <?php if ($this->permission1->method('tax_settings', 'create')->access() || $this->permission1->method('tax_settings', 'update')->access()) { ?>         
                                                                        <li class="treeview <?php if ($this->uri->segment('2') == ("tax_settings")) {
                                                                            echo "active";
                                                                        } else {
                                                                            echo " ";
                                                                        } ?>"><a href="<?php echo base_url('Caccounts/tax_settings') ?>"><?php echo display('tax_settings') ?></a></li>
                                        <?php } ?>
              
                                            <?php if ($this->permission1->method('add_incometax', 'create')->access()) { ?>
                                                                         <li class="treeview <?php if ($this->uri->segment('2') == ("add_incometax")) {
                                                                             echo "active";
                                                                         } else {
                                                                             echo " ";
                                                                         } ?>"><a href="<?php echo base_url('Caccounts/add_incometax') ?>"><?php echo display('add_incometax') ?></a></li>
                                             <?php } ?>
                                             <?php if ($this->permission1->method('manage_income_tax', 'read')->access()) { ?>
                                                                          <li class="treeview <?php if ($this->uri->segment('2') == ("manage_income_tax")) {
                                                                              echo "active";
                                                                          } else {
                                                                              echo " ";
                                                                          } ?>"><a href="<?php echo base_url('Caccounts/manage_income_tax') ?>"><?php echo display('manage_income_tax') ?></a></li>
                                                <?php } ?>
                                            <?php if ($this->permission1->method('tax_report', 'read')->access()) { ?>    
                                                                            <li class="treeview <?php if ($this->uri->segment('2') == ("tax_report")) {
                                                                                echo "active";
                                                                            } else {
                                                                                echo " ";
                                                                            } ?>"><a href="<?php echo base_url('Caccounts/tax_report') ?>"><?php echo display('tax_report') ?></a></li>
                                                <?php } ?>
                                            <?php if ($this->permission1->method('invoice_wise_tax_report', 'read')->access()) { ?>
                                                                        <li class="treeview <?php if ($this->uri->segment('2') == ("invoice_wise_tax_report")) {
                                                                            echo "active";
                                                                        } else {
                                                                            echo " ";
                                                                        } ?>"><a href="<?php echo base_url('Caccounts/invoice_wise_tax_report') ?>"><?php echo display('invoice_wise_tax_report') ?></a></li>
                                            <?php } ?>
                                                 </ul>

                    

                                        </li>
       <?php } ?>
            <!-- Tax menu end -->
        

            <!-- Search menu start -->
            <?php
            if ($this->permission1->module('medicine_search')->access() || $this->permission1->module('customer_search')->access() || $this->permission1->module('invoice_search')->access() || $this->permission1->module('purcahse_search')->access()) { ?>

                                         <li class="treeview <?php if ($this->uri->segment('1') == ("Csearch")) {
                                             echo "active";
                                         } else {
                                             echo " ";
                                         } ?>">
                                            <a href="#">
                                                <i class="ti-search"></i><span><?php echo display('search') ?></span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <?php
                                                if ($this->permission1->method('medicine_search', 'read')->access()) { ?>
                                                                               <li class="treeview <?php if ($this->uri->segment('2') == ("medicine")) {
                                                                                   echo "active";
                                                                               } else {
                                                                                   echo " ";
                                                                               } ?>"><a href="<?php echo base_url('Csearch/medicine') ?>"><?php echo display('medicine') ?></a></li>
                                                                            <?php
                                                }
                                                ?>

                                                <?php
                                                if ($this->permission1->method('customer_search', 'read')->access()) { ?>
                                                                            <li class="treeview <?php if ($this->uri->segment('2') == ("customer")) {
                                                                                echo "active";
                                                                            } else {
                                                                                echo " ";
                                                                            } ?>"><a href="<?php echo base_url('Csearch/customer') ?>"><?php echo display('customer') ?> </a></li>
                                                                            <?php
                                                }
                                                ?>

                                                <?php
                                                if ($this->permission1->method('invoice_search', 'read')->access()) { ?>
                                                                                <li class="treeview <?php if ($this->uri->segment('2') == ("invoice")) {
                                                                                    echo "active";
                                                                                } else {
                                                                                    echo " ";
                                                                                } ?>"><a href="<?php echo base_url('Csearch/invoice') ?>"><?php echo display('invoice') ?> </a></li>
                                                                                <?php
                                                }
                                                ?>

                                                <?php
                                                if ($this->permission1->method('purcahse_search', 'read')->access()) { ?>
                                                                                <li class="treeview <?php if ($this->uri->segment('2') == ("purchase")) {
                                                                                    echo "active";
                                                                                } else {
                                                                                    echo " ";
                                                                                } ?>"><a href="<?php echo base_url('Csearch/purchase') ?>"><?php echo display('purchase') ?> </a></li>
                                                                                <?php
                                                }
                                                ?>

                                            </ul>
                                         </li>
                                        <?php
            }
            ?>
        
            <!-- Software Settings menu start -->
            <?php
            if ($this->permission1->module('manage_company')->access() || $this->permission1->module('add_user')->access() || $this->permission1->module('manage_users')->access() || $this->permission1->module('language')->access() || $this->permission1->module('setting')->access() || $this->permission1->module('user_assign_role')->access() || $this->permission1->module('permission')->access() || $this->permission1->module('add_role')->access() || $this->permission1->module('role_list')->access() || $this->permission1->method('configure_sms', 'create')->access() || $this->permission1->method('configure_sms', 'update')->access() || $this->permission1->module('data_setting')->access() || $this->permission1->module('synchronize')->access() || $this->permission1->module('backup_and_restore')->access()) { ?>

                                             <li class="treeview <?php if ($this->uri->segment('1') == ("Company_setup") || $this->uri->segment('1') == ("User") || $this->uri->segment('1') == ("Cweb_setting") || $this->uri->segment('1') == ("Language") || $this->uri->segment('1') == ("Currency") || $this->uri->segment('1') == ("Permission") || $this->uri->segment('1') == ("Csms") || $this->uri->segment('1') == ("Backup_restore")) {
                                                 echo "active";
                                             } else {
                                                 echo " ";
                                             } ?>">
                                            <a href="#">
                                                <i class="ti-settings"></i><span><?php echo display('settings') ?></span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                           <li class="treeview <?php if ($this->uri->segment('1') == ("Company_setup") || $this->uri->segment('1') == ("User") || $this->uri->segment('1') == ("Cweb_setting") || $this->uri->segment('1') == ("Language") || $this->uri->segment('1') == ("Currency")) {
                                                               echo "active";
                                                           } else {
                                                               echo " ";
                                                           } ?>">
                                            <a href="#">
                                                <span><?php echo display('web_settings') ?></span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">

                                                <?php
                                                if ($this->permission1->method('manage_company', 'read')->access() || $this->permission1->method('manage_company', 'update')->access()) { ?>
                                                                              <li class="treeview <?php if ($this->uri->segment('2') == ("manage_company")) {
                                                                                  echo "active";
                                                                              } else {
                                                                                  echo " ";
                                                                              } ?>"><a href="<?php echo base_url('Company_setup/manage_company') ?>"><?php echo display('manage_company') ?></a></li>
                                                <?php } ?>

                                                <?php
                                                if ($this->permission1->method('add_user', 'create')->access()) { ?>
                                                                              <li class="treeview <?php if ($this->uri->segment('1') == ("User") && $this->uri->segment('2') == ("")) {
                                                                                  echo "active";
                                                                              } else {
                                                                                  echo " ";
                                                                              } ?>"><a href="<?php echo base_url('User') ?>"><?php echo display('add_user') ?></a></li>
                                                <?php } ?>

                                                <?php
                                                if ($this->permission1->method('manage_users', 'read')->access() || $this->permission1->method('manage_users', 'update')->access() || $this->permission1->method('manage_users', 'delete')->access()) { ?>
                                                                              <li class="treeview <?php if ($this->uri->segment('2') == ("manage_user")) {
                                                                                  echo "active";
                                                                              } else {
                                                                                  echo " ";
                                                                              } ?>"><a href="<?php echo base_url('User/manage_user') ?>"><?php echo display('manage_users') ?> </a></li>
                                                <?php } ?>

                                                <?php
                                                if ($this->permission1->method('language', 'create')->access() || $this->permission1->method('language', 'read')->access() || $this->permission1->method('add_phrase', 'read')->access() || $this->permission1->method('add_phrase', 'update')->access()) { ?>
                                                                                <li class="treeview <?php if ($this->uri->segment('1') == ("Language") && $this->uri->segment('2') == ("")) {
                                                                                    echo "active";
                                                                                } else {
                                                                                    echo " ";
                                                                                } ?>"><a href="<?php echo base_url('Language') ?>"><?php echo display('language') ?> </a></li>
                                                <?php } ?>
                                                <?php
                                                if ($this->permission1->method('currency', 'create')->access()) { ?>
                                                                               <li  class="treeview <?php if ($this->uri->segment('1') == ("Currency") && $this->uri->segment('2') == ("")) {
                                                                                   echo "active";
                                                                               } else {
                                                                                   echo " ";
                                                                               } ?>"><a href="<?php echo base_url('Currency') ?>"><?php echo display('currency') ?> </a></li>
                                               <?php } ?>
                                                <?php
                                                if ($this->permission1->method('soft_setting', 'read')->access() || $this->permission1->method('soft_setting', 'update')->access()) { ?>
                                                                                <li  class="treeview <?php if ($this->uri->segment('1') == ("Cweb_setting") && $this->uri->segment('2') == ("")) {
                                                                                    echo "active";
                                                                                } else {
                                                                                    echo " ";
                                                                                } ?>"><a href="<?php echo base_url('Cweb_setting') ?>"><?php echo display('setting') ?> </a></li>
                                                <?php } ?>


                                            </ul>
                                        </li>


                                        <?php
                                        if ($this->permission1->module('user_assign_role')->access() || $this->permission1->module('permission')->access() || $this->permission1->module('add_role')->access() || $this->permission1->module('role_list')->access()) { ?>
                                                                    <!-- Role-permission menu start -->
                                                                    <li class="treeview <?php if ($this->uri->segment('1') == ("Permission")) {
                                                                        echo "active";
                                                                    } else {
                                                                        echo " ";
                                                                    } ?>">
                                                                        <a href="#">
                                                                            <span><?php echo display('role_permission') ?></span>
                                                                            <span class="pull-right-container">
                                                                            <i class="fa fa-angle-left pull-right"></i>
                                                                            </span>
                                                                        </a>
                                                                        <ul class="treeview-menu">
                                                                            <?php
                                                                            if ($this->permission1->method('add_role', 'create')->access() || $this->permission1->method('add_role', 'read')->access() || $this->permission1->method('add_role', 'update')->access() || $this->permission1->method('add_role', 'delete')->access()) { ?>
                                                                                                            <li class="treeview <?php if ($this->uri->segment('2') == ("add_role")) {
                                                                                                                echo "active";
                                                                                                            } else {
                                                                                                                echo " ";
                                                                                                            } ?>"><a href="<?php echo base_url('Permission/add_role') ?>"><?php echo display('add_role') ?></a></li>
                                                                            <?php } ?>

                                                                            <?php
                                                                            if ($this->permission1->method('role_list', 'read')->access() || $this->permission1->method('role_list', 'update')->access() || $this->permission1->method('role_list', 'delete')->access()) { ?>
                                                                                                            <li class="treeview <?php if ($this->uri->segment('2') == ("role_list")) {
                                                                                                                echo "active";
                                                                                                            } else {
                                                                                                                echo " ";
                                                                                                            } ?>"><a href="<?php echo base_url('Permission/role_list') ?>"><?php echo display('role_list') ?></a></li>
                                                                            <?php } ?>



                                                                            <?php
                                                                            if ($this->permission1->method('user_assign_role', 'create')->access() || $this->permission1->method('user_assign_role', 'read')->access()) { ?>
                                                                                                            <li class="treeview <?php if ($this->uri->segment('2') == ("user_assign")) {
                                                                                                                echo "active";
                                                                                                            } else {
                                                                                                                echo " ";
                                                                                                            } ?>"><a href="<?php echo base_url('Permission/user_assign') ?>"><?php echo display('user_assign_role') ?></a></li>
                                                                            <?php } ?>

                                                                         <!--    <?php
                                                                         if ($this->permission1->method('permission', 'create')->access()) { ?>
                                                                                                            <li class="treeview <?php if ($this->uri->segment('1') == ("Permission") && $this->uri->segment('2') == ("")) {
                                                                                                                echo "active";
                                                                                                            } else {
                                                                                                                echo " ";
                                                                                                            } ?>"><a href="<?php echo base_url('Permission') ?>"><?php echo display('permission') ?></a></li>
                                                                            <?php } ?>
                                                         -->


                                                                        </ul>
                                                                    </li>
                                        <?php } ?>


                                                    <!-- Sms setting start -->
                                         <?php if ($this->permission1->method('configure_sms', 'create')->access() || $this->permission1->method('configure_sms', 'update')->access()) { ?>
            
                                                                 <li class="treeview <?php if ($this->uri->segment('1') == ("Csms")) {
                                                                     echo "active";
                                                                 } else {
                                                                     echo " ";
                                                                 } ?>">
                                                                        <a href="#">
                                                                            <span><?php echo display('sms'); ?></span>
                                                                            <span class="pull-right-container">
                                                                                <i class="fa fa-angle-left pull-right"></i>
                                                                            </span>
                                                                        </a>
                                                                        <ul class="treeview-menu">
                
                                                                              <li class="treeview <?php if ($this->uri->segment('2') == ("configure")) {
                                                                                  echo "active";
                                                                              } else {
                                                                                  echo " ";
                                                                              } ?>"><a href="<?php echo base_url('Csms/configure') ?>"><?php echo display('sms_configure'); ?></a></li>
                     
 
                                                                        </ul>
                                                                     </li>
                                     <?php } ?>
         
                                        <!-- Sms Setting end -->

                                        <!-- Synchronizer setting start -->
                                        <?php
                                        if ($this->permission1->module('data_setting')->access() || $this->permission1->module('synchronize')->access() || $this->permission1->module('backup_and_restore')->access()) { ?>
                                                                        <li class="treeview <?php if ($this->uri->segment('2') == ("form") || $this->uri->segment('2') == ("synchronize") || $this->uri->segment('1') == ("Backup_restore")) {
                                                                            echo "active";
                                                                        } else {
                                                                            echo " ";
                                                                        } ?>">
                                                                        <a href="#">
                                                                            <span><?php echo display('data_synchronizer') ?></span>
                                                                            <span class="pull-right-container">
                                                                                <i class="fa fa-angle-left pull-right"></i>
                                                                            </span>
                                                                        </a>
                                                                        <ul class="treeview-menu">
                                                                            <?php
                                                                            $localhost = false;
                                                                            if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1', 'localhost'))) {
                                                                                ?>
                                                                                                        <?php
                                                                                                        if ($this->permission1->method('data_setting', 'read')->access() || $this->permission1->method('data_setting', 'update')->access()) { ?>
                                                                                                                                           <li  class="treeview <?php if ($this->uri->segment('1') == ("data_synchronizer") && $this->uri->segment('2') == ("form")) {
                                                                                                                                               echo "active";
                                                                                                                                           } else {
                                                                                                                                               echo " ";
                                                                                                                                           } ?>"><a href="<?php echo base_url('data_synchronizer/form') ?>"><?php echo display('setting') ?></a></li>
                                                                                                            <?php } ?>
                                                                            <?php } ?>


                                                                            <?php
                                                                            if ($this->permission1->method('synchronize', 'read')->access() || $this->permission1->method('synchronize', 'update')->access()) { ?>
                                                                                                        <!--  <li><a href="<?php echo base_url('data_synchronizer/synchronize') ?>"><?php echo display('synchronize') ?></a></li>-->
                                                                                                        <!--<?php } ?>-->

                                                                            <?php
                                                                            if ($this->permission1->method('backup_and_restore', 'read')->access() || $this->permission1->method('backup_and_restore', 'update')->access() || $this->permission1->method('backup_and_restore', 'delete')->access()) { ?>
                                                                                                            <li class="treeview <?php if ($this->uri->segment('1') == ("Backup_restore") && $this->uri->segment('2') == ("")) {
                                                                                                                echo "active";
                                                                                                            } else {
                                                                                                                echo " ";
                                                                                                            } ?>"><a href="<?php echo base_url('Backup_restore') ?>"><?php echo display('backup') ?></a></li>
                                                                            <?php } ?>
                                                                              <li class="treeview <?php if ($this->uri->segment('1') == ("Backup_restore") && $this->uri->segment('2') == ("import")) {
                                                                                  echo "active";
                                                                              } else {
                                                                                  echo " ";
                                                                              } ?>"><a href="<?php echo base_url('Backup_restore/import_form') ?>"><?php echo display('import') ?></a></li>

                                                                        </ul>
                                                                    </li>
                                        <?php } ?>
                                        <!-- Synchronizer setting end -->
                                         <li><a href="https://forum.bdtask.com/Pharmacare-software" target="blank"><i class="fa fa-question-circle"></i> Support</a></li>
                                            </ul>
                                        </li>
            <?php } ?>
            <!-- Software Settings menu end -->

        
        
        </ul>
    </div> <!-- /.sidebar -->
</aside>