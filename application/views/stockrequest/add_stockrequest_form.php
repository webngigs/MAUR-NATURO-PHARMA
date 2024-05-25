<script src="<?php echo base_url()?>my-assets/js/admin_js/sendrequest.js" type="text/javascript"></script>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('new_stockrequest') ?></h1>
            <small><?php echo display('add_new_stockrequest') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('stockrequest') ?></a></li>
                <li class="active"><?php echo display('new_stockrequest') ?></li>
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
                    if($this->permission1->method('manage_stockrequest', 'read')->access()){ 
                        ?><a href="<?php echo base_url('Cstockrequest/manage_stockrequest')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_stockrequest')?> </a><?php 
                    }
                ?></div>
            </div>
        </div><?php
        if($this->permission1->method('add_stockrequest', 'create')->access()) {
            ?><div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h4><?php echo display('new_stockrequest') ?></h4>
                    </div>
                </div>
                <div class="panel-body"><?php 
                    echo form_open_multipart('Cstockrequest/insert_stockrequest', array('class' => 'form-vertical', 'id' => 'insert_stockrequest', 'name' => '')); 
                    if($user_id == 1){ 
                        ?><div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="mr_name" class="col-sm-12 col-form-label"><?php echo display('mr_name') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="mr_name" class=" form-control" placeholder='<?php echo display('mr_name') ?>' id="mr_name" tabindex="1" onkeyup="mr_autocomplete()" value="" required  />
                                        <input id="autocomplete_mr_id" class="mr_hidden_value abc" type="hidden" name="mr_id"  value="{mr_id}">
                                    </div>
                                </div>
                            </div>
                        </div><?php 
                    } 
                        ?><div class="table-responsive" style="margin-top: 10px">
                            <table class="table table-bordered table-hover" id="normalstockrequest">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 220px"><?php echo display('item_information') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center" width="130"><?php echo display('batch') ?><i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('available_qnty') ?></th>
                                        <th class="text-center" width="120"><?php echo display('expiry') ?></th>
                                        <th class="text-center" width="100"><?php echo display('unit') ?></th>
                                        <th class="text-center"  width="70"><?php echo display('qty') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center" width="100"><?php echo display('price') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center" width="110"><?php echo display('total') ?></th>
                                        <th class="text-center"><?php echo display('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody id="addstockrequestsItem">
                                    <tr>
                                        <td style="width: 220px">
                                            <input type="text" name="product_name" onkeyup="invoice_productList(1);" onkeypress="invoice_productList(1);" class="form-control productSelection" placeholder='<?php echo display('product_name') ?>' required="" id="product_name_1" tabindex="7">
                                            <input type="hidden" class="autocomplete_hidden_value product_id_1" name="product_id[]" id="SchoolHiddenId" />
                                            <input type="hidden" class="baseUrl" value="<?php echo base_url();?>" />
                                        </td>
                                        <td>
                                            <select class="form-control" id="batch_id_1" name="batch_id[]"  onchange="product_stock(1)" tabindex="8" required="required">
                                                <option value="">Select One</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="available_quantity[]" class="form-control text-right available_quantity_1" value="0" readonly="" id="available_quantity_1"/>
                                        </td>
                                        <td id="expire_date_1"></td>
                                        <td>
                                            <input name="" id="" class="form-control text-right unit_1 valid" value="None" readonly="" aria-invalid="false" type="text">
                                        </td>
                                        <td>
                                            <input type="text" name="product_quantity[]" onkeyup="quantity_calculate(1),checkqty(1);" onchange="quantity_calculate(1);" class="total_qntt_1 form-control text-right" id="total_qntt_1" placeholder="0.00" min="0" tabindex="9" required/>
                                        </td>
                                        <td>
                                            <input type="text" name="product_rate[]" id="price_item_1" class="price_item1 price_item form-control text-right" tabindex="10" required="" onkeyup="quantity_calculate(1),checkqty(1);" onchange="quantity_calculate(1);" placeholder="0.00" min="0" readonly/>
                                        </td>
                                        <td style="width: 100px">
                                            <input class="total_price form-control text-right" type="text" name="total_price[]" id="total_price_1" value="0.00" readonly="readonly" />
                                        </td>
                                        <td>
                                            <button style="text-align: right;" class="btn btn-info" type="button" onClick="addInputField('addstockrequestsItem');" tabindex="12" id="add_stockrequests_item"><i class="fa fa-plus"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="8">
                                            <label style="text-align:center;" for="details" class="col-form-label"><?php echo display('stockrequests_details') ?></label>
                                            <textarea name="stockrequests_details" class="form-control" placeholder="<?php echo display('stockrequests_details') ?>"></textarea>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7"  style="text-align:right;"><b><?php echo display('grand_total') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="grandTotal" class="form-control text-right" name="grand_total_price" value="0.00" readonly="readonly" />
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <input type="submit" id="add_stockrequest" class="btn btn-success" name="add-stockrequest" value="<?php echo display('submit') ?>"/><?php 
                    echo form_close();
                ?></div>
            </div><?php
        }
    ?></section>
</div>

<script type="text/javascript">
    function invoice_productList(sl) {
        var priceClass  =   'price_item'+sl;
        var unit        =   'unit_'+sl; 
        var batch_id    =   'batch_id_'+sl;
        var options = {
            minLength: 0,
            source: function( request, response ) {
                var product_name = $('#product_name_'+sl).val();
                $.ajax({
                    url     :   "<?php echo base_url('Cinvoice/autocompleteproductsearch')?>",
                    method  :   'post',
                    dataType:   "json",
                    data    :   {
                        term            :   request.term,
                        product_name    :   product_name,
                    },
                    success:function(data) {
                        response(data);
                    }
                });
            },
            focus:function(event, ui) {
                $(this).val(ui.item.label);
                return false;
            },
            select:function(event, ui) {
                $(this).parent().parent().find(".autocomplete_hidden_value").val(ui.item.value); 
                $(this).val(ui.item.label);
                var id=ui.item.value;
                var dataString = 'product_id='+ id;
                var base_url = $('.baseUrl').val();
                $.ajax({
                    type: "POST",
                    url: base_url+"Cinvoice/retrieve_product_data_inv",
                    data: dataString,
                    cache: false,
                    success: function(data){
                        var obj = jQuery.parseJSON(data);
                        $('.'+priceClass).val(obj.price);
                        $('.'+unit).val(obj.unit);
                        $('#'+batch_id).html(obj.batch);    
                        quantity_calculate(sl);
                    } 
                });
                $(this).unbind("change");
                return false;
            }
        }
        //$('body').on('keypress.autocomplete', '.productSelection', function() {
            $('.productSelection').autocomplete(options);
        //});
    }
    function product_stock(sl) {
        var batch_id            =   $('#batch_id_'+sl).val();
        var dataString          =   'batch_id='+ batch_id;
        var base_url            =   $('.baseUrl').val();
        var available_quantity  =   'available_quantity_'+sl;
        var product_rate        =   'product_rate_'+sl;
        var expire_date         =   'expire_date_'+sl;
        if(batch_id == '') {
            alert('Please Select Batch ID');
            return false;     
        }
        else{
            $.ajax({
                type: "POST",
                url: base_url+"Cinvoice/retrieve_product_batchid",
                data: dataString,
                cache: false,
                success: function(data){
                    obj = JSON.parse(data);
                    var today = new Date();
                    var dd = today.getDate();
                    var mm = today.getMonth()+1; //January is 0!
                    var yyyy = today.getFullYear();
                    if(dd<10)   dd='0'+dd;
                    if(mm<10)   mm='0'+mm;
                    var today = yyyy+'-'+mm+'-'+dd;
                    aj  =   new Date(today);
                    exp =   new Date(obj.expire_date);
                    if(aj >= exp) {
                        alert('<?php echo display('date_expired_please_choose_another')?>');
                        $('#total_qntt_'+sl).val('');
                        $('#batch_id_'+sl)[0].selectedIndex = 0;
                        $('#'+expire_date).html('<p style="color:red;align:center">'+obj.expire_date+'</p>');
                        document.getElementById('expire_date_'+sl).innerHTML = '';
                    }
                    else{
                        $('#'+expire_date).html('<p style="color:green;align:center">'+obj.expire_date+'</p>');
                    }
                    $('#'+available_quantity).val(obj.total_product);
                }
            });
            $(this).unbind("change");
            return false;
        }
    }
    function checknum(){
        var dis     =   $("#invdcount").val();
        var paid    =   $("#paidAmount").val();
        if(isNaN(dis)){
            alert("<?php echo display('must_input_numbers')?>");
            document.getElementById("invdcount").value = '';
            return false;
        }
        if(isNaN(paid)){
            alert("<?php echo display('must_input_numbers')?>");
            document.getElementById("paidAmount").value = '';
            return false;
        }
    }
    function checkqty(sl) {
        var batch_id =   $('#batch_id_'+sl).val();
        var quant    =   $("#total_qntt_"+sl).val();
        var price    =   $("#price_item_"+sl).val();
        if(batch_id == '') {
            alert('Please Select Batch ID');
            return false;     
        }
        else{
            if(isNaN(quant)) {
                alert("<?php echo display('must_input_numbers')?>");
                document.getElementById("total_qntt_"+sl).value = '';
                return false;
            }
            //else $("#batch_id_"+sl).attr('disabled', 'disabled');   
            //if(quant=='') $("#batch_id_"+sl).removeAttr('disabled');
            
            if(isNaN(price)) {
                alert("<?php echo display('must_input_numbers')?>");
                document.getElementById("price_item_"+sl).value = '';
                return false;
            }
        }
    }
    function mr_autocomplete(sl) {
        var mr_id = $('#mr_id').val();
        var options = {
            minLength: 0,
            source: function( request, response ) {
                var mr_name = $('#mr_name').val();
                $.ajax({
                    url: "<?php echo base_url('Cstockrequest/mr_autocomplete')?>",
                    method: 'post',
                    dataType: "json",
                    data: {
                        term:request.term,
                        mr_id:mr_name,
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            focus: function( event, ui ) {
                $(this).val(ui.item.label);
                return false;
            },
            select: function( event, ui ) {
                $(this).parent().parent().find("#autocomplete_mr_id").val(ui.item.value); 
                var mr_id = ui.item.value;
                $(this).unbind("change");
                return false;
            }
        }
        //$('body').on('keypress.autocomplete', '#mr_name', function(){ 
            $('#mr_name').autocomplete(options); 
        //});
    }
</script>