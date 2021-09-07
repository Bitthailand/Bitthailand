<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
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
if (empty($column) && ($keyword)) {
} else {
    // $column = "AND $column LIKE'$keyword%'";
    echo"$columx";
       if($column=='po_id'){
        $colum_po = "AND po_id LIKE'%$keyword%'";
       }
       if($column=='po_date'){
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
if (($column == "") && ($keyword == "")) {
    $columx = "";
    $keywordx = "";
}
if ($rowS == '') {
    $total_records_per_page = 10;
} else {
    $total_records_per_page = $rowS;
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
                                <a class="linkLoadModalNext nav-link active" href="/productionfinishlist.php">
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
                                        <span class="ul-widget__desc "> รายการที่ผลิตสำเร็จแล้ว </span>
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
                                            <th>รหัสสินค้า</th>
                                            <th>จำนวนผลิต</th>
                                            <th>ชื่อสินค้า</th>
                                            <th>แพที่</th>
                                            <th>หนา</th>
                                            <th>กว้าง</th>
                                            <th>ยาว</th>
                                            <th>เริ่มเท</th>
                                            <th>เทเสร็จ</th>
                                            <th>วันที่เช็คเข้าสต๊อก</th>
                                            <th>สมบูรณ์</th>
                                            <th>ไม่สมบูรณ์</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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

                                        $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM `production_order`  where status='0' AND status_cf='1'  ");
                                        $total_records = mysqli_fetch_array($result_count);
                                        $total_records = $total_records['total_records'];
                                        $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                        $second_last = $total_no_of_pages - 1; // total page minus 1

                                        $result = mysqli_query($conn, "SELECT * FROM `production_order`   where status='0'  AND status_cf='1'  LIMIT $offset, $total_records_per_page");
                                        while ($row = mysqli_fetch_array($result)) {


                                            $count = mysqli_query($conn, "SELECT COUNT(*) As total FROM production_detail  where po_id = '$row[po_id]' AND status='0'  order by id ASC ");
                                            $total = mysqli_fetch_array($count);
                                            $count = 0;
                                            $sqlxx = "SELECT *  FROM production_detail  where po_id = '$row[po_id]' AND status='0' order by id ASC ";
                                            $resultxx = mysqli_query($conn, $sqlxx);
                                            if (mysqli_num_rows($resultxx) > 0) {
                                                $num = @mysqli_num_rows($resultxx);
                                                $row_cnt = $resultxx->num_rows;
                                                // while ($row1 = mysqli_fetch_assoc($resultxx)) {
                                                while ($row2 = mysqli_fetch_array($resultxx)) {
                                        ?>
                                                    <tr>
                                                        <td>
                                                        <?php
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
                                                        <td><?php echo $row2['product_id']; ?></td>
                                                   
                                                        <td><strong><?php echo $row2['qty']; ?></strong></td>
                                                        <td>   <?php
                                                        $sqlx = "SELECT * FROM product   WHERE product_id= '$row2[product_id]'";
                                                        $rsx = $conn->query($sqlx);
                                                        $rowx = $rsx->fetch_assoc();

                                                        ?><?php echo $rowx['product_name']; ?></td>
                                                        <td><strong><?php echo $row2['plant_id']; ?></strong></td>
                                                        <td><?php echo $rowx['thickness']; ?></td>
                                                        <td><?php echo $rowx['width']; ?></td>
                                                        <td><?php echo $rowx['size']; ?></td>
                                                        <td>
                                                           
                                                            <?php $date = explode(" ", $row['po_start']);
                                                                $dat = datethai2($date[0]);
                                                                echo $dat . '-' . $date[1]; ?></td>
                                                        <td><?php 
                                                         $date = explode(" ", $row['po_stop']);
                                                         $dat = datethai2($date[0]);
                                                         echo  $dat . '-' . $date[1];
                                                        ?></td>
                                                        <td><?php 
                                                         $date = explode(" ", $row['stock_date']);
                                                         $dat = datethai2($date[0]);
                                                         echo  $dat . '-' . $date[1];
                                                        ?></td>
                                                        <td><?=$row2['a_type'];?></td>
                                                        <td><?=$row2['b_type'];?></td>
                                                    </tr>
                                        <?php
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
                                                        <li class='page-item  active'><a class="page-link"><?=$counter?></a></li>
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
                                                <li><a class="page-link" href='?page_no=<?=$second_last?>'><?=$second_last?></a></li>
                                                <li><a class="page-link" href='?page_no=<?php echo "$total_no_of_pages"; ?>'><?php echo "$total_no_of_pages"; ?></a></li>
                                            <?php  } else { ?>
                                                <li><a class="page-link" href='?page_no=1'>1</a></li>
                                                <li><a class="page-link" href='?page_no=2'>2</a></li>
                                                <li><a class="page-link">...</a></li>

                                                <?php for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                                    if ($counter == $page_no) { ?>
                                                        <li class='page-item  active'><a class="page-link"><?php echo "$counter"; ?></a></li>
                                                    <?php  } else {
                                                    ?> <li><a class="page-link" href='?page_no=<?=$counter?>'><?php echo "$counter"; ?></a></li>
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
</body>
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

    if(column==''){
        $("#FSKeywordId").val(name);
        $("#FSButtonID").click();
    }else{

    $("#FSKeywordId").val(name);
    $("#FSColumnId").val(column);
    $("#FSButtonID").click();
console.log('column',column)
console.log('name',name)
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
</html>