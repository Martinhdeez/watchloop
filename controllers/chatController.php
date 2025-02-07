<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Iniciar la sesión

require_once "../config/Db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $watch_id = $_POST["watch_id"];
    $receiver_id = $_POST["receiver_id"];
    $sender_id = $_POST["sender_id"];

    try {
        $db = new Db();
        // Corregir la consulta SQL con los operadores AND
        $stmt = $db->conn->prepare("SELECT * FROM chat_users WHERE user1_id = ? AND user2_id = ? AND watch_id = ?");
        $stmt->execute([$sender_id, $receiver_id, $watch_id]);

        if ($stmt->rowCount() > 0) {
            $chat = $stmt->fetch(PDO::FETCH_ASSOC);
            $chat_id = $chat['id'];
            echo "Chat exists\n";
            header("Location: ../views/chat.php?watch_id=$watch_id&receiver_id=$receiver_id&chat_id=$chat_id");
            exit();
        }

        // Crear el nuevo chat
        $stmt = $db->conn->prepare("INSERT INTO chat_users (user1_id, user2_id, watch_id) VALUES (?, ?, ?)");
        $stmt->execute([$sender_id, $receiver_id, $watch_id]);

        if ($stmt->rowCount() > 0) {
            $chat = $stmt->fetch(PDO::FETCH_ASSOC);
            $chat_id = $chat['id'];
            echo "Chat created\n";
            header("Location: ../views/chat.php?watch_id=$watch_id&receiver_id=$receiver_id&chat_id=$chat_id");
            exit();
        } else {
            $_SESSION["error"] = "Error creating chat";
            echo "Chat creation failed\n";
            // Uncomment this to redirect to a fallback page in case of failure
            // header("Location: ../views/watch.php?id=$watch_id");
            // exit();
        }
    } catch (PDOException $e) {
        // Manejo de errores de base de datos
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method\n";
}
?>
