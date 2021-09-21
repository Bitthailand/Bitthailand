<?php

// $host = "61.91.124.163"; /* Host name */
// $user = "1mpro_main"; /* User */
// $password = "oI08XTiw98"; /* Password */
// $dbname = "1mpro_main"; /* Database name */
// $conn= mysqli_connect($host, $user, $password,$dbname);
// mysqli_query($conn,"SET CHARACTER SET 'utf8'");
// mysqli_query($conn,"SET SESSION collation_connection ='utf8_unicode_ci'");
// // Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }


$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "1mpro_main"; /* Database name */
$conn= mysqli_connect($host, $user, $password,$dbname);
mysqli_query($conn,"SET CHARACTER SET 'utf8'");
mysqli_query($conn,"SET SESSION collation_connection ='utf8_unicode_ci'");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


?>