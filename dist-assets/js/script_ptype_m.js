$(function() {
    var ptypeObject = $('#ptype_id');

    var productx1Object = $('#productx1');

    // on change province
    ptypeObject.on('change', function() {
        var ptype_id = $(this).val();

        productx1Object.html('<option value="">เลือกสินค้านำเข้าจำหน่าย</option>');
        // sqmObject.html('<option value="">เลือก</option>');

        $.get('get_product_m.php?ptype_id=' + ptype_id, function(data) {
            var result = JSON.parse(data);
            console.log('re', result)
            $.each(result, function(index, item) {
                productx1Object.append(
                    $('<option></option>').val(item.product_id).html(item.product_id + item.product_name)
                );
            });
        });
    });

    // 



});