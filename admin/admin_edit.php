<?php
require_once("../db/connect.php");

// มีการกด submit
if (isset($_POST["btn-edit"])) {
    $admId = $_POST["adm_id"];
    $admFname = $_POST["adm_fname"];
    $admLname = $_POST["adm_lname"];
    $admProfile = $_POST["adm_profile"];
    $admNewProfile =  $_FILES["adm_newProfile"]['tmp_name'];

    $locationSuccess = "Location: admin_show.php";
    $locationError = "Location: admin_edit_form.php";

    try {
        // อัพเดทข้อมูล Admin
        $sql = "UPDATE ot_admin 
                SET adm_fname = :adm_fname, 
                    adm_lname = :adm_lname 
                WHERE adm_id = :adm_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":adm_fname", $admFname);
        $stmt->bindParam(":adm_lname", $admLname);
        $stmt->bindParam(":adm_id", $admId);
        $stmt->execute();
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }


    // หากมีการอัปโหลดไฟล์ใหม่
    if (!empty($admNewProfile)) {

        $dir = "../uploads/profile_admin/";
        // สุ่มชื่อไฟล์ใหม่
        $newProfile = uniqid('profile_', true) . ".png";
        $pathNewProfile = $dir . $newProfile;

        if (move_uploaded_file($admNewProfile, $pathNewProfile)) {

            // ลบไฟล์เดิม (ถ้ามี)
            $oldFilePath = $dir . $admProfile;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            // อัพเดทข้อมูลรูปโปรไฟล์ใหม่ในฐานข้อมูล
            try {
                $sql = "UPDATE ot_admin 
                    SET adm_profile = :adm_profile 
                    WHERE adm_id = :adm_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":adm_profile", $newProfile);
                $stmt->bindParam(":adm_id", $admId);
                $stmt->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
                header($locationError);
                exit();
            }
        } else {
            $_SESSION['error'] = "เกิดข้อผิดพลาดในการย้ายไฟล์";
            header($locationError);
            exit();
        }
    }

    if (empty($_SESSION['error'])) {
        // ลบ session id 
        unset($_SESSION['adm_id']);

        $_SESSION['success'] = "แก้ไขข้อมูลผู้ดูแลระบบสำเร็จ";
        header($locationSuccess);
    }
} else {
    // กลับหน้า index ของ User ทั่วไป
    require_once("includes/no_permission.php");
}
