<?php
include './include/connect.php';
include './include/config.php';
$id = intval($_REQUEST['id']);


$sql = "SELECT * FROM production_order  WHERE id= '$id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();


?>


<form class="tab-pane fade active show" method="post">



        <div class="viewDateClass col pr-0 ">
            <div class="form-group">
                <label for="searchSDateId">วันเวลาเท</label>
                <input id="searchSDateId" class="form-control" type="datetime-local" min="2021-06-01" name="po_start" value="<?php echo $row['po_start']; ?>" required="">
            </div>
        </div>
        <div class="viewDateClass col pr-0 ">
            <div class="form-group">
                <label for="searchEDateId">วันเวลาเทเสร็จ</label>
                <input id="searchEDateId" class="form-control" type="datetime-local" name="po_stop" value="<?=$row['po_stop']?>" required="">
            </div>
        </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="add-data"><span class="glyphicon glyphicon-plus"></span>
        บันทึก</button>
        <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
        <input type="hidden" name="action" value="edit_prox">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>