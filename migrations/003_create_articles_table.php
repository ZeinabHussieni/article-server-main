<?php 

require("../connection/connection.php");

$query = "CREATE TABLE categories (
           id INT AUTO_INCREMENT PRIMARY KEY,
           name VARCHAR(100) NOT NULL UNIQUE,
            description TEXT NOT NULL
           )";


$execute = $mysqli->prepare($query);
$execute->execute();