<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
$emp_id=$_SESSION["username"]; 
include './include/connect.php';
include './include/config_so.php';
include './include/config_date.php';
$order_id = $_REQUEST['order_id'];
$emp_id = $_SESSION["username"];
$datetoday = date('Y-m-d');
$sql = "SELECT * FROM orders   WHERE order_id= '$order_id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
// ====
// echo"$order_id";
// echo"$row[cus_type]";
$sql2 = "SELECT * FROM customer_type  WHERE id= '$row[cus_type]'";
$rs2 = $conn->query($sql2);
$row2 = $rs2->fetch_assoc();
// ====
$sql3 = "SELECT * FROM customer  WHERE customer_id= '$row[cus_id]'";
$rs3 = $conn->query($sql3);
$row3 = $rs3->fetch_assoc();
// ===
if ($row['dev_status'] == 1) {
    $dev_status = $row['dev_status'];
    $datetoday = $row['dev_date'];
} else {
    $sql5 = "SELECT MAX(id) AS id_run FROM delivery  ";
    $rs5 = $conn->query($sql5);
    $row_run = $rs5->fetch_assoc();
    $dev_status = $row['dev_status'];
    $datetodat = date('Y-m-d');
    $date = explode(" ", $datetodat);
    $dat = datethai_so($date[0]);
    $code_new = $row_run['id_run'] + 1;
    $code = sprintf('%05d', $code_new);
    $dev_id = $dat . $code;
    $sql5 = "SELECT MAX(id) AS id_run FROM iv_number  ";
    $rs5 = $conn->query($sql5);
    $row_run = $rs5->fetch_assoc();
    $datetodat = date('Y-m-d');
    $date = explode(" ", $datetodat);
    $dat = datethai_IV($date[0]);
    $code_new = $row_run['id_run'] + 1;
    $code = sprintf('%05d', $code_new);
    $iv_id = $dat . $code;
    $sql5 = "SELECT MAX(id) AS id_run FROM bi_number  ";
    $rs5 = $conn->query($sql5);
    $row_run = $rs5->fetch_assoc();
    $strStartDate = $row['qt_date'];
    $strNewDate = date("Y-m-d", strtotime("+$row[date_confirm] day", strtotime($strStartDate)));
}
?>
<!DOCTYPE html>
<html lang="en" dir="">
<!-- <input id="order_id" value="<?php echo "$order_id"; ?>" type="text" name="order_id"> -->

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Sale Order | ใบส่งของ</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <style>
        p {
            margin-top: 0;
            margin-bottom: 0.1rem;
        }
    </style>
    <style>
        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
            font-size: 0.813rem !important;
        }
    </style>
</head>
<?php
include './include/alert.php';

