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
if(
    !empty($data->name) &&
    !empty($data->email) &&
    !empty($data->password) &&
    !empty($data->confirm_password)
){
 
    // set user property values
    $user->name = $data->name;
    $user->email = $data->email;
    $user->password = $data->password;
    $user->created = date('Y-m-d H:i:s');
 
    // query users
    $stmt = $user->checkIfExist();
    $num = $stmt->rowCount();

    if($num == 0){
        // create the user
        if($user->create()){
        
            // set response code - 201 created
            http_response_code(201);

            // tell the user
            echo json_encode(array("message" => "User was created."));
        }

        // if unable to create the user, tell the user
        else{

            // set response code - 503 service unavailable
            http_response_code(503);

            // tell the user
            echo json_encode(array("message" => "Unable to create user."));
        }
    } else {
        // set response code - 409 conflict
        http_response_code(409);

        // tell the user
        echo json_encode(array("message" => "Email already exists"));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create user. Data is incomplete."));
}
?>