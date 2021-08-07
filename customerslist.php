<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';
include './include/config.php';
error_reporting(0);
$action = $_REQUEST['action'];
if ($action == 'del') {
    $del_id = $_REQUEST['del_id'];

    $sql = "DELETE FROM customer  WHERE customer_id='$del_id' ";
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
$rowS = $_REQUEST['row'];
if ($column == '') {
} else {
    $columx = "AND $column LIKE'$keyword%'";
    // echo"$columx";   
}
if ($keyword == '') {
} else {
    $keywordx = "AND customer_id LIKE'$keyword%'
               OR customer_name LIKE'$keyword%'
               OR  company_name LIKE'$keyword%'
               OR tel LIKE'$keyword%'
               OR contact_name  LIKE'$keyword%' 
               OR bill_address LIKE'$keyword%' ";
    //    echo"$keywordx";
}
if ($rowS == '') {
    $total_records_per_page = 10;
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
    <title>Customer | รายการลูกค้า</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="../../dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="../../dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
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
                                                <div class="form-group">
                                                    <label for="searchColumnId"> ประเภท </label>
                                                    <select id="searchColumnId" class="custom-select" name="column">
                                                        <option value="" <?php echo $column == '' ? 'selected' : ''; ?>> ไม่ระบุ </option>
                                                        <option value="customer_id" <?php echo $column == 'customer_id' ? 'selected' : ''; ?>> รหัสลูกค้า </option>
                                                        <option value="customer_name" <?php echo $column == 'customer_name' ? 'selected' : ''; ?>>ชื่อลูกค้า </option>
                                                        <option value="company" <?php echo $column == 'company' ? 'selected' : ''; ?>>บริษัท </option>
                                                        <option value="address" <?php echo $column == 'address' ? 'selected' : ''; ?>>ที่อยู่ </option>
                                                        <option value="phone" <?php echo $column == 'phone' ? 'selected' : ''; ?>>เบอร์โทร </option>
                                                        <option value="tax_number" <?php echo $column == 'tax_number' ? 'selected' : ''; ?>>เลขที่ผู้เสียภาษี</option>

                                                    </select>
                                                </div>
                                            </div>
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

                                                        <option value="10" <?php echo $rowS == 10 ? 'selected' : ''; ?>> 10 </option>
                                                        <option value="20" <?php echo $rowS == 20 ? 'selected' : ''; ?>> 20 </option>
                                                        <option value="30" <?php echo $rowS == 30 ? 'selected' : ''; ?>> 30 </option>
                                                        <option value="40" <?php echo $rowS == 40 ? 'selected' : ''; ?>> 40 </option>
                                                        <option value="50" <?php echo $rowS == 50 ? 'selected' : ''; ?>> 50 </option>
                                                        <option value="100" <?php echo $rowS == 100 ? 'selected' : ''; ?>> 100 </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="/customer.php" class="btn btn-outline-primary mt-4" role="button" aria-pressed="true"> เพิ่มลูกค้าใหม่</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ============ Table Start ============= -->
                            <div class="table-responsive">
                                <table class="table table-hover text-nowrap table-sm">

                                    <thead>
                                        <tr>
                                            <th>customer ID</th>
                                            <th>ชื่อลูกค้า</th>
                                            <th>บริษัท</th>
                                            <th>ที่อยู่</th>
                                            <th>ตำบล</th>
                                            <th>อำเภอ</th>
                                            <th>จังหวัด</th>
                                            <th>เบอร์โทร</th>
                                            <th>เลขที่เสียภาษี</th>
                                            <th>อ้างอิง</th>
                                            <th>Action</th>
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

                                        $result_count = mysqli_query($conn, "SELECT COUNT(*) As total_records FROM `customer` where  status='0' $columx $keywordx  ");
                                        $total_records = mysqli_fetch_array($result_count);
                                        $total_records = $total_records['total_records'];
                                        $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                        $second_last = $total_no_of_pages - 1; // total page minus 1

                                        $result = mysqli_query($conn, "SELECT * FROM `customer` where status='0' $columx $keywordx LIMIT $offset, $total_records_per_page");
                                        while ($row = mysqli_fetch_array($result)) { ?>
                                        <tr>
                                            <td><?php echo $row['customer_id']; ?></td>
                                            <td><?php echo $row['customer_name']; ?></td>
                                            <td><?php echo $row['company_name']; ?></td>
                                            <td><?php echo $row['bill_address']; ?></td>
                                            <td><?php
                                                    $sql3 = "SELECT * FROM districts  WHERE id= '$row[subdistrict]'";
                                                    $rs3= $conn->query($sql3);
                                                    $row3 = $rs3->fetch_assoc();
                                                    echo $row3['name_th'];

                                                    ?>
                                            </td>
                                            <td><?php
                                                    $sql4 = "SELECT * FROM amphures  WHERE id= '$row[district]'";
                                                    $rs4= $conn->query($sql4);
                                                    $row4 = $rs4->fetch_assoc();
                                                    echo $row4['name_th'];

                                                    ?>
                                            <td><?php
                                                    $sql5 = "SELECT * FROM provinces  WHERE id= '$row[province]'";
                                                    $rs5= $conn->query($sql5);
                                                    $row5 = $rs5->fetch_assoc();
                                                    echo $row5['name_th'];

                                                    ?>
                                            </td>
                                            <td><?php echo $row['tel']; ?></td>
                                            <td><?php echo $row['tax_number']; ?></td>
                                            <td><?php echo $row['contact_name']; ?></td>
                                            <td>

                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ไขข้อมูลลูกค้า"
                                                    href="/customer_update.php?customer_id=<?php echo $row['customer_id']; ?>">
                                                    <i class="i-Pen-2 font-weight-bold"></i>
                                                </a>

                                                <button type="button" class="btn btn-outline-info btn-sm line-height-1" data-id="<?php echo $row['customer_id']; ?>"
                                                    data-toggle="modal" data-target="#myModal_del"> <i class="i-Close-Window font-weight-bold"></i> </button>

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
                                <!-- ============ Table End ============= -->
                                <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
                                    <strong>Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong>
                                </div>






                                <div class="mb-5 mt-3">
                                    <nav aria-label="Page navigation ">
                                        <ul class="pagination justify-content-center">
                                            <?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } 
                                            ?>

                                            <li class="page-item" <?php if ($page_no <= 1) {
                                                                        echo "class='disabled'";
                                                                    } ?>>
                                                <a <?php if ($page_no > 1) {
                                                        echo "href='?page_no=$previous_page' ";
                                                    } ?>>Previous</a>
                                            </li>

                                            <?php
                                            if ($total_no_of_pages <= 10) {
                                                for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                                                    if ($counter == $page_no) {
                                                        echo "<li class='active'><a>$counter</a></li>";
                                                    } else {
                                                        echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                                                    }
                                                }
                                            } elseif ($total_no_of_pages > 10) {

                                                if ($page_no <= 4) {
                                                    for ($counter = 1; $counter < 8; $counter++) {
                                                        if ($counter == $page_no) {
                                                            echo "<li class='page-item  active'><a>$counter</a></li>";
                                                        } else {
                                                            echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                                                        }
                                                    }
                                            ?>
                                            <li class="page-item"><a>...</a></li>
                                            <li><a href='?page_no=<?php echo "$second_last"; ?>'><?php echo "$second_last"; ?></a></li>
                                            <li><a href='?page_no=<?php echo "$total_no_of_pages"; ?>'><?php echo "$total_no_of_pages"; ?></a></li>
                                            <?php  } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) { ?>
                                            <li class="page-item"><a class="page-link" href='?page_no=1'>1</a></li>"
                                            <li class="page-item"><a class="page-link" href='?page_no=2'>2</a></li>
                                            <li class="page-item"><a>...</a></li>
                                            <?php for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                                                        if ($counter == $page_no) { ?>
                                            <li class='active'><a><?php echo "$counter"; ?></a></li>
                                            <?php  } else { ?>
                                            <li><a href='?page_no=<?php echo "$counter"; ?>'><?php echo "$counter"; ?></a></li>
                                            <?php    }
                                                    }
                                                    echo "<li><a>...</a></li>";
                                                    echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
                                                    echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                                                } else {
                                                    echo "<li><a href='?page_no=1'>1</a></li>";
                                                    echo "<li><a href='?page_no=2'>2</a></li>";
                                                    echo "<li><a>...</a></li>";

                                                    for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                                        if ($counter == $page_no) {
                                                            echo "<li class='active'><a>$counter</a></li>";
                                                        } else {
                                                        ?> <li><a class="page-link" href='?page_no=$counter'><?php echo "$counter"; ?></a></li>
                                            <?php   }
                                                    }
                                                }
                                            }
                                            ?>

                                            <li <?php if ($page_no >= $total_no_of_pages) {
                                                    echo "class='disabled'";
                                                } ?>>
                                                <a <?php if ($page_no < $total_no_of_pages) {
                                                        echo "href='?page_no=$next_page'";
                                                    } ?>>Next</a>
                                            </li>







                                            <?php if ($page_no < $total_no_of_pages) {
                                                echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
                                            } ?>
                                        </ul>




                                </div>


                            </div>
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

</html>