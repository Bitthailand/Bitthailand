<?php
include './include/connect.php';
$sql = "SELECT * FROM districts WHERE id={$_GET['subdistrict_id']}";
$json = array();
$rs3 = $conn->query($sql);
$row3 = $rs3->fetch_assoc();


array_push($data, array('id' => $row3['id']));
// array_push($json, $result);

echo json_encode($json);
?>