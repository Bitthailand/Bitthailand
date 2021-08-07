<?php

?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Production | รายการสั่งผลิตสินค้า</title>
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
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link active" href="/productionlist.php">
                                    <h3 class="h5 font-weight-bold"> รายการสั่งผลิต
                                        <span class="badge badge-pill badge-danger">1</span>
                                    </h3>
                                    <span>รายการสินค้าที่อยู่ระหว่างการผลิต
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link" href="/productionfinishlist.php">
                                    <h3 class="h5 font-weight-bold"> รายการสำเร็จ</h3>
                                    <span>รายการสินค้าที่ผลิตเรียบร้อย
                                        <span class="badge badge-success"> Success </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="mb-1">
                                <div class="ul-widget__item">
                                    <div class="ul-widget__info">
                                        <h3 class="ul-widget1__title "> ผลิตสินค้า </h3>
                                        <span class="ul-widget__desc "> รายการสั่งผลิตสินค้า </span>
                                    </div>
                                    <div class="text-left">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="searchColumnId"> ประเภท </label>
                                                    <select id="searchColumnId" class="custom-select" name="column">
                                                        <option value="po_id">รหัสสั่งผลิต</option>
                                                        <option value="po_date">วันที่สั่งผลิต</option>
                                                        <option value="plane_id">แพที่ผลิต</option>
                                                        <option value="product_id">รหัสสินค้า</option>
                                                        <option value="product_name">ชื่อสินค้า</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="searchNameId"> คำที่ต้องการค้น</label>
                                                    <input id="searchNameId" class="form-control" placeholder="Keyword" type="text" value="">
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="searchRowsId"> Row </label>
                                                    <select id="searchRowsId" class="custom-select">
                                                        <option value="10"> 10 </option>
                                                        <option value="20" selected=""> 20 </option>
                                                        <option value="30"> 30 </option>
                                                        <option value="40"> 40 </option>
                                                        <option value="50"> 50 </option>
                                                        <option value="100"> 100 </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="/addproduction.php" class="btn btn-outline-primary mt-4" role="button" aria-pressed="true"> เพิ่มรายการสั่งผลิต</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ============ Table Start ============= -->
                            <div id="productionorder" class="table-responsive">
                                <table role="table" class="table table-hover text-nowrap table-sm">
                                    <thead>
                                        <tr class="table-secondary">
                                            <th>รหัสสั่งผลิต</th>
                                            <th>แพที่</th>
                                            <th>วันที่สั่ง</th>
                                            <th>กำหนดเสร็จ</th>
                                            <th>รหัสสินค้า</th>
                                            <th>จำนวนผลิต</th>
                                            <th>ชื่อสินค้า</th>
                                            <th>หนา</th>
                                            <th>กว้าง</th>
                                            <th>ยาว</th>
                                            <th>ขนาดลวด</th>
                                            <th>จำนวนลวด</th>
                                            <th>พ.ท.(Sq.m)</th>
                                            <th>คอนกรีตคำนวณ</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <strong> PD640800001 </strong>
                                            </td>
                                            <td><strong>5</strong></td>
                                            <td> <strong>29 ก.ค. 2021 17:53</strong></td>
                                            <td> <strong>5 ส.ค. 2021</strong></td>
                                            <td>FP03100020</td>
                                            <td>120</td>
                                            <td>เสารั้ว 3x3"</td>
                                            <td>1.00</td>
                                            <td>1.00</td>
                                            <td>1.00</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>-</td>
                                            <td>2.21</td>
                                            <td>
                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ไขข้อมูลสั่งผลิต"
                                                    href="editproduction.php?po_id=PD640800001">
                                                    <i class="i-Pen-2 font-weight-bold"></i>
                                                </a>
                                                <a class="btn btn-outline-info btn-sm line-height-1" data-toggle="modal" title="บันทีกการเทคอนกรีต"
                                                    data-target="#medalconcreteuse">
                                                    <i class="i-Gear font-weight-bold"></i>
                                                </a>
                                                <a class="btn btn-outline-info btn-sm line-height-1" data-toggle="modal" title="เช็คสินค้าเข้าสต๊อก" data-target="#medalstockcheck">
                                                    <i class="i-Check font-weight-bold"></i>
                                                </a>
                                                <a class="btn btn-outline-danger btn-sm line-height-1" data-toggle="tooltip" title="ยกเลิกรายการผลิต" href="#">
                                                    <i class="i-Close-Window font-weight-bold"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="table table-hover text-nowrap table-sm">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>120</strong></td>
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
                                        <tr>
                                            <td>
                                                <strong> PD640800002 </strong>
                                            </td>
                                            <td><strong>5</strong></td>
                                            <td> <strong>23 ก.ค. 2021 11:23</strong></td>
                                            <td> <strong>5 ส.ค. 2021</strong></td>
                                            <td>FP03100020</td>
                                            <td>100</td>
                                            <td>เสารั้ว 3x3"</td>
                                            <td>1.00</td>
                                            <td>1.00</td>
                                            <td>1.00</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>-</td>
                                            <td>2.36</td>
                                            <td>
                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ไขข้อมูลสั่งผลิต"
                                                    href="editproduction.php?po_id=PD640800002">
                                                    <i class="i-Pen-2 font-weight-bold"></i>
                                                </a>
                                                <a class="btn btn-outline-info btn-sm line-height-1" data-toggle="modal" title="บันทีกการเทคอนกรีต"
                                                    data-target="#medalconcreteuse">
                                                    <i class="i-Gear font-weight-bold"></i>
                                                </a>
                                                <a class="btn btn-outline-info btn-sm line-height-1" data-toggle="modal" title="เช็คสินค้าเข้าสต๊อก" data-target="#medalstockcheck">
                                                    <i class="i-Check font-weight-bold"></i>
                                                </a>
                                                <a class="btn btn-outline-danger btn-sm line-height-1" data-toggle="tooltip" title="ยกเลิกรายการผลิต" href="#">
                                                    <i class="i-Close-Window font-weight-bold"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td>FP03145020</td>
                                            <td>60</td>
                                            <td>เสารั้ว 3x3"</td>
                                            <td>1.00</td>
                                            <td>1.00</td>
                                            <td>1.45</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>44.10</td>
                                            <td>2.90</td>
                                            <td> </td>
                                        </tr>
                                        <tr>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td>FP03200020</td>
                                            <td>40</td>
                                            <td>เสารั้ว 3x3"</td>
                                            <td>1.00</td>
                                            <td>1.00</td>
                                            <td>2.00</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>44.10</td>
                                            <td>2.68</td>
                                            <td> </td>
                                        </tr>

                                        <tr class="table table-hover text-nowrap table-sm">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>200</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- ============ Table End ============= -->

                            <div class="mb-5 mt-3">
                                <nav aria-label="Page navigation ">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item"><a class="page-link" href="#" onclick="clickNav(1)" aria-label="Previous"><span aria-hidden="true">«</span><span
                                                    class="sr-only">Previous</span></a></li>
                                        <!-- <| 123 |> -->
                                        <li class="page-item active"><a class="page-link" href="#" onclick="clickNav(1)">1</a></li>
                                        <!-- <| 123 ...|>  -->

                                        <li class="page-item"><a class="page-link" href="#" onclick="clickNav(1)" aria-label="Next"><span aria-hidden="true">»</span><span
                                                    class="sr-only">Next</span></a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
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

    <!-- Modal บันทึกวันเวลา เท -->
    <div class="modal fade" id="medalconcreteuse" tabindex="-1" role="dialog" aria-labelledby="medalconcreteuseTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalconcreteuseTitle-2">บันทีกการเทคอนกรีต</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="viewDateClass col pr-0 ">
                        <div class="form-group">
                            <label for="searchSDateId">วันเวลาเท</label>
                            <input id="searchSDateId" class="form-control" type="datetime-local" min="2021-06-01" name="start" value="2021-08-04" required="">
                        </div>
                    </div>
                    <div class="viewDateClass col pr-0 ">
                        <div class="form-group">
                            <label for="searchEDateId">วันเวลาเทเสร็จ</label>
                            <input id="searchEDateId" class="form-control" type="datetime-local" name="end" value="2021-08-04" required="">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                    <button class="btn btn-primary ml-2" type="button">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal เช็คสินค้าเข้าสต๊อก -->
    <div class="modal fade" id="medalstockcheck" tabindex="-1" role="dialog" aria-labelledby="medalstockcheckTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalstockcheckTitle-2">เช็คสินค้าเข้าสต๊อก</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">


                    <!-- ============ Table Start ============= -->
                    <div id="productionorder" class="table-responsive">
                        <table role="table" class="table table-hover text-nowrap table-sm">
                            <thead>
                                <tr class="table-secondary">

                                    <th>รหัสสินค้า</th>
                                    <th>ชื่อสินค้า</th>
                                    <th>ความยาว</th>
                                    <th>จำนวนผลิต</th>
                                    <th>สมบูรณ์</th>
                                    <th>ไม่สมบูรณ์</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>FP03100020</td>
                                    <td>เสารั้ว 3x3"</td>
                                    <td>1.00</td>
                                    <td>100</td>
                                    <td><input class="form-control" type="text" placeholder="ใส่ข้อมูล"></td>
                                    <td><input class="form-control" type="text" placeholder="ใส่ข้อมูล"></td>
                                </tr>
                                <tr>

                                    <td>FP03145020</td>
                                    <td>เสารั้ว 3x3"</td>
                                    <td>1.45</td>
                                    <td>60</td>
                                    <td><input class="form-control" type="text" placeholder="ใส่ข้อมูล"></td>
                                    <td><input class="form-control" type="text" placeholder="ใส่ข้อมูล"></td>
                                </tr>
                                <tr>
                                    <td>FP03200020</td>
                                    <td>เสารั้ว 3x3"</td>
                                    <td>2.00</td>
                                    <td>40</td>
                                    <td><input class="form-control" type="text" placeholder="ใส่ข้อมูล"></td>
                                    <td><input class="form-control" type="text" placeholder="ใส่ข้อมูล"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- ============ Table End ============= -->

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                    <button class="btn btn-primary ml-2" type="button">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============ Search UI End ============= -->
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