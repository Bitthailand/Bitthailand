<?php
include './include/connect.php';
include './include/config_date2.php';

$datex = date('Y-m');
$d = explode("-", $datex);

$sql = "SELECT  DATE_FORMAT(dev_date,'%Y-%m') As MyDate ,SUM(discount) AS discount ,SUM(pay_full) AS pay_full    FROM delivery  WHERE    status_chk='1' AND status_payment='1'   GROUP BY MyDate   ORDER BY MyDate ASC  LIMIT 12 "; //คำสั่ง เลือกข้อมูลจากตาราง report
$result = mysqli_query($conn, $sql);
$month = [];
$sum_all = [];
$cus_back = [];
$cus_back2 = [];
// $value = [];
if (mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)) {
    $d = explode("-", $row['MyDate']);
    $d1 = explode("-", $row['MyDate']);
    $yd = "$d[0]-$d[1]";
    $date1 = explode(" ", $yd);
    $dat1 = datethai5($date1[0]);
    $month[] = $dat1;
    // $value[] = $row['value'];

   


        $sql_dev = "SELECT COUNT(DISTINCT dev_id) AS dev FROM delivery  WHERE  MONTH(dev_date) = '$d1[1]' AND YEAR(dev_date) = '$d1[0]' AND status_chk='1' AND status_payment='1'  ";
        $rs_dev = $conn->query($sql_dev);
        $row_dev = $rs_dev->fetch_assoc();

        $sql_ai = "SELECT SUM(price)AS total  FROM ai_number  WHERE  MONTH(date_create) = '$d1[1]' AND YEAR(date_create) = '$d1[0]' AND aix_status = '0'  ";
        $rs_ai = $conn->query($sql_ai);
        $row_ai = $rs_ai->fetch_assoc();
        $sql_pay = "SELECT SUM(price)AS totalx  FROM ai_number  WHERE MONTH(date_create) = '$d1[1]' AND YEAR(date_create) = '$d1[0]'  AND aix_status = '1' AND pay_full='1'  ";
        $rs_pay = $conn->query($sql_pay);
        $row_pay = $rs_pay->fetch_assoc();
        $sql_sum3 = "SELECT SUM(deliver_detail.total_price) AS total  FROM delivery  INNER JOIN deliver_detail  ON  delivery.order_id=deliver_detail.order_id AND   MONTH(delivery.date_create) = '$d1[1]' AND YEAR(delivery.date_create) = '$d1[0]'  AND delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='2'  AND delivery.dev_id=deliver_detail.dev_id  ";
        $rs_sum3 = $conn->query($sql_sum3);
        $row_sum3 = $rs_sum3->fetch_assoc();

        $sql_sum = "SELECT SUM(deliver_detail.total_price) AS total  FROM delivery  INNER JOIN deliver_detail  ON  delivery.order_id=deliver_detail.order_id AND  MONTH(delivery.dev_date) = '$d1[1]' AND YEAR(delivery.dev_date) = '$d1[0]'   AND delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.dev_id=deliver_detail.dev_id   AND delivery.cus_type='1' ";
        $rs_sum = $conn->query($sql_sum);
        $row_sum = $rs_sum->fetch_assoc();

        $sql_sum1 = "SELECT SUM(ai_number.price) AS price   FROM delivery  INNER JOIN ai_number  ON  delivery.order_id=ai_number.order_id AND   MONTH(delivery.dev_date) = '$d1[1]'  AND YEAR(delivery.dev_date) = '$d1[0]'  AND  ai_number.aix_status = '0' AND   delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='1' ";
        $rs_sum1 = $conn->query($sql_sum1);
        $row_sum1 = $rs_sum1->fetch_assoc();
        $sql_sum4 = "SELECT SUM(delivery.ai_count) AS ai_count FROM delivery  INNER JOIN ai_number  ON  delivery.order_id=ai_number.order_id AND  MONTH(delivery.dev_date) = '$d1[1]' AND YEAR(delivery.dev_date) = '$d1[0]'   AND delivery.ai_status = '1' AND   delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='1'";
        $rs_sum4 = $conn->query($sql_sum4);
        $row_sum4 = $rs_sum4->fetch_assoc();

        $sql_refun = "SELECT SUM(price_refun)AS total  FROM  sr_number  WHERE status_refun='1' AND   MONTH(date_create) = '$d1[1]' AND YEAR(date_create) = '$d1[0]' ";
        $rs_refun = $conn->query($sql_refun);
        $row_refun = $rs_refun->fetch_assoc();

        $sumx_ai = $row_sum4['ai_count'];
        $sum_total = $row_sum['total'] - $row['discount'];
        $sum_totalz= $sum_total-$sumx_ai-$row['pay_full'];
        $sum= $sum_totalz+$row_ai['total']+$row_pay['totalx']+$row_sum3['total']-$row_refun['total'];

        // $sumx_ai = $row_sum4['ai_count'];
        // $sum_total = $row_sum['total'] - $row['discount'];
        // $sum= $sum_total- $sumx_ai+$row_ai['total']+$row_sum3['total']-$row_refun['total'];

        $sum_all[] = $sum;
        // $value[] = $row['value'];

     

    $sql3 = "SELECT  SUM(deliver_detail.total_price-delivery.discount)AS total,SUM(delivery.discount)AS discount  FROM  delivery INNER JOIN  deliver_detail
    ON  MONTH(delivery.dev_date) = '$d[1]' AND YEAR(delivery.dev_date) = '$d[0]' AND delivery.dev_id=deliver_detail.dev_id  AND  deliver_detail.status_cf='1' AND deliver_detail.payment='1' AND deliver_detail.cus_back='1' ";
    $result3 = mysqli_query($conn, $sql3);
    if (mysqli_num_rows($result3) > 0) {
      while ($row3 = mysqli_fetch_assoc($result3)) {

        // $sql_month_discount = "SELECT SUM(discount) AS month_discount FROM delivery   WHERE MONTH(date_create) = '$d[1]' AND YEAR(date_create) = '$d[0]' AND  cus_back='1'   ";
        // $rs_month_discount = $conn->query($sql_month_discount);
        // $row_month_discount = $rs_month_discount->fetch_assoc();
     
        // $SUM_MONTH=$row3['sum']-$row_month_discount['month_discount'];
        $cus_back[] = $row3['total'];
        // $value[] = $row['value'];
        //  echo json_encode($row3['sum']);
      }
    }
    $sql4 = "SELECT SUM(deliver_detail.total_price-delivery.discount)AS total,SUM(delivery.discount)AS discount  FROM  delivery INNER JOIN  deliver_detail
    ON  MONTH(delivery.dev_date) = '$d[1]' AND YEAR(delivery.dev_date) = '$d[0]' AND delivery.dev_id=deliver_detail.dev_id  AND  deliver_detail.status_cf='1' AND deliver_detail.payment='1' AND deliver_detail.cus_back='2'  ";
    $result4 = mysqli_query($conn, $sql4);
    if (mysqli_num_rows($result4) > 0) {
      while ($row4 = mysqli_fetch_assoc($result4)) {

        // $sql_month_discount = "SELECT SUM(discount) AS month_discount FROM delivery   WHERE MONTH(date_create) = '$d[1]' AND YEAR(date_create) = '$d[0]' AND  cus_back='2'   ";
        // $rs_month_discount = $conn->query($sql_month_discount);
        // $row_month_discount = $rs_month_discount->fetch_assoc();
        // $SUM_MONTH=$row4['sum']-$row_month_discount['month_discount'];
        $cus_back2[] = $row4['total'];
      }
    }
  }
}
// แบ่งตามประเภทสินค้า
$sql = "SELECT *  FROM product_type  where statusx='1'  ORDER BY  num_orderby  ASC  LIMIT 20 ";
$result = mysqli_query($conn, $sql);
$ptype = [];
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    // echo"$row[ptype_name]<br>";
    $ptype[] = $row['ptype_name'];
  }
}


