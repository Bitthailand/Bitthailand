<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config_date.php';
$po_id = $_REQUEST['po_id'];

?>
<!DOCTYPE html>
<html>

<head>
    <link href="../../dist-assets/css/themes/styleforprint.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />

</head>

<body>
    <!--  header  -->

    <div class="page-header" style="text-align: center">
        <div class="col-12">
            <div class="row">
                <div class="col-12" style="text-align: right">
                    <button type="button" class="btn-primary mb-sm-0 mb-3 " onclick="window.print()">
                        พิมพ์ใบสั่งผลิต
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <h4 class="font-weight-bold">บริษัท วันเอ็ม จำกัด/ 1M CO.,LTD.</h4>
                    <p>290 ม.1 ต.กระโสบ อ.เมือง จ.อุบลราชธานี 34000 โทร 061-4362825</p>
                    <p>290 MU 1 Krasop, Mueang Ubon Ratchathani, Ubon Ratchathani 34000, Tel. 045-953-448</p>
                    <div class="mt-3 mb-4 border-top"></div>
                </div>
                <div class="col-12 text-sm-center">
                    <h4 class="font-weight-bold">ใบสั่งผลิตสินค้า</h4>
                </div>
                <div class="col-12">
                    <div class="row">
                        <?php
                        $sql = "SELECT * FROM production_order  where po_id='$po_id'  ";
                        $rs = $conn->query($sql);
                        $row = $rs->fetch_assoc();

                        ?>
                        <div class="col-6 text-left">
                            <strong>วันที่สั่งผลิต :</strong>
                            <?php $date = explode(" ", $row['po_date']);
                            $dat = datethai2($date[0]);
                            echo '<strong>' . $dat . '</strong>'; ?>
                        </div>
                        <div class="col-6 text-right"><strong>ผู้สั่งผลิต :</strong>
                            <?php echo $_SESSION["username"] ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br />
    </div>
    <!-- End header  -->
    <!-- Footer  -->
    <div class="page-footer">
        <div class="col-md-12">
            <div class="invoice-summary">
                <p> ผู้สั่งผลิต <span>_____________________</span></p>
                <br>
                <p> ผู้ควบคุมการผลิต <span>_____________________</span></p>
                <br>
                <p> ผู้รับเหมา <span>_____________________</span></p>
                <br>
                <p> ผู้ควบคุมคุณภาพ <span>_____________________</span></p>
            </div>
        </div>
    </div>
    <!-- End Footer  -->

    <!-- Print List data  -->
    <div class="col-12">
        <table class="print-table">

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
                        <!--*** CONTENT GOES HERE ***-->
                        <div class="page">

                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-hover">
                                        <thead>

                                        </thead>
                                        <colgroup>
                                            <col>
                                        </colgroup>
                                        <colgroup span="2"></colgroup>
                                        <colgroup span="2"></colgroup>

                                        <tbody>
                                            <tr class="bg-gray-300">
                                                <th rowspan="2" scope="rowgroup" class="text-center" width="3%">ลำดับ</th>
                                                <th rowspan="2" scope="rowgroup" class="text-center" width="3%">โรงงาน</th>
                                                <th rowspan="2" scope="rowgroup" class="text-center" width="3%">แพ</th>
                                                <th rowspan="2" scope="rowgroup" class="text-center" width="66%">รายการ</th>
                                                <th colspan="1" scope="colgroup" class="text-center" width="5%">จำนวน</th>
                                                <th colspan="1" scope="colgroup" class="text-center" width="5%">พ.ท.</th>
                                                <th colspan="1" scope="colgroup" class="text-center" width="5%">ขนาดลวด</th>
                                                <th colspan="1" scope="colgroup" class="text-center" width="5%">จำนวนลวด</th>
                                                <th colspan="1" scope="colgroup" class="text-center" width="5%">คอนกรีต</th>
                                            </tr>
                                            <tr class="bg-gray-300">
                                                <th scope="col" class="text-center">(P)</th>
                                                <th scope="col" class="text-center">(Sq.m.)</th>
                                                <th scope="col" class="text-center">Dai.(mm.)</th>
                                                <th scope="col" class="text-center">(เส้น)</th>
                                                <th scope="col" class="text-center">(ลบ.ม.)</th>
                                            </tr>

                                        </tbody>
                                        <tbody>
                                            <?php
                                            // echo "$po_id";

                                            $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM `production_order`  where po_id='$po_id'  ");
                                            $total_records = mysqli_fetch_array($result_count);
                                            $total_records = $total_records['total_records'];

                                            $result = mysqli_query($conn, "SELECT * FROM `production_order`   where po_id='$po_id' ");
                                            while ($row = mysqli_fetch_array($result)) {
                                                $count = mysqli_query($conn, "SELECT COUNT(*) As total FROM production_detail  where po_id = '$po_id'  ORDER BY id ASC ");
                                                $total = mysqli_fetch_array($count);
                                                $count = 0;
                                                $sqlxx = "SELECT *  FROM production_detail  where po_id = '$po_id' ORDER BY id ASC  ";
                                                $resultxx = mysqli_query($conn, $sqlxx);
                                                if (mysqli_num_rows($resultxx) > 0) {
                                                    $num = @mysqli_num_rows($resultxx);
                                                    $row_cnt = $resultxx->num_rows;
                                                    // while ($row1 = mysqli_fetch_assoc($resultxx)) {
                                                    while ($row2 = mysqli_fetch_array($resultxx)) {
                                            ?> <tr>
                                                            <td> <strong><?php
                                                                            $x = $count++;
                                                                            echo $x == 0 ? '<strong>' .  ++$id . '</strong>' : ''; ?></strong>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php
                                                                $sql5 = "SELECT * FROM plant where  plant_id='$row2[plant_id]' ";
                                                                $rs5 = $conn->query($sql5);
                                                                $row5 = $rs5->fetch_assoc();
                                                                echo "$row5[factory_id]";
                                                                ?>
                                                            </td>
                                                            <td class="text-center"><?= $row2['plant_id'] ?></td>
                                                            <td class="text-left"> <?php
                                                                                    $sqlx = "SELECT * FROM product   WHERE product_id= '$row2[product_id]'";
                                                                                    $rsx = $conn->query($sqlx);
                                                                                    $rowx = $rsx->fetch_assoc();
                                                                                    echo $rowx['product_name'];
                                                                                    ?></td>
                                                            <td class="text-right"><?php echo $row2['qty']; ?></td>
                                                            <td class="text-right"><?php echo $row2['sqm']; ?></td>
                                                            <td class="text-center"><?php echo $rowx['dia_size']; ?></td>
                                                            <td class="text-center"><?php echo $rowx['dia_count']; ?></td>
                                                            <td class="text-right"><?php echo $row2['concrete_cal']; ?></td>
                                                        </tr>
                                            <?php
                                                    }
                                                }
                                            }
                                            // mysqli_close($conn);
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <!-- <div class="page">PAGE 2</div> -->
                    </td>
                </tr>
            </tbody>

            <tfoot>
                <tr>
                    <td>
                        <!--place holder for the fixed-position footer-->
                        <div class="page-footer-space"></div>
                    </td>
                </tr>
            </tfoot>

        </table>
    </div>

    <!-- End Print List data  -->
</body>

</html>