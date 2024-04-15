<?php
    $dbHost = '127.0.0.1';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'landing_page';

    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    if($conn->connect_error){
        die("404 not found " . $conn->connect_error);
    }
?>