// แบ่งตามประเภทสินค้า PIE
$sql = "SELECT product.ptype_id AS ptype, product_type.ptype_name AS pname ,SUM(deliver_detail.total_price) AS total FROM  product INNER JOIN deliver_detail
ON product.product_id = deliver_detail.product_id 
INNER JOIN product_type ON  product.ptype_id = product_type.ptype_id AND deliver_detail.payment='1' AND deliver_detail.status_cf='1' 
INNER JOIN  delivery ON  MONTH(delivery.dev_date) = '$d[1]' AND YEAR(delivery.dev_date) = '$d[0]' AND delivery.dev_id=deliver_detail.dev_id
GROUP BY product.ptype_id";
$result = mysqli_query($conn, $sql);
$content = [];
if (mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)) {
    // echo"$row[ptype_name]<br>";
    $content[] = [
      'name' => $row['pname'],
      'value' => $row['total']
    ];
  }
}


// วันที่ย้อนหลัง 30 วัน

$sql4 = "SELECT  DATE_FORMAT(dev_date, '%Y-%m-%d') AS dev_date ,SUM(discount) AS discount ,SUM(ai_count) AS ai_count,SUM(pay_full) AS pay_full   FROM delivery WHERE  status_chk='1' AND status_payment='1'  AND dev_date  BETWEEN NOW() - INTERVAL 30 DAY AND NOW() GROUP BY dev_date ORDER BY dev_date  DESC";
$result = mysqli_query($conn, $sql4);
$datelast = [];
$sumdate = [];
if (mysqli_num_rows($result) > 0) {
  while ($row4 = mysqli_fetch_assoc($result)) {
    
    $d = explode("-", $row4['dev_date']);
    $yd = "$d[0]-$d[1]-$d[2]";
    $date1 = explode(" ", $yd);
    $dat1 = datethai4($date1[0]);


    $d = explode("-", $row4['dev_date']);
    $sql_cus_day = "SELECT COUNT(DISTINCT cus_id) month FROM delivery  WHERE dev_date= '$row4[dev_date]' AND status_chk='1' AND status_payment='1'  ";
    $rs_cus_day = $conn->query($sql_cus_day);
    $row_cus_day = $rs_cus_day->fetch_assoc();
    $sql_dev = "SELECT COUNT(DISTINCT dev_id) dev FROM delivery  WHERE dev_date= '$row4[dev_date]' AND status_chk='1' AND status_payment='1'  ";
    $rs_dev = $conn->query($sql_dev);
    $row_dev = $rs_dev->fetch_assoc();
    $sql_ai = "SELECT SUM(price)AS total  FROM ai_number  WHERE date_create LIKE'$row4[dev_date]%'  AND aix_status = '0'  ";
    $rs_ai = $conn->query($sql_ai);
    $row_ai = $rs_ai->fetch_assoc();

    $sql_ai2 = "SELECT SUM(price)AS total  FROM ai_number  WHERE date_create LIKE'$row4[dev_date]%'  AND aix_status = '1' AND pay_full='1'  ";
    $rs_ai2 = $conn->query($sql_ai2);
    $row_ai2 = $rs_ai2->fetch_assoc();


    $sql_sum = "SELECT SUM(deliver_detail.total_price) AS total  FROM delivery  INNER JOIN deliver_detail  ON  delivery.order_id=deliver_detail.order_id AND delivery.dev_date ='$row4[dev_date]' AND delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.dev_id=deliver_detail.dev_id   AND delivery.cus_type='1' ";
    $rs_sum = $conn->query($sql_sum);
    $row_sum = $rs_sum->fetch_assoc();

    $sql_sum1 = "SELECT SUM(ai_number.price) AS price   FROM delivery  INNER JOIN ai_number  ON  delivery.order_id=ai_number.order_id AND  delivery.dev_date ='$row4[dev_date]' AND  ai_number.aix_status = '0' AND   delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='1' ";
    $rs_sum1 = $conn->query($sql_sum1);
    $row_sum1 = $rs_sum1->fetch_assoc();

    $sql_sum4 = "SELECT SUM(delivery.ai_count) AS ai_count FROM delivery  INNER JOIN ai_number  ON  delivery.order_id=ai_number.order_id AND  delivery.dev_date ='$row4[dev_date]' AND delivery.ai_status = '1' AND   delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='1'";
    $rs_sum4 = $conn->query($sql_sum4);
    $row_sum4 = $rs_sum4->fetch_assoc();

    $sumx_ai = $row_sum4['ai_count'];

    $sql_refun = "SELECT SUM(price_refun)AS total  FROM sr_number  WHERE status_refun='1' AND  date_create LIKE '$row4[dev_date]%' ";
    $rs_refun = $conn->query($sql_refun);
    $row_refun = $rs_refun->fetch_assoc();


    $sql_sum3 = "SELECT SUM(deliver_detail.total_price) AS total  FROM delivery  INNER JOIN deliver_detail  ON  delivery.order_id=deliver_detail.order_id  AND delivery.dev_id=deliver_detail.dev_id AND delivery.date_create LIKE'$row4[dev_date]%' AND delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='2' ";
    $rs_sum3 = $conn->query($sql_sum3);
    $row_sum3 = $rs_sum3->fetch_assoc();
    $sum_total = $row_sum['total'] - $row4['discount'];
    $sum_ai = $sum_total - $sumx_ai-$row4['pay_full'];
    $money_in = $sum_ai + $row_ai['total'] + $row_ai2['total'] + $row_sum3['total'] - $row_refun['total'];
    $datelast[] = $dat1;
    $sumdate[] = $money_in;
  }
}


