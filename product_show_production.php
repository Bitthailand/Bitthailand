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
            <th>เลขที่สั่งผลิต</th>
            <th>จำนวนสั่งผลิต</th>
            <th>เข้าสต็อก</th>
            <th>ชำรุด</th>
            <th>รับเข้าโดย</th>
            <th>วันที่</th>
        </tr>
    </thead>
    <tbody id="myTable">
        <?php

        $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM production_detail where  product_id= '$row[product_id]' AND status_stock='1'   ");
        $total_records = mysqli_fetch_array($result_count);
        $total_records = $total_records['total_records'];
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1; // total page minus 1
        $result = mysqli_query($conn, "SELECT * FROM production_detail where  product_id= '$row[product_id]' AND status_stock='1'  ORDER BY date_create DESC  ");
        while ($rowx = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $rowx["product_id"]; ?></td>
                <td><?php echo $rowx["po_id"]; ?></td>
                <td><?php echo $rowx["qty"]; $qtyx=$qtyx+$rowx["qty"]; ?></td>
                 <td> <?php echo $rowx["a_type"]; $a_type=$a_type+$rowx["a_type"]; ?> </td>
                <td> <?php echo $rowx["b_type"]; $b_type=$b_type+$rowx["b_type"];  ?> </td>
                <td> <?php echo $rowx["employee_id"]; ?> </td>
                <td> <?php $date = explode(" ", $rowx['date_create']);
                                                    $dat = datethai2($date[0]);
                                                    echo $dat;    ?></td>
              
               
                
            </tr>
        <?php
        }

        ?>
<tr>
            <th></th>
            <th></th>
            <th><?=$qtyx?></th>
            <th><?=$a_type?></th>
            <th><?=$b_type?></th>
            <th></th>
            <th></th>
        </tr>

    </tbody>
  
</table>