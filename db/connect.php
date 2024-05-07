<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "otop";
$dsn = "mysql:host=$servername;dbname=$dbname";

try {
    $conn = new PDO($dsn, $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // เพิ่มข้อมูล Admin เริ่มต้น
    require_once("admin_add_defalault.php");
    session_start();
    // echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
