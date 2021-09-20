<?php
include './include/connect.php';
error_reporting(~E_NOTICE);
error_reporting(0);
/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;


$columns = array(
                // datatable column index  => database column name
                0 => 'date_create',
                1 => 'order_id',
                2 => 'qt_id',
                3 => 'cus_id'
);

// getting total number records without any search
$sql = "SELECT * FROM orders where status='0'   AND status_button='1'   ";
$query = mysqli_query($conn, $sql) or die("");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT * FROM orders  where status='0' AND status_button='1'";
// $sql.=" FROM employee WHERE 1=1";
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                $sql .= " AND ( order_id LIKE '" . $requestData['search']['value'] . "%' ";
                $sql .= " OR qt_id  LIKE '" . $requestData['search']['value'] . "%' ";
                $sql .= " OR cus_id  LIKE '" . $requestData['search']['value'] . "%' )";
                }
$query = mysqli_query($conn, $sql) or die("");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql .= "ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
$query = mysqli_query($conn, $sql) or die("");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
                $nestedData = array();
echo"$row[0]";
               

                $nestedData[] =  $dat;
                $nestedData[] = $row["order_id"];
                $nestedData[] = $row["qt_id"];
                $nestedData[] = $row2['name'];
                $nestedData[] = $cus_name;
                $nestedData[] = $tel;
                $nestedData[] = $row_am['name_th'];
                $nestedData[] = $row_provin['name_th'];
                $nestedData[] ="<a class='btn btn-outline-success btn-sm line-height-1' title='TIME LINE' href='/ordertimeline.php?order_id=$row[order_id]' target='_blank'> <i class='i-File font-weight-bold'></i></a>";
              
                $data[] = $nestedData;
}



$json_data = array(
                "draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                "recordsTotal"    => intval($totalData),  // total number of records
                "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
                "data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format


