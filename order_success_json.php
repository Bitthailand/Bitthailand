<?php
include './include/connect.php';
error_reporting(~E_NOTICE);
error_reporting(0);
/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;


$columns = array(
                // datatable column index  => database column name
                0 => 'orders.date_create',
                1 => 'orders.order_id',
                2 => 'orders.qt_id',
                3 => 'customer.customer_name',
                4 => 'customer.tel'
);

// getting total number records without any search
$sql = "SELECT * FROM orders JOIN customer ON  orders.cus_id=customer.customer_id   AND orders.order_status='5'    ";
$query = mysqli_query($conn, $sql) or die("");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT * FROM  orders JOIN customer ON  orders.cus_id=customer.customer_id  AND orders.order_status='5'  ";
// $sql.=" FROM employee WHERE 1=1";
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                $sql .= " AND ( orders.order_id LIKE '" . $requestData['search']['value'] . "%' ";
                $sql .= " OR orders.qt_id  LIKE '" . $requestData['search']['value'] . "%' ";
                $sql .= " OR customer.customer_name  LIKE '" . $requestData['search']['value'] . "%' )";
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
                $sqlcb = "SELECT * FROM customer_back WHERE id= '$row[cus_back]'";
                $rscb = $conn->query($sqlcb);
                $rowcb = $rscb->fetch_assoc();
                $sql2 = "SELECT * FROM customer_type WHERE id= '$row[cus_type]'";
                $rs2 = $conn->query($sql2);
                $row2 = $rs2->fetch_assoc();
                $ai_count=number_format($row['ai_count'], '2', '.', ',');
                $sqlx4 = "SELECT SUM(total_price) AS total FROM order_details  WHERE order_id= '$row[order_id]'";
                $rsx4 = $conn->query($sqlx4);
                $rowx4 = $rsx4->fetch_assoc();
                $sub_total = $rowx4['total'] - $row['discount'];
                $sub_total_ai=$sub_total-$row['ai_count'];
                $first_total = ($sub_total_ai * 100) / 107;
                $tax = ($sub_total_ai - $first_total);
                $grand_total = ($sub_total_ai - $tax);
                $grand_total_all=($grand_total + $tax);
                $grand_total=number_format($grand_total, '2', '.', ',');
                $taxx=number_format($tax, '2', '.', ',');
                $grand_total_all=number_format($grand_total_all, '2', '.', ',');
                $sqlx5 = "SELECT COUNT(*)  AS sum  FROM delivery  WHERE order_id= '$row[order_id]'";
                $rsx5 = $conn->query($sqlx5);
                $rowx5 = $rsx5->fetch_assoc();
   
                $nestedData[] =  $dat;
                $nestedData[] = $row["order_id"];
                $nestedData[] = $row2['name'];
                $nestedData[] = $rowcb['name'] ;
                $nestedData[] = $cus_name;
                $nestedData[] = $tel;
                $nestedData[] = $row_am['name_th'];
                $nestedData[] = $row_provin['name_th'];
                $nestedData[] = $ai_count;
                $nestedData[] = $grand_total;
                $nestedData[] = $taxx;
                $nestedData[] = $grand_total_all;
                if ($rowx5['sum'] == 1) {
                $nestedData[] ="<a class='btn btn-outline-info btn-sm line-height-1'  title='ใบเสร็จรับเงิน' href='/hs.php?order_id=$row[order_id]&so_id=$row[dev_id]' target='_blank'> <i class='i-File font-weight-bold'></i></a>
                <a class='btn btn-outline-success btn-sm line-height-1' title='คืนสินค้า' href='/refun.php?order_id=$row[order_id]&so_id=$row[dev_id]' target='_blank'> <i class='i-Repeat-2 font-weight-bold'></i></a>";                
               } else{
                $nestedData[] ="<a class='btn btn-outline-info btn-sm line-height-1'  title='ใบเสร็จรับเงิน' href='/hs_all.php?order_id=$row[order_id] target='_blank'> <i class='i-File font-weight-bold'></i></a>
                <a class='btn btn-outline-success btn-sm line-height-1' title='คืนสินค้า' href='/refun.php?order_id=$row[order_id]&so_id=$row[dev_id]' target='_blank'> <i class='i-Repeat-2 font-weight-bold'></i></a>";                
               }
               if($emp_id=='noom'||$emp_id=='admin'){
               $nestedData[] = "<a class='btn btn-outline-success btn-sm line-height-1'  title='แก้ข้ข้อมูล Order' href='/editorder_final.php?order_id=$row[order_id]'> <i class='i-Check font-weight-bold'></i></a>";
                }else{
                $nestedData[] =  '';         
                }
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
