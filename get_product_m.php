<?php
include './include/connect.php';
$sql = "SELECT * FROM product  WHERE ptype_id='{$_GET['ptype_id']}'  order by product_id ASC";
$query = mysqli_query($conn, $sql);
$json = array();
while($result = mysqli_fetch_assoc($query)) {    
array_push($json, $result);
}

echo json_encode($json);
?>