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
include './get_dashbord_quotation_year.php';
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
                                                            <th scope="col" class="text-left">ยอดขายประจำปี</th>
                                                            <th scope="col" class="text-left">จำนวนสินค้า</th>
                                              
                                                            <th scope="col" class="text-left">ข้อมูล</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $sql4 = "SELECT DATE_FORMAT(delivery.dev_date,'%Y') As MyYear ,SUM(deliver_detail.dev_qty) AS qty ,SUM(deliver_detail.unit_price) AS unit_price ,SUM(total_price) AS total  FROM delivery  INNER JOIN  deliver_detail ON delivery.dev_id=deliver_detail.dev_id  
                                                         AND deliver_detail.status_cf='1' AND deliver_detail.payment='1'  GROUP BY MyYear  ORDER BY MyYear  DESC  ";
                                                        $result4 = mysqli_query($conn, $sql4);
                                                        if (mysqli_num_rows($result4) > 0) {
                                                            while ($row4 = mysqli_fetch_assoc($result4)) {
                                                        ?> <tr>
                                                                    <th scope="row"><?= ++$idx; ?></th>
                                                                    <td class="text-left">
                                                                        <?php 
                                                                        $year =$row4['MyYear'] + 543;  ?>
                                                                        <?= $year ?></td>
                                                                    <td class="text-left"><?php echo number_format($row4['total'], '2', '.', ',') ?></td>
                                                                    <td class="text-left"><?php echo number_format($row4['qty'], '0', '.', ',') ?></td>
                                                                    
                                                                    <td class="text-left"><a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="ดูข้อมูลรายเดือน" href="/report_sale_month.php?MyYear=<?= $row4['MyYear'] ?>">
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