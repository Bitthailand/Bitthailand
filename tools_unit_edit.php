<?php
include './include/connect.php';
include './include/config.php';
$id = intval($_REQUEST['id']);


$sql = "SELECT * FROM unit_tools   WHERE id= '$id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();


?>


<form class="tab-pane fade active show" method="post">


    <div class="form-row mt-3">

        <div class="form-group col-md-3">
            <label for="accNameId"><strong>รหัสหน่วยนับ <span class="text-danger">*</span></strong></label>
            <input type="text" name="id"   value="<?=$row['id']?>"  id="plant_id" class="classcus form-control" placeholder="รหัสแพ" required disabled>
        </div>
        <div class="form-group col-md-6">
            <label for="accNameId"><strong>ชื่อหน่วยนับ<span class="text-danger"></span></strong></label>
            <input type="text" name="name"  value="<?=$row['name']?>"   class="classcus form-control" placeholder="ความกว้างแพ">
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


