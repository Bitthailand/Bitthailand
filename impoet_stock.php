<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config.php';

if(isset($_POST["Import"])){
echo $filename=$_FILES["file"]["tmp_name"];
if($_FILES["file"]["size"] > 0)
 { 
    $file = fopen($filename, "r");
      while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
      {
                $sqlx = "SELECT * FROM products  WHERE  product_id='$emapData[0]'";
	$result = mysqli_query($conn, $sqlx);
	if (mysqli_num_rows($result) > 0) {
	$name = addslashes($emapData[2]);
	$sql = "UPDATE product  SET fac1_stock='$emapData[6]',fac2_stock='$emapData[7]'  where product_id='$emapData[0]'";
	if ($conn->query($sql) === TRUE) { }
	  }else{

                  }
	  fclose($file);
	 //throws a message if data successfully imported to mysql database from excel file
	  echo "<script type=\"text/javascript\">
	         alert(\"CSV File has been successfully Imported.\");
	         </script>";
	         //close of connection
	         mysqli_close($conn); 
        }
 }
}
?>
