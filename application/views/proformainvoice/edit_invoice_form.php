<!-- <script src="<?php echo base_url()?>my-assets/js/admin_js/json/product_invoice.js.php" ></script> -->
<!-- Invoice js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/invoice.js?v=3.9" type="text/javascript"></script>
<style type="text/css">
     .hiddenRow {
  display: none;
}
</style>

<!-- Edit Invoice Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('proforma_invoice_edit') ?></h1>
            <small><?php echo display('proforma_invoice_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('proforma_invoice') ?></a></li>
                <li class="active"><?php echo display('proforma_invoice_edit') ?></li>
            </ol>
        </div>
    </section>

    <?php
    if ($this->permission1->method('manage_proforma_invoice','update')->access()){ ?>
  <section class="content">
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
        <!-- Invoice report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('proforma_invoice_edit') ?></h4>
                        </div>
                    </div>
                    <?php echo form_open('Cproformainvoice/invoice_update',array('class' => 'form-vertical','id'=>'invoice_update' ))?>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-6" id="payment_from_1">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-4 col-form-label"><?php echo display('customer_name') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">

                                         <input type="text" size="100"  name="customer_name" class=" form-control" placeholder='<?php echo display('customer_name').'/'.display('phone') ?>' id="customer_name" value="{customer_name}" tabindex="1" onkeyup="customer_autocomplete()"/>

                                        <input id="autocomplete_customer_id" class="customer_hidden_value abc" type="hidden" name="customer_id" value="{customer_id}">
                                    </div>
                                </div>
                            </div>
                                <div class="col-sm-6" id="payment_from_1">
                                <div class="form-group row">
                                    <label for="payment_type" class="col-sm-4 col-form-label"><?php
                                        echo display('payment_type');
                                        ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <select name="paytype" class="form-control" required="" onchange="bank_paymet(this.value)">
                                            <option value="">Select Payment Option</option>
                                            <option value="1" <?php if($paytype ==1){echo 'selected';}?>>Cash Payment</option>
                                            <option value="2"  <?php if($paytype ==2){echo 'selected';}?>>Bank Payment</option> 
                                        </select>
                                      

                                     
                                    </div>
                                 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-4 col-form-label"><?php echo display('date') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input type="text" tabindex="2" class="form-control datepicker" readonly name="invoice_date" value="{date}"  required />
                                    </div>
                                </div>
                            </div>
                               <div class="col-sm-6" id="bank_div" style="display: <?php if($paytype == 2){echo 'block';}else{echo 'none';}?>;">
                            <div class="form-group row">
                                <label for="bank" class="col-sm-4 col-form-label"><?php
                                    echo display('bank');
                                    ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                   <select name="bank_id" class="form-control"  id="bank_id">
                                        <option value="">Select Location</option>
                                        <?php foreach($bank_list as $bank){?>
                                            <option value="<?php echo $bank['bank_id']?>" <?php if($bank['bank_id'] == $bank_id){echo 'selected';}?>><?php echo $bank['bank_name'];?></option>
                                        <?php }?>
                                    </select>
                                 
                                </div>
                             
                            </div>
                        </div>
                        </div>

                        <div class="table-responsive" style="margin-top: 10px">
                            <table class="table table-bordered table-hover" id="normalinvoice">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 210px"><?php echo display('item_information') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center" width="120"><?php echo display('batch') ?><i class="text-danger">*</i></th>
                                        <th class="text-center" width="130"><?php echo display('expiry') ?></th>
                                        <th class="text-center" width="70"><?php echo display('unit') ?></th>
                                        <th class="text-center"  width="100"><?php echo display('qty') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center" width="100"><?php echo display('price') ?> <i class="text-danger">*</i></th>

                                        <?php if ($discount_type == 1) { ?>
                                        <th class="text-center"><?php echo display('discount_percentage') ?> %</th>
                                        <?php }elseif($discount_type == 2){ ?>
                                        <th class="text-center"><?php echo display('discount') ?> </th>
                                        <?php }elseif($discount_type == 3) { ?>
                                        <th class="text-center"><?php echo display('fixed_dis') ?> </th>
                                        <?php } ?>
                                        <th class="text-center" width="110">Rate</th>
                                        <th class="text-center" width="110"><?php echo display('total') ?></th>
                                        <th class="text-center" width="140">G. <?php echo display('total') ?></th>
                                        <th class="text-center"><?php echo display('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody id="addinvoiceItem">
                                <?php
                                $dataCounter = 0;
                                if ($invoice_all_data) {
                                    $dataCounter = count($invoice_all_data);
                                    foreach ($invoice_all_data as $invoice) {
                                        $batch_info = $this->db->select('batch_id')
                                                        ->from('product_purchase_details')
                                                        ->where('product_id',$invoice['product_id'])
                                                        ->get()
                                                        ->result();
                                ?>
                                <?php

                               $expire = $this->db->select('expeire_date')
                                                        ->from('product_purchase_details')
                                                        ->where('batch_id',$invoice['batch_id'])
                                                        ->group_by('batch_id')
                                                        ->get()
                                                        ->result();

                                ?>
                                    <tr>
                                        <td class="" style="width: 200px;">
                                            <?php echo $invoice['product_name']?>-(<?php echo $invoice['product_model']?>)
                                            <input type="hidden" name="product_name" value="<?php echo $invoice['product_name']?>-(<?php echo $invoice['product_model']?>)" id="product_name_<?php echo $invoice['sl']?>">
                                            <input type="hidden" class="product_id_<?php echo $invoice['sl']?> autocomplete_hidden_value" name="product_id[]" value="<?php echo $invoice['product_id']?>"/>
                                        </td>
                                        <td><?php echo $invoice['batch_id']; ?>
                                        <input type="hidden" name="batch_id[]" class="batch_id<?php echo $invoice['sl']?>" value="<?php echo $invoice['batch_id']; ?>" id="batch_id_<?php echo $invoice['sl']?>"/></td>
                                        <td id="expire_date_<?php echo $invoice['sl']?>">
                                            <?php foreach ($expire as $vale) {
                                                echo $vale->expeire_date;
                                            }?>
                                        </td>
                                        <td><?php echo $invoice['unit']?></td> 
                                        <td>
                                            <input type="text" readonly name="product_quantity[]" onkeyup="quantity_calculate(<?php echo $invoice['sl']?>),checkqty(<?php echo $invoice['sl']?>);" onchange="quantity_calculate(<?php echo $invoice['sl']?>);" value="<?php echo $invoice['quantity']?>" class="total_qntt_<?php echo $invoice['sl']?> form-control text-right" id="total_qntt_<?php echo $invoice['sl']?>" min="0" placeholder="0.00" tabindex="<?php echo $invoice['sl']+4?>)" />
                                        </td>

                                        <td>
                                            <input type="text" name="product_rate[]" onkeyup="quantity_calculate(<?php echo $invoice['sl']?>),checkqty(<?php echo $invoice['sl']?>);" onchange="quantity_calculate(<?php echo $invoice['sl']?>);" value="<?php echo $invoice['rate']?>" id="price_item_<?php echo $invoice['sl']?>" class="price_item<?php echo $invoice['sl']?> form-control text-right" min="0" required="" placeholder="0.00" readonly/>
                                        </td>
                                        <!-- Discount -->
                                        <td>
                                            <input type="text" name="discount[]" onkeyup="quantity_calculate(<?php echo $invoice['sl']?>),checkqty(<?php echo $invoice['sl']?>);"  onchange="quantity_calculate(<?php echo $invoice['sl']?>);" id="discount_<?php echo $invoice['sl']?>" class="form-control text-right" placeholder="0.00" value="<?php echo $invoice['discount']?>" min="0" tabindex="<?php echo $invoice['sl']+5?>)"/>

                                            <input type="hidden" value="<?php echo $discount_type?>" name="discount_type" id="discount_type_<?php echo $invoice['sl']?>">
                                        </td>
                                        
                                        <td style="width: 100px" class="text-center">
                                            <strong id="item_rate_<?php echo $invoice['sl']?>"><?php echo $invoice['item_rate']; ?></strong> 
                                        </td>
                                        <td style="width: 100px" class="text-center">
                                            <strong id="total_item_rate_<?php echo $invoice['sl']?>"></strong>
                                        </td>

                                        <td>
                                            <input class="total_price form-control text-right" type="text" name="total_price[]" id="total_price_<?php echo $invoice['sl']?>" value="<?php echo $invoice['total_price']?>" readonly="readonly" />

                                            <input type="hidden" name="invoice_details_id[]" id="invoice_details_id" value="<?php echo $invoice['invoice_details_id']?>"/>
                                        </td>
                                         <td>

                                            <!-- Tax calculate start-->
                                            <?php $x=0;
                                            foreach($taxes as $taxfldt){?>
                                            <input id="total_tax<?php echo $x;?>_<?php echo $invoice['sl']?>" class="total_tax<?php echo $x;?>_<?php echo $invoice['sl']?>" type="hidden">
                                            <input id="all_tax<?php echo $x;?>_<?php echo $invoice['sl']?>" class="total_tax<?php echo $x;?>" type="hidden" name="tax[]">
                                             <?php $x++;} ?>
                                            <!-- Tax calculate end-->

                                            <!-- Discount calculate start-->
                                            <input type="hidden" id="total_discount_<?php echo $invoice['sl']?>" class="" value="<?php echo $invoice['discount']?>"/>

                                            <input type="hidden" id="all_discount_<?php echo $invoice['sl']?>" class="total_discount dppr" value="<?php echo $invoice['discount'] * $invoice['quantity']?>" />
                                            <!-- Discount calculate end -->

                                            <button style="text-align: right;" class="btn btn-danger" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)" tabindex="<?php echo $invoice['sl']+6?>)"><i class="fa fa-close"></i></button>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                }
                                ?>
                                </tbody>

                                       <tfoot>
                                    
                                    <tr>
                                        <td colspan="6" rowspan="2">
                                            <center><label style="text-align:center;" for="details" class="  col-form-label"><?php echo display('invoice_details') ?></label></center>
                                            <textarea name="inva_details" class="form-control" placeholder="<?php echo display('invoice_details') ?>">{invoice_details}</textarea>
                                        </td>
                                        <td style="text-align:right;" colspan="3"><b>Proforma Invoice Discount:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="invdcount" class="form-control text-right" name="invdcount" onkeyup="calculateSum(),checknum();" onchange="calculateSum()" placeholder="0.00" value="{invoice_discount}" />
                                            <input type="hidden" name="invoice_id" id="invoice_id" value="{invoice_id}"/>
                                           
                                        </td>
                                        <td> 
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="3"  style="text-align:right;"><b><?php echo display('total_discount') ?>:</b></td>
                                        <td class="text-right">
                                           <input type="text" id="total_discount_ammount" class="form-control text-right" name="total_discount"  readonly="readonly" value="{total_discount}"/>
                                              <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>
                                        </td>
                                        <td></td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="9"  style="text-align:right;"><b><?php echo display('total') ?> Amount:</b></td>
                                        <td class="text-right">
                                           <input type="text" id="total_s" class="form-control text-right"  value="0.00" readonly="readonly" />
                                        </td>
                                        <td></td>
                                    </tr>
                                    
                                         <?php $i=0;
                                     foreach($taxes as $taxfldt){?>
                                    <tr class="hideableRow hiddenRow">
                                       
                                <td style="text-align:right;" colspan="9"><b><?php echo $taxfldt['tax_name'] ?></b></td>
                                <td class="text-right">
                                    <input id="total_tax_amount<?php echo $i;?>" tabindex="-1" class="form-control text-right valid totalTax" name="total_tax<?php echo $i;?>" value="<?php $txval ='tax'.$i;
                                     echo $taxvalu[0][$txval]?>" readonly="readonly" aria-invalid="false" type="text">
                                    
                                </td>
                               
                               
                                 
                                </tr>
                            <?php $i++;}?>
                              <tr>
                                         
                                        <td style="text-align:right;" colspan="9"><b><?php echo display('total_tax') ?>:</b></td>
                                        <td class="text-right">
                                            <input id="total_tax_amount" tabindex="-1" class="form-control text-right valid" name="total_tax" value="{total_tax}" readonly="readonly" aria-invalid="false" type="text">
                                        </td>
                                         <td><button style="display:none;" type="button" class="toggle btn-warning">
                                            <i class="fa fa-angle-double-down"></i>
                                          </button></td>
                                    </tr>
                                    
                                    <tr>
                                        <td   style="text-align:right;">
                                            <input type="submit" id="add_invoice" class="btn btn-success" name="add-invoice" value="<?php echo display('save_changes') ?>" tabindex="15"/>
                                        </td>
                                        <td colspan="8"  style="text-align:right;"><b><?php echo display('grand_total') ?>:</b></td>
                                        <td class="text-right">
                                             <input type="text" id="grandTotal" class="form-control text-right" name="grand_total_price" value="<?php $grandttl=$total_amount;
                                            echo $grandttl; ?>" readonly="readonly" />
                                              <input type="hidden" id="txfieldnum" value="<?php echo count($taxes);?>">
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr style="display:none;">
                                    <td colspan="9"  style="text-align:right;"><b><?php echo display('previous'); ?>:</b></td>
                                    <td class="text-right">
                                        <input type="text" id="previous" class="form-control text-right" name="previous" value="{prev_due}" readonly="readonly" />
                                    </td>
                                    <td></td>
                                </tr>
                                <tr style="display:none;">
                                    
                                    <td colspan="9"  style="text-align:right;"><b><?php echo display('net_total'); ?>:</b></td>
                                    <td class="text-right">
                                        <input type="text" id="n_total" class="form-control text-right" name="n_total" value="{total_amount}" readonly="readonly" placeholder="" />
                                    </td>
                                    <td></td>
                                </tr>
                                    <tr  style="display:none;">
                                        <td style="text-align:right;" colspan="8"><b><?php echo display('paid_ammount') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="paidAmount"
                                            onkeyup="calculateSum(),checknum();" class="form-control text-right" name="paid_amount" placeholder="0.00" tabindex="13" value="{paid_amount}"/>
                                        </td>
                                    </tr>
                                    <tr style="display:none;">
                                        <td align="center">
                                            <input type="button" id="full_paid_tab" class="btn btn-warning" value="<?php echo display('full_paid') ?>" tabindex="14" onClick="full_paid()"/>

                                            <input type="submit" id="add_invoice" class="btn btn-success" name="add-invoice" value="<?php echo display('save_changes') ?>" tabindex="15"/>
                                        </td>

                                        <td style="text-align:right;" colspan="7"><b><?php echo display('due') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="dueAmmount" class="form-control text-right" name="due_amount" value="{due_amount}" readonly="readonly"/>
                                        </td>
                                    </tr>
                                    <tr id="change_m" style="display:none;"><td style="text-align:right;" colspan="8" id="ch_l"><b>Change:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="change" class="form-control text-right" name="change" value="" readonly="readonly"/>
                                        </td></tr>
                                </tfoot> 
                            </table>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
   <?php
    }
    else{
    ?>
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4><?php echo display('You do not have permission to access. Please contact with administrator')?></h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
</div>
<!-- Edit Invoice End -->

<style type="text/css">
    .btn:focus {
      background-color: #6A5ACD;
    }
</style>


<script type="text/javascript">

     $(document).ready(function() {

   var frm = $("#insert_sale");
    var output = $("#output");
    frm.on('submit', function(e) {
        e.preventDefault(); 
        $.ajax({
            url : $(this).attr('action'),
            method : $(this).attr('method'),
            dataType : 'json',
            data : frm.serialize(),
            success: function(data) 
            {
                if (data.status == true) {
                    output.empty().html(data.message).addClass('alert-success').removeClass('alert-danger').removeClass('hide');
              
                    $("#inv_id").val(data.invoice_id);
                  $('#printconfirmodal').modal('show');
                   if(data.status == true && event.keyCode == 13) {
                  //$('#yes').trigger('click');
        }
                  //$('#printconfirmodal').html(data.payment);
                } else {
                    output.empty().html(data.exception).addClass('alert-danger').removeClass('alert-success').removeClass('hide');
                }
            },
            error: function(xhr)
            {
                alert('failed!');
            }
        });
    });
     });
     $("#printconfirmodal").on('keydown', function ( e ) {
    var key = e.which || e.keyCode;
    if (key == 13) {
       $('#yes').trigger('click');
    }
});


     function cancelprint(){
   location.reload();
}

</script>

<script type="text/javascript">
    $('.ac').click(function () {
     $('.customer_hidden_value').val('');
 });
$('#myRadioButton_1').click(function () {
     $('#customer_name').val('');
 });

$('#myRadioButton_2').click(function () {
     $('#customer_name_others').val('');
 });
$('#myRadioButton_2').click(function () {
     $('#customer_name_others_address').val('');
 });

</script>
<script type="text/javascript">
      function bank_paymet(val){
        if(val==2){
           var style = 'block'; 
           document.getElementById('bank_id').setAttribute("required", true);
        }else{
   var style ='none';
    document.getElementById('bank_id').removeAttribute("required");
        }
           
    document.getElementById('bank_div').style.display = style;
    }

</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#normalinvoice .toggle').on('click', function() {
        $('#normalinvoice .hideableRow').toggleClass('hiddenRow');
    });
});
function product_stock(sl) {
    var customer_id         =   $('#autocomplete_customer_id').val();
    var batch_id            =   $('#batch_id_'+sl).val();
    var dataString          =   'batch_id='+ batch_id+'&customer_id='+customer_id;
    var base_url            =   $('.baseUrl').val();
    var available_quantity  =   'available_quantity_'+sl;
    var product_rate        =   'product_rate_'+sl;
    var item_rate           =   'item_rate_'+sl;
    var expire_date         =   'expire_date_'+sl;
     $.ajax({
        type: "POST",
        url: base_url+"Cproformainvoice/retrieve_product_batchid",
        data: dataString,
        cache: false,
        success: function(data)
        {
            obj = JSON.parse(data);
            // alert(today);
            $('#'+available_quantity).val(obj.total_product);
            $('#'+item_rate).html(obj.item_rate);
            quantity_calculate(sl);
        }
     });

    $(this).unbind("change");
    return false;
}


