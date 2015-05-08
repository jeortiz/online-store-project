<?php

$mysqli = new mysqli($hostname, $username, $password, $database);

if($mysqli->connect_error) {
    echo "Connect failed: " . $mysqli->connect_error;
    exit();
}

?>