$(function() {
    var plantObject = $('#plant');
    var productxObject = $('#productx');
    // on change province
    plantObject.on('change', function() {
        var plantId = $(this).val();

        var t = plantId.split("|"); //ถ้าเจอวรรคแตกเก็บลง array t
        for (var i = 0; i < t.length; i++) {
            // document.write(t[i] + "<br/>");
        }
        console.log("xx", t[0])
        console.log("yy", t[1])
        productxObject.html('<option value="">เลือกสินค้าผลิต</option>');


        $.get('get_product.php?ptype_id=' + t[0] + '&width=' + t[1], function(data) {
            var result = JSON.parse(data);
            console.log('re', result)
            $.each(result, function(index, item) {
                productxObject.append(
                    $('<option></option>').val(item.product_id).html(item.product_name + '  ยาว' + item.width + '  ขนาดลวด' + item.dia_size + '  จำนวน' + item.dia_count)
                );
            });
        });
    });

    // on change amphure

});