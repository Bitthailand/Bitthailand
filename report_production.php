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
    <title>Dashboard | ภาพรวมการผลิต</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
</head>
<?php
include './include/connect.php';
include './include/config.php';
include './get_dashbord_production.php';
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
$sql_value = "SELECT count(production_detail.product_id) AS today,SUM(production_detail.qty) AS qty,SUM(product.unit_price)AS unit_price,SUM(qty*unit_price) AS CO  FROM production_order INNER JOIN production_detail ON production_order.po_id=production_detail.po_id AND 
MONTH(production_order.po_enddate) = '$d[1]' AND YEAR(production_order.po_enddate) = '$d[0]' INNER JOIN  product ON product.product_id=production_detail.product_id AND production_detail.status_stock='1'  ";
$rs_value = $conn->query($sql_value);
$row_value = $rs_value->fetch_assoc();
$sql_pmonth = "SELECT count(production_detail.product_id) AS month,SUM(production_detail.qty) AS qty,SUM(product.unit_price)AS unit_price FROM production_order INNER JOIN production_detail ON production_order.po_id=production_detail.po_id AND 
MONTH(production_order.po_enddate) = '$d[1]' AND YEAR(production_order.po_enddate) = '$d[0]'   INNER JOIN  product ON product.product_id=production_detail.product_id AND production_detail.status_stock='1'   ";
$rs_pmonth = $conn->query($sql_pmonth);
$row_pmonth = $rs_pmonth->fetch_assoc();
$sql_pmonth1 = "SELECT count(production_detail.product_id) AS month,SUM(production_detail.qty) AS qty,SUM(product.unit_price)AS unit_price FROM production_order INNER JOIN production_detail ON production_order.po_id=production_detail.po_id AND 
MONTH(production_order.po_enddate) = '$d[1]' AND YEAR(production_order.po_enddate) = '$d[0]'   INNER JOIN  product ON product.product_id=production_detail.product_id    ";
$rs_pmonth1 = $conn->query($sql_pmonth1);
$row_pmonth1 = $rs_pmonth1->fetch_assoc();
$sql_qc = "SELECT SUM(production_detail.a_type) AS a_type,SUM(production_detail.b_type) AS b_type,SUM(product.unit_price)AS unit_price, SUM(a_type*unit_price) AS sum_a,SUM(b_type*unit_price)AS sum_b  FROM production_order INNER JOIN production_detail ON production_order.po_id=production_detail.po_id AND 
MONTH(production_order.po_enddate) = '$d[1]'  AND YEAR(production_order.po_enddate) = '$d[0]'  INNER JOIN  product ON product.product_id=production_detail.product_id AND production_detail.status_stock='1' ";
$rs_qc = $conn->query($sql_qc);
$row_qc = $rs_qc->fetch_assoc();
$sql_order_month = "SELECT COUNT(*) AS month FROM orders  WHERE MONTH(date_create) = '$d[1]' AND YEAR(date_create) = '$d[0]' AND order_status='5' ";
$rs_order_month = $conn->query($sql_order_month);
$row_order_month = $rs_order_month->fetch_assoc();
$sql_order_year = "SELECT COUNT(*) AS year  FROM orders  WHERE  YEAR(date_create) = '$d[0]'  AND order_status='5'  ";
$rs_order_year = $conn->query($sql_order_year);
$row_order_year = $rs_order_year->fetch_assoc();
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
                        <div class="col-lg-8 col-md-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title">ยอดผลิตประจำปี</div>
                                    <div id="echartBar" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title">ยอดผลิตตามประเภทสินค้า ปี <?= $d['0'] ?></div>
                                    <div id="echartPie" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title">รายการผลิตประจำวัน</div>
                                    <div class="table-responsive">
                                        <table class="table text-center" id="user_table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col" class="text-left">รหัสสินค้า</th>
                                                    <th scope="col" class="text-left">ชื่อสินค้า</th>
                                                    <th scope="col" class="text-left">จำนวนผลิต</th>
                                                    <th scope="col" class="text-left">ราคาต่อหน่วย</th>
                                                    <th scope="col" class="text-left">รวมราคา</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $datex = date('Y-m-d');
                                                $sql4 = "SELECT DATE_FORMAT(production_order.po_date, '%Y-%m-%d') AS po_date,production_detail.product_id AS product,production_detail.qty AS qty,product.unit_price AS unit_price ,(unit_price*qty) AS total  FROM production_detail INNER JOIN production_order ON production_order.po_id=production_detail.po_id
                                                         INNER JOIN product ON production_detail.product_id=product.product_id AND    po_date   ='$datex' ORDER BY total  DESC";
                                                $result4 = mysqli_query($conn, $sql4);
                                                if (mysqli_num_rows($result4) > 0) {
                                                    while ($row4 = mysqli_fetch_assoc($result4)) {
                                                ?>
                                                        <tr>
                                                            <th scope="row"><?= ++$idx; ?></th>
                                                            <td class="text-left">
                                                                <?php $sql_pro = "SELECT * FROM product   WHERE product_id= '$row4[product]'";
                                                                $rs_pro = $conn->query($sql_pro);
                                                                $row_pro = $rs_pro->fetch_assoc();  ?>
                                                                <?= $row_pro['product_id'] ?></td>
                                                            <td class="text-left"><?php echo $row_pro['product_name']; ?></td>
                                                            <td class="text-left"><?php echo number_format($row4['qty'], '0', '.', ',');
                                                                                    $sum_qty = $sum_qty + $row4['qty'];  ?></td>
                                                            <td class="text-left"><?php echo number_format($row4['unit_price'], '0', '.', ',');
                                                                                    $sum_unit_price = $sum_unit_price + $row4['unit_price']; ?></td>
                                                            <td class="text-left"><?php echo number_format($row4['total'], '0', '.', ',');
                                                                $sum_total = $sum_total + $row4['total']; ?></td>
                                                        </tr>
                                                <?php }
                                                } ?>
                                            </tbody>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col" class="text-left"></th>
                                                <th scope="col" class="text-left">รวม</th>
                                                <th scope="col" class="text-left"><?php echo number_format($sum_qty, '0', '.', ','); ?></th>
                                                <th scope="col" class="text-left"><?php echo number_format($sum_unit_price, '0', '.', ','); ?></th>
                                                <th scope="col" class="text-left"><?php echo number_format($sum_total, '0', '.', ','); ?></th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="ul-widget__head">
                                                <div class="ul-widget__head-label">
                                                    <h3 class="ul-widget__head-title">รายการสั่งผลิตสินค้าสูงสุด</h3>
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
                                                                            <th scope="col" class="text-left">ชื่อสินค้า</th>
                                                                            <th scope="col" class="text-left">ผลิต</th>
                                                                            <th scope="col" class="text-left">สำเร็จ</th>
                                                                            <th scope="col" class="text-left">ชำรุด</th>
                                                                            <th scope="col" class="text-left">มูลค่า</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $sql4 = "SELECT SUM(production_detail.qty) AS qty ,production_detail.product_id AS product_id,SUM(production_detail.a_type) AS a_type ,SUM(production_detail.b_type) AS b_type ,SUM(product.unit_price)AS unit_price,SUM(qty*unit_price) AS sumall ,SUM(a_type*unit_price) AS sum_atype ,SUM(b_type*unit_price) AS sum_btype   FROM production_detail  INNER JOIN  product  ON product.product_id=production_detail.product_id  
                                                                                    INNER JOIN  production_order on  MONTH(production_order.po_enddate) = '$d[1]' AND YEAR(production_order.po_enddate) = '$d[0]' AND production_order.po_id=production_detail.po_id  GROUP BY product_id  ORDER BY qty DESC LIMIT 5";
                                                                        $result4 = mysqli_query($conn, $sql4);
                                                                        if (mysqli_num_rows($result4) > 0) {
                                                                            while ($row4 = mysqli_fetch_assoc($result4)) {
                                                                        ?>

                                                                                <tr>
                                                                                    <th scope="row"><?= ++$idxx4; ?></th>
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
                                                    <div class="tab-pane" id="__d-widget4-tab2-content">
                                                        <div class="ul-widget1">
                                                            <div class="table-responsive">
                                                                <table class="table text-center" id="user_table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">#</th>
                                                                            <th scope="col" class="text-left">ชื่อสินค้า</th>
                                                                            <th scope="col" class="text-left">ผลิต</th>
                                                                            <th scope="col" class="text-left">สำเร็จ</th>
                                                                            <th scope="col" class="text-left">ชำรุด</th>
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
                                                                                    <th scope="row"><?= ++$idxx; ?></th>
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
                        <div class="col-lg-6 col-md-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="ul-widget__head">
                                        <div class="ul-widget__head-label">
                                            <h3 class="ul-widget__head-title">แพที่ใช้ผลิตมากสุด</h3>
                                        </div>
                                        <div class="ul-widget__head-toolbar">
                                            <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold ul-widget-nav-tabs-line" role="tablist">
                                                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#__g-widget4-tab1-content2" role="tab" aria-selected="true">Month</a></li>
                                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#__g-widget4-tab2-content2" role="tab" aria-selected="false">Year</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="ul-widget__body">
                                        <div class="tab-content">
                                            <div class="tab-pane active show" id="__g-widget4-tab1-content2">
                                                <div class="ul-widget1">
                                                    <div class="table-responsive">
                                                        <table class="table text-center" id="user_table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col" class="text-center">แพที่</th>
                                                                    <th scope="col" class="text-left">โรงงาน</th>
                                                                    <th scope="col" class="text-left">ประเภทสินค้า</th>
                                                                    <th scope="col" class="text-left">จำนวนผลิต</th>
                                                                    <th scope="col" class="text-left">มูลค่า</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $sql5 = "SELECT production_detail.plant_id, SUM(production_detail.qty) AS qty,SUM(production_detail.a_type) AS a_type ,SUM(production_detail.b_type) AS b_type ,SUM(product.unit_price)AS unit_price,SUM(qty*unit_price) AS sumall ,SUM(a_type*unit_price) AS sum_atype ,SUM(b_type*unit_price) AS sum_btype   FROM production_order INNER JOIN production_detail ON production_order.po_id=production_detail.po_id AND 
                                                                        MONTH(production_order.po_enddate) = '$d[1]'  AND YEAR(production_order.po_enddate) = '$d[0]'  INNER JOIN  product ON product.product_id=production_detail.product_id AND production_detail.status_stock='1'
                                                                        GROUP BY production_detail.plant_id  ORDER BY  qty DESC  LIMIT 5 ";
                                                                $result5 = mysqli_query($conn, $sql5);
                                                                if (mysqli_num_rows($result5) > 0) {
                                                                    while ($row5 = mysqli_fetch_assoc($result5)) {
                                                                ?> <tr>
                                                                            <th scope="row"><?= ++$idx5; ?></th>
                                                                            <td class="text-center">
                                                                                <?php $sql_plant = "SELECT * FROM plant  WHERE plant_id= '$row5[plant_id]'";
                                                                                $rs_plant = $conn->query($sql_plant);
                                                                                $row_plant = $rs_plant->fetch_assoc();
                                                                                $sql_type = "SELECT * FROM product_type  WHERE ptype_id= '$row_plant[ptype_id]'";
                                                                                $rs_type  = $conn->query($sql_type);
                                                                                $row_type  = $rs_type->fetch_assoc();

                                                                                ?>
                                                                                <?= $row5['plant_id'] ?></td>
                                                                            <td class="text-left"> <?= $row_plant['factory'] ?></td>
                                                                            <td class="text-left"><?= $row_type['ptype_name'] ?></td>
                                                                            <td class="text-left"><?php echo number_format($row5['qty'], '0', '.', ',') ?></td>
                                                                            <td class="text-left"><?php echo number_format($row5['sumall'], '2', '.', ',') ?></td>
                                                                        </tr>
                                                                <?php }
                                                                } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="__g-widget4-tab2-content2">
                                                <div class="ul-widget1">
                                                    <div class="table-responsive">
                                                        <table class="table text-center" id="user_table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col" class="text-center">แพที่</th>
                                                                    <th scope="col" class="text-left">โรงงาน</th>
                                                                    <th scope="col" class="text-left">ประเภทสินค้า</th>
                                                                    <th scope="col" class="text-left">จำนวนผลิต</th>
                                                                    <th scope="col" class="text-left">มูลค่า</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $sql5 = "SELECT production_detail.plant_id, SUM(production_detail.qty) AS qty,SUM(production_detail.a_type) AS a_type ,SUM(production_detail.b_type) AS b_type ,SUM(product.unit_price)AS unit_price,SUM(qty*unit_price) AS sumall ,SUM(a_type*unit_price) AS sum_atype ,SUM(b_type*unit_price) AS sum_btype   FROM production_order INNER JOIN production_detail ON production_order.po_id=production_detail.po_id AND 
                                                                         YEAR(production_order.po_enddate) = '$d[0]'  INNER JOIN  product ON product.product_id=production_detail.product_id AND production_detail.status_stock='1'
                                                                        GROUP BY production_detail.plant_id  ORDER BY  qty DESC  LIMIT 5 ";
                                                                $result5 = mysqli_query($conn, $sql5);
                                                                if (mysqli_num_rows($result5) > 0) {
                                                                    while ($row5 = mysqli_fetch_assoc($result5)) {
                                                                ?> <tr>
                                                                            <th scope="row"><?= ++$idx6; ?></th>
                                                                            <td class="text-center">
                                                                                <?php $sql_plant = "SELECT * FROM plant  WHERE plant_id= '$row5[plant_id]'";
                                                                                $rs_plant = $conn->query($sql_plant);
                                                                                $row_plant = $rs_plant->fetch_assoc();
                                                                                $sql_type = "SELECT * FROM product_type  WHERE ptype_id= '$row_plant[ptype_id]'";
                                                                                $rs_type  = $conn->query($sql_type);
                                                                                $row_type  = $rs_type->fetch_assoc();

                                                                                ?>
                                                                                <?= $row5['plant_id'] ?></td>
                                                                            <td class="text-left"> <?= $row_plant['factory'] ?></td>
                                                                            <td class="text-left"><?= $row_type['ptype_name'] ?></td>
                                                                            <td class="text-left"><?php echo number_format($row5['qty'], '0', '.', ',') ?></td>
                                                                            <td class="text-left"><?php echo number_format($row5['sumall'], '2', '.', ',') ?></td>
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