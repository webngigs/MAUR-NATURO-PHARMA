<style type="text/css">
    .prints{
        background-color: #31B404;
        color:#fff;
    }
</style>
<!-- Manage Invoice Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('manage_proforma_invoice') ?></h1>
            <small><?php echo display('manage_proforma_invoice') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('proforma_invoice') ?></a></li>
                <li class="active"><?php echo display('manage_proforma_invoice') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- Alert Message -->
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

        <div class="row">
            <div class="col-sm-12">
                <div class="column"><?php 
                if($this->permission1->method('new_proforma_invoice','create')->access()){ 
                    ?><a href="<?php echo base_url('Cproformainvoice') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('new_proforma_invoice') ?> </a><?php 
                }
                ?></div>
            </div>
        </div>

        <!-- date between search -->
        <div class="row">
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
        <!-- Manage Invoice report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('proforma_invoice') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive" >
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="InvList"> 
                                <thead>
                                    <tr>
                                        <th><?php echo display('sl') ?></th>
                                        <th><?php echo display('proforma_invoice_no') ?></th>
                                        <th><?php echo display('customer_name') ?></th>
                                        <th><?php echo display('date') ?></th>
                                        <th><?php echo display('total_amount') ?></th>
                                        <th><?php echo display('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
             
                                </tbody>
                                <tfoot>
                                    <th colspan="4" style="text-align:right">Total:</th>
                                    <th></th>  
                                    <th></th> 
                                </tfoot>
                            </table>
                            
                        </div>
                       

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Manage Invoice End -->

<!-- Manage Product End -->
<script type="text/javascript">
$(document).ready(function() { 
 var mydatatable = $('#InvList').DataTable({ 
             responsive: true,

             "aaSorting": [[ 1, "desc" ]],
             "columnDefs": [
                { "bSortable": false, "aTargets": [0,2,3,4,5] },

            ],
           'processing': true,
           'serverSide': true,

          
           'lengthMenu':[[10, 25, 50,100,250,500, "<?php echo $total_invoice;?>"], [10, 25, 50,100,250,500, "All"]],

             dom:"'<'col-sm-4'l><'col-sm-4 text-center'><'col-sm-4'>Bfrtip", buttons:[ 
                {
                    extend: "copy",exportOptions: {
                       columns: [ 0, 1, 2, 3,4 ] //Your Colume value those you want
                           }, className: "btn-sm prints"
            }
            , {
                extend: "csv", title: "InvoiceList",exportOptions: {
                       columns: [ 0, 1, 2, 3,4] //Your Colume value those you want print
                           }, className: "btn-sm prints"
            }
            , {
                extend: "excel",exportOptions: {
                       columns: [ 0, 1, 2, 3,4 ] //Your Colume value those you want print
                           }, title: "InvoiceList", className: "btn-sm prints"
            }
            , {
                extend: "pdf",exportOptions: {
                       columns: [ 0, 1, 2, 3,4 ] //Your Colume value those you want print
                           }, title: "Invoice List", className: "btn-sm prints"
            }
            , {
                extend: "print",exportOptions: {
                       columns: [ 0, 1, 2, 3,4 ] //Your Colume value those you want print
                           }, title: "Invoice List", className: "btn-sm prints"
            }
            ],

            
            'serverMethod': 'post',
            'ajax': {
                'url':'<?=base_url()?>Cproformainvoice/CheckInvoiceList',
                "data": function ( data) {
                    data.fromdate = $('#from_date').val();
                    data.todate = $('#to_date').val();
                    //data.status = $('#status').val();
                }
            },
            'columns': [
                { data: 'sl' },
                { data: 'proforma' },
                { data: 'customer_name'},
                { data: 'final_date', class:"text-center" },
                { data: 'total_amount', class:"total_sale text-right"},
                { data: 'button', class:"text-center"},
            ],

  "footerCallback": function(row, data, start, end, display) {
  var api = this.api();
   api.columns('.total_sale', {
    page: 'current'
  }).every(function() {
    var sum = this
      .data()
      .reduce(function(a, b) {
        var x = parseFloat(a) || 0;
        var y = parseFloat(b) || 0;
        return x + y;
      }, 0);
    $(this.footer()).html(sum.toFixed(2, 2)+' INR');
  });
}


    });


$('#btn-filter').click(function(){ 
mydatatable.ajax.reload();  
});

});
</script>
<script>
	function convertIntoInvoice(invoice_id){
        if(confirm('Do you want to convert proforma to invoice?\nPress OK otherwise Cancel!')==true){
			var dataString = 'invoice_id='+invoice_id;
			$.ajax({
				type: "POST",
				url: '<?=base_url()?>Cproformainvoice/convertIntoInvoice',
				data: dataString,
				cache: false,
				dataType: 'json',
				success: function(data){
					if(data['status'] == true){
						window.location.href = '<?=base_url()?>Cinvoice/invoice_inserted_data/'+data['invoice_id'];		
					}
					else{
						alert('Error while COnvert Proforma into Invoice!!');
					}
				}
			});
        }
    }
</script>