<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
$emp_id = $_SESSION["username"];


echo 'from database';
$s = ob_get_clean();
file_put_contents('cache.html',$s);
?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Dashboard | ภาพรวมการทำงาน</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
</head>
<?php
include './include/connect.php';
include './include/config.php';
include './get_dashbord.php';
include './get_chart.php';
$datex = date('Y-m');
$d = explode("-", $datex);
$sql_month = "SELECT  DATE_FORMAT(dev_date,'%Y-%m') As MyDate ,SUM(discount) AS discount ,SUM(pay_full) AS pay_full FROM delivery  WHERE    status_chk='1' AND status_payment='1' AND  MONTH(dev_date) = '$d[1]' AND YEAR(dev_date) = '$d[0]' ";
$rs_month = $conn->query($sql_month);
$row_month = $rs_month->fetch_assoc();
// มัดจำ
$sql_ai = "SELECT SUM(price)AS total  FROM ai_number  WHERE  MONTH(date_create) = '$d[1]' AND YEAR(date_create) = '$d[0]'   AND aix_status = '0'  ";
$rs_ai = $conn->query($sql_ai);
$row_ai = $rs_ai->fetch_assoc();
// จ่ายเต็ม
$sql_pay = "SELECT SUM(price)AS totalx  FROM ai_number  WHERE MONTH(date_create) = '$d[1]' AND YEAR(date_create) = '$d[0]'  AND aix_status = '1' AND pay_full='1'  ";
$rs_pay = $conn->query($sql_pay);
$row_pay = $rs_pay->fetch_assoc();

// เครดิส
$sql_sum3 = "SELECT SUM(deliver_detail.total_price) AS total  FROM delivery  INNER JOIN deliver_detail  ON  delivery.order_id=deliver_detail.order_id AND   MONTH(delivery.date_create) = '$d[1]' AND YEAR(delivery.date_create) = '$d[0]'  AND delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='2'  AND delivery.dev_id=deliver_detail.dev_id  ";
$rs_sum3 = $conn->query($sql_sum3);
$row_sum3 = $rs_sum3->fetch_assoc();
// ยอดก่อนหัก
$sql_sum = "SELECT SUM(deliver_detail.total_price) AS total  FROM delivery  INNER JOIN deliver_detail  ON  delivery.order_id=deliver_detail.order_id AND  MONTH(delivery.dev_date) = '$d[1]' AND YEAR(delivery.dev_date) = '$d[0]'   AND delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.dev_id=deliver_detail.dev_id   AND delivery.cus_type='1' ";
$rs_sum = $conn->query($sql_sum);
$row_sum = $rs_sum->fetch_assoc();

// หักมัดจำ
$sql_sum1 = "SELECT SUM(ai_number.price) AS price   FROM delivery  INNER JOIN ai_number  ON  delivery.order_id=ai_number.order_id AND   MONTH(delivery.dev_date) = '$d[1]'  AND YEAR(delivery.dev_date) = '$d[0]'  AND  ai_number.aix_status = '0' AND   delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='1' ";
$rs_sum1 = $conn->query($sql_sum1);
$row_sum1 = $rs_sum1->fetch_assoc();
$sql_sum4 = "SELECT SUM(delivery.ai_count) AS ai_count FROM delivery  INNER JOIN ai_number  ON  delivery.order_id=ai_number.order_id AND  MONTH(delivery.dev_date) = '$d[1]' AND YEAR(delivery.dev_date) = '$d[0]'   AND delivery.ai_status = '1' AND   delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='1'";
$rs_sum4 = $conn->query($sql_sum4);
$row_sum4 = $rs_sum4->fetch_assoc();


$sql_refun = "SELECT SUM(price_refun)AS total  FROM  sr_number  WHERE status_refun='1' AND   MONTH(date_create) = '$d1[1]' AND YEAR(date_create) = '$d1[0]' ";
$rs_refun = $conn->query($sql_refun);
$row_refun = $rs_refun->fetch_assoc();

