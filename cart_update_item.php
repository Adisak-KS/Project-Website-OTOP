<?php
require_once("db/connect.php");

// ตรวจสอบว่ามีข้อมูลที่ส่งมาจากฟอร์มหรือไม่
if (isset($_POST['mem_id']) && isset($_POST['prd_id']) && isset($_POST['prd_add_amount'])) {
    $memId = $_SESSION['mem_id'];
    $prdId = $_SESSION['prd_id'];
    $cartQuantity = $_POST['prd_add_amount'];
    
    try {
        $sql = "UPDATE ot_cart 
                SET cart_quantity = :cart_quantity 
                WHERE mem_id = :mem_id AND prd_id = :prd_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cart_quantity', $cartQuantity);
        $stmt->bindParam(':mem_id', $memId);
        $stmt->bindParam(':prd_id', $prdId);
        $stmt->execute();

        $rowCount = $stmt->rowCount(); // จำนวนแถวที่ถูกอัปเดต

        if ($rowCount > 0) {
            // อัปเดตสำเร็จ
            header("Location: cart_show.php");
            exit();
        } else {
            // อัปเดตไม่สำเร็จ
            $_SESSION["error"] = "Failed to update cart item.";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>