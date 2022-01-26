<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
$emp_id = $_SESSION["username"];
include './include/connect.php';
include './include/config.php';
?>
<?php

error_reporting(0);
$action = $_REQUEST['action'];
$keyword = $_POST['keyword'];
$column = $_REQUEST['column'];
$rowS = $_REQUEST['row'];
$emp_id = $_SESSION["username"];
$datetoday = date('Y-m-d h:i:s');
// echo"$datetoday";
unset($_SESSION['po_id']);
$emp_id = $_SESSION["username"];
$sql = "DELETE FROM production_order  WHERE status_button='0' AND employee_id='$emp_id'  ";
if ($conn->query($sql) === TRUE) {
}
$sql2 = "DELETE FROM production_detail  WHERE status_button='0'AND employee_id='$emp_id'  ";
if ($conn->query($sql2) === TRUE) {
}


if (empty($column) && ($keyword)) {
} else {
    // $column = "AND $column LIKE'$keyword%'";
    echo "$columx";
    if ($column == 'po_id') {
        $colum_po = "AND po_id LIKE'%$keyword%'";
    }
    if ($column == 'po_date') {
        $colum_po = "AND po_date LIKE'%$keyword%'";
    }

    //    echo"$column";
}

if (($column == "") && ($keyword == "$keyword")) {
    $keywordx = "AND po_id LIKE'%$keyword%'
               OR product_id LIKE'%$keyword%'
               OR  qty LIKE'%$keyword%'
               OR plant_id  LIKE'%$keyword%'
               OR sqm LIKE'%$keyword%' 
               OR status_stock LIKE'%$keyword%' ";
    //    echo"$keywordx";
}
if ($rowS == '') {
    $total_records_per_page = 40;
} else {
    $total_records_per_page = $rowS;
}


