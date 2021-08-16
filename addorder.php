<?php
session_start();
if (isset($_SESSION["username"])) {
} else {
    header("location:signin.php");
}
include './include/connect.php';

error_reporting(0);
$CUS_ID = $_REQUEST['CUS_ID'];
echo "$CUS_ID";
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
            <div class="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <!-- <div class="card"> -->
                        <div class="tab-content">
                            <form class="tab-pane fade active show" method="post">
                                <div class="border-bottom text-primary">
                                    <div class="card-title">เพิ่ม Order ใหม่</div>
                                </div>
                                <div class="form-row mt-3">
                                    <div class="form-group col-md-1">
                                        <label for="order_id"><strong>รหัส Order <span class="text-danger"></span></strong></label>
                                        <input type="text" name="order_id" id="order_id" class="classcus form-control" placeholder="รหัส Order" required>
                                    </div>
                                    <button class="btn btn-outline-primary ripple m-1" type="button" data-toggle="modal" data-target="#modalcustomerlist" style=" height: 33px; margin-top: 24px!important;">เลือกลูกค้า</button>
                                    <a class="btn btn-outline-primary m-1" href="/customer.php" type="button" style=" height: 33px; margin-top: 24px!important;">เพิ่มลูกค้าใหม่</a>
                                    <div class="form-group col-md-1">
                                        <label for="customer_type"><strong>รับสินค้า <span class="text-danger"></span></strong></label>
                                        <select class="classcus custom-select" name="customer_type" id="customer_type" required>
                                            <option value="เงินสด">รับกลับเอง</option>
                                            <option value="เครดิต">บริษัทส่งให้</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="accNameId"><strong>ประเภทลูกค้า <span class="text-danger"></span></strong></label>
                                        <input type="text" name="customer_type" id="Fcus_type_name" class="classcus form-control" placeholder="ประเภทลูกค้า" required>
                                        <input type="hidden" name="customer_type" id="Fcus_type_id" class="classcus form-control">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="accNameId"><strong>ชื่อ-นามสกุล <span class="text-danger"></span></strong></label>
                                        <input type="text" name="customer_name" id="Fcus_name" class="classcus form-control" placeholder="ชื่อ-นามสกุล" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="phone"><strong>เบอร์โทร <span class="text-danger"></span></strong></label>
                                        <input type="text" name="phone" id="Fcus_tel" class="classcus form-control" placeholder="เบอร์โทร" required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="accAddressId"><strong>ที่อยู่ <span class="text-danger"></span></strong></label>
                                        <input type="text" name="address" class="classcus form-control" id="Fcus_bill_address" placeholder="ที่อยู่" required="">
                                    </div>
                                    <div class="row mt-12">
                                        <div class="form-group col-md-2">
                                            <label for="product_type"><strong>ประเภท <span class="text-danger"></span></strong></label>
                                            <select class="classcus custom-select" name="product_type" id="product_type" required>
                                                <option value="PT001">เสารั้วลวดหนาม</option>
                                                <option value="PT002">เสาเข็มไอ</option>
                                                <option value="PT003">เสาเข็มสี่เหลี่ยม</option>
                                                <option value="PT004">กำแพงกันดิน</option>
                                                <option value="PT005">เสาไฟฟ้า</option>
                                                <option value="PT006">ลวดหนาม</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="product"><strong>สินค้าที่จะผลิต <span class="text-danger"></span></strong></label>
                                            <select class="classcus custom-select" name="product" id="product" required>
                                                <option value="FP03100020">เสารั้ว 3x3" ยาว 1.00 ขนาดลวด 4 จำนวน 2 เส้น </option>
                                                <option value="FP03145020">เสารั้ว 3x3" ยาว 1.45 ขนาดลวด 4 จำนวน 2 เส้น</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="qty"><strong>จำนวนที่สั่ง <span class="text-danger"></span></strong></label>
                                            <input type="text" name="qty" id="qty" class="classcus form-control" placeholder="จำนวนสั่งผลิต" required>
                                        </div>
                                        <button class="btn btn-outline-primary ripple m-1" type="button" style=" height: 33px; margin-top: 24px!important;">เพิ่มรายการ</button>

                                        <!-- ============ Table Start ============= -->
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-hover text-nowrap table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>รหัสสินค้า</th>
                                                            <th>ประเภทสินค้า</th>
                                                            <th>ชื่อสินค้า</th>
                                                            <th>ราคาต่อหน่วย</th>
                                                            <th>จำนวนที่สั่ง</th>
                                                            <th>รวมเป็นเงิน</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td> <strong>FP03100020</strong> </td>
                                                            <td> เสารั้วลวดหนาม</td>
                                                            <td> เสารั้วลวดหนาม ขนาด 3 นิ้ว ยาว 2.00 เมตร </td>
                                                            <td> 45 </td>
                                                            <td> 120 </td>
                                                            <td> 5,400.00 </td>
                                                            <td>
                                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ไขจำนวนที่สั่ง" href="#">
                                                                    <i class="i-Pen-2 font-weight-bold"></i>
                                                                </a>
                                                                <a class="btn btn-outline-danger btn-sm line-height-1" data-toggle="tooltip" title="ยกเลิกรายการ" href="#">
                                                                    <i class="i-Close-Window font-weight-bold"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>FP03145020</strong> </td>
                                                            <td> เสารั้วลวดหนาม</td>
                                                            <td> เสารั้วลวดหนาม ขนาด 3 นิ้ว ยาว 1.45 เมตร </td>
                                                            <td> 60 </td>
                                                            <td> 90 </td>
                                                            <td> 5,000.00 </td>
                                                            <td>
                                                                <a class="btn btn-outline-success btn-sm line-height-1" data-toggle="tooltip" title="แก้ไขจำนวนที่สั่ง" href="#">
                                                                    <i class="i-Pen-2 font-weight-bold"></i>
                                                                </a>
                                                                <a class="btn btn-outline-danger btn-sm line-height-1" data-toggle="tooltip" title="ยกเลิกรายการ" href="#">
                                                                    <i class="i-Close-Window font-weight-bold"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="14"> &nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- ============ Table End ============= -->
                                    </div>
                                    <div class="viewDateClass col pr-0 ">
                                        <div class="form-group">
                                            <label for="delivery_date">กำหนดส่งสินค้า</label>
                                            <input id="delivery_date" class="form-control" type="date" min="2021-06-01" name="start" value="2021-08-04" required="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label for="delivery_Address"><strong>ที่อยู่ จัดส่ง<span class="text-danger"></span></strong></label>
                                        <input type="text" name="delivery_Address" class="classcus form-control" id="delivery_Address" placeholder="ที่อยู่" required="">
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="date_confirm"><strong>ยืนยันใน(วัน) <span class="text-danger"></span></strong></label>
                                        <input type="text" name="date_confirm" id="date_confirm" class="classcus form-control" placeholder="ยืนยันราคาใน" Value="0" required>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="tax"><strong>ภาษี(%) <span class="text-danger"></span></strong></label>
                                        <input type="text" name="tax" id="tax" class="classcus form-control" placeholder="ภาษี" Value="7" required>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="discount"><strong>ส่วนลด(บาท) <span class="text-danger"></span></strong></label>
                                        <input type="text" name="discount" id="discount" class="classcus form-control" placeholder="ส่วนลด" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-right">
                                    <input class="d-none" id="addAccId" type="text" name="acc_id" value="" placeholder="">
                                    <input class="d-none" id="addActionId" type="text" name="action" value="add" placeholder="">

                                    <a class="btn btn-outline-primary m-1" href="/quotation.php" type="button" target="_blank">ออกใบเสนอราคา(QT)</a>
                                    <a class="btn btn-outline-primary m-1 disabled" href="/hs.php" type="button" target="_blank">ออกใบเสร็จรับเงิน(HS)</a>
                                    <a class="btn btn-outline-primary m-1 disabled" href="/saleorder.php" type="button" target="_blank">ออกใบส่งของ(SO)</a>
                                    <button id="btnAddId" class="btn btn-outline-primary d-none" type="submit">ยืนยัน Order</button>
                                    <button class="btn btn-primary ladda-button btn-add" data-style="expand-left">
                                        <span class="ladda-label">ยืนยัน Order</span>
                                    </button>
                                    <a class="btn btn-outline-danger m-1" href="/quotationlist.php" type="button">กลับหน้ารายการ Order</a>
                                </div>
                            </form>
                        </div>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
            <!-- Header -->
            <?php include './include/footer.php'; ?>
            <!-- =============== Header End ================-->
        </div>
    </div>

    <!-- Modal เลือกรายการลูกค้า -->
    <div class="modal fade" id="modalcustomerlist" tabindex="-1" role="dialog" aria-labelledby="medalmodalcustomerlistTitle-2" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medalmodalcustomerlistTitle-2">เลือกรายการลูกค้า</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="col-auto">
                        <div class="text-left">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="form-group">
                                        <label for="searchNameId"> ค้นหา</label>
                                        <input id="myInput" class="form-control" placeholder="ใส่คำที่ต้องการค้นหา" type="text" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============ Table Start ============= -->
                        <div class="modal-content">
                            <div id="productionorder" class="table-responsive">
                                <table role="table" class="table table-hover text-nowrap table-sm">
                                    <thead>
                                        <tr class="table-secondary">
                                            <th>เลือก</th>
                                            <th>รหัสลูกค้า</th>
                                            <th>ชื่อลูกค้า</th>
                                            <th>ที่อยู่</th>

                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                                        <?php
                                        $sqlxx = "SELECT *  FROM customer  order by customer_id  DESC";
                                        $resultxx = mysqli_query($conn, $sqlxx);
                                        if (mysqli_num_rows($resultxx) > 0) {
                                            while ($row1 = mysqli_fetch_assoc($resultxx)) {

                                        ?>
                                                <tr data-toggle="modal" data-id="3" data-target="#orderModal">

                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="cus_id" id="cus_id<?php echo $row1['id']; ?>" value="<?php echo $row1['id']; ?>" onclick="selection()" data-dismiss="modal">
                                                            <label class="btn btn-outline-primary" for="cus_id<?php echo $row1['id']; ?>">เลือกลูกค้า</label><br>
                                                        </div>
                                                    </td>
                                                    <td> <?php echo $row1['customer_id']; ?> </td>
                                                    <td><?php echo "$row1[customer_name]"; ?></td>
                                                    <td><?php echo "$row1[bill_address]"; ?></td>

                                            <?php }
                                        } ?>

                                    </tbody>
                                </table>
                                <div class="modal-footer">


                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">ปิด</button>
                                    <button class="btn btn-secondary " type="button" onclick="selection()" data-dismiss="modal">เลือกลูกค้า</button>

                                </div>
                            </div>
                        </div>
                        <!-- ============ Table End ============= -->

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
        <!-- ============ Script End ============= -->

        <!-- ============ Tooltip Starts ============ -->
        <script src="/dist-assets/js/scripts/tooltip.script.min.js"></script>
        <!-- ============ Tooltip End ============ -->

        <!-- ============ btnLoad Script Starts ============ -->
        <script src="/dist-assets/js/plugins/spin.min.js"></script>
        <script src="/dist-assets/js/plugins/ladda.min.js"></script>
        <!-- ============ btnLoad Script End ============ -->

        <!-- ============ dataTable Script Starts ============ -->
        <script src="/dist-assets/js/plugins/datatables.min.js"></script>
        <script src="/dist-assets/js/scripts/datatables.script.min.js"></script>
        <!-- ============ dataTable Script End ============ -->

        <!-- ============ Modal Script Starts ============ -->
        <script src="/dist-assets/js/plugins/sweetalert2.min.js"></script>

        <!--  -->
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


        <form class="d-none" method="POST">
            <input type="text" id="Fcus_id" name="CUS_ID" value="<?php echo $CUS_ID; ?>" placeholder="">
            <input type="hidden" id="FSpo_id" name="po_idd1" value="<?php echo "$po_id"; ?>">
            <button class="btn" id="FSButtonID" type="submit"></button>
        </form>
        <!-- ============ Modal Script End ============ -->
        <script>
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

            function selection() {

                let cusid = $("input:radio[name=cus_id]:checked").val()
                if (cusid === undefined || cusid === '') {
                    alert('xxxx');
                } else {

                    // alert('d' + d);
                    console.log('dds', cusid)


                    $.get('get_customer.php?cus_id=' + cusid, function(data) {
                        var result = JSON.parse(data);
                        console.log('cus', result)
                        $.each(result, function(index, cus) {


                                $("#Fid").val(cus.id);
                                $("#Fcus_id").val(cus.customer_id);
                                $("#Fcus_name").val(cus.customer_name);
                                $("#Fcus_tel").val(cus.tel);

                                $("#Fcus_type_id").val(cus.customer_type);
                                //    
                                $.get('get_customer_type.php?type_id=' + cus.customer_type, function(data) {
                                    var result = JSON.parse(data);
                                    console.log('cus_type', result)
                                    $.each(result, function(index, custype) {
                                            $("#Fcus_type_name").val(custype.name);
                                        }


                                    );
                                });
                                $.get('get_district1.php?subdistrict_id=' + cus.subdistrict, function(data) {
                                    var result = JSON.parse(data);
                                    console.log('cus_subdistrict', result)
                                    $.each(result, function(index, subdistrict) {
                                            $("#Fcus_subdistrict").val(subdistrict.name_th);

                                            let bill = cus.bill_address+subdistrict.name_th;
                                            $("#Fcus_bill_address").val(bill);
                                        }


                                    );
                                });
                                // 


                            }


                        );
                    });
                }
            }

            function address() {



            }
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