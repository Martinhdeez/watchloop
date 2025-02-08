<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();
    require_once "../config/Db.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $item_id = $_POST['item_id'];
        $user_id = $_SESSION['user_id'];

        $db = new Db();

        $stmt = $db->conn->prepare("SELECT * FROM favorites WHERE user_id = ? AND watch_id = ?");
        $stmt->execute([$user_id, $item_id]);
        $favorite = $stmt->fetch(PDO::FETCH_ASSOC);

        if($favorite){
                    // Eliminar de favoritos
            $stmt = $db->conn->prepare("DELETE FROM favorites WHERE user_id = ? AND watch_id = ?");
            $stmt->execute([$user_id, $item_id]);
            $favorited = false;
        }else{
            $stmt = $db->conn->prepare("INSERT INTO favorites (user_id, watch_id) VALUES (?, ?)");
            $stmt->execute([$user_id, $item_id]);
            $favorited = true;
        }

        $stmt = $db->conn->prepare("SELECT COUNT(*) FROM favorites WHERE watch_id = ?");
        $stmt->execute([$item_id]);
        $count = $stmt->fetchColumn();
    
        echo json_encode(['status' => 'success', 'favorited' => $favorited, 'count' => $count]);
    }
