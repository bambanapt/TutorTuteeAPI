<?php

/**
 * Created by PhpStorm.
 * User: Belal
 * Date: 04/02/17
 * Time: 7:51 PM
 */
class dbConnection {
    private $conn;

    function __construct() {}

    /**
     * Establishing database connection
     * return database connection handler
     */
    function connect() {
        require_once 'constants.php';
        
        $this->conn = null;    
        
        try {
            // Connecting to mysql database
            $this->conn = new PDO("mysql:host=" . DB_HOST . ";port=8889;dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        } catch(PDOException $exception) {
             // Check for database connection error
            echo "Connection error: " . $exception->getMessage();
        }

        // // Connecting to mysql database
        // $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        // // Check for database connection error
        // if (mysqli_connect_errno()) {
        //     echo "Failed to connect to MySQL: " . mysqli_connect_error();
        // }

        // returing connection resource
        return $this->conn;
    }
}

?>