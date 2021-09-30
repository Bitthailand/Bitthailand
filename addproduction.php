<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
$emp_id=$_SESSION["username"]; 
include './include/connect.php';
include './include/config.php';

$action = $_REQUEST['action'];
$status_po = $_REQUEST['status_po'];
$po_id = $_REQUEST['FMpo_id'];
$date_month = date('Y-m');
if ($status_po == 'new') {
    // echo"xxd";
    $sql5 = "SELECT COUNT(id) AS id_run FROM production_order where date_month='$date_month' ";
    $rs5 = $conn->query($sql5);
    $row_run = $rs5->fetch_assoc();
    $datetodat = date('Y-m-d');
    $date = explode(" ", $datetodat);
    $dat = datethai_po($date[0]);
    // echo"$row_run[id_run]";
    $code_new = $row_run['id_run'] + 1;
    $code = sprintf('%02d', $code_new);
    $po_idx = $dat . $code;
    $po_id = $_REQUEST['FMpo_id'];
    // echo"$po_idx";
    $sqlx = "SELECT * FROM production_order   WHERE po_id='$po_idx' ";
    $result = mysqli_query($conn, $sqlx);
    if (mysqli_num_rows($result) > 0) {
?>
        <script>
            $(document).ready(function() {
                showAlert("รหัสใบสั่งชื้อซ้ำ", "alert-danger");
                window.location = 'addproduction.php'
            });
        </script>
        <?php } else {


        $_SESSION["po_id"] = $po_idx;
    }
}
$po_id = $_SESSION["po_id"];
$emp_id = $_SESSION["username"];
// echo "$po_id";
// echo "$status_po";
// echo "$po_id";

$po_date = $_REQUEST['po_date'];
$po_enddate = $_REQUEST['po_enddate'];

// ตัดคำแพ
$plant = $_REQUEST['plant'];
$plant_id = explode("|", $plant);
$plantx = $plant_id[2];
$plant_w = $plant_id[1];
$plant_ptype = $plant_id[0];
$concrete_cal = $_REQUEST['concrete_cal'];
$productx = $_REQUEST['productx'];
$sqm = $_REQUEST['sqm'];
$sqm1 = $_REQUEST['sqm1'];
$concrete_cal1 = $_REQUEST['concrete_cal1'];
$width1 = $_REQUEST['width1'];
$size1 = $_REQUEST['size1'];
$thickness1 = $_REQUEST['thickness1'];
$area1 = $_REQUEST['area1'];
// echo "$productx";
// echo "$plant";
$po_idx = $_REQUEST['po_idx'];
// echo "$po_idx";
// =============================

// =============================
// 
if ($action == 'add_po') {
    $productx = $_REQUEST['productx'];
    $qty = $_REQUEST['qty'];
    $po_idx = $_REQUEST['po_idd1'];
    $sqm = $_REQUEST['sqm'];
    $concrete_cal = $_REQUEST['concrete_cal'];
    $plant = $_REQUEST['plant'];
    $sql5 = "SELECT * FROM product where  id='$productx' ";
    $rs5 = $conn->query($sql5);
    $row5 = $rs5->fetch_assoc();
    $plant_id = explode("|", $plant);
    $plantx = $plant_id[2];
    $sqlx = "SELECT * FROM production_detail   WHERE product_id='$row5[product_id]' AND plant_id ='$plantx' AND po_id='$po_idx'";
    $result = mysqli_query($conn, $sqlx);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $qtyx = $row['qty'] + $qty;
            $sqmx = $row['sqm'] + $sqm;
            $concrete_calx = $row['concrete_cal'] + $concrete_cal;

            $sql = "UPDATE production_detail    SET qty='$qtyx',sqm='$sqmx',concrete_cal='$concrete_calx',employee_id='$emp_id',status_button='0' where product_id='$row5[product_id]'  AND plant_id ='$plantx' AND po_id='$po_idx'";


            if ($conn->query($sql) === TRUE) {  ?>
                <script>
                    $(document).ready(function() {
                        showAlert("บันทึกข้อมูลสำเร็จxx", "alert-success");
                    });
                </script>
            <?php }
        }
    } else {
        // echo"xxx";
        $sql = "INSERT INTO production_detail (po_id,product_id,qty,sqm,plant_id,concrete_cal,status_button,employee_id)
                                       VALUES ('$po_idx','$row5[product_id]','$qty','$sqm','$plant_id[2]','$concrete_cal','0','$emp_id')";
        if ($conn->query($sql) === TRUE) {  ?>
            <script>
                $(document).ready(function() {
                    showAlert("บันทึกข้อมูลสำเร็จ", "alert-success");
                });
            </script>
        <?php   }
    }
}

