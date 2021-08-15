<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config.php';
?>
<?php $keyword = $_POST['keyword'];
$column = $_REQUEST['column'];
$rowS = $_REQUEST['row'];
if(empty($column)&&($keyword)) {}else{
    $columx = "AND $column LIKE'$keyword%'";
    // echo"$columx";   
}
if (($column=="")&&($keyword == "$keyword")) {
    $keywordx = "AND customer_id LIKE'$keyword%'
               OR customer_name LIKE'$keyword%'
               OR  company_name LIKE'$keyword%'
               OR tel LIKE'$keyword%'
               OR contact_name  LIKE'$keyword%' 
               OR bill_address LIKE'$keyword%' ";
    //    echo"$keywordx";
}
if (($column=="")&&($keyword == "")) {
    $columx ="";
    $keywordx ="";
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
                                <a class="linkLoadModalNext nav-link active" href="/productionlist.php">
                                    <h3 class="h5 font-weight-bold"> รายการสั่งผลิต
                                        <span class="badge badge-pill badge-danger">1</span>
                                    </h3>
                                    <span>รายการสินค้าที่อยู่ระหว่างการผลิต
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
                                                        <option value="po_id">รหัสสั่งผลิต</option>
                                                        <option value="po_date">วันที่สั่งผลิต</option>
                                                        <option value="plane_id">แพที่ผลิต</option>
                                                        <option value="product_id">รหัสสินค้า</option>
                                                        <option value="product_name">ชื่อสินค้า</option>
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
                                                <a href="/addproduction.php" class="btn btn-outline-primary mt-4" role="button" aria-pressed="true"> เพิ่มรายการสั่งผลิต</a>

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
                                            <th>วันที่สั่งผลิต</th>
                                            <th>วันที่สั่งเข้าสต็อก</th>
                                            <th>วันที่เท</th>
                                            <th>วันที่เสร็จ</th>
                                            <th>จำนวนรายการ</th>
                                            <th>บันทึกโดย</th>
                                            <th>Action</th>
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

                                        $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM `production_order` where  status='0' $columx $keywordx  ");
                                        $total_records = mysqli_fetch_array($result_count);
                                        $total_records = $total_records['total_records'];
                                        $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                        $second_last = $total_no_of_pages - 1; // total page minus 1

                                        $result = mysqli_query($conn, "SELECT * FROM `production_order` where status='0' $columx $keywordx LIMIT $offset, $total_records_per_page");
                                        while ($row = mysqli_fetch_array($result)) { 
                                            ?>
                                        <tr>
                                            <td>
                                                <strong> <?php echo $row['po_id']; ?></strong>
                                            </td>
                                            <td><strong><?php echo $row['po_date'];?></strong></td>
                                            <td> <strong><?php echo $row['po_enddate'];?></strong></td>
                                            <td> <strong><?php echo $row['po_stop'];?></strong></td>
                                            <td> <strong><?php echo $row['po_enddate'];?></strong></td>
                                            <td> <strong>0</strong></td>
                                            <td> <strong><?php echo $row['employee_id'];?></strong></td>

                                         

                                            <td>
                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ไขข้อมูลสั่งผลิต" href="editproduction.php?po_id=<?php echo $row['po_id'];?>">
                                                    <i class="i-Pen-2 font-weight-bold"></i>
                                                </a>
                                                <!-- <a class="btn btn-outline-info btn-sm line-height-1" data-toggle="modal" title="บันทีกการเทคอนกรีต" data-target="#medalconcreteuse">
                                                    <i class="i-Gear font-weight-bold"></i>
                                                </a> -->
                                                <button type="button" class="btn btn-outline-info btn-sm line-height-1" title="บันทีกการเทคอนกรีต"  data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#medalconcreteuse" id="edit_po">   <i class="i-Gear font-weight-bold"></i> </button>

                                                <a class="btn btn-outline-info btn-sm line-height-1" data-toggle="modal" title="เช็คสินค้าเข้าสต๊อก" data-target="#medalstockcheck">
                                                    <i class="i-Check font-weight-bold"></i>
                                                </a>
                                                <a class="btn btn-outline-danger btn-sm line-height-1" data-toggle="tooltip" title="ยกเลิกรายการผลิต" href="#">
                                                    <i class="i-Close-Window font-weight-bold"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        mysqli_close($conn);
                                        ?>
                                        <tr class="table table-hover text-nowrap table-sm">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>120</strong></td>
                                            <td></td>
                                            <td></td>
                                            
                                           
                                          
                                           
                                        </tr>

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
                                                   <li class='page-item active'><a class="page-link"><?php echo"$counter"; ?></a></li>
                                               <?php  } else { ?>
                                                   <li><a class="page-link" href='?page_no=<?php echo "$counter";?>'><?php echo"$counter"; ?></a></li>
                                              <?php   }
                                            }
                                        } elseif ($total_no_of_pages > 10) {
                                            if ($page_no <= 4) {
                                                for ($counter = 1; $counter < 8; $counter++) {
                                                    if ($counter == $page_no) {
                                                        echo "<li class='page-item  active'><a>$counter</a></li>";
                                                    } else { ?>
                                                      <li><a class="page-link" href='?page_no=<?php echo"$counter"; ?>'><?php echo"$counter";?></a></li>
                                                   <?php  }
                                                }
                                        ?>
                                                <li class="page-item"><a>...</a></li>
                                                <li class="page-item"><a  class="page-link" href='?page_no=<?php echo "$second_last"; ?>'><?php echo "$second_last"; ?></a></li>
                                                <li class="page-item"><a  class="page-link"href='?page_no=<?php echo "$total_no_of_pages"; ?>'><?php echo "$total_no_of_pages"; ?></a></li>
                                                <?php  } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) { ?>
                                                <li class="page-item"><a class="page-link" href='?page_no=1'>1</a></li>
                                                <li class="page-item"><a class="page-link" href='?page_no=2'>2</a></li>
                                                <li class="page-item"><a>...</a></li>
                                                <?php for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                                                    if ($counter == $page_no) { ?>
                                                        <li class='active'><a><?php echo "$counter"; ?></a></li>
                                                    <?php  } else { ?>
                                                        <li><a class="page-link" href='?page_no=<?php echo "$counter"; ?>'><?php echo "$counter"; ?></a></li>
                                                    <?php    }
                                                } ?>
                                                <li><a class="page-link">...</a></li>
                                               <li><a class="page-link" href='?page_no=<?php echo"$second_last";?>'><? echo"$second_last";?></a></li>
                                               <li><a class="page-link" href='?page_no=<?php echo"$total_no_of_pages";?>'><? echo"$total_no_of_pages";?></a></li>";
                                            <?php  } else { ?>
                                               <li><a class="page-link"  href='?page_no=1'>1</a></li>
                                               <li><a class="page-link" href='?page_no=2'>2</a></li>
                                               <li><a class="page-link">...</a></li>

                                         <?php for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                                    if ($counter == $page_no) { ?>
                                                       <li class='active'><a class="page-link"><?php echo"$counter";?></a></li>
                                                  <?php  } else {
                                                    ?> <li><a class="page-link" href='?page_no=$counter'><?php echo "$counter"; ?></a></li>
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
                                           <li><a class="page-link"  href='?page_no=<?php echo"$total_no_of_pages"; ?>'>Last &rsaquo;&rsaquo;</a></li>
                                      <?php   } ?>
                                    </ul>

                            </div>

                        </div>
                            <!--  -->
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

                    <div class="viewDateClass col pr-0 ">
                        <div class="form-group">
                            <label for="searchSDateId">วันเวลาเท</label>
                            <input id="searchSDateId" class="form-control" type="datetime-local" min="2021-06-01" name="start" value="2021-08-04" required="">
                        </div>
                    </div>
                    <div class="viewDateClass col pr-0 ">
                        <div class="form-group">
                            <label for="searchEDateId">วันเวลาเทเสร็จ</label>
                            <input id="searchEDateId" class="form-control" type="datetime-local" name="end" value="2021-08-04" required="">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                    <button class="btn btn-primary ml-2" type="button">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal เช็คสินค้าเข้าสต๊อก -->
    <div class="modal fade" id="medalstockcheck" tabindex="-1" role="dialog" aria-labelledby="medalstockcheckTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalstockcheckTitle-2">เช็คสินค้าเข้าสต๊อก</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">


                    <!-- ============ Table Start ============= -->
                    <div id="productionorder" class="table-responsive">
                        <table role="table" class="table table-hover text-nowrap table-sm">
                            <thead>
                                <tr class="table-secondary">

                                    <th>รหัสสินค้า</th>
                                    <th>ชื่อสินค้า</th>
                                    <th>ความยาว</th>
                                    <th>จำนวนผลิต</th>
                                    <th>สมบูรณ์</th>
                                    <th>ไม่สมบูรณ์</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>FP03100020</td>
                                    <td>เสารั้ว 3x3"</td>
                                    <td>1.00</td>
                                    <td>100</td>
                                    <td><input class="form-control" type="text" placeholder="ใส่ข้อมูล"></td>
                                    <td><input class="form-control" type="text" placeholder="ใส่ข้อมูล"></td>
                                </tr>
                                <tr>

                                    <td>FP03145020</td>
                                    <td>เสารั้ว 3x3"</td>
                                    <td>1.45</td>
                                    <td>60</td>
                                    <td><input class="form-control" type="text" placeholder="ใส่ข้อมูล"></td>
                                    <td><input class="form-control" type="text" placeholder="ใส่ข้อมูล"></td>
                                </tr>
                                <tr>
                                    <td>FP03200020</td>
                                    <td>เสารั้ว 3x3"</td>
                                    <td>2.00</td>
                                    <td>40</td>
                                    <td><input class="form-control" type="text" placeholder="ใส่ข้อมูล"></td>
                                    <td><input class="form-control" type="text" placeholder="ใส่ข้อมูล"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- ============ Table End ============= -->

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                    <button class="btn btn-primary ml-2" type="button">บันทึก</button>
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