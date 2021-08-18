<?php

?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Sale Order | ใบส่งของ</title>
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
                                                    <p><strong>ชื่อลูกค้า : </strong>คุณ มนต์ชัย สุขเกษม</p>
                                                    <p><strong>ที่อยู่จัดส่ง : </strong>213 ม.6 ต.โพธิ์ใหญ่ อ.วารินชำราบ จ.อุบลราชธานี 34190 </p>
                                                    <p><strong>โทร : </strong> 093-6954224</p>
                                                    <p><strong>อ้างอิง : </strong></p>
                                                </div>
                                                <div class="col-md-6 text-sm-right">
                                                    <h5 class="font-weight-bold"></h5>
                                                    <div class="invoice-summary">
                                                        <div class="form-group col-md-12">
                                                            <p>ลำดับการสั่งซื้อ <span>OR6400024</span></p>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="ai_id"><strong>เลขที่ใบส่งของ <span class="text-danger"></span></strong></label>
                                                            <input type="text" name="ai_id" class="classcus form-control" id="ai_id" placeholder="เลขที่ใบส่งของ">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <div class="form-group">
                                                                <label for="delivery_date">วันที่</label>
                                                                <input id="delivery_date" class="form-control" type="date" min="2021-06-01" name="start" value="2021-08-04">
                                                            </div>
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
                                                                <th scope="col" class="text-center" width="10%">สต๊อกโรงงาน 1</th>
                                                                <th scope="col" class="text-center" width="10%">สต๊อกโรงงาน 2</th>
                                                                <th scope="col" class="text-center" width="10%">จำนวนที่ต้องส่ง</th>
                                                                <th scope="col" class="text-center" width="10%">โรงงาน 1</th>
                                                                <th scope="col" class="text-center" width="10%">โรงงาน 2</th>
                                                                <th scope="col" class="text-center" width="10%">จำนวนส่ง</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row" class="text-center">1</th>
                                                                <td>FP03100020 เสารั้ว 3x3" 1.00 1.00 1.00</td>
                                                                <td class="text-center">40</td>
                                                                <td class="text-center">20</td>
                                                                <td class="text-center">60</td>
                                                                <td class="text-center"><input class="form-control" value="" type="number" placeholder="จำนวนที่ส่ง"></td>
                                                                <td class="text-center"><input class="form-control" value="" type="number" placeholder="จำนวนที่ส่ง"></td>
                                                                <td class="text-center">60</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" class="text-center">2</th>
                                                                <td>FP03100025 เสารั้ว 3x3" 1.00 1.00 1.00</td>
                                                                <td class="text-center">200</td>
                                                                <td class="text-center">50</td>
                                                                <td class="text-center">60</td>
                                                                <td class="text-center"><input class="form-control" value="" type="number" placeholder="จำนวนที่ส่ง"></td>
                                                                <td class="text-center"><input class="form-control" value="" type="number" placeholder="จำนวนที่ส่ง"></td>
                                                                <td class="text-center">60</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="mt-3 mb-4 border-top"></div>
                                            <div class="d-sm-flex mb-5" data-view="print">
                                                <span class="m-auto"></span>
                                                <a class="btn btn-outline-primary m-1" href="/saleorder.php" type="button" target="_blank">พิมพ์ใบส่งของ(SO)</a>
                                                <a class="btn btn-outline-primary m-1" href="/hs.php" type="button" target="_blank">พิมพ์ใบเสร็จรับเงิน(HS)</a>
                                                <a class="btn btn-outline-primary m-1" href="/invoice.php" type="button" target="_blank">พิมพ์ใบกำกับสินค้า(IV)</a>
                                                <a class="btn btn-outline-primary m-1" href="#" type="button">บันทึกการส่งของ</a>
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