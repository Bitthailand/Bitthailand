<?php 
echo '<h4> + วันที่ PHP </h4>';
$strStartDate =date('Y-m-d');
$strNewDate = date ("Y-m-d", strtotime("+20 day", strtotime($strStartDate)));
echo 'วันที่ '.$strStartDate;
echo '<br>';
echo ' + 20 วัน = '.$strNewDate;
//-------------//
echo '<hr>';
echo '<b> Workshop คำนวณวันหมดอายุสินค้า </b><br>';
$prdImptDate =date('Y-m-d'); //วันที่รับสินค้าเข้าคลัง
//คำนวณวันหมดอายุ
$calExpireDate = date ("Y-m-d", strtotime("+30 day", strtotime($prdImptDate)));
//echo ออกมาดู
echo 'สินค้ารับเข้าวันที่ '.$prdImptDate;
echo '<br>';
echo 'สินค้าจะหมดอายุอีก 30 วัน <br>';
echo 'สินค้าหมดอายุวันที่ '.$calExpireDate;
//devbanban.com
?>