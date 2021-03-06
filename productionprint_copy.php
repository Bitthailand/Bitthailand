<?php

?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>IV | ใบกำกับสินค้า</title>
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
                                            <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">พิมพ์ใบกำกับสินค้า</button>
                                        </div>
                                        <!-- -===== Print Area =======-->
                                        <div id="print-area">
                                            <div class="row">
                                                <div class="col-md-12 text-sm-center">
                                                    <h4 class="font-weight-bold">บริษัท วันเอ็ม จำกัด/ 1M CO.,LTD.</h4>
                                                    <p>290 ม.1 ต.กระโสบ อ.เมือง จ.อุบลราชธานี 34000 โทร 061-4362825</p>

                                                    <p>290 MU 1 Krasop, Mueang Ubon Ratchathani, Ubon Ratchathani 34000, Tel. 045-953-448</p>
                                                    <div class="mt-3 mb-4 border-top"></div>
                                                </div>

                                                <div class="col-md-12 text-sm-center">
                                                    <h4 class="font-weight-bold">ใบสั่งผลิตสินค้า</h4>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-hover mb-4">
                                                        <thead>

                                                            <col>
                                                            <colgroup span="2"></colgroup>
                                                            <colgroup span="2"></colgroup>
                                                            </col>
                                                            <tr class="bg-gray-300">
                                                                <th rowspan="2" scope="rowgroup" class="text-center" width="3%">ลำดับ</th>
                                                                <th rowspan="2" scope="rowgroup" class="text-center" width="10%">ว.ด.ป.</th>
                                                                <th rowspan="2" scope="rowgroup" class="text-center" width="3%">โรงงาน</th>
                                                                <th rowspan="2" scope="rowgroup" class="text-center" width="3%">แพ</th>
                                                                <th rowspan="2" scope="rowgroup" class="text-center" width="38%">รายการ</th>
                                                                <th colspan="1" scope="colgroup" class="text-center" width="5%">จำนวน</th>
                                                                <th colspan="1" scope="colgroup" class="text-center" width="5%">พ.ท.</th>
                                                                <th colspan="1" scope="colgroup" class="text-center" width="12%">ขนาดลวด</th>
                                                                <th colspan="1" scope="colgroup" class="text-center" width="13%">จำนวนลวด</th>
                                                                <th colspan="1" scope="colgroup" class="text-center" width="10%">คอนกรีต</th>
                                                            </tr>
                                                            <tr class="bg-gray-300">
                                                                <th scope="col" class="text-center">(P)</th>
                                                                <th scope="col" class="text-center">(Sq.m.)</th>
                                                                <th scope="col" class="text-center">Dai.(mm.)</th>
                                                                <th scope="col" class="text-center">(เส้น)</th>
                                                                <th scope="col" class="text-center">(ลบ.ม.)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td scope="row" class="text-center">1</td>
                                                                <td class="text-center">2 ส.ค. 21</td>
                                                                <td class="text-center">2</td>
                                                                <td class="text-center">35</td>
                                                                <td class="text-left">แผ่นพื้นสำเร็จรูป ขนาด 0.05x0.35x4.00 เมตร</td>
                                                                <td class="text-right">66</td>
                                                                <td class="text-right">69.30</td>
                                                                <td class="text-center">4</td>
                                                                <td class="text-center">5</td>
                                                                <td class="text-right">3.47</td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row" class="text-center"></td>
                                                                <td></td>
                                                                <td class="text-right"></td>
                                                                <td class="text-right">35</td>
                                                                <td class="text-left">แผ่นพื้นสำเร็จรูป ขนาด 0.05x0.35x2.50 เมตร</td>
                                                                <td class="text-right">78</td>
                                                                <td class="text-right">54.60</td>
                                                                <td class="text-center">4</td>
                                                                <td class="text-center">5</td>
                                                                <td class="text-right">2.73</td>
                                                            </tr>
                                                            <tr class="bg-gray-200">
                                                                <td scope="row" class="text-center"></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td class="text-right"></td>
                                                                <td class="text-right"><strong>รวม</strong></td>
                                                                <td class="text-right"><strong>144</strong></td>
                                                                <td class="text-right"><strong>123.90</strong></td>
                                                                <td class="text-center"></td>
                                                                <td class="text-center"></td>
                                                                <td class="text-right"><strong>6.20 </strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="invoice-summary">
                                                        <p> ผู้สั่งผลิต <span>_____________________</span></p>
                                                        <br>
                                                        <p> ผู้ควบคุมการผลิต <span>_____________________</span></p>
                                                        <br>
                                                        <p> ผู้รับเหมา <span>_____________________</span></p>
                                                        <br>
                                                        <p> ผู้ควบคุมคุณภาพ <span>_____________________</span></p>
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