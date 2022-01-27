<?php
include './include/connect.php';
include './include/config_date2.php';

$datex = date('Y-m');
$d = explode("-", $datex);

$sql = "SELECT  DATE_FORMAT(po_enddate,'%Y-%m') As MyDate   FROM production_order  GROUP BY MyDate   ORDER BY MyDate ASC  LIMIT 12 "; //คำสั่ง เลือกข้อมูลจากตาราง report
$result = mysqli_query($conn, $sql);
$month = [];
$sum_all=[];
$qc_ok=[];
$qc_no=[];
// $value = [];
if (mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)) {
    $d = explode("-", $row['MyDate']);
    $yd = "$d[0]-$d[1]";
    $date1 = explode(" ", $yd);
    $dat1 =datethai5($date1[0]);
    $month[] = $dat1;
    // $value[] = $row['value'];
   
$sql2 = " SELECT SUM(production_detail.qty) AS qty ,production_detail.product_id AS product_id,SUM(production_detail.a_type) AS a_type ,SUM(production_detail.b_type) AS b_type ,SUM(product.unit_price)AS unit_price,SUM(qty*unit_price) AS sumall ,SUM(a_type*unit_price) AS sum_atype ,SUM(b_type*unit_price) AS sum_btype   FROM production_detail  INNER JOIN  product  ON product.product_id=production_detail.product_id  
INNER JOIN  production_order ON MONTH(production_order.po_enddate) = '$d[1]' AND YEAR(production_order.po_enddate) = '$d[0]' AND production_order.po_id=production_detail.po_id AND production_detail.status_stock='1'   "; 
$result2 = mysqli_query($conn, $sql2);

// $value = [];
if (mysqli_num_rows($result2) > 0) {

  while ($row2 = mysqli_fetch_assoc($result2)) {
    $sum_all[] = $row2['sumall'];
    $qc_ok[] =   $row2['sum_atype'];
    $qc_no[] =   $row2['sum_btype'];
  }
}



}
}
// แบ่งตามประเภทสินค้า
$sql = "SELECT *  FROM product_type  where status='0'  ORDER BY  id  ASC  LIMIT 20 "; 
$result = mysqli_query($conn, $sql);
$ptype = [];
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    // echo"$row[ptype_name]<br>";
    $ptype[] = $row['ptype_name'];
  }}


  // แบ่งตามประเภทสินค้า PIE
$sql = "SELECT product.ptype_id AS ptype, product_type.ptype_name AS pname,SUM(production_detail.qty) AS qty,SUM(product.unit_price)AS unit_price, SUM(qty*unit_price) AS CO FROM  product INNER JOIN production_detail
ON product.product_id = production_detail.product_id 
INNER JOIN product_type ON  product.ptype_id = product_type.ptype_id AND production_detail.status_stock='1' 
INNER JOIN production_order ON  YEAR(production_order.po_enddate) = '$d[0]'  GROUP BY product.ptype_id"; 
$result = mysqli_query($conn, $sql);
$content = [];
if (mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)) {
    // echo"$row[ptype_name]<br>";
    $content[] = [
      'name' => $row['pname'],
      'value' => $row['CO']
     ];
  }}


  // วันที่ย้อนหลัง 30 วัน

$sql = "SELECT  DATE_FORMAT(production_order.po_date, '%Y-%m-%d') AS DATE ,ROUND(SUM(production_detail.qty)) AS SUM  FROM  production_detail    INNER JOIN production_order   ON  production_order.po_id=production_detail.po_id  AND production_order.po_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW() GROUP BY DATE  "; 
$result = mysqli_query($conn, $sql);
$datelast = [];
$sumdate=[];
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $d = explode("-", $row['DATE']);
    $yd = "$d[0]-$d[1]-$d[2]";
    $date1 = explode(" ", $yd);
    $dat1 =datethai4($date1[0]);
    $datelast[] = $dat1;
    $sumdate[] = $row['SUM'];
  }}




