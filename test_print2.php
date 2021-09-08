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
$rowx = $rs->fetch_assoc();
// ====
$sql2 = "SELECT * FROM customer_type  WHERE id= '$rowx[cus_type]'";
$rs2 = $conn->query($sql2);
$row2 = $rs2->fetch_assoc();
// ====
$sql3 = "SELECT * FROM customer  WHERE customer_id= '$rowx[cus_id]'";
$rs3 = $conn->query($sql3);
$row3 = $rs3->fetch_assoc();
// ===
$strStartDate = $rowx['qt_date'];
$strNewDate = date("Y-m-d", strtotime("+$row[date_confirm] day", strtotime($strStartDate)));
// echo"$strNewDate";
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>css print report table continue</title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            font-family: "Angsana New";
            font-size: 16px;
        }

        html {
            font-family: "Angsana New";
            font-size: 16px;
            color: #000000;
        }

        body {
            font-family: "Angsana New";
            font-size: 16px;
            padding: 0;
            margin: 0;
            color: #000000;
        }

        .headTitle {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            font-family: "Angsana New";
        }

        .headerTitle01 {
            border: 1px solid #333333;
            border-left: 2px solid #000;
            border-bottom-width: 2px;
            border-top-width: 2px;
            font-size: 16px;
            font-family: "Angsana New";
        }

        .headerTitle01_r {
            border: 1px solid #333333;
            border-left: 2px solid #000;
            border-right: 2px solid #000;
            border-bottom-width: 2px;
            border-top-width: 2px;
            font-size: 11px;
            font-family: "Angsana New";
        }

        /* สำหรับช่องกรอกข้อมูล  */
        .box_data1 {
            font-family: "Angsana New";
            height: 18px;
            border: 0px dotted #333333;
            border-bottom-width: 1px;
        }

        /* กำหนดเส้นบรรทัดซ้าย  และด้านล่าง */
        .left_bottom {
            border-left: 2px solid #000;
            border-bottom: 1px solid #000;
        }

        /* กำหนดเส้นบรรทัดซ้าย ขวา และด้านล่าง */
        .left_right_bottom {
            border-left: 2px solid #000;
            border-bottom: 1px solid #000;
            border-right: 2px solid #000;
        }

        /* สร้างช่องสี่เหลี่ยมสำหรับเช็คเลือก */
        .chk_box {
            display: block;
            width: 10px;
            height: 10px;
            overflow: hidden;
            border: 1px solid #000;
        }

        /* css ส่วนสำหรับการแบ่งหน้าข้อมูลสำหรับการพิมพ์ */
        @media all {
            .page-break {
                display: none;
            }

            .page-break-no {
                display: none;
            }
        }

        @media print {
            .page-break {
                display: block;
                height: 1px;
                page-break-before: always;
            }

            .page-break-no {
                display: block;
                height: 1px;
                page-break-after: avoid;
            }
        }
    </style>
        <link href="../../dist-assets/css/themes/styleforprint2.css" rel="stylesheet" />
</head>

