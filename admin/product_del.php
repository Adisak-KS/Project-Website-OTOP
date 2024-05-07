<?php
require_once("../db/connect.php");

if (isset($_POST['prd_id'])) {

    $prdId = filter_input(INPUT_POST, 'prd_id', FILTER_VALIDATE_INT);
    $prdImgName = $_POST['prd_img_name'];

    $locationSuccess = "refresh:1; url=product_show.php";
    $locationError = "refresh:1; url=product_edit_form.php";

    // พบ Peoduct Id
    if ($prdId) {
        $sql = "DELETE FROM ot_product 
                WHERE prd_id = :prd_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':prd_id', $prdId);
        $stmt->execute();

        // ลบสำเร็จ
        if ($stmt->rowCount() > 0) {
            // ให้ลบรูป
            $dir = "../uploads/img_product/";

            $oldFilePath = $dir . $prdImgName;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $sql = "DELETE FROM ot_product_img 
                    WHERE prd_id = :prd_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':prd_id', $prdId);
            $stmt->execute();
        } else {
            $_SESSION['error'] = "ลบข้อมูลสินค้าไม่สำเร็จ";
            header($locationError);
            exit;
        }
    } else {
        $_SESSION['error'] = "ไม่พบรหัสสินค้า";
        header($locationError);
        exit;
    }

    // ไม่พบ Error
    if (empty($_SESSION['error'])) {
        $_SESSION['success'] = "ลบข้อมูลสินค้าสำเร็จ";
        header($location);
    }
} else {
    // กลับหน้า index ของ User ทั่วไป
    require_once("includes/no_permission.php");
}