if ($action == 'edit') {
    $edit_id = $_REQUEST['edit_id'];
    $qty = $_REQUEST['qty2'];
    $sqm = $_REQUEST['sqm2'];
    $concrete_cal = $_REQUEST['concrete_cal2'];

    // echo"$edit_id ";
    // echo"$qty ";
    // echo"$sqm";
    // echo"$concrete_cal";
    $sql = "UPDATE production_detail    SET qty='$qty',sqm='$sqm',concrete_cal='$concrete_cal'  where id='$edit_id'";
    if ($conn->query($sql) === TRUE) {  ?>
        <script>
            $(document).ready(function() {
                showAlert("แก้ไขข้อมูลผลิตสินค้าสำเร็จ", "alert-success");
            });
        </script>
    <?php   }
}

if ($action == 'add') {
    $production_id = $_REQUEST['production_id'];
    $po_date = $_REQUEST['start'];
    $po_enddate = $_REQUEST['end'];
    // $plant_id= $_REQUEST['plantx']; 

    // $delivery_address=$_REQUEST['delivery_address'];
    $sqlx = "SELECT * FROM production_order  WHERE po_id='$production_id' ";
    $result = mysqli_query($conn, $sqlx);
    if (mysqli_num_rows($result) > 0) { ?>
        <script>
            $(document).ready(function() {
                showAlert("ข้อมูลใบสั่งผลิตซ้ำไม่สามารถบันทึกได้", "alert-danger");
            });
        </script>
        <?php    } else {
        $sql = "INSERT INTO production_order  (po_id,po_date,po_enddate,employee_id,status_button,date_month)
                   VALUES ('$production_id','$po_date','$po_enddate','$emp_id','1','$date_month')";
        $sql2 = "UPDATE production_detail    SET status_button='1' where po_id='$production_id'";
        if ($conn->query($sql2) === TRUE) {
        }
        if ($conn->query($sql) === TRUE) {  ?>
            <script>
                $(document).ready(function() {
                    showAlert("บันทึกข้อมูลสำเร็จ", "alert-success");
                });
            </script>
        <?php   }
    }
}
if ($action == 'del') {
    $del_id = $_REQUEST['del_id'];

    $sql = "DELETE FROM production_detail  WHERE  id='$del_id' ";
    if ($conn->query($sql) === TRUE) { ?>
        <script>
            $(document).ready(function() {
                showAlert("ลบรายการสำเร็จ", "alert-primary");
            });
        </script>
    <?php  } else { ?>
        <script>
            $(document).ready(function() {
                showAlert("ไม่สามารถลบรายการได้", "alert-danger");
            });
        </script>
<?php }
}
?>
<script language="JavaScript">
    function fncASum() {
        {
            let sqmx = $("#sqm1").val();
            let qtyx = $("#qty").val();
            let concrete_calx = $("#concrete_cal1").val();

            let width1x = $("#width1").val();
            let size1x = $("#size1").val();
            let thickness1x = $("#thickness1").val();
            let area1 = $("#area1").val();


            var sum_sqm = (width1x * size1x * qtyx * 1000 / 1000).toFixed(3);
            if (area1 !== 'undefined') {
                var sum_concrete = (width1x * size1x * thickness1x * qtyx * 1000 / 1000).toFixed(3);
            }
            if (area1 >= 1) {
                var sum_concrete = (width1x * size1x * thickness1x * area1 * qtyx * 1000 / 1000).toFixed(3);
            }
            // var sum_concrete = concrete_calx  * qtyx;
            console.log('=========คำนวณตรงๆ=====================');
            console.log('sqm', sqmx);
            console.log('concrete', concrete_calx);
            console.log('qty', qtyx);
            console.log('==========ค่าคำนวณ=====');
            console.log('width1x_num', width1x);
            console.log('size1x_num', size1x);
            console.log('thickness1x_num', thickness1x);
            console.log('area1', area1);
            console.log('==========จขบ=====');
            console.log('sqm', sqmx);
            console.log('sum_sqm', sum_sqm);
            console.log('sum_concrete', sum_concrete);
            console.log('=============================');
            $("#sqm").val(sum_sqm);
            $("#concrete_cal").val(sum_concrete);

            // console.log('SQM2',qty);
            // document.frmAMain['sqm'].value = (document.frmAMain['qty'].value * sqmx * 1000 / 1000).toFixed(3);
            // document.frmAMain['concrete_cal'].value = (document.frmAMain['qty'].value * concrete_calx * 1000 / 1000).toFixed(3);

        }

        // document.frmAMain['sqm'].value;
        // document.frmAMain['concrete_cal'].value;

        // document.frmAMain.total.value = Asum;
    }