function checkqty(sl)
{

  var quant=$("#total_qntt_"+sl).val();
  var price=$("#price_item_"+sl).val();
  var dis=$("#discount_"+sl).val();
  if (isNaN(quant))
  {
    alert("<?php echo display('must_input_numbers')?>");
    document.getElementById("total_qntt_"+sl).value = '';
     //$("#quantity_"+sl).val() = '';
    return false;
  }
  if (isNaN(price))
  {
    alert("<?php echo display('must_input_numbers')?>");
     document.getElementById("price_item_"+sl).value = '';
    return false;
  }
  if (isNaN(dis))
  {
    alert("<?php echo display('must_input_numbers')?>");
     document.getElementById("discount_"+sl).value = '';
    return false;
  }
}
//discount and paid check
function checknum(){
      var dis=$("#invdcount").val();
      var paid=$("#paidAmount").val();
      if (isNaN(dis))
  {
    alert("<?php echo display('must_input_numbers')?>");
     document.getElementById("invdcount").value = '';
    return false;
  }
  if (isNaN(paid))
  {
    alert("<?php echo display('must_input_numbers')?>");
     document.getElementById("paidAmount").value = '';
    return false;
  }
    }
</script>
<script type="text/javascript">
function customer_due(id){
    $.ajax({
        url: '<?php echo base_url('Cproformainvoice/previous')?>',
        type: 'post',
        data: {customer_id:id}, 
        success: function (msg){
            $("#previous").val(msg);
        },
        error: function (xhr, desc, err){
             alert('failed');
        }
    });        
}

