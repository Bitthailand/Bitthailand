<?php
function datethai_so($date1)
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
        return  "SO".$year;
    }
}
function datethai_HS1($date1)
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

function datethai_IV($date1)
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
        return  "IV".$year.$month_th_name[intval($temp[1])];
    }
}
function datethai_BI($date1)
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
        return  "BI".$year.$month_th_name[intval($temp[1])];
    }
}

function datethai_RE($date1)
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


function datethai_SR($date1)
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
?>