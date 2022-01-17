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

$event_msg = "อยู่หน้าแจ้งสินค้าชำรุดรหัส '$row[product_id]' ข้อมูลเดิมก่อนแก้ไข  ชื่อสินค้า : $row[product_name]  Stock1: $rs_pro[fac1_stock] Stock2: $rs_pro[fac2_stock]  "; 
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
            <label for="accNameId"><strong>แจ้งชำรุดโรงงาน1 </strong></label>
            <input type="text"   name="stock1" value="" class="classcus form-control" >
        </div>
        <div class="form-group col-md-4">
        <label for="accNameId"><strong>แจ้งชำรุดโรงงาน2 </strong></label>
            <input type="text" name="stock2" value="" class="classcus form-control" >
        </div>
        <div class="form-group col-md-4">
            <label for="accNameId"><strong>สาเหตุชำรุด</strong> </label>
            <input type="text" name="comment"  value="" class="classcus form-control" >
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="add-data"><span class="glyphicon glyphicon-plus"></span>
            เพิ่มสินค้าชำรุด</button>
        <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
        <input type="hidden" name="action" value="bin">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>