<?php
require_once("db/connect.php");


if (isset($_POST["btn-edit-profile"])) {
    $memId = $_POST["mem_id"];
    $memFname = $_POST["mem_fname"];
    $memLname = $_POST["mem_lname"];
    $memProfile = $_POST["mem_profile"];
    $memNewProfile = $_FILES["mem_newProfile"];

    try {
        $sql = "UPDATE ot_member
                SET mem_fname = :mem_fname,
                    mem_lname = :mem_lname
                WHERE mem_id = :mem_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":mem_fname", $memFname);
        $stmt->bindParam(":mem_lname", $memLname);
        $stmt->bindParam(":mem_id", $memId);
        $stmt->execute();

         } catch (PDOEXception $e) {
        echo $e->getMessage();
        return false;
    }

    // หากมีการอัปโหลดไฟล์เข้ามา
    if (!empty($memNewProfile['tmp_name'])){
        $dir = "uploads/profile_member/";

        // สุ่มชื่อ
        $newProfile = uniqid('profile_', true) . ".png";
        $pathNewProfile = $dir . $newProfile;

        // อัพเดทข้อมูลรูปโปรไฟล์หากมีการอัพโหลดรูปใหม่
        if (move_uploaded_file($memNewProfile['tmp_name'], $pathNewProfile)) {

            // แก้ไขชื่อไฟล์ใหม่
            try {
                $sql = "UPDATE ot_member
                        SET mem_profile = :mem_profile
                        WHERE mem_id = :mem_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":mem_profile", $newProfile);
                $stmt->bindParam(":mem_id", $memId);
                $stmt->execute();

                // ลบไฟล์เดิม (ถ้ามี)
                $oldFilePath = $dir . $memProfile;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        } else {
            $_SESSION['error'] = "เกิดข้อผิดพลาดในการย้ายไฟล์";
            header("Location: my_account_profile_edit_form.php");
            exit();
        }
    }
    $_SESSION["success"] = "แก้ไขข้อมูลส่วนตัวสำเร็จ";
    header("Location: my_account_setting.php");
}
