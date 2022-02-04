<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';

error_reporting(0);
$emp_id = $_SESSION["username"];
$action = $_REQUEST['action'];
if ($action == 'del') {
    $del_id = $_REQUEST['del_id'];
    $sql = "SELECT * FROM tools WHERE id= '$del_id'";
    $rs = $conn->query($sql);
    $row = $rs->fetch_assoc();



    $sql = "DELETE FROM tools WHERE id='$del_id' ";
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

if ($action == 'add') {
    $name = $_REQUEST['name'];
    $comment = $_REQUEST['comment'];
    $date_import = $_REQUEST['date_import'];
    $qty = $_REQUEST['qty'];
    $unit = $_REQUEST['unit'];

    $sqlx = "INSERT INTO tools(name,qty,date_import,emp_id,unit,comment,status) 
VALUES ('$name','$qty','$date_import','$emp_id','$unit','$comment','0')";


    if ($conn->query($sqlx) === TRUE) {

    ?> <script>
            $(document).ready(function() {
                showAlert("บันทึกข้อมูลสต็อกสำเร็จ", "alert-success");
            });
        </script>
    <?php
    }
    $action = '0';
    $qty = '0';
}

if ($action == 'edit') {
    $edit_id = $_REQUEST['edit_id'];
    $name = $_REQUEST['name'];
    $comment = $_REQUEST['comment'];
    $date_import = $_REQUEST['date_import'];
    $qty = $_REQUEST['qty'];
    $unit = $_REQUEST['unit'];

    $sqlxxx = "UPDATE tools  SET name='$name',comment='$comment',date_import='$date_import',qty='$qty',unit='$unit' where id='$edit_id'";
    if ($conn->query($sqlxxx) === TRUE) { ?>
        <script>
            $(document).ready(function() {
                showAlert("แก้ไขข้อมูลสำเร็จ", "alert-primary");
            });
        </script>
    <?php }
}
if ($action == 'edit_bin') {
    $edit_id = $_REQUEST['edit_id'];
    $name = $_REQUEST['name'];
    $comment = $_REQUEST['comment'];
    $date_out = $_REQUEST['date_import'];
    $qty_out = $_REQUEST['qty_out'];
    $unit = $_REQUEST['unit'];

    $sql = "SELECT * FROM tools WHERE id= '$edit_id'";
    $rs = $conn->query($sql);
    $row = $rs->fetch_assoc();

    $sum_qty = $row['qty'] - $qty_out;
    $sum_qtyout=$row['qty_out']+$qty_out;
    $sqlx = "INSERT INTO tools_out(name,tools_id,emp_id,unit,comment,qty_out,date_out) 
    VALUES ('$name','$edit_id','$emp_id','$unit','$comment','$qty_out','$date_out')";
    if ($conn->query($sqlx) === TRUE) {
    }

    $sqlxxx = "UPDATE tools  SET qty='$sum_qty',qty_out='$sum_qtyout' where id='$edit_id'";
    if ($conn->query($sqlxxx) === TRUE) { ?>
        <script>
            $(document).ready(function() {
                showAlert("บันทึกสินค้าชำรุดสำเร็จ", "alert-primary");
            });
        </script>
<?php }
}
?>
<!DOCTYPE html>
<html lang="en" dir="">



<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>รายการเครื่องมือช่าง</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css?v=11" rel="stylesheet" />
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

<script>
    function reP() {
        window.location.href = 'tools.php';
    }
</script>

<body class="text-left">
    <div class="app-admin-wrap layout-horizontal-bar">
        <!-- Header -->
        <?php include './include/header.php'; 
        include './include/config.php';
        ?>
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
                                        <h3 class="ul-widget1__title ">เครื่องมือช่าง </h3>

                                    </div>
                                    <div class="pull-right">
                                        <div class="pull-right">
                                            <button type="button" onclick="reP()" class="btn btn btn-success mb-2 mr-2">
                                                <i class="text-20 i-Restore-Window"></i></button>
                                            <button type="button" class="btn btn btn-success mb-2 mr-2" data-toggle="modal" data-target="#Modal-add1"><i class="fa fa-plus"></i>
                                                เพิ่มครื่องมือ
                                            </button>
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
                                                            <th>วันที่</th>
                                                            <th>ชื่อเครื่องมือ</th>
                                                            <th>จำนวน</th>
                                                            <th>นำออก</th>

                                                            <th>รายละเอียด</th>
                                                            <th>ผู้รับเข้า</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                        <?php


                                                        $result = mysqli_query($conn, "SELECT * FROM tools  where    status='0'   order by date_import  ASC  ");
                                                        while ($row = mysqli_fetch_array($result)) { ?>
                                                            <tr>
                                                                <td> <?php 
                                                                       
                                                                        echo $row['date_import'] ?></td>
                                                                <td><?php echo $row["name"]; ?></td>
                                                                <td> <?php
                                                                        $sql3 = "SELECT * FROM unit_tools  WHERE id= '$row[unit]'";
                                                                        $rs3 = $conn->query($sql3);
                                                                        $row3 = $rs3->fetch_assoc();

                                                                        echo $row["qty"] . ':' . $row3['name']; ?></td>
                                                                <td>
                                                                <a data-toggle="modal" data-target="#view-modal4" data-id="<?php echo $row['id']; ?>" id="edit4" class="btn  btn-sm line-height-1">
                                                                    <?php if ($row["qty_out"] > 0) {
                                                                        echo $row["qty_out"] . ':' . $row3['name'];
                                                                    } ?> </a></td>

                                                                <td> <?php echo $row["comment"]; ?> </td>

                                                                <td> <?php echo $row["emp_id"]; ?> </td>

                                                                <td>
                                                                    <button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $row['id']; ?>" id="edit" class="btn btn-outline-success btn-sm line-height-1"> <i class="i-Pen-2 font-weight-bold"></i> </button>
                                                                    <button data-toggle="modal" data-target="#Modal-move" data-id="<?php echo $row['id']; ?>" id="edit_bin" class="btn btn-outline-success btn-sm line-height-1"> <i class="i-Gear font-weight-bold" title="เครื่องมือชำรุด"></i> </button>
                                                                    <button type="button" class="btn btn-outline-info btn-sm line-height-1" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#myModal_del"> <i class="i-Close-Window font-weight-bold"></i> </button>

                                                                </td>
                                                            </tr>
                                                        <?php
                                                        }

                                                        ?>
                                                    <tfoot>
                                                        <tr>
                                                            <th>วันที่</th>
                                                            <th>ชื่อเครื่องมือ</th>
                                                            <th>จำนวน</th>
                                                            <th>นำออก</th>

                                                            <th>รายละเอียด</th>
                                                            <th>ผู้รับเข้า</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- ============ Table End ============= -->

                                    </div>
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
                            <!-- Modal ADD -->


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
                            <script src="../../dist-assets/js/scripts/datatables.script.min.js"></script>
                            <script src="../../dist-assets/js/script_ptype_m.js"></script>
</body>

<!-- Modal DEL  -->
<div class="modal fade" id="myModal_del" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
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
                        <div class="form-group col-md-12">
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
<div id="view-modal4" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fa fa-pencil"></i>
                                    แสดงรายการจำหน่ายออก</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <!-- mysql data will be load here -->
                                <div id="dynamic-content4"></div>
                            </div>

                        </div>
                    </div>
                </div>
<div id="Modal-move" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fa fa-pencil"></i>เครื่องมือชำรุด จำหน่ายออก
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">


                <div class="box-content">
                    <div class="form-row">
                        <div class="modal-body">

                            <!-- mysql data will be load here -->
                            <div id="dynamic-content7"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal edit -->
<div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fa fa-pencil"></i> แก้ไขข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">


                    <div id="dynamic-content"></div>




                </form>
            </div>
        </div>
    </div>
</div>
<div id="Modal-add1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fa fa-pencil"></i>เพิ่มเครื่องมือช่าง
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">

                <form class="form-horizontal well" action="" method="post" name="upload_excel" enctype="multipart/form-data">
                    <div class="box-content">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="accNameId"><strong>ชื่อเครื่องมือช่าง<span class="text-danger"></span></strong></label>
                                <input type="text" name="name" value="" class="form-control" require>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="accNameId"><strong>รายละเอียด<span class="text-danger"></span></strong></label>
                                <input type="text" name="comment" value="" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <?php $datex = date('Y-m-d'); ?>
                                <label for="accNameId"><strong>วันที่รับเข้า<span class="text-danger"></span></strong></label>
                                <input id="date_import" name="date_import" value="<?php echo "$datex"; ?>" class="form-control" type="date" min="2021-06-01" require>
                            </div>
                            <div class="form-group col-md-3">
                                <?php $datex = date('Y-m-d'); ?>
                                <label for="accNameId"><strong>จำนวน<span class="text-danger"></span></strong></label>
                                <input id="qty" name="qty" value="<?php echo "$qty"; ?>" class="form-control" type="text" require>
                            </div>
                            <div class="form-group col-md-3">

                                <label for="accNameId"><strong>จำนวน<span class="text-danger"></span></strong></label>
                                <select name="unit" id="unit" class="classcus custom-select " required>
                                    <option value="">หน่วยนับ</option>
                                    <?php
                                    $sql6 = "SELECT *  FROM unit_tools     order by name ASC ";
                                    $result6 = mysqli_query($conn, $sql6);
                                    if (mysqli_num_rows($result6) > 0) {
                                        while ($row6 = mysqli_fetch_assoc($result6)) {
                                    ?>
                                            <option value="<?= $row6['id'] ?>" <?php if (isset($row['unit']) && ($row['unit'] == $row6['id'])) {
                                                                                    echo "selected"; ?>>
                                                <?= $row6['name'] ?>
                                            <?php  } else {      ?>
                                            <option value="<?= $row6['id'] ?>"> <?= $row6['name'] ?>
                                            <?php } ?>
                                            </option>
                                    <?php  }
                                    }  ?>

                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">เพิ่มสต็อก</button>

                            <input type="hidden" name="action" value="add">
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
    $(document).ready(function() {
        $(document).on('click', '#edit', function(e) {
            e.preventDefault();
            var uid = $(this).data('id'); // get id of clicked row
            $('#dynamic-content').html(''); // leave this div blank
            $('#modal-loader').show(); // load ajax loader on button click
            $.ajax({
                    url: 'tools_edit.php',
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
<script>
    $(document).ready(function() {
        $(document).on('click', '#edit_bin', function(e) {
            e.preventDefault();
            var uid = $(this).data('id'); // get id of clicked row
            $('#dynamic-content7').html(''); // leave this div blank
            $('#modal-loader').show(); // load ajax loader on button click
            $.ajax({
                    url: 'tools_bin.php',
                    type: 'POST',
                    data: 'id=' + uid,
                    dataType: 'html'
                })
                .done(function(data) {
                    console.log(data);
                    $('#dynamic-content7').html(''); // blank before load.
                    $('#dynamic-content7').html(data); // load here
                    $('#modal-loader').hide(); // hide loader  
                })
                .fail(function() {
                    $('#dynamic-content7').html(
                        '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                    );
                    $('#modal-loader').hide();
                });
        });
    });
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
<script>
    $('#orderby1').DataTable({
        "order": [
            [0, "desc"]
        ],

    }); // multi column ordering
</script>
<script>
    $(document).ready(function() {
        $(document).on('click', '#edit4', function(e) {
            e.preventDefault();
            var uid = $(this).data('id'); // get id of clicked row
            $('#dynamic-content4').html(''); // leave this div blank
            $('#modal-loader4').show(); // load ajax loader on button click
            $.ajax({
                    url: 'tools_show.php',
                    type: 'POST',
                    data: 'id=' + uid,
                    dataType: 'html'
                })
                .done(function(data) {
                    console.log(data);
                    $('#dynamic-content4').html(''); // blank before load.
                    $('#dynamic-content4').html(data); // load here
                    $('#modal-loader4').hide(); // hide loader  
                })
                .fail(function() {
                    $('#dynamic-content4').html(
                        '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...'
                    );
                    $('#modal-loader4').hide();
                });
        });
    });
</script>
</html>