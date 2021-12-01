<?php
include './include/connect.php';
include './include/config.php';
$id = intval($_REQUEST['id']);


$sql = "SELECT * FROM orders  WHERE id= '$id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$sql_dev = "SELECT SUM(qty*(unit_price-disunit)) AS total FROM order_details  WHERE order_id='$row[order_id]' ";
$rs_dev = $conn->query($sql_dev);
$row2 = $rs_dev->fetch_assoc();
$sumx = $row2['total'] - $row['discount'];
$datetodat = date('Y-m-d');

$sql3 = "SELECT * FROM customer  WHERE customer_id= '$row[cus_id]'";
$rs3 = $conn->query($sql3);
$row3 = $rs3->fetch_assoc();
?>


<form action="" method="post" name="form1" id="form1">


    <div class="modal-body">
        <p class="text-16 line-height-1 mb-6">ยืนยันลูกค้าชำระเงินเต็มจำนวนเลขที่ใบสั่งชื้อ : <?= $row['order_id'] ?> เรียบร้อยใช่หรือไม่ ?</p>
        <p class="text-16 line-height-1 mb-6 ">ชื่อลูกค้า: <?php echo $row3['customer_name'];  ?> </p>
        <p class="text-16 line-height-1 mb-6 ">จำนวนเงินที่รับ: <?php echo number_format($sumx, '2', '.', ',') ?> </p>
        <div class="text-16 mb-6 ">
           
                <label for="pay_date">วันที่รับชำระเงินจากลูกค้า</label>
                <input id="Fai_date_start" class="form-control" type="date" min="2021-06-01" name="pay_date" value="<?= $datetodat ?>">
            
        </div>
    </div>

    <div class="modal-footer">

        <button type="submit" class="btn btn-primary ml-2" name="add-data">ใช่</span>
            <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
            <input type="hidden" name="price" value="<?php echo $sumx; ?>">
            <input type="hidden" name="action" value="add_pay">
            <button type="button" class="btn btn-default" data-dismiss="modal">ไม่ใช่</button>
    </div>
</form>