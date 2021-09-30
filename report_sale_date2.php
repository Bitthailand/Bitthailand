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
    <link rel="stylesheet" href="../../dist-assets/css/plugins/datatables.min.css" />

</head>
<?php
include './include/connect.php';
include './include/config.php';
include './get_dashbord_sale_year.php';
$MyMonth = $_REQUEST['MyMonth'];
$datex = date($MyMonth);
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
                    <a class="linkLoadModalNext nav-link " href="/report_sale.php">
                        <h4 class="h5 font-weight-bold"> ภาพรวมข้อมูลยอดขาย
                        </h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="linkLoadModalNext nav-link active" href="/report_sale_year.php">
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
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="ul-widget__head">
                                                <div class="ul-widget__head-label">
                                                    <h3 class="ul-widget__head-title">รายการสั่งผลิตสินค้าแบบรายเดือน <?= $MyMonth ?> </h3>
                                                </div>
                                                <a class="btn btn btn-success mb-2 mr-2" href="/report_sale_excel.php?MyMonth=<?= $MyMonth ?>">export excel</a>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-hover text-nowrap table-sm" id="example">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 16.66%">ลำดับ</th>
                                                            <th style="width: 16.66%">ชื่อลูกค้า</th>
                                                            <th style="width: 16.66%">ผู้ติดต่อ</th>
                                                            <th style="width: 16.66%">สถานที่จัดส่งสินค้า</th>
                                                            <th style="width: 16.66%">เบอร์โทร</th>
                                                            <th style="width: 16.66%">สินค้า</th>
                                                            <th style="width: 16.66%">ค่าจัดส่ง</th>
                                                            <th style="width: 16.66%">ยอดรวม</th>
                                                            <th style="width: 16.66%">วันส่งของ</th>
                                                            <th style="width: 16.66%">ใบเสนอราคา</th>
                                                            <th style="width: 16.66%">ใบกำกับภาษี</th>
                                                            <th style="width: 16.66%">คนส่ง</th>
                                                            <th style="width: 16.66%">คนตรวจสอบ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $sql4 = "SELECT  DATE_FORMAT(dev_date, '%Y-%m-%d') AS DATE,cus_id AS cus_id ,dev_id AS dev_id,dev_date AS dev_date, order_id AS order_id  FROM delivery WHERE  status_chk='1' AND status_payment='1'   AND MONTH(dev_date) = '$d[1]' AND YEAR(dev_date) = '$d[0]' ORDER BY DATE DESC";
                                                        $result4 = mysqli_query($conn, $sql4);
                                                        if (mysqli_num_rows($result4) > 0) {
                                                            while ($row4 = mysqli_fetch_assoc($result4)) {
                                                                $d = explode("-", $row4['DATE']);
                                                                $sql_cus = "SELECT * FROM customer  WHERE customer_id='$row4[cus_id]'  ";
                                                                $rs_cus = $conn->query($sql_cus);
                                                                $row_cus = $rs_cus->fetch_assoc();

                                                                $sql_TF = "SELECT * FROM deliver_detail  WHERE dev_id='$row4[dev_id]' AND ptype_id='TF'  ";
                                                                $rs_TF = $conn->query($sql_TF);
                                                                $row_TF = $rs_TF->fetch_assoc();
                                                                $sql_pTF = "SELECT * FROM product  WHERE product_id='$row_TF[product_id]'  ";
                                                                $rs_pTF = $conn->query($sql_pTF);
                                                                $row_pTF = $rs_pTF->fetch_assoc();
                                                                $sql6 = "SELECT * FROM districts  WHERE id= '$row_cus[subdistrict]'";
                                                                $rs6 = $conn->query($sql6);
                                                                $row6 = $rs6->fetch_assoc();
                                                                $sql7 = "SELECT * FROM amphures  WHERE id= '$row_cus[district]'";
                                                                $rs7 = $conn->query($sql7);
                                                                $row7 = $rs7->fetch_assoc();
                                                                $sql8 = "SELECT * FROM provinces  WHERE id= '$row_cus[province]'";
                                                                $rs8 = $conn->query($sql8);
                                                                $row8 = $rs8->fetch_assoc();
                                                                if ($row3['province'] == 1) {
                                                                    $t = 'แขวง';
                                                                    $a = '';
                                                                } else {
                                                                    $t = 'ต.';
                                                                    $a = 'อ.';
                                                                }

                                                                if ($row_pTF['product_name'] == '') {
                                                                    $address = $row3['bill_address'] . " $t" . $row6['name_th'] . "  $a" . $row7['name_th'] . " จ." . $row8['name_th'];
                                                                } else {
                                                                    if ($row4['cus_back'] == 1 || $row4['cus_back'] == 3) {
                                                                        $address = $row3['bill_address'] . " $t" . $row6['name_th'] . "  $a" . $row7['name_th'] . " จ." . $row8['name_th'];
                                                                    } else {
                                                                        $address = $row_pTF['product_name'];
                                                                    }
                                                                }
                                                                $sql_dev = "SELECT * FROM deliver_detail  WHERE dev_id='$row4[dev_id]'";
                                                                $rs_dev  = $conn->query($sql_dev);
                                                                $row_dev  = $rs_dev->fetch_assoc();
                                                        ?>
                                                                <tr>
                                                                    <th scope="row"><?= ++$idx; ?></th>
                                                                    <td class="text-left"> <?php echo "$row_cus[customer_name]"; ?> </td>
                                                                    <td class="text-left"> <?php echo "$row_cus[contact_name]"; ?> </td>
                                                                    <td class="text-left"> <?php echo "$address"; ?> </td>
                                                                    <td class="text-left"> <?php
                                                                                            $tel = explode(" ", $row_cus['tel']);
                                                                                            echo "$tel[0]";
                                                                                            ?></td>
                                                                    <td class="text-left">
                                                                        <?php
                                                                        $sql_dev1 = "SELECT * FROM deliver_detail  WHERE dev_id='$row4[dev_id]' AND ptype_id <>'TF'";
                                                                        $result_dev1 = mysqli_query($conn, $sql_dev1);
                                                                        while ($row_dev1 = mysqli_fetch_assoc($result_dev1)) {
                                                                            // echo"$row_dev1[dev_id]";
                                                                            $sql_pro = "SELECT * FROM product  WHERE product_id='$row_dev1[product_id]'";
                                                                            $rs_pro  = $conn->query($sql_pro);
                                                                            $row_pro  = $rs_pro->fetch_assoc();
                                                                            $sql_unit = "SELECT * FROM unit  WHERE id='$row_pro[units]'";
                                                                            $rs_unit = $conn->query($sql_unit);
                                                                            $row_unit  = $rs_unit->fetch_assoc();

                                                                            $st = $row_pro['product_name'] . ' ' . $row_dev1['dev_qty'] . ' ' . $row_unit['unit_name'] . ',<br> ';

                                                                            echo $st;
                                                                        }
                                                                        ?></td>
                                                                    <td class="text-left">
                                                                        <?php
                                                                        $sql_tf = "SELECT SUM(total_price) AS  total_price  FROM deliver_detail  WHERE dev_id='$row4[dev_id]' AND ptype_id ='TF'";
                                                                        $result_tf = mysqli_query($conn, $sql_tf);
                                                                        while ($row_tf = mysqli_fetch_assoc($result_tf)) {
                                                                            echo number_format($row_tf['total_price'], '2', '.', ',');
                                                                        }
                                                                        ?></td>
                                                                    <td class="text-left">
                                                                        <?php
                                                                        $sql_tf = "SELECT SUM(total_price) AS  total_price  FROM deliver_detail  WHERE dev_id='$row4[dev_id]' ";
                                                                        $result_tf = mysqli_query($conn, $sql_tf);
                                                                        while ($row_tf = mysqli_fetch_assoc($result_tf)) {
                                                                            echo number_format($row_tf['total_price'], '2', '.', ',');
                                                                        }
                                                                        ?></td>
                                                                    <td class="text-center">
                                                                        <?php $date = explode(" ", $row4['dev_date']);
                                                                        $dat = datethai2($date[0]);
                                                                        echo $dat ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php $sql_quo = "SELECT * FROM quotation  WHERE  order_id='$row4[order_id]'";
                                                                        $rs_quo = $conn->query($sql_quo);
                                                                        $row_quo  = $rs_quo->fetch_assoc();
                                                                        echo "$row_quo[qt_number]";
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php $sql_de = "SELECT * FROM delivery  WHERE dev_id='$row4[dev_id]' AND order_id='$row4[order_id]'";
                                                                        $rs_de = $conn->query($sql_de);
                                                                        $row_de  = $rs_de->fetch_assoc();
                                                                        if ($row_de['hs_id'] == '0') {
                                                                        } else {
                                                                            echo "$row_de[hs_id]";
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php $sql_emp = "SELECT * FROM employee_check WHERE id='$row_de[dev_employee]' ";
                                                                        $rs_emp = $conn->query($sql_emp);
                                                                        $row_emp  = $rs_emp->fetch_assoc();
                                                                        echo "$row_emp[name]";
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php $sql_emp = "SELECT * FROM employee_check WHERE id='$row_de[dev_check]' ";
                                                                        $rs_emp = $conn->query($sql_emp);
                                                                        $row_emp  = $rs_emp->fetch_assoc();
                                                                        echo "$row_emp[name]";
                                                                        ?>
                                                                    </td>
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
        <script src="../../dist-assets/js/plugins/datatables.min.js"></script>
        <script src="../../dist-assets/js/scripts/datatables.script.min.js"></script>
</body>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "scrollX": true,
            "columns": columns,
            "scrollX": true,
            "ordering": false,
            "fixedColumns": {
                leftColumns: 1,
                rightColumns: 1
            }

        });
    });
</script>

</html>