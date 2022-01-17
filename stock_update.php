<?php
session_start();
include './include/connect.php';
include './include/config.php';
$id = intval($_REQUEST['id']);
$emp_id = $_SESSION["username"];

$sql = "SELECT * FROM product  WHERE id= '$id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$datetodat = date('Y-m-d');
echo 'รหัสสินค้า'.$row['product_id'];


    $event_msg = "ข้อมูลสินค้าก่อนทำรายการแก้ไข  รหัสสินค้า ".$row['product_id']." โรงงาน1:".$row['fac1_stock']." โรงงาน2:".$row['fac2_stock']."" ;
    $sql_event = "INSERT INTO log (product_id,emp_id,event)
VALUES ('$row[product_id]','$emp_id','$event_msg')";
    if ($conn->query($sql_event) === TRUE) {
    }
?>
<?php
$sql3 = "SELECT * FROM product_type WHERE ptype_id= '$row[ptype_id]'";
$rs3 = $conn->query($sql3);
$row3 = $rs3->fetch_assoc();
// echo $row3['ptype_name'];  
?>
<?php
if ($row3['stock_m'] == 1) {
    $sql_po = "SELECT sum(qty) AS a_type  FROM production_import   where  product_id='$row[product_id]' ";
    $rs_po = $conn->query($sql_po);
    $row_po = $rs_po->fetch_assoc();
    // echo "$row_po[a_type]";
} else {


    $sql_po = "SELECT sum(a_type) AS a_type  FROM production_detail   where status_stock='1' AND product_id='$row[product_id]' ";
    $rs_po = $conn->query($sql_po);
    $row_po = $rs_po->fetch_assoc();
    // echo "$row_po[a_type]";
} ?>
<?php
$sql_dev = "SELECT sum(dev_qty) AS dev_qty  FROM deliver_detail  where  product_id='$row[product_id]' ";
$rs_dev = $conn->query($sql_dev);
$row_dev = $rs_dev->fetch_assoc();

 $sum_stock = $row_po['a_type'] - $row_dev['dev_qty'];

?>
<form class="tab-pane fade active show" method="post">
<div class="form-row mt-3">
<div class="form-group col-md-4">
            <label for="accNameId"><strong>สต็อกโรงงาน1 </strong></label>
            <input id="delivery_date" name="fac1_stock" value="<?php echo "$row[fac1_stock]"; ?>" class="form-control" type="text">
        </div>
        <div class="form-group col-md-4">
            <label for="accNameId"><strong>สต็อกโรงงาน2</strong> </label>
            <input id="delivery_date" name="fac2_stock" value="<?php echo "$row[fac2_stock]"; ?>" class="form-control" type="text">
        </div>
   
</div>
    <div class="form-row mt-3">

        <div class="form-group col-md-4">
            <label for="accNameId"><strong>จำนวนสินค้าผลิตทั้งหมด </strong></label>
            <input type="text" value="<?php echo $row_po['a_type']; ?>" class="classcus form-control" disabled>
        </div>
        <div class="form-group col-md-4">
            <label for="accNameId"><strong>จำนวนสินค้าที่ขายไปทั้งหมด</strong> </label>
            <input type="text" value="<?php echo $row_dev['dev_qty']; ?>" class="classcus form-control" disabled>
        </div>
        <div class="form-group col-md-4">
            <label for="accNameId"><strong>ยอดสต็อคคงเหลือ</strong> </label>
            <input type="text" value="<?php echo $sum_stock; ?>" class="classcus form-control" disabled>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="add-data"><span class="glyphicon glyphicon-plus"></span>
            EDIT</button>
        <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
        <input type="hidden" name="action" value="editx">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>