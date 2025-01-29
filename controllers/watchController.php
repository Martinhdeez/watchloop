<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once "../auth/auth.php";
    require_once "../config/Db.php";
    require_once "../models/Watch.php";

    if(isset($_POST['update'])){
        $name = $_POST["name"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $condition = $_POST["condition"];
        $watchId = $_POST["watchId"];

        $db = new Db();

        $watch = new Watch($db, $_SESSION['user_id'], null, null, null, null);
        $res = $watch->upgrade($watchId, $name, $description, $condition, $price);
        if ($res) {
            $_SESSION['success'] = "Watch details updated successfully";
        } else {
             $_SESSION["error"] = "Error updating the Watch Details";
        }
    
        header("Location: ../views/watch.php?id=$watchId");
        exit();
    }

    if(isset($_POST["delete"])){
        $id = $_POST["watchId"];
        $db = new Db();
        $watch = new Watch($db, null, null, null, null, null);  
        $res = $watch->delete($id);
        if ($res) {
            $_SESSION["success"] = "Watch deleted successfully";
        } else {    
            $_SESSION["error"] = "Error deleting the Watch";
        }
        header("Location: ../views/mywatches.php");
        exit();
    }



