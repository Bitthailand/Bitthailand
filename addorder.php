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
                        <!-- <div class="card"> -->
                        <div class="tab-content">
                            <form class="tab-pane fade active show" method="post">
                                <div class="border-bottom text-primary">
                                    <div class="card-title">เพิ่ม Order ใหม่</div>
                                </div>
                                <div class="form-row mt-3">
                                    <div class="form-group col-md-2">
                                        <label for="order_id"><strong>รหัส Order <span class="text-danger"></span></strong></label>
                                        <input type="text" name="order_id" id="order_id" class="classcus form-control" placeholder="รหัส Order" required>
                                    </div>
                                    <button class="btn btn-outline-primary ripple m-1" type="button" data-toggle="modal" data-target="#modalcustomerlist"
                                        style=" height: 33px; margin-top: 24px!important;">เลือกลูกค้า</button>
                                    <a class="btn btn-outline-primary m-1" href="/customer.php" type="button" style=" height: 33px; margin-top: 24px!important;">เพิ่มลูกค้าใหม่</a>
                                    <div class="form-group col-md-2">
                                        <label for="accNameId"><strong>ชื่อ-นามสกุล <span class="text-danger">*</span></strong></label>
                                        <input type="text" name="customer_name" id="customer_name" class="classcus form-control" placeholder="ชื่อ-นามสกุล" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="phone"><strong>เบอร์โทร <span class="text-danger">*</span></strong></label>
                                        <input type="text" name="phone" id="phone" class="classcus form-control" placeholder="เบอร์โทร" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="accAddressId"><strong>ที่อยู่ <span class="text-danger">*</span></strong></label>
                                        <input type="text" name="address" class="classcus form-control" id="address" placeholder="ที่อยู่" required="">
                                    </div>

                                    <div class="row mt-12">
                                        <div class="form-group col-md-2">
                                            <label for="product_type"><strong>ประเภท <span class="text-danger"></span></strong></label>
                                            <select class="classcus custom-select" name="product_type" id="product_type" required>
                                                <option value="PT001">เสารั้วลวดหนาม</option>
                                                <option value="PT002">เสาเข็มไอ</option>
                                                <option value="PT003">เสาเข็มสี่เหลี่ยม</option>
                                                <option value="PT004">กำแพงกันดิน</option>
                                                <option value="PT005">เสาไฟฟ้า</option>
                                                <option value="PT006">ลวดหนาม</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="product"><strong>สินค้าที่จะผลิต <span class="text-danger">*</span></strong></label>
                                            <select class="classcus custom-select" name="product" id="product" required>
                                                <option value="FP03100020">เสารั้ว 3x3" ยาว 1.00 ขนาดลวด 4 จำนวน 2 เส้น </option>
                                                <option value="FP03145020">เสารั้ว 3x3" ยาว 1.45 ขนาดลวด 4 จำนวน 2 เส้น</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="qty"><strong>จำนวนที่สั่ง <span class="text-danger"></span></strong></label>
                                            <input type="text" name="qty" id="qty" class="classcus form-control" placeholder="จำนวนสั่งผลิต" required>
                                        </div>
                                        <button class="btn btn-outline-primary ripple m-1" type="button" style=" height: 33px; margin-top: 24px!important;">เพิ่มรายการ</button>

                                        <!-- ============ Table Start ============= -->
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-hover text-nowrap table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>รหัสสินค้า</th>
                                                            <th>ประเภทสินค้า</th>
                                                            <th>ชื่อสินค้า</th>
                                                            <th>หน้ากว้าง</th>
                                                            <th>ความยาว</th>
                                                            <th>ขนาดลวด</th>
                                                            <th>จำนวนลวด</th>
                                                            <th>เซอร์คีย์(เส้น)</th>
                                                            <th>จำนวนที่สั่ง</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td> <strong>FP03100020</strong> </td>
                                                            <td> เสารั้วลวดหนาม</td>
                                                            <td> เสารั้ว 3x3" </td>
                                                            <td> <strong>3"</strong> </td>
                                                            <td> 1.00 </td>
                                                            <td> 4 </td>
                                                            <td> 5 </td>
                                                            <td> - </td>
                                                            <td> 120 </td>
                                                            <td>
                                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ไขจำนวนที่สั่ง" href="#">
                                                                    <i class="i-Pen-2 font-weight-bold"></i>
                                                                </a>
                                                                <a class="btn btn-outline-danger btn-sm line-height-1" data-toggle="tooltip" title="ยกเลิกรายการ" href="#">
                                                                    <i class="i-Close-Window font-weight-bold"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>FP03145020</strong> </td>
                                                            <td> เสารั้วลวดหนาม</td>
                                                            <td> เสารั้ว 3x3" </td>
                                                            <td> <strong>3"</strong> </td>
                                                            <td> 1.45 </td>
                                                            <td> 4 </td>
                                                            <td> 5 </td>
                                                            <td> - </td>
                                                            <td> 90 </td>
                                                            <td>
                                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ไขจำนวนที่สั่ง" href="#">
                                                                    <i class="i-Pen-2 font-weight-bold"></i>
                                                                </a>
                                                                <a class="btn btn-outline-danger btn-sm line-height-1" data-toggle="tooltip" title="ยกเลิกรายการ" href="#">
                                                                    <i class="i-Close-Window font-weight-bold"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="14"> &nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- ============ Table End ============= -->
                                    </div>

                                    <div class="viewDateClass col pr-0 ">
                                        <div class="form-group">
                                            <label for="delivery_date">กำหนดส่งสินค้า</label>
                                            <input id="delivery_date" class="form-control" type="date" min="2021-06-01" name="start" value="2021-08-04" required="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label for="delivery_Address"><strong>ที่อยู่ จัดส่ง<span class="text-danger">*</span></strong></label>
                                        <input type="text" name="delivery_Address" class="classcus form-control" id="delivery_Address" placeholder="ที่อยู่" required="">
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="date_confirm"><strong>ยืนยันใน(วัน) <span class="text-danger"></span></strong></label>
                                        <input type="text" name="date_confirm" id="date_confirm" class="classcus form-control" placeholder="ยืนยันราคาใน" Value="0" required>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="tax"><strong>ภาษี(%) <span class="text-danger"></span></strong></label>
                                        <input type="text" name="tax" id="tax" class="classcus form-control" placeholder="ภาษี" Value="7" required>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="discount"><strong>ส่วนลด(บาท) <span class="text-danger"></span></strong></label>
                                        <input type="text" name="discount" id="discount" class="classcus form-control" placeholder="ส่วนลด" required>
                                    </div>
                                </div>

                                <hr>

                                <div class="text-right">
                                    <input class="d-none" id="addAccId" type="text" name="acc_id" value="" placeholder="">
                                    <input class="d-none" id="addActionId" type="text" name="action" value="add" placeholder="">

                                    <button id="btnAddId" class="btn btn-outline-primary d-none" type="submit">ยืนยัน Order</button>
                                    <button class="btn btn-primary ladda-button btn-add" data-style="expand-left">
                                        <span class="ladda-label">ยืนยันการสั่งผลิต</span>
                                    </button>
                                    <a class="btn btn-outline-danger m-1" href="/quotationlist.php" type="button">กลับหน้ารายการ Order</a>
                                </div>

                            </form>
                        </div>
                        <!-- </div> -->
                    </div>
                </div>
            </div><!-- Footer Start -->
            <div class="flex-grow-1"></div>
            <div class="app-footer">
                <div class="footer-bottom border-top pt-3 d-flex flex-column flex-sm-row align-items-center">
                    <a class="btn btn-primary text-white btn-rounded" href="https://themeforest.net/item/gull-bootstrap-laravel-admin-dashboard-template/23101970"
                        target="_blank">Buy Gull HTML</a>
                    <span class="flex-grow-1"></span>
                    <div class="d-flex align-items-center">
                        <img class="logo" src="../../dist-assets/images/logo.png" alt="">
                        <div>
                            <p class="m-0">&copy; 2021 1M Co,.Ltd.</p>
                            <p class="m-0">All rights reserved</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- fotter end -->
        </div>
    </div>

    <!-- Modal เลือกรายการลูกค้า -->
    <div class="modal fade" id="modalcustomerlist" tabindex="-1" role="dialog" aria-labelledby="medalmodalcustomerlistTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalmodalcustomerlistTitle-2">บันทีกการใช้ คอนกรีต</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <!-- ============ Table Start ============= -->
                    <div id="productionorder" class="table-responsive">
                        <table role="table" class="table table-hover text-nowrap table-sm">
                            <thead>
                                <tr class="table-secondary">

                                    <th>รหัสลูกค้า</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>ที่อยู่</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>CUS640800001</td>
                                    <td>คุณเวนิช พุ่มจันทร์</td>
                                    <td>ตำบลหนองเป็ด อำเภอเมือง จ.ยโสธร 35000</td>
                                </tr>
                                <tr>

                                    <td>CUS640800002</td>
                                    <td>กฤษณะ ยศวิปาน</td>
                                    <td>บ้านหนองค้า ต.หนองค้า อ.พยุห์ ศรีสะเกษ</td>
                                </tr>
                                <tr>
                                    <td>CUS640800003</td>
                                    <td>ภัทราวดี คำบ่อ</td>
                                    <td>บ้านหนองช้าง ต.หนองขอน จ.อุบล</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- ============ Table End ============= -->

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
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