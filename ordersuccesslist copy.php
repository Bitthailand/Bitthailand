<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
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
    <link rel="stylesheet" href="../../dist-assets/css/plugins/datatables.min.css" />
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
<?php
include './include/connect.php';
include './include/config.php';
unset($_SESSION['order_id']);
$emp_id = $_SESSION["username"];

?>
        <!-- =============== Horizontal bar End ================-->
        <div class="main-content-wrap d-flex flex-column">
            <!-- ============ Body content start ============= -->
            <div class="main-content">

                <div class="row">
                    <div class="col-md-12">
                        <!-- ============ Tab Menu ============= -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link " href="/quotationlist.php">
                                    <h3 class="h5 font-weight-bold"> Order เสนอราคา
                                        <?php
                                        $count0 = "SELECT COUNT(*) As total_records FROM orders where  status='0'  AND order_status='1'";
                                        $rs_count0 = $conn->query($count0);
                                        $rcount0 = $rs_count0->fetch_assoc();
                                        ?>
                                        <span class="badge badge-pill badge-danger"><?= $rcount0['total_records'] ?></span>
                                    </h3>
                                    <span>รายการ Order เสนอราคา
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link" href="/ailist.php">
                                    <?php
                                    $count = "SELECT COUNT(*) As total_records FROM orders where  status='0'  AND order_status='2'";
                                    $rs_count = $conn->query($count);
                                    $rcount = $rs_count->fetch_assoc();
                                    ?>
                                    <h3 class="h5 font-weight-bold"> Order รอส่ง
                                        <span class="badge badge-pill badge-danger"><?= $rcount['total_records'] ?></span>
                                    </h3>
                                    <span>Order รอส่งสินค้า
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link" href="/creditlist.php">
                                    <h3 class="h5 font-weight-bold"> รอเคลียเครดิต
                                        <?php
                                        $count = "SELECT COUNT(*) As total_records FROM bi_number  where  status='0'  AND status_bi='1' ";
                                        $rs_count = $conn->query($count);
                                        $rcount = $rs_count->fetch_assoc();
                                        ?>

                                        <span class="badge badge-pill badge-danger"><?= $rcount['total_records'] ?></span>
                                    </h3>
                                    <span>ลูกค้าเครดิตรอเคลียยอด
                                        <span class="badge badge-warning"> Wait </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link active" href="/ordersuccesslist.php">
                                    <h3 class="h5 font-weight-bold"> Order สำเร็จ</h3>
                                    <span>Order ที่ส่งสินค้าเรียบร้อย
                                        <span class="badge badge-success"> Pass </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <?php
                                $countx = "SELECT COUNT(*) As total_records FROM sr_number  where  status_sr='1'   ";
                                $rs_countx = $conn->query($countx);
                                $rcountx = $rs_countx->fetch_assoc();
                                ?>
                                <a class="linkLoadModalNext nav-link" href="/orderrefun.php">
                                    <h3 class="h5 font-weight-bold"> Order คืนสินค้า </h3>
                                    <span> รายการคืนสินค้า
                                    <span class="badge badge-pill badge-danger"><?= $rcountx['total_records'] ?></span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="linkLoadModalNext nav-link" href="/orderloglist.php">
                                    <h3 class="h5 font-weight-bold"> Order Log </h3>
                                    <span> รายการ Order ทั้งหมด
                                        <span class="badge badge-light"> Log </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <!-- ============ End Tab Menu ============= -->
                        <div class="tab-content">

                            <!-- ============ Alert Message Start ============= -->

                            <!-- ============ Alert Message End ============= -->

                            <div class="mb-1">
                                <div class="ul-widget__item">
                                    <div class="ul-widget__info">
                                        <h3 class="ul-widget1__title "> ขายสินค้า </h3>
                                        <span class="ul-widget__desc "> รายการใบเสนอราคา </span>
                                    </div>
                                    <div class="text-left">
                                        <div class="row">

                                            <div class="col-auto">
                                            <div class="form-group">
                                                    <label for="searchNameId"> คำที่ต้องการค้น</label>
                                                    <input id="searchNameId" class="form-control" placeholder="Keyword" type="text" value="">
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="searchRowsId"> Row </label>
                                                    <select id="searchRowsId" class="custom-select">
                                                        <option value="40" <?php echo $rowS == 40 ? 'selected' : ''; ?>> 40 </option>
                                                        <option value="50" <?php echo $rowS == 50 ? 'selected' : ''; ?>> 50 </option>
                                                        <option value="100" <?php echo $rowS == 100 ? 'selected' : ''; ?>> 100 </option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ============ Table Start ============= -->
                            <div class="row mb-4">
                            <div class="col-md-12 mb-4">
                                <div class="card text-left">
                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <table class="display table table-striped table-bordered" id="orderby1" style="width:100%">
                                                <thead>
                                                    <tr>
                                            <th width="10%">วันที่</th>
                                            <th width="10%">Order ID</th>
                                            <th width="10%">ประเภทลูกค้า</th>
                                            <th width="10%">รับสินค้าโดย</th>
                                            <th width="10%">ชื่อลูกค้า</th>
                                            <th width="10%">เบอร์โทร</th>
                                            <th width="10%">อำเภอ</th>
                                            <th width="10%">จังหวัด</th>
                                            <th width="10%">ค่ามัดจำ</th>
                                            <th width="10%">ก่อนรวมภาษี</th>
                                            <th width="10%">ภาษี</th>
                                            <th width="10%">ยอดรวม</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody > <?php
                                                            if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
                                                                $page_no = $_GET['page_no'];
                                                            } else {
                                                                $page_no = 1;
                                                            }
                                                            // $total_records_per_page = 10;
                                                            $offset = ($page_no - 1) * $total_records_per_page;
                                                            $previous_page = $page_no - 1;
                                                            $next_page = $page_no + 1;
                                                            $adjacents = "2";

                                                            $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM `orders` where  status='0'  AND order_status='5'  ");
                                                            $total_records = mysqli_fetch_array($result_count);
                                                            $total_records = $total_records['total_records'];
                                                            $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                                            $second_last = $total_no_of_pages - 1; // total page minus 1

                                                            $result = mysqli_query($conn, "SELECT * FROM `orders` where status='0'  AND order_status='5'   order by date_create desc  ");
                                                            while ($row = mysqli_fetch_array($result)) { ?>
                                            <tr>

                                                <td>
                                                    <?php $date = explode(" ", $row['date_create']);
                                                                $dat = datethai2($date[0]);
                                                                echo $dat ?>
                                                </td>
                                                <td> <?= $row['order_id'] ?></td>
                                                <td><?php
                                                                $sql2 = "SELECT * FROM customer_type WHERE id= '$row[cus_type]'";
                                                                $rs2 = $conn->query($sql2);
                                                                $row2 = $rs2->fetch_assoc();
                                                                // ====
                                                                $sql3 = "SELECT * FROM customer WHERE customer_id= '$row[cus_id]'";
                                                                $rs3 = $conn->query($sql3);
                                                                $row3 = $rs3->fetch_assoc();

                                                                $sqlcb = "SELECT * FROM customer_back WHERE id= '$row[cus_back]'";
                                                                $rscb = $conn->query($sqlcb);
                                                                $rowcb = $rscb->fetch_assoc();

                                                    ?>
                                                    <?= $row2['name'] ?>
                                                </td>
                                                <td> <?= $rowcb['name'] ?></td>
                                                <td>  <?php echo iconv_substr($row3['customer_name'],0,30,'UTF-8'); ?> </td>
                                                <td> <?php echo substr($row3['tel'], 0, 12);  ?> </td>
                                                <td>
                                                    <?php
                                                                $sql2 = "SELECT * FROM amphures   WHERE id= '$row3[district]'";
                                                                $rs2 = $conn->query($sql2);
                                                                $row2 = $rs2->fetch_assoc();
                                                                echo $row2['name_th'];
                                                    ?>
                                                </td>
                                                <td> <?php
                                                                $sql2 = "SELECT * FROM provinces WHERE id= '$row3[province]'";
                                                                $rs2 = $conn->query($sql2);
                                                                $row2 = $rs2->fetch_assoc();
                                                                echo $row2['name_th'];
                                                        ?>
                                                </td>
                                                <td><span class="font-weight-bold"> <?php echo number_format($row['ai_count'], '2', '.', ',') ?></span>
                                                </td>
                                                <td>
                                                    <?php
                                                                $sqlx4 = "SELECT SUM(total_price) AS total FROM order_details  WHERE order_id= '$row[order_id]'";
                                                                $rsx4 = $conn->query($sqlx4);
                                                                $rowx4 = $rsx4->fetch_assoc();

                                                    ?>
                                                    <?php $sub_total = $rowx4['total'] - $row['discount'];
                                                          $sub_total_ai=$sub_total-$row['ai_count'];
                                                          $first_total = ($sub_total_ai * 100) / 107;
                                                          $tax = ($sub_total_ai - $first_total);
                                                          $grand_total = ($sub_total_ai - $tax);
                                                          $grand_total_all=($grand_total + $tax);
                                                    ?> <span class="font-weight-bold"> <?php echo number_format($grand_total, '2', '.', ',') ?> </span>
                                                </td>
                                                <td> <span class="font-weight-bold"> <?php echo number_format($tax, '2', '.', ',') ?></span> </td>
                                                <td>
                                                    <span class="font-weight-bold"> <?php echo number_format($grand_total_all, '2', '.', ',') ?> </span>
                                                </td>
                                                <td>
                                                    <?php
                                                                $sqlx5 = "SELECT COUNT(*)  AS sum  FROM delivery  WHERE order_id= '$row[order_id]'";
                                                                $rsx5 = $conn->query($sqlx5);
                                                                $rowx5 = $rsx5->fetch_assoc();
                                                                if ($rowx5['sum'] == 1) {
                                                    ?>
                                                        <a class="btn btn-outline-info btn-sm line-height-1" data-toggle="tooltip" title="ใบเสร็จรับเงิน" href="/hs.php?order_id=<?= $row['order_id'] ?>&so_id=<?= $row['dev_id'] ?>" target="_blank">
                                                            <i class="i-Full-View-Window font-weight-bold"></i>
                                                        </a>
                                                    <?php } else { ?>
                                                        <a class="btn btn-outline-info btn-sm line-height-1" data-toggle="tooltip" title="ใบเสร็จรับเงิน" href="/hs_all.php?order_id=<?= $row['order_id'] ?>" target="_blank">
                                                            <i class="i-Full-View-Window font-weight-bold"></i>
                                                        </a>
                                                    <?php } ?>
                                                    <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="คืนสินค้า" href="/refun.php?order_id=<?php echo $row['order_id']; ?>&so_id=<?php echo $row['dev_id']; ?>" target="_blank">
                                                        <i class="i-Repeat-2 font-weight-bold"></i>
                                                    </a>
                                                    <?php if($emp_id=='noom'||$emp_id=='admin'){ ?> 
                                                     <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ข้ข้อมูล Order" href="/editorder_final.php?order_id=<?= $row['order_id'] ?>">
                                                            <i class="i-Check font-weight-bold"></i>
                                                        </a>
                                                        <?php } ?>
                                                </td>
                                            </tr>
                                        <?php
                                                            }
                                                            mysqli_close($conn);
                                        ?>

