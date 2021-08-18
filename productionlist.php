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
if ($action =='edit_prox') {
    // echo"xx";
    $edit_id= $_REQUEST['edit_id'];   
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
 if ($action =='add_stock') {
echo"xx";
$po_id=$_REQUEST['po_id'];
echo"$po_id";
$sql = "SELECT * FROM production_order  WHERE id= '$po_id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$sqlxx = "SELECT *  FROM production_detail  where po_id= '$row[po_id]' ORDER BY id DESC";
$resultxx = mysqli_query($conn, $sqlxx);
if (mysqli_num_rows($resultxx) > 0) {
    while ($rowx = mysqli_fetch_assoc($resultxx)) {
        $product_id=$rowx['product_id'];
     
       $stock_a=$_POST['a_type'][$product_id][++$id];
       $stock_b=$_POST['a_type'][$product_id][++$id2];
       echo 'A'.$stock_a.'B'.$stock_b.'ID'.$product_id.'<br>';

    }}
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
                                            <th>วันที่สั่ง</th>
                                            <th>กำหนดเสร็จ</th>
                                            <th>วันที่เท</th>
                                            <th>กำหนดเทเสร็จ</th>
                                            <th>รหัสสินค้า</th>
                                            <th>จำนวนผลิต</th>
                                            <th>ชื่อสินค้า</th>
                                            <th>หนา</th>
                                            <th>กว้าง</th>
                                            <th>ยาว</th>
                                            <th>ขนาดลวด</th>
                                            <th>จำนวนลวด</th>
                                            <th>พ.ท.(Sq.m)</th>
                                            <th>คอนกรีตคำนวณ</th>
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

                                        $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM `production_order`  ");
                                        $total_records = mysqli_fetch_array($result_count);
                                        $total_records = $total_records['total_records'];
                                        $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                        $second_last = $total_no_of_pages - 1; // total page minus 1

                                        $result = mysqli_query($conn, "SELECT * FROM `production_order`     LIMIT $offset, $total_records_per_page");
                                        while ($row = mysqli_fetch_array($result)) {


                                            $count = mysqli_query($conn, "SELECT COUNT(*) As total FROM production_detail  where po_id = '$row[po_id]' ");
                                            $total = mysqli_fetch_array($count);
                                            $count = 0;
                                            $sqlxx = "SELECT *  FROM production_detail  where po_id = '$row[po_id]'";
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
                                                      
                                                        <td> <?php if ($x == 0) {  $date=explode(" ",$row['po_date'] );
                                                          $dat=datethai2($date[0]); 
                                                          echo '<strong>' .$dat. '</strong>';
                                                        }?>
                                                          
                                                        <td>
                                                        <?php if ($x == 0) {  $date=explode(" ",$row['po_enddate'] );
                                                          $dat=datethai2($date[0]); 
                                                          echo '<strong>' .$dat. '</strong>';
                                                        }?>
                                                       
                                                        <td>
                                                        <?php if ($x == 0) {  $date=explode(" ",$row['po_start'] );
                                                          $dat=datethai2($date[0]); 
                                                          echo '<strong>' .$dat.'-'.$date[1]. '</strong>';
                                                        }?> 
                                                        
                                                       
                                                        <td> 
                                                        <?php if ($x == 0) {  $date=explode(" ",$row['po_stop'] );
                                                          $dat=datethai2($date[0]); 
                                                          echo '<strong>' .$dat.'-'.$date[1]. '</strong>';
                                                        }?>     
                                                      
                                                        <td><?php echo $row2['product_id']; ?></td>
                                                        <td><?php echo $row2['qty']; ?></td>
                                                        <?php
                                                        $sqlx = "SELECT * FROM product   WHERE product_id= '$row2[product_id]'";
                                                        $rsx = $conn->query($sqlx);
                                                        $rowx = $rsx->fetch_assoc();

                                                        ?>
                                                        <td><?php echo $rowx['product_name']; ?></td>
                                                        <td><?php echo $rowx['thickness']; ?></td>
                                                        <td><?php echo $rowx['width']; ?></td>
                                                        <td><?php echo $rowx['size']; ?></td>
                                                        <td> <?php echo $rowx['dia_count']; ?> </td>
                                                        <td> <?php echo $rowx['dia_size']; ?></td>
                                                        <td> <?php echo $row2['sqm']; ?></td>
                                                        <td> <?php echo $row2['concrete_cal']; ?></td>

                                                        <td>
                                                            <?php if ($x == 0) { ?>
                                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ไขข้อมูลสั่งผลิต" href="editproduction.php?po_id=<?php echo $row['po_id']; ?>">
                                                                    <i class="i-Pen-2 font-weight-bold"></i>
                                                                </a>
                                                    
                                                                <button data-toggle="modal" data-target="#medalconcreteuse" title="บันทีกการเทคอนกรีต" data-id="<?php echo $row['id']; ?>" id="edit_pro" class="btn btn-outline-success btn-sm line-height-1">   <i class="i-Gear font-weight-bold"></i> </button>
                                                                <button data-toggle="modal" data-target="#medalstock" title="บันทีกการเทคอนกรีต" data-id="<?php echo $row['id']; ?>" id="edit_stock" class="btn btn-outline-info btn-sm line-height-1">   <i class="i-Check font-weight-bold"></i> </button>
                                                               
                                                                <a class="btn btn-outline-danger btn-sm line-height-1" data-toggle="tooltip" title="ยกเลิกรายการผลิต" href="#">
                                                                    <i class="i-Close-Window font-weight-bold"></i>
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr> <?php

                                                        }
                                                    }
                                                }

                                                mysqli_close($conn);
                                                            ?>
                                        <tr class="table table-hover text-nowrap table-sm">
                                            <td></td>

                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>120</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
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
                                        <li class="page-item"><a class="page-link" href="#" onclick="clickNav(1)" aria-label="Previous"><span aria-hidden="true">«</span><span class="sr-only">Previous</span></a></li>
                                        <!-- <| 123 |> -->
                                        <li class="page-item active"><a class="page-link" href="#" onclick="clickNav(1)">1</a></li>
                                        <!-- <| 123 ...|>  -->

                                        <li class="page-item"><a class="page-link" href="#" onclick="clickNav(1)" aria-label="Next"><span aria-hidden="true">»</span><span class="sr-only">Next</span></a></li>
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
    $('#inputform2').on('keydown', 'input', function(event) {
        if (event.which == 13) {
            event.preventDefault();
            var $this = $(event.target);
            var index = parseFloat($this.attr('data-index'));
            $('[data-index="' + (index + 1).toString() + '"]').focus();
        }
    });
</script>