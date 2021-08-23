<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config_so.php';
include './include/config_date.php';
$order_id=$_REQUEST['order_id'];
$emp_id = $_SESSION["username"];
$datetoday = date('Y-m-d');
$sql = "SELECT * FROM orders   WHERE order_id= '$order_id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
// ====
$sql2 = "SELECT * FROM customer_type  WHERE id= '$row[cus_type]'";
$rs2 = $conn->query($sql2);
$row2 = $rs2->fetch_assoc();
// ====
$sql3 = "SELECT * FROM customer  WHERE customer_id= '$row[cus_id]'";
$rs3 = $conn->query($sql3);
$row3 = $rs3->fetch_assoc();
// ===
$sql5 = "SELECT MAX(id) AS id_run FROM delivery  ";
$rs5 = $conn->query($sql5);
$row_run = $rs5->fetch_assoc();

$datetodat = date('Y-m-d');
$date = explode(" ", $datetodat);
$dat = datethai_so($date[0]);
$code_new = $row_run['id_run'] + 1;
$code = sprintf('%05d', $code_new);
$so_id = $dat . $code;
?>
<!DOCTYPE html>
<html lang="en" dir="">
<input id="order_id" value="<?php echo"$order_id";?>" type="text" name="order_id"  >
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Sale Order | ใบส่งของ</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <style>
    p {
        margin-top: 0;
        margin-bottom: 0.1rem;
    }
    </style>
        <style>
        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
            font-size: 0.813rem !important;
        }
    </style>
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
            <div class="main-content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="tab-content">
                            <div class="card">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">

                                        <!-- -===== Print Area =======-->
                                        <div id="print-area">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4 class="font-weight-bold">บริษัท วันเอ็ม จำกัด</h4>
                                                    <p>290 ม.1 ต.กระโสบ อ.เมือง จ.อุบลราชธานี 34000</p>
                                                    <p>เลขที่ประจำตัวผู้เสียภาษี 0345555000224 สำนักงานใหญ่</p>
                                                </div>
                                                <div class="col-md-6 text-sm-right">
                                                    <h4 class="font-weight-bold">ใบส่งของ</h4>
                                                </div>
                                            </div>
                                            <div class="mt-3 mb-4 border-top"></div>
                                            <div class="row mb-5">
                                                <div class="col-md-6 mb-3 mb-sm-0">
                                                    <h5 class="font-weight-bold">ลูกค้า</h5>
                                                    <p><strong>ชื่อลูกค้า : </strong><?= $row3['customer_name'] ?></p>
                                                    <p><strong>บริษัท : </strong><?= $row3['company_name'] ?></p>
                                                    <p><strong>ที่อยู่ : </strong><?= $row3['bill_address'] ?> </p>
                                                    <p>เลขที่ประจำตัวผู้เสียภาษี <?= $row3['tax_number'] ?></p>
                                                    <p><strong>โทร : </strong> <?= $row3['tel'] ?></p>
                                                    <p><strong>อ้างอิง : </strong><?= $row3['contact_name'] ?></p>
                                                </div>
                                                <div class="col-md-6 text-sm-right">
                                                    <h5 class="font-weight-bold"></h5>
                                                    <div class="invoice-summary">
                                                        <div class="form-group col-md-12">
                                                            <p>ลำดับการสั่งซื้อ <span><?=$order_id?></span></p>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="ai_id"><strong>เลขที่ใบส่งของ <span class="text-danger"></span></strong></label>
                                                            <input type="text" name="so_id" value="<?=$so_id?>" class="classcus form-control" id="so_id" placeholder="เลขที่ใบส่งของ">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <div class="form-group">
                                                                <label for="delivery_date">วันที่</label>
                                                                <input id="dev_date" class="form-control" type="date" min="<?=$datetodat?>" name="dev_date" value="<?=$dev_date?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-hover mb-4">
                                                        <thead class="bg-gray-300">
                                                            <tr>
                                                                <th scope="col" class="text-center" width="5%">No.</th>
                                                                <th scope="col" class="text-center" width="35%">รหัสสินค้า/รายละเอียด</th>
                                                                <th scope="col" class="text-center" width="10%">สต๊อกโรงงาน 1</th>
                                                                <th scope="col" class="text-center" width="10%">สต๊อกโรงงาน 2</th>
                                                                <th scope="col" class="text-center" width="10%">จำนวนที่ต้องส่ง</th>
                                                                <th scope="col" class="text-center" width="10%">โรงงาน 1</th>
                                                                <th scope="col" class="text-center" width="10%">โรงงาน 2</th>
                                                                <th scope="col" class="text-center" width="10%">จำนวนส่ง</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $sql_pro = "SELECT * FROM order_details  where order_id='$order_id' order by date_create  ASC ";
                                                        $result_pro = mysqli_query($conn, $sql_pro);
                                                        if (mysqli_num_rows($result_pro) > 0) {
                                                            while ($row_pro = mysqli_fetch_assoc($result_pro)) { 
                                                                
                                                                $detail_id=$row_pro['id'];
                                                                $product_id=$row_pro['product_id'];
                                                                ?>
                                                               <tr  class="line">
                                                                <th scope="row" class="text-center"><?=++$idx;?></th>
                                                                <td>  <?php
                                                                        $sqlx3 = "SELECT * FROM product  WHERE product_id= '$row_pro[product_id]'";
                                                                        $rsx3 = $conn->query($sqlx3);
                                                                        $rowx3 = $rsx3->fetch_assoc();
                                                                        echo $rowx3['product_id'].$rowx3['product_name'].'  หนา'.$rowx3['thickness'].'  ขนาดลวด'.$rowx3['dia_size']. '  จำนวน'.$rowx3['dia_count'];
                                                                        ?></td>
                                                                <td class="text-center"><?php echo $rowx3['fac1_stock'];?></td>
                                                                <td class="text-center"><?php echo $rowx3['fac2_stock'];?></td>
                                                                <td class="text-center"><?php echo $row_pro['qty'];?></td>
                                                                <td class="text-center"><input class="form-control"id="face1[<?=$detail_id?>][<?=++$idx;?>]" value="<?php echo"$face1";?>" type="text" name='face1[<?=$product_id?>][<?=$detail_id?>][<?=++$idx;?>]' placeholder="จำนวนที่ส่ง" ></td>
                                                                <td class="text-center"><input class="form-control"id="face2"  value="<?php echo"$face2";?>" type="text" name='face2[<?=$product_id?>][<?=$detail_id?>][<?=++$idx;?>]' placeholder="จำนวนที่ส่ง" ></td>
                                                                <td class="text-center">60</td>
                                                            </tr>
                                                           <?php }} ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="mt-3 mb-4 border-top"></div>
                                            <div class="d-sm-flex mb-5" data-view="print">
                                                <span class="m-auto"></span>
                                                <a class="btn btn-outline-primary m-1" href="/saleorder.php" type="button" target="_blank">พิมพ์ใบส่งของ(SO)</a>
                                                <a class="btn btn-outline-primary m-1" href="/hs.php" type="button" target="_blank">พิมพ์ใบเสร็จรับเงิน(HS)</a>
                                                <a class="btn btn-outline-primary m-1" href="/invoice.php" type="button" target="_blank">พิมพ์ใบกำกับสินค้า(IV)</a>
                                                <a class="btn btn-outline-primary m-1" href="#" type="button">บันทึกการส่งของ</a>
                                            </div>

                                        </div>
                                        <!-- ==== / Print Area =====-->
                                    </div>
                                </div>
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

</body>
<script>
    $( document ).ready(function() {
  $("body").on("keyup", "input", function(event){
	  $(this).closest(".line").find(".tot_price").val( $(this).closest(".line").find(".qty").val()*$(this).closest(".line").find(".value").val() );
    $(this).closest(".line").find(".total_price").val( $(this).closest(".line").find(".tot_price").val()*1-$(this).closest(".line").find(".discount").val() );
    var sum = 0;
    $('.total_price').each(function() {
        sum += Number($(this).val());
        console.log('sum',sum)
    });
    $(".grand_total").val(sum);
  });
});
</script>
</html>
