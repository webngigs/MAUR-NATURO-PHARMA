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
            <h1><?php echo display('gift_request') ?></h1>
            <small><?php echo display('gift') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('gift') ?></a></li>
                <li class="active"><?php echo display('gift_request') ?></li>
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
        ?>
        <!-- Manage gift report -->

        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="row">            
                    <div class="col-sm-4">
                        <h4 class="m-0 p-0">Total Invoice Amount</h4>
                        <h3 class="m-0 p-0"><?php echo $totalInvoiceAmount; ?><small> INR</small></h3>
                    </div>
                    <div class="col-sm-4">
                        <h4 class="m-0 p-0">Claimed Invoice Amount</h4>
                        <h3 class="m-0 p-0"><?php echo $ClaimedInvoiceAmount; ?><small> INR</small></h3>
                    </div>
                    <div class="col-sm-4">
                        <h4 class="m-0 p-0">To be Claim Invoice Amount</h4>
                        <h3 class="m-0 p-0"><?php echo $TobeClaimInvoiceAmount; ?><small> INR</small></h3>
                    </div>            
                    <div class="col-sm-12"><br/><h4 class="text-danger text-right">1 Point = 1 INR</h4></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title"><h4><?php echo display('gift_request') ?></h4></div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="giftLIst"> 
                                <thead>
                                    <tr>
                                        <th><?php echo display('sl') ?></th>
                                        <th><?php echo display('date') ?></th>
                                        <th><?php echo display('gift_name') ?></th>
                                        <th><?php echo display('customer') ?></th>
                                        <th><?php echo display('amount') ?></th>
                                        <th><?php echo display('status') ?></th>
                                        <th><?php echo display('action') ?> 
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
    $('#giftLIst').DataTable({ 
        responsive: true,
        "aaSorting": [[ 1, "asc" ]],
        "columnDefs": [{ 
            "bSortable": false, 
            "aTargets": [0, 4] },
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
                extend: "csv", title: "Gift Reques List", exportOptions: {
                    columns: [ 0, 1, 2,3] //Your Colume value those you want
                }, className: "btn-sm prints"
            }, 
            {
                extend: "excel", title: "Gift Reques List", exportOptions: {
                    columns: [ 0, 1, 2,3] //Your Colume value those you want
                },className: "btn-sm prints"
            }, 
            {
                extend: "pdf", title: " Gift Reques List",exportOptions: {
                    columns: [ 0, 1, 2,3] //Your Colume value those you want
                }, className: "btn-sm prints"
            }, 
            {
                extend: "print",exportOptions: {
                    columns: [ 0, 1, 2, 3] //Your Colume value those you want
                    },title: "<center> Gift Reques List</center>", className: "btn-sm prints"
            }
        ],   
        'serverMethod': 'post',
        'ajax': {
            'url':'<?=base_url()?>Cgift/CheckGiftRequestList'
        },
        'columns': [
            { data: 'sl' },
            { data: 'created_at', class:"text-center" },
            { data: 'gift_name', class:"text-left" },
            { data: 'customer_name', class:"text-left" },
            { data: 'gift_amount', class:"text-right" },
            { data: 'status', class:"text-center" },
            { data: 'button', class:"text-center"},
        ]
    });
});

function claimGiftRequestApprove(gift_request_id){
    if(confirm('Do you want to approve this gift claim request?\nPress OK otherwise Cancel!')==true){
        var base_url = $('.baseUrl').val();
        var dataString = 'gift_request_id='+gift_request_id;
        $.ajax({
            type: "POST",
            url: '<?=base_url()?>Cgift/claimGiftRequestApprove',
            data: dataString,
            cache: false,
            dataType: 'json',
            success: function(data){
                if(data['status'] == true){
                    window.location.href = window.location.href;
                }
            }
        });
    }
}

function claimGiftRequestCancel(gift_request_id){
    if(confirm('Do you want to cancel this gift claim request?\nPress OK otherwise Cancel!')==true){
        var base_url = $('.baseUrl').val();
        var dataString = 'gift_request_id='+gift_request_id;
        $.ajax({
            type: "POST",
            url: '<?=base_url()?>Cgift/claimGiftRequestCancel',
            data: dataString,
            cache: false,
            dataType: 'json',
            success: function(data){
                if(data['status'] == true){
                    window.location.href = window.location.href;
                }
            }
        });
    }
}
</script>