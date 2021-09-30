<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
$emp_id=$_SESSION["username"]; 
include './include/connect.php';
include './include/config_date2.php';
include './include/config_text.php';

$order_id = $_REQUEST['order_id'];
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
$sql4 = "SELECT * FROM employee  WHERE username= '$row[emp_id]'";
$rs4 = $conn->query($sql4);
$row4 = $rs4->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>ใบรับเงินมัดจำ | ใบกำกับภาษี</title>
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

<body class="qt2 text-left">
    <!--  header  -->
    <div class="page-header">
        <div class="col-12 text-right">
            <button class="btn-primary mb-sm-0 mb-3" onclick="window.print()">พิมพ์ใบเสนอราคา</button>
        </div>

        <div class="row">
            <div class="col-6">
                <h4 class="font-weight-bold">บริษัท วันเอ็ม จำกัด</h4>
                <p>290 ม.1 ต.กระโสบ อ.เมือง จ.อุบลราชธานี 34000</p>
                <p>โทร 061-4362825</p>
                <p>เลขที่ประจำตัวผู้เสียภาษี 0345555000224 สำนักงานใหญ่</p>
            </div>
            <div class="col-6 text-right">
                <h4 class="font-weight-bold">ใบรับเงินมัดจำ/ใบกำกับภาษี</h4>
            </div>
        </div>
        <div class="mt-3 mb-4 border-top"></div>
        <div class="row mb-5">
            <div class="col-6 mb-3 mb-sm-0">
                <h5 class="font-weight-bold">ลูกค้า</h5>
                <p><strong>ชื่อลูกค้า : </strong><?= $row3['customer_name'] ?></p>
                <!-- <p><strong>บริษัท : </strong><?= $row3['company_name'] ?></p> -->
                <p><strong>ที่อยู่ : </strong><?= $row3['bill_address'] ?> </p>
                <p>เลขที่ประจำตัวผู้เสียภาษี <?= $row3['tax_number'] ?></p>
                <p><strong>โทร : </strong> <?= $row3['tel'] ?></p>
                <p><strong>อ้างอิง : </strong><?= $row3['contact_name'] ?></p>
            </div>
            <div class="col-6 text-sm-right">
                <h5 class="font-weight-bold"></h5>
                <div class="invoice-summary">
                    <p><span>เลขที่ </span><span> <?=$row['ai_id']?></span></p>
                    <p><span>วันที่ </span><span> <?php $date=explode(" ",$row['ai_date_start'] ); $dat=datethai4($date[0]);
                                                        echo"$dat";?></span></p>
                    <p><span>วันที่ครบกำหนด </span><span> <?php $date=explode(" ",$row['ai_date_end'] ); $dat=datethai4($date[0]);
                                                        echo"$dat";?></span></p>
                    <p><span>พนักงานขาย : </span><span> <?=$row4['emp_name']?></span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- end  header  -->
    <!-- Footer  -->
    <div class="page-footer">
        <div class="mt-3 mb-4 border-top"></div>
        <div class="col-12">
            <div class="row">
                <p>การชำระเงินด้วยเช็คจะสมบูรณ์เมื่อบริษัทได้รับเงินตามเช็คเรียบร้อย </p>
                <p></p>
            </div>
            <div class="row">
                <div class="col-3">
                    <p></p>
                    <br>
                    <p>เงินสด _______________</p>
                </div>
                <div class="col-3">
                    <p></p>
                    <br>
                </div>
                <div class="col-3">
                    <p></p>
                    <br>
                </div>
                <div class="col-3">
                    <p></p>
                    <br>

                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <p></p>
                    <br>
                    <p>โอนเข้าบัญชี _______________<span></span></p>
                    <br>
                    <p>เช็คธนาคาร ________________ <span></span></p>
                </div>
                <div class="col-3">
                    <p></p>
                    <br>
                    <p>เลขที่ _______________<span></span></p>
                    <br>
                    <p>เช็คเลขที่ ________________ <span></span></p>
                </div>
                <div class="col-3">
                    <p></p>
                    <br>
                    <p>ลงวันที่ _____/______/______ <span></span></p>
                    <br>
                    <p>ลงวันที่ _____/______/______ <span></span></p>
                </div>
                <div class="col-3">
                    <p></p>
                    <br>
                    <p>จำนวนเงิน __________________ <span></span></p>
                    <br>
                    <p>จำนวนเงิน __________________ <span></span></p>
                </div>
            </div>
        </div>
        <div class="mt-3 mb-4 border-top"></div>
        <div class="col-12">
            <div class="row">
                <div class="col-4 text-center">
                    <p> ____________________</p>
                    <br>
                    <p>ผู้อนุมัติ<span></span></p>
                    <br>
                    <p>วันที่ ________/__________/__________ <span></span></p>
                </div>
                <div class="col-3"></div>
                <div class="col-5 text-center">
                    <p>ในนาม บริษัท วันเอ็ม จำกัด</p>
                    <br>
                    <p>ผู้รับมอบอำนาจ ____________________ <span></span></p>
                    <br>
                    <p>วันที่ ________/__________/__________ <span></span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer  -->
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
                                                <th scope="col" class="text-center">รายการ</th>
                                                <th scope="col" class="text-center">ราคารวมภาษี</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                        $sql_pro = "SELECT * FROM ai_number   where order_id='$row[order_id]' AND ai_num='$row[ai_id]' order by date_create  ASC ";
                                                        $result_pro = mysqli_query($conn, $sql_pro);
                                                        if (mysqli_num_rows($result_pro) > 0) {
                                                            while ($rowx = mysqli_fetch_assoc($result_pro)) { ?>
                                            <tr>
                                                <th scope="row" class="text-center"><?=++$id;?></th>
                                                <td><?=$rowx['messages']?></td>
                                                <td class="text-right"><?php echo number_format($rowx['price'], '2', '.', ',') ?></td>
                                            </tr>
                                            <?php }}  ?>
                                            <tr>
                                                <th scope="row" class="text-center"></th>
                                                <td></td>
                                                <td class="text-right"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-6">

                                </div>
                                <div class="col-2">

                                </div>
                                <div class="col-3">
                                    <p>ราคาสินค้า</p>
                                    <p>จำนวนภาษีมูลค่าเพิ่ม 7.00% </p>
                                </div>
                                <div class="col-1">
                                    <div class="invoice-summary-qt2">
                                        <?php  ?>

                                        <?php $tax = ($row['ai_count']* 100)/107;
                                                                $tax2 = ($row['ai_count'] - $tax);
                                                            $grand_total = ($row['ai_count']- $tax2);
                                                          ?>
                                        <p> <span><?php echo number_format($grand_total, '2', '.', ',') ?></span></p>
                                        <p><span><?php echo number_format($tax2, '2', '.', ',') ?></span></p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-3">
                                            <p>ตัวอักษร :</p>
                                        </div>
                                        <div class="col-5">
                                            <p><?php echo Convert2($row['ai_count']); ?></p>
                                        </div>
                                        <div class="col-3">
                                            <p>จำนวนเงินรวมทั้งสิ้น</p>
                                        </div>
                                        <div class="col-1 text-right">
                                            <div class="row" style="justify-content: flex-end; margin-right: 0;">

                                                <h3 class="font-weight-bold" style="width: 120px; display: inline-block;">
                                                    <span><?php echo number_format($row['ai_count'], '2', '.', ',') ?></span>
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
    <div class="app-admin-wrap layout-horizontal-bar">



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

</html>