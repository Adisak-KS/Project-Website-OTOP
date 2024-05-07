<?php
require_once("db/connect.php");


if (isset($_POST["btn-edit-account"])) {
    $memId = $_POST["mem_id"];
    $memNewUsername = $_POST["mem_newUsername"];
    $memNewEmail = $_POST["mem_newEmail"];

    // ตรวจสอบว่ามี Username ใหม่หรือไม่
    if (!empty($memNewUsername)) {

        // ตรวจสอบ Username ซ้ำ
        $sql = "SELECT mem_username 
                FROM ot_member 
                WHERE mem_username = :mem_username AND mem_id != :mem_id 
                LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":mem_username", $memNewUsername);
        $stmt->bindParam(":mem_id", $memId);
        $stmt->execute();
        $result = $stmt->rowCount();


        // ไม่พบ Username ซ้ำ
        if ($result === 0) {
            // อัปเดต Username
            try {
                $sql = "UPDATE ot_member
                        SET mem_username = :mem_username
                        WHERE mem_id = :mem_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":mem_username", $memNewUsername);
                $stmt->bindParam(":mem_id", $memId);
                $stmt->execute();

                $_SESSION["success"] = "แก้ไขข้อมูลบัญชีสำเร็จ";
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        } else {
            // มี Username ซ้ำ
            $_SESSION["error"] = "ไม่สามารถใช้ชื่อผู้ใช้หรืออีเมลนี้ได้";
            header("Location: my_account_setting.php");
            exit();
        }
    }


    // ตรวจสอบว่ามี Email ใหม่หรือไม่
    if (!empty($memNewEmail)) {

        // ตรวจสอบ Email ซ้ำ
        $sql = "SELECT mem_email 
                FROM ot_member 
                WHERE mem_email = :mem_email AND mem_id != :mem_id 
                LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":mem_email", $memNewEmail);
        $stmt->bindParam(":mem_id", $memId);
        $stmt->execute();
        $result = $stmt->rowCount();


        // ไม่พบ Email ซ้ำ
        if ($result === 0) {
            // อัปเดต Email
            try {
                $sql = "UPDATE ot_member
                        SET mem_email = :mem_email
                        WHERE mem_id = :mem_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":mem_email", $memNewEmail);
                $stmt->bindParam(":mem_id", $memId);
                $stmt->execute();

                $_SESSION["success"] = "แก้ไขข้อมูลบัญชีสำเร็จ";
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        } else {
            // พบ Email ซ้ำ
            $_SESSION["error"] = "ไม่สามารถใช้ชื่อผู้ใช้หรืออีเมลนี้ได้";
            header("Location: my_account_setting.php");
            exit();
        }
    }

    header("Location: my_account_setting.php");
    exit();
}
