<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>HS | ใบเสร็จรับเงินเลขที่ </title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <!-- <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" /> -->
    <!-- <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" /> -->
    <link href="../../dist-assets/css/themes/styleforprint.css?v=8" rel="stylesheet" />

    <style>
        p {
            margin-top: 0;
            margin-bottom: 0.1rem;
        }

        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
            font-size: 0.813rem !important;
        }
    </style>
</head>
<?php
include './include/config_so.php';
$order_id = $_REQUEST['order_id'];
$so_id = $_REQUEST['so_id'];
$sql5 = "SELECT count(id) AS id_run FROM hs_number  ";
$rs5 = $conn->query($sql5);
$row_run = $rs5->fetch_assoc();
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

    $sqlxxx = "UPDATE delivery  SET hs_id='$hs_id' where dev_id='$so_id'";
    if ($conn->query($sqlxxx) === TRUE) {
    }
}




$sql_hs = "SELECT * FROM delivery  WHERE dev_id= '$so_id' AND order_id='$order_id'";
$rs_hs = $conn->query($sql_hs);
$row_hs = $rs_hs->fetch_assoc();
// echo"$row_hs[id]";
$sql_h = "SELECT * FROM hs_number  WHERE hs_id= '$row_hs[hs_id]' ";
$rs_h = $conn->query($sql_h);
$row_h = $rs_h->fetch_assoc();
?>
<?php
include './include/config.php';
include './include/config_text.php';
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

$sql_emp = "SELECT * FROM employee  WHERE username= '$row[emp_id]'";
$rs_emp = $conn->query($sql_emp);
$row_emp = $rs_emp->fetch_assoc();



// ===
?>

