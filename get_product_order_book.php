<?php
include './include/connect.php';
$sql = "SELECT sum(order_details.qty_out) AS qty_out FROM order_details INNER JOIN orders ON order_details.product_id= '{$_GET['ProId']}'  AND order_details.order_id=orders.order_id AND orders.order_status='2' AND orders.is_ai='Y' AND  order_details.status_delivery='0' ";
// $sql = "SELECT * FROM product  WHERE product_id='{$_GET['ProId']}' ";
$query = mysqli_query($conn, $sql);
$json = array();
while($result = mysqli_fetch_assoc($query)) {    
array_push($json, $result);
}

echo json_encode($json);
?>