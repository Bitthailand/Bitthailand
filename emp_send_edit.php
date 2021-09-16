<?php
include './include/connect.php';
include './include/config.php';
$id = intval($_REQUEST['id']);


$sql = "SELECT * FROM delivery WHERE id= '$id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$datetodat = date('Y-m-d');
echo 'เลขที่ใบส่งสินค้า'.$row['dev_id'];
?>


<form class="tab-pane fade active show" method="post">

<div class="form-group">
        <label for="searchColumnId"> ชื่อพนักงานส่งสินค้า </label>
        <select class="classcus custom-select" name="dev_employee" id="dev_employee" required>
            <?php
            $sql6 = "SELECT *  FROM employee_check  where position='1' order by name DESC ";
            $result6 = mysqli_query($conn, $sql6);
            if (mysqli_num_rows($result6) > 0) {
                while ($row6 = mysqli_fetch_assoc($result6)) {
            ?>
                    <option value="<?php echo $row6['id'] ?>" <?php
                                                                    if (isset($row['dev_employee']) && ($row['dev_employee'] == $row6['id'])) {
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

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="add-data"><span class="glyphicon glyphicon-plus"></span>
            EDIT</button>
        <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
        <input type="hidden" name="action" value="edit">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>