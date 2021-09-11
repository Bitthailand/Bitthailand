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
// echo"$strNewDate";
?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Quotation | ใบเสนอราคา</title>
    <!-- <link rel="stylesheet" href="style.css" /> -->
    <!-- <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" /> -->
    <link href="../../dist-assets/css/themes/styleforprint.css?v=9" rel="stylesheet" />


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

<body class="qt2 text-left">

    <!--  header  -->

    <div class="page-header">
        <div class="col-12 text-right">
            <button class="btn-primary mb-sm-0 mb-3" onclick="window.print()">พิมพ์ใบเสนอราคา</button>
        </div>
        <div class="col-12">
        <div class="row">
            <div class="col-2_logo">
                <img class="logox" src="../../dist-assets/images/logo1.png" alt="">
            </div>
            <div class="col-5">
                <h4 class="font-weight-bold">บริษัท วันเอ็ม จำกัด</h4>
                <p>290 ม.1 ต.กระโสบ อ.เมือง จ.อุบลราชธานี 34000</p>
                <p>เลขที่ประจำตัวผู้เสียภาษี 0345555000224 สำนักงานใหญ่</p>
            </div>
            <div class="col-5 text-right">
                <h2 class="font-weight-bold">ใบเสนอราคา/ใบสั่งซื้อ</h2>
            </div>
        </div> </div>
            <div class="mt-3 mb-4 border-top"></div>
            <div class="row mb-5">
                <div class="col-7 mb-3 mb-sm-0"> <?php
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
                    <div class="rowx_cus">
                        <div class="col-4x_cus">
                            <p><strong>ชื่อลูกค้า</strong> </p>
                            <p><strong>ที่อยู่</strong> </p>
                            <p><strong>โทร </strong> </p>
                            <p><strong>อ้างอิง</strong> </p>
                             
                        </div>
                        <div class="col-1x">
                            <p>:</p>
                            <p>:</p>
                            <p>:</p>
                            <p>:</p>
                        </div>
                        <div class="col-4xx_cus">
                            <p><?= $row3['customer_name'] ?></p>
                            <p><?php echo $row3['bill_address'] . " ต." . $row6['name_th'] . "  อ." . $row7['name_th'] . " จ." . $row8['name_th']; ?></p>
                       <p><?= $row3['tel'] ?></p>
                       <p><?= $row3['contact_name'] ?></p>
                       
                        </div>
                    </div>

                </div>
                <div class="col-5 text-sm-right">
                    <div class="rowx">
                        <div class="col-4x">
                            <p>เลขที่ใบเสนอราคา </p>
                            <p>ลำดับการสั่งซื้อ </p>
                            <p>วันที่ </p>
                            <p>ยืนราคา <?php echo "$row[date_confirm]"; ?> วัน </p>
                            <p>เงื่อนไขการชำระเงิน </p>
                        </div>
                        <div class="col-1x">
                            <p>:</p>
                            <p>:</p>
                            <p>:</p>
                            <p>:</p>
                            <p>:</p>
                        </div>
                        <div class="col-4xx">
                            <p><?php echo "$row[qt_id]"; ?></p>
                            <p><?php echo "$row[order_id]"; ?> </p>
                            <p><?php $date = explode(" ", $row['qt_date']);
                                $dat = datethai2($date[0]);
                                echo "$dat"; ?> </p>
                            <p>ถึงวันที่
                                <?php $date = explode(" ", $strNewDate);
                                $dat = datethai2($date[0]);
                                echo "$dat"; ?></p>
                            <p><?= $row2['name'] ?> </p>
                        </div>
                    </div>

                </div>
               
                <div class="col-12">
                <p>&nbsp;บริษัทฯ มีความยินดีที่จะเสนอราคาสินค้า ดังต่อไปนี้ : </p>
                </div>
            
            </div>
           
        </div>

       
    </div>
    <!-- End header  -->
    <!-- Footer  -->
    <div class="page-footer">
        <div class="mt-3 mb-4 border-top"></div>
        <div class="col-12">
            <div class="col-12 mb-3 mb-sm-0">
                <h5 class="font-weight-bold">เงื่อนไขการขาย</h5>
                <p>1. มัดจำไม่น้อยกว่า 30% ของมูลค่าสินค้า เมื่อทำการสั่งซื้อสินค้า และชำระค่าสินค้าส่วนที่เหลือในวันที่จัดส่ง </p>
                <p>2. ผู้ซื้อเป็นผู้จัดเตรียมสถานที่สำหรับลงสินค้า และทางบริษัทฯ ขอสงวนสิทธิ์ในการลงสินค้าตามสถานที่เท่าที่รถเข้าถึงได้ </p>
                <p>3. บริษัทฯ ขอสงวนสิทธิ์ในการลงสินค้าต่อเที่ยว (ไม่เกิน 2 ชั่วโมง) หากเกินเวลาผู้ขายคิดเพิ่มชั่วโมงละ 500 บาท หรือตามตกลง </p>
                <p>4. สินค้ารับฝากไม่เกิน 1 เดือน นับจากวันที่กำหนดส่งสินค้า หากยังไม่รับสินค้า ทางบริษัทฯ ขอเก็บค่าดูแลสินค้า 5%
                    ต่อเดือนของมูลค่าสินค้า </p>
                <p>5. บริษัทฯ ขอสงวนสิทธิ์ไม่คืนมัดจำ/ค่าสินค้าในทุกกรณี หากผู้ชื้อแจ้งยกเลิก/เปลี่ยนแปลงรายการสินค้า</p>
                <p>6. บริษัทฯ ขอไม่รับผิดชอบต่อความเสียหายใดๆ หลังจากตรวจรับสินค้าแล้ว </p>
                <br>
                <h5 class="font-weight-bold">วิธีการชำระเงิน</h5>
                <p>ชื่อบัญชี : บจก.วันเอ็ม ธนาคารกสิกรไทย สาขาสุนีย์ทาวเวอร์ ประเภทออมทรัพย์ เลขที่บัญชี 685-2-29088-7 </p>
            </div>
            <div class="mt-3 mb-4 border-top"></div>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-4 text-center">
                    <br> <br>
                    <p> ____________________</p>

                    <p>ผู้อนุมัติ<span></span></p>
                    <br>
                    <p>วันที่ ________/__________/__________ <span></span></p>
                </div>
                <div class="col-3"></div>
                <div class="col-5 text-center">
                    <p>ในนาม บริษัท วันเอ็ม จำกัด</p>
                    <br><br>
                    <p>ผู้รับมอบอำนาจ ____________________ <span></span></p>
                    <br>
                    <p>วันที่ ________/__________/__________ <span></span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer  -->


    <div class="col-12">
        <table class="print-table" style="width: 100%;">
            <thead>
                <tr>
                    <td>
                        <!--place holder for the fixed-position header-->
                        <div class="page-header-space"></div>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="page">
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-hover mb-4">
                                        <thead class="bg-gray-300">
                                            <tr>
                                                <th scope="col" class="text-center">ลำดับ</th>
                                                <th scope="col" class="text-left">รายการ</th>
                                                <th scope="col" class="text-center">จำนวน</th>
                                                <th scope="col" class="text-center">หน่วยละ</th>
                                                <th scope="col" class="text-right">จำนวนเงิน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql_pro = "SELECT * FROM order_details  where order_id='$order_id'  AND ptype_id <> 'TF' order by date_create DESC ";
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
                                                            $price_dis=$row_pro['unit_price']-$row_pro['disunit'];
                                                            $total_price=$price_dis*$row_pro['qty'];
                                                            ?>

                                                        </td>
                                                        <td class="text-center"><?= $row_pro['qty'] ?> <?= $row_unit['unit_name'] ?></td>
                                                        <td class="text-center"><?php echo number_format($price_dis, '2', '.', ',') ?></td>
                                                        <td class="text-right"><?php echo number_format($total_price, '2', '.', ',') ?></td>
                                                    </tr>
                                            <?php }
                                            } ?>

                                            <?php
                                            $result_count = mysqli_query($conn, "SELECT COUNT(*) As total  FROM order_details where order_id='$order_id'  AND ptype_id='TF'  ");
                                            $count = mysqli_fetch_array($result_count);
                                            $countx = $count['total'];
                                            if ($countx > 0) {
                                            ?>
                                                <tr>
                                                    <th scope="row" class="text-center"><?= ++$id; ?></th>

                                                    <?php
                                                    $sqlx3x = "SELECT * FROM order_details  where order_id='$order_id'  AND ptype_id='TF' ";
                                                    $rsx3x = $conn->query($sqlx3x);
                                                    $rowx3x = $rsx3x->fetch_assoc();
                                                    ?>

                                                    <td>
                                                        <?php
                                                        $sqlx31 = "SELECT * FROM product  WHERE product_id= '$rowx3x[product_id]'";
                                                        $rsx31 = $conn->query($sqlx31);
                                                        $rowx31 = $rsx31->fetch_assoc();
                                                        //    echo $rowx31['product_name'];
                                                        echo 'ค่าจัดส่ง' . '(' . $rowx31['product_name'] . ')';
                                                        $sql_unit = "SELECT * FROM unit  WHERE id= '$rowx31[units]' ";
                                                        $rs_unit = $conn->query($sql_unit);
                                                        $row_unit = $rs_unit->fetch_assoc();
                                                        ?></td>
                                                    <td class="text-center"><?= $rowx3x['qty'] ?> <?= $row_unit['unit_name'] ?></td>
                                                    <td class="text-center"><?php echo number_format($rowx3x['unit_price'], '2', '.', ',') ?></td>
                                                    <td class="text-right"><?php echo number_format($rowx3x['total_price'], '2', '.', ',') ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-6">

                                </div>
                                <div class="col-2">

                                </div>
                                <div class="col-3">
                                    <p>รวมเป็นเงินทั้งสิ้น</p>
                                    <p>หัก ส่วนลด</p>
                                    <p>จำนวนเงินก่อนรวมภาษี</p>
                                    <p>จำนวนภาษีมูลค่าเพิ่ม 7%</p>
                                </div>
                                <div class="col-1">
                                    <div class="invoice-summary-qt2">
                                        <?php
                                        $sqlx4 = "SELECT SUM(total_price) AS total FROM order_details  WHERE order_id= '$order_id'";
                                        $rsx4 = $conn->query($sqlx4);
                                        $rowx4 = $rsx4->fetch_assoc();

                                        ?>
                                        <p> <span><?php echo number_format($rowx4['total'], '2', '.', ',') ?></span></p>
                                        <p> <span><?php echo number_format($row['discount'], '2', '.', ',') ?></span></p>
                                        <?php $sub_total = $rowx4['total'] - $row['discount'];
                                        $tax = ($sub_total * 100) / 107;
                                        $tax2 = ($sub_total - $tax);
                                        $grand_total = ($sub_total - $tax2);
                                        ?>
                                        <p> <span><?php echo number_format($grand_total, '2', '.', ',') ?></span></p>
                                        <p> <span><?php echo number_format($tax2, '2', '.', ',') ?></span></p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-3">
                                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตัวอักษร :</p>
                                        </div>
                                        <div class="col-5">
                                            <p><?php echo Convert($sub_total); ?></p>
                                        </div>
                                        <div class="col-3">
                                            <p>รวมเป็นเงิน</p>
                                        </div>
                                        <div class="col-1 text-right">
                                            <div class="row" style="justify-content: flex-end; margin-right: 0;">

                                                <h3 class="font-weight-bold" style="width: 120px; display: inline-block;">
                                                    <span><?php echo number_format($sub_total, '2', '.', ',') ?></span>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- <div class="page">PAGE 2</div> -->
                    </td>
                </tr>
            </tbody>
        </table>
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