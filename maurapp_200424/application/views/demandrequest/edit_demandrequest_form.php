<script src="<?php echo base_url()?>my-assets/js/admin_js/sendrequest.js" type="text/javascript"></script>
<style type="text/css">
    .hiddenRow { display: none;}
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon"><i class="pe-7s-note2"></i></div>
        <div class="header-title">
            <h1><?php echo display('stockrequests_edit') ?></h1>
            <small><?php echo display('stockrequests_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('stockrequest') ?></a></li>
                <li class="active"><?php echo display('edit') ?></li>
            </ol>
        </div>
    </section><?php
    if($this->permission1->method('manage_stockrequest', 'update')->access()){ 
        ?><section class="content"><?php
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
            ?><div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h4><?php echo display('stockrequests_edit') ?></h4>
                    </div>
                </div>
                <div class="panel-body"><?php 
                    echo form_open('Cstockrequest/stockrequest_update',array('class' => 'form-vertical','id'=>'stockrequest_update' ))
                    ?><div class="table-responsive" style="margin-top: 10px">
                        <table class="table table-bordered table-hover" id="normalinvoice">
                            <thead>
                                <tr>
                                    <th class="text-left" style="width: 220px"><?php echo display('item_information') ?> <i class="text-danger">*</i></th>
                                    <th class="text-center" width="130"><?php echo display('batch') ?> <i class="text-danger">*</i></th>
                                    <th class="text-center"><?php echo display('available_qnty') ?></th>
                                    <th class="text-center" width="120"><?php echo display('expiry') ?></th>
                                    <th class="text-center"><?php echo display('unit') ?></th>
                                    <th class="text-center"><?php echo display('qty') ?> <i class="text-danger">*</i></th>
                                    <th class="text-center"><?php echo display('price') ?> <i class="text-danger">*</i></th>
                                    <th class="text-center"><?php echo display('total') ?></th>
                                    <th class="text-center"><?php echo display('action') ?></th>
                                </tr>
                            </thead>
                            <tbody id="addstockrequestsItem"><?php
                                if($stockrequest_all_data) {
                                    foreach($stockrequest_all_data as $invoice) {
                                        $batch_info = $this->db->select('batch_id')->from('product_purchase_details')->where('product_id',$invoice['product_id'])->get()->result();
                                        $expire = $this->db->select('expeire_date')->from('product_purchase_details')->where('batch_id',$invoice['batch_id'])->group_by('batch_id')->get()->result();
                                        ?><tr>
                                            <td class="" style="width: 200px;">
                                                <input type="text" name="product_name" onkeyup="invoice_productList(<?php echo $invoice['sl']?>);" value="<?php echo $invoice['product_name']?>-(<?php echo $invoice['product_model']?>)" class="form-control productSelection" required placeholder='<?php echo display('product_name') ?>' id="product_name_<?php echo $invoice['sl']?>" tabindex="<?php echo $invoice['sl']+2?>)">
                                                <input type="hidden" class="product_id_<?php echo $invoice['sl']?> autocomplete_hidden_value" name="product_id[]" value="<?php echo $invoice['product_id']?>" id="SchoolHiddenId"/>
                                            </td>
                                            <td>
                                                <select name="batch_id[]" id="batch_id_<?php echo $invoice['sl']?>" class="form-control" required="required" onchange="product_stock(<?php echo $invoice['sl']?>)" tabindex="<?php echo $invoice['sl']+3?>)"><?php 
                                                foreach ($batch_info as $batch) {
                                                    ?><option value="<?php echo $batch->batch_id; ?>" <?php if ($batch->batch_id == $invoice['batch_id']) {echo "selected"; }?>><?php echo $batch->batch_id; ?></option><?php 
                                                }
                                                ?></select>
                                            </td>
                                            <td>
                                                <input type="text" name="available_quantity[]" class="form-control text-right available_quantity_<?php echo $invoice['sl']?>" value="0" readonly="" id="available_quantity_<?php echo $invoice['sl']?>"/>
                                            </td>
                                            <td id="expire_date_<?php echo $invoice['sl']?>"><?php foreach ($expire as $vale) { echo $vale->expeire_date; } ?></td>
                                            <td>
                                                <input name="" id="" class="form-control text-right unit_<?php echo $invoice['sl']?> valid" value="<?php echo $invoice['unit']?>" readonly="" aria-invalid="false" type="text">
                                            </td>
                                            <td>
                                                <input type="text" name="product_quantity[]" onkeyup="quantity_calculate(<?php echo $invoice['sl']?>),checkqty(<?php echo $invoice['sl']?>);" onchange="quantity_calculate(<?php echo $invoice['sl']?>);" value="<?php echo $invoice['quantity']?>" class="total_qntt_<?php echo $invoice['sl']?> form-control text-right" id="total_qntt_<?php echo $invoice['sl']?>" min="0" placeholder="0.00" tabindex="<?php echo $invoice['sl']+4?>)" />
                                            </td>
                                            <td>
                                                <input type="text" name="product_rate[]" onkeyup="quantity_calculate(<?php echo $invoice['sl']?>),checkqty(<?php echo $invoice['sl']?>);" onchange="quantity_calculate(<?php echo $invoice['sl']?>);" value="<?php echo $invoice['rate']?>" id="price_item_<?php echo $invoice['sl']?>" class="price_item<?php echo $invoice['sl']?> form-control text-right" min="0" required="" placeholder="0.00" readonly/>
                                            </td>
                                            <td>
                                                <input class="total_price form-control text-right" type="text" name="total_price[]" id="total_price_<?php echo $invoice['sl']?>" value="<?php echo $invoice['total_price']?>" readonly="readonly" />
                                                <input type="hidden" name="invoice_details_id[]" id="invoice_details_id" value="<?php echo $invoice['invoice_details_id']?>"/>
                                            </td>
                                            <td>
                                                <button style="text-align: right;" class="btn btn-danger" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)" tabindex="<?php echo $invoice['sl']+6?>)"><i class="fa fa-close"></i></button>
                                            </td>
                                        </tr><?php
                                    }
                                }
                            ?></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">
                                        <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>
                                        <input type="hidden" name="stockrequests_id" id="stockrequests_id" value="{stockrequests_id}"/>
                                        <label for="stockrequests_details" class="col-form-label"><?php echo display('stockrequests_details') ?></label></center>
                                        <textarea name="stockrequests_details" class="form-control" placeholder="<?php echo display('stockrequests_details') ?>">{stockrequests_details}</textarea>
                                    </td>
                                    <td> 
                                        <button style="text-align: right;" class="btn btn-info" type="button" onClick="addInputField('addstockrequestsItem');" tabindex="12" id="add_stockrequests_item"><i class="fa fa-plus"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7"  style="text-align:right;"><b><?php echo display('grand_total') ?>:</b></td>
                                    <td class="text-right">
                                        <input type="text" id="grandTotal" class="form-control text-right" name="grand_total_price" value="<?php $grandttl=$total_amount; echo $grandttl; ?>" readonly="readonly" />
                                    </td>
                                    <td></td>
                                </tr>
                                
                            </tfoot>
                        </table>
                    </div>
                    <input type="submit" id="add_stockrequest" class="btn btn-success" name="add-stockrequest" value="<?php echo display('save_changes') ?>"/><?php 
                    echo form_close()
                ?></div>
            </div>
        </section><?php
    }
    else{
        ?><div class="col-sm-12"><div class="panel panel-bd lobidrag"><div class="panel-heading">
            <div class="panel-title"><h4><?php echo display('You do not have permission to access. Please contact with administrator')?></h4></div>
        </div></div></div><?php
    }
