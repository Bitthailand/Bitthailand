$('#myModal_del').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')
    var modal = $(this)
    modal.find('#del_id').val(id)
    let Fcus_type_name = $("#Fcus_type_name").val();
    let Fcus_type_id = $("#Fcus_type_id").val();
    let Fcus_id = $("#Fcus_id").val();
    let Fcus_name = $("#Fcus_name").val();
    let Fcus_tel = $("#Fcus_tel").val();
    let Fcus_bill_address = $("#Fcus_bill_address").val();
    let Fcontact_name = $("#Fcontact_name").val();
    let Fvat = $("#Fvat").val();
    let Fcus_back = $("#cus_back").val();
    let Fdelivery_date = $("#delivery_date").val();
    let Fdelivery_Address = $("#delivery_Address").val();
    let Fdate_confirm = $("#date_confirm").val();
    let Ftax = $("#tax").val();
    let Fdiscount = $("#discount").val();
    let Forder_id = $("#order_id").val();
    $("#Dcus_type_name").val(Fcus_type_name);
    $("#Dcus_type_id ").val(Fcus_type_id);
    $("#Dcus_id").val(Fcus_id);
    $("#Dcus_name").val(Fcus_name);
    $("#Dcus_tel").val(Fcus_tel);
    $("#Dcus_bill_address").val(Fcus_bill_address);
    $("#Dcontact_name").val(Fcontact_name);
    $("#Dvat").val(Fvat);
    $("#Ddelivery_date").val(Fdelivery_date);
    $("#Ddelivery_Address").val(Fdelivery_Address);
    $("#Ddate_confirm").val(Fdate_confirm);
    $("#Dtax").val(Ftax);
    $("#Ddiscount").val(Fdiscount);
    $("#Dcus_back").val(Fcus_back);
    $("#Dorder_id").val(Forder_id);
    console.log('Fcus_type_name', Fcus_type_name);
})

function modalLoad() {
    $("#ModalLoadId").modal({
        backdrop: 'static',
        'keyboard': false,
    });
};

function clickNav(page) {
    modalLoad();
    $("#FSPageId").val(page);
    $("#FSButtonID").click();
}

