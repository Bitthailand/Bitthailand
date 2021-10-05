<?php
include './include/connect.php';
include './include/config_date2.php';

$datex = date('Y-m');
$d = explode("-", $datex);

$sql = "SELECT  DATE_FORMAT(date_create,'%Y-%m') As MyDate   FROM quotation  GROUP BY MyDate   ORDER BY MyDate ASC  LIMIT 12 "; //คำสั่ง เลือกข้อมูลจากตาราง report
$result = mysqli_query($conn, $sql);
$month = [];
$sum_all=[];
$cus_back=[];
$cus_back2=[];
// $value = [];
if (mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)) {
    $d = explode("-", $row['MyDate']);
    $yd = "$d[0]-$d[1]";
    $date1 = explode(" ", $yd);
    $dat1 =datethai5($date1[0]);
    $month[] = $dat1;
    // $value[] = $row['value'];

$sql2 = "SELECT  ROUND(SUM((order_details.qty-order_details.disunit)*order_details.unit_price), 2) AS sum  FROM quotation  INNER JOIN order_details  ON  quotation.order_id=order_details.order_id AND  MONTH(quotation.date_create) = '$d[1]' AND YEAR(quotation.date_create) = '$d[0]'  "; 
$result2 = mysqli_query($conn, $sql2);

// $value = [];
if (mysqli_num_rows($result2) > 0) {

  while ($row2 = mysqli_fetch_assoc($result2)) {
    $sum_all[] = $row2['sum'];
    // $value[] = $row['value'];
 
  }
}

$sql3 = "SELECT ROUND(SUM((order_details.qty-order_details.disunit)*order_details.unit_price), 2) AS sum  FROM quotation  INNER JOIN order_details  ON  quotation.order_id=order_details.order_id AND  MONTH(quotation.date_create) = '$d[1]' AND YEAR(quotation.date_create) = '$d[0]' "; 
$result3 = mysqli_query($conn, $sql3);
if (mysqli_num_rows($result3) > 0) {
  while ($row3 = mysqli_fetch_assoc($result3)) {
    $cus_back[] = $row3['sum'];
    // $value[] = $row['value'];
  //  echo json_encode($row3['sum']);
  }
}
$sql4 = "SELECT ROUND(SUM((deliver_detail.dev_qty-deliver_detail.disunit)*deliver_detail.unit_price), 2) AS sum  FROM quotation  INNER JOIN deliver_detail  ON  quotation.order_id=deliver_detail.order_id AND  MONTH(quotation.date_create) = '$d[1]' AND YEAR(quotation.date_create) = '$d[0]'  AND  deliver_detail.status_cf='1' "; 
$result4 = mysqli_query($conn, $sql4);
if (mysqli_num_rows($result4) > 0) {
  while ($row4 = mysqli_fetch_assoc($result4)) {
    $cus_back2[] = $row4['sum'];
  }
}

}
}

  ?>
<script>
  "use strict";


  $(document).ready(function() {

    // ยอดขาย 30 วันล่าสุด in Dashboard version 1
    var echartElemBar = document.getElementById("eORchartBar");

    if (echartElemBar) {
      var echartBar = echarts.init(echartElemBar);
      echartBar.setOption({
        legend: {
          borderRadius: 0,
          orient: "horizontal",
          x: "right",
          data: ["ยอดขาย"],
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
          data: <?= json_encode($datelast); ?>  ,
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
          min: 30000,
          max: 300000,
          interval: 25000,
          axisLine: {
            show: false,
          },
          splitLine: {
            show: true,
            interval: "auto",
          },
        }, ],
        series: [{
          name: "ยอดขาย",
          data: <?= json_encode($sumdate); ?>  ,
          label: {
            show: false,
            color: "#0168c1",
          },
          type: "line",
          barGap: 0,
          color: "#8b5cf6",
          smooth: true,
          itemStyle: {
            emphasis: {
              shadowBlur: 10,
              shadowOffsetX: 0,
              shadowOffsetY: -2,
              shadowColor: "rgba(0, 0, 0, 0.3)",
            },
          },
        }, ],
      });
      $(window).on("resize", function() {
        setTimeout(function() {
          echartBar.resize();
        }, 500);
      });
    }

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
          data: <?= json_encode($month); ?>  ,

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
          max: 8000000,
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
            name: "[ยอดสั่งชื้อ]",
            data: <?= json_encode($sum_all); ?>,
            label: {
              show: false,
              color: "#0168c1",
            },
            type: "bar",
            barGap: 0,
            color: "#8b5cf6",
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
            name: "เสนอราคา",
            data:<?= json_encode($cus_back); ?>,
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
            name: "ส่งสำเร็จ",
            data:<?= json_encode($cus_back2); ?>,
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
        ],
      });
 
    
    // Chart in Dashboard version 1

      $(window).on("resize", function() {
        setTimeout(function() {
          echart2.resize();
        }, 500);
      });
    } // Chart in Dashboard version 1

   
     
  });
</script>