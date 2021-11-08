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
    <title>รายงานใบเสนอราคา</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../dist-assets/css/plugins/datatables.min.css" />

</head>
<?php
$datetodat = date('Y-m-d');
$strExcelFileName = "QT-$datetodat.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");

header("Pragma:no-cache");
?>
<?php
include './include/connect.php';
include './include/config.php';
include './get_dashbord_sale_year.php';
// $MyMonth = $_REQUEST['MyMonth'];
// $datex = date($MyMonth);
// $d = explode("-", $datex);

?>

<body class="text-left">
    <div class="app-admin-wrap layout-horizontal-bar">

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card mb-4">
                            <div class="card-body ">

                                <br>
                                <div id="SiXhEaD_Excel" align=center x:publishsource="Excel">
                                    <div class="table-responsive">

                                        <table width="100%" border="1" align="center" cellpadding="1" cellspacing="0" class="table table-hover text-nowrap table-sm" id="example">
                                            <thead>
                                                <tr>
                                                    <td class="text-center" colspan="13">
                                                        <h2> <strong>รายงานใบเสนอราคาทั้งหมด </strong></h2>
                                                    </td>
                                                </tr>
                                            </thead>
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
                                                    <th scope="col" class="text-right">วันที่เสนอราคา</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $sql4 = "SELECT  orders.cus_id AS cus_id, orders.order_id  AS order_id , orders.cus_type AS cus_type,orders.cus_back AS cus_back, orders.order_status AS order_status ,orders.qt_id  AS qt_id ,orders.qt_date  AS qt_date  FROM quotation  INNER JOIN   orders   ON  quotation.order_id=orders.order_id  ORDER BY  orders.qt_id  DESC    ";
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

                                                        if ($row4['order_status'] == 1) {
                                                            $order_status = 'เสนอราคา';
                                                        }
                                                        if ($row4['order_status'] == 2) {
                                                            $order_status = 'มัดจำ';
                                                        }
                                                        if ($row4['order_status'] == 5) {
                                                            $order_status = 'จัดส่งเรียบร้อย';
                                                        }

                                                ?>

                                                        <tr>
                                                            <th scope="row"><?= ++$idx; ?></th>
                                                            <td class="text-right"><?php echo $row4['order_id']; ?> </td>
                                                            <td class="text-right"><?php echo $row4['qt_id']; ?> </td>
                                                            <td class="text-left"><?php echo $row_cus['customer_name']; ?></td>
                                                            <td class="text-left"><?php echo $row_custype['name']; ?></td>
                                                            <td class="text-left"><?php echo $row_cusback['name']; ?></td>
                                                            <td class="text-left"><?php echo $order_status; ?></td>
                                                            <td class="text-right"><?php echo number_format($row_sumx['sum'], '2', '.', ',');
                                                                                    $sum_dev = $sum_dev + $row_sumx['sum']; ?></td>

                                                            <td class="text-right"><?php echo number_format($row_ai['price'], '2', '.', ',');
                                                                                    $sum_total = $sum_total + $row_ai['price']; ?></td>
                                                            <td class="text-right"><?php echo number_format($row_sumx1['sum'], '2', '.', ',');
                                                                                    $sum_total2 = $sum_total2 + $row_sumx1['sum']; ?></td>

                                                            <td class="text-left"> <?php $date = explode(" ", $row4['qt_date']);
                                                                                    $dat = datethai2($date[0]);
                                                                                    echo $dat ?> </td>

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
                                                    <th scope="col" class="text-right"></th>
                                                    <th scope="col" class="text-right"><?php echo number_format($sum_dev, '2', '.', ','); ?></th>
                                                    <th scope="col" class="text-right"><?php echo number_format($sum_total, '2', '.', ','); ?></th>
                                                    <th scope="col" class="text-right"><?php echo number_format($sum_total2, '2', '.', ','); ?></th>

                                                    <th scope="col" class="text-right"></th>
                                                    
                                                </tr>
                                            </tbody>
                                        </table>
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