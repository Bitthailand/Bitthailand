<?php
include './include/connect.php';
include './include/config.php';
$id = intval($_REQUEST['id']);


$sql = "SELECT * FROM orders  WHERE id= '$id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();

?>


<form action="" method="post" name="form1" id="form1">


    <div class="modal-body">
        <p class="text-Success text-16 line-height-1 mb-2">ยืนยันลูกค้าเครดิตสั่งสินค้าเลขที่ใบสั่งชื้อ : <?=$row['order_id']?>  เรียบร้อยใช่หรือไม่ ?</p>
    </div>

    <div class="modal-footer">

        <button type="submit" class="btn btn-primary ml-2" name="add-data">ใช่</span>
            <input type="hidden" name="order_id" value="<?php echo $id; ?>">
            <input type="hidden" name="action" value="add_cfx">
            <button type="button" class="btn btn-default" data-dismiss="modal">ไม่ใช่</button>
    </div>
</form>