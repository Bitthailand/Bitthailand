<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config_so.php';
include './include/config_date.php';
$order_id = $_REQUEST['order_id'];
$emp_id = $_SESSION["username"];
$datetoday = date('Y-m-d');
$sql = "SELECT * FROM orders   WHERE order_id= '$order_id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
// ====

$sql2 = "SELECT * FROM customer_type  WHERE id= '$row[cus_type]'";
$rs2 = $conn->query($sql2);
$row2 = $rs2->fetch_assoc();
// ====
$sql3 = "SELECT * FROM customer  WHERE customer_id= '$row[cus_id]'";
$rs3 = $conn->query($sql3);
$row3 = $rs3->fetch_assoc();
// ===
if ($row['dev_status'] == 1) {
    $dev_status = $row['dev_status'];
} else {
    $sql5 = "SELECT MAX(id) AS id_run FROM delivery  ";
    $rs5 = $conn->query($sql5);
    $row_run = $rs5->fetch_assoc();
    $dev_status = $row['dev_status'];
    $datetodat = date('Y-m-d');
    $date = explode(" ", $datetodat);
    $dat = datethai_so($date[0]);
    $code_new = $row_run['id_run'] + 1;
    $code = sprintf('%05d', $code_new);
    $dev_id = $dat . $code;
}
?>
<!DOCTYPE html>
<html lang="en" dir="">
<!-- <input id="order_id" value="<?php echo "$order_id"; ?>" type="text" name="order_id"> -->

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Sale Order | ใบส่งของ</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <style>
        p {
            margin-top: 0;
            margin-bottom: 0.1rem;
        }
    </style>
    <style>
        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
            font-size: 0.813rem !important;
        }
    </style>
</head>
<?php
include './include/alert.php';

