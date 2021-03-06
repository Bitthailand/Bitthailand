<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
$emp_id=$_SESSION["username"]; 
$MyDate = $_REQUEST['MyDate'];

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
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card mb-4">
                                        <div class="card-body">


                                            <div class="ul-widget__body">
                                                <div class="tab-content">
                                                    <div class="tab-pane active show" id="__d-widget4-tab1-content">
                                                        <div class="ul-widget1">

                                                            <div class="table-responsive">
                                                                <table class="table text-center" id="user_table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">#</th>
                                                                            <th scope="col" class="text-right">เลขที่สั่งชื้อ</th>
                                                                            <th scope="col" class="text-right">เลขที่ QT</th>
                                                                            <th scope="col" class="text-left">ลูกค้า</th>
                                                                            <th scope="col" class="text-left">ประเภทลูกค้า</th>
                                                                            <th scope="col" class="text-left">รับสินค้า</th>
                                                                            <th scope="col" class="text-left">สถานะ</th>
                                                                            <th scope="col" class="text-right">มูลค่าสินค้า</th>
                                                                            <th scope="col" class="text-right">ยอดมัดจำ</th>
                                                                            <th scope="col" class="text-right">ขายสำเร็จ</th>
                                                                            <th scope="col" class="text-right">ข้อมูล</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $d = explode("-", $MyDate);
                                                                        echo 'รายงานใบเสนอราคา' . $MyDate;
                                                                        $sql4 = "SELECT  orders.cus_id AS cus_id, orders.order_id  AS order_id , orders.cus_type AS cus_type,orders.cus_back AS cus_back, orders.order_status AS order_status ,orders.qt_id  AS qt_id  FROM quotation  INNER JOIN   orders   ON  quotation.order_id=orders.order_id   AND  DAY(quotation.date_create)= '$d[2]' AND MONTH(quotation.date_create) = '$d[1]' AND YEAR(quotation.date_create) = '$d[0]'   ";
                                                                        $result4 = mysqli_query($conn, $sql4);
                                                                        if (mysqli_num_rows($result4) > 0) {
                                                                            while ($row4 = mysqli_fetch_assoc($result4)) {

                                                                                $sql_cus = "SELECT * FROM customer  WHERE customer_id='$row4[cus_id]' ";
                                                                                $rs_cus = $conn->query($sql_cus);
                                                                                $row_cus = $rs_cus->fetch_assoc();
                                                                                $sql_dev = "SELECT SUM(dev_qty) AS dev FROM deliver_detail  WHERE dev_id='$row4[dev_id]' AND order_id='$row4[order_id]' ";
                                                                                $rs_dev = $conn->query($sql_dev);
                                                                                $row_dev = $rs_dev->fetch_assoc();
                                                                                $sql_custype = "SELECT * FROM customer_type WHERE id='$row4[cus_type]' ";
                                                                                $rs_custype = $conn->query($sql_custype);
                                                                                $row_custype = $rs_custype->fetch_assoc();

                                                                                $sql_cusback = "SELECT * FROM customer_back WHERE id='$row4[cus_back]' ";
                                                                                $rs_cusback = $conn->query($sql_cusback);
                                                                                $row_cusback = $rs_cusback->fetch_assoc();

                                                                                $sql_sumx = "SELECT ROUND(SUM(total_price), 2) AS sum   FROM order_details WHERE order_id='$row4[order_id]' ";
                                                                                $rs_sumx = $conn->query($sql_sumx);
                                                                                $row_sumx = $rs_sumx->fetch_assoc();

                                                                                $sql_ai = "SELECT * FROM ai_number  WHERE  order_id='$row4[order_id]' ";
                                                                                $rs_ai = $conn->query($sql_ai);
                                                                                $row_ai = $rs_ai->fetch_assoc();

                                                                                $sql_sumx1 = "SELECT SUM(total_price) AS sum   FROM deliver_detail  WHERE order_id='$row4[order_id]'  AND status_cf='1'";
                                                                                $rs_sumx1 = $conn->query($sql_sumx1);
                                                                                $row_sumx1 = $rs_sumx1->fetch_assoc();
                                                                                
                                                                                if($row4['order_status']==1){ $order_status='เสนอราคา';}
                                                                                if($row4['order_status']==2){ $order_status='มัดจำ';}
                                                                                if($row4['order_status']==5){ $order_status='จัดส่งเรียบร้อย';}
                                                                        ?>
                                                                                <tr>
                                                                                    <th scope="row"><?= ++$idx; ?></th>
                                                                                    <td class="text-right"><?php echo $row4['order_id']; ?> </td>
                                                                                    <td class="text-right"><?php echo $row4['qt_id']; ?> </td>
                                                                                    <td class="text-left"><?php echo $row_cus['customer_name']; ?></td>
                                                                                    <td class="text-left"><?php echo $row_custype['name']; ?></td>
                                                                                    <td class="text-left"><?php echo $row_cusback['name']; ?></td>
                                                                                    <td class="text-left"><?php echo $order_status; ?></td>
                                                                                    <td class="text-right"><?php echo number_format($row_sumx['sum'], '2', '.', ','); $sum_dev=$sum_dev+$row_sumx['sum']; ?></td>

                                                                                    <td class="text-right"><?php echo number_format($row_ai['price'], '2', '.', ','); $sum_total=$sum_total+$row_ai['price']; ?></td>
                                                                                    <td class="text-right"><?php echo number_format($row_sumx1['sum'], '2', '.', ','); $sum_total2=$sum_total2+$row_sumx1['sum']; ?></td>

                                                                                    <td class="text-right"><a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="ดูข้อมูลใบเสนอราคา" href="/report_qt_detail.php?order_id=<?=$row4['order_id']?>">
                                                                                            <i class="i-Check font-weight-bold"></i> </a></td>

                                                                                </tr>
                                                                        <?php }
                                                                        } ?>
                                                                        <tr>
                                                                            <th scope="col">#</th>
                                                                            <th scope="col" class="text-right">รวม</th>
                                                                            <th scope="col" class="text-right"></th>
                                                                            <th scope="col" class="text-left"></th>
                                                                            <th scope="col" class="text-left"></th>
                                                                            <th scope="col" class="text-left"></th>
                                                                            <th scope="col" class="text-left"></th>
                                                                            <th scope="col" class="text-right"><?php echo number_format($sum_dev, '2', '.', ',');?></th>
                                                                            <th scope="col" class="text-right"><?php echo number_format($sum_total, '2', '.', ',');?></th>
                                                                            <th scope="col" class="text-right"><?php echo number_format($sum_total2, '2', '.', ',');?></th>

                                                                            <th scope="col" class="text-right"></th>
                                                                        </tr>
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