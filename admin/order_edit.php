<?php
    require_once("../db/connect.php");


    if(isset($_POST["btn-edit"])){
        $ordId = $_POST["ord_id"];
        $ordStatus = $_POST["ord_status"];

        try{
            $sql = "UPDATE ot_order
                    SET ord_status = :ord_status
                    WHERE ord_id = :ord_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":ord_status", $ordStatus);
            $stmt->bindParam(":ord_id",$ordId);
            $stmt->execute();

        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }

        if(empty($_SESSION["error"])){
            $_SESSION["success"] = "แก้ไขข้อมูลสำเร็จ";
            header("Location:order_show.php");
        }

    }else{
        require_once("includes/no_permission.php");
    }