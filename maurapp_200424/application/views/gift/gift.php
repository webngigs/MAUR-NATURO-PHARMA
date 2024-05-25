<style type="text/css">
    .prints{ background-color:#31B404; color:#fff; }
    .action{ color:#fff; }
    .dropdown-menu>li>a{ color:#fff; }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon"><i class="pe-7s-note2"></i></div>
        <div class="header-title">
            <h1><?php echo display('gift') ?></h1>
            <small><?php echo display('manage_gift') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('gift') ?></a></li>
                <li class="active"><?php echo display('manage_gift') ?></li>
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
                if($this->permission1->method('add_gift','create')->access()){ 
                    ?><a href="<?php echo base_url('Cgift') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_gift') ?> </a><?php 
                }
                ?></div>
            </div>
        </div>
        <!-- Manage gift report -->

        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="row">            
                    <div class="col-sm-4">
                        <h4 class="m-0 p-0">Total  Points</h4>
                        <h3 class="m-0 p-0"><?php echo ($totalInvoiceAmount/100); ?></h3>
                    </div>
                    <div class="col-sm-4">
                        <h4 class="m-0 p-0">Claimed Points</h4>
                        <h3 class="m-0 p-0"><?php echo $ClaimedInvoiceAmount; ?></h3>
                    </div>
                    <div class="col-sm-4">
                        <h4 class="m-0 p-0">To be Claim Points</h4>
                        <h3 class="m-0 p-0"><?php echo $TobeClaimInvoiceAmount; ?></h3>
                    </div>            
                    <div class="col-sm-12"><br/><h4 class="text-danger text-right">100 INR = 1 Point</h4></div>
                </div>
            </div>
        </div>  
        <div class="row">            
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('manage_gift') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="giftLIst"> 
                                <thead>
                                    <tr>
                                        <th><?php echo display('sl') ?></th>
                                        <th><?php echo display('gift_name') ?></th>
                                        <th><?php echo display('worth') ?></th>
                                        <th><?php echo display('points') ?></th>
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
            "aaSorting": [[ 3, "asc" ]],
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
                    extend: "csv", title: "giftList", exportOptions: {
                        columns: [ 0, 1, 2, 3] //Your Colume value those you want
                    }, className: "btn-sm prints"
                }, 
                {
                    extend: "excel", title: "giftList", exportOptions: {
                        columns: [ 0, 1, 2, 3] //Your Colume value those you want
                    },className: "btn-sm prints"
                }, 
                {
                    extend: "pdf", title: " giftList",exportOptions: {
                        columns: [ 0, 1, 2, 3] //Your Colume value those you want
                    }, className: "btn-sm prints"
                }, 
                {
                    extend: "print",exportOptions: {
                        columns: [ 0, 1, 2, 3] //Your Colume value those you want
                        },title: "<center> giftList</center>", className: "btn-sm prints"
                }
            ],   
            'serverMethod': 'post',
            'ajax': {
                'url':'<?=base_url()?>Cgift/CheckGiftList'
            },
            'columns': [
                { data: 'sl' },
                { data: 'name' },
                { data: 'amount', class:"text-right" },
                { data: 'mintarget', class:"text-right" },
                { data: 'button', class:"text-center"},
            ]
        });
    });
    function requestForGift(gift_id, gift_amount){
        if(confirm('Do you want to claim this gift?\nPress OK otherwise Cancel!')==true){
            var base_url = $('.baseUrl').val();
            var dataString = 'gift_id='+gift_id+'&gift_amount='+gift_amount;
            $.ajax({
                type: "POST",
                url: '<?=base_url()?>Cgift/request_for_gift',
                data: dataString,
                cache: false,
                dataType: 'json',
                success: function(data){
                    if(data['status'] == true){
                        $('.requestForGift_'+gift_id).removeAttr('onclick');
                        $('.requestForGift_'+gift_id).html('Claimed');
                        $('.requestForGift_'+gift_id).removeClass('btn-primary');
                        $('.requestForGift_'+gift_id).addClass('btn-success');
                        window.location.href = window.location.href;
                    }
                }
            });
        }
    }
</script>