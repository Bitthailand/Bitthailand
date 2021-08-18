<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config.php';
unset($_SESSION['order_id']);
$emp_id = $_SESSION["username"];
$sql = "DELETE FROM orders  WHERE status_button='0' AND emp_id='$emp_id'  ";
if ($conn->query($sql) === TRUE) {
}
$sql2 = "DELETE FROM order_details  WHERE status_button='0'AND emp_id='$emp_id'  ";
if ($conn->query($sql2) === TRUE) {
}
?>
<?php $keyword = $_POST['keyword'];
$column = $_REQUEST['column'];
$rowS = $_REQUEST['row'];
if (empty($column) && ($keyword)) {
} else {
    $columx = "AND $column LIKE'$keyword%'";
    // echo"$columx";   
}
if (($column == "") && ($keyword == "$keyword")) {
    $keywordx = "AND customer_id LIKE'$keyword%'
               OR customer_name LIKE'$keyword%'
               OR  company_name LIKE'$keyword%'
               OR tel LIKE'$keyword%'
               OR contact_name  LIKE'$keyword%' 
               OR bill_address LIKE'$keyword%' ";
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
            <div class="main-content">

                <div class="row">
                    <div class="col-md-12">
                        <!-- ============ Tab Menu ============= -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link active" href="/quotationlist.php">
                                    <h3 class="h5 font-weight-bold"> Order เสนอราคา
                                        <span class="badge badge-pill badge-danger">1</span>
                                    </h3>
                                    <span>รายการ Order ที่อยู่ระหว่างการเสนอราคา
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link" href="/ailist.php">
                                    <h3 class="h5 font-weight-bold"> Order รอส่ง
                                        <span class="badge badge-pill badge-danger">1</span>
                                    </h3>
                                    <span>Order รอส่งสินค้า
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link" href="/creditlist.php">
                                    <h3 class="h5 font-weight-bold"> รอเคลียเครดิต
                                        <span class="badge badge-pill badge-danger">1</span>
                                    </h3>
                                    <span>ลูกค้าเครดิตรอเคลียยอด
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link" href="/tranDW.php">
                                    <h3 class="h5 font-weight-bold"> Order สำเร็จ</h3>
                                    <span>Order ที่ส่งสินค้าเรียบร้อย
                                        <span class="badge badge-success"> Pass </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link" href="/tranDWLog.php">
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
                                        <h3 class="ul-widget1__title "> ขายสินค้า </h3>
                                        <span class="ul-widget__desc "> รายการใบเสนอราคา </span>
                                    </div>
                                    <div class="text-left">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="searchColumnId"> ประเภท </label>
                                                    <select id="searchColumnId" class="custom-select" name="column">
                                                        <option value="bank_number">Bank No</option>
                                                        <option value="bank_amount">Amount</option>
                                                        <option value="order_id">OrderId</option>
                                                        <option value="bank_time">Bank D/T</option>
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
                                            <div class="col-auto">
                                                <a href="/addorder.php?status_order=new" class="btn btn-outline-primary mt-4" role="button" aria-pressed="true"> เปิด Order ใหม่</a>
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
                                            <th>วันที่</th>
                                            <th>Order ID</th>
                                            <th>เลขใบเสนอราคา</th>
                                            <th>ประเภทลูกค้า</th>
                                            <th>ชื่อลูกค้า</th>
                                            <th>เบอร์โทร์</th>
                                            <th>อำเภอ</th>
                                            <th>จังหวัด</th>
                                            <th>ส่วนลด</th>
                                            <th>ก่อนรวมภาษี</th>
                                            <th>ภาษี</th>
                                            <th>ยอดรวม</th>
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

                                        $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM `orders` where  status='0' $columx $keywordx  ");
                                        $total_records = mysqli_fetch_array($result_count);
                                        $total_records = $total_records['total_records'];
                                        $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                        $second_last = $total_no_of_pages - 1; // total page minus 1

                                        $result = mysqli_query($conn, "SELECT * FROM `orders` where status='0' $columx $keywordx LIMIT $offset, $total_records_per_page");
                                        while ($row = mysqli_fetch_array($result)) { ?>
                                            <tr>
                                                <td>
                                                    <?php $date = explode(" ", $row['date_create']);
                                                    $dat = datethai2($date[0]);
                                                    echo $dat . '-' . $date[1]; ?>
                                                </td>
                                                <td> <?= $row['order_id'] ?></td>
                                                <td> <?= $row['qt_id'] ?></td>
                                                <td><?php 
                                                    $sql2 = "SELECT * FROM customer_type WHERE id= '$row[cus_type]'";
                                                    $rs2 = $conn->query($sql2);
                                                    $row2 = $rs2->fetch_assoc();
                                                    // ====
                                                    $sql3 = "SELECT * FROM customer WHERE customer_id= '$row[cus_id]'";
                                                    $rs3 = $conn->query($sql3);
                                                    $row3= $rs3->fetch_assoc(); 
                                                    ?>
                                                    <?=$row2['name']?></td>
                                                <td> <?=$row3['customer_name']?></td>
                                                <td> <?=$row3['tel']?> </td>
                                                <td>
                                                    เมือง
                                                </td>
                                                <td> อุบลราชธานี </td>
                                                <td>
                                                    <span class="font-weight-bold"> 0.00 </span>
                                                </td>
                                                <td> <span class="font-weight-bold"> 76,191.59 </span> </td>
                                                <td> <span class="font-weight-bold"> 5,333.41 </span> </td>
                                                <td>
                                                    <span class="font-weight-bold"> 81,525.00 </span>
                                                </td>
                                                <td>
                                                    <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="มัดจำสินค้า(AI)" href="/addai.php?order_id=OR6401052">
                                                        <i class="i-Money-Bag font-weight-bold"></i>
                                                    </a>
                                                    <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ข้ข้อมูล Order" href="/editorder.php?order_id=OR6400001">
                                                        <i class="i-Check font-weight-bold"></i>
                                                    </a>
                                                    <div class="btn btn-outline-danger btn-sm line-height-1" data-toggle="modal" title="ยกเลิก Order" data-target="#medalcancleorder">
                                                        <i class="i-Close-Window font-weight-bold"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        mysqli_close($conn);
                                        ?>
                                        <tr>
                                            <td colspan="14"> &nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- ============ Table End ============= -->
                            <div class="mt-1">
                                <span class="text-danger mr-1">**</span>
                                <span class="text-muted"> มัดจำขั้นต่ำ 30% เมื่อทำการสั่งซื้อสินค้า</span>
                            </div>
                            <div class="">
                                <span class="text-danger mr-1">**</span>
                                <span class="text-muted">ชำระค่าสินค้าที่เหลือในวันจัดส่ง ก่อนลงสินค้า</span>
                            </div>
                            <div class="">
                                <span class="text-danger mr-1">**</span>
                                <span class="text-muted">ขอสงวนสิทธิ์ในการลงสินค้าต่อเที่ยว (ไม่เกิน 2 ชั่วโมง) หากเกินเวลาคิดเพิ่มชั่วโมงละ 500 บาท</span>
                            </div>
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

    <!-- Modal ยืนยันสั่งผลิต -->
    <div class="modal fade" id="medalconfirmorder" tabindex="-1" role="dialog" aria-labelledby="medalconfirmorder" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalconfirmorder">ยืนยันสั่งผลิต</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p class="text-danger text-16 line-height-1 mb-2">ยืนยันสั่งผลิต Order : OR6400001 ใช่หรือไม่ ?</p>
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