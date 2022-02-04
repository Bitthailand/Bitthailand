<?php
include './include/connect.php';
include './include/config.php';
$id = intval($_REQUEST['id']);


$sql = "SELECT * FROM tools_out  WHERE tools_id= '$id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
$datetodat = date('Y-m-d');

$sql2 = "SELECT * FROM tools  WHERE id= '$id'";
$rs2 = $conn->query($sql2);
$row2 = $rs2->fetch_assoc();

echo "$row2[name]";
?>


<table class="display table table-striped table-bordered" id="orderby1" style="width:100%">
    <thead>
        <tr>
            <th>วันที่</th>
            <th>ชื่อเครื่องมือ</th>
            <th>นำออก</th>
            <th>สาเหตุ</th>
            <th>ผู้นำออก</th>
        </tr>
    </thead>
    <tbody id="myTable">
        <?php


        $result = mysqli_query($conn, "SELECT * FROM tools_out   WHERE tools_id= '$id'  ORDER BY date_out  DESC ");
        while ($row = mysqli_fetch_array($result)) { ?>
            <tr>
                <td> <?php echo $row['date_out'] ?></td>
                <td><?php echo $row["name"]; ?></td>
                <td> <?php
                        $sql3 = "SELECT * FROM unit_tools  WHERE id= '$row[unit]'";
                        $rs3 = $conn->query($sql3);
                        $row3 = $rs3->fetch_assoc();

                        echo $row["qty_out"] . ':' . $row3['name']; ?></td>


                <td> <?php echo $row["comment"]; ?> </td>

                <td> <?php echo $row["emp_id"]; ?> </td>
            </tr>
        <?php
        }

        ?>


    </tbody>

</table>