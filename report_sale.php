<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}

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
include './get_dashbord.php';
$datex = date('Y-m-d');
$d = explode("-", $datex);
$sql_pday = "SELECT count(production_detail.product_id) AS today FROM production_order INNER JOIN production_detail ON production_order.po_id=production_detail.po_id AND 
production_order.po_enddate LIKE  '$datex%'  ";
$rs_pday = $conn->query($sql_pday);
$row_pday = $rs_pday->fetch_assoc();

$sql_pdaycf = "SELECT count(production_detail.product_id) AS today FROM production_order INNER JOIN production_detail ON production_order.po_id=production_detail.po_id AND 
production_order.po_enddate LIKE  '$datex%' AND production_detail.status_stock='0'  ";
$rs_pdaycf = $conn->query($sql_pdaycf);
$row_pdaycf = $rs_pdaycf->fetch_assoc();

$sql_pdaycf1 = "SELECT count(production_detail.product_id) AS today FROM production_order INNER JOIN production_detail ON production_order.po_id=production_detail.po_id AND 
production_order.po_enddate LIKE  '$datex%' AND production_detail.status_stock='1'  ";
$rs_pdaycf1 = $conn->query($sql_pdaycf1);
$row_pdaycf1 = $rs_pdaycf1->fetch_assoc();

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
                    <a class="linkLoadModalNext nav-link active" href="/report_production.php">
                        <h4 class="h5 font-weight-bold"> ภาพรวมข้อมูลสั่งผลิต
                        </h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="linkLoadModalNext nav-link" href="/report_production_year.php">
                        <h4 class="h5 font-weight-bold"> รายงานยอดผลิตรายปี
                        </h4>
                    </a>
                </li>

            </ul>
            <div class="tab-content">
                <div class="main-content">

                    <div class="breadcrumb">
                        <h1 class="mr-2">ข้อมูลสั่งผลิตสินค้า
                        </h1>
                        <ul>
                            <li><a href="">ภาพรวมการผลิต</a></li>
                            <li>มูลค่าการผลิต</li>
                        </ul>
                    </div>
                    <div class="row">
                        <!-- ICON BG-->
                        <div class="col-md-3 col-lg-3">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="ul-widget__row">
                                        <div class="ul-widget-stat__font"><i class="i-Money-2 text-success"></i></div>
                                        <div class="ul-widget__content">
                                            <p class="m-0">สินค้าผลิตเสร็จประจำวันนี้</p>
                                            <h4 class="heading"><?php echo number_format($row_pday['today'], '0', '.', ',') ?> รายการ</h4>
                                            <small class="text-muted m-0">รอดำเนินการ : <?= $row_pdaycf['today'] ?>|นำเข้าสต็อก:<?= $row_pdaycf1['today'] ?> </small>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="ul-widget__row">
                                        <div class="ul-widget-stat__font"><i class="i-Full-Cart text-success"></i></div>
                                        <div class="ul-widget__content">
                                            <p class="m-0">สินค้าผลิตประจำเดือน</p>
                                            <h4 class="heading">สำเร็จ <?php echo number_format($row_pmonth['qty'], '0', '.', ',') ?> ชิ้น </h4>
                                            <small class="text-muted m-0">สั่งผลิตทั้งหมดเดือน : <?php echo number_format($row_pmonth1['qty'], '0', '.', ',') ?> ชิ้น</small>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="ul-widget__row">
                                        <div class="ul-widget-stat__font"><i class="i-Add-User text-warning"></i></div>
                                        <div class="ul-widget__content">
                                            <p class="m-0">สินค้าดี:ชำรุดประจำเดือน</p>
                                            <h4 class="heading"><?php echo number_format($row_qc['a_type'], '0', '.', ',') ?> : <?php echo number_format($row_qc['b_type'], '0', '.', ',') ?> </h4>
                                            <small class="text-muted m-0">มูลค่าสินค้าดี <?php echo number_format($row_qc['sum_a'], '0', '.', ',') ?>: <?php echo number_format($row_qc['sum_b'], '0', '.', ',') ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="ul-widget__row">
                                        <div class="ul-widget-stat__font"><i class="i-Administrator text-primary"></i></div>
                                        <div class="ul-widget__content">
                                            <p class="m-0">มูลค่าการผลิตประจำเดือน</p>
                                            <h4 class="heading"><?php echo number_format($row_value['CO'], '2', '.', ',') ?></h4>
                                            <small class="text-muted m-0">จำนวนสินค้า : <?php echo number_format($row_value['qty'], '2', '.', ',') ?> ชิ้น </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


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
                                                    <h3 class="ul-widget__head-title">รายการขายประจำเดือน</h3>
                                                </div>
                                                <div class="ul-widget__head-toolbar">
                                                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold ul-widget-nav-tabs-line" role="tablist">
                                                        <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#__d-widget4-tab1-content" role="tab" aria-selected="true">Month</a></li>
                                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#__d-widget4-tab2-content" role="tab" aria-selected="false">Year</a>
                                                        </li>
                                                    </ul>
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
                                                                            <th scope="col" class="text-left">วันที่</th>
                                                                            <th scope="col" class="text-left">ลูกค้า</th>
                                                                            <th scope="col" class="text-left">รายการ</th>
                                                                            <th scope="col" class="text-left">ยอดมัดจำ</th>
                                                                            <th scope="col" class="text-left">ยอดขาย</th>
                                                                            <th scope="col" class="text-left">ยอดคืน</th>
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
                                                                                ?>
                                                                                <tr>
                                                                                    <th scope="row"><?= ++$idx; ?></th>
                                                                                    <td class="text-left">
                                                                                        <?php echo "$row4[DATE]"; ?>
                                                                                       </td>
                                                                                    <td class="text-left"><?php echo number_format($row_cus_day['month'], '0', '.', ',') ?></td>
                                                                                    <td class="text-left"><?php echo number_format($row_dev['dev'], '0', '.', ',') ?></td>
                                                                                    <td class="text-left"><?php echo number_format($row4['sumall'], '2', '.', ',') ?></td>
                                                                                    <td class="text-left"><?php echo number_format($row_sum['total'], '0', '.', ',') ?></td>
                                                                                    <td class="text-left"><?php echo number_format($row4['sumall'], '2', '.', ',') ?></td>
                                                                                    
                                                                                </tr>
                                                                        <?php }
                                                                        } ?>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane" id="__d-widget4-tab2-content">
                                                        <div class="ul-widget1">
                                                            <div class="table-responsive">
                                                                <table class="table text-center" id="user_table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">#</th>
                                                                            <th scope="col" class="text-left">วันที่ส่งสินค้า</th>
                                                                            <th scope="col" class="text-left">เลขที่สั่งชื้อ</th>
                                                                            <th scope="col" class="text-left">ชื่อลูกค้า</th>
                                                                            <th scope="col" class="text-left">จำนวนเงิน</th>
                                                                            <th scope="col" class="text-left">มูลค่า</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $sql4 = "SELECT SUM(production_detail.qty) AS qty ,production_detail.product_id AS product_id,SUM(production_detail.a_type) AS a_type ,SUM(production_detail.b_type) AS b_type ,SUM(product.unit_price)AS unit_price,SUM(qty*unit_price) AS sumall ,SUM(a_type*unit_price) AS sum_atype ,SUM(b_type*unit_price) AS sum_btype   FROM production_detail  INNER JOIN  product  ON product.product_id=production_detail.product_id  
                                                                                    INNER JOIN  production_order ON YEAR(production_order.po_enddate) = '$d[0]' AND production_order.po_id=production_detail.po_id  GROUP BY product_id  ORDER BY qty DESC LIMIT 5 ";
                                                                        $result4 = mysqli_query($conn, $sql4);
                                                                        if (mysqli_num_rows($result4) > 0) {
                                                                            while ($row4 = mysqli_fetch_assoc($result4)) {
                                                                        ?> <tr>
                                                                                    <th scope="row"><?= ++$idx; ?></th>
                                                                                    <td class="text-left">
                                                                                        <?php $sql_pro = "SELECT * FROM product   WHERE product_id= '$row4[product_id]'";
                                                                                        $rs_pro = $conn->query($sql_pro);
                                                                                        $row_pro = $rs_pro->fetch_assoc();  ?>
                                                                                        <?= $row_pro['product_name'] ?></td>
                                                                                    <td class="text-left"><?php echo number_format($row4['qty'], '0', '.', ',') ?></td>
                                                                                    <td class="text-left"><?php echo number_format($row4['a_type'], '0', '.', ',') ?></td>
                                                                                    <td class="text-left"><?php echo number_format($row4['b_type'], '0', '.', ',') ?></td>
                                                                                    <td class="text-left"><?php echo number_format($row4['sumall'], '2', '.', ',') ?></td>
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


                    
                        <div class="col-lg-12 col-md-12">
                            <div class="card mb-4">
                                <h5 class="card-title m-0 p-3">ยอดผลิต 30 วันล่าสุด <?php echo date("Y-m-d", strtotime("-30 days")); ?></h5>
                                <div id="eORchartBar" style="height: 360px;"></div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title">ยอดผลิตตามประเภทสินค้า</div>
                                    <div id="ProtypechartBar" style="height: 300px;"></div>
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