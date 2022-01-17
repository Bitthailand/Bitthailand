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
    // if ($rowx3['qty']==0){
    //     $sqlx13 = "UPDATE orders  SET order_status='5',error_status='3' WHERE order_id= '$row[order_id]' ";
    //     if ($conn->query($sqlx13) === TRUE) {
    //     }
    // } 
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

                <form name='frmAMain' id='inputform2' class="tab-pane fade active show" method="post">
                    <div class="border-bottom text-primary">
                        <div class="card-title">คำนวณพื้นที่เสารั้วลวดหนาม</div>
                    </div>
                    <div class="form-row mt-3">
                            <div class="row mt-12">
                                <div class="form-group col-md-4">
                                    <label for="product"><strong>สินค้าที่จะผลิต <span class="text-danger">*</span></strong></label>
                                    <select name="productx" id="productx" class="classcus custom-select " required>
                                        <?php
                                        $sql6 = "SELECT *  FROM product where ptype_id='FP'  AND   status='0'  order by product_id  ASC ";
                                        $result6 = mysqli_query($conn, $sql6);
                                        if (mysqli_num_rows($result6) > 0) {
                                            while ($row6 = mysqli_fetch_assoc($result6)) {
                                        ?>
                                                <option value="<?= $row6['id'] ?>" <?php if (isset($productx) && ($productx == $row6['id'])) {
                                                                                        echo "selected"; ?>>
                                                    <?php echo $row6['product_id'] .  $row6['product_name'] . '  หนา' . $row6['thickness'];     ?>
                                                <?php  } else {      ?>
                                                <option value="<?= $row6['id'] ?>"> <?php echo $row6['product_id'] .  $row6['product_name'] . '  หนา' . $row6['thickness'];    ?>
                                                <?php } ?>
                                                </option>
                                        <?php  }
                                        }  ?>
                                    </select>

                                </div>
                                <div class="form-group col-md-2">
                                    <label for="sqm"><strong>พืนที่ <span class="text-danger"></span></strong></label>

                                    <input type="text" name="sqm" id="sqm" value="<?= $sqm ?>" class="classcus form-control" placeholder="พ.ท">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="sqm"><strong>ระยะห่าง <span class="text-danger"></span></strong></label>

                                    <input type="text" name="sqm" id="sqm" value="<?= $sqm ?>" class="classcus form-control" placeholder="ระยะ">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="concrete_cal"><strong>จำนวนมุม <span class="text-danger"></span></strong></label>
                                    <input type="text" name="concrete_cal" id="concrete_cal" value="<?php echo "$concrete_cal"; ?>" class="classcus form-control" placeholder="คำนวณคอนกรีต">
                                </div>
                                <input type="hidden" name="call" value="1" >
                                <button class="btn btn-outline-primary ripple m-1"  name="submit" type="submit"  style=" height: 33px; margin-top: 24px!important;">คำนวณสินค้า</button>
                          
                            </div>
                    </div>
            </div>
        </form>

        <?php 
        $call=$_REQUEST['call'];
      if($call==1){ ?>
    

xzz

            <?php } ?>
        <!-- Header -->
        <?php include './include/footer.php'; ?>
        <!-- =============== Header End ================-->
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
