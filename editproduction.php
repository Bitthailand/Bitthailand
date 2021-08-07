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
                                    <div class="card-title">เพิ่มรายการสั่งผลิตสินค้า</div>
                                </div>
                                <div class="form-row mt-3">
                                    <div class="form-group col-md-2">
                                        <label for="production_id"><strong>รหัสสั่งผลิต <span class="text-danger"></span></strong></label>
                                        <input type="text" name="production_id" id="production_id" class="classcus form-control" placeholder="รหัสสั่งผลิต" value="PD640800001"
                                            required>
                                    </div>
                                    <div class="viewDateClass col pr-0 ">
                                        <div class="form-group">
                                            <label for="searchSDateId">วันที่สั่งผลิต</label>
                                            <input id="searchSDateId" class="form-control" type="date" min="2021-06-01" name="start" value="2021-08-04" required="">
                                        </div>
                                    </div>
                                    <div class="viewDateClass col pr-0 ">
                                        <div class="form-group">
                                            <label for="searchEDateId">เช็คเขาสต๊อกภายในวันที่</label>
                                            <input id="searchEDateId" class="form-control" type="date" name="end" value="2021-08-04" required="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="plant"><strong>แพที่ผลิต <span class="text-danger"></span></strong></label>
                                        <select class="classcus custom-select" name="plant" id="plant" required>
                                            <option value="0">เลือก</option>
                                            <option value="1">1 โรงงาน 1</option>
                                            <option value="2">2 โรงงาน 1</option>
                                            <option value="3">3 โรงงาน 1</option>
                                            <option value="4">4 โรงงาน 1</option>
                                            <option value="5">5 โรงงาน 1</option>
                                            <option value="6">6 โรงงาน 1</option>
                                        </select>
                                    </div>
                                    <div class="row mt-12">
                                        <div class="form-group col-md-4">
                                            <label for="product"><strong>สินค้าที่จะผลิต <span class="text-danger">*</span></strong></label>
                                            <select class="classcus custom-select" name="product" id="product" required>
                                                <option value="FP03100020">เสารั้ว 3x3" ยาว 1.00 ขนาดลวด 4 จำนวน 2 เส้น </option>
                                                <option value="FP03145020">เสารั้ว 3x3" ยาว 1.45 ขนาดลวด 4 จำนวน 2 เส้น</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="qty"><strong>จำนวนสั่งผลิต <span class="text-danger"></span></strong></label>
                                            <input type="text" name="qty" id="qty" class="classcus form-control" placeholder="จำนวนสั่งผลิต" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="concrete_cal"><strong>คำนวณคอนกรีต <span class="text-danger"></span></strong></label>
                                            <input type="text" name="concrete_cal" id="concrete_cal" class="classcus form-control" placeholder="คำนวณคอนกรีต" required>
                                        </div>

                                        <button class="btn btn-outline-primary ripple m-1" type="button"
                                            style=" height: 33px; margin-top: 24px!important;">แก้ไขข้อมูลสั่งผลิต</button>

                                        <!-- ============ Table Start ============= -->
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-hover text-nowrap table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>รหัสสินค้า</th>
                                                            <th>ชื่อสินค้า</th>
                                                            <th>หน้ากว้าง</th>
                                                            <th>ความยาว</th>
                                                            <th>ขนาดลวด</th>
                                                            <th>จำนวนลวด</th>
                                                            <th>เซอร์คีย์(เส้น)</th>
                                                            <th>คอนกรีตคำนวณ</th>
                                                            <th>คอนกรีตใช้จริง</th>
                                                            <th>จำนวนสั่งผลิต</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td> <strong>FP03100020</strong> </td>
                                                            <td> เสารั้ว 3x3" </td>
                                                            <td> <strong>3"</strong> </td>
                                                            <td> 1.00 </td>
                                                            <td> 4 </td>
                                                            <td> 5 </td>
                                                            <td> - </td>
                                                            <td> 2.21 </td>
                                                            <td> - </td>
                                                            <td> 120 </td>
                                                            <td>
                                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ไขข้อมูลสั่งผลิต" href="#">
                                                                    <i class="i-Pen-2 font-weight-bold"></i>
                                                                </a>
                                                                <a class="btn btn-outline-info btn-sm line-height-1" data-toggle="tooltip" title="บันทึกการใช้คอนกรีต" href="#">
                                                                    <i class="i-Gear font-weight-bold"></i>
                                                                </a>
                                                                <a class="btn btn-outline-danger btn-sm line-height-1" data-toggle="tooltip" title="ยกเลิกรายการผลิต" href="#">
                                                                    <i class="i-Close-Window font-weight-bold"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>FP03145020</strong> </td>
                                                            <td> เสารั้ว 3x3" </td>
                                                            <td> <strong>3"</strong> </td>
                                                            <td> 1.45 </td>
                                                            <td> 4 </td>
                                                            <td> 5 </td>
                                                            <td> - </td>
                                                            <td> 2.59 </td>
                                                            <td> - </td>
                                                            <td> 90 </td>
                                                            <td>
                                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ไขข้อมูลสั่งผลิต" href="#">
                                                                    <i class="i-Pen-2 font-weight-bold"></i>
                                                                </a>
                                                                <a class="btn btn-outline-info btn-sm line-height-1" data-toggle="tooltip" title="บันทึกการใช้คอนกรีต" href="#">
                                                                    <i class="i-Gear font-weight-bold"></i>
                                                                </a>
                                                                <a class="btn btn-outline-danger btn-sm line-height-1" data-toggle="tooltip" title="ยกเลิกรายการผลิต" href="#">
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
                                    <div class="form-group col-md-2">
                                        <label for="sqm"><strong>พ.ท.(Sq.m) <span class="text-danger"></span></strong></label>
                                        <input type="text" name="sqm" id="sqm" class="classcus form-control" placeholder="พ.ท.(Sq.m)" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="accNameId"><strong>ความยาวลวด(ทั้งแพ) <span class="text-danger"></span></strong></label>
                                        <input type="text" name="customer_name" id="customer_name" class="classcus form-control" placeholder="ความยาวลวด(ทั้งแพ)" required>
                                    </div>
                                </div>

                                <hr>

                                <div class="text-right">
                                    <input class="d-none" id="addAccId" type="text" name="acc_id" value="" placeholder="">
                                    <input class="d-none" id="addActionId" type="text" name="action" value="add" placeholder="">

                                    <button id="btnAddId" class="btn btn-outline-primary d-none" type="submit">ยืนยันการแก้ไข</button>
                                    <button class="btn btn-primary ladda-button btn-add" data-style="expand-left">
                                        <span class="ladda-label">ยืนยันการแก้ไข</span>
                                    </button>
                                    <a class="btn btn-outline-danger m-1" href="/productionlist.php" type="button">กลับหน้ารายการสั่งผลิต</a>
                                </div>

                            </form>
                        </div>
                        <!-- </div> -->
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