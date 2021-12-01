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
            <th>ข้อความมัดจำ</th>
            <th>ยอดชำระเต็ม</th>
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
        $result = mysqli_query($conn, "SELECT ai_number.date_create AS date_create ,ai_number.price AS price,ai_number.messages AS messages,customer.customer_name AS customer_name, orders.order_id AS order_id  FROM   ai_number INNER JOIN  orders  ON ai_number.order_id=orders.order_id  INNER JOIN customer ON orders.cus_id=customer.customer_id    AND  ai_number.date_create LIKE '$d[0]%'  AND ai_number.aix_status='1' AND  ai_number.pay_full='1'");
        while ($rowx = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $rowx["order_id"]; ?></td>
                <td><?php echo $rowx["customer_name"]; ?></td>
                <td><?php echo $rowx["messages"]; ?></td>
                <td> <?php echo number_format($rowx['price'], '2', '.', ','); ?> </td>
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