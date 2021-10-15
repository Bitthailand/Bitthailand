<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
$emp_id=$_SESSION["username"]; 
include './include/connect.php';
include './include/config.php';
unset($_SESSION['order_id']);
unset($_SESSION['Forder_id']);
$emp_id = $_SESSION["username"];
$sql = "DELETE FROM orders  WHERE status_button='0' AND emp_id='$emp_id'  ";
if ($conn->query($sql) === TRUE) {
}
$sql2 = "DELETE FROM order_details  WHERE status_button='0' AND emp_id='$emp_id'  ";
if ($conn->query($sql2) === TRUE) {
}
$sql3 = "UPDATE orders_number  SET  status_use='2',status_cf='0'  where emp_id='$emp_id' AND status_button='0' ";
if ($conn->query($sql3) === TRUE) {}
// $sql3 = "DELETE FROM orders_number  WHERE status_use='1' AND emp_id='$emp_id'  ";
// if ($conn->query($sql3) === TRUE) {
// }
// $sql3 = "DELETE FROM orders_number  WHERE status_use='2' AND status_cf='0' AND emp_id='$emp_id'  ";
// if ($conn->query($sql3) === TRUE) {
// }
// $sql3 = "DELETE FROM orders_number  WHERE status_use='1' AND status_cf='0' AND emp_id='$emp_id'  ";
// if ($conn->query($sql3) === TRUE) {
// }
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
    $total_records_per_page = 40;
} else {
    $total_records_per_page = $rowS;
}
$action = $_REQUEST['action'];
if ($action == 'del') {
    $del_id = $_REQUEST['del_id'];

    // $sql = "DELETE FROM customer  WHERE customer_id='$del_id' ";
    $sql = "UPDATE orders    SET status='1',order_status='6'  where id='$del_id' ";

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
if ($action == 'add_cfx') {
    $order_id= $_REQUEST['order_id'];
    $sqlxxx1 = "UPDATE orders  SET order_status='2',is_ai='Y'  where id='$order_id'";
    if ($conn->query($sqlxxx1) === TRUE) {
        ?>
<script>
        $(document).ready(function() {
            showAlert("ยืนยันสั่งสินค้าลูกค้าเครดิส", "alert-primary");
        });
    </script>

<?php 
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
        <div id="alert_placeholder" style="z-index: 9999999; left:1px; top:1%; width:100%; position:absolute;"></div>
            <!-- ปิดการแจ้งเตือน -->
            <!-- ============ Body content start ============= -->
            <div class="main-content">

                <div class="row">
                    <div class="col-md-12">
                        <!-- ============ Tab Menu ============= -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link active" href="/quotationlist.php">
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
                                <a class="linkLoadModalNext nav-link" href="/ordersuccesslist.php">
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
                                <a class="linkLoadModalNext nav-link" href="/orderloglist.php">
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
                                                    <label for="searchNameId"> Keyword</label>
                                                    <input id="myInput" class="form-control" placeholder="Keyword" type="text" value="">
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="searchRowsId"> Row </label>
                                                    <select id="searchRowsId" class="custom-select">
                                                        <option value="40" <?php echo $rowS == 40 ? 'selected' : ''; ?>> 40 </option>
                                                        <option value="50" <?php echo $rowS == 50 ? 'selected' : ''; ?>> 50 </option>
                                                        <option value="100" <?php echo $rowS == 100 ? 'selected' : ''; ?>> 100 </option>
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
                                            <!-- <th>ส่วนลด</th> -->
                                            <!-- <th>ก่อนรวมภาษี</th> -->
                                            <!-- <th>ภาษี</th> -->
                                            <th>ยอดรวม</th>
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

                                        $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM `orders` where  status='0'  AND order_status='1'  AND status_button='1' $columx $keywordx   ");
                                        $total_records = mysqli_fetch_array($result_count);
                                        $total_records = $total_records['total_records'];
                                        $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                        $second_last = $total_no_of_pages - 1; // total page minus 1

                                        $result = mysqli_query($conn, "SELECT * FROM `orders` where status='0'  AND order_status='1'  AND status_button='1' $columx $keywordx  order by date_create DESC  LIMIT $offset, $total_records_per_page");
                                        while ($row = mysqli_fetch_array($result)) { ?>
                                            <tr>
                                                <td>
                                                    <?php $date = explode(" ", $row['date_create']);
                                                    $dat = datethai2($date[0]);
                                                    echo $dat ?>
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
                                                    $row3 = $rs3->fetch_assoc();
                                                    ?>
                                                    <?= $row2['name'] ?></td>
                                                <td> <?php echo iconv_substr($row3['customer_name'], 0, 30, 'UTF-8'); ?> </td>
                                                <td> <?php echo substr($row3['tel'], 0, 12);  ?> </td>
                                                <td>
                                                    <?php
                                                    $sql2 = "SELECT * FROM amphures   WHERE id= '$row3[district]'";
                                                    $rs2 = $conn->query($sql2);
                                                    $row2 = $rs2->fetch_assoc();
                                                    echo $row2['name_th'];
                                                    ?>
                                                </td>
                                                <td> <?php
                                                        $sql2 = "SELECT * FROM provinces WHERE id= '$row3[province]'";
                                                        $rs2 = $conn->query($sql2);
                                                        $row2 = $rs2->fetch_assoc();
                                                        echo $row2['name_th'];
                                                        ?> </td>
                                                <!-- <td>
                                                    <span class="font-weight-bold"><?php echo number_format($row['discount'], '2', '.', ',') ?> </span>
                                                </td> -->
                                                <!-- <td>
                                                    <?php
                                                    $sqlx4 = "SELECT SUM(total_price) AS total FROM order_details  WHERE order_id= '$row[order_id]'";
                                                    $rsx4 = $conn->query($sqlx4);
                                                    $rowx4 = $rsx4->fetch_assoc();

                                                    ?>
                                                    <?php $sub_total = $rowx4['total'] - $row['discount'];
                                                    $tax = ($sub_total * 100) / 107;
                                                    $tax2 = ($sub_total - $tax);
                                                    $grand_total = ($sub_total - $tax2);

                                                    ?>
                                                    <span class="font-weight-bold"> <?php echo number_format($grand_total, '2', '.', ',') ?> </span>
                                                </td>
                                                <td> <span class="font-weight-bold"> <?php echo number_format($tax2, '2', '.', ',') ?></span> </td> -->
                                                <td>
                                                    <span class="font-weight-bold"> <?php echo number_format($sub_total, '2', '.', ',') ?> </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-warning p-1">เสนอราคา</span>
                                                </td>
                                                <td>
                                                    <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="ออกใบเสนอราคา(QT)" href="/quotation.php?order_id=<?= $row['order_id'] ?>" target="_blank">
                                                        <i class="i-File font-weight-bold"></i>
                                                    </a>
                                                    <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="มัดจำสินค้า(AI)" href="/addai.php?order_id=<?= $row['order_id'] ?>" target="_blank">
                                                        <i class="i-Money-Bag font-weight-bold"></i>
                                                    </a>
                                                    <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ข้ข้อมูล Order" href="/editorder.php?order_id=<?= $row['order_id'] ?>">
                                                        <i class="i-Check font-weight-bold"></i>
                                                    </a>
<?php if($row['cus_type']==2){ ?>
    <button data-toggle="modal" data-target="#medalcf" title="ยืนยันสั่งสินค้าลูกค้าเครดิต" data-id="<?php echo $row['id']; ?>" id="add_cf" class="btn btn-outline-success btn-sm line-height-1"> <i class="i-Yes font-weight-bold"></i> </button>
          </a>
    <?php } ?>

                                                    <button type="button" class="btn btn-outline-danger btn-sm line-height-1" title="ยกเลิก Order" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#myModal_del"> <i class="i-Close-Window font-weight-bold"></i> </button>
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
    <!-- Modal DEL  -->
    <div class="modal fade" id="myModal_del" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
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
                            <div class="form-group col-md-10">
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
     <!-- Modal CF-->
     <div class="modal fade" id="medalcf" tabindex="-1" role="dialog" aria-labelledby="medalconcreteuseTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalconcreteuseTitle-2">ยืนยันลูกค้าเครดิสสั่งสินค้า</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div id="dynamic-content1"></div>

                </div>

            </div>
        </div>
    </div>

    <form class="d-none" method="POST">
        <input type="text" id="FSColumnId" name="column" value="<?php echo $S_COLUMN; ?>" placeholder="">
        <input type="text" id="FSKeywordId" name="keyword" value="<?php echo $S_KEYWORD; ?>" placeholder="">
        <input type="text" id="FSRowId" name="row" value="<?php echo $S_ROW; ?>" placeholder="">
        <input type="number" id="FSPageId" name="page" value="<?php echo $S_PAGE; ?>" placeholder="">
        <button class="btn" id="FSButtonID" type="submit"></button>
    </form>
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
        $("#FSButtonID").click();

    });
    $("#searchNameId").on("change", function() {
        modalLoad();

        let name = $("#searchNameId").val();
        $("#FSKeywordId").val(name);
        let column = $("#searchColumnId").val();
        $("#FSColumnId").val(column);
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
<script>
    $('#myModal_del').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('#del_id').val(id)

    })
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
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
<script>
        $(document).ready(function() {

            $(document).on('click', '#add_cf', function(e) {

                e.preventDefault();

                var uid = $(this).data('id'); // get id of clicked row

                $('#dynamic-content1').html(''); // leave this div blank
                $('#modal-loader').show(); // load ajax loader on button click

                $.ajax({
                        url: 'customercredit_confirm.php',
                        type: 'POST',
                        data: 'id=' + uid,
                        dataType: 'html'
                    })
                    .done(function(data) {
                        console.log(data);
                        $('#dynamic-content1').html(''); // blank before load.
                        $('#dynamic-content1').html(data); // load here
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