<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config.php';


$sql5 = "SELECT MAX(id) AS id_run FROM production_order ";
$rs5 = $conn->query($sql5);
$row_run = $rs5->fetch_assoc();

$datetodat = date('Y-m-d');
$date = explode(" ", $datetodat);
$dat = datethai_po($date[0]);
$code_new = $row_run['id_run'] + 1;
$code = sprintf('%05d', $code_new);
$po_id = $dat . $code;
$sql = "SELECT * FROM plant";
$query = mysqli_query($conn, $sql);

$action = $_REQUEST['action'];
$po_date = $_REQUEST['po_date'];
$po_enddate = $_REQUEST['po_enddate'];

if ($action == 'add_po') {
    $product_id = $_REQUEST['productx'];
    $qty = $_REQUEST['qty'];
    $po_id = $_REQUEST['po_idd1'];
    $sqm = $_REQUEST['sqm'];
    $concrete_cal = $_REQUEST['concrete_cal'];

    echo "$product_id";
    echo "$qty";
    echo "$po_id";
    echo "$sqm";
    echo "$concrete_cal";
    echo "$action";
    // $delivery_address=$_REQUEST['delivery_address'];
    $sqlx = "SELECT * FROM production_detail   WHERE po_id='$po_id' AND product_id='$product_id' ";
    $result = mysqli_query($conn, $sqlx);
    if (mysqli_num_rows($result) > 0) { ?>
        <script>
            $(document).ready(function() {
                showAlert("ข้อมูลซ้ำไม่สามารถบันทึกได้", "alert-danger");
            });
        </script>
        <?php    } else {
        $sql = "INSERT INTO production_detail (po_id,product_id)
                                       VALUES ('$po_id','$product_id')";
        if ($conn->query($sql) === TRUE) {  ?>
            <script>
                $(document).ready(function() {
                    showAlert("บันทึกข้อมูลสำเร็จ", "alert-success");
                });
            </script>
<?php   }
    }
}



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

    <style>
        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
            font-size: 0.813rem !important;
        }
    </style>
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
            <!-- แจ้งเตือน -->
            <div id="alert_placeholder" style="z-index: 9999999; left:1px; top:1%; width:100%; position:absolute;"></div>
            <!-- ปิดการแจ้งเตือน -->
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
                                        <input type="text" name="production_id" value="<?php echo "$po_id"; ?>" class="classcus form-control" placeholder="รหัสสั่งผลิต" required>
                                    </div>
                                    <div class="viewDateClass col pr-0 ">
                                        <div class="form-group">
                                            <label for="searchSDateId">วันที่สั่งผลิต</label>
                                            <input id="po_date" class="form-control" type="date" min="2021-06-01" name="start" value="<?php echo "$po_date"; ?>" required="">
                                        </div>
                                    </div>
                                    <div class="viewDateClass col pr-0 ">
                                        <div class="form-group">
                                            <label for="searchEDateId">เช็คเขาสต๊อกภายในวันที่</label>
                                            <input id="po_enddate" class="form-control" type="date" name="end" value="<?php echo "$po_enddate"; ?>" required="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="plant"><strong>แพที่ผลิต <span class="text-danger"></span></strong></label>



                                        <select name="plant" id="plant" class="classcus custom-select " required>
                                            <option value="">เลือกแพ</option>
                                            <?php while ($result = mysqli_fetch_assoc($query)) : ?>
                                                <option value="<?= $result['ptype_id'] ?>|<?= $result['width'] ?>">แพที่<?= $result['plant_id'] ?>-<?= $result['factory'] ?></option>
                                            <?php endwhile; ?>
                                        </select>


                                    </div>

                                    <div class="row mt-12">
                                        <div class="form-group col-md-4">
                                            <label for="product"><strong>สินค้าที่จะผลิต <span class="text-danger">*</span></strong></label>
                                            <select name="productx" id="productx" class="classcus custom-select" required>
                                                <option value="">เลือกสินค้าผลิต</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="qty"><strong>จำนวนสั่งผลิต <span class="text-danger"></span></strong></label>
                                            <input type="text" name="qty" id="qty" class="classcus form-control" placeholder="จำนวนสั่งผลิต" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="sqm"><strong>พ.ท.(Sq.m) <span class="text-danger"></span></strong></label>
                                            <input type="text" name="sqm" id="sqm" class="classcus form-control" placeholder="พ.ท.(Sq.m)" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="concrete_cal"><strong>คำนวณคอนกรีต <span class="text-danger"></span></strong></label>
                                            <input type="text" name="concrete_cal" id="concrete_cal" class="classcus form-control" placeholder="คำนวณคอนกรีต" required>
                                        </div>
                                        <input type="hidden" name="po_idd1" id="po_id" value="<?php echo "$po_id"; ?>">
                                        <button class="btn btn-outline-primary ripple m-1" type="button" id="btu" style=" height: 33px; margin-top: 24px!important;">เพิ่มสินค้าสั่งผลิต</button>

                                        <!-- ============ Table Start ============= -->
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-hover text-nowrap table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>รหัสสินค้า</th>
                                                            <th>ชื่อสินค้า</th>
                                                            <th>หนา</th>
                                                            <th>กว้าง</th>
                                                            <th>ยาว</th>
                                                            <th>พื้นที่หน้าตัด</th>
                                                            <th>ขนาดลวด</th>
                                                            <th>จำนวนลวด</th>
                                                            <th>คอนกรีตคำนวณ</th>
                                                            <th>พ.ท.(Sq.m)</th>
                                                            <th>จำนวนสั่งผลิต</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT * FROM production_detail  where po_id='$po_id' order by date_create  ASC ";
                                                        $result = mysqli_query($conn, $sql);
                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                                                <tr>
                                                                    <td> <strong><?php echo $row['product_id']; ?></strong> </td>
                                                                    <td>
                                                                        <?php
                                                                        $sql3 = "SELECT * FROM product  WHERE product_id= '$row[product_id]'";
                                                                        $rs3 = $conn->query($sql3);
                                                                        $row3 = $rs3->fetch_assoc();
                                                                        echo $row3['product_name'];

                                                                        ?></td>
                                                                    <td> - </td>
                                                                    <td> <strong>3"</strong> </td>
                                                                    <td> 1.00 </td>
                                                                    <td> - </td>
                                                                    <td> 5 </td>
                                                                    <td> - </td>
                                                                    <td> 2.21 </td>
                                                                    <td> - </td>
                                                                    <td> 120 </td>
                                                                    <td>
                                                                        <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ไขข้อมูลสั่งผลิต" href="#">
                                                                            <i class="i-Pen-2 font-weight-bold"></i>
                                                                        </a>
                                                                        <a class="btn btn-outline-danger btn-sm line-height-1" data-toggle="tooltip" title="ยกเลิกรายการผลิต" href="#">
                                                                            <i class="i-Close-Window font-weight-bold"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                        <?php }
                                                        } ?>
                                                        <tr>
                                                            <td colspan="14"> &nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- ============ Table End ============= -->
                                    </div>

                                </div>

                                <hr>

                                <div class="text-right">
                                    <input class="d-none" id="addAccId" type="text" name="acc_id" value="" placeholder="">
                                    <input class="d-none" id="addActionId" type="text" name="action" value="add" placeholder="">

                                    <button id="btnAddId" class="btn btn-outline-primary d-none" type="submit">ยืนยันการสั่งผลิต</button>
                                    <button class="btn btn-primary ladda-button btn-add" data-style="expand-left">
                                        <span class="ladda-label">ยืนยันการสั่งผลิต</span>
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
    <script src="../../dist-assets/js/scripts/tooltip.script.min.js"></script>
    <script src="../../dist-assets/js/script_face.js"></script>


    <!-- ============ Form Search End ============= -->
