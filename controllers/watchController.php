<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once "../auth/auth.php";
    require_once "../config/Db.php";
    require_once "../models/Watch.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $name = $_POST["name"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $condition = $_POST["condition"];
        $price = $_POST["price"];
        $watchId = $_POST["watchId"];

        $db = new Db();

        $watch = new Watch($db, $_SESSION['user_id'], null, null, null, null);
        $res = $watch->upgrade($watchId, $name, $description, $condition, $price);
        if($res){
            $_SESSION['success'] = "Watch details updated succesfully";
        }else{
            $_SESSION["error"] = "Error updating the Watch Details";
        }
        header("Location: ../views/watch.php?id=$watchId");
        exit();
    }