function customer_discount_rate(id){
    $.ajax({
        url: '<?php echo base_url('Cproformainvoice/customer_discount_rate')?>',
        type: 'post',
        dataType: "json",
        data: {customer_id:id}, 
        success: function (msg){
            $('#cust_discout').val(msg['discount']);
            $('.discount-val').val(msg['discount']);
        },
        error: function (xhr, desc, err){
             alert('failed');
        }
    });        
}

function customer_autocomplete(sl) {
    var customer_id = $('#customer_id').val();
    var options = {
        minLength: 0,
        source: function( request, response ) {
            //var customer_name = $('#customer_name').val();
            $.ajax({
                url: "<?php echo base_url('Cproformainvoice/customer_autocomplete')?>",
                method: 'post',
                dataType: "json",
                data: {
                    term: request.term,
                    customer_id:$('#customer_name').val(),
                },
                success: function(data){
                    
                    response( data );
                }
            });
        },
        focus: function( event, ui ) {
           $(this).val(ui.item.label);
           return false;
        },
        select: function( event, ui ) {
            $(this).parent().parent().find("#autocomplete_customer_id").val(ui.item.value); 
            var customer_id          = ui.item.value;
            //customer_due(customer_id);
            customer_discount_rate(customer_id);
            $(this).unbind("change");
            return false;
        }
    }
    //$('body').on('onfocus.autocomplete', '#customer_name', function() {
        $('#customer_name').autocomplete(options);
    //});
}

