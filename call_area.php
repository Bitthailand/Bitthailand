<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
$emp_id = $_SESSION["username"];
include './include/connect.php';
include './include/config.php';
$call = $_REQUEST['call'];
$area = $_REQUEST['area'];
$space = $_REQUEST['space'];
$corner = $_REQUEST['corner'];

?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>ขนส่งสินค้า</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
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
            <!-- แจ้งเตือน -->
            <div id="alert_placeholder" style="z-index: 9999999; left:1px; top:1%; width:100%; position:absolute;"></div>
            <!-- ปิดการแจ้งเตือน -->
            <div class="main-content">

                <form name='frmAMain' id='inputform2' class="tab-pane fade active show" method="post">
                    <div class="border-bottom text-primary">
                        <div class="card-title">คำนวณพื้นที่เสารั้วลวดหนาม</div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="row mt-12">
                            <div class="form-group col-md-4">
                                <label for="product"><strong>สินค้าที่จะผลิต <span class="text-danger">*</span></strong></label>
                                <select name="productx" id="productx" class="classcus custom-select " required>
                                    <?php
                                    $sql6 = "SELECT *  FROM product where ptype_id='FP'  AND   status='0'  order by product_id  ASC ";
                                    $result6 = mysqli_query($conn, $sql6);
                                    if (mysqli_num_rows($result6) > 0) {
                                        while ($row6 = mysqli_fetch_assoc($result6)) {
                                    ?>
                                            <option value="<?= $row6['id'] ?>" <?php if (isset($productx) && ($productx == $row6['id'])) {
                                                                                    echo "selected"; ?>>
                                                <?php echo $row6['product_id'] .  $row6['product_name'] . '  หนา' . $row6['thickness'];     ?>
                                            <?php  } else {      ?>
                                            <option value="<?= $row6['id'] ?>"> <?php echo $row6['product_id'] .  $row6['product_name'] . '  หนา' . $row6['thickness'];    ?>
                                            <?php } ?>
                                            </option>
                                    <?php  }
                                    }  ?>
                                </select>

                            </div>
                            <div class="form-group col-md-2">
                                <label for="area"><strong>พื้นที่ เมตร <span class="text-danger"></span></strong></label>

                                <input type="text" name="area" value="<?= $area ?>" class="classcus form-control" placeholder="พ.ท">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="space"><strong>ระยะห่าง เมตร <span class="text-danger"></span></strong></label>

                                <input type="text" name="space"  value="<?= $space ?>" class="classcus form-control" placeholder="ระยะ">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="corner"><strong>จำนวนมุม <span class="text-danger"></span></strong></label>
                                <input type="text" name="corner" id="concrete_cal" value="<?php echo "$corner"; ?>" class="classcus form-control" placeholder="คำนวณคอนกรีต">
                            </div>
                            <input type="hidden" name="call" value="1">
                            <button class="btn btn-outline-primary ripple m-1" name="submit" type="submit" style=" height: 33px; margin-top: 24px!important;">คำนวณสินค้า</button>

                        </div>
                    </div>
            </div>
            </form>

            <?php
            $call = $_REQUEST['call'];
            $area = $_REQUEST['area'];
            $space = $_REQUEST['space'];
            $corner = $_REQUEST['corner'];
            $productx = $_REQUEST['productx'];
            if ($call == 1) {
                $sql = "SELECT * FROM product  where id='$productx'  ";
                $rs = $conn->query($sql);
                $rs = $rs->fetch_assoc(); 
                $corner = $_REQUEST['corner'];
                $sum = ($area / $space) + 1+ $corner;
                echo"$sum";
                $total=$rs['unit_price']*$sum;
                echo"ราคาต่อหน่วย $rs[unit_price]";
                echo"รวมราคา: $total";
            } ?>
            <!-- Header -->
            <?php include './include/footer.php'; ?>
            <!-- =============== Header End ================-->
        </div>
    </div>


    <form class="d-none" method="POST">
        <input type="text" id="FSColumnId" name="column" value="<?php echo $S_COLUMN; ?>" placeholder="">
        <input type="text" id="FSKeywordId" name="keyword" value="<?php echo $S_KEYWORD; ?>" placeholder="">
        <input type="text" id="FSRowId" name="row" value="<?php echo $S_ROW; ?>" placeholder="">
        <input type="number" id="FSPageId" name="page" value="<?php echo $S_PAGE; ?>" placeholder="">
        <button class="btn" id="FSButtonID" type="submit"></button>
    </form>
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