<!-- Product Purchase js -->
<script src="<?php echo base_url()?>my-assets/js/admin_js/json/product_purchase.js.php" ></script>
<!-- manufacturer Js -->
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/manufacturer.js.php" ></script>

<script src="<?php echo base_url()?>my-assets/js/admin_js/purchase.js" type="text/javascript"></script>
<style type="text/css">
    .close{color:white;}
    .hiddenRow {display: none;}
</style>

<!-- Add New Purchase Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_purchase') ?></h1>
            <small><?php echo display('add_new_purchase') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('purchase') ?></a></li>
                <li class="active"><?php echo display('add_purchase') ?></li>
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
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
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

        <?php
        if($this->permission1->method('manage_purchase','update')->access()){ ?>
        <!-- Purchase report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_purchase') ?></h4>
                        </div>
                    </div>

                    <div class="panel-body">
                      <?php echo form_open_multipart('Cpurchase/purchase_update',array('class' => 'form-vertical', 'id' => 'purchase_update'))?>
                        <div class="row">
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="manufacturer_sss" class="col-sm-4 col-form-label"><?php echo display('manufacturer') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                   <div class="col-sm-8">
                                        <select name="manufacturer_id" id="manufacturer_id" class="form-control " required="">

                                            {manufacturer_list}
                                            <option value="{manufacturer_id}">{manufacturer_name}</option>
                                            {/manufacturer_list}
                                            {manufacturer_selected}
                                            <option value="{manufacturer_id}" selected="">{manufacturer_name}</option>
                                            {/manufacturer_selected}
                                        </select>
                                    </div>


                                </div>
                            </div>

                             <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('purchase_date') ?><i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input type="text" tabindex="2" class="form-control datepicker" name="purchase_date" value="{purchase_date}" id="date" required />
                                          <input type="hidden" name="purchase_id" value="{purchase_id}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label"><?php echo display('invoice_no') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" tabindex="3" class="form-control" name="chalan_no" placeholder="<?php echo display('invoice_no') ?>" id="invoice_no" required  value="{chalan_no}" readonly/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label"><?php echo display('details') ?></label>
                                    <div class="col-sm-8">
                                         <textarea class="form-control" tabindex="4" id="adress" name="purchase_details" placeholder=" <?php echo display('details') ?>" rows="1">{purchase_details}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                           <div class="row">
                              <div class="col-sm-6" id="payment_from_1">
                                <div class="form-group row">
                                    <label for="payment_type" class="col-sm-4 col-form-label"><?php
                                        echo display('payment_type');
                                        ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <select name="paytype" class="form-control" required="" onchange="bank_paymet(this.value)">
                                            <option value="">Select Payment Option</option>
                                            <option value="1" <?php if($paytype ==1){echo 'selected';}?>>Cash Payment</option>
                                            <option value="2" <?php if($paytype ==2){echo 'selected';}?>>Bank Payment</option>
                                            <option value="3" <?php if($paytype ==3){echo 'selected';}?>>Due Payment</option> 
                                        </select>
                                      

                                     
                                    </div>
                                 
                                </div>
                            </div>
                             <div class="col-sm-6" id="bank_div" style="display: <?php if($paytype == 2){echo 'block';}else{echo 'none';}?>;">
                            <div class="form-group row">
                                <label for="bank" class="col-sm-4 col-form-label"><?php echo display('bank'); ?> <i class="text-danger">*</i></label>
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
                            <table class="table table-bordered table-hover" id="purchaseTable">
                                <thead>
                                    <tr>
                                            <th class="text-center" width="20%"><?php echo display('item_information') ?><i class="text-danger">*</i></th>
                                            <th class="text-center"><?php echo display('batch_id') ?> <i class="text-danger">*</i></th>
                                             <th class="text-center"><?php echo display('expeire_date') ?> <i class="text-danger">*</i></th>
                                            <th class="text-center"><?php echo display('stock_ctn') ?></th>
                                            <th class="text-center"><?php echo display('quantity') ?> <i class="text-danger">*</i></th>
                                            <th class="text-center"><?php echo display('manufacturer_rate') ?><i class="text-danger">*</i></th>
                                            <th class="text-center"><?php echo display('discount_percentage') ?> %</th>
                                            <th class="text-center"><?php echo display('total') ?></th>
                                            <th class="text-center"><?php echo display('action') ?></th>
                                        </tr>
                                </thead>
                                <tbody id="addPurchaseItem">
                                    <?php 
                                        $total_discount = $purchase_info[0]['total_discount']; 
                                        $grand_total_amount = $purchase_info[0]['grand_total_amount'];
                                        $total_s = $total_discount + $grand_total_amount;
                                    ?>
                                    {purchase_info}
                                    <tr>
                                        <td class="span3 manufacturer">
                                           <input type="text" name="product_name" required class="form-control product_name productSelection" onkeypress="product_pur_or_list({sl});" placeholder="<?php echo display('product_name') ?>" id="product_name_{sl}" tabindex="5" value="{product_name}"  >

                                            <input type="hidden" class="autocomplete_hidden_value product_id_{sl}" name="product_id[]" id="SchoolHiddenId" value="{product_id}"/>

                                            <input type="hidden" class="sl" value="{sl}">
                                        </td>
                                         <td>
                                                <input type="text" name="batch_id[]" id="batch_id_{sl}" class="form-control text-right"  tabindex="11" placeholder="<?php echo display('batch_id') ?>" required="required" value="{batch_id}"/>
                                            </td>
                                            <td>
                                                <input type="text" name="expeire_date[]" id="expeire_date_{sl}" class="form-control datepicker"   tabindex="12" placeholder="<?php echo display('expeire_date') ?>" value="{expeire_date}" required="required" onchange="checkExpiredate({sl})"/>
                                            </td>

                                       <td class="wt">
                                                <input type="text" id="available_quantity_{sl}" class="form-control text-right stock_ctn_{sl}" placeholder="0.00" readonly/>
                                            </td>

                                            <td class="text-right">

                                                <input type="text" name="product_quantity[]" id="quantity_{sl}" required="required" class="form-control text-right store_cal_{sl}" onkeyup="calculate_store({sl}),checkqty({sl});" onchange="calculate_store({sl});" placeholder="0.00" value="{quantity}" min="0" tabindex="6"/>
                                            </td>
                                            <td class="test">
                                                <input type="text" name="product_rate[]" onkeyup="calculate_store({sl}),checkqty({sl});" onchange="calculate_store({sl});" id="product_rate_{sl}" class="form-control product_rate_{sl} text-right" placeholder="0.00" value="{rate}" required="required" min="0" tabindex="7" readonly/>
                                            </td>
                                            
                                            <td>
                                                <input type="text" name="discount[]" onkeyup="calculate_store({sl}), checkqty({sl});"  onchange="calculate_store({sl}), checkqty({sl});" id="discount_{sl}" class="form-control text-right discount-val"  value="{discount}" min="0" tabindex="11" placeholder="0.00"/>
                                            </td>


                                            <td class="text-right">
                                                <input class="form-control total_price text-right" type="text" name="total_price[]" id="total_price_{sl}" value="{total_amount}" readonly="readonly" />
                                            </td>
                                            <td>



                                                <button style="text-align: right;" class="btn btn-danger red" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)" tabindex="8"><?php echo display('delete')?></button>
                                            </td>
                                    </tr>
                                    {/purchase_info}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7"  style="text-align:right;"><b><?php echo display('total') ?>:</b></td>
                                        <td class="text-right">
                                           <input type="text" id="total_s" class="form-control text-right" name="total_s" value="<?php echo $total_s; ?>" readonly="readonly" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right;" colspan="7"><b><?php echo '% '.display('discount_percentage') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="invdcount" class="form-control text-right" name="invdcount" onkeyup="checknum(); discount_percentage();" value="<?php echo $purchase_info[0]['invdcount']; ?>" placeholder="0.00" />
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td colspan="7"  style="text-align:right;"><b><?php echo display('total_discount') ?>:</b></td>
                                        <td class="text-right">
                                           <input type="text" id="total_discount_ammount" class="form-control text-right" name="total_discount" value="{total_discount}" readonly="readonly" />
                                        </td>
                                    </tr><?php 
                                    $i=0;
                                    foreach($taxes as $taxfldt){
                                        ?><tr class="hideableRow hiddenRow">
                                            <td style="text-align:right;" colspan="7"><b><?php echo $taxfldt['tax_name'] ?></b></td>
                                            <td class="text-right">
                                                <input id="total_tax_amount<?php echo $i;?>" tabindex="-1" class="form-control text-right valid totalTax taxesData" name="total_tax<?php echo $i;?>" value="<?php echo $taxfldt['default_value']; ?>" readonly="readonly" aria-invalid="false" type="text">
                                            </td>
                                        </tr><?php 
                                        $i++;
                                    }
                                    ?><tr>
                                        <td style="text-align:right;" colspan="7"><b><?php echo display('total_tax') ?>:</b></td>
                                        <td class="text-right">
                                            <input id="total_tax_amount" tabindex="-1" class="form-control text-right valid" name="total_tax" value="{total_tax}" readonly="readonly" aria-invalid="false" type="text">
                                        </td>
                                        <td><button type="button" class="toggle btn-warning">
                                            <i class="fa fa-angle-double-down"></i>
                                        </button></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                           <input type="button" id="add_invoice_item" class="btn btn-info" name="add-invoice-item"  onClick="addPurchaseOrderField1('addPurchaseItem');" value="<?php echo display('add_new_item') ?>"  tabindex="9"/>

                                            <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>
                                        </td>
                                        <td style="text-align:right;" colspan="5"><b><?php echo display('grand_total') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="grandTotal" class="text-right form-control" name="grand_total_price" value="{grand_total}" readonly="readonly" />
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="submit" id="add_purchase" class="btn btn-primary btn-large" name="add-purchase" value="<?php echo display('save_changes') ?>" />

                            </div>
                        </div>
                    <?php echo form_close()?>
                    </div>
                </div>
            </div>
        </div>
         <?php
        }
        else{
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('You do not have permission to access. Please contact with administrator.');?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </section>
</div>
<!-- Purchase Report End -->

<style type="text/css">
    .btn:focus {
      background-color: #6A5ACD;
    }
</style>
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

$(document ).ready(function() {
    $('#purchaseTable .toggle').on('click', function() {
    $('#purchaseTable .hideableRow').toggleClass('hiddenRow');
  })
});
function product_pur_or_list(sl) {

    var manufacturer_id = $('#manufacturer_id').val();


    if ( manufacturer_id == 0) {
        alert('Please select manufacturer !');
        return false;
    }

    // Auto complete
    var options = {
        minLength: 0,
        source: function( request, response ) {
            var product_name = $('#product_name_'+sl).val();
        $.ajax( {
          url: "<?php echo base_url('Cpurchase/product_search_by_manufacturer')?>",
          method: 'post',
          dataType: "json",
          data: {
            term: request.term,
            manufacturer_id:$('#manufacturer_id').val(),
            product_name:product_name,
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
            var sl = $(this).parent().parent().find(".sl").val();

            var product_id          = ui.item.value;

          var  manufacturer_id=$('#manufacturer_id').val();


            var base_url    = $('.baseUrl').val();


            var available_quantity    = 'available_quantity_'+sl;
            var product_rate    = 'product_rate_'+sl;




            $.ajax({
                type: "POST",
                url: base_url+"Cinvoice/retrieve_product_data",
                 data: {product_id:product_id,manufacturer_id:manufacturer_id},
                cache: false,
                success: function(data)
                {
                    console.log(data);
                    obj = JSON.parse(data);
                   $('#'+available_quantity).val(obj.total_product);
                    $('#'+product_rate).val(obj.manufacturer_price);

                }
            });

            $(this).unbind("change");
            return false;
       }
   }

   //$('body').on('keypress.autocomplete', '.product_name', function() {
       $('.product_name').autocomplete(options);
   //});

}

</script>


<script type="text/javascript">

  // Counts and limit for purchase order
    var count = (document.getElementById('purchaseTable').getElementsByTagName("tbody")[0].getElementsByTagName("tr").length)+1;
    var limits = 500;

    function addPurchaseOrderField1(divName){
        if (count == limits)  {
            alert("<?php echo display('you_have_reached_the_limit_of_adding')?>" + count + "<?php echo display('inputs')?>");
        }
        else{
            var newdiv = document.createElement('tr');
            var tabin="product_name_"+count;
             tabindex = count * 4 ,
           newdiv = document.createElement("tr");
            tab1 = tabindex + 1;

            tab2 = tabindex + 2;
            tab3 = tabindex + 3;
            tab4 = tabindex + 4;
            tab5 = tabindex + 5;
            tab6 = tab5 + 1;
            tab7 = tab6 +1;



            newdiv.innerHTML ='<td class="span3 manufacturer"><input type="text" name="product_name" required class="form-control product_name productSelection" onkeypress="product_pur_or_list('+ count +');" placeholder="<?php echo display("product_name") ?>" id="product_name_'+ count +'" tabindex="'+tab1+'" > <input type="hidden" class="autocomplete_hidden_value product_id_'+ count +'" name="product_id[]" id="SchoolHiddenId"/>  <input type="hidden" class="sl" value="'+ count +'">  </td> <td> <input type="text" name="batch_id[]" id="batch_id_'+ count +'" class="form-control text-right" required  tabindex="11" placeholder="<?php echo display('batch_id') ?>"/></td><td><input type="text" name="expeire_date[]" onchange="checkExpiredate('+ count +')" id="expeire_date_'+ count +'" required class="form-control datepicker"  placeholder="<?php echo display('expeire_date') ?>"/> </td>  <td class="wt"> <input type="text" id="available_quantity_'+ count +'" class="form-control text-right stock_ctn_'+ count +'" placeholder="0.00" readonly/> </td><td class="text-right"><input type="text" name="product_quantity[]" tabindex="'+tab2+'" required  id="quantity_'+ count +'" class="form-control text-right store_cal_' + count + '" onkeyup="calculate_store(' + count + '),checkqty(' + count + ');" onchange="calculate_store(' + count + ');" placeholder="0.00" value="" min="0"/>  </td><td class="test"><input type="text" name="product_rate[]" required onkeyup="calculate_store('+ count +'),checkqty('+ count +');" onchange="calculate_store('+ count +');" id="product_rate_'+ count +'" class="form-control product_rate_'+ count +' text-right" readonly placeholder="0.00" value="" min="0" tabindex="'+tab3+'"/></td><td class="text-right"><input type="text" name="discount[]" onkeyup="calculate_store('+ count +'), checkqty('+ count +');"  onchange="calculate_store('+ count +'1), checkqty('+ count +');" id="discount_'+ count +'" class="form-control text-right discount-val" min="0" tabindex="11" placeholder="0.00"/></td><td class="text-right"><input class="form-control total_price text-right total_price_'+ count +'" type="text" name="total_price[]" id="total_price_'+ count +'" value="0.00" readonly="readonly" /> </td><td> <input type="hidden" id="total_discount_1" class="" /><input type="hidden" id="all_discount_1" class="total_discount" /><button style="text-align: right;" class="btn btn-danger red" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)" tabindex="8"><?php echo display('delete')?></button></td>';
            document.getElementById(divName).appendChild(newdiv);
            document.getElementById(tabin).focus();
            document.getElementById("add_invoice_item").setAttribute("tabindex", tab5);
            document.getElementById("add_purchase").setAttribute("tabindex", tab6);


            count++;
$(".datepicker").datepicker({ dateFormat:'yy-mm-dd' });
            $("select.form-control:not(.dont-select-me)").select2({
                placeholder: "Select option",
                allowClear: true
            });
        }
    }

    //Calculate store product
    function calculate_store(sl) {
       
        var gr_tot = 0;
        var item_ctn_qty    = $("#quantity_"+sl).val();
        var vendor_rate = $("#product_rate_"+sl).val();
        var discount    = $("#discount_" + sl).val();

        var total_price     = item_ctn_qty * vendor_rate;
        total_price = total_price - (total_price * discount / 100);

        $("#total_price_"+sl).val(total_price.toFixed(2));
        

       
        //Total Price
        $(".total_price").each(function() {
            isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
        });
        
        $("#total_s").val(gr_tot.toFixed(2,2));
        
        var invdcount = $("#invdcount").val();
        if(!isNaN(invdcount)){
            var total_discount_ammount = (gr_tot * invdcount / 100);
            $("#total_discount_ammount").val(total_discount_ammount.toFixed(2));
            if(!isNaN(total_discount_ammount)){
                gr_tot = gr_tot -  total_discount_ammount;   
            }
        }
        
        var totalTaxAmount  = 0;
        $(".taxesData").each(function() {
            if(!isNaN(this.value)){
                var taxAmount = (gr_tot * this.value / 100);  
                totalTaxAmount = totalTaxAmount + taxAmount;
            }
        });
        
        $("#total_tax_amount").val(totalTaxAmount.toFixed(2,2));
        gr_tot = gr_tot +  totalTaxAmount;
        
        $("#grandTotal").val(gr_tot.toFixed(2,2));
    }
</script>

<script type="text/javascript">
    function checkExpiredate(sl) {
        var purdates =  $("#purdate").val();
        var expiredate = $("#expeire_date_"+sl).val();
        var purchasedate = new Date(purdates);
        var expirydate = new Date(expiredate);
        if (expirydate <= purchasedate ) {
            alert('<?php echo display('expiry_date_should_be_greater_than_puchase_date')?>');
          document.getElementById("expeire_date_"+sl).value = '';
            return false;
        }
        return true;
    }


     function checkqty(sl)
{

  var y=$("#quantity_"+sl).val();
  var x=$("#product_rate_"+sl).val();
  if (isNaN(y))
  {
    alert("<?php echo display('must_input_numbers')?>");
    document.getElementById("quantity_"+sl).value = '';
     //$("#quantity_"+sl).val() = '';
    return false;
  }
  if (isNaN(x))
  {
     alert("<?php echo display('must_input_numbers')?>");
     document.getElementById("product_rate_"+sl).value = '';
    return false;
  }
}


function checknum(){
    var dis=$("#invdcount").val();
    if(isNaN(dis)) {
        alert("<?php echo display('must_input_numbers')?>");
        document.getElementById("invdcount").value = '';
        return false;
    }
}

function discount_percentage(){
    var gr_tot = $("#total_s").val();
    var invdcount = $("#invdcount").val();
    if(!isNaN(invdcount)){
        var total_discount_ammount = (gr_tot * invdcount / 100);
        $("#total_discount_ammount").val(total_discount_ammount.toFixed(2));
        if(!isNaN(total_discount_ammount)){
            gr_tot = gr_tot -  total_discount_ammount;   
        }
    }
    
    var totalTaxAmount  = 0;
    $(".taxesData").each(function() {
        if(!isNaN(this.value)){
            var taxAmount = (gr_tot * this.value / 100);  
            totalTaxAmount = totalTaxAmount + taxAmount;
        }
    });
    
    $("#total_tax_amount").val(totalTaxAmount.toFixed(2,2));
    gr_tot = gr_tot +  totalTaxAmount;
    
    $("#grandTotal").val(gr_tot.toFixed(2,2));    
}

</script>

<!-- JS -->



