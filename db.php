<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "obs";

    $conn = mysqli_connect($server, $username, $password, $database);
    if (!$conn) 
    {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn,"utf8");

?>