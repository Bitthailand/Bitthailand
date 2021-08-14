<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config.php';
$product_id = $_REQUEST['product_id'];

$action = $_REQUEST['action'];
if ($action == 'edit') {
    $edit_id = $_REQUEST['edit_id'];
    $type_id = $_REQUEST['type_id'];
    $product_name = $_REQUEST['product_name'];
    $width = $_REQUEST['width'];
    $size = $_REQUEST['size'];
    $dia_size = $_REQUEST['dia_size'];
    $dia_count = $_REQUEST['dia_count'];
    $units = $_REQUEST['units'];
    $unit_price = $_REQUEST['unit_price'];
    $spacial = $_REQUEST['spacial'];
    $fac1_stock = $_REQUEST['fac1_stock'];
    $fac2_stock = $_REQUEST['fac2_stock'];
    $remarks = $_REQUEST['remarks'];
    $thickness = $_REQUEST['thickness'];
    $area = $_REQUEST['area'];
    $sql = "UPDATE product SET ptype_id='$type_id',product_name='$product_name',
    width='$width',size='$size',dia_size='$dia_size',dia_count='$dia_count',
    units='$units',unit_price='$unit_price',spacial='$spacial',fac1_stock ='$fac1_stock',
    fac2_stock='$fac2_stock',remarks='$remarks',thickness='$thickness',area='$area'
      where product_id='$edit_id'";
 
    if ($conn->query($sql) === TRUE) {  ?>
        <script>
            $(document).ready(function() {
                showAlert("แก้ไขข้อมูลสินค้าสำเร็จ", "alert-success");
            });
        </script>
<?php   }
}


