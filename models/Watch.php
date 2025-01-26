<?php
require_once "../config/Db.php";
class Watch{

    private $conn;
    private $table = 'watches';
    public $user_id;
    public $name;
    public $description;
    public $location;
    public $condition;
    public $price;

    public function __construct($db, $user_id, $name, $description, $condition, $price){  
        $this->user_id = $user_id;  
        $this->name = $name;    
        $this->description = $description;  
        $this->condition = $condition;
        $this->price = $price;
        $this->conn = $db->connect();
    }

    public function upload(){
        if (strlen($this->name) < 3 || strlen($this->name) > 50) {
            return "Name must be between 3 and 50 characters.";
        }
        $sql = "INSERT INTO ". $this->table ."( user_id, name, description, wcondition, price) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $res = $stmt->execute([$this->user_id, $this->name, $this->description, $this->condition, $this->price]); 
        if($res){
            true;
        }else{
            return "Error: " . $stmt->errorInfo()[2];
        }
    }
}