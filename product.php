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
                        <div class="card">
                            <div class="tab-content" id="myTabContent">
                                <form class="tab-pane fade active show" method="post">

                                    <div class="border-bottom text-primary">
                                        <div class="card-title">เพิ่มข้อมูลลูกค้า</div>
                                    </div>
                                    <div class="row mt-4">
                                    </div>
                                    <div class="form-row mt-3">

                                        <div class="form-group col-md-4">
                                            <label for="accNameId"><strong>รหัสลูกค้า <span class="text-danger">*</span></strong></label>
                                            <input type="text" name="customer_id" id="customer_id" class="classcus form-control" placeholder="รหัสลูกค้า" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="accNameId"><strong>ชื่อ-นามสกุล <span class="text-danger">*</span></strong></label>
                                            <input type="text" name="customer_name" id="customer_name" class="classcus form-control" placeholder="ชื่อ-นามสกุล" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="accNameId"><strong>ชื่อบริษัท <span class="text-danger"></span></strong></label>
                                            <input type="text" name="company_name" id="company_name" class="classcus form-control" placeholder="ชื่อบริษัท" >
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="phone"><strong>เบอร์โทร <span class="text-danger">*</span></strong></label>
                                            <input type="text" name="phone" id="phone" class="classcus form-control" placeholder="เบอร์โทร" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="tax_number"><strong>เลขที่ผู้เสียภาษี <span class="text-danger"></span></strong></label>
                                            <input type="text" name="tax_number" id="tax_number" class="classcus form-control" placeholder="เลขที่ผู้เสียภาษี" autocomplete="off" >
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="referral"><strong>บุคคลอ้างอิง <span class="text-danger"></span></strong></label>
                                            <input type="text" name="referral" id="referral" class="classcus form-control" placeholder="บุคคลอ้างอิง" autocomplete="off" >
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="accAddressId"><strong>ที่อยู่ <span class="text-danger">*</span></strong></label>
                                            <input type="text" name="address" class="classcus form-control" id="address" placeholder="ที่อยู่" required="">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="province"><strong>จังหวัด <span class="text-danger">*</span></strong></label>
                                            <select class="classcus custom-select" name="province" id="province" required>
                                                <option value="อุบลราชธานี">อุบลราชธานี</option>
                                                <option value="ยโสธร">ยโสธร</option>
                                                <option value="อำนาจเจริญ">อำนาจเจริญ</option>
                                                <option value="ศรีสะเกษ">ศรีสะเกษ</option>
                                                <option value="บุรีรัม">บุรีรัม</option>
                                                <option value="ร้อยเอ็ด">ร้อยเอ็ด</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="district"><strong>อำเภอ <span class="text-danger">*</span></strong></label>
                                            <select class="classcus custom-select" name="district" id="district" required>
                                                <option value="เมือง">เมือง</option>
                                                <option value="เขื่องใน">เขื่องใน</option>
                                                <option value="วารินชำราบ">วารินชำราบ</option>
                                                <option value="สว่างวีระวงศ์">สว่างวีระวงศ์</option>
                                                <option value="เหล่าเสือโก้ก">เหล่าเสือโก้ก</option>
                                                <option value="ม่วงสามสิบ">ม่วงสามสิบ</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="subdistrict"><strong>ตำบล <span class="text-danger">*</span></strong></label>
                                            <select class="classcus custom-select" name="subdistrict" id="subdistrict" required>
                                                <option value="ในเมือง">ในเมือง</option>
                                                <option value="หนองขอน">หนองขอน</option>
                                                <option value="ขามใหญ่">ขามใหญ่</option>
                                                <option value="แจระแม">แจระแม</option>
                                                <option value="หนองบ่อ">หนองบ่อ</option>
                                                <option value="ไร่น้อย">ไร่น้อย</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="delivery_address"><strong>ที่อยู่ส่งสินค้า <span class="text-danger"></span></strong></label>
                                            <input type="text" name="delivery_address" class="classcus form-control" id="delivery_address" placeholder="ที่อยู่ส่งสินค้า" >
                                        </div>


                                    </div>
                                  
                                    <hr>

                                    <div class="text-right">
                                        <input class="d-none" id="addAccId" type="text" name="acc_id" value="" placeholder="">
                                        <input class="d-none" id="addActionId" type="text" name="action" value="add" placeholder="">

                                        <button id="btnAddId" class="btn btn-outline-primary d-none" type="submit">ยืนยันการเพิ่มลูกค้า</button>
                                        <button class="btn btn-primary ladda-button btn-add" data-style="expand-left">
                                            <span class="ladda-label">ยืนยันการเพิ่มลูกค้า</span>
                                        </button>
                                        <a class="btn btn-outline-danger m-1" href="/customerslist.php" type="button">กลับหน้ารายการ</a>
                                    </div>

                                </form>

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
    </div><!-- ============ Search UI Start ============= -->
    <div class="search-ui">
        <div class="search-header">
            <img src="../../dist-assets/images/logo.png" alt="" class="logo">
            <button class="search-close btn btn-icon bg-transparent float-right mt-2">
                <i class="i-Close-Window text-22 text-muted"></i>
            </button>
        </div>
        <input type="text" placeholder="Type here" class="search-input" autofocus>
        <div class="search-title">
            <span class="text-muted">Search results</span>
        </div>
        <div class="search-results list-horizontal">
            <div class="list-item col-md-12 p-0">
                <div class="card o-hidden flex-row mb-4 d-flex">
                    <div class="list-thumb d-flex">
                        <!-- TUMBNAIL -->
                        <img src="../../dist-assets/images/products/headphone-1.jpg" alt="">
                    </div>
                    <div class="flex-grow-1 pl-2 d-flex">
                        <div class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center flex-lg-row">
                            <!-- OTHER DATA -->
                            <a href="" class="w-40 w-sm-100">
                                <div class="item-title">Headphone 1</div>
                            </a>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">Gadget</p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">$300
                                <del class="text-secondary">$400</del>
                            </p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100 d-none d-lg-block item-badges">
                                <span class="badge badge-danger">Sale</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-item col-md-12 p-0">
                <div class="card o-hidden flex-row mb-4 d-flex">
                    <div class="list-thumb d-flex">
                        <!-- TUMBNAIL -->
                        <img src="../../dist-assets/images/products/headphone-2.jpg" alt="">
                    </div>
                    <div class="flex-grow-1 pl-2 d-flex">
                        <div class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center flex-lg-row">
                            <!-- OTHER DATA -->
                            <a href="" class="w-40 w-sm-100">
                                <div class="item-title">Headphone 1</div>
                            </a>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">Gadget</p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">$300
                                <del class="text-secondary">$400</del>
                            </p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100 d-none d-lg-block item-badges">
                                <span class="badge badge-primary">New</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-item col-md-12 p-0">
                <div class="card o-hidden flex-row mb-4 d-flex">
                    <div class="list-thumb d-flex">
                        <!-- TUMBNAIL -->
                        <img src="../../dist-assets/images/products/headphone-3.jpg" alt="">
                    </div>
                    <div class="flex-grow-1 pl-2 d-flex">
                        <div class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center flex-lg-row">
                            <!-- OTHER DATA -->
                            <a href="" class="w-40 w-sm-100">
                                <div class="item-title">Headphone 1</div>
                            </a>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">Gadget</p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">$300
                                <del class="text-secondary">$400</del>
                            </p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100 d-none d-lg-block item-badges">
                                <span class="badge badge-primary">New</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-item col-md-12 p-0">
                <div class="card o-hidden flex-row mb-4 d-flex">
                    <div class="list-thumb d-flex">
                        <!-- TUMBNAIL -->
                        <img src="../../dist-assets/images/products/headphone-4.jpg" alt="">
                    </div>
                    <div class="flex-grow-1 pl-2 d-flex">
                        <div class="card-body align-self-center d-flex flex-column justify-content-between align-items-lg-center flex-lg-row">
                            <!-- OTHER DATA -->
                            <a href="" class="w-40 w-sm-100">
                                <div class="item-title">Headphone 1</div>
                            </a>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">Gadget</p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100">$300
                                <del class="text-secondary">$400</del>
                            </p>
                            <p class="m-0 text-muted text-small w-15 w-sm-100 d-none d-lg-block item-badges">
                                <span class="badge badge-primary">New</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PAGINATION CONTROL -->
        <div class="col-md-12 mt-5 text-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination d-inline-flex">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
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