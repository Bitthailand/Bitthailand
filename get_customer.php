<?php
include './include/connect.php';
$sql = "SELECT * FROM customer  WHERE id={$_GET['cus_id']}";
$query = mysqli_query($conn, $sql);
$json = array();
while($result = mysqli_fetch_assoc($query)) {    
array_push($json, $result);
}
echo json_encode($json);
?>