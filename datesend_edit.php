<?php
include './include/connect.php';
include './include/config.php';
$id = intval($_REQUEST['id']);


$sql = "SELECT * FROM orders   WHERE id= '$id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$datetodat = date('Y-m-d');
echo"$row[order_id]";
?>


<form class="tab-pane fade active show" method="post">

        <div class="form-group">
            <label for="delivery_date">กำหนดส่งสินค้า</label>
            <input id="delivery_date" name="delivery_date" value="<?php echo "$datetodat"; ?>" class="form-control" type="date" min="2021-06-01">
        </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="add-data"><span class="glyphicon glyphicon-plus"></span>
            EDIT</button>
        <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
        <input type="hidden" name="action" value="edit">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>