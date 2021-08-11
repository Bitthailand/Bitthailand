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
$customer_id = $_REQUEST['customer_id'];



$action = $_REQUEST['action'];
if ($action == 'edit') {
    $edit_id = $_REQUEST['edit_id'];
    $customer_name = $_REQUEST['customer_name'];
    $company_name = $_REQUEST['company_name'];
    $bill_address = $_REQUEST['bill_address'];
    $chk = $_REQUEST['chk'];
    if($chk=='1'){
        $subdistrict = $_REQUEST['subdistrict'];
        $district = $_REQUEST['district'];
        $province = $_REQUEST['province'];
    }
  
    $tel = $_REQUEST['tel'];
    $tax_number = $_REQUEST['tax_number'];
    $contact_name = $_REQUEST['contact_name'];
    $sql = "UPDATE customer  SET customer_name='$customer_name',company_name='$company_name',bill_address='$bill_address',tel='$tel',tax_number='$tax_number',contact_name='$contact_name'  where customer_id='$edit_id'";
    if($chk=='1'){
        $sql = "UPDATE customer  SET subdistrict='$subdistrict',district='$district',province='$province' where customer_id='$edit_id'";   
    }

    if ($conn->query($sql) === TRUE) {  ?>
        <script>
            $(document).ready(function() {
                showAlert("แก้ไขข้อมูลลูกค้าสำเร็จ", "alert-success");
            });
        </script>
<?php   }
}
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
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
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
                                    <?php $sql5 = "SELECT * FROM customer  WHERE customer_id = '$customer_id'";
                                    $rs5 = $conn->query($sql5);
                                    $row = $rs5->fetch_assoc(); ?>
                                    <div class="border-bottom text-primary">
                                        <div class="card-title">แก้ไขข้อมูลลูกค้า</div>
                                    </div>
                                    <div class="row mt-4">
                                    </div>
                                    <div class="form-row mt-3">

                                        <div class="form-group col-md-4">
                                            <label for="accNameId"><strong>รหัสลูกค้า <span class="text-danger">*</span></strong></label>
                                            <input type="text" name="customer_id" value="<?php echo $row['customer_id']; ?>" class="classcus form-control" disabled>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="accNameId"><strong>ชื่อ-นามสกุล <span class="text-danger">*</span></strong></label>
                                            <input type="text" name="customer_name" id="customer_name" value="<?php echo $row['customer_name']; ?>" class="classcus form-control" placeholder="ชื่อ-นามสกุล" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="accNameId"><strong>ชื่อบริษัท <span class="text-danger"></span></strong></label>
                                            <input type="text" name="company_name" id="company_name" value="<?php echo $row['company_name']; ?>" class="classcus form-control" placeholder="ชื่อบริษัท">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="phone"><strong>เบอร์โทร <span class="text-danger">*</span></strong></label>
                                            <input type="text" name="tel" id="phone" value="<?php echo $row['tel']; ?>" class="classcus form-control" placeholder="เบอร์โทร" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="tax_number"><strong>เลขที่ผู้เสียภาษี <span class="text-danger"></span></strong></label>
                                            <input type="text" name="tax_number" id="tax_number" value="<?php echo $row['tax_number']; ?>" class="classcus form-control" placeholder="เลขที่ผู้เสียภาษี" autocomplete="off">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="referral"><strong>บุคคลอ้างอิง <span class="text-danger"></span></strong></label>
                                            <input type="text" name="contact_name" id="contact_name" value="<?php echo $row['contact_name']; ?>" class="classcus form-control" placeholder="บุคคลอ้างอิง" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <?php
                                            $sql5 = "SELECT * FROM provinces  WHERE id= '$row[province]'";
                                            $rs5 = $conn->query($sql5);
                                            $row5 = $rs5->fetch_assoc();

                                            $sql4 = "SELECT * FROM amphures  WHERE id= '$row[district]'";
                                            $rs4 = $conn->query($sql4);
                                            $row4 = $rs4->fetch_assoc();
                                            $sql3 = "SELECT * FROM districts  WHERE id= '$row[subdistrict]'";
                                            $rs3 = $conn->query($sql3);
                                            $row3 = $rs3->fetch_assoc();
                                            ?>
                                            <label for="accAddressId"><strong>ที่อยู่ <span class="text-danger">*</span></strong></label>
                                            <input type="text" name="bill_address" class="classcus form-control" id="address" value="<?php echo $row['bill_address']; ?>" placeholder="ที่อยู่">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="province"><strong>จังหวัด <span class="text-danger">*</span></strong></label>
                                            <input type="text" class="classcus form-control" value="<?php echo $row5['name_th']; ?>" placeholder="จังหวัด" disabled>

                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="district"><strong>อำเภอ <span class="text-danger">*</span></strong></label>

                                            <input type="text" class="classcus form-control" value="<?php echo $row4['name_th']; ?>" placeholder="อำเภอ" disabled>

                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="subdistrict"><strong>ตำบล <span class="text-danger">*</span></strong></label>


                                            <input type="text" class="classcus form-control" value="<?php echo $row3['name_th']; ?>" placeholder="ตำบล" disabled>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="chkPassport">
                                                <input type="checkbox" id="chkPassport" name="chk" value="1" />
                                                แก้ไขข้อมูลจังหวัด
                                            </label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="province"><strong>จังหวัด <span class="text-danger">*</span></strong></label>

                                            <select name="province" id="province" class="classcus custom-select " disabled="disabled">
                                                <option value="">เลือกจังหวัด</option>
                                                <?php while ($result = mysqli_fetch_assoc($query)) : ?>
                                                    <option value="<?= $result['id'] ?>"><?= $result['name_th'] ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="district"><strong>อำเภอ <span class="text-danger">*</span></strong></label>


                                            <select name="district" id="amphure" class="classcus custom-select" disabled="disabled">
                                                <option value="">เลือกอำเภอ</option>
                                            </select>

                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="subdistrict"><strong>ตำบล <span class="text-danger">*</span></strong></label>


                                            <select name="subdistrict" id="district" class="classcus custom-select" disabled="disabled">
                                                <option value="">เลือกตำบล</option>
                                            </select>
                                        </div>

                                      


                                    </div>
                                
                                    <hr>
                                    <div class="text-right">
                                        <input type="hidden" name="edit_id" value="<?php echo $row['customer_id']; ?>">

                                        <input type="hidden" name="action" value="edit">
                                        <button id="btnAddId" class="btn btn-outline-primary d-none" type="submit">ยืนยันการเพิ่มลูกค้า</button>
                                        <button class="btn btn-primary ladda-button btn-add" data-style="expand-left">
                                            <span class="ladda-label">ยืนยันการแก้ไขข้อมูลลูกค้า</span>
                                        </button>
                                        <a class="btn btn-outline-danger m-1" href="/customerslist.php" type="button">กลับหน้ารายการ</a>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- Footer Start -->
            <div class="flex-grow-1"></div>
            <div class="app-footer">
                <div class="footer-bottom border-top pt-3 d-flex flex-column flex-sm-row align-items-center">
                    <a class="btn btn-primary text-white btn-rounded" href="https://themeforest.net/item/gull-bootstrap-laravel-admin-dashboard-template/23101970" target="_blank">Buy Gull HTML</a>
                    <span class="flex-grow-1"></span>
                    <div class="d-flex align-items-center">
                        <img class="logo" src="../../dist-assets/images/logo.png" alt="">
                        <div>
                            <p class="m-0">&copy; 2021 1M Co,.Ltd.</p>
                            <p class="m-0">All rights reserved</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- fotter end -->
        </div>
    </div><!-- ============ Search UI Start ============= -->


    <!-- PAGINATION CONTROL -->

    <!-- ============ Search UI End ============= -->
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
    <script type="text/javascript">
        $(function() {
            $("#chkPassport").click(function() {
                if ($(this).is(":checked")) {

                    $("#province").removeAttr("disabled");
                    $("#district").removeAttr("disabled");
                    $("#amphure").removeAttr("disabled");
                    $("#province").focus();
                } else {
                    $("#province").attr("disabled", "disabled");
                    $("#district").attr("disabled", "disabled");
                    $("#amphure").attr("disabled", "disabled");
                }
            });
        });
    </script>
</body>

</html>