<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<?php

function datethai2($date1)
{
    $month_th_name = array(
        1 => "ม.ค.",
        "ก.พ.",
        "มี.ค.",
        "เม.ย.",
        "พ.ค.",
        "มิ.ย.",
        "ก.ค.",
        "ส.ค.",
        "ก.ย.",
        "ต.ค.",
        "พ.ย.",
        "ธ.ค.",
    );
    $temp = explode("-", $date1);
    if (checkdate(intval($temp[1]), intval($temp[2]), intval($temp[0]))) {
        if ($temp[2] < 10) {
            $date = substr($temp[2], -1, 1);
        } else {
            $date = $temp[2];
        }
        $year = substr(($temp[0] + 543), 2, 2);
        return $date . " " . $month_th_name[intval($temp[1])] .'&nbsp;'. $year;
    }
}
function datethai_cus($date1)
{
    $month_th_name = array(
        1 => "01",
        "02",
        "03",
        "04",
        "05",
        "06",
        "07",
        "08",
        "09",
        "10",
        "11",
        "12",
    );
    $temp = explode("-", $date1);
    if (checkdate(intval($temp[1]), intval($temp[2]), intval($temp[0]))) {
        if ($temp[2] < 10) {
            $date = substr($temp[2], -1, 1);
        } else {
            $date = $temp[2];
        }
        $year = substr(($temp[0] + 543), 2, 2);
        return  "CUS".$year.$month_th_name[intval($temp[1])];
    }
}

function datethai_order($date1)
{
    $month_th_name = array(
        1 => "01",
        "02",
        "03",
        "04",
        "05",
        "06",
        "07",
        "08",
        "09",
        "10",
        "11",
        "12",
    );
    $temp = explode("-", $date1);
    if (checkdate(intval($temp[1]), intval($temp[2]), intval($temp[0]))) {
        if ($temp[2] < 10) {
            $date = substr($temp[2], -1, 1);
        } else {
            $date = $temp[2];
        }
        $year = substr(($temp[0] + 543), 2, 2);
        return  "OR".$year.$month_th_name[intval($temp[1])];
    }
}
function datethai_po($date1)
{
    $month_th_name = array(
        1 => "01",
        "02",
        "03",
        "04",
        "05",
        "06",
        "07",
        "08",
        "09",
        "10",
        "11",
        "12",
    );
    $temp = explode("-", $date1);
    if (checkdate(intval($temp[1]), intval($temp[2]), intval($temp[0]))) {
        if ($temp[2] < 10) {
            $date = substr($temp[2], -1, 1);
        } else {
            $date = $temp[2];
        }
        $year = substr(($temp[0] + 543), 2, 2);
        return  "PO".$year.$month_th_name[intval($temp[1])];
    }
}

function datethai_qt($date1)
{
    $month_th_name = array(
        1 => "01",
        "02",
        "03",
        "04",
        "05",
        "06",
        "07",
        "08",
        "09",
        "10",
        "11",
        "12",
    );
    $temp = explode("-", $date1);
    if (checkdate(intval($temp[1]), intval($temp[2]), intval($temp[0]))) {
        if ($temp[2] < 10) {
            $date = substr($temp[2], -1, 1);
        } else {
            $date = $temp[2];
        }
        $year = substr(($temp[0] + 543), 2, 2);
        return  "QT".$year;
    }
}



function datethai_TF($date1)
{
    $month_th_name = array(
        1 => "01",
        "02",
        "03",
        "04",
        "05",
        "06",
        "07",
        "08",
        "09",
        "10",
        "11",
        "12",
    );
    $temp = explode("-", $date1);
    if (checkdate(intval($temp[1]), intval($temp[2]), intval($temp[0]))) {
        if ($temp[2] < 10) {
            $date = substr($temp[2], -1, 1);
        } else {
            $date = $temp[2];
        }
        $year = substr(($temp[0] + 543), 2, 2);
        return  "TF".$year.$month_th_name[intval($temp[1])];
    }
}


function datethai_HS($date1)
{
    $month_th_name = array(
        1 => "01",
        "02",
        "03",
        "04",
        "05",
        "06",
        "07",
        "08",
        "09",
        "10",
        "11",
        "12",
    );
    $temp = explode("-", $date1);
    if (checkdate(intval($temp[1]), intval($temp[2]), intval($temp[0]))) {
        if ($temp[2] < 10) {
            $date = substr($temp[2], -1, 1);
        } else {
            $date = $temp[2];
        }
        $year = substr(($temp[0] + 543), 2, 2);
        return  "HS".$year.$month_th_name[intval($temp[1])];
    }
}
function datethai3($date1)
{
    $month_th_name = array(
        1 => "ม.ค.",
        "ก.พ.",
        "มี.ค.",
        "เม.ย.",
        "พ.ค.",
        "มิ.ย.",
        "ก.ค.",
        "ส.ค.",
        "ก.ย.",
        "ต.ค.",
        "พ.ย.",
        "ธ.ค.",
    );
    $temp = explode("-", $date1);
  
     
        $year = substr(($temp[0] + 543), 2, 2);
        return $month_th_name[intval($temp[1])] . $year;
 
}

function datethai_RE1($date1)
{
    $month_th_name = array(
        1 => "01",
        "02",
        "03",
        "04",
        "05",
        "06",
        "07",
        "08",
        "09",
        "10",
        "11",
        "12",
    );
    $temp = explode("-", $date1);
    if (checkdate(intval($temp[1]), intval($temp[2]), intval($temp[0]))) {
        if ($temp[2] < 10) {
            $date = substr($temp[2], -1, 1);
        } else {
            $date = $temp[2];
        }
        $year = substr(($temp[0] + 543), 2, 2);
        return  "RE".$year.$month_th_name[intval($temp[1])];
    }
}

function getNumDay($d1,$d2){
    $dArr1    = preg_split("/-/", $d1);
    list($year1, $month1, $day1) = $dArr1;
    $Day1 =  mktime(0,0,0,$month1,$day1,$year1);
     
    $dArr2    = preg_split("/-/", $d2);
    list($year2, $month2, $day2) = $dArr2;
    $Day2 =  mktime(0,0,0,$month2,$day2,$year2);
     
    return round(abs( $Day2 - $Day1 ) / 86400 )+1;
    }
    function datethai_ai($date1)
    {
        $month_th_name = array(
            1 => "01",
            "02",
            "03",
            "04",
            "05",
            "06",
            "07",
            "08",
            "09",
            "10",
            "11",
            "12",
        );
        $temp = explode("-", $date1);
        if (checkdate(intval($temp[1]), intval($temp[2]), intval($temp[0]))) {
            if ($temp[2] < 10) {
                $date = substr($temp[2], -1, 1);
            } else {
                $date = $temp[2];
            }
            $year = substr(($temp[0] + 543), 2, 2);
            return  "AI".$year.$month_th_name[intval($temp[1])];
        }
    }
    
?>

<script>
function showAlert( message, alerttype ) {

$('#alert_placeholder').append( $('#alert_placeholder').append(
  '<div id="alertdiv" class="alert ' +  alerttype + '">' +
      '<a class="close" data-dismiss="alert" aria-label="close" >×</a>' +
      '<span>' + message + '</span>' + 
  '</div>' )
);

// close it in 3 secs
setTimeout( function() {
    $("#alertdiv").remove();
}, 1000 );

}
</script>
<?php error_reporting(~E_NOTICE); 
error_reporting(0);

?>