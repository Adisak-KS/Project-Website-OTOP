<?php
require_once("db/connect.php");


if (isset($_POST['mem_id']) && isset($_POST['prd_id'])) {
    $memId = $_POST["mem_id"];
    $prdId = $_POST["prd_id"];

    $location = "Location: cart_show.php";

    $sql = "SELECT * 
            FROM ot_cart
            WHERE mem_id = :mem_id AND prd_id = :prd_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":mem_id",$memId);
    $stmt->bindParam(":prd_id", $prdId);
    $stmt->execute();
    $check = $stmt->fetch();

    if($check){
        try{
            $sql = "DELETE FROM ot_cart WHERE mem_id = :mem_id AND prd_id = :prd_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":mem_id", $memId);
            $stmt->bindParam(":prd_id", $prdId);
            $stmt->execute();


        }catch(Exception $e){
            echo $e->getMessage();
            return false;
        }
    }else{
        $_SESSION["error"] = "ไม่พบข้อมูลสินค้าในตะกร้า";
        header($location);
        exit;
    }

}else{
    echo "Aaa";
}
