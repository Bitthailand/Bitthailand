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
$sql4 = "SELECT * FROM plant";
$query4 = mysqli_query($conn, $sql4);
?>
<form method="post">
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
            <input type="text" name="qty" value="<?php echo $row['qty']; ?>" class="classcus form-control" placeholder="จำนวนสั่งผลิต" required>
        </div>
        <div class="form-group col-md-4">
            <label for="sqm"><strong>พ.ท.(Sq.m) <span class="text-danger"></span></strong></label>
            <input type="text" name="sqm" value="<?php echo $row['sqm']; ?>"  class="classcus form-control" placeholder="พ.ท.(Sq.m)" required>
        </div>
        <div class="form-group col-md-4">
            <label for="concrete_cal"><strong>คำนวณคอนกรีต <span class="text-danger"></span></strong></label>
            <input type="text" name="concrete_cal" value="<?php echo $row['concrete_cal']; ?>"  class="classcus form-control" placeholder="คำนวณคอนกรีต" required>
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
