<?php
#This file was created on 28-OCT-2018  :  10:36pm CAT
#Author: Ohuoba Chimaraoke
#File name: Datacontrol.php
#File type: PHP
#Description:
/*The purpose of this script is to connect to database and control the reading and writing
of data to the database */


define('USERS', 'users');
define('USERNAME', 'username');
define('FIRSTNAME', 'firstname');
define('LASTNAME', 'lasttname');
define('EMAIL', 'email');
define('PASSWORD', 'password');
define('PHOTO', 'photo_url');
define('br','<br>');



class database{
    /*
    this class was written to handle all requests to a specific database, just make sure you pass in
    the Database name to the constructor while instantiating the object

    */

    protected $dbName;
    protected $conn;
    protected $connectionStatus;




    function __construct($db){

        #constructor
        $servername = "localhost" ;
        $username = "root" ;
        $password = "" ;
        $this->dbName = $db;

        #create a Mysqli connection
        $this->conn = new mysqli($servername, $username, $password, $this->dbName);
        if($this->conn->connect_error){
            #failed to connect to database
            $this->connectionStatus = FALSE;
            //die ("Failed to connect to database: ".$this->conn->connect_error);
        }else{
            #connected to database successfully
            $this->connectionStatus = TRUE;

        }

    }

    #----------Getter Functions
    function getConn(){
        #this function returns an instance of the database connection created
        return $this->conn;
    }

    function getConnStatus(){
        #returns TRUE if connection was successful, or returns FALSE if connection was not sucessful
        return $this->connectionStatus;
    }

    function getDBname(){
        #this function returns the name of the database passed when instantiating the object
        return $this->dbName;

    }




    #--------DATABASE data input functions
    function insertUsers($username, $firstname, $lastname, $email, $mobile, $password, $photo_url){
        #this function inserts a row of data into the users table in the database
        $sql="INSERT INTO users (username, firstname, lastname, email, mobile, password, photo_url)
        VALUES(?,?,?,?,?,?,?)" ;
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssss", $username, $firstname, $lastname, $email, $mobile, $password, $photo_url);
        $stmt->execute();

    }

    function updateUsers($column, $newValue, $whereArg, $whereClause){
        #this function updates a single colume of record in a table in a database
        $sql = "UPDATE users SET $column='$newValue' WHERE $whereArg=$whereClause" ;
        var_dump($this->conn);
        if($this->conn->query($sql) == TRUE){
            return TRUE;
        }else{
            return FALSE;
        }

    }

    function insertItems($name, $votes, $photo_url, $creator, $category, $item_group){
        #this function inserts a row of data into the users table in the database
        $sql="INSERT INTO items (name, votes, photo_url, creator, category, item_group)
        VALUES('$name', '$votes', '$photo_url', '$creator', '$category', '$item_group')" ;
        if($this->conn->query($sql)){
            echo "success";
            return TRUE;
        }else{
            echo $this->conn->error;
            return FALSE;
        }

    }

    function insertPosts($name, $votes, $creator, $photo_url, $category){
        #this function inserts a row of data into the users table in the database
        $sql="INSERT INTO posts (name, votes, creator, photo_url, category)
        VALUES('$name', '$votes', '$creator', '$photo_url', '$category')" ;
        if($this->conn->query($sql)){
            echo "success";
            return TRUE;
        }else{
            echo $this->conn->error;
            return FALSE;
        }

    }

    function updateRecord($table, $column, $newValue, $whereArg, $whereClause){
        #this function updates a single colume of record in a table in a database
        $sql = "UPDATE $table SET $column='$newValue' WHERE $whereArg=$whereClause" ;
        if($this->conn->query($sql) == TRUE){
            return TRUE;
        }else{
            return FALSE;
        }

    }



    public function getRecord($table, $column, $whereArg, $whereClause){
        #this function reads and returns a column of data from a table in the database
        $sql = "SELECT $column FROM $table WHERE $whereArg='$whereClause'";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            return $result->fetch_assoc()[$column];
        }else{
            return NULL;
        }
    }

    function getRecordRow($table, $whereArg, $whereClause){
        #this function reads and returns a column of data from a table in the database
        $sql = "SELECT * FROM $table WHERE $whereArg='$whereClause'";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            return $result->fetch_assoc();
        }else{
            return NULL;
        }
    }

    function getMultipleRecords($table, $whereArg, $whereClause){
        $records = Array();
        $count = 0;
        $sql = "SELECT * FROM $table WHERE $whereArg='$whereClause'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $records[$count] = $row;
                $count++;
            }
            return $records;

        }else {
            return NULL;
        }

    }

    function deleteRecord($table, $whereArg, $whereClause){
        $sql = "DELETE FROM $table WHERE $whereArg='$whereClause'";
        if($this->conn->query($sql) == TRUE){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function parseInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }




}

/*
$baseData = new database("thehub");
$vote = $baseData->getRecord('items', 'votes', 'id', 2);
$vote++; #increment the votes
$success = $baseData->updateRecord('items', 'votes', $vote, 'id', 2);
if ($success){
    echo 'voted ';
}else {
     echo 'error voting';
}
*/




?>