<?php 
    require_once("../db/connect.php");

    if(isset($_POST["btn-edit"])){
        $emId = $_POST["em_id"];
        $emShow = $_POST["em_show"];

        try{
            $sql = "UPDATE ot_email
                    SET em_show = :em_show
                    WHERE em_id = :em_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":em_show", $emShow);
            $stmt->bindParam(":em_id", $emId);
            $stmt->execute();
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }

        if(empty($_SESSION["error"])){
            $_SESSION["success"] = "แก้ไขข้อมูลสำเร็จ";
            header("Location: email_show.php");
        }
    }else{
        require_once("includes/no_permission.php");
    }