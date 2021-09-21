<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
// include './include/config.php';
error_reporting(~E_NOTICE); 
error_reporting(0);
if(isset($_POST["Import"])){
echo $filename=$_FILES["file"]["tmp_name"];
if($_FILES["file"]["size"] > 0)
 { 
    $file = fopen($filename, "r");
      while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
      {
	echo $emapData[0].'x'.$emapData[1].'x'.$emapData[2].'<br>'; 
                // $sqlx = "SELECT * FROM products  WHERE  product_id='$emapData[0]'";
	// $result = mysqli_query($conn, $sqlx);
	// if (mysqli_num_rows($result) > 0) {
	// $name = addslashes($emapData[2]);
	$sql = "UPDATE product   SET fac1_stock='$emapData[1]',fac2_stock='$emapData[2]',weight='$emapData[3]'  where product_id='$emapData[0]'";
	if ($conn->query($sql) === TRUE) { }
	//   }
	//   fclose($file);
	 //throws a message if data successfully imported to mysql database from excel file
	
	         //close of connection
	//          mysqli_close($conn); 
        }
        ?>
                 
        
        <script type="text/javascript">
        alert("CSV File has been successfully Imported.")
       </script>
  <?php
 }
}
?>
