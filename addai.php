<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
$emp_id=$_SESSION["username"]; 
include './include/connect.php';
include './include/config.php';
include './include/config_text.php';

$order_id = $_REQUEST['order_id'];
$datetoday = date('Y-m-d');
$sql = "SELECT * FROM orders   WHERE order_id= '$order_id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
// ====
$sql2 = "SELECT * FROM customer_type  WHERE id= '$row[cus_type]'";
$rs2 = $conn->query($sql2);
$row2 = $rs2->fetch_assoc();
// ====
$sql3 = "SELECT * FROM customer  WHERE customer_id= '$row[cus_id]'";
$rs3 = $conn->query($sql3);
$row3 = $rs3->fetch_assoc();
// ===

$strStartDate = $row['qt_date'];
$strNewDate = date("Y-m-d", strtotime("+$row[date_confirm] day", strtotime($strStartDate)));
// ============ปิดเงื่อนไขการอับเดตรหัสสินค้า
$sql5 = "SELECT MAX(id) AS id_run FROM ai_number  ";
$rs5 = $conn->query($sql5);
$row_run = $rs5->fetch_assoc();

$datetodat = date('Y-m-d');
$date = explode(" ", $datetodat);
$dat = datethai_ai($date[0]);
$code_new = $row_run['id_run'] + 1;
$code = sprintf('%05d', $code_new);
$ai_id = $dat . $code;
$input_price = $_REQUEST['input_price'];
$Finput_text = $_REQUEST['FFinput_text'];
$ai_date_start = $_REQUEST['ai_date_start'];
$ai_date_end = $_REQUEST['ai_date_end'];
$Fai_id = $_REQUEST['ai_id'];
$status_ai = $_REQUEST['status_ai'];

