<?php
include './include/connect.php';
$sql = "SELECT * FROM product  WHERE product_id='{$_GET['ProId']}'";
$query = mysqli_query($conn, $sql);
$json = array();
while($result = mysqli_fetch_assoc($query)) {    
array_push($json, $result);
}

echo json_encode($json);
?>