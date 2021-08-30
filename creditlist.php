<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config.php';
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
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
            font-size: 0.813rem !important;
        }
    </style>
</head>
<?php
if (empty($column) && ($keyword)) {
} else {
    // $column = "AND $column LIKE'$keyword%'";
    echo "$columx";
    if ($column == 'po_id') {
        $colum_po = "AND po_id LIKE'%$keyword%'";
    }
    if ($column == 'po_date') {
        $colum_po = "AND po_date LIKE'%$keyword%'";
    }

    //    echo"$column";
}

if (($column == "") && ($keyword == "")) {
    $columx = "";
    $keywordx = "";
}
if ($rowS == '') {
    $total_records_per_page = 40;
} else {
    $total_records_per_page = $rowS;
}
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
                                    <span>รายการ Order ที่อยู่ระหว่างการเสนอราคา
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
                                <a class="linkLoadModalNext nav-link active" href="/creditlist.php">
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
                                <a class="linkLoadModalNext nav-link" href="/ordersuccesslist.php">
                                    <h3 class="h5 font-weight-bold"> Order สำเร็จ</h3>
                                    <span>Order ที่ส่งสินค้าเรียบร้อย
                                        <span class="badge badge-success"> Pass </span>
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
                                        <h3 class="ul-widget1__title "> รายการวางบิล </h3>
                                        <span class="ul-widget__desc "> รายการวางบิลของลูกค้าเครดิต </span>
                                    </div>
                                    <div class="text-left">
                                        <div class="row">

                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="searchNameId"> Keyword</label>
                                                    <input id="myInput" class="form-control" placeholder="Keyword" type="text" value="">
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
                        </div>

                        <!-- ============ Table Start ============= -->
                        <div class="table-responsive">
                            <table role="table" class="table table-hover text-nowrap table-sm">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>รหัส BI</th>
                                        <th>วันที่วางบิล</th>
                                        <th>ชื่อลูกค้า</th>
                                        <th>เลขที่ใบกำกับ</th>
                                        <th>วันที่</th>
                                        <th>ครบกำหนด</th>
                                        <th>จำนวนเงิน</th>
                                        <th>ชำระแล้ว</th>
                                        <th>เงินคงค้าง</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                    <?php
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

                                    $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM `bi_number`  where status='0'  $colum_po  ");
                                    $total_records = mysqli_fetch_array($result_count);
                                    $total_records = $total_records['total_records'];
                                    $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                    $second_last = $total_no_of_pages - 1; // total page minus 1

                                    $result = mysqli_query($conn, "SELECT * FROM `bi_number`   where status='0'  $colum_po  GROUP BY bi_number  ORDER BY date_start  DESC LIMIT $offset, $total_records_per_page");
                                    while ($row = mysqli_fetch_array($result)) {
                                        $count = mysqli_query($conn, "SELECT COUNT(*) As total FROM bi_number  where bi_number= '$row[bi_number]' AND status='0'   ORDER BY id ASC ");
                                        $total = mysqli_fetch_array($count);
                                        $count = 0;
                                        $sqlxx = "SELECT *  FROM bi_number  where bi_number= '$row[bi_number]' AND status='0'   ORDER BY id ASC  ";
                                        $resultxx = mysqli_query($conn, $sqlxx);
                                        if (mysqli_num_rows($resultxx) > 0) {
                                            $num = @mysqli_num_rows($resultxx);
                                            $row_cnt = $resultxx->num_rows;
                                            // while ($row1 = mysqli_fetch_assoc($resultxx)) {
                                            while ($row2 = mysqli_fetch_array($resultxx)) { ?>
                                                <tr>
                                                    <td> <?php $x = $count++;
                                                            echo $x == 0 ? '<strong>' .  $row['bi_number'] . '</strong>' : ''; ?>


                                                    </td>
                                                    <td> <strong><?php if ($x == 0) {
                                                                        $date = explode(" ", $row['date_start']);
                                                                        $dat = datethai2($date[0]);
                                                                        $date_end = explode(" ", $row['date_end']);
                                                                        $dat_end = datethai2($date_end[0]);
                                                                        echo '<strong>' . $dat . ' -' . $dat_end . '</strong>';
                                                                    } ?></strong>
                                                    </td>
                                                    <td>
                                                        <strong> <?php
                                                                    $sql_cus = "SELECT * FROM customer   WHERE customer_id= '$row2[cus_id]'";
                                                                    $rs_cus = $conn->query($sql_cus);
                                                                    $row_cus = $rs_cus->fetch_assoc();
                                                                    echo "$row_cus[customer_name]";
                                                                    ?></strong>
                                                    </td>
                                                    <td>
                                                        <strong><?= $row2['iv_id'] ?> </strong>
                                                        <?php
                                                        $sql_dev = "SELECT * FROM delivery  WHERE iv_id= '$row2[iv_id]'";
                                                        $rs_dev = $conn->query($sql_dev);
                                                        $row_dev  = $rs_dev->fetch_assoc();
                                                        $sql_dev_detail = "SELECT  SUM(dev_qty*unit_price) AS total FROM deliver_detail  WHERE dev_id= '$row_dev[dev_id]'";
                                                        $rs_dev_detail = $conn->query($sql_dev_detail);
                                                        $row_dev_detail  = $rs_dev_detail->fetch_assoc();

                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $date = explode(" ", $row_dev['dev_date']);
                                                        $dat = datethai2($date[0]);
                                                        echo "$dat";
                                                        ?>
                                                    </td>
                                                    <td> <?php
                                                            $date = explode(" ", $row_dev['date_end']);
                                                            $dat = datethai2($date[0]);
                                                            echo "$dat";
                                                            ?>
                                                    </td>
                                                    <td><?php echo number_format($row_dev_detail['total'], '2', '.', ',') ?></td>
                                                    <td><?php echo number_format($row_dev['ai_count'], '2', '.', ',') ?>
                                                    </td>
                                                    <td>
                                                        <?php $sum_total = $row_dev_detail['total'] - $row_dev['ai_count'];
                                                        echo number_format($sum_total, '2', '.', ',') ?>
                                                    </td>
                                                    <td> <?php
                                                            if ($x == 0) {
                                                                if ($row['status_bi'] == 1) {  ?>
                                                                <span class="badge badge-warning p-1">รอวางบิล</span>
                                                            <?php } else { ?>
                                                                <span class="badge badge-success"> วางบิลสำเร็จ</span>
                                                        <?php }
                                                            } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($x == 0) { ?>
                                                            <a class="btn btn-outline-success btn-sm line-height-1" href="bi_view.php?bi_id=<?= $row['bi_number'] ?>" data-toggle="tooltip" title="ออกใบวางบิล">
                                                                <i class="fa fa-print font-weight-bold"></i>
                                                            </a>
                                                            <?php
                                                            if ($row['status_bi'] == 1) {
                                                            ?>
                                                                <a class="btn btn-outline-success btn-sm line-height-1" href="bi.php?bi_id=<?= $row['bi_number'] ?>" data-toggle="tooltip" title="บันทึกการชำระเงินใบวางบิล">
                                                                    <i class="fa fa-plus-square font-weight-bold"></i>
                                                                </a>
                                                            <?php  }
                                                            if ($row['status_bi'] == 2) {
                                                            ?>
                                                                <a class="btn btn-outline-success btn-sm line-height-1" href="re_view.php?re_id=<?= $row['re_id'] ?>" data-toggle="tooltip" title="ใบเสร็จชำระเงิน (RE)">
                                                                    <i class="i-Money-Bag font-weight-bold"></i>
                                                                </a>
                                                        <?php }
                                                        } ?>
                                                    </td>
                                                </tr> <?php
                                                    }
                                                }
                                            }
                                            mysqli_close($conn);
                                                        ?>





                                </tbody>
                            </table>
                        </div>
                        <!-- ============ Table End ============= -->
                        <!--                             <div class="mt-1">
                                <span class="text-danger mr-1">**</span>
                                <span class="text-muted"> มัดจำขั้นต่ำ 30% เมื่อทำการสั่งซื้อสินค้า</span>
                            </div>
                            <div class="">
                                <span class="text-danger mr-1">**</span>
                                <span class="text-muted">ชำระค่าสินค้าที่เหลือในวันจัดส่ง ก่อนลงสินค้า</span>
                            </div>
                            <div class="">
                                <span class="text-danger mr-1">**</span>
                                <span class="text-muted">ขอสงวนสิทธิ์ในการลงสินค้าต่อเที่ยว (ไม่เกิน 2 ชั่วโมง) หากเกินเวลาคิดเพิ่มชั่วโมงละ 500 บาท</span>
                            </div> -->
                        <div class="mb-5 mt-3">
                            <nav aria-label="Page navigation ">
                                <ul class="pagination justify-content-center">
                                    <?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } 
                                    ?>
                                    <li class="page-item" <?php if ($page_no <= 1) {
                                                                echo "class='disabled'";
                                                            } ?>>
                                        <a class="page-link" <?php if ($page_no > 1) {
                                                                    echo "href='?page_no=$previous_page' ";
                                                                } ?>>Previous</a>
                                    </li>

                                    <?php
                                    if ($total_no_of_pages <= 10) {
                                        for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                                            if ($counter == $page_no) { ?>
                                                <li class='page-item active'><a class="page-link"><?php echo "$counter"; ?></a></li>
                                            <?php  } else { ?>
                                                <li><a class="page-link" href='?page_no=<?php echo "$counter"; ?>'><?php echo "$counter"; ?></a></li>
                                                <?php   }
                                        }
                                    } elseif ($total_no_of_pages > 10) {
                                        if ($page_no <= 4) {
                                            for ($counter = 1; $counter < 8; $counter++) {
                                                if ($counter == $page_no) {
                                                    echo "<li class='page-item  active'><a>$counter</a></li>";
                                                } else { ?>
                                                    <li><a class="page-link" href='?page_no=<?php echo "$counter"; ?>'><?php echo "$counter"; ?></a></li>
                                            <?php  }
                                            }
                                            ?>
                                            <li class="page-item"><a>...</a></li>
                                            <li class="page-item"><a class="page-link" href='?page_no=<?php echo "$second_last"; ?>'><?php echo "$second_last"; ?></a></li>
                                            <li class="page-item"><a class="page-link" href='?page_no=<?php echo "$total_no_of_pages"; ?>'><?php echo "$total_no_of_pages"; ?></a></li>
                                        <?php  } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) { ?>
                                            <li class="page-item"><a class="page-link" href='?page_no=1'>1</a></li>
                                            <li class="page-item"><a class="page-link" href='?page_no=2'>2</a></li>
                                            <li class="page-item"><a>...</a></li>
                                            <?php for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                                                if ($counter == $page_no) { ?>
                                                    <li class='active'><a><?php echo "$counter"; ?></a></li>
                                                <?php  } else { ?>
                                                    <li><a class="page-link" href='?page_no=<?php echo "$counter"; ?>'><?php echo "$counter"; ?></a></li>
                                            <?php    }
                                            } ?>
                                            <li><a class="page-link">...</a></li>
                                            <li><a class="page-link" href='?page_no=<?php echo "$second_last"; ?>'><? echo "$second_last"; ?></a></li>
                                            <li><a class="page-link" href='?page_no=<?php echo "$total_no_of_pages"; ?>'><? echo "$total_no_of_pages"; ?></a></li>";
                                        <?php  } else { ?>
                                            <li><a class="page-link" href='?page_no=1'>1</a></li>
                                            <li><a class="page-link" href='?page_no=2'>2</a></li>
                                            <li><a class="page-link">...</a></li>

                                            <?php for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                                if ($counter == $page_no) { ?>
                                                    <li class='active'><a class="page-link"><?php echo "$counter"; ?></a></li>
                                                <?php  } else {
                                                ?> <li><a class="page-link" href='?page_no=$counter'><?php echo "$counter"; ?></a></li>
                                    <?php   }
                                            }
                                        }
                                    }
                                    ?>

                                    <li <?php if ($page_no >= $total_no_of_pages) {
                                            echo "class='disabled'";
                                        } ?>>
                                        <a class="page-link" <?php if ($page_no < $total_no_of_pages) {
                                                                    echo "href='?page_no=$next_page'";
                                                                } ?>>Next</a>
                                    </li>

                                    <?php if ($page_no < $total_no_of_pages) { ?>
                                        <li><a class="page-link" href='?page_no=<?php echo "$total_no_of_pages"; ?>'>Last &rsaquo;&rsaquo;</a></li>
                                    <?php   } ?>
                                </ul>
                            </nav>
                        </div>
                     
                        </div>
                </div>
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
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>