<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
$order_id = $_REQUEST['order_id'];
$so_id = $_REQUEST['so_id'];

?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sale Order | ใบส่งของ</title>
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
    <link href="../../dist-assets/css/themes/styleforprint2.css?v=18" rel="stylesheet" />
</head>
<?php
include './include/config.php';
include './include/config_text.php';
$datetoday = date('Y-m-d');
$sql_main = "SELECT * FROM orders   WHERE order_id= '$order_id'";
$rs_main = $conn->query($sql_main);
$row_main = $rs_main->fetch_assoc();
// ====
$sql2 = "SELECT * FROM customer_type  WHERE id= '$row_main[cus_type]'";
$rs2 = $conn->query($sql2);
$row2 = $rs2->fetch_assoc();
// ====
$sql3 = "SELECT * FROM customer  WHERE customer_id= '$row_main[cus_id]'";
$rs3 = $conn->query($sql3);
$row3 = $rs3->fetch_assoc();

$sql5 = "SELECT * FROM delivery  WHERE dev_id= '$so_id' AND order_id='$order_id'";
$rs5 = $conn->query($sql5);
$row5 = $rs5->fetch_assoc();
// ===
?>

<body>
    <?php
    $total_page_data = 0;  // เก็บจำนวนหน้า รายการทั้งหมด
    $total_page_item = 22; // จำนวนรายการที่แสดงสูงสุดในแต่ละหน้า
    $total_page_item_all = 0; // ไว้เก็บจำนวนรายการจริงทั้งหมด
    $arr_data_set = array(array()); // [][];
    $sql = "SELECT * FROM deliver_detail  where order_id='$order_id'  AND dev_id='$so_id' order by ptype_id,date_create ASC";
    $i = 1;
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {  // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
        $total_page_item_all = $result->num_rows; // จำนวนรายการทั้งหมด
        $total_page_data = ceil($total_page_item_all / $total_page_item); // หาจำนวนหน้าจากรายการทั้งหมด
        while ($row = $result->fetch_assoc()) { // วนลูปแสดงรายการ     
            $arr_data_set['id'][$i] = $row['id'];
            $arr_data_set['idx'][$i] = ++$id;
            $arr_data_set['product_id'][$i] = $row['product_id'];
            $arr_data_set['qty'][$i] = $row['dev_qty'];
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
            <button class="btn-primary mb-sm-0 mb-3" onclick="window.print()">พิมพ์ใบส่งของ</button>
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
                    <p>โทร. 061-436-2825</p>
                </div>
                <div class="col-5 text-right">
                    <h2 class="font-weight-bold">ใบส่งของ</h2>
                </div>
            </div>
        </div>
        <div class="mt-3 mb-4 border-top"></div>
        <div class="row">
            <div class="col-8 mb-3 mb-sm-0"> <?php
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
                                                $sql_dev = "SELECT * FROM delivery  WHERE order_id= '$order_id' AND dev_id='$so_id'";
                                                $rs_dev  = $conn->query($sql_dev);
                                                $row_dev  = $rs_dev->fetch_assoc();

                                                $sql_TF = "SELECT * FROM deliver_detail  where order_id='$order_id'  AND dev_id='$so_id' AND (ptype_id ='TF' OR ptype_id ='TF0')";
                                                $rs_TF = $conn->query($sql_TF);
                                                $row_TF = $rs_TF->fetch_assoc();
                                                $sqlx3_TF = "SELECT * FROM product  WHERE product_id= '$row_TF[product_id]'";
                                                $rsx3_TF = $conn->query($sqlx3_TF);
                                                $rowx3_TF = $rsx3_TF->fetch_assoc();

                                                ?>
                <div class="rowx_cus">
                    <div class="col-4x_cus">
                        <p style="font-size: 18px;font-weight: 700;">ชื่อลูกค้า </p>
                        <p style="font-size: 18px;font-weight: 700;">ที่อยู่จัดส่ง </p>
                        <p style="font-size: 18px;font-weight: 700;">โทร  </p>
                        <p style="font-size: 18px;font-weight: 700;">อ้างอิง </p>

                    </div>
                    <div class="col-1x_cus">
                        <p style="font-size: 18px;">:</p>
                        <p style="font-size: 18px;">:</p>
                        <p style="font-size: 18px;">:</p>
                        <p style="font-size: 18px;">:</p>
                    </div>
                    <div class="col-4xx_cus">
                        <p style="font-size: 18px;"><?= $row3['customer_name'] ?></p>
                        <p style="font-size: 18px;"><?php  if ($rowx3_TF['product_name'] == '') {
                                                       
                                                        echo $row3['bill_address'] . " $t" . $row6['name_th'] . "  $a" . $row7['name_th'] . " จ." . $row8['name_th'];
                                                    } else {
                                                        if($row5['cus_back']==1||$row5['cus_back']==3){
                                                            echo $row3['bill_address'] . " $t" . $row6['name_th'] . "  $a" . $row7['name_th'] . " จ." . $row8['name_th'];
                                                        }else{ 
                                                        echo $rowx3_TF['product_name'];
                                                    }
                                                    } ?></p>
                        <p style="font-size: 18px;"><?= $row3['tel'] ?></p>
                        <p style="font-size: 18px;"><?= $row3['contact_name'] ?></p>

                    </div>
                </div>

            </div>
            <div class="col-4 text-sm-right">
                <div class="row_so">
                    <div class="col-4_text_so">
                        <p style="font-size: 18px;">เลขที่ใบส่งของ </p>
                        <p style="font-size: 18px;">ลำดับการสั่งซื้อ </p>
                        <p style="font-size: 18px;">วันที่ </p>

                    </div>
                    <div class="col-1x">
                        <p style="font-size: 18px;">:</p>
                        <p style="font-size: 18px;">:</p>
                        <p style="font-size: 18px;">:</p>

                    </div>
                    <div class="col-4_so">
                        <p style="font-size: 18px;"><?= $so_id ?></p>
                        <p style="font-size: 18px;"><?= $order_id ?> </p>
                        <p style="font-size: 18px;"><?php $date = explode(" ", $row5['dev_date']);
                                                    $dat = datethai2($date[0]);
                                                    echo "$dat"; ?> </p>

                    </div>
                </div>

            </div>


        </div>

        </div>
        <div class="row">
            <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top: 15px; margin-right: 15px; margin-left: 15px; margin-bottom: 0px;  ">
                <tr>
                    <td width="30" rowspan="2" class="headerTitle01" align="center" valign="middle">ลำดับ</td>
                    <td width="60" rowspan="2" class="headerTitle01" align="center" valign="middle">รหัสสินค้า</td>
                    <td width="280" rowspan="2" class="headerTitle01" align="center" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;รายละเอียด</td>

                    <td width="80" rowspan="2" class="headerTitle01" align="center" valign="middle">จำนวน</td>

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
                    $item_i = isset($arr_data_set['name_th'][$item_i]) ? $item_i : "";
                    $_status_new = isset($arr_data_set['status_new'][$item_i]) ? $arr_data_set['status_new'][$item_i] : "";
                ?>
                    <?php if ($_ptype <> 'TF') { ?>
                        <tr>
                            <td height="20" align="center" class="left_bottom"<?php if($_idx==1){ ?>style="padding-top: 5px;"<?php } ?>><?= $_idx ?></td>
                            <td align="center" class="left_bottom" <?php if($_idx==1){ ?>style="padding-top: 5px;"<?php } ?>>&nbsp;&nbsp;<?php echo "$_product_id" . '&nbsp;'; ?></td>
                            <td align="left" class="left_bottom" <?php if($_idx==1){ ?>style="padding-top: 5px;"<?php } ?>>&nbsp;&nbsp;
                                <?php
                                $sqlx3 = "SELECT * FROM product  WHERE product_id= '$_product_id'";
                                $rsx3 = $conn->query($sqlx3);
                                $rowx3 = $rsx3->fetch_assoc();
                                echo $rowx3['product_name'];
                                if ($rowx3['spacial'] == '') {
                                } else {
                                    echo "  (" . $rowx3['spacial'] . ")";
                                }
                              
                                if($_status_new==1){ echo"*";}
                                $sql_unit = "SELECT * FROM unit  WHERE id= '$rowx3[units]' ";
                                $rs_unit = $conn->query($sql_unit);
                                $row_unit = $rs_unit->fetch_assoc();
                                $price_dis = $_unit_price - $_disunit;
                                $total_price = $price_dis * $_qty;
                                $total_all = $total_all + $total_price;
                                ?>
                            </td>
                            <td align="left" class="left_right_bottom" <?php if($_idx==1){ ?>style="padding-top: 5px;"<?php } ?>>
                                <div class="row_pro">
                                    <div class="col-4x_product"><?= $_qty ?>
                                    </div>
                                    <div class="col-4x_unit"><?= $row_unit['unit_name'] ?>&nbsp;&nbsp;</div>
                                </div>
                            </td>

                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td height="20" align="center" class="left_bottom"><?= $_idx ?></td>
                            <td align="center" class="left_bottom">&nbsp;&nbsp;<?php echo "$_product_id" . '&nbsp;'; ?></td>
                            <td align="left" class="left_bottom">&nbsp;&nbsp;

                                <?php
                                $sqlx3 = "SELECT * FROM product  WHERE product_id= '$_product_id'";
                                $rsx3 = $conn->query($sqlx3);
                                $rowx3 = $rsx3->fetch_assoc();
                                echo 'ค่าจัดส่ง';
                                $sql_unit = "SELECT * FROM unit  WHERE id= '$rowx3[units]' ";
                                $rs_unit = $conn->query($sql_unit);
                                $row_unit = $rs_unit->fetch_assoc();
                                $price_dis = $_unit_price - $_disunit;
                                $total_price = $price_dis * $_qty;
                                $total_all = $total_all + $total_price;
                                ?>
                            </td>
                            <td align="left" class="left_right_bottom">
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

                        </tr>

                <?php  }
                } ?>
                <tr>
                    <td height="20" align="left" class="bottomx2_firt">&nbsp;</td>
                    <td align="left" class="bottomx2">&nbsp;</td>
                    <td align="left" class="bottomx2">&nbsp;</td>
                    <td align="left" class="bottomx2">&nbsp;</td>

                </tr>


            </table>
        </div>
        <div class="page-footer">
            <div class="row_con">
                <div class="mt-3 mb-4 border-top"></div>

                <div class="col-12_con mb-3 mb-sm-0">
                    <!-- <h6 class="font-weight-bold" style="font-size: 20px;" >เงื่อนไขการขาย</h6> -->
                    <br>
                    <p style="font-size: 18px;">- ได้รับสินค้าตามรายการข้างบนนี้ในสภาพสมบูรณ์ถูกต้องครบถ้วนแล้ว </p>
                    <p style="font-size: 18px;">- สินค้ายังเป็นกรรมสิทธิ์ของทางบริษัทฯ จนกว่าผู้ซื้อจะชำระสินค้าเรียบร้อยแล้ว </p>
                    <p style="font-size: 18px;">- ทางบริษัทฯ ขอสงวนสิทธิ์ไม่รับคืนสินค้าในกรณีที่ไม่ได้เกิดจากความผิดพลาดของทางบริษัทฯ</p>
                    <br>
                </div>
                <div class="mt-3 mb-4 border-top"></div>
            </div>
            <div class="row_con">
                <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top: 0px; margin-right: 0px; margin-left: 0px; margin-bottom: 0px;  ">
                    <tr>
                        <td width="300" class="rightx" valign="middle">
                            <div class="col-12_footx text-center">
                                <br> <br>
                                <p> _________________________</p>

                                <p>ผู้รับสินค้า<span></span></p>
                                <br>
                                <p>วันที่ _____/_______/______ <span></span></p>
                            </div>
                        </td>
                        <td width="300" class="rightx" valign="middle">
                            <div class="col-12_footx text-center"> <br> <br>
                                <p> _________________________</p>

                                <p>พนักงานส่งของ<span></span></p>
                                <br>
                                <p>วันที่ _____/_______/______ <span></span></p>
                            </div>
                        </td>
                        <td width="300" class="rightx" valign="middle">
                            <div class="col-12 text-center">
                                <br> <br>
                                <p> _________________________</p>

                                <p>ผู้ตรวจสอบ<span></span></p>
                                <br>
                                <p>วันที่ _____/_______/______ <span></span></p>
                            </div>
                        </td>
                        <td width="300" valign="middle">
                        <div class="col-12 text-center">
                    <p>ในนาม บริษัท วันเอ็ม จำกัด</p>
                    <br> 
                    <p> _________________________</p>
                    <p>ผู้รับมอบอำนาจ<span></span></p>
                    <br>
                    <p>วันที่ _____/_______/______ <span></span></p>
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