// ผลิตย้อนหลัง 30 วัน

$sql4x = "SELECT DATE_FORMAT(po_date, '%Y-%m-%d') AS po_date  FROM  production_order  where   po_date   BETWEEN NOW() - INTERVAL 30 DAY AND NOW()  ORDER BY po_date  DESC";
$resultx = mysqli_query($conn, $sql4x);
$a = [];
$b= [];
if (mysqli_num_rows($resultx) > 0) {
  while ($row4x = mysqli_fetch_assoc($resultx)) {
    
// echo"$row4x[po_date]";
    $dat1_poxx = datethai4($row4x['po_date']);
    $sql_sum = "SELECT  SUM(product.unit_price*production_detail.qty)AS sumall  FROM production_detail INNER JOIN production_order ON production_order.po_id=production_detail.po_id
    INNER JOIN product ON production_detail.product_id=product.product_id AND    production_order.po_date  ='$row4x[po_date]'  ";
    $rs_sum = $conn->query($sql_sum);
    $row_sum = $rs_sum->fetch_assoc();
  
    $sumxx=$row_sum['sumall'];

    // echo"$sumxx";
    $a[] = $dat1_poxx;
    $b[] = $sumxx;
  }
}


$sql = "SELECT  DATE_FORMAT(date_create,'%Y-%m') As MyDate   FROM deliver_detail where status_cf='1' AND payment='1' GROUP BY MyDate   ORDER BY MyDate DESC  LIMIT 12 "; //คำสั่ง เลือกข้อมูลจากตาราง report
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
    $dat1 = datethai5($date1[0]);
    $month_pro[] = $dat1;

    $sql2 = "SELECT product.ptype_id AS ptype, product_type.ptype_name AS pname ,SUM(deliver_detail.total_price) AS total FROM  product INNER JOIN deliver_detail
  ON product.product_id = deliver_detail.product_id 
  INNER JOIN product_type ON  product.ptype_id = product_type.ptype_id AND   product.ptype_id='PS'  AND   MONTH(deliver_detail.date_create) = '$d[1]' AND YEAR(deliver_detail.date_create) = '$d[0]'  AND deliver_detail.payment='1' AND deliver_detail.status_cf='1'  GROUP BY product.ptype_id ";
    $result2 = mysqli_query($conn, $sql2);
    if (mysqli_num_rows($result2) > 0) {
      while ($row2 = mysqli_fetch_assoc($result2)) {
        $pro_PS[] = $row2['total'];
      }
    }

    $sql_FP = "SELECT product.ptype_id AS ptype, product_type.ptype_name AS pname ,SUM(deliver_detail.total_price) AS total FROM  product INNER JOIN deliver_detail
  ON product.product_id = deliver_detail.product_id 
  INNER JOIN product_type ON  product.ptype_id = product_type.ptype_id AND   product.ptype_id='FP'  AND   MONTH(deliver_detail.date_create) = '$d[1]' AND YEAR(deliver_detail.date_create) = '$d[0]' AND deliver_detail.payment='1' AND deliver_detail.status_cf='1'  GROUP BY product.ptype_id ";
    $result_FP = mysqli_query($conn, $sql_FP);
    if (mysqli_num_rows($result_FP) > 0) {
      while ($row_FP = mysqli_fetch_assoc($result_FP)) {
        $pro_FP[] = $row_FP['total'];
      }
    }
    $sql_CF = "SELECT product.ptype_id AS ptype, product_type.ptype_name AS pname ,SUM(deliver_detail.total_price) AS total FROM  product INNER JOIN deliver_detail
  ON product.product_id = deliver_detail.product_id 
  INNER JOIN product_type ON  product.ptype_id = product_type.ptype_id AND   product.ptype_id='CF'  AND   MONTH(deliver_detail.date_create) = '$d[1]' AND YEAR(deliver_detail.date_create) = '$d[0]' AND deliver_detail.payment='1' AND deliver_detail.status_cf='1'  GROUP BY product.ptype_id ";
    $result_CF = mysqli_query($conn, $sql_CF);
    if (mysqli_num_rows($result_CF) > 0) {
      while ($row_CF = mysqli_fetch_assoc($result_CF)) {
        $pro_CF[] = $row_CF['total'];
      }
    }

    $sql_CO = "SELECT product.ptype_id AS ptype, product_type.ptype_name AS pname ,SUM(deliver_detail.total_price) AS total FROM  product INNER JOIN deliver_detail
  ON product.product_id = deliver_detail.product_id 
  INNER JOIN product_type ON  product.ptype_id = product_type.ptype_id AND   product.ptype_id='CO'  AND   MONTH(deliver_detail.date_create) = '$d[1]' AND YEAR(deliver_detail.date_create) = '$d[0]' AND deliver_detail.payment='1' AND deliver_detail.status_cf='1'  GROUP BY product.ptype_id ";
    $result_CO = mysqli_query($conn, $sql_CO);
    if (mysqli_num_rows($result_CO) > 0) {
      while ($row_CO = mysqli_fetch_assoc($result_CO)) {
        $pro_CO[] = $row_CO['total'];
      }
    }

    $sql_IP = "SELECT product.ptype_id AS ptype, product_type.ptype_name AS pname ,SUM(deliver_detail.total_price) AS total FROM  product INNER JOIN deliver_detail
  ON product.product_id = deliver_detail.product_id 
  INNER JOIN product_type ON  product.ptype_id = product_type.ptype_id AND   product.ptype_id='IP'  AND   MONTH(deliver_detail.date_create) = '$d[1]' AND YEAR(deliver_detail.date_create) = '$d[0]' AND deliver_detail.payment='1' AND deliver_detail.status_cf='1'   GROUP BY product.ptype_id ";
    $result_IP = mysqli_query($conn, $sql_IP);
    if (mysqli_num_rows($result_IP) > 0) {
      while ($row_IP = mysqli_fetch_assoc($result_IP)) {
        $pro_IP[] = $row_IP['total'];
      }
    }

    $sql_BB = "SELECT product.ptype_id AS ptype, product_type.ptype_name AS pname ,SUM(deliver_detail.total_price) AS total FROM  product INNER JOIN deliver_detail
  ON product.product_id = deliver_detail.product_id 
  INNER JOIN product_type ON  product.ptype_id = product_type.ptype_id AND   product.ptype_id='BB'  AND   MONTH(deliver_detail.date_create) = '$d[1]' AND YEAR(deliver_detail.date_create) = '$d[0]' AND deliver_detail.payment='1' AND deliver_detail.status_cf='1'  GROUP BY product.ptype_id ";
    $result_BB = mysqli_query($conn, $sql_BB);
    if (mysqli_num_rows($result_BB) > 0) {
      while ($row_BB = mysqli_fetch_assoc($result_BB)) {
        $pro_BB[] = $row_BB['total'];
      }
    }

    $sql_BC = "SELECT product.ptype_id AS ptype, product_type.ptype_name AS pname ,SUM(deliver_detail.total_price) AS total FROM  product INNER JOIN deliver_detail
  ON product.product_id = deliver_detail.product_id 
  INNER JOIN product_type ON  product.ptype_id = product_type.ptype_id AND   product.ptype_id='BC'  AND   MONTH(deliver_detail.date_create) = '$d[1]' AND YEAR(deliver_detail.date_create) = '$d[0]' AND deliver_detail.payment='1' AND deliver_detail.status_cf='1'  GROUP BY product.ptype_id ";
    $result_BC = mysqli_query($conn, $sql_BC);
    if (mysqli_num_rows($result_BC) > 0) {
      while ($row_BC = mysqli_fetch_assoc($result_BC)) {
        $pro_BC[] = $row_BC['total'];
      }
    }

    $sql_PS2 = "SELECT product.ptype_id AS ptype, product_type.ptype_name AS pname ,SUM(deliver_detail.total_price) AS total FROM  product INNER JOIN deliver_detail
    ON product.product_id = deliver_detail.product_id 
    INNER JOIN product_type ON  product.ptype_id = product_type.ptype_id AND   product.ptype_id='PS2'  AND   MONTH(deliver_detail.date_create) = '$d[1]' AND YEAR(deliver_detail.date_create) = '$d[0]'  AND deliver_detail.payment='1' AND deliver_detail.status_cf='1'  GROUP BY product.ptype_id ";
      $result_PS2 = mysqli_query($conn, $sql_PS2);
      if (mysqli_num_rows($result_PS2) > 0) {
        while ($row_PS2 = mysqli_fetch_assoc($result_PS2)) {
          $pro_PS2[] = $row_PS2['total'];
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
          data: <?= json_encode($datelast); ?>,
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
          max: 500000,
          interval: 30000,
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
          data: <?= json_encode($sumdate); ?>,
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



// ยอดผลิต

var echartElemBar_po = document.getElementById("eORchartBar_po");

if (echartElemBar_po) {
  var echartBar_po = echarts.init(echartElemBar_po);
  echartBar_po.setOption({
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
      data: <?= json_encode($a); ?>,
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
      min: 50000,
      max: 1000000,
      interval: 50000,
      axisLine: {
        show: false,
      },
      splitLine: {
        show: true,
        interval: "auto",
      },
    }, ],
    series: [{
      name: "ยอดผลิต",
      data: <?= json_encode($b); ?>,
      label: {
        show: false,
        color: "#0168c1",
      },
      type: "line",
      barGap: 0,
      color: "#336699",
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
      echartBar_po.resize();
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
          max: 5000000,
          interval: 400000,
          axisLine: {
            show: false,
          },
          splitLine: {
            show: true,
            interval: "auto",
          },
        }, ],
        series: [{
            name: "[ยอดขาย]",
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
          data: <?= json_encode($ptype); ?>,
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
          data: <?= json_encode($month_pro); ?>,
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
          min: 10000,
          max: 2000000,
          interval: 100000,
          axisLine: {
            show: false,
          },
          splitLine: {
            show: true,
            interval: "auto",
          },
        }, ],
        series: [{
            name: "แผ่นพื้นสำเร็จรูป 35",
            data: <?= json_encode($pro_PS); ?>,
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
            data: <?= json_encode($pro_FP); ?>,
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
            data: <?= json_encode($pro_CF); ?>,
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
            data: <?= json_encode($pro_CO); ?>,
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
            data: <?= json_encode($pro_BC); ?>,
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
            data: <?= json_encode($pro_BB); ?>,
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
            data: <?= json_encode($pro_PS2); ?>,
            label: {
              show: false,
              color: "#659",
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
            name: "แผ่นพื้นสำเร็จรูป 30",
            data: <?= json_encode($pro_PS2); ?>,
            label: {
              show: false,
              color: "#639",
            },
            type: "bar",
            color: "#99CC99",
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
          name: "ยอดขายตามประเภทสินค้า",
          type: "pie",
          radius: "60%",
          center: ["50%", "50%"],
          data: <?= json_encode($content) ?>,

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