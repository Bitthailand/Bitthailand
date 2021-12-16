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
    <title>Dashboard | ภาพรวมสต็อกสินค้า</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
</head>
<?php
include './include/connect.php';
include './include/config.php';
include './get_dashbord_stock.php';
$datex = date('Y-m-d');
$d = explode("-", $datex);
$sql_pday = "SELECT SUM(fac1_stock) AS fac1_stock,SUM(fac2_stock)AS fac2_stock,SUM(fac1_stock+fac2_stock)AS sum_all ,SUM(unit_price*fac1_stock) AS total1 ,SUM(unit_price*fac2_stock) AS total2  FROM product   ";
$rs_pday = $conn->query($sql_pday);
$row_pday = $rs_pday->fetch_assoc();
$sum_v=$row_pday['total1']+$row_pday['total2'];
// รวมสินค้าผลิตทั้งหมด


$sql_pmonth = "SELECT count(production_detail.product_id) AS month,SUM(production_detail.qty) AS qty,SUM(product.unit_price)AS unit_price FROM production_order INNER JOIN production_detail ON production_order.po_id=production_detail.po_id AND 
MONTH(production_order.po_enddate) = '$d[1]' AND YEAR(production_order.po_enddate) = '$d[0]'   INNER JOIN  product ON product.product_id=production_detail.product_id AND production_detail.status_stock='1'   ";
$rs_pmonth = $conn->query($sql_pmonth);
$row_pmonth = $rs_pmonth->fetch_assoc();

$sql_po = "SELECT sum(qty) AS a_type  FROM production_import   ";
$rs_po = $conn->query($sql_po);
$row_po = $rs_po->fetch_assoc();
$sql_po1 = "SELECT sum(a_type) AS a_type  FROM production_detail   where status_stock='1'  ";
$rs_po1 = $conn->query($sql_po1);
$row_po1 = $rs_po1->fetch_assoc();
$sum_stock = $row_po['a_type'] + $row_po1['a_type'];

$sql_dev = "SELECT sum(dev_qty) AS dev_qty  FROM deliver_detail  where  ptype_id<>'TF' AND status_cf='1' ";
$rs_dev = $conn->query($sql_dev);
$row_dev = $rs_dev->fetch_assoc();