</script>

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
                            <form name='frmAMain' id='inputform2' class="tab-pane fade active show" method="post">
                                <div class="border-bottom text-primary">
                                    <div class="card-title">เพิ่มรายการสั่งผลิตสินค้า(code not automatic)</div>
                                </div>
                                <div class="form-row mt-3">
                                    <div class="form-group col-md-2">
                                        <label for="production_id"><strong>รหัสสั่งผลิต <span class="text-danger"></span></strong></label>
                                        <input type="text" id="Mpo_id" name="production_id" value="<?php echo "$po_id"; ?>" class="classcus form-control" placeholder="รหัสสั่งผลิต" required>
                                    </div>
                                    <div class="viewDateClass col pr-0 ">
                                        <div class="form-group">
                                            <label for="searchSDateId">วันที่สั่งผลิต</label>
                                            <input id="po_date" class="form-control" type="date" min="2021-06-01" name="start" value="<?php echo "$po_date"; ?>" required="">
                                        </div>
                                    </div>
                                    <div class="viewDateClass col pr-0 ">
                                        <div class="form-group">
                                            <label for="searchEDateId">เช็คเข้าสต๊อกภายในวันที่</label>
                                            <input id="po_enddate" class="form-control" type="date" name="end" value="<?php echo "$po_enddate"; ?>" required="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="plant"><strong>แพที่ผลิต <span class="text-danger"></span></strong></label>

                                        <?php
                                        $plant = $_REQUEST['plant'];
                                        if (empty($plant)) {
                                        }
                                        ?>
                                        <select name="plant" id="plant" class="classcus custom-select " required>
                                            <?php
                                            $sql6 = "SELECT *  FROM plant   order by plant_id  ASC ";
                                            $result6 = mysqli_query($conn, $sql6);
                                            if (mysqli_num_rows($result6) > 0) {
                                                while ($row6 = mysqli_fetch_assoc($result6)) {
                                            ?>
                                                    <option value="<?= $row6['ptype_id'] ?>|<?= $row6['width'] ?>|<?= $row6['plant_id'] ?>" <?php if (isset($plantx) && ($plantx == $row6['plant_id'])) {
                                                                                                                                                echo "selected"; ?>>
                                                        แพที่<?= $row6['plant_id'] ?>(<?= $row6['remark'] ?>)-<?= $row6['factory'] ?>
                                                    <?php  } else {      ?>
                                                    <option value="<?= $row6['ptype_id'] ?>|<?= $row6['width'] ?>|<?= $row6['plant_id'] ?>"> แพที่<?= $row6['plant_id'] ?>(<?= $row6['remark'] ?>)-<?= $row6['factory'] ?>
                                                    <?php } ?>
                                                    </option>
                                            <?php  }
                                            }  ?>

                                        </select>
                                    </div>
                                    <?php if ($status_po == 'update') {
                                    } else { ?>
                                        <div class="row mt-12">
                                            <div class="form-group col-md-4">
                                                <label for="product"><strong>สินค้าที่จะผลิต <span class="text-danger">*</span></strong></label>
                                                <?php
                                                $plant = $_REQUEST['plant'];
                                                if (empty($plant)) {

                                                ?>
                                                    <select name="productx" id="productx" class="classcus custom-select" data-index="1">
                                                        <option value="">เลือกสินค้าผลิต</option>
                                                    </select>

                                                <?php } else { ?>
                                                    <select name="productx" id="productx" class="classcus custom-select " required>
                                                        <?php
                                                        $sql6 = "SELECT *  FROM product where ptype_id='$plant_ptype'  AND width='$plant_w'  order by product_id  ASC ";
                                                        $result6 = mysqli_query($conn, $sql6);
                                                        if (mysqli_num_rows($result6) > 0) {
                                                            while ($row6 = mysqli_fetch_assoc($result6)) {
                                                        ?>
                                                                <option value="<?= $row6['id'] ?>" <?php if (isset($productx) && ($productx == $row6['id'])) {
                                                                                                        echo "selected"; ?>>
                                                                    <?php echo $row6['product_id'] .  $row6['product_name'] . '  หนา' . $row6['thickness'] . '  ขนาดลวด' . $row6['dia_size'] . '  จำนวน' . $row6['dia_count'];    ?>
                                                                <?php  } else {      ?>
                                                                <option value="<?= $row6['id'] ?>"> <?php echo $row6['product_id'] .  $row6['product_name'] . '  หนา' . $row6['thickness'] . '  ขนาดลวด' . $row6['dia_size'] . '  จำนวน' . $row6['dia_count'];    ?>
                                                                <?php } ?>
                                                                </option>
                                                        <?php  }
                                                        }  ?>
                                                    </select>
                                                <?php } ?>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="qty"><strong>จำนวนสั่งผลิต <span class="text-danger"></span></strong></label>
                                                <input type="text" name="qty" id="qty" value="<?= $qty ?>" class="classcus form-control" placeholder="จำนวนสั่งผลิต" data-index="2" onKeyUp="fncASum();">
                                                <input type="hidden" name="sqm1" id="sqm1" value="<?= $sqm1 ?>" class="classcus form-control" placeholder="จำนวนสั่งผลิต" data-index="2">
                                                <input type="hidden" name="concrete_cal1" id="concrete_cal1" value="<?php echo "$concrete_cal1"; ?>" class="classcus form-control" placeholder="จำนวนสั่งผลิต" data-index="2">
                                                <input type="hidden" name="width1" id="width1" value="<?php echo "$width1"; ?>">
                                                <input type="hidden" name="size1" id="size1" value="<?php echo "$size1"; ?>">
                                                <input type="hidden" name="thickness1" id="thickness1" value="<?php echo "$thickness1"; ?>">
                                                <input type="hidden" name="area1" id="area1" value="<?php echo "$area1"; ?>">


                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="sqm"><strong>พ.ท.(Sq.m) <span class="text-danger"></span></strong></label>

                                                <input type="text" name="sqm" id="sqm" value="<?= $sqm ?>" class="classcus form-control" placeholder="พ.ท.(Sq.m)">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="concrete_cal"><strong>คำนวณคอนกรีต <span class="text-danger"></span></strong></label>
                                                <input type="text" name="concrete_cal" id="concrete_cal" value="<?php echo "$concrete_cal"; ?>" class="classcus form-control" placeholder="คำนวณคอนกรีต">
                                            </div>
                                            <input type="hidden" name="po_idd1" id="po_id" value="<?php echo "$po_id"; ?>">
                                            <button class="btn btn-outline-primary ripple m-1" type="button" id="btu" style=" height: 33px; margin-top: 24px!important;">เพิ่มสินค้าสั่งผลิต</button>
                                        <?php } ?>
                                        <!-- ============ Table Start ============= -->
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-hover text-nowrap table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>แพที่</th>
                                                            <th>รหัสสินค้า</th>
                                                            <th>ชื่อสินค้า</th>

                                                            <th>หนา</th>
                                                            <th>กว้าง</th>
                                                            <th>ยาว</th>
                                                            <th>พื้นที่หน้าตัด</th>
                                                            <th>ขนาดลวด</th>
                                                            <th>จำนวนลวด</th>

                                                            <th>พ.ท.(Sq.m)</th>
                                                            <th>คอนกรีตคำนวณ</th>
                                                            <th>จำนวนสั่งผลิต</th>
                                                            <?php if ($status_po == 'update') {
                                                            } else { ?> <th>Action</th> <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT * FROM production_detail  where po_id='$po_id' order by date_create  ASC ";
                                                        $result = mysqli_query($conn, $sql);
                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                                                <tr>
                                                                    <td> <?php echo $row['plant_id']; ?></td>
                                                                    <td> <strong><?php echo $row['product_id']; ?></strong> </td>
                                                                    <td>
                                                                        <?php
                                                                        $sql3 = "SELECT * FROM product  WHERE product_id= '$row[product_id]'";
                                                                        $rs3 = $conn->query($sql3);
                                                                        $row3 = $rs3->fetch_assoc();
                                                                        echo $row3['product_name'];

                                                                        ?></td>

                                                                    <td> <?php echo $row3['thickness'];
                                                                     $sumthickness = $sumthickness+ $row3['thickness'];
                                                                    ?></td>
                                                                    <td> <strong><?php echo $row3['width'];
                                                                     $sumwidth = $sumwidth+ $row3['width'];
                                                                    ?></strong> </td>
                                                                    <td><?php echo $row3['size']; 
                                                                    $sumsize = $sumsize+ $row3['size'];
                                                                    ?></td>
                                                                    <td><?php echo $row3['area']; 
                                                                     $sumarea = $sumarea+ $row3['area'];
                                                                    ?></td>
                                                                    <td> <?php echo $row3['dia_size']; 
                                                                    $sumdia_size = $sumdia_size+ $row3['dia_size'];
                                                                    ?></td>
                                                                    <td> <?php echo $row3['dia_count'];
                                                                      $sumdia_count = $sumdia_count+ $row3['dia_count'];
                                                                    ?> </td>

                                                                    <td> <?php echo $row['sqm'];
                                                                            $sumsqm = $sumsqm + $row['sqm'];
                                                                            ?> </td>
                                                                    <td> <?php echo $row['concrete_cal'];
                                                                            $sumconcrete_cal = $sumconcrete_cal + $row['concrete_cal'];
                                                                            ?></td>
                                                                    <td><?php echo $row['qty'];
                                                                        $sumqty = $sumqty + $row['qty']; ?></td>

                                                                    <?php if ($status_po == 'update') {
                                                                    } else { ?> <td>

                                                                            <button type="button" class="btn btn-outline-success btn-sm line-height-1" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#Modaledit" id="edit_po"> <i class="i-Pen-2 font-weight-bold"></i> </button>

                                                                            <button type="button" class="btn btn-outline-danger btn-sm line-height-1" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#myModal_del" data-toggle="tooltip" title="ยกเลิกรายการผลิต"> <i class="i-Close-Window font-weight-bold"></i> </button>

                                                                        </td> <?php } ?>
                                                                </tr>
                                                        <?php }
                                                        } ?>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td  class="text-left">รวม</td>
                                                            <td><?=$sumthickness?></td>
                                                            <td><?=$sumwidth?></td>
                                                            <td><?=$sumsize?></td>
                                                            <td><?= $sumarea?></td>
                                                            <td><?=$sumdia_size?></td>
                                                            <td><?=$sumdia_count?></td>
                                                            
                                                            <td><?=$sumsqm?></td>
                                                            <td><?= $sumconcrete_cal ?></td>
                                                            <td><?= $sumqty ?></td>
                                                            <td></td>
                                                          
                                                        </tr>
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

                                    <?php if ($action == 'add') { ?>
                                        <a class="btn btn-primary ladda-button btn-add" href="/productionprint.php?po_id=<?= $po_id ?>" target="_blank" type="button">พิมพ์ใบสั่งผลิต</a>

                                    <?php } else {  ?>
                                        <input type="hidden" name="action" value="add">
                                        <input type="hidden" name="status_po" value="update">
                                        <input type="hidden" name="po_id" value="<?= $po_id ?>">
                                        <button id="btnAddId" class="btn btn-outline-primary d-none" type="submit">ยืนยันการสั่งผลิต</button>
                                        <button id="btu1" class="btn btn-primary ladda-button btn-add" data-style="expand-left">
                                            <span class="ladda-label">ยืนยันการสั่งผลิต</span>
                                        </button>
                                    <?php } ?>
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
    <input type="text" id="FSconcrete_cal1" name="concrete_cal1" value="<?php echo $concrete_cal1; ?>" placeholder="">
    <input type="text" id="FSwidth1" name="width1" value="<?php echo $width1; ?>" placeholder="">
    <input type="text" id="FSsize1" name="size1" value="<?php echo $size1; ?>" placeholder="">
    <input type="text" id="FSthickness1" name="thickness1" value="<?php echo $thickness1; ?>" placeholder="">
    <input type="text" id="FSarea1" name="area1" value="<?php echo $area1; ?>" placeholder="">
    <input type="text" id="FSsqm1" name="sqm1" value="<?php echo $sqm1; ?>" placeholder="">
    <input type="text" id="FSpo_date" name="po_date" value="<?php echo $po_date; ?>" placeholder="">
    <input type="text" id="FSpo_enddate" name="po_enddate" value="<?php echo $po_enddate; ?>" placeholder="">
    <input type="text" id="FSplant" name="plant" value="<?php echo $po_enddate; ?>" placeholder="">
    <input type="text" name="action" value="add_po">
    <input type="hidden" name="status_po" value="update_pro">
    <input type="hidden" id="FSpo_id" name="po_idd1" value="<?php echo "$po_id"; ?>">
    <button class="btn" id="FSButtonID" type="submit"></button>
