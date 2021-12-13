<?php
include './include/connect.php';
include './include/config.php';
$id = $_REQUEST['id'];


$sql = "SELECT * FROM orders  WHERE order_id= '$id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$datetodat = date('Y-m-d');
echo"$row[order_id]";
?>


<form class="tab-pane fade active show" method="post">

        <div class="form-group">
         
            <input id="price" name="contact_name" value="<?php echo "$row[contact_name]"; ?>" class="form-control" type="text" >
        </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="add-data"><span class="glyphicon glyphicon-plus"></span>
            EDIT</button>
        <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
        <input type="hidden" name="order_id" value="<?=$row['order_id'];?>">
        <input type="hidden" name="action" value="edit_contact">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>