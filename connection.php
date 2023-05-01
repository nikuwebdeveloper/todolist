<?php   
    $serverName = "localhost";
    $dbName = "test";
    $username = "root";
    $password = "";

    $db = mysqli_connect($serverName, $username, $password, $dbName);
    if(!$db)
    {
        echo "<p>NO CONNECTION </p>";
        die("Connection failed: " . mysqli_connect_error());
    }
?>