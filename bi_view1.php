<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config_so.php';
include './include/config_date.php';
$bi_id = $_REQUEST['bi_id'];
$emp_id = $_SESSION["username"];
$datetoday = date('Y-m-d');
$sql = "SELECT * FROM bi_number  WHERE bi_number= '$bi_id'";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
// ====
// echo"$order_id";
// echo"$row[cus_type]";
$sql3 = "SELECT * FROM customer  WHERE customer_id= '$row[cus_id]'";
$rs3 = $conn->query($sql3);
$row3 = $rs3->fetch_assoc();

$sql2 = "SELECT * FROM customer_type  WHERE id= '$row3[cus_type]'";
$rs2 = $conn->query($sql2);
$row2 = $rs2->fetch_assoc();
$datetoday = date('Y-m-d');
// ====
?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Quotation | ใบเสนอราคา</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />


    <style>
        p {
            margin-top: 0;
            margin-bottom: 0.1rem;
        }

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
                                        <div class="d-sm-flex mb-5" data-view="print"><span class="m-auto"></span>

                                            <button class="btn btn-primary mb-sm-0 mb-3 print-invoice" onclick="window.print()">พิมพ์ใบวางบิล</button>
                                        </div>
                                        <!-- -===== Print Area =======-->
                                        <div id="print-area">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4 class="font-weight-bold">บริษัท วันเอ็ม จำกัด</h4>
                                                    <p>290 ม.1 ต.กระโสบ อ.เมือง จ.อุบลราชธานี 34000</p>
                                                    <p>เลขที่ประจำตัวผู้เสียภาษี 0345555000224 สำนักงานใหญ่</p>
                                                </div>
                                                <div class="col-md-6 text-sm-right">
                                                    <h4 class="font-weight-bold">ใบวางบิล</h4>
                                                </div>
                                            </div>
                                            <div class="mt-3 mb-4 border-top"></div>
                                            <div class="row mb-5">
                                                <div class="col-md-6 mb-3 mb-sm-0">
                                                    <h5 class="font-weight-bold">ลูกค้า</h5>
                                                    <?php
                                                    $sql6 = "SELECT * FROM districts  WHERE id= '$row3[subdistrict]'";
                                                    $rs6 = $conn->query($sql6);
                                                    $row6 = $rs6->fetch_assoc();
                                                    $sql7 = "SELECT * FROM amphures  WHERE id= '$row3[district]'";
                                                    $rs7 = $conn->query($sql7);
                                                    $row7 = $rs7->fetch_assoc();
                                                    $sql8 = "SELECT * FROM provinces  WHERE id= '$row3[province]'";
                                                    $rs8 = $conn->query($sql8);
                                                    $row8 = $rs8->fetch_assoc();

                                                    ?>
                                                    <p><strong>ชื่อลูกค้า : </strong>คุณ <?= $row3['customer_name'] ?></p>
                                                    <p><strong>บริษัท : </strong>คุณ <?= $row3['company_name'] ?></p>
                                                    <p><strong>ที่อยู่ : </strong><?php echo $row3['bill_address'] . " ต" . $row6['name_th'] . "  อ." . $row7['name_th'] . " จ." . $row8['name_th']; ?> </p>
                                                    <p><strong>โทร : </strong> <?= $row3['tel'] ?></p>
                                                    <p><strong>อ้างอิง : </strong><?= $row3['contact_name'] ?></p>
                                                    <p> </p>
                                                </div>
                                                <div class="col-md-6 text-sm-right">
                                                    <h5 class="font-weight-bold"></h5>
                                                    <div class="invoice-summary">
                                                        <p>เลขที่ใบวางบิล <span><?php echo "$row[bi_number]"; ?></span></p>
                                                        <p></span></p>
                                                        <p>วันที่ <span><?php $date = explode(" ", $datetoday);
                                                                        $dat = datethai2($date[0]);
                                                                        echo "$dat"; ?> </span></p>
                                                        <p></p>
                                                        <p>เงื่อนไขการชำระเงิน : <span></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-hover mb-4">
                                                        <thead class="bg-gray-300">
                                                            <tr>
                                                                <th scope="col" class="text-center">No.</th>
                                                                <th scope="col" class="text-center">เลขที่ใบกำกับ</th>
                                                                <th scope="col" class="text-center">วันที่</th>
                                                                <th scope="col" class="text-center">ครบกำหนด</th>
                                                                <th scope="col" class="text-center">จำนวนเงิน</th>
                                                                <th scope="col" class="text-center">ชำระแล้ว</th>
                                                                <th scope="col" class="text-center">เงินคงค้าง</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $sql_pro = "SELECT * FROM bi_number  where bi_number='$bi_id' order by id ASC ";
                                                            $result_pro = mysqli_query($conn, $sql_pro);
                                                            if (mysqli_num_rows($result_pro) > 0) {
                                                                while ($row_pro = mysqli_fetch_assoc($result_pro)) { ?>
                                                                    <tr>
                                                                        <th scope="row" class="text-center"><?= ++$id; ?></th>
                                                                        <td class="text-center"><?= $row_pro['iv_id'] ?>
                                                                            <?php
                                                                            $sql_dev = "SELECT * FROM delivery  WHERE iv_id= '$row_pro[iv_id]'";
                                                                            $rs_dev = $conn->query($sql_dev);
                                                                            $row_dev  = $rs_dev->fetch_assoc();
                                                                            $sql_dev_detail = "SELECT  SUM(dev_qty*unit_price) AS total FROM deliver_detail  WHERE dev_id= '$row_dev[dev_id]'";
                                                                            $rs_dev_detail = $conn->query($sql_dev_detail);
                                                                            $row_dev_detail  = $rs_dev_detail->fetch_assoc();

                                                                            ?>
                                                                        </td>
                                                                        <td class="text-center"> <?php
                                                                                                    $date = explode(" ", $row_dev['dev_date']);
                                                                                                    $dat = datethai2($date[0]);
                                                                                                    echo "$dat";
                                                                                                    ?>
                                                                        </td>
                                                                        <td class="text-center"><?php
                                                                                                $date = explode(" ", $row_dev['date_end']);
                                                                                                $dat = datethai2($date[0]);
                                                                                                echo "$dat";
                                                                                                ?></td>
                                                                        <td class="text-center"><?php echo number_format($row_dev_detail['total'], '2', '.', ',') ?></td>
                                                                        <td class="text-center"><?php echo number_format($row_dev['ai_count'], '2', '.', ',') ?>
                                                                        <td class="text-center">
                                                                            <?php $sum_total = $row_dev_detail['total'] - $row_dev['ai_count'];
                                                                            echo number_format($sum_total, '2', '.', ',');
                                                                            $grand_total=$grand_total+$sum_total;
                                                                            
                                                                            
                                                                            
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                            <?php }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <p>ตัวอักษร :</p>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <p><?php echo Convert($grand_total);?></p>
                                                        </div>
                                                        <div class="col-md-4 text-right">
                                                            <div class="row" style="justify-content: flex-end; margin-right: 0;">
                                                                <p>รวมเป็นเงิน</p>
                                                                <h5 class="font-weight-bold" style="width: 120px; display: inline-block;"> <span><?php echo number_format($grand_total,'2','.',',')?></span></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                               

                                            </div>
                                            <div class="mt-3 mb-4 border-top"></div>
                                          
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-4 text-center">
                                                        <p>ชื่อผู้รับวางบิล ____________________________</p>
                                                        <br>
                                                        <p>วันที่รับ ________/__________/_____ <span></span></p>
                                                        <p>วันที่นัดรับเช็ค ________/__________/__________ <span></span></p>
                                                    </div>
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-5 text-center">
                                                        <p>ในนาม บริษัท วันเอ็ม จำกัด</p>
                                                        <br>
                                                        <p>ผู้รับวางบิล ____________________ <span></span></p>
                                                        <br>
                                                        <p>วันที่ ________/__________/__________ <span></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ==== / Print Area =====-->
                                    </div>
                                    <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="edit-tab">
                                        <!-- ==== Edit Area =====-->
                                        <div class="d-flex mb-5"><span class="m-auto"></span>
                                            <button class="btn btn-primary">Save</button>
                                        </div>
                                        <form>
                                            <div class="row justify-content-between">
                                                <div class="col-md-6">
                                                    <h4 class="font-weight-bold">Order Info</h4>
                                                    <div class="col-sm-4 form-group mb-3 pl-0">
                                                        <label for="orderNo">Order Number</label>
                                                        <input class="form-control" id="orderNo" type="text" placeholder="Enter order number" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 text-right">
                                                    <label class="d-block text-12 text-muted">Order Status</label>
                                                    <div class="pr-0 mb-4">
                                                        <label class="radio radio-reverse radio-danger">
                                                            <input type="radio" name="orderStatus" value="Pending" /><span>Pending</span><span class="checkmark"></span>
                                                        </label>
                                                        <label class="radio radio-reverse radio-warning">
                                                            <input type="radio" name="orderStatus" value="Processing" /><span>Processing</span><span class="checkmark"></span>
                                                        </label>
                                                        <label class="radio radio-reverse radio-success">
                                                            <input type="radio" name="orderStatus" value="Delivered" /><span>Delivered</span><span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="order-datepicker">Order Date</label>
                                                        <input class="form-control text-right" id="order-datepicker" placeholder="yyyy-mm-dd" name="dp" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3 mb-4 border-top"></div>
                                            <div class="row mb-5">
                                                <div class="col-md-6">
                                                    <h5 class="font-weight-bold">Bill From</h5>
                                                    <div class="col-md-10 form-group mb-3 pl-0">
                                                        <input class="form-control" id="billFrom3" type="text" placeholder="Bill From" />
                                                    </div>
                                                    <div class="col-md-10 form-group mb-3 pl-0">
                                                        <textarea class="form-control" placeholder="Bill From Address"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <h5 class="font-weight-bold">Bill To</h5>
                                                    <div class="col-md-10 offset-md-2 form-group mb-3 pr-0">
                                                        <input class="form-control text-right" id="billFrom2" type="text" placeholder="Bill From" />
                                                    </div>
                                                    <div class="col-md-10 offset-md-2 form-group mb-3 pr-0">
                                                        <textarea class="form-control text-right" placeholder="Bill From Address"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-hover mb-3">
                                                        <thead class="bg-gray-300">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Item Name</th>
                                                                <th scope="col">Unit Price</th>
                                                                <th scope="col">Unit</th>
                                                                <th scope="col">Cost</th>
                                                                <th scope="col"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">1</th>
                                                                <td>
                                                                    <input class="form-control" value="Product 1" type="text" placeholder="Item Name" />
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" value="300" type="number" placeholder="Unit Price" />
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" value="2" type="number" placeholder="Unit" />
                                                                </td>
                                                                <td>600</td>
                                                                <td>
                                                                    <button class="btn btn-outline-secondary float-right">Delete</button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">2</th>
                                                                <td>
                                                                    <input class="form-control" value="Product 1" type="text" placeholder="Item Name" />
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" value="300" type="number" placeholder="Unit Price" />
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" value="2" type="number" placeholder="Unit" />
                                                                </td>
                                                                <td>600</td>
                                                                <td>
                                                                    <button class="btn btn-outline-secondary float-right">Delete</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <button class="btn btn-primary float-right mb-4">Add Item</button>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="invoice-summary invoice-summary-input float-right">
                                                        <p>Sub total: <span>$1200</span></p>
                                                        <p class="d-flex align-items-center">Vat(%):<span>
                                                                <input class="form-control small-input" type="text" value="10" />$120</span></p>
                                                        <h5 class="font-weight-bold d-flex align-items-center">Grand Total:<span>
                                                                <input class="form-control small-input" type="text" value="$" />$1320</span></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- ==== / Edit Area =====-->
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

</html>