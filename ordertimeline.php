<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config_date.php';
$order_id = $_REQUEST['order_id'];
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
$sql6 = "SELECT * FROM districts  WHERE id= '$row3[subdistrict]'";
$rs6 = $conn->query($sql6);
$row6 = $rs6->fetch_assoc();
$sql7 = "SELECT * FROM amphures  WHERE id= '$row3[district]'";
$rs7 = $conn->query($sql7);
$row7 = $rs7->fetch_assoc();
$sql8 = "SELECT * FROM provinces  WHERE id= '$row3[province]'";
$rs8 = $conn->query($sql8);
$row8 = $rs8->fetch_assoc();

$sql_ref = "SELECT * FROM referent  WHERE id= '$row3[province]'";
$rs_ref  = $conn->query($sql_ref);
$row_ref  = $rs_ref->fetch_assoc();


$sql_bk = "SELECT * FROM customer_back   WHERE id= '$row[cus_back]'";
$rs_bk = $conn->query($sql_bk);
$row_bk = $rs_bk->fetch_assoc();
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
            <div class="main-content">

                <div class="border-primary mb-4" style="border-bottom: solid 2px;">
                    <h4 class="mb-3">
                        Order Timeline
                        <span class="font-weight-bold ml-2 text-danger">( <?= $row['order_id'] ?>)</span>
                    </h4>
                </div>

                <div class="row">
                    <!-- Timeline -->
                    <div class="col-md-4 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="text-primary">Timeline</h4>
                                <div class="separator-breadcrumb border-top mb-3"></div>
                                <div class="ul-widget-s6__items">
                                    <div class="ul-widget-s6__item">
                                        <span class="ul-widget-s6__badge">
                                            <p class="badge-dot-success ul-widget6__dot"></p>
                                        </span>
                                        <span class="ul-widget-s6__text">
                                            <strong class="mr-1">เปิด Order</strong>
                                            <a class=" btn-success text-white " href="orderview.php?saleorder_id=<?= $order_id ?>" target="_blank"><?= $order_id ?></a>
                                        </span>
                                        <span class="ul-widget-s6__time"> <?php $date = explode(" ", $row['date_create']);
                                                                            $dat = datethai2($date[0]);
                                                                            echo $dat . '-' . $date[1] ?> </span>
                                    </div>
                                    <?php
                                    $sql_qt= "SELECT  * FROM  quotation  where  order_id='$order_id'   ";
                                    $result_qt = mysqli_query($conn, $sql_qt);
                                    if (mysqli_num_rows($result_qt) > 0) {
                                        while ($row_qt = mysqli_fetch_assoc($result_qt)) {
                                            ?>
                                    <div class="ul-widget-s6__item">
                                        <span class="ul-widget-s6__badge">
                                            <p class="badge-dot-primary ul-widget6__dot"></p>
                                        </span>
                                        <span class="ul-widget-s6__text">
                                            <strong class="mr-1">ออกใบเสนอราคา</strong>
                                            <a class=" btn-primary text-white " href="quotation.php?order_id=<?=$order_id?>" target="_blank"><?=$row_qt['qt_number']?></a>
                                        </span>
                                        <span class="ul-widget-s6__time"> <?php $date = explode(" ", $row_qt['date_create']);
                                                                            $dat = datethai2($date[0]);
                                                                            echo $dat . '-' . $date[1] ?></span>
                                    </div>
                                    
                                    <?php }} 
                                    $sql_ai= "SELECT  * FROM  ai_number   where  order_id='$order_id'   ";
                                    $result_ai = mysqli_query($conn, $sql_ai);
                                    if (mysqli_num_rows($result_ai) > 0) {
                                        while ($row_ai = mysqli_fetch_assoc($result_ai)) {
                                            ?>
                                    <div class="ul-widget-s6__item">
                                        <span class="ul-widget-s6__badge">
                                            <p class="badge-dot-primary ul-widget6__dot"></p>
                                        </span>
                                        <span class="ul-widget-s6__text">
                                            <strong class="mr-1">ออกใบมัดจำสินค้า</strong>
                                            <a class=" btn-primary text-white " href="ai.php?order_id=<?=$order_id?>" target="_blank"><?=$row_ai['ai_num']?></a>
                                        </span>
                                        <span class="ul-widget-s6__time">  <?php $date = explode(" ", $row_ai['date_create']);
                                                                            $dat = datethai2($date[0]);
                                                                            echo $dat . '-' . $date[1] ?></span>
                                    </div>
                                    <?php   }
                                    }
                                    $sql_hs= "SELECT  * FROM  hs_number  where  order_id='$order_id'   ";
                                    $result_hs = mysqli_query($conn, $sql_hs);
                                    if (mysqli_num_rows($result_hs) > 0) {
                                        while ($row_hs = mysqli_fetch_assoc($result_hs)) {
                                            ?>
                                    <div class="ul-widget-s6__item">
                                        <span class="ul-widget-s6__badge">
                                            <p class="badge-dot-primary ul-widget6__dot"></p>
                                        </span>
                                        <span class="ul-widget-s6__text">
                                            <strong class="mr-1">ออกใบเสร็จรับเงิน</strong>
                                            <a class=" btn-primary text-white " href="hs_all.php?order_id=<?=$order_id?>" target="_blank"><?=$row_hs['hs_id']?></a>
                                        </span>
                                        <span class="ul-widget-s6__time">  <?php $date = explode(" ", $row_hs['date_create']);
                                                                            $dat = datethai2($date[0]);
                                                                            echo $dat . '-' . $date[1] ?> </span>
                                    </div>
                                    <?php }}   $sql_dev= "SELECT  * FROM  delivery  where  order_id='$order_id'   ";
                                    $result_dev = mysqli_query($conn, $sql_dev);
                                    if (mysqli_num_rows($result_dev) > 0) {
                                        while ($row_dev = mysqli_fetch_assoc($result_dev)) {
                                            ?>
                                    <div class="ul-widget-s6__item">
                                        <span class="ul-widget-s6__badge">
                                            <p class="badge-dot-primary ul-widget6__dot"></p>
                                        </span>
                                        <span class="ul-widget-s6__text">
                                            <strong class="mr-1">ออกใบส่งสินค้า</strong>
                                            <a class=" btn-primary text-white " href="saleorder.php?order_id=<?=$order_id?>&so_id=<?=$row_dev['dev_id']?>" target="_blank"><?=$row_dev['dev_id']?></a>
                                        </span>
                                        <span class="ul-widget-s6__time">
                                        <?php $date = explode(" ", $row_dev['date_create']);
                                                                            $dat = datethai2($date[0]);
                                                                            echo $dat . '-' . $date[1] ?> </span>
                                    </div>
                                    <?php } } ?>
                                    <div class="ul-widget-s6__item">
                                        <span class="ul-widget-s6__badge">
                                            <p class="badge-dot-info ul-widget6__dot"></p>
                                        </span>
                                        <span class="ul-widget-s6__text">
                                            <strong class="mr-1">เพิ่มรายการสั่งสินค้า</strong>
                                            <a class=" btn-info text-white " href="orderview.php?saleorder_id=OR6408001" target="_blank">OR64080001</a>
                                        </span>
                                        <span class="ul-widget-s6__time">
                                            30 ก.ค. 2021 11:24 </span>
                                    </div>
                                    <?php
                                    $sql_iv= "SELECT  * FROM  iv_number  where  order_id='$order_id'   ";
                                    $result_iv = mysqli_query($conn, $sql_iv);
                                    if (mysqli_num_rows($result_iv) > 0) {
                                        while ($row_iv = mysqli_fetch_assoc($result_iv)) {
                                            ?>

                                    <div class="ul-widget-s6__item">
                                        <span class="ul-widget-s6__badge">
                                            <p class="badge-dot-primary ul-widget6__dot"></p>
                                        </span>
                                        <span class="ul-widget-s6__text">
                                            <strong class="mr-1">ออกใบกำกับสินค้า</strong>
                                            <a class=" btn-primary text-white " href="invoice.php?order_id=<?=$order_id?>" target="_blank"><?=$row_iv['iv_number']?></a>
                                        </span>
                                        <span class="ul-widget-s6__time">
                                            30 ก.ค. 2021 11:19 </span>
                                    </div>
                                    <?php }} ?>
                                    <div class="ul-widget-s6__item">
                                        <span class="ul-widget-s6__badge">
                                            <p class="badge-dot-primary ul-widget6__dot"></p>
                                        </span>
                                        <span class="ul-widget-s6__text">
                                            <strong class="mr-1">ออกใบเสร็จรับเงิน</strong>
                                            <a class=" btn-primary text-white " href="orderview.php?saleorder_id=OR6408001" target="_blank">RE64080001</a>
                                        </span>
                                        <span class="ul-widget-s6__time">
                                            30 ก.ค. 2021 11:19 </span>
                                    </div>
                                    <div class="ul-widget-s6__item">
                                        <span class="ul-widget-s6__badge">
                                            <p class="badge-dot-primary ul-widget6__dot"></p>
                                        </span>
                                        <span class="ul-widget-s6__text">
                                            <strong class="mr-1">ออกใบวางบิล</strong>
                                            <a class=" btn-primary text-white " href="orderview.php?saleorder_id=OR6408001" target="_blank">BI64080001</a>
                                        </span>
                                        <span class="ul-widget-s6__time">
                                            30 ก.ค. 2021 11:19 </span>
                                    </div>
                                    <div class="ul-widget-s6__item">
                                        <span class="ul-widget-s6__badge">
                                            <p class="badge-dot-danger ul-widget6__dot"></p>
                                        </span>
                                        <span class="ul-widget-s6__text">
                                            <strong class="mr-1">ยกเลิก Order</strong>
                                            <a class=" btn-danger text-white " href="orderview.php?saleorder_id=OR6408001" target="_blank">OR64080001</a>
                                        </span>
                                        <span class="ul-widget-s6__time">
                                            30 ก.ค. 2021 11:19 </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 col-lg-8">
                        <div class="mb-3">

                            <div class="class-view-log card-body" id="order_create" style="padding-top:0!important;">

                                <!-- รายละเอียด Order -->
                                <div class="card">
                                    <div class="col-md-12">
                                        <div class="col-mb-12 col-12 mb-2 mt-3 pt-2">
                                            <h4 class="text-muteds"><span>รายละเอียด Order: <?= $row['order_id'] ?></span></h4>
                                        </div>
                                        <div class="separator-breadcrumb border-top mb-3"></div>
                                        <div class="row">
                                            <div class="col-mb-12 col-12 mb-2 mt-3 pt-2">
                                                <h4 class="text-muted text-success"> ข้อมูลลูกค้า </h4>
                                            </div>
                                            <div class="col-md-12 col-12 mb-2">
                                                ชื่อลูกค้า :
                                                <strong class="font-weight-bold text-primary"><?= $row3['customer_name'] ?></strong>
                                            </div>

                                            <div class="col-md-4 col-12 mb-2">
                                                ที่อยู่ :
                                                <strong><?php echo $row3['bill_address'] . " ต." . $row6['name_th'] . "  อ." . $row7['name_th'] . " จ." . $row8['name_th']; ?></strong>
                                            </div>
                                            <div class="col-md-4 col-12 mb-2">
                                                โทร :
                                                <strong><?= $row3['tel'] ?></strong>
                                            </div>
                                            <div class="col-md-4 col-12 mb-2">
                                                อ้างอิง :
                                                <strong class="font-weight-bold text-primary"><?= $row3['contact_name'] ?></strong>
                                            </div>

                                            <div class="col-md-4 col-12 mb-2">
                                                เลขที่ประจำตัวผู้เสียภาษี :
                                                <strong><?= $row3['contact_name'] ?></strong>
                                            </div>
                                            <div class="col-md-4 col-12 mb-2">
                                                ประเภทลูกค้า :
                                                <strong><?= $row3['tax_number'] ?></strong>
                                            </div>
                                            <div class="col-md-4 col-12 mb-2">
                                                รู้จักบริษัทผ่านช่องทาง :
                                                <strong><?= $row_ref['name'] ?></strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ข้อมูล Order -->
                                <div class="card mt-3">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-mb-12 col-12 mb-2 mt-3 pt-2">
                                                <h4 class="text-muteds"><span class="text-success"> ข้อมูล Order </span></h4>
                                            </div>
                                            <div class="col-md-4 col-12 mb-2">
                                                ประเภท Order :
                                                <span class="ml-1 text-primary font-weight-bold"><?= $row_bk['name'] ?></strong>
                                            </div>
                                            <div class="col-md-4 col-12 mb-2">
                                                วันที่เปิด Order :
                                                <strong> <?php $date = explode(" ", $row['date_create']);
                                                            $dat = datethai2($date[0]);
                                                            echo $dat ?></strong>
                                            </div>
                                            <div class="col-md-4 col-12 mb-2">
                                                พนักงานขาย :
                                                <strong class="font-weight-bold text-primary"><?= $row['emp_id'] ?></strong>
                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-md-12 table-responsive">
                                                <table class="table table-hover text-nowrap table-sm">
                                                    <thead class="bg-gray-300">
                                                        <tr>
                                                            <th scope="col" class="text-center">No.</th>
                                                            <th scope="col" class="text-center">รหัสสินค้า/รายละเอียด</th>
                                                            <th scope="col" class="text-center">จำนวน</th>
                                                            <th scope="col" class="text-center">หน่วยละ</th>
                                                            <th scope="col" class="text-center">ราคารวมภาษี</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql_pro = "SELECT * FROM order_details  where order_id='$order_id'   AND ptype_id <> 'TF' order by product_id ASC ";
                                                        $result_pro = mysqli_query($conn, $sql_pro);
                                                        if (mysqli_num_rows($result_pro) > 0) {
                                                            while ($row_pro = mysqli_fetch_assoc($result_pro)) { ?>
                                                                <tr>
                                                                    <th scope="row" class="text-center"><?= ++$id; ?></th>
                                                                    <td>
                                                                        <?php
                                                                        $sqlx3 = "SELECT * FROM product  WHERE product_id= '$row_pro[product_id]'";
                                                                        $rsx3 = $conn->query($sqlx3);
                                                                        $rowx3 = $rsx3->fetch_assoc();
                                                                        if ($rowx3['ptype_id'] == 'TF0') {
                                                                            echo 'ค่าจัดส่ง' . '(' . $rowx3['product_name'] . ')';
                                                                        } else {
                                                                            echo $rowx3['product_name'];
                                                                            if ($rowx3['spacial'] == '') {
                                                                            } else {
                                                                                echo "  (" . $rowx3['spacial'] . ")";
                                                                            }
                                                                        }
                                                                        $sql_unit = "SELECT * FROM unit  WHERE id= '$rowx3[units]' ";
                                                                        $rs_unit = $conn->query($sql_unit);
                                                                        $row_unit = $rs_unit->fetch_assoc();
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-right"><?= $row_pro['qty'] ?> <?= $row_unit['unit_name'] ?></td>
                                                                    <td class="text-right"><?php echo number_format($row_pro['unit_price'], '2', '.', ',') ?></td>
                                                                    <td class="text-right"><?php  ?><?php echo number_format($row_pro['total_price'], '2', '.', ',');
                                                                                                    $total = $total + $row_pro['total_price']; ?></td>
                                                                </tr>
                                                        <?php }
                                                        } ?> <?php
                                                                $result_count = mysqli_query($conn, "SELECT COUNT(*) As total  FROM order_details where order_id='$order_id'  AND ptype_id='TF'  ");
                                                                $count = mysqli_fetch_array($result_count);
                                                                $countx = $count['total'];
                                                                if ($countx > 0) {
                                                                ?>
                                                            <tr>
                                                                <td scope="row" class="text-center"><?= ++$id; ?></td>
                                                                <?php
                                                                    $sqlx3x = "SELECT * FROM order_details  where order_id='$order_id'  AND ptype_id='TF' ";
                                                                    $rsx3x = $conn->query($sqlx3x);
                                                                    $rowx3x = $rsx3x->fetch_assoc();
                                                                ?>
                                                                <td> <?php
                                                                        $sqlx31 = "SELECT * FROM product  WHERE product_id= '$rowx3x[product_id]'";
                                                                        $rsx31 = $conn->query($sqlx31);
                                                                        $rowx31 = $rsx31->fetch_assoc();
                                                                        // echo $rowx31['product_name'];
                                                                        echo 'ค่าจัดส่ง' . '(' . $rowx31['product_name'] . ')';
                                                                        $sql_unit = "SELECT * FROM unit  WHERE id= '$rowx31[units]' ";
                                                                        $rs_unit = $conn->query($sql_unit);
                                                                        $row_unit = $rs_unit->fetch_assoc();
                                                                        ?>
                                                                </td>
                                                                <td class="text-right"><?= $rowx3x['qty'] ?> <?= $row_unit['unit_name'] ?></td>
                                                                <td class="text-right"><?php echo number_format($rowx3x['unit_price'], '2', '.', ',') ?></td>
                                                                <td class="text-right"><?php echo number_format($rowx3x['total_price'], '2', '.', ',') ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="invoice-summary">
                                                    <p style="margin-bottom: 0;">รวมเป็นเงินทั้งสิ้น <span><?php echo number_format($total, '2', '.', ',') ?></span></p>
                                                    <p style="margin-bottom: 0;">หัก ส่วนลด <span>0.00</span></p>
                                                    <?php $tax = ($total * 100) / 107;
                                                    $tax2 = $total - $tax;
                                                    $sub_total = $total - $tax2;
                                                    $grand_total = $sub_total + $tax2;
                                                    ?>
                                                    <p style="margin-bottom: 0;">จำนวนเงินก่อนรวมภาษี <span><?php echo number_format($sub_total, '2', '.', ',') ?></span></p>
                                                    <p>จำนวนภาษีมูลค่าเพิ่ม 7% <span><?php echo number_format($tax2, '2', '.', ',') ?></span></p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <p>ตัวอักษร :</p>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <p><?php echo Convert($grand_total); ?></p>
                                                    </div>
                                                    <div class="col-md-4 text-right">
                                                        <div class="row" style="justify-content: flex-end; margin-right: 0;">
                                                            <p>รวมเป็นเงิน</p>
                                                            <h5 class="font-weight-bold text-primary" style="width: 120px; display: inline-block;"> <span><?php echo number_format($grand_total, '2', '.', ',') ?></span></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $result_count = mysqli_query($conn, "SELECT COUNT(*) As total  FROM delivery  where  status='0' AND  order_id='$order_id'  ");
                                $count = mysqli_fetch_array($result_count);
                                $countx = $count['total'];
                                if ($countx > 0) {
                                ?>
                                    <?php
                                    $sql_dev = "SELECT * FROM delivery   where order_id='$order_id'  order by dev_id ASC ";
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
                                                                <th scope="col" class="text-center">จำนวนเงิน</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $sql_detail = "SELECT * FROM deliver_detail   where order_id='$order_id' AND dev_id='$row_dev[dev_id]' AND ptype_id <> 'TF'   order by dev_id ASC ";
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

                                                                                echo $row_pro['product_name'];
                                                                                ?>
                                                                        </td>
                                                                        <td class="text-right"><?= $row_detail['dev_qty'] ?> <?= $row_unit['unit_name'] ?> </td>
                                                                        <td class="text-right"><?php echo number_format($row_detail['unit_price'], '2', '.', ',') ?></td>

                                                                        <td class="text-right"><?php echo number_format($row_detail['total_price'], '2', '.', ',') ?></td>
                                                                    </tr>
                                                            <?php }
                                                            } ?>
                                                            <?php
                                                            $result_count = mysqli_query($conn, "SELECT COUNT(*) As total  FROM deliver_detail  where  dev_id='$row_dev[dev_id]' AND ptype_id='TF'  ");
                                                            $count = mysqli_fetch_array($result_count);
                                                            $countx = $count['total'];
                                                            if ($countx > 0) {
                                                            ?><tr>
                                                                    <td scope="row" class="text-center"><?= ++$id7; ?></td>
                                                                    <td>
                                                                        <?php
                                                                        $sqlx3 = "SELECT * FROM deliver_detail  where order_id='$order_id' AND dev_id='$row_dev[dev_id]'  AND  ptype_id='TF' ";
                                                                        $rsx3 = $conn->query($sqlx3);
                                                                        $rowx3 = $rsx3->fetch_assoc();
                                                                        // echo $rowx3['product_id'];
                                                                        ?>
                                                                        <?php $sql_pro = "SELECT * FROM product  WHERE product_id= '$rowx3[product_id]'";
                                                                        $rs_pro = $conn->query($sql_pro);
                                                                        $row_pro = $rs_pro->fetch_assoc();
                                                                        $sql_unit = "SELECT * FROM unit  WHERE id= '$row_pro[units]' ";
                                                                        $rs_unit = $conn->query($sql_unit);
                                                                        $row_unit = $rs_unit->fetch_assoc();
                                                                        echo 'ค่าจัดส่ง' . '(' . $row_pro['product_name'] . ')';

                                                                        ?>
                                                                    </td>
                                                                    <td class="text-right"><?= $rowx3['dev_qty'] ?> <?= $row_unit['unit_name'] ?> </td>
                                                                    <td class="text-right"><?php echo number_format($rowx3['unit_price'], '2', '.', ',') ?></td>

                                                                    <td class="text-right"><?php echo number_format($rowx3['total_price'], '2', '.', ',') ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                    <div class="mb-2 mt-3 pt-2 border-warning border-top">
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                <?php }
                                    }
                                } ?>
                            </div>







                        </div>
                    </div>

                </div>
            </div>
            <!-- ============ Body End ======================= -->
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