<?php
include './include/connect.php';
error_reporting(~E_NOTICE);
error_reporting(0);
/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;

$table = 'orders';

// Table's primary key
$primaryKey = 'id';
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
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn, $sql) or die("");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
                $nestedData = array();

                $sql2 = "SELECT * FROM customer_type WHERE id= '$row[cus_type]'";
                $rs2 = $conn->query($sql2);
                $row2 = $rs2->fetch_assoc();
                // ====
                $sql3 = "SELECT * FROM customer WHERE customer_id= '$row[cus_id]'";
                $rs3 = $conn->query($sql3);
                $row3 = $rs3->fetch_assoc();
                $date = explode(" ", $row['date_create']);
                $dat = datethai2($date[0]);
                $cus_name = iconv_substr($row3['customer_name'], 0, 30, 'UTF-8');
                $tel = substr($row3['tel'], 0, 12);
                $sql_am = "SELECT * FROM amphures   WHERE id= '$row3[district]'";
                $rs_am = $conn->query($sql_am);
                $row_am = $rs_am->fetch_assoc();
                $sql_provin= "SELECT * FROM provinces WHERE id= '$row3[province]'";
                $rs_provin = $conn->query($sql_provin);
                $row_provin = $rs_provin->fetch_assoc();

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