?></div>
<style type="text/css">
    .btn:focus { background-color: #6A5ACD; }
</style>
<script type="text/javascript">
    $(document).ready(function(){ $('#normalinvoice .toggle').on('click', function(){ $('#normalinvoice .hideableRow').toggleClass('hiddenRow'); });});
    function product_stock(sl) {
        var batch_id            =   $('#batch_id_'+sl).val();
        var dataString          =   'batch_id='+ batch_id;
        var base_url            =   $('.baseUrl').val();
        var available_quantity  =   'available_quantity_'+sl;
        var product_rate        =   'product_rate_'+sl;
        var expire_date         =   'expire_date_'+sl;
        $.ajax({
            type    : "POST",
            url     : base_url+"Cinvoice/retrieve_product_batchid",
            data    : dataString,
            cache   : false,
            success : function(data) {
                obj = JSON.parse(data);
                var today   =   new Date();
                var dd      =   today.getDate();
                var mm      =   today.getMonth()+1; //January is 0!
                var yyyy    =   today.getFullYear();
                if(dd<10)   dd  =   '0'+dd;
                if(mm<10)   mm  =   '0'+mm;
                var today   =   yyyy+'-'+mm+'-'+dd;
                aj  =   new Date(today);
                exp =   new Date(obj.expire_date);
                if(aj>=exp) {
                    alert('<?php echo display('date_expired_please_choose_another')?>');
                    $('#batch_id_'+sl)[0].selectedIndex = 0;
                    $('#'+expire_date).html('<p style="color:red;align:center">'+obj.expire_date+'</p>');
                    document.getElementById('expire_date_'+sl).innerHTML = '';
                }
                else $('#'+expire_date).html('<p style="color:green;align:center">'+obj.expire_date+'</p>');
                $('#'+available_quantity).val(obj.total_product);
            }
        });
        $(this).unbind("change");
        return false;
    }
    function checkqty(sl) {
        var quant   =   $("#total_qntt_"+sl).val();
        var price   =   $("#price_item_"+sl).val();
        if(isNaN(quant)){
            alert("<?php echo display('must_input_numbers')?>");
            document.getElementById("total_qntt_"+sl).value = '';
            return false;
        }
        if(isNaN(price)){
            alert("<?php echo display('must_input_numbers')?>");
            document.getElementById("price_item_"+sl).value = '';
            return false;
        }
    }
    function checknum(){ }
    function invoice_productList(sl) {
        var priceClass  =   'price_item'+sl;
        var unit        =   'unit_'+sl;
        var batch_id    =   'batch_id_'+sl;
        var options = {
            minLength: 0,
            source: function(request, response) {
                var product_name = $('#product_name_'+sl).val();
                $.ajax({
                    url         :   "<?php echo base_url('Cinvoice/autocompleteproductsearch')?>",
                    method      :   'post',
                    dataType    :   "json",
                    data: {
                        term        :   request.term,
                        product_name:   product_name,
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            focus: function( event, ui ) {
                $(this).val(ui.item.label);
                return false;
            },
            select: function( event, ui ) {
                $(this).parent().parent().find(".autocomplete_hidden_value").val(ui.item.value); 
                $(this).val(ui.item.label);
                var id=ui.item.value;
                var dataString = 'product_id='+ id;
                var base_url = $('.baseUrl').val();
                $.ajax({
                    type    :   "POST",
                    url     :   base_url+"Cinvoice/retrieve_product_data_inv",
                    data    :   dataString,
                    cache   :   false,
                    success :   function(data){
                        var obj = jQuery.parseJSON(data);
                        $('.'+priceClass).val(obj.price);
                        $('.'+unit).val(obj.unit);
                        $('.'+tax).val(obj.tax);
                        $('#txfieldnum').val(obj.txnmber);
                        $('#'+discount_type).val(obj.discount_type);
                        $('#'+batch_id).html(obj.batch);        
                        quantity_calculate(sl);
                    } 
                });
                $(this).unbind("change");
                return false;
            }
        }
        //$('body').on('keypress.autocomplete', '.productSelection', function(){ 
            $('.productSelection').autocomplete(options); 
        
        //});
    }
</script>