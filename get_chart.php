<?php
include './include/connect.php';
error_reporting(~E_NOTICE);
$datex = date('Y-m');
$d = explode("-", $datex);

$sql = "SELECT  DATE_FORMAT(dev_date,'%Y') As MyDate ,SUM(discount) AS discount ,SUM(pay_full) AS pay_full    FROM delivery  WHERE    status_chk='1' AND status_payment='1'  AND dev_date  BETWEEN NOW() - INTERVAL 2 YEAR  AND NOW() GROUP BY MyDate  ORDER BY dev_date  DESC  ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  while ($r = $result->fetch_assoc()) {
    $year = [];
    $data=[];
    $sum=[];
    $year[] = $r['MyDate'];
    // $mydate = $r['MyDate'];
    $d1 = explode("-", $r['MyDate']);
    for ($i=1; $i<=12; $i++) { 
      $last = strtotime("-$i month");
      $month_in=date('m', $last);

      $sql2 = "SELECT DATE_FORMAT(dev_date, '%Y-%m') AS MONTH ,  SUM(discount) AS discount ,SUM(pay_full) AS pay_full   FROM delivery  WHERE    status_chk='1' AND status_payment='1'  AND YEAR(dev_date) = '$r[MyDate]'  AND MONTH(dev_date) LIKE '$i'  ORDER BY MONTH DESC  "; 
      $result2 = mysqli_query($conn, $sql2);
      if (mysqli_num_rows($result2) > 0) {
        while ($row4 = mysqli_fetch_assoc($result2)) {
          $datex1 = date($row4['MONTH']);
          $d1 = explode("-", $datex1);
          $sql_cus_day = "SELECT COUNT(DISTINCT cus_id) AS month FROM delivery  WHERE   MONTH(dev_date) = '$d1[1]' AND YEAR(dev_date) = '$d1[0]' AND status_chk='1' AND status_payment='1'  ";
          $rs_cus_day = $conn->query($sql_cus_day);
          $row_cus_day = $rs_cus_day->fetch_assoc();

          $sql_dev = "SELECT COUNT(DISTINCT dev_id) AS dev FROM delivery  WHERE  MONTH(dev_date) = '$d1[1]' AND YEAR(dev_date) = '$d1[0]' AND status_chk='1' AND status_payment='1'  ";
          $rs_dev = $conn->query($sql_dev);
          $row_dev = $rs_dev->fetch_assoc();

          $sql_ai = "SELECT SUM(price)AS total  FROM ai_number  WHERE  MONTH(date_create) = '$d1[1]' AND YEAR(date_create) = '$d1[0]'   AND aix_status = '0'  ";
          $rs_ai = $conn->query($sql_ai);
          $row_ai = $rs_ai->fetch_assoc();
          // จ่ายเต็ม
          $sql_pay = "SELECT SUM(price)AS totalx  FROM ai_number  WHERE MONTH(date_create) = '$d1[1]' AND YEAR(date_create) = '$d1[0]'  AND aix_status = '1' AND pay_full='1'  ";
          $rs_pay = $conn->query($sql_pay);
          $row_pay = $rs_pay->fetch_assoc();
          // 
          $sql_sum3 = "SELECT SUM(deliver_detail.total_price) AS total  FROM delivery  INNER JOIN deliver_detail  ON  delivery.order_id=deliver_detail.order_id AND   MONTH(delivery.date_create) = '$d1[1]' AND YEAR(delivery.date_create) = '$d1[0]'  AND delivery.status_chk='1' AND delivery.dev_id=deliver_detail.dev_id   AND delivery.status_payment='1' AND delivery.cus_type='2' ";
          $rs_sum3 = $conn->query($sql_sum3);
          $row_sum3 = $rs_sum3->fetch_assoc();

          $sql_sum = "SELECT SUM(deliver_detail.total_price) AS total  FROM delivery  INNER JOIN deliver_detail  ON  delivery.order_id=deliver_detail.order_id AND  MONTH(delivery.dev_date) = '$d1[1]' AND YEAR(delivery.dev_date) = '$d1[0]'   AND delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.dev_id=deliver_detail.dev_id   AND delivery.cus_type='1' ";
          $rs_sum = $conn->query($sql_sum);
          $row_sum = $rs_sum->fetch_assoc();

          $sql_sum1 = "SELECT SUM(ai_number.price) AS price   FROM delivery  where   MONTH(delivery.dev_date) = '$d1[1]'  AND YEAR(delivery.dev_date) = '$d1[0]'  AND  ai_number.aix_status = '0' AND   delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='1' ";
          $rs_sum1 = $conn->query($sql_sum1);
          $row_sum1 = $rs_sum1->fetch_assoc();
          $sql_sum4 = "SELECT SUM(delivery.ai_count) AS ai_count FROM delivery  INNER JOIN ai_number  ON  delivery.order_id=ai_number.order_id AND  MONTH(delivery.dev_date) = '$d1[1]' AND YEAR(delivery.dev_date) = '$d1[0]'   AND delivery.ai_status = '1' AND   delivery.status_chk='1' AND delivery.status_payment='1' AND delivery.cus_type='1'";
          $rs_sum4 = $conn->query($sql_sum4);
          $row_sum4 = $rs_sum4->fetch_assoc();

          $sumx_ai = $row_sum4['ai_count'];

          $sql_refun = "SELECT SUM(price_refun)AS total  FROM  sr_number  WHERE status_refun='1' AND   MONTH(date_create) = '$d1[1]' AND YEAR(date_create) = '$d1[0]' ";
          $rs_refun = $conn->query($sql_refun);
          $row_refun = $rs_refun->fetch_assoc();
          $sum_total = $row_sum['total'] - $row4['discount'];
          $sum_ai = $sum_total -$sumx_ai- $row4['pay_full'];
          $money_in = $sum_ai + $row_ai['total']+$row_pay['totalx'] + $row_sum3['total'] - $row_refun['total'];
          if($row4['MONTH']==null){
            $sum  = 0;
          }else{ 
          $sum = $money_in  ;
        }
      }}

      $sum=$sum;


      $data[] =$sum;
    }
    // $sql2 = "SELECT  DATE_FORMAT(dev_date,'%Y-%m') As Month  FROM delivery  WHERE    status_chk='1' AND status_payment='1'  AND YEAR(dev_date) = '$r[MyDate]'  GROUP BY Month    ORDER BY Month  ASC  LIMIT 12 "; //คำสั่ง เลือกข้อมูลจากตาราง report
    // $result2 = mysqli_query($conn, $sql2);
    // if (mysqli_num_rows($result) > 0) {
    //   while ($row = mysqli_fetch_assoc($result2)) {
    //     $dx1 = explode("-", $row['Month']);
    //      if($dx1[1]==01){
    //       $data[] = $r['pay_full'];
    //      }
        
    //     $data[] = $row['Month'];
    //   }
    // }
      $json_data[] = array(
        'name' => $year,
        'data' => $data
  
      );
  }
}


