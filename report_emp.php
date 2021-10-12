<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
$emp_id=$_SESSION["username"]; 
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
include './get_dashbord_sale.php';
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
                    <a class="linkLoadModalNext nav-link active" href="/report_sale.php">
                        <h4 class="h5 font-weight-bold"> ภาพรวมข้อมูลพนักงาน
                        </h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="linkLoadModalNext nav-link" href="/report_sale_year.php">
                        <h4 class="h5 font-weight-bold"> รายงานข้อมูลพนักงาน
                        </h4>
                    </a>
                </li>

            </ul>
            <div class="tab-content">
                <div class="main-content">

                    <div class="breadcrumb">
                        <h1 class="mr-2">ข้อมูลพนักงาน
                        </h1>
                        <ul>
                            <li><a href="">ภาพรวมพนักงานส่งสินค้า</a></li>
                       
                        </ul>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title">พนักงานส่งสินค้า</div>
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
                                                    <h3 class="ul-widget__head-title">รายการส่งสินค้าประจำเดือน</h3>
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
                                                                            <th scope="col" class="text-right">ลูกค้า</th>
                                                                            <th scope="col" class="text-right">รายการ</th>
                                                                            <th scope="col" class="text-right">ยอดมัดจำ</th>
                                                                            <th scope="col" class="text-right">ยอดขาย</th>
                                                                            <th scope="col" class="text-right">ยอดคืน</th>
                                                                            <th scope="col" class="text-right">ข้อมูล</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $sql4 = "SELECT  DATE_FORMAT(dev_date, '%Y-%m-%d') AS DATE   FROM delivery WHERE  status_chk='1' AND status_payment='1'  AND dev_date  BETWEEN NOW() - INTERVAL 30 DAY AND NOW() GROUP BY DATE ORDER BY DATE DESC";
                                                                        $result4 = mysqli_query($conn, $sql4);
                                                                        if (mysqli_num_rows($result4) > 0) {
                                                                            while ($row4 = mysqli_fetch_assoc($result4)) {
                                                                                $d = explode("-", $row4['DATE']);
                                                                                $sql_cus_day = "SELECT COUNT(DISTINCT cus_id) month FROM delivery  WHERE DAY(dev_date)= '$d[2]' AND MONTH(dev_date) = '$d[1]' AND YEAR(dev_date) = '$d[0]' AND status_chk='1' AND status_payment='1'  ";
                                                                                $rs_cus_day = $conn->query($sql_cus_day);
                                                                                $row_cus_day = $rs_cus_day->fetch_assoc();
                                                                                $sql_dev = "SELECT COUNT(DISTINCT dev_id) dev FROM delivery  WHERE DAY(dev_date)= '$d[2]' AND MONTH(dev_date) = '$d[1]' AND YEAR(dev_date) = '$d[0]' AND status_chk='1' AND status_payment='1'  ";
                                                                                $rs_dev = $conn->query($sql_dev);
                                                                                $row_dev = $rs_dev->fetch_assoc();
                                                                                $sql_sum = "SELECT SUM(deliver_detail.total_price)AS total  FROM deliver_detail
                                                                                INNER JOIN  delivery ON delivery.dev_id=deliver_detail.dev_id  AND
                                                                                DAY(delivery.dev_date)= '$d[2]' AND MONTH(delivery.dev_date) = '$d[1]' AND YEAR(delivery.dev_date) = '$d[0]' AND delivery.status_payment='1' ";
                                                                                $rs_sum = $conn->query($sql_sum);
                                                                                $row_sum = $rs_sum->fetch_assoc();

                                                                                $sql_refun = "SELECT SUM(total_price)AS total  FROM sr_detail WHERE
                                                                                DAY(date_create)= '$d[2]' AND MONTH(date_create) = '$d[1]' AND YEAR(date_create) = '$d[0]' ";
                                                                                $rs_refun = $conn->query($sql_refun);
                                                                                $row_refun = $rs_refun->fetch_assoc();

                                                                                $sql_ai = "SELECT SUM(price)AS total  FROM ai_number  WHERE
                                                                                DAY(date_create)= '$d[2]' AND MONTH(date_create) = '$d[1]' AND YEAR(date_create) = '$d[0]' ";
                                                                                $rs_ai = $conn->query($sql_ai);
                                                                                $row_ai = $rs_ai->fetch_assoc();
                                                                        ?>
                                                                                <tr>
                                                                                    <th scope="row"><?= ++$idx; ?></th>
                                                                                    <td class="text-center">
                                                                                        <?php echo "$row4[DATE]"; ?>
                                                                                    </td>
                                                                                    <td class="text-right"><?php echo number_format($row_cus_day['month'], '0', '.', ',') ?></td>
                                                                                    <td class="text-right"><?php echo number_format($row_dev['dev'], '0', '.', ',') ?></td>
                                                                                    <td class="text-right"><?php echo number_format($row_ai['total'], '2', '.', ',') ?></td>
                                                                                    <td class="text-right"><?php echo number_format($row_sum['total'], '2', '.', ',') ?></td>
                                                                                    <td class="text-right"><?php echo number_format($row_refun['total'], '2', '.', ',') ?></td>
                                                                                    <td class="text-right"><a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="ดูข้อมูลรายวัน" href="/report_sale_date.php?MyDate=<?= $row4['DATE'] ?>">
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