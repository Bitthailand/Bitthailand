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
                        <!-- ============ Tab Menu ============= -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link active" href="/quotationlist.php">
                                    <h3 class="h5 font-weight-bold"> Order เสนอราคา
                                        <span class="badge badge-pill badge-danger">1</span>
                                    </h3>
                                    <span>รายการ Order ที่อยู่ระหว่างการเสนอราคา
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link" href="/ailist.php">
                                    <h3 class="h5 font-weight-bold"> Order รอส่ง
                                        <span class="badge badge-pill badge-danger">1</span>
                                    </h3>
                                    <span>Order รอส่งสินค้า
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link" href="/creditlist.php">
                                    <h3 class="h5 font-weight-bold"> รอเคลียเครดิต
                                        <span class="badge badge-pill badge-danger">1</span>
                                    </h3>
                                    <span>ลูกค้าเครดิตรอเคลียยอด
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link" href="/tranDW.php">
                                    <h3 class="h5 font-weight-bold"> Order สำเร็จ</h3>
                                    <span>Order ที่ส่งสินค้าเรียบร้อย
                                        <span class="badge badge-success"> Pass </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link" href="/tranDWLog.php">
                                    <h3 class="h5 font-weight-bold"> Order Log </h3>
                                    <span> รายการ Order ทั้งหมด
                                        <span class="badge badge-light"> Log </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <!-- ============ End Tab Menu ============= -->
                        <div class="tab-content">

                            <!-- ============ Alert Message Start ============= -->

                            <!-- ============ Alert Message End ============= -->

                            <div class="mb-1">
                                <div class="ul-widget__item">
                                    <div class="ul-widget__info">
                                        <h3 class="ul-widget1__title "> ขายสินค้า </h3>
                                        <span class="ul-widget__desc "> รายการใบเสนอราคา </span>
                                    </div>
                                    <div class="text-left">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="searchColumnId"> ประเภท </label>
                                                    <select id="searchColumnId" class="custom-select" name="column">
                                                        <option value="bank_number">Bank No</option>
                                                        <option value="bank_amount">Amount</option>
                                                        <option value="order_id">OrderId</option>
                                                        <option value="bank_time">Bank D/T</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="searchNameId"> Keyword</label>
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
                                                <a href="/addorder.php" class="btn btn-outline-primary mt-4" role="button" aria-pressed="true"> เปิด Order ใหม่</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ============ Table Start ============= -->
                            <div class="table-responsive">
                                <table class="table table-hover text-nowrap table-sm">
                                    <thead>
                                        <tr>
                                            <th>วันที่</th>
                                            <th>Order ID</th>
                                            <th>เลขใบเสนอราคา</th>
                                            <th>ประเภทลูกค้า</th>
                                            <th>ชื่อลูกค้า</th>
                                            <th>เบอร์โทร์</th>
                                            <th>อำเภอ</th>
                                            <th>จังหวัด</th>
                                            <th>ส่วนลด</th>
                                            <th>ก่อนรวมภาษี</th>
                                            <th>ภาษี</th>
                                            <th>ยอดรวม</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> 29 ก.ค. 2021 17:53 </td>
                                            <td> OR6400001</td>
                                            <td> QT6401052</td>
                                            <td> เงินสด</td>
                                            <td> คุณพูนศักดิ์ </td>
                                            <td> 0999999999 </td>
                                            <td>
                                                เมือง
                                            </td>
                                            <td> อุบลราชธานี </td>
                                            <td>
                                                <span class="font-weight-bold"> 0.00 </span>
                                            </td>
                                            <td> <span class="font-weight-bold"> 76,191.59 </span> </td>
                                            <td> <span class="font-weight-bold"> 5,333.41 </span> </td>
                                            <td>
                                                <span class="font-weight-bold"> 81,525.00 </span>
                                            </td>
                                            <td>
                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="มัดจำสินค้า(AI)"
                                                    href="/addai.php?order_id=OR6401052">
                                                    <i class="i-Money-Bag font-weight-bold"></i>
                                                </a>
                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ข้ข้อมูล Order"
                                                    href="/editorder.php?order_id=OR6400001">
                                                    <i class="i-Check font-weight-bold"></i>
                                                </a>
                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="ดูรายละเอียด Order"
                                                    href="/orderview.php?order_id=OR6400001" target="_blank">
                                                    <i class="i-Eye font-weight-bold"></i>
                                                </a>
                                                <div class="btn btn-outline-danger btn-sm line-height-1" data-toggle="modal" title="ยกเลิก Order" data-target="#medalcancleorder">
                                                    <i class="i-Close-Window font-weight-bold"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> 29 ก.ค. 2021 17:53 </td>
                                            <td> OR6400002</td>
                                            <td> QT6401053</td>
                                            <td> เครดิต</td>
                                            <td> คุณธนนวัต </td>
                                            <td> 0888888888 </td>
                                            <td>
                                                เมือง
                                            </td>
                                            <td> ยโสธร </td>
                                            <td>
                                                <span class="font-weight-bold"> 0.00 </span>
                                            </td>
                                            <td> <span class="font-weight-bold"> 6,651.59 </span> </td>
                                            <td> <span class="font-weight-bold"> 953.41 </span> </td>
                                            <td>
                                                <span class="font-weight-bold"> 7,545.00 </span>
                                            </td>
                                            <td>
                                                <div class="btn btn-outline-success btn-sm line-height-1" data-toggle="modal" title="ยืนยันสั่งสินค้า"
                                                    data-target="#medalconfirmorder">
                                                    <i class="i-Memory-Card-3 font-weight-bold"></i>
                                                </div>
                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ข้ข้อมูล Order"
                                                    href="/editorder.php?order_id=OR6400001">
                                                    <i class="i-Check font-weight-bold"></i>
                                                </a>
                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="ดูรายละเอียด Order"
                                                    href="/orderview.php?order_id=OR6400001" target="_blank">
                                                    <i class="i-Eye font-weight-bold"></i>
                                                </a>
                                                <div class="btn btn-outline-danger btn-sm line-height-1" data-toggle="modal" title="ยกเลิก Order" data-target="#medalcancleorder">
                                                    <i class="i-Close-Window font-weight-bold"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="14"> &nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- ============ Table End ============= -->
                            <div class="mt-1">
                                <span class="text-danger mr-1">**</span>
                                <span class="text-muted"> มัดจำขั้นต่ำ 30% เมื่อทำการสั่งซื้อสินค้า</span>
                            </div>
                            <div class="">
                                <span class="text-danger mr-1">**</span>
                                <span class="text-muted">ชำระค่าสินค้าที่เหลือในวันจัดส่ง ก่อนลงสินค้า</span>
                            </div>
                            <div class="">
                                <span class="text-danger mr-1">**</span>
                                <span class="text-muted">ขอสงวนสิทธิ์ในการลงสินค้าต่อเที่ยว (ไม่เกิน 2 ชั่วโมง) หากเกินเวลาคิดเพิ่มชั่วโมงละ 500 บาท</span>
                            </div>
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
            </div>
            <!-- Header -->
            <?php include './include/footer.php'; ?>
            <!-- =============== Header End ================-->
        </div>
    </div>

    <!-- Modal ยกเลิก Order -->
    <div class="modal fade" id="medalcancleorder" tabindex="-1" role="dialog" aria-labelledby="medalcancleorderTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalcancleorderTitle-2">ยกเลิก Order</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p class="text-danger text-16 line-height-1 mb-2">คุณต้องการยกเลิก Order : OR6400001 ใช่หรือไม่ ?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">ไม่ใช่</button>
                    <button class="btn btn-primary ml-2" type="button">ใช่</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal ยืนยันสั่งผลิต -->
    <div class="modal fade" id="medalconfirmorder" tabindex="-1" role="dialog" aria-labelledby="medalconfirmorder" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalconfirmorder">ยืนยันสั่งผลิต</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p class="text-danger text-16 line-height-1 mb-2">ยืนยันสั่งผลิต Order : OR6400001 ใช่หรือไม่ ?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">ไม่ใช่</button>
                    <button class="btn btn-primary ml-2" type="button">ใช่</button>
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