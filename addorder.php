<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config.php';
$status_order = $_REQUEST['status_order'];
error_reporting(0);
$emp_id = $_SESSION["username"];
echo "$status_order";
if ($status_order == 'new') {
    $sql5 = "SELECT COUNT(id) AS id_run FROM orders   ";
    $rs5 = $conn->query($sql5);
    $row_run = $rs5->fetch_assoc();

    $datetodat = date('Y-m-d');
    $date = explode(" ", $datetodat);
    $dat = datethai_order($date[0]);
    $code_new = $row_run['id_run'] + 1;
    $code = sprintf('%05d', $code_new);
    $order_id = $dat . $code;
    $_SESSION["order_id"] = $order_id;
}
$order_idx = $_SESSION["order_id"];
if ($status_order == 'confirm') {
    $cus_back = $_REQUEST['cus_back'];
    $sql = "SELECT * FROM orders where order_id='$order_idx'  ";
    $rs = $conn->query($sql);
    $rs = $rs->fetch_assoc();
    // ===============
    $sql2 = "SELECT * FROM customer  where customer_id='$rs[cus_id]'  ";
    $rs2 = $conn->query($sql2);
    $rs2 = $rs2->fetch_assoc();
    // ==================
    $sql3 = "SELECT * FROM customer_type  where id='$rs[cus_type]'  ";
    $rs3 = $conn->query($sql3);
    $rs3 = $rs3->fetch_assoc();
    if ($cus_back == 1) {
        $cus_back1 = "รับสินค้ากลับเอง";
    }
    if ($cus_back== 2) {
        $cus_back1 = "บริษัทจัดส่งให้";
    }
    if ($cus_back == 3) {
        $cus_back1 = "รับกลับเองวันหลัง";
    }
    // echo"วิธีรับสินค้า";
    // echo"$discount ";
    $cus_tel = $_REQUEST['cus_tel'];
    $cus_bill_address = $_REQUEST['cus_bill_address'];
    $delivery_datex = $_REQUEST['delivery_datex'];
    $date_confirm = $_REQUEST['date_confirm'];
    $tax = $_REQUEST['tax'];
    $discount = $_REQUEST['discount'];
    $delivery_Address = $_REQUEST['delivery_Address'];
    // echo "$delivery_datex";
    // echo"$discount";
}
$delivery_datex = $_REQUEST['delivery_datex'];

$action = $_REQUEST['action'];
$Fcus_type_name = $_REQUEST['Fcus_type_name'];
$Fcus_type_id = $_REQUEST['Fcus_type_id'];
$Fcus_name = $_REQUEST['Fcus_name'];
$Fcus_id = $_REQUEST['Fcus_id'];
$Fcus_tel = $_REQUEST['Fcus_tel'];
$Fcus_bill_address = $_REQUEST['Fcus_bill_address'];
$Fcus_back = $_REQUEST['Fcus_back'];
$Fdelivery_date = $_REQUEST['Fdelivery_date'];
$Fdelivery_Address = $_REQUEST['Fdelivery_Address'];
$Fdate_confirm = $_REQUEST['Fdate_confirm'];
$tax = $_REQUEST['Ftax'];
$discount = $_REQUEST['Fdiscount'];
$Forder_id = $_REQUEST['Forder_id'];
// echo"$Fcus_back";
if ($action == 'add_product') {

    $Fproduct_type = $_REQUEST['Fproduct_type'];
    $Fproductx = $_REQUEST['Fproductx'];
    $Funit_price = $_REQUEST['Funit_price'];
    $Fqty = $_REQUEST['Fqty'];
    $Forder_id = $_REQUEST['Forder_id'];
    $send_to = $_REQUEST['Fsend_to'];
    $send_price = $_REQUEST['Fsend_price'];
    $send_qty = $_REQUEST['Fsend_qty'];
    $TF = $_REQUEST['FTF'];
    $disunit = $_REQUEST['Fdisunit'];
    $total_disunit = $Funit_price - $disunit;
    $total_price = $Fqty * $total_disunit;
    $tax = $_REQUEST['Ftax'];
$discount = $_REQUEST['Fdiscount'];
    $status_order = 'update';
    $sql5 = "SELECT * FROM product  where  product_id='$Fproductx' ";
    $rs5 = $conn->query($sql5);
    $row5 = $rs5->fetch_assoc();
    if ($TF == 1) {  // ค่าจัดส่ง
        $sql2 = "SELECT * FROM orders  WHERE order_id='$Forder_id'  ";
        $result2 = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($result2) > 0) {
            // echo "orders";
        } else {
            // echo "ordersss";
            $sqlx5 = "INSERT INTO orders (order_id,cus_id,cus_back,cus_type,emp_id,status_button)
    VALUES ('$Forder_id','$Fcus_id','$Fcus_back','$Fcus_type_id','$emp_id','0')";
            if ($conn->query($sqlx5) === TRUE) {
            }
        }
        // ====บันทึกเป็นสินค้าใหม่
        $sql9 = "SELECT COUNT(id) AS id_run FROM product where ptype_id='TF0'  ";
        $rs9 = $conn->query($sql9);
        $row_run = $rs9->fetch_assoc();

        $datetodat = date('Y-m-d');
        $date = explode(" ", $datetodat);
        $dat = datethai_TF($date[0]);
        $code_new = $row_run['id_run'] + 1;
        $code = sprintf('%05d', $code_new);
        $TF_id = $dat . $code;
        echo "$TF_id";
        $sql99 = "INSERT INTO product (product_id,thickness,units,product_name,ptype_id,unit_price)
            VALUES ('$TF_id','0','99','$send_to','TF0','$send_price')";
        if ($conn->query($sql99) === TRUE) {
            $last_id = $conn->insert_id;
            // echo "$last_id";
            // echo"xx";
        }
        $sql5 = "SELECT * FROM product  where  id='$last_id' ";
        $rs5 = $conn->query($sql5);
        $row5 = $rs5->fetch_assoc();
        // =======================
        $send_total = $send_price * $send_qty;
        $sql = "INSERT INTO order_details (order_id,ptype_id,product_id,qty,unit_price,total_price,status_button,emp_id)
        VALUES ('$Forder_id','$Fproduct_type','$row5[product_id]','$send_qty','$send_price','$send_total','0','$emp_id')";
        if ($conn->query($sql) === TRUE) { ?>
            <script>
                $(document).ready(function() {
                    showAlert("บันทึกข้อมูลจัดส่งสำเร็จ", "alert-success");
                });
            </script>
        <?php   }
    } else {
        $sqlx = "SELECT * FROM order_details   WHERE order_id='$Forder_id' AND product_id='$row5[product_id]' ";
        $result = mysqli_query($conn, $sqlx);
        if (mysqli_num_rows($result) > 0) { ?>
            <script>
                $(document).ready(function() {
                    showAlert("ข้อมูลรายการสั่งสินค้าซ้ำไม่สามารถบันทึกได้", "alert-danger");
                });
            </script>
            <?php    } else {
            // สินค้าไม่ซ้ำ ให้มาตรวจสอบ ถ้ามี ==1 ให้ เพิ่มรายการลงในตาราง orders
            $sql2 = "SELECT * FROM orders  WHERE order_id='$Forder_id'  ";
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                // echo "orders";
            } else {
                // echo "o orders";
                $sqlx5 = "INSERT INTO orders (order_id,cus_id,cus_back,cus_type,emp_id,status_button)
        VALUES ('$Forder_id','$Fcus_id','$Fcus_back','$Fcus_type_id','$emp_id','0')";
                if ($conn->query($sqlx5) === TRUE) {
                }
            }
            // echo "in";
            $sql = "INSERT INTO order_details (order_id,ptype_id,product_id,qty,unit_price,total_price,status_button,emp_id,disunit)
            VALUES ('$Forder_id','$Fproduct_type','$Fproductx','$Fqty','$Funit_price','$total_price','0','$emp_id','$disunit')";
            if ($conn->query($sql) === TRUE) { ?>
                <script>
                    $(document).ready(function() {
                        showAlert("บันทึกข้อมูลสำเร็จ", "alert-success");
                    });
                </script>
        <?php   } else{ echo"errr";}
        }
    }
}