$sumx_ai = $row_sum4['ai_count'];
$sum_total = $row_sum['total'] - $row_month['discount'];
// $sum= $sum_total- ($sumx_ai-$row_month['pay_full'])+$row_ai['total']+$row_pay['totalx']+$row_sum3['total']-$row_refun['total'];
$sum_totalz= $sum_total-$sumx_ai-$row_month['pay_full'];
$sum=$sum_totalz+$row_ai['total']+$row_pay['totalx']+$row_sum3['total']-$row_refun['total'];

// รายปี

$sql_year = "SELECT  DATE_FORMAT(dev_date,'%Y-%m') As MyDate ,SUM(discount) AS discount ,SUM(pay_full) AS pay_full FROM delivery  WHERE    status_chk='1' AND status_payment='1' AND   YEAR(dev_date) = '$d[0]' ";
$rs_year = $conn->query($sql_year);
$row_year = $rs_year->fetch_assoc();
// มัดจำ
$sql_ai_year = "SELECT SUM(price)AS total  FROM ai_number  WHERE   YEAR(date_create) = '$d[0]'   AND aix_status = '0'  ";
$rs_ai_year = $conn->query($sql_ai_year);
$row_ai_year = $rs_ai_year->fetch_assoc();
// จ่ายเต็ม
$sql_pay_year = "SELECT SUM(price)AS totalx  FROM ai_number  WHERE  YEAR(date_create) = '$d[0]'  AND aix_status = '1' AND pay_full='1'  ";
$rs_pay_year = $conn->query($sql_pay_year);
$row_pay_year = $rs_pay_year->fetch_assoc();

// เครดิส
$sql_sum3_year = "SELECT SUM(deliver_detail.total_price) AS total  FROM delivery  INNER JOIN deliver_detail  ON  delivery.order_id=deliver_detail.order_id    AND YEAR(delivery.date_create) = '$d[0]'  AND delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='2'  AND delivery.dev_id=deliver_detail.dev_id  ";
$rs_sum3_year = $conn->query($sql_sum3_year);
$row_sum3_year = $rs_sum3_year->fetch_assoc();
// ยอดก่อนหัก
$sql_sum_year = "SELECT SUM(deliver_detail.total_price) AS total  FROM delivery  INNER JOIN deliver_detail  ON  delivery.order_id=deliver_detail.order_id AND  YEAR(delivery.dev_date) = '$d[0]'   AND delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.dev_id=deliver_detail.dev_id   AND delivery.cus_type='1' ";
$rs_sum_year = $conn->query($sql_sum_year);
$row_sum_year = $rs_sum_year->fetch_assoc();

// หักมัดจำ
$sql_sum1_year = "SELECT SUM(ai_number.price) AS price   FROM delivery  INNER JOIN ai_number  ON  delivery.order_id=ai_number.order_id  AND YEAR(delivery.dev_date) = '$d[0]'  AND  ai_number.aix_status = '0' AND   delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='1' ";
$rs_sum1_year = $conn->query($sql_sum1_year);
$row_sum1_year = $rs_sum1_year->fetch_assoc();
$sql_sum4_year = "SELECT SUM(delivery.ai_count) AS ai_count FROM delivery  INNER JOIN ai_number  ON  delivery.order_id=ai_number.order_id  AND YEAR(delivery.dev_date) = '$d[0]'   AND delivery.ai_status = '1' AND   delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='1'";
$rs_sum4_year = $conn->query($sql_sum4_year);
$row_sum4_year = $rs_sum4_year->fetch_assoc();


$sql_refun_year = "SELECT SUM(price_refun)AS total  FROM  sr_number  WHERE status_refun='1' AND    YEAR(date_create) = '$d1[0]' ";
$rs_refun_year = $conn->query($sql_refun_year);
$row_refun_year = $rs_refun_year->fetch_assoc();

$sumx_ai_year = $row_sum4_year['ai_count'];
$sum_total_year = $row_sum_year['total'] - $row_year['discount'];
// $sum= $sum_total- ($sumx_ai-$row_month['pay_full'])+$row_ai['total']+$row_pay['totalx']+$row_sum3['total']-$row_refun['total'];
$sum_totaly= $sum_total_year-$sumx_ai_year-$row_year['pay_full'];
$sum_year=$sum_totaly+$row_ai_year['total']+$row_pay_year['totalx']+$row_sum3_year['total']-$row_refun_year['total'];
// 