$action = $_REQUEST['action'];
if ($action == 'add_dev') {
    // echo"$action";
    $order_id = $_REQUEST['order_id'];
    $dev_id = $_REQUEST['dev_id'];
    $dev_date = $_REQUEST['dev_date'];
    $cus_id = $_REQUEST['cus_id'];
    $cus_type = $_REQUEST['cus_type'];
    $iv_id = $_REQUEST['iv_id'];
    $ai_count = $_REQUEST['ai_count'];
    $date_credit = $_REQUEST['date_credit'];
    $date_end = $_REQUEST['date_end'];

    if ($dev_date == '') { ?>
        <script>
            $(document).ready(function() {
                showAlert("ไม่ได้กรอกวันที่", "alert-danger");
            });
        </script>
        <?php } else {
        $sqlxx = "SELECT *  FROM order_details  where order_id= '$order_id' AND ptype_id<>'TF'  AND product_id<>'TF00000000' ORDER BY id ASC";
        $resultxx = mysqli_query($conn, $sqlxx);
        if (mysqli_num_rows($resultxx) > 0) {
            while ($rowx = mysqli_fetch_assoc($resultxx)) {
                // echo"$product_id";

                $product_id = $rowx['product_id'];
                $pid = $rowx['id'];
                // echo"++$id5x";
                $stock1 = $_POST['stock1'][$product_id][$pid][++$id];
                $stock2 = $_POST['stock2'][$product_id][$pid][++$id2];
                echo $stock1."<br>".$stock2;
                $total_instock = $stock1 + $stock2;  //รวมจำนวนที่รรับเข้ามาเพื่อต้องการส่ง
                $sqlx3 = "SELECT * FROM product  WHERE product_id= '$product_id'";
                $rsx3 = $conn->query($sqlx3);
                $rowx3 = $rsx3->fetch_assoc();

                if ($rowx3['fac1_stock'] < $stock1) { ?>
                    <script>
                        $(document).ready(function() {
                            showAlert("ไม่สามารถบันทึกสต็อกโรงงาน1 รหัส  <?= $product_id ?> ได้เนื่องจากจำนวนที่กรอกเกินสต็อก", "alert-danger");
                        });
                    </script>
                <?php
                }
                if ($rowx3['fac2_stock'] < $stock2) { ?>
                    <script>
                        $(document).ready(function() {
                            showAlert("ไม่สามารถบันทึกสต็อกโรงงาน2 รหัส  <?= $product_id ?> ได้เนื่องจากจำนวนที่กรอกเกินสต็อก", "alert-danger");
                        });
                    </script>
                <?php
                }
                if ($rowx['qty'] < $total_instock) { 
                ?>
                <script>
                    $(document).ready(function() {
                    showAlert("ไม่สามารถบันทึกรหัส  <?= $product_id ?> ได้เนื่องจากจำนวนที่กรอกเกินจำนวนที่สั่งไว้", "alert-danger");
                    });
                </script>
                <?php
                }
                if ($total_instock == 0) { 
                ?>
                <script>
                    $(document).ready(function() {
                        showAlert("ไม่สามารถบันทึกรหัส  <?= $product_id ?> ได้เนื่องจากจำนวนที่ส่งเป็น 0 หรือ ค่าว่าง", "alert-danger");
                    });
                </script>
                <?php
                }
                //  ถ้าผ่านเงื่อนไขไม่มี error ให้ บันทึก
                // echo "xxxxx";

        if (($rowx['qty'] >= $total_instock) && ($total_instock <> 0)) {
                    $sum_face1 = $rowx3['fac1_stock'] - $stock1;
                    $sum_face2 = $rowx3['fac2_stock'] - $stock2;
                    // echo "xxxxxyyyy";
                    echo $rowx['qty_out'].'x'.$total_instock;
                    
                    $call_qty = $rowx['qty_out'] - $total_instock; //ยอดที่สั่งเพื่อส่ง มาลบกับยอดที่่สั่งชื้อ
                   
                    $add_devqty = $rowx['qty_dev'] + $total_instock; //เพิ่มจำนวนจัดส่ง
                    //    ตรวจสอบรหัสซ้ำในตารางจัดส่ง
                    $sql99 = "SELECT *  FROM deliver_detail  where order_id= '$order_id' AND dev_id='$dev_id'AND product_id='$product_id' ";
                    $result99 = mysqli_query($conn, $sql99);
                    if (mysqli_num_rows($result99) > 0) {
                    } else {
                        $sql_or = "SELECT * FROM orders   WHERE order_id= '$order_id'";
                        $rs_or = $conn->query($sql_or);
                        $row_or = $rs_or->fetch_assoc();
                        $sum_dis=$rowx['unit_price']-$rowx['disunit'];
                        $sumtotal=$sum_dis*$total_instock;
                        $sqlx = "INSERT INTO deliver_detail (dev_id,product_id,order_id,dev_qty,unit_price,total_price,disunit,ptype_id,cus_type,cus_back)
                            VALUES ('$dev_id','$product_id','$order_id','$total_instock','$rowx[unit_price]','$sumtotal','$rowx[disunit]','$rowx[ptype_id]','$cus_type','$row_or[cus_back]')";
                        if ($conn->query($sqlx) === TRUE) {
                        }
                        // echo"dd";
                       
                        if ($action == 'add_dev') {
                            if($stock1==''){$stock1='0';}
                            if($stock2==''){$stock2='0';}

                            echo"cal=".$call_qty.'id='.$pid.'pro_id='.$product_id.'$stock1='.$stock1.'$stock2='.$stock2;
                            if ($call_qty == 0) {
                                $sql1yyy = "UPDATE order_details SET face1_stock_out='$stock1',face2_stock_out='$stock2',qty_dev='$add_devqty',status_delivery='1',qty_out='$call_qty',error='2' where  id='$pid'  ";
                                if ($conn->query($sql1yyy) === TRUE) {
                                }
                            } else {
                                $sql1xxx = "UPDATE order_details SET face1_stock_out='$stock1',face2_stock_out='$stock2',qty_dev='$add_devqty',status_delivery='0',qty_out='$call_qty',error='3' where  id='$pid' ";
                                if ($conn->query($sql1xxx) === TRUE) {
                                }
                            }
                        }
                        $sql2 = "UPDATE product  SET fac1_stock='$sum_face1',fac2_stock='$sum_face2' where product_id='$product_id'";
                        if ($conn->query($sql2) === TRUE) {
                        }
                ?>
                        <script>
                            $(document).ready(function() {
                                showAlert("บันทึกสต็อกรหัส <?= $product_id ?> สำเร็จ", "alert-primary");
                            });
                        </script>
                <?php

                    }
         }
            }
        }

        $sqlc1 = "SELECT COUNT(*) AS ts  FROM order_details  WHERE   order_id= '$order_id' AND status_delivery='1' AND ptype_id<>'TF' AND product_id<>'TF00000000' ";
        $rsc1 = $conn->query($sqlc1);
        $rowc1 = $rsc1->fetch_assoc();
        $sqlc0 = "SELECT COUNT(*) AS ts2  FROM order_details  WHERE   order_id= '$order_id' AND ptype_id<>'TF' AND product_id<>'TF00000000' ";
        $rsc0 = $conn->query($sqlc0);
        $rowc0 = $rsc0->fetch_assoc();
        // $sqlx12 = "UPDATE orders  SET dev_status='1',dev_id='$dev_id',delivery_date='$dev_date' WHERE order_id= '$order_id'";
        // echo "$rowc1[ts]=$rowc0[ts2]=$dev_date";
        // echo"$rowc1[ts]<br>";
        // echo"$rowc0[ts2]<br>";
        // echo "xxx<br>";
        if ($rowc0['ts2'] == $rowc1['ts']) {
            // echo "$order_id";
            $dev_status = '1';
            $sqlx12 = "UPDATE orders  SET dev_status='1',dev_id='$dev_id' WHERE order_id= '$order_id'";
            if ($conn->query($sqlx12) === TRUE) {
            }
            $sqlx13 = "UPDATE order_details SET status_delivery='1',error='13' WHERE order_id= '$order_id'";
            if ($conn->query($sqlx13) === TRUE) {
            }
        }
        // ตัดยอดมัดจำ
        $sql = "SELECT * FROM orders   WHERE order_id= '$order_id'";
        $rs = $conn->query($sql);
        $row = $rs->fetch_assoc();
        $sum_ai = $row['ai_count'] - $ai_count;
        $sqlx12 = "UPDATE orders  SET ai_count='$sum_ai' WHERE order_id= '$order_id'";
        if ($conn->query($sqlx12) === TRUE) {
        }
        // ปิดตัดยอดมัดจำ
        // ลูกค้าเครดิส บักทึก BI
        if ($cus_type == 2) {
            $datetodat = date('Y-m-d');
            $datetomonth = date('Y-m');
            $sql_cus = "SELECT COUNT(*) AS ts2  FROM order_details  WHERE   order_id= '$order_id' AND ptype_id<>'TF' ";
            $rs_cus = $conn->query($sql_cus);
            $row_cus = $rs_cus->fetch_assoc();


            $date = explode("-", $date_end);
            $date_run = $date[2];
            echo"";
            if ($date_run <= 15) {
                $datemont = "$date[0]-$date[1]";
                $date_start_true = "$datemont-1";
                $date_end_true = "$datemont-15";
            }
            if ($date_run >= 16) {
                $date_start = '16';
                $datetoday = $date_end;
                $enddate = date("t", strtotime($datetoday));
                $datemont = "$date[0]-$date[1]";
                $date_start_true = "$datemont-16";
                $date_end_true = "$datemont-$enddate";
            }
            //    echo"xxxxxxxxxxxxx"."$cus_id";

            $sql_pro = "SELECT * FROM bi_number where cus_id='$cus_id' AND iv_id='$iv_id' AND status_bi='1' ";
            $result_pro = mysqli_query($conn, $sql_pro);
            if (mysqli_num_rows($result_pro) > 0) {
                // echo"OUT";
            } else {
                // echo"IN";
                $datetodat = date('Y-m-d');
                $sql_pro = "SELECT * FROM bi_number where cus_id='$cus_id' AND date_start <='$date_end' AND date_end >='$date_end' AND status_bi='1'  ";
                $result_pro = mysqli_query($conn, $sql_pro);
                if (mysqli_num_rows($result_pro) > 0) {
                    $sql2 = "SELECT * FROM bi_number  WHERE cus_id='$cus_id' AND date_start <='$date_end' AND date_end >='$date_end' AND status_bi='1' ";
                    $rs2 = $conn->query($sql2);
                    $row2 = $rs2->fetch_assoc();
                    $bi_id = $row2['bi_number'];
                    // echo"$row2[bi_number]";
                } else {
                    $sql5 = "SELECT COUNT(id) AS id_run  FROM bi_number  where datetomonth='$datetomonth'  ";
                    $rs5 = $conn->query($sql5);
                    $row_run = $rs5->fetch_assoc();
                    $datetodat = date('Y-m-d');
                    $date = explode(" ", $datetodat);
                    $dat = datethai_BI($date[0]);
                    $code_new = $row_run['id_run'] + 1;
                    $code = sprintf('%03d', $code_new);
                    $bi_id = $dat . $code;
                    // echo "xxxx";
                }

                $sqlx = "INSERT INTO bi_number(bi_number,cus_id,iv_id,status_bi,date_start,date_end,datetomonth,dev_id)
            VALUES ('$bi_id','$cus_id','$iv_id','1','$date_start_true','$date_end_true','$datetomonth','$dev_id')";
                if ($conn->query($sqlx) === TRUE) {
                }
            }
        }     //  if($cus_type==2){
        $sqlxx = "SELECT *  FROM delivery  where order_id= '$order_id' AND dev_id='$dev_id' ";
        $resultxx = mysqli_query($conn, $sqlxx);
        if (mysqli_num_rows($resultxx) > 0) {
        } else {
            if ($cus_type == 2) {
                $status_inv = '1';
            } else {
                $status_inv = '2';
            }
            $sqlx = "INSERT INTO delivery(dev_id,order_id,dev_date,cus_id,cus_type,iv_id,ai_count,date_credit,date_end,status_inv,cus_back)
             VALUES ('$dev_id','$order_id','$dev_date','$cus_id','$cus_type','$iv_id','$ai_count','$date_credit','$date_end','$status_inv','$row[cus_back]')";
            if ($conn->query($sqlx) === TRUE) {
            }
            if ($cus_type == 2) {
                $sqlx2 = "INSERT INTO iv_number(iv_number,order_id,so_id,cus_id,cus_type)
            VALUES ('$iv_id','$order_id','$dev_id','$cus_id','$cus_type')";
                if ($conn->query($sqlx2) === TRUE) {
                }
            }
            // ค้นหาสินค้าที่ขึ้นต้น TF มาอับเดต
            $sql_TF = "SELECT * FROM order_details  where order_id='$order_id'  AND ptype_id='TF'  ";
            $result_TF = mysqli_query($conn, $sql_TF);
            while ($row_TF = mysqli_fetch_assoc($result_TF)) {
                $sql_TF = "INSERT INTO deliver_detail(dev_id,order_id,product_id,dev_qty,unit_price,total_price,ptype_id,cus_back,cus_type)
                   VALUES ('$dev_id','$order_id','$row_TF[product_id]','1','$row_TF[unit_price]','$row_TF[unit_price]','$row_TF[ptype_id]','$row[cus_back]','$cus_type')";
                $sql1xx = "UPDATE order_details SET  status_delivery='1'  where product_id='$row_TF[product_id]'";
                if ($conn->query($sql1xx) === TRUE) {
                }
                if ($conn->query($sql_TF) === TRUE) {
                }
            }
        }
        $cf = 'ok';
    }
    $action = '';
    $dev_date = '';
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
                                                        <h4 class="font-weight-bold">ใบส่งของ</h4>
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
                                                        ?>
                                                        <p><strong>ชื่อลูกค้า : </strong><?= $row3['customer_name'] ?></p>
                                                        <!-- <p><strong>บริษัท : </strong><?= $row3['company_name'] ?></p> -->
                                                        <p><strong>ที่อยู่ : </strong><?php echo $row3['bill_address'] . " $t" . $row6['name_th'] . "  $a" . $row7['name_th'] . " จ." . $row8['name_th']; ?> </p>
                                                        <p>เลขที่ประจำตัวผู้เสียภาษี <?= $row3['tax_number'] ?></p>
                                                        <p><strong>โทร : </strong> <?= $row3['tel'] ?></p>
                                                        <p><strong>อ้างอิง : </strong><?= $row3['contact_name'] ?></p>
                                                        <p><strong>ประเภทลูกค้า : </strong><?= $row2['name'] ?></p>
                                                    </div>
                                                    <div class="col-md-6 text-sm-right">
                                                        <h5 class="font-weight-bold"></h5>
                                                        <div class="invoice-summary">
                                                            <div class="form-group col-md-12">
                                                                <p>ลำดับการสั่งซื้อ <span><?= $order_id ?></span></p>
                                                            </div>
                                                            <?php if ($row['cus_type'] == 2) {
                                                                $col = '6';
                                                            } else {
                                                                $col = '12';
                                                            } ?>
                                                            <div class="form-row mt-3">
                                                                <div class="form-group col-md-<?= $col ?>">
                                                                    <label for="ai_id"><strong>เลขที่ใบส่งของ <span class="text-danger"></span></strong></label>
                                                                    <input type="text" name="dev_id" value="<?= $dev_id ?>" class="classcus form-control" id="so_id" placeholder="เลขที่ใบส่งของ">
                                                                </div>
                                                                <?php if ($row['cus_type'] == 2) { ?>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="ai_id"><strong>เลขที่ใบเอกสาร IV <span class="text-danger"></span></strong></label>
                                                                        <input type="text" name="iv_id" value="<?= $iv_id ?>" class="classcus form-control" id="iv_id" placeholder="เลขที่ใบส่งของ">
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="form-row mt-3">

                                                                <div class="form-group col-md-6">
                                                                    <label for="delivery_date">วันที่</label>
                                                                    <input id="dev_date" class="form-control" type="date" require min="2021-06-01" name="dev_date" value="<?= $datetoday ?>">
                                                                </div>
                                                                <div class="form-group col-md-6">

                                                                    <label for="ai_id"><strong>หักเงินมัดจำจากราคา<?= $row['ai_count'] ?><span class="text-danger"></span></strong></label>
                                                                    <input type="text" name="ai_count" value="<?= $ai_count ?>" class="classcus form-control" id="so_id" placeholder="หักเงินมัดจำ">
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="cus_id" value="<?= $row['cus_id'] ?>">
                                                            <input type="hidden" name="cus_type" value="<?= $row['cus_type'] ?>">
                                                            <?php if ($row['cus_type'] == 2) { ?>
                                                                <div class="form-row mt-3">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="ai_id"><strong>เครดิต <span class="text-danger"></span></strong></label>
                                                                        <input type="text" name="date_credit" value="<?= $date_credit ?>" class="classcus form-control" id="date_credit" placeholder="เครดิตจำนวนวัน">
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label for="delivery_date">วันที่ครบกำหนด</label>
                                                                        <input id="dete_end" class="form-control" type="date" require min="2021-06-01" name="date_end" value="<?= $date_end ?>" require>
                                                                    </div>

                                                                </div>
                                                            <?php } ?>
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
                                                                <th scope="col" class="text-center" width="35%">รหัสสินค้า/รายละเอียด</th>
                                                                <th scope="col" class="text-center" width="8%">จำนวนที่สั่งทั้งหมด</th>
                                                                <th scope="col" class="text-center" width="8%">สต๊อกโรงงาน 1</th>
                                                                <th scope="col" class="text-center" width="8%">สต๊อกโรงงาน 2</th>
                                                                <th scope="col" class="text-center" width="8%">จำนวนที่ต้องส่ง</th>
                                                                <th scope="col" class="text-center" width="8%">โรงงาน 1</th>
                                                                <th scope="col" class="text-center" width="8%">โรงงาน 2</th>

                                                                <th scope="col" class="text-center" width="10%">จำนวนส่ง</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $sql_pro = "SELECT * FROM order_details  where order_id='$order_id' AND ptype_id<>'TF' AND product_id<>'TF00000000' order by id  ASC ";
                                                            $result_pro = mysqli_query($conn, $sql_pro);
                                                            if (mysqli_num_rows($result_pro) > 0) {
                                                                while ($row_pro = mysqli_fetch_assoc($result_pro)) {

                                                                    $no = $row_pro['id'];
                                                                    $product_id = $row_pro['product_id'];
                                                            ?>
                                                                    <tr class="line">
                                                                        <th scope="row" class="text-center"><?= ++$idx; ?></th>
                                                                        <td> <?php $idx7 = ++$id7;
                                                                                $idx8 = ++$id8;
                                                                                $sqlx3 = "SELECT * FROM product  WHERE product_id= '$row_pro[product_id]' ";
                                                                                $rsx3 = $conn->query($sqlx3);
                                                                                $rowx3 = $rsx3->fetch_assoc();
                                                                                echo $rowx3['product_id'] . $rowx3['product_name'];
                                                                                ?></td>
                                                                        <td class="text-center"><input type='number' class="form-control" <?php echo "id='qty" . $no . "'"; ?> value='<?php echo $row_pro['qty']; ?>' readonly></td>
                                                                        <td class="text-center"><input type='number' class="form-control" <?php echo "id='face1_stock" . $no . "'"; ?> value='<?php echo $rowx3['fac1_stock']; ?>' readonly></td>
                                                                        <td class="text-center"><input type='number' class="form-control" <?php echo "id='face2_stock" . $no . "'"; ?> value='<?php echo $rowx3['fac2_stock']; ?>' readonly></td>
                                                                        <td class="text-center"><input type='number' class="form-control" <?php echo "id='qty_out" . $no . "'"; ?> value='<?php echo $row_pro['qty_out']; ?>' readonly></td>
                                                                        <td class="text-center"> <?php echo "<span id='err" . $no . "' ></span>"; ?><input type='number' class="form-control" <?php echo "id='face1" . $no . "'"; ?> value='' <?php echo "name='stock1[$product_id][$no][$idx7]'"; ?> onkeyup='keyup("<?= $no ?>")' <?php if ($row_pro['status_delivery'] == 1) {
                                                                                                                                                                                                                                                                                                                                                                                    echo "disabled";
                                                                                                                                                                                                                                                                                                                                                                                } ?>></td>
                                                                        <td class="text-center"> <?php echo "<span id='err2" . $no . "' ></span>"; ?><input type='number' class="form-control" <?php echo "id='face2" . $no . "'"; ?> value='' <?php echo "name='stock2[$product_id][$no][$idx8]'"; ?> onkeyup='keyup("<?= $no ?>")' <?php if ($row_pro['status_delivery'] == 1) {
                                                                                                                                                                                                                                                                                                                                                                                    echo "disabled";
                                                                                                                                                                                                                                                                                                                                                                                } ?>></td>
                                                                        <td class="text-center"> <?php echo "<span id='err3" . $no . "' ></span>"; ?><input type='number' class="form-control" <?php echo "id='total_price" . $no . "'"; ?> value='<?php echo $row_pro['qty_dev']; ?>' readonly></td>


                                                                    </tr>
                                                            <?php }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                    </div>
                                    <div class="mt-3 mb-4 border-top"></div>
                                    <div class="d-sm-flex mb-5" data-view="print">
                                        <span class="m-auto"></span>
                                        <!-- เงินสด SO  HS   เครดิส  SO  IV   -->
                                        <?php

                                        // echo "$dev_status+$action";
                                        if (($dev_status == 1) || ($cf == 'ok')) {
                                            // echo"$row[cus_type]";
                                        ?>
                                            <a class="btn btn-outline-primary m-1" href="/saleorder.php?order_id=<?= $order_id ?>&so_id=<?= $dev_id ?>" type="button" target="_blank">พิมพ์ใบส่งของ(SO)</a>
                                            <?php if ($row['cus_type'] == 1) { ?>
                                                <?php
                                                $sql = "SELECT * FROM delivery  where order_id='$order_id'  ";
                                                $rsx = $conn->query($sql);
                                                $rsx = $rsx->fetch_assoc();
                                                // echo"$rsx[dev_id]";
                                                ?>
                                                <a class="btn btn-outline-primary m-1" href="/hs.php?order_id=<?= $order_id ?>&so_id=<?= $dev_id ?>" type="button" target="_blank">พิมพ์ใบเสร็จรับเงิน(HS)</a>

                                            <?php   } ?>
                                            <?php if ($row['cus_type'] == 2) { ?> <a class="btn btn-outline-primary m-1" href="/invoice.php?order_id=<?= $order_id ?>&so_id=<?= $dev_id ?>" type="button" target="_blank">พิมพ์ใบกำกับสินค้า(IV)</a><?php } ?>
                                        <?php } else {  ?>
                                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                            <input type="hidden" name="action" value="add_dev">
                                            <button type="submit" id="btu" class="btn btn-outline-primary m-1" name="add-data">บันทึกการส่งของ</span></button>

                                        <?php } ?>
                                        <a class="btn btn-outline-danger m-1" href="/ailist.php" type="button">กลับหน้ารายการ Order</a>
                                    </div>

                                </div>
                                <!-- ==== / Print Area =====-->
                                </form>
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
    <!-- Modal HS-->
    <div class="modal fade" id="medalhs" tabindex="-1" role="dialog" aria-labelledby="medalconcreteuseTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalconcreteuseTitle-2">ยืนยันการออกใบเสร็จรับเงิน</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div id="dynamic-content2"></div>

                </div>

            </div>
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
<script>
    function keyup(id) {
        var face1 = $('#face1' + id).val();
        var face2 = $('#face2' + id).val();
        var face1_stock = $('#face1_stock' + id).val();
        var face2_stock = $('#face2_stock' + id).val();
        var qty = $('#qty_out' + id).val();
        var face1x = Number(face1);
        var face2x = Number(face2);
        var face1x_stock = Number(face1_stock);
        var face2x_stock = Number(face2_stock);
        var qtyx = Number(qty);
        var errid = 'err' + id;
        var status = 'status' + id;
        var errid2 = 'err2' + id;
        var errid3 = 'err3' + id;
        var numx = 1;
        console.log('errid', errid)
        if (face1x_stock < face1x) {

            document.getElementById(errid).innerHTML = "*"

        } else {
            document.getElementById(errid).innerHTML = ""
        }

        if (face2x_stock < face2x) {
            document.getElementById(errid2).innerHTML = "*"

        } else {
            document.getElementById(errid2).innerHTML = ""
        }
        console.log('face1', face1x + face2x)
        console.log('status', status)
        total_price = parseFloat(face1x) + parseFloat(face2x);
        console.log('total_price', total_price + id)
        $('#total_price' + id).val(total_price);
        if (total_price > qtyx) {
            document.getElementById(errid3).innerHTML = "*"

        } else {
            document.getElementById(errid3).innerHTML = ""
        }

    }
    $("#dev_date").on("change", function() {

        let dev_date = $("#dev_date").val();
        console.log('btu', dev_date)
        if (dev_date === undefined || dev_date === '') {
            document.getElementById("btu").disabled = true;
        } else {
            document.getElementById("btu").disabled = false;

        }

    });
</script>
<script>
    $(document).ready(function() {

        $(document).on('click', '#add_hs', function(e) {

            e.preventDefault();

            var uid = $(this).data('id'); // get id of clicked row

            $('#dynamic-content2').html(''); // leave this div blank
            $('#modal-loader').show(); // load ajax loader on button click

            $.ajax({
                    url: 'hs_confirm.php',
                    type: 'POST',
                    data: 'id=' + uid,
                    dataType: 'html'
                })
                .done(function(data) {
                    console.log(data);
                    $('#dynamic-content2').html(''); // blank before load.
                    $('#dynamic-content2').html(data); // load here
                    $('#modal-loader').hide(); // hide loader  
                })
                .fail(function() {
                    $('#dynamic-content2').html(
                        '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                    );
                    $('#modal-loader').hide();
                });

        });
    });
</script>

</html>