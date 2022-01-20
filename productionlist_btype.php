<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
$emp_id=$_SESSION["username"]; 
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
    $total_records_per_page = 20;
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
if ($action == 'stock_b') {
    // echo "xx";
    $id = $_REQUEST['id'];
    // echo "$po_id";
    $sql = "SELECT * FROM production_detail  WHERE id= '$id'";
    $rs = $conn->query($sql);
    $row = $rs->fetch_assoc();
    for ($x = 1; $x <= $row['b_type']; $x++) {
        $product_id = $row['product_id'];
        $pid = $row['id'];
        // echo"$row_count";
        $stock_b = $_POST['product_id'][$product_id][$pid][$x];
        // echo $row['product_id'] . 'move' . $stock_b . '<br>';
 
        if ($stock_b == 99) {
            //  เลือกนำสินค้าทิ้ง 
            $xx = $x + 1;

            $sql = "INSERT INTO production_b_type  (po_id,product_id,qty,moveto,case_type)
            VALUES ('$row[po_id]','$product_id','1','$stock_b','C1')";
            if ($conn->query($sql) === TRUE) {
            }
            $sql2 = "SELECT * FROM production_detail  WHERE id= '$id'";
            $rs2 = $conn->query($sql2);
            $row2 = $rs2->fetch_assoc();
            $sum_b_type = $row2['b_type'] - 1; //นำทิ้งเอาจำนวนชำรุดมาลบ 1 แล้วอับเดตชำรุดคงเหลือ
            // อับเดตจำนวนสินค้าชำรุดในตาราง production_detail
            $sqlx = "UPDATE production_detail   SET b_type='$sum_b_type'  where id='$id' ";
            if ($conn->query($sqlx) === TRUE) {
            }
        } else { 
            
            if ($stock_b == '00') {
                // echo"ไม่เลือก";
               }else{ 
            //กรณีย้ายไปรหัสสินค้าอื่น
            $sql = "INSERT INTO production_b_type  (po_id,product_id,qty,moveto,case_type)
            VALUES ('$row[po_id]','$product_id','1','$stock_b','C2')";
            if ($conn->query($sql) === TRUE) {
            }
            $sql2 = "SELECT * FROM production_detail  WHERE id= '$id'";
            $rs2 = $conn->query($sql2);
            $row2 = $rs2->fetch_assoc();
            $sum_b_type = $row2['b_type'] - 1; //ย้ายสินค้าไปรหัสอื่นเอาจำนวนชำรุดมาลบ 1 แล้วอับเดตชำรุดคงเหลือ
            // อับเดตจำนวนสินค้าชำรุดในตาราง production_detail
            $sqlx = "UPDATE production_detail   SET b_type='$sum_b_type'  where id='$id' ";
            if ($conn->query($sqlx) === TRUE) {
            }
            // อับเดตเสร็จให้ไปเติมจำนวนสต็อกตามรหัสที่ระบุ
            $sql_fac = "SELECT * FROM plant  WHERE plant_id= '$row[plant_id]'";
            $rs_fac = $conn->query($sql_fac);
            $row_fac = $rs_fac->fetch_assoc();
            //เรียกตารางสินค้ารหัสที่จะย้ายไป
            $sql_pro = "SELECT * FROM product  WHERE product_id= '$stock_b'";
            $rs_pro = $conn->query($sql_pro);
            $row_pro = $rs_pro->fetch_assoc();

            if ($row_fac['factory_id'] == 1) {
                // echo"โรง1";
                $sum_stock = $row_pro['fac1_stock'] + 1;
                //    echo"$sum_stock";
                $sqlx4 = "UPDATE product   SET fac1_stock='$sum_stock' WHERE product_id='$stock_b' ";
                if ($conn->query($sqlx4) === TRUE) {
                }
            }
            if ($row_fac['factory_id'] == 2) {
                // echo"โรง2";
                $sum_stock = $row_pro['fac2_stock'] + 1;
                //    echo"$sum_stock";
                $sqlx4 = "UPDATE product   SET fac2_stock='$sum_stock' WHERE product_id='$stock_b' ";
                if ($conn->query($sqlx4) === TRUE) {
                }
            }
        }
    }
    } ?>
    <script>
        $(document).ready(function() {
            showAlert("ย้ายสินค้าชำรุดเรียบร้อย", "alert-primary");
        });
    </script>
    <?php
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
                                <a class="linkLoadModalNext nav-link " href="/productionlist.php">
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
                                <a class="linkLoadModalNext nav-link active " href="/productionlist_btype.php">
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
                                                    <label for="searchColumnId"> ประเภท </label>

                                                    <select id="searchColumnId" class="custom-select" name="column">
                                                        <option value="" <?php echo $column == '' ? 'selected' : ''; ?>> ไม่ระบุ </option>
                                                        <option value="po_id" <?php echo $column == 'po_id' ? 'selected' : ''; ?>> รหัสสั่งผลิต </option>
                                                        <option value="po_date" <?php echo $column == 'po_date' ? 'selected' : ''; ?>> วันที่สั่งผลิต </option>

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
                                                        <option value="10" <?php echo $rowS == 10 ? 'selected' : ''; ?>> 10 </option>
                                                        <option value="20" <?php echo $rowS == 20 ? 'selected' : ''; ?>> 20 </option>
                                                        <option value="30" <?php echo $rowS == 30 ? 'selected' : ''; ?>> 30 </option>
                                                        <option value="40" <?php echo $rowS == 40 ? 'selected' : ''; ?>> 40 </option>
                                                        <option value="50" <?php echo $rowS == 50 ? 'selected' : ''; ?>> 50 </option>
                                                        <option value="100" <?php echo $rowS == 100 ? 'selected' : ''; ?>> 100 </option>
                                                    </select>
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

                                            <th>หนา</th>
                                            <th>กว้าง</th>
                                            <th>ยาว</th>
                                            <th>ขนาดลวด</th>
                                            <th>จำนวนลวด</th>
                                            <!-- <th>พ.ท.(Sq.m)</th>
                                            <th>คอนกรีตคำนวณ</th> -->
                                            <th>จำนวนชำรุด</th>
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

                                        $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM `production_detail`  where  status_stock='1' AND b_type >'0'  $colum_po  ");
                                        $total_records = mysqli_fetch_array($result_count);
                                        $total_records = $total_records['total_records'];
                                        $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                        $second_last = $total_no_of_pages - 1; // total page minus 1
                                        $count = 0;
                                        // if($colum_po==''){}
                                        $result = mysqli_query($conn, "SELECT * FROM `production_detail`   where  status_stock='1' AND b_type >'0'  $colum_po ORDER BY date_create DESC LIMIT $offset, $total_records_per_page");
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <tr>
                                                <td> <?php
                                                        $x = $count++;
                                                        echo $x == 0 ? '<strong>' .  $row['po_id'] . '</strong>' : ''; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $sql_po = "SELECT * FROM production_order  WHERE po_id= '$row[po_id]'";
                                                    $rs_po = $conn->query($sql_po);
                                                    $row_po = $rs_po->fetch_assoc();

                                                    ?> <?php if ($x == 0) {
                                                            $date = explode(" ", $row_po['po_date']);
                                                            $dat = datethai2($date[0]);
                                                            echo '<strong>' . $dat . '</strong>';
                                                        } ?>
                                                </td>
                                                <td>
                                                    <?php if ($x == 0) {
                                                        $date = explode(" ", $row_po['po_enddate']);
                                                        $dat = datethai2($date[0]);
                                                        echo '<strong>' . $dat . '</strong>';
                                                    } ?>
                                                </td>
                                                <td><?php echo $row['plant_id']; ?></td>
                                                <td><?php echo $row['product_id']; ?></td>
                                                <td><?php echo $row['qty']; ?></td>
                                                <?php
                                                $sqlx = "SELECT * FROM product   WHERE product_id= '$row[product_id]'";
                                                $rsx = $conn->query($sqlx);
                                                $rowx = $rsx->fetch_assoc();

                                                ?>
                                                <td><?php echo $rowx['product_name']; ?></td>

                                                <td><?php echo $rowx['thickness']; ?></td>
                                                <td><?php echo $rowx['width']; ?></td>
                                                <td><?php echo $rowx['size']; ?></td>

                                                <td> <?php echo $rowx['dia_size']; ?></td>
                                                <td> <?php echo $rowx['dia_count']; ?> </td>
                                                <!-- <td> <?php echo $row2['sqm']; ?></td>
                                                        <td> <?php echo $row2['concrete_cal']; ?></td> -->
                                                <td> <?php echo $row['b_type']; ?>
                                                </td>
                                                <td>
                                                   
                                                        <button data-toggle="modal" data-target="#medalstock_b" title="ปรับเปลี่ยนสภาพสินค้า" data-id="<?php echo $row['id']; ?>" id="edit_stock" class="btn btn-outline-info btn-sm line-height-1"> <i class="i-Add-Cart font-weight-bold"></i> </button>

                                                    
                                                </td>
                                            </tr> <?php

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
    <div class="modal fade" id="medalstock_b" tabindex="-1" role="dialog" aria-labelledby="medalconcreteuseTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalconcreteuseTitle-2">เปลี่ยนสภาพสินค้าชำรุด</h5>
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
                    url: 'production_stock_b.php',
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
    $("#searchRowsId").on("change", function() {
        modalLoad();

        let row = $("#searchRowsId").val();
        $("#FSRowId").val(row);
        let column = $("#searchColumnId").val();
        $("#FSColumnId").val(column);
        $("#FSButtonID").click();

    });
    $("#searchNameId").on("change", function() {
        // modalLoad();

        let name = $("#searchNameId").val();
        let column = $("#searchColumnId").val();

        if (column == '') {
            $("#FSKeywordId").val(name);
            $("#FSButtonID").click();
        } else {

            $("#FSKeywordId").val(name);
            $("#FSColumnId").val(column);
            $("#FSButtonID").click();
            console.log('column', column)
            console.log('name', name)
        }


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
<script>
    $('#myModal_del').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('#del_id').val(id)

    })

    //click next link
    $(".linkLoadModalNext").on('click', function() {
        $("#ModalLoadId").modal({
            backdrop: 'static',
            'keyboard': false,
        });
    });
</script>


<script>
    $(function() {
        $('#orderModal').modal({
            keyboard: true,
            backdrop: "static",
            show: false,

        }).on('show', function() {
            var getIdFromRow = $(this).data('orderid');
            //make your ajax call populate items or what even you need
            $(this).find('#orderDetails').html($('<b> Order Id selected: ' + getIdFromRow + '</b>'))
        });

        $(".table-striped").find('tr[data-target]').on('click', function() {
            //or do your operations here instead of on show of modal to populate values to modal.
            $('#orderModal').data('orderid', $(this).data('id'));
        });

    });
</script>
<script>
    $(document).ready(function() {
        $("#searchNameId").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>