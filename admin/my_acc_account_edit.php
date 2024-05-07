<?php
require_once("../db/connect.php");


if (isset($_POST["btn-edit"])) {
    $admId = $_POST["adm_id"];
    $admNewUsername = $_POST["adm_newUsername"];
    $admNewEmail = $_POST["adm_newEmail"];

    $locationSuccess = "Location: my_account_setting.php";
    $locationError = "Location: my_acc_account_edit_form.php";

    // หากมี Username ใหม่
    if (!empty($admNewUsername)) {

        $sql = "SELECT adm_username
                FROM ot_admin
                WHERE adm_username = :adm_username AND adm_id != :adm_id
                LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":adm_username", $admNewUsername);
        $stmt->bindParam(":adm_id", $admId);
        $stmt->execute();
        $check = $stmt->fetch();

        // พบ Username ซ้ำ 
        if ($check) {
            $_SESSION["error"] = "ไม่สามารถใช้ชื่อผู้ใช้นี้ได้";
            header($locationError);
            exit();
        } else {

            // ไม่พบ Username ซ้ำ 
            try {
                $sql = "UPDATE ot_admin
                        SET adm_username = :adm_username
                        WHERE adm_id = :adm_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":adm_username", $admNewUsername);
                $stmt->bindParam(":adm_id", $admId);
                $stmt->execute();

                $_SESSION["success"] = "แก้ไขข้อมูลบัญชีสำเร็จ";
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
        }
    }


    // หากมี email ใหม่
    if (!empty($admNewEmail)) {
        $sql = "SELECT adm_email
                FROM ot_admin
                WHERE adm_email = :adm_email AND adm_id != :adm_id
                LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":adm_email", $admNewEmail);
        $stmt->bindParam(":adm_id", $admId);
        $stmt->execute();
        $check = $stmt->fetch();

        // พบ Email ซ้ำ 
        if ($check) {
            $_SESSION["error"] = "ไม่สามารถใช้อีเมลนี้ได้";
            header($locationError);
            exit();
        } else {

            // ไม่พบ Email ซ้ำ 
            try {
                $sql = "UPDATE ot_admin
                        SET adm_email = :adm_email
                        WHERE adm_id = :adm_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":adm_email", $admNewEmail);
                $stmt->bindParam(":adm_id", $admId);
                $stmt->execute();

                $_SESSION["success"] = "แก้ไขข้อมูลบัญชีสำเร็จ";
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
        }
    }

    header($locationSuccess);
} else {
    // กลับหน้า index ของ User ทั่วไป
    require_once("includes/no_permission.php");
}
