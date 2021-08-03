<?php

?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Customer | รายการลูกค้า</title>
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
                    <h1 class="mr-2">ลูกค้า</h1>
                    <ul>
                        <li><a href="index.php">Dashboard</a></li>
                        <li>ลูกค้า</li>
                    </ul>
                </div>
                <div class="separator-breadcrumb border-top"></div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="tab-content">
                            <div class="mb-1">
                                <div class="ul-widget__item">
                                    <div class="ul-widget__info">
                                        <h3 class="ul-widget1__title d-none"> Customer </h3>
                                        <span class="ul-widget__desc d-none"> รายการลูกค้า </span>
                                    </div>
                                    <div class="text-left">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="searchColumnId"> ประเภท </label>
                                                    <select id="searchColumnId" class="custom-select" name="column">
                                                        <option value="customer_id">รหัสลูกค้า</option>
                                                        <option value="customer_name">ชื่อลูกค้า</option>
                                                        <option value="company">บริษัท</option>
                                                        <option value="address">ที่อยู่</option>
                                                        <option value="phone">เบอร์โทร</option>
                                                        <option value="tax_number">เลขที่ผู้เสียภาษี</option>
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
                                            <a href="/customer.php" class="btn btn-outline-primary mt-4" role="button" aria-pressed="true"> เพิ่มลูกค้าใหม่</a>

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
                                            <th>customer ID</th>
                                            <th>ชื่อลูกค้า</th>
                                            <th>บริษัท</th>
                                            <th>ที่อยู่</th>
                                            <th>ตำบล</th>
                                            <th>อำเภอ</th>
                                            <th>จังหวัด</th>
                                            <th>เบอร์โทร</th>
                                            <th>เลขที่เสียภาษี</th>
                                            <th>อ้างอิง</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> CUS000001 </td>
                                            <td> คุณพูนศักดิ์</td>
                                            <td> - </td>
                                            <td> 123/456 ถ.ชยางค์กูล </td>
                                            <td> ในเมือง </td>
                                            <td>
                                                เมือง
                                            </td>
                                            <td> อุบลราชธานี </td>
                                            <td>
                                                0999999999
                                            </td>
                                            <td> 2904311034586 </td>
                                            <td> - </td>
                                            <td>

                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ไขข้อมูลลูกค้า" href="/customer.php?customer_id=CUS000001">
                                                    <i class="i-Check font-weight-bold"></i>
                                                </a>
                                                <a class="btn btn-outline-info btn-sm line-height-1" data-toggle="tooltip" title="ดูรายการสั่งสินค้า" href="/orderlist.php?statement=268">
                                                    <i class="i-File font-weight-bold"></i>
                                                </a>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td> CUS000001 </td>
                                            <td> คุณพูนศักดิ์</td>
                                            <td> - </td>
                                            <td> 123/456 ถ.ชยางค์กูล </td>
                                            <td> ในเมือง </td>
                                            <td>
                                                เมือง
                                            </td>
                                            <td> อุบลราชธานี </td>
                                            <td>
                                                0999999999
                                            </td>
                                            <td> 2904311034586 </td>
                                            <td> - </td>
                                            <td>

                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ไขข้อมูลลูกค้า" href="/customer.php?customer_id=CUS000001">
                                                    <i class="i-Check font-weight-bold"></i>
                                                </a>
                                                <a class="btn btn-outline-info btn-sm line-height-1" data-toggle="tooltip" title="ดูรายการสั่งสินค้า" href="/orderlist.php?statement=268">
                                                    <i class="i-File font-weight-bold"></i>
                                                </a>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td> CUS000001 </td>
                                            <td> คุณพูนศักดิ์</td>
                                            <td> - </td>
                                            <td> 123/456 ถ.ชยางค์กูล </td>
                                            <td> ในเมือง </td>
                                            <td>
                                                เมือง
                                            </td>
                                            <td> อุบลราชธานี </td>
                                            <td>
                                                0999999999
                                            </td>
                                            <td> 2904311034586 </td>
                                            <td> - </td>
                                            <td>

                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ไขข้อมูลลูกค้า" href="/customer.php?customer_id=CUS000001">
                                                    <i class="i-Check font-weight-bold"></i>
                                                </a>
                                                <a class="btn btn-outline-info btn-sm line-height-1" data-toggle="tooltip" title="ดูรายการสั่งสินค้า" href="/orderlist.php?statement=268">
                                                    <i class="i-File font-weight-bold"></i>
                                                </a>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td> CUS000001 </td>
                                            <td> คุณพูนศักดิ์</td>
                                            <td> - </td>
                                            <td> 123/456 ถ.ชยางค์กูล </td>
                                            <td> ในเมือง </td>
                                            <td>
                                                เมือง
                                            </td>
                                            <td> อุบลราชธานี </td>
                                            <td>
                                                0999999999
                                            </td>
                                            <td> 2904311034586 </td>
                                            <td> - </td>
                                            <td>

                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ไขข้อมูลลูกค้า" href="/customer.php?customer_id=CUS000001">
                                                    <i class="i-Check font-weight-bold"></i>
                                                </a>
                                                <a class="btn btn-outline-info btn-sm line-height-1" data-toggle="tooltip" title="ดูรายการสั่งสินค้า" href="/orderlist.php?statement=268">
                                                    <i class="i-File font-weight-bold"></i>
                                                </a>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="14"> &nbsp;</td>
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