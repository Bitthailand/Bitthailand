<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config_date.php';
$order_id= $_REQUEST['order_id'];
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
$row3= $rs3->fetch_assoc();
// ===
$strStartDate =$row['qt_date'];
$strNewDate = date ("Y-m-d", strtotime("+$row[date_confirm] day", strtotime($strStartDate)));

?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Quotation | ใบเสนอราคา</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="style.css" /> -->
        <!-- <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" /> -->
    <link href="../../dist-assets/css/themes/styleforprint.css" rel="stylesheet" />


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
                <div class="col-6">
                    <h4 class="font-weight-bold">บริษัท วันเอ็ม จำกัด</h4>
                    <p>290 ม.1 ต.กระโสบ อ.เมือง จ.อุบลราชธานี 34000</p>
                    <p>เลขที่ประจำตัวผู้เสียภาษี 0345555000224 สำนักงานใหญ่</p>
                </div>
                <div class="col-6 text-right">
                    <h4 class="font-weight-bold">ใบเสนอราคา/ใบสั่งซื้อ</h4>
                </div>
            </div>
            <div class="mt-3 mb-4 border-top"></div>
            <div class="row mb-5">
                <div class="col-6 mb-3 mb-sm-0">
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
                    <p><strong>ชื่อลูกค้า : </strong>คุณ <?=$row3['customer_name']?></p>
                    <p><strong>ที่อยู่ : </strong><?php  echo $row3['bill_address']." ต" . $row6['name_th'] . "  อ." . $row7['name_th'] . " จ." . $row8['name_th']; ?> </p>
                    <p><strong>โทร : </strong> <?=$row3['tel']?></p>
                    <p style="margin-bottom: 10px;"><strong>อ้างอิง : </strong><?=$row3['contact_name']?></p>
                    <p>บริษัทฯ มีความยินดีที่จะเสนอราคาสินค้า ดังต่อไปนี้ : </p>
                </div>
                <div class="col-6 text-sm-right">
                    <h5 class="font-weight-bold"></h5>
                    <div class="invoice-summary">
                        <p><span>เลขที่ใบเสนอราคา </span><span><?php echo"$row[qt_id]";?></span></p>
                        <p><span>ลำดับการสั่งซื้อ</span> <span><?php echo"$row[order_id]";?></span></p>
                        <p><span>วันที่</span> <span><?php $date=explode(" ",$row['qt_date'] ); $dat=datethai2($date[0]);
                                                        echo"$dat";?> </span></p>
                        <p><span>ยืนราคา : <?php echo"$row[date_confirm]";?> วัน </span> <span>ถึงวันที่ 
                                <?php $date=explode(" ",$strNewDate ); $dat=datethai2($date[0]);
                                                        echo"$dat";?></span></p>
                        <p><span>เงื่อนไขการชำระเงิน : </span><span><?=$row2['name']?></span></p>
                    </div>
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
                <p>1.มัดจำไม่น้อยกว่า 30% ขอมูลค่าสินค้า เมื่อทำการสั่งซื้อสินค้า และชำระค่าสินค้าส่วนที่เหลือในวันที่จัดส่ง ก่อนลงสินค้า </p>
                <p>2.ผู้ซื้อเป็นผู้จัดเตรียมถนนชั่วคราว/สถานที่ ให้รถส่งสินค้าเข้าถึงจุดส่งสินค้า หรือ จะลงสินค้าเท่าที่รถสามารถเข้าได้ </p>
                <p>3.ขอสงวนสิทธิ์ในการลงสอนค้าต่อเที่ยว (ไม่เกิน 2 ชั่วโมง) หากเกินเวลาผู้ขายคิดเพิ่มชั่วโมงละ 500 บาท หรือตามตกลง </p>
                <p>4.สอนค้ารับฝากไม่เกิน 1 เดือน นับจากวันที่กำหนดส่งสินค้า หากยังไม่รับสินค้า ทางบริษัทขอเก็บค่าดูแลสินค้า 5%
                    ต่อเดือนของมูลค่าสินค้า </p>
                <p>5.การสั่งสินค้า/ซื้อสินค้าแล้ว ทางบริษัทไม่รับคืนสินค้า </p>
                <p>6.กรณีผู้ซื้อตรวจรับสอนค้าจำนวนถูกต้องและสภาพเรียบร้อย บริษัทไม่รับผิดชอบหลังการตรวจรับแล้ว </p>
                <br>
                <h5 class="font-weight-bold">วิธีการชำระเงิน</h5>
                <p>ชื่อบัญชี : บจก.วันเอ็ม ชื่อธนาคาร/เลขที่บัญชี : ธนาคารกสิกรไทย ออกทรัพย์ สาขาสินีย์ทาวเวอร์ เลขที่บัญชี 685-2-29088-7 </p>
            </div>
            <div class="mt-3 mb-4 border-top"></div>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-4 text-center">
                    <p> ____________________</p>
                    <br>
                    <p>ผู้อนุมัติ<span></span></p>
                    <br>
                    <p>วันที่ ________/__________/__________ <span></span></p>
                </div>
                <div class="col-3"></div>
                <div class="col-5 text-center">
                    <p>ในนาม บริษัท วันเอ็ม จำกัด</p>
                    <br>
                    <p>ผู้รับมอบอำนวจ ____________________ <span></span></p>
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
                                                <th scope="col" class="text-center">No.</th>
                                                <th scope="col" class="text-center">รายการ</th>
                                                <th scope="col" class="text-center">จำนวน</th>
                                                <th scope="col" class="text-center">หน่วยละ</th>
                                                <th scope="col" class="text-center">จำนวนเงิน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                        $sql_pro = "SELECT * FROM order_details  where order_id='$order_id' order by product_id ASC ";
                                                        $result_pro = mysqli_query($conn, $sql_pro);
                                                        if (mysqli_num_rows($result_pro) > 0) {
                                                            while ($row_pro = mysqli_fetch_assoc($result_pro)) { ?>
                                            <tr>
                                                <th scope="row" class="text-center"><?=++$id;?></th>
                                                <td>
                                                    <?php
                                                                        $sqlx3 = "SELECT * FROM product  WHERE product_id= '$row_pro[product_id]'";
                                                                        $rsx3 = $conn->query($sqlx3);
                                                                        $rowx3 = $rsx3->fetch_assoc();
                                                                        if($rowx3['ptype_id']=='TF0'){
                                                                            echo $rowx3['product_id'].$rowx3['product_name'];
                                                                        }else{ 
                                                                        echo $rowx3['product_name'];
                                                                       if($rowx3['spacial']==''){}else{ echo"  (".$rowx3['spacial'].")";}
                                                                        

                                                                    }
                                                                        ?>

                                                </td>
                                                <td class="text-right"><?=$row_pro['qty']?></td>
                                                <td class="text-right"><?=$row_pro['unit_price']?></td>
                                                <td class="text-right"><?=$row_pro['total_price']?></td>
                                            </tr>
                                            <?php } } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12">
                                    <div class="invoice-summary-qt2">
                                        <?php
                                                                        $sqlx4 = "SELECT SUM(total_price) AS total FROM order_details  WHERE order_id= '$order_id'";
                                                                        $rsx4 = $conn->query($sqlx4);
                                                                        $rowx4 = $rsx4->fetch_assoc();
                                                                       
                                                                        ?>
                                        <p>รวมเป็นเงินทั้งสิ้น <span><?php echo number_format($rowx4['total'],'2','.',',')?></span></p>
                                        <p>หัก ส่วนลด <span><?php echo number_format($row['discount'],'2','.',',')?></span></p>
                                        <?php $sub_total=$rowx4['total']-$row['discount']; 
                                                        $tax = ($sub_total* 100)/107;
                                                        $tax2 = ($sub_total - $tax);
                                                        $grand_total = ($sub_total - $tax2);
                                                        ?>
                                        <p>จำนวนเงินก่อนรวมภาษี <span><?php echo number_format($grand_total,'2','.',',')?></span></p>
                                        <p>จำนวนภาษีมูลค่าเพิ่ม <?=$row['tax']?>% <span><?php echo number_format($tax2,'2','.',',')?></span></p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-3">
                                            <p>ตัวอักษร :</p>
                                        </div>
                                        <div class="col-5">
                                            <p><?php echo Convert($sub_total);?></p>
                                        </div>
                                        <div class="col-4 text-right">
                                            <div class="row" style="justify-content: flex-end; margin-right: 0;">
                                                <p>รวมเป็นเงิน</p>
                                                <h3 class="font-weight-bold" style="width: 120px; display: inline-block;">
                                                    <span><?php echo number_format($sub_total,'2','.',',')?></span>
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