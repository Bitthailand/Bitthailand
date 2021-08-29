<?php

function datethai4($date1)
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
        return $date . " " . $month_th_name[intval($temp[1])] . $year;
    }
}
function datethai5($date1)
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
?>