</body>
<form class="d-none" method="POST">
    <input type="text" id="FSproductx" name="productx" value="<?php echo $FSproductx; ?>" placeholder="">
    <input type="text" id="FSqty" name="qty" value="<?php echo $qty; ?>" placeholder="">
    <input type="text" id="FSconcrete_cal" name="concrete_cal" value="<?php echo $concrete_cal; ?>" placeholder="">
    <input type="text" id="FSsqm" name="sqm" value="<?php echo $sqm; ?>" placeholder="">
    <input type="text" id="FSpo_date" name="po_date" value="<?php echo $po_date; ?>" placeholder="">
    <input type="text" id="FSpo_enddate" name="po_enddate" value="<?php echo $po_enddate; ?>" placeholder="">
    <input type="text" name="action" value="add_po">
    <input type="hidden" id="FSpo_id" name="po_idd1" value="<?php echo "$po_id"; ?>">
    <button class="btn" id="FSButtonID" type="submit"></button>
</form>
<!-- ============ Modal End ============= -->

<!-- modal load -->
<div class="modal fade" id="ModalLoadId" tabindex="-1" role="dialog" aria-labelledby="modalLoadTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center">
                    <div class="spinner-bubble spinner-bubble-primary m-5"></div>
                    <div class="mt-1">
                        Load ...
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    /* ===== search start ===== */
    function modalLoad() {
        $("#ModalLoadId").modal({
            backdrop: 'static',
            'keyboard': false,
        });
    };

    function clickNav(page) {
        modalLoad();

        $("#FSPageId").val(page);
        $("#FSButtonID").click();
    }

    $("#btu").click("change", function() {
        modalLoad();

        let name = $("#qty").val();
        let column = $("#productx").val();
        let po_id = $("#po_id").val();
        let sqm = $("#sqm").val();
        let concrete_cal = $("#concrete_cal").val();
        let po_date = $("#po_date").val();
        let po_enddate = $("#po_enddate").val();
        console.log('xxx', name)
        $("#FSqty").val(name);
        $("#FSproductx").val(column);
        $("#FSpo_id").val(po_id);
        $("#FSsqm").val(sqm);
        $("#FSconcrete_cal").val(concrete_cal);
        $("#FSpo_date").val(po_date);
        $("#FSpo_enddate").val(po_enddate);
        $("#FSButtonID").click();

    });
    /* ===== search end ===== */

    //click next link
    $(".linkLoadModalNext").on('click', function() {
        $("#ModalLoadId").modal({
            backdrop: 'static',
            'keyboard': false,
        });
    });
</script>

</html>