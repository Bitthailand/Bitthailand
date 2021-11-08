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
    <title>รายงานใบเสนอราคา</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
</head>
<?php
include './include/connect.php';
include './include/config.php';
include './include/config_date2.php';
include './get_dashbord_qt_year.php';
$MyYear = $_REQUEST['MyYear'];
$datex = date($MyYear);
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
                    <a class="linkLoadModalNext nav-link " href="/report_quotation.php">
                        <h4 class="h5 font-weight-bold"> ภาพรวมข้อมูลใบเสนอราคา
                        </h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="linkLoadModalNext nav-link active" href="/report_quotation_year.php">
                        <h4 class="h5 font-weight-bold"> รายงานใบเสนอราคารายปี
                        </h4>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="main-content">
                    <div class="breadcrumb">
                        <h1 class="mr-2">ข้อมูลใบเสนอราคา
                        </h1>
                        <ul>
                            <li><a href="">ภาพรวมใบเสนอราคา</a></li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card mb-4">
                                        <div class="card-body">

                                            <div class="ul-widget__head">
                                                <div class="ul-widget__head-label">
                                                    <h3 class="ul-widget__head-title">รายการใบเสนอราคาแบบรายปี <?= $MyYear ?> </h3>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table text-center" id="user_table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col" class="text-right">เดือน</th>
                                                            <th scope="col" class="text-right">จำนวนใบเสนอราคา</th>
                                                            <th scope="col" class="text-right">มูลค่าใบเสนอราคา</th>
                                                            <th scope="col" class="text-right">ขายสำเร็จ</th>
                                                            <th scope="col" class="text-right">ข้อมูล</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $sql4 = "SELECT DATE_FORMAT(date_create, '%Y-%m') AS MONTH   FROM quotation  WHERE   YEAR(date_create) = '$d[0]'   GROUP BY MONTH  ORDER BY MONTH DESC ";
                                                        $result4 = mysqli_query($conn, $sql4);
                                                        if (mysqli_num_rows($result4) > 0) {
                                                            while ($row4 = mysqli_fetch_assoc($result4)) {
                                                        ?> <tr>
                                                                    <th scope="row"><?= ++$idx; ?></th>
                                                                    <td class="text-right">
                                                                      <?php   $d = explode("-", $row4['MONTH']);
                                                                        $yd = "$d[0]-$d[1]";
                                                                        $date1 = explode(" ", $yd);
                                                                        $dat1 =datethai5($date1[0]);
                                                                        echo $dat1;
                                                                        ?>
                                                                    </td>
                                                                    <?php
                                                                    $datex1 = date($row4['MONTH']);
                                                                    $d1 = explode("-", $datex1);
                                                                    $sql_cus_day = "SELECT COUNT(DISTINCT qt_number) AS sum_qt FROM quotation WHERE   MONTH(date_create) = '$d1[1]' AND YEAR(date_create) = '$d1[0]'  ";
                                                                    $rs_cus_day = $conn->query($sql_cus_day);
                                                                    $row_cus_day = $rs_cus_day->fetch_assoc();
                                                                    $sql_qt = "SELECT ROUND(SUM((order_details.qty-order_details.disunit)*order_details.unit_price), 2) AS sum  FROM quotation  INNER JOIN order_details  ON  quotation.order_id=order_details.order_id AND  MONTH(quotation.date_create) = '$d1[1]' AND YEAR(quotation.date_create) = '$d1[0]'";
                                                                    $rs_qt = $conn->query($sql_qt);
                                                                    $row_qt = $rs_qt->fetch_assoc();
                                                                    $sql_sum = "SELECT ROUND(SUM((deliver_detail.dev_qty-deliver_detail.disunit)*deliver_detail.unit_price), 2) AS sum  FROM quotation  INNER JOIN deliver_detail  ON  quotation.order_id=deliver_detail.order_id AND  MONTH(quotation.date_create) = '$d1[1]' AND YEAR(quotation.date_create) = '$d1[0]'  AND  deliver_detail.status_cf='1' ";
                                                                    $rs_sum = $conn->query($sql_sum);
                                                                    $row_sum = $rs_sum->fetch_assoc();
                                                                    ?>
                                                                    <td class="text-right"><?php echo number_format($row_cus_day['sum_qt'], '0', '.', ',') ?></td>

                                                                    <td class="text-right"><?php echo number_format($row_qt['sum'], '2', '.', ',');
                                                                                            $total_ai = $total_ai + $row_qt['sum']; ?></td>
                                                                    <td class="text-right"><?php echo number_format($row_sum['sum'], '2', '.', ',');
                                                                                            $total = $total + $row_sum['sum']; ?></td>

                                                                    <td class="text-right"><a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="ดูข้อมูลรายเดือน" href="/report_qt_date1.php?MyMonth=<?= $row4['MONTH'] ?>">
                                                                            <i class="i-Check font-weight-bold"></i> </a></td>

                                                                </tr>
                                                        <?php }
                                                        } ?><tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-right"><?php echo number_format($total_ai, '2', '.', ','); ?></td>
                                                            <td class="text-right"><?php echo number_format($total, '2', '.', ','); ?></td>
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