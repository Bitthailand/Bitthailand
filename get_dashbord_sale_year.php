<?php
include './include/connect.php';
include './include/config_date2.php';

$datex = date('Y-m');
$d = explode("-", $datex);

$sql = "SELECT  DATE_FORMAT(delivery.dev_date,'%Y') As MyDate,SUM(discount) AS discount   FROM delivery  WHERE    status_chk='1' AND status_payment='1'   GROUP BY MyDate ORDER BY MyDate  DESC "; //คำสั่ง เลือกข้อมูลจากตาราง report
$result = mysqli_query($conn, $sql);
$month = [];
$sum_all=[];

// $value = [];
if (mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)) {
    $d1 = explode("-", $row['MyDate']);
    $yd = "$d[0]";
    $date1 = explode(" ", $yd);
    $dat1 = datethai5($date1[0]);
    $month[] = $dat1;
    
    // $value[] = $row['value'];


        $sql_sum1 = "SELECT SUM(ai_number.price) AS price   FROM delivery  INNER JOIN ai_number  ON  delivery.order_id=ai_number.order_id AND   YEAR(delivery.dev_date) = '$d1[0]'  AND  ai_number.aix_status = '0' AND   delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='1' ";
        $rs_sum1 = $conn->query($sql_sum1);
        $row_sum1 = $rs_sum1->fetch_assoc();
        $sql_sum4 = "SELECT SUM(delivery.ai_count) AS ai_count FROM delivery  INNER JOIN ai_number  ON  delivery.order_id=ai_number.order_id AND   YEAR(delivery.dev_date) = '$d1[0]'   AND delivery.ai_status = '1' AND   delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='1'";
        $rs_sum4 = $conn->query($sql_sum4);
        $row_sum4 = $rs_sum4->fetch_assoc();
        $sql_ai = "SELECT SUM(price)AS total  FROM ai_number  WHERE   YEAR(date_create) = '$d1[0]' AND aix_status = '0'  ";
        $rs_ai = $conn->query($sql_ai);
        $row_ai = $rs_ai->fetch_assoc();
    
        $sql_sum3 = "SELECT SUM(deliver_detail.total_price) AS total  FROM delivery  INNER JOIN deliver_detail  ON  delivery.order_id=deliver_detail.order_id AND   YEAR(delivery.date_create) = '$d1[0]'  AND delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='2'   AND delivery.dev_id=deliver_detail.dev_id ";
        $rs_sum3 = $conn->query($sql_sum3);
        $row_sum3 = $rs_sum3->fetch_assoc();
    
        $sql_sum = "SELECT SUM(deliver_detail.total_price) AS total  FROM delivery  INNER JOIN deliver_detail  ON  delivery.order_id=deliver_detail.order_id AND   YEAR(delivery.dev_date) = '$d1[0]'   AND delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.dev_id=deliver_detail.dev_id   AND delivery.cus_type='1' ";
        $rs_sum = $conn->query($sql_sum);
        $row_sum = $rs_sum->fetch_assoc();
    
        $sql_refun = "SELECT SUM(price_refun)AS total  FROM  sr_number  WHERE status_refun='1' AND  YEAR(date_create) = '$d1[0]' ";
        $rs_refun = $conn->query($sql_refun);
        $row_refun = $rs_refun->fetch_assoc();

        $sumx_ai = $row_sum1['price'] + $row_sum4['ai_count'];
        $sum_total = $row_sum['total'] - $row['discount'];
        $sum= $sum_total- $sumx_ai+$row_ai['total']+$row_sum3['total']-$row_refun['total'];

        $sum_all[] = $sum;
        // $value[] = $row['value'];
     
    
    
    $sql3 = "SELECT ROUND(SUM(deliver_detail.total_price), 2) AS sum  FROM  delivery INNER JOIN  deliver_detail ON delivery.dev_id=deliver_detail.dev_id  AND  deliver_detail.status_cf='1' AND deliver_detail.payment='1'AND  deliver_detail.cus_back='1' AND   YEAR(delivery.dev_date) = '$d[0]'  "; 
    $result3 = mysqli_query($conn, $sql3);
    if (mysqli_num_rows($result3) > 0) {
      while ($row3 = mysqli_fetch_assoc($result3)) {
        
        $cus_back[] = $row3['sum'];
      
      }
    }
    $sql3 = "SELECT ROUND(SUM(deliver_detail.total_price), 2) AS sum  FROM  delivery INNER JOIN  deliver_detail ON delivery.dev_id=deliver_detail.dev_id  AND  deliver_detail.status_cf='1' AND deliver_detail.payment='1'AND  deliver_detail.cus_back='2' AND   YEAR(delivery.dev_date) = '$d[0]'  "; 
    $result3 = mysqli_query($conn, $sql3);
    if (mysqli_num_rows($result3) > 0) {
      while ($row3 = mysqli_fetch_assoc($result3)) {
        $cus_back2[] = $row3['sum'];
      
      }
    }
    $sql3 = "SELECT ROUND(SUM(deliver_detail.total_price), 2) AS sum  FROM  delivery INNER JOIN  deliver_detail ON delivery.dev_id=deliver_detail.dev_id  AND  deliver_detail.status_cf='1' AND deliver_detail.payment='1'AND  deliver_detail.cus_back='3' AND   YEAR(delivery.dev_date) = '$d[0]'  "; 
    $result3 = mysqli_query($conn, $sql3);
    if (mysqli_num_rows($result3) > 0) {
      while ($row3 = mysqli_fetch_assoc($result3)) {
        $cus_back3[] = $row3['sum'];
      
      }
    }
  }
}



?>
<script>
  "use strict";


  $(document).ready(function() {

    // ยอดขาย 30 วันล่าสุด in Dashboard version 1



    // ยอดขายประจำปี in Dashboard version 1
    var echartElemBar = document.getElementById("echartBar");

    if (echartElemBar) {
      var echartBar = echarts.init(echartElemBar);



      echartBar.setOption({

        legend: {
          borderRadius: 0,
          orient: "horizontal",
          x: "right",
          data: ["ยอดขาย", "Online", "Wark-in"],
        },
        grid: {
          left: "8px",
          right: "8px",
          bottom: "0",
          containLabel: true,
        },
        tooltip: {
          show: true,
          backgroundColor: "rgba(0, 0, 0, .8)",
        },
        xAxis: [{
          type: "category",
          data: <?= json_encode($month); ?>,

          axisTick: {
            alignWithLabel: true,
          },
          splitLine: {
            show: false,
          },
          axisLine: {
            show: true,
          },
        }, ],

        yAxis: [{
          type: "value",
          axisLabel: {
            formatter: "฿{value}",
          },
          min: 0,
          max: 19400000,
          interval: 1000000,
          axisLine: {
            show: false,
          },
          splitLine: {
            show: true,
            interval: "auto",
          },
        }, ],
        series: [{
            name: "[ยอดขายรวม]",
            data: <?= json_encode($sum_all); ?>,
            label: {
              show: false,
              color: "#0168c1",
            },
            type: "bar",
            barGap: 0,
            color: "#FF3333",
            smooth: true,
            itemStyle: {
              emphasis: {
                shadowBlur: 10,
                shadowOffsetX: 0,
                shadowOffsetY: -2,
                shadowColor: "rgba(0, 0, 0, 0.3)",
              },
            },
          },
         
        
          
        ],
      });
    

    // Chart in Dashboard version 1

   
      $(window).on("resize", function() {
        setTimeout(function() {
          echart3.resize();
        }, 500);
      });
    }
  });
</script>