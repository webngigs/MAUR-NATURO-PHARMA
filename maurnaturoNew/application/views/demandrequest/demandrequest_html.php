<?php
$CI =& get_instance();
$CI->load->model('Web_settings');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
?>

<!-- Printable area start -->
<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
    function printDiv(divName) {
        var printContents       =   document.getElementById(divName).innerHTML;
        var originalContents    =   document.body.innerHTML;
        document.body.innerHTML =   printContents;
        window.print();
        document.body.innerHTML =   originalContents;
    }
</script>
<!-- Printable area end -->

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon"><i class="pe-7s-note2"></i></div>
        <div class="header-title">
            <h1><?php echo display('demandrequests_details') ?></h1>
            <small><?php echo display('demandrequests_details') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('demandrequest') ?></a></li>
                <li class="active"><?php echo display('details') ?></li>
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
        if($this->permission1->method('manage_demandrequest','read')->access() ){
            if($status == 1)        $demandrequest_status = '<strong class="text-primary">Pending</strong>';
            else if($status == 2)   $demandrequest_status = '<strong class="text-danger">Cancelled</strong>';
            elseif($status == 3)    $demandrequest_status = '<strong class="text-success">Approved</strong>';
            elseif($status == 4)    $demandrequest_status = '<strong class="text-success">Received</strong>';    

            ?><div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd">
                        <div id="printableArea">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-8" style="display: inline-block;width: 64%">
                                        <img src="<?php if(isset($Web_settings[0]['invoice_logo'])) echo $Web_settings[0]['invoice_logo']; ?>" class="" alt="" style="margin-bottom:20px">
                                    </div>
                                    <div class="col-sm-4 text-left" style="display: inline-block;margin-left: 5px;">
                                        <h3 class="m-t-0"><?php echo display('demandrequests_details') ?></h3>
                                        <div><?php echo display('demandrequest_no') ?> : {demandrequest_no}</div>
                                        <div><?php echo display('demandrequest_date') ?> : {final_date}</div>
                                        <div class="m-b-15"><?php echo display('status') ?> : <?php echo $demandrequest_status; ?></div>
                                    </div>
                                </div><hr>

                                <div class="table-responsive m-b-20">
	                                <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-left"><?php echo display('sl'); ?></th>
                                                <th class="text-left"><?php echo display('product_name'); ?></th>
                                                <th class="text-right"><?php echo display('quantity'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {demandrequest_all_data}
                                            <tr>
                                                <td class="text-left">{sl}</td>
                                                <td class="text-left"><div><strong>{product_name} - ({strength})</strong></div></td>
                                                <td class="text-right">{quantity}</td>
                                            </tr>
                                            {/demandrequest_all_data}
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
		                        	<div class="col-xs-12" style="display: inline-block;">
		                                <p></p>
		                                <p><strong>{demandrequest_detail}</strong></p>		                               
		                            </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-left">
                            <button class="btn btn-info" onclick="printDiv('printableArea')"><span class="fa fa-print"></span> <?php echo display('print'); ?></button>
                        </div>
                    </div>
                </div>
            </div><?php
        }
        else{
            ?><div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title"><h4><?php 
                            echo display('You do not have permission to access. Please contact with administrator.');
                        ?></h4></div>
                    </div>
                </div>
            </div><?php
        }
	?></section>
</div>