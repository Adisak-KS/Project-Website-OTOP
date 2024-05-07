<?php
require_once("../db/connect.php");


if (isset($_POST["btn-edit"])) {
    $memId = $_POST["mem_id"];
    $memFname = $_POST["mem_fname"];
    $memLname = $_POST["mem_lname"];
    $memProfile = $_POST["mem_profile"];
    $memNewProfile =  $_FILES["mem_newProfile"]["tmp_name"];


    $locationSuccess = "location: member_show.php";
    $locationError = "location: member_edit_form.php";

    try {
        // อัพเดทข้อมูลผู้ดูแลระบบ
        $sql = "UPDATE ot_member 
                SET mem_fname = :mem_fname, 
                    mem_lname = :mem_lname 
                WHERE mem_id = :mem_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":mem_fname", $memFname);
        $stmt->bindParam(":mem_lname", $memLname);
        $stmt->bindParam(":mem_id", $memId);
        $stmt->execute();
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }

    if (!empty($memNewProfile)) {
        $dir = "../uploads/profile_member/";

        // สุ่มชื่อไฟล์ใหม่
        $newProfile = uniqid('profile_', true) . ".png";
        $pathNewProfile = $dir . $newProfile;

        if (move_uploaded_file($memNewProfile, $pathNewProfile)) {

            // ลบไฟล์เดิม (ถ้ามี)
            $oldFilePath = $dir . $memProfile;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            // อัพเดทข้อมูลรูปโปรไฟล์หากมีการอัพโหลดรูปใหม่
            try {
                $sql = "UPDATE ot_member 
                        SET mem_profile = :mem_profile 
                        WHERE mem_id = :mem_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":mem_profile", $newProfile);
                $stmt->bindParam(":mem_id", $memId);
                $stmt->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
        } else {
            $_SESSION['error'] = "เกิดข้อผิดพลาดในการย้ายไฟล์";
            header($locationError);
            exit();
        }
    }

    if (empty($_SESSION["error"])) {
        // ลบ session id 
        unset($_SESSION["mem_id"]);
        $_SESSION["success"]= "แก้ไขข้อมูลสมาชิกสำเร็จ";
        // ไปยังหน้า member_show.php
        header($locationSuccess);
    }
} else {
    require_once("includes/no_permission.php");
}
