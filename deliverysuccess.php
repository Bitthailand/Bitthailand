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
                                <a class="linkLoadModalNext nav-link " href="/deliverylist.php">
                                    <h3 class="h5 font-weight-bold"> รายการส่งสินค้า
                                        <span class="badge badge-pill badge-danger">3</span>
                                    </h3>
                                    <span>รายการส่งสินค้าที่ออกใบ SO แล้วอยู่ระหว่างการส่ง
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link active" href="/deliverysuccess.php">
                                    <h3 class="h5 font-weight-bold">รายการส่งสินค้าเรียบร้อย
                                        <span class="badge badge-pill badge-danger"></span>
                                    </h3>
                                    <span>รายการที่ส่งสินค้าเรียบร้อยแล้ว
                                        <span class="badge badge-success"> Success </span>
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
                                        <h3 class="ul-widget1__title "> ส่งสินค้า </h3>
                                        <span class="ul-widget__desc "> รายการสินค้าเรียบร้อย </span>
                                    </div>
                                    <div class="text-left">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="searchColumnId"> ประเภท </label>
                                                    <select id="searchColumnId" class="custom-select" name="column">
                                                        <option value="bank_number">Sale Order ID</option>
                                                        <option value="bank_amount">Order ID</option>
                                                        <option value="order_id">พนักงานส่ง</option>
                                                        <option value="bank_time">พสักงานตรวจสอบ</option>
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
                                <table class="table table-hover text-nowrap table-sm">
                                    <thead>
                                        <tr>
                                            <th>SO ID</th>
                                            <th>Order ID</th>
                                            <th>วันที่ส่ง</th>
                                            <th>พนักงานส่ง</th>
                                            <th>พนักงานตรวจสอบ</th>
                                            <th>ชื่อลูกค้า</th>
                                            <th>เบอร์โทร</th>
                                            <th>ที่อยู่ส่ง</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> SO6401052 </td>
                                            <td> OR6400001</td>
                                            <td> 29 ก.ค. 2021</td>
                                            <td> นายธนนวัต</td>
                                            <td> นายประสิทธิ์ </td>
                                            <td> คุณพูนศักดิ์ </td>
                                            <td> 0999999999 </td>
                                            <td>
                                                89/171 หมู่บ้านเจริญทรัพย์ 10 ต.คลองหาด อ.คลองหาด จ.สระแก้ว
                                            </td>
                                            <td>
                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="ดูรายละเอียด Order"
                                                    href="/orderview.php?order_id=OR6400001" target="_blank">
                                                    <i class="i-Eye font-weight-bold"></i>
                                                </a>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td> SO6401052 </td>
                                            <td> OR6400001</td>
                                            <td> 29 ก.ค. 2021</td>
                                            <td> นายธนนวัต</td>
                                            <td> นายประสิทธิ์ </td>
                                            <td> คุณพูนศักดิ์ </td>
                                            <td> 0999999999 </td>
                                            <td>
                                                89/171 หมู่บ้านเจริญทรัพย์ 10 ต.คลองหาด อ.คลองหาด จ.สระแก้ว
                                            </td>
                                            <td>
                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="ดูรายละเอียด Order"
                                                    href="/orderview.php?order_id=OR6400001" target="_blank">
                                                    <i class="i-Eye font-weight-bold"></i>
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
                            <div class="mt-1">
                                <span class="text-danger mr-1">**</span>
                                <span class="text-muted">-</span>
                            </div>
                            <div class="">
                                <span class="text-danger mr-1">**</span>
                                <span class="text-muted">-</span>
                            </div>
                            <div class="">
                                <span class="text-danger mr-1">**</span>
                                <span class="text-muted">-</span>
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

    <!-- Modal กำหนดพนักงานส่งและตรวจสอบ -->
    <div class="modal fade" id="medaltransorder" tabindex="-1" role="dialog" aria-labelledby="medaltransorderTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medaltransorderTitle-2">กำหนดพนักงานส่งและตรวจสอบ</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="searchColumnId"> ชื่อพนักงานส่ง </label>
                        <select id="searchColumnId" class="custom-select" name="column">
                            <option value="นาย A ">นาย A </option>
                            <option value="นาย B">นาย B</option>
                            <option value="นาย C">นาย C</option>
                            <option value="นาย D">นาย D</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="searchColumnId"> ชื่อพนักงานตรวจสอบ </label>
                        <select id="searchColumnId" class="custom-select" name="column">
                            <option value="นาย A ">นาย A </option>
                            <option value="นาย B">นาย B</option>
                            <option value="นาย C">นาย C</option>
                            <option value="นาย D">นาย D</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary ml-2" type="button">ตกลง</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal ยืนยันส่งสินค้า -->
    <div class="modal fade" id="medaltransuccess" tabindex="-1" role="dialog" aria-labelledby="medaltransuccess-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medaltransuccess-2">ยืนยันส่งสินค้า</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p class="text-Success text-16 line-height-1 mb-2">ยืนยันส่งสินค้า Sale Order ID : SO6400001 เรียบร้อยใช่หรือไม่ ?</p>
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