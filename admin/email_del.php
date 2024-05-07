<?php
require_once("../db/connect.php");

if (isset($_POST["em_id"])) {
    $emId = $_POST["em_id"];

    try {
        $sql = "DELETE FROM ot_email
                    WHERE em_id = :em_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":em_id", $emId);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
    if (empty($_SESSION["error"])) {
        $_SESSION["success"] = "ลบข้อมูลสำเร็จ";
        header("refresh:1 url=email_show.php");
    }
} else {
    require_once("includes/no_permission.php");
}
