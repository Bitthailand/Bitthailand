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
            <label for="delivery_date">เปลี่ยนแปลงสถานะใบสั่งชื้อ</label>
            <select class="classcus custom-select" name="order_status" required>
                                                <?php
                                                $sql6 = "SELECT *  FROM  status_or  order by  id ASC ";
                                                $result6 = mysqli_query($conn, $sql6);
                                                if (mysqli_num_rows($result6) > 0) {
                                                    while ($row6 = mysqli_fetch_assoc($result6)) {
                                                ?>
                                                <option value="<?php echo $row6['id'] ?>" <?php
                                                                                                        if (isset($row['order_status']) && ($row['order_status'] == $row6['id'])) {
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