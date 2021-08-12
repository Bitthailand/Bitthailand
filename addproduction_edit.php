<?php
include './include/connect.php';

$id = intval($_REQUEST['id']);
echo "$id";
$sql = "SELECT * FROM production_detail  WHERE id = '$id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
echo "$row[po_id]";
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


<form action="" id='inputform2' method="post" name="myform">
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

        <div class="form-group col-md-4">
            <label for="qty"><strong>จำนวนสั่งผลิต <span class="text-danger"></span></strong></label>
            <input type="text" name="qty" value="<?php echo "$row[qty]"; ?>" data-index="1" onkeyup="calculate()" class="classcus form-control" placeholder="จำนวนสั่งผลิต"  required>
            <input type="hidden" name="cal_item" value="<?php echo "$cal_item"; ?>" onkeyup="calculate()" data-index="2" />
            <input type="hidden" name="cal_item2" value="<?php echo "$cal_item2"; ?>" onkeyup="calculate()" data-index="2" />
        </div>
        <div class="form-group col-md-4">
            <label for="sqm"><strong>พ.ท.(Sq.m) <span class="text-danger"></span></strong></label>
            <input type="text" name="textbox5" value="<?php echo "$row[sqm]"; ?>" class="classcus form-control" placeholder="พ.ท.(Sq.m)" required>
        </div>
        <div class="form-group col-md-4">
            <label for="concrete_cal"><strong>คำนวณคอนกรีต <span class="text-danger"></span></strong></label>
            <input type="text" name="textbox6" value="<?php echo "$row[concrete_cal]"; ?>"  class="classcus form-control" placeholder="คำนวณคอนกรีต" required>
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
    function calculate() {
        if (isNaN(document.forms["myform"]["qty"].value) || document.forms["myform"]["qty"].value == "") {
            var text1 = 0;
        } else {
            var text1 = parseInt(document.forms["myform"]["qty"].value);
        }
        if (isNaN(document.forms["myform"]["cal_item"].value) || document.forms["myform"]["cal_item"].value == "") {
            var text2 = 0;
        } else {
            var text2 = parseFloat(document.forms["myform"]["cal_item"].value);
        }
        if (isNaN(document.forms["myform"]["cal_item2"].value) || document.forms["myform"]["cal_item2"].value == "") {
            var text3 = 0;
        } else {
            var text3 = parseFloat(document.forms["myform"]["cal_item2"].value);
        }
        document.forms["myform"]["textbox5"].value = (text1 * text2);
        document.forms["myform"]["textbox6"].value = (text1 * text3);
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