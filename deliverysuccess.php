<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config.php';
$emp_id = $_SESSION["username"];
$keyword = $_POST['keyword'];
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
    $total_records_per_page = 40;
} else {
    $total_records_per_page = $rowS;
}
$action = $_REQUEST['action'];
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

                                        $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM `delivery` where  status='0' AND status_chk='1'   $columx $keywordx  ");
                                        $total_records = mysqli_fetch_array($result_count);
                                        $total_records = $total_records['total_records'];
                                        $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                        $second_last = $total_no_of_pages - 1; // total page minus 1

                                        $result = mysqli_query($conn, "SELECT * FROM `delivery` where status='0'  AND status_chk='1'   $columx $keywordx LIMIT $offset, $total_records_per_page");
                                        while ($row = mysqli_fetch_array($result)) { ?>
                                        <tr>
                                        <td> <?= $row['dev_id'] ?> </td>
                                                <td> <?= $row['order_id'] ?></td>
                                                <td><?php
                                                    $sql1 = "SELECT * FROM orders WHERE order_id= '$row[order_id]'";
                                                    $rs1 = $conn->query($sql1);
                                                    $row1 = $rs1->fetch_assoc();

                                                    $sql2 = "SELECT * FROM customer_type WHERE id= '$row1[cus_type]'";
                                                    $rs2 = $conn->query($sql2);
                                                    $row2 = $rs2->fetch_assoc();
                                                    // ====

                                                    $date = explode(" ", $row['dev_date']);
                                                    $dat = datethai2($date[0]);
                                                    echo '<strong>' . $dat . '</strong>'; ?> </td>
                                                <td> <?php
                                                        $sql3 = "SELECT * FROM employee  WHERE emp_id= '$row[dev_employee]'";
                                                        $rs3 = $conn->query($sql3);
                                                        $row3 = $rs3->fetch_assoc();
                                                        echo "$row3[emp_name]";
                                                        ?>
                                                </td>
                                                <td> <?php
                                                        $sql4 = "SELECT * FROM employee  WHERE emp_id= '$row[dev_check]'";
                                                        $rs4 = $conn->query($sql4);
                                                        $row4 = $rs4->fetch_assoc();
                                                        echo "$row4[emp_name]";

                                                        ?></td>
                                                <td> <?php
                                                        $sql5 = "SELECT * FROM customer WHERE customer_id= '$row1[cus_id]'";
                                                        $rs5 = $conn->query($sql5);
                                                        $row5 = $rs5->fetch_assoc();

                                                        echo $row5['customer_name']; ?> </td>
                                                <td> <?php echo $row5['tel']; ?> </td>
                                                <td>
                                                    <?php echo $row5['bill_address'];
                                                    $sql6 = "SELECT * FROM districts  WHERE id= '$row5[subdistrict]'";
                                                    $rs6 = $conn->query($sql6);
                                                    $row6 = $rs6->fetch_assoc();
                                                    $sql7 = "SELECT * FROM amphures  WHERE id= '$row5[district]'";
                                                    $rs7 = $conn->query($sql7);
                                                    $row7 = $rs7->fetch_assoc();
                                                    $sql8 = "SELECT * FROM provinces  WHERE id= '$row5[province]'";
                                                    $rs8 = $conn->query($sql8);
                                                    $row8 = $rs8->fetch_assoc();

                                                    echo " ต" . $row6['name_th'] . "  อ." . $row7['name_th'] . " จ." . $row8['name_th'];

                                                    ?>
                                                </td>
                                            <td>
                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="ดูรายละเอียด Order"
                                                    href="/orderview.php?order_id=<?php echo $row['order_id']; ?>&so_id=<?php echo $row['dev_id']; ?>" target="_blank">
                                                    <i class="i-Eye font-weight-bold"></i>
                                                </a>

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