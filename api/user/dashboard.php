<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/requests.php';
 
$database = new Database();
$db = $database->getConnection();
 
$request = new Requests($db);
 
    // query users
    $stmt = $request->readAll();
    $num = $stmt->rowCount();

    if($num > 0){
        
        
            // set response code - 201 created
            http_response_code(201);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // tell the user
            echo json_encode(array("data" => $rows));
        

       
    } else {
        // set response code - 409 conflict
        http_response_code(200);

        // tell the user
        echo json_encode(array("message" => "No data to display"));
    }
?>