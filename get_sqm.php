<?php
include './include/connect.php';
$sql = "SELECT * FROM product WHERE id={$_GET['sqm_id']}";
$query = mysqli_query($conn, $sql);
$json = array();
while($result = mysqli_fetch_assoc($query)) {    
array_push($json, $result);
}
echo json_encode($json);
?>