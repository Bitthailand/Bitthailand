        <!-- header top menu end-->
        <?php 
        $sql_emp = "SELECT * FROM employee   WHERE  emp_name = '$emp_id' ";
        $rs_emp = $conn->query($sql_emp);
        $row_emp = $rs_emp->fetch_assoc();
        $sql_grant = "SELECT * FROM user_grant WHERE  emp_id = '$row_emp[emp_id]' ";
        $rs_grant = $conn->query($sql_grant);
        $row_grant = $rs_grant->fetch_assoc();

        ?>
        <div class="horizontal-bar-wrap">
            <div class="header-topnav">
                <div class="container-fluid">
                    <div class="topnav rtl-ps-none" id="" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                        <ul class="menu float-left">
                            <li>
                                <div>
                                    <div>
                                        <label class="toggle" for="drop-2">Dashboard</label><a href="index.php"><i class="nav-icon mr-2 i-Bar-Chart"></i> Dashboard</a>
                                    </div>
                                </div>
                            </li>
                            <?php if ($row_grant['sale'] == 1) { ?> <li>
                                    <div>
                                        <div>
                                            <label class="toggle" for="drop-2">ขายสินค้า</label><a href="#"><i class="nav-icon mr-2 i-Suitcase"></i> ขายสินค้า</a>
                                            <input id="drop-2" type="checkbox" />
                                            <ul>
                                                <li><a href="/quotationlist.php"><i class="nav-icon mr-2 i-Add-Window"></i><span class="item-name"> รายการ Order</span></a></li>
                                                <li><a href="/customerslist.php"><i class="nav-icon mr-2 i-Add-User"></i><span class="item-name"> รายการ ลูกค้า</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                            <!-- end ui kits-->
                            <?php if ($row_grant['production'] == 1) { ?>
                                <li>
                                    <div>
                                        <div>
                                            <label class="toggle" for="drop-2">ผลิตสินค้า</label><a href="productionlist.php"><i class="nav-icon i-Factory1 mr-2"></i> ผลิตสินค้า</a>
                                            <!--      <input id="drop-2" type="checkbox" />
                                        <ul>
                                            <li><a href="productionlist.php"><i class="nav-icon mr-2 i-Line-Chart-2"></i><span class="item-name">รายการสั่งผลิต</span></a></li>
                                            <li><a href="productlist.php"><i class="nav-icon mr-2 i-Line-Chart-2"></i><span class="item-name">รายการสินค้า</span></a></li> 
                                        </ul> -->
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                            <!-- end extra uikits-->
                            <?php if ($row_grant['stock'] == 1) { ?>
                                 <li>
                                    <div>
                                        <div>
                                            <label class="toggle" for="drop-2">สต๊อกสินค้า</label><a href="/inventorylist.php"><i class="nav-icon mr-2 i-Computer-Secure"></i>
                                                สต๊อกสินค้า</a>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                            <!-- end apps-->
                            <?php if ($row_grant['transport'] == 1) { ?> 
                                <li>
                                    <div>
                                        <div>
                                            <label class="toggle" for="drop-2">ขนส่งสินค้า</label><a href="deliverylist.php"><i class="nav-icon mr-2 i-File-Clipboard-File--Text"></i> ขนส่งสินค้า</a>
                                        </div>
                                    </div>
                                </li> <?php } ?>
                            <!-- end Forms-->
                            <!-- end ui kits-->
                            <?php if ($row_grant['setting'] == 1) { ?>
                                 <li>
                                    <div>
                                        <div>
                                            <label class="toggle" for="drop-2">ตั้งค่า</label><a href="#"><i class="nav-icon i-Data-Settings mr-2"></i> ตั้งค่า</a>
                                            <input id="drop-2" type="checkbox" />
                                            <ul>
                                                <li><a href="setting_plant.php"><i class="nav-icon mr-2 i-Factory1"></i><span class="item-name">แพ</span></a></li>
                                                <li><a href="setting_ptype.php"><i class="nav-icon mr-2 i-Code-Window"></i><span class="item-name">ประเภทสินค้า</span></a></li>
                                                <li><a href="setting_unit.php"><i class="nav-icon mr-2 i-Duplicate-Window"></i><span class="item-name">หน่วยนับ</span></a></li>
                                                <li><a href="setting_emp.php"><i class="nav-icon mr-2 i-Duplicate-Window"></i><span class="item-name">เพิ่มพนักงาน</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                            <li>
                                <div>
                                    <div>
                                        <label class="toggle" for="drop-2">รายงาน</label><a href="#"><i class="nav-icon i-Data-Settings mr-2"></i> รายงาน</a>
                                        <ul>
                                        <?php if ($row_grant['report_production'] == 1) { ?>  <li><a href="report_production.php"><i class="nav-icon mr-2 i-Factory1"></i><span class="item-name">รายงานสั่งผลิต</span></a></li><?php } ?>
                                        <?php if ($row_grant['report_stock'] == 1) { ?>   <li><a href="report_stock.php"><i class="nav-icon mr-2 i-Code-Window"></i><span class="item-name">รายงานสต็อก</span></a></li><?php } ?>
                                        <?php if ($row_grant['report_sale'] == 1) { ?>    <li><a href="report_sale.php"><i class="nav-icon mr-2 i-Duplicate-Window"></i><span class="item-name">รายงานยอดขาย</span></a></li><?php } ?>
                                        <?php if ($row_grant['report_emp'] == 1) { ?>   <li><a href="report_emp.php"><i class="nav-icon mr-2 i-Duplicate-Window"></i><span class="item-name">รายงานพนักงาน</span></a></li><?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <!-- end extra uikits-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>