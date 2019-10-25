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
if(
    !empty($data->title) &&
    !empty($data->category) &&
    !empty($data->initiator) &&
    !empty($data->initiator_email) &&
    !empty($data->assignee) &&
    !empty($data->priority) &&
    !empty($data->status) &&
    !empty($data->created_date)
){
    if(!empty($data->user_id)){
        // set user property values
        $request->title = $data->title;
        $request->category = $data->category;
        $request->initiator = $data->initiator;
        $request->initiator_email = $data->initiator_email;
        $request->assignee = $data->assignee;
        $request->priority = $data->priority;
        $request->status = $data->status;
        $request->user_id = $data->user_id;
        $request->created_date = date('Y-m-d H:i:s');

        if($request->create()){
            
            
                // set response code - 201 created
                http_response_code(201);
                // tell the user
                echo json_encode(array("message" => "Data was updated successfully"));
            

        
        } else {
            // set response code - 409 conflict
            http_response_code(200);

            // tell the user
            echo json_encode(array("message" => "Error Occured while processing"));
        }
    }
    // tell the user data is incomplete
    else{
    
        // set response code - 400 bad request
        http_response_code(400);
    
        // tell the user
        echo json_encode(array("message" => "You are not authorised for this action"));
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