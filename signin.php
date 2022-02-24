<!DOCTYPE html>
<?php
session_start();
// unset($_SESSION['username']);
include './include/connect.php';
include './include/config.php';

$action = $_REQUEST['action'];
// htmlentities($_REQUEST["action"]);
if ($action == 'login') {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    // echo"$username";
    // $scon->getlogin($username, $password);
    $sql = "SELECT * FROM employee  where username= '$username' ";
    $rs = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($rs);


    if ($numRows  == 1) {
        $row = mysqli_fetch_assoc($rs);
        // if(password_verify($password,$row['password'])){
        if ($password == $row['password']) {
            session_start();
            echo "Password verified $row[username] ";
            $_SESSION["username"] = $row['username'];

            $_SESSION["rule"] = $row['rule'];

            $sql = "INSERT INTO log (emp_id,event)
            VALUES ('$row[username]','ลงชื่อเข้าระบบ')";
            if ($conn->query($sql) === TRUE) {
            }
            $_SESSION["time"] = time() + 150000;
         
            if ($row['level'] == 1) {
                header('Location: index.php');
            }
            if ($row['level'] == 2) {
                header('Location: quotationlist.php');
            }
            if ($row['level'] == 3) {
                header('Location: inventorylist.php');
            }
            if ($row['level'] == 4) {
                header('Location: productionlist.php');
            }
        } else {
?>

            <script>
                $(document).ready(function() {
                    showAlert("รหัสผ่านไม่ถูกต้อง", "alert-danger");
                });
            </script>
        <?php
        }
    } else {
        ?>
        <script>
            $(document).ready(function() {
                showAlert("ไม่พบผู้ใช้นี้", "alert-danger");
            });
        </script>
<?php
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ระบบจัดการสินค้า 1M </title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet">

</head>
<div class="auth-layout-wrap" style="background-image: url(../../dist-assets/images/photo-wide-4.jpg)">
    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-12">
                    <div class="p-4">
                        <div class="auth-logo text-center mb-4"><img src="../../dist-assets/images/logo.png" alt=""></div>
                        <h1 class="mb-3 text-18">Sign In</h1>


                        <form method="POST">
                            <div class="form-group">
                                <label for="username">User Name</label>
                                <input class="form-control form-control-rounded" name="username" type="text" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control form-control-rounded" name="password" type="password" placeholder="password" required>
                            </div>
                            <input type="hidden" name="action" value="login">
                            <button class="btn btn-rounded btn-primary btn-block mt-2">Sign In</button>
                        </form>
                        <div id="alert_placeholder" style="z-index: 9999999; left:1px; top:1%; width:100%; position:absolute;"></div>
                        <div class="mt-3 text-center">
                            <a class="text-muted" href="forgot.php">
                                <u>Forgot Password?</u></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>