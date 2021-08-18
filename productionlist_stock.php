<?php
include './include/connect.php';
include './include/config.php';
$id = intval($_REQUEST['id']);


$sql = "SELECT * FROM production_order  WHERE id= '$id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$sql2 = "SELECT * FROM production_detail  WHERE po_id= '$row[po_id]'";
$rs2 = $conn->query($sql2);
$row2 = $rs2->fetch_assoc();
echo "$row2[po_id]";
?>


<form action="" method="post" name="form1"  id="form1">



    <!-- ============ Table Start ============= -->
    <div id="productionorder" class="table-responsive">
  
        <table role="table" class="table table-hover text-nowrap table-sm">
            <thead>
                <tr class="table-secondary">

                    <th>รหัสสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>ความยาว</th>
                    <th>จำนวนผลิต</th>
                    <th>สมบูรณ์</th>
                    <th>ไม่สมบูรณ์</th>
                </tr>
            </thead>
            <tbody>
                <?php $sqlxx = "SELECT *  FROM production_detail  where po_id = '$row2[po_id]' ORDER BY id DESC";
                $resultxx = mysqli_query($conn, $sqlxx);
                if (mysqli_num_rows($resultxx) > 0) {
                    while ($rowx = mysqli_fetch_assoc($resultxx)) { ?>
                        <tr>
                            <td><?php
                                $sqlx = "SELECT * FROM product   WHERE product_id= '$row2[product_id]'";
                                $rsx = $conn->query($sqlx);
                                $rowx2 = $rsx->fetch_assoc();
                                $product_id=$rowx['product_id'];
                                echo "$rowx[product_id]";
                                ?></td>
                            <td><?php echo"$rowx2[product_name]";?></td>
                            <td><?php echo"$rowx2[width]";?></td>
                            <td><?php echo"$rowx[qty]";?></td>
                            <td><input class="form-control" value="<?php echo"$rowx[a_type]";?>" type="text" name='a_type[<?=$product_id?>][<?=++$idx;?>]' placeholder="ใส่ข้อมูล"></td>
                            <td><input class="form-control" value="<?php echo"$rowx[b_type]";?>"type="text" name='b_type[<?=$product_id?>][<?=++$idx1;?>]' placeholder="ใส่ข้อมูล"></td>
                        </tr>
                <?php }
                } ?>

            </tbody>
        </table>
   
    </div>
    <!-- ============ Table End ============= -->

    </div>

    <div class="modal-footer">

        <button type="submit" class="btn btn-primary ml-2" name="add-data">บันทึก</span>
        <input type="hidden" name="po_id" value="<?php echo $id; ?>">
        <input type="hidden" name="action" value="add_stock">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>