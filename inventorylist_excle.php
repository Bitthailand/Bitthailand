<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
error_reporting(0);
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
?>
<?php $keyword = $_POST['keyword'];
$column = $_REQUEST['column'];
// echo"$column";
$rowS = $_REQUEST['row'];
if (empty($column) && ($keyword)) {
} else {

    if ($column == "ptype_id") {
        $sql = "SELECT * FROM product_type WHERE ptype_name LIKE'$keyword%'";
        $rs = $conn->query($sql);
        $rowx = $rs->fetch_assoc();
        $columx = "AND ptype_id ='$rowx[ptype_id]'";
    }
    if ($column == "units") {
        $sql = "SELECT * FROM unit  WHERE unit_name LIKE'$keyword%'";
        $rs = $conn->query($sql);
        $rowx = $rs->fetch_assoc();
        $columx = "AND units ='$rowx[id]'";
    }
    if ($column == "product_id") {
        $columx = "AND $column LIKE'$keyword%'";
    }
    if ($column == "product_name") {
        $columx = "AND $column LIKE'$keyword%'";
    }
    // echo"$columx";   
}


if (($column == "") && ($keyword == "$keyword")) {

    $keywordx = "AND product_id LIKE'$keyword%'
                 OR product_name LIKE'$keyword%' ";
    //    echo"$keywordx";
}
if ($rowS == '') {
    $total_records_per_page = 40;
} else {
    $total_records_per_page = $rowS;
}
?>
<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Stocks | รายการสินค้าคงคลัง</title>
  
</head>
<?php
$datetodat = date('Y-m-d');
$strExcelFileName = "$datetodat.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");
?>
<style>
    .table-sm th,
    .table-sm td {
        padding: 0.3rem;
        font-size: 0.813rem !important;
    }
</style>

<body class="text-left">
    <div class="app-admin-wrap layout-horizontal-bar">
        <?php include './include/config.php'; ?>
        <!-- Header -->

            <div class="main-content">

               
                            <!-- ============ Table Start ============= -->
                            <strong>รายงานสินค้า วันที่ <?php echo date("d/m/Y"); ?> ทั้งหมด <?php echo number_format($num); ?> </strong><br>
                            <br>
                            <div id="SiXhEaD_Excel" align=center x:publishsource="Excel">
                                    <div class="table-responsive">
                                        <table class="table table-hover text-nowrap table-sm">
                                            <thead>
                                                <tr>
                                                    <th>รหัสสินค้า</th>
                                                    <th>ประเภทสินค้า</th>
                                                    <th>ชื่อสินค้า</th>
                                                    <th>หนา</th>
                                                    <th>กว้าง</th>
                                                    <th>ยาว</th>
                                                    <th>พื้นที่หน้าตัด</th>
                                                    <th>ขนาดลวด</th>
                                                    <th>จำนวนเส้นลวด</th>
                                                    <th>ราคาต่อหน่วย</th>
                                                    <th>ข้อมูลเพิ่มเติม</th>
                                                    <th>สต๊อกโรงงาน 1</th>
                                                    <th>สต๊อกโรงงาน 2</th>
                                                    <th>หน่วยนับ</th>
                                                    <th>น้ำหนัก</th>
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
                                                // echo"$total_records_per_page";
                                                // $total_records_per_page = 10;
                                                $offset = ($page_no - 1) * $total_records_per_page;
                                                $previous_page = $page_no - 1;
                                                $next_page = $page_no + 1;
                                                $adjacents = "2";

                                                $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM `product` where  status='0'   ");
                                                $total_records = mysqli_fetch_array($result_count);
                                                $total_records = $total_records['total_records'];
                                                $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                                $second_last = $total_no_of_pages - 1; // total page minus 1
                                                $result = mysqli_query($conn, "SELECT * FROM `product` where status='0' ");
                                                while ($row = mysqli_fetch_array($result)) { ?>
                                                    <tr>
                                                        <td ><?php echo $row["product_id"]; ?></td>
                                                        <td><?php
                                                            $sql3 = "SELECT * FROM product_type WHERE ptype_id= '$row[ptype_id]'";
                                                            $rs3 = $conn->query($sql3);
                                                            $row3 = $rs3->fetch_assoc();
                                                            echo $row3['ptype_name'];

                                                            ?> </td>
                                                        <td> <?php echo $row["product_name"]; ?></td>
                                                        <td> <?php echo $row["thickness"]; ?> </td>
                                                        <td> <?php echo $row["width"]; ?> </td>
                                                        <td> <?php echo $row["size"]; ?> </td>
                                                        <td> <?php echo $row["area"]; ?></td>
                                                        <td><?php echo $row["dia_size"]; ?></td>
                                                        <td> <?php echo $row["dia_count"]; ?> </td>
                                                        <td> <?php echo $row["unit_price"]; ?> </td>
                                                        <td><?php echo $row["spacial"]; ?> </td>
                                                        <td> <?php echo $row["fac1_stock"]; ?> </td>
                                                        <td>
                                                            <?php echo $row["fac2_stock"]; ?> </td>
                                                        <td> <?php
                                                                $sql4 = "SELECT * FROM unit WHERE id= '$row[units]'";
                                                                $rs4 = $conn->query($sql4);
                                                                $row4 = $rs4->fetch_assoc();
                                                                echo $row4['unit_name'];

                                                                ?>
                                                        </td>
                                                        <td> <?php echo $row["weight"]; ?> </td>
                                                        <td>

                                                            <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ไขข้อมูลสินค้า" href="/product_update.php?product_id=<?php echo $row["product_id"]; ?>">
                                                                <i class="i-Pen-2 font-weight-bold"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                mysqli_close($conn);
                                                ?>
                                                <tr>
                                                    <td colspan="14"> &nbsp;</td>
                                                </tr>

                                            </tbody>
                                        </table>
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