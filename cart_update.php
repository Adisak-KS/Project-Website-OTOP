<?php
require_once("db/connect.php");
// ตรวจสอบว่ามีข้อมูลที่ส่งมาจากฟอร์มหรือไม่
if (isset($_POST["btn-minus"]) || isset($_POST["btn-plus"])) {
    $memId = $_POST["mem_id"];
    $prdId = $_POST["prd_id"];


    $sql = "SELECT *, ot_product.prd_amount, ot_product.prd_price
            FROM ot_cart
            INNER JOIN ot_product ON ot_cart.prd_id = ot_product.prd_id
            WHERE ot_cart.prd_id = :prd_id AND ot_cart.mem_id = :mem_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":prd_id", $prdId);
    $stmt->bindParam(":mem_id", $memId);
    $stmt->execute();
    $check = $stmt->fetch(PDO::FETCH_ASSOC);

    



    if (isset($_POST["btn-minus"])) {
        $cartQuantity = max(1, $check["cart_quantity"] - 1);

        if ($cartQuantity <= 1) {
            $cartQuantity = 1;
        }

        try {
            $sql = "UPDATE ot_cart 
                    SET cart_quantity = :cart_quantity 
                    WHERE mem_id = :mem_id AND prd_id = :prd_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':cart_quantity', $cartQuantity);
            $stmt->bindParam(':mem_id', $memId);
            $stmt->bindParam(':prd_id', $prdId);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }



    if (isset($_POST["btn-plus"])) {
        $prdAmount = $check["prd_amount"];
        $cartQuantity =($check["cart_quantity"] + 1);

        // เพิ่มปริมาณสินค้าขึ้น 1 แต่ไม่เกิน $prdAmount
        if ($cartQuantity > $prdAmount) {
            $cartQuantity = $prdAmount;
        }

        try {
            $sql = "UPDATE ot_cart 
                    SET cart_quantity = :cart_quantity 
                    WHERE mem_id = :mem_id AND prd_id = :prd_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':cart_quantity', $cartQuantity);
            $stmt->bindParam(':mem_id', $memId);
            $stmt->bindParam(':prd_id', $prdId);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    if (empty($_SESSION["error"])) {
        header("Location: cart_show.php");
    }
}


?>





<?php
// require_once("db/connect.php");
// // ตรวจสอบว่ามีข้อมูลที่ส่งมาจากฟอร์มหรือไม่
// if (isset($_POST["btn-update"])) {
//     // รับค่าที่ส่งมาจากฟอร์ม
//     $memId = $_POST['mem_id'];
//     $prdId = $_POST['prd_id'];
//     $cartQuanlity = $_POST['prd_add_amount'];
//     try {
//         $sql = "UPDATE ot_cart 
//                 SET cart_quantity = :cart_quantity 
//                 WHERE mem_id = :mem_id AND prd_id = :prd_id";
//         $stmt = $conn->prepare($sql);
//         $stmt->bindParam(':cart_quantity', $cartQuanlity);
//         $stmt->bindParam(':mem_id', $memId);
//         $stmt->bindParam(':prd_id', $prdId);
//         $stmt->execute();
//     } catch (PDOException $e) {
//         echo $e->getMessage();
//     }

//     if (empty($_SESSION["error"])) {
//         header("Location: cart_show.php");
//     }
// }
