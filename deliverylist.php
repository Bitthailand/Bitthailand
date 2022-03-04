<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
$emp_id = $_SESSION["username"];
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
$event_msg = "รายการจัดส่งสินค้า";
$sql_event = "INSERT INTO log (order_id,emp_id,event)
VALUES ('0 ','$emp_id','$event_msg')";
if ($conn->query($sql_event) === TRUE) {
}


$action = $_REQUEST['action'];
if ($action == 'add_emp') {
    $dev_id = $_REQUEST['dev_id'];
    $dev_employee = $_REQUEST['dev_employee'];
    $dev_check = $_REQUEST['dev_check'];
    //    echo"$po_stop";
    //    echo"$po_start";
    $sqlxxx = "UPDATE delivery  SET dev_employee='$dev_employee',dev_check='$dev_check' where id='$dev_id'";
    if ($conn->query($sqlxxx) === TRUE) { ?>
        <script>
            $(document).ready(function() {
                showAlert("บันทึกข้อมูลพนักงานจัดส่งเรียบร้อย", "alert-primary");
            });
        </script>
    <?php }
}

if ($action == 'add_cfx') {
    $dev_id = $_REQUEST['dev_id'];

    //    echo"$po_stop";
    //    echo"$dev_id";
    $sql = "SELECT * FROM delivery WHERE id= '$dev_id'";
    $rs = $conn->query($sql);
    $row = $rs->fetch_assoc();
    if ($row['cus_type'] == 1) {
        $sqlxxx1 = "UPDATE delivery  SET status_chk='1',status_payment='1' where id='$dev_id'";
        if ($conn->query($sqlxxx1) === TRUE) {
        }
        $sql5 = "UPDATE deliver_detail  SET status_cf='1',payment='1' where dev_id='$row[dev_id]'";
        if ($conn->query($sql5) === TRUE) {
        }
    } else {
        $sqlxxx1 = "UPDATE delivery  SET status_chk='1',status_payment='0' where id='$dev_id'";
        if ($conn->query($sqlxxx1) === TRUE) {
        }
        $sql5 = "UPDATE deliver_detail  SET status_cf='1',payment='0' where dev_id='$row[dev_id]'";
        if ($conn->query($sql5) === TRUE) {
        }
    }


    $sql1 = "SELECT * FROM orders WHERE order_id= '$row[order_id]'";
    $rs1 = $conn->query($sql1);
    $row1 = $rs1->fetch_assoc();


    $sqlx2 = "SELECT * FROM order_details WHERE order_id = '$row[order_id]' AND ptype_id='TF'";
    $rsx2 = $conn->query($sqlx2);
    $rowx2 = $rsx2->fetch_assoc();


    $sqlx3 = "SELECT * FROM order_details WHERE order_id = '$row[order_id]' AND ptype_id='TF0'";
    $rsx3 = $conn->query($sqlx3);
    $rowx3 = $rsx3->fetch_assoc();



    $sqlc0 = "SELECT COUNT(*) AS ts2  FROM delivery   WHERE   order_id= '$row[order_id]' AND status_chk='1' ";
    $rsc0 = $conn->query($sqlc0);
    $rowc0 = $rsc0->fetch_assoc();
    // echo $rowc0['ts2'].'<br>'.$rowc1['ts'] ;
    if ($rowx2['qty'] == $rowc0['ts2']) {
        $sqlx12 = "UPDATE orders  SET order_status='5' WHERE order_id= '$row[order_id]' ";
        if ($conn->query($sqlx12) === TRUE) {
        }
    }

    if ($rowx3['qty'] == $rowc0['ts2']) {
        $sqlx12 = "UPDATE orders  SET order_status='5',error_status='2' WHERE order_id= '$row[order_id]' ";
        if ($conn->query($sqlx12) === TRUE) {
        }
    }

    $event_msg = "ยืนยันการส่งสินค้าวิธีรับโดย บริษัทจัดส่งสินค้า ใบสั่งชื้อ $row[order_id] เลขที่จัดส่ง $dev_id ";
    $sql_event = "INSERT INTO log (order_id,emp_id,event)
    VALUES ('$row[order_id] ','$emp_id','$event_msg')";
    if ($conn->query($sql_event) === TRUE) {
    }
    if ($row['cus_back']==3){
        $event_msg = "ยืนยันการส่งสินค้าวิธีรับโดย ลูกค้ารับกลับเอง ใบสั่งชื้อ $row[order_id] เลขที่จัดส่ง $dev_id ";
        $sql_event = "INSERT INTO log (order_id,emp_id,event)
        VALUES ('$row[order_id] ','$emp_id','$event_msg')";
        if ($conn->query($sql_event) === TRUE) {
        }

        $sqlx13 = "UPDATE orders  SET order_status='5',error_status='3' WHERE order_id= '$row[order_id]' ";
        if ($conn->query($sqlx13) === TRUE) {
        }
    } 
    ?>
    <script>
        $(document).ready(function() {
            showAlert("ยืนยันการจัดส่งเรียบร้อย", "alert-primary");
        });
    </script>
    <?php
}


