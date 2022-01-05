<?php
include './include/connect.php';
include './include/config.php';
$order_id = $_REQUEST['id'];


$sql1 = "SELECT * FROM orders  WHERE order_id= '$order_id'";
$rs1 = $conn->query($sql1);
$row1 = $rs1->fetch_assoc();


$sql = "SELECT * FROM ai_number  WHERE order_id= '$row1[order_id]'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$datetodat = date('Y-m-d');
// echo"$row[order_id]";
?>


<form class="tab-pane fade active show" method="post">

        <div class="form-group">
            <label for="delivery_date">ยกเลิกรายการมัดจำ <?php  echo"$row1[order_id]"; ?></label>
            <input id="price" name="price" value="<?php echo "$row[price]"; ?>" class="form-control" type="hidden" >
        </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="add-data"><span class="glyphicon glyphicon-plus"></span>
            ยกเลิกรายการมัดจำ</button>
        <input type="hidden" name="edit_id" value="<?php echo $row1['order_id']; ?>">
        <input type="hidden" name="order_id" value="<?=$row1['order_id'];?>">
        <input type="hidden" name="action" value="cancle_ai">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>