<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
$emp_id=$_SESSION["username"]; 
include './include/connect.php';
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Stocks | รายการสินค้าคงคลัง</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../dist-assets/css/plugins/datatables.min.css" />
</head>
<style>
    .table-sm th,
    .table-sm td {
        padding: 0.3rem;
        font-size: 0.813rem !important;
    }
</style>
<?php 
$action = $_REQUEST['action'];
if ($action == 'del') {
    $del_id = $_REQUEST['del_id'];

    $sql = "DELETE FROM product  WHERE product_id='$del_id' ";
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


if ($action =='editx') {
//   echo"xx";
    $edit_id= $_REQUEST['edit_id'];   
    $fac1_stock= $_REQUEST['fac1_stock'];  
    $fac2_stock= $_REQUEST['fac2_stock'];  
    // echo $edit_id;
// echo"$delivery_date";
    $sqlxxx = "UPDATE product  SET fac1_stock='$fac1_stock',fac2_stock='$fac2_stock' where id='$edit_id'";
    if ($conn->query($sqlxxx) === TRUE) { ?>
<script>
$(document).ready(function() {
    showAlert("อับเดตสต็อกเรียบร้อย", "alert-primary");
});
</script>
<?php }  
 }
?>
<body class="text-left">
    <div class="app-admin-wrap layout-horizontal-bar">
        <?php include './include/config.php'; ?>
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

                        <div class="tab-content">
                            <div class="mb-1">
                                <div class="ul-widget__item">
                                    <div class="ul-widget__info">
                                        <h3 class="ul-widget1__title "> สต๊อกสินค้า </h3>
                                        <span class="ul-widget__desc "> รายการสต๊อกสินค้า </span>
                                        <button type="button" class="btn btn btn-success mb-2 mr-2" data-toggle="modal" data-target="#Modal-add1"><i class="fa fa-plus"></i>
                                            import Excel
                                        </button>
                                        <a class="btn btn btn-success mb-2 mr-2" href="/inventorylist_hfix.php"> รายงานแบบที่2</a>
                                        <a class="btn btn btn-success mb-2 mr-2" href="/inventorylist4.php"> รายงานแบบที่3</a>
                                        <a class="btn btn btn-success mb-2 mr-2" href="/stock_import.php"> สินค้านำเข้าจำหน่าย</a>
                                    </div>
                                    <div class="text-left">

                                        <div class="col-auto">
                                            <a href="/product.php" class="btn btn-outline-primary mt-4" role="button" aria-pressed="true"> เพิ่มสินค้าใหม่</a>

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
                                                        <th>รหัสสินค้า</th>
                                                        <th>ประเภทสินค้า</th>
                                                        <th>ชื่อสินค้า</th>
                                                        <th>stock1</th>
                                                        <th>stock2</th>
                                                        <th>จอง</th>
                                                        <th>ผลิต</th>
                                                        <th>ขาย</th>
                                                        <th>เหลือ</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="myTable">
                                                    <?php

                                                    $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM product  where  status='0' AND  ptype_id<>'TF0'  order by product_id asc ");
                                                    $total_records = mysqli_fetch_array($result_count);
                                                    $total_records = $total_records['total_records'];
                                                    $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                                    $second_last = $total_no_of_pages - 1; // total page minus 1
                                                    $result = mysqli_query($conn, "SELECT * FROM product where  ptype_id <> 'TF0' AND  status='0'   order by product_id asc  ");
                                                    while ($row = mysqli_fetch_array($result)) { ?>
                                                        <tr>
                                                            <td><?php echo $row["product_id"]; ?></td>
                                                            <td><?php
                                                                $sql3 = "SELECT * FROM product_type WHERE ptype_id= '$row[ptype_id]'";
                                                                $rs3 = $conn->query($sql3);
                                                                $row3 = $rs3->fetch_assoc();
                                                                echo $row3['ptype_name'];  ?> </td>
                                                            <td> <?php echo $row["product_name"]; ?></td>


                                                            <td> <?php echo $row["fac1_stock"]; ?> </td>
                                                            <td>
                                                                <?php echo $row["fac2_stock"]; ?> </td>
                                                            <td>
                                                                <?php
                                                                $sql_pro = "SELECT sum(order_details.qty_out) AS qty_out FROM order_details INNER JOIN orders ON order_details.product_id= '$row[product_id]' AND order_details.order_id=orders.order_id AND orders.is_ai='Y' ";
                                                                $rs_pro = $conn->query($sql_pro);
                                                                $row_pro = $rs_pro->fetch_assoc();
                                                                $sum_stock = $row["fac1_stock"] + $row["fac2_stock"];
                                                                if ($sum_stock < $row_pro['qty_out']) {  ?>
                                                                    <span class="badge badge-square-danger m-1"> <?php echo "$row_pro[qty_out]"; ?></span>
                                                                <?php    } else { ?>
                                                                    <span class="badge badge-square-success m-1"> <?php echo "$row_pro[qty_out]"; ?></span>
                                                                <?php   }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($row3['stock_m'] == 1) {
                                                                    $sql_po = "SELECT sum(qty) AS a_type  FROM production_import   where  product_id='$row[product_id]' ";
                                                                    $rs_po = $conn->query($sql_po);
                                                                    $row_po = $rs_po->fetch_assoc();
                                                                    echo "$row_po[a_type]";
                                                                } else {


                                                                    $sql_po = "SELECT sum(a_type) AS a_type  FROM production_detail   where status_stock='1' AND product_id='$row[product_id]' ";
                                                                    $rs_po = $conn->query($sql_po);
                                                                    $row_po = $rs_po->fetch_assoc();
                                                                    echo "$row_po[a_type]";
                                                                } ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $sql_dev = "SELECT sum(dev_qty) AS dev_qty  FROM deliver_detail  where  product_id='$row[product_id]' ";
                                                                $rs_dev = $conn->query($sql_dev);
                                                                $row_dev = $rs_dev->fetch_assoc();
                                                                echo "$row_dev[dev_qty]";
                                                                ?>

                                                            </td>
                                                            <td><?php $sum_stock = $row_po['a_type'] - $row_dev['dev_qty'];
                                                                echo "$sum_stock";
                                                                ?></td>
                                                            <td>
                                                                <button data-toggle="modal" data-target="#Modal-add1" data-id="<?php echo $row['id']; ?>" id="edit" class="btn btn-outline-success btn-sm line-height-1"> <i class="i-Pen-2 font-weight-bold"></i> </button>

                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }

                                                    ?>


                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>รหัสสินค้า</th>
                                                        <th>ประเภทสินค้า</th>
                                                        <th>ชื่อสินค้า</th>
                                                        <th>stock1</th>
                                                        <th>stock2</th>
                                                        <th>จอง</th>
                                                        <th>ผลิต</th>
                                                        <th>ขาย</th>
                                                        <th>เหลือ</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============ Table End ============= -->



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
                </div>
                <div id="Modal-add1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fa fa-pencil"></i>อับเดตสต็อกสินค้า
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">

                              
                                    <div class="box-content">
                                        <div class="form-row">
                                            <div class="modal-body">

                                                <!-- mysql data will be load here -->
                                                <div id="dynamic-content"></div>
                                            </div>
                                        </div>
                               
                            </div>
                        </div>
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
                <script src="../../dist-assets/js/scripts/tooltip.script.min.js"></script>
                <script src="../../dist-assets/js/plugins/datatables.min.js"></script>
                <script src="../../dist-assets/js/scripts/datatables.script.min.js"></script>
                <script src="../../dist-assets/js/plugins/datatables.min.js"></script>
                <script src="../../dist-assets/js/scripts/datatables.script.min.js"></script>


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
<script>
    $(document).ready(function() {
        $(document).on('click', '#edit', function(e) {
            e.preventDefault();
            var uid = $(this).data('id'); // get id of clicked row
            $('#dynamic-content').html(''); // leave this div blank
            $('#modal-loader').show(); // load ajax loader on button click
            $.ajax({
                    url: 'stock_update.php',
                    type: 'POST',
                    data: 'id=' + uid,
                    dataType: 'html'
                })
                .done(function(data) {
                    console.log(data);
                    $('#dynamic-content').html(''); // blank before load.
                    $('#dynamic-content').html(data); // load here
                    $('#modal-loader').hide(); // hide loader  
                })
                .fail(function() {
                    $('#dynamic-content').html(
                        '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                    );
                    $('#modal-loader').hide();
                });
        });
    });
</script>