// echo json_encode($json_data);
?>
<script>
  "use strict";

  $(document).ready(function() {
    // basic Line Chart
    var options = {
      chart: {
        height: 350,
        type: 'line',
        zoom: {
          enabled: false
        },
        toolbar: {
          show: true
        }
      },
      tooltip: {
        enabled: true,
        shared: true,
        followCursor: false,
        intersect: false,
        inverseOrder: false,
        custom: undefined,
        fillSeriesColor: false,
        theme: false
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth'
      },
      series: [{
        name: "Desktops",
        data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
      }],
      grid: {
        row: {
          colors: ['#f3f3f3', 'transparent'],
          // takes an array which will be repeated on columns
          opacity: 0.5
        }
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
      }
    };
    var chart = new ApexCharts(document.querySelector("#basicLine-chart"), options);
    chart.render(); // line chart with Data Label

    var options = {
      chart: {
        height: 350,
        type: 'line',
        shadow: {
          enabled: true,
          color: '#000',
          top: 18,
          left: 7,
          blur: 10,
          opacity: 1
        },
        toolbar: {
          show: false
        },
        animations: {
          enabled: true,
          easing: 'linear',
          speed: 500,
          animateGradually: {
            enabled: true,
            delay: 150
          },
          dynamicAnimation: {
            enabled: true,
            speed: 550
          }
        }
      },
      colors: ['#77B6EA', '#545454'],
      dataLabels: {
        enabled: true
      },
      stroke: {
        curve: 'smooth'
      },
      series: [{
        name: "High - 2013",
        data: [28, 29, 33, 36, 32, 32, 33]
      }, {
        name: "Low - 2013",
        data: [12, 11, 14, 18, 17, 13, 13]
      }],
      grid: {
        borderColor: '#e7e7e7',
        row: {
          colors: ['#f3f3f3', 'transparent'],
          // takes an array which will be repeated on columns
          opacity: 0.5
        }
      },
      markers: {
        size: 6
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        title: {
          text: 'Month'
        }
      },
      yaxis: {
        title: {
          text: 'Temperature'
        },
        min: 5,
        max: 40
      },
      legend: {
        position: 'top',
        horizontalAlign: 'right',
        floating: true,
        offsetY: -25,
        offsetX: -5
      }
    };
    var chart = new ApexCharts(document.querySelector("#lineChartWIthDataLabel"), options);
    chart.render(); // Zoomable timeseries line chart

    var ts2 = 1484418600000;
    var dates = [];
    var spikes = [5, -5, 3, -3, 8, -8];

    for (var i = 0; i < 120; i++) {
      ts2 = ts2 + 86400000;
      var innerArr = [ts2, dataSeries[1][i].value];
      dates.push(innerArr);
    }

    var options = {
      chart: {
        type: 'area',
        stacked: false,
        height: 350,
        zoom: {
          type: 'x',
          enabled: true
        },
        toolbar: {
          autoSelected: 'zoom'
        }
      },
      dataLabels: {
        enabled: false
      },
      series: [{
        name: 'XYZ MOTORS',
        data: dates
      }],
      markers: {
        size: 0
      },
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          inverseColors: false,
          opacityFrom: 0.5,
          opacityTo: 0,
          stops: [0, 90, 100]
        }
      },
      yaxis: {
        min: 20000000,
        max: 250000000,
        labels: {
          formatter: function formatter(val) {
            return (val / 1000000).toFixed(0);
          }
        },
        title: {
          text: 'Price'
        }
      },
      xaxis: {
        type: 'datetime'
      },
      tooltip: {
        shared: false,
        y: {
          formatter: function formatter(val) {
            return (val / 1000000).toFixed(0);
          }
        }
      }
    };
    var chart = new ApexCharts(document.querySelector("#zoomableLine-chart"), options);
    chart.render(); // gradient line chart

    var options = {
      chart: {
        height: 350,
        type: 'line',
        dropShadow: {
          enabled: true,
          top: 3,
          left: 3,
          blur: 1,
          opacity: 0.2
        }
      },
      stroke: {
        width: 7,
        curve: 'smooth'
      },
      series: [{
        name: 'Likes',
        data: [4, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5, 13, 9, 17, 2, 7, 5]
      }],
      xaxis: {
        type: 'datetime',
        categories: ['1/11/2000', '2/11/2000', '3/11/2000', '4/11/2000', '5/11/2000', '6/11/2000', '7/11/2000', '8/11/2000', '9/11/2000', '10/11/2000', '11/11/2000', '12/11/2000', '1/11/2001', '2/11/2001', '3/11/2001', '4/11/2001', '5/11/2001', '6/11/2001']
      },
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'dark',
          gradientToColors: ['#FDD835'],
          shadeIntensity: 1,
          type: 'horizontal',
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100, 100, 100]
        }
      },
      markers: {
        size: 4,
        opacity: 0.9,
        colors: ["#FFA41B"],
        strokeColor: "#fff",
        strokeWidth: 2,
        hover: {
          size: 7
        }
      },
      yaxis: {
        min: -10,
        max: 40,
        title: {
          text: 'Engagement'
        }
      }
    };
    var chart = new ApexCharts(document.querySelector("#gradientLineChart"), options);
    chart.render(); // Real time Line chart

    /*
    // this function will generate output in this format
    // data = [
        [timestamp, 23],
        [timestamp, 33],
        [timestamp, 12]
        ...
    ]
    */

    var lastDate = 0;
    var data = [];

    function getDayWiseTimeSeries(baseval, count, yrange) {
      var i = 0;

      while (i < count) {
        var x = baseval;
        var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
        data.push({
          x: x,
          y: y
        });
        lastDate = baseval;
        baseval += 86400000;
        i++;
      }
    }

    getDayWiseTimeSeries(new Date('11 Feb 2017 GMT').getTime(), 10, {
      min: 10,
      max: 90
    });

    function getNewSeries(baseval, yrange) {
      var newDate = baseval + 86400000;
      lastDate = newDate;
      data.push({
        x: newDate,
        y: Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min
      });
    }

    function resetData() {
      data = data.slice(data.length - 10, data.length);
    }

    var options = {
      chart: {
        height: 350,
        type: 'line',
        animations: {
          enabled: true,
          easing: 'linear',
          dynamicAnimation: {
            speed: 2000
          }
        },
        toolbar: {
          show: false
        },
        zoom: {
          enabled: false
        },
        dropShadow: {
          enabled: true,
          top: 3,
          left: 3,
          blur: 1,
          opacity: 0.2
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth'
      },
      series: [{
        data: data
      }],
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'dark',
          gradientToColors: ['#FDD835'],
          shadeIntensity: 1,
          type: 'horizontal',
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100, 100, 100]
        }
      },
      markers: {
        size: 0
      },
      xaxis: {
        type: 'datetime',
        range: 777600000
      },
      yaxis: {
        max: 100
      },
      legend: {
        show: false
      }
    };
    var RealTimechart = new ApexCharts(document.querySelector("#realTimeLine-chart"), options);
    RealTimechart.render();
    var dataPointsLength = 10;
    window.setInterval(function() {
      getNewSeries(lastDate, {
        min: 10,
        max: 90
      });
      RealTimechart.updateSeries([{
        data: data
      }]);
    }, 2000); // every 60 seconds, we reset the data 

    window.setInterval(function() {
      resetData();
      RealTimechart.updateSeries([{
        data: data
      }], false, true);
    }, 60000); // Dashed Line Chart

    var options = {
      chart: {
        height: 350,
        type: 'line',
        zoom: {
          enabled: false
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: [5, 7, 5],
        curve: 'smooth',
        dashArray: [0, 8, 5]
      },
      // series: [{
      //   name: "ปี 2564",
      //   data: [11, 11, 33, 44, 55, 66, 77, 88, 99, 100, 110, 110]
      // }, {
      //   name: "ปี 2565",
      //   data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
      // }],
      series: <?= json_encode($json_data); ?>,
      markers: {
        size: 0,
        hover: {
          sizeOffset: 6
        }
      },
      xaxis: {
        categories: ['ม.ค', 'ก.พ', 'มี.ค', 'เม.ย', 'พ.ค', 'มิ.ย', 'ก.ค', 'ส.ค', 'ก.ย', 'ต.ค', 'พ.ย', 'ธ.ค'],
      },
      tooltip: {
        y: [{
          title: {
            formatter: function formatter(val) {
              return val + " (ปีปัจจุบัน)";
            }
          }
        }, {
          title: {
            formatter: function formatter(val) {
              return val + " ปีก่อนหน้า";
            }
          }
        }, {
          title: {
            formatter: function formatter(val) {
              return val;
            }
          }
        }]
      },
      grid: {
        borderColor: '#f1f1f1'
      }
    };
    var chart = new ApexCharts(document.querySelector("#dashedLineChart"), options);
    chart.render(); // brush chart

    var data = generateDayWiseTimeSeries(new Date('11 Feb 2017').getTime(), 185, {
      min: 30,
      max: 90
    });
    var optionsline2 = {
      chart: {
        id: 'chart2',
        type: 'line',
        height: 230,
        toolbar: {
          autoSelected: 'pan',
          show: false
        }
      },
      colors: ['#546E7A'],
      stroke: {
        width: 3
      },
      dataLabels: {
        enabled: false
      },
      fill: {
        opacity: 1
      },
      markers: {
        size: 0
      },
      series: [{
        data: data
      }],
      xaxis: {
        type: 'datetime'
      }
    };
    var chartline2 = new ApexCharts(document.querySelector("#chart-line2"), optionsline2);
    chartline2.render();
    var options = {
      chart: {
        id: 'chart1',
        height: 130,
        type: 'area',
        brush: {
          target: 'chart2',
          enabled: true
        },
        selection: {
          enabled: true,
          xaxis: {
            min: new Date('19 Jun 2017').getTime(),
            max: new Date('14 Aug 2017').getTime()
          }
        }
      },
      colors: ['#008FFB'],
      series: [{
        data: data
      }],
      fill: {
        type: 'gradient',
        gradient: {
          opacityFrom: 0.91,
          opacityTo: 0.1
        }
      },
      xaxis: {
        type: 'datetime',
        tooltip: {
          enabled: false
        }
      },
      yaxis: {
        tickAmount: 2
      }
    };
    var chart = new ApexCharts(document.querySelector("#brushLine-chart"), options);
    chart.render();
    /*
      // this function will generate output in this format
      // data = [
          [timestamp, 23],
          [timestamp, 33],
          [timestamp, 12]
          ...
      ]
    */

    function generateDayWiseTimeSeries(baseval, count, yrange) {
      var i = 0;
      var series = [];

      while (i < count) {
        var x = baseval;
        var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
        series.push([x, y]);
        baseval += 86400000;
        i++;
      }

      return series;
    }
  });
</script>