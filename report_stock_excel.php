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
    <title>Dashboard | ภาพรวมสต็อกสินค้า</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
</head>
<?php
$datetodat = date('Y-m-d');
$strExcelFileName = "stock-$datetodat.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");

header("Pragma:no-cache");
?>
<?php
include './include/connect.php';
include './include/config.php';
include './get_dashbord_stock.php';
$datex = date('Y-m-d');
$d = explode("-", $datex);
$sql_pday = "SELECT SUM(fac1_stock) AS fac1_stock,SUM(fac2_stock)AS fac2_stock,SUM(fac1_stock+fac2_stock)AS sum_all  FROM product   ";
$rs_pday = $conn->query($sql_pday);
$row_pday = $rs_pday->fetch_assoc();
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
    
        <!-- =============== Header End ================-->
        <!-- side bar menu -->
 
        <!-- =============== Left side End ================-->

        <!-- =============== Horizontal bar End ================-->
        <div class="main-content-wrap d-flex flex-column">
            <!-- ============ Body content start ============= -->
            <!-- ============ Tab Menu ============= -->
        
            <div class="tab-content">
                <div class="main-content">
                
               
            

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
                                                                         
                                                                            <th scope="col" class="text-left">มูลค่าขาย</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $sql4 = "SELECT *  FROM product where  ptype_id<>'TF0'  ORDER BY fac1_stock DESC ";
                                                                        $result4 = mysqli_query($conn, $sql4);
                                                                        if (mysqli_num_rows($result4) > 0) {
                                                                            while ($row4 = mysqli_fetch_assoc($result4)) {
                                                                        ?>

                                                                                <tr>
                                                                                    <th scope="row"><?= ++$idx; ?></th>
                                                                                    <td class="text-left"> <?= $row4['product_id'] ?></td>
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
                                                                                        $sql_dev = "SELECT sum(dev_qty) AS dev_qty,sum(total_price) AS total_price  FROM deliver_detail  where  product_id='$row4[product_id]' ";
                                                                                        $rs_dev = $conn->query($sql_dev);
                                                                                        $row_dev = $rs_dev->fetch_assoc();

                                                                                        ?>
                                                                                        <?= $row4['product_name'] ?></td>
                                                                                    <td class="text-left"><?php echo number_format($row4['fac1_stock'], '0', '.', ',') ?></td>
                                                                                    <td class="text-left"><?php echo number_format($row4['fac2_stock'], '0', '.', ',') ?></td>
                                                                                    <td class="text-left"><?php echo number_format($row_po['a_type'], '0', '.', ',') ?></td>
                                                                                    <td class="text-left"><?php echo number_format($row_dev['dev_qty'], '0', '.', ',') ?></td>
                                                                                   
                                                                                    
                                                                                    <td class="text-left"><?php echo number_format($row_dev['total_price'], '2', '.', ',') ?></td>
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