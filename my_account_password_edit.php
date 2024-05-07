<?php
require_once("db/connect.php");


if (isset($_POST["btn-edit-password"])) {
    $memId = $_POST["mem_id"];
    $memOldPassword = $_POST["mem_oldPassword"];
    $memNewPassword = $_POST["mem_newPassword"];

    try {

        $sql = "SELECT mem_password FROM ot_member WHERE mem_id = :mem_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":mem_id", $memId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // ตรวจสอบว่ารหัสผ่านที่ถูก hash ตรงกับรหัสผ่านที่ผู้ใช้ป้อนเข้ามาหรือไม่
        if (password_verify($memOldPassword, $result['mem_password'])) {
            // รหัสผ่านถูกต้อง
            try {

                // ทำการ hash รหัสผ่านใหม่
                $hashedPassword = password_hash($memNewPassword, PASSWORD_DEFAULT);

                $sql = "UPDATE ot_member
                        SET mem_password = :mem_password
                        WHERE mem_id = :mem_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":mem_password", $hashedPassword);
                $stmt->bindParam(":mem_id", $memId);
                $stmt->execute();

                $_SESSION["success"] = "แก้ไขรหัสผ่านสำเร็จ";
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        } else {
            // รหัสผ่านไม่ถูกต้อง
            $_SESSION["error"] = "รหัสผ่านไม่ถูกต้อง";
            header("Location: my_account_setting.php");
            exit();
        }

        header("Location: my_account_setting.php");
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}