</tbody>
                                               
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============ Table End ============= -->
                           
                            
                </div>
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
        <script src="../../dist-assets/js/plugins/datatables.min.js"></script>
                <script src="../../dist-assets/js/scripts/datatables.script.min.js"></script>
                <script src="../../dist-assets/js/plugins/datatables.min.js"></script>
                <script src="../../dist-assets/js/scripts/datatables.script.min.js"></script>
    </body>

</html>
<script>
    /* ===== search start ===== */
    function modalLoad() {
        $("#ModalLoadId").modal({
            backdrop: 'static',
            'keyboard': false,
        });
    };

    function clickNav(page) {
        modalLoad();

        $("#FSPageId").val(page);
        $("#FSButtonID").click();
    }
    $("#searchRowsId").on("change", function() {
        modalLoad();

        let row = $("#searchRowsId").val();
        $("#FSRowId").val(row);
        $("#FSButtonID").click();

    });
    $("#searchNameId").on("change", function() {
        modalLoad();

        let name = $("#searchNameId").val();
        $("#FSKeywordId").val(name);
        let column = $("#searchColumnId").val();
        $("#FSColumnId").val(column);
        $("#FSButtonID").click();

    });
    /* ===== search end ===== */

    //click next link
    $(".linkLoadModalNext").on('click', function() {
        $("#ModalLoadId").modal({
            backdrop: 'static',
            'keyboard': false,
        });
    });
</script>
<script>
    $('#myModal_del').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('#del_id').val(id)

    })
</script>
<script>
    $(function() {
        $('#orderModal').modal({
            keyboard: true,
            backdrop: "static",
            show: false,

        }).on('show', function() {
            var getIdFromRow = $(this).data('orderid');
            //make your ajax call populate items or what even you need
            $(this).find('#orderDetails').html($('<b> Order Id selected: ' + getIdFromRow + '</b>'))
        });

        $(".table-striped").find('tr[data-target]').on('click', function() {
            //or do your operations here instead of on show of modal to populate values to modal.
            $('#orderModal').data('orderid', $(this).data('id'));
        });

    });
</script>
<script>
$(document).ready(function() {
    $("#searchNameId").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>
<script>
    $('#orderby1').DataTable({
        "order": [
            [6, "asc"]
        ],
        "scrollX": true
    }); // multi column ordering
</script>