echo "$dev_date";
$action = $_REQUEST['action'];
if ($action == 'add_dev') {
    $order_id = $_REQUEST['order_id'];
    $dev_id = $_REQUEST['dev_id'];
    $dev_date = $_REQUEST['dev_date'];

    if ($dev_date == '') { ?>
        <script>
            $(document).ready(function() {
                showAlert("ไม่ได้กรอกวันที่", "alert-danger");
            });
        </script>
        <?php } else {
        $sqlxx = "SELECT *  FROM order_details  where order_id= '$order_id' AND ptype_id<>'TF' ORDER BY id ASC";
        $resultxx = mysqli_query($conn, $sqlxx);
        if (mysqli_num_rows($resultxx) > 0) {
            while ($rowx = mysqli_fetch_assoc($resultxx)) {
                // echo"$product_id";

                $product_id = $rowx['product_id'];
                $pid = $rowx['id'];
                // echo"++$id5x";
                $stock1 = $_POST['stock1'][$product_id][$pid][++$id];
                $stock2 = $_POST['stock2'][$product_id][$pid][++$id2];
                $total_instock = $stock1 + $stock2;
                // echo "vvvvv";
                // echo "$stock1";
                // echo "$stock2";
                // echo "$stock2";
                // echo "total_instoc";
                // echo "$total_instock";
                $sqlx3 = "SELECT * FROM product  WHERE product_id= '$product_id'";
                $rsx3 = $conn->query($sqlx3);
                $rowx3 = $rsx3->fetch_assoc();
                // echo "===";
                // echo "$rowx3[fac2_stock]";
                // echo "===<br>";
                if ($rowx3['fac1_stock'] < $stock1) { ?>
                    <script>
                        $(document).ready(function() {
                            showAlert("ไม่สามารถบันทึกสต็อกโรงงาน1 รหัส  <?= $product_id ?> ได้เนื่องจากจำนวนที่กรอกเกินสต็อก", "alert-danger");
                        });
                    </script>
                <?php
                }
                if ($rowx3['fac2_stock'] < $stock2) { ?>
                    <script>
                        $(document).ready(function() {
                            showAlert("ไม่สามารถบันทึกสต็อกโรงงาน2 รหัส  <?= $product_id ?> ได้เนื่องจากจำนวนที่กรอกเกินสต็อก", "alert-danger");
                        });
                    </script>
                <?php
                }
                if ($rowx['qty'] < $total_instock) { ?>
                    <script>
                        $(document).ready(function() {
                            showAlert("ไม่สามารถบันทึกรหัส  <?= $product_id ?> ได้เนื่องจากจำนวนที่กรอกเกินจำนวนที่สั่งไว้", "alert-danger");
                        });
                    </script>
                <?php
                }
                if ($total_instock == 0) { ?>
                    <script>
                        $(document).ready(function() {
                            showAlert("ไม่สามารถบันทึกรหัส  <?= $product_id ?> ได้เนื่องจากจำนวนที่ส่งเป็น 0 หรือ ค่าว่าง", "alert-danger");
                        });
                    </script>
                    <?php
                }
                //  ถ้าผ่านเงื่อนไขไม่มี error ให้ บันทึก
                if (($rowx['qty'] >= $total_instock) && ($total_instock <> 0)) {
                    $sum_face1 = $rowx3['fac1_stock'] - $stock1;
                    $sum_face2 = $rowx3['fac2_stock'] - $stock2;
                    //    ตรวจสอบรหัสซ้ำในตารางจัดส่ง
                    $sql99 = "SELECT *  FROM deliver_detail  where order_id= '$order_id' AND dev_id='$dev_id'AND product_id='$product_id' ";
                    $result99 = mysqli_query($conn, $sql99);
                    if (mysqli_num_rows($result99) > 0) {
                    } else {

                        $sqlx = "INSERT INTO deliver_detail (dev_id,product_id,order_id,dev_qty,unit_price,total_price,disunit)
                            VALUES ('$dev_id','$product_id','$order_id','$total_instock','$rowx[unit_price]','$rowx[total_price]','$rowx[disunit]')";



                        $sql1 = "UPDATE order_details SET face1_stock_out='$stock1',face2_stock_out='$stock2',qty_dev='$total_instock',status_delivery='1' where product_id='$product_id'";
                        $sql2 = "UPDATE product  SET fac1_stock='$sum_face1',fac2_stock='$sum_face2' where product_id='$product_id'";

                        if ($conn->query($sql1) === TRUE) {
                        }
                        if ($conn->query($sql2) === TRUE) {
                        }

                        if ($conn->query($sqlx) === TRUE) {
                    ?>
                            <script>
                                $(document).ready(function() {
                                    showAlert("บันทึกสต็อกรหัส <?= $product_id ?> สำเร็จ", "alert-primary");
                                });
                            </script>
        <?php
                        }
                    }
                }
            }
        }

        $sqlc1 = "SELECT COUNT(*) AS ts  FROM order_details  WHERE   order_id= '$order_id' AND status_delivery='1' ";
        $rsc1 = $conn->query($sqlc1);
        $rowc1 = $rsc1->fetch_assoc();

        $sqlc0 = "SELECT COUNT(*) AS ts2  FROM order_details  WHERE   order_id= '$order_id' AND ptype_id<>'TF' ";
        $rsc0 = $conn->query($sqlc0);
        $rowc0 = $rsc0->fetch_assoc();
        $sqlx12 = "UPDATE orders  SET dev_status='1',dev_id='$dev_id',delivery_date='$dev_date' WHERE order_id= '$order_id'";
        // echo "$rowc1[ts]=$rowc0[ts2]=$dev_date";


        // echo"$rowc1[ts]<br>";
        // echo "xxx<br>";
        if ($rowc0['ts2'] == $rowc1['ts']) {
            // echo "$order_id";
            $dev_status = '1';
            $sqlx12 = "UPDATE orders  SET dev_status='1',dev_id='$dev_id' WHERE order_id= '$order_id'";
            if ($conn->query($sqlx12) === TRUE) {
            }
        }

        $sqlxx = "SELECT *  FROM delivery  where order_id= '$order_id' AND dev_id='$dev_id' ";
        $resultxx = mysqli_query($conn, $sqlxx);
        if (mysqli_num_rows($resultxx) > 0) {
        } else {
            $sqlx = "INSERT INTO delivery(dev_id,order_id,dev_date)
             VALUES ('$dev_id','$order_id','$dev_date')";
            if ($conn->query($sqlx) === TRUE) {
            }
            $sql_TF = "SELECT * FROM order_details  where order_id='$order_id'  AND ptype_id='TF'  ";
            $result_TF = mysqli_query($conn, $sql_TF);
            while ($row_TF = mysqli_fetch_assoc($result_TF)) {

                $sql_TF = "INSERT INTO deliver_detail(dev_id,order_id,product_id,dev_qty,unit_price)
        VALUES ('$dev_id','$order_id','$row_TF[product_id]','1','$row_TF[unit_price]')";
                if ($conn->query($sql_TF) === TRUE) {
                }
            }
        }
        $cf = 'ok';
    }
    $action = '';
    $dev_date = '';
}
if ($action == 'add_hs') {
    $e_id = $_REQUEST['e_id'];
    $so_id = $_REQUEST['so_id'];
    $order_id = $_REQUEST['order_id'];

    //    echo"$po_stop";
    //    echo"$po_start";
    $sql5 = "SELECT count(id) AS id_run FROM hs_number  ";
    $rs5 = $conn->query($sql5);
    $row_run = $rs5->fetch_assoc();
    $dev_status = $row['dev_status'];
    $datetodat = date('Y-m-d');
    $date = explode(" ", $datetodat);
    $dat = datethai_HS1($date[0]);
    $code_new = $row_run['id_run'] + 1;
    $code = sprintf('%05d', $code_new);
    $hs_id = $dat . $code;

    $sqlx = "SELECT * FROM hs_number  WHERE order_id='$order_id' AND so_id='$so_id' ";
    $result = mysqli_query($conn, $sqlx);
    if (mysqli_num_rows($result) > 0) {
    } else {
        $sqlx5 = "INSERT INTO hs_number (order_id,so_id,hs_id)
    VALUES ('$order_id','$so_id','$hs_id')";
        if ($conn->query($sqlx5) === TRUE) {
        }
    }
    $sqlxxx = "UPDATE delivery  SET hs_id='$hs_id' where id='$e_id'";
    if ($conn->query($sqlxxx) === TRUE) { ?>
        <script>
            $(document).ready(function() {
                // showAlert("บันทึกข้อมูลพนักงานจัดส่งเรียบร้อย", "alert-primary");

                window.open('hs.php?order_id=<?= $order_id ?>&so_id=<?= $so_id ?>', '_blank');
            });
        </script>
<?php }
}

