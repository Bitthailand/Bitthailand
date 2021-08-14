<?php

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
            <div class="main-content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="tab-content">
                            <div class="card">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
                                        <div class="d-sm-flex mb-5" data-view="print"><span class="m-auto"></span>
                                            <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">พิมพ์ใบเสนอราคา</button>
                                        </div>
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
                                                    <p><strong>ชื่อลูกค้า : </strong>ปอณรัตน์พา</p>
                                                    <p><strong>บริษัท : </strong>หจก. ปอณรัตน์พานิชย์</p>
                                                    <p><strong>ที่อยู่ : </strong>213 ม.6 ต.โพธิ์ใหญ่ อ.วารินชำราบ จ.อุบลราชธานี 34190 </p>
                                                    <p>เลขที่ประจำตัวผู้เสียภาษี 0343560001118 สำนักงานใหญ่</p>
                                                    <p><strong>โทร : </strong> 093-6954224</p>
                                                    <p><strong>อ้างอิง : </strong></p>
                                                </div>
                                                <div class="col-md-6 text-sm-right">
                                                    <h5 class="font-weight-bold"></h5>
                                                    <div class="invoice-summary">
                                                        <p>เลขที่ <span> AI6408006</span></p>
                                                        <p>วันที่ <span> 02/08/64</span></p>
                                                        <p>วันที่ครบกำหนด <span> 02/08/64</span></p>
                                                        <p>พนักงานขาย : <span> -</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-hover mb-4">
                                                        <thead class="bg-gray-300">
                                                            <tr>
                                                                <th scope="col" class="text-center">No.</th>
                                                                <th scope="col" class="text-center">รายการ</th>
                                                                <th scope="col" class="text-center">ราคารวมภาษี</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row" class="text-center">1</th>
                                                                <td>รับรายได้มัดจำแผ่นพื้น</td>
                                                                <td class="text-right">3,500.00</td>
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
                                                        <p>จำนวนเงินรวมทั้งสิ้น <span>49,135.75</span></p>
                                                        <p>จำนวนภาษีมูลค่าเพิ่ม 7.00% <span>228.97</span></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <p>ตัวอักษร :</p>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <p>หนึ่งหมื่นหกร้อยสิบเจ็ดบาทถ้วน</p>
                                                        </div>
                                                        <div class="col-md-4 text-right">
                                                            <div class="row" style="justify-content: flex-end; margin-right: 0;">
                                                                <p>ราคาสินค้า</p>
                                                                <h5 class="font-weight-bold" style="width: 120px; display: inline-block;"> <span>3,271.03</span></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3 mb-4 border-top"></div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <p>การชำระเงินด้วยเช็คจะสมบูรณ์เมื่อบริษัทได้รับเงินตามเช็คเรียบร้อย </p>
                                                    <p></p>                                                    
                                                </div>
                                                <div class="row">                                                    
                                                    <div class="col-md-3">
                                                        <p></p>
                                                        <br>
                                                        <p>เงินสด _______________</p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p></p>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p></p>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p></p>
                                                        <br>

                                                    </div>
                                                </div>
                                                <div class="row">                                                    
                                                    <div class="col-md-3">
                                                        <p></p>
                                                        <br>
                                                        <p>โอนเข้าบัญชี _______________<span></span></p>
                                                        <br>
                                                        <p>เช็คธนาคาร ________________ <span></span></p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p></p>
                                                        <br>
                                                        <p>เลขที่ _______________<span></span></p>
                                                        <br>
                                                        <p>เช็คเลขที่ ________________ <span></span></p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p></p>
                                                        <br>
                                                        <p>ลงวันที่ _____/______/______ <span></span></p>
                                                        <br>
                                                        <p>ลงวันที่ _____/______/______ <span></span></p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p></p>
                                                        <br>
                                                        <p>จำนวนเงิน __________________ <span></span></p>
                                                        <br>
                                                        <p>จำนวนเงิน __________________ <span></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3 mb-4 border-top"></div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-4 text-center">
                                                        <p> ____________________</p>
                                                        <br>
                                                        <p>ผู้อนุมัติ<span></span></p>
                                                        <br>
                                                        <p>วันที่ ________/__________/__________ <span></span></p>
                                                    </div>
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-5 text-center">
                                                        <p>ในนาม บริษัท วันเอ็ม จำกัด</p>
                                                        <br>
                                                        <p>ผู้รับมอบอำนวจ ____________________ <span></span></p>
                                                        <br>
                                                        <p>วันที่ ________/__________/__________ <span></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ==== / Print Area =====-->
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