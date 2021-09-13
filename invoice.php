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
    <title>IV | ใบกำกับสินค้า</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <!-- <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" /> -->
    <!-- <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" /> -->
    <link href="../../dist-assets/css/themes/styleforprint.css?v=2" rel="stylesheet" />


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
include './include/config.php';
include './include/config_text.php';
$order_id = $_REQUEST['order_id'];
$so_id = $_REQUEST['so_id'];
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


$sql_dev = "SELECT * FROM delivery WHERE dev_id= '$so_id'";
$rs_dev = $conn->query($sql_dev);
$row_dev = $rs_dev->fetch_assoc();

?>

<body class="qt2 text-left">

    <!--  header  -->

    <div class="page-header">
        <div class="col-12 text-right">
            <button class="btn-primary mb-sm-0 mb-3" onclick="window.print()">พิมพ์ใบกำกับสินค้า</button>
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
                    <h4 class="font-weight-bold">ใบกำกับสินค้า/ใบกำกับภาษี</h4>
                </div>
            </div>

            <div class="mt-3 mb-4 border-top"></div>
            <div class="row mb-5">
                <div class="col-6 mb-3 mb-sm-0">
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
                    if($row3['province']==1){ $t='แขวง'; $a=''; }else{ $t='ต.'; $a='อ.';  }

                    ?>
                    <h5 class="font-weight-bold">ลูกค้า</h5>
                    <p><strong>ชื่อลูกค้า : </strong><?= $row3['customer_name'] ?></p>
                    <p><strong>บริษัท : </strong><?= $row3['company_name'] ?></p>
                    <p><strong>ที่อยู่ :
                        </strong><?php echo $row3['bill_address'] . " $t" . $row6['name_th'] . "  $a" . $row7['name_th'] . " จ." . $row8['name_th']; ?>
                    </p>
                    <p>เลขที่ประจำตัวผู้เสียภาษี <?= $row3['tax_number'] ?></p>
                    <p><strong>โทร : </strong> <?= $row3['tel'] ?></p>
                    <p><strong>อ้างอิง : </strong><?= $row3['contact_name'] ?></p>
                    <p>ขนส่งโดย : </p>
                </div>
                <div class="col-6 text-sm-right">
                    <h5 class="font-weight-bold"></h5>
                    <div class="invoice-summary">
                        <p><span>เลขที่ใบกำกับ</span> <span><?= $row_dev['iv_id'] ?></span></p>
                        <p><span>วันที่ </span><span><?php $date = explode(" ", $row_dev['dev_date']);
                                                        $dat = datethai2($date[0]);
                                                        echo "$dat"; ?></span></p>
                        <p><span>เครดิต วัน ครบกำหนด</span><span><?php $date = explode(" ", $row_dev['date_end']);
                                                                    $dat = datethai2($date[0]);
                                                                    echo "$dat"; ?></span></p>
                        <p><span>เลขที่ใบสั่งขาย </span><span><?= $order_id ?></span></p>
                        <p><span>พนักงานขาย </span><span>-</span></p>
                        <p><span>เขตการขาย </span><span>-</span></p>
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
                <div class="col-6">
                    <p></p>
                    <br>
                    <p><span></span></p>
                    <br>
                    <p>ผู้รับสินค้า/ผู้จ่ายเงิน ________________________ <span>วันที่ ____/_____/_____</span></p>
                </div>
                <div class="col-6 text-center">
                    <p>ในนาม บริษัท วันเอ็ม จำกัด</p>
                    <br>
                    <p> ผู้รับมอบอำนาจ _____________________ <span></span></p>
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
                                                <th scope="col" class="text-center">No.</th>
                                                <th scope="col" class="text-center">รหัสสินค้า/รายละเอียด</th>
                                                <th scope="col" class="text-center">จำนวน</th>
                                                <th scope="col" class="text-center">หน่วยละ</th>
                                                <th scope="col" class="text-center">ส่วนลดต่อหน่วย</th>
                                                <th scope="col" class="text-center">ราคารวมภาษี</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql_pro = "SELECT * FROM deliver_detail  where order_id='$order_id'  AND dev_id='$so_id' order by product_id ASC ";
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
                                                            ?></td>
                                                        <td class="text-right"><?= $row_pro['dev_qty'] ?></td>
                                                        <td class="text-right"><?= $rowx3['unit_price'] ?></td>
                                                        <td class="text-right"><?= $row_pro['disunit'] ?>
                                                            <?php $total = $rowx3['unit_price'] - $row_pro['disunit']; ?>
                                                        </td>
                    </td>
                    <td class="text-right"><?php $sum_total = $row_pro['dev_qty'] * $total; ?>
                        <?php echo number_format($sum_total, '2', '.', ',') ?>

                        <?php $g = $g + $sum_total; ?>
                    </td>
                </tr>
        <?php }
                                            } ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <?php
        $sqlx4 = "SELECT ROUND(SUM(unit_price*dev_qty)) AS total FROM deliver_detail   where order_id='$order_id'  AND dev_id='$so_id' ";
        $rsx4 = $conn->query($sqlx4);
        $rowx4 = $rsx4->fetch_assoc();
        $sql_ai = "SELECT *  FROM ai_number  where order_id='$order_id'  ";
        $rs_ai  = $conn->query($sql_ai);
        $row_ai  = $rs_ai->fetch_assoc();
        $sql_dev = "SELECT *  FROM delivery  where order_id='$order_id' AND dev_id='$so_id' ";
        $rs_dev  = $conn->query($sql_dev);
        $row_dev  = $rs_dev->fetch_assoc();
        ?>
        <div class="invoice-summary">
            <p>รวมเป็นเงิน <span><?php echo number_format($g, '2', '.', ',') ?></span></p>
            <p>หัก ส่วนลด <span>00.00</span></p>
            <p>ยอดหลังหักส่วนลด <span><?php echo number_format($g, '2', '.', ',') ?></span></p>
            <?php if ($row_ai['ai_num'] == '') {
                $total = $g;
            } else { ?>
                <p>หักเงินมัดจำ #<?= $row_ai['ai_num'] ?> <span>
                        <?php echo number_format($row_dev['ai_count'], '2', '.', ',') ?></span></p>
            <?php }
            $total = $g - $row_dev['ai_count'];
            $tax = ($total * 100) / 107;
            $tax2 = ($total - $tax);
            $grand_total = ($total - $tax2);
            ?>
            <p> <span> 0.00</span></p>
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
                <p>ราคาสินค้า</p>
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