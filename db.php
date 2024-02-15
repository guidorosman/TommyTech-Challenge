<?php

include "config.php";

try {
    $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
    
    if ($conn->connect_error) {
        throw new Exception("Connection error: " . $conn->connect_error);
    }
} catch (Exception $e) {
    echo "Error connecting to database: " . $e->getMessage();
}
?>