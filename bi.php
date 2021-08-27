<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config_text.php';
// include './include/config_date.php';
$bi_id = $_REQUEST['bi_id'];
$bi_number = $_REQUEST['bi_id'];



// $sql_bi = "SELECT * FROM bi_number  WHERE bi_number= '$bi_number'";
// $rs_bi = $conn->query($sql_bi);
// $row_bi = $rs_bi->fetch_assoc();

// $sql_dev = "SELECT * FROM delivery WHERE dev_id= '$row_bi[dev_id]'";
// $rs_dev = $conn->query($sql_dev);
// $row_dev = $rs_dev->fetch_assoc();
// echo "$row_bi[iv_id]";
?>

<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Quotation | ใบเสนอราคา</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />


    <style>
        p {
            margin-top: 0;
            margin-bottom: 0.1rem;
        }

        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
            font-size: 0.813rem !important;
        }
    </style>
</head>
<?php
include './include/config.php';
$bi_id = $_REQUEST['bi_id'];
$emp_id = $_SESSION["username"];
$datetoday = date('Y-m-d');
$sql = "SELECT * FROM bi_number  WHERE bi_number= '$bi_id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
// ====
// echo"$order_id";
// echo"$row[cus_type]";
$sql3 = "SELECT * FROM customer  WHERE customer_id= '$row[cus_id]'";
$rs3 = $conn->query($sql3);
$row3 = $rs3->fetch_assoc();

$sql2 = "SELECT * FROM customer_type  WHERE id= '$row3[cus_type]'";
$rs2 = $conn->query($sql2);
$row2 = $rs2->fetch_assoc();
$datetoday = date('Y-m-d');
// ====
// echo $row['status_bi'];


