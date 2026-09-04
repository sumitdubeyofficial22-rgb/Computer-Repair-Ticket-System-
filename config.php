<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "repairdesk";
$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database
);

if (!$conn) {
    http_response_code(500);
    exit("Database connection is unavailable.");
}

mysqli_set_charset($conn, "utf8mb4");

?>