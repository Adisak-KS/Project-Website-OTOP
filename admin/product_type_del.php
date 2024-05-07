<?php
require_once("../db/connect.php");

if (isset($_POST['pty_id'])) {

    $ptyId = filter_input(INPUT_POST, 'pty_id', FILTER_VALIDATE_INT);
    $ptyImg = $_POST['pty_img'];

    $locationSuccess = "refresh:1; url=product_type_show.php";
    $locationError = "refresh:1; url=product_type_del_form.php";

    if ($ptyId) {
        $sql = "DELETE FROM ot_product_type 
                WHERE pty_id = :pty_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':pty_id', $ptyId);
        $stmt->execute();

        // ลบสำเร็จ
        if ($stmt->rowCount() > 0) {
            
            $dir = "../uploads/img_product_type/";

            // ลบรูป
            $oldFilePath = $dir . $ptyImg;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        } else {
            $_SESSION['error'] = "ลบข้อมูลประเภทสินค้าไม่สำเร็จ";
            header($locationError);
            exit;
        }
    } else {
        $_SESSION['error'] = "ไม่พบรหัสประเภทสินค้านี้";
        header($locationError);
        exit;
    }

    if (empty($_SESSION["error"])) {
        unset($_SESSION["pty_id"]);

        $_SESSION["success"] = "ลบข้อมูลประเภทสินค้าสำเร็จ";
        header($locationSuccess);
    }
} else {
    // กลับหน้า index ของ User ทั่วไป
    require_once("includes/no_permission.php");
}
