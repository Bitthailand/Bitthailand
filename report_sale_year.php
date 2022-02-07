<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
$emp_id = $_SESSION["username"];
?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>รายงานยอดขาย</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
</head>
<?php
include './include/connect.php';
include './include/config.php';
include './get_dashbord_sale_year.php';
$datex = date('Y-m-d');
$d = explode("-", $datex);

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
            <!-- ============ Tab Menu ============= -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="linkLoadModalNext nav-link " href="/report_sale.php">
                        <h4 class="h5 font-weight-bold"> ภาพรวมข้อมูลยอดขาย
                        </h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="linkLoadModalNext nav-link active" href="/report_sale_year.php">
                        <h4 class="h5 font-weight-bold"> รายงานยอดขายรายปี
                        </h4>
                    </a>
                </li>

            </ul>
            <div class="tab-content">
                <div class="main-content">

                    <div class="breadcrumb">
                        <h1 class="mr-2">ข้อมูลยอดขาย
                        </h1>
                        <ul>
                            <li><a href="">ภาพรวมยอดขาย</a></li>

                        </ul>
                    </div>



                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title">ยอดขายประจำปี</div>
                                    <div id="echartBar" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card mb-4">
                                        <div class="card-body">

                                            <div class="ul-widget__head">
                                                <div class="ul-widget__head-label">
                                                    <h3 class="ul-widget__head-title">รายการสั่งผลิตสินค้าแบบรายปี</h3>
                                                </div>

                                            </div>


                                            <div class="table-responsive">
                                                <table class="table text-center" id="user_table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col" class="text-left">ปี</th>
                                                            <th scope="col" class="text-right">ลูกค้า</th>
                                                            <th scope="col" class="text-right">รายการ</th>
                                                            <th scope="col" class="text-right">ยอดมัดจำ</th>
                                                            <th scope="col" class="text-right">จ่ายเต็ม</th>
                                                            <th scope="col" class="text-right">ยอดเครดิต</th>
                                                            <th scope="col" class="text-right">ส่วนลด</th>
                                                            <th scope="col" class="text-right">ยอดขาย</th>
                                                            <th scope="col" class="text-right">หักมัดจำ</th>
                                                            <th scope="col" class="text-right">หักจ่ายเต็ม</th>
                                                            <th scope="col" class="text-right">ยอดรวม</th>
                                                            <th scope="col" class="text-right">ยอดคืน</th>
                                                            <th scope="col" class="text-right">เงินสด</th>
                                                            <th scope="col" class="text-left">ข้อมูล</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $sql4 = "SELECT DATE_FORMAT(delivery.dev_date,'%Y') As MyYear ,SUM(discount) AS discount ,SUM(pay_full) AS pay_full   FROM delivery  WHERE    status_chk='1' AND status_payment='1'   GROUP BY MyYear ORDER BY MyYear  DESC ";
                                                        $result4 = mysqli_query($conn, $sql4);
                                                        if (mysqli_num_rows($result4) > 0) {
                                                            while ($row4 = mysqli_fetch_assoc($result4)) {
                                                        ?> <tr>
                                                                    <th scope="row"><?= ++$idx; ?></th>
                                                                    <td class="text-left">
                                                                        <?php
                                                                        $year = $row4['MyYear'] + 543;  ?>
                                                                        <?= $year ?></td>


                                                                    <?php
                                                                    $datex1 = date($row4['MyYear']);
                                                                    $d1 = explode("-", $datex1);
                                                                    $sql_cus_day = "SELECT COUNT(DISTINCT cus_id) AS month FROM delivery  WHERE   YEAR(dev_date) = '$d1[0]' AND status_chk='1' AND status_payment='1'  ";
                                                                    $rs_cus_day = $conn->query($sql_cus_day);
                                                                    $row_cus_day = $rs_cus_day->fetch_assoc();

                                                                    $sql_dev = "SELECT COUNT(DISTINCT dev_id) AS dev FROM delivery  WHERE  YEAR(dev_date) = '$d1[0]' AND status_chk='1' AND status_payment='1'  ";
                                                                    $rs_dev = $conn->query($sql_dev);
                                                                    $row_dev = $rs_dev->fetch_assoc();

                                                                    $sql_ai = "SELECT SUM(price)AS total  FROM ai_number  WHERE   YEAR(date_create) = '$d1[0]'  AND aix_status = '0'   ";
                                                                    $rs_ai = $conn->query($sql_ai);
                                                                    $row_ai = $rs_ai->fetch_assoc();
                                                                    // จ่ายเต็ม
                                                                    $sql_pay = "SELECT SUM(price)AS totalx  FROM ai_number  WHERE  YEAR(date_create) = '$d1[0]'  AND aix_status = '1' AND pay_full='1'  ";
                                                                    $rs_pay = $conn->query($sql_pay);
                                                                    $row_pay = $rs_pay->fetch_assoc();
                                                                    // 
                                                                    $sql_sum3 = "SELECT SUM(deliver_detail.total_price) AS total  FROM delivery  INNER JOIN deliver_detail  ON  delivery.order_id=deliver_detail.order_id AND   YEAR(delivery.date_create) = '$d1[0]'  AND delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='2'  AND delivery.dev_id=deliver_detail.dev_id  ";
                                                                    $rs_sum3 = $conn->query($sql_sum3);
                                                                    $row_sum3 = $rs_sum3->fetch_assoc();

                                                                    $sql_sum = "SELECT SUM(deliver_detail.total_price) AS total  FROM delivery  INNER JOIN deliver_detail  ON  delivery.order_id=deliver_detail.order_id AND   YEAR(delivery.dev_date) = '$d1[0]'   AND delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.dev_id=deliver_detail.dev_id   AND delivery.cus_type='1' ";
                                                                    $rs_sum = $conn->query($sql_sum);
                                                                    $row_sum = $rs_sum->fetch_assoc();

                                                                    $sql_sum1 = "SELECT SUM(ai_number.price) AS price   FROM delivery  where  YEAR(delivery.dev_date) = '$d1[0]'  AND  ai_number.aix_status = '0' AND   delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='1' ";
                                                                    $rs_sum1 = $conn->query($sql_sum1);
                                                                    $row_sum1 = $rs_sum1->fetch_assoc();
                                                                    $sql_sum4 = "SELECT SUM(delivery.ai_count) AS ai_count FROM delivery  INNER JOIN ai_number  ON  delivery.order_id=ai_number.order_id AND   YEAR(delivery.dev_date) = '$d1[0]'   AND delivery.ai_status = '1' AND   delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='1'";
                                                                    $rs_sum4 = $conn->query($sql_sum4);
                                                                    $row_sum4 = $rs_sum4->fetch_assoc();

                                                                    $sumx_ai = $row_sum4['ai_count'];

                                                                    $sql_refun = " SELECT SUM(price_refun)AS total  FROM  sr_number  WHERE status_refun='1' AND     YEAR(date_create) = '$d1[0]' ";
                                                                    $rs_refun = $conn->query($sql_refun);
                                                                    $row_refun = $rs_refun->fetch_assoc();
                                                                    ?>
                                                                    <td class="text-right"><?php echo number_format($row_cus_day['month'], '0', '.', ',');
                                                                                            $cus = $cus + $row_cus_day['month']; ?></td>
                                                                    <td class="text-right"><?php echo number_format($row_dev['dev'], '0', '.', ',');
                                                                                            $dev = $dev + $row_dev['dev']; ?></td>
                                                                    <td class="text-right"> <?php echo number_format($row_ai['total'], '2', '.', ',');
                                                                                            $total_ai = $total_ai + $row_ai['total'];  ?></a></td>
                                                                    <td class="text-right"> <?php echo number_format($row_pay['totalx'], '2', '.', ',');
                                                                                            $total_ai2 = $total_ai2 + $row_pay['totalx'];  ?></a></td>
                                                                    <td class="text-right"><?php echo number_format($row_sum3['total'], '2', '.', ',');
                                                                                            $total3 = $total3 + $row_sum3['total'];  ?></td>
                                                                    <td class="text-right"><?php echo number_format($row4['discount'], '2', '.', ',');
                                                                                            $total_discount = $total_discount + $row4['discount']; ?></td>
                                                                    <td class="text-right"><?php $sum_total = $row_sum['total'] - $row4['discount'];
                                                                                            echo number_format($sum_total, '2', '.', ',');
                                                                                            $total = $total + $sum_total; ?></td>
                                                                    <td class="text-right"><?php echo number_format($sumx_ai, '2', '.', ',');
                                                                                            $sum2 = $sum2 + $sumx_ai; ?></td>
                                                                    <td class="text-right"><?php echo number_format($row4['pay_full'], '2', '.', ',');
                                                                                            $sum_pay = $sum_pay + $row4['pay_full']; ?></td>
                                                                    <td class="text-right"><?php $sum_ai = $sum_total - $sumx_ai - $row4['pay_full'];
                                                                                            echo number_format($sum_ai, '2', '.', ',');
                                                                                            $sum3 = $sum3 + $sum_ai;  ?></td>

                                                                    <td class="text-right"><?php echo number_format($row_refun['total'], '2', '.', ',');
                                                                                            $sum4 = $sum4 + $row_refun['total']; ?></td>
                                                                    <td class="text-right"><?php $money_in = $sum_ai + $row_ai['total'] +$row_pay['totalx']+ $row_sum3['total'] - $row_refun['total'];
                                                                                            echo number_format($money_in, '2', '.', ',');
                                                                                            $sum5 = $sum5 + $money_in; ?></td>

                                                                    <td class="text-left"><a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="ดูข้อมูลรายเดือน" href="/report_sale_month.php?MyYear=<?= $row4['MyYear'] ?>">
                                                                            <i class="i-Check font-weight-bold"></i> </a></td>
                                                                </tr>
                                                        <?php }
                                                        } ?>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-right"><?php echo number_format($cus, '0', '.', ','); ?></td>
                                                            <td class="text-right"><?php echo number_format($dev, '0', '.', ','); ?></td>
                                                            <td class="text-right"><?php echo number_format($total_ai, '2', '.', ','); ?></td>
                                                            <td class="text-right"><?php echo number_format($total_ai2, '2', '.', ','); ?></td>
                                                            <td class="text-right"><?php echo number_format($total3, '2', '.', ','); ?></td>
                                                            <td class="text-right"><?php echo number_format($total_discount, '2', '.', ','); ?></td>
                                                            <td class="text-right"><?php echo number_format($total, '2', '.', ','); ?></td>
                                                            <td class="text-right"><?php echo number_format($sum2, '2', '.', ','); ?></td>
                                                            <td class="text-right"><?php echo number_format($sum_pay, '2', '.', ','); ?></td>
                                                            <td class="text-right"><?php echo number_format($sum3, '2', '.', ','); ?></td>
                                                            <td class="text-right"><?php echo number_format($sum4, '2', '.', ','); ?></td>
                                                            <td class="text-right"><?php echo number_format($sum5, '2', '.', ','); ?></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
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
        <script src="../../dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
        <script src="../../dist-assets/js/plugins/bootstrap.bundle.min.js"></script>
        <script src="../../dist-assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="../../dist-assets/js/scripts/script.min.js"></script>
        <script src="../../dist-assets/js/scripts/sidebar-horizontal.script.js"></script>
        <script src="../../dist-assets/js/plugins/echarts.min.js"></script>
        <script src="../../dist-assets/js/scripts/echart.options.min.js"></script>
        <script src="../../dist-assets/js/scripts/dashboard.v1.script.min.js?id=1"></script>
        <script src="../../dist-assets/js/scripts/customizer.script.min.js"></script>
        <script src="../../dist-assets/js/plugins/apexcharts.min.js"></script>
        <script src="../../dist-assets/js/plugins/apexcharts.dataseries.min.js"></script>
        <script src="../../dist-assets/js/scripts/apexChart.script.min.js"></script>
</body>

</html>