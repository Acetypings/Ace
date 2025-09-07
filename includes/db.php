<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "sme_tracker";

$conn = new mysqli($host, $user, $pass, $db);
if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

// Include currency handler safely
include_once __DIR__ . '/currency.php';
?>
