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
    <title>Dashboard | ข้อมูลการผลิตรายปี</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
</head>
<?php
include './include/connect.php';
include './include/config.php';
include './get_dashbord_production_year.php';
$datex = date('Y-m-d');
$d = explode("-", $datex);
$sql_pday = "SELECT count(production_detail.product_id) AS today FROM production_order INNER JOIN production_detail ON production_order.po_id=production_detail.po_id AND 
production_order.po_enddate LIKE  '$datex%'  ";
$rs_pday = $conn->query($sql_pday);
$row_pday = $rs_pday->fetch_assoc();


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
                    <a class="linkLoadModalNext nav-link " href="/report_stock.php">
                        <h4 class="h5 font-weight-bold"> ภาพรวมสต็อก
                        </h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="linkLoadModalNext nav-link active" href="/report_stock_year.php">
                        <h4 class="h5 font-weight-bold"> รายงานสต็อกผลิตรายปี
                        </h4>
                    </a>
                </li>


            </ul>
            <div class="tab-content">
                <div class="main-content">

                    <div class="breadcrumb">
                        <h1 class="mr-2">ภาพรวมสต็อก
                        </h1>
                        <ul>
                            <li><a href="">รายงานยอดสต็อกรายปี</a></li>

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
                                                    <h3 class="ul-widget__head-title">รายการสั่งผลิตสินค้าแบบรายปี</h3>
                                                </div>

                                            </div>


                                            <div class="table-responsive">
                                                <table class="table text-center" id="user_table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col" class="text-left">ชื่อสินค้า</th>
                                                            <th scope="col" class="text-left">ผลิต</th>
                                                            <th scope="col" class="text-left">ขาย</th>
                                                            <th scope="col" class="text-left">คงเหลือ</th>
                                                            <!-- <th scope="col" class="text-left">มูลค่า</th> -->
                                                            <th scope="col" class="text-left">ข้อมูล</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $sql4 = "SELECT DATE_FORMAT(po_enddate,'%Y') As MyYear,SUM(production_detail.qty) AS qty ,production_detail.product_id AS product_id,SUM(production_detail.a_type) AS a_type ,SUM(production_detail.b_type) AS b_type ,SUM(product.unit_price)AS unit_price,SUM(qty*unit_price) AS sumall ,SUM(a_type*unit_price) AS sum_atype ,SUM(b_type*unit_price) AS sum_btype   FROM production_detail  INNER JOIN  product  ON product.product_id=production_detail.product_id  
                                                                                    INNER JOIN  production_order ON  production_order.po_id=production_detail.po_id  AND production_detail.status_stock='1'  GROUP BY MyYear  ORDER BY qty DESC  ";
                                                        $result4 = mysqli_query($conn, $sql4);
                                                        if (mysqli_num_rows($result4) > 0) {
                                                            while ($row4 = mysqli_fetch_assoc($result4)) {
                                                        ?> <tr>
                                                                    <th scope="row"><?= ++$idx; ?></th>
                                                                    <td class="text-left">
                                                                        <?php
                                                                        $d1 = explode("-", $row4['MyYear']);
                                                                        $sql_div = "SELECT  SUM(dev_qty)AS dev_qty FROM deliver_detail   WHERE YEAR(date_create) = '$d1[0]'  AND  ptype_id<>'TF' AND status_cf='1'  ";
                                                                        $rs_div  = $conn->query($sql_div);
                                                                        $row_div  = $rs_div ->fetch_assoc();
                                                                        $year = $row4['MyYear'] + 543;
                                                                        $sql_po1 = "SELECT  SUM(qty)AS qty_im FROM production_import  WHERE YEAR(date_import) = '$d1[0]'  ";
                                                                        $rs_po1  = $conn->query($sql_po1);
                                                                        $row_po1  = $rs_po1 ->fetch_assoc();
                                                                        
                                                                        $sum_po=$row4['a_type']+$row_po1['qty_im'];
                                                                        $sum_all=$sum_po-$row_div['dev_qty'];


                                                                        ?>
                                                                        <?= $year ?></td>
                                                                    <td class="text-left"><?php echo number_format($sum_po, '0', '.', ',') ?></td>
                                                                    <td class="text-left"><?php echo number_format($row_div['dev_qty'], '0', '.', ',') ?></td>
                                                                    <td class="text-left"><?php echo number_format($sum_all, '0', '.', ',') ?></td>
                                                                    <!-- <td class="text-left"><?php echo number_format($row4['sumall'], '2', '.', ',') ?></td> -->
                                                                    <td class="text-left"><a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="ดูข้อมูลรายเดือน" href="/report_stock_month.php?MyYear=<?= $row4['MyYear'] ?>">
                                                                            <i class="i-Check font-weight-bold"></i>
                                                                        </a></td>
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