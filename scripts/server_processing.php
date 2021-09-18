<?php

$table = 'orders';

// Table's primary key
$primaryKey = 'id';

$columns = array(
	array('db' => '`ORD`.`date_create`', 'dt' => 0, 'field' => 'date_create', 'formatter' => function ($d, $row) {
		return date('Y-m-d', strtotime($d));
	}),
	array('db' => '`ORD`.`order_id`', 'dt' => 1, 'field' => 'order_id'),
	array('db' => '`ORD`.`qt_id`',  'dt' => 2, 'field' => 'qt_id'),
	array('db' => '`CT`.`name`',  'dt' => 3, 'field' => 'name'),
	array('db' => '`CUS`.`customer_name`',  'dt' => 4, 'field' => 'customer_name'),
	array('db' => '`CUS`.`tel`',  'dt' => 5, 'field' => 'tel'),
	// array('db' => '`AMP`.`name_th`',  'dt' => 6, 'field' => 'name_th'),
	
	
);

// SQL server connection information
require('config.php');
$sql_details = array(
	'user' => $db_username,
	'pass' => $db_password,
	'db'   => $db_name,
	'host' => $db_host
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

// require( 'ssp.class.php' );
require('ssp.customized.class.php');

$joinQuery = "FROM `orders` AS `ORD` INNER JOIN `customer` AS `CUS` ON (`CUS`.`customer_id` = `ORD`.`cus_id`)
INNER JOIN customer_type AS CT ON (CT.id=ORD.cus_type)

";
// $extraWhere = "`u`.`salary` >= 90000";
// $groupBy = "`u`.`office`";
// $having = "`u`.`salary` >= 140000";

echo json_encode(
	SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery)
);
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
                                return $date . " " . $month_th_name[intval($temp[1])] . '&nbsp;' . $year;
                }
}
