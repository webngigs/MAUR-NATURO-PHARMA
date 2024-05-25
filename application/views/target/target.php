<style type="text/css">
    .prints{
        background-color: #31B404;
        color:#fff;
    }
    .action{
        color:#fff;
    }
    .dropdown-menu>li>a {
        color: #fff;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('target') ?></h1>
            <small><?php echo display('manage_target') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('target') ?></a></li>
                <li class="active"><?php echo display('manage_target') ?></li>
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
        if(isset($error_message)) {
            ?><div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error_message ?>                    
            </div><?php
            $this->session->unset_userdata('error_message');
        }
        ?><div class="row">
            <div class="col-sm-12">
                <div class="column"><?php 
                    if($this->permission1->method('add_target','create')->access()){ 
                        ?><a href="<?php echo base_url('Ctarget') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_target') ?> </a><?php 
                    }
                ?></div>
            </div>
        </div>
        <!-- Manage Product report -->
        <div class="row">
            <?php if($this->session->userdata('user_type') == '3'){
                ?><div class="col-sm-4 text-center">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title"><h4>Total Sales: &nbsp;&nbsp;&nbsp;<?php echo '₹'.$total_sales_amount; ?></h4></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 text-center">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title"><h4>100 ₹. &nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp; 1 Point</h4></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 text-center">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title"><h4>Earn Points: <?php echo round($total_sales_amount/100); ?></h4></div>
                        </div>
                    </div>
                </div><?php
            } ?>
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title"><h4><?php echo display('manage_target') ?></h4></div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="targetLIst"> 
                                <thead>
                                    <tr>
                                        <th><?php echo display('sl') ?></th>
                                        <th><?php echo display('mr_name') ?></th>
                                        <th><?php echo display('minpurchase') ?></th>
                                        <th><?php echo display('maxpurchase') ?></th>
                                        <th><?php echo display('commission') ?></th>
                                        <th>Type</th>
                                        <th><?php echo display('action') ?></th>                                    
                                    </tr>
                                </thead>
                                <tbody></tbody> 
                            </table>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Manage Product End -->
<script type="text/javascript">
$(document).ready(function() { 
    $('#targetLIst').DataTable({ 
        responsive: true,
        "aaSorting": [[ 2, "asc" ]],
        "columnDefs": [{ 
            "bSortable": false, 
            "aTargets": [5] },
        ],
        'processing': true,
        'serverSide': true,  
        'lengthMenu':[[10, 25, 50,100,250,500, "<?php echo $total_customer;?>"], [10, 25, 50,100,250,500, "All"]],
        dom:"'<'col-sm-4'l><'col-sm-4 text-center'><'col-sm-4'>Bfrtip", 
        buttons:[ 
            {
                extend: "copy", className: "btn-sm prints"
            }, 
            {
                extend: "csv", title: "TargetList", exportOptions: {
                    columns: [0,1, 2, 3, 4] //Your Colume value those you want
                }, className: "btn-sm prints"
            }, 
            {
                extend: "excel", title: "TargetList", exportOptions: {
                    columns: [0,1, 2, 3, 4] //Your Colume value those you want
                },className: "btn-sm prints"
            }, 
            {
                extend: "pdf", title: " TargetList",exportOptions: {
                    columns: [0,1, 2, 3, 4] //Your Colume value those you want
                }, className: "btn-sm prints"
            }, 
            {
                extend: "print",exportOptions: {
                    columns: [0,1, 2, 3, 4] //Your Colume value those you want
                },title: "TargetList", className: "btn-sm prints"
            }
        ],   
        'serverMethod': 'post',
        'ajax': {
            'url':'<?=base_url()?>Ctarget/CheckList'
        },
        'columns': [
            { data: 'sl' },
            { data: 'mr_name' },
            { data: 'minpurchase', class:"text-right" },
            { data: 'maxpurchase', class:"text-right" },
            { data: 'commission', class:"text-right" },
            { data: 'commission_type', class:"text-center" },
            { data: 'button', class:"text-center" }         
        ]
    });
});
</script>