</form>

<form class="d-none" method="POST">
    <input type="hidden" name="status_po" value="Mnew">
    <input type="hidden" id="FMpo_id" name="FMpo_id" value="<?php echo "$Mpo_id"; ?>">
    <button class="btn" id="MButtonID" type="submit"></button>
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



<div id="Modaledit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fa fa-pencil"></i>
                    แก้ไขข้อมูลสินค้าผลิต</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- mysql data will be load here -->
                <div id="dynamic-content"></div>
            </div>



        </div>
    </div>
</div>


<!-- Modal DEL  -->
<div class="modal fade" id="myModal_del" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fa fa-pencil"></i> DELETE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputEmail4"><strong>คุณต้องการลบข้อมูลใช่หรือไม่
                                    <span>*</span></strong></label>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="action" value="del">
                        <input type="hidden" name="del_id" id="del_id" value="">
                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span>
                            DELETE</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal_end -->
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
    $("#Mpo_id").on("change", function() {
        // modalLoad();
        let Mpo_id = $("#Mpo_id").val();
        $("#FMpo_id").val(Mpo_id);
        console.log('mpo_Id', Mpo_id)
        $("#MButtonID").click();
    });
    $("#btu").click("change", function() {
        modalLoad();
        let name = $("#qty").val();
        let productx = $("#productx").val();
        let po_id = $("#po_id").val();
        let sqm = $("#sqm").val();
        let sqm1 = $("#sqm1").val();
        let width1 = $("#width1").val();
        let size1 = $("#size1").val();
        let thickness1 = $("#thickness1").val();
        let area1 = $("#area1").val();

        let concrete_cal = $("#concrete_cal").val();
        let concrete_cal1 = $("#concrete_cal1").val();
        let po_date = $("#po_date").val();
        let po_enddate = $("#po_enddate").val();
        let plant = $("#plant").val();
        console.log('xxx', name)
        $("#FSqty").val(name);
        $("#FSproductx").val(productx);
        $("#FSpo_id").val(po_id);
        $("#FSsqm").val(sqm);
        $("#FSsqm1").val(sqm1);
        $("#FSwidth1").val(width1);
        $("#FSsize1").val(size1);
        $("#FSthickness1").val(thickness1);
        $("#FSarea1").val(area1);

        $("#FSconcrete_cal").val(concrete_cal);
        $("#FSconcrete_cal1").val(concrete_cal1);
        $("#FSpo_date").val(po_date);
        $("#FSpo_enddate").val(po_enddate);
        $("#FSplant").val(plant);
        $("#FSButtonID").click();

    });
    let Mpo_id = $("#Mpo_id").val();
    if (Mpo_id == '') {
        document.getElementById("btu").disabled = true;
        document.getElementById("btu1").disabled = true;
    } else {
        document.getElementById("btu").disabled = false;
        document.getElementById("btu1").disabled = false;
    }
    /* ===== search end ===== */
    function selection5() {
        let plant1 = $("#plant1").val();
        console.log('plant1', plant1)

    };

    //click next link
    $(".linkLoadModalNext").on('click', function() {
        $("#ModalLoadId").modal({
            backdrop: 'static',
            'keyboard': false,
        });
    });
</script>

<script>
    $(document).ready(function() {

        $(document).on('click', '#edit_po', function(e) {

            e.preventDefault();

            var uid = $(this).data('id'); // get id of clicked row

            $('#dynamic-content').html(''); // leave this div blank
            $('#modal-loader').show(); // load ajax loader on button click

            $.ajax({
                    url: 'addproduction_edit.php',
                    type: 'POST',
                    data: 'id=' + uid,
                    dataType: 'html'
                })
                .done(function(data) {
                    console.log(data);
                    $('#dynamic-content').html(''); // blank before load.
                    $('#dynamic-content').html(data); // load here
                    $('#modal-loader').hide(); // hide loader  
                })
                .fail(function() {
                    $('#dynamic-content').html(
                        '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                    );
                    $('#modal-loader').hide();
                });

        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
<script>
    $('#inputform2').on('keydown', 'input', function(event) {
        if (event.which == 13) {
            event.preventDefault();
            var $this = $(event.target);
            var index = parseFloat($this.attr('data-index'));
            $('[data-index="' + (index + 1).toString() + '"]').focus();
        }
    });
</script>
<script>
    $('#myModal_del').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('#del_id').val(id)

    })
</script>

</html>