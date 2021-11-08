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
include './get_dashbord_quotation.php';
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
                    <a class="linkLoadModalNext nav-link active" href="/report_quotation.php">
                        <h4 class="h5 font-weight-bold"> ภาพรวมข้อมูลใบเสนอราคา
                        </h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="linkLoadModalNext nav-link" href="/report_quotation_year.php">
                        <h4 class="h5 font-weight-bold"> รายงานใบเสนอราคารายปี
                        </h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="linkLoadModalNext nav-link" href="/report_qt_date_all.php">
                        <h4 class="h5 font-weight-bold"> รายงานใบเสนอทั้งหมด
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
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title">ใบเสนอราคาประจำปี</div>
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
                                                    <h3 class="ul-widget__head-title">รายการใบเสนอราคาประจำเดือน</h3>
                                                </div>

                                            </div>
                                            <div class="ul-widget__body">
                                                <div class="tab-content">
                                                    <div class="tab-pane active show" id="__d-widget4-tab1-content">
                                                        <div class="ul-widget1">

                                                            <div class="table-responsive">
                                                                <table class="table text-center" id="user_table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">#</th>
                                                                            <th scope="col" class="text-center">วันที่</th>
                                                                            <th scope="col" class="text-right">รายการ</th>
                                                                            <th scope="col" class="text-right">เสนอราคา</th>
                                                                            <th scope="col" class="text-right">ขายสำเร็จ</th>

                                                                            <th scope="col" class="text-right">ข้อมูล</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $sql4 = "SELECT  DATE_FORMAT(quotation.date_create, '%Y-%m-%d') AS DATE  FROM quotation  INNER JOIN   order_details  ON  quotation.order_id=order_details.order_id   AND quotation.date_create  BETWEEN NOW() - INTERVAL 60 DAY  AND NOW() GROUP BY DATE ORDER BY DATE DESC";
                                                                        $result4 = mysqli_query($conn, $sql4);
                                                                        if (mysqli_num_rows($result4) > 0) {
                                                                            while ($row4 = mysqli_fetch_assoc($result4)) {
                                                                                $d = explode("-", $row4['DATE']);
                                                                                $sql_qt_day = "SELECT COUNT(DISTINCT qt_number) AS  date1 FROM quotation  WHERE DAY(date_create)= '$d[2]' AND MONTH(date_create) = '$d[1]' AND YEAR(date_create) = '$d[0]'  ";
                                                                                $rs_qt_day = $conn->query($sql_qt_day);
                                                                                $row_qt_day = $rs_qt_day->fetch_assoc();
                                                                                $sql_qt_sum = "SELECT ROUND(SUM(order_details.total_price), 2) AS sum  FROM quotation  INNER JOIN order_details  ON  quotation.order_id=order_details.order_id AND  DAY(quotation.date_create)= '$d[2]' AND  MONTH(quotation.date_create) = '$d[1]' AND YEAR(quotation.date_create) = '$d[0]' ";
                                                                                $rs_qt_sum  = $conn->query($sql_qt_sum);
                                                                                $row_qt_sum  = $rs_qt_sum->fetch_assoc();

                                                                                $sql_qt_succ = "SELECT ROUND(SUM(deliver_detail.total_price), 2) AS sumx  FROM quotation  INNER JOIN deliver_detail  ON  quotation.order_id=deliver_detail.order_id AND  DAY(quotation.date_create)= '$d[2]' AND  MONTH(quotation.date_create) = '$d[1]' AND YEAR(quotation.date_create) = '$d[0]'  AND deliver_detail.status_cf='1'  ";
                                                                                $rs_qt_succ  = $conn->query($sql_qt_succ);
                                                                                $row_qt_succ  = $rs_qt_succ->fetch_assoc();


                                                                        ?>
                                                                                <tr>
                                                                                    <th scope="row"><?= ++$idx; ?></th>
                                                                                    <td class="text-center">
                                                                                       
                                                                                        <?php $d = explode("-", $row4['DATE']);
                                                                                        $yd = "$d[0]-$d[1]";
                                                                                        $date1 = explode(" ", $row4['DATE']);
                                                                                        $dat1 = datethai2($date1[0]);
                                                                                        echo $dat1;

                                                                                        ?>
                                                                                    </td>

                                                                                    <td class="text-right"><?php echo number_format($row_qt_day['date1'], '0', '.', ',') ?></td>
                                                                                    <td class="text-right"><?php echo number_format($row_qt_sum['sum'], '2', '.', ',') ?></td>
                                                                                    <td class="text-right"><?php echo number_format($row_qt_succ['sumx'], '2', '.', ',') ?></td>

                                                                                    <td class="text-right"><a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="ดูข้อมูลรายวัน" href="/report_qt_date.php?MyDate=<?= $row4['DATE'] ?>">
                                                                                            <i class="i-Check font-weight-bold"></i> </a></td>

                                                                                </tr>
                                                                        <?php }
                                                                        } ?>

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

                            </div>

                        </div>


                    </div><!-- end of main-content -->
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