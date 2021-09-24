<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';

unset($_SESSION['order_id']);
?>

<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Datatables | Gull Admin Template</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../dist-assets/css/plugins/datatables.min.css" />
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
                                        <?php
                                        $count0 = "SELECT COUNT(*) As total_records FROM orders where  status='0'  AND order_status='1'";
                                        $rs_count0 = $conn->query($count0);
                                        $rcount0 = $rs_count0->fetch_assoc();
                                        ?>
                                        <span class="badge badge-pill badge-danger"><?= $rcount0['total_records'] ?></span>
                                    </h3>
                                    <span>รายการ Order เสนอราคา
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link" href="/ailist.php">
                                    <?php
                                    $count = "SELECT COUNT(*) As total_records FROM orders where  status='0'  AND order_status='2'";
                                    $rs_count = $conn->query($count);
                                    $rcount = $rs_count->fetch_assoc();
                                    ?>
                                    <h3 class="h5 font-weight-bold"> Order รอส่ง
                                        <span class="badge badge-pill badge-danger"><?= $rcount['total_records'] ?></span>
                                    </h3>
                                    <span>Order รอส่งสินค้า
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link" href="/creditlist.php">
                                    <h3 class="h5 font-weight-bold"> รอเคลียเครดิต
                                        <?php
                                        $count = "SELECT COUNT(*) As total_records FROM bi_number  where  status='0'  AND status_bi='1' ";
                                        $rs_count = $conn->query($count);
                                        $rcount = $rs_count->fetch_assoc();
                                        ?>

                                        <span class="badge badge-pill badge-danger"><?= $rcount['total_records'] ?></span>
                                    </h3>
                                    <span>ลูกค้าเครดิตรอเคลียยอด
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link active" href="/ordersuccesslist.php">
                                    <h3 class="h5 font-weight-bold"> Order สำเร็จ</h3>
                                    <span>Order ที่ส่งสินค้าเรียบร้อย
                                        <span class="badge badge-success"> Pass </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <?php
                                $countx = "SELECT COUNT(*) As total_records FROM sr_number  where  status_sr='1'   ";
                                $rs_countx = $conn->query($countx);
                                $rcountx = $rs_countx->fetch_assoc();
                                ?>
                                <a class="linkLoadModalNext nav-link" href="/orderrefun.php">
                                    <h3 class="h5 font-weight-bold"> Order คืนสินค้า </h3>
                                    <span> รายการคืนสินค้า
                                        <span class="badge badge-pill badge-danger"><?= $rcountx['total_records'] ?></span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link " href="/orderloglist.php">
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
                                        <h3 class="ul-widget1__title "> รายการสำเร็จ </h3>

                                    </div>

                                </div>
                            </div>

                            <!-- ============ Table Start ============= -->
                            <div class="table-responsive">
                            <table id="employee-grid" class="display nowrap table-bordered" style="width:100%">
                               

                                    <thead>
                                        <tr>
                                            <th width="10%">วันที่</th>
                                            <th width="10%">Order ID</th>
                                            <th width="10%">ประเภท</th>
                                            <th width="20%">รับสินค้า</th>
                                            <th width="30%">ชื่อลูกค้า</th>
                                            <th width="10%">เบอร์โทร</th>
                                            <th width="10%">อำเภอ</th>
                                            <th width="10%">จังหวัด</th>
                                            <th width="10%">ค่ามัดจำ</th>
                                            <th width="10%">ก่อนรวมภาษี</th>
                                            <th width="10%">ภาษี</th>
                                            <th width="10%">ยอดรวม</th>
                                            <th width="20%">Action</th>
                                            <th width="5%">แก้ไข</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                </table>

                            </div>
                        </div>
                        <!-- ============ Table End ============= -->

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
                <!-- ============ Search UI End ============= -->
                <script src="../../dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
                <script src="../../dist-assets/js/plugins/bootstrap.bundle.min.js"></script>
                <script src="../../dist-assets/js/plugins/perfect-scrollbar.min.js"></script>
                <script src="../../dist-assets/js/scripts/script.min.js"></script>
                <script src="../../dist-assets/js/scripts/sidebar-horizontal.script.js"></script>
                <script src="../../dist-assets/js/plugins/datatables.min.js"></script>
                <script src="../../dist-assets/js/scripts/datatables.script.min.js"></script>
                <script src="../../dist-assets/js/scripts/customizer.script.min.js"></script>

</html>
<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        var dataTable = $('#employee-grid').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "order_success_json.php", // json datasource
                type: "post", // method  , by default get
                error: function() { // error handling
                    $(".employee-grid-error").html("");
                    $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#employee-grid_processing").css("display", "none");

                },
                "scrollX": true,
                "order": [[ 0, "asc" ]]
            }
        });
    });
</script>

<script type="text/javascript">
    function createManageBtn() {
        return '<button id="manageBtn" type="button" onclick="myFunc()" class="btn btn-success btn-xs">Manage</button>';
    }

    function myFunc() {
        console.log("Button was clicked!!!");
    }
</script>