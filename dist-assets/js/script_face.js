$(function() {
    var plantObject = $('#plant');
    var plantObject1 = $('#plant1');
    var productxObject = $('#productx');
    var sqmObject = $('#sqm');
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
        sqmObject.html('<option value="">เลือก</option>');

        $.get('get_product.php?ptype_id=' + t[0] + '&width=' + t[1], function(data) {
            var result = JSON.parse(data);
            console.log('re', result)
            $.each(result, function(index, item) {
                productxObject.append(
                    $('<option></option>').val(item.id).html(item.product_id + item.product_name + '  หนัก' + item.weight + '  หนา' + item.thickness + '  ขนาดลวด' + item.dia_size + '  จำนวน' + item.dia_count)
                );
            });
        });
    });

    // 



    // on change amphure
    productxObject.on('change', function() {
        var sqmId = $(this).val();
        console.log('sqmId', sqmId);
        sqmObject.html('');

        $.get('get_sqm.php?sqm_id=' + sqmId, function(data) {
            var result = JSON.parse(data);
            console.log('rexx', result)
            $.each(result, function(index, item) {
                let thickness;
                let area;
                // var cal_cons;


                // var cal_item = item.weight / 2400;
                var cal_item = item.width * item.size;
                if (item.area !== 'undefined') {
                    var cal_cons = item.weight / 2400;
                }
                if (item.area >= 1) {
                    // var cal_cons = item.width * item.size * item.thickness * item.area;
                }
                var cal_cons = item.weight / 2400;

                console.log('=========คำนวณตรงๆ=====================');
                console.log('item.width', item.width);
                console.log('item.size', item.size);
                console.log('item.thickness', item.thickness);
                console.log('item.area', item.area);
                console.log('SUM_cal_cons', cal_cons);
                console.log('SUM_SQM', cal_item);
                console.log('==============================');
                console.log('=========ปัดเศษ=====================');
                console.log('item.width', item.width);
                console.log('item.size', item.size);
                console.log('item.thickness', item.thickness);
                console.log('SUM_cal_cons', Math.round(cal_cons.toFixed(5) * 1000) / 1000);
                console.log('SUM_SQM', Math.round(cal_item.toFixed(5) * 1000) / 1000);
                console.log('==============================');
                var df = 1;
                // console.log('calitem', cal_item.toFixed(3));


                $('#qty').val(df)
                $('#width1').val(item.width)
                $('#size1').val(item.size)
                $('#thickness1').val(item.thickness)
                $('#area1').val(item.area)
                $('#sqm').val(Math.round(cal_item.toFixed(5) * 1000) / 1000)
                $('#sqm1').val(Math.round(cal_item.toFixed(5) * 1000) / 1000)
                $('#concrete_cal').val(Math.round(cal_cons.toFixed(5) * 1000) / 1000)
                $('#concrete_cal1').val(Math.round(cal_cons.toFixed(5) * 1000) / 1000)

            });
        });
    });
});