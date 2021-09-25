<?php
include './include/connect.php';
include './include/config_date2.php';

$datex = date('Y-m');
$d = explode("-", $datex);

$sql = "SELECT  DATE_FORMAT(delivery.dev_date,'%Y') As MyDate   FROM delivery INNER JOIN  deliver_detail  ON delivery.dev_id=deliver_detail.dev_id  GROUP BY MyDate   ORDER BY MyDate ASC  LIMIT 5 "; //คำสั่ง เลือกข้อมูลจากตาราง report
$result = mysqli_query($conn, $sql);
$month = [];
$sum_all=[];
$cus_back=[];
$cus_back2=[];
$cus_back3=[];
// $value = [];
if (mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)) {
    $d = explode("-", $row['MyDate']);
    $yd = "$d[0]";
    $date1 = explode(" ", $yd);
    $dat1 = datethai5($date1[0]);
    $month[] = $dat1;
    
    // $value[] = $row['value'];

    $sql2 = "SELECT  ROUND(SUM(deliver_detail.total_price), 2) AS sum  FROM delivery INNER JOIN  deliver_detail ON delivery.dev_id=deliver_detail.dev_id  AND  deliver_detail.status_cf='1' AND deliver_detail.payment='1' AND   YEAR(delivery.dev_date) = '$d[0]'  "; 
    $result2 = mysqli_query($conn, $sql2);
    
    // $value = [];
    if (mysqli_num_rows($result2) > 0) {
    
      while ($row2 = mysqli_fetch_assoc($result2)) {
        $sum_all[] = $row2['sum'];
        // $value[] = $row['value'];
     
      }
    }
    
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
          max: 9400000,
          interval: 500000,
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
            color: "#8b5cf4",
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
          {
            name: "รับกลับบ้าน",
            data: <?= json_encode($cus_back); ?>,
            label: {
              show: false,
              color: "#639",
            },
            type: "bar",
            color: "#A78BFA",
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
          {
            name: "บริษัทจัดส่ง",
            data: <?= json_encode($cus_back2); ?>,
            label: {
              show: false,
              color: "#639",
            },
            type: "bar",
            color: "#DDD6FE",
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
          {
            name: "บริษัทจัดส่ง",
            data: <?= json_encode($cus_back3); ?>,
            label: {
              show: false,
              color: "#619",
            },
            type: "bar",
            color: "#DDD6FE",
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