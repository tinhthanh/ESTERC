<?php 
  class Orders {
    //  database  connection and table name 
       private $conn;
       private $table_name = 'orders';
     // object properties
     public $id;
     public $date_order ;
     public $name ;
     public $phone ;
     public $count;
    // constructor with $db as database 
    public function __construct($db){
        $this->conn = $db;
    }
    function create(){
 
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                date_order=:date_order, name=:name, phone=:phone, count=:count";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->date_order=htmlspecialchars(strip_tags($this->date_order));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->count=htmlspecialchars(strip_tags($this->count));
     
        // bind values
        $stmt->bindParam(":date_order", $this->date_order);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":count", $this->count);
        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
         
    }
    public function read($limit , $offset){
 
        //select all data
        $query = "SELECT
                    id, name, phone, count ,date_order
                FROM
                    " . $this->table_name . "
                ORDER BY
                date_order desc LIMIT ".$limit." OFFSET ".$offset;
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
     
        return $stmt;
    }

    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        return $row['total_rows'];
    }
  }
?>