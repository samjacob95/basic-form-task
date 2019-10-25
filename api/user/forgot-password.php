<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
// make sure data is not empty
if(!empty($data->email)){
 
    // set user property values
    $user->email = $data->email;
 
    // query users
    $stmt = $user->checkIfExist();
    $num = $stmt->rowCount();

    if($num > 0){
        // create the user
        if($user->send()){
        
            // set response code - 200 success
            http_response_code(200);

            // tell the user
            echo json_encode(array("message" => "Mail was sent"));
        }

        // if unable to create the user, tell the user
        else{

            // set response code - 503 service unavailable
            http_response_code(503);

            // tell the user
            echo json_encode(array("message" => "Mail was not set"));
        }
    } else {
        // set response code - 409 conflict
        http_response_code(409);

        // tell the user
        echo json_encode(array("message" => "Email does not match any data"));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Please provide an email id"));
}
?>