<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config.php';
$sql = "SELECT * FROM provinces";
$query = mysqli_query($conn, $sql);

$sql5 = "SELECT MAX(id) AS id_run FROM customer  ";
$rs5 = $conn->query($sql5);
$row_run = $rs5->fetch_assoc(); 

$datetodat=date('Y-m-d');
 $date=explode(" ",$datetodat);
 $dat=datethai_cus($date[0]);
 $code_new=$row_run['id_run']+1;
 $code = sprintf('%05d', $code_new);
 $cus_id=$dat.$code;

$action= $_REQUEST['action'];
if ($action == 'add') {
    $customer_id = $_REQUEST['customer_id'];  
    $customer_name= $_REQUEST['customer_name']; 
    $customer_type= $_REQUEST['customer_type']; 
    
    $company_name = $_REQUEST['company_name'];   
    $bill_address= $_REQUEST['bill_address'];  
    $subdistrict = $_REQUEST['subdistrict'];
    $district= $_REQUEST['district'];
    $province= $_REQUEST['province'];
    $tel = $_REQUEST['tel'];
    $tax_number = $_REQUEST['tax_number'];
    $contact_name = $_REQUEST['contact_name'];
    // $delivery_address=$_REQUEST['delivery_address'];
    $sqlx = "SELECT * FROM customer  WHERE customer_id='$customer_id' ";
    $result = mysqli_query($conn, $sqlx);
    if (mysqli_num_rows($result) > 0) {?>
<script>
$(document).ready(function() {
    showAlert("ข้อมูลซ้ำไม่สามารถบันทึกได้", "alert-danger");
});
</script>
<?php    } else { 
                   $sql = "INSERT INTO customer (customer_id,customer_name,company_name,bill_address,subdistrict,district,province,tel,tax_number,contact_name,customer_type)
                   VALUES ('$customer_id','$customer_name','$company_name','$bill_address','$subdistrict','$district','$province','$tel','$tax_number','$contact_name','$customer_type')";                 
                    if ($conn->query($sql) === TRUE) {  ?>
<script>
$(document).ready(function() {
    showAlert("บันทึกข้อมูลสำเร็จ", "alert-success");
});
</script>
<?php   }   }   }
                        
?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Order | เสนอราคา</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
</head>

<body class="text-left">
    <div class="app-admin-wrap layout-horizontal-bar">
        <!-- Header -->
        <?php include './include/header.php'; ?>
        <!-- =============== Header End ================-->
        <!-- side bar menu -->
        <?php include './include/menu.php'; ?>
        <!-- =============== Left side End ================-->

        <!-- =============== Horizontal bar End ================-->
        <div class="main-content-wrap d-flex flex-column">
            <!-- ============ Body content start ============= -->
            <!-- แจ้งเตือน -->
            <div id="alert_placeholder" style="z-index: 9999999; left:1px; top:1%; width:100%; position:absolute;"></div>
            <!-- ปิดการแจ้งเตือน -->
            <div class="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="tab-content" id="myTabContent">
                                <form class="tab-pane fade active show" method="post">

                                    <div class="border-bottom text-primary">
                                        <div class="card-title">เพิ่มข้อมูลแพ</div>
                                    </div>
                                    <div class="row mt-4">
                                    </div>
                                    <div class="form-row mt-3">

                                        <div class="form-group col-md-3">
                                            <label for="accNameId"><strong>รหัสแพ <span class="text-danger">*</span></strong></label>
                                            <input type="text" name="plant_id" id="plant_id" class="classcus form-control"
                                                placeholder="รหัสแพ" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="accNameId"><strong>ความกว้างของแพ <span class="text-danger"></span></strong></label>
                                            <input type="number" name="width" id="company_name" step="0.01" class="classcus form-control" placeholder="ความกว้างแพ">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="customer_type"><strong>ประเภทสินค้า <span class="text-danger"></span></strong></label>
                                           
                                            <select class="classcus custom-select" name="customer_type" id="type_id" required>
                                                <?php
                                                $sql6 = "SELECT *  FROM product_type order by id DESC ";
                                                $result6 = mysqli_query($conn, $sql6);
                                                if (mysqli_num_rows($result6) > 0) {
                                                    while ($row6 = mysqli_fetch_assoc($result6)) {
                                                ?>
                                                <option value="<?php echo $row6['ptype_id'] ?>" <?php
                                                                                                        if (isset($row['ptype_id']) && ($row['ptype_id'] == $row6['ptype_id'])) {
                                                                                                            echo "selected"; ?>>
                                                    <?php echo "$row6[ptype_name]";
                                                                                                        } else {      ?>
                                                <option value="<?php echo $row6['ptype_id']; ?>"> <?php echo $row6['ptype_name'];  ?>
                                                    <?php } ?>
                                                </option>
                                                <?php  }
                                                }  ?>

                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="accNameId"><strong>โรงงาน<span class="text-danger">*</span></strong></label>
                                            <select class="classcus custom-select" name="customer_type" id="type_id" required>
                                                <?php
                                                $sql6 = "SELECT *  FROM  factory order by id DESC ";
                                                $result6 = mysqli_query($conn, $sql6);
                                                if (mysqli_num_rows($result6) > 0) {
                                                    while ($row6 = mysqli_fetch_assoc($result6)) {
                                                ?>
                                                <option value="<?php echo $row6['id'] ?>" <?php
                                                                                                        if (isset($row['factory']) && ($row['factory'] == $row6['id'])) {
                                                                                                            echo "selected"; ?>>
                                                    <?php echo "$row6[name]";
                                                                                                        } else {      ?>
                                                <option value="<?php echo $row6['id']; ?>"> <?php echo $row6['name'];  ?>
                                                    <?php } ?>
                                                </option>
                                                <?php  }
                                                }  ?>

                                            </select>
                                        </div>

                                     
                                       




                                    </div>

                                    <hr>

                                    <div class="text-right">
                                        <input class="d-none" id="addAccId" type="text" name="acc_id" value="" placeholder="">
                                        <input class="d-none" id="addActionId" type="text" name="action" value="add" placeholder="">
                                        <input type="hidden" name="action" value="add">
                                        <button id="btnAddId" class="btn btn-outline-primary d-none" type="submit">ยืนยันการเพิ่มลูกค้า</button>
                                        <button class="btn btn-primary ladda-button btn-add" data-style="expand-left">
                                            <span class="ladda-label">ยืนยันการเพิ่มลูกค้า</span>
                                        </button>
                                        <a class="btn btn-outline-danger m-1" href="/customerslist.php" type="button">กลับหน้ารายการ</a>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Header -->
            <?php include './include/footer.php'; ?>
            <!-- =============== Header End ================-->
        </div>
    </div>
    <script src="../../dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
    <script src="../../dist-assets/js/plugins/bootstrap.bundle.min.js"></script>
    <script src="../../dist-assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../../dist-assets/js/scripts/script.min.js"></script>
    <script src="../../dist-assets/js/scripts/sidebar-horizontal.script.js"></script>
    <script src="../../dist-assets/js/plugins/echarts.min.js"></script>
    <script src="../../dist-assets/js/scripts/echart.options.min.js"></script>
    <script src="../../dist-assets/js/scripts/dashboard.v1.script.min.js"></script>
    <script src="../../dist-assets/js/scripts/customizer.script.min.js"></script>
    <script src="../../dist-assets/js/jquery.min.js"></script>
    <script src="../../dist-assets/js/script.js"></script>

</body>

</html>