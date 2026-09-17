<?php

$host = "YOUR_DATABASE_HOST";
$user = "YOUR_DATABASE_USERNAME";
$password = "YOUR_DATABASE_PASSWORD";
$database = "YOUR_DATABASE_NAME";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Unable to connect to database.");
}
?>