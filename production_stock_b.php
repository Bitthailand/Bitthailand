<?php
include './include/connect.php';
include './include/config.php';
$id = intval($_REQUEST['id']);



$sql2 = "SELECT * FROM production_detail  WHERE id= '$id'";
$rs2 = $conn->query($sql2);
$row = $rs2->fetch_assoc();
echo "$row2[po_id]";
$sql = "SELECT * FROM production_order  WHERE id= '$row2[po_id]'";
$rs = $conn->query($sql);
$row2 = $rs->fetch_assoc();
?>


<form action="" method="post" name="form1" id="form1">



    <!-- ============ Table Start ============= -->
    <div id="productionorder" class="table-responsive">

        <table role="table" class="table table-hover text-nowrap table-sm">
            <thead>
                <tr class="table-secondary">

                    <th>สินค้าชิ้นที่</th>
                    <th>ชื่อสินค้า</th>
                    <th>แพที่</th>
                    <th>ความยาว</th>
              
                    <th>ย้ายรหัสสินค้า</th>
                   
                </tr>
            </thead>
            <tbody>
                <?php for ($x = 1; $x <= $row['b_type']; $x++) {
                ?>
                    <tr>
                        <td><?= ++$idx3 ?></td>

                        <td><?php
                            $sqlx = "SELECT * FROM product   WHERE product_id= '$row[product_id]'";
                            $rsx = $conn->query($sqlx);
                            $rowx2 = $rsx->fetch_assoc();
                            $pid = $row['id'];
                            $product_id = $row['product_id'];
                            echo "$row[product_id]";
                            ?><?php echo "$rowx2[product_name]"; ?></td>
                        <td><?php echo "$row[plant_id]"; ?></td>
                        <td><?php echo "$rowx2[width]"; ?></td>
                       
                        <td><select class="classcus custom-select" name="product_id[<?=$product_id?>][<?=$pid?>][<?=$x;?>]" id="type_id" >
                        <option value="00">เลือกสินค้า</option>
                        <option value="99">ทิ้งสินค้า</option>
                         <?php
                                                $sql6 = "SELECT *  FROM  product where ptype_id='$rowx2[ptype_id]'   order by ptype_id DESC ";
                                                $result6 = mysqli_query($conn, $sql6);
                                                if (mysqli_num_rows($result6) > 0) {
                                                    while ($row6 = mysqli_fetch_assoc($result6)) {
                                                ?>
                                                <option value="<?php echo $row6['product_id'] ?>" <?php
                                                                                                        if (isset($row['product_id']) && ($row['product_id'] == $row6['product_id'])) {
                                                                                                            echo "selected"; ?>>
                                                    <?php echo $row6['product_id'].'-'.$row6['product_name'];
                                                                                                        } else {      ?>
                                                <option value="<?php echo $row6['ptype_id']; ?>"> <?php echo $row6['product_id'].'-'.$row6['product_name']; ?>
                                                    <?php } ?>
                                                </option>
                                                <?php  }
                                                }  ?>
                            </select></td>
                     
                    </tr>
                <?php }
                ?>

            </tbody>
        </table>

    </div>
    <!-- ============ Table End ============= -->

    </div>

    <div class="modal-footer">

        <button type="submit" class="btn btn-primary ml-2" name="add-data">บันทึก</span>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="action" value="stock_b">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>
