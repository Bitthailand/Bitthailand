<?php
include './include/connect.php';
$ptype_id = $_REQUEST['ptype_id'];
error_reporting(~E_NOTICE);
$sql = "SELECT * FROM product  where ptype_id='$ptype_id'  ORDER BY product_id  DESC  ";

$result = mysqli_query($conn, $sql);
if($result && $result->num_rows > 0){

    while($r = $result->fetch_assoc()){ 
      $product_id=  $r['huey_lot_name'];
      $product_name =  $r['subject'];
     
     

    
      if($original==''){
        $orin="-";
      }else 
      {
        $orin="$original";
      }
      
      $json_data[] = array(
        "product_id"=> $product_id, 
        "product_name" =>  $product_name
      
        
       
      );    
      }
    }else{
      $product_id='null';
      $product_name= 'null';
     
      $json_data[] = array(
        "product_id"=> $product_id, 
        "product_name" =>  $product_name
       
       
      );    
    }
    header("Content-Type: application/json");
    echo json_encode($json_data);

?>

