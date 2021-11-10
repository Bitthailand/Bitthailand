<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
$emp_id = $_SESSION["username"];
$order_id = $_REQUEST['order_id'];
$dev_id = $_REQUEST['dev_id'];
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
                        <h4 class="h5 font-weight-bold"> ภาพรวมข้อมูลยอดขาย
                        </h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="linkLoadModalNext nav-link" href="/report_sale_year.php">
                        <h4 class="h5 font-weight-bold"> รายงานยอดขายรายปี
                        </h4>
                    </a>
                </li>

            </ul>
            <div class="tab-content">
                <div class="main-content">

                    <div class="breadcrumb">
                        <h1 class="mr-2">ข้อมูลยอดขาย
                        </h1>
                        <ul>
                            <li><a href="">ภาพรวมยอดขาย</a></li>

                        </ul>
                    </div>

                    <?php
                    $sql_dev = "SELECT * FROM delivery   where order_id='$order_id'  AND dev_id='$dev_id' order by dev_id ASC ";
                    $result_dev = mysqli_query($conn, $sql_dev);
                    if (mysqli_num_rows($result_dev) > 0) {
                        while ($row_dev = mysqli_fetch_assoc($result_dev)) { ?>
                            <!-- รายการส่งสินค้า -->
                            <div class="card mt-3">
                                <div class="col-mb-12 col-12 mb-2 pt-2">
                                    <h4 class="text-muted"><span class="text-success"> รายการส่งสินค้า</span></h4>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4 col-12 mb-2">
                                            รหัสส่งสินค้า :
                                            <span class="ml-1 text-primary font-weight-bold"><?= $row_dev['dev_id'] ?></strong>
                                        </div>
                                        <div class="col-md-4 col-12 mb-2">
                                            วันที่ส่งสินค้า :
                                            <strong><?php $date = explode(" ", $row_dev['dev_date']);
                                                    $dat = datethai2($date[0]);
                                                    echo $dat ?></strong>
                                        </div>
                                        <div class="col-md-4 col-12 mb-2">
                                            พนักงานส่ง : <?php $sql_emp = "SELECT * FROM employee_check   WHERE id= '$row_dev[dev_employee]'";
                                                            $rs_emp = $conn->query($sql_emp);
                                                            $row_emp = $rs_emp->fetch_assoc(); ?>
                                            <strong class="font-weight-bold text-primary"><?= $row_emp['name'] ?></strong>
                                        </div>
                                        <div class="col-md-8">
                                            พนักงานตรวจสอบ :<?php $sql_emp = "SELECT * FROM employee_check   WHERE id= '$row_dev[dev_check]'";
                                                            $rs_emp = $conn->query($sql_emp);
                                                            $row_emp = $rs_emp->fetch_assoc(); ?>
                                            <strong class="font-weight-bold text-primary"><?= $row_emp['name'] ?></strong>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <table class="table table-hover text-nowrap table-sm">
                                        <thead class="bg-gray-300">
                                            <tr>
                                                <th scope="col" class="text-center">No.</th>
                                                <th scope="col" class="text-center">รหัสสินค้า/รายละเอียด</th>
                                                <th scope="col" class="text-center">จำนวน</th>
                                                <th scope="col" class="text-center">หน่วยละ</th>
                                                <th scope="col" class="text-center">ส่วนลด</th>
                                                <th scope="col" class="text-center">จำนวนเงิน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql_detail = "SELECT * FROM deliver_detail  INNER JOIN product_type  ON deliver_detail.ptype_id=product_type.ptype_id  AND  deliver_detail.order_id='$order_id'  AND deliver_detail.dev_id='$dev_id' ORDER BY  product_type.num_orderby,deliver_detail.date_create ASC ";
                                            $result_detail = mysqli_query($conn, $sql_detail);
                                            if (mysqli_num_rows($result_detail) > 0) {
                                                while ($row_detail = mysqli_fetch_assoc($result_detail)) { ?>
                                                    <tr>
                                                        <td scope="row" class="text-center"><?= ++$id7; ?></td>
                                                        <td> <?php $sql_pro = "SELECT * FROM product  WHERE product_id= '$row_detail[product_id]'";
                                                                $rs_pro = $conn->query($sql_pro);
                                                                $row_pro = $rs_pro->fetch_assoc();
                                                                $sql_unit = "SELECT * FROM unit  WHERE id= '$row_pro[units]' ";
                                                                $rs_unit = $conn->query($sql_unit);
                                                                $row_unit = $rs_unit->fetch_assoc();
                                                                if ($row_detail['ptype_id'] == 'TF') {
                                                                    echo 'ค่าจัดส่ง' . '(' . $row_pro['product_name'] . ')';
                                                                } else {
                                                                    echo $row_pro['product_name'];
                                                                }
                                                                $sum_dis = $row_detail['unit_price'] - $rowx3['disunit'];
                                                                $sum_total = $sum_dis * $row_detail['dev_qty'];
                                                                $total_all = $total_all + $sum_total;
                                                                ?>
                                                        </td>
                                                        <td class="text-right"><?= $row_detail['dev_qty'] ?> <?= $row_unit['unit_name'] ?> </td>
                                                        <td class="text-right"><?php echo number_format($row_detail['unit_price'], '2', '.', ',') ?></td>
                                                        <td class="text-right"><?php echo number_format($rowx3['disunit'], '2', '.', ',') ?></td>
                                                        <td class="text-right"><?php echo number_format($sum_total, '2', '.', ',') ?></td>
                                                    </tr>
                                            <?php }
                                            } ?>


                                        </tbody>
                                    </table>
                                    <div class="col-md-12">
                                        <div class="invoice-summary">
                                            <?php

                                            $sql_ai = "SELECT * FROM ai_number  WHERE order_id= '$order_id'";
                                            $rs_ai = $conn->query($sql_ai);
                                            $row_ai = $rs_ai->fetch_assoc();

                                           
                                            $sub_total = $total_all - $row_dev['discount'];
                                            if($row_dev['ai_count']==''){
                                                $sub_total_ai=$sub_total-$row_ai['price'];
                                            }else{
                                                $sub_total_ai=$sub_total-$row_dev['ai_count'];
                                            }
                                            $first_total = ($sub_total_ai * 100) / 107;
                                            $tax = ($sub_total_ai - $first_total);
                                            $grand_total = ($sub_total_ai - $tax);
                                            ?>
                                            <p style="margin-bottom: 0;">รวมเป็นเงินทั้งสิ้น <span><?php echo number_format($total_all, '2', '.', ',') ?></span></p>
                                            <p style="margin-bottom: 0;">หัก ส่วนลด <span><?php echo number_format($row_dev['discount'], '2', '.', ',') ?></span></p>
                                            <p style="margin-bottom: 0;">ยอดหลังหักส่วนลด <span><?php echo number_format($sub_total, '2', '.', ',') ?></span></p>
                                            <p style="margin-bottom: 0;">หักมัดจำ <span><?php   if($row_dev['ai_count']==''){ echo number_format($row_ai['price'], '2', '.', ','); } else{ echo number_format($row_dev['ai_count'], '2', '.', ','); }   ?></span></p>
                                           
                                            <p style="margin-bottom: 0;">จำนวนเงินรวมทั้งสิ้น<span><?php echo number_format($sub_total_ai, '2', '.', ',') ?></span></p>
                                            <p>จำนวนภาษีมูลค่าเพิ่ม 7% <span><?php echo number_format($tax, '2', '.', ',') ?></span></p>
                                            <p>รวมเป็นเงิน <span><?php echo number_format($grand_total, '2', '.', ',') ?></span></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">

                                            <div class="col-md-5">

                                            </div>
                                            <div class="col-md-4 text-right">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-2 mt-3 pt-2 border-warning border-top">
                                        <br>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } ?>
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