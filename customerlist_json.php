<?php
include './include/connect.php';
error_reporting(~E_NOTICE);
error_reporting(0);
/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;


$columns = array(
                // datatable column index  => database column name
                0 => 'customer_id',
                1 => 'customer_name'
             
);

// getting total number records without any search
$sql = "SELECT * FROM customer where  status='0'  ";
$query = mysqli_query($conn, $sql) or die("");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT * FROM  customer where  status='0' ";
// $sql.=" FROM employee WHERE 1=1";
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                $sql .= " AND ( customer_id LIKE '" . $requestData['search']['value'] . "%' ";
                $sql .= " OR customer_name  LIKE '" . $requestData['search']['value'] . "%' ";
                // $sql .= " OR customer.customer_name  LIKE '" . $requestData['search']['value'] . "%' )";
                // $sql .= " OR tel  LIKE '" . $requestData['search']['value'] . "%' )";
             
}
$query = mysqli_query($conn, $sql) or die("");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn, $sql) or die("");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
                $nestedData = array();

               

             
                $nestedData[] = $row["customer_id"];
                $nestedData[] = $row["qt_id"];
           
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
