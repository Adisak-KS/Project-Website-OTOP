<?php
require_once("db/connect.php");

if (isset($_POST["btn-send-mail"])) {
    $emName = $_POST["em_name"];
    $emEmail = $_POST["em_email"];
    $emDetail = $_POST["em_detail"];

    try {
        $sql = "INSERT INTO ot_email (em_name, em_email, em_detail, em_time)
                    VALUES (:em_name, :em_email, :em_detail, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":em_name", $emName);
        $stmt->bindParam(":em_email", $emEmail);
        $stmt->bindParam(":em_detail", $emDetail);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }

    if(empty($_SESSION["error"])){
        $_SESSION["success"] = "ส่งข้อมูลติดต่อสำเร็จ เราจะรีบติดต่อคุณกลับโดยเร็วที่สุด";
        header("Location: contact.php");
    }
} else {
    require_once("includes/permission.php");
}
