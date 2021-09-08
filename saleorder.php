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
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Sale Order | ใบส่งของ</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <!-- <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" /> -->
    <!-- <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" /> -->
    <link href="../../dist-assets/css/themes/styleforprint.css?v=4" rel="stylesheet" />

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
include './include/config_text.php';
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

$sql5 = "SELECT * FROM delivery  WHERE dev_id= '$so_id' AND order_id='$order_id'";
$rs5 = $conn->query($sql5);
$row5 = $rs5->fetch_assoc();
// ===
?>

<body class="qt-so text-left">

    <!--  header  -->

    <div class="page-header">
        <div class="col-12 text-right">
            <button class="btn-primary mb-sm-0 mb-3" onclick="window.print()">พิมพ์ใบส่งของ</button>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-6">
                    <h4 class="font-weight-bold">บริษัท วันเอ็ม จำกัด</h4>
                    <p>290 ม.1 ต.กระโสบ อ.เมือง จ.อุบลราชธานี 34000</p>
                    <p>เลขที่ประจำตัวผู้เสียภาษี 0345555000224 สำนักงานใหญ่</p>
                </div>
                <div class="col-6 text-right">
                    <h2 class="font-weight-bold">ใบส่งของ</h2>
                </div>
            </div>
            <div class="mt-3 mb-4 border-top"></div>
            <div class="row mb-5">
                <div class="col-8 mb-3 mb-sm-0">
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

                $sql_dev = "SELECT * FROM delivery  WHERE order_id= '$order_id' AND dev_id='$so_id'";
                $rs_dev  = $conn->query($sql_dev);
                $row_dev  = $rs_dev->fetch_assoc();

                $sql_TF = "SELECT * FROM deliver_detail  where order_id='$order_id'  AND dev_id='$so_id' AND (ptype_id ='TF' OR ptype_id ='TF0')";
                $rs_TF = $conn->query($sql_TF);
                $row_TF = $rs_TF->fetch_assoc();
                $sqlx3 = "SELECT * FROM product  WHERE product_id= '$row_TF[product_id]'";
                $rsx3 = $conn->query($sqlx3);
                $rowx3 = $rsx3->fetch_assoc();
               
                ?>
                    <p><strong>ชื่อลูกค้า : </strong><?= $row3['customer_name'] ?></p>
                    <p><strong>ที่อยู่ : </strong><?php echo $row3['bill_address'] . " ต." . $row6['name_th'] . "  อ." . $row7['name_th'] . " จ." . $row8['name_th']; ?> </p>
                    <p><strong>โทร : </strong> <?= $row3['tel'] ?></p>
                    <p><strong>อ้างอิง : </strong><?= $row3['contact_name'] ?></p>
                    <p><strong>ที่อยู่จัดส่ง : </strong><?=$rowx3['product_name']?></p>
                </div>
                <div class="col-4 text-sm-right">
                  
                    <div class="invoice-summary">
                        <p><span>เลขที่ใบส่งของ</span> <span><?= $so_id ?></span></p>
                        <p><span>ลำดับการสั่งซื้อ</span> <span><?= $order_id ?></span></p>
                        <p><span>วันที่ </span> <span><?php $date = explode(" ", $row5['dev_date']);
                                                    $dat = datethai2($date[0]);
                                                    echo $dat; ?> </span></p>
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
                <p>- ได้รับสินค้าตามรายการข้างบนนี้ในสภาพสมบูรณ์ถูกต้องครบถ้วนแล้ว </p>
                <p>- สินค้ายังเป็นกรรมสิทธิ์ของทางบริษัทฯ จนกว่าผู้ซื้อจะชำระสินค้าเรียบร้อยแล้ว </p>
                <p>- ทางบริษัทฯ ขอสงวนสิทธิ์ไม่รับคืนสินค้าในกรณีที่ไม่ได้เกิดจากความผิดพลาดของทางบริษัทฯ  </p>
            </div>
            <div class="mt-3 mb-4 border-top"></div>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-3 text-center">
                   
                <br><p> ____________________</p>
                    <br>
                    <p>ผู้รับสินค้า<span></span></p>
                    <br>
                    <p>วันที่ _____/_______/______ <span></span></p>
                </div>
                <div class="col-3 text-center">
                <br>  <p> ____________________</p>
                    <br>
                    <p>พนักงานส่งของ<span></span></p>
                    <br>
                    <p>วันที่ _____/_______/______ <span></span></p>
                </div>
                <div class="col-3 text-center">
                <br>   <p> ____________________</p>
                    <br>
                    <p>ผู้ตรวจสอบ<span></span></p>
                    <br>
                    <p>วันที่ _____/_______/______ <span></span></p>
                </div>
                <div class="col-3 text-center">
                <p>ในนาม บริษัท วันเอ็ม จำกัด</p>
                <br> <br>
                    <p>ผู้รับมอบอำนาจ _______________ <span></span></p>
                    <br>
                    <p>วันที่ _____/_______/______ <span></span></p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer  -->

    <!-- Data  -->
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
                                                <th scope="col"  class="text-left" width="50">ลำดับ</th>
                                                <th scope="col" class="text-center" width="250">รหัสสินค้า</th>
                                                <th scope="col" class="text-left" width="750">รายละเอียด</th>
                                                <th scope="col" class="text-right"  width="50px">จำนวน</th>
                                                <th scope="col" class="text-right"  width="20px"></th>
                                                <th scope="col" class="text-left" width="40"></th>
                                                <th scope="col" class="text-left" width="10"></th>
                                             
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                               $sql_pro = "SELECT * FROM deliver_detail  where order_id='$order_id'  AND dev_id='$so_id'  AND ptype_id <> 'TF' order by product_id ASC ";
                                                $result_pro = mysqli_query($conn, $sql_pro);
                                              if (mysqli_num_rows($result_pro) > 0) {
                                              while ($row_pro = mysqli_fetch_assoc($result_pro)) {

                                                  $no = $row_pro['id'];
                                              $product_id = $row_pro['product_id'];
                                           ?> <tr>
                                                <td scope="row" class="text-center"><?= ++$id; ?></td>
                                                <td scope="row" class="text-center"><?= $row_pro['product_id']?></td>
                                                <td> <?php
                                            $sqlx3 = "SELECT * FROM product  WHERE product_id= '$row_pro[product_id]'";
                                            $rsx3 = $conn->query($sqlx3);
                                            $rowx3 = $rsx3->fetch_assoc();
                                            $sql_unit = "SELECT * FROM unit  WHERE id= '$rowx3[units]' ";
                                            $rs_unit = $conn->query($sql_unit);
                                            $row_unit = $rs_unit->fetch_assoc();
                                            if ($rowx3['ptype_id'] == 'TF0') {
                                                echo 'ค่าจัดส่ง';
                                            } else {
                                                echo $rowx3['product_name'] ;
                                            }
                                            ?></td>
                                                <td class="text-right"><?= $row_pro['dev_qty'] ?> </td>
                                                <td class="text-right"></td>
                                                <td class="text-right"><?=$row_unit['unit_name']?></td>
                                                <td class="text-right"></td>
                                            </tr>
                                            <?php }
                                            } ?>
                                            <tr>
                                             <td scope="row" class="text-center"><?= ++$id; ?></td>
                                            
                                                 <?php
                                            $sqlx3 = "SELECT * FROM deliver_detail  where order_id='$order_id'  AND dev_id='$so_id' AND ptype_id='TF' ";
                                            $rsx3 = $conn->query($sqlx3);
                                            $rowx3 = $rsx3->fetch_assoc();
                                            ?> 
                                            <td scope="row" class="text-center"><?= $rowx3['product_id']?></td>
                                            <td>
                                            <?php 
                                            $sqlx31 = "SELECT * FROM product  WHERE product_id= '$rowx3[product_id]'";
                                            $rsx31 = $conn->query($sqlx31);
                                            $rowx31 = $rsx31->fetch_assoc();
                                            if ($rowx31['ptype_id'] == 'TF0') {
                                                echo 'ค่าจัดส่ง';
                                            } else {
                                                echo $rowx31['product_name'] ;
                                            }
                                            $sql_unit = "SELECT * FROM unit  WHERE id= '$rowx31[units]' ";
                                            $rs_unit = $conn->query($sql_unit);
                                            $row_unit = $rs_unit->fetch_assoc();
                                            ?></td>
                                                <td class="text-right"><?= $rowx3['dev_qty'] ?></td>
                                                <td class="text-right"></td>
                                                <td class="text-right"> <?=$row_unit['unit_name']?></td>
                                                <td class="text-right"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-6">

                                </div>
                                <div class="col-2">

                                </div>
                                
                            </div>
                        </div>
                        <!-- <div class="page">PAGE 2</div> -->
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- End Data  -->



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