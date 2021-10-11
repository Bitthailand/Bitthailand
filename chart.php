<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>เซ็ค</title>
</head>
<body>
<?PHP
$file="C:\Users\\1000273853\Desktop\\datatest.txt"; //อ่านจากไฟล์txt
$num1=$num2=$num3=$num4=$num5=$num6=$num7=$num8=$num9=$num10=$num11=$num12=$num13=$num14=$num15=$num16=$num17=$num18=$num19=$num20=$num21=$num22=$num23=$num24=$num25= array(); //สร้างที่เก็บ array
$file_array=file($file);//อ่านไฟล์เข้ามา
$i = 0;
$strnum ="";
foreach ($file_array as $mini){//อ่านทีละบรรทัด
//$strnum.="[".$mini[$num1].",".$mini[$num18]."],";
list($num1[$i],$num2[$i],$num3[$i],$num4[$i],$num5[$i],$num6[$i],$num7[$i],$num8[$i],$num9[$i],$num10[$i],$num11[$i],$num12[$i],$num13[$i],$num14[$i],$num15[$i],$num16[$i],$num17[$i],$num18[$i],$num19[$i],$num20[$i],$num21[$i],$num22[$i],$num23[$i],$num24[$i],$num25[$i]) = explode(',', substr($mini,0)); //กำหนดบรรทัด array
$num1[$i] = intval(substr($num1[$i],8));
$num18[$i] = intval($num18[$i]);
$num19[$i] = intval($num19[$i]);
$num20[$i] = intval($num20[$i]);
$num21[$i] = intval($num21[$i]);
$num22[$i] = intval($num22[$i]);
//echo "<pre>";
//echo "num1 = " ; echo intval($num18[$i]); echo "<td>,";
//echo "num2 = " ; echo intval($num19[$i]); echo "<td>,";
//echo "num3 = " ; echo intval($num20[$i]); echo "<td>,";
//echo "num4 = " ; echo intval($num21[$i]); echo "<td>,";
//echo "num5 = " ; echo intval($num22[$i]); echo "</pre>";
$i++;
}


?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {'packages':['line']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

var data = new google.visualization.DataTable();
data.addColumn('number', 'วันที่');
data.addColumn('number', 'num1');
data.addColumn('number', 'num2');
data.addColumn('number', 'num3');
data.addColumn('number', 'num4');
data.addColumn('number', 'num5');

data.addRows([
[1,12,23,34,5,13],
[2,12,22,53,3,12],
[3,12,26,43,5,13],
[4,12,23,43,5,13],
[5,12,22,53,3,15],
[6,14,23,44,5,13],
[7,12,22,53,4,12],
[8,12,32,44,5,13],
[9,12,22,53,3,12],
[10,12,32,44,5,13],
[11,12,22,53,3,12],
[12,12,22,44,5,13],
[13,12,22,54,3,12],
[14,13,32,43,5,13],
[15,12,22,53,3,12],
[16,12,32,43,5,13],
[17,12,22,23,4,12],
[18,12,32,34,5,13],
[19,16,22,35,3,15],
[20,12,32,34,5,13],
[21,14,22,53,3,12],
[22,12,32,43,5,13],
[23,12,22,53,3,12]

]);

var options = {
chart: {
title: 'กราฟ',

},
width: 800,
height: 400,
axes: {
x: {
0: {side: 'button'}
}
}
};

var chart = new google.charts.Line(document.getElementById('line_top_x'));

chart.draw(data, google.charts.Line.convertOptions(options));
}
</script>
</head>
<body>
<div id="line_top_x"></div>
</body>
<?php


$file = fopen('C:\Users\\1000273853\Desktop\\text.txt','w+') or die("Unable to open file!");

$str = implode(',', $num18);



fwrite($file,$str);
fclose($file);

unset($file_array) ; echo '<pre>'; //กำหนดแสดง
echo 'num0 = '; echo implode(',', $num1); echo '<br>';
echo 'num1 = '; echo implode(',', $num18); echo '<br>';
echo 'num2 = '; echo implode(',', $num19); echo '<br>';
echo 'num3 = '; echo implode(',', $num20); echo '<br>';
echo 'num4 = '; echo implode(',', $num21); echo '<br>';
echo 'num5 = '; echo implode(',', $num22); echo '</pre>';

?>
</html>