<style type="text/css">
    .prints{ background-color:#31B404; color:#fff; }
    .action{ color:#fff; }
    .dropdown-menu>li>a{ color:#fff; }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon"><i class="pe-7s-note2"></i></div>
        <div class="header-title">
            <h1><?php echo display('salary') ?></h1>
            <small><?php echo display('manage_salary') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('salary') ?></a></li>
                <li class="active"><?php echo display('manage_salary') ?></li>
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
                if($this->permission1->method('add_salary','create')->access()){ 
                    ?><a href="<?php echo base_url('Csalary') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_salary') ?> </a><?php 
                }
                ?></div>
            </div>
        </div>
        <!-- Manage gift report -->
  
        <div class="row">            
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('manage_salary') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="salaryList"> 
                                <thead>
                                    <tr>
                                        <th><?php echo display('sl') ?></th>
                                        <th><?php echo display('mr') ?></th>
                                        <th><?php echo display('title') ?></th>
                                        <th>Salary Date</th>
                                        <th><?php echo display('amount') ?></th>
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
<!-- Manage gift End -->
<script type="text/javascript">
    $(document).ready(function() { 
        $('#salaryList').DataTable({ 
            responsive: true,
            "aaSorting": [[ 3, "desc" ]],
            "columnDefs": [{ 
                "bSortable": false, 
                "aTargets": [3] },
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
                    extend: "csv", title: "salaryList", exportOptions: {
                        columns: [ 0, 1, 2, 3, 4] //Your Colume value those you want
                    }, className: "btn-sm prints"
                }, 
                {
                    extend: "excel", title: "salaryList", exportOptions: {
                        columns: [ 0, 1, 2, 3, 4] //Your Colume value those you want
                    },className: "btn-sm prints"
                }, 
                {
                    extend: "pdf", title: "salaryList", exportOptions: {
                        columns: [ 0, 1, 2, 3, 4] //Your Colume value those you want
                    }, className: "btn-sm prints"
                }, 
                {
                    extend: "print", title: "salaryList", exportOptions: {
                        columns: [ 0, 1, 2, 3, 4] //Your Colume value those you want
                    }, className: "btn-sm prints"
                }, 
                {
                    extend: "print", title: "<center>salaryList</center>", exportOptions: {
                        columns: [ 0, 1, 2, 3, 4] //Your Colume value those you want
                    }, className: "btn-sm prints"
                }
            ],   
            'serverMethod': 'post',
            'ajax': {
                'url':'<?=base_url()?>Csalary/CheckSalaryList'
            },
            'columns': [
                { data: 'sl' },
                { data: 'mr_name' },
                { data: 'name' },
                { data: 'salary_date' },
                { data: 'amount', class:"text-right" }
            ]
        });
    });
</script>