?>

<body class="text-left">
    <div class="app-admin-wrap layout-horizontal-bar">
        <!-- Header -->
        <?php include './include/header.php'; ?>
        <!-- =============== Header End ================-->
        <!-- side bar menu -->
        <?php include './include/menu.php'; ?>
        <!-- =============== Left side End ================-->

        <!-- =============== Horizontal bar End ================-->
        <div class="main-content-wrap d-flex flex-column">
            <!-- ============ Body content start ============= -->
            <!-- แจ้งเตือน -->
            <div id="alert_placeholder" style="z-index: 9999999; left:1px; top:1%; width:100%; position:absolute;"></div>
            <!-- ปิดการแจ้งเตือน -->
            <div class="main-content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="tab-content">
                            <div class="card">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
                                        <form action="" method="post" name="form1" id="form1">
                                            <!-- -===== Print Area =======-->
                                            <div id="print-area">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h4 class="font-weight-bold">บริษัท วันเอ็ม จำกัด</h4>
                                                        <p>290 ม.1 ต.กระโสบ อ.เมือง จ.อุบลราชธานี 34000</p>
                                                        <p>เลขที่ประจำตัวผู้เสียภาษี 0345555000224 สำนักงานใหญ่</p>
                                                    </div>
                                                    <div class="col-md-6 text-sm-right">
                                                        <h4 class="font-weight-bold">ใบส่งของ</h4>
                                                    </div>
                                                </div>
                                                <div class="mt-3 mb-4 border-top"></div>
                                                <div class="row mb-5">
                                                    <div class="col-md-6 mb-3 mb-sm-0">
                                                        <h5 class="font-weight-bold">ลูกค้า</h5>
                                                        <?php
                                                        $sql6 = "SELECT * FROM districts  WHERE id= '$row3[subdistrict]'";
                                                        $rs6 = $conn->query($sql6);
                                                        $row6 = $rs6->fetch_assoc();
                                                        $sql7 = "SELECT * FROM amphures  WHERE id= '$row3[district]'";
                                                        $rs7 = $conn->query($sql7);
                                                        $row7 = $rs7->fetch_assoc();
                                                        $sql8 = "SELECT * FROM provinces  WHERE id= '$row3[province]'";
                                                        $rs8 = $conn->query($sql8);
                                                        $row8 = $rs8->fetch_assoc();

                                                        ?>
                                                        <p><strong>ชื่อลูกค้า : </strong><?= $row3['customer_name'] ?></p>
                                                        <p><strong>บริษัท : </strong><?= $row3['company_name'] ?></p>
                                                        <p><strong>ที่อยู่ : </strong><?php echo $row3['bill_address'] . " ต" . $row6['name_th'] . "  อ." . $row7['name_th'] . " จ." . $row8['name_th']; ?> </p>
                                                        <p>เลขที่ประจำตัวผู้เสียภาษี <?= $row3['tax_number'] ?></p>
                                                        <p><strong>โทร : </strong> <?= $row3['tel'] ?></p>
                                                        <p><strong>อ้างอิง : </strong><?= $row3['contact_name'] ?></p>
                                                        <p><strong>ประเภทลูกค้า : </strong><?= $row2['name'] ?></p>
                                                    </div>
                                                    <div class="col-md-6 text-sm-right">
                                                        <h5 class="font-weight-bold"></h5>
                                                        <div class="invoice-summary">
                                                            <div class="form-group col-md-12">
                                                                <p>ลำดับการสั่งซื้อ <span><?= $order_id ?></span></p>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="ai_id"><strong>เลขที่ใบส่งของ <span class="text-danger"></span></strong></label>
                                                                <input type="text" name="dev_id" value="<?= $dev_id ?>" class="classcus form-control" id="so_id" placeholder="เลขที่ใบส่งของ">
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <div class="form-group">
                                                                    <label for="delivery_date">วันที่</label>
                                                                    <input id="dev_date" class="form-control" type="date" require min="<?= $datetodat ?>" name="dev_date" value="<?= $row['delivery_date'] ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 table-responsive">
                                                        <table class="table table-hover mb-4">
                                                            <thead class="bg-gray-300">
                                                                <tr>
                                                                    <th scope="col" class="text-center" width="5%">No.</th>
                                                                    <th scope="col" class="text-center" width="35%">รหัสสินค้า/รายละเอียด</th>
                                                                    <th scope="col" class="text-center" width="10%">สต๊อกโรงงาน 1</th>
                                                                    <th scope="col" class="text-center" width="10%">สต๊อกโรงงาน 2</th>
                                                                    <th scope="col" class="text-center" width="10%">จำนวนที่ต้องส่ง</th>
                                                                    <th scope="col" class="text-center" width="10%">โรงงาน 1</th>
                                                                    <th scope="col" class="text-center" width="10%">โรงงาน 2</th>

                                                                    <th scope="col" class="text-center" width="10%">จำนวนส่ง</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $sql_pro = "SELECT * FROM order_details  where order_id='$order_id' AND ptype_id<>'TF' order by id  ASC ";
                                                                $result_pro = mysqli_query($conn, $sql_pro);
                                                                if (mysqli_num_rows($result_pro) > 0) {
                                                                    while ($row_pro = mysqli_fetch_assoc($result_pro)) {

                                                                        $no = $row_pro['id'];
                                                                        $product_id = $row_pro['product_id'];
                                                                ?>
                                                                        <tr class="line">
                                                                            <th scope="row" class="text-center"><?= ++$idx; ?></th>
                                                                            <td> <?php $idx7 = ++$id7;
                                                                                    $idx8 = ++$id8;
                                                                                    $sqlx3 = "SELECT * FROM product  WHERE product_id= '$row_pro[product_id]' ";
                                                                                    $rsx3 = $conn->query($sqlx3);
                                                                                    $rowx3 = $rsx3->fetch_assoc();
                                                                                    echo $rowx3['product_id'] . $rowx3['product_name'] . '  หนา' . $rowx3['thickness'] . '  ขนาดลวด' . $rowx3['dia_size'] . '  จำนวน' . $rowx3['dia_count'];
                                                                                    ?></td>

                                                                            <td class="text-center"><input type='number' class="form-control" <?php echo "id='face1_stock" . $no . "'"; ?> value='<?php echo $rowx3['fac1_stock']; ?>' readonly></td>
                                                                            <td class="text-center"><input type='number' class="form-control" <?php echo "id='face2_stock" . $no . "'"; ?> value='<?php echo $rowx3['fac2_stock']; ?>' readonly></td>
                                                                            <td class="text-center"><input type='number' class="form-control" <?php echo "id='qty" . $no . "'"; ?> value='<?php echo $row_pro['qty']; ?>' readonly></td>
                                                                            <td class="text-center"> <?php echo "<span id='err" . $no . "' ></span>"; ?><input type='number' class="form-control" <?php echo "id='face1" . $no . "'"; ?> value='<?php echo $row_pro['face1_stock_out']; ?>' <?php echo "name='stock1[$product_id][$no][$idx7]'"; ?> onkeyup='keyup("<?= $no ?>")' <?php if ($row_pro['status_delivery'] == 1) {
                                                                                                                                                                                                                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                                                                                                                                                                                                                    } ?>></td>
                                                                            <td class="text-center"> <?php echo "<span id='err2" . $no . "' ></span>"; ?><input type='number' class="form-control" <?php echo "id='face2" . $no . "'"; ?> value='<?php echo $row_pro['face2_stock_out']; ?>' <?php echo "name='stock2[$product_id][$no][$idx8]'"; ?> onkeyup='keyup("<?= $no ?>")' <?php if ($row_pro['status_delivery'] == 1) {
                                                                                                                                                                                                                                                                                                                                                                                        echo "disabled";
                                                                                                                                                                                                                                                                                                                                                                                    } ?>></td>
                                                                            <td class="text-center"> <?php echo "<span id='err3" . $no . "' ></span>"; ?><input type='number' class="form-control" <?php echo "id='total_price" . $no . "'"; ?> value='<?php echo $row_pro['qty_dev']; ?>' readonly></td>
                                                                            <?php
                                                                            // echo "<td class=\"text-center\"><span id='err" . $no . "' ></span><input type='number' class=\"form-control\" id='face1" . $no . "' value='.$row_pro[face1_stock_out].' name='stock1[$product_id][$no][$idx7]' onkeyup='keyup(" . $no . ")'></td>";
                                                                            // echo "<td class=\"text-center\"><span id='err2" . $no . "' ></span><input type='number' class=\"form-control\"id='face2" . $no . "' value='.$row_pro[face2_stock_out].' name='stock2[$product_id][$no][$idx7]'  onkeyup='keyup(" . $no . ")'></td>";
                                                                            // echo "<td class=\"text-center\"><span id='err3" . $no . "' ></span><input type='number' class=\"form-control\" id='total_price" . $no . "' readonly></td>";

                                                                            ?>

                                                                        </tr>
                                                                <?php }
                                                                } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="mt-3 mb-4 border-top"></div>
                                                <div class="d-sm-flex mb-5" data-view="print">
                                                    <span class="m-auto"></span>
                                                    <!-- เงินสด SO  HS   เครดิส  SO  IV   -->
                                                    <?php

                                                    echo "$dev_status+$action";
                                                    if (($dev_status == 1) || ($cf == 'ok')) {
                                                        // echo"$row[cus_type]";
                                                    ?>
                                                        <a class="btn btn-outline-primary m-1" href="/saleorder.php?order_id=<?= $order_id ?>&so_id=<?= $dev_id ?>" type="button" target="_blank">พิมพ์ใบส่งของ(SO)</a>
                                                        <?php if ($row['cus_type'] == 1) { ?>
                                                            <?php
                                                            $sql = "SELECT * FROM delivery  where order_id='$order_id'  ";
                                                            $rsx = $conn->query($sql);
                                                            $rsx = $rsx->fetch_assoc();
                                                            // echo"$rsx[dev_id]";
                                                            if ($rsx['hs_id'] == '0') { ?>
                                                                <button data-toggle="modal" data-target="#medalhs" title="ออกใบเสร็จรับเงิน(HS)" data-id="<?php echo $rsx['id']; ?>" id="add_hs" class="btn btn-outline-primary m-1"> ออกใบเสร็จรับเงิน(HS) </button>
                                                            <?php } else {  ?>
                                                                <a class="btn btn-outline-primary m-1" href="/hs.php?order_id=<?= $order_id ?>&dev_id=<?= $dev_id ?>" type="button" target="_blank">พิมพ์ใบเสร็จรับเงิน(HS)</a>
                                                        <?php }
                                                        } ?>
                                                        <?php if ($row['cus_type'] == 2) { ?> <a class="btn btn-outline-primary m-1" href="/invoice.php" type="button" target="_blank">พิมพ์ใบกำกับสินค้า(IV)</a><?php } ?>
                                                    <?php } else {  ?>
                                                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                                        <input type="hidden" name="action" value="add_dev">
                                                        <button type="submit" id="btu" class="btn btn-outline-primary m-1" name="add-data">บันทึกการส่งของ</span></button>

                                                    <?php } ?>
                                                    <a class="btn btn-outline-danger m-1" href="/ailist.php" type="button">กลับหน้ารายการ Order</a>
                                                </div>

                                            </div>
                                            <!-- ==== / Print Area =====-->
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Header -->
            <?php include './include/footer.php'; ?>
            <!-- =============== Header End ================-->
        </div>
    </div>
   <!-- Modal HS-->
   <div class="modal fade" id="medalhs" tabindex="-1" role="dialog" aria-labelledby="medalconcreteuseTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalconcreteuseTitle-2">ยืนยันการออกใบเสร็จรับเงิน</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div id="dynamic-content2"></div>

                </div>

            </div>
        </div>
    </div>

    <script src="../../dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
    <script src="../../dist-assets/js/plugins/bootstrap.bundle.min.js"></script>
    <script src="../../dist-assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../../dist-assets/js/scripts/script.min.js"></script>
    <script src="../../dist-assets/js/scripts/sidebar-horizontal.script.js"></script>
    <script src="../../dist-assets/js/plugins/echarts.min.js"></script>
    <script src="../../dist-assets/js/scripts/echart.options.min.js"></script>
    <script src="../../dist-assets/js/scripts/dashboard.v1.script.min.js"></script>
    <script src="../../dist-assets/js/scripts/customizer.script.min.js"></script>

