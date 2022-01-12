<?php
include './include/connect.php';
include './include/config.php';
$id = intval($_REQUEST['id']);


$sql = "SELECT * FROM product  WHERE id= '$id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$datetodat = date('Y-m-d');
echo "$row[product_id]";
?>


<table class="display table table-striped table-bordered" id="orderby1" style="width:100%">
    <thead>
        <tr>
            <th>รหัสสินค้า</th>
            <th>เลขที่ใบสั่งชื้อ</th>
            <th>ประเภทลูกค้า</th>
            <th>ชื่อลูกค้า</th>
            <th>จำนวนที่ขาย</th>
            <th>วันที่ส่งสินค้า</th>
        </tr>
    </thead>
    <tbody id="myTable">
        <?php

        $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM deliver_detail  INNER JOIN delivery  ON deliver_detail.product_id= '$row[product_id]' AND deliver_detail.order_id=delivery.order_id AND delivery.status_payment='1' ");
        $total_records = mysqli_fetch_array($result_count);
        $total_records = $total_records['total_records'];
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1; // total page minus 1
        $result = mysqli_query($conn, "SELECT * FROM deliver_detail  INNER JOIN delivery   ON deliver_detail.product_id= '$row[product_id]' AND deliver_detail.order_id=delivery.order_id AND delivery.status_payment='1' ORDER BY delivery.dev_date DESC ");
        while ($rowx = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $rowx["product_id"]; ?></td>
                <td><?php echo $rowx["order_id"]; ?></td>
                <td><?php 
                 $sql2 = "SELECT * FROM customer_type WHERE id= '$rowx[cus_type]'";
                 $rs2 = $conn->query($sql2);
                 $row2 = $rs2->fetch_assoc();
                 $sql3 = "SELECT * FROM customer WHERE customer_id= '$rowx[cus_id]'";
                 $rs3 = $conn->query($sql3);
                 $row3 = $rs3->fetch_assoc();
                
                echo $row2["name"]; ?></td>
                 <td> <?php echo $row3["customer_name"]; ?> </td>
                <td> <?php echo $rowx["dev_qty"]; ?> </td>
                <td> <?php $date = explode(" ", $rowx['dev_date']);
                                                    $dat = datethai2($date[0]);
                                                    echo $dat;    ?></td>
              
               
                
            </tr>
        <?php
        }

        ?>


    </tbody>
  
</table>