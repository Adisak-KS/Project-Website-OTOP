<?php
require_once("db/connect.php");

if (isset($_POST["mem_id"]) && isset($_POST["ord_id"])) {
    $memId = $_POST["mem_id"];
    $ordId = $_POST["ord_id"];

    try {
        // อัปเดท ord_status เป็น ยกเลิกรายการ
        $sql = "UPDATE ot_order
                SET ord_status = 'ยกเลิกรายการ'
                WHERE mem_id = :mem_id AND ord_id = :ord_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam("mem_id", $memId);
        $stmt->bindParam("ord_id", $ordId);
        $stmt->execute();


        // ตรวจสอบรายการ product
        $sql = "SELECT mem_id, ord_id, prd_id, cart_quantity
                FROM ot_order 
                WHERE mem_id = :mem_id AND ord_id = :ord_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam("mem_id", $memId);
        $stmt->bindParam("ord_id", $ordId);
        $stmt->execute();
        $check = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // ผลการตรวจสอบ
        if ($check) {
            foreach ($check as $row) {
                $prdId = $row["prd_id"];
                $cartQuantity = $row["cart_quantity"];

                // นำจำนวนสินค้า + กลับเข้าสินค้าแต่ล id
                $sql = "UPDATE ot_product
                        SET prd_amount = prd_amount + :cart_quantity
                        WHERE prd_id = :prd_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":cart_quantity", $cartQuantity);
                $stmt->bindParam(":prd_id", $prdId);
                $stmt->execute();
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }


    if (empty($_SESSION["error"])) {
        $_SESSION["success"] = "ยกเลิกรายการสำเร็จ";
        header("refresh:1; url=my_account_history.php");
    }

}
