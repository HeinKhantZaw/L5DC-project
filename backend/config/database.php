<?php
session_start();

$hostname = "localhost";
$username = "root";
$password = "";
$database = "LifeCare_Clinic_DB";
$port = 3307;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $connection = new mysqli($hostname, $username, $password, $database, $port);
    $connection->set_charset("utf8mb4");
} catch (Exception $e) {
    error_log($e->getMessage());
    exit('Error connecting to database');
}
