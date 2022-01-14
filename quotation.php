<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
$emp_id=$_SESSION["username"]; 
include './include/connect.php';
include './include/config_date.php';
$order_id = $_REQUEST['order_id'];
$sqlx = "SELECT * FROM orders   WHERE order_id= '$order_id'";
$rsx = $conn->query($sqlx);
$rowx = $rsx->fetch_assoc();
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
$strNewDate = date("Y-m-d", strtotime("+$rowx[date_confirm] day", strtotime($strStartDate)));
// echo"$strNewDate";
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>ใบเสนอราคา</title>
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
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            font-family: "Angsana New";
        }

        .headerTitle01 {
            border: 1px solid #333333;
            border-left: 1px solid #000;
            border-bottom-width: 1px;
            border-top-width: 1px;
            font-size: 18px;
            font-family: "Angsana New";
            font-weight: 700;
        }

        .headerTitle01_r {
            border: 1px solid #333333;
            border-left: 2px solid #000;
            border-right: 2px solid #000;
            border-bottom-width: 2px;
            border-top-width: 2px;
            font-size: 18px;
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
            border-left: 1px solid #000;
            /* border-bottom: 1px solid #000; */
            font-family: "Angsana New";
            font-size: 18px;
        }

        .rightx {
            border-right: 1px solid #000;
            /* border-bottom: 1px solid #000; */
            font-family: "Angsana New";
            font-size: 18px;
        }

        .bottomx {
            border-bottom: 1px solid #000;
            /* border-bottom: 1px solid #000; */
            font-family: "Angsana New";
            font-size: 18px;
        }

        .bottomx2 {
            border-bottom: 1px solid #000;
            border-right: 1px solid #000;
            font-family: "Angsana New";
            font-size: 18px;
        }

        .bottomx2_firt {
            border-bottom: 1px solid #000;
            border-right: 1px solid #000;
            border-left: 1px solid #000;
            font-family: "Angsana New";
            font-size: 18px;
        }

        .bottomx_rl {
            border-bottom: 1px solid #000;
            border-right: 1px solid #000;
            font-family: "Angsana New";
            font-size: 18px;
        }

        /* กำหนดเส้นบรรทัดซ้าย ขวา และด้านล่าง */
        .left_right_bottom {
            border-left: 1px solid #000;
            /* border-bottom: 1px solid #000; */
            border-right: 1px solid #000;
            font-family: "Angsana New";
            font-size: 18px;
        }

        .left_bottom1 {
            border-left: 1px solid #000;
            border-bottom: 1px solid #000;
            /* border-right: 1px solid #000; */
            font-family: "Angsana New";
            font-size: 18px;
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
    <link href="../../dist-assets/css/themes/styleforprint2.css?v=5" rel="stylesheet" />
</head>

<body>
    <?php
    $total_page_data = 0;  // เก็บจำนวนหน้า รายการทั้งหมด
    $total_page_item = 8; // จำนวนรายการที่แสดงสูงสุดในแต่ละหน้า
    $total_page_item_all = 0; // ไว้เก็บจำนวนรายการจริงทั้งหมด
    $arr_data_set = array(array()); // [][];
    $sql = "SELECT * FROM order_details INNER JOIN product_type  ON order_details.ptype_id=product_type.ptype_id  AND  (order_details.order_id='$order_id')  ORDER BY  product_type.num_orderby,order_details.product_id, order_details.date_create ASC    ";
    $i = 1;
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {  // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
        $total_page_item_all = $result->num_rows; // จำนวนรายการทั้งหมด
        $total_page_data = ceil($total_page_item_all / $total_page_item); // หาจำนวนหน้าจากรายการทั้งหมด
        while ($row = $result->fetch_assoc()) { // วนลูปแสดงรายการ     
            $arr_data_set['id'][$i] = $row['id'];
            $arr_data_set['idx'][$i] = ++$id;
            $arr_data_set['product_id'][$i] = $row['product_id'];
            $arr_data_set['qty'][$i] = $row['qty'];
            $arr_data_set['disunit'][$i] = $row['disunit'];
            $arr_data_set['unit_price'][$i] = $row['unit_price'];
            $arr_data_set['ptype'][$i] = $row['ptype_id'];
            $arr_data_set['status_new'][$i] = $row['status_new'];
            $i++;
        }
    }

    ?>
    <?php for ($i = 1; $i <= $total_page_data; $i++) { ?>
        <div class="page-break<?= ($i == 1) ? "-no" : "" ?>"></div>

        <div class="col-12 text-right">
            <button class="btn-primary mb-sm-0 mb-3" onclick="window.print()">พิมพ์ใบเสนอราคา</button>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-2_logo">
                    <img class="logox" src="../../dist-assets/images/logo2.fw.png" alt="">
                </div>
                <div class="col-5">
                    <h4 class="font-weight-bold">บริษัท วันเอ็ม จำกัด</h4>
                    <p>290 ม.1 ต.กระโสบ อ.เมือง จ.อุบลราชธานี 34000</p>
                    <p>เลขที่ประจำตัวผู้เสียภาษี 0345555000224 สำนักงานใหญ่</p>
                    <p>โทร. 061-436-2825</p>
                </div>
                <div class="col-5 text-right">
                    <h2 class="font-weight-bold">ใบเสนอราคา/ใบสั่งซื้อ</h2>
                </div>
            </div>
        </div>
        <div class="mt-3 mb-4 border-top"></div>
        <div class="row">
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
                                                if($row3['province']==1){ $t='แขวง'; $a=''; }else{ $t='ต.'; $a='อ.';  }
                                                ?>
                <div class="rowx_cus">
                    <div class="col-4x_cus">
                        <p style="font-size: 18px;font-weight: 700;">ชื่อลูกค้า </p>
                        <p style="font-size: 18px;font-weight: 700;">ที่อยู่ </p>
                        <p style="font-size: 18px;font-weight: 700;"> &nbsp;</p>
                        <p style="font-size: 18px;font-weight: 700;">โทร </p>
                        <p style="font-size: 18px;font-weight: 700;">อ้างอิง </p>

                    </div>
                    <div class="col-1x_cus">
                        <p style="font-size: 18px;">:</p>
                        <p style="font-size: 18px;">:</p>
                        <p style="font-size: 18px;padding-top:3px;">&nbsp;</p>
                        <p style="font-size: 18px;">:</p>
                        <p style="font-size: 18px;">:</p>
                    </div>
                    <div class="col-4xx_cus">
                        <p style="font-size: 18px;"><?= $row3['customer_name'] ?></p>
                        <p style="font-size: 18px;"><?php echo $row3['bill_address'] . " $t" . $row6['name_th']; ?></p>
                        <p style="font-size: 18px;"><?php echo $a . $row7['name_th'] . " จ." . $row8['name_th']; ?>
                        <p style="font-size: 18.5px;padding-top:4px;"><?= $row3['tel'] ?></p>
                        <p style="font-size: 18px;"><?php if($rowx['contact_name']=='-'){ echo $row3['contact_name'];  }else{ echo $rowx['contact_name']; } ?></p>

                    </div>
                    <div class="rowx_cus">
                    <p style="font-size: 18px;font-weight: 700; padding-left: 4px;">เลขประจำตัวผู้เสียภาษี &nbsp; </p> <p style="font-size: 18px;">: <?php if ($row3['tax_number'] == '') {
                                                        echo "-";
                                                    } else {
                                                        echo $row3['tax_number'];
                                                    } ?> </p>
            </div>
                </div>

            </div>
            <div class="col-5 text-sm-right">
                <div class="rowx">
                    <div class="col-4x">
                        <p style="font-size: 18px;">เลขที่ใบเสนอราคา </p>
                        <p style="font-size: 18px;">ลำดับการสั่งซื้อ </p>
                        <p style="font-size: 18px;">วันที่ </p>
                        <p style="font-size: 18px;">ยืนราคา <?php echo "$rowx[date_confirm]"; ?> วัน </p>
                        <p style="font-size: 18px;">เงื่อนไขการชำระเงิน </p>
                    </div>
                    <div class="col-1x">
                        <p style="font-size: 18px;">:</p>
                        <p style="font-size: 18px;">:</p>
                        <p style="font-size: 18px;">:</p>
                        <p style="font-size: 18px;">:</p>
                        <p style="font-size: 18px;">:</p>
                    </div>
                    <div class="col-4xx">
                        <p style="font-size: 18px;"><?php echo "$rowx[qt_id]"; ?></p>
                        <p style="font-size: 18px;"><?php echo "$rowx[order_id]"; ?> </p>
                        <p style="font-size: 18px;"><?php $date = explode(" ", $rowx['qt_date']);
                                                    $dat = datethai2($date[0]);
                                                    echo "$dat"; ?> </p>
                        <p style="font-size: 18px;">ถึงวันที่
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
        <div class="row">
            <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top: 15px; margin-right: 15px; margin-left: 15px; margin-bottom: 0px;  ">
                <tr>
                    <td width="30" rowspan="2" class="headerTitle01" align="center" valign="middle">ลำดับ</td>
                    <td width="280" rowspan="2" class="headerTitle01" align="center" valign="middle">รายการ</td>
                    <td width="80" rowspan="2" class="headerTitle01" align="center" valign="middle">จำนวน</td>
                    <td width="50" rowspan="2" class="headerTitle01" align="center" valign="middle">ราคาต่อหน่วย</td>
                    <td width="50" rowspan="2" class="headerTitle01" align="center" valign="middle">จำนวนเงิน</td>

                </tr>
                <tr>
                </tr>
                <?php
                // ส่วนของ repeat content
                for ($v = 1; $v <= $total_page_item; $v++) {
                    $item_i = (($i - 1) * $total_page_item) + $v;
                    $_product_id = isset($arr_data_set['product_id'][$item_i]) ? $arr_data_set['product_id'][$item_i] : "";
                    $_qty = isset($arr_data_set['qty'][$item_i]) ? $arr_data_set['qty'][$item_i] : "";
                    $_idx = isset($arr_data_set['idx'][$item_i]) ? $arr_data_set['idx'][$item_i] : "";
                    $_ptype = isset($arr_data_set['ptype'][$item_i]) ? $arr_data_set['ptype'][$item_i] : "";
                    $_disunit = isset($arr_data_set['disunit'][$item_i]) ? $arr_data_set['disunit'][$item_i] : "";
                    $_unit_price = isset($arr_data_set['unit_price'][$item_i]) ? $arr_data_set['unit_price'][$item_i] : "";
                    $_status_new = isset($arr_data_set['status_new'][$item_i]) ? $arr_data_set['status_new'][$item_i] : "";
                    $item_i = isset($arr_data_set['name_th'][$item_i]) ? $item_i : "";
                ?>
                    <?php  if ($_ptype <> 'TF') { ?>
                        <tr>
                            <td height="20" align="center" class="left_bottom" <?php if($_idx==1){ ?>style="padding-top: 5px;"<?php } ?>><?= $_idx ?></td>
                            <td align="left" class="left_bottom" <?php if($_idx==1){ ?>style="padding-top: 5px;"<?php } ?>>&nbsp;
                                <?php 
                                $sqlx3 = "SELECT * FROM product  WHERE product_id= '$_product_id'";
                                $rsx3 = $conn->query($sqlx3);
                                $rowx3 = $rsx3->fetch_assoc();
                                echo $rowx3['product_name'];
                                if ($rowx3['spacial'] == '') {
                                } else {
                                    echo "  (" . $rowx3['spacial'] . ")";
                                }
                                if($_status_new==1){echo"*";}
                                $sql_unit = "SELECT * FROM unit  WHERE id= '$rowx3[units]' ";
                                $rs_unit = $conn->query($sql_unit);
                                $row_unit = $rs_unit->fetch_assoc();
                                $price_dis = $_unit_price - $_disunit;
                                $total_price = $price_dis * $_qty;
                                $total_all = $total_all + $total_price;
                                ?>
                            </td>
                            <td align="left" class="left_bottom"<?php if($_idx==1){ ?>style="padding-top: 5px;"<?php } ?>>
                                <div class="row_pro">
                                    <div class="col-4x_product"><?= $_qty ?>
                                    </div>
                                    <div class="col-4x_unit"><?= $row_unit['unit_name'] ?>&nbsp;&nbsp;</div>
                                </div>
                            </td>
                            <td align="right" class="left_bottom"<?php if($_idx==1){ ?>style="padding-top: 5px;"<?php } ?>><?php if ($price_dis == "") {
                                                                    } else {
                                                                        echo number_format($price_dis, '2', '.', ',');
                                                                    } ?>&nbsp;&nbsp;</td>

                            <td align="right" class="left_right_bottom"><?php if ($total_price == "") {
                                                                        } else {
                                                                            echo number_format($total_price, '2', '.', ',');
                                                                        } ?>&nbsp;&nbsp;</td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td height="20" align="center" class="left_bottom"><?= $_idx ?></td>
                            <td align="left" class="left_bottom">&nbsp;

                                <?php
                                $sqlx3 = "SELECT * FROM product  WHERE product_id= '$_product_id'";
                                $rsx3 = $conn->query($sqlx3);
                                $rowx3 = $rsx3->fetch_assoc();
                                echo 'ค่าจัดส่ง'.' ' . '(' . $rowx3['product_name'] . ')';
                                $sql_unit = "SELECT * FROM unit  WHERE id= '$rowx3[units]' ";
                                $rs_unit = $conn->query($sql_unit);
                                $row_unit = $rs_unit->fetch_assoc();
                                $price_dis = $_unit_price - $_disunit;
                                $total_price = $price_dis * $_qty;
                                $total_all = $total_all + $total_price;
                                ?>
                            </td>
                            <td align="left" class="left_bottom">
                                <div class="row_pro">
                                    <div class="col-4x_product"><?= $_qty ?>
                                    </div>
                                    <div class="col-4x_unit"><?php if ($row_unit['unit_name'] == '') {
                                                                    echo "เที่ยว";
                                                                } else {
                                                                    echo $row_unit['unit_name'];
                                                                } ?>&nbsp;&nbsp;</div>
                                </div>
                            </td>
                            <td align="right" class="left_bottom"><?php if ($price_dis == "") {
                                                                    } else {
                                                                        echo number_format($price_dis, '2', '.', ',');
                                                                    } ?>&nbsp;&nbsp;</td>

                            <td align="right" class="left_right_bottom"><?php if ($total_price == "") {
                                                                        } else {
                                                                            echo number_format($total_price, '2', '.', ',');
                                                                        } ?>&nbsp;&nbsp;</td>
                        </tr>

                <?php  }
                } ?>
                <tr>
                    <td height="20" align="left" class="bottomx2_firt">&nbsp;</td>
                    <td align="left" class="bottomx2">&nbsp;</td>
                    <td align="left" class="bottomx2">&nbsp;</td>
                    <td align="left" class="bottomx2">&nbsp;</td>
                    <td align="left" class="bottomx2">&nbsp;</td>
                </tr>
                <?php if ($total_page_data == $i) { ?>
                    <?php $sql_or = "SELECT * FROM orders  WHERE order_id= '$order_id'";
                    $rs_or  = $conn->query($sql_or);
                    $row_or = $rs_or->fetch_assoc();
                    $sub_total = $total_all - $row_or['discount'];
                    $first_total = ($sub_total * 100) / 107;
                    $tax = ($sub_total - $first_total);
                    $grand_total = ($first_total + $tax);
                    ?>

                    <tr>
                        <td colspan="2" class="left_bottom" align="left" style="border-top:1px solid #000;">
                        </td>
                        <td align="left" colspan="2" style="border-top:1px solid #000; font-size: 18px;">&nbsp;รวมเป็นเงินทั้งสิ้น</td>

                        <td align="right" class="left_right_bottom" style="border-bottom:5px;border-top:1px solid #000;"><?php echo number_format($total_all, '2', '.', ',') ?>&nbsp;&nbsp;</td>

                    </tr>
                    <tr>
                        
                        <td colspan="2" class="left_bottom" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $row_or['discount_text']; ?> </td>
                        <td align="left" colspan="2" style="font-size: 18px;">&nbsp;หักส่วนลด</td>

                        <td align="right" class="left_right_bottom"><?php echo number_format($row_or['discount'], '2', '.', ',') ?>&nbsp;&nbsp;</td>

                    </tr>
                   <?php if($rowx['vat']=='Y'){  ?> <tr>
                        <td colspan="2" class="left_bottom" align="left"> </td>
                        <td align="left" colspan="2" style="font-size: 18px;">&nbsp;จำนวนเงินก่อนรวมภาษี </td>

                        <td align="right" class="left_right_bottom"><?php echo number_format($first_total, '2', '.', ',') ?>&nbsp;&nbsp;</td>

                    </tr>
                    <?php } ?>
                    <?php if($rowx['vat']=='Y'){  ?> <tr>
                        <td colspan="2" class="left_bottom" align="left"> </td>
                        <td align="left" colspan="2" style="font-size: 18px;">&nbsp;จำนวนเงินภาษีมูลค่าเพิ่ม&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;7.00% </td>

                        <td align="right" class="left_right_bottom"><?php echo number_format($tax, '2', '.', ',') ?>&nbsp;&nbsp;</td>

                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2" class="left_bottom1" align="left">
                            <div class="row_text">
                                <div class="col-3_text"> ตัวอักษร
                                </div>
                                <div class="col-9_text ">
                                    <?php echo Convert($grand_total); ?>
                                </div>
                            </div>
                        </td>
                        <td class="bottomx_rl" colspan="2" align="center" style="font-size: 18px;">&nbsp;รวมเป็นเงิน</td>

                        <td align="right" class="bottomx_rl" style="font-size: 18px;  font-weight: 700;"><?php echo number_format($grand_total, '2', '.', ',') ?>&nbsp;&nbsp;</td>

                    </tr>
                <?php } ?>

            </table>
        </div>
        <div class="page-footer">
            <div class="row_con">
                <div class="mt-3 mb-4 border-top"></div>

                <div class="col-12_con mb-3 mb-sm-0">
                    <h6 class="font-weight-bold" style="font-size: 18px; padding-top: 8px; padding-bottom: 0px; ">เงื่อนไขการขาย</h6>
                    <p style="font-size: 18px;">1. มัดจำไม่น้อยกว่า 30% ของมูลค่าสินค้า เมื่อทำการสั่งซื้อสินค้า และชำระค่าสินค้าส่วนที่เหลือก่อนจัดส่งสินค้า </p>
                    <p style="font-size: 18px;">2. ผู้ซื้อเป็นผู้จัดเตรียมสถานที่สำหรับลงสินค้า และทางบริษัทฯ ขอสงวนสิทธิ์ในการลงสินค้าตามสถานที่เท่าที่รถเข้าถึงได้ </p>
                    <p style="font-size: 18px;">3. บริษัทฯ ขอสงวนสิทธิ์ในการลงสินค้าต่อเที่ยว (ไม่เกิน 2 ชั่วโมง) หากเกินเวลาผู้ขายคิดเพิ่มชั่วโมงละ 500 บาท หรือตามตกลง </p>
                    <p style="font-size: 18px;">4. สินค้ารับฝากไม่เกิน 1 เดือน นับจากวันที่กำหนดส่งสินค้า หากยังไม่รับสินค้า ทางบริษัทฯ ขอเก็บค่าดูแลสินค้า 5%
                        ต่อเดือนของมูลค่าสินค้า </p>
                    <p style="font-size: 18px;">5. บริษัทฯ ขอสงวนสิทธิ์ไม่คืนมัดจำ/ค่าสินค้าในทุกกรณี หากผู้ชื้อแจ้งยกเลิก/เปลี่ยนแปลงรายการสินค้า</p>
                    <p style="font-size: 18px;">6. บริษัทฯ ขอไม่รับผิดชอบต่อความเสียหายใดๆ หลังจากตรวจรับสินค้าแล้ว </p>
                    <br>
                    <h6 class="font-weight-bold" style="font-size: 18px;">วิธีการชำระเงิน</h6>
                    <?php if($rowx['vat']=='Y'){  ?> <p style="font-size: 18px;">ชื่อบัญชี : บจก.วันเอ็ม ธนาคารกสิกรไทย สาขาสุนีย์ทาวเวอร์ ประเภทออมทรัพย์ เลขที่บัญชี <b>685-2-29088-7 </b> </p> <?php }else{  ?>
                     <p style="font-size: 18px;">ชื่อบัญชี : นายธนศักดิ์  พละศักดิ์  ธนาคารกสิกรไทย  ประเภทออมทรัพย์ เลขที่บัญชี <b>744-2-56311-4 </b> </p> <?php } ?>
                </div>
                <div class="mt-3 mb-4 border-top"></div>
            </div>
            <div class="row_con">
                <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top: 0px; margin-right: 0px; margin-left: 0px; margin-bottom: 0px;  ">
                    <tr>
                        <td width="300" valign="middle">
                            <div class="col-12_footx text-center">
                            <br><br> 
                                <p> ____________________________</p>

                                <p style="font-size: 18px;">ผู้อนุมัติชื้อ<span></span></p>
                                <br>
                                <p style="font-size: 18px;">วันที่ ________/__________/__________ <span></span></p>
                            </div>
                        </td>
                        <td width="300" valign="middle"></td>
                        <td width="300" valign="middle">
                            <div class="col-12 text-center">
                                <p style="font-size: 18px;">ในนาม บริษัท วันเอ็ม จำกัด</p>
                                <br><br>
                                <p style="font-size: 18px;">ผู้รับมอบอำนาจ ____________________ <span></span></p>
                                <br>
                                <p style="font-size: 18px;">วันที่ ________/__________/__________ <span></span></p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
        </table>
        </div>
    <?php } ?>
</body>

</html>