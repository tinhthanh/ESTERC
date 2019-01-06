<?php
// required header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/orders.php';
 
// instantiate database and category object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$orders = new Orders($db);
 
// query categorys
$limit  = 5 ;
$offset = 0;

if(
     isset($_GET['limit']) &&
     isset($_GET['offset']) 
)  {
    $limit  = $_GET['limit'];
    $offset = $_GET['offset'];
}
$stmt = $orders->read($limit,$offset );
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $orders_arr=array();
    $orders_arr["records"]=array();
    $orders_arr["total"]= $orders-> count();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $order_item=array(
            "id" => $id,
            "name" => $name,
            "phone" => $phone,
            "date_order" => $date_order,
            "count" => $count
        );
 
        array_push($orders_arr["records"], $order_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show categories data in json format
    echo json_encode($orders_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no categories found
    echo json_encode(
        array("message" => "No categories found.")
    );
}
?>