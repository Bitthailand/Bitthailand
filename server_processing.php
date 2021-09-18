<?php

$table = 'orders';
// Table's primary key
$primaryKey = 'id';
$columns = array(
	array( 'db' => 'order_id', 'dt' => 0, 'field' => 'order_id' )
																return '$'.number_format($d);
															})
);

// SQL server connection information
include './include/connect.php';
$sql_details = array(
	'user' => $user,
	'pass' => $password,
	'db'   => $dbname,
	'host' => $host
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );

$joinQuery = "FROM orders";
// $extraWhere = "`u`.`salary` >= 90000";
// $groupBy = "`u`.`office`";
// $having = "`u`.`salary` >= 140000";

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery )
);