$sql = "SELECT  DATE_FORMAT(po_enddate,'%Y-%m') As MyDate   FROM production_order  where status_cf='1' GROUP BY MyDate   ORDER BY MyDate DESC  LIMIT 12 "; //คำสั่ง เลือกข้อมูลจากตาราง report
$result = mysqli_query($conn, $sql);
$month_pro = [];
$pro_PS = [];
$pro_FP = [];
$pro_CF = [];
$pro_CO = [];
$pro_IP = [];
$pro_BB = [];
$pro_BC = [];
if (mysqli_num_rows($result) > 0) {
while ($row = mysqli_fetch_assoc($result)) {
  $d = explode("-", $row['MyDate']);
  $yd = "$d[0]-$d[1]";
  $date1 = explode(" ", $yd);
  $dat1 =datethai5($date1[0]);
  $month_pro[] = $dat1;

  $sql2 = "SELECT product.ptype_id AS ptype, product_type.ptype_name AS pname ,SUM(production_detail.qty) AS qty ,SUM(product.unit_price)AS unit_price , SUM(production_detail.a_type) AS a_type,SUM(production_detail.b_type) AS b_type FROM  product INNER JOIN production_detail
  ON product.product_id = production_detail.product_id 
  INNER JOIN product_type ON  product.ptype_id = product_type.ptype_id AND   product.ptype_id='PS'  
  INNER JOIN production_order ON  MONTH(production_order.po_enddate) ='$d[1]'  AND YEAR(production_order.po_enddate) = '$d[0]' 
  AND  production_order.po_id=production_detail.po_id  AND production_detail.status_stock='1'
   GROUP BY product.ptype_id "; 
  $result2 = mysqli_query($conn, $sql2);
  if (mysqli_num_rows($result2) > 0) {
    while ($row2 = mysqli_fetch_assoc($result2)) {
      $pro_PS[] = $row2['qty'];
    }
  }
  
  $sql_FP = "SELECT product.ptype_id AS ptype, product_type.ptype_name AS pname ,SUM(production_detail.qty) AS qty ,SUM(product.unit_price)AS unit_price , SUM(production_detail.a_type) AS a_type,SUM(production_detail.b_type) AS b_type FROM  product INNER JOIN production_detail
  ON product.product_id = production_detail.product_id 
  INNER JOIN product_type ON  product.ptype_id = product_type.ptype_id AND   product.ptype_id='FS'  
  INNER JOIN production_order ON  MONTH(production_order.po_enddate) ='$d[1]'  AND YEAR(production_order.po_enddate) = '$d[0]' 
  AND  production_order.po_id=production_detail.po_id  AND production_detail.status_stock='1'
   GROUP BY product.ptype_id  "; 
  $result_FP = mysqli_query($conn, $sql_FP);
  if (mysqli_num_rows($result_FP) > 0) {
    while ($row_FP = mysqli_fetch_assoc($result_FP)) {
      $pro_FP[] = $row_FP['qty'];
    }
  }
  $sql_CF = "SELECT product.ptype_id AS ptype, product_type.ptype_name AS pname ,SUM(production_detail.qty) AS qty ,SUM(product.unit_price)AS unit_price , SUM(production_detail.a_type) AS a_type,SUM(production_detail.b_type) AS b_type FROM  product INNER JOIN production_detail
  ON product.product_id = production_detail.product_id 
  INNER JOIN product_type ON  product.ptype_id = product_type.ptype_id AND   product.ptype_id='CF'  
  INNER JOIN production_order ON  MONTH(production_order.po_enddate) ='$d[1]'  AND YEAR(production_order.po_enddate) = '$d[0]' 
  AND  production_order.po_id=production_detail.po_id  AND production_detail.status_stock='1'
   GROUP BY product.ptype_id  "; 
  $result_CF = mysqli_query($conn, $sql_CF);
  if (mysqli_num_rows($result_CF) > 0) {
    while ($row_CF = mysqli_fetch_assoc($result_CF)) {
      $pro_CF[] = $row_CF['qty'];
    }
  }

  $sql_CO = "SELECT product.ptype_id AS ptype, product_type.ptype_name AS pname ,SUM(production_detail.qty) AS qty ,SUM(product.unit_price)AS unit_price , SUM(production_detail.a_type) AS a_type,SUM(production_detail.b_type) AS b_type FROM  product INNER JOIN production_detail
  ON product.product_id = production_detail.product_id 
  INNER JOIN product_type ON  product.ptype_id = product_type.ptype_id AND   product.ptype_id='CO'  
  INNER JOIN production_order ON  MONTH(production_order.po_enddate) ='$d[1]'  AND YEAR(production_order.po_enddate) = '$d[0]' 
  AND  production_order.po_id=production_detail.po_id  AND production_detail.status_stock='1'
   GROUP BY product.ptype_id  "; 
  $result_CO = mysqli_query($conn, $sql_CO);
  if (mysqli_num_rows($result_CO) > 0) {
    while ($row_CO = mysqli_fetch_assoc($result_CO)) {
      $pro_CO[] = $row_CO['qty'];
    }
  }

  $sql_IP = "SELECT product.ptype_id AS ptype, product_type.ptype_name AS pname ,SUM(production_detail.qty) AS qty ,SUM(product.unit_price)AS unit_price , SUM(production_detail.a_type) AS a_type,SUM(production_detail.b_type) AS b_type FROM  product INNER JOIN production_detail
  ON product.product_id = production_detail.product_id 
  INNER JOIN product_type ON  product.ptype_id = product_type.ptype_id AND   product.ptype_id='IP'  
  INNER JOIN production_order ON  MONTH(production_order.po_enddate) ='$d[1]'  AND YEAR(production_order.po_enddate) = '$d[0]' 
  AND  production_order.po_id=production_detail.po_id  AND production_detail.status_stock='1'
   GROUP BY product.ptype_id"; 
  $result_IP = mysqli_query($conn, $sql_IP);
  if (mysqli_num_rows($result_IP) > 0) {
    while ($row_IP = mysqli_fetch_assoc($result_IP)) {
      $pro_IP[] = $row_IP['qty'];
    }
  }

  $sql_BB = "SELECT product.ptype_id AS ptype, product_type.ptype_name AS pname ,SUM(production_detail.qty) AS qty ,SUM(product.unit_price)AS unit_price , SUM(production_detail.a_type) AS a_type,SUM(production_detail.b_type) AS b_type FROM  product INNER JOIN production_detail
  ON product.product_id = production_detail.product_id 
  INNER JOIN product_type ON  product.ptype_id = product_type.ptype_id AND   product.ptype_id='BB'  
  INNER JOIN production_order ON  MONTH(production_order.po_enddate) ='$d[1]'  AND YEAR(production_order.po_enddate) = '$d[0]' 
  AND  production_order.po_id=production_detail.po_id  AND production_detail.status_stock='1'
   GROUP BY product.ptype_id"; 
  $result_BB = mysqli_query($conn, $sql_BB);
  if (mysqli_num_rows($result_BB) > 0) {
    while ($row_BB = mysqli_fetch_assoc($result_BB)) {
      $pro_BB[] = $row_BB['qty'];
    }
  }

  $sql_BC = "SELECT product.ptype_id AS ptype, product_type.ptype_name AS pname ,SUM(production_detail.qty) AS qty ,SUM(product.unit_price)AS unit_price , SUM(production_detail.a_type) AS a_type,SUM(production_detail.b_type) AS b_type FROM  product INNER JOIN production_detail
  ON product.product_id = production_detail.product_id 
  INNER JOIN product_type ON  product.ptype_id = product_type.ptype_id AND   product.ptype_id='BC'  
  INNER JOIN production_order ON  MONTH(production_order.po_enddate) ='$d[1]'  AND YEAR(production_order.po_enddate) = '$d[0]' 
  AND  production_order.po_id=production_detail.po_id  AND production_detail.status_stock='1'
   GROUP BY product.ptype_id"; 
  $result_BC = mysqli_query($conn, $sql_BC);
  if (mysqli_num_rows($result_BC) > 0) {
    while ($row_BC = mysqli_fetch_assoc($result_BC)) {
      $pro_BC[] = $row_BC['qty'];
    }
  }

}}
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
          data: ["ยอดผลิต"],
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
          min: 10,
          max: 12000,
          interval: 500,
          axisLine: {
            show: false,
          },
          splitLine: {
            show: true,
            interval: "auto",
          },
        }, ],
        series: [{
          name: "ยอดผลิต:ชิ้น",
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
// 



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
          max: 4000000,
          interval: 300000,
          axisLine: {
            show: false,
          },
          splitLine: {
            show: true,
            interval: "auto",
          },
        }, ],
        series: [{
            name: "[มูลค่าการผลิต]",
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
            name: "สินค้าดี",
            data:<?= json_encode($qc_ok); ?>,
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
            name: "สินค้าชำรุด",
            data:<?= json_encode($qc_no); ?>,
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
      console.log('xx', echartElemBar);
      $(window).on("resize", function() {
        setTimeout(function() {
          echartBar.resize();
        }, 500);
      });

    }

    // ยอดขายตามประเภทสินค้า type in Dashboard version 1
    var echartElemBar = document.getElementById("ProtypechartBar");
    if (echartElemBar) {
      var echartBar = echarts.init(echartElemBar);
      echartBar.setOption({
        legend: {
          borderRadius: 0,
          orient: "horizontal",
          x: "right",
          data: ["แผ่นพื้นสำเร็จรูป", "เสารั้วลวดหนาม", "รั้วคาวบอย", "เสาตีนช้าง", "ขอบคันหิน", "แผ่นปูทางเท้า", "เสาเข็มไอ"],
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
          data: <?= json_encode($month_pro); ?>  ,
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
          max: 8000,
          interval: 500,
          axisLine: {
            show: false,
          },
          splitLine: {
            show: true,
            interval: "auto",
          },
        }, ],
        series: [{
            name: "แผ่นพื้นสำเร็จรูป",
            data: <?= json_encode($pro_PS); ?>  ,
            label: {
              show: false,
              color: "#360167",
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
            name: "เสารั้วลวดหนาม",
            data: <?= json_encode($pro_FP); ?>  ,
            label: {
              show: false,
              color: "#639",
            },
            type: "bar",
            color: "#6B0772",
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
            name: "รั้วคาวบอย",
            data: <?= json_encode($pro_CF); ?>  ,
            label: {
              show: false,
              color: "#639",
            },
            type: "bar",
            color: "#AF1281",
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
            name: "เสาตีนช้าง",
            data: <?= json_encode($pro_CO); ?>  ,
            label: {
              show: false,
              color: "#639",
            },
            type: "bar",
            color: "#CF268A",
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
            name: "ขอบคันหิน",
            data: <?= json_encode($pro_BC); ?>  ,
            label: {
              show: false,
              color: "#639",
            },
            type: "bar",
            color: "#E65C9C",
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
            name: "แผ่นปูทางเท้า",
            data: <?= json_encode($pro_BB); ?>  ,
            label: {
              show: false,
              color: "#639",
            },
            type: "bar",
            color: "#FB8CAB",
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
            name: "เสาเข็มไอ",
            data: <?= json_encode($pro_IP); ?>  ,
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
      $(window).on("resize", function() {
        setTimeout(function() {
          echartBar.resize();
        }, 500);
      });
    }
    // Chart in Dashboard version 1

    var echartElemPie = document.getElementById("echartPie");

    if (echartElemPie) {
      var echartPie = echarts.init(echartElemPie);
      echartPie.setOption({
        color: ["#62549c", "#7566b5", "#7d6cbb", "#8877bd", "#9181bd", "#6957af"],
        tooltip: {
          show: true,
          backgroundColor: "rgba(0, 0, 0, .8)",
        },
        series: [{
          name: "ยอดผลิตตามประเภทสินค้า",
          type: "pie",
          radius: "60%",
          center: ["50%", "50%"],
          data:<?=json_encode($content)?>,
           
          itemStyle: {
            emphasis: {
              shadowBlur: 10,
              shadowOffsetX: 0,
              shadowColor: "rgba(0, 0, 0, 0.5)",
            },
          },
        }, ],
      });
      $(window).on("resize", function() {
        setTimeout(function() {
          echartPie.resize();
        }, 500);
      });
    } // Chart in Dashboard version 1

    var echartElem1 = document.getElementById("echart1");

    if (echartElem1) {
      var echart1 = echarts.init(echartElem1);
      echart1.setOption(
        _objectSpread({},
          echartOptions.lineFullWidth, {}, {
            series: [
              _objectSpread({
                  data: [30, 40, 20, 50, 40, 80, 90],
                },
                echartOptions.smoothLine, {
                  markArea: {
                    label: {
                      show: true,
                    },
                  },
                  areaStyle: {
                    color: "rgba(102, 51, 153, .2)",
                    origin: "start",
                  },
                  lineStyle: {
                    color: "#8B5CF6",
                  },
                  itemStyle: {
                    color: "#8B5CF6",
                  },
                }
              ),
            ],
          }
        )
      );
      $(window).on("resize", function() {
        setTimeout(function() {
          echart1.resize();
        }, 500);
      });
    } // Chart in Dashboard version 1

    var echartElem2 = document.getElementById("echart2");

    if (echartElem2) {
      var echart2 = echarts.init(echartElem2);
      echart2.setOption(
        _objectSpread({},
          echartOptions.lineFullWidth, {}, {
            series: [
              _objectSpread({
                  data: [30, 10, 40, 10, 40, 20, 90],
                },
                echartOptions.smoothLine, {
                  markArea: {
                    label: {
                      show: true,
                    },
                  },
                  areaStyle: {
                    color: "rgba(255, 193, 7, 0.2)",
                    origin: "start",
                  },
                  lineStyle: {
                    color: "#FFC107",
                  },
                  itemStyle: {
                    color: "#FFC107",
                  },
                }
              ),
            ],
          }
        )
      );
      $(window).on("resize", function() {
        setTimeout(function() {
          echart2.resize();
        }, 500);
      });
    } // Chart in Dashboard version 1

    var echartElem3 = document.getElementById("echart3");

    if (echartElem3) {
      var echart3 = echarts.init(echartElem3);
      echart3.setOption(
        _objectSpread({},
          echartOptions.lineNoAxis, {}, {
            series: [{
              data: [
                132538.03,
                96392.00,
                40862.23,
                153829.90,
                150329.00,
                90328.34,
                219423.00,
                39429.00,
                29073.93,
                10934.20,
                29403.23,
                392843.00,
                432954.00,
                296438.00,
                593201.00,
                604329.00,
                294305.00,
                402186.00,
                395428.00,
                692384.00,
                29403.23,
                392843.00,
                432954.00,
                296438.00,
                593201.00,
                604329.00,
                294305.00,
                402186.00,
                395428.00,
                692384.00,
              ],
              lineStyle: _objectSpread({
                  color: "rgba(102, 51, 153, 0.8)",
                  width: 3,
                },
                echartOptions.lineShadow
              ),
              label: {
                show: true,
                color: "#212121",
              },
              type: "line",
              smooth: true,
              itemStyle: {
                borderColor: "rgba(102, 51, 153, 1)",
              },
            }, ],
          }
        )
      );
      $(window).on("resize", function() {
        setTimeout(function() {
          echart3.resize();
        }, 500);
      });
    }
  });
</script>