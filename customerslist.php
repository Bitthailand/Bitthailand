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
    <title>รายการลูกค้า</title>
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
<style>
    .table-sm th,
    .table-sm td {
        padding: 0.3rem;
        font-size: 0.813rem !important;
    }
</style>

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
        error_reporting(0);
        $action = $_REQUEST['action'];
        if ($action == 'del') {
            $del_id = $_REQUEST['del_id'];

            // $sql = "DELETE FROM customer  WHERE customer_id='$del_id' ";
            $sql = "UPDATE customer    SET status='1'  where customer_id='$del_id' ";

            if ($conn->query($sql) === TRUE) { ?>
                <script>
                    $(document).ready(function() {
                        showAlert("ลบรายการสำเร็จ", "alert-primary");
                    });
                </script>
            <?php  } else { ?>
                <script>
                    $(document).ready(function() {
                        showAlert("ไม่สามารถลบรายการได้", "alert-danger");
                    });
                </script>
        <?php }
        }
        ?>

        <!-- =============== Horizontal bar End ================-->
        <div class="main-content-wrap d-flex flex-column">
            <!-- ============ Body content start ============= -->
            <!-- แจ้งเตือน -->
            <div id="alert_placeholder" style="z-index: 9999999; left:1px; top:1%; width:100%; position:absolute;"></div>
            <!-- ปิดการแจ้งเตือน -->
            <div class="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="tab-content">
                            <div class="mb-1">
                                <div class="ul-widget__item">
                                    <div class="ul-widget__info">
                                        <h3 class="ul-widget1__title "> ลูกค้า </h3>
                                        <span class="ul-widget__desc "> รายการลูกค้า </span>
                                    </div>
                                    <div class="text-left">
                                        <div class="row">


                                            <div class="col-auto">
                                                <a href="/customer.php?status_confirm=add" class="btn btn-outline-primary mt-4" role="button" aria-pressed="true"> เพิ่มลูกค้าใหม่</a>
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
                                            <th width="10%" >cusID</th>
                                            <th width="4%">ประเภท</th>
                                            <th width="10%">ชื่อลูกค้า</th>
                                            <th width="10%">ที่อยู่</th>
                                            <th width="5%">ตำบล</th>
                                            <th width="10%">อำเภอ</th>
                                            <th width="10%">จังหวัด</th>
                                            <th width="10%">เบอร์โทร</th>
                                            <th  width="6%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>


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

                                        $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM `customer` where  status='0'   ");
                                        $total_records = mysqli_fetch_array($result_count);
                                        $total_records = $total_records['total_records'];
                                        $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                        $second_last = $total_no_of_pages - 1; // total page minus 1

                                        $result = mysqli_query($conn, "SELECT * FROM `customer` where status='0'  ORDER BY date_create DESC ");
                                        while ($row = mysqli_fetch_array($result)) { ?>
                                            <tr>
                                                <td><?php echo $row['customer_id']; ?></td>
                                                <td><?php
                                                    $sql2 = "SELECT * FROM customer_type   WHERE id= '$row[customer_type]'";
                                                    $rs2 = $conn->query($sql2);
                                                    $row2 = $rs2->fetch_assoc();
                                                    echo $row2['name'];

                                                    ?>
                                                </td>

                                                <td> <?php echo iconv_substr($row['customer_name'], 0, 30, 'UTF-8'); ?> </td>
                                                <td> <?php echo iconv_substr($row['bill_address'], 0, 30, 'UTF-8'); ?> </td>

                                                <td><?php
                                                    $sql3 = "SELECT * FROM districts  WHERE id= '$row[subdistrict]'";
                                                    $rs3 = $conn->query($sql3);
                                                    $row3 = $rs3->fetch_assoc();
                                                    echo $row3['name_th'];

                                                    ?>
                                                </td>
                                                <td><?php
                                                    $sql4 = "SELECT * FROM amphures  WHERE id= '$row[district]'";
                                                    $rs4 = $conn->query($sql4);
                                                    $row4 = $rs4->fetch_assoc();
                                                    echo $row4['name_th'];

                                                    ?>
                                                <td><?php
                                                    $sql5 = "SELECT * FROM provinces  WHERE id= '$row[province]'";
                                                    $rs5 = $conn->query($sql5);
                                                    $row5 = $rs5->fetch_assoc();
                                                    echo $row5['name_th'];

                                                    ?>
                                                </td>
                                                <td> <?php echo substr($row['tel'], 0, 12);  ?> </td>


                                                <td>

                                                    <a class="btn btn-outline-success btn-sm line-height-1" href="/customer_update.php?customer_id=<?php echo $row['customer_id']; ?>">
                                                        <i class="i-Pen-2 font-weight-bold"></i>
                                                    </a>

                                                    <button type="button" class="btn btn-outline-info btn-sm line-height-1" data-id="<?php echo $row['customer_id']; ?>" data-toggle="modal" data-target="#myModal_del"> <i class="i-Close-Window font-weight-bold"></i> </button>
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
                            </div>
                            <!-- ============ Table End ============= -->


                            <!-- Footer Start -->
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
                    <script src="../../dist-assets/js/scripts/tooltip.script.min.js"></script>
                    <script src="../../dist-assets/js/plugins/datatables.min.js"></script>
                    <script src="../../dist-assets/js/scripts/datatables.script.min.js"></script>
                    <script src="../../dist-assets/js/scripts/customizer.script.min.js"></script>
</body>

<!-- Modal DEL  -->
<div class="modal fade" id="myModal_del" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fa fa-pencil"></i> DELETE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputEmail4"><strong>คุณต้องการลบข้อมูลใช่หรือไม่
                                    <span>*</span></strong></label>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="action" value="del">
                        <input type="hidden" name="del_id" id="del_id" value="">
                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span>
                            DELETE</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============ Form Search Start ============= -->
<form class="d-none" method="POST">
    <input type="text" id="FSColumnId" name="column" value="<?php echo $S_COLUMN; ?>" placeholder="">
    <input type="text" id="FSKeywordId" name="keyword" value="<?php echo $S_KEYWORD; ?>" placeholder="">
    <input type="text" id="FSRowId" name="row" value="<?php echo $S_ROW; ?>" placeholder="">
    <input type="number" id="FSPageId" name="page" value="<?php echo $S_PAGE; ?>" placeholder="">
    <button class="btn" id="FSButtonID" type="submit"></button>
</form>
<!-- ============ Form Search End ============= -->

<!-- ============ Modal Start ============= -->
<!-- modal load -->
<div class="modal fade" id="ModalLoadId" tabindex="-1" role="dialog" aria-labelledby="modalLoadTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center">
                    <div class="spinner-bubble spinner-bubble-primary m-5"></div>
                    <div class="mt-1">
                        Load ...
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- ============ Modal End ============= -->
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
        let column = $("#searchColumnId").val();
        $("#FSColumnId").val(column);
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

</html>

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

    }); // multi column ordering
</script>