<body>
    <?php
    $total_page_data = 0;  // เก็บจำนวนหน้า รายการทั้งหมด
    $total_page_item = 14; // จำนวนรายการที่แสดงสูงสุดในแต่ละหน้า
    $total_page_item_all = 0; // ไว้เก็บจำนวนรายการจริงทั้งหมด
    $arr_data_set = array(array()); // [][];
    $sql = "SELECT * FROM provinces";
    $i = 1;
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {  // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
        $total_page_item_all = $result->num_rows; // จำนวนรายการทั้งหมด
        $total_page_data = ceil($total_page_item_all / $total_page_item); // หาจำนวนหน้าจากรายการทั้งหมด
        while ($row = $result->fetch_assoc()) { // วนลูปแสดงรายการ     
            $arr_data_set['id'][$i] = $row['id'];
            $arr_data_set['name_th'][$i] = $row['name_th'];
            $i++;
        }
    }
    ?>
    <?php for ($i = 1; $i <= $total_page_data; $i++) { ?>
        <div class="page-break<?= ($i == 1) ? "-no" : "" ?>">&nbsp;</div>
        <div class="col-12">
        <div class="col-12">
            <div class="row">
                <div class="col-6">
                    <h4>บริษัท วันเอ็ม จำกัด</h4>
                    <p>290 ม.1 ต.กระโสบ อ.เมือง จ.อุบลราชธานี 34000</p>
                    <p>เลขที่ประจำตัวผู้เสียภาษี 0345555000224 สำนักงานใหญ่</p>
                </div>
                <div class="col-6 text-right">
                    <h4>ใบเสนอราคา/ใบสั่งซื้อ</h4>
                </div>
            </div>
            <div class="mt-3 mb-4 border-top"></div>
            <div class="row mb-5">
                <div class="col-6 mb-3 mb-sm-0">
                  
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
                    <p><strong>ชื่อลูกค้า : </strong> <?= $row3['customer_name'] ?></p>
                    <p><strong>ที่อยู่ : </strong><?php echo $row3['bill_address'] . " ต." . $row6['name_th'] . "  อ." . $row7['name_th'] . " จ." . $row8['name_th']; ?> </p>
                    <p><strong>โทร : </strong> <?= $row3['tel'] ?></p>
                    <p><strong>อ้างอิง : </strong><?= $row3['contact_name'] ?></p>
                    <p>บริษัทฯ มีความยินดีที่จะเสนอราคาสินค้า ดังต่อไปนี้ : </p>
                </div>
                <div class="col-6 text-sm-right">
                         <div class="col-6 ">
                        <p><span>เลขที่ใบเสนอราคา </span><span><?php echo "$rowx[qt_id]"; ?></span></p>
                        <p><span>ลำดับการสั่งซื้อ</span> <span><?php echo "$rowx[order_id]"; ?></span></p>
                        <p><span>วันที่</span> <span><?php $date = explode(" ", $rowx['qt_date']);
                                                        $dat = datethai2($date[0]);
                                                        echo "$dat"; ?> </span></p>
                        <p><span>ยืนราคา : <?php echo "$rowx[date_confirm]"; ?> วัน </span> <span>ถึงวันที่
                                <?php $date = explode(" ", $strNewDate);
                                $dat = datethai2($date[0]);
                                echo "$dat"; ?></span></p>
                        <p><span>เงื่อนไขการชำระเงิน : </span><span><?= $row2['name'] ?></span></p>
                        </div>
                        <div class="col-6 ">
                        <p><?php echo "$row[qt_id]"; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     
    
                    <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse;border-top:5px double #000;margin: 15px;  ">
                        <tr>
                            <td width="30" rowspan="2" class="headerTitle01" align="center" valign="middle">ลำดับที่</td>
                            <td width="150" rowspan="2" class="headerTitle01" align="center" valign="middle">รายการ</td>
                            <td width="130" rowspan="2" class="headerTitle01" align="center" valign="middle">จำนวน</td>
                            <td width="70" rowspan="2" class="headerTitle01" align="center" valign="middle">หน่วยละ</td>
                            <td width="60" rowspan="2" class="headerTitle01" align="center" valign="middle">จำนวนเงิน</td>
                         
                        </tr>
                        <tr>
                        </tr>
                        <?php
                        // ส่วนของ repeat content
                        for ($v = 1; $v <= $total_page_item; $v++) {
                            $item_i = (($i - 1) * $total_page_item) + $v;
                            $_name_th = isset($arr_data_set['name_th'][$item_i]) ? $arr_data_set['name_th'][$item_i] : "";
                            $item_i = isset($arr_data_set['name_th'][$item_i]) ? $item_i : "";
                        ?>
                            <tr>
                                <td height="20" align="center" class="left_bottom"><?= $item_i ?></td>
                                <td align="left" class="left_bottom">&nbsp;
                                    <?= $_name_th ?>
                                </td>
                                <td align="left" class="left_bottom">&nbsp;</td>
                                <td align="left" class="left_bottom">&nbsp;</td>
                               
                                <td align="left" class="left_right_bottom">&nbsp;</td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td height="20" align="left" class="left_bottom">&nbsp;</td>
                            <td align="left" class="left_bottom">&nbsp;</td>
                            <td align="left" class="left_bottom">&nbsp;</td>
                            <td align="left" class="left_bottom">&nbsp;</td>
                            <td align="left" class="left_right_bottom">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left" style="border-top:2px solid #000;">รวมทั้งสิ้น
                                Total
                                <input name="textfield2" type="text" class="box_data1" id="textfield2" style="text-align:center;width:250px;" />
                                ฉบับ/ห่อ
                                Pieces
                            </td>
                            <td align="center" style="border-top:2px solid #000;">เป็นเงิน
                                Amount</td>
                            <td height="20" align="left" class="left_right_bottom" style="border-bottom:5px double #000;border-top:2px solid #000;">&nbsp;</td>
                            <td align="left" class="left_right_bottom" style="border-bottom:5px double #000;border-top:2px solid #000;">&nbsp;</td>
                           
                        </tr>
                    </table>
             
                    <div class="page-footer">
        <div class="mt-3 mb-4 border-top"></div>
        <div class="col-12">
            <div class="col-12 mb-3 mb-sm-0">
                <h5 class="font-weight-bold">เงื่อนไขการขาย</h5>
                <p>1.มัดจำไม่น้อยกว่า 30% ของมูลค่าสินค้า เมื่อทำการสั่งซื้อสินค้า และชำระค่าสินค้าส่วนที่เหลือในวันที่จัดส่ง </p>
                <p>2.ผู้ซื้อเป็นผู้จัดเตรียมสถานที่สำหรับลงสินค้า  และทางบริษัทฯขอสงวนสิทธิ์ในการลงสินค้าตามสถานที่เท่าที่รถเข้าถึง </p>
                <p>3.บริษัทฯ ขอสงวนสิทธิ์ในการลงสินค้าต่อเที่ยว (ไม่เกิน 2 ชั่วโมง) หากเกินเวลาผู้ขายคิดเพิ่มชั่วโมงละ 500 บาท หรือตามตกลง </p>
                <p>4.สินค้ารับฝากไม่เกิน 1 เดือน นับจากวันที่กำหนดส่งสินค้า หากยังไม่รับสินค้า ทางบริษัทฯ ขอเก็บค่าดูแลสินค้า 5%
                    ต่อเดือนของมูลค่าสินค้า </p>
                <p>5.บริษัทฯขอสงวนสิทธิ์ไม่คืนมัดจำ/ค่าสินค้าในทุกกรณี หากผู้ชื้อแจ้งยกเลิก/เปลี่ยนแปลงรายการสินค้า</p>
                <p>6.บริษัทฯขอไม่รับผิดชอบต่อความเสียหายใดๆ หลังจากตรวจรับสินค้าแล้ว </p>
                <br>
                <h5 class="font-weight-bold">วิธีการชำระเงิน</h5>
                <p>ชื่อบัญชี : บจก.วันเอ็ม ชื่อธนาคาร/เลขที่บัญชี : ธนาคารกสิกรไทย ออมทรัพย์ สาขาสุนีย์ทาวเวอร์ เลขที่บัญชี 685-2-29088-7 </p>
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
        </table>
        </div>
    <?php } ?>
</body>

</html>