if ($action == 'add_hs') {
    $e_id = $_REQUEST['e_id'];
    $so_id = $_REQUEST['so_id'];
    $order_id = $_REQUEST['order_id'];

    //    echo"$po_stop";
    //    echo"$po_start";
    $sql5 = "SELECT count(id) AS id_run FROM hs_number  ";
    $rs5 = $conn->query($sql5);
    $row_run = $rs5->fetch_assoc();
    $dev_status = $row['dev_status'];
    $datetodat = date('Y-m-d');
    $date = explode(" ", $datetodat);
    $dat = datethai_HS($date[0]);
    $code_new = $row_run['id_run'] + 1;
    $code = sprintf('%05d', $code_new);
    $hs_id = $dat . $code;

    $sqlx = "SELECT * FROM hs_number  WHERE order_id='$order_id' AND so_id='$so_id' ";
    $result = mysqli_query($conn, $sqlx);
    if (mysqli_num_rows($result) > 0) {
    } else {
        $sqlx5 = "INSERT INTO hs_number (order_id,so_id,hs_id)
    VALUES ('$order_id','$so_id','$hs_id')";
        if ($conn->query($sqlx5) === TRUE) {
        }
    }
    $sqlxxx = "UPDATE delivery  SET hs_id='$hs_id' where id='$e_id'";
    if ($conn->query($sqlxxx) === TRUE) { ?>
        <script>
            $(document).ready(function() {
                // showAlert("บันทึกข้อมูลพนักงานจัดส่งเรียบร้อย", "alert-primary");

                window.open('hs.php?order_id=<?= $order_id ?>&so_id=<?= $so_id ?>', '_blank');
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
    <title>ขนส่งสินค้า</title>
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
                                <a class="linkLoadModalNext nav-link active" href="/deliverylist.php">
                                    <?php
                                    $count0 = "SELECT COUNT(*) As total_records FROM delivery where  status='0' AND status_chk='0' ";
                                    $rs_count0 = $conn->query($count0);
                                    $rcount0 = $rs_count0->fetch_assoc();
                                    ?>
                                    <h3 class="h5 font-weight-bold"> รายการส่งสินค้า
                                        <span class="badge badge-pill badge-danger"><?= $rcount0['total_records'] ?></span>
                                    </h3>
                                    <span>รายการส่งสินค้าที่ออกใบ SO แล้วอยู่ระหว่างการส่ง
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link" href="/deliverysuccess.php">
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
                                        <span class="ul-widget__desc "> รายการสินค้ากำลังรอส่ง </span>
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
                                        <th>ประเภท</th>
                                        <th>รับสินค้า</th>
                                        <th>เบอร์โทร</th>
                                        <th>ที่อยู่ส่ง</th>
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

                                    $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM `delivery` where  status='0' AND status_chk='0'    $columx $keywordx  ORDER BY date_create DESC ");
                                    $total_records = mysqli_fetch_array($result_count);
                                    $total_records = $total_records['total_records'];
                                    $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                    $second_last = $total_no_of_pages - 1; // total page minus 1

                                    $result = mysqli_query($conn, "SELECT * FROM `delivery` where status='0'  AND status_chk='0'   $columx $keywordx ORDER BY date_create DESC  LIMIT $offset, $total_records_per_page");
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
                                                    $sql3 = "SELECT * FROM employee_check  WHERE id= '$row[dev_employee]'";
                                                    $rs3 = $conn->query($sql3);
                                                    $row3 = $rs3->fetch_assoc();
                                                    echo "$row3[name]";
                                                    ?>
                                            </td>
                                            <td> <?php
                                                    $sql4 = "SELECT * FROM employee_check  WHERE id= '$row[dev_check]'";
                                                    $rs4 = $conn->query($sql4);
                                                    $row4 = $rs4->fetch_assoc();
                                                    echo "$row4[name]";

                                                    ?></td>
                                            <td>
                                                <h5> <span class="badge badge-success  "> <?php
                                                                                            $sql5 = "SELECT * FROM customer WHERE customer_id= '$row1[cus_id]'";
                                                                                            $rs5 = $conn->query($sql5);
                                                                                            $row5 = $rs5->fetch_assoc();
                                                                                            echo $row5['customer_name']; ?></span></h5>
                                            </td>
                                            <td> <?php
                                                    $sqlct = "SELECT * FROM customer_type  WHERE  id= '$row1[cus_type]'";
                                                    $rsct = $conn->query($sqlct);
                                                    $rowct = $rsct->fetch_assoc();
                                                    echo $rowct['name']; ?> </td>
                                            <td> <?php
                                                    $sqlcb = "SELECT * FROM customer_back  WHERE  id= '$row1[cus_back]'";
                                                    $rscb = $conn->query($sqlcb);
                                                    $rowcb = $rscb->fetch_assoc();
                                                    echo $rowcb['name']; ?> </td>
                                            <td> <?php echo substr($row5['tel'], 0, 12);  ?> </td>
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

                                                echo " ต." . $row6['name_th'] . "  อ." . $row7['name_th'] . " จ." . $row8['name_th'];
                                                ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-outline-info btn-sm line-height-1" data-toggle="tooltip" title="แก้ไขข้อมูล Orderที่ออกใบจัดส่งแล้ว" href="/editorder_step2.php?order_id=<?= $row['order_id'] ?>&dev_id=<?= $row['dev_id'] ?>">
                                                    <i class="i-Check font-weight-bold"></i>
                                                </a>
                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="ออกใบส่งของ(SO)" href="/saleorder.php?order_id=<?= $row['order_id'] ?>&so_id=<?= $row['dev_id'] ?>" target="_blank">
                                                    <i class="i-Lock-2 font-weight-bold"></i>
                                                </a>
                                                <?php if ($row['hs_id'] == '0') { ?>
                                                    <button data-toggle="modal" data-target="#medalhs" title="ออกใบเสร็จรับเงิน(HS)" data-id="<?php echo $row['id']; ?>" id="add_hs" class="btn btn-outline-success btn-sm line-height-1"> <i class="i-Car-Items font-weight-bold"></i> </button>
                                                <?php } else {  ?>
                                                    <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="ออกใบเสร็จรับเงิน(HS)" href="/hs.php?order_id=<?= $row['order_id'] ?>&so_id=<?= $row['dev_id'] ?>" target="_blank">
                                                        <i class="i-Car-Items font-weight-bold"></i>
                                                    </a>
                                                <?php } ?>
                                                <?php if ($row['iv_id'] == '0' || $row['iv_id'] == '') { ?>

                                                <?php } else {  ?>
                                                    <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="ออกใบกำกับสินค้า(IV)" href="/invoice.php?order_id=<?= $row['order_id'] ?>&so_id=<?= $row['dev_id'] ?>" target="_blank">
                                                        <i class="i-Car-Items font-weight-bold"></i>
                                                    </a>
                                                <?php } ?>
                                                <button data-toggle="modal" data-target="#medalemp" title="กำหนดพนักงานส่ง" data-id="<?php echo $row['id']; ?>" id="add_emp" class="btn btn-outline-success btn-sm line-height-1"> <i class="i-Add-User font-weight-bold"></i> </button>

                                                <button data-toggle="modal" data-target="#medalcf" title="ยืนยันส่งสินค้า" data-id="<?php echo $row['id']; ?>" id="add_cf" class="btn btn-outline-success btn-sm line-height-1"> <i class="i-Check font-weight-bold"></i> </button>
                                                <a class='btn btn-outline-success btn-sm line-height-1' title='คืนสินค้า' href='/refun_so.php?order_id=<?= $row['order_id'] ?>&so_id=<?= $row['dev_id'] ?>' target='_blank'> <i class='i-Repeat-2 font-weight-bold'></i></a>
                                            </td>
                                        </tr><?php
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
            <!-- Header -->
            <?php include './include/footer.php'; ?>
            <!-- =============== Header End ================-->
        </div>
    </div>


    <!-- Modal บันทึกสต็อก-->
    <div class="modal fade" id="medalemp" tabindex="-1" role="dialog" aria-labelledby="medalconcreteuseTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalconcreteuseTitle-2">กำหนดพนักงานส่งและตรวจสอบ</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div id="dynamic-content"></div>

                </div>

            </div>
        </div>
    </div>
    <!-- Modal CF-->
    <div class="modal fade" id="medalcf" tabindex="-1" role="dialog" aria-labelledby="medalconcreteuseTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalconcreteuseTitle-2">ยืนยันส่งสินค้า</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div id="dynamic-content1"></div>

                </div>

            </div>
        </div>
    </div>

    <!-- Modal HS-->
    <div class="modal fade" id="medalhs" tabindex="-1" role="dialog" aria-labelledby="medalconcreteuseTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalconcreteuseTitle-2">ยืนยันการออกใบเสร็จรับเงิน</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div id="dynamic-content2"></div>

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
                    <p class="text-Success text-16 line-height-1 mb-2">ยืนยันส่งสินค้า Sale Order ID : <span id="message"></span> เรียบร้อยใช่หรือไม่ ?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">ไม่ใช่</button>
                    <button class="btn btn-primary ml-2" type="button">ใช่</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $(document).on('click', '#add_emp', function(e) {

                e.preventDefault();

                var uid = $(this).data('id'); // get id of clicked row

                $('#dynamic-content').html(''); // leave this div blank
                $('#modal-loader').show(); // load ajax loader on button click

                $.ajax({
                        url: 'delivery_emp.php',
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

            $(document).on('click', '#add_cf', function(e) {

                e.preventDefault();

                var uid = $(this).data('id'); // get id of clicked row

                $('#dynamic-content1').html(''); // leave this div blank
                $('#modal-loader').show(); // load ajax loader on button click

                $.ajax({
                        url: 'delivery_confirm.php',
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

    <script>
        $(document).ready(function() {

            $(document).on('click', '#add_hs', function(e) {

                e.preventDefault();

                var uid = $(this).data('id'); // get id of clicked row

                $('#dynamic-content2').html(''); // leave this div blank
                $('#modal-loader').show(); // load ajax loader on button click

                $.ajax({
                        url: 'hs_confirm.php',
                        type: 'POST',
                        data: 'id=' + uid,
                        dataType: 'html'
                    })
                    .done(function(data) {
                        console.log(data);
                        $('#dynamic-content2').html(''); // blank before load.
                        $('#dynamic-content2').html(data); // load here
                        $('#modal-loader').hide(); // hide loader  
                    })
                    .fail(function() {
                        $('#dynamic-content2').html(
                            '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                        );
                        $('#modal-loader').hide();
                    });

            });
        });
    </script>
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