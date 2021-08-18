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
        productxObject.html('<option value="">เลือกสินค้าผลิต</option>');
        ProIdObject.html('<option value="">เลือก</option>');

        $.get('get_product_order.php?ptype_id=' + product_typeId, function(data) {
            var result = JSON.parse(data);
            console.log('re', result)
            $.each(result, function(index, item) {
                productxObject.append(
                    $('<option></option>').val(item.product_id).html(item.product_id + item.product_name + '  หนา' + item.thickness + '  ขนาดลวด' + item.dia_size + '  จำนวน' + item.dia_count)
                );
            });
        });
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

                var df = 1;
                console.log('unit_price', unit_price);


                $('#qty').val(df);
                $('#unit_price').val(unit_price);


            });
        });
    });
});