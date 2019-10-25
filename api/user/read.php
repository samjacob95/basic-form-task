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
include_once '../objects/requests.php';
 
$database = new Database();
$db = $database->getConnection();
 
$request = new Requests($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
// make sure data is not empty
if(!empty($data->id)){
        // set user property values
        $request->id = $data->id;

        if($stmt = $request->readOne()){
            
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // set response code - 201 created
            http_response_code(201);
            // tell the user
            echo json_encode(array("data" => $rows));
            

        
        } else {
            // set response code - 409 conflict
            http_response_code(409);

            // tell the user
            echo json_encode(array("message" => "Error Occured while processing"));
        }
}
    // tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to process. Data is incomplete."));
}
?>