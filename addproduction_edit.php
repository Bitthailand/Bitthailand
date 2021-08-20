<?php
include './include/connect.php';
include './include/config.php';
$id = intval($_REQUEST['id']);
// echo "$id";
$sql = "SELECT * FROM production_detail  WHERE id = '$id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
// echo "$row[po_id]";
$sql2 = "SELECT * FROM plant  WHERE plant_id = '$row[plant_id]'";
$rs2 = $conn->query($sql2);
$row2 = $rs2->fetch_assoc();

$sql3 = "SELECT * FROM product  WHERE product_id = '$row[product_id]'";
$rs3 = $conn->query($sql3);
$row3 = $rs3->fetch_assoc();
$cal_item = $row3['width'] * $row3['size'];
if ($row3['area'] !== 'undefined') {
    $cal_item2 = $row3['width'] * $row3['size'] * $row3['thickness'];
}
if ($row3['area'] >= 1) {
    $cal_item2 = $row3['width'] * $row3['size'] * $row3['thickness'] * $row3['area'];
}

$sql4 = "SELECT * FROM plant";
$query4 = mysqli_query($conn, $sql4);
?>


<form action="" id='inputform2' method="post" name="frmAMain1">
    <div class="row mt-12">
        <div class="form-group col-md-4">
            <label for="plant"><strong>แพที่ผลิต <span class="text-danger"></span></strong></label>
            <input type="text" class="classcus form-control" value="แพที่ <?php echo $row2['plant_id']; ?> - <?php echo $row2['factory']; ?> " placeholder="แพผลิต" disabled>
        </div>
        <div class="form-group col-md-8">
            <label for="plant"><strong>สินค้าที่ผลิต <span class="text-danger"></span></strong></label>
            <input type="text" class="classcus form-control" value="<?php echo $row3['product_id']; ?> - <?php echo $row3['product_name']; ?> - ยาว <?php echo $row3['width']; ?>  ขนาดลวด <?php echo $row3['dia_size']; ?> จำนวน <?php echo $row3['dia_count']; ?>  " placeholder="สินค้าผลิต" disabled>
        </div>
    </div>
    <div class="row mt-12">

        <div class="form-group col-md-2">
            <label for="qty"><strong>จำนวนสั่งผลิต <span class="text-danger"></span></strong></label>
            <input type="text" name="qty2" id="qty2" value="<?php echo "$row[qty]"; ?>" data-index="1" onKeyUp="fncASum1();" class="classcus form-control" placeholder="จำนวนสั่งผลิต"  required>
            <input type="hidden"  name="sqm2" id="sqm2"  value="<?php echo round($cal_item, 2, PHP_ROUND_HALF_UP); ?>"  >
            <input type="hidden" name="concrete_cal2" id="concrete_cal2"   value="<?php echo round($cal_item2, 2, PHP_ROUND_HALF_UP); ?>" >
        </div>
        
        <div class="form-group col-md-4">
            <label for="sqm"><strong>พ.ท.(Sq.m) <span class="text-danger"></span></strong></label>
            <input type="text" name="sqmx_2" id="sqmx_2"   value="<?php echo "$row[sqm]"; ?>" class="classcus form-control" placeholder="พ.ท.(Sq.m)" required>
        </div>
        <div class="form-group col-md-4">
            <label for="concrete_cal"><strong>คำนวณคอนกรีต <span class="text-danger"></span></strong></label>
            <input type="text" name="concrete_calx_2" id="concrete_calx_2"  value="<?php echo "$row[concrete_cal]"; ?>"  class="classcus form-control" placeholder="คำนวณคอนกรีต" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="add-data"><span class="glyphicon glyphicon-plus"></span>
            EDIT</button>
        <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
       
        <input type="hidden" name="action" value="edit">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>

</form>

<script>
    function fncASum1() {
        {
            let sqm2 = $("#sqm2").val();
            let qty2 = $("#qty2").val();
            let concrete_cal2= $("#concrete_cal2").val();
            console.log('concrete_cal2', concrete_cal2);
            console.log('sqm2', sqm2);
            console.log('qty2', qty2);
            sqmtotal2=Math.round(qty2*sqm2*100)/100;
            concretetotal2=qty2*concrete_cal2;
            $("#sqmx_2").val(sqmtotal2.toFixed(3))
            $("#concrete_calx_2").val(concretetotal2.toFixed(3))
            // console.log('SQM2',qty);
            // document.frmAMain['sqm'].value = (document.frmAMain['qty'].value * sqmx);
            // document.frmAMain['concrete_cal'].value = (document.frmAMain['qty'].value * concrete_calx);

        }

        // document.frmAMain['sqm'].value;
        // document.frmAMain['concrete_cal'].value;
    }
</script>

<script>
    $('#inputform2').on('keydown', 'input', function(event) {
        if (event.which == 13) {
            event.preventDefault();
            var $this = $(event.target);
            var index = parseFloat($this.attr('data-index'));
            $('[data-index="' + (index + 1).toString() + '"]').focus();
        }
    });
</script>