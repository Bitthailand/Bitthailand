<?php
include './include/connect.php';
include './include/config.php';
$id = intval($_REQUEST['id']);


$sql = "SELECT * FROM employee_check  WHERE id = '$id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();


?>


<form class="tab-pane fade active show" method="post">


    <div class="form-row mt-3">
        <div class="form-group col-md-6">
            <label for="accNameId"><strong>ชื่อ นามสกุล<span class="text-danger"></span></strong></label>
            <input type="text" name="name" id="name" value="<?=$row['name']?>" class="classcus form-control" placeholder="ชื่อ นามสกุล">
        </div>
        <div class="form-group col-md-3">
            <label for="accNameId"><strong>เบอร์โทร<span class="text-danger"></span></strong></label>
            <input type="text" name="tel" id="tel" value="<?=$row['tel']?>" class="classcus form-control" placeholder="เบอร์โทร">
        </div>
        <div class="form-group col-md-3">
            <label for="accNameId"><strong>ตำแหน่ง<span class="text-danger"></span></strong></label>
            <select class="classcus custom-select" name="position" required>
                <?php
                $sql6 = "SELECT *  FROM department order by id DESC ";
                $result6 = mysqli_query($conn, $sql6);
                if (mysqli_num_rows($result6) > 0) {
                    while ($row6 = mysqli_fetch_assoc($result6)) {
                ?>
                        <option value="<?php echo $row6['id'] ?>" <?php
                                                                    if (isset($row['position']) && ($row['position'] == $row6['id'])) {
                                                                        echo "selected"; ?>>
                        <?php echo "$row6[name]";
                                                                    } else {      ?>
                        <option value="<?php echo $row6['id']; ?>"> <?php echo $row6['name'];  ?>
                        <?php } ?>
                        </option>
                <?php  }
                }  ?>
            </select>
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