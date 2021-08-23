$(function() {
    var product_typeObject = $('#product_type');
    var productxObject = $('#productx');
    var ProIdObject = $('#ProId');
    // on change province
    product_typeObject.on('change', function() {
        var product_typeId = $(this).val();

        // var t = plantId.split("|"); //ถ้าเจอวรรคแตกเก็บลง array t
        // for (var i = 0; i < t.length; i++) {
        //     // document.write(t[i] + "<br/>");
        // }
        console.log("product_typeId", product_typeId)
            // console.log("yy", t[1])
        if (product_typeId == 'TF') {
            document.getElementById("ifYes").style.display = "block";
            document.getElementById("ifYes1").style.display = "none";
            document.getElementById("ifYes_price").style.display = "none";
            document.getElementById("ifYes_price1").style.display = "block";
            document.getElementById("ifYes_price2").style.display = "none";
            document.getElementById("ifYes_price3").style.display = "none";
            document.getElementById("ifYes_qty").style.display = "none";
            document.getElementById("ifYes_qty2").style.display = "block";
            document.getElementById("ifYes_dis").style.display = "none";
            document.getElementById("btu").disabled = false;
            var df = 1;
            var TF = 1;
            // $('#qty').val(df);
            $('#send_qty').val(df);
            $('#TF').val(TF);

        } else {
            document.getElementById("ifYes").style.display = "none";
            document.getElementById("ifYes1").style.display = "block";
            document.getElementById("ifYes_price").style.display = "block";
            document.getElementById("ifYes_price1").style.display = "none";
            document.getElementById("ifYes_price2").style.display = "block";
            document.getElementById("ifYes_price3").style.display = "block";
            document.getElementById("ifYes_qty").style.display = "block";
            document.getElementById("ifYes_qty2").style.display = "none";
            document.getElementById("ifYes_dis").style.display = "block";
            productxObject.html('<option value="">เลือกสินค้าสั่งขื้อ</option>');
            ProIdObject.html('<option value="">เลือก</option>');
            $("input_tf").hide();
            $("productx").show();
            $.get('get_product_order.php?ptype_id=' + product_typeId, function(data) {
                var result = JSON.parse(data);
                console.log('re', result)
                $.each(result, function(index, item) {
                    if (item.ptype_id == 'TF0') {
                        productxObject.append(
                            $('<option></option>').val(item.product_id).html(item.product_id + item.product_name)
                        );
                    } else {
                        productxObject.append(
                            $('<option></option>').val(item.product_id).html(item.product_id + item.product_name + '  หนา' + item.thickness + '  ขนาดลวด' + item.dia_size + '  จำนวน' + item.dia_count)
                        );
                    }
                });
            });
        }
    });

    // on change amphure
    productxObject.on('change', function() {
        var ProId = $(this).val();
        console.log('ProId', ProId);
        ProIdObject.html('');

        $.get('get_product_order_detail.php?ProId=' + ProId, function(data) {
            var result = JSON.parse(data);
            console.log('pro_detail', result)
            $.each(result, function(index, item) {
                let unit_price = item.unit_price;
                let stock1 = item.fac1_stock;
                let stock2 = item.fac2_stock;
                let sum;
                var df = 1;
                var disunit = 0;
                console.log('stock1', stock1);


                $('#qty').val(df);
                $('#disunit').val(disunit);
                $('#unit_price').val(unit_price);
                $('#stock1').val(stock1);
                $('#stock2').val(stock2);






            });
        });
    });
});