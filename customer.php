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
<<<<<<< HEAD
                 <script>
                 $(document).ready(function() {
                     showAlert("ข้อมูลซ้ำไม่สามารถบันทึกได้", "alert-danger");
                 });
                 </script>
     <?php    } else { 
                   $sql = "INSERT INTO customer (customer_id,customer_name,company_name,bill_address,subdistrict,district,province,tel,tax_number,contact_name)
                   VALUES ('$customer_id','$customer_name','$company_name','$bill_address','$subdistrict','$district','$province','$tel','$tax_number','$contact_name')";                 
=======
<script>
$(document).ready(function() {
    showAlert("ข้อมูลซ้ำไม่สามารถบันทึกได้", "alert-danger");
});
</script>
<?php    } else { 
                   $sql = "INSERT INTO customer (customer_id,customer_name,company_name,bill_address,subdistrict,district,province,tel,tax_number,contact_name,delivery_address)
                   VALUES ('$customer_id','$customer_name','$company_name','$bill_address','$subdistrict','$district','$province','$tel','$tax_number','$contact_name','$delivery_address')";                 
>>>>>>> b685939885eb4d40b9474a77b1df70f96d1ec0c4
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
                                        <div class="card-title">เพิ่มข้อมูลลูกค้า</div>
                                    </div>
                                    <div class="row mt-4">
                                    </div>
                                    <div class="form-row mt-3">

                                        <div class="form-group col-md-4">
                                            <label for="accNameId"><strong>รหัสลูกค้า <span class="text-danger">*</span></strong></label>
                                            <input type="text" name="customer_id" id="customer_id"  value="<?php echo"$cus_id";?>"  class="classcus form-control" placeholder="รหัสลูกค้า" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="accNameId"><strong>ชื่อ-นามสกุล <span class="text-danger">*</span></strong></label>
                                            <input type="text" name="customer_name" id="customer_name" class="classcus form-control" placeholder="ชื่อ-นามสกุล" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="accNameId"><strong>ชื่อบริษัท <span class="text-danger"></span></strong></label>
                                            <input type="text" name="company_name" id="company_name" class="classcus form-control" placeholder="ชื่อบริษัท">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="phone"><strong>เบอร์โทร <span class="text-danger">*</span></strong></label>
                                            <input type="text" name="tel" id="phone" class="classcus form-control" placeholder="เบอร์โทร" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="tax_number"><strong>เลขที่ผู้เสียภาษี <span class="text-danger"></span></strong></label>
                                            <input type="text" name="tax_number" id="tax_number" class="classcus form-control" placeholder="เลขที่ผู้เสียภาษี" autocomplete="off">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="referral"><strong>บุคคลอ้างอิง <span class="text-danger"></span></strong></label>
                                            <input type="text" name="contact_name" id="contact_name" class="classcus form-control" placeholder="บุคคลอ้างอิง" autocomplete="off">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="accAddressId"><strong>ที่อยู่ <span class="text-danger">*</span></strong></label>
                                            <input type="text" name="bill_address" class="classcus form-control" id="address" placeholder="ที่อยู่" required="">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="province"><strong>จังหวัด <span class="text-danger">*</span></strong></label>

                                            <select name="province" id="province" class="classcus custom-select " required>
                                                <option value="">เลือกจังหวัด</option>
                                                <?php while ($result = mysqli_fetch_assoc($query)) : ?>
                                                <option value="<?= $result['id'] ?>"><?= $result['name_th'] ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="district"><strong>อำเภอ <span class="text-danger">*</span></strong></label>


                                            <select name="district" id="amphure" class="classcus custom-select" required>
                                                <option value="">เลือกอำเภอ</option>
                                            </select>

                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="subdistrict"><strong>ตำบล <span class="text-danger">*</span></strong></label>


                                            <select name="subdistrict" id="district" class="classcus custom-select">
                                                <option value="">เลือกตำบล</option>
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