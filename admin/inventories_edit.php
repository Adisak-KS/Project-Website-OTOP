<?php
require_once("../db/connect.php");


if (isset($_POST["btn-edit"])) {
    // รับค่าที่ส่งมาจากฟอร์ม
    $prdId = $_POST["prd_id"];
    $prdAmount = $_POST["prd_amount"];

    $locationSuccess = "Location: inventories_show.php";
    $locationError = "Location: inventories_edit_form.php";

    try {
        $sql = "UPDATE ot_product
                SET prd_amount = :prd_amount
                WHERE prd_id = :prd_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":prd_amount", $prdAmount);
        $stmt->bindParam(":prd_id", $prdId);
        $stmt->execute();
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }


    // ล้าง session และกลับไปยังหน้าที่กำหนด
    if (empty($_SESSION["error"])) {
        unset($_SESSION["prd_id"]);
        $_SESSION["success"] = "แก้ไขข้อมูลสินค้าสำเร็จ";
        header($locationSuccess);
    }
} else {
    // กลับหน้า index ของ User ทั่วไป
    require_once("includes/no_permission.php");
}
