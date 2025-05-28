<?php
    $host = "localhost";
    $name = "root";
    $password = "";
    $dbName = "dbhotelre";

    // Creating a connection
    $conn = new mysqli($host,$name,$password,$dbName);

    if($conn->connect_error){
        die("Connection Failed". $conn->connect_error);
    }
?>