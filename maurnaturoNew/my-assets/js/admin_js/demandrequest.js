function addInputField(t) {
    var row     =   $("#normaldemandrequest tbody tr").length;
    var count   =   row + 1;
    var limits  =   500;
    if(count==limits)   alert("You have reached the limit of adding "+count+" inputs");
    else {
        var a           =   "product_name_"+count;
        var tabindex    =   count * 5;
        var e   =   document.createElement("tr");
        tab1    =   tabindex + 1;
        tab2    =   tabindex + 2;
        tab3    =   tabindex + 3; 

        innerHTMLData  = "<td>";
            innerHTMLData += "<input type='text' name='product_name' onkeyup='invoice_productList("+count+");' onkeypress='invoice_productList("+count+");' class='form-control productSelection' placeholder='Medicine Name' id='"+a+"' required tabindex='"+tab1+"'/>";
            innerHTMLData += "<input type='hidden' class='autocomplete_hidden_value  product_id_"+count+"' name='product_id[]' id='SchoolHiddenId'/>";
        innerHTMLData += "</td>";
        innerHTMLData += "<td>";
            innerHTMLData += "<input type='text' name='product_quantity[]' id='total_qntt_"+count+"' class='total_qntt_"+count+" form-control text-right' placeholder='0.00' min='0' tabindex='"+tab2+"' required/>";
        innerHTMLData += "</td>";
        innerHTMLData += "<td>";
            innerHTMLData += "<a tabindex='"+tab3+"' style='text-align: right;' class='btn btn-danger' value='Delete' onclick='deleteRow(this)'><i class='fa fa-close'></i></a>";
        innerHTMLData += "</td>"; 

        e.innerHTML = innerHTMLData;

        document.getElementById(t).appendChild(e); 
        document.getElementById(a).focus();
        document.getElementById("add_demandrequests_item").setAttribute("tabindex", tab4);
        document.getElementById("add_demandrequests").setAttribute("tabindex", tab5);
        count++;
    }
}
function editInputField(t) {
    var row = $("#normalinvoice tbody tr").length;
    var count = row + 1;
    var limits = 500;
    if (count == limits) alert("You have reached the limit of adding "+count+" inputs");
    else {
        var a = "product_name" + count,
            tabindex = count * 5,
            e = document.createElement("tr");
            tab1 = tabindex + 1;
            tab2 = tabindex + 2;
            tab3 = tabindex + 3;
            tab4 = tabindex + 4;
            tab5 = tabindex + 5;
            tab6 = tabindex + 6;
            tab7 = tabindex + 7;
            tab8 = tabindex + 8;
            tab9 = tabindex + 9;
        e.innerHTML = "<td><input type='text' name='product_name' onkeyup='invoice_productList("+count+");' class='form-control productSelection' placeholder='Product Name' id='" + a + "' required tabindex='"+tab1+"'><input type='hidden' class='autocomplete_hidden_value  product_id_"+count+"' name='product_id[]' id='SchoolHiddenId'/></td><td><select class='form-control' id='batch_id_"+count+"' name='batch_id[]' onchange='product_stock("+count+")'><option></option></select>     <td><input type='text' name='available_quantity[]' id='available_quantity_"+count+"' class='form-control text-right available_quantity_"+count+"' value='0' readonly='readonly' /></td> <td id='expire_date_"+count+"'></td><td><input class='form-control text-right unit_"+count+" valid' value='None' readonly='' aria-invalid='false' type='text'></td><td> <input type='text' name='product_quantity[]' onkeyup='quantity_calculate("+count+"),checkqty("+count+");' onchange='quantity_calculate("+count+");' id='total_qntt_"+count+"' class='total_qntt_"+count+" form-control text-right' placeholder='0.00' min='0' tabindex='"+tab2+"'/></td><td><input type='text' name='product_rate[]' readonly onkeyup='quantity_calculate("+count+"),checkqty("+count+");' onchange='quantity_calculate("+count+");' id='price_item_"+count+"' readonly class='price_item"+count+" form-control text-right' required placeholder='0.00' min='0' tabindex='"+tab3+"'/></td><td><input type='text' name='discount[]' onkeyup='quantity_calculate("+count+"),checkqty("+count+");' onchange='quantity_calculate("+count+");' id='discount_"+count+"' class='form-control text-right' placeholder='0.00' min='0' tabindex='"+tab4+"' /><input type='hidden' value='' name='discount_type' id='discount_type_"+count+"'></td><td class='text-right'><input class='total_price form-control text-right' type='text' name='total_price[]' id='total_price_"+count+"' value='0.00' readonly='readonly'/></td><td><input type='hidden' id='total_tax_"+count+"' class='total_tax_"+count+"' /><input type='hidden' id='all_tax_"+count+"' class=' total_tax' name='tax[]'/><input type='hidden'  id='total_discount_"+count+"' class='total_tax_"+count+"' /><input type='hidden' id='all_discount_"+count+"' class='total_discount'/><button tabindex='"+tab5+"' style='text-align: right;' class='btn btn-danger' type='button' value='Delete' onclick='deleteRow(this)'>Delete</button></td>", 
        document.getElementById(t).appendChild(e), 
        document.getElementById(a).focus(),
        document.getElementById("add_invoice_item").setAttribute("tabindex", tab6);
        document.getElementById("paidAmount").setAttribute("tabindex", tab7);
        document.getElementById("full_paid_tab").setAttribute("tabindex", tab8);
        document.getElementById("add_invoice_item").setAttribute("tabindex", tab9);
        count++
    }
}
function quantity_calculate(item) {
    var quantity    =   $("#total_qntt_" + item).val();
    var price_item  =   $("#price_item_" + item).val();
    var available_quantity = $("#available_quantity_" + item).val();
    
    if(parseInt(quantity) > parseInt(available_quantity)) {
        var message = "You can Sale maximum " + available_quantity + " Items";
        $("#total_qntt_" + item).val('');
        var quantity = 0;
        alert(message);
        $("#total_price_" + item).val(0);
    }
    if(quantity > 0) {
        var n = quantity * price_item;
        $("#total_price_" + item).val(n);
    }
    calculateSum();
}
function calculateSum() {
    var total_price = 0;
    $(".total_price").each(function() {
        isNaN(this.value) || 0 == this.value.length || (total_price += parseFloat(this.value))
    });
    $("#grandTotal").val(total_price.toFixed(2, 2));
}
function stockLimit(t) {
    var a   =   $("#total_qntt_" + t).val();
    var e   =   $(".product_id_" + t).val();
    var o   =   $(".baseUrl").val();
    $.ajax({
        type    :   "POST",
        url     :   o + "Cdemandrequest/product_stock_check",
        data    :   { product_id: e },
        cache   :   !1,
        success :   function(e) {
            if(a>Number(e)){
                var o = "You can purchase maximum "+e+" Items";
                alert(o); 
                $("#qty_item_" + t).val("0");
                $("#total_qntt_" + t).val("0");
                $("#total_price_" + t).val("0");
            }
        }
    });
}
function stockLimitAjax(t) {
    var a = $("#total_qntt_" + t).val(),
        e = $(".product_id_" + t).val(),
        o = $(".baseUrl").val();
    $.ajax({
        type: "POST",
        url: o + "Cdemandrequest/product_stock_check",
        data: {
            product_id: e
        },
        cache: !1,
        success: function(e) {
            if (a > Number(e)) {
                var o = "You can purchase maximum " + e + " Items";
                alert(o), $("#qty_item_" + t).val("0"), $("#total_qntt_" + t).val("0"), $("#total_price_" + t).val("0.00"), calculateSum()
            }
        }
    });
}
function deleteRow(t) {
    var a = $("#normaldemandrequest > tbody > tr").length;
    if (1==a) alert("There only one row you can't delete.");
    else {
        var e = t.parentNode.parentNode;
        e.parentNode.removeChild(e), 
        calculateSum();
    }
}
var count = 2, limits = 500;