if ($action == 'edit') {
    $edit_id = $_REQUEST['edit_id'];
    $qty = $_REQUEST['qty'];
    $total_price = $_REQUEST['total_price'];
    $status_order = 'confirm';
    $sql = "UPDATE order_details    SET qty='$qty',total_price='$total_price'  where id='$edit_id'";
    if ($conn->query($sql) === TRUE) {  ?>
        <script>
            $(document).ready(function() {
                showAlert("แก้ไขข้อมูลจำนวนสั่งสินค้าสำเร็จ", "alert-success");
            });
        </script>
    <?php   }
}
if ($action == 'del') {
    $del_id = $_REQUEST['del_id'];

    $sql = "DELETE FROM order_details WHERE  id='$del_id' ";
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


if ($action == 'add') {
    $order_idx = $_REQUEST['order_idx'];
    $cus_id = $_REQUEST['Fcus_id'];
    $cus_back = $_REQUEST['cus_back'];
    $cus_type = $_REQUEST['customer_type_id'];
    $cus_tel = $_REQUEST['cus_tel'];
    $cus_bill_address = $_REQUEST['cus_bill_address'];
    $delivery_date = $_REQUEST['delivery_date'];
    $delivery_Address = $_REQUEST['delivery_Address'];
    $date_confirm = $_REQUEST['date_confirm'];
    $tax = $_REQUEST['tax'];
    $discount = $_REQUEST['discount'];
    $status_order = 'confirm';
    $delivery_datex = $_REQUEST['delivery_datex'];
    echo"$delivery_datex";
    echo"$discount";
    $sqlx = "SELECT * FROM order_details  WHERE order_id='$order_idx' AND status_button='0' ";
    $result = mysqli_query($conn, $sqlx);
    if (mysqli_num_rows($result) < 1) { ?>
        <script>
            $(document).ready(function() {
                showAlert("ไม่สามารถบันทึกได้เนื่องจากไม่มีรายการสั่งสินค้า", "alert-danger");
            });
        </script>
        <?php    } else {
        echo "$order_idx";
        //   เช็ครหัสสั่งชื้อซ้ำหรือไม่
        $sqlx = "SELECT * FROM orders  WHERE order_id='$order_idx' ";
        $result = mysqli_query($conn, $sqlx);
        if (mysqli_num_rows($result) > 0) {
            echo"$delivery_date";
            $sql = "UPDATE orders   SET cus_id='$cus_id',cus_back='$cus_back',cus_type='$cus_type',emp_id='$emp_id',status_button='1',discount='$discount',tax='$tax' where order_id='$order_idx'";
            echo "$order_idx";
            if($delivery_date='$delivery_date'){
                $sql11 = "UPDATE orders   SET delivery_date='$delivery_datex',delivery_address='$delivery_Address',date_confirm='$date_confirm' where order_id='$order_idx'";
                if ($conn->query($sql11) === TRUE) {}
            }
            $sql7 = "UPDATE order_details  SET status_button='1' where order_id='$order_idx'";
            if ($conn->query($sql7) === TRUE) {
            }
            if ($conn->query($sql) === TRUE) {  ?>
                <script>
                    $(document).ready(function() {
                        showAlert("บันทึกข้อมูลสั่งสินค้าสำเร็จ", "alert-success");
                    });
                </script>
            <?php   }
            // ============ปิดเงื่อนไขการอับเดตรหัสสินค้า
            $sql5 = "SELECT MAX(id) AS id_run FROM quotation ";
            $rs5 = $conn->query($sql5);
            $row_run = $rs5->fetch_assoc();

            $datetodat = date('Y-m-d');
            $date = explode(" ", $datetodat);
            $dat = datethai_qt($date[0]);
            $code_new = $row_run['id_run'] + 1;
            $code = sprintf('%05d', $code_new);
            $qt_id = $dat . $code;
            // =====เช็คสถานะของลูกค้า
            // $cus_type == 1 ลูกค้าเงินสด
            // $cus_type == 2 ลูกค้าเครดิส
            // $cus_back == 1 รับกลับเอง
            // $cus_back == 2 บริษัทจัดส่ง
            // $cus_back == 3 รับกลับเองวันหลัง
            if (($cus_type == 1) && ($cus_back == 1)) {
              
                $sql9 = "UPDATE orders  SET order_status='2'  where  order_id='$order_idx'";
            
                if ($conn->query($sql9) === TRUE) {
                }
            }

            if (($cus_type == 1) && ($cus_back == 2)) {
                $sql8 = "INSERT INTO  quotation(qt_number,order_id)
                VALUES ('$qt_id','$order_idx')";
                $sql9 = "UPDATE orders  SET order_status='1', qt_id='$qt_id',qt_date='$datetodat'  where  order_id='$order_idx'";
                if ($conn->query($sql8) === TRUE) {
                }
                if ($conn->query($sql9) === TRUE) {
                }
            }

            if (($cus_type == 1) && ($cus_back == 3)) {
                $sql8 = "INSERT INTO  quotation(qt_number,order_id)
                VALUES ('$qt_id','$order_idx')";
                $sql9 = "UPDATE orders  SET order_status='1', qt_id='$qt_id',qt_date='$datetodat' where  order_id='$order_idx'";
                if ($conn->query($sql8) === TRUE) {
                }
                if ($conn->query($sql9) === TRUE) {
                }
            }
            if ($cus_type == 2) {
                $sql8 = "INSERT INTO  quotation(qt_number,order_id)
                VALUES ('$qt_id','$order_idx')";
                $sql9 = "UPDATE orders  SET order_status='1',  qt_id='$qt_id',qt_date='$datetodat' where  order_id='$order_idx'";
                if ($conn->query($sql8) === TRUE) {
                }
                if ($conn->query($sql9) === TRUE) {
                }
            }
            // ============ปิดการสร้างรหัส QT


        } else {  ?>
            <script>
                $(document).ready(function() {
                    showAlert("ไม่สามารถบันทึกได้เนื่องจากไม่มีรายการสั่งสินค้า", "alert-danger");
                });
            </script>
<?php
        }
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
            <!-- ============ Body content start ============= -->
            <!-- แจ้งเตือน -->
            <div id="alert_placeholder" style="z-index: 9999999; left:1px; top:1%; width:100%; position:absolute;"></div>
            <!-- ปิดการแจ้งเตือน -->
            <div class="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <!-- <div class="card"> -->
                        <div class="tab-content">
                            <form name='frmAMain' id='inputform2' class="tab-pane fade active show" method="post">
                                <div class="border-bottom text-primary">
                                    <div class="card-title">เพิ่ม Order ใหม่</div>
                                </div>
                                <div class="form-row mt-3">
                                    <div class="form-group col-md-2">
                                        <label for="order_id"><strong>รหัส Order <span class="text-danger"></span></strong></label>
                                        <input type="text" name="order_id" id="order_id" value="<?= $order_idx ?>" class="classcus form-control" placeholder="รหัส Order" required>
                                    </div>
                                    <?php if ($status_order == 'confirm') {
                                    } else { ?>
                                        <button class="btn btn-outline-primary ripple m-1" type="button" data-toggle="modal" data-target="#modalcustomerlist" style=" height: 33px; margin-top: 24px!important;">เลือกลูกค้า</button>
                                        <a class="btn btn-outline-primary m-1" href="/customer.php" type="button" style=" height: 33px; margin-top: 24px!important;">เพิ่มลูกค้าใหม่</a>
                                    <?php } ?>
                                    <div class="form-group col-md-1">
                                        <label for="customer_type"><strong>รับสินค้า <span class="text-danger"></span></strong></label>

                                        <?php if ($status_order == 'confirm') { ?>
                                            <input type="text" value="<?php echo $cus_back1; ?>" class="classcus form-control">
                                        <?php } else { ?>
                                            <select id="cus_back" class="classcus custom-select" name="cus_back">
                                                <option value="1" <?php echo $Fcus_back == '1' ? 'selected' : ''; ?>> รับกลับเอง </option>
                                                <option value="2" <?php echo $Fcus_back == '2' ? 'selected' : ''; ?>>บริษัทส่งให้</option>
                                                <option value="3" <?php echo $Fcus_back == '3' ? 'selected' : ''; ?>>รับกลับเองวันหลัง</option>
                                            </select>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="accNameId"><strong>ประเภทลูกค้า <span class="text-danger"></span></strong></label>
                                        <?php if ($status_order == 'confirm') { ?> <input type="text" value="<?php echo $rs3['name']; ?>" class="classcus form-control">
                                        <?php  } else { ?>
                                            <input type="text" name="customer_type" id="Fcus_type_name" value="<?= $Fcus_type_name ?>" class="classcus form-control" placeholder="ประเภทลูกค้า" required>
                                            <input type="hidden" name="customer_type_id" id="Fcus_type_id" value="<?= $Fcus_type_id ?>" class="classcus form-control">
                                        <?php } ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="accNameId"><strong>ชื่อ-นามสกุล <span class="text-danger"></span></strong></label>
                                        <?php if ($status_order == 'confirm') { ?> <input type="text" value="<?php echo $rs2['customer_name']; ?>" class="classcus form-control" placeholder="ชื่อ-นามสกุล" required>
                                        <?php } else { ?>
                                            <input type="text" name="cus_name" id="Fcus_name" value="<?= $Fcus_name ?>" class="classcus form-control" placeholder="ชื่อ-นามสกุล" required>
                                            <input type="hidden" name="Fcus_id" id="Fcus_id" value="<?= $Fcus_id ?>" class="classcus form-control">
                                        <?php } ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="phone"><strong>เบอร์โทร <span class="text-danger"></span></strong></label>
                                        <?php if ($status_order == 'confirm') { ?>
                                            <input type="text" value="<?= $cus_tel ?>" class="classcus form-control">
                                        <?php } else { ?>
                                            <input type="text" name="cus_tel" id="Fcus_tel" value="<?= $Fcus_tel ?>" class="classcus form-control" placeholder="เบอร์โทร" required>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="accAddressId"><strong>ที่อยู่ <span class="text-danger"></span></strong></label>
                                        <?php if ($status_order == 'confirm') { ?>
                                            <input type="text" class="classcus form-control" value="<?= $cus_bill_address ?>">
                                        <?php } else { ?>
                                            <input type="text" name="cus_bill_address" class="classcus form-control" id="Fcus_bill_address" value="<?= $Fcus_bill_address ?>" placeholder="ที่อยู่" required="">
                                        <?php } ?>
                                    </div>
                                    <div class="row mt-12">

                                        <div class="form-group col-md-2">
                                            <label for="product_type"><strong>ประเภท <span class="text-danger"></span></strong></label>


                                            <select name="product_type" id="product_type" class="classcus custom-select ">
                                                <?php
                                                $sql6 = "SELECT *  FROM product_type  order by id ASC ";
                                                $result6 = mysqli_query($conn, $sql6);
                                                if (mysqli_num_rows($result6) > 0) {
                                                    while ($row6 = mysqli_fetch_assoc($result6)) {
                                                ?>
                                                        <option value="<?= $row6['ptype_id'] ?>" <?php if (isset($row['ptype_id']) && ($row['ptype_id'] == $row6['ptype_id'])) {
                                                                                                        echo "selected"; ?>>
                                                            <?= $row6['ptype_name'] ?>
                                                        <?php  } else {      ?>
                                                        <option value="<?= $row6['ptype_id'] ?>"> <?= $row6['ptype_name'] ?>
                                                        <?php } ?>
                                                        </option>
                                                <?php  }
                                                }  ?>

                                            </select>


                                        </div>

                                        <div class="form-group col-md-4">
                                            <div id="ifYes1" style="display: block;">
                                                <label for="product"><strong>สินค้าที่สั่งชื้อ <span class="text-danger"></span></strong></label>
                                                <select name="productx" id="productx" style="display:block;" class="classcus custom-select" data-index="1">
                                                    <option value="">เลือกสินค้าสั่งชื้อ</option>
                                                </select>
                                            </div>
                                            <div id="ifYes" style="display: none;">
                                                <label for="product"><strong>สถานที่จัดส่ง<span class="text-danger"></span></strong></label>
                                                <input type="text" name="send_to" id="send_to" class="classcus form-control" placeholder="สถานที่จัดส่ง">
                                            </div>

                                        </div>

                                        <div class="form-group col-md-1" id="ifYes_price" style="display: block;">
                                            <label for="qty"><strong>ราคา <span class="text-danger"></span></strong></label>
                                            <input type="text" name="unit_price" id="unit_price" class="classcus form-control" placeholder="ราคาต่อหน่วย" disabled>
                                        </div>
                                        <div class="form-group col-md-2" id="ifYes_price1" style="display: none;">
                                            <label for="qty"><strong>ราคาจัดส่ง <span class="text-danger"></span></strong></label>
                                            <input type="text" name="send_price" id="send_price" class="classcus form-control" placeholder="ราคาค่าจัดส่ง">
                                        </div>

                                        <div class="form-group col-md-1" id="ifYes_dis" style="display: block;">
                                            <label for="qty"><strong>ส่วนลด <span class="text-danger"></span></strong></label>
                                            <input type="text" name="disunit" id="disunit" class="classcus form-control" placeholder="ลดต่อหน่วย">
                                        </div>
                                        <div class="form-group col-md-1" id="ifYes_price2" style="display: block;">
                                            <label for="stock1"><strong>โรงงาน1 <span class="text-danger"></span></strong></label>
                                            <input type="text" name="stock1" id="stock1" class="classcus form-control" placeholder="จำนวนสินค้า" disabled>
                                        </div>

                                        <div class="form-group col-md-1" id="ifYes_price3" style="display: block;">
                                            <label for="stock1"><strong>โรงงาน2 <span class="text-danger"></span></strong></label>
                                            <input type="text" name="stock2" id="stock2" class="classcus form-control" placeholder="จำนวนสินค้า" disabled>
                                        </div>

                                        <div class="form-group col-md-1" id="ifYes_qty" style="display: block;">
                                            <label for="qty"><strong>จำนวนที่สั่ง <span class="text-danger"></span></strong></label>
                                            <input type="text" name="qty" id="qty" class="classcus form-control" placeholder="จำนวนสั่ง" data-index="1" onkeyup="calculate()">
                                        </div>
                                        <div class="form-group col-md-2" id="ifYes_qty2" style="display: none;">
                                            <label for="qty"><strong>จำนวนรอบ <span class="text-danger"></span></strong></label>
                                            <input type="text" name="send_qty" id="send_qty" value="<?= $send_qty ?>" class="classcus form-control" placeholder="จำนวนสั่ง" data-index="1" onkeyup="calculate1()">
                                            <input type="hidden" name="TF" id="TF" class="classcus form-control">
                                        </div>
                                        <?php if ($status_order == 'confirm') {
                                        } else {  ?>
                                            <div class="form-group col-md-1">
                                                <input type="hidden" name="order_id" id="Forder_id" value="<?php echo "$order_id"; ?>">
                                                <button class="btn btn-outline-primary ripple m-1" type="button" id="btu" style=" height: 33px; margin-top: 24px!important;">เพิ่มรายการ</button>
                                            </div>
                                        <?php } ?>
                                        <!-- ============ Table Start ============= -->
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-hover text-nowrap table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>รหัสสินค้า</th>
                                                            <th>ประเภทสินค้า</th>
                                                            <th>ชื่อสินค้า</th>
                                                            <th>ราคาต่อหน่วย</th>
                                                            <th>ลดต่อหน่วย</th>
                                                            <th>จำนวนที่สั่ง</th>
                                                            <th>รวมเป็นเงิน</th>
                                                            <?php if ($status_order == 'confirm') {
                                                            } else { ?><th>Action</th> <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql_pro = "SELECT * FROM order_details  where order_id='$order_idx' order by date_create  ASC ";
                                                        $result_pro = mysqli_query($conn, $sql_pro);
                                                        if (mysqli_num_rows($result_pro) > 0) {
                                                            while ($row_pro = mysqli_fetch_assoc($result_pro)) { ?>
                                                                <tr>
                                                                    <td> <strong><?= $row_pro['product_id'] ?></strong> </td>
                                                                    <td>
                                                                        <?php
                                                                        $sql2 = "SELECT * FROM product_type   WHERE ptype_id= '$row_pro[ptype_id]'";
                                                                        $rs2 = $conn->query($sql2);
                                                                        $row2 = $rs2->fetch_assoc();
                                                                        echo $row2['ptype_name'];
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        $sql3 = "SELECT * FROM product  WHERE product_id= '$row_pro[product_id]'";
                                                                        $rs3 = $conn->query($sql3);
                                                                        $row3 = $rs3->fetch_assoc();
                                                                        echo $row3['product_name'];
                                                                        ?>
                                                                    </td>
                                                                    <td> <?= $row_pro['unit_price'] ?> </td>
                                                                    <td> <?= $row_pro['disunit'] ?> </td>
                                                                    <td> <?= $row_pro['qty'] ?></td>
                                                                    <td><?= $row_pro['total_price'] ?> </td>
                                                                    <?php if ($status_order == 'confirm') {
                                                                    } else { ?> <td>
                                                                            <button type="button" class="btn btn-outline-success btn-sm line-height-1" data-id="<?php echo $row_pro['id']; ?>" data-toggle="modal" data-target="#Modaledit" id="edit_po"> <i class="i-Pen-2 font-weight-bold"></i> </button>

                                                                            <button type="button" class="btn btn-outline-danger btn-sm line-height-1" data-id="<?php echo $row_pro['id']; ?>" data-toggle="modal" data-target="#myModal_del" data-toggle="tooltip" title="ยกเลิกรายการสั่งสินค้า"> <i class="i-Close-Window font-weight-bold"></i> </button>
                                                                        </td>
                                                                    <?php } ?>
                                                                </tr>
                                                        <?php }
                                                        } ?>

                                                        <tr>
                                                            <td colspan="14"> &nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- ============ Table End ============= -->
                                    </div>
                                    <div  class="form-group col-md-2" id="cus_back_show" style="display: none;">
                                        <div class="form-group">
                                            <label for="delivery_date">กำหนดส่งสินค้า</label>
                                                <input id="delivery_date" name="delivery_datex" value="<?php echo"$delivery_datex"; ?>" class="form-control" type="date" min="2021-06-01" >
                                        </div>
                                    </div>
                                    <?php if ($status_order == 'confirm') { 
                                      
                                            if (empty($delivery_datex)) { }else{
                                        ?>
                                        <div  class="form-group col-md-2">
                                                 <label for="delivery_date">กำหนดส่งสินค้า<span class="text-danger"></span></strong></label>
                                                <input value="<?php echo"$delivery_datex"; ?>" class="form-control" type="text" readonly>
                                                </div>
                                                <div class="form-group col-md-8">
                                                <label for="delivery_Address"><strong>ที่อยู่ จัดส่ง<span class="text-danger"></span></strong></label>
                                                <input type="text" value="<?= $delivery_Address ?>" class="classcus form-control" readonly>  
                                            </div>
                                            <div class="form-group col-md-1">
                                            <label for="date_confirm"><strong>ยืนยันใน(วัน) <span class="text-danger"></span></strong></label>
                                            <input type="text" value="<?= $date_confirm ?>" class="classcus form-control" readonly>
                                            </div>
                                                <?php  }} ?>
                                            
                                    <div class="form-group col-md-8" id="cus_back_show1" style="display: none;">
                                        <label for="delivery_Address"><strong>ที่อยู่ จัดส่ง<span class="text-danger"></span></strong></label>
                                        <?php if ($status_order == 'confirm') { ?>
                                            <input type="text" value="<?= $delivery_Address ?>" class="classcus form-control">
                                        <?php  } else { ?>
                                            <input type="text" name="delivery_Address" value="<?= $Fdelivery_Address ?>" class="classcus form-control" id="delivery_Address" placeholder="ที่อยู่">
                                        <?php } ?>
                                    </div>
                                    <div class="form-group col-md-1" id="cus_back_show2" style="display: none;">
                                        <label for="date_confirm"><strong>ยืนยันใน(วัน) <span class="text-danger"></span></strong></label>

                                        <?php if ($status_order == 'confirm') { ?>
                                            <input type="text" value="<?= $date_confirm ?>" class="classcus form-control">
                                        <?php  } else { ?>
                                            <input type="text" name="date_confirmx" id="date_confirm" value="<?= $Fdate_confirm ?>" class="classcus form-control" placeholder="ยืนยันราคาใน" Value="0">
                                        <?php } ?>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <?php $Ftax = 7; ?>
                                        <?php 
                                            $tax=$_REQUEST['tax'];
                                                 if (empty($tax)) {
                                                    $tax='7';
                                                 }else{
                                             
                                                $tax=$tax;
                                            }
                                                ?>
                                        <label for="tax"><strong>ภาษี(%) <span class="text-danger"></span></strong></label>
                                        <?php if ($status_order == 'confirm') { ?>
                                            <input type="text" value="<?php echo "$tax"; ?>" class="classcus form-control">
                                        <?php  } else { ?>
                                            <input type="text" name="tax" id="tax" value="<?php echo "$tax"; ?>" class="classcus form-control" placeholder="ภาษี">
                                        <?php } ?>
                                    </div>
                                    <?php 
                                            $discount=$_REQUEST['discount'];
                                                 if (empty($discount)) {
                                                    $discount='0';
                                                 }else{
                                             
                                                $discount=$discount;
                                            }
                                                ?>
                                    <div class="form-group col-md-1">
                                        <label for="discount"><strong>ส่วนลด(บาท) <span class="text-danger"></span></strong></label>
                                        <?php if ($status_order == 'confirm') { ?>
                                            <input type="text" value="<?= $discount ?>" class="classcus form-control">
                                        <?php  } else { ?>
                                           
                                            <input type="text" name="discount" id="discount" value="<?=$discount?>" class="classcus form-control" placeholder="ส่วนลด">
                                        <?php } ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-right">
                                    <input class="d-none" id="addAccId" type="text" name="acc_id" value="" placeholder="">
                                    <input class="d-none" id="addActionId" type="text" name="action" value="add" placeholder="">
                                    <?php if ($status_order == 'confirm') {
                                        $sql = "SELECT * FROM orders where order_id='$order_idx'  ";
                                        $rs = $conn->query($sql);
                                        $rs = $rs->fetch_assoc();
                                        echo "ประเภทลูกค้า".$rs['cus_type'];
                                        echo "รับกลับ".$rs['cus_back'];
                                    ?>
                                        <?php if (($rs['cus_type'] == 1) && ($rs['cus_back'] == 1)) { ?>
                                            <a class="btn btn-outline-primary m-1" href="/hs.php?order_id=<?= $rs['order_id'] ?>" type="button" target="_blank">ออกใบเสร็จรับเงิน(HS)</a>
                                            <a class="btn btn-outline-primary m-1" href="/addsaleorder.php?order_id=<?= $rs['order_id'] ?>" type="button" target="_blank" id="SO">ออกใบส่งของ(SO)</a>
                                        <?php } ?>
                                        <?php if (($rs['cus_type'] == 1) && ($rs['cus_back'] == 2)) { ?>
                                            <a class="btn btn-outline-primary m-1" href="/quotation.php?order_id=<?= $rs['order_id'] ?>" type="button" target="_blank">ออกใบเสนอราคา(QT)</a>
                                        <?php } ?>
                                        <?php if (($rs['cus_type'] == 1) && ($rs['cus_back'] == 3)) { ?>
                                            <a class="btn btn-outline-primary m-1" href="/quotation.php?order_id=<?= $rs['order_id'] ?>" type="button" target="_blank">ออกใบเสนอราคา(QT)</a>
                                        <?php } ?>
                                        <?php if ($rs['cus_type'] == 2) { ?>
                                            <a class="btn btn-outline-primary m-1" href="/quotation.php?order_id=<?= $rs['order_id'] ?>" type="button" target="_blank">ออกใบเสนอราคา(QT)</a>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <button id="btnAddId" class="btn btn-outline-primary d-none" type="submit">ยืนยัน Order</button>
                                        <button class="btn btn-primary ladda-button btn-add" data-style="expand-left">
                                            <input type="hidden" name="order_idx" value="<?php echo "$order_idx"; ?>">
                                            <input type="hidden" name="status_order" value="confirm">
                                            <input type="hidden" name="action" value="add">
                                            <span class="ladda-label">ยืนยัน Order</span>
                                        </button>
                                    <?php } ?>
                                    <a class="btn btn-outline-danger m-1" href="/quotationlist.php" type="button">กลับหน้ารายการ Order</a>
                                </div>
                            </form>
                        </div>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
            <!-- Header -->
            <?php include './include/footer.php'; ?>
            <!-- =============== Header End ================-->
        </div>
    </div>
    <!--  -->

    <div id="Modaledit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fa fa-pencil"></i>
                        แก้ไขข้อมูลสั่งสินค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id='inputform2' method="post" name="myform">
                        <!-- mysql data will be load here -->
                        <div id="dynamic-content"></div>
                        <input type="hidden" id="Ecus_name" name="Fcus_name" value="<?php echo $Fcus_name; ?>" placeholder="">
                        <input type="hidden" id="Ecus_id" name="Fcus_id" value="<?php echo $Fcus_id; ?>" placeholder="">
                        <input type="hidden" id="Ecus_type_id" name="Fcus_type_id" value="<?php echo $Fcus_type_id; ?>" placeholder="">
                        <input type="hidden" id="Ecus_type_name" name="Fcus_type_name" value="<?php echo $Fcus_type_name; ?>" placeholder="">
                        <input type="hidden" id="Ecus_tel" name="Fcus_tel" value="<?php echo $Fcus_tel; ?>" placeholder="">
                        <input type="hidden" id="Ecus_bill_address" name="Fcus_bill_address" value="<?php echo $Fcus_bill_address; ?>" placeholder="">
                        <input type="hidden" id="Ecus_back" name="Fcus_back" value="<?php echo $Fcus_back; ?>" placeholder="">
                        <input type="hidden" id="Edelivery_date" name="Fdelivery_date" value="<?php echo $Fdelivery_date ?>" placeholder="">
                        <input type="hidden" id="Edelivery_Address" name="Fdelivery_Address" value="<?php echo $Fdelivery_Address; ?>" placeholder="">
                        <input type="hidden" id="Edate_confirm" name="Fdate_confirm" value="<?php echo $Fdate_confirm; ?>" placeholder="">
                        <input type="hidden" id="Etax" name="Ftax" value="<?php echo $Ftax; ?>" placeholder="">
                        <input type="hidden" id="Eorder_id" name="Forder_id" value="<?php echo $Forder_id; ?>" placeholder="">
                        <input type="hidden" id="Ediscount" name="Fdiscount" value="<?php echo $Fdiscount; ?>" placeholder="">

                    </form>
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
                            <input type="hidden" name="status_order" value="update">
                            <input type="hidden" name="del_id" id="del_id" value="">
                            <input type="hidden" id="Dcus_name" name="Fcus_name" value="<?php echo $Fcus_name; ?>" placeholder="">
                            <input type="hidden" id="Dcus_id" name="Fcus_id" value="<?php echo $Fcus_id; ?>" placeholder="">
                            <input type="hidden" id="Dcus_type_id" name="Fcus_type_id" value="<?php echo $Fcus_type_id; ?>" placeholder="">
                            <input type="hidden" id="Dcus_type_name" name="Fcus_type_name" value="<?php echo $Fcus_type_name; ?>" placeholder="">
                            <input type="hidden" id="Dcus_tel" name="Fcus_tel" value="<?php echo $Fcus_tel; ?>" placeholder="">
                            <input type="hidden" id="Dcus_bill_address" name="Fcus_bill_address" value="<?php echo $Fcus_bill_address; ?>" placeholder="">
                            <input type="hidden" id="Dcus_back" name="Fcus_back" value="<?php echo $Fcus_back; ?>" placeholder="">
                            <input type="hidden" id="Ddelivery_date" name="Fdelivery_date" value="<?php echo $Fdelivery_date ?>" placeholder="">
                            <input type="hidden" id="Ddelivery_Address" name="Fdelivery_Address" value="<?php echo $Fdelivery_Address; ?>" placeholder="">
                            <input type="hidden" id="Ddate_confirm" name="Fdate_confirm" value="<?php echo $Fdate_confirm; ?>" placeholder="">
                            <input type="hidden" id="Dtax" name="Ftax" value="<?php echo $Ftax; ?>" placeholder="">
                            <input type="hidden" id="Dorder_id" name="Forder_id" value="<?php echo $Forder_id; ?>" placeholder="">
                            <input type="hidden" id="Ddiscount" name="Fdiscount" value="<?php echo $Fdiscount; ?>" placeholder="">
                            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span>
                                DELETE</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal เลือกรายการลูกค้า -->
    <div class="modal fade" id="modalcustomerlist" tabindex="-1" role="dialog" aria-labelledby="medalmodalcustomerlistTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalmodalcustomerlistTitle-2">เลือกรายการลูกค้า</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="col-auto">
                        <div class="text-left">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="form-group">
                                        <label for="searchNameId"> ค้นหา</label>
                                        <input id="myInput" class="form-control" placeholder="ใส่คำที่ต้องการค้นหา" type="text" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============ Table Start ============= -->
                        <div class="modal-content">
                            <div id="productionorder" class="table-responsive">
                                <table role="table" class="table table-hover text-nowrap table-sm">
                                    <thead>
                                        <tr class="table-secondary">
                                            <th>เลือก</th>
                                            <th>รหัสลูกค้า</th>
                                            <th>ชื่อลูกค้า</th>
                                            <th>ที่อยู่</th>

                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                                        <?php
                                        $sqlxx = "SELECT *  FROM customer  order by customer_id  DESC";
                                        $resultxx = mysqli_query($conn, $sqlxx);
                                        if (mysqli_num_rows($resultxx) > 0) {
                                            while ($row1 = mysqli_fetch_assoc($resultxx)) {

                                        ?>
                                                <tr data-toggle="modal" data-id="3" data-target="#orderModal">

                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="cus_id" id="cus_id<?php echo $row1['id']; ?>" value="<?php echo $row1['id']; ?>" onclick="selection()" data-dismiss="modal">
                                                            <label class="btn btn-outline-primary" for="cus_id<?php echo $row1['id']; ?>">เลือกลูกค้า</label><br>
                                                        </div>
                                                    </td>
                                                    <td> <?php echo $row1['customer_id']; ?> </td>
                                                    <td><?php echo "$row1[customer_name]"; ?></td>
                                                    <td><?php echo "$row1[bill_address]"; ?></td>

                                            <?php }
                                        } ?>

                                    </tbody>
                                </table>
                                <div class="modal-footer">


                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">ปิด</button>
                                    <button class="btn btn-secondary " type="button" onclick="selection()" data-dismiss="modal">เลือกลูกค้า</button>

                                </div>
                            </div>
                        </div>
                        <!-- ============ Table End ============= -->

                    </div>

                </div>
            </div>
        </div>
        <form class="d-none" method="POST">

            <input type="text" id="FFcus_type_name" name="Fcus_type_name" value="<?php echo $Fcus_type_name; ?>" placeholder="">
            <input type="text" id="FFcus_type_id" name="Fcus_type_id" value="<?php echo $Fcus_type_id; ?>" placeholder="">
            <input type="text" id="FFcus_name" name="Fcus_name" value="<?php echo $Fcus_name; ?>" placeholder="">
            <input type="text" id="FFcus_id" name="Fcus_id" value="<?php echo $Fcus_id; ?>" placeholder="">
            <input type="text" id="FFcus_tel" name="Fcus_tel" value="<?php echo $Fcus_tel; ?>" placeholder="">
            <input type="text" id="FFcus_bill_address" name="Fcus_bill_address" value="<?php echo $Fcus_bill_address; ?>" placeholder="">
            <input type="text" id="FFcus_back" name="Fcus_back" value="<?php echo $Fcus_back; ?>" placeholder="">
            <input type="text" id="FFdelivery_date" name="Fdelivery_date" value="<?php echo $Fdelivery_date ?>" placeholder="">
            <input type="text" id="FFdelivery_Address" name="Fdelivery_Address" value="<?php echo $Fdelivery_Address; ?>" placeholder="">
            <input type="text" id="FFdate_confirm" name="Fdate_confirm" value="<?php echo $Fdate_confirm; ?>" placeholder="">
            <input type="text" id="FFtax" name="Ftax" value="<?php echo $Ftax; ?>" placeholder="">
            <input type="text" id="FForder_id" name="Forder_id" value="<?php echo $Forder_id; ?>" placeholder="">
            <input type="text" id="FFdiscount" name="Fdiscount" value="<?php echo $Fdiscount; ?>" placeholder="">
            <input type="text" id="FFproduct_type" name="Fproduct_type" value="<?php echo $Fproduct_type; ?>" placeholder="">
            <input type="text" id="FFproductx" name="Fproductx" value="<?php echo $Fproductx; ?>" placeholder="">
            <input type="text" id="FFunit_price" name="Funit_price" value="<?php echo $Funit_price; ?>" placeholder="">
            <input type="text" id="FFsend_to" name="Fsend_to" value="<?php echo $Fsend_to; ?>" placeholder="">
            <input type="text" id="FFsend_qty" name="Fsend_qty" value="<?php echo $Fsend_qty; ?>" placeholder="">
            <input type="text" id="FFsend_price" name="Fsend_price" value="<?php echo $Fsend_price; ?>" placeholder="">
            <input type="text" id="FFdisunit" name="Fdisunit" value="<?php echo $Fdisunit; ?>" placeholder="">
            <input type="text" id="FFTF" name="FTF" value="<?php echo $FTF; ?>" placeholder="">



            <input type="text" id="status_order" name="status_order" value="update" placeholder="">
            <input type="text" id="FFqty" name="Fqty" value="<?php echo $Fqty; ?>" placeholder="">

            <input type="text" name="action" value="add_product">
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
        <script src="../../dist-assets/js/script_product_type.js"></script>


        <!--  -->
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
        <script>
            $('#myModal_del').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var modal = $(this)
                modal.find('#del_id').val(id)
                let Fcus_type_name = $("#Fcus_type_name").val();
                let Fcus_type_id = $("#Fcus_type_id").val();
                let Fcus_id = $("#Fcus_id").val();
                let Fcus_name = $("#Fcus_name").val();
                let Fcus_tel = $("#Fcus_tel").val();
                let Fcus_bill_address = $("#Fcus_bill_address").val();
                let Fcus_back = $("#cus_back").val();
                let Fdelivery_date = $("#delivery_date").val();
                let Fdelivery_Address = $("#delivery_Address").val();
                let Fdate_confirm = $("#date_confirm").val();
                let Ftax = $("#tax").val();
                let Fdiscount = $("#discount").val();
                let Forder_id = $("#order_id").val();
                $("#Dcus_type_name").val(Fcus_type_name);
                $("#Dcus_type_id ").val(Fcus_type_id);
                $("#Dcus_id").val(Fcus_id);
                $("#Dcus_name").val(Fcus_name);
                $("#Dcus_tel").val(Fcus_tel);
                $("#Dcus_bill_address").val(Fcus_bill_address);
                $("#Ddelivery_date").val(Fdelivery_date);
                $("#Ddelivery_Address").val(Fdelivery_Address);
                $("#Ddate_confirm").val(Fdate_confirm);
                $("#Dtax").val(Ftax);
                $("#Ddiscount").val(Fdiscount);
                $("#Dcus_back").val(Fcus_back);
                $("#Dorder_id").val(Forder_id);
                console.log('Fcus_type_name', Fcus_type_name);
            })
        </script>
        <!-- ============ Modal Script End ============ -->
        <script>
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

            function selection() {

                let cusid = $("input:radio[name=cus_id]:checked").val()
                if (cusid === undefined || cusid === '') {
                    alert('xxxx');
                } else {
                    console.log('dds', cusid)
                    $.get('get_customer.php?cus_id=' + cusid, function(data) {
                        var result = JSON.parse(data);
                        console.log('cus', result)
                        $.each(result, function(index, cus) {
                            $("#Fid").val(cus.id);
                            $("#Fcus_id").val(cus.customer_id);
                            $("#Fcus_name").val(cus.customer_name);
                            $("#Fcus_tel").val(cus.tel);
                            $("#Fcus_type_id").val(cus.customer_type);

                            //    
                            $.get('get_customer_type.php?type_id=' + cus.customer_type, function(data) {
                                var result = JSON.parse(data);
                                console.log('cus_type', result)
                                $.each(result, function(index, custype) {
                                    $("#Fcus_type_name").val(custype.name);
                                });
                            });
                            $.get('get_district1.php?subdistrict_id=' + cus.subdistrict, function(data) {
                                var result = JSON.parse(data);
                                console.log('cus_subdistrict', result)
                                $.each(result, function(index, subdistrict) {
                                    let bill = cus.bill_address + ' ' + 'ตำบล.' + subdistrict.TUM + ' อำเภอ.' + subdistrict.AUM + ' จังหวัด.' + subdistrict.PRO;
                                    $("#Fcus_bill_address").val(bill);
                                });
                            });
                            // 
                        });
                    });
                }
            }
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
            $("#cus_back").on("change", function() {
                // modalLoad();

                let cus_back = $("#cus_back").val();
                console.log('cus', cus_back)
                if (cus_back == 1) {
                    document.getElementById("cus_back_show").style.display = "none";
                    document.getElementById("cus_back_show1").style.display = "none";
                    document.getElementById("cus_back_show2").style.display = "none";
                   
                }
                if (cus_back == 2) {
                    document.getElementById("cus_back_show").style.display = "block";
                    document.getElementById("cus_back_show1").style.display = "block";
                    document.getElementById("cus_back_show2").style.display = "block";

                }
                if (cus_back == 3) {
                    document.getElementById("cus_back_show").style.display = "none";
                    document.getElementById("cus_back_show1").style.display = "none";
                    document.getElementById("cus_back_show2").style.display = "none";

                }


            });

            function calculate() {
                let qty = $("#qty").val();
                let stock1S = $("#stock1").val();
                let stock2S = $("#stock2").val();
                let s_cus_back = $("#cus_back").val();
                let sum_stock1x = 0;
                console.log('stock1S', stock1S)
                console.log('stock2S', stock2S)
                sum_stock1x = Number(stock1S) + Number(stock2S);
                if (s_cus_back == 1) {
                    console.log('stock1xxx', sum_stock1x);
                    if (sum_stock1x == 0) {
                        document.getElementById("btu").disabled = true;

                    }
                    if (sum_stock1x <= qty) {
                        document.getElementById("btu").disabled = true;

                    } else {
                        document.getElementById("btu").disabled = false;

                    }
                } else {
                    document.getElementById("btu").disabled = false;
                }

                console.log('qty', qty);

            };
            function calculate1() {
                let send_qty = $("#send_qty").val();
                let send_price = $("#send_price").val();
                console.log('send_qty ', send_qty);
                console.log('send_price', send_price);

                if (send_qty == 0 || send_qty == undefined || send_qty == '') {
                    document.getElementById("btu").disabled = true;

                } else {
                    document.getElementById("btu").disabled = false;
                }

            };
            $("#btu").click("change", function() {
                modalLoad();

                let Fqty = $("#qty").val();
                let Fproductx = $("#productx").val();
                let Fproduct_type = $("#product_type").val();
                let Funit_price = $("#unit_price").val();
                // ==================
                let Fcus_type_name = $("#Fcus_type_name").val();
                let Fcus_type_id = $("#Fcus_type_id").val();
                let Fcus_id = $("#Fcus_id").val();
                let Fcus_name = $("#Fcus_name").val();
                let Fcus_tel = $("#Fcus_tel").val();
                let Fcus_bill_address = $("#Fcus_bill_address").val();
                let Fcus_back = $("#cus_back").val();
                let Fdelivery_date = $("#delivery_date").val();
                let Fdelivery_Address = $("#delivery_Address").val();
                let Fdate_confirm = $("#date_confirm").val();
                let Ftax = $("#tax").val();
                let Fdiscount = $("#discount").val();
                let Forder_id = $("#order_id").val();
                let Fdisunit = $("#disunit").val();

                // ==============สถานที่จัดส่ง
                let send_to = $("#send_to").val();
                let send_price = $("#send_price").val();
                let send_qty = $("#send_qty").val();
                let TF = $("#TF").val();

                console.log('send_to', send_to)
                console.log('send_price', send_price)
                console.log('send_qty', send_qty)

                $("#FFsend_to").val(send_to);
                $("#FFsend_price").val(send_price);
                $("#FFsend_qty").val(send_qty);
                $("#FFTF").val(TF);
                // =============
                $("#FFqty").val(Fqty);
                $("#FFproductx").val(Fproductx);
                $("#FFproduct_type").val(Fproduct_type);
                $("#FFunit_price").val(Funit_price);
                // =================================
                $("#FFcus_type_name").val(Fcus_type_name);
                $("#FFcus_type_id ").val(Fcus_type_id);
                $("#FFcus_id").val(Fcus_id);
                $("#FFcus_name").val(Fcus_name);
                $("#FFcus_tel").val(Fcus_tel);
                $("#FFcus_bill_address").val(Fcus_bill_address);
                $("#FFdelivery_date").val(Fdelivery_date);
                $("#FFdelivery_Address").val(Fdelivery_Address);
                $("#FFdate_confirm").val(Fdate_confirm);
                $("#FFtax").val(Ftax);
                $("#FFdiscount").val(Fdiscount);
                $("#FFcus_back").val(Fcus_back);
                $("#FForder_id").val(Forder_id);
                $("#FFdisunit").val(Fdisunit);
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
            $(document).ready(function() {
                $(document).on('click', '#edit_po', function(e) {
                    e.preventDefault();
                    var uid = $(this).data('id'); // get id of clicked row

                    let Fcus_type_name = $("#Fcus_type_name").val();
                    let Fcus_type_id = $("#Fcus_type_id").val();
                    let Fcus_id = $("#Fcus_id").val();
                    let Fcus_name = $("#Fcus_name").val();
                    let Fcus_tel = $("#Fcus_tel").val();
                    let Fcus_bill_address = $("#Fcus_bill_address").val();
                    let Fcus_back = $("#cus_back").val();
                    let Fdelivery_date = $("#delivery_date").val();
                    let Fdelivery_Address = $("#delivery_Address").val();
                    let Fdate_confirm = $("#date_confirm").val();
                    let Ftax = $("#tax").val();
                    let Fdiscount = $("#discount").val();
                    let Forder_id = $("#order_id").val();
                    $("#Ecus_type_name").val(Fcus_type_name);
                    $("#Ecus_type_id ").val(Fcus_type_id);
                    $("#Ecus_id").val(Fcus_id);
                    $("#Ecus_name").val(Fcus_name);
                    $("#Ecus_tel").val(Fcus_tel);
                    $("#Ecus_bill_address").val(Fcus_bill_address);
                    $("#Edelivery_date").val(Fdelivery_date);
                    $("#Edelivery_Address").val(Fdelivery_Address);
                    $("#Edate_confirm").val(Fdate_confirm);
                    $("#Etax").val(Ftax);
                    $("#Ediscount").val(Fdiscount);
                    $("#Ecus_back").val(Fcus_back);
                    $("#Eorder_id").val(Forder_id);
                    console.log('Fdelivery_Address', Fdelivery_Address)




                    $('#dynamic-content').html(''); // leave this div blank
                    $('#modal-loader').show(); // load ajax loader on button click
                    $.ajax({
                            url: 'addorder_edit.php',
                            type: 'POST',
                            data: 'id=' + uid,
                            dataType: 'html'
                        })
                        .done(function(data) {
                            console.log('data', data);
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