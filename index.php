<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Dashboard | ภาพรวมการทำงาน</title>
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
                <div class="breadcrumb">
                    <h1 class="mr-2">ข้อมูลภาพรวม
                    </h1>
                    <ul>
                        <li><a href="">ภาพรวมการขาย</a></li>
                        <li>ประจำเดือน</li>
                    </ul>
                </div>
                <div class="row">
                    <!-- ICON BG-->
                    <div class="col-md-3 col-lg-3">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="ul-widget__row">
                                    <div class="ul-widget-stat__font"><i class="i-Money-2 text-success"></i></div>
                                    <div class="ul-widget__content">
                                        <p class="m-0">ยอดขายประจำเดือน</p>
                                        <h4 class="heading">400,894.00</h4>
                                        <small class="text-muted m-0">ยอดขายประจำปี : 12,265,546.00</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="ul-widget__row">
                                    <div class="ul-widget-stat__font"><i class="i-Administrator text-primary"></i></div>
                                    <div class="ul-widget__content">
                                        <p class="m-0">จำนวนลูกค้าประจำเดือน</p>
                                        <h4 class="heading">544</h4>
                                        <small class="text-muted m-0">จำนวนลูกค้าประจำปี : 1,265</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="ul-widget__row">
                                    <div class="ul-widget-stat__font"><i class="i-Full-Cart text-success"></i></div>
                                    <div class="ul-widget__content">
                                        <p class="m-0">จำนวน Order ประจำเดือน</p>
                                        <h4 class="heading">652</h4>
                                        <small class="text-muted m-0">จำนวน Order ประจำปี : 1,352</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="ul-widget__row">
                                    <div class="ul-widget-stat__font"><i class="i-Add-User text-warning"></i></div>
                                    <div class="ul-widget__content">
                                        <p class="m-0">ลูกค้า Online : Wark-in</p>
                                        <h4 class="heading">352 : 52</h4>
                                        <small class="text-muted m-0">ในรอบปี 2,256 : 534</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">ยอดขายประจำปี</div>
                                <div id="echartBar" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">ยอดขายตามประเภทสินค้า</div>
                                <div id="echartPie" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">

                                        <div class="ul-widget__head">
                                            <div class="ul-widget__head-label">
                                                <h3 class="ul-widget__head-title"> รายชื่อลูกค้าที่มียอดสั่งสูงสุด</h3>
                                            </div>
                                            <div class="ul-widget__head-toolbar">
                                                <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold ul-widget-nav-tabs-line" role="tablist">
                                                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#__d-widget4-tab1-content" role="tab"
                                                            aria-selected="true">Month</a></li>
                                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#__d-widget4-tab2-content" role="tab"
                                                            aria-selected="false">Year</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="ul-widget__body">
                                            <div class="tab-content">
                                                <div class="tab-pane active show" id="__d-widget4-tab1-content">
                                                    <div class="ul-widget1">

                                                        <div class="table-responsive">
                                                            <table class="table text-center" id="user_table">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">ชื่อลูกค้า</th>
                                                                        <th scope="col">อำเภอ</th>
                                                                        <th scope="col">จังหวัด</th>
                                                                        <th scope="col">ยอดสั่งรวม</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <th scope="row">1</th>
                                                                        <td>คุณภู จารุจิตร</td>
                                                                        <td>หัวตะพาน</td>
                                                                        <td>อำนาจเจริญ</td>
                                                                        <td>1,345,526.44</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">2</th>
                                                                        <td>คุณพิสิษฐ ทองทวี</td>
                                                                        <td>สิรินธร</td>
                                                                        <td>อุบลราชธานี</td>
                                                                        <td>456,526.44</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">3</th>
                                                                        <td>ร้านศักดิ์ไทย</td>
                                                                        <td>ศรีรัตนะ</td>
                                                                        <td>ศรีสะเกษ</td>
                                                                        <td>456,526.44</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">4</th>
                                                                        <td>คุณวิชัย ปัญญาวงค์</td>
                                                                        <td>พิบูลมังสาหาร</td>
                                                                        <td>อุบลราชธานี</td>
                                                                        <td>143,526.44</td>
                                                                    </tr>
                                                                    <th scope="row">5</th>
                                                                    <td>คุณคณาธร ธาตุระหัน</td>
                                                                    <td>รัตนบุรี</td>
                                                                    <td>สุรินทร์</td>
                                                                    <td>86,526.44</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="__d-widget4-tab2-content">
                                                    <div class="ul-widget1">
                                                        <div class="table-responsive">
                                                            <table class="table text-center" id="user_table">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">ชื่อลูกค้า</th>
                                                                        <th scope="col">อำเภอ</th>
                                                                        <th scope="col">จังหวัด</th>
                                                                        <th scope="col">ยอดสั่งรวม</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <th scope="row">1</th>
                                                                        <td>คุณพิสิษฐ ทองทวี</td>
                                                                        <td>สิรินธร</td>
                                                                        <td>อุบลราชธานี</td>
                                                                        <td>12,453,526.44</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">2</th>
                                                                        <td>คุณภู จารุจิตร</td>
                                                                        <td>หัวตะพาน</td>
                                                                        <td>อำนาจเจริญ</td>
                                                                        <td>5,345,526.44</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">3</th>
                                                                        <td>คุณวิชัย ปัญญาวงค์</td>
                                                                        <td>พิบูลมังสาหาร</td>
                                                                        <td>อุบลราชธานี</td>
                                                                        <td>1,453,526.44</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">4</th>
                                                                        <td>คุณคณาธร ธาตุระหัน</td>
                                                                        <td>รัตนบุรี</td>
                                                                        <td>สุรินทร์</td>
                                                                        <td>854,526.44</td>
                                                                    </tr>
                                                                    <th scope="row">5</th>
                                                                    <td>ร้านศักดิ์ไทย</td>
                                                                    <td>ศรีรัตนะ</td>
                                                                    <td>ศรีสะเกษ</td>
                                                                    <td>356,526.44</td>
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
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body p-0">
                                        <h5 class="card-title m-0 p-3">ยอดขาย 30 วันล่าสุด</h5>
                                        <div id="eORchartBar" style="height: 360px;"></div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">

                                <div class="ul-widget__head">
                                    <div class="ul-widget__head-label">
                                        <h3 class="ul-widget__head-title">รายชื่อสินค้าที่มียอดขายสูงสุด</h3>
                                    </div>
                                    <div class="ul-widget__head-toolbar">
                                        <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold ul-widget-nav-tabs-line" role="tablist">
                                            <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#__g-widget4-tab1-content" role="tab"
                                                    aria-selected="true">Month</a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#__g-widget4-tab2-content" role="tab" aria-selected="false">Year</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="ul-widget__body">
                                    <div class="tab-content">
                                        <div class="tab-pane active show" id="__g-widget4-tab1-content">
                                            <div class="ul-widget1">
                                                <div class="ul-widget4__item ul-widget4__users">
                                                    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3">
                                                        <img class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="../../dist-assets/images/products/11.jpg" alt="" />
                                                        <div class="flex-grow-1">
                                                            <h5><a href="#"> เสารั้วลวดหนาม ขนาด 3 นิ้ว ยาว 1.45 เมตร</a></h5>
                                                            <p class="m-0 text-small text-muted">เสารั้วลวดหนาม</p>
                                                            <p class="text-small text-danger m-0">฿354,693.00
                                                                <del class="text-muted"></del>
                                                            </p>
                                                        </div>
                                                        <div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ul-widget4__item ul-widget4__users">
                                                    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3">
                                                        <img class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="../../dist-assets/images/products/22.png" alt="" />
                                                        <div class="flex-grow-1">
                                                            <h5><a href="#"> เสารั้วคาวบอย 4 คาน ยาว 2.00 เมตร</a></h5>
                                                            <p class="m-0 text-small text-muted">เสารั้วคาวบอย</p>
                                                            <p class="text-small text-danger m-0">฿259,663.00
                                                                <del class="text-muted"></del>
                                                            </p>
                                                        </div>
                                                        <div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ul-widget4__item ul-widget4__users">
                                                    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3">
                                                        <img class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="../../dist-assets/images/products/33.jpg" alt="" />
                                                        <div class="flex-grow-1">
                                                            <h5><a href="#"> เสารั้วลวดหนาม ขนาด 4 นิ้ว ยาว 4.00 เมตร</a></h5>
                                                            <p class="m-0 text-small text-muted">เสารั้วลวดหนาม</p>
                                                            <p class="text-small text-danger m-0">฿159,493.00
                                                                <del class="text-muted"></del>
                                                            </p>
                                                        </div>
                                                        <div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ul-widget4__item ul-widget4__users">
                                                    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3">
                                                        <img class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="../../dist-assets/images/products/44.png" alt="" />
                                                        <div class="flex-grow-1">
                                                            <h5><a href="#"> เสาเข็มไอ 18 ยาว 2.50 เมตร</a></h5>
                                                            <p class="m-0 text-small text-muted">เสาเข็มไอ</p>
                                                            <p class="text-small text-danger m-0">฿124,643.00
                                                                <del class="text-muted"></del>
                                                            </p>
                                                        </div>
                                                        <div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ul-widget4__item ul-widget4__users">
                                                    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3">
                                                        <img class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="../../dist-assets/images/products/44.png" alt="" />
                                                        <div class="flex-grow-1">
                                                            <h5><a href="#"> เสาเข็มไอ 18 ยาว 2.50 เมตร</a></h5>
                                                            <p class="m-0 text-small text-muted">เสาเข็มไอ</p>
                                                            <p class="text-small text-danger m-0">฿124,643.00
                                                                <del class="text-muted"></del>
                                                            </p>
                                                        </div>
                                                        <div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ul-widget4__item ul-widget4__users">
                                                    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3">
                                                        <img class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="../../dist-assets/images/products/44.png" alt="" />
                                                        <div class="flex-grow-1">
                                                            <h5><a href="#"> เสาเข็มไอ 18 ยาว 2.50 เมตร</a></h5>
                                                            <p class="m-0 text-small text-muted">เสาเข็มไอ</p>
                                                            <p class="text-small text-danger m-0">฿124,643.00
                                                                <del class="text-muted"></del>
                                                            </p>
                                                        </div>
                                                        <div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="__g-widget4-tab2-content">
                                            <div class="ul-widget1">
                                                <div class="ul-widget4__item ul-widget4__users">
                                                    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3">
                                                        <img class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="../../dist-assets/images/products/33.jpg" alt="" />
                                                        <div class="flex-grow-1">
                                                            <h5><a href="#"> เสารั้วลวดหนาม ขนาด 4 นิ้ว ยาว 4.00 เมตร</a></h5>
                                                            <p class="m-0 text-small text-muted">เสารั้วลวดหนาม</p>
                                                            <p class="text-small text-danger m-0">฿159,493.00
                                                                <del class="text-muted"></del>
                                                            </p>
                                                        </div>
                                                        <div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ul-widget4__item ul-widget4__users">
                                                    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3">
                                                        <img class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="../../dist-assets/images/products/11.jpg" alt="" />
                                                        <div class="flex-grow-1">
                                                            <h5><a href="#"> เสารั้วลวดหนาม ขนาด 3 นิ้ว ยาว 1.45 เมตร</a></h5>
                                                            <p class="m-0 text-small text-muted">เสารั้วลวดหนาม</p>
                                                            <p class="text-small text-danger m-0">฿354,693.00
                                                                <del class="text-muted"></del>
                                                            </p>
                                                        </div>
                                                        <div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ul-widget4__item ul-widget4__users">
                                                    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3">
                                                        <img class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="../../dist-assets/images/products/22.png" alt="" />
                                                        <div class="flex-grow-1">
                                                            <h5><a href="#"> เสารั้วคาวบอย 4 คาน ยาว 2.00 เมตร</a></h5>
                                                            <p class="m-0 text-small text-muted">เสารั้วคาวบอย</p>
                                                            <p class="text-small text-danger m-0">฿259,663.00
                                                                <del class="text-muted"></del>
                                                            </p>
                                                        </div>
                                                        <div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ul-widget4__item ul-widget4__users">
                                                    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3">
                                                        <img class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="../../dist-assets/images/products/44.png" alt="" />
                                                        <div class="flex-grow-1">
                                                            <h5><a href="#"> เสาเข็มไอ 18 ยาว 2.50 เมตร</a></h5>
                                                            <p class="m-0 text-small text-muted">เสาเข็มไอ</p>
                                                            <p class="text-small text-danger m-0">฿124,643.00
                                                                <del class="text-muted"></del>
                                                            </p>
                                                        </div>
                                                        <div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ul-widget4__item ul-widget4__users">
                                                    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3">
                                                        <img class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="../../dist-assets/images/products/44.png" alt="" />
                                                        <div class="flex-grow-1">
                                                            <h5><a href="#"> เสาเข็มไอ 18 ยาว 2.50 เมตร</a></h5>
                                                            <p class="m-0 text-small text-muted">เสาเข็มไอ</p>
                                                            <p class="text-small text-danger m-0">฿124,643.00
                                                                <del class="text-muted"></del>
                                                            </p>
                                                        </div>
                                                        <div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ul-widget4__item ul-widget4__users">
                                                    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3">
                                                        <img class="avatar-lg mb-3 mb-sm-0 rounded mr-sm-3" src="../../dist-assets/images/products/44.png" alt="" />
                                                        <div class="flex-grow-1">
                                                            <h5><a href="#"> เสาเข็มไอ 18 ยาว 2.50 เมตร</a></h5>
                                                            <p class="m-0 text-small text-muted">เสาเข็มไอ</p>
                                                            <p class="text-small text-danger m-0">฿124,643.00
                                                                <del class="text-muted"></del>
                                                            </p>
                                                        </div>
                                                        <div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">ยอดขายตามประเภทสินค้า</div>
                                <div id="ProtypechartBar" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div><!-- end of main-content -->
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
    <script src="../../dist-assets/js/scripts/dashboard.v1.script.min.js?id=1"></script>
    <script src="../../dist-assets/js/scripts/customizer.script.min.js"></script>
</body>

</html>