<style type="text/css">
    .prints{
        background-color: #31B404;
        color:#fff;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon"><i class="pe-7s-note2"></i></div>
        <div class="header-title">
            <h1><?php echo display('customer_demandrequest') ?></h1>
            <small><?php echo display('customer_demandrequest') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('demandrequest') ?></a></li>
                <li class="active"><?php echo display('customer_demandrequest') ?></li>
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
                <div class="panel panel-default">
                    <div class="panel-body text-center">
                        <?php echo form_open('', array('class' => 'form-inline', 'method' => 'get')) ?>
                        <?php $today = date('Y-m-d'); ?>
                        <div class="form-group">
                            <label class="" for="from_date"><?php echo display('start_date') ?></label>
                            <input type="text" name="from_date" class="form-control datepicker" id="from_date" value="" placeholder="<?php echo display('start_date') ?>" >
                        </div>
                        <div class="form-group">
                            <label class="" for="to_date"><?php echo display('end_date') ?></label>
                            <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>" value="">
                        </div>
                        <div class="form-group">
                            <button type="button" id="btn-filter" class="btn btn-success"><?php echo display('find') ?></button>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>            
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('customer_demandrequest') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive" >
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="InvList"> 
                                <thead>
                                    <tr>
                                        <th><?php echo display('sl') ?></th>
                                        <th><?php echo display('demandrequest_no') ?></th>                                        
                                        <th><?php echo display('mr_name') ?></th>
                                        <th><?php echo display('customer_name') ?></th>
                                        <th><?php echo display('date') ?></th>
                                        <th><?php echo display('quantity') ?></th>                                 
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

<script type="text/javascript">
    $(document).ready(function() {
        var mydatatable = $('#InvList').DataTable({
            responsive: true,
            "aaSorting": [[ 1, "desc" ]],
            "columnDefs": [{ "bSortable": false, "aTargets": [0,6] }],
            'processing': true,
            'serverSide': true,
            'lengthMenu':[[10, 25, 50,100,250,500, "<?php echo $total_invoice;?>"], [10, 25, 50,100,250,500, "All"]],
            dom:"'<'col-sm-4'l><'col-sm-4 text-center'><'col-sm-4'>Bfrtip",
            buttons:[
                {
                    extend: "copy",exportOptions: {columns: [0, 1, 2, 3, 4, 5]}, className: "btn-sm prints"
                },
                {
                    extend: "csv", title: "Demand Request List", exportOptions: {columns:[0, 1, 2, 3, 4, 5]}, className: "btn-sm prints"
                },
                {
                    extend: "excel",exportOptions: {columns:[0, 1, 2, 3, 4, 5]}, title: "Demand Request List", className: "btn-sm prints"
                },
                {
                    extend: "pdf",exportOptions: {columns: [0, 1, 2, 3, 4, 5]}, title: "Demand Request List", className: "btn-sm prints"
                },
                {
                    extend: "print",exportOptions: {columns: [0, 1, 2, 3, 4, 5]}, title: "Demand Request List", className: "btn-sm prints"
                }
            ],
            'serverMethod': 'post',
            'ajax': {
                'url':'<?=base_url()?>Cdemandrequest/CheckCustomerDemandrequestList',
                "data": function ( data) {
                    data.fromdate = $('#from_date').val();
                    data.todate = $('#to_date').val();
                    //data.status = $('#status').val();
                }
            },
            'columns': [
                { data: 'sl' },
                { data: 'demandrequests' },
                { data: 'mr_name' }, 
                { data: 'customer_name' },                
                { data: 'final_date' },
                { data: 'total_quantity' },              
                { data: 'button', class:"text-center"},
            ],
            "footerCallback": function(row, data, start, end, display) {
               
            }
        });
        $('#btn-filter').click(function(){ 
            mydatatable.ajax.reload();  
        });
    });
</script>