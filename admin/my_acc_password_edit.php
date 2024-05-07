<?php
require_once("../db/connect.php");


if (isset($_POST["btn-edit"])) {
    $admId = $_POST["adm_id"];
    $admOldPassword = $_POST["adm_oldPassword"];
    $admPassword = $_POST["adm_password"];

    $locationSuccess = "Location: my_account_setting.php";
    $locationError = "Location: my_acc_password_edit_form.php";

    try {
        $sql = "SELECT adm_password 
                FROM ot_admin 
                WHERE adm_id = :adm_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":adm_id", $admId);
        $stmt->execute();
        $result = $stmt->fetch();

        // ตรวจสอบว่ารหัสผ่านที่ถูก hash ตรงกับรหัสผ่านที่ผู้ใช้ป้อนเข้ามาหรือไม่
        if (password_verify($admOldPassword, $result['adm_password'])) {

            // รหัสผ่านถูกต้อง
            try {
                // ทำการ hash รหัสผ่านใหม่
                $hashedPassword = password_hash($admPassword, PASSWORD_DEFAULT);

                $sql = "UPDATE ot_admin
                        SET adm_password = :adm_password
                        WHERE adm_id = :adm_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":adm_password", $hashedPassword);
                $stmt->bindParam(":adm_id", $admId);
                $stmt->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
        } else {
            // รหัสผ่านไม่ถูกต้อง
            $_SESSION["error"] = "รหัสผ่านไม่ถูกต้อง";
            header($locationError);
            exit();
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }


    if (empty($_SESSION["error"])) {
        $_SESSION["success"] = "แก้ไขรหัสผ่านสำเร็จ";
        header($locationSuccess);
    }
} else {
    // กลับหน้า index ของ User ทั่วไป
    require_once("includes/no_permission.php");
}