<body class="qt2 text-left">

    <!--  header  -->

    <div class="page-header">
        <div class="col-12 text-right">
            <button class="btn-primary mb-sm-0 mb-3" onclick="window.print()">พิมพ์ใบเสร็จรับเงิน</button>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-6">
                    <h4 class="font-weight-bold">บริษัท วันเอ็ม จำกัด</h4>
                    <p>290 ม.1 ต.กระโสบ อ.เมือง จ.อุบลราชธานี 34000</p>
                    <p>โทร 061-4362825</p>
                    <p>เลขที่ประจำตัวผู้เสียภาษี 0345555000224 สำนักงานใหญ่</p>
                </div>
                <div class="col-6 text-right">
                <h2 class="font-weight-bold">ใบเสร็จรับเงิน/ใบกำกับภาษี</h4>
                </div>
            </div>
            <div class="mt-3 mb-4 border-top"></div>
            <div class="row mb-5">
                <div class="col-8 mb-3 mb-sm-0">
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

                    $sql_dev = "SELECT * FROM delivery  WHERE order_id= '$order_id' AND dev_id='$so_id'";
                    $rs_dev  = $conn->query($sql_dev);
                    $row_dev  = $rs_dev->fetch_assoc();
                    ?>

                    <div class="rowx_cus">
                        <div class="col-4x_slip">
                            <p><strong>ชื่อลูกค้า</strong> </p>
                            <p><strong>ที่อยู่</strong> </p>
                            <p><strong>เลขที่ประจำตัวผู้เสียภาษี </strong> </p>
                            <p><strong>โทร </strong> </p>
                            <p><strong>อ้างอิง</strong> </p>
                            <p><strong>ขนส่งโดย</strong></p>

                        </div>
                        <div class="col-1x">
                            <p>:</p>
                            <p>:</p>
                            <p>:</p>
                            <p>:</p>
                            <p>:</p>
                            <p>:</p>
                            <p></p>
                        </div>
                        <div class="col-4xx_cus">
                            <p><?= $row3['customer_name'] ?></p>
                            <p><?php echo $row3['bill_address'] . " ต." . $row6['name_th'] . "  อ." . $row7['name_th'] . " จ." . $row8['name_th']; ?></p>
                            <p><?php if($row3['tax_number']==''){echo"-";}else{ echo $row3['tax_number']; } ?></p>
                            <p><?= $row3['tel'] ?></p>
                            <p><?= $row3['contact_name'] ?></p>
                        </div>
                    </div>

                </div>
                <div class="col-4 text-sm-right">
                    <div class="rowx">
                        <div class="col-4x_slip1">
                            <p>เลขที่ใบเสร็จรับเงิน </p>
                            <p>วันที่</p>
                            <p>ลำดับการสั่งซื้อ</p>
                            <p>พนักงานขาย </p>
                            <p>เขตการขาย</p>
                        </div>
                        <div class="col-1x">
                            <p>:</p>
                            <p>:</p>
                            <p>:</p>
                            <p>:</p>
                            <p>:</p>
                        </div>

                        <div class="col-4xx_slip">
                            <p><?= $row_hs['hs_id'] ?></p>
                            <p><?php $date = explode(" ", $row_h['date_create']);
                                $dat = datethai2($date[0]);
                                echo "$dat"; ?> </p>
                            
                            <p><?php echo "$row[order_id]"; ?> </p>
                            <p><?= $row_emp['emp_name'] ?> </p>
                        </div>
                    </div>
                </div>


            </div>
            </div>
            </div>
            <!-- End header  -->

            <!-- Footer  -->
            <div class="page-footer">
                <div class="mt-3 mb-4 border-top"></div>
                <div class="col-12">
                    <div class="col-12 mb-3 mb-sm-0">
                        <p>ได้รับสินค้าตามรายการข้างบนนี้ไว้ถูกต้อง และอยู่ในสภาพเรียบร้อยทุกประการ </p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                    <div class="col-4 text-center">
                    <br> <br>
                    <p> ____________________</p>

                    <p>ผู้รับสินค้า/ผู้จ่ายเงิน</p>
                    <br>
                    <p>วันที่ ________/__________/__________ <span></span></p>
                </div>
                        <div class="col-5 text-center">
                    <p>ในนาม บริษัท วันเอ็ม จำกัด</p>
                    <br><br>
                    <p>ผู้รับมอบอำนาจ ____________________ <span></span></p>
                    <br>
                    <p>วันที่ ________/__________/__________ <span></span></p>
                </div>
                    </div>
                </div>
            </div>
            <!-- End Footer  -->

            <!-- Data  -->
            <div class="col-12">
                <table class="print-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <td>
                                <!--place holder for the fixed-position header-->
                                <div class="page-header-space"></div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="page">
                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table class="table table-hover mb-4">
                                                <thead class="bg-gray-300">
                                                    <tr>
                                                        <th scope="col" class="text-center">ลำดับ</th>
                                                        <th scope="col" class="text-left">รหัสสินค้า/รายละเอียด</th>
                                                        <th scope="col" class="text-right">จำนวน</th>
                                                        <th scope="col" class="text-right">หน่วยละ</th>
                                                     
                                                        <th scope="col" class="text-right">ราคารวมภาษี</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql_pro = "SELECT * FROM deliver_detail  where order_id='$order_id'  AND dev_id='$so_id'   AND ptype_id <> 'TF' order by date_create DESC ";
                                                    $result_pro = mysqli_query($conn, $sql_pro);
                                                    if (mysqli_num_rows($result_pro) > 0) {
                                                        while ($row_pro = mysqli_fetch_assoc($result_pro)) {
                                                            $no = $row_pro['id'];
                                                            $product_id = $row_pro['product_id'];
                                                    ?>
                                                            <tr>
                                                                <td scope="row" class="text-center"><?= ++$id; ?></td>
                                                                <td><?php
                                                                    $sqlx3 = "SELECT * FROM product  WHERE product_id= '$row_pro[product_id]'";
                                                                    $rsx3 = $conn->query($sqlx3);
                                                                    $rowx3 = $rsx3->fetch_assoc();
                                                                    if ($rowx3['ptype_id'] == 'TF0') {
                                                                        echo 'ค่าขนส่ง:' . $rowx3['product_name'];
                                                                    } else {
                                                                        echo $rowx3['product_name'];
                                                                    }
                                                                    $sql_unit = "SELECT * FROM unit  WHERE id= '$rowx3[units]' ";
                                                                    $rs_unit = $conn->query($sql_unit);
                                                                    $row_unit = $rs_unit->fetch_assoc();
                                                                    ?></td>
                                                                <td class="text-right"><?= $row_pro['dev_qty'] ?> <?= $row_unit['unit_name'] ?></td>
                                                                
                                                                
                                                                    <?php $total_dis = $row_pro['unit_price'] - $row_pro['disunit']; ?>
                                                                    <td class="text-right"><?= $total_dis ?></td>
                                                               
                                                                <td class="text-right"><?php $sum_total = $row_pro['dev_qty'] * $total_dis; ?>
                                                                    <?php echo number_format($sum_total, '2', '.', ',');
                                                                    $total_all = $total_all + $sum_total;
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                    <?php }
                                                    } ?> <?php
                                                    $result_count = mysqli_query($conn, "SELECT COUNT(*) As total  FROM deliver_detail where order_id='$order_id'  AND dev_id='$so_id' AND ptype_id='TF'  ");
                                                    $count = mysqli_fetch_array($result_count);
                                                    $countx = $count['total'];
                                                    if ($countx > 0) {
                                                    ?>
                                                        <tr>
                                                            <td scope="row" class="text-center"><?= ++$id; ?></td>
    
                                                            <?php
                                                            $sqlx3 = "SELECT * FROM deliver_detail  where order_id='$order_id'  AND dev_id='$so_id' AND ptype_id='TF' ";
                                                            $rsx3 = $conn->query($sqlx3);
                                                            $rowx3 = $rsx3->fetch_assoc();
                                                            ?>
                                                            <td>
                                                           
                                                                <?php
                                                                $sqlx31 = "SELECT * FROM product  WHERE product_id= '$rowx3[product_id]'";
                                                                $rsx31 = $conn->query($sqlx31);
                                                                $rowx31 = $rsx31->fetch_assoc();
                                                                
                                                                echo 'ค่าจัดส่ง' . '(' . $rowx31['product_name'] . ')';
                                                                
                                                                $sql_unit = "SELECT * FROM unit  WHERE id= '$rowx31[units]' ";
                                                                $rs_unit = $conn->query($sql_unit);
                                                                $row_unit = $rs_unit->fetch_assoc();
                                                                ?></td>
                                                            <td class="text-right"><?= $rowx3['dev_qty'] ?>  <?= $row_unit['unit_name'] ?></td>
                                                           
                                                            <?php $sum_tf=$rowx3['unit_price'] * $rowx3['dev_qty'];
                                                            $total_all=$total_all+$sum_tf;
                                                            ?>
                                                            <td class="text-right"> <?php echo number_format($rowx3['unit_price'], '2', '.', ','); ?></td>
                                                            <td class="text-right"> <?php echo number_format($sum_tf, '2', '.', ','); ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-6">

                                        </div>
                                        <div class="col-2">

                                        </div>
                                        <div class="col-3">
                                            <p>รวมเป็นเงิน</p>
                                            <p>หัก ส่วนลด</p>
                                            <p>ยอดหลังหักส่วนลด</p>
                                            <p>หักเงินมัดจำ </p>
                                            <p>จำนวนเงินรวมทั้งสิ้น</p>
                                            <p>จำนวนภาษีมูลค่าเพิ่ม 7%</p>
                                        </div>
                                        <div class="col-1">
                                            <div class="invoice-summary-qt2">
                                                <?php
                                                $sql_ai = "SELECT * FROM delivery  WHERE id= '$so_id' AND order_id='$order_id' ";
                                                $rs_ai = $conn->query($sql_unit);
                                                $row_ai = $rs_unit->fetch_assoc();

                                                ?>
                                                <p> <span><?php echo number_format($total_all, '2', '.', ',') ?></span></p>
                                                <p> <span>00.00</span></p>
                                                <p> <span><?php echo number_format($total_all, '2', '.', ',') ?></span></p>

                                                <?php echo number_format($row_ai['ai_count'], '2', '.', ',') ?></p>
                                                <?php
                                                $total = $total_all - $row_ai['ai_count'];
                                                $tax = ($total * 100) / 107;
                                                $tax2 = ($total - $tax);
                                                $grand_total = ($total - $tax2);
                                                ?>
                                                <p> <span> <?php echo number_format($total, '2', '.', ',') ?></span></p>
                                                <p> <span><?php echo number_format($tax2, '2', '.', ',') ?></span></p>

                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-3">
                                                    <p>ตัวอักษร :</p>
                                                </div>
                                                <div class="col-5">
                                                    <p><?php echo Convert2($total); ?></p>
                                                </div>
                                                <div class="col-3">
                                                    <p>รวมเป็นเงิน</p>
                                                </div>
                                                <div class="col-1 text-right">
                                                    <div class="row" style="justify-content: flex-end; margin-right: 0;">

                                                        <h3 class="font-weight-bold" style="width: 120px; display: inline-block;">
                                                            <span><?php echo number_format($grand_total, '2', '.', ',') ?></span>
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!-- <div class="page">PAGE 2</div> -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- End Data  -->


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

</html>