</body>
<script>
    function keyup(id) {
        var face1 = $('#face1' + id).val();
        var face2 = $('#face2' + id).val();
        var face1_stock = $('#face1_stock' + id).val();
        var face2_stock = $('#face2_stock' + id).val();
        var qty = $('#qty' + id).val();
        var face1x = Number(face1);
        var face2x = Number(face2);
        var face1x_stock = Number(face1_stock);
        var face2x_stock = Number(face2_stock);
        var qtyx = Number(qty);
        var errid = 'err' + id;
        var status = 'status' + id;
        var errid2 = 'err2' + id;
        var errid3 = 'err3' + id;
        var numx = 1;
        console.log('errid', errid)
        if (face1x_stock < face1x) {

            document.getElementById(errid).innerHTML = "*"

        } else {
            document.getElementById(errid).innerHTML = ""
        }

        if (face2x_stock < face2x) {
            document.getElementById(errid2).innerHTML = "*"

        } else {
            document.getElementById(errid2).innerHTML = ""
        }
        console.log('face1', face1 + face2)
        console.log('status', status)
        total_price = parseFloat(face1) + parseFloat(face2);
        $('#total_price' + id).val(total_price);
        if (total_price > qtyx) {
            document.getElementById(errid3).innerHTML = "*"

        } else {
            document.getElementById(errid3).innerHTML = ""
        }

    }
    $("#dev_date").on("change", function() {

        let dev_date = $("#dev_date").val();
        console.log('btu', dev_date)
        if (dev_date === undefined || dev_date === '') {
            document.getElementById("btu").disabled = true;
        } else {
            document.getElementById("btu").disabled = false;

        }

    });
</script>
<script>
        $(document).ready(function() {

            $(document).on('click', '#add_hs', function(e) {

                e.preventDefault();

                var uid = $(this).data('id'); // get id of clicked row

                $('#dynamic-content2').html(''); // leave this div blank
                $('#modal-loader').show(); // load ajax loader on button click

                $.ajax({
                        url: 'hs_confirm.php',
                        type: 'POST',
                        data: 'id=' + uid,
                        dataType: 'html'
                    })
                    .done(function(data) {
                        console.log(data);
                        $('#dynamic-content2').html(''); // blank before load.
                        $('#dynamic-content2').html(data); // load here
                        $('#modal-loader').hide(); // hide loader  
                    })
                    .fail(function() {
                        $('#dynamic-content2').html(
                            '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                        );
                        $('#modal-loader').hide();
                    });

            });
        });
    </script>
</html>