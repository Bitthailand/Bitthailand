<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config_so.php';
include './include/config_date.php';
?>
<!DOCTYPE html>
<html lang="en" dir="">
<?php
$re_id = $_REQUEST['re_id'];
$emp_id = $_SESSION["username"];
$datetoday = date('Y-m-d');
// echo"$re_id";
$sql = "SELECT * FROM re_number  WHERE re_number= '$re_id'  ";
$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
// ====

$sql3 = "SELECT * FROM bi_number  WHERE re_id= '$row[re_number]' ";
$rs3 = $conn->query($sql3);
$row3 = $rs3->fetch_assoc();
// echo"$row3[cus_id]";
$sql3 = "SELECT * FROM customer  WHERE customer_id= '$row3[cus_id]'";
$rs3 = $conn->query($sql3);
$row3 = $rs3->fetch_assoc();

$sql2 = "SELECT * FROM customer_type  WHERE id= '$row3[cus_type]'";
$rs2 = $conn->query($sql2);
$row2 = $rs2->fetch_assoc();
$datetoday = date('Y-m-d');
// ====
?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Quotation | ใบเสนอราคา</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <!-- <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" /> -->
    <!-- <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" /> -->
    <link href="../../dist-assets/css/themes/styleforprint.css" rel="stylesheet" />


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

<body class="qt2 text-left">
    <!--  header  -->
    <div class="page-header">
        <div class="col-12 text-right">
            <button class="btn-primary mb-0 mb-3" onclick="window.print()">พิมพ์ใบวางบิล</button>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-6">
                    <h4 class="font-weight-bold">บริษัท วันเอ็ม จำกัด</h4>
                    <p>290 ม.1 ต.กระโสบ อ.เมือง จ.อุบลราชธานี 34000</p>
                    <p>เลขที่ประจำตัวผู้เสียภาษี 0345555000224 สำนักงานใหญ่</p>
                </div>
                <div class="col-6 text-right">
                    <h4 class="font-weight-bold">ใบเสร็จรับเงิน(RE)</h4>
                </div>
            </div>
            <div class="mt-3 mb-4 border-top"></div>
            <div class="row mb-5">
                <div class="col-6 mb-3 mb-0">
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
                    <p><strong>ชื่อลูกค้า : </strong> <?= $row3['customer_name'] ?></p>
                    <p><strong>บริษัท : </strong> <?= $row3['company_name'] ?></p>
                    <p><strong>ที่อยู่ :
                        </strong><?php echo $row3['bill_address'] . " ต." . $row6['name_th'] . "  อ." . $row7['name_th'] . " จ." . $row8['name_th']; ?>
                    </p>
                    <p><strong>โทร : </strong> <?= $row3['tel'] ?></p>
                    <p><strong>เลขที่ประจำตัวผู้เสียภาษี : </strong><?= $row3['tax_number'] ?></p>
                    <p> </p>
                </div>
                <div class="col-6 text-right">
                    <h5 class="font-weight-bold"></h5>
                    <div class="invoice-summary">
                        <p><span>เลขที่ใบเสร็จ </span><span><?php echo "$row[re_number]"; ?></span></p>
                        <p></span></p>
                        <p><span>วันที่ </span><span><?php $date = explode(" ", $row['re_date']);
                                                                        $dat = datethai2($date[0]);
                                                                        echo "$dat"; ?> </span></p>
                        <p></p>
                        <?php
                                                        
                                                         $sql8x = "SELECT * FROM payment  WHERE id= '$row[payment]'";
                                                         $rs8x = $conn->query($sql8x);
                                                         $row8x = $rs8x->fetch_assoc();
                                                       
                                                        ?>
                        <p><span>พนักงานขาย : </span><span>-</span></p>
                        <p><span>วิธีการชำระเงิน : </span><span><?php  echo"$row8x[name]"; ?></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End header  -->

    <!-- Footer  -->
    <div class="page-footer">
        <div class="mt-3 mb-4 border-top"></div>
        <div class="col-12">
            <div class="row">
                <div class="col-4 text-center">
                    <p>ผู้รับเงิน____________________</p>
                </div>
                <div class="col-3">
                    <p>ผู้จ่ายเงิน____________________</p>
                </div>
                <div class="col-5 text-center">
                    <p>ผู้รับมอบอำนาจ____________________</p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer  -->

    <!-- Data  -->
    <div class="col-12">
        <table class="print-table" style="width: 100%;">
            <thead>
                <tr>
                    <td>
                        <!--place holder for the fixed-position header-->
                        <div class="page-header-space"></div>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="page">
                            <div class="row">
                                <div class="col-12 table-responsive">
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
                                                            $sql_pro = "SELECT * FROM bi_number  where re_id='$re_id' order by id ASC ";
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
                                <div class="col-6">

                                </div>
                                <div class="col-2">

                                </div>
                                <div class="col-3">

                                </div>
                                <div class="col-1">

                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-3">
                                            <p>ตัวอักษร :</p>
                                        </div>
                                        <div class="col-5">
                                            <p><?php echo Convert($grand_total);?></p>
                                        </div>
                                        <div class="col-3">
                                            <p>รวมเป็นเงิน</p>
                                        </div>
                                        <div class="col-1 text-right">
                                            <div class="row" style="justify-content: flex-end; margin-right: 0;">

                                                <h3 class="font-weight-bold" style="width: 120px; display: inline-block;">
                                                    <span><?php echo number_format($grand_total,'2','.',',')?></span>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="page">PAGE 2</div> -->
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- End Data  -->

</body>

</html>