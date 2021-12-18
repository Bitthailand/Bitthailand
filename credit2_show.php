<?php
include './include/connect.php';
include './include/config.php';
$datex = $_REQUEST['id'];
echo "$datex";

$sql = "SELECT * FROM ai_number WHERE date_create LIKE '$datex%' ";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();

$datex = date($row['date_create']);
$d = explode(" ", $datex);
// echo"$d[0]";
?>


<table class="display table table-striped table-bordered" id="orderby1" style="width:100%">
    <thead>
        <tr>

            <th>เลขที่ใบสั่งชื้อ</th>
            <th>ชื่อลูกค้า</th>
        
            <th>เครดิตชำระเงิน</th>
            <th>วันที่รับเงิน</th>
        </tr>
    </thead>
    <tbody id="myTable">
        <?php

        $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM ai_number  where date_create LIKE '$d[0]%'    ");
        $total_records = mysqli_fetch_array($result_count);
        $total_records = $total_records['total_records'];
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1; // total page minus 1
        $result = mysqli_query($conn, "SELECT SUM(deliver_detail.total_price) AS total ,delivery.order_id AS order_id,customer.customer_name AS customer_name,delivery.date_create AS date_create  FROM delivery  INNER JOIN deliver_detail  ON  delivery.order_id=deliver_detail.order_id  AND delivery.dev_id=deliver_detail.dev_id AND delivery.date_create LIKE '$d[0]%'  AND delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='2'  INNER JOIN customer ON delivery.cus_id=customer.customer_id ");
        while ($rowx = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $rowx["order_id"]; ?></td>
                <td><?php echo $rowx["customer_name"]; ?></td>
             
                <td> <?php echo number_format($rowx['total'], '2', '.', ','); ?> </td>
                <td> <?php
                        $datex = date($rowx['date_create']);
                        $d = explode(" ", $datex);
                        echo"$d[0]";
                        ?>
                </td>

            </tr>
        <?php
        }
        ?>


    </tbody>

</table>