if ($row['status_bi'] == 2) {
    $sql_re = "SELECT * FROM re_number  WHERE bi_number= '$bi_id'";
    $rs_re = $conn->query($sql_re);
    $row_re = $rs_re->fetch_assoc();
    $bi_status = $row['status_bi'];
    $re_id = $row['re_id'];
    $datetoday = $row_re['re_date'];
    $payment = $row_re['payment'];
} else {
    $datemonth = date('Y-m');
    $sql5 = "SELECT COUNT(id) AS id_run FROM re_number where datemonth='$datemonth'  ";
    $rs5 = $conn->query($sql5);
    $row_run = $rs5->fetch_assoc();
    $datetodat = date('Y-m-d');
    $date = explode(" ", $datetodat);
    $dat = datethai_RE1($date[0]);
    $code_new = $row_run['id_run'] + 1;
    $code = sprintf('%03d', $code_new);
    $re_id = $dat . $code;
}
$action = $_REQUEST['action'];
if ($action == 'add') {
    $bi_number = $_REQUEST['bi_number'];
    $re_id = $_REQUEST['re_id'];
    $re_date = $_REQUEST['re_date'];
    $payment = $_REQUEST['payment'];
    $re_qty = $_REQUEST['re_qty'];
    $sqlx = "SELECT * FROM re_number  WHERE re_number='$re_id' ";
    $result = mysqli_query($conn, $sqlx);
    if (mysqli_num_rows($result) > 0) { ?>
        <script>
            $(document).ready(function() {
                showAlert("ข้อมูลซ้ำไม่สามารถบันทึกได้", "alert-danger");
            });
        </script>
        <?php
    } else {
        // echo"$re_id<br>";
        // echo "$bi_number<br>";
        // echo"$re_date<br>";
        // echo"$datemonth<br>";
        // echo"$payment<br>"; echo"$re_qty<br>";
        $datemonth = date('Y-m');
        $sql_bi = "SELECT * FROM bi_number  WHERE bi_number= '$bi_number'";
        $rs_bi = $conn->query($sql_bi);
        $row_bi = $rs_bi->fetch_assoc();

        $sql_dev = "SELECT * FROM delivery WHERE dev_id= '$row_bi[dev_id]'";
        $rs_dev = $conn->query($sql_dev);
        $row_dev = $rs_dev->fetch_assoc();
        // echo "$row_bi[dev_id]";
        $sql = "INSERT INTO re_number (bi_number,re_number,re_date,datemonth,payment,re_qty)
        VALUES ('$bi_number','$re_id','$re_date','$datemonth','$payment','$re_qty')";

        $sql2 = "UPDATE bi_number  SET status_bi='2',re_id='$re_id'  where bi_number='$bi_number'";

        $sql6 = "SELECT *  FROM  bi_number  WHERE bi_number= '$bi_number' ";
        $result6 = mysqli_query($conn, $sql6);
        if (mysqli_num_rows($result6) > 0) {
            while ($row6 = mysqli_fetch_assoc($result6)) {

                $sql_dev = "SELECT * FROM delivery WHERE iv_id= '$row6[iv_id]'";
                $rs_dev = $conn->query($sql_dev);
                $row_dev = $rs_dev->fetch_assoc();
                // echo "$row_dev[order_id]";
                $sql3 = "UPDATE orders  SET order_status='5'  where order_id='$row_dev[order_id]'";
                if ($conn->query($sql3) === TRUE) {
                }
            }
        }
       
        if ($conn->query($sql2) === TRUE) {
        }
        
        if ($conn->query($sql) === TRUE) {  ?>
            <script>
                $(document).ready(function() {
                    showAlert("บันทึกข้อมูลสำเร็จ", "alert-success");
                    // window.location='customer.php?status_confirm=add'
                });
            </script>
<?php   }
    }
}

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
            <!-- แจ้งเตือน -->
            <div id="alert_placeholder" style="z-index: 9999999; left:1px; top:1%; width:100%; position:absolute;"></div>
            <!-- ปิดการแจ้งเตือน -->
            <div class="main-content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="tab-content">
                            <div class="card">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">

                                        <form action="" method="post" name="form1" id="form1">
                                            <!-- -===== Print Area =======-->
                                            <div id="print-area">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h4 class="font-weight-bold">บริษัท วันเอ็ม จำกัด</h4>
                                                        <p>290 ม.1 ต.กระโสบ อ.เมือง จ.อุบลราชธานี 34000</p>
                                                        <p>เลขที่ประจำตัวผู้เสียภาษี 0345555000224 สำนักงานใหญ่</p>
                                                    </div>
                                                    <div class="col-md-6 text-sm-right">
                                                        <h4 class="font-weight-bold">ใบวางบิล</h4>
                                                    </div>
                                                </div>
                                                <div class="mt-3 mb-4 border-top"></div>
                                                <div class="row mb-5">
                                                    <div class="col-md-6 mb-3 mb-sm-0">
                                                        <h5 class="font-weight-bold">ลูกค้า</h5>
                                                        <?php
                                                        $sql6 = "SELECT * FROM districts  WHERE id= '$row3[subdistrict]'";
                                                        $rs6 = $conn->query($sql6);
                                                        $row6 = $rs6->fetch_assoc();
                                                        $sql7 = "SELECT * FROM amphures  WHERE id= '$row3[district]'";
                                                        $rs7 = $conn->query($sql7);
                                                        $row7 = $rs7->fetch_assoc();
                                                        $sql8 = "SELECT * FROM provinces  WHERE id= '$row3[province]'";
                                                        $rs8 = $conn->query($sql8);
                                                        $row8 = $rs8->fetch_assoc();

                                                        ?>
                                                        <p><strong>ชื่อลูกค้า : </strong>คุณ <?= $row3['customer_name'] ?></p>
                                                        <p><strong>บริษัท : </strong>คุณ <?= $row3['company_name'] ?></p>
                                                        <p><strong>ที่อยู่ : </strong><?php echo $row3['bill_address'] . " ต" . $row6['name_th'] . "  อ." . $row7['name_th'] . " จ." . $row8['name_th']; ?> </p>
                                                        <p><strong>โทร : </strong> <?= $row3['tel'] ?></p>
                                                        <p><strong>อ้างอิง : </strong><?= $row3['contact_name'] ?></p>
                                                        <p> </p>
                                                    </div>
                                                    <div class="col-md-6 text-sm-right">
                                                        <h5 class="font-weight-bold"></h5>
                                                        <div class="invoice-summary">
                                                            <div class="form-group col-md-12">
                                                                <label for="ai_id"><strong>เลขที่ใบวางบิล <span class="text-danger"></span></strong></label>
                                                                <p><span><?php echo "$row[bi_number]"; ?></span></p>
                                                                <input type="hidden" name="bi_number" value="<?= $bi_id ?>" class="classcus form-control">
                                                            </div>

                                                            <div class="form-group col-md-12">
                                                                <label for="ai_id"><strong>เลขที่ใบเสร็จรับเงิน (RE) <span class="text-danger"></span></strong></label>
                                                                <input type="text" name="re_id" value="<?= $re_id ?>" class="classcus form-control" id="so_id" placeholder="เลขที่ใบส่งของ">
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="delivery_date">วันที่ออกใบเสร็จ</label>
                                                                <input id="re_date" class="form-control" type="date" require min="<?= $datetoday ?>" name="re_date" value="<?= $datetoday ?>">
                                                            </div>

                                                            <div class="form-group col-md-12">
                                                                <label for="delivery_date">การชำระเงิน</label>
                                                                <select class="classcus custom-select" name="payment" required>
                                                                    <?php
                                                                    $sql6 = "SELECT *  FROM payment  order by name DESC ";
                                                                    $result6 = mysqli_query($conn, $sql6);
                                                                    if (mysqli_num_rows($result6) > 0) {
                                                                        while ($row6 = mysqli_fetch_assoc($result6)) {
                                                                    ?>
                                                                            <option value="<?php echo $row6['id'] ?>" <?php
                                                                                                                        if (isset($payment) && ($payment == $row6['id'])) {
                                                                                                                            echo "selected"; ?>>
                                                                            <?php echo "$row6[name]";
                                                                                                                        } else {      ?>
                                                                            <option value="<?php echo $row6['id']; ?>"> <?php echo $row6['name'];  ?>
                                                                            <?php } ?>
                                                                            </option>
                                                                    <?php  }
                                                                    }  ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 table-responsive">
                                                        <table class="table table-hover mb-4">
                                                            <thead class="bg-gray-300">
                                                                <tr>
                                                                    <th scope="col" class="text-center">No.</th>
                                                                    <th scope="col" class="text-center">เลขที่ใบกำกับ</th>
                                                                    <th scope="col" class="text-center">วันที่</th>
                                                                    <th scope="col" class="text-center">ครบกำหนด</th>
                                                                    <th scope="col" class="text-center">จำนวนเงิน</th>
                                                                    <th scope="col" class="text-center">ชำระแล้ว</th>
                                                                    <th scope="col" class="text-center">เงินคงค้าง</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $sql_pro = "SELECT * FROM bi_number  where bi_number='$bi_id' order by id ASC ";
                                                                $result_pro = mysqli_query($conn, $sql_pro);
                                                                if (mysqli_num_rows($result_pro) > 0) {
                                                                    while ($row_pro = mysqli_fetch_assoc($result_pro)) { ?>
                                                                        <tr>
                                                                            <th scope="row" class="text-center"><?= ++$id; ?></th>
                                                                            <td class="text-center"><?= $row_pro['iv_id'] ?>
                                                                                <?php
                                                                                $sql_dev = "SELECT * FROM delivery  WHERE iv_id= '$row_pro[iv_id]'";
                                                                                $rs_dev = $conn->query($sql_dev);
                                                                                $row_dev  = $rs_dev->fetch_assoc();
                                                                                $sql_dev_detail = "SELECT  SUM(dev_qty*unit_price) AS total FROM deliver_detail  WHERE dev_id= '$row_dev[dev_id]'";
                                                                                $rs_dev_detail = $conn->query($sql_dev_detail);
                                                                                $row_dev_detail  = $rs_dev_detail->fetch_assoc();

                                                                                ?>
                                                                            </td>
                                                                            <td class="text-center"> <?php
                                                                                                        $date = explode(" ", $row_dev['dev_date']);
                                                                                                        $dat = datethai2($date[0]);
                                                                                                        echo "$dat";
                                                                                                        ?>
                                                                            </td>
                                                                            <td class="text-center"><?php
                                                                                                    $date = explode(" ", $row_dev['date_end']);
                                                                                                    $dat = datethai2($date[0]);
                                                                                                    echo "$dat";
                                                                                                    ?></td>
                                                                            <td class="text-center"><?php echo number_format($row_dev_detail['total'], '2', '.', ',') ?></td>
                                                                            <td class="text-center"><?php echo number_format($row_dev['ai_count'], '2', '.', ',') ?>
                                                                            <td class="text-center">
                                                                                <?php $sum_total = $row_dev_detail['total'] - $row_dev['ai_count'];
                                                                                echo number_format($sum_total, '2', '.', ',');
                                                                                $grand_total = $grand_total + $sum_total;
                                                                                ?>

                                                                            </td>
                                                                        </tr>
                                                                <?php }
                                                                } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <p>ตัวอักษร :</p>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <p><?php echo Convert2($grand_total); ?></p>
                                                            </div>
                                                            <div class="col-md-4 text-right">
                                                                <div class="row" style="justify-content: flex-end; margin-right: 0;">
                                                                    <p>รวมเป็นเงิน</p>
                                                                    <input type="hidden" name="re_qty" value="<?= $grand_total ?>" class="classcus form-control">
                                                                    <h5 class="font-weight-bold" style="width: 120px; display: inline-block;"> <span><?php echo number_format($grand_total, '2', '.', ',') ?></span></h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-3 mb-4 border-top"></div>
                                                <div class="d-sm-flex mb-5" data-view="print">
                                                    <span class="m-auto"></span>
                                                    <?php if ($row['status_bi'] == 2) { ?>
                                                        <a class="btn btn-outline-primary m-1" href="/re_view.php?re_id=<?= $re_id ?>" type="button" target="_blank">พิมพ์ใบเสร็จรับเงิน (RE)</a>
                                                    <?php } else { ?>
                                                        <input type="hidden" name="action" value="add">
                                                        <button id="btu1" class="btn btn-outline-primary m-1" data-style="expand-left">
                                                            <span class="ladda-label">บันทึกใบเสร็จรับเงิน (RE)</span>
                                                        </button>
                                                    <?php } ?>
                                                    <!-- <a class="btn btn-outline-primary m-1" id="btu1"  href="#" type="button">บันทึกใบมัดจำ</a> -->
                                                </div>
                                            </div>
                                            <div class="mt-3 mb-4 border-top"></div>

                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-4 text-center">
                                                        <p>ชื่อผู้รับวางบิล ____________________________</p>
                                                        <br>
                                                        <p>วันที่รับ ________/__________/_____ <span></span></p>
                                                        <p>วันที่นัดรับเช็ค ________/__________/__________ <span></span></p>
                                                    </div>
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-5 text-center">
                                                        <p>ในนาม บริษัท วันเอ็ม จำกัด</p>
                                                        <br>
                                                        <p>ผู้รับวางบิล ____________________ <span></span></p>
                                                        <br>
                                                        <p>วันที่ ________/__________/__________ <span></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <!-- ==== / Print Area =====-->
                                    </form>
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
                        <script src="../../dist-assets/js/scripts/dashboard.v1.script.min.js"></script>
                        <script src="../../dist-assets/js/scripts/customizer.script.min.js"></script>
</body>

</html>