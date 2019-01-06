<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';


// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/orders.php';
include_once '../email.php';
$database = new Database();
$email = new MainEMail();  

$db = $database->getConnection();
 
$product = new Orders($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->phone) &&
    !empty($data->name) &&
    !empty($data->count)
){
 
    // set product property values
    $product->phone = $data->phone;
    $product->count = $data->count;
    $product->name = $data->name;
    $product->date_order = date('Y-m-d H:i:s');
 
    // create the product
    if($product->create()){
       $email->sendMail($product->name , $product->phone , $product->count);

        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Product was created."));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create product."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}
?>