if ($status_ai == 1) {
    $sqlx = "SELECT * FROM ai_number   WHERE order_id='$order_id'  ";
    $result = mysqli_query($conn, $sqlx);
    if (mysqli_num_rows($result) > 0) { ?>
        <script>
            $(document).ready(function() {
                showAlert("ใบมัดจำรหัสนี้ซ้ำ", "alert-danger");
            });
        </script>
        <?php } else {
        $sqlx5 = "INSERT INTO ai_number (order_id,ai_num,messages,price)
 VALUES ('$order_id','$Fai_id','$Finput_text','$input_price')";

        $sql7 = "UPDATE orders SET is_ai='Y',ai_id='$Fai_id',ai_count='$input_price',ai_date_start='$ai_date_start',ai_date_end='$ai_date_end',order_status='2' where order_id='$order_id'";
        if ($conn->query($sql7) === TRUE) { }
        if ($conn->query($sqlx5) === TRUE) { ?>
            <script>
                $(document).ready(function() {
                    showAlert("บันทึกข้อมูลสำเร็จ", "alert-success");
                });
            </script>
<?php
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Order | เสนอราคา</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
    <style>
        p {
            margin-top: 0;
            margin-bottom: 0.1rem;
        }
    </style>
</head>
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

                                        <!-- -===== Print Area =======-->
                                        <div id="print-area">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4 class="font-weight-bold">บริษัท วันเอ็ม จำกัด</h4>
                                                    <p>290 ม.1 ต.กระโสบ อ.เมือง จ.อุบลราชธานี 34000</p>
                                                    <p>โทร 061-4362825</p>
                                                    <p>เลขที่ประจำตัวผู้เสียภาษี 0345555000224 สำนักงานใหญ่</p>
                                                </div>
                                                <div class="col-md-6 text-sm-right">
                                                    <h4 class="font-weight-bold">ใบรับเงินมัดจำ/ใบกำกับภาษี</h4>
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
                                                       if($row3['province']==1){ $t='แขวง'; $a=''; }else{ $t='ต.'; $a='อ.';  }

                                                       $sql_pro = "SELECT SUM(total_price) AS total FROM order_details   WHERE order_id= '$order_id'";
                                                       $rs_pro = $conn->query($sql_pro);
                                                       $row_pro = $rs_pro->fetch_assoc();
                                                       
                                                        ?>
                                                    <p><strong>ชื่อลูกค้า : </strong><?= $row3['customer_name'] ?></p>
                                                    <p><strong>บริษัท : </strong><?= $row3['company_name'] ?></p>
                                                    <p><strong>ที่อยู่ : </strong><?php  echo $row3['bill_address']." $t" . $row6['name_th'] . "  $a" . $row7['name_th'] . " จ." . $row8['name_th']; ?> </p>
                                                    <p>เลขที่ประจำตัวผู้เสียภาษี <?= $row3['tax_number'] ?></p>
                                                    <p><strong>โทร : </strong> <?= $row3['tel'] ?></p>
                                                    <p><strong>อ้างอิง : </strong><?= $row3['contact_name'] ?></p>
                                                </div>
                                                <div class="col-md-6 text-sm-right">
                                                    <h5 class="font-weight-bold"></h5>
                                                    <div class="invoice-summary">
                                                        <div class="form-group col-md-12">
                                                            <label for="ai_id"><strong>เลขที่ใบมัดจำ <span class="text-danger"></span></strong></label>
                                                            <input type="text" name="ai_id" value="<?= $ai_id ?>" class="classcus form-control" id="ai_id" placeholder="เลขที่ใบรับมัดจำ">
                                                        </div>
                                                        <div class="viewDateClass col pr-12 ">
                                                            <div class="form-group">
                                                                <label for="delivery_date">วันที่</label>
                                                                <input id="Fai_date_start" class="form-control" type="date" min="2021-06-01" name="ai_date_start" value="<?= $datetoday?>">
                                                            </div>
                                                        </div>
                                                        <div class="viewDateClass col pr-12 ">
                                                            <div class="form-group">
                                                                <label for="delivery_date">วันที่ครบกำหนด</label>
                                                                <input id="Fai_date_end" class="form-control" type="date" min="2021-06-01" name="ai_date_end" value="<?= $datetoday?>">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-hover mb-4">
                                                        <thead class="bg-gray-300">
                                                            <tr>
                                                                <th scope="col" class="text-center" width="5%">No.</th>
                                                                <th scope="col" class="text-center" width="75%">รายการ</th>
                                                                <th scope="col" class="text-center" width="20%">ราคารวมภาษี</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row" class="text-center">1</th>
                                                                <td><input class="form-control" type="text" id="Finput_text" name="Finput_text" value="<?= $Finput_text ?>" placeholder="รับรายได้มัดจำ"></td>
                                                                <td class="text-right"><input class="form-control" id="input_price" name="input_price" value="<?= $input_price ?>" type="number" placeholder="ค่ามัดจำ"></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" class="text-center"></th>
                                                                <td></td>
                                                                <td class="text-right"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="invoice-summary">
                                                        <p>จำนวนเงินค่าสินค้ารวมทั้งสิ้น <span><?php echo number_format($row_pro['total'], '2', '.', ',') ?></span></p>
                                                        <p>จำนวนเงินมัดจำรวมทั้งสิ้น <span><?php echo number_format($input_price, '2', '.', ',') ?></span></p>
                                                        <p>จำนวนภาษีมูลค่าเพิ่ม 7.00% <?php $tax = ($input_price * 100)/107;
                                                                                        $tax2 = ($input_price - $tax);
                                                                                        $grand_total = ($input_price- $tax2);
                                                                                        ?><span><?php echo number_format($tax2, '2', '.', ',') ?></span></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <p>ตัวอักษร :</p>
                                                        </div>
                                                        <div class="col-md-5">

                                                            <p> <?php echo Convert2($input_price); ?></p>
                                                        </div>
                                                        <div class="col-md-4 text-right">
                                                            <div class="row" style="justify-content: flex-end; margin-right: 0;">
                                                                <p>ราคาสินค้า</p>
                                                                <h5 class="font-weight-bold" style="width: 120px; display: inline-block;"> <span><?php echo number_format($grand_total, '2', '.', ',') ?></span></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- ==== / Print Area =====-->
                                        <div class="mt-3 mb-4 border-top"></div>
                                        <br>
                                        <div class="d-sm-flex mb-5" data-view="print">
                                            <span class="m-auto"></span>
                                            <?php if ($status_ai == 1) { ?>
                                                <button id="btu" class="btn btn-outline-primary m-1" onclick="window.location.href='ai.php?order_id=<?=$order_id?>', '_blank'">พิมพ์ใบมัดจำ</button>
                                            <?php } else { ?>
                                                <button id="btu1" class="btn btn-outline-primary m-1" data-style="expand-left">
                                                    <span class="ladda-label">บันทึกใบมัดจำ</span>
                                                </button>
                                            <?php } ?>
                                            <!-- <a class="btn btn-outline-primary m-1" id="btu1"  href="#" type="button">บันทึกใบมัดจำ</a> -->
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
    <!-- modal load -->

    <form class="d-none" method="POST">
        <input type="text" id="FSinput_text" name="FFinput_text" value="<?php echo $input_text; ?>" placeholder="">
        <input type="text" id="FSinput_price" name="input_price" value="<?php echo $input_price; ?>" placeholder="">
        <input type="text" id="FSai_date_end" name="ai_date_end" value="<?php echo $ai_date_end; ?>" placeholder="">
        <input type="text" id="FSai_date_start" name="ai_date_start" value="<?php echo $ai_date_start; ?>" placeholder="">
        <input type="text" id="FSai_id" name="ai_id" value="<?php echo $ai_id; ?>" placeholder="">
        <button class="btn" id="FSButtonID" type="submit"></button>
    </form>

    <form class="d-none" method="POST">
        <input type="text" id="SFSinput_text" name="FFinput_text" value="<?php echo $input_text; ?>" placeholder="">
        <input type="text" id="SFSinput_price" name="input_price" value="<?php echo $input_price; ?>" placeholder="">
        <input type="text" id="SFSai_date_end" name="ai_date_end" value="<?php echo $ai_date_end; ?>" placeholder="">
        <input type="text" id="SFSai_date_start" name="ai_date_start" value="<?php echo $ai_date_start; ?>" placeholder="">
        <input type="text" id="SFSai_id" name="ai_id" value="<?php echo $ai_id; ?>" placeholder="">
        <input type="text" id="SFSstatus_ai" name="status_ai" value="1">

        <button class="btn" id="FSBtusave" type="submit"></button>
    </form>
    <script src="../../dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
    <script src="../../dist-assets/js/plugins/bootstrap.bundle.min.js"></script>
    <script src="../../dist-assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../../dist-assets/js/scripts/script.min.js"></script>
    <script src="../../dist-assets/js/scripts/sidebar-horizontal.script.js"></script>
    <script src="../../dist-assets/js/plugins/echarts.min.js"></script>
    <script src="../../dist-assets/js/scripts/echart.options.min.js"></script>
    <script src="../../dist-assets/js/scripts/dashboard.v1.script.min.js"></script>
    <script src="../../dist-assets/js/scripts/customizer.script.min.js"></script>
    <script src="../../dist-assets/js/scripts/tooltip.script.min.js"></script>
</body>
<div class="modal fade" id="ModalLoadId" tabindex="-1" role="dialog" aria-labelledby="modalLoadTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center">
                    <div class="spinner-bubble spinner-bubble-primary m-5"></div>
                    <div class="mt-1">
                        Load ...
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    function modalLoad() {
        $("#ModalLoadId").modal({
            backdrop: 'static',
            'keyboard': false,
        });
    };
    $("#input_price").on("change", function() {
        // modalLoad();

        let price = $("#input_price").val();
        let FFtext = $("#Finput_text").val();
        let FFai_date_start = $("#Fai_date_start").val();
        let FFai_date_end = $("#Fai_date_end").val();
        $("#FSinput_price").val(price);
        $("#FSinput_text").val(FFtext);
        $("#FSai_date_start").val(FFai_date_start);
        $("#FSai_date_end").val(FFai_date_end);
        $("#FSButtonID").click();
        console.log('ai_date_start', FFai_date_start)
        console.log('ai_date_start', FFai_date_end)
        // $("#FSColumnId").val(column);
        // $("#FSButtonID").click();

    });
    $("#btu1").click("change", function() {
        modalLoad();
        let price = $("#input_price").val();
        let FFtext = $("#Finput_text").val();
        let FFai_date_start = $("#Fai_date_start").val();
        let FFai_date_end = $("#Fai_date_end").val();
        let FFai_id = $("#ai_id").val();
        $("#SFSinput_price").val(price);
        $("#SFSinput_text").val(FFtext);
        $("#SFSai_date_start").val(FFai_date_start);
        $("#SFSai_date_end").val(FFai_date_end);
        $("#SFSai_id").val(FFai_id);
        $("#FSBtusave").click();

    });
    let input_price = $("#input_price").val();
    let btu = $("#btu").val();
    console.log('input_price',input_price)
    if (input_price == '') {
        document.getElementById("btu").disabled = true;
        document.getElementById("btu1").disabled = true;
    } else {
        document.getElementById("btu").disabled = false;
        document.getElementById("btu1").disabled = false;
    }
    console.log('btu', btu)
</script>

</html>