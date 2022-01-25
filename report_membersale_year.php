<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
$emp_id = $_SESSION["username"];
?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>รายงานลูกค้าที่ชื้อสินค้า</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
</head>
<?php
include './include/connect.php';
include './include/config.php';
include './get_dashbord_sale.php';
$datex = date('Y-m-d');
$d = explode("-", $datex);

?>

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
            <!-- ============ Tab Menu ============= -->


            <div class="main-content">


                <?php $datex = date('Y-m');
                $d = explode("-", $datex); ?>





                <div class="col-lg-12 col-md-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card mb-4">
                                <div class="card-body">


                                    <div class="ul-widget__body">
                                        <div class="tab-content">
                                            <div class="ul-widget__item">
                                                <div class="ul-widget__info">
                                                    <h3 class="ul-widget1__title ">รายงานลูกค้าที่มียอดสั่งชื้อ </h3>

                                                </div>
                                               
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table text-center" id="user_table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col" class="text-left">ประจำปี</th>
                                                            <th scope="col" class="text-left">จำนวนลูกค้า</th>
                                                            <th scope="col" class="text-left">ข้อมูล</th>
                                                          
                                                        </tr>
                                                    </thead>
                                                    <tbody id="myTable">
                                                        <?php
                                                        $datex = date('Y-m');
                                                        $d = explode("-", $datex);
                                                        $sql4 = "SELECT   YEAR(delivery.dev_date) AS year,COUNT(DISTINCT  delivery.cus_id )AS cus_id FROM  delivery  where  status_payment='1'  GROUP BY  year    ORDER BY year  DESC  ";
                                                        $result4 = mysqli_query($conn, $sql4);
                                                        if (mysqli_num_rows($result4) > 0) {
                                                            while ($row4 = mysqli_fetch_assoc($result4)) {
                                                        ?> <tr>
                                                                    <th scope="row"><?= ++$idx1; ?></th>
                                                                    <td class="text-left"><?= $row4['year'] ?></td>
                                                                    <td class="text-left"><?php  $sum_cus=$row4['cus_id']-1;  echo"$sum_cus"; ?></td>
                                                                    <td class="text-left"><a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="ดูข้อมูลประจำปี" href="/report_membersale.php?year=<?= $row4['year'] ?>">
                                                                            <i class="i-Check font-weight-bold"></i> </a></td>
                                                                  
                                                                </tr>
                                                        <?php }
                                                        } ?>
                                                    </tbody>
                                                </table>

                                            </div>



                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>





            </div><!-- end of main-content -->


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
    <script src="../../dist-assets/js/scripts/dashboard.v1.script.min.js?id=1"></script>
    <script src="../../dist-assets/js/scripts/customizer.script.min.js"></script>
    <script src="../../dist-assets/js/plugins/apexcharts.min.js"></script>
    <script src="../../dist-assets/js/plugins/apexcharts.dataseries.min.js"></script>
    <script src="../../dist-assets/js/scripts/apexChart.script.min.js"></script>
</body>
<script>
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
</html>