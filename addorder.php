<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config.php';
include './include/config_so.php';
$status_order = $_REQUEST['status_order'];
error_reporting(0);
$emp_id = $_SESSION["username"];
// echo "$status_order";
$order_id = $_REQUEST['order_id'];
// echo"$order_id";
// echo"$status_order";
if ($status_order == 'Mnew') {
    $order_id = $_REQUEST['order_id'];
    $sqlx = "SELECT * FROM orders   WHERE order_id='$order_id' ";
    $result = mysqli_query($conn, $sqlx);
    if (mysqli_num_rows($result) > 0) {
?>
        <script>
            $(document).ready(function() {
                showAlert("รหัสใบสั่งชื้อซ้ำ", "alert-danger");
                window.location = 'addorder.php'
            });
        </script>
        <?php } else {
        $_SESSION["order_id"] = $order_id;
    }
}
if ($status_order == 'new') {
    $date_month = date('Y-m');
    $sql5 = "SELECT COUNT(id) AS id_run FROM orders_number where date_month='$date_month'  AND status_use='2'  ";
    $rs5 = $conn->query($sql5);
    $row_run = $rs5->fetch_assoc();
    
    $datetodat = date('Y-m-d');
    $date = explode(" ", $datetodat);
    $dat = datethai_order($date[0]);
    $code_new = $row_run['id_run'] + 1;
    $code = sprintf('%03d', $code_new);
    $order_id = $dat . $code;
    $_SESSION["order_id"] = $order_id;

    $sqlx5 = "INSERT INTO orders_number (order_id,emp_id,status_use,date_month)
    VALUES ('$order_id','$emp_id','1','$date_month')";
    if ($conn->query($sqlx5) === TRUE) { }
}
$order_idx = $_SESSION["order_id"];
$Forder_idx = $_SESSION["order_id"];
// echo"$order_idx";
// echo"$status_order";
if ($status_order == 'confirm') {
    // echo"$order_idx";
    // $order_id = $_REQUEST['Forder_id'];
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
    // echo"$rs3[name]";
    if ($cus_back == 1) {
        $cus_back1 = "รับสินค้ากลับเอง";
    }
    if ($cus_back == 2) {
        $cus_back1 = "บริษัทจัดส่งให้";
    }
    if ($cus_back == 3) {
        $cus_back1 = "รับกลับเองวันหลัง";
    }
    // echo"วิธีรับสินค้า";
    // echo"$discount ";
    $cus_tel = $_REQUEST['cus_tel'];
    $cus_bill_address = $_REQUEST['cus_bill_address'];
    $Fcus_type_name = $_REQUEST['Fcus_type_name'];
    $Fcus_type_id = $_REQUEST['Fcus_type_id'];
    $Fcus_name = $_REQUEST['Fcus_name'];
    $Fcus_id = $_REQUEST['Fcus_id'];
    $delivery_datex = $_REQUEST['delivery_datex'];
    $date_confirm = $_REQUEST['date_confirm'];
    $tax = $_REQUEST['tax'];
    $discount = $_REQUEST['discount'];
    $delivery_Address = $_REQUEST['delivery_Address'];
    $Fdate_confirm = $_REQUEST['date_confirmx'];
    $tax = $_REQUEST['Ftax'];
    $discount = $_REQUEST['Fdiscount'];
    // echo "$delivery_datex";
    // echo"$Fdate_confirm";
    $datecf = $Fdate_confirm;
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
if ($action == 'add_product') {
    $Fproduct_type = $_REQUEST['Fproduct_type'];
    $Fproductx = $_REQUEST['Fproductx'];
    $Funit_price = $_REQUEST['Funit_price'];
    $Fqty = $_REQUEST['Fqty'];
    $Fqty2 = $_REQUEST['Fqty2'];
    $qty = $_REQUEST['qty'];
    $Forder_id = $_REQUEST['Forder_id'];
    $Fcus_id = $_REQUEST['Fcus_id'];
    $Fcus_type_name = $_REQUEST['Fcus_type_name'];
    $Fcus_type_id = $_REQUEST['Fcus_type_id'];
    $Fcus_name = $_REQUEST['Fcus_name'];
    $Fcus_id = $_REQUEST['Fcus_id'];
    $Fcus_tel = $_REQUEST['Fcus_tel'];
    $Fcus_bill_address = $_REQUEST['Fcus_bill_address'];
    $Fcus_back = $_REQUEST['Fcus_back'];
    $send_to = $_REQUEST['Fsend_to'];
    $send_price = $_REQUEST['Fsend_price'];
    $send_qty = $_REQUEST['Fsend_qty'];
    $TF = $_REQUEST['FTF'];
    $disunit = $_REQUEST['Fdisunit'];
    $sumQTY = $Fqty + $Fqty2;
    $total_disunit = $Funit_price - $disunit;
    $total_price = $sumQTY * $total_disunit;
    $tax = $_REQUEST['Ftax'];
    $discount = $_REQUEST['Fdiscount'];
    $status_order = 'update';
    $Fcus_back = $_REQUEST['Fcus_back'];
    // echo "$Fproductx";
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
                                if ($conn->query($sqlx5) === TRUE) { }
                                $sql112 = "UPDATE orders_number  SET status_use='2' where order_id='$Forder_id'";
                                if ($conn->query($sql112) === TRUE) { }

                  }
                 // ====บันทึกเป็นสินค้าใหม่
                  $sql9 = "SELECT COUNT(id) AS id_run FROM product where ptype_id='TF0'  ";
                    $rs9 = $conn->query($sql9);
                    $row_run = $rs9->fetch_assoc();
                    $datetodat = date('Y-m-d');
                    $date = explode(" ", $datetodat);
                    $dat = datethai_TF($date[0]);
                    $code_new = $row_run['id_run'] + 1;
                    $code = sprintf('%04d', $code_new);
                    $TF_id = $dat . $code;
                 $sql99 = "INSERT INTO product (product_id,thickness,units,product_name,ptype_id,unit_price)
                            VALUES ('$TF_id','0','99','$send_to','TF0','$send_price')";
                            if ($conn->query($sql99) === TRUE) {
                             $last_id = $conn->insert_id;
              }
                    $sql5 = "SELECT * FROM product  where  id='$last_id' ";
                    $rs5 = $conn->query($sql5);
                    $row5 = $rs5->fetch_assoc();
        // =======================
                     $send_total = $send_price * $send_qty;
                $sql = "INSERT INTO order_details (order_id,ptype_id,product_id,qty,unit_price,total_price,status_button,emp_id,status_chk_stock,qty_out)
                        VALUES ('$Forder_id','$Fproduct_type','$row5[product_id]','$send_qty','$send_price','$send_total','0','$emp_id','TF','$send_qty')";
                          if ($conn->query($sql) === TRUE) { ?>
                 <script>
                     $(document).ready(function() {
                    showAlert("บันทึกข้อมูลจัดส่งสำเร็จ", "alert-success");
                 });
                </script>
        <?php   }
         } else { //ปิดบันทึกค่าจัดส่ง
                $sqlx = "SELECT * FROM order_details   WHERE order_id='$Forder_id' AND product_id='$row5[product_id]' ";
                $result = mysqli_query($conn, $sqlx);
                if (mysqli_num_rows($result) > 0) { ?>
                        <script>
                            $(document).ready(function() {
                                showAlert("ข้อมูลรายการสั่งสินค้าซ้ำไม่สามารถบันทึกได้", "alert-danger");
                            });
                        </script>
          <?php  } else {
              echo"xxxx";
            // สินค้าไม่ซ้ำ ให้มาตรวจสอบ ถ้ามี ==1 ให้ เพิ่มรายการลงในตาราง orders
                $sql2 = "SELECT * FROM orders  WHERE order_id='$Forder_id'  ";
                $result2 = mysqli_query($conn, $sql2);
                         if (mysqli_num_rows($result2) > 0) {
                         } else {
                     $sqlx5 = "INSERT INTO orders (order_id,cus_id,cus_back,cus_type,emp_id,status_button)
                                VALUES ('$Forder_id','$Fcus_id','$Fcus_back','$Fcus_type_id','$emp_id','0')";
                                if ($conn->query($sqlx5) === TRUE) {}
                                $sql112 = "UPDATE orders_number  SET status_use='2' where order_id='$Forder_id'";
                                if ($conn->query($sql112) === TRUE) { }
                         } //ปิดบันทึก order
            // echo "in";
            // ลูกค้ารับกลับเอง ต้องเช็ตสต็อค
            if ($Fcus_back == 1) {  //ลูกค้ารับกลับเอง
                         $sql5 = "SELECT * FROM product  where  product_id='$Fproductx' ";
                         $rs5 = $conn->query($sql5);
                         $row5 = $rs5->fetch_assoc();
                         $sum_qty = $Fqty + $Fqty2;
                         if ($row['fac1_stock'] < $Fqty) {
                             $chk1 = 'true';
                         } else {
                             $chk1 = 'false';
                         }
                         if ($row['fac2_stock'] < $Fqty2) {
                             $chk2 = 'true';
                         } else {
                             $chk2 = 'false';
                         }
                         if ($chk1 == 'true' && $chk2 = 'true') {
                                 $sqlx4 = "INSERT INTO order_details (order_id,ptype_id,product_id,qty,unit_price,total_price,status_button,emp_id,status_chk_stock,face1_stock_out,face2_stock_out,qty_out)
                                     VALUES ('$Forder_id','$Fproduct_type','$Fproductx','$sum_qty','$Funit_price','$total_price','0','$emp_id','CB2','$Fqty','$Fqty2','0')";
                                    if ($conn->query($sqlx4) === TRUE) { ?>
                                    <script>
                                        $(document).ready(function() {
                                            showAlert("บันทึกข้อมูลสำเร็จ", "alert-success");
                                        });
                                    </script>
                              <?php   } //      
                              } else {
                                         // echo "errALL";
                                 } //ถ้าไม่ใช้ รับกลับเอง ก็ให้ใช้เงื่อนไขต่อไป
                 }
                  else
                 {
                         $sqlyy = "INSERT INTO order_details (order_id,ptype_id,product_id,qty,unit_price,total_price,status_button,emp_id,disunit,status_chk_stock,qty_out)
                                   VALUES ('$Forder_id','$Fproduct_type','$Fproductx','$Fqty','$Funit_price','$total_price','0','$emp_id','$disunit','CB','$Fqty')";
                                    if ($conn->query($sqlyy) === TRUE) { ?>
                                    <script>
                                        $(document).ready(function() {
                                            showAlert("บันทึกข้อมูลสำเร็จ", "alert-success");
                                        });
                                    </script>
                              <?php   } else {
                              // echo "errr";
                                         }
                 } //ปิด เช็คสถานะรับกลับ
            // 

        }
    }
}
$action1 = $_REQUEST['action1'];
// echo "$action1";
// echo "$Fcus_back";
if ($action1 == 'chk_cusback') {

    $Fproduct_type = $_REQUEST['Fproduct_type'];
    $Fproductx = $_REQUEST['Fproductx'];
    $Funit_price = $_REQUEST['Funit_price'];
    $Fqty = $_REQUEST['Fqty'];
    $Fqty2 = $_REQUEST['Fqty2'];
    $qty = $_REQUEST['qty'];
    $Forder_id = $_REQUEST['Forder_id'];

    if ($Fcus_back == 1) {
        // echo "$Forder_id", "$Fproductx";
        $sql_pro = "SELECT * FROM order_details  WHERE  order_id='$Forder_id' AND (status_chk_stock='CB' OR status_chk_stock='TF')  AND status_button='0' ";
        $result_pro = mysqli_query($conn, $sql_pro);
        if (mysqli_num_rows($result_pro) > 0) {
            while ($row_pro = mysqli_fetch_assoc($result_pro)) {
                $sql = "DELETE FROM order_details  WHERE  product_id='$row_pro[product_id]' ";
                if ($conn->query($sql) === TRUE) {
                }
            }
        }
    }
}
if ($action == 'edit') {
    $edit_id = $_REQUEST['edit_id'];
    $edit_id = $_REQUEST['edit_id'];
    $qty = $_REQUEST['qty'];
    $total_price = $_REQUEST['total_price'];
    $face1_out = $_REQUEST['face1_out'];
    $face2_out = $_REQUEST['face2_out'];
    $total_price = $_REQUEST['total_price'];

    $sql = "UPDATE order_details    SET qty='$qty',qty_out='$qty',total_price='$total_price',face1_stock_out='$face1_out',face2_stock_out='$face2_out' where id='$edit_id'";
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
    $date_confirm = $_REQUEST['date_confirmx'];
    $tax = $_REQUEST['tax'];
    $discount = $_REQUEST['discount'];
    $status_order = 'confirm';
    $delivery_datex = $_REQUEST['delivery_datex'];
    $sqlx = "SELECT * FROM order_details  WHERE order_id='$order_idx' AND status_button='0' AND status_delivery='0' ";
    $result = mysqli_query($conn, $sqlx);
    if (mysqli_num_rows($result) < 1) 
    { ?>
                <script>
                    $(document).ready(function() {
                        showAlert("ไม่สามารถบันทึกได้เนื่องจากไม่มีรายการสั่งสินค้า", "alert-danger");
                    });
                </script>
     <?php } 
     else
    {
            // ลูกค้ารับกลับเอง เงินสด
        if (($cus_type == 1) && ($cus_back == 1)) {
            // echo "ค้นหา ORDER ว่ามีหรือไม่";
              $sqlx = "SELECT * FROM orders  WHERE order_id='$order_idx' ";
                 $result = mysqli_query($conn, $sqlx);
                 if (mysqli_num_rows($result) > 0) 
                 {
                        $sql88 = "UPDATE orders   SET cus_id='$cus_id',cus_back='$cus_back',cus_type='$cus_type',emp_id='$emp_id',status_button='1',discount='$discount',tax='$tax',error='2' where order_id='$order_idx'";
                                  if ($conn->query($sql88) === TRUE) {   }
                                  $sql112 = "UPDATE orders_number   SET status_use='2',status_cf='1' where order_id='$order_idx'";
                                  if ($conn->query($sql112) === TRUE) { }
                        if ($delivery_date = '$delivery_date')
                         {
                                $sql11 = "UPDATE orders   SET delivery_date='$delivery_datex',delivery_address='$delivery_Address',date_confirm='30',error='3'  where order_id='$order_idx'";
                                          if ($conn->query($sql11) === TRUE) { }
                         } //if ($delivery_date = '$delivery_date') 
                  } else {
                // ถ้ายังไม่มี ORDER ให้เพิ่ม
                // echo "xx2";
                         $sqlx5 = "INSERT INTO orders (order_id,cus_id,cus_back,cus_type,emp_id,status_button)
                                      VALUES ('$order_idx','$cus_id','$cus_back','$cus_type_id','$emp_id','1')";
                                    if ($conn->query($sqlx5) === TRUE) {  }
                         $sql11 = "UPDATE orders   SET delivery_date='$delivery_datex',delivery_address='$delivery_Address',date_confirm='30',error='4'  where order_id='$order_idx'";
                                    if ($conn->query($sql11) === TRUE) { }
                                    $sql112 = "UPDATE orders_number   SET status_use='2' ,status_cf='1' where order_id='$order_idx'";
                                    if ($conn->query($sql112) === TRUE) { }
                 } //ปิดการเพิ่ม ORDER
            //   echo "เช็คสต็อกจาก Product";
            // ลูกค้าเครดิส CB2 รับกลับเอง
            $sql_pro = "SELECT * FROM order_details  WHERE  order_id='$order_idx' AND status_chk_stock='CB2'   AND status_button='0' AND status_delivery='0' ";
            $result_pro = mysqli_query($conn, $sql_pro);
            if (mysqli_num_rows($result_pro) > 0) {
                while ($row_pro = mysqli_fetch_assoc($result_pro)) {
                    // echo "เรียกรหัสสินค้า มาเช็คสต็อก", $row_pro['product_id'];
                    $sqlx3 = "SELECT * FROM product  WHERE product_id= '$row_pro[product_id]'";
                    $rsx3 = $conn->query($sqlx3);
                    $row2 = $rsx3->fetch_assoc();
                    $fac1_stock = $row2['fac1_stock'];
                    $fac2_stock = $row2['fac2_stock'];
                    $sum_dev = $row_pro['face1_stock_out'] + $row_pro['face2_stock_out'];
                    // echo"$sum_dev";
                    //   เทียบสต็อก
                    // echo "จำนวนสต็อกที่สั่ง" . $row_pro['face1_stock_out'];
                    if ($fac1_stock >= $row_pro['face1_stock_out']) { //จำนวนที่สั่งต้องน้อยกว่าสต็อก
                        $stock1 = $fac1_stock - $row_pro['face1_stock_out'];
                        $sql112 = "UPDATE product  SET fac1_stock='$stock1' where product_id='$row2[product_id]'";
                        if ($conn->query($sql112) === TRUE) {   }
                    } else {
                        echo "error";
                    }
                    if ($fac2_stock >= $row_pro['face2_stock_out']) { //จำนวนที่สั่งต้องน้อยกว่าสต็อก
                        $stock2 = $fac2_stock - $row_pro['face2_stock_out'];
                        $sql222 = "UPDATE product  SET  fac1_stock2='$stock2' where product_id='$row2[product_id]'";
                        if ($conn->query($sql222) === TRUE) { }
                    } else {
                        echo "error";
                    }
                    // echo "อับเดตสถานะรายละเอียดสินค้า" . $sum_dev;
                    if (($cus_type == 1) && ($cus_back == 1)) {
                    $sql71 = "UPDATE order_details  SET status_button='1',qty_dev='$sum_dev',status_delivery='1',error='1'  where order_id='$order_idx' AND product_id='$row_pro[product_id]' ";
                    if ($conn->query($sql71) === TRUE) {}
                    //    บันทึกข้อมูลลงตารางจัดส่ง
                    }
                }
            }
                    $sql5 = "SELECT MAX(id) AS id_run FROM delivery ";
                    $rs5 = $conn->query($sql5);
                    $row_run = $rs5->fetch_assoc();
                    $dev_status = $row['dev_status'];
                    $datetodat = date('Y-m-d');
                    $date = explode(" ", $datetodat);
                    $dat = datethai_so($date[0]);
                    $code_new = $row_run['id_run'] + 1;
                    $code = sprintf('%05d', $code_new);
                    $dev_id = $dat . $code;
                        // ตรวจสอบเลขจัดส่ง
                   $sqlx12 = "UPDATE orders  SET dev_status='1',dev_id='$dev_id',delivery_date='$datetodat',order_status='5',status_button='1'  WHERE order_id= '$order_idx'";
                              if ($conn->query($sqlx12) === TRUE) {   }
                              $sql112 = "UPDATE orders_number   SET status_use='2' ,status_cf='1' where order_id='$order_idx'";
                              if ($conn->query($sql112) === TRUE) { }
                    $sqlxx = "SELECT *  FROM delivery  where order_id= '$order_idx' AND dev_id='$dev_id' ";
                                 $resultxx = mysqli_query($conn, $sqlxx);
                             if (mysqli_num_rows($resultxx) > 0) 
                             {
                             } else {
                                 // echo "tt"; cus_id='$cus_id',cus_back='$cus_back',cus_type='$cus_type'
                                 $sqlx = "INSERT INTO delivery(dev_id,order_id,dev_date,status_chk,cus_id,cus_back,cus_type)
                                          VALUES ('$dev_id','$order_idx','$datetodat','1','$cus_id','$cus_back','$cus_type')";
                                          if ($conn->query($sqlx) === TRUE) {}
                                $sql_pro2 = "SELECT * FROM order_details  WHERE  order_id='$order_idx' ";
                                $result_pro2 = mysqli_query($conn, $sql_pro2);
                                if (mysqli_num_rows($result_pro2) > 0) {
                                    while ($row_pro2 = mysqli_fetch_assoc($result_pro2)) {
                                            $sqlx = "INSERT INTO deliver_detail (dev_id,product_id,order_id,dev_qty,unit_price,total_price,disunit,status_cf,ptype_id,cus_back,cus_type)
                                                     VALUES ('$dev_id','$row_pro2[product_id]','$order_idx','$row_pro2[qty]','$row_pro2[unit_price]','$row_pro2[total_price]','$row_pro2[disunit]','1','$row_pro2[ptype_id]','$cus_back','$cus_type')";
                                                        if ($conn->query($sqlx) === TRUE) { }
                                             }
                                }
                            }  // $sql_pro  ?> 
                                <script>
                                    $(document).ready(function() {
                                        showAlert("บันทึกข้อมูลสั่งสินค้าสำเร็จกรณีลูกค้ารับเอง", "alert-success");
                                    });
                                </script>
      <?php   }
        // <!-- ปิดเงื่อนไขรับกลับเอง เงินสด -->
      else {
            
            //  if (($cus_type == 1) && ($cus_back == 1))
            // echo "$order_idx";
            //   เช็ครหัสสั่งชื้อซ้ำหรือไม่
                $sqlx = "SELECT * FROM orders  WHERE order_id='$order_idx'  ";
                $result = mysqli_query($conn, $sqlx);
                if (mysqli_num_rows($result) > 0) {
                // echo "$delivery_date";
                    $sql = "UPDATE orders SET cus_id='$cus_id',cus_back='$cus_back',cus_type='$cus_type',emp_id='$emp_id',status_button='1',discount='$discount',tax='$tax',date_confirm='30',error='12' where order_id='$order_idx'";
                            if ($conn->query($sql) === TRUE) { }
                            $sql112 = "UPDATE orders_number   SET status_use='2' ,status_cf='1' where order_id='$order_idx'";
                            if ($conn->query($sql112) === TRUE) { }
                    if ($delivery_date = '$delivery_date') 
                        {
                                $sql11 = "UPDATE orders   SET delivery_date='$delivery_datex',delivery_address='$delivery_Address',date_confirm='30' where order_id='$order_idx'";
                                        if ($conn->query($sql11) === TRUE) { }
                        } else {
                                $sqlx5 = "INSERT INTO orders (order_id,cus_id,cus_back,cus_type,emp_id,status_button)
                                            VALUES ('$order_idx','$cus_id','$cus_back','$cus_type_id','$emp_id','0')";
                                            if ($conn->query($sqlx5) === TRUE) { }
                                $sql11 = "UPDATE orders   SET delivery_date='$delivery_datex',delivery_address='$delivery_Address',date_confirm='30',error='1' where order_id='$order_idx'";
                                            if ($conn->query($sql11) === TRUE) { }
                        }
                    $sql7 = "UPDATE order_details  SET status_button='1' where order_id='$order_idx'";
                            if ($conn->query($sql7) === TRUE) { }
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

                                if (($cus_type == 1) && ($cus_back == 2)) {
                                        $sql8 = "INSERT INTO  quotation(qt_number,order_id)
                                                        VALUES ('$qt_id','$order_idx')";
                                        $sql9 = "UPDATE orders  SET order_status='1', qt_id='$qt_id',qt_date='$datetodat'  where  order_id='$order_idx'";
                                                if ($conn->query($sql8) === TRUE) { }
                                                if ($conn->query($sql9) === TRUE) { }
                                    }

                                if (($cus_type == 1) && ($cus_back == 3)) {
                                        $sql8 = "INSERT INTO  quotation(qt_number,order_id)
                                                    VALUES ('$qt_id','$order_idx')";
                                        $sql9 = "UPDATE orders  SET order_status='1', qt_id='$qt_id',qt_date='$datetodat' where  order_id='$order_idx'";
                                                if ($conn->query($sql8) === TRUE) { }
                                                if ($conn->query($sql9) === TRUE) { }
                                    }
                                if ($cus_type == 2) {
                                        $sql8 = "INSERT INTO  quotation(qt_number,order_id)
                                                VALUES ('$qt_id','$order_idx')";
                                        $sql9 = "UPDATE orders  SET order_status='2',  qt_id='$qt_id',qt_date='$datetodat' where  order_id='$order_idx'";
                                        if ($conn->query($sql8) === TRUE) { }
                                        if ($conn->query($sql9) === TRUE) {  }
                                    }
                                  // ============ปิดการสร้างรหัส QT
                     ?>
                    <script>
                        $(document).ready(function() {
                            showAlert("บันทึกข้อมูลสั่งสินค้าสำเร็จ", "alert-success");
                        });
                    </script>

      <?php  }
            } //ปิดลูกค้าไม่รับกลับ

  } //ปิดเช็คช้ำ
}      
        
