<?php 

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "med";

    // Create Connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    try {
        $db = new PDO("mysql:host={$servername}; dbname={$dbname}", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOEXCEPTION $e) {
        $e->getMessage();
    }

?>