if ($action == 'add_type') {
    $ptype_id = $_REQUEST['ptype_id'];
    $ptype_name = $_REQUEST['ptype_name'];

    $sqlx = "SELECT * FROM product_type WHERE ptype_id='$ptype_id' ";
    $result = mysqli_query($conn, $sqlx);
    if (mysqli_num_rows($result) > 0) { ?>
        <script>
            $(document).ready(function() {
                showAlert("ข้อมูลประเภทสินค้าซ้ำไม่สามารถบันทึกได้", "alert-danger");
            });
        </script>
        <?php    } else {
        $sql = "INSERT INTO product_type (ptype_id,ptype_name)
                   VALUES ('$ptype_id','$ptype_name')";
        if ($conn->query($sql) === TRUE) {  ?>
            <script>
                $(document).ready(function() {
                    showAlert("บันทึกประเภทสินค้ามูลสำเร็จ", "alert-success");
                });
            </script>
        <?php   }
    }
}
if ($action == 'add_unit') {
    $unit_name = $_REQUEST['unit_name'];
    $sqlx = "SELECT * FROM unit  WHERE unit_name='$unit_name' ";
    $result = mysqli_query($conn, $sqlx);
    if (mysqli_num_rows($result) > 0) { ?>
        <script>
            $(document).ready(function() {
                showAlert("ข้อมูลหน่วยนับซ้ำไม่สามารถบันทึกได้", "alert-danger");
            });
        </script>
        <?php    } else {
        $sql = "INSERT INTO unit (unit_name)
                   VALUES ('$unit_name')";
        if ($conn->query($sql) === TRUE) {  ?>
            <script>
                $(document).ready(function() {
                    showAlert("บันทึกหน่วยนับสำเร็จ", "alert-success");
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

            <?php $sql5 = "SELECT * FROM product  WHERE product_id = '$product_id'";
            $rs5 = $conn->query($sql5);
            $row = $rs5->fetch_assoc(); ?>
            <div class="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="tab-content" id="myTabContent">
                                <form class="tab-pane fade active show" method="post">

                                    <div class="border-bottom text-primary">
                                        <div class="card-title">แก้ไขข้อมูลสินค้า</div>
                                    </div>
                                    <div class="row mt-4">
                                    </div>
                                    <div class="form-row mt-3">

                                        <div class="form-group col-md-2">
                                            <label for="product_id"><strong>รหัสสินค้า <span class="text-danger"></span></strong></label>
                                            <input type="text" name="product_id" value="<?php echo $row['product_id']; ?>" class="classcus form-control" placeholder="รหัสสินค้า" disabled>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="product_id"><strong>ชื่อสินค้า <span class="text-danger"></span></strong></label>
                                            <input type="text" name="product_name" value="<?php echo $row['product_name']; ?>" class="classcus form-control" placeholder="ชื่อสินค้า" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="product_type"><strong>ประเภท <span class="text-danger"></span></strong></label>


                                            <select class="classcus custom-select" name="type_id" id="type_id" required>
                                                <?php
                                                $sql6 = "SELECT *  FROM  product_type  order by ptype_id DESC ";
                                                $result6 = mysqli_query($conn, $sql6);
                                                if (mysqli_num_rows($result6) > 0) {
                                                    while ($row6 = mysqli_fetch_assoc($result6)) {
                                                ?>
                                                        <option value="<?php echo $row6['ptype_id'] ?>" <?php
                                                                                                        if (isset($row['ptype_id']) && ($row['ptype_id'] == $row6['ptype_id'])) {
                                                                                                            echo "selected"; ?>>
                                                        <?php echo "$row6[ptype_name]";
                                                                                                        } else {      ?>
                                                        <option value="<?php echo $row6['ptype_id']; ?>"> <?php echo $row6['ptype_name'];  ?>
                                                        <?php } ?>
                                                        </option>
                                                <?php  }
                                                }  ?>

                                            </select>
                                        </div>
                                        <button class="btn btn-outline-primary ripple m-1" type="button" data-toggle="modal" data-target="#modalproducttype" style=" height: 33px; margin-top: 24px!important;">เพิ่มประเภทสินค้า</button>
                                    </div>
                                    <div class="form-row mt-3">
                                        <div class="form-group col-md-2">
                                            <label for="thickness"><strong>ความหนา <span class="text-danger"></span></strong></label>
                                            <input type="number"  step="0.01"  name="thickness" value="<?php echo $row['thickness']; ?>" class="classcus form-control" placeholder="ขนาดความหนา" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="product_name"><strong>หน้ากว้าง <span class="text-danger"></span></strong></label>
                                            <input type="number" step="0.01"  name="width" value="<?php echo $row['width']; ?>" class="classcus form-control" placeholder="หน้ากว้าง" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="product_name"><strong>ความยาว<span class="text-danger"></span></strong></label>
                                            <input type="number" step="0.01"  name="size" value="<?php echo $row['size']; ?>" class="classcus form-control" placeholder="ขนาดความยาว" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="area"><strong>พื้นที่หน้าตัดเสาเข็มไอ <span class="text-danger"></span></strong></label>
                                            <input type="number"  step="0.01"  name="area" value="<?php echo $row['area']; ?>" class="classcus form-control" placeholder="พื้นที่หน้าตัดเสาเข็มไอ" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="accNameId"><strong>ขนาดลวด <span class="text-danger"></span></strong></label>
                                            <input type="number" value="<?php echo $row['dia_size']; ?>" name="dia_size" step="0.01"  class="classcus form-control" placeholder="ขนาดลวด" required>
                                        </div>
                                    </div>


                                    <div class="form-row mt-3">
                                        <div class="form-group col-md-2">
                                            <label for="phone"><strong>จำนวนลวด <span class="text-danger"></span></strong></label>
                                            <input type="number" name="dia_count" value="<?php echo $row['dia_count']; ?>" class="classcus form-control" placeholder="จำนวนเส้นลวด" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="accAddressId"><strong>ราคา <span class="text-danger"></span></strong></label>
                                            <input type="number" name="unit_price" step="0.01"   value="<?php echo $row['unit_price']; ?>" class="classcus form-control" placeholder="ราคาต่อหน่วย" required="">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="unit"><strong>หน่วยนับ <span class="text-danger"></span></strong></label>
                                            <select class="classcus custom-select" name="units" value="<?php echo $row['units']; ?>" required>
                                                <?php
                                                $sql6 = "SELECT *  FROM  unit order by unit_name DESC ";
                                                $result6 = mysqli_query($conn, $sql6);
                                                if (mysqli_num_rows($result6) > 0) {
                                                    while ($row6 = mysqli_fetch_assoc($result6)) {
                                                ?>
                                                        <option value="<?php echo $row6['id'] ?>" <?php if (isset($row['units']) && ($row['units'] == $row6['id'])) {
                                                         echo "selected"; ?>>
                                                        <?php echo "$row6[unit_name]"; } else {      ?>
                                                        <option value="<?php echo $row6['id']; ?>"> <?php echo $row6['unit_name'];  ?>
                                                        <?php } ?>
                                                        </option>
                                                <?php  }
                                                }  ?>

                                            </select>

                                        </div>
                                        <button class="btn btn-outline-primary ripple m-1" type="button" data-toggle="modal" data-target="#modal2" style=" height: 33px; margin-top: 24px!important;">เพิ่มหน่วยนับ</button>
                                        <div class="form-group col-md-4">
                                            <label for="tax_number"><strong>ข้อมูลพิเศษ <span class="text-danger"></span></strong></label>
                                            <input type="text" name="spacial" value="<?php echo $row['spacial']; ?>" class="classcus form-control" placeholder="ข้อมูลเพิ่มเติม" autocomplete="off">
                                        </div>

                                    </div>

                                    <div class="form-row mt-3">
                                        <div class="form-group col-md-4">
                                            <label for="delivery_address"><strong>หมายเหตุ <span class="text-danger"></span></strong></label>
                                            <input type="text" name="remarks" value="<?php echo $row['remarks']; ?>" class="classcus form-control" placeholder="หมายเหตุ">
                                        </div>


                                        <div class="form-group col-md-3">
                                            <label for="accAddressId"><strong>สต๊อกโรงงาน 1 <span class="text-danger"></span></strong></label>
                                            <input type="number" name="fac1_stock" value="<?php echo $row['fac1_stock']; ?>" class="classcus form-control" placeholder="สต๊อกโรงงาน 1" required="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="accAddressId"><strong>สต๊อกโรงงาน 2 <span class="text-danger"></span></strong></label>
                                            <input type="number" name="fac2_stock" value="<?php echo $row['fac2_stock']; ?>" class="classcus form-control" placeholder="สต๊อกโรงงาน 1" required="">
                                        </div>
                                    </div>
                                    <hr>
                                   
                                    <div class="text-right">
                                        
                                        <input type="hidden" name="edit_id" value="<?php echo $row['product_id']; ?>">
                                        <input type="hidden" name="action" value="edit">
                                        <button class="btn btn-primary ladda-button btn-add" data-style="expand-left" type="submit" >
                                            <span class="ladda-label">ยืนยันการแก้ไขสินค้า</span>
                                        </button>
                                        <a class="btn btn-outline-danger m-1" href="/inventorylist.php" type="button">กลับไปหน้าสต๊อกสินค้า</a>
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
                    <a class="btn btn-primary text-white btn-rounded" href="https://themeforest.net/item/gull-bootstrap-laravel-admin-dashboard-template/23101970" target="_blank">Buy Gull HTML</a>
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
    <!--  -->


    <!-- Modal เพิ่มประเภทสินค้า -->

    <div class="modal fade" id="modalproducttype" tabindex="-1" role="dialog" aria-labelledby="modalproducttypeTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">

            <div class="modal-content">
                <form method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalproducttypeTitle-2">เพิ่มประเภทสินค้า</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="type_id"><strong>รหัสประเภท <span class="text-danger"></span></strong></label>
                                <input type="text" name="ptype_id" class="classcus form-control" placeholder="รหัสประเภท" required="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="type_name"><strong>ชื่อประเภท <span class="text-danger"></span></strong></label>
                                <input type="text" name="ptype_name" class="classcus form-control" placeholder="รหัสประเภท" required="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="add-data"><span class="glyphicon glyphicon-plus"></span> Add</button>
                            <input type="hidden" name="action" value="add_type">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>


    <!-- Modal เพิ่มหน่วยนับ -->

    <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modalproducttypeTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">

            <div class="modal-content">
                <form method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalproducttypeTitle-2">เพิ่มหน่วยนับ</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-10">
                                <label for="type_id"><strong>ชื่อหน่วยนับ <span class="text-danger"></span></strong></label>
                                <input type="text" name="unit_name" class="classcus form-control" placeholder="ชื่อหน่วยนับ" required="">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="add-data1"><span class="glyphicon glyphicon-plus"></span> Add</button>
                            <input type="hidden" name="action" value="add_unit">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
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

    <!-- Modal เพิ่มประเภทสินค้า -->

    <div class="modal fade" id="modalproducttype" tabindex="-1" role="dialog" aria-labelledby="modalproducttypeTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">

            <div class="modal-content">
                <form method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalproducttypeTitle-2">เพิ่มประเภทสินค้า</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="type_id"><strong>รหัสประเภท <span class="text-danger"></span></strong></label>
                                <input type="text" name="ptype_id" class="classcus form-control" placeholder="รหัสประเภท" required="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="type_name"><strong>ชื่อประเภท <span class="text-danger"></span></strong></label>
                                <input type="text" name="ptype_name" class="classcus form-control" placeholder="รหัสประเภท" required="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="add-data"><span class="glyphicon glyphicon-plus"></span> Add</button>
                            <input type="hidden" name="action" value="add_type">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>


    <!-- Modal เพิ่มหน่วยนับ -->

    <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modalproducttypeTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">

            <div class="modal-content">
                <form method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalproducttypeTitle-2">เพิ่มหน่วยนับ</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-10">
                                <label for="type_id"><strong>ชื่อหน่วยนับ <span class="text-danger"></span></strong></label>
                                <input type="text" name="unit_name" class="classcus form-control" placeholder="ชื่อหน่วยนับ" required="">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="add-data1"><span class="glyphicon glyphicon-plus"></span> Add</button>
                            <input type="hidden" name="action" value="add_unit">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

</html>