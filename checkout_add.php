<?php
require_once("db/connect.php");

if (isset($_POST["btn-confirm-order"])) {
    $memId = $_POST["mem_id"];
    $memFname = $_POST["mem_fname"];
    $memLname = $_POST["mem_lname"];
    $memHouseNumber = $_POST["mem_house_number"];
    $memDistrict = $_POST["mem_district"];
    $memProvince = $_POST["mem_province"];
    $memZipCode = $_POST["mem_zip_code"];
    $memTel = $_POST["mem_tel"];
    $memEmail = $_POST["mem_email"];
    $memDetail = $_POST["mem_detail"];
    $cartNetPrice = $_SESSION["netPrice"];

    // Find the next available ord_id
    $sql = "SELECT MAX(ord_id) AS max_id FROM ot_order";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $next_ord_id = $result['max_id'] + 1;

    $sql = "SELECT *
            FROM ot_cart
            INNER JOIN ot_member ON ot_cart.mem_id = ot_member.mem_id
            INNER JOIN ot_product ON ot_cart.prd_id = ot_product.prd_id
            WHERE ot_cart.mem_id = :mem_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":mem_id", $memId);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $prdId = $row["prd_id"];
        $prdPrice = $row["prd_price"];
        $prdAmount = $row["prd_amount"];
        $cartQuantity = $row["cart_quantity"];

        if ($cartQuantity > $prdAmount) {
            $_SESSION["error"] = "สินค้า" . $row["prd_name"] . "หมดแล้ว";
            exit();
        } else {
            try {
                $sql = "INSERT INTO ot_order (ord_id, mem_id, mem_fname, mem_lname, mem_house_number, mem_district, mem_province, mem_zip_code, mem_tel, mem_email, mem_detail, prd_id, prd_price, cart_quantity, cart_net_price)
                    VALUES (
                        :ord_id,
                        :mem_id, 
                        :mem_fname, 
                        :mem_lname, 
                        :mem_house_number, 
                        :mem_district,
                        :mem_province, 
                        :mem_zip_code, 
                        :mem_tel, 
                        :mem_email, 
                        :mem_detail, 
                        :prd_id, 
                        :prd_price, 
                        :cart_quantity,
                        :cart_net_price
                    )";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":ord_id", $next_ord_id);
                $stmt->bindParam(":mem_id", $memId);
                $stmt->bindParam(":mem_fname", $memFname);
                $stmt->bindParam(":mem_lname", $memLname);
                $stmt->bindParam(":mem_house_number", $memHouseNumber);
                $stmt->bindParam(":mem_district", $memDistrict);
                $stmt->bindParam(":mem_province", $memProvince);
                $stmt->bindParam(":mem_zip_code", $memZipCode);
                $stmt->bindParam(":mem_tel", $memTel);
                $stmt->bindParam(":mem_email", $memEmail);
                $stmt->bindParam(":mem_detail", $memDetail);
                $stmt->bindParam(":prd_id", $prdId);
                $stmt->bindParam(":prd_price", $prdPrice);
                $stmt->bindParam(":cart_quantity", $cartQuantity);
                $stmt->bindParam(":cart_net_price", $cartNetPrice);
                $stmt->execute();


                // ลบขำนวนสินค้าในคลัง
                $prdRemaining = $prdAmount - $cartQuantity;

                try {
                    $sql = "UPDATE ot_product 
                        SET prd_amount = :prd_amount
                        WHERE prd_id = :prd_id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":prd_amount", $prdRemaining);
                    $stmt->bindParam(":prd_id", $prdId);
                    $stmt->execute();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    return false;
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }
    }


    if (empty($_SESSION["error"])) {

        // ลบรายการสินค้าใน Cart ออก
        try {
            $sql = "DELETE FROM ot_cart WHERE mem_id = :mem_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":mem_id", $memId);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }


        // เก็บรหัสรายการสั่งซื้อ
        $_SESSION["ord_id"] = $next_ord_id;
        header("Location: slip_form.php");
    }
} elseif (isset($_POST["btn-add-slip"])) {

    $memId = $_POST["mem_id"];
    $ordId = $_POST["ord_id"];

    $memFname = $_POST["mem_fname"];
    $memLname = $_POST["mem_lname"];
    $memHouseNumber = $_POST["mem_house_number"];
    $memDistrict = $_POST["mem_district"];
    $memProvince = $_POST["mem_province"];
    $memZipCode = $_POST["mem_zip_code"];
    $memTel = $_POST["mem_tel"];
    $memEmail = $_POST["mem_email"];
    $memDetail = $_POST["mem_detail"];

    try {
        $sql = "UPDATE ot_order
                SET mem_fname = :mem_fname,
                    mem_lname = :mem_lname,
                    mem_house_number = :mem_house_number,
                    mem_district = :mem_district,
                    mem_province = :mem_province,
                    mem_zip_code = :mem_zip_code,
                    mem_tel = :mem_tel,
                    mem_email = :mem_email,
                    mem_detail = :mem_detail
                WHERE mem_id =:mem_id AND ord_id = :ord_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":mem_fname", $memFname);
        $stmt->bindParam(":mem_lname", $memLname);
        $stmt->bindParam(":mem_house_number", $memHouseNumber);
        $stmt->bindParam(":mem_district", $memDistrict);
        $stmt->bindParam(":mem_province", $memProvince);
        $stmt->bindParam(":mem_zip_code", $memZipCode);
        $stmt->bindParam(":mem_tel", $memTel);
        $stmt->bindParam(":mem_email", $memEmail);
        $stmt->bindParam(":mem_detail", $memDetail);
        $stmt->bindParam(":mem_id", $memId);
        $stmt->bindParam(":ord_id", $ordId);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }

    // เก็บรหัสรายการสั่งซื้อ
    $_SESSION["ord_id"] = $ordId;
    header("Location: slip_form.php");
}