$sql_pro2 = "SELECT sum(order_details.qty_out) AS qty_out FROM order_details INNER JOIN orders ON  order_details.order_id=orders.order_id AND orders.is_ai='Y' AND order_details.ptype_id<>'TF' ";
$rs_pro2 = $conn->query($sql_pro2);
$row_pro2 = $rs_pro2->fetch_assoc();
$sum_stock_all = $sum_stock - $row_dev['dev_qty'];

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
                    <a class="linkLoadModalNext nav-link active" href="/report_stock.php">
                        <h4 class="h5 font-weight-bold"> ภาพรวมสต็อก
                        </h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="linkLoadModalNext nav-link" href="/report_stock_year.php">
                        <h4 class="h5 font-weight-bold"> รายงานยอดสต็อกรายปี
                        </h4>
                    </a>

                </li>

            </ul>
            <div class="tab-content">
                <div class="main-content">

                    <div class="breadcrumb">
                        <h1 class="mr-2">ข้อมูลสต็อกสินค้า
                        </h1>
                        <ul>
                            <li><a href="">ภาพรวมสต็อกสินค้า</a></li>
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
                                            <p class="m-0">สต็อกทั้งหมดประจำวันนี้</p>
                                            <h4 class="heading"><?php echo number_format($row_pday['sum_all'], '0', '.', ',') ?> ชิ้น</h4>
                                            <small class="text-muted m-0">โรงงาน1 :<?php echo number_format($row_pday['fac1_stock'], '0', '.', ',') ?> ชิ้น </small><br>
                                            <small class="text-muted m-0">โรงงาน2 :<?php echo number_format($row_pday['fac2_stock'], '0', '.', ',') ?> ชิ้น </small>

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
                                            <p class="m-0">มูลค่าสต็อก</p>
                                            <h4 class="heading"> <?php echo number_format($sum_v, '2', '.', ',') ?> ชิ้น </h4>
                                            <small class="text-muted m-0">มูลค่าโรงงาน1: <?php echo number_format($row_pday['total1'], '2', '.', ',') ?> ชิ้น</small><br>
                                            <small class="text-muted m-0">มูลค่าโรงงาน2: <?php echo number_format($row_pday['total2'], '2', '.', ',') ?> ชิ้น</small>

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
                                            <p class="m-0">สินค้าออกจากสต็อก</p>
                                            <h4 class="heading"><?php echo number_format($row_dev['dev_qty'], '0', '.', ',') ?> ชิ้น </h4>
                                            <small class="text-muted m-0">สินค้ามัดจำ <?php echo number_format($row_pro2['qty_out'], '0', '.', ',') ?> ชิ้น</small><br>
                                            <small class="text-muted m-0">สินค้าส่งเสร็จ <?php echo number_format($row_dev['dev_qty'], '0', '.', ',') ?> ชิ้น</small>
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
                                            <p class="m-0">สต็อกคงเหลือ</p>
                                            <h4 class="heading"><?php echo number_format($sum_stock_all, '0', '.', ',') ?></h4><br><br>
                                            <!-- <small class="text-muted m-0">จำนวนสินค้า : <?php echo number_format($row_value['qty'], '2', '.', ',') ?> ชิ้น </small> -->
                                        </div>
                                    </div>
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
                                                    <h3 class="ul-widget__head-title">รายการสินค้าที่มีสต็อกสูงสุด</h3>
                                                </div>
                                                <a class="btn btn btn-success mb-2 mr-2" href="/report_stock_excel.php">export excel</a>
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
                                                                            <th scope="col" class="text-left">รหัสสินค้า</th>
                                                                            <th scope="col" class="text-left">ชื่อสินค้า</th>
                                                                            <th scope="col" class="text-left">สต็อกโรงงาน1</th>
                                                                            <th scope="col" class="text-left">สต็อกโรงงาน2</th>
                                                                            <th scope="col" class="text-left">ผลิต</th>
                                                                            <th scope="col" class="text-left">ขาย</th>
                                                                            <th scope="col" class="text-left">คงเหลือ</th>
                                                                            <th scope="col" class="text-left">สต็อกเดิม</th>
                                                                            <th scope="col" class="text-left">รวมสินค้าที่ขาย</th>
                                                                            <th scope="col" class="text-left">ราคาขาย</th>
                                                                           
                                                                            <th scope="col" class="text-left">มูลค่าขาย</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $sql4 = "SELECT *  FROM product where  ptype_id<>'TF0'  AND status='0'  ORDER BY fac1_stock DESC ";
                                                                        $result4 = mysqli_query($conn, $sql4);
                                                                        if (mysqli_num_rows($result4) > 0) {
                                                                            while ($row4 = mysqli_fetch_assoc($result4)) {
                                                                        ?>

                                                                                <tr>
                                                                                    <th scope="row"><?= ++$idx; ?></th>
                                                                                    <th scope="row"><?= $row4['product_id'] ?></th>
                                                                                    <td class="text-left"> <?= $row4['ptype_id'] ?>
                                                                                        <?php $sql_pro = "SELECT * FROM product_type  WHERE ptype_id= '$row4[ptype_id]'  ";
                                                                                        $rs_pro = $conn->query($sql_pro);
                                                                                        $row_pro = $rs_pro->fetch_assoc();  ?>
                                                                                        <?php
                                                                                        if ($row_pro['stock_m'] == 1) {
                                                                                            $rs_po = $conn->query($sql_po);
                                                                                            $row_po = $rs_po->fetch_assoc();
                                                                                            // echo "$row_po[a_type]";
                                                                                        } else {
                                                                                            $sql_po = "SELECT sum(a_type) AS a_type,SUM(product.unit_price)AS unit_price FROM production_detail   INNER JOIN product on production_detail.product_id=product.product_id  AND  production_detail.status_stock='1' AND production_detail.product_id='$row4[product_id]' ";
                                                                                            $rs_po = $conn->query($sql_po);
                                                                                            $row_po = $rs_po->fetch_assoc();
                                                                                            // echo "$row_po[a_type]";
                                                                                        }
                                                                                        $sql_dev = "SELECT sum(dev_qty) AS dev_qty   FROM deliver_detail  where  product_id='$row4[product_id]' ";
                                                                                        $rs_dev = $conn->query($sql_dev);
                                                                                        $row_dev = $rs_dev->fetch_assoc();

                                                                                        ?>
                                                                                        <?= $row4['product_name'] ?></td>
                                                                                    <td class="text-left"><?php echo number_format($row4['fac1_stock'], '0', '.', ',') ?></td>
                                                                                    <td class="text-left"><?php echo number_format($row4['fac2_stock'], '0', '.', ',') ?></td>
                                                                                    <td class="text-left"><?php echo number_format($row_po['a_type'], '0', '.', ',') ?></td>
                                                                                    <td class="text-left"><?php echo number_format($row_dev['dev_qty'], '0', '.', ',') ?></td>
                                                                                    <td class="text-left"><?php $sumx = $row_po['a_type'] - $row_dev['dev_qty'];
                                                                                                            echo number_format($sumx, '0', '.', ',') ?></td>
                                                                                    <td class="text-left"><?php echo number_format($row4['stock_old'], '0', '.', ',') ?></td>
                                                                                    <td class="text-left"><?php $sum_stock = $sumx + $row4['stock_old'];
                                                                                                            echo number_format($sum_stock, '0', '.', ',') ?></td>
                                                                                    <td class="text-left"><?php echo number_format($row4['unit_price'], '0', '.', ',') ?></td>
                                                                                  
                                                                                    


                                                                                    <td class="text-left"><?php $total = $sum_stock * $row4['unit_price'];
                                                                                                            echo number_format($total, '2', '.', ',') ?></td>
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