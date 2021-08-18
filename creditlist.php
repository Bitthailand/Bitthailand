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
                                <a class="linkLoadModalNext nav-link " href="/quotationlist.php">
                                    <h3 class="h5 font-weight-bold"> Order เสนอราคา
                                        <span class="badge badge-pill badge-danger">1</span>
                                    </h3>
                                    <span>รายการ Order ที่อยู่ระหว่างการเสนอราคา
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link " href="/ailist.php">
                                    <h3 class="h5 font-weight-bold"> Order รอส่ง
                                        <span class="badge badge-pill badge-danger">1</span>
                                    </h3>
                                    <span>Order รอส่งสินค้า
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link active" href="/creditlist.php">
                                    <h3 class="h5 font-weight-bold"> รอเคลียเครดิต
                                        <span class="badge badge-pill badge-danger">1</span>
                                    </h3>
                                    <span>ลูกค้าเครดิตรอเคลียยอด
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link" href="/ordersuccesslist.php">
                                    <h3 class="h5 font-weight-bold"> Order สำเร็จ</h3>
                                    <span>Order ที่ส่งสินค้าเรียบร้อย
                                        <span class="badge badge-success"> Pass </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link" href="/orderloglist.php">
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
                                        <h3 class="ul-widget1__title "> รายการวางบิล </h3>
                                        <span class="ul-widget__desc "> รายการวางบิลของลูกค้าเครดิต </span>
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

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ============ Table Start ============= -->
                            <div class="table-responsive">
                                <table role="table" class="table table-hover text-nowrap table-sm">
                                    <thead>
                                        <tr class="table-secondary">
                                            <th>รหัส BI</th>
                                            <th>วันที่วางบิล</th>
                                            <th>ชื่อลูกค้า</th>
                                            <th>เลขที่ใบกำกับ</th>
                                            <th>วันที่</th>
                                            <th>ครบกำหนด</th>
                                            <th>จำนวนเงิน</th>
                                            <th>ชำระแล้ว</th>
                                            <th>เงินคงค้าง</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <strong>BI6405002</strong>
                                            </td>
                                            <td> <strong>13 พ.ค.64</strong>
                                            </td>
                                            <td>
                                                <strong>โฮมเมท</strong>
                                            </td>
                                            <td>
                                                <strong>IV6400048</strong>
                                            </td>
                                            <td>
                                                24 พ.ค.64
                                            </td>
                                            <td>24 พ.ค.64</td>
                                            <td>3,705.00</td>
                                            <td>0.00</td>
                                            <td>3,705.00</td>
                                            <td>
                                                <span class="badge badge-warning p-1">รอวางบิล</span>
                                            </td>
                                            <td>
                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="" href="bi.php?po_id=PO640800056"
                                                    data-original-title="วาลบิล">
                                                    <i class="i-Pen-2 font-weight-bold"></i>
                                                </a>
                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="" href="biinvoice.php?po_id=PO640800056"
                                                    data-original-title="ชำระเงิน">
                                                    <i class="i-Money-Bag font-weight-bold"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td>
                                                <strong>IV6400048</strong>
                                            </td>
                                            <td>
                                                24 พ.ค.64
                                            </td>
                                            <td>24 พ.ค.64</td>
                                            <td>3,705.00</td>
                                            <td>0.00</td>
                                            <td>3,705.00</td>
                                            <td>
                                                <span class="badge badge-warning p-1">รอวางบิล</span>
                                            </td>
                                            <td> </td>
                                        </tr>
                                        <tr class="table table-hover text-nowrap table-sm">
                                            <td></td>

                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>7,410.00</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>BI6405002</strong>
                                            </td>
                                            <td> <strong>13 พ.ค.64</strong>
                                            </td>
                                            <td>
                                                <strong>โฮมเมท</strong>
                                            </td>
                                            <td>
                                                <strong>IV6400048</strong>
                                            </td>
                                            <td>
                                                24 พ.ค.64
                                            </td>
                                            <td>24 พ.ค.64</td>
                                            <td>3,705.00</td>
                                            <td>0.00</td>
                                            <td>3,705.00</td>
                                            <td>
                                                <span class="badge badge-warning p-1">วางบิล</span>
                                            </td>
                                            <td>
                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="" href="bi.php?po_id=PO640800056"
                                                    data-original-title="วาลบิล">
                                                    <i class="i-Pen-2 font-weight-bold"></i>
                                                </a>
                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="" href="biinvoice.php?po_id=PO640800056"
                                                    data-original-title="ชำระเงิน">
                                                    <i class="i-Money-Bag font-weight-bold"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td>
                                                <strong>IV6400048</strong>
                                            </td>
                                            <td>
                                                24 พ.ค.64
                                            </td>
                                            <td>24 พ.ค.64</td>
                                            <td>3,705.00</td>
                                            <td>0.00</td>
                                            <td>3,705.00</td>
                                            <td>
                                                <span class="badge badge-warning p-1">วางบิล</span>
                                            </td>
                                            <td> </td>
                                        </tr>
                                        <tr class="table table-hover text-nowrap table-sm">
                                            <td></td>

                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>7,410.00</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- ============ Table End ============= -->
<!--                             <div class="mt-1">
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
                            </div> -->
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