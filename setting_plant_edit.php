<?php
include './include/connect.php';
include './include/config.php';
$id = intval($_REQUEST['id']);


$sql = "SELECT * FROM plant  WHERE id = '$id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();


?>


<form class="tab-pane fade active show" method="post">


    <div class="form-row mt-3">

        <div class="form-group col-md-3">
            <label for="accNameId"><strong>รหัสแพ <span class="text-danger">*</span></strong></label>
            <input type="text" name="plant_id"   value="<?=$row['plant_id']?>"  id="plant_id" class="classcus form-control" placeholder="รหัสแพ" required disabled>
        </div>
        <div class="form-group col-md-3">
            <label for="accNameId"><strong>โรงงาน<span class="text-danger">*</span></strong></label>
            <select class="classcus custom-select" name="factory" id="type_id" required>
                <?php
                $sql6 = "SELECT *  FROM  factory order by id DESC ";
                $result6 = mysqli_query($conn, $sql6);
                if (mysqli_num_rows($result6) > 0) {
                    while ($row6 = mysqli_fetch_assoc($result6)) {
                ?>
                        <option value="<?php echo $row6['name'] ?>" <?php
                                                                    if (isset($row['factory']) && ($row['factory'] == $row6['name'])) {
                                                                        echo "selected"; ?>>
                        <?php echo "$row6[name]";
                                                                    } else {      ?>
                        <option value="<?php echo $row6['name']; ?>"> <?php echo $row6['name'];  ?>
                        <?php } ?>
                        </option>
                <?php  }
                }  ?>

            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="customer_type"><strong>ประเภทสินค้า <span class="text-danger"></span></strong></label>

            <select class="classcus custom-select" name="ptype_id" id="type_id" required>
                <?php
                $sql6 = "SELECT *  FROM product_type order by id DESC ";
                $result6 = mysqli_query($conn, $sql6);
                if (mysqli_num_rows($result6) > 0) {
                    while ($row6 = mysqli_fetch_assoc($result6)) {
                ?>
                        <option value="<?php echo $row6['ptype_id'] ?>" <?php
                                                                        if (isset($row['ptype_id']) && ($row['ptype_id'] == $row6['ptype_id'])) {
                                                                            echo "selected"; ?>>
                        <?php echo "$row6[ptype_name]";
                                                                        } else {      ?>
                        <option value="<?php echo $row6['ptype_id']; ?>"> <?php echo $row6['ptype_name'];  ?>
                        <?php } ?>
                        </option>
                <?php  }
                }  ?>

            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="accNameId"><strong>ความกว้างของแพ <span class="text-danger"></span></strong></label>
            <input type="number" name="width"  value="<?=$row['width']?>"   step="0.01" class="classcus form-control" placeholder="ความกว้างแพ">
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