function selection() {
    let cusid = $("input:radio[name=cus_id]:checked").val()
    if (cusid === undefined || cusid === '') {
        alert('xxxx');
    } else {
        console.log('dds', cusid)
        $.get('get_customer.php?cus_id=' + cusid, function(data) {
            var result = JSON.parse(data);
            console.log('cus', result)
            $.each(result, function(index, cus) {
                $("#Fid").val(cus.id);
                $("#Fcus_id").val(cus.customer_id);
                $("#Fcus_name").val(cus.customer_name);
                $("#Fcus_tel").val(cus.tel);
                $("#Fcus_type_id").val(cus.customer_type);
                //    
                $.get('get_customer_type.php?type_id=' + cus.customer_type, function(data) {
                    var result = JSON.parse(data);
                    console.log('cus_type', result)
                    $.each(result, function(index, custype) {
                        $("#Fcus_type_name").val(custype.name);
                    });
                });
                $.get('get_district1.php?subdistrict_id=' + cus.subdistrict, function(data) {
                    var result = JSON.parse(data);
                    console.log('cus_subdistrict', result)
                    $.each(result, function(index, subdistrict) {
                        let bill = cus.bill_address + ' ' + 'ต.' + subdistrict.TUM + ' อ.' + subdistrict.AUM + ' จ.' + subdistrict.PRO;
                        $("#Fcus_bill_address").val(bill);
                    });
                });
                // 
            });
        });
    }
}
$(function() {
    $('#orderModal').modal({
        keyboard: true,
        backdrop: "static",
        show: false,

    }).on('show', function() {
        var getIdFromRow = $(this).data('orderid');
        //make your ajax call populate items or what even you need
        $(this).find('#orderDetails').html($('<b> Order Id selected: ' + getIdFromRow + '</b>'))
    });

    $(".table-striped").find('tr[data-target]').on('click', function() {
        //or do your operations here instead of on show of modal to populate values to modal.
        $('#orderModal').data('orderid', $(this).data('id'));
    });

});
$(document).ready(function() {
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
$('#inputform2').on('keydown', 'input', function(event) {
    if (event.which == 13) {
        event.preventDefault();
        var $this = $(event.target);
        var index = parseFloat($this.attr('data-index'));
        $('[data-index="' + (index + 1).toString() + '"]').focus();
    }
});
/* ===== search start ===== */
function modalLoad() {
    $("#ModalLoadId").modal({
        backdrop: 'static',
        'keyboard': false,
    });
};

function clickNav(page) {
    modalLoad();
    $("#FSPageId").val(page);
    $("#FSButtonID").click();
}
$("#cus_back").on("change", function() {
    // modalLoad();
    let cus_back = $("#cus_back").val();
    console.log('cus', cus_back)
    $("#cusx").val(cus_back);
    if (cus_back == 1) {

        document.getElementById("ifYes").style.display = "none";
        document.getElementById("ifYes1").style.display = "block";
        document.getElementById("ifYes_price").style.display = "block";
        document.getElementById("ifYes_price1").style.display = "none";
        document.getElementById("ifYes_price2").style.display = "block";
        document.getElementById("ifYes_price3").style.display = "block";
        document.getElementById("ifYes_qty").style.display = "block";
        document.getElementById("ifYes_qty2").style.display = "none";
        document.getElementById("cus_back_show").style.display = "none";
        document.getElementById("cus_back_show1").style.display = "none";
        document.getElementById("cus_back_show2").style.display = "none";
        document.getElementById("ifYes_dis").style.display = "block";
        document.getElementById("ifYes_qty_face2").style.display = "block";
        document.getElementById("btu").disabled = true;

    }
    if (cus_back == 2) {
        document.getElementById("ifYes").style.display = "none";
        document.getElementById("ifYes1").style.display = "block";
        document.getElementById("ifYes_price").style.display = "block";
        document.getElementById("ifYes_price1").style.display = "none";
        document.getElementById("ifYes_price2").style.display = "block";
        document.getElementById("ifYes_price3").style.display = "block";
        document.getElementById("ifYes_qty").style.display = "block";
        document.getElementById("ifYes_qty2").style.display = "none";
        document.getElementById("cus_back_show").style.display = "block";
        document.getElementById("cus_back_show1").style.display = "block";
        document.getElementById("cus_back_show2").style.display = "block";
        document.getElementById("ifYes_qty_face2").style.display = "block";
        document.getElementById("ifYes_dis").style.display = "block";
        document.getElementById("ifYes_qty_face2").style.display = "none";
        document.getElementById("btu").disabled = false;
    }
    if (cus_back == 3) {
        document.getElementById("ifYes").style.display = "none";
        document.getElementById("ifYes1").style.display = "block";
        document.getElementById("ifYes_price").style.display = "block";
        document.getElementById("ifYes_price1").style.display = "none";
        document.getElementById("ifYes_price2").style.display = "block";
        document.getElementById("ifYes_price3").style.display = "block";
        document.getElementById("ifYes_qty").style.display = "block";
        document.getElementById("ifYes_qty2").style.display = "none";
        document.getElementById("cus_back_show").style.display = "block";
        document.getElementById("cus_back_show1").style.display = "block";
        document.getElementById("cus_back_show2").style.display = "block";
        document.getElementById("ifYes_qty_face2").style.display = "block";
        document.getElementById("ifYes_dis").style.display = "block";
        document.getElementById("ifYes_qty_face2").style.display = "none";
        document.getElementById("btu").disabled = false;

    }
    let Fcus_type_name = $("#Fcus_type_name").val();
    let Fcus_type_id = $("#Fcus_type_id").val();
    let Fcus_id = $("#Fcus_id").val();
    let Fcus_name = $("#Fcus_name").val();
    let Fcus_tel = $("#Fcus_tel").val();
    let Fcus_bill_address = $("#Fcus_bill_address").val();
    let Fcontact_name = $("#Fcontact_name").val();
    let Fvat = $("#vat").val();
    let Fcus_back = $("#cus_back").val();
    let Fdelivery_date = $("#delivery_date").val();
    let Fdelivery_Address = $("#delivery_Address").val();
    let Fdate_confirm = $("#date_confirm").val();
    let Ftax = $("#tax").val();
    let Fdiscount = $("#discount").val();
    let Forder_id = $("#order_id").val();
    $("#PPcus_type_name").val(Fcus_type_name);
    $("#PPcus_type_id ").val(Fcus_type_id);
    $("#PPcus_id").val(Fcus_id);
    $("#PPcus_name").val(Fcus_name);
    $("#PPcus_tel").val(Fcus_tel);
    $("#PPcus_bill_address").val(Fcus_bill_address);
    $("#PPcontact_name").val(Fcontact_name);
    $("#PPvat").val(Fvat);
    $("#PPdelivery_date").val(Fdelivery_date);
    $("#PPdelivery_Address").val(Fdelivery_Address);
    $("#PPdate_confirm").val(Fdate_confirm);
    $("#PPtax").val(Ftax);
    $("#PPdiscount").val(Fdiscount);
    $("#PPcus_back").val(Fcus_back);
    $("#PPPorder_id").val(Forder_id);
    $("#PPButtonID").click();

});

function calculate() {
    let qty = $("#qty").val();
    let qty2 = $("#qty2").val();
    let stock1S = $("#stock1").val();
    let stock2S = $("#stock2").val();
    let s_cus_back = $("#cus_back").val();
    let sum_stock1x = 0;
    console.log('stock1S', stock1S)
    console.log('stock2S', stock2S)
    console.log('qty2', qty2)
    stock1SS = Number(stock1S)
    stock2SS = Number(stock2S)
    sum_stock1x = Number(stock1S) + Number(stock2S);
    sum_qtySS = Number(qty) + Number(qty2);
    sum_stock1xx = Number(sum_stock1x);
    console.log('stock1SS', stock1SS, qty)
    console.log('stock2SS', stock2SS, qty2)
    if (s_cus_back == 1) {

        if (stock1SS < qty) {
            document.getElementById("btu").disabled = true;
            alert('ลูกค้ารับกลับเองเช็คสต็อกโรงงาน1 จำนวนที่กรอก มากกว่าจำนวนสต็อกที่มี');
            var dff = 0;
            $("#qty").val(dff);
            $chk1 = '1'
        }
        if (stock1SS > qty) {
            // alert('xx1');
            document.getElementById("btu").disabled = false;
        }


        if (stock2SS < qty2) {
            // document.getElementById("btu").disabled = true;
            alert('ลูกค้ารับกลับเองเช็คสต็อกโรงงาน2 จำนวนที่กรอก มากกว่าจำนวนสต็อกที่มี');
            var dff = 0;
            $("#qty2").val(dff);
            $chk2 = '1'
        }
        if (stock2SS > qty2) {
            document.getElementById("btu").disabled = false;
            // alert('xx2');
        }
        if (sum_stock1xx == 0) {
            document.getElementById("btu").disabled = true;
        } else {
            document.getElementById("btu").disabled = false;
        }
        if (sum_qtySS == 0) {
            document.getElementById("btu").disabled = true;
        } else {
            document.getElementById("btu").disabled = false;
        }
        // if ($chk1 == 1 && $chk2 == 1) {
        //     document.getElementById("btu").disabled = true;
        // } else {
        //     document.getElementById("btu").disabled = false;
        // }

    } else {
        document.getElementById("btu").disabled = false;
    }

    console.log('qty', qty);

};

function calculate1() {
    let send_qty = $("#send_qty").val();
    let send_price = $("#send_price").val();
    console.log('send_qty ', send_qty);
    console.log('send_price', send_price);

    if (send_qty == 0 || send_qty == undefined || send_qty == '') {
        document.getElementById("btu").disabled = true;

    } else {
        document.getElementById("btu").disabled = false;
    }

};
$("#btu").click("change", function() {
    modalLoad();

    let Fqty = $("#qty").val();
    let Fqty2 = $("#qty2").val();
    let Fproductx = $("#productx").val();
    let Fproduct_type = $("#product_type").val();
    let Funit_price = $("#unit_price").val();
    console.log('Fproduct_type', Fproduct_type)
        // ==================
    let Fcus_type_name = $("#Fcus_type_name").val();
    let Fcus_type_id = $("#Fcus_type_id").val();
    let Fcus_id = $("#Fcus_id").val();
    let Fcus_name = $("#Fcus_name").val();
    let Fcus_tel = $("#Fcus_tel").val();
    let Fcus_bill_address = $("#Fcus_bill_address").val();
    let Fcontact_name = $("#Fcontact_name").val();
    let Fvat = $("#vat").val();
    let Fcus_back = $("#cus_back").val();
    let Fdelivery_date = $("#delivery_date").val();
    let Fdelivery_Address = $("#delivery_Address").val();
    let Fdate_confirm = $("#date_confirm").val();
    let Ftax = $("#tax").val();
    let Fdiscount = $("#discount").val();
    let Forder_id = $("#order_id").val();
    let Fdisunit = $("#disunit").val();

    // ==============สถานที่จัดส่ง
    let send_to = $("#send_to").val();
    let send_price = $("#send_price").val();
    let send_qty = $("#send_qty").val();
    let TF = $("#TF").val();
    console.log('send_to', send_to)
    console.log('send_price', send_price)
    console.log('send_qty', send_qty)
    $("#FFsend_to").val(send_to);
    $("#FFsend_price").val(send_price);
    $("#FFsend_qty").val(send_qty);
    $("#FFTF").val(TF);
    // =============
    $("#FFqty").val(Fqty);
    $("#FFqty2").val(Fqty2);
    $("#FFproductx").val(Fproductx);
    $("#FFproduct_type").val(Fproduct_type);
    $("#FFunit_price").val(Funit_price);
    // =================================
    $("#FFcus_type_name").val(Fcus_type_name);
    $("#FFcus_type_id ").val(Fcus_type_id);
    $("#FFcus_id").val(Fcus_id);
    $("#FFcus_name").val(Fcus_name);
    $("#FFcus_tel").val(Fcus_tel);
    $("#FFcus_bill_address").val(Fcus_bill_address);
    $("#FFcontact_name").val(Fcontact_name);
    $("#FFvat").val(Fvat);
    $("#FFdelivery_date").val(Fdelivery_date);
    $("#FFdelivery_Address").val(Fdelivery_Address);
    $("#FFdate_confirm").val(Fdate_confirm);
    $("#FFtax").val(Ftax);
    $("#FFdiscount").val(Fdiscount);
    $("#FFcus_back").val(Fcus_back);
    $("#FForder_id").val(Forder_id);
    $("#FFdisunit").val(Fdisunit);
    $("#FSButtonID").click();
});
/* ===== search end ===== */

//click next link
$(".linkLoadModalNext").on('click', function() {
    $("#ModalLoadId").modal({
        backdrop: 'static',
        'keyboard': false,
    });
});
$(document).ready(function() {
    $(document).on('click', '#edit_po', function(e) {
        e.preventDefault();
        var uid = $(this).data('id'); // get id of clicked row
        $('#dynamic-content').html(''); // leave this div blank
        $('#modal-loader').show(); // load ajax loader on button click
        $.ajax({
                url: 'addorder_edit.php',
                type: 'POST',
                data: 'id=' + uid,
                dataType: 'html'
            })
            .done(function(data) {
                console.log('data', data);
                $('#dynamic-content').html(''); // blank before load.
                $('#dynamic-content').html(data); // load here
                $('#modal-loader').hide(); // hide loader  
            })
            .fail(function() {
                $('#dynamic-content').html(
                    '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                );
                $('#modal-loader').hide();
            });
    });
});




// 

$(document).ready(function() {
    $(document).on('click', '#edit_main', function(e) {
        e.preventDefault();
        var uid = $(this).data('id'); // get id of clicked row
        let Fcus_type_name = $("#Fcus_type_name").val();
        let Fcus_type_id = $("#Fcus_type_id").val();
        let Fcus_id = $("#Fcus_id").val();
        let Fcus_name = $("#Fcus_name").val();
        let Fcus_tel = $("#Fcus_tel").val();
        let Fcus_bill_address = $("#Fcus_bill_address").val();
        let Fcontact_name = $("#Fcontact_name").val();
        let Fvat = $("#vat").val();
        let Fcus_back = $("#cus_back").val();
        let Fdelivery_date = $("#delivery_date").val();
        let Fdelivery_Address = $("#delivery_Address").val();
        let Fdate_confirm = $("#date_confirm").val();
        let Ftax = $("#tax").val();
        let Fdiscount = $("#discount").val();
        let Forder_id = $("#order_id").val();
        $("#Ecus_type_name").val(Fcus_type_name);
        $("#Ecus_type_id ").val(Fcus_type_id);
        $("#Ecus_id").val(Fcus_id);
        $("#Ecus_name").val(Fcus_name);
        $("#Ecus_tel").val(Fcus_tel);
        $("#Ecus_bill_address").val(Fcus_bill_address);
        $("#Edelivery_date").val(Fdelivery_date);
        $("#Edelivery_Address").val(Fdelivery_Address);
        $("#Edate_confirm").val(Fdate_confirm);
        $("#Etax").val(Ftax);
        $("#Ediscount").val(Fdiscount);
        $("#Ecus_back").val(Fcus_back);
        $("#Evat").val(Fvat);
        $("#Eorder_id").val(Forder_id);
        console.log('Fdelivery_Address', Fdelivery_Address)
        $('#dynamic-content4').html(''); // leave this div blank
        $('#modal-loader').show(); // load ajax loader on button click
        $.ajax({
                url: 'addorder_editmian.php',
                type: 'POST',
                data: 'id=' + uid,
                dataType: 'html'
            })
            .done(function(data) {
                console.log('data', data);
                $('#dynamic-content4').html(''); // blank before load.
                $('#dynamic-content4').html(data); // load here
                $('#modal-loader').hide(); // hide loader  
            })
            .fail(function() {
                $('#dynamic-content4').html(
                    '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                );
                $('#modal-loader').hide();
            });
    });
});
let cus_back = $("#cus_back").val();
console.log('cus', cus_back)
if (cus_back == 1) {

    document.getElementById("ifYes").style.display = "none";
    document.getElementById("ifYes1").style.display = "block";
    document.getElementById("ifYes_price").style.display = "block";
    document.getElementById("ifYes_price1").style.display = "none";
    document.getElementById("ifYes_price2").style.display = "block";
    document.getElementById("ifYes_price3").style.display = "block";
    document.getElementById("ifYes_qty").style.display = "block";
    document.getElementById("ifYes_qty2").style.display = "none";
    document.getElementById("cus_back_show").style.display = "none";
    document.getElementById("cus_back_show1").style.display = "none";
    document.getElementById("cus_back_show2").style.display = "none";
    document.getElementById("ifYes_dis").style.display = "block";
    document.getElementById("ifYes_qty_face2").style.display = "block";
    document.getElementById("btu").disabled = true;
    let Aproduct_type = $("#product_type").val();
    console.log('Aproduct_type', Aproduct_type)


}
if (cus_back == 2) {
    document.getElementById("ifYes").style.display = "none";
    document.getElementById("ifYes1").style.display = "block";
    document.getElementById("ifYes_price").style.display = "block";
    document.getElementById("ifYes_price1").style.display = "none";
    document.getElementById("ifYes_price2").style.display = "block";
    document.getElementById("ifYes_price3").style.display = "block";
    document.getElementById("ifYes_qty").style.display = "block";
    document.getElementById("ifYes_qty2").style.display = "none";
    document.getElementById("cus_back_show").style.display = "block";
    document.getElementById("cus_back_show1").style.display = "block";
    document.getElementById("cus_back_show2").style.display = "block";

    document.getElementById("ifYes_dis").style.display = "block";
    document.getElementById("ifYes_qty_face2").style.display = "none";
    document.getElementById("btu").disabled = false;

}
if (cus_back == 3) {
    document.getElementById("ifYes").style.display = "none";
    document.getElementById("ifYes1").style.display = "block";
    document.getElementById("ifYes_price").style.display = "block";
    document.getElementById("ifYes_price1").style.display = "none";
    document.getElementById("ifYes_price2").style.display = "block";
    document.getElementById("ifYes_price3").style.display = "block";
    document.getElementById("ifYes_qty").style.display = "block";
    document.getElementById("ifYes_qty2").style.display = "none";
    document.getElementById("cus_back_show").style.display = "block";
    document.getElementById("cus_back_show1").style.display = "block";
    document.getElementById("cus_back_show2").style.display = "block";

    document.getElementById("ifYes_dis").style.display = "block";
    document.getElementById("ifYes_qty_face2").style.display = "none";
    document.getElementById("btu").disabled = false;

}

$("#order_id").on("change", function() {
    // modalLoad();
    let order_id = $("#order_id").val();
    $("#FMorder_id").val(order_id);
    console.log('order_id', order_id)
    $("#MButtonID").click();
});
let Morid = $("#order_id").val();
if (Morid == '') {
    document.getElementById("btu").disabled = true;
    // document.getElementById("btu1").disabled = true;
} else {
    document.getElementById("btu").disabled = false;
    // document.getElementById("btu1").disabled = false;
}