</script>

<script type="text/javascript">

function invoice_productList(sl) {
    if($('#autocomplete_customer_id').val() == ''){
        $('#customer_name').addClass('border-danger');
        $('.productSelection').val('');
        alert('Please Select Customer before select any medicine!!');
        $('#customer_name').focus();
        return false;    
    } 
    else{
        var priceClass = 'price_item'+sl;
        var unit = 'unit_'+sl;
        var tax = 'total_tax_'+sl;
        var discount_type = 'discount_type_'+sl; 
        var tax_percentage = 'tax_percentage_'+sl; 
        var batch_id = 'batch_id_'+sl;
        // Auto complete
        var options = {
            minLength: 0,
            source: function( request, response ) {
                var product_name = $('#product_name_'+sl).val();
            $.ajax( {
              url: "<?php echo base_url('Cproformainvoice/autocompleteproductsearch')?>",
              method: 'post',
              dataType: "json",
              data: {
                term: request.term,
                product_name:product_name,
                customer_id: $('#autocomplete_customer_id').val()
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
                $(this).parent().parent().find(".autocomplete_hidden_value").val(ui.item.value); 
                $(this).val(ui.item.label);
                //var sl = $(this).parent().parent().find(".sl").val();
                var id=ui.item.value;
                var dataString = 'product_id='+ id;
                var base_url = $('.baseUrl').val();
                $.ajax({
                    type: "POST",
                    url: base_url+"Cproformainvoice/retrieve_product_data_inv",
                    data: dataString,
                    cache: false,
                    success: function(data) {
                        var obj = jQuery.parseJSON(data);
                        for(var i=0; i<(obj.txnmber); i++) {
                            var txam    =   obj.taxdta[i];
                            var txclass =   'total_tax'+i+'_'+sl;
                            $('.'+txclass).val(txam);
                        }
                        $('.'+priceClass).val(obj.price);
                        $('.'+unit).val(obj.unit);
                        $('.'+tax).val(obj.tax);
                        $('#txfieldnum').val(obj.txnmber);
                        $('#'+discount_type).val(obj.discount_type);
                        $('#'+tax_percentage).val(obj.tax0);
                        $('#'+batch_id).html(obj.batch);
                        //This Function Stay on others.js page
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

}

</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#full_paid_tab').keydown(function(event) {
            if(event.keyCode == 13) {
                $('#add_invoice').trigger('click');
            }
        });
    });
</script>

<script type="text/javascript">
    var dataCounter = '<?php echo $dataCounter; ?>';
    if(dataCounter>0){
        for(i=1; i<=dataCounter; i++){
            product_stock(i); 
            //quantity_calculate(i); 
        }   
    }
</script>
