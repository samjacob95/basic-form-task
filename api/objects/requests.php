<?php
class Requests{
 
    // database connection and table name
    private $conn;
    private $table_name = "requests";
 
    // object properties
    public $id;
    public $title;
    public $category;
    public $initiator;
    public $initiator_email;
    public $assignee;
    public $priority;
    public $status;
    public $created_date;
    public $user_id;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read users
    function readALL(){
        
       //Checking is user existing in the database or not
           $query = "SELECT * FROM ".$this->table_name;

       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
       
        return $stmt;
    }

    // create user
    function create(){
    
       // query to insert record
       $query = 'INSERT INTO
       ' . $this->table_name . ' (title, category, initiator, initiator_email, assignee, priority, status, created_date, user_id)
        VALUES (:title, :category, :initiator, :initiator_email, :assignee, :priority, :status, :created_date, :user_id)';
        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->category=htmlspecialchars(strip_tags($this->category));
        $this->initiator=htmlspecialchars(strip_tags($this->initiator));
        $this->initiator_email=htmlspecialchars(strip_tags($this->initiator_email));
        $this->assignee=htmlspecialchars(strip_tags($this->assignee));
        $this->priority=htmlspecialchars(strip_tags($this->priority));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->created_date=htmlspecialchars(strip_tags($this->created_date));
        // bind values
        $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
        $stmt->bindValue(':category', $this->category, PDO::PARAM_STR);
        $stmt->bindValue(':initiator', $this->initiator, PDO::PARAM_STR);
        $stmt->bindParam(":initiator_email", $this->initiator_email, PDO::PARAM_STR);
        $stmt->bindParam(":assignee", $this->assignee, PDO::PARAM_STR);
        $stmt->bindParam(":priority", $this->priority, PDO::PARAM_STR);
        $stmt->bindParam(":status", $this->status, PDO::PARAM_STR);
        $stmt->bindParam(":created_date", $this->created_date, PDO::PARAM_STR);
        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
        //print_r($stmt->errorInfo());

        return false;
        
    }

    // check duplicate 
    function readOne(){
    
        // query to insert record
        $query = "SELECT * FROM
                    " . $this->table_name . " WHERE id=:id";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind values
        $stmt->bindParam(":id", $this->id);
    
       // execute query
       $stmt->execute();
    
       return $stmt;
        
    }
}
?>