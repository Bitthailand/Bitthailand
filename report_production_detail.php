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
$MyDate = $_REQUEST['MyDate'];

$date1 = explode(" ", $MyDate);
$dat1 = datethai2($date1[0]);

$d = explode("-", $MyDate);
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
                    <a class="linkLoadModalNext nav-link " href="/report_production.php">
                        <h4 class="h5 font-weight-bold"> ภาพรวมข้อมูลสั่งผลิต
                        </h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="linkLoadModalNext nav-link active" href="/report_production_year.php">
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
                            <li><a href="">ภาพรวมการผลิตรายวัน <?= $dat1 ?></a></li>

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
                                                    <h3 class="ul-widget__head-title">รายการสั่งผลิตสินค้าแบบรายวัน <?= $dat1 ?></h3>
                                                </div>

                                            </div>


                                            <div class="table-responsive">
                                                <table class="table text-center" id="user_table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col" class="text-left">ชื่อสินค้า</th>
                                                            <th scope="col" class="text-left">ผลิต</th>
                                                            <th scope="col" class="text-left">สำเร็จ</th>
                                                            <th scope="col" class="text-left">ชำรุด</th>
                                                            <th scope="col" class="text-left">ราคาต่อหน่วย</th>
                                                            <th scope="col" class="text-left">มูลค่า</th>
                                              
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $sql4 = "SELECT * FROM production_detail  INNER JOIN  product  ON product.product_id=production_detail.product_id  
                                                                                    INNER JOIN  production_order ON  DAY(production_order.po_enddate) = '$d[2]' AND MONTH(production_order.po_enddate) = '$d[1]' AND YEAR(production_order.po_enddate) = '$d[0]' AND production_order.po_id=production_detail.po_id AND production_detail.status_stock='1'   ";
                                                        $result4 = mysqli_query($conn, $sql4);
                                                        if (mysqli_num_rows($result4) > 0) {
                                                            while ($row4 = mysqli_fetch_assoc($result4)) {
                                                        ?> <tr>
                                                                    <th scope="row"><?= ++$idx; ?></th>
                                                                    <td class="text-left">
                                                                        <?php $sql_pro = "SELECT * FROM product   WHERE product_id= '$row4[product_id]'";
                                                                        $rs_pro = $conn->query($sql_pro);
                                                                        $row_pro = $rs_pro->fetch_assoc();
                                                                        echo $row_pro['product_name'];
                                                                        ?>
                                                                        <?= $dat1?></td>
                                                                    <td class="text-left"><?php echo number_format($row4['qty'], '0', '.', ',') ?></td>
                                                                    <td class="text-left"><?php echo number_format($row4['a_type'], '0', '.', ',') ?></td>
                                                                    <td class="text-left"><?php echo number_format($row4['b_type'], '0', '.', ',') ?></td>
                                                                    <td class="text-left"><?php echo number_format($row_pro['unit_price'], '2', '.', ',') ?></td>
                                                                    <td class="text-left"><?php $sumall=$row_pro['unit_price']*$row4['qty']; echo number_format($sumall, '2', '.', ',') ?></td>
                                                                   
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