$action = $_REQUEST['action'];
if ($action == 'add_cus') {

    // echo "xx";
    $customer_id = $_REQUEST['customer_id'];
    $customer_name = $_REQUEST['customer_name'];
    $customer_type = $_REQUEST['customer_type'];
    $company_name = $_REQUEST['company_name'];
    $bill_address = $_REQUEST['bill_address'];
    $subdistrict = $_REQUEST['subdistrict'];
    $district = $_REQUEST['district'];
    $province = $_REQUEST['province'];
    $tel = $_REQUEST['tel'];
    $tax_number = $_REQUEST['tax_number'];
    $contact_name = $_REQUEST['contact_name'];
    $datemonth = date('Y-m'); 
    $sqlx = "SELECT * FROM customer  WHERE customer_id='$customer_id' ";
    $result = mysqli_query($conn, $sqlx);
    if (mysqli_num_rows($result) > 0) { ?>
        <script>
            $(document).ready(function() {
                showAlert("ข้อมูลซ้ำไม่สามารถบันทึกได้", "alert-danger");
            });
        </script>
        <?php    } else {
        $sql = "INSERT INTO customer (customer_id,customer_name,company_name,bill_address,subdistrict,district,province,tel,tax_number,contact_name,customer_type,datemonth)
                   VALUES ('$customer_id','$customer_name','$company_name','$bill_address','$subdistrict','$district','$province','$tel','$tax_number','$contact_name','$customer_type','$datemonth')";
        if ($conn->query($sql) === TRUE) {  ?>
            <script>
                $(document).ready(function() {
                    showAlert("บันทึกข้อมูลสำเร็จ", "alert-success");
                });
            </script>
        <?php   }
    }
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
    $sqlxxx = "UPDATE delivery  SET hs_id='$hs_id',status_payment='2' where id='$e_id'";
    if ($conn->query($sqlxxx) === TRUE) { ?>
        <script>
            $(document).ready(function() {
                // showAlert("บันทึกข้อมูลพนักงานจัดส่งเรียบร้อย", "alert-primary");
                window.location = 'hs.php?order_id=<?= $order_id ?>&so_id=<?= $so_id ?>', '_blank'
                // window.open('hs.php?order_id=<?= $order_id ?>&so_id=<?= $so_id ?>', '_blank');
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
                                        <!-- <input type="text" name="order_id" id="order_id" value="<?= $order_idx ?>" class="classcus form-control" placeholder="รหัส Order" required> -->
                                        <input type="text" id="order_id" name="order_id" value="<?php echo "$order_idx"; ?>" class="classcus form-control" placeholder="รหัส Order" required>
                                    </div>
                                    <?php if ($status_order == 'confirm') {
                                    } else { ?>
                                        <button class="btn btn-outline-primary ripple m-1" type="button" data-toggle="modal" data-target="#modalcustomerlist" style=" height: 33px; margin-top: 24px!important;">เลือกลูกค้า</button>

                                        <button class="btn btn-outline-primary m-1" type="button" data-toggle="modal" data-target="#modalcus" style=" height: 33px; margin-top: 24px!important;">เพิ่มลูกค้าใหม่</button>
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
                                            <input type="hidden" id="cusx" name="cusx" value="<?= $Fcus_back ?>">
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
                                            <option value="">--เลือกประเภทสินค้า--</option>
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
                                            <label for="qty"><strong>ราคาขนส่ง <span class="text-danger"></span></strong></label>
                                            <input type="text" name="send_price" id="send_price" class="classcus form-control" placeholder="ราคาค่าจัดส่ง">
                                        </div>

                                        <div class="form-group col-md-1" id="ifYes_dis" style="display: none;">
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
                                            <label for="qty"><strong>จำนวน1 <span class="text-danger"></span></strong></label>
                                            <input type="text" name="qty" id="qty" class="classcus form-control" placeholder="จำนวนสั่ง" data-index="1" onkeyup="calculate()">
                                        </div>
                                        <div class="form-group col-md-1" id="ifYes_qty_face2" style="display: block;">
                                            <label for="qty"><strong>จำนวน2 <span class="text-danger"></span></strong></label>
                                            <input type="text" name="qty2" id="qty2" class="classcus form-control" placeholder="จำนวนสั่ง" data-index="1" onkeyup="calculate()">
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
                                                            <th>ลำดับ</th>
                                                            <th>รหัสสินค้า</th>
                                                            <th>ประเภทสินค้า</th>
                                                            <th>ชื่อสินค้า</th>
                                                            <th>ราคาต่อหน่วย</th>
                                                            <th>ลดต่อหน่วย</th>
                                                            <th>จำนวนที่สั่ง</th>
                                                            <th>รวมเป็นเงิน</th>

                                                            <?php if ($status_order == 'confirm') {
                                                            } else { ?><th>Action</th> <?php } ?>
                                                            <!-- <th>chk</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql_pro = "SELECT * FROM order_details  where order_id='$order_idx' order by date_create  ASC ";
                                                        $result_pro = mysqli_query($conn, $sql_pro);
                                                        if (mysqli_num_rows($result_pro) > 0) {
                                                            while ($row_pro = mysqli_fetch_assoc($result_pro)) { ?>
                                                                <tr>
                                                                    <td> <strong><?= ++$id; ?></strong> </td>
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
                                                                    <td> <?php echo number_format($row_pro['unit_price'], '2', '.', ',') ?> </td>
                                                                    <td> <?= $row_pro['disunit'] ?> </td>
                                                                    <td> <?= $row_pro['qty'] ?><?php $sumqty = $sumqty + $row_pro['qty'];  ?></td>
                                                                    <td> <?php echo number_format($row_pro['total_price'], '2', '.', ',') ?><?php $sumtotal = $sumtotal + $row_pro['total_price']; ?></td>
                                                                    <?php if ($status_order == 'confirm') {
                                                                    } else { ?> <td>
                                                                            <button type="button" class="btn btn-outline-success btn-sm line-height-1" data-id="<?php echo $row_pro['id']; ?>" data-toggle="modal" data-target="#Modaleditmain" id="edit_main"> <i class="i-Pen-2 font-weight-bold"></i> </button>

                                                                            <button type="button" class="btn btn-outline-danger btn-sm line-height-1" data-id="<?php echo $row_pro['id']; ?>" data-toggle="modal" data-target="#myModal_del" data-toggle="tooltip" title="ยกเลิกรายการสั่งสินค้า"> <i class="i-Close-Window font-weight-bold"></i> </button>
                                                                        </td>
                                                                    <?php } ?>

                                                                </tr>
                                                        <?php }
                                                        } ?>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>รวม</td>
                                                            <td><?= $sumqty ?></td>
                                                            <td><?php echo number_format($sumtotal, '2', '.', ',') ?></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="14"> &nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- ============ Table End ============= -->
                                    </div>
                                    <div class="form-group col-md-2" id="cus_back_show" style="display: none;">
                                        <div class="form-group">
                                            <label for="delivery_date">กำหนดส่งสินค้า</label>
                                            <input id="delivery_date" name="delivery_datex" value="<?php echo "$delivery_datex"; ?>" class="form-control" type="date" min="2021-06-01">
                                        </div>
                                    </div>
                                    <?php if ($status_order == 'confirm') {

                                        if (empty($delivery_datex)) {
                                        } else {
                                    ?>
                                            <div class="form-group col-md-2">
                                                <label for="delivery_date">กำหนดส่งสินค้า<span class="text-danger"></span></strong></label>
                                                <input value="<?php echo "$delivery_datex"; ?>" class="form-control" type="text" readonly>
                                            </div>
                                            <div class="form-group col-md-8">
                                                <label for="delivery_Address"><strong>ที่อยู่ จัดส่ง<span class="text-danger"></span></strong></label>
                                                <input type="text" value="<?= $delivery_Address ?>" class="classcus form-control" readonly>
                                            </div>
                                            <div class="form-group col-md-1">
                                                <label for="date_confirm"><strong>ยืนยันใน(วัน) <span class="text-danger"></span></strong></label>
                                                <input type="text" value="30" class="classcus form-control" readonly>
                                            </div>
                                    <?php  }
                                    } ?>

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
                                            <input type="text" value="30" class="classcus form-control">
                                        <?php  } else { ?>
                                            <input type="text" name="date_confirmx" id="date_confirm" value="30" class="classcus form-control" placeholder="ยืนยันราคาใน" Value="0">
                                        <?php } ?>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <?php $Ftax = 7; ?>
                                        <?php
                                        $tax = $_REQUEST['tax'];
                                        if (empty($tax)) {
                                            $tax = '7';
                                        } else {

                                            $tax = $tax;
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
                                    $discount = $_REQUEST['discount'];
                                    if (empty($discount)) {
                                        $discount = '0';
                                    } else {

                                        $discount = $discount;
                                    }
                                    ?>
                                    <div class="form-group col-md-1">
                                        <label for="discount"><strong>ส่วนลด(บาท) <span class="text-danger"></span></strong></label>
                                        <?php if ($status_order == 'confirm') { ?>
                                            <input type="text" value="<?= $discount ?>" class="classcus form-control">
                                        <?php  } else { ?>

                                            <input type="text" name="discount" id="discount" value="<?= $discount ?>" class="classcus form-control" placeholder="ส่วนลด">
                                        <?php } ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-right">

                                    <?php if ($status_order == 'confirm') {
                                        $sql = "SELECT * FROM orders where order_id='$order_idx'  ";
                                        $rs = $conn->query($sql);
                                        $rs = $rs->fetch_assoc();
                                        // echo "ประเภทลูกค้า" . $rs['cus_type'];
                                        // echo "รับกลับ" . $rs['cus_back'];
                                    ?>
                                        <?php if (($rs['cus_type'] == 1) && ($rs['cus_back'] == 1)) { ?>
                                            <?php $sql = "SELECT * FROM delivery  where order_id='$order_idx'  ";
                                            $rsx = $conn->query($sql);
                                            $rsx = $rsx->fetch_assoc();
                                            ?>
                                            <a class="btn btn-outline-primary m-1" data-toggle="tooltip" title="ออกใบเสร็จรับเงิน(HS) " href="/hs.php?order_id=<?= $rsx['order_id'] ?>&so_id=<?= $rsx['dev_id'] ?>" target="_blank">
                                                ออกใบเสร็จรับเงิน(HS)
                                            </a>

                                            <a class="btn btn-outline-primary m-1" href="/saleorder.php?order_id=<?= $rs['order_id'] ?>&so_id=<?= $rsx['dev_id'] ?>" type="button" target="_blank" id="SO">ออกใบส่งของ(SO)</a>
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
                                        <?php } else {
                                        // echo "$order_idx";
                                        $sql2 = "SELECT COUNT(*) AS total FROM order_details   WHERE order_id= '$order_idx'";
                                        $rs2 = $conn->query($sql2);
                                        $row2 = $rs2->fetch_assoc();
                                        if ($row2['total'] > 0) {
                                        ?>
                                            <button id="btnAddId" class="btn btn-outline-primary d-none" type="submit">ยืนยัน Order</button>
                                            <button class="btn btn-primary ladda-button btn-add" data-style="expand-left">
                                                <input type="hidden" name="order_idx" value="<?php echo "$order_idx"; ?>">
                                                <input type="hidden" name="status_order" value="confirm">
                                                <input type="hidden" name="action" value="add">
                                                <span class="ladda-label">ยืนยัน Order</span>
                                            </button>
                                    <?php }
                                    } ?>
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
    <div id="Modaleditmain" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
                        <div id="dynamic-content4"></div>
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
    <div class="modal fade" id="modalcustomerlist" tabindex="-1" role="dialog" aria-labelledby="medalmodalcus2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalmodalcus">เลือกรายการลูกค้า</h5>
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

    <form class="d-none" method="POST">
        <input type="hidden" name="status_order" value="Mnew">
        <input type="hidden" id="FMorder_id" name="order_id" value="<?php echo "$Morder_id"; ?>">
        <button class="btn" id="MButtonID" type="submit"></button>
    </form>
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
        <input type="text" id="FFqty2" name="Fqty2" value="<?php echo $Fqty2; ?>" placeholder="">
        <input type="text" name="action" value="add_product">
        <button class="btn" id="FSButtonID" type="submit"></button>
    </form>

    <form class="d-none" method="POST">
        <input type="text" id="PPcus_type_name" name="Fcus_type_name" value="<?php echo $Fcus_type_name; ?>" placeholder="">
        <input type="text" id="PPcus_type_id" name="Fcus_type_id" value="<?php echo $Fcus_type_id; ?>" placeholder="">
        <input type="text" id="PPcus_name" name="Fcus_name" value="<?php echo $Fcus_name; ?>" placeholder="">
        <input type="text" id="PPcus_id" name="Fcus_id" value="<?php echo $Fcus_id; ?>" placeholder="">
        <input type="text" id="PPcus_tel" name="Fcus_tel" value="<?php echo $Fcus_tel; ?>" placeholder="">
        <input type="text" id="PPcus_bill_address" name="Fcus_bill_address" value="<?php echo $Fcus_bill_address; ?>" placeholder="">
        <input type="text" id="PPcus_back" name="Fcus_back" value="<?php echo $Fcus_back; ?>" placeholder="">
        <input type="text" id="PPdelivery_date" name="Fdelivery_date" value="<?php echo $Fdelivery_date ?>" placeholder="">
        <input type="text" id="PPdelivery_Address" name="Fdelivery_Address" value="<?php echo $Fdelivery_Address; ?>" placeholder="">
        <input type="text" id="PPdate_confirm" name="Fdate_confirm" value="<?php echo $Fdate_confirm; ?>" placeholder="">
        <input type="text" id="PPtax" name="Ftax" value="<?php echo $Ftax; ?>" placeholder="">
        <input type="text" id="PPorder_id" name="Forder_id" value="<?php echo $Forder_id; ?>" placeholder="">
        <input type="text" id="PPdiscount" name="Fdiscount" value="<?php echo $Fdiscount; ?>" placeholder="">
        <input type="text" id="PPproduct_type" name="Fproduct_type" value="<?php echo $Fproduct_type; ?>" placeholder="">
        <input type="text" id="PPproductx" name="Fproductx" value="<?php echo $Fproductx; ?>" placeholder="">
        <input type="text" id="PPunit_price" name="Funit_price" value="<?php echo $Funit_price; ?>" placeholder="">
        <input type="text" id="PPsend_to" name="Fsend_to" value="<?php echo $Fsend_to; ?>" placeholder="">
        <input type="text" id="PPsend_qty" name="Fsend_qty" value="<?php echo $Fsend_qty; ?>" placeholder="">
        <input type="text" id="PPsend_price" name="Fsend_price" value="<?php echo $Fsend_price; ?>" placeholder="">
        <input type="text" id="PPdisunit" name="Fdisunit" value="<?php echo $Fdisunit; ?>" placeholder="">
        <input type="text" id="PPTF" name="FTF" value="<?php echo $FTF; ?>" placeholder="">
        <input type="text" id="status_order" name="status_order" value="update" placeholder="">
        <input type="text" id="PPqty" name="Fqty" value="<?php echo $Fqty; ?>" placeholder="">
        <input type="text" name="action1" value="chk_cusback">
        <button class="btn" id="PPButtonID" type="submit"></button>
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
    <script src="../../dist-assets/js/script.js"></script>
    <script src="../../dist-assets/js/script_addorder.js"></script>
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



    <!-- Modal ยืนยันส่งสินค้า -->
    <div class="modal fade" id="modalcus" tabindex="-1" role="dialog" aria-labelledby="medaltransuccess-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medaltransuccess-2">เพิ่มข้อมูลลูกค้า</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="main-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content" id="myTabContent">
                                <form class="tab-pane fade active show" method="post">
                                    <?php
                                      $datemonth = date('Y-m'); 
                                    $sql = "SELECT * FROM provinces";
                                    $query = mysqli_query($conn, $sql);
                                    $sql5 = "SELECT COUNT(id) AS id_run FROM customer where datemonth='$datemonth'     ";
                                    $rs5 = $conn->query($sql5);
                                    $row_run = $rs5->fetch_assoc();
                                    $datetodat = date('Y-m-d');
                                    $date = explode(" ", $datetodat);
                                    $dat = datethai_cus($date[0]);
                                    $code_new = $row_run['id_run'] + 1;
                                    $code = sprintf('%05d', $code_new);
                                    $cus_id = $dat . $code;
                                    ?>
                                    <div class="form-row mt-3">
                                        <div class="form-group col-md-2">
                                            <label for="accNameId"><strong>รหัสลูกค้า <span class="text-danger">*</span></strong></label>
                                            <input type="text" name="customer_id" id="customer_id" value="<?php echo "$cus_id"; ?>" class="classcus form-control" placeholder="รหัสลูกค้า" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="customer_type"><strong>ประเภท <span class="text-danger"></span></strong></label>
                                            <select class="classcus custom-select" name="customer_type" id="type_id" required>
                                                <?php
                                                $sql6 = "SELECT *  FROM  customer_type  order by id ASC ";
                                                $result6 = mysqli_query($conn, $sql6);
                                                if (mysqli_num_rows($result6) > 0) {
                                                    while ($row6 = mysqli_fetch_assoc($result6)) {
                                                ?>
                                                        <option value="<?php echo $row6['id'] ?>" <?php
                                                                                                    if (isset($row['customer_type']) && ($row['customer_type'] == $row6['id'])) {
                                                                                                        echo "selected"; ?>>
                                                        <?php echo "$row6[name]";
                                                                                                    } else {      ?>
                                                        <option value="<?php echo $row6['id']; ?>"> <?php echo $row6['name'];  ?>
                                                        <?php } ?>
                                                        </option>
                                                <?php  }
                                                }  ?>

                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="accNameId"><strong>ชื่อ-นามสกุล <span class="text-danger">*</span></strong></label>
                                            <input type="text" name="customer_name" id="customer_name" class="classcus form-control" placeholder="ชื่อ-นามสกุล" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="accNameId"><strong>ชื่อบริษัท <span class="text-danger"></span></strong></label>
                                            <input type="text" name="company_name" id="company_name" class="classcus form-control" placeholder="ชื่อบริษัท">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="phone"><strong>เบอร์โทร <span class="text-danger">*</span></strong></label>
                                            <input type="text" name="tel" id="phone" class="classcus form-control" placeholder="เบอร์โทร" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="tax_number"><strong>เลขที่ผู้เสียภาษี <span class="text-danger"></span></strong></label>
                                            <input type="text" name="tax_number" id="tax_number" class="classcus form-control" placeholder="เลขที่ผู้เสียภาษี" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="referral"><strong>บุคคลอ้างอิง <span class="text-danger"></span></strong></label>
                                            <input type="text" name="contact_name" id="contact_name" class="classcus form-control" placeholder="บุคคลอ้างอิง" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-10">
                                            <label for="accAddressId"><strong>ที่อยู่ <span class="text-danger">*</span></strong></label>
                                            <input type="text" name="bill_address" class="classcus form-control" id="address" placeholder="ที่อยู่" required="">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="province"><strong>จังหวัด <span class="text-danger">*</span></strong></label>

                                            <select name="province" id="province" class="classcus custom-select " required>
                                                <option value="">เลือกจังหวัด</option>
                                                <?php while ($result = mysqli_fetch_assoc($query)) : ?>
                                                    <option value="<?= $result['id'] ?>"><?= $result['name_th'] ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="district"><strong>อำเภอ <span class="text-danger">*</span></strong></label>
                                            <select name="district" id="amphure" class="classcus custom-select" required>
                                                <option value="">เลือกอำเภอ</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="subdistrict"><strong>ตำบล <span class="text-danger">*</span></strong></label>
                                            <select name="subdistrict" id="district" class="classcus custom-select">
                                                <option value="">เลือกตำบล</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="text-right">
                                            <input type="hidden" name="action" value="add_cus">
                                            <button id="btnAddId" class="btn btn-outline-primary d-none" type="submit">ยืนยันการเพิ่มลูกค้า</button>
                                            <button class="btn btn-primary ladda-button btn-add" data-style="expand-left">
                                                <span class="ladda-label">ยืนยันการเพิ่มลูกค้า</span>
                                            </button>
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">ปิด</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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