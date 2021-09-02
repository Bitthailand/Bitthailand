<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config_date.php';
$order_id= $_REQUEST['saleorder_id'];
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
                        <span class="font-weight-bold ml-2 text-danger">( OR64080001 )</span>
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
                                            <a class=" btn-success text-white " href="orderview.php?saleorder_id=OR6408001" target="_blank">OR64080001</a>
                                        </span>
                                        <span class="ul-widget-s6__time"> 25 ส.ค. 2021 11:07 </span>
                                    </div>
                                    <div class="ul-widget-s6__item">
                                        <span class="ul-widget-s6__badge">
                                            <p class="badge-dot-primary ul-widget6__dot"></p>
                                        </span>
                                        <span class="ul-widget-s6__text">
                                            <strong class="mr-1">ออกใบเสนอราคา</strong>
                                            <a class=" btn-primary text-white " href="orderview.php?saleorder_id=OR6408001" target="_blank">QT64080001</a>
                                        </span>
                                        <span class="ul-widget-s6__time"> 25 ส.ค. 2021 11:30 </span>
                                    </div>
                                    <div class="ul-widget-s6__item">
                                        <span class="ul-widget-s6__badge">
                                            <p class="badge-dot-primary ul-widget6__dot"></p>
                                        </span>
                                        <span class="ul-widget-s6__text">
                                            <strong class="mr-1">ออกใบมัดจำสินค้า</strong>
                                            <a class=" btn-primary text-white " href="orderview.php?saleorder_id=OR6408001" target="_blank">AI64080001</a>
                                        </span>
                                        <span class="ul-widget-s6__time"> 26 ส.ค. 2021 09:30 </span>
                                    </div>
                                    <div class="ul-widget-s6__item">
                                        <span class="ul-widget-s6__badge">
                                            <p class="badge-dot-primary ul-widget6__dot"></p>
                                        </span>
                                        <span class="ul-widget-s6__text">
                                            <strong class="mr-1">ออกใบเสร็จรับเงิน</strong>
                                            <a class=" btn-primary text-white " href="orderview.php?saleorder_id=OR6408001" target="_blank">HS64080001</a>
                                        </span>
                                        <span class="ul-widget-s6__time"> 30 ส.ค. 2021 13:19 </span>
                                    </div>
                                    <div class="ul-widget-s6__item">
                                        <span class="ul-widget-s6__badge">
                                            <p class="badge-dot-primary ul-widget6__dot"></p>
                                        </span>
                                        <span class="ul-widget-s6__text">
                                            <strong class="mr-1">ออกใบส่งสินค้า</strong>
                                            <a class=" btn-primary text-white " href="orderview.php?saleorder_id=OR6408001" target="_blank">SO64080001</a>
                                        </span>
                                        <span class="ul-widget-s6__time">
                                            30 ก.ค. 2021 11:19 </span>
                                    </div>
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
                                    <div class="ul-widget-s6__item">
                                        <span class="ul-widget-s6__badge">
                                            <p class="badge-dot-primary ul-widget6__dot"></p>
                                        </span>
                                        <span class="ul-widget-s6__text">
                                            <strong class="mr-1">ออกใบกำกับสินค้า</strong>
                                            <a class=" btn-primary text-white " href="orderview.php?saleorder_id=OR6408001" target="_blank">IV64080001</a>
                                        </span>
                                        <span class="ul-widget-s6__time">
                                            30 ก.ค. 2021 11:19 </span>
                                    </div>
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
                                            <h4 class="text-muteds"><span>รายละเอียด Order: OR64080001</span></h4>
                                        </div>
                                        <div class="separator-breadcrumb border-top mb-3"></div>
                                        <div class="row">
                                            <div class="col-mb-12 col-12 mb-2 mt-3 pt-2">
                                                <h4 class="text-muted text-success"> ข้อมูลลูกค้า </h4>
                                            </div>
                                            <div class="col-md-12 col-12 mb-2">
                                                ชื่อลูกค้า :
                                                <strong class="font-weight-bold text-primary">คุณประสงค์ ฝักทอง</strong>
                                            </div>

                                            <div class="col-md-4 col-12 mb-2">
                                                ที่อยู่ :
                                                <strong>49 หมู่ที่ 10 ต.ระเว อ.พิบูลมังสาหาร จ.อุบลราชธานี</strong>
                                            </div>
                                            <div class="col-md-4 col-12 mb-2">
                                                โทร :
                                                <strong>087-776-4057</strong>
                                            </div>
                                            <div class="col-md-4 col-12 mb-2">
                                                อ้างอิง :
                                                <strong class="font-weight-bold text-primary">-</strong>
                                            </div>

                                            <div class="col-md-4 col-12 mb-2">
                                                เลขที่ประจำตัวผู้เสียภาษี :
                                                <strong>0345555000224</strong>
                                            </div>
                                            <div class="col-md-4 col-12 mb-2">
                                                ประเภทลูกค้า :
                                                <strong>เงินสด</strong>
                                            </div>
                                            <div class="col-md-4 col-12 mb-2">
                                                รู้จักบริษัทผ่านช่องทาง :
                                                <strong> Facebook</strong>
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
                                                <span class="ml-1 text-primary font-weight-bold">บริษัทส่งให้</strong>
                                            </div>
                                            <div class="col-md-4 col-12 mb-2">
                                                วันที่เปิด Order :
                                                <strong>30 ก.ค. 2021 11:19</strong>
                                            </div>
                                            <div class="col-md-4 col-12 mb-2">
                                                พนักงานขาย :
                                                <strong class="font-weight-bold text-primary">นางสาวหทัยทิพย์ แสงชาติ</strong>
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
                                                        <tr>
                                                            <th scope="row" class="text-center">1</th>
                                                            <td>
                                                                เสารั้วลวดหนาม ขนาด 3 นิ้ว ยาว 2.00 เมตร
                                                            </td>
                                                            <td class="text-right">100</td>
                                                            <td class="text-right">80.00</td>
                                                            <td class="text-right">8000.00</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row" class="text-center">2</th>
                                                            <td>
                                                                ค่าขนส่ง
                                                            </td>
                                                            <td class="text-right">1</td>
                                                            <td class="text-right">1000.00</td>
                                                            <td class="text-right">1000.00</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row" class="text-center">3</th>
                                                            <td>
                                                                ลวดหนาม 8.5 กิโลกรัม
                                                            </td>
                                                            <td class="text-right">18</td>
                                                            <td class="text-right">435.00</td>
                                                            <td class="text-right">7830.00</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="invoice-summary">
                                                    <p style="margin-bottom: 0;">รวมเป็นเงินทั้งสิ้น <span>16,830.00</span></p>
                                                    <p style="margin-bottom: 0;">หัก ส่วนลด <span>0.00</span></p>
                                                    <p style="margin-bottom: 0;">จำนวนเงินก่อนรวมภาษี <span>17,931.03</span></p>
                                                    <p>จำนวนภาษีมูลค่าเพิ่ม 7% <span>1,101.03</span></p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <p>ตัวอักษร :</p>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <p>หนึ่งหมื่นหกพันแปดร้อยสามสิบบาทถ้วน</p>
                                                    </div>
                                                    <div class="col-md-4 text-right">
                                                        <div class="row" style="justify-content: flex-end; margin-right: 0;">
                                                            <p>รวมเป็นเงิน</p>
                                                            <h5 class="font-weight-bold text-primary" style="width: 120px; display: inline-block;"> <span>16,830.00</span></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- รายการส่งสินค้า -->
                                <div class="card mt-3">
                                    <div class="col-mb-12 col-12 mb-2 pt-2">
                                        <h4 class="text-muted"><span class="text-success"> รายการส่งสินค้า</span></h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4 col-12 mb-2">
                                                รหัสส่งสินค้า :
                                                <span class="ml-1 text-primary font-weight-bold">SO6400001</strong>
                                            </div>
                                            <div class="col-md-4 col-12 mb-2">
                                                วันที่ส่งสินค้า :
                                                <strong>30 ก.ค. 2021 11:19</strong>
                                            </div>
                                            <div class="col-md-4 col-12 mb-2">
                                                พนักงานส่ง :
                                                <strong class="font-weight-bold text-primary">นางสาวหทัยทิพย์ แสงชาติ</strong>
                                            </div>
                                            <div class="col-md-4 col-12 mb-2">
                                                พนักงานตรวจสอบ :
                                                <strong class="font-weight-bold text-primary">นางสาวหทัยทิพย์ แสงชาติ</strong>
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
                                                <tr>
                                                    <td scope="row" class="text-center">1</td>
                                                    <td> แผ่นพื้นสำเร็จรูป ขนาด 0.05x0.35x2.30 เมตร หนา0.05 ขนาดลวด4 จำนวน5</td>
                                                    <td class="text-right">11</td>
                                                    <td class="text-right">-</td>

                                                    <td class="text-right">-</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row" class="text-center">2</td>
                                                    <td> แผ่นพื้นสำเร็จรูป ขนาด 0.05x0.35x2.40 เมตร หนา0.05 ขนาดลวด4 จำนวน5</td>
                                                    <td class="text-right">4</td>
                                                    <td class="text-right">-</td>

                                                    <td class="text-right">-</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row" class="text-center">3</td>
                                                    <td> แผ่นพื้นสำเร็จรูป ขนาด 0.05x0.35x2.60 เมตร หนา0.05 ขนาดลวด4 จำนวน5</td>
                                                    <td class="text-right">11</td>
                                                    <td class="text-right">-</td>

                                                    <td class="text-right">-</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row" class="text-center">4</td>
                                                    <td> แผ่นพื้นสำเร็จรูป ขนาด 0.05x0.35x3.20 เมตร หนา0.05 ขนาดลวด4 จำนวน5</td>
                                                    <td class="text-right">8</td>
                                                    <td class="text-right">-</td>

                                                    <td class="text-right">-</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row" class="text-center">5</td>
                                                    <td> แผ่นพื้นสำเร็จรูป ขนาด 0.05x0.35x3.70 เมตร หนา0.05 ขนาดลวด4 จำนวน5</td>
                                                    <td class="text-right">6</td>
                                                    <td class="text-right">-</td>

                                                    <td class="text-right">-</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row" class="text-center">6</td>
                                                    <td> ค่าจัดส่ง</td>
                                                    <td class="text-right">1</td>
                                                    <td class="text-right">-</td>

                                                    <td class="text-right">-</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div class="mb-2 mt-3 pt-2 border-warning border-top">
                                            <br>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4 col-12 mb-2">
                                                    รหัสส่งสินค้า :
                                                    <span class="ml-1 text-primary font-weight-bold">SO6400002</strong>
                                                </div>
                                                <div class="col-md-4 col-12 mb-2">
                                                    วันที่ส่งสินค้า :
                                                    <strong>30 ก.ค. 2021 11:19</strong>
                                                </div>
                                                <div class="col-md-4 col-12 mb-2">
                                                    พนักงานส่ง :
                                                    <strong class="font-weight-bold text-primary">นางสาวหทัยทิพย์ แสงชาติ</strong>
                                                </div>
                                                <div class="col-md-4 col-12 mb-2">
                                                    พนักงานตรวจสอบ :
                                                    <strong class="font-weight-bold text-primary">นางสาวหทัยทิพย์ แสงชาติ</strong>
                                                </div>
                                            </div>
                                        </div>





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
                                                <tr>
                                                    <td scope="row" class="text-center">1</td>
                                                    <td> แผ่นพื้นสำเร็จรูป ขนาด 0.05x0.35x2.30 เมตร หนา0.05 ขนาดลวด4 จำนวน5</td>
                                                    <td class="text-right">11</td>
                                                    <td class="text-right">-</td>

                                                    <td class="text-right">-</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row" class="text-center">2</td>
                                                    <td> แผ่นพื้นสำเร็จรูป ขนาด 0.05x0.35x2.40 เมตร หนา0.05 ขนาดลวด4 จำนวน5</td>
                                                    <td class="text-right">4</td>
                                                    <td class="text-right">-</td>

                                                    <td class="text-right">-</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row" class="text-center">3</td>
                                                    <td> แผ่นพื้นสำเร็จรูป ขนาด 0.05x0.35x2.60 เมตร หนา0.05 ขนาดลวด4 จำนวน5</td>
                                                    <td class="text-right">11</td>
                                                    <td class="text-right">-</td>

                                                    <td class="text-right">-</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row" class="text-center">4</td>
                                                    <td> แผ่นพื้นสำเร็จรูป ขนาด 0.05x0.35x3.20 เมตร หนา0.05 ขนาดลวด4 จำนวน5</td>
                                                    <td class="text-right">8</td>
                                                    <td class="text-right">-</td>

                                                    <td class="text-right">-</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row" class="text-center">5</td>
                                                    <td> แผ่นพื้นสำเร็จรูป ขนาด 0.05x0.35x3.70 เมตร หนา0.05 ขนาดลวด4 จำนวน5</td>
                                                    <td class="text-right">6</td>
                                                    <td class="text-right">-</td>

                                                    <td class="text-right">-</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row" class="text-center">6</td>
                                                    <td> ค่าจัดส่ง</td>
                                                    <td class="text-right">1</td>
                                                    <td class="text-right">-</td>

                                                    <td class="text-right">-</td>
                                                </tr>
                                            </tbody>
                                        </table>


                                    </div>
                                </div>
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