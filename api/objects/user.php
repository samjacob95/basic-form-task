<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $id;
    public $name;
    public $password;
    public $email;
    public $created;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read users
    function login(){

        $this->email=htmlspecialchars(strip_tags($this->email));
       $this->password=htmlspecialchars(strip_tags($this->password));
        
       //Checking is user existing in the database or not
           $query = "SELECT * FROM ".$this->table_name." WHERE email=:email
       and password=:password";

       // prepare query statement
       $stmt = $this->conn->prepare($query);

       $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
       $stmt->bindValue(':password', md5($this->password), PDO::PARAM_STR);
    
        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();

        if($num >= 1) {
            session_start();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['logged_in'] = true;
            $_SESSION['cust_id'] = $rows[0]['id'];
            return $rows[0]['id'];
        }
        return false;
    }

    // create user
    function create(){
    
       // query to insert record
       $query = 'INSERT INTO
       ' . $this->table_name . ' (username, email, password, trn_date)
        VALUES (:name, :email, :password, :trn_date)';
        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->created=htmlspecialchars(strip_tags($this->created));
        // bind values
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindValue(':password', md5($this->password), PDO::PARAM_STR);
        $stmt->bindParam(":trn_date", $this->created, PDO::PARAM_STR);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
       // print_r($stmt->errorInfo());

        return false;
        
    }

    // check duplicate 
    function checkIfExist(){
    
        // query to insert record
        $query = "SELECT email FROM
                    " . $this->table_name . " WHERE email=:email";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->email=htmlspecialchars(strip_tags($this->email));
    
        // bind values
        $stmt->bindParam(":email", $this->email);
    
       // execute query
       $stmt->execute();
    
       return $stmt;
        
    }

    function send(){

        $expFormat = mktime(
            date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
            );
            $expDate = date("Y-m-d H:i:s",$expFormat);
            $key = md5(2418*2+$email);
            $addKey = substr(md5(uniqid(rand(),1)),3,10);
            $key = $key . $addKey;
         // Insert Temp Table
         $query = 
         "INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`)
         VALUES (:email, :key, :expDate)";

          // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->email=htmlspecialchars(strip_tags($this->email));
    
        // bind values
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":key", $key);
        $stmt->bindParam(":expDate", $expDate);
    
       // execute query
       $stmt->execute();
    
            $output = "
            <html>
            <head>
            </head>
            <body>
                <center><h2><b>Forgot Password Mail</b></h2></center><br><p>Dear, <br>
                You have received this mail because you have registered with us and you have clicked the forgot password option:-<br>";
            $output.='<p>Please click on the following link to reset your password.</p>';
            $output.='<p>-------------------------------------------------------------</p>';
            $output.='<p><a href="https://www.allphptricks.com/frontend/reset-password.php?
            key='.$key.'&email='.$this->email.' target="_blank">
            https://www.allphptricks.com/frontend/reset-password.php
            ?key='.$key.'&email='.$this->email.'</a></p>'; 
            $output.='<p>-------------------------------------------------------------</p>';
            $output.='<p>Please be sure to copy the entire link into your browser.
            The link will expire after 1 day for security reason.</p>';
            $output.='<p>If you did not request this forgotten password email, no action 
            is needed, your password will not be reset. However, you may want to log into 
            your account and change your security password as someone may have guessed it.</p>';   
            $output.='<p>Thanks,</p>';
            $output.= "</body>
                </html>";
                $body = $output;
                $from ='forgotpassword@abc.com';
                $subject = "Forgot Password mail for ".$email."";
                $server=$_SERVER['HTTP_HOST'];
                $headers = "From: ABC<".$from. ">\r\nContent-type: text/html; charset=iso-8859-1\r\nMIME-Version: 1.0\r\n";
                $to = $this->email;
                $send_email = mail($to, $subject, $body, $headers);
                return $send_email;
    }
}
?>