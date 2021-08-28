<?php
include './include/connect.php';
$sql1 = "SELECT * FROM districts WHERE id={$_GET['subdistrict_id']}";
// $json = array();
$rs1 = $conn->query($sql1);
$row1 = $rs1->fetch_assoc();


$sql2 = "SELECT * FROM amphures  WHERE id='$row1[amphure_id]'";
// $json = array();
$rs2 = $conn->query($sql2);
$row2= $rs2->fetch_assoc();

$sql3 = "SELECT * FROM provinces  WHERE id='$row2[province_id]'";
// $json = array();
$rs3 = $conn->query($sql3);
$row3= $rs3->fetch_assoc();

// array_push($data, array('id' => $row3['id']));
// array_push($json, $result);

// echo json_encode($json);
$json_data[] = array(
    "TUM" =>  $row1['name_th'],
    "AUM" =>  $row2['name_th'],
    "PRO" =>  $row3['name_th']
   
  
  );    

// header("Content-Type: application/json");
echo json_encode($json_data);
?>