<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$user = new User($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
// make sure data is not empty
if(
    !empty($data->email) &&
    !empty($data->password)
){
    $user->email = $data->email;
    $user->password = $data->password;

    // query users
    $stmt = $user->login();
    
    if($stmt !== false){
        // set response code - 200 OK
        http_response_code(200);
        
        // show products data in json format
        echo json_encode(
            array("message" => "Login was succesful", "id" => $stmt)
        );
    } else {
        // set response code - 400 unauthorised credentials
        http_response_code(400);
        
        // tell the user no products found
        echo json_encode(
            array("message" => "Username/password is incorrect.")
        );
    }
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Fill the form. Data is incomplete."));
}
?>