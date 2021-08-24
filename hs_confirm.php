<?php
include './include/connect.php';
include './include/config.php';
$id = intval($_REQUEST['id']);


$sql = "SELECT * FROM delivery  WHERE id= '$id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();

?>


<form action="" method="post" name="form1" id="form1">


    <div class="modal-body">
        <p class="text-Success text-16 line-height-1 mb-2">ยืนยันการออกใบเสร็จรับเงิน Sale Order ID : <?=$row['order_id']?> SO ID <?=$row['dev_id']?> ใช่หรือไม่ ?</p>
    </div>

    <div class="modal-footer">

        <button type="submit" class="btn btn-primary ml-2" name="add-data">ใช่</span>
            <input type="hidden" name="e_id" value="<?php echo $id; ?>">
            <input type="hidden" name="so_id" value="<?php echo $row['dev_id'];?>">
            <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
            <input type="hidden" name="action" value="add_hs">
            <button type="button" class="btn btn-default" data-dismiss="modal">ไม่ใช่</button>
    </div>
</form>