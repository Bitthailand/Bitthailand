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
                                        <div class="d-sm-flex mb-5" data-view="print"><span class="m-auto"></span>
                                            <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">พิมพ์ใบส่งของ</button>
                                        </div>
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
                                                        <p>เลขที่ใบส่งของ <span>SO6401561</span></p>
                                                        <p>ลำดับการสั่งซื้อ <span>OR6400024</span></p>
                                                        <p>วันที่ <span>05-ส.ค.-64</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-hover mb-4">
                                                        <thead class="bg-gray-300">
                                                            <tr>
                                                                <th scope="col" class="text-center">No.</th>
                                                                <th scope="col"class="text-center">รหัสสินค้า/รายละเอียด</th>
                                                                <th scope="col"class="text-center">จำนวน</th>
                                                                <th scope="col"class="text-center">หน่วยละ</th>
                                                                <th scope="col"class="text-center">ราคารวมภาษี</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row" class="text-center">1</th>
                                                                <td>FP03100020 เสารั้ว 3x3" 1.00 1.00 1.00</td>
                                                                <td class="text-right">120</td>
                                                                <td class="text-right">-</td>
                                                                <td class="text-right">-</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" class="text-center">2</th>
                                                                <td>FP03100025 เสารั้ว 3x3" 1.00 1.00 1.00</td>
                                                                <td class="text-right">60</td>
                                                                <td class="text-right">-</td>
                                                                <td class="text-right">-</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="invoice-summary">
                                                        <p>รวมเป็นเงินทั้งสิ้น <span>-</span></p>
                                                        <p>หัก ส่วนลด <span>-</span></p>
                                                        <p>จำนวนเงินก่อนรวมภาษี <span>-</span></p>
                                                        <p>จำนวนภาษีมูลค่าเพิ่ม 7.00% <span>-</span></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <p>ตัวอักษร :</p>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <p>ศูนย์บาทถ้วน</p>
                                                        </div>
                                                        <div class="col-md-4 text-right">
                                                            <div class="row" style="justify-content: flex-end; margin-right: 0;">
                                                                <p>รวมเป็นเงิน</p>
                                                                <h5 class="font-weight-bold" style="width: 120px; display: inline-block;"> <span>-</span></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3 mb-4 border-top"></div>
                                            <div class="col-md-12">
                                                <div class="col-md-12 mb-3 mb-sm-0">
                                                    <h5 class="font-weight-bold">เงื่อนไขการขาย</h5>
                                                    <p>- ได้รับสินค้าตามรายการข้างบนนี้ในสภาพสมบูรณ์ถูกต้องครบถ้วนแล้ว </p>
                                                    <p>- สินค้ายังเป็นกรรมสิทธิ์ของทางร้านจนกว่าผู้ซื้อจะชำระสินค้าเรียบร้อยแล้ว </p>
                                                    <p>- ทางร้านขอสงวนสิทธิ์ไม่รับคืนสินค้าในกรณีที่ไม่ได้เกิดจากความผิดพลาดของทางร้าน </p>
                                                </div>
                                                <div class="mt-3 mb-4 border-top"></div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-3 text-center">
                                                        <p> ____________________</p>
                                                        <br>
                                                        <p>ผู้รับสินค้า<span></span></p>
                                                        <br>
                                                        <p>วันที่ _______/_________/_________ <span></span></p>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <p> ____________________</p>
                                                        <br>
                                                        <p>พนักงานส่งของ<span></span></p>
                                                        <br>
                                                        <p>วันที่ _______/_________/_________ <span></span></p>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <p> ____________________</p>
                                                        <br>
                                                        <p>ผู้ตรวจสอบ<span></span></p>
                                                        <br>
                                                        <p>วันที่ _______/_________/__________ <span></span></p>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                        <p>ในนาม บริษัท วันเอ็ม จำกัด</p>
                                                        <br>
                                                        <p>ผู้รับมอบอำนวจ ____________________ <span></span></p>
                                                        <br>
                                                        <p>วันที่ _______/_________/_________ <span></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ==== / Print Area =====-->
                                    </div>
                                    <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="edit-tab">
                                        <!-- ==== Edit Area =====-->
                                        <div class="d-flex mb-5"><span class="m-auto"></span>
                                            <button class="btn btn-primary">Save</button>
                                        </div>
                                        <form>
                                            <div class="row justify-content-between">
                                                <div class="col-md-6">
                                                    <h4 class="font-weight-bold">Order Info</h4>
                                                    <div class="col-sm-4 form-group mb-3 pl-0">
                                                        <label for="orderNo">Order Number</label>
                                                        <input class="form-control" id="orderNo" type="text" placeholder="Enter order number" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 text-right">
                                                    <label class="d-block text-12 text-muted">Order Status</label>
                                                    <div class="pr-0 mb-4">
                                                        <label class="radio radio-reverse radio-danger">
                                                            <input type="radio" name="orderStatus" value="Pending" /><span>Pending</span><span class="checkmark"></span>
                                                        </label>
                                                        <label class="radio radio-reverse radio-warning">
                                                            <input type="radio" name="orderStatus" value="Processing" /><span>Processing</span><span class="checkmark"></span>
                                                        </label>
                                                        <label class="radio radio-reverse radio-success">
                                                            <input type="radio" name="orderStatus" value="Delivered" /><span>Delivered</span><span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="order-datepicker">Order Date</label>
                                                        <input class="form-control text-right" id="order-datepicker" placeholder="yyyy-mm-dd" name="dp" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3 mb-4 border-top"></div>
                                            <div class="row mb-5">
                                                <div class="col-md-6">
                                                    <h5 class="font-weight-bold">Bill From</h5>
                                                    <div class="col-md-10 form-group mb-3 pl-0">
                                                        <input class="form-control" id="billFrom3" type="text" placeholder="Bill From" />
                                                    </div>
                                                    <div class="col-md-10 form-group mb-3 pl-0">
                                                        <textarea class="form-control" placeholder="Bill From Address"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <h5 class="font-weight-bold">Bill To</h5>
                                                    <div class="col-md-10 offset-md-2 form-group mb-3 pr-0">
                                                        <input class="form-control text-right" id="billFrom2" type="text" placeholder="Bill From" />
                                                    </div>
                                                    <div class="col-md-10 offset-md-2 form-group mb-3 pr-0">
                                                        <textarea class="form-control text-right" placeholder="Bill From Address"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-hover mb-3">
                                                        <thead class="bg-gray-300">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Item Name</th>
                                                                <th scope="col">Unit Price</th>
                                                                <th scope="col">Unit</th>
                                                                <th scope="col">Cost</th>
                                                                <th scope="col"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">1</th>
                                                                <td>
                                                                    <input class="form-control" value="Product 1" type="text" placeholder="Item Name" />
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" value="300" type="number" placeholder="Unit Price" />
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" value="2" type="number" placeholder="Unit" />
                                                                </td>
                                                                <td>600</td>
                                                                <td>
                                                                    <button class="btn btn-outline-secondary float-right">Delete</button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">2</th>
                                                                <td>
                                                                    <input class="form-control" value="Product 1" type="text" placeholder="Item Name" />
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" value="300" type="number" placeholder="Unit Price" />
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" value="2" type="number" placeholder="Unit" />
                                                                </td>
                                                                <td>600</td>
                                                                <td>
                                                                    <button class="btn btn-outline-secondary float-right">Delete</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <button class="btn btn-primary float-right mb-4">Add Item</button>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="invoice-summary invoice-summary-input float-right">
                                                        <p>Sub total: <span>$1200</span></p>
                                                        <p class="d-flex align-items-center">Vat(%):<span>
                                                                <input class="form-control small-input" type="text" value="10" />$120</span></p>
                                                        <h5 class="font-weight-bold d-flex align-items-center">Grand Total:<span>
                                                                <input class="form-control small-input" type="text" value="$" />$1320</span></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- ==== / Edit Area =====-->
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