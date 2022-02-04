<?php
include './include/connect.php';
include './include/config.php';
$id = intval($_REQUEST['id']);


$sql = "SELECT * FROM tools  WHERE id = '$id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();


?>


<form class="tab-pane fade active show" method="post">


    <div class="box-content">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="accNameId"><strong>ชื่อเครื่องมือช่าง<span class="text-danger"></span></strong></label>
                <input type="text" name="name" value="<?=$row['name']?>" class="form-control" disabled>
                <input type="hidden" name="name" value="<?=$row['name']?>" class="form-control" >
            </div>

            <div class="form-group col-md-6">
                <label for="accNameId"><strong>สาเหตุชำรุด<span class="text-danger"></span></strong></label>
                <input type="text" name="comment" value="" class="form-control" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <?php $datex = date('Y-m-d'); ?>
                <label for="accNameId"><strong>วันที่จำหน่ายออก<span class="text-danger"></span></strong></label>
                <input id="date_import" name="date_import" value="<?=$row['date_import']?>" class="form-control" type="date" min="2021-06-01" require>
            </div>
            <div class="form-group col-md-3">
                <?php $datex = date('Y-m-d'); ?>
                <label for="accNameId"><strong>จำนวน<span class="text-danger"></span></strong></label>
                <input id="qty" name="qty_out" value="" class="form-control" type="text" require>
            </div>
            <div class="form-group col-md-3">

                <label for="accNameId"><strong>หน่วยนับ<span class="text-danger"></span></strong></label>
                <select name="unit" id="unit" class="classcus custom-select " required>
                    <option value="">หน่วยนับ</option>
                    <?php
                    $sql6 = "SELECT *  FROM unit_tools     order by name ASC ";
                    $result6 = mysqli_query($conn, $sql6);
                    if (mysqli_num_rows($result6) > 0) {
                        while ($row6 = mysqli_fetch_assoc($result6)) {
                    ?>
                            <option value="<?= $row6['id'] ?>" <?php if (isset($row['unit']) && ($row['unit'] == $row6['id'])) {
                                                                    echo "selected"; ?>>
                                <?= $row6['name'] ?>
                            <?php  } else {      ?>
                            <option value="<?= $row6['id'] ?>"> <?= $row6['name'] ?>
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
            <input type="hidden" name="action" value="edit_bin">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
</form>