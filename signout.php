<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['user']);


// session_destroy(); // ทำลาย session
//session_destroy();
echo "<script>window.location = 'signin.php'</script>";