$sql_year_discount = "SELECT SUM(discount) AS year_discount FROM delivery   WHERE  YEAR(date_create) = '$d[0]'  ";
$rs_year_discount = $conn->query($sql_year_discount);
$row_year_discount = $rs_year_discount->fetch_assoc();

$SUM_MONTH = $row_month['month']-$row_month_discount['month_discount'];
$SUM_YEAR = $row_year['month']-$row_year_discount['year_discount'];
$sql_cus_month = "SELECT COUNT(DISTINCT  cus_id )   month FROM orders  WHERE MONTH(date_create) = '$d[1]' AND YEAR(date_create) = '$d[0]' AND order_status='5'   ";
$rs_cus_month = $conn->query($sql_cus_month);
$row_cus_month = $rs_cus_month->fetch_assoc();

$sql_cus_year = "SELECT COUNT(DISTINCT  cus_id ) AS year FROM  orders  WHERE  YEAR(date_create) = '$d[0]' AND order_status='5'  ";
$rs_cus_year = $conn->query($sql_cus_year);
$row_cus_year = $rs_cus_year->fetch_assoc();

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
            <div class="main-content">
                <div class="breadcrumb">
                    <h1 class="mr-2">ข้อมูลภาพรวม
                    </h1>
                    <ul>
                        <li><a href="">ภาพรวมการขาย</a></li>
                        <li>ประจำเดือน</li>
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
                                        <p class="m-0">ยอดขายประจำเดือน</p>
                                        <h4 class="heading"><a href="report_sale_date1.php?MyMonth=<?=$datex?>" target="blank"><?php echo number_format($sum, '2', '.', ',') ?></a></h4>
                                     
                                        <small class="text-muted m-0">ยอดขายประจำปี : <?php echo number_format($sum_year, '2', '.', ',') ?></small>
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
                                        <p class="m-0">จำนวนลูกค้าประจำเดือน</p>
                                        <h4 class="heading"><?= $row_cus_month['month'] ?></h4>
                                        <small class="text-muted m-0">จำนวนลูกค้าประจำปี : <?= $row_cus_year['year'] ?></small>
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
                                        <p class="m-0">จำนวน Order ประจำเดือน</p>
                                        <h4 class="heading"><?= $row_order_month['month'] ?></h4>
                                        <small class="text-muted m-0">จำนวน Order ประจำปี : <?= $row_order_year['year'] ?></small>
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
                                        <p class="m-0">ลูกค้า Online : Wark-in</p>
                                        <h4 class="heading">352 : 52</h4>
                                        <small class="text-muted m-0">ในรอบปี 2,256 : 534</small>
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
                                <div class="card-title">ยอดขายประจำปี</div>
                                <div id="echartBar" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">ยอดขายตามประเภทสินค้า</div>
                                <div id="echartPie" style="height: 300px;"></div>
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
                                                <h3 class="ul-widget__head-title"> รายชื่อลูกค้าที่มียอดสั่งสูงสุด</h3>
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
                                                                        <th scope="col">ชื่อลูกค้า</th>
                                                                        <th scope="col">อำเภอ</th>
                                                                        <th scope="col">จังหวัด</th>
                                                                        <th scope="col">ยอดสั่งรวม</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $sql4 = "SELECT customer.customer_id AS c_id,customer.customer_name AS c_name,deliver_detail.total_price AS total ,ROUND(SUM(deliver_detail.total_price), 2) AS sum FROM customer  INNER JOIN  delivery
                                                                            ON customer.customer_id =delivery.cus_id 
                                                                            INNER JOIN  deliver_detail  ON  deliver_detail.dev_id = delivery.dev_id  AND   MONTH(deliver_detail.date_create) = '$d[1]' AND YEAR(deliver_detail.date_create) = '$d[0]'  AND deliver_detail.status_cf='1' AND deliver_detail.payment='1'  GROUP BY  customer.customer_name    ORDER BY SUM DESC LIMIT 10  ";
                                                                    $result4 = mysqli_query($conn, $sql4);
                                                                    if (mysqli_num_rows($result4) > 0) {
                                                                        while ($row4 = mysqli_fetch_assoc($result4)) {
                                                                    ?>

                                                                            <tr>
                                                                                <th scope="row"><?= ++$idx; ?></th>
                                                                                <td class="text-left"><?= $row4['c_name'] ?></td>
                                                                                <td class="text-left"><?php
                                                                                                        $sql_cus = "SELECT * FROM customer  WHERE customer_id= '$row4[c_id]'";
                                                                                                        $rs_cus = $conn->query($sql_cus);
                                                                                                        $row_cus = $rs_cus->fetch_assoc();

                                                                                                        $sql4x = "SELECT * FROM amphures  WHERE id= '$row_cus[district]'";
                                                                                                        $rs4x = $conn->query($sql4x);
                                                                                                        $row4x = $rs4x->fetch_assoc();
                                                                                                        echo $row4x['name_th'];  ?></td>
                                                                                <td class="text-left"><?php
                                                                                                        $sql5 = "SELECT * FROM provinces  WHERE id= '$row_cus[province]'";
                                                                                                        $rs5 = $conn->query($sql5);
                                                                                                        $row5 = $rs5->fetch_assoc();
                                                                                                        echo $row5['name_th'];

                                                                                                        ?></td>
                                                                                <td class="text-left"><?php echo number_format($row4['sum'], '2', '.', ',') ?></td>
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
                                                                        <th scope="col">ชื่อลูกค้า</th>
                                                                        <th scope="col">อำเภอ</th>
                                                                        <th scope="col">จังหวัด</th>
                                                                        <th scope="col">ยอดสั่งรวม</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $sql4 = "SELECT customer.customer_id AS c_id,customer.customer_name AS c_name,deliver_detail.total_price AS total ,ROUND(SUM(deliver_detail.total_price), 2) AS sum FROM customer  INNER JOIN  delivery
                                                                            ON customer.customer_id =delivery.cus_id 
                                                                            INNER JOIN  deliver_detail  ON  deliver_detail.dev_id = delivery.dev_id  AND    YEAR(deliver_detail.date_create) = '$d[0]'  AND YEAR(deliver_detail.date_create) = '$d[0]'  AND deliver_detail.status_cf='1' AND deliver_detail.payment='1'  GROUP BY  customer.customer_name    ORDER BY SUM DESC LIMIT 10  ";
                                                                    $result4 = mysqli_query($conn, $sql4);
                                                                    if (mysqli_num_rows($result4) > 0) {
                                                                        while ($row4 = mysqli_fetch_assoc($result4)) {
                                                                    ?> <tr>
                                                                                <th scope="row"><?= ++$idx1; ?></th>
                                                                                <td class="text-left"><?= $row4['c_name'] ?></td>
                                                                                <td class="text-left"><?php
                                                                                                        $sql_cus = "SELECT * FROM customer  WHERE customer_id= '$row4[c_id]'";
                                                                                                        $rs_cus = $conn->query($sql_cus);
                                                                                                        $row_cus = $rs_cus->fetch_assoc();

                                                                                                        $sql4x = "SELECT * FROM amphures  WHERE id= '$row_cus[district]'";
                                                                                                        $rs4x = $conn->query($sql4x);
                                                                                                        $row4x = $rs4x->fetch_assoc();
                                                                                                        echo $row4x['name_th'];  ?></td>
                                                                                <td class="text-left"><?php
                                                                                                        $sql5 = "SELECT * FROM provinces  WHERE id= '$row_cus[province]'";
                                                                                                        $rs5 = $conn->query($sql5);
                                                                                                        $row5 = $rs5->fetch_assoc();
                                                                                                        echo $row5['name_th'];

                                                                                                        ?></td>
                                                                                <td class="text-left"><?php echo number_format($row4['sum'], '2', '.', ',') ?></td>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body p-0">
                                        <h5 class="card-title m-0 p-3">ยอดขาย 30 วันล่าสุด <?php echo date("Y-m-d", strtotime("-30 days")); ?></h5>
                                        <div id="eORchartBar" style="height: 360px;"></div>
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
                                        <h3 class="ul-widget__head-title">สินค้าที่มียอดขายสูงสุด</h3>
                                    </div>
                                    <div class="ul-widget__head-toolbar">
                                        <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold ul-widget-nav-tabs-line" role="tablist">
                                            <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#__g-widget4-tab1-content" role="tab" aria-selected="true">Month</a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#__g-widget4-tab2-content" role="tab" aria-selected="false">Year</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="ul-widget__body">
                                    <div class="tab-content">
                                        <div class="tab-pane active show" id="__g-widget4-tab1-content">
                                            <div class="ul-widget1">
                                                <?php $sql4 = "SELECT ROUND(SUM(total_price), 2) AS sum,product_id,ptype_id FROM deliver_detail  WHERE   MONTH(date_create) = '$d[1]' AND YEAR(date_create) = '$d[0]'  GROUP BY  product_id    ORDER BY SUM DESC LIMIT 5  ";
                                                $result4 = mysqli_query($conn, $sql4);
                                                if (mysqli_num_rows($result4) > 0) {
                                                    while ($row4 = mysqli_fetch_assoc($result4)) {
                                                ?>
                                                        <div class="ul-widget4__item ul-widget4__users">
                                                            <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3">
                                                                <!-- <img class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="../../dist-assets/images/products/11.jpg" alt="" /> -->
                                                                <div class="flex-grow-1">
                                                                    <?php
                                                                    $sql_pro = "SELECT * FROM product  WHERE product_id= '$row4[product_id]'";
                                                                    $rs_pro = $conn->query($sql_pro);
                                                                    $row_pro = $rs_pro->fetch_assoc();

                                                                    $sql_type = "SELECT * FROM product_type  WHERE ptype_id= '$row4[ptype_id]'";
                                                                    $rs_type = $conn->query($sql_type);
                                                                    $row_type = $rs_type->fetch_assoc();
                                                                    ?>
                                                                    <h5><a href="#"> <?= $row_pro['product_name'] ?></a></h5>
                                                                    <p class="m-0 text-small text-muted"><?= $row_type['ptype_name'] ?></p>
                                                                    <p class="text-small text-danger m-0">฿<?php echo number_format($row4['sum'], '2', '.', ',') ?>
                                                                        <del class="text-muted"></del>
                                                                    </p>
                                                                </div>
                                                                <div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="__g-widget4-tab2-content">
                                            <div class="ul-widget1">
                                                <?php $sql4 = "SELECT ROUND(SUM(total_price), 2) AS sum,product_id,ptype_id FROM deliver_detail  WHERE    YEAR(date_create) = '$d[0]'  GROUP BY  product_id    ORDER BY SUM DESC LIMIT 5  ";
                                                $result4 = mysqli_query($conn, $sql4);
                                                if (mysqli_num_rows($result4) > 0) {
                                                    while ($row4 = mysqli_fetch_assoc($result4)) {
                                                ?>
                                                        <div class="ul-widget4__item ul-widget4__users">
                                                        <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3">
                                                                <!-- <img class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="../../dist-assets/images/products/11.jpg" alt="" /> -->
                                                                <div class="flex-grow-1">
                                                                    <?php
                                                                    $sql_pro = "SELECT * FROM product  WHERE product_id= '$row4[product_id]'";
                                                                    $rs_pro = $conn->query($sql_pro);
                                                                    $row_pro = $rs_pro->fetch_assoc();

                                                                    $sql_type = "SELECT * FROM product_type  WHERE ptype_id= '$row4[ptype_id]'";
                                                                    $rs_type = $conn->query($sql_type);
                                                                    $row_type = $rs_type->fetch_assoc();
                                                                    ?>
                                                                    <h5><a href="#"> <?= $row_pro['product_name'] ?></a></h5>
                                                                    <p class="m-0 text-small text-muted"><?= $row_type['ptype_name'] ?></p>
                                                                    <p class="text-small text-danger m-0">฿<?php echo number_format($row4['sum'], '2', '.', ',') ?>
                                                                        <del class="text-muted"></del>
                                                                    </p>
                                                                </div>
                                                                <div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">ยอดขายตามประเภทสินค้า</div>
                                <div id="ProtypechartBar" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">ยอดขายรายปี</div>
                                <div id="dashedLineChart"></div>
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
   
</body>

</html>