if ($action == 'edit_prox') {
    // echo"xx";
    $edit_id = $_REQUEST['edit_id'];
    // echo"$edit_id";
    $po_start = $_REQUEST['po_start'];
    $po_stop = $_REQUEST['po_stop'];
    //    echo"$po_stop";
    //    echo"$po_start";
    $sqlxxx = "UPDATE production_order  SET po_start='$po_start',po_stop='$po_stop' where id='$edit_id'";
    if ($conn->query($sqlxxx) === TRUE) { ?>
        <script>
            $(document).ready(function() {
                showAlert("บันทึกข้อมูลการเทคอนกรีตสำเร็จ", "alert-primary");
            });
        </script>
        <?php }
}
if ($action == 'add_stock') {
    // echo "xx";
    $po_id = $_REQUEST['po_id'];
    // echo "$po_id";
    $sql = "SELECT * FROM production_order  WHERE id= '$po_id'";
    $rs = $conn->query($sql);
    $row = $rs->fetch_assoc();
    $sqlxx = "SELECT *  FROM production_detail  where po_id= '$row[po_id]' ORDER BY id ASC";
    $resultxx = mysqli_query($conn, $sqlxx);
    if (mysqli_num_rows($resultxx) > 0) {

        while ($rowx = mysqli_fetch_assoc($resultxx)) {
            $product_id = $rowx['product_id'];
            $pid = $rowx['id'];
            // echo"$pid";
            // echo"$row_count";
            $stock_a = $_POST['a_type'][$product_id][$pid][++$id];
            $stock_b = $_POST['b_type'][$product_id][$pid][++$id2];
            $total_stock = $stock_a + $stock_b;

            if ($total_stock <= $rowx['qty']) {
                if ($total_stock == 0) {
                    // $sqlx17 = "UPDATE production_detail   SET a_type='$stock_a',b_type='$stock_b' WHERE po_id= '$rowx[po_id]' AND product_id='$rowx[product_id]' ";
                    // if ($conn->query($sqlx17) === TRUE) {}
                } else {

                    // 
                    // ตรวจสอบโรงงานผลิต   
                    $sqlx2 = "SELECT * FROM plant  WHERE plant_id= '$rowx[plant_id]'";
                    $rsx2 = $conn->query($sqlx2);
                    $rowx2 = $rsx2->fetch_assoc();
                    // echo $rowx2['factory_id'];
                    // นับจำนวนที่มีอยู๋ในสต็อก
                    $sqlx3 = "SELECT * FROM product  WHERE product_id= '$rowx[product_id]'";
                    $rsx3 = $conn->query($sqlx3);
                    $rowx3 = $rsx3->fetch_assoc();
                    $sql_po = "SELECT * FROM production_detail    WHERE product_id='$rowx[product_id]' AND id='$rowx[id]'  ";
                    $rs_po = $conn->query($sql_po);
                    $row_po = $rs_po->fetch_assoc();
                    $sum_po = $row_po['a_type'] + $row_po['b_type'];
                    $sumy = $rowx['qty'] - $sum_po;
                    $total_sumy = $total_stock - $sumy;
                    $totalstock1 = $row_po['a_type'] + $stock_a;
                    $totalstock2 = $row_po['b_type'] + $stock_b;
                    // echo"$total_sumy";
                    // ผลรวมเป็น 0 คือครบจำนวนผลิตแล้ว
                    if ($total_sumy == 0) {
                        $sqlx3 = "SELECT * FROM product  WHERE product_id= '$rowx[product_id]'";
                        $rsx3 = $conn->query($sqlx3);
                        $rowx3 = $rsx3->fetch_assoc();
                        if ($rowx2['factory_id'] == 1) {
                            $sqlx3 = "SELECT * FROM product  WHERE product_id= '$rowx[product_id]'";
                            $rsx3 = $conn->query($sqlx3);
                            $rowx3 = $rsx3->fetch_assoc();
                            // echo'st'.$rowx3['fac1_stock'];
                            $sum_stock1 = $rowx3['fac1_stock'] + $stock_a;

                            $sqlx4 = "UPDATE product   SET fac1_stock='$sum_stock1' WHERE product_id='$rowx[product_id]' ";
                            if ($conn->query($sqlx4) === TRUE) {
                            }
                            $sqlx = "INSERT INTO product_log  (product_id,stock1_in,po_id,stock_b1)
                            VALUES ('$rowx[product_id]','$stock_a','$row[po_id]','$stock_b1')";
                            if ($conn->query($sqlx) === TRUE) {
                            }
                        }
                        if ($rowx2['factory_id'] == 2) {
                            $sqlx3 = "SELECT * FROM product  WHERE product_id= '$rowx[product_id]'";
                            $rsx3 = $conn->query($sqlx3);
                            $rowx3 = $rsx3->fetch_assoc();
                            $sum_stock2 = $rowx3['fac2_stock'] + $stock_a;
                            $sqlx4 = "UPDATE product   SET fac2_stock='$sum_stock2' WHERE product_id='$rowx[product_id]' ";
                            if ($conn->query($sqlx4) === TRUE) {
                            }
                            $sqlx = "INSERT INTO product_log  (product_id,stock2_in,po_id,stock_b2)
                            VALUES ('$rowx[product_id]','$stock_a','$row[po_id]','$stock_b2')";
                            if ($conn->query($sqlx) === TRUE) {
                            }
                        }
                        // echo"$stock_a";
                        $sqlx1x = "UPDATE production_detail   SET a_type='$totalstock1',b_type='$totalstock2',status_stock='1' WHERE po_id= '$rowx[po_id]' AND product_id='$rowx[product_id]' AND id='$rowx[id]'  ";

                        if ($conn->query($sqlx1x) === TRUE) { ?>
                            <script>
                                $(document).ready(function() {
                                    showAlert("บันทึกสต็อกรหัส สำเร็จxxx", "alert-primary");
                                });
                            </script>
                        <?php
                        }
                    }
                    if ($total_sumy > 0) { ?>
                        <script>
                            $(document).ready(function() {
                                showAlert("ไม่สามารถบันทึกเกินจำนวนสั่งผลิต", "alert-danger");
                            });
                        </script>
                        <?php   }
                    if ($total_sumy < 0) {
                        $sqlx3 = "SELECT * FROM product  WHERE product_id= '$rowx[product_id]'";
                        $rsx3 = $conn->query($sqlx3);
                        $rowx3 = $rsx3->fetch_assoc();

                        if ($rowx2['factory_id'] == 1) {
                            // echo"$rowx3[fac1_stock]";
                            $sum_stock1 = $rowx3['fac1_stock'] + $stock_a;
                            $sqlx4 = "UPDATE product   SET fac1_stock='$sum_stock1' WHERE product_id='$rowx[product_id]' ";
                            if ($conn->query($sqlx4) === TRUE) {
                            }
                            $sqlx = "INSERT INTO product_log  (product_id,stock1_in,po_id)
                        VALUES ('$product_id','$stock_a','$po_id')";
                            if ($conn->query($sqlx) === TRUE) {
                            }
                        }
                        if ($rowx2['factory_id'] == 2) {
                            $sum_stock2 = $rowx3['fac2_stock'] + $stock_a;
                            $sqlx4 = "UPDATE product   SET fac2_stock='$sum_stock2' WHERE product_id='$rowx[product_id]' ";
                            if ($conn->query($sqlx4) === TRUE) {
                            }
                            $sqlx = "INSERT INTO product_log  (product_id,stock2_in,po_id)
                        VALUES ('$product_id','$stock_a','$po_id')";
                            if ($conn->query($sqlx) === TRUE) {
                            }
                        }
                        $sqlx1 = "UPDATE production_detail   SET a_type='$totalstock1',b_type='$totalstock2'  WHERE po_id= '$rowx[po_id]' AND product_id='$rowx[product_id]' AND id='$rowx[id]'  ";
                        if ($conn->query($sqlx1) === TRUE) { ?>
                            <script>
                                $(document).ready(function() {
                                    showAlert("บันทึกสต็อกรหัส สำเร็จYYY", "alert-primary");
                                });
                            </script>
                <?php
                        }
                    }
                }
            } else { ?>
                <script>
                    $(document).ready(function() {
                        showAlert("ไม่สามารถบันทึกสต็อกรหัส  <?= $product_id ?> ได้เนื่องจากจำนวนที่กรอกเกินจำนวนที่สั่งผลิต", "alert-danger");
                    });
                </script>
        <?php       }
            //  $sql = "UPDATE production_detail   SET a_type='$stock_a',b_type='$stock_b'  where  po_id= '$row[po_id]' AND product_id='$product_id' ";

            // echo 'A' . $stock_a . 'B' . $stock_b . 'ID' . $product_id . 'จำนวนกรอกรวม' . $total_stock . 'สต็อก' . $rowx['qty'] . '<br>';
        }
    }
    $sqlc1 = "SELECT COUNT(*) AS stock1  FROM production_detail  WHERE   po_id= '$row[po_id]' AND status_stock='1' ";
    $rsc1 = $conn->query($sqlc1);
    $rowc1 = $rsc1->fetch_assoc();

    $sqlc0 = "SELECT COUNT(*) AS stock0  FROM production_detail  WHERE   po_id= '$row[po_id]' ";
    $rsc0 = $conn->query($sqlc0);
    $rowc0 = $rsc0->fetch_assoc();
    if ($rowc0['stock0'] == $rowc1['stock1']) {
        $sqlx12 = "UPDATE production_order   SET status_cf='1',employee_qc='$emp_id',stock_date='$datetoday' WHERE po_id= '$row[po_id]' ";
        if ($conn->query($sqlx12) === TRUE) {
        }
    }
}
if ($action == 'del') {
    $del_id = $_REQUEST['del_id'];
    // echo"$del_id";
    // $sql = "DELETE FROM customer  WHERE customer_id='$del_id' ";
    $sql = "UPDATE production_order    SET status='1'  where po_id='$del_id' ";
    $sql = "UPDATE production_detail    SET status='1'  where po_id='$del_id' ";

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
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Production | รายการสั่งผลิตสินค้า</title>
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
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link active" href="/productionlist.php">
                                    <h3 class="h5 font-weight-bold"> รายการสั่งผลิต
                                        <?php $sql_count = "SELECT COUNT(*) AS CO FROM production_order  WHERE  status='0' AND status_cf='0' ";
                                        $rs_count = $conn->query($sql_count);
                                        $row_count = $rs_count->fetch_assoc();
                                        ?> <span class="badge badge-pill badge-danger"><?= $row_count['CO'] ?></span>
                                    </h3>
                                    <span>รายการสินค้าที่อยู่ระหว่างการผลิต
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link " href="/productionlist_btype.php">
                                    <h3 class="h5 font-weight-bold"> รายการสินค้าชำรุด
                                        <?php $sql_count = "SELECT COUNT(*) AS CO FROM production_detail  WHERE   status_stock='1' AND b_type >'0' ";
                                        $rs_count = $conn->query($sql_count);
                                        $row_count = $rs_count->fetch_assoc();
                                        ?> <span class="badge badge-pill badge-danger"><?= $row_count['CO'] ?></span>
                                    </h3>
                                    <span>รายการสินค้าที่ถูกเลือกชำรุด
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link" href="/productionfinishlist.php">
                                    <h3 class="h5 font-weight-bold"> รายการสำเร็จ</h3>
                                    <span>รายการสินค้าที่ผลิตเรียบร้อย

                                        <span class="badge badge-success"> Success </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="mb-1">
                                <div class="ul-widget__item">
                                    <div class="ul-widget__info">
                                        <h3 class="ul-widget1__title "> ผลิตสินค้า </h3>
                                        <span class="ul-widget__desc "> รายการสั่งผลิตสินค้า </span>
                                    </div>
                                    <div class="text-left">
                                        <div class="row">
                                            
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="searchNameId"> คำที่ต้องการค้น</label>
                                                    <input id="myInput" class="form-control" placeholder="Keyword" type="text" value="">
                                                </div>
                                            </div>
                                            
                                            <div class="col-auto">
                                                <a href="/addproduction.php?status_po=new" class="btn btn-outline-primary mt-4" role="button" aria-pressed="true"> เพิ่มรายการสั่งผลิต</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ============ Table Start ============= -->
                            <div id="productionorder" class="table-responsive">
                                <table role="table" class="table table-hover text-nowrap table-sm">
                                    <thead>
                                        <tr class="table-secondary">
                                            <th>รหัสสั่งผลิต</th>
                                            <th>วันที่สั่ง</th>
                                            <th>กำหนดเสร็จ</th>
                                            <th>แพที่</th>
                                            <th>รหัสสินค้า</th>
                                            <th>จำนวนผลิต</th>
                                            <th>ชื่อสินค้า</th>
                                            <th>ข้อมูลสินค้า</th>
                                            <th>หนา</th>
                                            <th>กว้าง</th>
                                            <th>ยาว</th>
                                            <th>ขนาดลวด</th>
                                            <th>จำนวนลวด</th>
                                            <!-- <th>พ.ท.(Sq.m)</th>
                                            <th>คอนกรีตคำนวณ</th> -->
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                                        <?php
                                        if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
                                            $page_no = $_GET['page_no'];
                                        } else {
                                            $page_no = 1;
                                        }
                                        // $total_records_per_page = 10;
                                        $offset = ($page_no - 1) * $total_records_per_page;
                                        $previous_page = $page_no - 1;
                                        $next_page = $page_no + 1;
                                        $adjacents = "2";

                                        $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM `production_order`  where status='0' AND status_cf='0' $colum_po  ");
                                        $total_records = mysqli_fetch_array($result_count);
                                        $total_records = $total_records['total_records'];
                                        $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                        $second_last = $total_no_of_pages - 1; // total page minus 1
                                        $result = mysqli_query($conn, "SELECT * FROM `production_order`   where status='0'  AND status_cf='0' $colum_po ORDER BY date_create DESC LIMIT $offset, $total_records_per_page");
                                        while ($row = mysqli_fetch_array($result)) {       $count = mysqli_query($conn, "SELECT COUNT(*) As total FROM production_detail  where po_id = '$row[po_id]' AND status='0'   ORDER BY id ASC ");
                                            $total = mysqli_fetch_array($count);
                                            $count = 0;
                                            $sqlxx = "SELECT *  FROM production_detail  where po_id = '$row[po_id]' AND status='0'   ORDER BY id ASC  ";
                                            $resultxx = mysqli_query($conn, $sqlxx);
                                            if (mysqli_num_rows($resultxx) > 0) {
                                                $num = @mysqli_num_rows($resultxx);
                                                $row_cnt = $resultxx->num_rows;
                                                // while ($row1 = mysqli_fetch_assoc($resultxx)) {
                                                while ($row2 = mysqli_fetch_array($resultxx)) { ?>
                                                    <tr>
                                                        <td> <?php
                                                                $x = $count++;
                                                                echo $x == 0 ? '<strong>' .  $row['po_id'] . '</strong>' : ''; ?>
                                                        </td>
                                                        <td> <?php if ($x == 0) {
                                                                    $date = explode(" ", $row['po_date']);
                                                                    $dat = datethai2($date[0]);
                                                                    echo '<strong>' . $dat . '</strong>';
                                                                } ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($x == 0) {
                                                                $date = explode(" ", $row['po_enddate']);
                                                                $dat = datethai2($date[0]);
                                                                echo '<strong>' . $dat . '</strong>';
                                                            } ?>
                                                        </td>
                                                        <td><?php echo $row2['plant_id']; ?></td>
                                                        <td><?php echo $row2['product_id']; ?></td>
                                                        <td><?php echo $row2['qty']; ?></td>
                                                        <?php
                                                        $sqlx = "SELECT * FROM product   WHERE product_id= '$row2[product_id]'";
                                                        $rsx = $conn->query($sqlx);
                                                        $rowx = $rsx->fetch_assoc();
                                                        ?>
                                                        <td><?php echo $rowx['product_name']; ?></td>
                                                        <td><?php echo $rowx['spacial']; ?></td>
                                                        <td><?php echo $rowx['thickness']; ?></td>
                                                        <td><?php echo $rowx['width']; ?></td>
                                                        <td><?php echo $rowx['size']; ?></td>
                                                        <td> <?php echo $rowx['dia_size']; ?></td>
                                                        <td> <?php echo $rowx['dia_count']; ?> </td>
                                                        <!-- <td> <?php echo $row2['sqm']; ?></td>
                                                        <td> <?php echo $row2['concrete_cal']; ?></td> -->
                                                        <td> <?php if ($row2['status_stock'] == 1) { ?>
                                                                <span class="badge badge-success p-1">เข้าสต๊อก</span>
                                                            <?php } ?>
                                                            <?php if ($row2['status_stock'] == 0) { ?>
                                                                <span class="badge badge-warning p-1">รอดำเนินการ</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($x == 0) { ?>

                                                                <a class="btn btn-outline-success btn-sm line-height-1" href="/editproduction.php?po_id=<?php echo $row['po_id']; ?>" type="button" title="แก้ไขข้อมูลสั่งผลิต"> <i class="i-Pen-2 font-weight-bold"></i></a>
                                                                <a class="btn btn-outline-success btn-sm line-height-1" href="/productionprint.php?po_id=<?= $row['po_id'] ?>" target="_blank" type="button" title="พริ้นใบสั่งผลิต"> <i class="i-Folder-With-Document font-weight-bold"></i></a>

                                                                <button data-toggle="modal" data-target="#medalstock" title="เช็คสินค้าเข้าสต๊อก" data-id="<?php echo $row['id']; ?>" id="edit_stock" class="btn btn-outline-info btn-sm line-height-1"> <i class="i-Add-Cart font-weight-bold"></i> </button>

                                                                <button type="button" class="btn btn-outline-danger btn-sm line-height-1" data-id="<?php echo $row['po_id']; ?>" data-toggle="modal" data-target="#myModal_del" data-toggle="tooltip" title="ยกเลิกรายการผลิต"> <i class="i-Close-Window font-weight-bold"></i> </button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr> <?php
                                                        }
                                                    }
                                                }
                                                mysqli_close($conn);
                                                            ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- ============ Table End ============= -->
                            <div class="mb-5 mt-3">
                                <nav aria-label="Page navigation ">
                                    <ul class="pagination justify-content-center">
                                        <?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } 
                                        ?>
                                        <li class="page-item" <?php if ($page_no <= 1) {
                                                                    echo "class='disabled'";
                                                                } ?>>
                                            <a class="page-link" <?php if ($page_no > 1) {
                                                                        echo "href='?page_no=$previous_page' ";
                                                                    } ?>>Previous</a>
                                        </li>
                                        <?php
                                        if ($total_no_of_pages <= 10) {
                                            for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                                                if ($counter == $page_no) { ?>
                                                    <li class='page-item active'><a class="page-link"><?php echo "$counter"; ?></a></li>
                                                <?php  } else { ?>
                                                    <li><a class="page-link" href='?page_no=<?php echo "$counter"; ?>'><?php echo "$counter"; ?></a></li>
                                                    <?php   }
                                            }
                                        } elseif ($total_no_of_pages > 10) {
                                            if ($page_no <= 4) {
                                                for ($counter = 1; $counter < 8; $counter++) {
                                                    if ($counter == $page_no) { ?>
                                                        <li class='page-item  active'><a class="page-link"><?= $counter ?></a></li>
                                                    <?php  } else { ?>
                                                        <li><a class="page-link" href='?page_no=<?php echo "$counter"; ?>'><?php echo "$counter"; ?></a></li>
                                                <?php  }
                                                }
                                                ?>
                                                <li class="page-item"><a>...</a></li>
                                                <li class="page-item"><a class="page-link" href='?page_no=<?php echo "$second_last"; ?>'><?php echo "$second_last"; ?></a></li>
                                                <li class="page-item"><a class="page-link" href='?page_no=<?php echo "$total_no_of_pages"; ?>'><?php echo "$total_no_of_pages"; ?></a></li>
                                            <?php  } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) { ?>
                                                <li class="page-item"><a class="page-link" href='?page_no=1'>1</a></li>
                                                <li class="page-item"><a class="page-link" href='?page_no=2'>2</a></li>
                                                <li class="page-item"><a class="page-link">..</a></li>
                                                <?php for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                                                    if ($counter == $page_no) { ?>
                                                        <li class='page-item  active'><a class="page-link"><?php echo "$counter"; ?></a></li>
                                                    <?php  } else { ?>
                                                        <li><a class="page-link" href='?page_no=<?php echo "$counter"; ?>'><?php echo "$counter"; ?></a></li>
                                                <?php    }
                                                } ?>
                                                <li><a class="page-link">...</a></li>
                                                <li><a class="page-link" href='?page_no=<?= $second_last ?>'><?= $second_last ?></a></li>
                                                <li><a class="page-link" href='?page_no=<?php echo "$total_no_of_pages"; ?>'><?php echo "$total_no_of_pages"; ?></a></li>
                                            <?php  } else { ?>
                                                <li><a class="page-link" href='?page_no=1'>1</a></li>
                                                <li><a class="page-link" href='?page_no=2'>2</a></li>
                                                <li><a class="page-link">...</a></li>

                                                <?php for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                                    if ($counter == $page_no) { ?>
                                                        <li class='page-item  active'><a class="page-link"><?php echo "$counter"; ?></a></li>
                                                    <?php  } else {
                                                    ?> <li><a class="page-link" href='?page_no=<?= $counter ?>'><?php echo "$counter"; ?></a></li>
                                        <?php   }
                                                }
                                            }
                                        }
                                        ?>
                                        <li <?php if ($page_no >= $total_no_of_pages) {
                                                echo "class='disabled'";
                                            } ?>>
                                            <a class="page-link" <?php if ($page_no < $total_no_of_pages) {
                                                                        echo "href='?page_no=$next_page'";
                                                                    } ?>>Next</a>
                                        </li>
                                        <?php if ($page_no < $total_no_of_pages) { ?>
                                            <li><a class="page-link" href='?page_no=<?php echo "$total_no_of_pages"; ?>'>Last &rsaquo;&rsaquo;</a></li>
                                        <?php   } ?>
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
    </div>
    <!-- Modal บันทึกวันเวลา เท -->
    <div class="modal fade" id="medalconcreteuse" tabindex="-1" role="dialog" aria-labelledby="medalconcreteuseTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalconcreteuseTitle-2">บันทีกการเทคอนกรีต</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div id="dynamic-content"></div>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal บันทึกสต็อก-->
    <div class="modal fade" id="medalstock" tabindex="-1" role="dialog" aria-labelledby="medalconcreteuseTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalconcreteuseTitle-2">เช็คสินค้าเข้าสต๊อก</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div id="dynamic-content1"></div>

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
    <!-- ============ Form Search Start ============= -->
    <form class="d-none" method="POST">
        <input type="text" id="FSColumnId" name="column" value="<?php echo $S_COLUMN; ?>" placeholder="">
        <input type="text" id="FSKeywordId" name="keyword" value="<?php echo $S_KEYWORD; ?>" placeholder="">
        <input type="text" id="FSRowId" name="row" value="<?php echo $S_ROW; ?>" placeholder="">
        <input type="number" id="FSPageId" name="page" value="<?php echo $S_PAGE; ?>" placeholder="">
        <button class="btn" id="FSButtonID" type="submit"></button>
    </form>
    <!-- ============ Form Search End ============= -->

    <!-- ============ Modal Start ============= -->
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
    <script src="../../dist-assets/js/scripts/tooltip.script.min.js"></script>
</body>

</html>
<script>
    $(document).ready(function() {

        $(document).on('click', '#edit_pro', function(e) {

            e.preventDefault();

            var uid = $(this).data('id'); // get id of clicked row

            $('#dynamic-content').html(''); // leave this div blank
            $('#modal-loader').show(); // load ajax loader on button click

            $.ajax({
                    url: 'productionlist_editpo.php',
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

        $(document).on('click', '#edit_stock', function(e) {

            e.preventDefault();

            var uid = $(this).data('id'); // get id of clicked row

            $('#dynamic-content1').html(''); // leave this div blank
            $('#modal-loader1').show(); // load ajax loader on button click

            $.ajax({
                    url: 'productionlist_stock.php',
                    type: 'POST',
                    data: 'id=' + uid,
                    dataType: 'html'
                })
                .done(function(data) {
                    console.log(data);
                    $('#dynamic-content1').html(''); // blank before load.
                    $('#dynamic-content1').html(data); // load here
                    $('#modal-loader1').hide(); // hide loader  
                })
                .fail(function() {
                    $('#dynamic-content1').html(
                        '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                    );
                    $('#modal-loader1').hide();
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