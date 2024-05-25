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
            <h1><?php echo display('mr') ?></h1>
            <small><?php echo display('manage_mr') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('mr') ?></a></li>
                <li class="active"><?php echo display('manage_mr') ?></li>
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
                    if($this->permission1->method('add_mr','create')->access()){ 
                        ?><a href="<?php echo base_url('Cmr') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_mr') ?> </a><?php 
                    }
                ?></div>
            </div>
        </div>
        <!-- Manage Product report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title"><h4><?php echo display('manage_mr') ?></h4></div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="mrLIst"> 
                                <thead>
                                    <tr>
                                        <th><?php echo display('sl') ?></th>
                                        <th><?php echo display('mr_name') ?></th>
                                        <th><?php echo display('mobile') ?></th>
                                        <th><?php echo display('email') ?></th>
                                        <th><?php echo display('password') ?></th>
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
    $('#mrLIst').DataTable({ 
        responsive: true,
        "aaSorting": [[ 1, "asc" ]],
        "columnDefs": [{ 
            "bSortable": false, 
            "aTargets": [0,2,3,4] },
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
                extend: "csv", title: "MRList", exportOptions: {
                    columns: [ 0, 1, 2, 3, 4] //Your Colume value those you want
                }, className: "btn-sm prints"
            }, 
            {
                extend: "excel", title: "MRList", exportOptions: {
                    columns: [ 0, 1, 2, 3, 4] //Your Colume value those you want
                },className: "btn-sm prints"
            }, 
            {
                extend: "pdf", title: " MRList",exportOptions: {
                    columns: [ 0, 1, 2, 3, 4] //Your Colume value those you want
                }, className: "btn-sm prints"
            }, 
            {
                extend: "print",exportOptions: {
                    columns: [ 0, 1, 2, 3, 4] //Your Colume value those you want
                    },title: "<center> MRList</center>", className: "btn-sm prints"
            }
        ],   
        'serverMethod': 'post',
        'ajax': {
            'url':'<?=base_url()?>Cmr/CheckMrList'
        },
        'columns': [
            { data: 'sl' },
            { data: 'mr_name' },
            { data: 'mr_mobile' },
            { data: 'mr_email' },
            { data: 'mr_password' },
            { data: 'button'},
        ]
    });
});
</script>