<?php
require_once("db/connect.php");

if (isset($_POST["btn-add-cart"]) && !empty($_SESSION["mem_id"]) && !empty($_SESSION["prd_id"])) {
    $memId = $_SESSION["mem_id"];
    $prdId = $_SESSION["prd_id"];
    $prdAmount = $_POST["prd_amount"];
    $cartQuanlity = $_POST["prd_add_amount"];

    $sql = "SELECT *
            FROM ot_cart
            WHERE mem_id = :mem_id AND prd_id = :prd_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":prd_id", $prdId);
    $stmt->bindParam(":mem_id", $memId);
    $stmt->execute();
    $check = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($check) {
        // นำ จำนวนที่อยู่ใน Database มา + กับจำนวนใหม่
        $totalAddPrd = ($check["cart_quantity"] + $cartQuanlity);

        // เพิ่มสินค้เข้า Cart มากกว่าที่มีในคลัง
        if ($totalAddPrd > $prdAmount) {
            $_SESSION["error"] = "คุณมีสินค้าชิ้นนี้ในตะกร้าได้ไม่เกิน $prdAmount ชิ้น";
            header("Location:product_detail.php");
            exit();
        } else {

            // มีสินค้าอยู่ในตะกร้า ให้อัปเดตจำนวนสินค้า
            try {

                $sql = "UPDATE ot_cart 
                        SET cart_quantity = :cart_quantity 
                        WHERE mem_id = :mem_id AND prd_id = :prd_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":cart_quantity", $totalAddPrd);
                $stmt->bindParam(":mem_id", $memId);
                $stmt->bindParam(":prd_id", $prdId);
                $stmt->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
        }
    } else {
        // ยังไม่มี Product ใน cart ให้ INSERT
        try {
            $sql = "INSERT INTO ot_cart (mem_id, prd_id, cart_quantity)
                    VALUES (:mem_id, :prd_id, :cart_quantity)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":mem_id", $memId);
            $stmt->bindParam(":prd_id", $prdId);
            $stmt->bindParam(":cart_quantity", $cartQuanlity);
            $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }


    // ไม่มี error
    if (empty($_SESSION["error"])) {
        $_SESSION["success"] = "เพิ่มสินค้าลงในรถเข็นสำเร็จ";
        header("Location:product_detail.php");
    }
} else {
    $_SESSION["error"] = "กรุณาเข้าสู่ระบบก่อนใช้งาน";
    header("Location:login_form.php");
    exit();
}
